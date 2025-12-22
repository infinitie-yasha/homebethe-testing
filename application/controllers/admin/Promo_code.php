<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Promo_code extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['ion_auth', 'form_validation', 'upload']);
        $this->load->helper(['url', 'language', 'file']);
        $this->load->model('Promo_code_model');
        // Deactivate expired promo codes
        $this->Promo_code_model->deactivate_expired_promo_codes();

        if (!has_permissions('read', 'promo_code')) {
            $this->session->set_flashdata('authorize_flag', PERMISSION_ERROR_MSG);
            redirect('admin/home', 'refresh');
        }
    }

    public function index()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $this->data['main_page'] = FORMS . 'promo-code';
            $settings = get_settings('system_settings', true);
            $this->data['title'] = 'Add Promo code | ' . $settings['app_name'];
            $this->data['meta_description'] = ' Add Promo code  | ' . $settings['app_name'];
            if (isset($_GET['edit_id'])) {
                $this->data['fetched_details'] = fetch_details('promo_codes', ['id' => $_GET['edit_id']]);
            }
            $this->load->view('admin/template', $this->data);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function manage_promo_code()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $this->data['main_page'] = TABLES . 'manage-promo-code';
            $settings = get_settings('system_settings', true);
            $this->data['title'] = 'Promo Code Management | ' . $settings['app_name'];
            $this->data['meta_description'] = ' Promo Code Management  | ' . $settings['app_name'];
            if (isset($_GET['edit_id']) && !empty($_GET['edit_id'])) {
                $this->data['fetched_data'] = fetch_details('promo_codes', ['id' => $_GET['edit_id']]);

                sendWebJsonResponse(false, '', [], $this->data);
            }
            $this->load->view('admin/template', $this->data);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function view_promo_code()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $discount_type_filter = $this->input->get('discount_type_filter', true);
            $status_filter = $this->input->get('status_filter', true);
            return $this->Promo_code_model->get_promo_code_list($discount_type_filter, $status_filter);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function get_promo_code_details()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $id = $this->input->post('id', true);

            if (empty($id)) {
                sendWebJsonResponse(true, 'Invalid promo code ID');
            }

            $promo_code = fetch_details('promo_codes', ['id' => $id]);

            if (!empty($promo_code)) {
                sendWebJsonResponse(false, 'Promo code details fetched successfully', $promo_code[0]);
            } else {
                sendWebJsonResponse(true, 'Promo code not found');
            }

        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function delete_promo_code()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            if (!has_permissions('delete', 'promo_code')) {
                return false;
            }

            if (delete_details(['id' => $_GET['id']], 'promo_codes') == TRUE) {
                $this->response['error'] = false;
                $this->response['message'] = 'Deleted Succesfully';
                print_r(json_encode($this->response));
            } else {
                $this->response['error'] = true;
                $this->response['message'] = 'Something Went Wrong';
                print_r(json_encode($this->response));
            }
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function add_promo_code()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            if (!has_permissions('create', 'promo_code')) {
                sendWebJsonResponse(true, 'You don\'t have permission to create / update promo code !');
            }

            $this->form_validation->set_rules('promo_code', 'Promo Code ', 'trim|required|xss_clean|max_length[15]');
            $this->form_validation->set_rules('message', 'Message ', 'trim|required|xss_clean');
            $this->form_validation->set_rules('start_date', 'Start date ', 'trim|required|xss_clean');
            $this->form_validation->set_rules('end_date', 'End date ', 'trim|required|xss_clean');
            $this->form_validation->set_rules('no_of_users', 'No of Users ', 'trim|required|numeric|xss_clean|greater_than[0]');
            $this->form_validation->set_rules('minimum_order_amount', 'Minimum Order Amount ', 'trim|numeric|required|xss_clean|greater_than_equal_to[0]');
            $this->form_validation->set_rules('discount_type', 'Discount Type ', 'trim|required|xss_clean');
            $this->form_validation->set_rules('discount', 'Discount', 'trim|required|numeric|xss_clean|less_than_equal_to[' . $this->input->post('minimum_order_amount') . ']');
            $this->form_validation->set_rules('repeat_usage', 'Repeat Usage ', 'trim|required|xss_clean');
            $this->form_validation->set_rules('image', 'Image ', 'required|xss_clean');
            $this->form_validation->set_rules('is_cashback', 'Is Cashback ', 'trim|xss_clean');
            $this->form_validation->set_rules('list_promocode', 'List Promocode ', 'trim|xss_clean');

            if ($_POST['repeat_usage'] == '1') {
                $this->form_validation->set_rules('no_of_repeat_usage', 'No. of Repeat Usage ', 'trim|required|numeric|xss_clean|greater_than[0]');
            }
            if ($_POST['discount_type'] == 'percentage') {
                $this->form_validation->set_rules('max_discount_amount', 'Maximum Discount Amount', 'trim|numeric|required|xss_clean|less_than_equal_to[' . $this->input->post('minimum_order_amount') . ']');
            }
            $this->form_validation->set_rules('status', 'Status ', 'trim|required|xss_clean');

            if (!$this->form_validation->run()) {

                sendWebJsonResponse(true, strip_tags(validation_errors()));
            } else {

                if (isset($_POST['edit_promo_code'])) {

                    if (is_exist(['promo_code' => $_POST['promo_code']], 'promo_codes', $_POST['edit_promo_code'])) {
                        sendWebJsonResponse(true, 'Promo Code Already Exists !');
                    }
                } else {
                    if (is_exist(['promo_code' => $_POST['promo_code']], 'promo_codes')) {
                        sendWebJsonResponse(true, 'Promo Code Already Exists !');
                    }
                }

                $fields = [
                    'edit_promo_code',
                    'promo_code',
                    'message',
                    'start_date',
                    'end_date',
                    'no_of_users',
                    'minimum_order_amount',
                    'discount',
                    'discount_type',
                    'max_discount_amount',
                    'repeat_usage',
                    'image',
                    'status',
                    'no_of_repeat_usage',
                    'list_promocode',
                    'is_cashback'
                ];
                // print_r($_POST['is_cashback']);
                // die();
                foreach ($fields as $field) {
                    $promocode[$field] = $this->input->post($field, true) ?? "";
                }
                // print_r($promocode);
                // die();
                $this->Promo_code_model->add_promo_code_details($promocode);

                $message = (isset($_POST['edit_promo_code']) && !empty($_POST['edit_promo_code'])) ? 'Promo code Updated Successfully' : 'Promo code Added Successfully';

                sendWebJsonResponse(false, $message);
            }
        } else {
            redirect('admin/login', 'refresh');
        }
    }
}
