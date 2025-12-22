<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Featured_sections extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(['url', 'language', 'timezone_helper']);
        $this->load->model(['Featured_section_model', 'category_model']);
        if (!has_permissions('read', 'featured_section')) {
            $this->session->set_flashdata('authorize_flag', PERMISSION_ERROR_MSG);
            redirect('admin/home', 'refresh');
        }
    }

    public function index()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $this->data['main_page'] = TABLES . 'featured_section';
            $settings = get_settings('system_settings', true);
            $this->data['title'] = 'Featured Sections Management | ' . $settings['app_name'];
            $this->data['meta_description'] = ' Featured Sections Management  | ' . $settings['app_name'];
            $this->data['categories'] = $this->category_model->get_categories();
            if (isset($_GET['edit_id'])) {
                $featured_data = fetch_details('sections', ['id' => $_GET['edit_id']]);
                $this->data['product_details'] = $this->db->where_in('id', explode(',', $featured_data[0]['product_ids']))->get('products')->result_array();
                $this->data['fetched_data'] = $featured_data;

                sendWebJsonResponse(false, '', [], $this->response);
            }

            $this->data['product_details'] = $this->db->select('*')->where('type', 'simple_product')->or_where('type', 'variable_product')->get('products')->result_array();
            $this->data['digital_product_details'] = $this->db->select('*')->where('type', 'digital_product')->get('products')->result_array();
            $this->load->view('admin/template', $this->data);
        } else {
            redirect('admin/login', 'refresh');
        }
    }


    public function add_featured_section()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

            if (isset($_POST['edit_featured_section']) && !empty($_POST['edit_featured_section'])) {
                if (print_msg(!has_permissions('update', 'featured_section'), PERMISSION_ERROR_MSG, 'featured_section')) {
                    return false;
                }
            } else {
                if (print_msg(!has_permissions('create', 'featured_section'), PERMISSION_ERROR_MSG, 'featured_section')) {
                    return false;
                }
            }

            $this->form_validation->set_rules('title', ' Title ', 'trim|required|xss_clean');
            $this->form_validation->set_rules('short_description', ' Short Description ', 'trim|required|xss_clean');
            $this->form_validation->set_rules('style', ' Style ', 'trim|required|xss_clean');
            $this->form_validation->set_rules('product_type', ' Product Type ', 'trim|required|xss_clean', array('required' => 'Select Product Type'));
            $this->form_validation->set_rules('product_ids[]', ' Product ', 'trim|xss_clean');
            //seo validation
            $this->form_validation->set_rules('seo_page_title', ' SEO Page Title', 'trim|xss_clean');
            $this->form_validation->set_rules('seo_meta_keywords', 'SEO Meta Keywords', 'trim|xss_clean');
            $this->form_validation->set_rules('seo_meta_description', 'SEO Meta Description', 'trim|xss_clean');
            $this->form_validation->set_rules('seo_og_image', 'SEO Open Graph Image', 'trim|xss_clean');

            if (!$this->form_validation->run()) {
                sendWebJsonResponse(true, strip_tags(validation_errors()));
            } else {

                if (isset($_POST['edit_featured_section']) && !empty($_POST['edit_featured_section'])) {

                    if (is_exist(['title' => $_POST['title']], 'sections', [$_POST['edit_featured_section']])) {
                        sendWebJsonResponse(true, 'Title Already Exists !');
                    }
                } else {
                    if (is_exist(['title' => $_POST['title']], 'sections')) {
                        sendWebJsonResponse(true, 'Title Already Exists !');
                    }
                }

                if (isset($_POST['seo_meta_keywords']) && $_POST['seo_meta_keywords'] != '') {
                    $_POST['seo_meta_keywords'] = json_decode($_POST['seo_meta_keywords'], 1);
                    $seo_meta_keywords = array_column($_POST['seo_meta_keywords'], 'value');
                    $_POST['seo_meta_keywords'] = implode(",", $seo_meta_keywords);
                }

                $fields = [
                    'edit_featured_section',
                    'title',
                    'short_description',
                    'style',
                    'product_type',
                    'seo_page_title',
                    'seo_meta_keywords',
                    'seo_meta_description',
                    'seo_og_image'
                ];

                foreach ($fields as $field) {
                    $feature_section[$field] = $this->input->post($field, true) ?? "";
                }


                $feature_section['product_ids'] = $this->input->post('product_ids[]');
                $feature_section['categories'] = $this->input->post('categories[]');
                $this->Featured_section_model->add_featured_section($feature_section);

                $message = (isset($_POST['edit_featured_section']) && !empty($_POST['edit_featured_section'])) ? 'Section Updated Successfully' : 'Section Added Successfully';

                sendWebJsonResponse(false, $message);
            }
            print_r(json_encode($this->response));
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function section_order()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $this->data['main_page'] = TABLES . 'section-order';
            $settings = get_settings('system_settings', true);
            $this->data['title'] = 'Section Order | ' . $settings['app_name'];
            $this->data['meta_description'] = 'Section Order | ' . $settings['app_name'];
            $sections = $this->db->select('*')->order_by('row_order')->get('sections')->result_array();
            $this->data['section_result'] = $sections;
            $this->load->view('admin/template', $this->data);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function update_section_order()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            if (defined('ALLOW_MODIFICATION') && ALLOW_MODIFICATION == 0) {
                sendWebJsonResponse(true, DEMO_VERSION_MSG);
            }
            $i = 0;
            $temp = array();
            $flag = false;
            foreach ($_GET['section_id'] as $row) {
                $temp[$row] = $i;
                $data = [
                    'row_order' => $i
                ];
                $data = escape_array($data);
                $this->db->where(['id' => $row])->update('sections', $data);
                $i++;
                $flag = true;
            }
            if ($flag == true) {
                sendWebJsonResponse(false, 'Section order update successfully');
            } else {
                sendWebJsonResponse(true, 'Order not updated.');
            }
        } else {
            redirect('admin/login', 'refresh');
        }
    }


    public function get_section_list()
    {

        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            return $this->Featured_section_model->get_section_list();
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function delete_featured_section()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

            if (print_msg(!has_permissions('delete', 'featured_section'), PERMISSION_ERROR_MSG, 'featured_section', false)) {
                return false;
            }
            if (defined('SEMI_DEMO_MODE') && SEMI_DEMO_MODE == 0) {
                sendWebJsonResponse(true, SEMI_DEMO_MODE_MSG);
            }
            if (delete_details(['id' => $_GET['id']], 'sections') == TRUE) {
                sendWebJsonResponse(false, 'Feature Section Deleted Succesfully');
            } else {
                sendWebJsonResponse(true, 'Something Went Wrong');
            }
        } else {
            redirect('admin/login', 'refresh');
        }
    }
}
