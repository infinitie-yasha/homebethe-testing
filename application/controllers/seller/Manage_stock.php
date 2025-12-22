<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manage_stock extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['ion_auth', 'form_validation', 'upload']);
        $this->load->helper(['url', 'language', 'file']);
        $this->load->model(['product_model', 'product_faqs_model']);
    }
    public function index()
{
    if ($this->ion_auth->logged_in() && $this->ion_auth->is_seller()) {
        $this->data['main_page'] = TABLES . 'manage_stock';
        $settings = get_settings('system_settings', true);
        $this->data['title'] = 'Stock Management | ' . $settings['app_name'];
        $this->data['meta_description'] = 'Stock Management | ' . $settings['app_name'];

        $seller_id = $_SESSION['user_id'];
        // Fetch categories using your new method
        $this->data['categories'] = json_decode(json_encode($this->category_model->get_seller_categories($seller_id)), true);

        if (isset($_GET['edit_id'])) {
            $stock = fetch_details("product_variants", ['id' => $_GET['edit_id']], ['stock', 'product_id', 'attribute_value_ids']);
            if (!empty($stock)) {
                $product_id = $stock[0]['product_id'];
                $product_data = fetch_product("", "", $product_id);

                $this->data['fetched_data'] = $product_data;
                $this->data['fetched'] = $stock[0]['stock'];
                $attribute_value = fetch_details("attribute_values", ['id' => $stock[0]['attribute_value_ids']], ['value']);
                $this->data['attribute'] = $attribute_value;
                $this->data['variant_id'] = $_GET['edit_id'];
            }
        }

        $this->load->view('seller/template', $this->data);
    } else {
        redirect('seller/login', 'refresh');
    }
}

    public function get_stock_list()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_seller()) {

            return $this->product_model->get_seller_stock_details();
        } else {
            redirect('seller/login', 'refresh');
        }
    }
public function update_stock()
{
    $this->form_validation->set_rules('product_name', 'Product Name', 'trim|required|xss_clean');
    $this->form_validation->set_rules('current_stock', 'Current Stock', 'trim|required|numeric|xss_clean');
    $this->form_validation->set_rules('quantity', 'Quantity', 'trim|required|numeric|greater_than[0]|xss_clean');
    $this->form_validation->set_rules('type', 'Type', 'trim|required|in_list[add,subtract]|xss_clean');
    $this->form_validation->set_rules('variant_id', 'Variant ID', 'trim|required|numeric|xss_clean');

    if (!$this->form_validation->run()) {
        sendWebJsonResponse(true, strip_tags(validation_errors()));
    }

    $variant_id = $this->input->post('variant_id', true);
    $quantity = (int) $this->input->post('quantity', true);
    $type = $this->input->post('type', true);
    $current_stock = (int) $this->input->post('current_stock', true);
    $product_name = $this->input->post('product_name', true); // Store product_name

    // Verify variant exists
    $this->db->where('id', $variant_id);
    $product = $this->db->get('product_variants')->row_array();
    if (!$product) {
        sendWebJsonResponse(true, 'Invalid product variant.');
    }

    // Validate stock for subtraction
    if ($type === 'subtract' && $quantity > $current_stock) {
        sendWebJsonResponse(true, 'Subtracted stock cannot be greater than current stock.');
    }

    // Update stock
    $new_stock = ($type === 'add') ? $current_stock + $quantity : $current_stock - $quantity;
    $this->db->where('id', $variant_id);
    $this->db->update('product_variants', ['stock' => $new_stock]);
    // If affected_rows() == 0 it may be because the new stock equals the previous value.
    if ($this->db->affected_rows() > 0) {
        $success = true;
    } else {
        // double-check current DB value to determine if update actually resulted in desired state
        $this->db->where('id', $variant_id);
        $row = $this->db->get('product_variants')->row_array();
        if ($row && isset($row['stock']) && (int) $row['stock'] === (int) $new_stock) {
            $success = true; // nothing changed but desired value already present
        } else {
            $success = false;
        }
    }

    if ($success) {
        sendWebJsonResponse(false, 'Stock updated successfully.', [
            'new_stock' => $new_stock,
            'product_name' => $product_name, // Return original product_name
            'current_stock' => $current_stock, // Return original current_stock
            'variant_id' => $variant_id // Return original variant_id
        ]);
    } else {
        sendWebJsonResponse(true, 'Failed to update stock in the database.');
    }

    echo json_encode($this->response);
}
public function get_variant_data()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_seller()) {
            // if (isset($_GET['edit_id'])) {

            //     $product_id = fetch_details('product_variants', ['id' => $_GET['edit_id']]);
            //     $product_type = fetch_details('products', ['id' => $product_id[0]['product_id']]);

            //     if ($product_type[0]['stock_type'] == 0) {
            //         $stock = $product_type[0];
            //         $id = $stock['id'];
            //         $attributes = fetch_details("product_attributes", ['product_id' => $product_id[0]['product_id']]);
            //         $attribute_value = fetch_details("attribute_values", ['id' => $attributes[0]['attribute_value_ids']], ['value']);
            //         $this->data['fetched'] = $stock['stock'];
            //     } else {
            //         $stock = fetch_details("product_variants", ['id' => $_GET['edit_id']], ['stock', 'product_id', 'attribute_value_ids']);
            //         $attribute_value = fetch_details("attribute_values", ['id' => $stock[0]['attribute_value_ids']], ['value']);
            //         $id = $stock[0]['product_id'];
            //         $this->data['fetched'] = $stock[0]['stock'];
            //     }

            //     $this->data['fetched_data'] = fetch_product("", "", $id);
            //     $this->data['attribute'] = $attribute_value;

            // }
            if (isset($_GET['edit_id'])) {
                $product_id = fetch_details('product_variants', ['id' => $_GET['edit_id']]);
                $product_type = fetch_details('products', ['id' => $product_id[0]['product_id']]);
                // print_r($product_type[0]);

                if ($product_type[0]['stock_type'] == 0) {
                    $stock = $product_type[0];
                    $id = $stock['id'];
                    $attributes = fetch_details("product_attributes", ['product_id' => $product_id[0]['product_id']]);
                    $attribute_value = fetch_details("attribute_values", ['id' => $attributes[0]['attribute_value_ids']], ['value']);
                    $current_stock = $stock['stock'];
                } else {
                    $stock = fetch_details("product_variants", ['id' => $_GET['edit_id']], ['stock', 'product_id', 'attribute_value_ids']);
                    $attribute_value = fetch_details("attribute_values", ['id' => $stock[0]['attribute_value_ids']], ['value']);
                    $id = $stock[0]['product_id'];
                    $current_stock = $stock[0]['stock'];
                }

                $fetched_data = fetch_product("", "", $id);
                $product_name = '';

                if (isset($attribute_value[0]['value']) && !empty($attribute_value[0]['value']) && isset($fetched_data['product'][0]['stock_type']) && $fetched_data['product'][0]['stock_type'] != 1) {
                    $product_name = $fetched_data['product'][0]['name'] . ' - ' . $attribute_value[0]['value'];
                } else if (isset($fetched_data['product'][0]['name'])) {
                    $product_name = $fetched_data['product'][0]['name'];
                }

                // Return JSON data
                $response = [
                    'success' => true,
                    'data' => [
                        'variant_id' => $_GET['edit_id'],
                        'product_name' => $product_name,
                        'current_stock' => $current_stock
                    ]
                ];

                echo json_encode($response);
            }
        } else {
            $response = ['success' => false, 'message' => 'Unauthorized'];
            echo json_encode($response);
        }
    }
    
}
