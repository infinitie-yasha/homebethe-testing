<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Support_tickets extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['ion_auth', 'form_validation', 'upload']);
        $this->load->helper(['url', 'language', 'file']);
        $this->load->model(['Category_model', 'ticket_model']);
    }

    public function index()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_seller() && ($this->ion_auth->seller_status() == 1 || $this->ion_auth->seller_status() == 0)) {
            $this->data['main_page'] = TABLES . 'manage-tickets';
            $settings = get_settings('system_settings', true);
            $this->data['title'] = 'Support Tickets | ' . $settings['app_name'];
            $this->data['meta_description'] = 'Support Tickets | ' . $settings['app_name'];

            $ticket_type = $this->db->where(['for' => 'seller'])->get('ticket_types')->result_array();
            $this->data['ticket_type'] = $ticket_type;


            $this->load->view('seller/template', $this->data);
        } else {
            redirect('seller/login', 'refresh');
        }
    }

    public function create_ticket()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_seller() && ($this->ion_auth->seller_status() == 1 || $this->ion_auth->seller_status() == 0)) {
            $this->form_validation->set_rules('ticket_type', 'Ticket Type', 'trim|required|xss_clean');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
            $this->form_validation->set_rules('subject', 'Subject', 'trim|required|xss_clean');
            $this->form_validation->set_rules('description', 'Description', 'trim|required|xss_clean');

            if (!$this->form_validation->run()) {
                $this->response['error'] = true;
                $this->response['csrfName'] = $this->security->get_csrf_token_name();
                $this->response['csrfHash'] = $this->security->get_csrf_hash();
                $this->response['message'] = strip_tags(validation_errors());
                print_r(json_encode($this->response));
            } else {

                $seller_ticket_id = $this->input->post('seller_ticket_id', true);

                $ticket_type_id = $this->input->post('ticket_type', true);
                $user_id = $this->session->userdata('user_id');
                $subject = $this->input->post('subject', true);
                $email = $this->input->post('email', true);
                $description = $this->input->post('description', true);
                $user = fetch_users($user_id);
                if (empty($user)) {
                    sendWebJsonResponse(true, 'User not found!');
                }
                $data = array(
                    'ticket_type_id' => $ticket_type_id,
                    'user_id' => $user_id,
                    'subject' => $subject,
                    'email' => $email,
                    'description' => $description,
                    'status' => PENDING,
                );

                if (isset($seller_ticket_id) && !empty($seller_ticket_id)) {

                    $ticket = $this->db->where('id', $seller_ticket_id)->get('tickets')->row_array();

                    if (empty($ticket)) {
                        sendWebJsonResponse(true, 'Ticket not found');
                    }

                    if ($ticket['status'] == "") {
                        sendWebJsonResponse(true, 'Ticket not found');
                    }

                    $this->db->where(['id' => $seller_ticket_id])->update('tickets', $data);

                    sendWebJsonResponse(false, 'Ticket updated successfully');
                } else {
                    $insert_id = $this->ticket_model->add_ticket($data);
                    if (!empty($insert_id)) {
                        $result = $this->ticket_model->get_tickets($insert_id, $ticket_type_id, $user_id);
                        sendWebJsonResponse(false, 'Ticket Created Successfully');
                    } else {
                        sendWebJsonResponse(true, 'Ticket Not Added');
                    }
                }

            }

        } else {
            sendWebJsonResponse(true, "Please login !");
        }
    }

    public function get_seller_tickets()
    {

        if ($this->ion_auth->logged_in() && $this->ion_auth->is_seller() && ($this->ion_auth->seller_status() == 1 || $this->ion_auth->seller_status() == 0)) {

            $user_id = $this->session->userdata('user_id');



            $user = fetch_users($user_id);
            if (empty($user)) {
                $this->response['error'] = true;
                $this->response['message'] = "User not found!";
                $this->response['data'] = [];
                print_r(json_encode($this->response));
                return false;
            }

            $search = $_GET['search'] ?? '';

            $tickets = $this->ticket_model->get_user_ticket_list($user_id, $search);
            exit;


        } else {
            sendWebJsonResponse(true, "Please login !");
        }

    }

    public function delete_ticket()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_seller() && ($this->ion_auth->seller_status() == 1 || $this->ion_auth->seller_status() == 0)) {

            $user_id = $this->session->userdata('user_id');
            $user = fetch_users($user_id);
            if (empty($user)) {
                $this->response['error'] = true;
                $this->response['message'] = "User not found!";
                $this->response['data'] = [];
                print_r(json_encode($this->response));
                return false;
            }

            $id = $_GET['id'] ?? '';

            if (empty($id)) {
                $this->response['error'] = true;
                $this->response['message'] = "Id is required";
                $this->response['data'] = [];
                print_r(json_encode($this->response));
                return false;
            }

            $ticket = $this->db->where([
                'id' => $id,
                'user_id' => $user_id
            ])->get('tickets')->row_array();

            if (empty($ticket)) {
                $this->response['error'] = true;
                $this->response['message'] = "Tickets not found !";
                $this->response['data'] = [];
                print_r(json_encode($this->response));
                return false;
            }

            $this->db->where([
                'id' => $id,
                'user_id' => $user_id
            ])->delete();

            $this->response['error'] = false;
            $this->response['message'] = "Tickets deleted successfully ";
            $this->response['data'] = [];
            print_r(json_encode($this->response));
            exit;


        } else {
            sendWebJsonResponse(true, "Please login !");
        }
    }
}
