<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['ion_auth', 'form_validation']);
        $this->load->helper(['url', 'language']);
        $this->load->model('affiliate_model');
        $this->lang->load('auth');
    }

    public function index()
    {

        if (!$this->ion_auth->logged_in() && !$this->ion_auth->is_affiliate_user()) {

            $this->data['main_page'] = FORMS . 'login';
            $settings = get_settings('system_settings', true);
            $this->data['title'] = 'affiliate Login Panel | ' . $settings['app_name'];
            $this->data['meta_description'] = 'affiliate Login Panel | ' . $settings['app_name'];
            $this->data['logo'] = get_settings('logo');
            $this->data['app_name'] = $settings['app_name'];
            $identity = $this->config->item('identity', 'ion_auth');
            if (empty($identity)) {
                $identity_column = 'text';
            } else {
                $identity_column = $identity;
            }
            $this->data['identity_column'] = $identity_column;
            $this->load->view('affiliate/login', $this->data);
        } else
            if ($this->ion_auth->logged_in() && $this->ion_auth->is_affiliate_user() && ($this->ion_auth->affiliate_status() == 2 || $this->ion_auth->affiliate_status() == 0)) {
                $this->ion_auth->logout();
                $this->data['main_page'] = FORMS . 'login';
                $settings = get_settings('system_settings', true);
                $this->data['title'] = 'affiliate Login Panel | ' . $settings['app_name'];
                $this->data['meta_description'] = 'affiliate Login Panel | ' . $settings['app_name'];
                $this->data['logo'] = get_settings('logo');
                $this->data['app_name'] = $settings['app_name'];
                $identity = $this->config->item('identity', 'ion_auth');
                if (empty($identity)) {
                    $identity_column = 'text';
                } else {
                    $identity_column = $identity;
                }
                $this->data['identity_column'] = $identity_column;
                $this->load->view('affiliate/login', $this->data);
            } else if ($this->ion_auth->logged_in() && $this->ion_auth->is_affiliate_user() && ($this->ion_auth->affiliate_status() == 1 || $this->ion_auth->affiliate_status() == 0)) {
                redirect('affiliate/home', 'refresh');
            } else if ($this->ion_auth->logged_in() && $this->ion_auth->is_delivery_boy()) {
                redirect('delivery_boy/home', 'refresh');
            } else if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
                redirect('admin/home', 'refresh');
            }
    }

    public function update_user()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_affiliate_user() && ($this->ion_auth->affiliate_status() == 1 || $this->ion_auth->affiliate_status() == 77)) {

            if (defined('ALLOW_MODIFICATION') && ALLOW_MODIFICATION == 0) {
                $this->response['error'] = true;
                $this->response['message'] = DEMO_VERSION_MSG;
                echo json_encode($this->response);
                return false;
                exit();
            }

            $identity_column = $this->config->item('identity', 'ion_auth');
            $identity = $this->session->userdata('identity');
            $user = $this->ion_auth->user()->row();
            $this->form_validation->set_rules('full_name', 'Name', 'trim|required|xss_clean');
            if (!isset($_POST['edit_affiliate_user'])) {
                $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|numeric|xss_clean|min_length[5]|max_length[16]|edit_unique[users.mobile.' . $user->id . ']');
                $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
                $this->form_validation->set_rules('confirm_password', 'Confirm password', 'trim|required|matches[password]|xss_clean');
            }
            $this->form_validation->set_rules('address', 'Address', 'trim|required|xss_clean');
            $this->form_validation->set_rules('my_website', 'Website', 'trim|required|xss_clean');
            $this->form_validation->set_rules('my_app', 'App', 'trim|required|xss_clean');


            if (!$this->form_validation->run()) {

                sendWebJsonResponse(
                    true,
                    validation_errors(),
                    [],
                    []
                );
            } else {


                if (isset($_POST['edit_affiliate_user']) && !empty($_POST['edit_affiliate_user'])) {

                    if (!empty($_POST['old']) || !empty($_POST['new']) || !empty($_POST['new_confirm'])) {
                        if (!$this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'))) {
                            sendWebJsonResponse(
                                true,
                                $this->ion_auth->errors(),
                                [],
                                []
                            );
                            return;
                            exit();
                        }
                    }
                    // process images of profile
                    if (!file_exists(FCPATH . USER_IMG_PATH)) {
                        mkdir(FCPATH . USER_IMG_PATH, 0777);
                    }

                    //process Profile Image
                    $temp_array_profile = $profile_doc = array();
                    $profile_files = $_FILES;
                    $profile_error = "";
                    $config = [
                        'upload_path' => FCPATH . USER_IMG_PATH,
                        'allowed_types' => 'jpg|png|jpeg|gif',
                        'max_size' => 10000,
                    ];
                    if (isset($profile_files['image']) && !empty($profile_files['image']['name']) && isset($profile_files['image']['name'])) {
                        $other_img = $this->upload;
                        $other_img->initialize($config);



                        if (!empty($profile_files['image']['name'])) {

                            $_FILES['temp_image']['name'] = $profile_files['image']['name'];
                            $_FILES['temp_image']['type'] = $profile_files['image']['type'];
                            $_FILES['temp_image']['tmp_name'] = $profile_files['image']['tmp_name'];
                            $_FILES['temp_image']['error'] = $profile_files['image']['error'];
                            $_FILES['temp_image']['size'] = $profile_files['image']['size'];
                            if (!$other_img->do_upload('temp_image')) {
                                $profile_error = 'Images :' . $profile_error . ' ' . $other_img->display_errors();
                            } else {
                                $temp_array_profile = $other_img->data();
                                resize_review_images($temp_array_profile, FCPATH . USER_IMG_PATH);
                                $profile_doc = USER_IMG_PATH . $temp_array_profile['file_name'];
                            }
                        } else {
                            $_FILES['temp_image']['name'] = $profile_files['image']['name'];
                            $_FILES['temp_image']['type'] = $profile_files['image']['type'];
                            $_FILES['temp_image']['tmp_name'] = $profile_files['image']['tmp_name'];
                            $_FILES['temp_image']['error'] = $profile_files['image']['error'];
                            $_FILES['temp_image']['size'] = $profile_files['image']['size'];
                            if (!$other_img->do_upload('temp_image')) {
                                $profile_error = $other_img->display_errors();
                            }
                        }
                        //Deleting Uploaded Images if any overall error occured
                        if ($profile_error != NULL || !$this->form_validation->run()) {
                            if (isset($profile_doc) && !empty($profile_doc || !$this->form_validation->run())) {
                                foreach ($profile_doc as $key => $val) {
                                    unlink(FCPATH . USER_IMG_PATH . $profile_doc[$key]);
                                }
                            }
                        }
                    }

                    if ($profile_error != NULL) {
                        sendWebJsonResponse(
                            true,
                            $profile_error,
                            [],
                            []
                        );
                        return;
                    }


                    $fullname = $this->input->post('full_name', true);

                    $affiliate_data = array(
                        'user_id' => $this->input->post('edit_affiliate_user', true),
                        'edit_affiliate_data_id' => $this->input->post('edit_affiliate_data_id', true),
                        'uuid' => $this->input->post('affiliate_uuid', true),
                        'website_url' => $this->input->post('my_website', true),
                        'mobile_app_url' => $this->input->post('my_app', true),
                        'status' => $this->input->post('status', true),
                        'commission_type' => 'percentage',

                    );
                    $affiliate_profile = array(
                        'username' => $fullname,
                        'email' => $this->input->post('email', true),
                        'mobile' => $this->input->post('mobile', true),
                        'address' => $this->input->post('address', true),
                        'is_affiliate_user' => $this->input->post('is_affiliate_user', true),
                        'image' => (!empty($profile_doc)) ? $profile_doc : $this->input->post('old_profile_image', true)
                    );
                    // print_r($affiliate_profile);
                    // die;

                    if ($this->affiliate_model->add_affiliate($affiliate_data, $affiliate_profile)) {
                        sendWebJsonResponse(
                            false,
                            [],
                            [],
                            ['Affiliate Update Successfully']
                        );
                    } else {
                        sendWebJsonResponse(
                            true,
                            [],
                            [],
                            ['Seller data was not updated']
                        );
                    }
                }
            }
        } else {
            redirect('seller/home', 'refresh');
        }
    }
    public function auth()
    {
        $identity_column = $this->config->item('identity', 'ion_auth');
        $identity = $this->input->post('identity', true);
        $this->form_validation->set_rules('identity', 'Email', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
        $res = $this->db->select('id')->where($identity_column, $identity)->get('users')->result_array();
        if ($this->form_validation->run()) {
            if (!empty($res)) {
                if ($this->ion_auth_model->in_group('seller', $res[0]['id'])) {
                    $remember = (bool) $this->input->post('remember');
                    if ($this->ion_auth->login($this->input->post('identity', true), $this->input->post('password', true), $remember, 'phone')) {
                        //if the login is successful
                        sendWebJsonResponse(
                            false,
                            $this->ion_auth->messages(),
                            [],
                            []
                        );
                    } else {
                        // if the login was un-successful
                        sendWebJsonResponse(
                            true,
                            $this->ion_auth->errors(),
                            [],
                            []
                        );

                    }
                } else {
                    sendWebJsonResponse(
                        true,
                        'You are not authorized to access this portal',
                        [],
                        []
                    );
                  
                }
            } else {
               sendWebJsonResponse(
    true,
    ucfirst($identity_column) . ' field is not correct',
    [],
    []
);

            }
        } else {
          sendWebJsonResponse(
    true,
    validation_errors(),
    [],
    []
);
        }
    }

    public function forgot_password()
    {
        if (defined('ALLOW_MODIFICATION') && ALLOW_MODIFICATION == 0) {
            $this->response['error'] = true;
            $this->response['message'] = DEMO_VERSION_MSG;
            echo json_encode($this->response);
            return false;
            exit();
        }

        $this->data['main_page'] = FORMS . 'forgot-password';
        $settings = get_settings('system_settings', true);
        $this->data['title'] = 'Forgot Password | ' . $settings['app_name'];
        $this->data['meta_description'] = 'Forget Password | ' . $settings['app_name'];
        $this->data['logo'] = get_settings('logo');
        $this->load->view('seller/login', $this->data);
    }
}
