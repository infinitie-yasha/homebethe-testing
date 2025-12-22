<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Language extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(['url', 'language', 'timezone_helper', 'file']);
        $this->load->model('language_model');

        if (!has_permissions('read', 'settings')) {
            $this->session->set_flashdata('authorize_flag', PERMISSION_ERROR_MSG);
            redirect('admin/home', 'refresh');
        }
    }

    public function index()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $this->data['main_page'] = FORMS . 'languages';
            $settings = get_settings('system_settings', true);
            $this->data['title'] = 'Languages | ' . $settings['app_name'];
            $this->data['meta_description'] = 'Languages  | ' . $settings['app_name'];
            $this->data['settings'] = get_settings('system_settings', true);
            $this->data['languages'] = get_languages();
            $this->data['default_language'] = get_languages('', '', '', '', 1);

            if (isset($_GET['id'])) {
                $this->data['language'] = get_languages($_GET['id']);
            } else {
                $this->data['language'] = get_languages();
            }

            if (empty($this->data['language'])) {
                redirect(base_url('admin/language'), 'refresh');
            }
            $this->data['language'] = $this->data['language'][0];
            // print_r($this->data['language']);

            $this->data['lang_labels'] = $this->lang->load('web_labels_lang', strtolower($this->data['language']['language']), true);
            $this->load->view('admin/template', $this->data);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function create()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            if (print_msg(!has_permissions('update', 'settings'), PERMISSION_ERROR_MSG, 'settings')) {
                return false;
            }
            if (defined('ALLOW_MODIFICATION') && ALLOW_MODIFICATION == 0) {
                sendWebJsonResponse(true, DEMO_VERSION_MSG);
            }
            $language_id = $this->input->post('language_id', true);

            if (isset($language_id) && !empty($language_id)) {
                $this->form_validation->set_rules('language', 'Language', 'trim|required|xss_clean|strtolower|alpha');
                $this->form_validation->set_rules('code', 'Code', 'trim|required|xss_clean|strtolower');
                # code...
            } else {
                $this->form_validation->set_rules('language', 'Language', 'trim|required|xss_clean|strtolower|alpha|is_unique[languages.language]|strtolower', array('is_unique' => 'This Language is already exists.'));
                $this->form_validation->set_rules('code', 'Code', 'trim|required|xss_clean|strtolower|is_unique[languages.language]', array('is_unique' => 'This Code is already exists.'));
            }
            $this->form_validation->set_rules('native_language', 'Native Language', 'trim|required|xss_clean');
            $this->form_validation->set_rules('is_rtl', 'RTL', 'trim|xss_clean');
            if (!$this->form_validation->run()) {
                sendWebJsonResponse(true, strip_tags(validation_errors()));
            }
            $language = $this->input->post('language', true);
            $language = strtolower($language);
            if (isset($language_id) && !empty($language_id)) {
                $data = $this->language_model->create($this->input->post(null, true));
                sendWebJsonResponse(false, 'Language Updated Successfully');
            } else {
                if ($this->language_model->create($this->input->post(null, true))) {
                    // Create all necessary language files and directories
                    $this->createLanguageFiles($language);

                    sendWebJsonResponse(false, 'Language added successfully with all necessary files created.');
                } else {
                    sendWebJsonResponse(false, 'Cannot add language. Please try again later.');
                }

            }

        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function save()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            if (print_msg(!has_permissions('update', 'settings'), PERMISSION_ERROR_MSG, 'settings')) {
                return false;
            }
            if (defined('ALLOW_MODIFICATION') && ALLOW_MODIFICATION == 0) {
                sendWebJsonResponse(true, DEMO_VERSION_MSG);
            }
            $this->form_validation->set_rules('language_id', 'ID', 'trim|required|xss_clean|numeric');
            $this->form_validation->set_rules('is_rtl', 'RTL', 'trim|xss_clean');
            if (!$this->form_validation->run()) {
                sendWebJsonResponse(true, strip_tags(validation_errors()));
            }
            $language_id = $this->input->post('language_id', true);
            $language = get_languages($language_id);
            if (empty($language)) {
                sendWebJsonResponse(true, 'No Language Found.');
            }
            $language = $language[0];
            $language_name = strtolower($language['language']);
            $lang = array();
            $langstr = '';
            $data = $this->input->post(null, true);
            foreach ($data as $key => $value) {
                $label_data = strip_tags($value);
                $label_data = $this->db->escape_str($label_data);
                $label_key = $key;
                $langstr .= "\$lang['" . $label_key . "'] = \"$label_data\";" . "\n";
            }

            $langstr_final = "<?php defined('BASEPATH') OR exit('No direct script access allowed');" . "\n\n\n" . $langstr;
            if (file_exists('./application/language/' . $language_name . '/web_labels_lang.php')) {
                delete_files('./application/language/' . $language_name . '/web_labels_lang.php');
            }

            $data['is_rtl'] = (isset($_POST['is_rtl']) && !empty($_POST['is_rtl'])) ? 1 : 0;

            if (write_file('./application/language/' . $language_name . '/web_labels_lang.php', $langstr_final)) {
                if ($this->language_model->update($data)) {
                    sendWebJsonResponse(false, 'Language added successfully.');
                } else {
                    sendWebJsonResponse(true, 'This Language file is not writable.');
                }
            } else {
                sendWebJsonResponse(true, 'This Language file is not writable.');
            }
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function set_default_for_web()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            if (print_msg(!has_permissions('update', 'settings'), PERMISSION_ERROR_MSG, 'settings')) {
                return false;
            }
            if (defined('ALLOW_MODIFICATION') && ALLOW_MODIFICATION == 0) {
                sendWebJsonResponse(true, DEMO_VERSION_MSG);
            }

            $this->form_validation->set_rules('language_id', 'Language ID', 'trim|required|xss_clean|numeric');

            if (!$this->form_validation->run()) {
                $errors = validation_errors();
                $response = array(
                    'error' => true,
                    'message' => strip_tags($errors),
                    'csrfName' => $this->security->get_csrf_token_name(),
                    'csrfHash' => $this->security->get_csrf_hash()
                );
                echo json_encode($response);
                return;
            }

            $data['language_id'] = $this->input->post('language_id', true);
            $data['is_default'] = 1;

            // Verify language exists
            $language = get_languages($data['language_id']);
            if (empty($language)) {
                sendWebJsonResponse(true, 'Language not found.');
            }

            if ($this->language_model->is_default_for_web($data)) {
                sendWebJsonResponse(false, 'Language set as default successfully.');

            } else {
                sendWebJsonResponse(true, 'Failed to set language as default. Please try again.');

            }
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function get_list()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $this->language_model->get_language_list();
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    // In your LanguageController.php

    public function delete_language()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            if (print_msg(!has_permissions('update', 'settings'), PERMISSION_ERROR_MSG, 'settings')) {
                return false;
            }
            if (defined('ALLOW_MODIFICATION') && ALLOW_MODIFICATION == 0) {
                sendWebJsonResponse(true, DEMO_VERSION_MSG);
            }

            $language_id = $this->input->get('id', true);

            if (empty($language_id)) {
                sendWebJsonResponse(true, 'Language ID is required.');
            }

            // Get language details before deletion
            $language = get_languages($language_id);
            if (empty($language)) {
                sendWebJsonResponse(true, 'Language not found.');
            }

            $language = $language[0];
            $language_name = strtolower($language['language']);

            // Check if this is the default language
            if ($language['is_default'] == '1') {
                sendWebJsonResponse(true, 'Cannot delete the default language. Please set another language as default first.');
            }

            // Delete from database first
            if ($this->language_model->delete_language($language_id)) {
                // Delete language files and directories
                $this->deleteLanguageFiles($language_name);

                sendWebJsonResponse(false, 'Language and all related files deleted successfully.');
            } else {
                sendWebJsonResponse(true, 'Failed to delete language from database.');
            }
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    /**
     * Delete language files and directories
     * 
     * @param string $language_name The language name (lowercase)
     * @return bool True if successful, false otherwise
     */
    private function deleteLanguageFiles($language_name)
    {
        $deleted_files = [];
        $deleted_dirs = [];

        // Paths to delete
        $paths_to_delete = [
            './application/language/' . $language_name . '/',
            './system/language/' . $language_name . '/',
            './uploads/language_files/language_' . $language_name . '_*'
        ];

        foreach ($paths_to_delete as $path) {
            if (strpos($path, '*') !== false) {
                // Handle wildcard patterns for uploaded files
                $pattern = $path;
                $files = glob($pattern);
                foreach ($files as $file) {
                    if (is_file($file) && unlink($file)) {
                        $deleted_files[] = $file;
                    }
                }
            } else {
                // Handle directories
                if (is_dir($path)) {
                    if ($this->deleteDirectory($path)) {
                        $deleted_dirs[] = $path;
                    }
                }
            }
        }

        // Log deletion results
        error_log('Language files deleted: ' . implode(', ', $deleted_files));
        error_log('Language directories deleted: ' . implode(', ', $deleted_dirs));

        return true;
    }

    /**
     * Recursively delete a directory and its contents
     * 
     * @param string $dir The directory path
     * @return bool True if successful, false otherwise
     */
    private function deleteDirectory($dir)
    {
        if (!is_dir($dir)) {
            return false;
        }

        $files = array_diff(scandir($dir), array('.', '..'));

        foreach ($files as $file) {
            $path = $dir . '/' . $file;
            if (is_dir($path)) {
                $this->deleteDirectory($path);
            } else {
                unlink($path);
            }
        }

        return rmdir($dir);
    }

    /**
     * Get list of files that will be deleted for a language
     * 
     * @param string $language_name The language name (lowercase)
     * @return array List of files and directories that will be deleted
     */
    public function getLanguageFilesToDelete($language_name)
    {
        $files_to_delete = [];

        // Check application language directory
        $app_lang_dir = './application/language/' . $language_name . '/';
        if (is_dir($app_lang_dir)) {
            $files_to_delete[] = $app_lang_dir;
        }

        // Check system language directory
        $sys_lang_dir = './system/language/' . $language_name . '/';
        if (is_dir($sys_lang_dir)) {
            $files_to_delete[] = $sys_lang_dir;
        }

        // Check uploaded language files
        $uploaded_files = glob('./uploads/language_files/language_' . $language_name . '_*');
        $files_to_delete = array_merge($files_to_delete, $uploaded_files);

        return $files_to_delete;
    }

    /**
     * Create all necessary language files and directories
     * 
     * @param string $language_name The language name (lowercase)
     * @return bool True if successful, false otherwise
     */
    private function createLanguageFiles($language_name)
    {
        $created_files = [];
        $created_dirs = [];

        // Create application language directory
        $app_lang_dir = './application/language/' . $language_name . '/';
        $sys_lang_dir = './system/language/' . $language_name . '/';
        if (!is_dir($app_lang_dir)) {
            if (mkdir($app_lang_dir, 0777, true)) {
                $created_dirs[] = $app_lang_dir;
            }
        }

        // Create uploads directory if it doesn't exist
        $uploads_dir = './uploads/language_files/';
        if (!is_dir($uploads_dir)) {
            if (mkdir($uploads_dir, 0777, true)) {
                $created_dirs[] = $uploads_dir;
            }
        }

        // Create web_labels_lang.php with basic structure
        $web_labels_content = $this->createWebLabelsFile($language_name);
        if (write_file($app_lang_dir . 'web_labels_lang.php', $web_labels_content)) {
            $created_files[] = $app_lang_dir . 'web_labels_lang.php';
        }

        // Create system language files
        $system_files = $this->createSystemLanguageFiles($sys_lang_dir);
        $created_files = array_merge($created_files, $system_files);

        // Create additional application language files
        $app_files = $this->createApplicationLanguageFiles($app_lang_dir);
        $created_files = array_merge($created_files, $app_files);

        // Log creation results
        error_log('Language directories created: ' . implode(', ', $created_dirs));
        error_log('Language files created: ' . implode(', ', $created_files));

        return true;
    }

    /**
     * Create web_labels_lang.php file with basic structure
     * 
     * @param string $language_name The language name
     * @return string The file content
     */
    private function createWebLabelsFile($language_name)
    {
        $content = "<?php defined('BASEPATH') OR exit('No direct script access allowed');\n\n";
        $content .= "// Language: " . ucfirst($language_name) . "\n";
        $content .= "// Generated: " . date('Y-m-d H:i:s') . "\n\n";
        $content .= "\$lang['language_id'] = \"" . $language_name . "\";\n";
        $content .= "\$lang['language'] = \"" . ucfirst($language_name) . "\";\n";
        $content .= "\$lang['code'] = \"" . strtoupper(substr($language_name, 0, 2)) . "\";\n\n";

        // Add basic language labels
        $basic_labels = [
            'welcome' => 'Welcome',
            'hello' => 'Hello',
            'goodbye' => 'Goodbye',
            'thank_you' => 'Thank you',
            'please' => 'Please',
            'yes' => 'Yes',
            'no' => 'No',
            'cancel' => 'Cancel',
            'save' => 'Save',
            'edit' => 'Edit',
            'delete' => 'Delete',
            'add' => 'Add',
            'search' => 'Search',
            'filter' => 'Filter',
            'sort' => 'Sort',
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'confirm_password' => 'Confirm Password',
            'phone' => 'Phone',
            'address' => 'Address',
            'city' => 'City',
            'country' => 'Country',
            'submit' => 'Submit',
            'reset' => 'Reset',
            'loading' => 'Loading...',
            'error' => 'Error',
            'success' => 'Success',
            'warning' => 'Warning',
            'info' => 'Information',
            'home' => 'Home',
            'menu' => 'Menu',
            'products' => 'Products',
            'shop' => 'Shop',
            'my_account' => 'My Account',
            'login' => 'Sign In',
            'register' => 'Sign Up',
            'logout' => 'Logout',
            'about_us' => 'About Us',
            'contact_us' => 'Contact Us',
            'shopping_cart' => 'Shopping Cart',
            'close' => 'Close',
            'view_cart' => 'View Cart',
            'add_to_cart' => 'Add to Cart',
            'favorite' => 'Favorite',
            'reviews' => 'Reviews',
            'pages' => 'Pages',
            'terms_and_condition' => 'Terms & Condition',
            'privacy_policy' => 'Privacy Policy'
        ];

        foreach ($basic_labels as $key => $value) {
            $content .= "\$lang['" . $key . "'] = \"" . $value . "\";\n";
        }

        return $content;
    }

    /**
     * Create system language files
     * 
     * @param string $sys_lang_dir The system language directory
     * @return array List of created files
     */
    private function createSystemLanguageFiles($sys_lang_dir)
    {
        $created_files = [];

        $system_files = [
            'calendar_lang.php' => "<?php defined('BASEPATH') OR exit('No direct script access allowed');\n\n// Calendar Language File\n",
            'date_lang.php' => "<?php defined('BASEPATH') OR exit('No direct script access allowed');\n\n// Date Language File\n",
            'db_lang.php' => "<?php defined('BASEPATH') OR exit('No direct script access allowed');\n\n// Database Language File\n",
            'email_lang.php' => "<?php defined('BASEPATH') OR exit('No direct script access allowed');\n\n// Email Language File\n",
            'form_validation_lang.php' => "<?php defined('BASEPATH') OR exit('No direct script access allowed');\n\n// Form Validation Language File\n",
            'ftp_lang.php' => "<?php defined('BASEPATH') OR exit('No direct script access allowed');\n\n// FTP Language File\n",
            'imglib_lang.php' => "<?php defined('BASEPATH') OR exit('No direct script access allowed');\n\n// Image Library Language File\n",
            'migration_lang.php' => "<?php defined('BASEPATH') OR exit('No direct script access allowed');\n\n// Migration Language File\n",
            'number_lang.php' => "<?php defined('BASEPATH') OR exit('No direct script access allowed');\n\n// Number Language File\n",
            'pagination_lang.php' => "<?php defined('BASEPATH') OR exit('No direct script access allowed');\n\n// Pagination Language File\n",
            'profiler_lang.php' => "<?php defined('BASEPATH') OR exit('No direct script access allowed');\n\n// Profiler Language File\n",
            'unit_test_lang.php' => "<?php defined('BASEPATH') OR exit('No direct script access allowed');\n\n// Unit Test Language File\n",
            'upload_lang.php' => "<?php defined('BASEPATH') OR exit('No direct script access allowed');\n\n// Upload Language File\n"
        ];

        foreach ($system_files as $filename => $content) {
            if (write_file($sys_lang_dir . $filename, $content)) {
                $created_files[] = $sys_lang_dir . $filename;
            }
        }

        return $created_files;
    }

    /**
     * Create additional application language files
     * 
     * @param string $app_lang_dir The application language directory
     * @return array List of created files
     */
    private function createApplicationLanguageFiles($app_lang_dir)
    {
        $created_files = [];

        $app_files = [
            'common_lang.php' => "<?php defined('BASEPATH') OR exit('No direct script access allowed');\n\n// Common Language File\n",
            'admin_lang.php' => "<?php defined('BASEPATH') OR exit('No direct script access allowed');\n\n// Admin Language File\n",
            'frontend_lang.php' => "<?php defined('BASEPATH') OR exit('No direct script access allowed');\n\n// Frontend Language File\n",
            'api_lang.php' => "<?php defined('BASEPATH') OR exit('No direct script access allowed');\n\n// API Language File\n",
            'error_lang.php' => "<?php defined('BASEPATH') OR exit('No direct script access allowed');\n\n// Error Language File\n"
        ];

        foreach ($app_files as $filename => $content) {
            if (write_file($app_lang_dir . $filename, $content)) {
                $created_files[] = $app_lang_dir . $filename;
            }
        }

        return $created_files;
    }

    /**
     * Convert JSON language data to web_labels_lang.php format
     * 
     * @param array $json_data The JSON data array
     * @param string $language_name The language name (lowercase)
     * @return string The formatted PHP language file content
     */
    private function convertJsonToLanguageFile($json_data, $language_name)
    {
        // Start with the required PHP header
        $langstr = "<?php defined('BASEPATH') OR exit('No direct script access allowed');\n\n";

        // Add language_id as the first entry
        $langstr .= "\$lang['language_id'] = \"" . $language_name . "\";\n";

        // Process each translation entry
        foreach ($json_data as $key => $value) {
            // Clean and escape the value
            $label_data = strip_tags($value);
            $label_data = $this->db->escape_str($label_data);

            // Add the language entry
            $langstr .= "\$lang['" . $key . "'] = \"" . $label_data . "\";\n";
        }

        return $langstr;
    }

    /**
     * Replace existing language file if it exists
     * 
     * @param string $file_path The path to the language file
     * @param string $content The new content to write
     * @return bool True if successful, false otherwise
     */
    private function replaceLanguageFile($file_path, $content)
    {
        // Check if file exists and delete it
        if (file_exists($file_path)) {
            if (!unlink($file_path)) {
                return false; // Failed to delete existing file
            }
        }

        // Write the new file
        return write_file($file_path, $content);
    }

    public function testUploadPath()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $upload_path = FCPATH . 'uploads/language_files';
            $upload_path = rtrim($upload_path, '/\\');

            $response = [
                'upload_path' => $upload_path,
                'path_exists' => is_dir($upload_path),
                'path_writable' => is_writable($upload_path),
                'real_path' => realpath($upload_path),
                'fcpath' => FCPATH,
                'test_file' => $upload_path . '/test.json'
            ];

            // Try to create a test file
            $test_content = '{"test": "value"}';
            if (write_file($upload_path . '/test.json', $test_content)) {
                $response['test_write'] = 'Success';
                unlink($upload_path . '/test.json'); // Clean up
            } else {
                $response['test_write'] = 'Failed';
            }

            echo json_encode($response, JSON_PRETTY_PRINT);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function uploadLanguageFile()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            if (print_msg(!has_permissions('update', 'settings'), PERMISSION_ERROR_MSG, 'settings')) {
                return false;
            }
            if (defined('ALLOW_MODIFICATION') && ALLOW_MODIFICATION == 0) {
                sendWebJsonResponse(true, DEMO_VERSION_MSG);
            }

            $this->form_validation->set_rules('language_id', 'Language', 'trim|required|xss_clean|numeric');
            // $this->form_validation->set_rules('upload_file', 'Language File', 'trim|required|xss_clean');

            if (!$this->form_validation->run()) {
                sendWebJsonResponse(true, strip_tags(validation_errors()));
            }

            $language_id = $this->input->post('language_id', true);
            $language = get_languages($language_id);

            if (empty($language)) {
                sendWebJsonResponse(true, 'No Language Found.');
            }

            $language = $language[0];
            $language_name = strtolower($language['language']);

            // Check if file was uploaded
            if (empty($_FILES['upload_file']['name'])) {
                sendWebJsonResponse(true, 'Please select a JSON file to upload.');
            }

            // Validate file type
            $file_extension = pathinfo($_FILES['upload_file']['name'], PATHINFO_EXTENSION);
            if (strtolower($file_extension) !== 'json') {
                sendWebJsonResponse(true, 'Please upload a valid JSON file.');
            }

            // Upload configuration - ensure proper path format
            $upload_path = FCPATH . 'uploads/language_files';

            // Create directory if it doesn't exist
            if (!is_dir($upload_path)) {
                if (!mkdir($upload_path, 0777, true)) {
                    sendWebJsonResponse(true, 'Failed to create upload directory. Please check permissions.');
                }
            }

            // Verify the upload path is writable
            if (!is_writable($upload_path)) {
                sendWebJsonResponse(true, 'Upload directory is not writable. Please check permissions.');
            }

            // Ensure path doesn't end with slash for CodeIgniter upload library
            $upload_path = rtrim($upload_path, '/\\');

            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'json';
            $config['max_size'] = 2048; // 2MB
            $config['file_name'] = 'language_' . $language_name . '_' . time();

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('upload_file')) {
                $error_message = 'Upload failed: ' . $this->upload->display_errors();
                $error_message .= ' | Upload path: ' . $config['upload_path'];
                $error_message .= ' | Path exists: ' . (is_dir($config['upload_path']) ? 'Yes' : 'No');
                $error_message .= ' | Path writable: ' . (is_writable($config['upload_path']) ? 'Yes' : 'No');
                $error_message .= ' | Real path: ' . realpath($config['upload_path']);
                $error_message .= ' | FCPATH: ' . FCPATH;

                // Try alternative approach - direct file handling
                if (isset($_FILES['upload_file']) && $_FILES['upload_file']['error'] == 0) {
                    $temp_file = $_FILES['upload_file']['tmp_name'];
                    $file_name = 'language_' . $language_name . '_' . time() . '.json';
                    $target_file = $config['upload_path'] . '/' . $file_name;

                    if (move_uploaded_file($temp_file, $target_file)) {
                        // Success with direct file handling
                        $file_path = $target_file;
                        goto process_file; // Skip to file processing
                    } else {
                        $error_message .= ' | Direct upload also failed';
                    }
                }

                sendWebJsonResponse(true, $error_message);
            }

            $upload_data = $this->upload->data();
            $file_path = $config['upload_path'] . '/' . $upload_data['file_name'];

            process_file:
            // Read and validate JSON file
            $json_content = file_get_contents($file_path);
            $language_data = json_decode($json_content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                unlink($file_path); // Delete uploaded file
                sendWebJsonResponse(true, 'Invalid JSON file format.');
            }

            // Convert JSON to language file format
            $langstr = $this->convertJsonToLanguageFile($language_data, $language_name);

            // Ensure language directory exists
            $language_dir = './application/language/' . $language_name . '/';
            if (!is_dir($language_dir)) {
                mkdir($language_dir, 0777, TRUE);
            }

            // Define the target language file path
            $target_file_path = $language_dir . 'web_labels_lang.php';

            // Replace existing file if it exists
            if ($this->replaceLanguageFile($target_file_path, $langstr)) {
                // Delete the uploaded JSON file after processing
                unlink($file_path);
                sendWebJsonResponse(false, 'Language file uploaded and processed successfully. ' .
                    (file_exists($target_file_path) ? 'Existing file was replaced.' : 'New file was created.'));
            } else {
                unlink($file_path); // Delete uploaded file on failure
                sendWebJsonResponse(true, 'Failed to create/replace language file. Please check file permissions.');
            }
        } else {
            redirect('admin/login', 'refresh');
        }
    }
}
