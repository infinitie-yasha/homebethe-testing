<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Slider extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(['url', 'language', 'timezone_helper']);
        $this->load->model(['Slider_model', 'category_model']);
        if (!has_permissions('read', 'home_slider_images')) {
            $this->session->set_flashdata('authorize_flag', PERMISSION_ERROR_MSG);
            redirect('admin/home', 'refresh');
        }
    }

    public function index()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $this->data['main_page'] = FORMS . 'slider';
            $settings = get_settings('system_settings', true);
            $this->data['title'] = (isset($_GET['edit_id']) && !empty($_GET['edit_id'])) ? 'Edit Slider | ' . $settings['app_name'] : 'Add Slider | ' . $settings['app_name'];
            $this->data['meta_description'] = 'Add Slider | ' . $settings['app_name'];
            $this->data['categories'] = $this->category_model->get_categories();
            if (isset($_GET['edit_id']) && !empty($_GET['edit_id'])) {
                $this->data['fetched_data'] = fetch_details('sliders', ['id' => $_GET['edit_id']]);
            }
            $this->data['about_us'] = get_settings('about_us');
            $this->load->view('admin/template', $this->data);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function manage_slider()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $this->data['main_page'] = TABLES . 'manage-slider';
            $settings = get_settings('system_settings', true);
            $this->data['title'] = 'Slider Management | ' . $settings['app_name'];
            $this->data['meta_description'] = ' Slider Management  | ' . $settings['app_name'];
            $this->data['categories'] = $this->category_model->get_categories();
            if (isset($_GET['edit_id']) && !empty($_GET['edit_id'])) {
                sendWebJsonResponse(false, '', [], $this->response);
            }

            $this->load->view('admin/template', $this->data);
        } else {
            redirect('admin/login', 'refresh');
        }
    }
    public function delete_slider()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            if (print_msg(!has_permissions('delete', 'home_slider_images'), PERMISSION_ERROR_MSG, 'home_slider_images', false)) {
                return false;
            }
            if (defined('SEMI_DEMO_MODE') && SEMI_DEMO_MODE == 0) {
                $this->response['error'] = true;
                $this->response['message'] = SEMI_DEMO_MODE_MSG;
                echo json_encode($this->response);
                return false;
                exit();
            }
            if (delete_details(['id' => $_GET['id']], 'sliders') == TRUE) {
                $this->response['error'] = false;
                $this->response['message'] = 'Deleted Succesfully';
            } else {
                $this->response['error'] = true;
                $this->response['message'] = 'Something Went Wrong';
            }
            print_r(json_encode($this->response));
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    function get_values_by_type()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin() && isset($_GET['type_val'])) {
            print_r(json_encode(fetch_details($_GET['type_val'], '', 'id,name')));
        } else {
            redirect('admin/login', 'refresh');
        }
    }
   public function add_slider()
{
    if (isset($_POST['edit_slider']) && !empty($_POST['edit_slider'])) {
        // Update permission
        if (print_msg(!has_permissions('update', 'home_slider_images'), PERMISSION_ERROR_MSG, 'home_slider_images')) {
            return false;
        }

        if (defined('SEMI_DEMO_MODE') && SEMI_DEMO_MODE == 0) {
            $this->response['error'] = true;
            $this->response['message'] = SEMI_DEMO_MODE_MSG;
            echo json_encode($this->response);
            return false;
            exit();
        }
    } else {
        // Create permission
        if (print_msg(!has_permissions('create', 'home_slider_images'), PERMISSION_ERROR_MSG, 'home_slider_images')) {
            return false;
        }
    }

    $this->form_validation->set_rules('slider_type', 'Slider Type', 'trim|required|xss_clean');

    $edit_id = $this->input->post('edit_slider', true);
    $uploaded_image = $this->input->post('uploaded_image', true);

    /**
     * ✅ Image validation logic:
     * - For Add → always required.
     * - For Update → required only if no new file and no existing image.
     */
    if (empty($edit_id)) {
        $this->form_validation->set_rules('image', 'Slider Image', 'trim|required|xss_clean');
    } else {
        if (empty($_FILES['image']['name']) && empty($uploaded_image)) {
            $this->form_validation->set_rules('image', 'Slider Image', 'trim|required|xss_clean');
        }
    }

    // Type-specific rules
    if (isset($_POST['slider_type']) && $_POST['slider_type'] == 'categories') {
        $this->form_validation->set_rules('category_id', 'Category', 'trim|required|xss_clean');
    }
    if (isset($_POST['slider_type']) && ($_POST['slider_type'] == 'sliderurl' || $_POST['slider_type'] == 'slider_url')) {
        $this->form_validation->set_rules('link', 'Link', 'trim|required|xss_clean');
        // Convert legacy slider_url to new format
        $_POST['slider_type'] = 'sliderurl';
    }
    if (isset($_POST['slider_type']) && $_POST['slider_type'] == 'products') {
        $this->form_validation->set_rules('product_id', 'Product', 'trim|required|xss_clean');
    }

    if (!$this->form_validation->run()) {
        sendWebJsonResponse(true, strip_tags(validation_errors()));
    } else {
        $fields = ['edit_slider', 'type_id', 'slider_type', 'category_id', 'link', 'product_id', 'image', 'uploaded_image'];
        foreach ($fields as $field) {
            $slider[$field] = $this->input->post($field, true) ?? "";
        }

        $this->Slider_model->add_slider($slider);

        $message = (!empty($edit_id)) ? 'Slider Updated Successfully' : 'Slider Added Successfully';
        sendWebJsonResponse(false, $message);
    }
}




    public function view_slider()
    {
    $limit  = $this->input->get('limit') ?? 10;
    $offset = $this->input->get('offset') ?? 0;
    $sort   = $this->input->get('sort') ?? 'id';
    $order  = $this->input->get('order') ?? 'DESC';
    $search = $this->input->get('search') ?? '';
    $type_filter = $this->input->get('type_filter', true);
        return $this->Slider_model->get_slider_list($limit, $offset, $sort, $order, $search, $type_filter);
    }
}
