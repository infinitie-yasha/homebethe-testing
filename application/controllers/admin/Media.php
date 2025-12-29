<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Media extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['ion_auth', 'form_validation', 'upload']);
        $this->load->helper(['url', 'language', 'file']);
        $this->load->model(['media_model']);

        if (!has_permissions('read', 'media')) {
            $this->session->set_flashdata('authorize_flag', PERMISSION_ERROR_MSG);
            redirect('admin/home', 'refresh');
        }
    }
    public function index()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $this->data['main_page'] = VIEW . 'media-gallary';
            $settings = get_settings('system_settings', true);
            $this->data['title'] = 'Media | ' . $settings['app_name'];
            $this->data['meta_description'] = 'Media |' . $settings['app_name'];
            $this->load->view('admin/template', $this->data);
        } else {
            redirect('admin/login', 'refresh');
        }
    }
    
    public function upload()
    {
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('admin/login', 'refresh');
            exit();
        }

        if (print_msg(!has_permissions('create', 'media'), PERMISSION_ERROR_MSG, 'media')) {
            return false;
        }

        $year = date('Y');
        $target_path = FCPATH . MEDIA_PATH . $year . '/';
        $sub_directory = MEDIA_PATH . $year . '/';

        if (!file_exists($target_path)) {
            mkdir($target_path, 0777, true);
        }

        $temp_array = $media_ids = $other_images_new_name = [];
        $files = $_FILES;
        $other_image_info_error = "";

        $config['upload_path'] = $target_path;
        $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';

        $other_image_cnt = count($_FILES['documents']['name']);
        $other_img = $this->upload;
        $other_img->initialize($config);

        // Allowed image mime types & extensions
        $allowedMimeTypes = [
            'image/jpeg',
            'image/png',
            'image/jpg',
            'image/gif',
            'image/webp'
        ];

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        for ($i = 0; $i < $other_image_cnt; $i++) {

            if (empty($files['documents']['name'][$i])) {
                continue;
            }

            $_FILES['temp_image']['name'] = $files['documents']['name'][$i];
            $_FILES['temp_image']['type'] = $files['documents']['type'][$i];
            $_FILES['temp_image']['tmp_name'] = $files['documents']['tmp_name'][$i];
            $_FILES['temp_image']['error'] = $files['documents']['error'][$i];
            $_FILES['temp_image']['size'] = $files['documents']['size'][$i];

            /* ================= IMAGE-ONLY VALIDATION ================= */
            $fileTmp = $_FILES['temp_image']['tmp_name'];
            $fileExt = strtolower(pathinfo($_FILES['temp_image']['name'], PATHINFO_EXTENSION));
            $fileMime = mime_content_type($fileTmp);

            if (
                !in_array($fileMime, $allowedMimeTypes) ||
                !in_array($fileExt, $allowedExtensions)
            ) {
                $other_image_info_error .= ' Invalid file type. Only image files are allowed.';
                continue;
            }

            // Extra security (real image check)
            if (!@getimagesize($fileTmp)) {
                $other_image_info_error .= ' Uploaded file is not a valid image.';
                continue;
            }
            /* ========================================================= */

            if (!$other_img->do_upload('temp_image')) {
                $other_image_info_error .= ' ' . $other_img->display_errors();
            } else {
                $temp_array = $other_img->data();
                $temp_array['sub_directory'] = $sub_directory;

                $media_id = $this->media_model->set_media($temp_array);
                $media_ids[] = $media_id;

                if (strtolower($temp_array['image_type']) != 'gif') {
                    resize_image($temp_array, $target_path, $media_id);
                }

                $other_images_new_name[$i] = $temp_array['file_name'];
            }
        }

        // ❌ Delete uploaded images if any error occurred
        if (!empty($other_image_info_error)) {
            if (!empty($other_images_new_name)) {
                foreach ($other_images_new_name as $file) {
                    if (file_exists($target_path . $file)) {
                        unlink($target_path . $file);
                    }
                }
            }
            sendWebJsonResponse(true, $other_image_info_error);
        }

        // WEBP → PNG conversion
        $arr = explode(".", $_FILES['documents']['name'][0]);
        if (in_array("webp", $arr)) {

            $title = $_FILES['documents']['name'][0];
            $arr[count($arr) - 1] = "png";
            $newName = $target_path . implode(".", $arr);
            $title = rtrim($title, ".webp");

            $im = imagecreatefromwebp($target_path . $_FILES['documents']['name'][0]);

            if (file_exists($newName)) {
                $fileName = $arr[count($arr) - 2];
                $temp = explode("_", $fileName);

                if (count($temp) == 1) {
                    $temp = explode("_", $fileName . "_1");
                }

                if (is_numeric(end($temp))) {
                    $temp[count($temp) - 1] = (int) end($temp) + 1;
                }

                $fileName = implode("_", $temp);
                $arr[count($arr) - 2] = $fileName;
                $newName = $target_path . implode(".", $arr);
                $title = $fileName;
            }

            update_details([
                'name' => $title . ".png",
                'title' => $title,
                'extension' => 'png'
            ], ['name' => $_FILES['documents']['name'][0]], "media");

            unlink($target_path . $_FILES['documents']['name'][0]);
            imagepng($im, $newName);
            imagedestroy($im);
        }

        sendWebJsonResponse(false, 'Images Uploaded Successfully!');
    }


    function delete($mediaid = false)
    {
        // print_r($_GET);
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('admin/login', 'refresh');
            exit();
        }
        if (print_msg(!has_permissions('delete', 'media'), PERMISSION_ERROR_MSG, 'media')) {
            return false;
        }
        // $urlid = $this->uri->segment(4);
        $id = (isset($_GET['id']) && !empty($_GET['id'])) ? $_GET['id'] : $mediaid;
        /* check if id is not empty or invalid */
        if (!is_numeric($id) && $id == '') {
            sendWebJsonResponse(true, 'Something went wrong! Try again!');
        }
        $media = $this->media_model->get_media_by_id($id);
        /* check if media actually exists */
        if (empty($media)) {
            sendWebJsonResponse(true, 'Media does not exist!');
        }
        $path = FCPATH . $media[0]['sub_directory'] . $media[0]['name'];
        $where = array('id' => $id);

        if (delete_details($where, 'media')) {

            delete_images($media[0]['sub_directory'], $media[0]['name']);

            sendWebJsonResponse(false, 'Media deleted successfully!');

        } else {
            sendWebJsonResponse(true, 'Media could not be deleted!');
        }
    }

    public function media_delete()
    {
        // Check if it's an AJAX request and if IDs are sent via POST.

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('admin/login', 'refresh');
            exit();
        }
        if (print_msg(!has_permissions('delete', 'media'), PERMISSION_ERROR_MSG, 'media')) {
            return false;
        }
        if ($this->input->post('ids')) {
            $ids = $this->input->post('ids');

            // Validate IDs (optional, depending on your application logic)
            $deleted = $this->media_model->delete_media($ids);

            if ($deleted) {
                sendWebJsonResponse(false, 'Media items deleted successfully.');
            } else {
                sendWebJsonResponse(true, 'Failed to delete media items.');
            }
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    function fetch()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            return $this->media_model->fetch_media();
        } else {
            redirect('admin/login', 'refresh');
        }
    }
}
