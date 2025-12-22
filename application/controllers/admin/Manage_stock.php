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
        $this->load->model(['product_model', 'product_faqs_model', 'category_model']);
    }

    public function index()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $this->data['main_page'] = TABLES . 'manage_stock';
            $settings = get_settings('system_settings', true);
            $this->data['title'] = 'Stock Management| ' . $settings['app_name'];
            $this->data['meta_description'] = 'Stock Management |' . $settings['app_name'];
            if (isset($_GET['edit_id'])) {

                $product_id = fetch_details('product_variants', ['id' => $_GET['edit_id']]);
                $product_type = fetch_details('products', ['id' => $product_id[0]['product_id']]);

                if ($product_type[0]['stock_type'] == 0) {
                    $stock = $product_type[0];
                    $id = $stock['id'];
                    $attributes = fetch_details("product_attributes", ['product_id' => $product_id[0]['product_id']]);
                    $attribute_value = fetch_details("attribute_values", ['id' => $attributes[0]['attribute_value_ids']], ['value']);
                    $this->data['fetched'] = $stock['stock'];
                } else {
                    $stock = fetch_details("product_variants", ['id' => $_GET['edit_id']], ['stock', 'product_id', 'attribute_value_ids']);
                    $attribute_value = fetch_details("attribute_values", ['id' => $stock[0]['attribute_value_ids']], ['value']);
                    $id = $stock[0]['product_id'];
                    $this->data['fetched'] = $stock[0]['stock'];
                }

                $this->data['fetched_data'] = fetch_product("", "", $id);
                $this->data['attribute'] = $attribute_value;

            }
            $this->data['categories'] = $this->category_model->get_categories();

            $this->data['sellers'] = $this->db->select(' u.username as seller_name,u.id as seller_id,sd.category_ids,sd.id as seller_data_id  ')
                ->join('users_groups ug', ' ug.user_id = u.id ')
                ->join('seller_data sd', ' sd.user_id = u.id ')
                ->where(['ug.group_id' => '4'])
                ->where(['sd.status' => 1])
                ->get('users u')->result_array();

            $this->load->view('admin/template', $this->data);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function get_stock_list()
    {
        $seller_id = (isset($_GET['seller_id']) && !empty($_GET['seller_id'])) ? $this->input->get('seller_id', true) : NULL;
        $status = (isset($_GET['status']) && $_GET['status'] != "") ? $this->input->get('status', true) : NULL;
        if (isset($_GET['flag']) && !empty($_GET['flag'])) {
            return $this->product_model->get_product_details($_GET['flag'], $seller_id, $status);
        }
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

            return $this->product_model->get_stock_details();
        } else {
            redirect('admin/login', 'refresh');
        }
    }


    public function update_stock()
    {
        $this->form_validation->set_rules('product_name', 'Product Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('current_stock', 'Current Stock', 'trim|required|xss_clean');
        $this->form_validation->set_rules('quantity', 'Quantity', 'trim|required|xss_clean|numeric|greater_than[0]');
        $this->form_validation->set_rules('type', 'Type', 'trim|required|xss_clean');
        $this->form_validation->set_rules('variant_id', 'Variant ID', 'trim|required|xss_clean');

        if (!$this->form_validation->run()) {
            sendWebJsonResponse(true, strip_tags(validation_errors()));
        } else {
            $type = $this->input->post('type', true);
            $variant_id = $this->input->post('variant_id', true);
            $quantity = $this->input->post('quantity', true);
            $product_name = $this->input->post('product_name', true);
            $current_stock = $this->input->post('current_stock', true);

            if ($type == 'add') {
                update_stock([$variant_id], [$quantity], 'plus');
                $new_stock = $current_stock + $quantity;
            } else {
                if ($type == 'subtract') {
                    if ($quantity > $current_stock) {
                        sendWebJsonResponse(true, 'Subtracted stock cannot be greater than current stock');
                    }
                }
                update_stock([$variant_id], [$quantity]);
                $new_stock = $current_stock - $quantity;
            }

            sendWebJsonResponse(false, 'Stock Updated Successfully', ['new_stock' => $new_stock]);
        }
    }


    public function get_product_data()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $seller_id = (isset($_GET['seller_id']) && !empty($_GET['seller_id'])) ? $this->input->get('seller_id', true) : NULL;
            $status = (isset($_GET['status']) && $_GET['status'] != "") ? $this->input->get('status', true) : NULL;
            if (isset($_GET['flag']) && !empty($_GET['flag'])) {
                return $this->product_model->get_product_details($_GET['flag'], $seller_id, $status);
            }
            return $this->product_model->get_product_details(null, $seller_id, $status);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function get_variant_data()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
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
                    // $attributes = fetch_details("product_attributes", ['product_id' => $product_id[0]['product_id']]);
                    // $attribute_value = fetch_details("attribute_values", ['id' => $attributes[0]['attribute_value_ids']], ['value']);
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
