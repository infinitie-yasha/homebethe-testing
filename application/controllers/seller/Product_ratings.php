<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product_ratings extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['ion_auth', 'form_validation', 'upload']);
        $this->load->helper(['url', 'language', 'file']);
        $this->load->model(['product_model', 'rating_model']);


    }

    public function index()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_seller()) {
            $this->data['main_page'] = TABLES . 'manage-product-ratings';
            $settings = get_settings('system_settings', true);
            $this->data['title'] = 'Product Ratings Management | ' . $settings['app_name'];
            $this->data['meta_description'] = 'Product Ratings Management |' . $settings['app_name'];
            $this->load->view('seller/template', $this->data);
        } else {
            redirect('seller/login', 'refresh');
        }
    }

    public function get_ratings_list()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_seller()) {
            $seller_id = $this->session->userdata('user_id');
            return $this->rating_model->get_rating($seller_id);
        } else {
            redirect('seller/login', 'refresh');
        }
    }

    public function delete_rating()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_seller()) {

            if (print_msg(!has_permissions('delete', 'product'), PERMISSION_ERROR_MSG, 'product', false)) {
                return false;
            }

            $this->rating_model->delete_rating($_GET['id']);

            $this->response['error'] = false;
            $this->response['message'] = 'Deleted Successfully';

            print_r(json_encode($this->response));
        } else {
            redirect('seller/login', 'refresh');
        }
    }
}

