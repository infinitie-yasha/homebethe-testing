<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Fund_transfer extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['ion_auth', 'form_validation', 'upload']);
        $this->load->helper(['url', 'language', 'file']);
        $this->load->model('Fund_transfers_model');

        if (!has_permissions('read', 'fund_transfer')) {
            $this->session->set_flashdata('authorize_flag', PERMISSION_ERROR_MSG);
            redirect('admin/home', 'refresh');
        }
    }

    public function index()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $this->data['main_page'] = TABLES . 'manage-fund-transfers';
                        $this->data['delivery_boys'] = $this->db->where(['ug.group_id' => '3', 'u.active' => 1])->join('users_groups ug', 'ug.user_id = u.id')->get('users u')->result_array();
            $settings = get_settings('system_settings', true);
            $this->data['title'] = 'View Fund Transfer | ' . $settings['app_name'];
            $this->data['meta_description'] = ' View Fund Transfer  | ' . $settings['app_name'];
            if (isset($_GET['edit_id']) && !empty($_GET['edit_id'])) {
                $this->data['fetched_data'] = fetch_details('delivery_boys', ['id' => $_GET['edit_id'], 'status' => '1']);
            }
            $this->load->view('admin/template', $this->data);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function add_fund_transfer()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {


            if (!has_permissions('create', 'fund_transfer')) {
                return false;
            }

            $this->form_validation->set_rules('delivery_boy_id', 'Delivery Boy', 'trim|required|xss_clean|numeric');
            $this->form_validation->set_rules('transfer_amt', 'Transfer Amount', 'trim|required|xss_clean|numeric');
            $this->form_validation->set_rules('message', 'Message', 'trim|xss_clean');
            if (!$this->form_validation->run()) {
                sendWebJsonResponse(true, strip_tags(validation_errors()));
            } else {
                $delivery_boy_id = $this->input->post('delivery_boy_id', true);
                $transfer_amt = $this->input->post('transfer_amt', true);
                $message = $this->input->post('message', true);
                $res = fetch_details('users', ['id' => $delivery_boy_id],  'balance');
                if ($res[0]['balance'] > 0 && $res[0]['balance'] != null) {
                    if ($res[0]['balance'] < $transfer_amt) {
                        $message = 'Transfer amount should be less than' . $res[0]['balance'];
                        sendWebJsonResponse(true, $message);
                    }

                    update_wallet_balance('debit', $delivery_boy_id, $transfer_amt);
                    $this->Fund_transfers_model->set_fund_transfer($delivery_boy_id, $transfer_amt, $res[0]['balance'], 'success', $message);

                    $message = 'Amount Successfully Transfered';

                    sendWebJsonResponse(false, $message);
                } else {
                    $message = 'Balance should be greater than 0';
                    sendWebJsonResponse(true, $message);
                }
            }
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function view_fund_transfers()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

            return $this->Fund_transfers_model->get_fund_transfers_list();
        } else {
            redirect('admin/login', 'refresh');
        }
    }
}
