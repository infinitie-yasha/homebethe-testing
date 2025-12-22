<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Themes extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(['url', 'language', 'timezone_helper']);
        $this->load->model('Setting_model');

        if (!has_permissions('read', 'settings')) {
            $this->session->set_flashdata('authorize_flag', PERMISSION_ERROR_MSG);
            redirect('admin/home', 'refresh');
        }
    }

    public function index()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $this->data['main_page'] = FORMS . 'themes';
            $settings = get_settings('system_settings', true);
            $this->data['title'] = 'Themes | ' . $settings['app_name'];
            $this->data['meta_description'] = 'Themes  | ' . $settings['app_name'];
            $this->load->view('admin/template', $this->data);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function get_themes()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $this->Setting_model->get_theme_list();
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function set_default_theme()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $this->form_validation->set_rules('theme_id', 'Theme', 'trim|required|xss_clean|numeric');
            if (!$this->form_validation->run()) {
                sendWebJsonResponse(true, strip_tags(validation_errors()));
            }
            $theme_id = $this->input->post('theme_id', true);
            $theme = $this->db->where('id', $theme_id)->get('themes')->row_array();
            if (empty($theme)) {
                $response['test'] = $theme;
                sendWebJsonResponse(true, 'No theme found.', [], $response);
            }

            if ($theme['status'] == 0) {
                sendWebJsonResponse(true, 'You can not set Inactive theme as default.');
            }
            $this->db->trans_start();

            $this->db->set('is_default', 0);
            $this->db->update('themes');

            $this->db->set('is_default', 1);
            $this->db->where('id', $theme_id)->update('themes');

            $this->db->trans_complete();
            $error = true;
            if ($this->db->trans_status() === true) {
                $error = false;
            }

            sendWebJsonResponse($error, 'Default Theme Updated.');
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function switch()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            if (defined('ALLOW_MODIFICATION') && ALLOW_MODIFICATION == 0) {
                sendWebJsonResponse(true, DEMO_VERSION_MSG);
            }

            $this->form_validation->set_rules('id', 'Theme', 'trim|required|xss_clean|numeric');
            $this->form_validation->set_rules('status', 'Status', 'trim|required|xss_clean|numeric|in_list[0,1]');
            if (!$this->form_validation->run()) {
                sendWebJsonResponse(true, strip_tags(validation_errors()));
            }

            $theme_id = $this->input->post('id', true);
            $status = $this->input->post('status', true);
            $theme = $this->db->where('id', $theme_id)->get('themes')->row_array();

            if (empty($theme)) {
                sendWebJsonResponse(true, 'No theme found.');
            }

            $this->db->trans_start();

            if ($status == 1) {
                // Deactivate all other themes
                $this->db->set(['status' => 0, 'is_default' => 0]);
                $this->db->update('themes');

                // Activate selected theme
                $this->db->set(['status' => 1, 'is_default' => 1]);
                $this->db->where('id', $theme_id);
                $this->db->update('themes');
            } else {
                $active_themes_count = $this->db->where('status', 1)->where('id !=', $theme_id)->count_all_results('themes');
                
                if ($active_themes_count == 0) {
                    sendWebJsonResponse(true, 'Cannot deactivate this theme. At least one theme must be active.');
                }
                
                // Just deactivate this theme
                $this->db->set(['status' => 0, 'is_default' => 0]);
                $this->db->where('id', $theme_id);
                $this->db->update('themes');
            }

            $this->db->trans_complete();
            $error = !$this->db->trans_status();

            sendWebJsonResponse($error, $error ? 'Something went wrong.' : 'Theme changed successfully.');
        } else {
            redirect('admin/login', 'refresh');
        }
    }

}