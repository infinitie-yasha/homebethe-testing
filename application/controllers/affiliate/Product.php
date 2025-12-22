<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['ion_auth', 'form_validation', 'upload', 'pagination']);
        $this->load->helper(['url', 'language', 'file', 'security']);
        $this->load->model(['product_model', 'category_model', 'affiliate_model']);
    }
    public function index()
    {
        // print_R('here');
        //     die;
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_affiliate_user()) {
            $this->data['main_page'] = TABLES . 'manage-product';
            $settings = get_settings('system_settings', true);
            $this->data['title'] = 'Product Management | ' . $settings['app_name'];
            $this->data['meta_description'] = 'Product Management |' . $settings['app_name'];


            $this->data['categories'] = $this->category_model->get_categories();

            $search = $this->input->get('search', true);

            $affiliate_categories = fetch_details('categories', ['is_in_affiliate' => 1], 'id');
            $affiliate_categories = array_column($affiliate_categories, 'id');

            $limit = ($this->input->get('per-page')) ? $this->input->get('per-page', true) : 12;

            // Pagination config
            $config = [];
            $config['base_url'] = base_url('affiliate/product'); // Change this as needed
            // $config['total_rows'] = $this->affiliate_model->count_affiliate_products_by_categories($affiliate_categories, $search);
            $config['total_rows'] = $this->affiliate_model->count_affiliate_products_by_categories($affiliate_categories, $search);
            $config['per_page'] = $limit;
            $config['num_links'] = 7;
            $config['use_page_numbers'] = TRUE;
            $config['reuse_query_string'] = TRUE;
            $config['page_query_string'] = TRUE;
            $config['query_string_segment'] = 'page';

            $config['attributes'] = array('class' => 'page-link');
            $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
            $config['full_tag_close'] = '</ul>';
            $config['prev_tag_open'] = '<li class="page-item">';
            $config['prev_link'] = '<i class="fa fa-arrow-left"></i>';
            $config['prev_tag_close'] = '</li>';

            $config['next_tag_open'] = '<li class="page-item">';
            $config['next_link'] = '<i class="fa fa-arrow-right"></i>';
            $config['next_tag_close'] = '</li>';

            $config['cur_tag_open'] = '<li class="page-item active disabled"><a class="page-link">';
            $config['cur_tag_close'] = '</a></li>';

            $config['num_tag_open'] = '<li class="page-item">';
            $config['num_tag_close'] = '</li>';

            $page_no = ($this->input->get('page')) ? $this->input->get('page') : 1;
            if (!is_numeric($page_no)) {
                redirect(base_url('products'));
            }
            $offset = ($page_no - 1) * $limit;

            $this->pagination->initialize($config);
            // Current page offset
            $offset = ($page_no - 1) * $limit;


            // Fetch products
            $products = $this->affiliate_model->get_affiliate_products_by_categories($affiliate_categories, $limit, $offset, $search);


            $this->data['products'] = $products['data'];
          
            $this->data['affiliate_categories'] = implode(',', $affiliate_categories);
            $this->data['pagination_links'] = $this->pagination->create_links();

            // If it's an AJAX request, return only product HTML
            if ($this->input->is_ajax_request()) {
                ob_start();

                // Same view, but we only render product section
                $this->load->view('affiliate/template', $this->data);
                $html = ob_get_clean();
                $doc = new DOMDocument();
                libxml_use_internal_errors(true);
                $doc->loadHTML($html);

                $finder = new DomXPath($doc);
                $nodes = $finder->query("//*[@id='product-list']");

                if ($nodes->length > 0) {
                    echo $doc->saveHTML($nodes->item(0));
                }
                return;
            }

            $this->load->view('affiliate/template', $this->data);
        } else {
            redirect('affiliate/login', 'refresh');
        }
    }

    public function manage_promoted_products()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_affiliate_user()) {
            $this->data['main_page'] = TABLES . 'promoted-products';
            $settings = get_settings('system_settings', true);
            $this->data['title'] = 'Promoted Products | ' . $settings['app_name'];
            $this->data['meta_description'] = 'Promoted Products | ' . $settings['app_name'];
            $this->data['categories'] = $this->category_model->get_categories();

            $this->load->view('affiliate/template', $this->data);
        } else {
            redirect('affiliate/login', 'refresh');
        }
    }

    public function get_categories_products($category_id = '')
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_affiliate_user()) {
            $this->data['main_page'] = TABLES . 'manage-product';
            $settings = get_settings('system_settings', true);
            $this->data['title'] = 'Promoted Products | ' . $settings['app_name'];
            $this->data['meta_description'] = 'Promoted Products | ' . $settings['app_name'];


            $affiliate_categories = fetch_details('categories', ['is_in_affiliate' => 1], 'id');
            $affiliate_categories = array_column($affiliate_categories, 'id');

            $limit = ($this->input->get('per-page')) ? $this->input->get('per-page', true) : 12;
            // Pagination config
            $config = [];
            $config['base_url'] = base_url('affiliate/product/get_categories_products/'. $category_id); // Change this as needed
            // $config['total_rows'] = $this->affiliate_model->count_affiliate_products_by_categories($affiliate_categories, $search);
            $config['total_rows'] = $this->affiliate_model->count_affiliate_products_by_categories($category_id);
            $config['per_page'] = $limit;
            $config['num_links'] = 7;
            $config['use_page_numbers'] = TRUE;
            $config['reuse_query_string'] = TRUE;
            $config['page_query_string'] = TRUE;
            $config['query_string_segment'] = 'page';

            $config['attributes'] = array('class' => 'page-link');
            $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
            $config['full_tag_close'] = '</ul>';
            $config['prev_tag_open'] = '<li class="page-item">';
            $config['prev_link'] = '<i class="fa fa-arrow-left"></i>';
            $config['prev_tag_close'] = '</li>';

            $config['next_tag_open'] = '<li class="page-item">';
            $config['next_link'] = '<i class="fa fa-arrow-right"></i>';
            $config['next_tag_close'] = '</li>';

            $config['cur_tag_open'] = '<li class="page-item active disabled"><a class="page-link">';
            $config['cur_tag_close'] = '</a></li>';

            $config['num_tag_open'] = '<li class="page-item">';
            $config['num_tag_close'] = '</li>';

            $page_no = ($this->input->get('page')) ? $this->input->get('page') : 1;
            if (!is_numeric($page_no)) {
                redirect(base_url('products'));
            }
            $offset = ($page_no - 1) * $limit;

            $this->pagination->initialize($config);
            // Current page offset
            $offset = ($page_no - 1) * $limit;


            // Fetch products
            $products = $this->affiliate_model->get_affiliate_products_by_categories($category_id, $limit, $offset);

            // Fetch products
            // $products = $this->affiliate_model->get_affiliate_products_by_categories($category_id);
             $this->data['total_products'] = $products['total'];
            $this->data['products'] = $products['data'];
            $this->data['pagination_links'] = $this->pagination->create_links();

            $this->load->view('affiliate/template', $this->data);
        } else {
            redirect('affiliate/login', 'refresh');
        }
    }

    // for getting affiliate product data list
    public function get_affiliate_product_data_list()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_affiliate_user()) {
            return $this->affiliate_model->get_product_details(is_in_affiliate: 1);
        } else {
            redirect('affiliate/login', 'refresh');
        }
    }
    // for getting affiliate promoted product data list
    public function get_my_promoted_products_list()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_affiliate_user()) {
            $affiliate_id = $_SESSION['user_id'];
            return $this->affiliate_model->get_promoted_product_list(is_in_affiliate: 1, affiliate_id: $affiliate_id);
        } else {
            redirect('affiliate/login', 'refresh');
        }
    }

    // for generating affiliate token
    // This function generates a secure token for affiliate products
   public function get_or_generate_token()
{
    // === 1. Security Checks ===
    if (!$this->input->is_ajax_request()) {
        $this->output
            ->set_status_header(403)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'error' => true,
                'message' => 'Direct access not allowed.'
            ]));
        return;
    }

    if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_affiliate_user()) {
        $this->output
            ->set_status_header(401)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'error' => true,
                'message' => 'Unauthorized access.'
            ]));
        return;
    }

    // === 2. Get & Validate POST Data ===
    $product_id = $this->input->post('product_id', true);
    $product_name = $this->input->post('product_name', true);
    $user_uuid = $this->input->post('user_id', true);
    $user_id = $_SESSION['user_id'];
    $category_id = $this->input->post('category_id', true);
    $affiliate_commission = $this->input->post('affiliate_commission', true);

    if (empty($product_id) || empty($user_uuid)) {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'error' => true,
                'message' => 'Invalid parameters.'
            ]));
        return;
    }

    // === 3. Check Existing Token ===
    $this->db->where('affiliate_id', $user_id);
    $this->db->where('product_id', $product_id);
    $existing = $this->db->get('affiliate_tracking')->row();

    if ($existing) {
        $response = [
            'error' => false,
            'token' => $existing->token,
            'message' => 'Token Already Exists',
            'csrfHash' => $this->security->get_csrf_hash()  // ← Critical!
        ];
    } else {
        // === 4. Generate New Token ===
        $timestamp = time();
        $secret = bin2hex(random_bytes(32));
        $raw_string = $product_id . '|' . $product_name . '|' . $user_uuid . '|' . $timestamp;
        $token = hash_hmac('sha256', $raw_string, $secret);

        if (!empty($token)) {
            $data = [
                'product_id'           => $product_id,
                'affiliate_id'         => $user_id,
                'token'                => $token,
                'category_id'          => $category_id,
                'category_commission'  => $affiliate_commission,
                'created_at'           => date('Y-m-d H:i:s')
            ];

            $this->affiliate_model->add_affiliate_tracking($data);

            $response = [
                'error' => false,
                'token' => $token,
                'message' => 'Token Generated Successfully',
                'csrfHash' => $this->security->get_csrf_hash()
            ];
        } else {
            $response = [
                'error' => true,
                'message' => 'Token Generation Failed',
                'csrfHash' => $this->security->get_csrf_hash()
            ];
        }
    }

    // === 5. Send JSON Response ===
    $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($response));

    // No need to `return` — output is final
}

    // public function check_token_status()
    // {
    //     if ($this->ion_auth->logged_in() && $this->ion_auth->is_affiliate_user()) {

    //         $user_id = $this->input->post('user_id', true);
    //         $product_id = $this->input->post('product_id', true);
    //         $timestamp = date('Y-m-d H:i:s');

    //         // Look for an unexpired token for this user and product
    //         $this->db->where('affiliate_id', $user_id);
    //         $this->db->where('product_id', $product_id);
    //         $this->db->where('expire_time >=', $timestamp);
    //         $query = $this->db->get('affiliate_tracking');

    //         if ($query->num_rows() > 0) {
    //             $existing = $query->row();

    //             $this->response['error'] = false;
    //             $this->response['token'] = $existing->token;
    //             $this->response['message'] = 'Token already exists and is valid.';
    //         } else {
    //             $this->response['error'] = true;
    //             $this->response['message'] = 'No valid token found for this product.';
    //         }

    //         echo json_encode($this->response);
    //     } else {
    //         // Redirect to login if not authenticated
    //         redirect('affiliate/login', 'refresh');
    //     }
    // }
}
