<?php
defined('BASEPATH') or exit('No direct script access allowed');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Orders extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['razorpay', 'paystack', 'flutterwave', 'midtrans']);
        $this->load->helper(['url', 'language', 'timezone_helper']);
        $this->load->model(['Order_model', 'Transaction_model']);

        $this->data['firebase_project_id'] = get_settings('firebase_project_id');
        $this->data['service_account_file'] = get_settings('service_account_file');

        if (!has_permissions('read', 'orders')) {
            $this->session->set_flashdata('authorize_flag', PERMISSION_ERROR_MSG);
            redirect('admin/home', 'refresh');
        } else {
            $this->session->set_flashdata('authorize_flag', "");
        }
    }

    public function index()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $this->data['main_page'] = TABLES . 'manage-orders';
            $settings = get_settings('system_settings', true);
            $this->data['title'] = 'Manage Orders | ' . $settings['app_name'];
            $this->data['meta_description'] = ' Manage Orders  | ' . $settings['app_name'];
            $this->data['about_us'] = get_settings('about_us');
            $this->data['curreny'] = get_settings('currency');
            $orders_count['awaiting'] = orders_count("awaiting");
            $orders_count['received'] = orders_count("received");
            $orders_count['processed'] = orders_count("processed");
            $orders_count['shipped'] = orders_count("shipped");
            $orders_count['delivered'] = orders_count("delivered");
            $orders_count['cancelled'] = orders_count("cancelled");
            $orders_count['returned'] = orders_count("returned");
            $orders_count['draft'] = orders_count("draft");
            $orders_count['return_pickup'] = orders_count("return_pickup");
            $orders_count['return_request_approved'] = orders_count("return_request_approved");
            $orders_count['return_request_pending'] = orders_count("return_request_pending");
            $this->data['status_counts'] = $orders_count;

            if (isset($_GET['edit_id'])) {
                $order_item_data = fetch_details('order_items', ['id' => $_GET['edit_id']], 'order_id,product_name,user_id');
                $order_data = fetch_details('orders', ['id' => $order_item_data[0]['order_id']], 'email');
                $user_data = fetch_details('users', ['id' => $order_item_data[0]['user_id']], 'username');
                $this->data['fetched'] = $order_data;
                $this->data['order_item_data'] = $order_item_data;
                $this->data['user_data'] = $user_data[0];
            }
            $this->load->view('admin/template', $this->data);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function view_orders()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            // print_r($_GET);
            $order = isset($_GET['order']) && !empty($_GET['order']) ? $_GET['order'] : '';
            $sort = isset($_GET['sort']) && !empty($_GET['sort']) ? $_GET['sort'] : '';
            $limit = isset($_GET['limit']) && !empty($_GET['limit']) ? $_GET['limit'] : 10;
            $offset = isset($_GET['offset']) && !empty($_GET['offset']) ? $_GET['offset'] : '';
            return $this->Order_model->get_orders_list(NULL, $offset, $limit, $sort, $order);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function view_order_items()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            return $this->Order_model->get_order_items_list();
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function consignment_view()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $order_id = $this->input->get('order_id', true);

            return $this->Order_model->consignment_view($order_id);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    function delete_consignment()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $this->form_validation->set_rules('id', 'ID', 'trim|required|xss_clean');
            if (!$this->form_validation->run()) {
                sendWebJsonResponse(true, strip_tags(validation_Errors()));
            } else {
                $consignment_id = $this->input->post('id', true);
                $res = delete_consignment($consignment_id);
                if ($res['error'] == false) {
                    sendWebJsonResponse($res['error'], $res['message'], [], $res['data']);
                }
                sendWebJsonResponse($res['error'], $res['message']);
            }
        } else {
            redirect('seller/login', 'refresh');
        }
    }

    public function get_digital_order_mails()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            return $this->Order_model->get_digital_order_mail_list();
        } else {
            redirect('admin/login', 'refresh');
        }
    }
    public function send_digital_product()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $this->form_validation->set_rules('message', 'Message', 'trim|required|xss_clean');
            $this->form_validation->set_rules('subject', 'Subject', 'trim|required|xss_clean');
            $this->form_validation->set_rules('pro_input_file', 'Attachment file', 'trim|required|xss_clean');

            if (!$this->form_validation->run()) {
                sendWebJsonResponse(true, strip_tags(validation_errors()));
            }

            $mail = $this->Order_model->send_digital_product($_POST);

            if ($mail['error'] == true) {
                $this->response['error'] = true;
                $this->response['message'] = "Cannot send mail. You can try to send mail manually.";
                $this->response['data'] = $mail['message'];
                echo json_encode($this->response);
                return false;
            } else {
                sendWebJsonResponse(false, 'Mail Sent Successfully.');
                update_details(['active_status' => 'delivered'], ['id' => $_POST['order_item_id']], 'order_items');
                update_details(['is_sent' => 1], ['id' => $_POST['order_item_id']], 'order_items');
                $data = array(
                    'order_id' => $_POST['order_id'],
                    'order_item_id' => $_POST['order_item_id'],
                    'subject' => $_POST['subject'],
                    'message' => $_POST['message'],
                    'file_url' => $_POST['pro_input_file'],
                );
                insert_details($data, 'digital_orders_mails');
                return false;
            }
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function delete_orders()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            if (print_msg(!has_permissions('delete', 'orders'), PERMISSION_ERROR_MSG, 'orders')) {
                return false;
            }
            if (defined('SEMI_DEMO_MODE') && SEMI_DEMO_MODE == 0) {
                sendWebJsonResponse(true, SEMI_DEMO_MODE_MSG);
            }
            $delete = array(
                "order_items" => 0,
                "orders" => 0,
                "order_bank_transfer" => 0
            );
            $orders = $this->db->where(' oi.order_id=' . $_GET['id'])->join('orders o', 'o.id=oi.order_id', 'right')->get('order_items oi')->result_array();
            if (!empty($orders)) {
                // delete orders
                if (delete_details(['order_id' => $_GET['id']], 'order_items')) {
                    $delete['order_items'] = 1;
                }
                if (delete_details(['id' => $_GET['id']], 'orders')) {
                    $delete['orders'] = 1;
                }
                if (delete_details(['order_id' => $_GET['id']], 'order_bank_transfer')) {
                    $delete['order_bank_transfer'] = 1;
                }
            }
            $deleted = FALSE;
            if (!in_array(0, $delete)) {
                $deleted = TRUE;
            }
            if ($deleted == TRUE) {
                $response['error'] = false;
                $response['message'] = 'Deleted Successfully';
                $response['permission'] = !has_permissions('delete', 'orders');
            } else {
                $response['error'] = true;
                $response['message'] = 'Something went wrong';
            }
            echo json_encode($response);
        } else {
            redirect('admin/login', 'refresh');
        }
    }
    public function delete_order_items()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            if (print_msg(!has_permissions('delete', 'orders'), PERMISSION_ERROR_MSG, 'orders')) {
                return false;
            }
            $delete = array(
                "order_items" => 0,
                "orders" => 0,
                "order_bank_transfer" => 0
            );
            /* check order items */
            $order_items = fetch_details('order_items', ['id' => $_GET['id']], 'id,order_id');
            if (delete_details(['id' => $_GET['id']], 'order_items')) {
                $delete['order_items'] = 1;
            }
            $res_order_id = array_values(array_unique(array_column($order_items, "order_id")));
            for ($i = 0; $i < count($res_order_id); $i++) {
                $orders = $this->db->where(' oi.order_id=' . $res_order_id[$i])->join('orders o', 'o.id=oi.order_id', 'right')->get('order_items oi')->result_array();
                if (empty($orders)) {
                    // delete orders
                    if (delete_details(['id' => $res_order_id[$i]], 'orders')) {
                        $delete['orders'] = 1;
                    }
                    if (delete_details(['order_id' => $res_order_id[$i]], 'order_bank_transfer')) {
                        $delete['order_bank_transfer'] = 1;
                    }
                }
            }

            if ($delete['order_items'] == TRUE) {
                $response['error'] = false;
                $response['message'] = 'Deleted Successfully';
                $response['permission'] = !has_permissions('delete', 'orders');
            } else {
                $response['error'] = true;
                $response['message'] = 'Something went wrong';
            }
            echo json_encode($response);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    /* Update complete order status */
    public function update_orders()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            if (print_msg(!has_permissions('update', 'orders'), PERMISSION_ERROR_MSG, 'orders')) {
                return false;
            }
            $msg = '';
            $order_method = fetch_details('orders', ['id' => $_POST['orderid']], 'payment_method');
            $firebase_project_id = $this->data['firebase_project_id'];
            $service_account_file = $this->data['service_account_file'];

            if ($order_method[0]['payment_method'] == 'bank_transfer') {
                $bank_receipt = fetch_details('order_bank_transfer', ['order_id' => $_POST['orderid']]);
                $transaction_status = fetch_details('transactions', ['order_id' => $_POST['orderid']], 'status');
                if (empty($bank_receipt) || strtolower($transaction_status[0]['status']) != 'success') {
                    sendWebJsonResponse(true, 'Order Status can not update, Bank verification is remain from transactions.');
                }
            }
            if (isset($_POST['deliver_by']) && !empty($_POST['deliver_by']) && isset($_POST['orderid']) && !empty($_POST['orderid'])) {
                $where = "id = " . $_POST['orderid'] . "";
                $current_delivery_boy = fetch_details('orders', $where, 'delivery_boy_id');
                $settings = get_settings('system_settings', true);
                $app_name = isset($settings['app_name']) && !empty($settings['app_name']) ? $settings['app_name'] : '';
                $user_res = fetch_details('users', ['id' => $_POST['deliver_by']], 'fcm_id,username,mobile,email,platform_type');
                $user_fcm_ids = fetch_details("user_fcm", ['user_id' => $_POST['deliver_by']], 'fcm_id,platform_type');
                $fcm_ids = array();
                //custom message
                if (isset($user_fcm_ids[0]) && !empty($user_fcm_ids[0])) {
                    if ((isset($current_delivery_boy[0]['delivery_boy_id']) && $current_delivery_boy[0]['delivery_boy_id'] == $_POST['deliver_by']) || (isset($_POST['status']) && $_POST['status'] == 'cancelled')) {
                        if ($_POST['status'] == 'received') {
                            $type = ['type' => "customer_order_received"];
                        } elseif ($_POST['status'] == 'processed') {
                            $type = ['type' => "customer_order_processed"];
                        } elseif ($_POST['status'] == 'shipped') {
                            $type = ['type' => "customer_order_shipped"];
                        } elseif ($_POST['status'] == 'delivered') {
                            $type = ['type' => "customer_order_delivered"];
                        } elseif ($_POST['status'] == 'cancelled') {
                            $type = ['type' => "customer_order_cancelled"];
                        } elseif ($_POST['status'] == 'returned') {
                            $type = ['type' => "customer_order_returned"];
                        }
                        $custom_notification = fetch_details('custom_notifications', $type, '');
                        $hashtag_cutomer_name = '< cutomer_name >';
                        $hashtag_order_id = '< order_item_id >';
                        $hashtag_application_name = '< application_name >';
                        $string = json_encode($custom_notification[0]['message'], JSON_UNESCAPED_UNICODE);
                        $hashtag = html_entity_decode($string);
                        $data = str_replace(array($hashtag_cutomer_name, $hashtag_order_id, $hashtag_application_name), array($user_res[0]['username'], $_POST['orderid'], $app_name), $hashtag);
                        $message = output_escaping(trim($data, '"'));
                        $customer_msg = (!empty($custom_notification)) ? $message : 'Hello Dear ' . $user_res[0]['username'] . ' Order status updated to' . $_POST['val'] . ' for order ID #' . $_POST['orderid'] . ' please take note of it! Thank you. Regards ' . $app_name . '';
                        $fcmMsg = array(
                            'title' => (!empty($custom_notification)) ? $custom_notification[0]['title'] : "Order status updated",
                            'body' => $customer_msg,
                            'type' => "order",
                        );
                        notify_event(
                            $type['type'],
                            ["delivery_boy" => [$user_res[0]['email']]],
                            ["delivery_boy" => [$user_res[0]['mobile']]],
                            ["orders.id" => $_POST['order_id']]
                        );
                    } else {
                        $custom_notification = fetch_details('custom_notifications', ['type' => "delivery_boy_order_deliver"], '');
                        $hashtag_cutomer_name = '< cutomer_name >';
                        $hashtag_order_id = '< order_id >';
                        $hashtag_application_name = '< application_name >';
                        $string = json_encode($custom_notification[0]['message'], JSON_UNESCAPED_UNICODE);
                        $hashtag = html_entity_decode($string);
                        $data = str_replace(array($hashtag_cutomer_name, $hashtag_order_id, $hashtag_application_name), array($user_res[0]['username'], $_POST['orderid'], $app_name), $hashtag);
                        $message = output_escaping(trim($data, '"'));
                        $customer_msg = (!empty($custom_notification)) ? $message : 'Hello Dear ' . $user_res[0]['username'] . ' you have new order to be deliver order ID #' . $_POST['orderid'] . ' please take note of it! Thank you. Regards ' . $app_name . '';
                        $fcmMsg = array(
                            'title' => (!empty($custom_notification)) ? $custom_notification[0]['title'] : " You have new order to deliver",
                            'body' => $customer_msg,
                            'type' => "order",
                        );
                        $msg = 'Delivery Boy Updated. ';
                        notify_event(
                            "delivery_boy_order_deliver",
                            ["delivery_boy" => [$user_res[0]['email']]],
                            ["delivery_boy" => [$user_res[0]['mobile']]],
                            ["orders.id" => $_POST['order_id']]
                        );
                    }
                }
                if (!empty($user_fcm_ids[0]['fcm_id'])) {
                    // Step 1: Group by platform
                    $groupedByPlatform = [];
                    foreach ($user_fcm_ids as $item) {
                        $platform = $item['platform_type'];
                        $groupedByPlatform[$platform][] = $item['fcm_id'];
                    }

                    // Step 2: Chunk each platform group into arrays of 1000
                    $fcm_ids = [];
                    foreach ($groupedByPlatform as $platform => $fcmIds) {
                        $fcm_ids[$platform] = array_chunk($fcmIds, 1000);
                    }

                    $fcm_ids = $fcm_ids;
                    if (isset($firebase_project_id) && isset($service_account_file) && !empty($firebase_project_id) && !empty($service_account_file)) {
                        send_notification($fcmMsg, $fcm_ids, $fcmMsg);
                    }
                }
                $where = [
                    'id' => $_POST['orderid']
                ];


                if ($this->Order_model->update_order(['delivery_boy_id' => $_POST['deliver_by']], $where)) {
                    $delivery_error = false;
                }
            }

            $res = validate_order_status($_POST['orderid'], $_POST['val'], 'orders');
            if ($res['error']) {
                sendWebJsonResponse(true, $msg . $res['message']);
            }

            $priority_status = [
                'received' => 0,
                'processed' => 1,
                'shipped' => 2,
                'delivered' => 3,
                'cancelled' => 4,
                'returned' => 5,
            ];

            $update_status = 1;
            $error = TRUE;
            $message = '';

            $where_id = "id = " . $_POST['orderid'] . " and (active_status != 'cancelled' and active_status != 'returned' ) ";
            $where_order_id = "order_id = " . $_POST['orderid'] . " and (active_status != 'cancelled' and active_status != 'returned' ) ";

            $order_items_details = fetch_details('order_items', $where_order_id, 'active_status');
            $counter = count($order_items_details);
            $cancel_counter = 0;
            foreach ($order_items_details as $row) {
                if ($row['active_status'] == 'cancelled') {
                    ++$cancel_counter;
                }
            }
            if ($cancel_counter == $counter) {
                $update_status = 0;
            }

            if (isset($_POST['orderid']) && isset($_POST['field']) && isset($_POST['val'])) {
                if ($_POST['field'] == 'status' && $update_status == 1) {

                    $current_orders_status = fetch_details('orders', $where_id, 'user_id,active_status');
                    $user_id = $current_orders_status[0]['user_id'];
                    $current_orders_status = $current_orders_status[0]['active_status'];

                    if ($priority_status[$_POST['val']] > $priority_status[$current_orders_status]) {
                        $set = [
                            $_POST['field'] => $_POST['val'] // status => 'proceesed'
                        ];

                        // Update Active Status of Order Table
                        if ($this->Order_model->update_order($set, $where_id, $_POST['json'])) {
                            if ($this->Order_model->update_order(['active_status' => $_POST['val']], $where_id)) {
                                if ($this->Order_model->update_order($set, $where_order_id, $_POST['json'], 'order_items')) {
                                    if ($this->Order_model->update_order(['active_status' => $_POST['val']], $where_order_id, false, 'order_items')) {
                                        $error = false;
                                    }
                                }
                            }
                        }

                        if ($error == false) {
                            //custom message
                            $settings = get_settings('system_settings', true);
                            $app_name = isset($settings['app_name']) && !empty($settings['app_name']) ? $settings['app_name'] : '';
                            if ($_POST['status'] == 'received') {
                                $type = ['type' => "customer_order_received"];
                            } elseif ($_POST['status'] == 'processed') {
                                $type = ['type' => "customer_order_processed"];
                            } elseif ($_POST['status'] == 'shipped') {
                                $type = ['type' => "customer_order_shipped"];
                                $d_type = ['type' => "delivery_boy_order_processed"];
                            } elseif ($_POST['status'] == 'delivered') {
                                $type = ['type' => "customer_order_delivered"];
                            } elseif ($_POST['status'] == 'cancelled') {
                                $type = ['type' => "customer_order_cancelled"];
                            } elseif ($_POST['status'] == 'returned') {
                                $type = ['type' => "customer_order_returned"];
                            }
                            $custom_notification = fetch_details('custom_notifications', $type, '');
                            $custom_d_boy_notification = fetch_details('custom_notifications', $d_type, '');

                            $hashtag_cutomer_name = '< cutomer_name >';
                            $hashtag_order_id = '< order_item_id >';
                            $hashtag_application_name = '< application_name >';
                            $string = json_encode($custom_notification[0]['message'], JSON_UNESCAPED_UNICODE);
                            $hashtag = html_entity_decode($string);
                            $data = str_replace(array($hashtag_cutomer_name, $hashtag_order_id, $hashtag_application_name), array($user_res[0]['username'], $_POST['orderid'], $app_name), $hashtag);
                            $message = output_escaping(trim($data, '"'));
                            $customer_msg = (!empty($custom_notification)) ? $message : 'Hello Dear ' . $user_res[0]['username'] . ' Order status updated to' . $_POST['val'] . ' for order ID #' . $_POST['orderid'] . ' please take note of it! Thank you. Regards ' . $app_name . '';
                            $user_res = fetch_details('users', ['id' => $user_id], 'username,fcm_id,mobile,email');
                            $user_fcm = fetch_details('user_fcm', ['user_id' => $user_id], 'fcm_id,platform_type');
                            $fcm_ids = array();

                            if (!empty($user_fcm[0]['fcm_id'])) {
                                $fcmMsg = array(
                                    'title' => (!empty($custom_notification)) ? $custom_notification[0]['title'] : " Order status updated",
                                    'body' => $customer_msg,
                                    'type' => "order"
                                );

                                // Step 1: Group by platform
                                $groupedByPlatform = [];
                                foreach ($user_fcm as $item) {
                                    $platform = $item['platform_type'];
                                    $groupedByPlatform[$platform][] = $item['fcm_id'];
                                }

                                // Step 2: Chunk each platform group into arrays of 1000
                                $fcm_ids = [];
                                foreach ($groupedByPlatform as $platform => $fcmIds) {
                                    $fcm_ids[$platform] = array_chunk($fcmIds, 1000);
                                }

                                $fcm_ids = $fcm_ids;

                                if (isset($firebase_project_id) && isset($service_account_file) && !empty($firebase_project_id) && !empty($service_account_file)) {
                                    send_notification($fcmMsg, $fcm_ids, $fcmMsg);
                                }
                            }
                            notify_event(
                                $type['type'],
                                ["customer" => [$user_res[0]['email']]],
                                ["customer" => [$user_res[0]['mobile']]],
                                ["orders.id" => $_POST['order_id']]
                            );
                            /* Process refer and earn bonus */
                            process_refund($_POST['orderid'], $_POST['val'], 'orders');
                            if (trim($_POST['val'] == 'cancelled')) {
                                $data = fetch_details('order_items', ['order_id' => $_POST['orderid']], 'product_variant_id,quantity');
                                $product_variant_ids = [];
                                $qtns = [];
                                foreach ($data as $d) {
                                    array_push($product_variant_ids, $d['product_variant_id']);
                                    array_push($qtns, $d['quantity']);
                                }

                                update_stock($product_variant_ids, $qtns, 'plus');
                            }
                            $message = 'Status Updated Successfully';
                            update_details(['updated_by' => $_SESSION['user_id']], ['order_id' => $_POST['orderid']], 'order_items');
                        }
                    }
                }
                if ($error == true) {
                    $message = $msg . ' Status Updation Failed';
                }
            }

            $response['total_amount'] = (!empty($data) ? $data : '');
            sendWebJsonResponse($error, $message, [], $response);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function edit_orders()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

            if (!has_permissions('read', 'orders')) {
                $this->session->set_flashdata('authorize_flag', PERMISSION_ERROR_MSG);
                redirect('admin/home', 'refresh');
            }
            $bank_transfer = array();
            $this->data['main_page'] = FORMS . 'edit-orders';
            $settings = get_settings('system_settings', true);

            $this->data['title'] = 'View Order | ' . $settings['app_name'];
            $this->data['meta_description'] = 'View Order | ' . $settings['app_name'];
            $res = $this->Order_model->get_order_details(['o.id' => $_GET['edit_id']]);
            if (is_exist(['id' => $res[0]['address_id']], 'addresses')) {
                $area_id = fetch_details('addresses', ['id' => $res[0]['address_id']], 'area_id');

                if (!empty($area_id) && $area_id[0]['area_id'] != 0) {
                    $zipcode_id = fetch_details('areas', ['id' => $area_id[0]['area_id']], 'zipcode_id');

                    if (!empty($zipcode_id)) {
                        $this->data['delivery_res'] = $this->db->where(['ug.group_id' => '3', 'u.active' => 1, 'u.status' => 1])->where('find_in_set(' . $zipcode_id[0]['zipcode_id'] . ', u.serviceable_zipcodes)!=', 0)->join('users_groups ug', 'ug.user_id = u.id')->get('users u')->result_array();
                    } else {
                        $this->data['delivery_res'] = $this->db->where(['ug.group_id' => '3', 'u.active' => 1, 'u.status' => 1])->join('users_groups ug', 'ug.user_id = u.id')->get('users u')->result_array();
                    }
                } else {
                    $this->data['delivery_res'] = $this->db->where(['ug.group_id' => '3', 'u.active' => 1, 'u.status' => 1])->join('users_groups ug', 'ug.user_id = u.id', 'left')->get('users u')->result_array();
                }
            } else {
                $this->data['delivery_res'] = $this->db->where(['ug.group_id' => '3', 'u.active' => 1, 'u.status' => 1])->join('users_groups ug', 'ug.user_id = u.id')->get('users u')->result_array();
            }


            if ($res[0]['payment_method'] == "bank_transfer") {
                $bank_transfer = fetch_details('order_bank_transfer', ['order_id' => $res[0]['order_id']]);
                $transaction_search_res = fetch_details('transactions', ['order_id' => $res[0]['order_id']]);
            }
            if (isset($_GET['edit_id']) && !empty($_GET['edit_id']) && is_numeric($_GET['edit_id']) && !empty($res)) {
                // check for notification param
                if (isset($_GET['noti_id']) && !empty($_GET['noti_id']) && is_numeric($_GET['noti_id'])) {
                    update_details(['read_by' => '1'], ['id' => $_GET['noti_id']], 'system_notification');
                }
                $items = [];
                foreach ($res as $row) {
                    $multipleWhere = ['seller_id' => $row['seller_id'], 'order_id' => $row['id']];
                    $order_charge_data = $this->db->where($multipleWhere)->get('order_charges')->result_array();

                    $updated_username = fetch_details('users', 'id =' . $row['updated_by'], 'username');
                    $address_number = fetch_details('addresses', 'id =' . $row['address_id'], 'mobile');
                    $deliver_by = fetch_details('users', 'id =' . $row['delivery_boy_id'], 'username');
                    $temp['id'] = $row['order_item_id'];
                    $temp['item_otp'] = $row['item_otp'];
                    $temp['tracking_id'] = $row['tracking_id'];
                    $temp['courier_agency'] = $row['courier_agency'];
                    $temp['url'] = $row['url'];
                    $temp['product_id'] = $row['product_id'];
                    $temp['product_variant_id'] = $row['product_variant_id'];
                    $temp['product_type'] = $row['type'];
                    $temp['pname'] = $row['product_name'];
                    $temp['quantity'] = $row['quantity'];
                    $temp['is_cancelable'] = $row['is_cancelable'];
                    $temp['is_returnable'] = $row['is_returnable'];
                    $temp['tax_amount'] = $row['tax_amount'];
                    $temp['discounted_price'] = $row['discounted_price'];
                    $temp['price'] = $row['price'];
                    $temp['row_price'] = $row['row_price'];
                    $temp['updated_by'] = $updated_username[0]['username'];
                    $temp['deliver_by'] = $deliver_by[0]['username'];
                    $temp['active_status'] = $row['oi_active_status'];
                    $temp['product_image'] = $row['product_image'];
                    $temp['product_variants'] = get_variants_values_by_id($row['product_variant_id']);
                    $temp['product_type'] = $row['type'];
                    $temp['product_id'] = $row['product_id'];
                    $temp['pickup_location'] = $row['pickup_location'];
                    $temp['seller_otp'] = $order_charge_data[0]['otp'];
                    $temp['is_sent'] = $row['is_sent'];
                    $temp['seller_id'] = $row['order_seller_id'];
                    $temp['download_allowed'] = $row['download_allowed'];
                    $temp['user_email'] = $row['user_email'];
                    $temp['product_slug'] = $row['product_slug'];
                    $temp['attachment'] = $row['attachment'];
                    $temp['sku'] = isset($row['product_sku']) && !empty($row['product_sku']) ? $row['product_sku'] : $row['sku'];
                    $temp['address_number'] = $address_number[0]['mobile'];
                    $temp['county_code'] = $row[0]['county_code'];
                    array_push($items, $temp);
                }
                $this->data['order_detls'] = $res;
                $this->data['bank_transfer'] = $bank_transfer;
                $this->data['transaction_search_res'] = $transaction_search_res;
                $this->data['order_tracking'] = fetch_details('order_tracking', ['order_id' => $_GET['edit_id']]);
                $this->data['items'] = $items;
                $this->data['settings'] = get_settings('system_settings', true);
                $this->data['shipping_method'] = get_settings('shipping_method', true);
                $this->data['pickup_locations'] = fetch_details('pickup_locations', ['status' => 1], 'id,name,pickup_location');

                if (isset($res[0]['seller_id']) && !empty($res[0]['seller_id'])) {
                    $seller_data = fetch_details('users', ['id' => $res[0]['seller_id']], 'id,username,email,mobile');
                    $seller_store_data = fetch_details('seller_data', ['id' => $res[0]['seller_id']], 'store_name,logo');
                    if (!empty($seller_data) && !empty($seller_store_data)) {
                        $seller_data[0] = array_merge($seller_data[0], $seller_store_data[0]);
                    }
                    $this->data['seller_data'] = !empty($seller_data) ? $seller_data[0] : null;
                } else {
                    $this->data['seller_data'] = null;
                }

                $this->load->view('admin/template', $this->data);
            } else {
                redirect('admin/orders/', 'refresh');
            }
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    /* Update individual order item status */
    public function update_order_status()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $consignment_order_id = fetch_details('consignments', ['id' => $this->input->post('consignment_id')], 'order_id');
            $data_get = fetch_details('order_items', ['order_id' => $consignment_order_id[0]['order_id']], 'seller_id');
            $seller_id = $data_get[0]['seller_id'];
            if (isset($_POST['type']) && $_POST['type'] == "digital") {
                $this->form_validation->set_rules('order_id', 'Order Id', 'trim|required|xss_clean');
                $this->form_validation->set_rules('status', 'Status', 'trim|required|xss_clean');
                if (!$this->form_validation->run()) {
                    sendWebJsonResponse(true, strip_tags(validation_errors()));
                } else {
                    $order_id = $this->input->post('order_id', true);
                    $status = $this->input->post('status', true);
                    $order_details = fetch_orders(order_id: $order_id, seller_id: $seller_id);
                    if (empty($order_details['order_data'])) {
                        sendWebJsonResponse(true, 'Order Not Found.');
                    }
                    $order_details = $order_details['order_data'];
                    $user_id = $order_details['user_id'];
                    $awaitingPresent = false;
                    foreach ($order_details[0]['order_items'] as $item) {
                        if ($item['active_status'] === 'awaiting') {
                            $awaitingPresent = true;
                            break;
                        }
                        if ($status != 'received' && $status != 'delivered') {
                            sendWebJsonResponse(true, 'Invalid Status Pass');
                        }
                        if ($item['active_status'] == $status) {
                            sendWebJsonResponse(true, 'One Of This Product Already Marked As ' . $status . '.');
                        }
                        if ($item['active_status'] == 'delivered' && $status != 'delivered') {
                            sendWebJsonResponse(true, 'Order Item is Delivered. You Can\'t Change It Again To ' . $status . '.');
                        }
                    }

                    if ($awaitingPresent) {
                        sendWebJsonResponse(true, 'You Can Not Change Status Of Awaiting Order ! please confirm the order first.');
                    } else {
                        if ($order_details[0]['payment_method'] == 'Bank Transfer') {
                            $bank_receipt = fetch_details('order_bank_transfer', ['order_id' => $order_id]);
                            $transaction_status = fetch_details('transactions', ['order_id' => $order_id], 'status');

                            if (empty($bank_receipt) || strtolower($transaction_status[0]['status']) != 'success' || $bank_receipt[0]['status'] == "0" || $bank_receipt[0]['status'] == "1") {
                                sendWebJsonResponse(true, 'Order item status can not update, Bank verification is remain from transactions for this order.');
                            }
                        }
                        foreach ($order_details[0]['order_items'] as $item) {
                            if ($this->Order_model->update_order(['status' => $status], ['id' => $item['id']], true, 'order_items', is_digital_product: 1)) {
                                $this->Order_model->update_order(['active_status' => $status], ['id' => $item['id']], false, 'order_items', is_digital_product: 1);
                                //Update login id in order_item table
                                update_details(['updated_by' => $_SESSION['user_id']], ['order_id' => $order_id, 'seller_id' => $seller_id], 'order_items');
                                $settings = get_settings('system_settings', true);
                                $app_name = isset($settings['app_name']) && !empty($settings['app_name']) ? $settings['app_name'] : '';
                                $user_res = fetch_details('users', ['id' => $user_id], 'username,fcm_id,mobile,email,platform_type');
                                $user_fcm = fetch_details('user_fcm', ['user_id' => $user_id], 'fcm_id,platform_type');
                                $fcm_ids = array();
                                //custom message
                                if (!empty($user_res[0]['fcm_id'])) {
                                    if ($status == 'received') {
                                        $type = ['type' => "customer_order_received"];
                                    } elseif ($status == 'processed') {
                                        $type = ['type' => "customer_order_processed"];
                                    } elseif ($status == 'shipped') {
                                        $type = ['type' => "customer_order_shipped"];
                                    } elseif ($status == 'delivered') {
                                        $type = ['type' => "customer_order_delivered"];
                                    } elseif ($status == 'cancelled') {
                                        $type = ['type' => "customer_order_cancelled"];
                                    } elseif ($status == 'returned') {
                                        $type = ['type' => "customer_order_returned"];
                                    }
                                    $custom_notification = fetch_details('custom_notifications', $type, '');
                                    $hashtag_cutomer_name = '< cutomer_name >';
                                    $hashtag_order_id = '< order_item_id >';
                                    $hashtag_application_name = '< application_name >';
                                    $string = json_encode($custom_notification[0]['message'], JSON_UNESCAPED_UNICODE);
                                    $hashtag = html_entity_decode($string);
                                    $data = str_replace(array($hashtag_cutomer_name, $hashtag_order_id, $hashtag_application_name), array($user_res[0]['username'], $order_id, $app_name), $hashtag);
                                    $message = output_escaping(trim($data, '"'));
                                    $customer_msg = (!empty($custom_notification)) ? $message : 'Hello Dear ' . $user_res[0]['username'] . 'Order status updated to' . $_POST['val'] . ' for order ID #' . $order_id . ' please take note of it! Thank you. Regards ' . $app_name . '';
                                    $fcmMsg = array(
                                        'title' => (!empty($custom_notification)) ? $custom_notification[0]['title'] : "Order status updated",
                                        'body' => $customer_msg,
                                        'type' => "order"
                                    );
                                    notify_event(
                                        $type['type'],
                                        ["customer" => [$user_res[0]['email']]],
                                        ["customer" => [$user_res[0]['mobile']]],
                                        ["orders.id" => $order_id]
                                    );
                                    // Step 1: Group by platform
                                    $groupedByPlatform = [];
                                    foreach ($user_fcm as $item) {
                                        $platform = $item['platform_type'];
                                        $groupedByPlatform[$platform][] = $item['fcm_id'];
                                    }

                                    // Step 2: Chunk each platform group into arrays of 1000
                                    $fcm_ids = [];
                                    foreach ($groupedByPlatform as $platform => $fcmIds) {
                                        $fcm_ids[$platform] = array_chunk($fcmIds, 1000);
                                    }

                                    $fcm_ids[0][] = $fcm_ids;
                                    if (isset($firebase_project_id) && isset($service_account_file) && !empty($firebase_project_id) && !empty($service_account_file)) {
                                        send_notification($fcmMsg, $fcm_ids, $fcmMsg);
                                    }
                                }
                            }
                            sendWebJsonResponse(false, 'Status Updated Successfully');
                        }
                    }
                }
            } else {
                $this->form_validation->set_rules('consignment_id', 'Consignment Id', 'trim|required|xss_clean');
                $this->form_validation->set_rules('status', 'Status', 'trim|required|xss_clean');
                $this->form_validation->set_rules('deliver_by', 'deliver Boy', 'trim|xss_clean');
                if (!$this->form_validation->run()) {
                    sendWebJsonResponse(true, strip_tags(validation_errors()));
                } else {



                    $consignment_id = $this->input->post('consignment_id', true);
                    $parcel_otp = $this->input->post('parcel_otp', true);
                    $status = $this->input->post('status', true);
                    $delivery_boy_otp_system = $this->input->post('delivery_boy_otp_system', true);



                    $consignment = fetch_details('consignments', ['id' => $consignment_id], '*');
                    if ($status === "delivered" && $delivery_boy_otp_system == 1 && $parcel_otp === "") {
                        sendWebJsonResponse(true, 'OTP is Requires in Delivered status');
                    }



                    if (empty($consignment)) {
                        sendWebJsonResponse(true, 'Consignment Not Found.');
                    }
                    if ($status === "delivered" && $delivery_boy_otp_system == 1 && $consignment[0]["otp"] != $parcel_otp) {
                        sendWebJsonResponse(true, 'Incorrect OTP. Please try again.');
                    }
                    $consignment_items = fetch_details('consignment_items', ['consignment_id' => $consignment[0]['id']], '*');
                    $order_id = $consignment[0]['order_id'];
                    $order_item_data = fetch_details('order_items', ['order_id' => $order_id], '*');
                    if (empty($order_item_data)) {
                        sendWebJsonResponse(true, 'Order Item Not Found.');
                    }

                    $order_tracking_data = fetch_details('order_tracking', ['consignment_id' => $consignment_id]);

                    // validate delivery boy when status is processed
                    $user_id = $order_item_data[0]['user_id'];
                    $user_res = fetch_details('users', ['id' => $user_id], 'username,fcm_id,mobile,email,platform_type');
                    $user_fcm = fetch_details('user_fcm', ['user_id' => $user_id], 'fcm_id,platform_type');

                    $delivery_boy_updated = 0;
                    $message = '';
                    $delivery_boy_id = (isset($_POST['deliver_by']) && !empty(trim($_POST['deliver_by']))) ? $this->input->post('deliver_by', true) : 0;

                    if (isset($status) && !empty($status) && $status == 'processed') {
                        if (!isset($delivery_boy_id) || empty($delivery_boy_id) || $delivery_boy_id == 0 || isset($order_tracking_data) && empty($order_tracking_data)) {
                            sendWebJsonResponse(true, 'Please select delivery boy to mark this order as processed.');
                        }
                    }

                    // validate delivery boy when status is shipped
                    if (isset($status) && !empty($status) && $status == 'shipped' && isset($order_tracking_data) && empty($order_tracking_data)) {
                        if ((!isset($order_item_data[0]['delivery_boy_id']) || empty($order_item_data[0]['delivery_boy_id']) || $order_item_data[0]['delivery_boy_id'] == 0) && (empty($_POST['deliver_by']) || $_POST['deliver_by'] == '')) {
                            sendWebJsonResponse(true, 'Please select delivery boy to mark this order as shipped.');
                        }
                    }
                    $awaitingPresent = false;
                    foreach ($consignment as $item) {
                        if ($item['active_status'] === 'awaiting') {
                            $awaitingPresent = true;
                            break;
                        }
                    }
                    if (!empty($delivery_boy_id)) {
                        if ($awaitingPresent) {
                            sendWebJsonResponse(true, 'You Can Not Change Status Of Awaiting Order ! please confirm the order first.');
                        } else {
                            $delivery_boy = fetch_details('users', ['id' => trim($delivery_boy_id)], '*');

                            if (empty($delivery_boy)) {
                                sendWebJsonResponse(true, 'Invalid Delivery Boy');
                            } else {
                                $current_delivery_boy = fetch_details('consignments', ['id', $consignment_id], '*');
                                $settings = get_settings('system_settings', true);
                                $app_name = isset($settings['app_name']) && !empty($settings['app_name']) ? $settings['app_name'] : '';
                                $firebase_project_id = $this->data['firebase_project_id'];
                                $service_account_file = $this->data['service_account_file'];
                                if (isset($current_delivery_boy[0]['delivery_boy_id']) && !empty($current_delivery_boy[0]['delivery_boy_id'])) {
                                    $delivery_boy_res = fetch_details('users', ['id', $current_delivery_boy[0]['delivery_boy_id']], 'fcm_id,username,email,mobile,platform_type');
                                } else {
                                    $delivery_boy_res = fetch_details('users', ['id' => $delivery_boy_id], 'fcm_id,username,platform_type');
                                }
                                $delivery_boy_fcm_res = fetch_details('user_fcm', ['user_id' => $delivery_boy_id], 'fcm_id,platform_type');



                                $fcm_ids = array();
                                //custom message
                                if (isset($delivery_boy_res[0]) && !empty($delivery_boy_res[0])) {
                                    if ($status == 'received') {
                                        $type = ['type' => "customer_order_received"];
                                    } elseif ($status == 'processed') {
                                        $type = ['type' => "customer_order_processed"];
                                    } elseif ($status == 'shipped') {
                                        $type = ['type' => "customer_order_shipped"];
                                        $d_type = ['type' => "delivery_boy_order_processed"];
                                    } elseif ($status == 'delivered') {
                                        $type = ['type' => "customer_order_delivered"];
                                    } elseif ($status == 'cancelled') {
                                        $type = ['type' => "customer_order_cancelled"];
                                    } elseif ($status == 'returned') {
                                        $type = ['type' => "customer_order_returned"];
                                    }
                                    $custom_notification = fetch_details('custom_notifications', $type, '');
                                    $custom_d_boy_notification = fetch_details('custom_notifications', $d_type, '');
                                    $hashtag_cutomer_name = '< cutomer_name >';
                                    $hashtag_order_id = '< order_item_id >';
                                    $hashtag_application_name = '< application_name >';
                                    $string = json_encode($custom_notification[0]['message'], JSON_UNESCAPED_UNICODE);
                                    $hashtag = html_entity_decode($string);
                                    $data = str_replace(array($hashtag_cutomer_name, $hashtag_order_id, $hashtag_application_name), array($user_res[0]['username'], $order_id, $app_name), $hashtag);
                                    $message = output_escaping(trim($data, '"'));


                                    if (!empty($current_delivery_boy[0]) && count($current_delivery_boy) > 1) {
                                        for ($i = 0; $i < count($current_delivery_boy); $i++) {
                                            $customer_msg = (!empty($custom_notification)) ? $message : 'Hello Dear ' . $user_res[$i]['username'] . 'Order status updated to' . $_POST['val'] . ' for order ID #' . $order_id . ' please take note of it! Thank you. Regards ' . $app_name . '';
                                            $fcmMsg = array(
                                                'title' => (!empty($custom_notification)) ? $custom_notification[0]['title'] : "Order status updated",
                                                'body' => $customer_msg,
                                                'type' => "order",
                                                'order_id' => (string) $order_id,
                                            );
                                            if (!empty($delivery_boy_fcm_res[$i]['fcm_id'])) {
                                                // Step 1: Group by platform
                                                $groupedByPlatform = [];
                                                foreach ($delivery_boy_fcm_res as $item) {
                                                    $platform = $item['platform_type'];
                                                    $groupedByPlatform[$platform][] = $item['fcm_id'];
                                                }

                                                // Step 2: Chunk each platform group into arrays of 1000
                                                $fcm_ids = [];
                                                foreach ($groupedByPlatform as $platform => $fcmIds) {
                                                    $fcm_ids[$platform] = array_chunk($fcmIds, 1000);
                                                }
                                                $fcm_ids[0][] = $fcm_ids;
                                            }
                                            if (isset($user_res) && !empty($user_res)) {
                                                $customer_msg = (!empty($custom_notification)) ? $message : 'Hello Dear ' . $user_res[$i]['username'] . 'Order status updated to' . $_POST['val'] . ' for order ID #' . $order_id . ' please take note of it! Thank you. Regards ' . $app_name . '';
                                                $fcmMsg = array(
                                                    'title' => (!empty($custom_notification)) ? $custom_notification[0]['title'] : "Order status updated",
                                                    'body' => $customer_msg,
                                                    'type' => "order",
                                                    'order_id' => (string) $order_id,
                                                );

                                                // Step 1: Group by platform
                                                $groupedByPlatform = [];
                                                foreach ($user_fcm as $item) {
                                                    $platform = $item['platform_type'];
                                                    $groupedByPlatform[$platform][] = $item['fcm_id'];
                                                }

                                                // Step 2: Chunk each platform group into arrays of 1000
                                                $fcm_ids = [];
                                                foreach ($groupedByPlatform as $platform => $fcmIds) {
                                                    $fcm_ids[$platform] = array_chunk($fcmIds, 1000);
                                                }

                                                $fcm_ids[0][] = $fcm_ids;
                                            }
                                            try {
                                                notify_event(
                                                    $type['type'],
                                                    ["delivery_boy" => [$delivery_boy_res[0]['email']]],
                                                    ["delivery_boy" => [$delivery_boy_res[0]['mobile']]],
                                                    ["orders.id" => $order_id]
                                                );
                                            } catch (\Throwable $th) {
                                            }
                                        }
                                        $message = 'Delivery Boy Updated.';
                                        $delivery_boy_updated = 1;
                                    } else {
                                        if (isset($current_delivery_boy[0]['delivery_boy_id']) && $current_delivery_boy[0]['delivery_boy_id'] == $_POST['deliver_by']) {
                                            $customer_msg = (!empty($custom_notification)) ? $message : 'Hello Dear ' . $user_res[0]['username'] . 'Order status updated to' . $_POST['val'] . ' for order ID #' . $order_id . '  please take note of it! Thank you. Regards ' . $app_name . '';
                                            $fcmMsg = array(
                                                'title' => (!empty($custom_notification)) ? $custom_notification[0]['title'] : "Order status updated",
                                                'body' => $customer_msg,
                                                'type' => "order",
                                                'order_id' => (string) $order_id,
                                            );

                                            try {
                                                notify_event(
                                                    $type['type'],
                                                    ["delivery_boy" => [$delivery_boy_res[0]['email']]],
                                                    ["delivery_boy" => [$delivery_boy_res[0]['mobile']]],
                                                    ["orders.id" => $order_id]
                                                );
                                            } catch (\Throwable $th) {
                                            }
                                            $message = 'Delivery Boy Updated';
                                            $delivery_boy_updated = 1;
                                        } else {
                                            $custom_notification = fetch_details('custom_notifications', ['type' => "delivery_boy_order_deliver"], '');
                                            $d_boy_msg = (!empty($custom_d_boy_notification)) ? $custom_d_boy_notification[0]['message'] : 'Hello Dear ' . $delivery_boy_res[0]['username'] . 'you have new order to be deliver order ID #' . $order_id . ' please take note of it! Thank you. Regards ' . $app_name . '';
                                            // $fcmMsg = array(
                                            //     'title' => (!empty($custom_notification)) ? $custom_notification[0]['title'] : "You have new order to deliver",
                                            //     'body' => $customer_msg,
                                            //     'type' => "order",
                                            //     'order_id' => (string) $order_id,
                                            // );

                                            $fcmMsg_dboy = array(
                                                'title' => (!empty($custom_d_boy_notification)) ? $custom_d_boy_notification[0]['title'] : "You have new order to deliver",
                                                'body' => $d_boy_msg,
                                                'type' => "order",
                                                'order_id' => (string) $order_id,
                                            );
                                            try {
                                                notify_event(
                                                    $type['type'],
                                                    ["delivery_boy" => [$delivery_boy_res[0]['email']]],
                                                    ["delivery_boy" => [$delivery_boy_res[0]['mobile']]],
                                                    ["orders.id" => $order_id]
                                                );
                                            } catch (\Throwable $th) {
                                            }
                                            $message = 'Delivery Boy Updated.';
                                            $delivery_boy_updated = 1;
                                        }
                                        if (!empty($delivery_boy_fcm_res[0]['fcm_id'])) {
                                            // Step 1: Group by platform
                                            $groupedByPlatform = [];
                                            foreach ($delivery_boy_fcm_res as $item) {
                                                $platform = $item['platform_type'];
                                                $groupedByPlatform[$platform][] = $item['fcm_id'];
                                            }

                                            // Step 2: Chunk each platform group into arrays of 1000
                                            $fcm_ids_dboy = [];
                                            foreach ($groupedByPlatform as $platform => $fcmIds) {
                                                $fcm_ids_dboy[$platform] = array_chunk($fcmIds, 1000);
                                            }

                                            $fcm_ids_dboy[0][] = $fcm_ids_dboy;
                                        }

                                        if (isset($user_res) && !empty($user_res)) {
                                            $customer_msg = (!empty($custom_notification)) ? $message : 'Hello Dear ' . $user_res[$i]['username'] . 'Order status updated to' . $_POST['val'] . ' for order ID #' . $order_id . ' please take note of it! Thank you. Regards ' . $app_name . '';
                                            $fcmMsg = array(
                                                'title' => (!empty($custom_notification)) ? $custom_notification[0]['title'] : "Order status updated",
                                                'body' => $customer_msg,
                                                'type' => "order",
                                                'order_id' => (string) $order_id,
                                            );

                                            // Step 1: Group by platform
                                            $groupedByPlatform = [];
                                            foreach ($user_fcm as $item) {
                                                $platform = $item['platform_type'];
                                                $groupedByPlatform[$platform][] = $item['fcm_id'];
                                            }

                                            // Step 2: Chunk each platform group into arrays of 1000
                                            $fcm_ids = [];
                                            foreach ($groupedByPlatform as $platform => $fcmIds) {
                                                $fcm_ids[$platform] = array_chunk($fcmIds, 1000);
                                            }

                                            $fcm_ids[0][] = $fcm_ids;
                                        }
                                    }
                                }

                                if (!empty($fcm_ids) && isset($firebase_project_id) && isset($service_account_file) && !empty($firebase_project_id) && !empty($service_account_file)) {
                                    send_notification($fcmMsg_dboy, $fcm_ids_dboy, $fcmMsg_dboy);
                                    send_notification($fcmMsg, $fcm_ids, $fcmMsg);
                                }
                                if ($this->Order_model->update_order(['delivery_boy_id' => $delivery_boy_id], ['id' => $consignment_id], false, 'consignments')) {
                                    foreach ($consignment_items as $item) {
                                        $res = $this->Order_model->update_order(['delivery_boy_id' => $delivery_boy_id], ['id' => $item['order_item_id']], false, 'order_items');
                                    }
                                    $delivery_error = false;
                                }
                            }
                        }
                    }

                    if (isset($status) && !empty($status) && $status != '') {
                        $res = validate_order_status($consignment_id, $status, 'consignments');

                        if ($res['error']) {
                            $error = $delivery_boy_updated == 1 ? false : true;
                            $message = (isset($_POST['status']) && !empty($_POST['status'])) ? $message . $res['message'] : $message;

                            sendWebJsonResponse($error, $message);
                        }
                    }
                    /* velidate bank transfer method status */
                    $order_method = fetch_details('orders', ['id' => $order_id], 'payment_method');

                    if ($order_method[0]['payment_method'] == 'bank_transfer') {
                        $bank_receipt = fetch_details('order_bank_transfer', ['order_id' => $order_id]);
                        $transaction_status = fetch_details('transactions', ['order_id' => $order_id], 'status');
                        if (empty($bank_receipt) || strtolower($transaction_status[0]['status']) != 'success' || $bank_receipt[0]['status'] == "0" || $bank_receipt[0]['status'] == "1") {
                            sendWebJsonResponse(true, 'Order item status can not update, Bank verification is remain from transactions for this order.');
                        }
                    }
                    // processing order items
                    $response_data = [];
                    if ($this->Order_model->update_order(['status' => $status], ['id' => $consignment_id], true, 'consignments')) {
                        $this->Order_model->update_order(['active_status' => $status], ['id' => $consignment_id], false, 'consignments');

                        foreach ($consignment_items as $item) {
                            $this->Order_model->update_order(['status' => $status], ['id' => $item['order_item_id']], true, 'order_items');
                            $this->Order_model->update_order(['active_status' => $status, 'delivery_boy_id' => $delivery_boy_id], ['id' => $item['order_item_id']], false, 'order_items');
                            $data = [
                                'order_item_id' => $item['order_item_id'],
                                'status' => $status
                            ];
                            array_push($response_data, $data);
                        }
                    }
                    //Update login id in order_item table
                    update_details(['updated_by' => $_SESSION['user_id']], ['order_id' => $consignment[0]['order_id'], 'seller_id' => $seller_id], 'order_items');

                    $settings = get_settings('system_settings', true);
                    $app_name = isset($settings['app_name']) && !empty($settings['app_name']) ? $settings['app_name'] : '';
                    $user_res = fetch_details('users', ['id' => $user_id], 'username,fcm_id,mobile,email');
                    $user_fcm = fetch_details('user_fcm', ['user_id' => $user_id], 'fcm_id,platform_type');
                    $fcm_ids = array();
                    //custom message
                    if (!empty($user_fcm[0]['fcm_id'])) {
                        if ($status == 'received') {
                            $type = ['type' => "customer_order_received"];
                        } elseif ($status == 'processed') {
                            $type = ['type' => "customer_order_processed"];
                        } elseif ($status == 'shipped') {
                            $type = ['type' => "customer_order_shipped"];
                        } elseif ($status == 'delivered') {
                            $type = ['type' => "customer_order_delivered"];
                        } elseif ($status == 'cancelled') {
                            $type = ['type' => "customer_order_cancelled"];
                        } elseif ($status == 'returned') {
                            $type = ['type' => "customer_order_returned"];
                        }
                        $custom_notification = fetch_details('custom_notifications', $type, '');
                        $hashtag_cutomer_name = '< cutomer_name >';
                        $hashtag_order_id = '< order_item_id >';
                        $hashtag_application_name = '< application_name >';
                        $string = json_encode($custom_notification[0]['message'], JSON_UNESCAPED_UNICODE);
                        $hashtag = html_entity_decode($string);
                        $data = str_replace(array($hashtag_cutomer_name, $hashtag_order_id, $hashtag_application_name), array($user_res[0]['username'], $order_id, $app_name), $hashtag);
                        $message = output_escaping(trim($data, '"'));
                        $customer_msg = (!empty($custom_notification)) ? $message : 'Hello Dear ' . $user_res[0]['username'] . 'Order status updated to' . $_POST['val'] . ' for order ID #' . $order_id . ' please take note of it! Thank you. Regards ' . $app_name . '';
                        $fcmMsg = array(
                            'title' => (!empty($custom_notification)) ? $custom_notification[0]['title'] : "Order status updated",
                            'body' => $customer_msg,
                            'type' => "order"
                        );
                        notify_event(
                            $type['type'],
                            ["customer" => [$user_res[0]['email']]],
                            ["customer" => [$user_res[0]['mobile']]],
                            ["orders.id" => $order_id]
                        );
                        // Step 1: Group by platform
                        $groupedByPlatform = [];
                        foreach ($user_fcm as $item) {
                            $platform = $item['platform_type'];
                            $groupedByPlatform[$platform][] = $item['fcm_id'];
                        }

                        // Step 2: Chunk each platform group into arrays of 1000
                        $fcm_ids = [];
                        foreach ($groupedByPlatform as $platform => $fcmIds) {
                            $fcm_ids[$platform] = array_chunk($fcmIds, 1000);
                        }

                        $fcm_ids[0][] = $fcm_ids;

                        if (isset($firebase_project_id) && isset($service_account_file) && !empty($firebase_project_id) && !empty($service_account_file)) {
                            send_notification($fcmMsg, $fcm_ids, $fcmMsg);
                        }
                    }

                    sendWebJsonResponse(false, 'Status Updated Successfully', [], $response_data);
                }
            }

            print_r(json_encode($this->response));
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    function order_tracking()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $this->data['main_page'] = TABLES . 'order-tracking';
            $settings = get_settings('system_settings', true);
            $this->data['title'] = 'Order Tracking | ' . $settings['app_name'];
            $this->data['meta_description'] = 'Order Tracking | ' . $settings['app_name'];
            $this->load->view('admin/template', $this->data);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function get_order_tracking()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            return $this->Order_model->get_order_tracking_list();
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function update_order_tracking()
    {
        if ($this->ion_auth->logged_in()) {
            $this->form_validation->set_rules('courier_agency', 'Courier Agency', 'trim|required|xss_clean');
            $this->form_validation->set_rules('tracking_id', 'Tracking Id', 'trim|required|xss_clean');
            $this->form_validation->set_rules('url', 'url', 'trim|required|xss_clean|valid_url');
            $this->form_validation->set_rules('consignment_id', 'Consignment Id', 'trim|required|xss_clean');
            if (!$this->form_validation->run()) {
                sendWebJsonResponse(true, strip_tags(validation_errors()));
            } else {
                // $seller_id = $this->ion_auth->get_user_id();
                $consignment_id = $this->input->post('consignment_id', true);
                $courier_agency = $this->input->post('courier_agency', true);
                $tracking_id = $this->input->post('tracking_id', true);
                $url = $this->input->post('url', true);
                $details = view_all_consignments(consignment_id: $consignment_id);
                if (isset($details['data']) && empty($details['data'])) {
                    sendWebJsonResponse(true, 'Parcel Not Found.');
                }
                $details = $details['data'][0];
                if (isset($details['is_shiprocket_order']) && $details['is_shiprocket_order'] == 1) {
                    sendWebJsonResponse(true, 'This is An Shiprocket Parcel You Can\'t Add Tracking Details Manually.');
                }
                $order_id = $details['order_id'];
                $data = array(
                    'consignment_id' => $consignment_id,
                    'order_id' => $order_id,
                    'courier_agency' => $courier_agency,
                    'tracking_id' => $tracking_id,
                    'url' => $url,
                );
                if (is_exist(['consignment_id' => $consignment_id, 'shipment_id' => ""], 'order_tracking', null)) {
                    if (update_details($data, ['consignment_id' => $consignment_id, 'shipment_id' => ""], 'order_tracking') == TRUE) {
                        sendWebJsonResponse(false, 'Tracking details Update successfully.');
                    } else {
                        sendWebJsonResponse(true, 'Not Updated. Try again later.');
                    }
                } else {
                    if (insert_details($data, 'order_tracking')) {
                        sendWebJsonResponse(false, 'Tracking details Inserted successfully.');
                    } else {
                        sendWebJsonResponse(true, 'Not Inserted. Try again later.');
                    }
                }
            }
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    function digital_product_orders()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $this->data['main_page'] = TABLES . 'manage-digital-product-order';
            $settings = get_settings('system_settings', true);
            $this->data['title'] = 'Order Management | ' . $settings['app_name'];
            $this->data['meta_description'] = ' Order Management  | ' . $settings['app_name'];
            $this->data['about_us'] = get_settings('about_us');
            $this->data['curreny'] = get_settings('currency');
            if (isset($_GET['edit_id'])) {
                $order_data = fetch_details('orders', ['id' => $_GET['edit_id']], 'email');
                $order_item_data = fetch_details('order_items', ['order_id' => $_GET['edit_id']], 'id,product_name');
                $this->data['fetched'] = $order_data;
                $this->data['order_item_data'] = $order_item_data;
            }

            $this->load->view('admin/template', $this->data);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function refund_payment()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $this->form_validation->set_rules('txn_id', 'Transaction Id', 'trim|required|xss_clean');
            $this->form_validation->set_rules('txn_amount', 'Transaction Amount', 'trim|required|xss_clean');
            if (!$this->form_validation->run()) {
                sendWebJsonResponse(true, strip_tags(validation_errors()));
            } else {
                if (!empty($_POST) || (isset($_POST['txn_id']) && $_POST['txn_id']) != '' && (isset($_POST['amount']) && $_POST['amount']) != '') {
                    $item_id = trim($_POST['item_id']);
                    $txn_id = $_POST['txn_id'];
                    $amount = $_POST['txn_amount'];
                    $payment = ($this->razorpay->refund_payment($txn_id, $amount));
                    if (([$payment['http_code']] != 'null') && empty($payment['http_code']) && $payment['http_code'] != '400') {
                        update_details(['is_refund' => 1], ['order_item_id' => $item_id], 'transactions');
                        sendWebJsonResponse(false, 'Payment Refund Successfully');
                    } else {
                        $message = json_decode($payment['body'], true);

                        sendWebJsonResponse(true, $message['error']['description']);
                    }
                    print_r(json_encode($this->response));
                }
            }
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function create_shiprocket_order()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

            $this->form_validation->set_rules('pickup_location', ' Pickup Location ', 'trim|required|xss_clean');
            $this->form_validation->set_rules('parcel_weight', ' Parcel Weight ', 'trim|required|xss_clean');
            $this->form_validation->set_rules('parcel_height', ' Parcel Height ', 'trim|required|xss_clean');
            $this->form_validation->set_rules('parcel_breadth', ' Parcel Breadth ', 'trim|required|xss_clean');
            $this->form_validation->set_rules('parcel_length', ' Parcel Length ', 'trim|required|xss_clean');

            if (!$this->form_validation->run()) {
                sendWebJsonResponse(true, strip_tags(validation_errors()));
            } else {

                $_POST['order_items'] = json_decode($_POST['order_items'][0], 1);
                $_POST['consignment_data'] = json_decode($_POST['consignment_data'][0], 1);

                $this->load->library(['Shiprocket']);
                $order_items = $_POST['order_items'];
                $consignment_data = $_POST['consignment_data'];
                if (is_exist(['consignment_id' => $consignment_data[0]['consignment_id'], 'is_canceled' => 0], 'order_tracking')) {
                    sendWebJsonResponse(true, 'Shiprocket order Already Created');
                }
                $items = [];
                $subtotal = 0;
                $order_id = 0;
                $pickup_location_pincode = fetch_details('pickup_locations', ['id' => $_POST['pickup_location']], 'pin_code');
                $user_data = fetch_details('users', ['id' => $_POST['user_id']], 'username,email');
                $order_data = fetch_details('orders', ['id' => $_POST['order_id']], 'date_added,address_id,mobile,payment_method,delivery_charge');
                $address_data = fetch_details('addresses', ['id' => $order_data[0]['address_id']], 'address,city_id,pincode,state,country');
                $city_data = fetch_details('cities', ['id' => $address_data[0]['city_id']], 'name');
                $availibility_data = [
                    'pickup_postcode' => $pickup_location_pincode[0]['pin_code'],
                    'delivery_postcode' => $address_data[0]['pincode'],
                    'cod' => ($order_data[0]['payment_method'] == 'COD') ? '1' : '0',
                    'weight' => $_POST['parcel_weight'],
                ];

                $check_deliveribility = $this->shiprocket->check_serviceability($availibility_data);
                $get_currier_id = shiprocket_recomended_data($check_deliveribility);
               
                foreach ($consignment_data as $consignment_item) {
                    foreach ($order_items as $row) {
                        
                        if ($row['id'] == $consignment_item['order_item_id']) {
                            if ($row['pickup_location'] == $_POST['pickup_location']) {
                                $order_item_id[] = $row['id'];
                                $order_id .= '-' . $row['id'];
                                $order_item_data = fetch_details('order_items', ['id' => $row['id']], 'sub_total');
                                if (isset($row['product_variants']) && !empty($row['product_variants'])) {
                                    $sku = $row['product_variants'][0]['sku'];
                                } else {
                                    $sku = $row['sku'];
                                }
                                $row['product_slug'] = strlen($row['product_slug']) > 8 ? substr($row['product_slug'], 0, 8) : $row['product_slug'];
                                $temp['name'] = $row['pname'];
                                $temp['sku'] = isset($sku) && !empty($sku) ? $sku : $row['product_slug'] . $row['id'];
                                $subtotal += (int) $consignment_item['quantity'] * (int) $consignment_item['unit_price'];
                                $temp['total_units'] = $consignment_item['total_quantity'];
                                $temp['units'] = $consignment_item['quantity'];
                                $temp['selling_price'] = $row['price'];
                                $temp['discount'] = $row['discounted_price'];
                                $temp['tax'] = $row['tax_amount'];
                                array_push($items, $temp);
                            }
                        }
                    }
                }
                $order_item_ids = implode(",", array($order_item_id));
                $random_id = '-' . rand(10, 10000);
                $delivery_charge = (strtoupper($order_data[0]['payment_method']) == 'COD') ? $order_data[0]['delivery_charge'] : 0;
                $create_order = [
                    'order_id' => $_POST['order_id'] . $order_id . $random_id,
                    'order_date' => $order_data[0]['date_added'],
                    'pickup_location' => $_POST['pickup_location_name'],
                    'billing_customer_name' => $user_data[0]['username'],
                    'billing_last_name' => "",
                    'billing_address' => $address_data[0]['address'],
                    'billing_city' => $city_data[0]['name'],
                    'billing_pincode' => $address_data[0]['pincode'],
                    'billing_state' => $address_data[0]['state'],
                    'billing_country' => $address_data[0]['country'],
                    'billing_email' => $user_data[0]['email'],
                    'billing_phone' => $order_data[0]['mobile'],
                    'shipping_is_billing' => true,
                    'order_items' => $items,
                    'payment_method' => (strtoupper($order_data[0]['payment_method']) == 'COD') ? 'COD' : 'Prepaid',
                    'sub_total' => $subtotal + $delivery_charge,
                    'length' => $_POST['parcel_length'],
                    'breadth' => $_POST['parcel_breadth'],
                    'height' => $_POST['parcel_height'],
                    'weight' => $_POST['parcel_weight'],
                ];
              
                $response = $this->shiprocket->create_order($create_order);

                if (isset($response['status_code']) && $response['status_code'] == 1) {
                    $courier_company_id = $get_currier_id['courier_company_id'];
                    $order_tracking_data = [
                        'order_id' => $_POST['order_id'],
                        'order_item_id' => $order_item_ids,
                        'consignment_id' => $consignment_data[0]['consignment_id'],
                        'shiprocket_order_id' => $response['order_id'],
                        'shipment_id' => $response['shipment_id'],
                        'courier_company_id' => $courier_company_id,
                        'pickup_status' => 0,
                        'pickup_scheduled_date' => '',
                        'pickup_token_number' => '',
                        'status' => 0,
                        'others' => '',
                        'pickup_generated_date' => '',
                        'data' => '',
                        'date' => '',
                        'manifest_url' => '',
                        'label_url' => '',
                        'invoice_url' => '',
                        'is_canceled' => 0,
                        'tracking_id' => $response['channel_order_id'],
                        'url' => ''
                    ];
                    $this->db->insert('order_tracking', $order_tracking_data);
                }
                if (isset($response['status_code']) && $response['status_code'] == 1) {
                    sendWebJsonResponse(false, 'Shiprocket order created successfully', [], $response);
                } else {
                    sendWebJsonResponse(true, 'Shiprocket order not created successfully', [], $response);
                }
                
            }
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function generate_awb()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

            $res = generate_awb($_POST['shipment_id']);
            if (!empty($res) && $res['status_code'] != 400) {
                sendWebJsonResponse(false, 'AWB generated successfully', [], $res);
            } else {
                sendWebJsonResponse(true, 'AWB not generated');
            }
            print_r(json_encode($this->response));
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function send_pickup_request()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {


            $res = send_pickup_request($_POST['shipment_id']);

            if (!empty($res)) {
                sendWebJsonResponse(false, 'Request send successfully', [], $res);
            } else {
                sendWebJsonResponse(true, 'Request not sent');
            }
            print_r(json_encode($this->response));
        } else {
            redirect('admin/login', 'refresh');
        }
    }


    public function generate_label()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $res = generate_label($_POST['shipment_id']);
            if (!empty($res)) {
                sendWebJsonResponse(false, 'Label generated successfully', [], $res);
            } else {
                sendWebJsonResponse(true, 'Label not generated');
            }
            print_r(json_encode($this->response));
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function generate_invoice()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

            $res = generate_invoice($_POST['order_id']);
            if (!empty($res) && isset($res['is_invoice_created']) && $res['is_invoice_created'] == 1) {
                sendWebJsonResponse(false, 'Invoice generated successfully', [], $res);
            } else {
                sendWebJsonResponse(true, 'Invoice not generated');
            }
            print_r(json_encode($this->response));
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function cancel_shiprocket_order()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

            $res = cancel_shiprocket_order($_POST['shiprocket_order_id']);
            if (!empty($res) && ($res['status_code'] == 200 || $res['status'] == 200)) {
                sendWebJsonResponse(false, 'Order Cancelled Successfully', [], $res);
            } else {
                sendWebJsonResponse(true, 'Order not Cancelled');
            }
            print_r(json_encode($this->response));
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function edit_transactions()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $this->form_validation->set_rules('status', 'status', 'trim|required|xss_clean');
            $this->form_validation->set_rules('txn_id', 'txn_id', 'trim|required|xss_clean');
            $this->form_validation->set_rules('id', 'id', 'trim|required|xss_clean');
            if (!$this->form_validation->run()) {
                sendWebJsonResponse(true, strip_tags(validation_errors()));
            } else {
                $_POST['message'] = (isset($_POST['message']) && trim($_POST['message']) != "") ? $this->input->post('message', true) : "";
                $status = $this->input->post('status', true);
                $prev_status = fetch_details('transactions', ['order_id' => $_POST['id']], 'status');


                if (isset($prev_status[0]['status']) && $prev_status[0]['status'] == 'failed') {
                    sendWebJsonResponse(true, 'You cannot failed an success payment request.');
                }
                if (isset($prev_status[0]['status']) && ($prev_status[0]['status'] == 'success' || $prev_status[0]['status'] == 'Success')) {
                    sendWebJsonResponse(true, 'You cannot success a failed payment request.');
                }
                if ($status == 'Failed' || $status == 'failed') {
                    sendWebJsonResponse(true, 'You have already rejected the amount.');
                }

                $this->Transaction_model->edit_transactions($_POST);
                sendWebJsonResponse(false, 'Transaction Updated Successfuly.');
            }
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    // delete_receipt
    function delete_receipt()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

            if (empty($_GET['id'])) {
                $response['error'] = true;
                $response['message'] = 'Something went wrong';
            }
            if (delete_details(['id' => $_GET['id']], "order_bank_transfer")) {
                $response['error'] = false;
                $response['message'] = 'Deleted Successfully';
            } else {
                $response['error'] = true;
                $response['message'] = 'Something went wrong';
            }
            echo json_encode($response);
        } else {
            redirect('seller/login', 'refresh');
        }
    }

    function update_receipt_status()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

            $this->form_validation->set_rules('order_id', 'Order Id', 'trim|required|xss_clean');
            $this->form_validation->set_rules('user_id', 'User Id', 'trim|required|xss_clean');
            $this->form_validation->set_rules('status', 'status', 'trim|required|xss_clean');

            if (!$this->form_validation->run()) {
                sendWebJsonResponse(true, strip_tags(validation_errors()));
            } else {
                $order_id = $this->input->post('order_id', true);
                $user_id = $this->input->post('user_id', true);
                $status = $this->input->post('status', true);

                $firebase_project_id = $this->data['firebase_project_id'];
                $service_account_file = $this->data['service_account_file'];
                if (update_details(['status' => $status], ['order_id' => $order_id], 'order_bank_transfer')) {
                    if ($status == 1) {
                        $status = "Rejected";
                    } else if ($status == 2) {
                        update_details(['active_status' => 'received'], ['order_id' => $order_id], 'order_items');
                        $status = json_encode(array(array('received', date("d-m-Y h:i:sa"))));
                        update_details(['status' => $status], ['order_id' => $order_id], 'order_items', false);
                        $status = "Accepted";
                    } else {
                        $status = "Pending";
                    }
                    //custom message
                    $custom_notification = fetch_details('custom_notifications', ['type' => "bank_transfer_receipt_status"], '');
                    $hashtag_status = '< status >';
                    $hashtag_order_id = '< order_id >';
                    $string = json_encode($custom_notification[0]['message'], JSON_UNESCAPED_UNICODE);
                    $hashtag = html_entity_decode($string);
                    $data = str_replace(array($hashtag_status, $hashtag_order_id), array($status, $order_id), $hashtag);
                    $message = output_escaping(trim($data, '"'));
                    $customer_title = (!empty($custom_notification)) ? $custom_notification[0]['title'] : 'Bank Transfer Receipt Status';
                    $customer_msg = (!empty($custom_notification)) ? $message : 'Bank Transfer Receipt' . $status . ' for order ID: ' . $order_id;

                    $user = fetch_details("users", ['id' => $user_id], 'email,mobile');
                    $user_fcm_ids = fetch_details("user_fcm", ['user_id' => $user_id], 'fcm_id,platform_type');
                    notify_event(
                        'bank_transfer_recipt_status',
                        ["customer" => [$user[0]['email']]],
                        ["customer" => [$user[0]['mobile']]],
                        ["orders.id" => $order_id]
                    );
                    // Step 1: Group by platform
                    $groupedByPlatform = [];
                    foreach ($user_fcm_ids as $item) {
                        $platform = $item['platform_type'];
                        $groupedByPlatform[$platform][] = $item['fcm_id'];
                    }

                    // Step 2: Chunk each platform group into arrays of 1000
                    $fcm_ids = [];
                    foreach ($groupedByPlatform as $platform => $fcmIds) {
                        $fcm_ids[$platform] = array_chunk($fcmIds, 1000);
                    }

                    $fcm_ids = $fcm_ids;

                    if (!empty($fcm_ids)) {
                        $fcmMsg = array(
                            'title' => $customer_title,
                            'body' => $customer_msg,
                            'type' => "order",
                        );
                        if (isset($firebase_project_id) && isset($service_account_file) && !empty($firebase_project_id) && !empty($service_account_file)) {
                            send_notification($fcmMsg, $fcm_ids, $fcmMsg);
                        }
                    }
                    sendWebJsonResponse(false, 'Recipt Status Updated Successfully');
                } else {
                    $this->response['message'] = 'Something went wrong';
                    sendWebJsonResponse(true, 'Something Went Wrong');
                }
            }

            print_r(json_encode($this->response));
        } else {
            redirect('seller/login', 'refresh');
        }
    }
}
