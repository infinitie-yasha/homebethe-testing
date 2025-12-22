<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Custom_notification extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(['url', 'language', 'timezone_helper']);
        $this->load->model(['custom_notification_model']);
    }

    public function index()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $this->data['main_page'] = FORMS . 'custom_notification';
            $settings = get_settings('system_settings', true);
            $this->data['title'] = (isset($_GET['edit_id']) && !empty($_GET['edit_id'])) ? 'Edit Custom Notification | ' . $settings['app_name'] : 'Add Custom Notification | ' . $settings['app_name'];
            $this->data['meta_description'] = 'Add Custom Notification , Create Custom Notification | ' . $settings['app_name'];

            $this->data['notification_modules'] = $this->config->item('notification_modules');
            $this->load->view('admin/template', $this->data);
        } else {
            redirect('admin/login', 'refresh');
        }
    }
    public function add_notification()
    {
        if (isset($_POST['edit_notification'])) {
            if (print_msg(!has_permissions('update', 'custom_notifications'), PERMISSION_ERROR_MSG, 'custom_notifications')) {
                return false;
            }
        } else {
            if (print_msg(!has_permissions('create', 'custom_notifications'), PERMISSION_ERROR_MSG, 'custom_notifications')) {
                return false;
            }
        }

        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $this->form_validation->set_rules('title', 'Title Name', 'required');
            $this->form_validation->set_rules('message', 'Message', 'required');
            $this->form_validation->set_rules('type', 'Type Name', 'required|xss_clean');
            if (!$this->form_validation->run()) {
                sendWebJsonResponse(true, strip_tags(validation_errors()));
            } else {
                $type = $this->input->post('type', true);
                $edit_custom_notification = $this->input->post('edit_custom_notification', true);
                if (isset($edit_custom_notification) && !empty($edit_custom_notification)) {
                    if (is_exist(['type' => $type], 'custom_notifications', $edit_custom_notification)) {
                        sendWebJsonResponse(true, 'Name Already Exist ! Provide a unique type');
                    }
                } else {
                    if (!$this->form_validation->is_unique($type, 'custom_notifications.type')) {
                        sendWebJsonResponse(true, 'Name Already Exist ! Provide a unique type');
                    }
                }
                $fields = [
                    'title',
                    'message',
                    'type',
                    'edit_custom_notification',

                ];
                foreach ($fields as $field) {
                    $custom_notification[$field] = $this->input->post($field, true) ?? "";
                }
                $this->custom_notification_model->add_custom_notification($_POST);

                $message = (isset($edit_custom_notification) && !empty($edit_custom_notification)) ? 'Notification Updated Successfully' : 'custom message  Added Successfully';

                sendWebJsonResponse(false, $message);
            }
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function delete_custom_notification()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            if (print_msg(!has_permissions('delete', 'custom_notifications'), PERMISSION_ERROR_MSG, 'custom_notifications', false)) {
                return false;
            }

            if (delete_details(['id' => $_GET['id']], 'custom_notifications') == TRUE) {
                $this->response['error'] = false;
                $this->response['message'] = 'Custom Message Deleted Succesfully';
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

    public function view_notification()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            return $this->custom_notification_model->get_custom_notifications_data();
        } else {
            redirect('admin/login', 'refresh');
        }
    }
}
