<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Payment_request extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['ion_auth', 'form_validation', 'upload']);
        $this->load->helper(['url', 'language', 'file']);
        $this->load->model(['payment_request_model', 'transaction_model']);

        if (!has_permissions('read', 'return_request')) {
            $this->session->set_flashdata('authorize_flag', PERMISSION_ERROR_MSG);
            redirect('admin/home', 'refresh');
        }
    }

    public function index()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $this->data['main_page'] = TABLES . 'payment-request';
            $settings = get_settings('system_settings', true);
            $this->data['title'] = 'Payment Request | ' . $settings['app_name'];
            $this->data['meta_description'] = ' Payment Request  | ' . $settings['app_name'];
            $this->load->view('admin/template', $this->data);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function update_payment_request()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $payment_req_id = $this->input->post('payment_request_id', true);
            $payment_type = $this->input->post('payment_type', true);
            $status = fetch_details('payment_requests', ['id' => $payment_req_id]);
            if (print_msg(!has_permissions('update', 'return_request'), PERMISSION_ERROR_MSG, 'return_request')) {
                return false;
            }
            $this->form_validation->set_rules('payment_request_id', 'id', 'trim|required|numeric|xss_clean');
            $this->form_validation->set_rules('payment_type', 'payment type', 'trim|required|xss_clean');
            $this->form_validation->set_rules('status', 'Status', 'trim|required|numeric|xss_clean');
            $this->form_validation->set_rules('update_remarks', 'Remarks ', 'trim|xss_clean');
            if (!$this->form_validation->run()) {
                sendWebJsonResponse(true, strip_tags(validation_errors()));
            } else {
                if (false) {
                    sendWebJsonResponse(true, 'You have already rejected the amount');
                } else {

                     if (isset($status[0]['status']) && $status[0]['status'] == 1 && in_array($_POST['status'], [0, 2])) {
                sendWebJsonResponse(true, 'You cannot change an approved payment request to pending or rejected.');
            }
                    $prev_status = fetch_details('transactions', ['id' => $_POST['id']], 'status');

                    if (isset($prev_status[0]['status']) && $prev_status[0]['status'] == '1' && $_POST['status'] == 2) {
                        sendWebJsonResponse(true, 'You cannot reject an approved payment request.');
                    }
                    if ($status[0]['status'] == 2) {
                        sendWebJsonResponse(true, 'You have already rejected the amount');
                    }
                    $fields = ['payment_request_id', 'status', 'update_remarks', 'id', 'payment_type'];

                    foreach ($fields as $field) {
                        $payment_request[$field] = $this->input->post($field, true) ?? "";
                    }

                    $res = $this->payment_request_model->update_payment_request($payment_request);

                    $error = $res['error'] == false ? false : true;

                    sendWebJsonResponse($error, $res['message']);
                }
            }
        } else {
            redirect('admin/login', 'refresh');
        }
    }


    public function view_payment_request_list()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $user_filter = $this->input->get('user_filter', true);
            $status_filter = $this->input->get('status_filter', true);
            return $this->payment_request_model->get_payment_request_list($user_filter, $status_filter);
        } else {
            redirect('admin/login', 'refresh');
        }
    }
}
