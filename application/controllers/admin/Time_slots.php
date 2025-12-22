<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Time_slots extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(['url', 'language', 'timezone_helper']);
        $this->load->model('Setting_model');
        if (!has_permissions('read', 'time_slots')) {
            $this->session->set_flashdata('authorize_flag', PERMISSION_ERROR_MSG);
            redirect('admin/home', 'refresh');
        }
    }

    public function index()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $this->data['main_page'] = FORMS . 'time-slots';
            $settings = get_settings('system_settings', true);
            $this->data['time_slot_config'] = get_settings('time_slot_config', true);
            $this->data['title'] = 'Time slots | ' . $settings['app_name'];
            $this->data['meta_description'] = 'Time slots | ' . $settings['app_name'];
            if (isset($_GET['edit_id'])) {
                $featured_data = fetch_details('time_slots', ['id' => $_GET['edit_id']]);
                $this->data['fetched_data'] = $featured_data;
            }
            $this->load->view('admin/template', $this->data);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function view_time_slots()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            return $this->Setting_model->get_time_slot_details();
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function delete_time_slots()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            if (print_msg(!has_permissions('delete', 'time_slots'), PERMISSION_ERROR_MSG, 'time_slots')) {
                return false;
            }
            if (delete_details(['id' => $_GET['id']], 'time_slots') == TRUE) {
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

    public function update_time_slots()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            if (print_msg(!has_permissions('update', 'time_slots'), PERMISSION_ERROR_MSG, 'time_slots')) {
                return false;
            }

            $this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
            $this->form_validation->set_rules('from_time', 'From Time', 'trim|required|xss_clean');
            $this->form_validation->set_rules('to_time', 'To TIme', 'trim|required|xss_clean');
            $this->form_validation->set_rules('last_order_time', 'Last Order Time', 'trim|required|xss_clean');
            $this->form_validation->set_rules('status', 'Status', 'trim|required|xss_clean');

            if (!$this->form_validation->run()) {
                sendWebJsonResponse(true, strip_tags(validation_errors()));

            } else {
                $fields = ['edit_time_slot', 'title', 'from_time', 'to_time', 'last_order_time', 'status'];

                foreach ($fields as $field) {
                    $time_slot_settings[$field] = $this->input->post($field, true) ?? "";
                }
                $this->Setting_model->update_time_slot($time_slot_settings);

                $message = (isset($_POST['edit_time_slot']) && !empty($_POST['edit_time_slot'])) ? 'Time slot updated successfully' : 'Time slot added successfully';

                sendWebJsonResponse(false, $message);
            }
        } else {
            redirect('admin/login', 'refresh');
        }
    }
    public function get_time_slot_details()
{
    if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
        $id = $this->input->get('id', true);

        if (empty($id)) {
            echo json_encode(['success' => false, 'message' => 'Missing time slot ID']);
            return;
        }

        $data = fetch_details('time_slots', ['id' => $id], '*');

        if (!empty($data)) {
            echo json_encode([
                'success' => true,
                'data' => $data[0]
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Time slot not found'
            ]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    }
}


    public function update_time_slots_config()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

            if (print_msg(!has_permissions('update', 'time_slots'), PERMISSION_ERROR_MSG, 'time_slots')) {
                return false;
            }
            $this->form_validation->set_rules('time_slot_config', 'Time Slot Config ', 'trim|required|numeric|xss_clean');
            $this->form_validation->set_rules('is_time_slots_enabled', 'Time Slot ', 'trim|xss_clean');
            $this->form_validation->set_rules('delivery_starts_from', 'Delivery Starts From', 'trim|required|numeric|xss_clean');
            $this->form_validation->set_rules('allowed_days', 'Days you want to allow ', 'trim|required|numeric|xss_clean');

            if (!$this->form_validation->run()) {

                sendWebJsonResponse(true, strip_tags(validation_errors()));
            } else {
                $fields = ['time_slot_config', 'is_time_slots_enabled', 'delivery_starts_from', 'allowed_days'];

                foreach ($fields as $field) {
                    $settings[$field] = $this->input->post($field, true) ?? "";
                }
                $this->Setting_model->update_time_slot_config($settings);

                sendWebJsonResponse(false, 'Time Slot Config Updated Successfully');
            }
        } else {
            redirect('admin/login', 'refresh');
        }
    }
}
