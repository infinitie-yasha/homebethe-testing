<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(['url', 'language', 'function_helper', 'bootstrap_table_helper', 'file']);
        $this->load->model(['Home_model', 'Order_model', 'Cart_model']);
    }

    public function index()
    {

        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $this->data['main_page'] = FORMS . 'home';
            $settings = get_settings('system_settings', true);
            $this->data['title'] = 'Admin Panel | ' . $settings['app_name'];
            $this->data['meta_description'] = 'Admin Panel | ' . $settings['app_name'];
            $this->data['currency'] = get_settings('currency');
            $this->data['order_counter'] = $this->Home_model->count_dashboard_orders();
            $this->data['user_counter'] = $this->Home_model->count_new_users();
            $this->data['delivery_boy_counter'] = $this->Home_model->count_delivery_boys();
            $this->data['product_counter'] = $this->Home_model->count_products();
            $this->data['count_products_low_status'] = $this->Home_model->count_products_stock_low_status();
            $this->data['count_products_availability_status'] = $this->Home_model->count_products_availability_status();
            $this->data['total_earnings'] = $this->Home_model->total_earnings($type = 'overall');
            $this->data['admin_earnings'] = $this->Home_model->total_earnings($type = 'admin');
            $this->data['seller_earnings'] = $this->Home_model->total_earnings($type = 'seller');
            $orders_count['awaiting'] = orders_count("awaiting");
            $orders_count['received'] = orders_count("received");
            $orders_count['processed'] = orders_count("processed");
            $orders_count['shipped'] = orders_count("shipped");
            $orders_count['delivered'] = orders_count("delivered");
            $orders_count['cancelled'] = orders_count("cancelled");
            $orders_count['returned'] = orders_count("returned");
            $orders_count['draft'] = orders_count("draft");
            $orders_count['return_request_approved'] = orders_count("return_request_approved");
            $orders_count['return_request_pending'] = orders_count("return_request_pending");
            // print_r($orders_count);
            $this->data['status_counts'] = $orders_count;
            $this->data['approved_sellers'] = $this->Home_model->approved_seller();
            $this->data['count_approved_sellers'] = $this->Home_model->count_approved_seller();
            $this->data['not_approved_sellers'] = $this->Home_model->not_approved_seller();
            $this->data['count_not_approved_sellers'] = $this->Home_model->count_not_approved_seller();
            $this->data['deactive_sellers'] = $this->Home_model->deactive_seller();
            $this->data['count_deactive_sellers'] = $this->Home_model->count_deactive_seller();

            $this->load->view('admin/template', $this->data);
        } elseif (isset($_SESSION) && isset($_SESSION["user_id"])) {
            $user_id = $_SESSION["user_id"];
            $user_group = fetch_details('users_groups', ['user_id' => $user_id], 'group_id');
            $orders_count['return_request_decline'] = orders_count("return_request_decline", $user_id);
            $orders_count['return_request_pending'] = orders_count("return_request_pending", $user_id);
            $orders_count['return_request_approved'] = orders_count("return_request_approved", $user_id);
            $orders_count['return_pickedup'] = orders_count("return_pickedup", $user_id);
            $group_id = $user_group[0]['group_id'];
            if ($group_id == 2) {
                redirect('home', 'refresh');
            } else {
                redirect('admin/login', 'refresh');
            }
        } else {
            redirect('admin/login', 'refresh');
        }
    }
    public function reset_password()
    {
        /* Parameters to be passed
            mobile_no:7894561235            
            new: pass@123
        */
        if (defined('ALLOW_MODIFICATION') && ALLOW_MODIFICATION == 0) {
            $this->response['error'] = true;
            $this->response['message'] = DEMO_VERSION_MSG;
            echo json_encode($this->response);
            return false;
        }

        $this->form_validation->set_rules('mobile', 'Mobile No', 'trim|numeric|required|xss_clean|max_length[16]');
        $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|xss_clean');

        if (!$this->form_validation->run()) {
            // $this->response['error'] = true;
            // $this->response['message'] = strip_tags(validation_errors());
            // print_r(json_encode($this->response));
            // return false;
            sendWebJsonResponse(true, strip_tags(validation_errors()));
        }
        $mobile = $this->input->post('mobile', true);
        $new_password = $this->input->post('new_password', true);
        $identity_column = $this->config->item('identity', 'ion_auth');
        $res = fetch_details('users', ['mobile' => $mobile]);
        if (!empty($res)) {
            $identity = ($identity_column == 'email') ? $res[0]['email'] : $res[0]['mobile'];
            if (!$this->ion_auth->reset_password($identity, $new_password)) {
                // $this->response['error'] = true;
                // $this->response['message'] = $this->ion_auth->messages();
                // $this->response['data'] = array();
                // echo json_encode($this->response);
                // return false;
                sendWebJsonResponse(true, $this->ion_auth->messages());
            } else {
                // $this->response['error'] = false;
                // $this->response['message'] = 'Reset Password Successfully';
                // $this->response['data'] = array();
                // echo json_encode($this->response);
                // return false;
                sendWebJsonResponse(false, 'Reset Password Successfully');
            }
        } else {
            // $this->response['error'] = true;
            // $this->response['message'] = 'User does not exists !';
            // $this->response['data'] = array();
            // echo json_encode($this->response);
            // return false;
            sendWebJsonResponse(true, 'User does not exists !');
        }
    }

    public function category_wise_product_sales()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $res = $this->db->select('c.name as category,count(oi.product_variant_id) as sales')
                ->join(' `product_variants` `pv` ', 'oi.`product_variant_id`=pv.`id`')
                ->join(' `products` p  ', ' pv.`product_id`=p.`id` ')
                ->join(' categories c ', ' p.category_id=c.id ')
                ->group_by('p.category_id')->get('`order_items` oi')->result_array();
            $response['category'] = array_column($res, 'category');
            $response['sales'] = array_column($res, 'sales');
            echo json_encode($response);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function fetch_sales()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $sales = [];

            $current_year = date('Y');
            $current_month = date('m');

            // --- Month-wise sales for current year ---
            $all_months = [
                'Jan' => 0,
                'Feb' => 0,
                'Mar' => 0,
                'Apr' => 0,
                'May' => 0,
                'Jun' => 0,
                'Jul' => 0,
                'Aug' => 0,
                'Sep' => 0,
                'Oct' => 0,
                'Nov' => 0,
                'Dec' => 0
            ];

            $month_res = $this->db->select('SUM(final_total) AS total_sale, DATE_FORMAT(date_added,"%b") AS month_name')
                ->where('YEAR(date_added)', $current_year)
                ->group_by('MONTH(date_added)')
                ->order_by('MONTH(date_added)')
                ->get('orders')->result_array();

            // Update the all_months array with sales data
            foreach ($month_res as $sale) {
                if (isset($all_months[$sale['month_name']])) {
                    $all_months[$sale['month_name']] = (float) $sale['total_sale'];
                }
            }

            // Format the data for the final response
            $month_wise_sales = [
                'total_sale' => array_values($all_months),
                'month_name' => array_keys($all_months)
            ];
            $sales[0] = $month_wise_sales;

            // --- Week-wise sales for current year (current week only) ---
            $all_days = [
                'Sunday' => 0,
                'Monday' => 0,
                'Tuesday' => 0,
                'Wednesday' => 0,
                'Thursday' => 0,
                'Friday' => 0,
                'Saturday' => 0
            ];

            $d = strtotime("today");
            $start_week = strtotime("last sunday midnight", $d);
            $end_week = strtotime("next saturday", $d);
            $start = date("Y-m-d", $start_week);
            $end = date("Y-m-d", $end_week);

            $week_res = $this->db->select("DATE_FORMAT(date_added, '%Y-%m-%d') as date, SUM(final_total) as total_sale")
                ->where("date(date_added) >= '$start' and date(date_added) <= '$end'")
                ->where('YEAR(date_added)', $current_year)
                ->group_by('DAY(date_added)')
                ->get('orders')->result_array();



            foreach ($week_res as $sale) {
                // Convert the 'date' field to a timestamp to get the day of the week
                $day_name = date('l', strtotime($sale['date'])); // 'l' gives the full day name (Monday, Tuesday, etc.)

                // Add the sales total to the correct day
                if (isset($all_days[$day_name])) {
                    $all_days[$day_name] = (float) $sale['total_sale'];
                }
            }

            // Format the data for the final response
            $week_wise_sales = [
                'total_sale' => array_values($all_days),  // Get just the sales figures
                'week' => array_keys($all_days)       // Get just the day names
            ];
            $sales[1] = $week_wise_sales;

            // --- Day-wise sales for current year (last 30 days of current year) ---
            $day_res = $this->db->select("DAY(date_added) as date, SUM(final_total) as total_sale")
                ->where('date_added >= DATE_SUB(CURDATE(), INTERVAL 29 DAY)')
                ->where('YEAR(date_added)', $current_year)
                ->where('MONTH(date_added)', $current_month)
                ->group_by('DAY(date_added)')
                ->get('orders')->result_array();

            $all_days = array_fill(0, 30, 0);

            foreach ($day_res as $sale) {
                $day_of_month = (int) $sale['date'];
                if ($day_of_month > 0 && $day_of_month <= 30) {
                    $all_days[$day_of_month - 1] = (float) $sale['total_sale'];
                }
            }

            $day_wise_sales = [
                'total_sale' => $all_days,
                'day' => range(1, 30)
            ];
            $sales[2] = $day_wise_sales;

            print_r(json_encode($sales));
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function category_wise_product_count()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $res = $this->db->select('c.name as name,count(c.id) as counter')->where(['p.status' => '1', 'c.status' => '1'])->join('products p', 'p.category_id=c.id')->group_by('c.id')->get('categories c')->result_array();
            $result = array();
            $result[0][] = 'Task';
            $result[0][] = 'Hours per Day';
            array_walk($res, function ($v, $k) use (&$result) {
                $result[$k + 1][] = $v['name'];
                $result[$k + 1][] = intval($v['counter']);
            });
            echo json_encode(array_values($result));
        } else {
            redirect('admin/login', 'refresh');
        }
    }


    public function delete_image()
    {
        $id = $this->input->post('id', true);
        $path = $this->input->post('path', true);
        $field = $this->input->post('field', true);
        $img_name = $this->input->post('img_name', true);
        $table_name = $this->input->post('table_name', true);
        $isjson = $this->input->post('isjson', true);

        $this->response['is_deleted'] = delete_image($id, $path, $field, $img_name, $table_name, $isjson);

        sendWebJsonResponse(false, '', [], $this->response);
    }
    public function logout()
    {
        $this->ion_auth->logout();
        redirect('admin/login', 'refresh');
    }

    public function profile()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $identity_column = $this->config->item('identity', 'ion_auth');
            $this->data['users'] = $this->ion_auth->user()->row();
            $settings = get_settings('system_settings', true);
            $this->data['identity_column'] = $identity_column;
            $this->data['main_page'] = FORMS . 'profile';
            $this->data['title'] = 'Profile | ' . $settings['app_name'];
            $this->data['meta_description'] = 'Profile | ' . $settings['app_name'];
            $this->load->view('admin/template', $this->data);
        } else {
            redirect('admin/home', 'refresh');
        }
    }

    public function update_status()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            if (defined('ALLOW_MODIFICATION') && ALLOW_MODIFICATION == 0) {
                $this->response['error'] = true;
                $this->response['message'] = DEMO_VERSION_MSG;
                echo json_encode($this->response);
                return false;
                exit();
            }

            // Toggle status based on the input
            if ($_GET['status'] == '1') {
                $_GET['status'] = 0;
            } else if ($_GET['status'] == '2') {
                $_GET['status'] = 1;
            } else {
                $_GET['status'] = 1;
            }

            $this->db->trans_start();

            if ($_GET['table'] == 'users') {
                // Update the 'active' field for users table
                $this->db->set('active', $this->db->escape($_GET['status']));
            } else if ($_GET['table'] == 'categories') {
                $category_id = $_GET['id']; // Assuming 'category_id' is passed via GET
                $category_status = $_GET['status']; // Assuming 'category_id' is passed via GET

                $this->db->select('*');
                $this->db->from('products');
                $this->db->where('find_in_set("' . $category_id . '", category_id) > 0');
                $query = $this->db->get()->result_array();

                if (count($query) > 0 && $category_status == 0) {
                    sendWebJsonResponse(true, 'This category is in use . you cannot deactivate it anymore');
                } else {
                    // Update based on FIND_IN_SET
                    $this->db->set('status', $this->db->escape($_GET['status']));
                }
            } else if ($_GET['table'] == 'brands') {
                $brand_id = $_GET['id']; // Assuming 'brand_id' is passed via GET
                $brand_status = $_GET['status']; // Assuming 'brand_id' is passed via GET

                $this->db->select('*');
                $this->db->from('products');
                $this->db->where('find_in_set("' . $brand_id . '", brand) > 0');
                $query = $this->db->get()->result_array();

                if (count($query) > 0 && $brand_status == 0) {
                    sendWebJsonResponse(true, 'This brand is in use . you cannot deactivate it anymore');
                } else {
                    // Update based on FIND_IN_SET
                    $this->db->set('status', $this->db->escape($_GET['status']));
                }
            } else if ($_GET['table'] == 'attribute_values') {
                $attribute_id = $_GET['id']; // Assuming 'attribute_id' is passed via GET
                $attribute_status = $_GET['status']; // Assuming 'attribute_id' is passed via GET

                $this->db->select('*');
                $this->db->from('product_attributes');
                $this->db->where('find_in_set("' . $attribute_id . '", attribute_value_ids) > 0');
                $query = $this->db->get()->result_array();

                if (count($query) > 0 && $attribute_status == 0) {
                    sendWebJsonResponse(true, 'This attribute is in use . you cannot deactivate it anymore');
                } else {
                    // Update based on FIND_IN_SET
                    $this->db->set('status', $this->db->escape($_GET['status']));
                }
            } else if ($_GET['table'] == 'attribute_set') {
                $attribute_id = $_GET['id']; // Assuming 'attribute_id' is passed via GET
                $attribute_status = $_GET['status']; // Assuming 'attribute_id' is passed via GET

                $this->db->select('*');
                $this->db->from('product_attributes');
                $this->db->where('find_in_set("' . $attribute_id . '", attribute_value_ids) > 0');
                $query = $this->db->get()->result_array();

                $this->db->select('*');
                $this->db->from('attributes');
                $this->db->where('attribute_set_id', $attribute_id);
                $attribute_query = $this->db->get()->result_array();

                if (count($query) > 0 && count($attribute_query) > 0 && $attribute_status == 0) {
                    sendWebJsonResponse(true, 'This attribute is in use . you cannot deactivate it anymore');
                } else {
                    // Update based on FIND_IN_SET
                    $this->db->set('status', $this->db->escape($_GET['status']));
                }
            } else if ($_GET['table'] == 'products') {

                $product_id = $_GET['id'];
                $product_table_data = $this->db->where(['id' => $product_id])->get('products')->row_array();

                if ($product_table_data['approval_status'] != 'approved') {
                    sendWebJsonResponse(true, "Product is not approved can not update status directly.");
                }

                // Update the status for other tables
                $this->db->set('status', $this->db->escape($_GET['status']));
            } else {
                // Update the status for other tables
                $this->db->set('status', $this->db->escape($_GET['status']));
            }

            // Update the specified table
            $this->db->where('id', $_GET['id'])->update($_GET['table']);
            $this->db->trans_complete();

            $tableName = getFriendlyTableName($_GET['table']);

            if ($this->db->trans_status() === true) {
                sendWebJsonResponse(false, "$tableName status updated successfully.");
            } else {
                sendWebJsonResponse(true, "Failed to update $tableName status. Please try again.");
            }

            // sendWebJsonResponse($error, $message);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    // send admin notification
    public function get_notification()
    {
        $count_noti = fetch_details('system_notification', ["read_by" => 0], 'count(id) as total');

        $response['error'] = false;
        $response['count_notifications'] = $count_noti[0]['total'];

        print_r(json_encode($response));
    }

    public function new_notification_list()
    {

        $notifications = fetch_details('system_notification', ["read_by" => 0], '*', '3', '0', 'id', 'DESC', '', '');

        $response['error'] = false;
        $response['notifications'] = $notifications;

        print_r(json_encode($response));
    }

    // Get dynamic stats data for different time periods
    public function get_stats_data()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $period = $this->input->get('period', true);

            $response = [
                'error' => false,
                'data' => []
            ];

            switch ($period) {
                case 'last_7_days':
                    $response['data'] = $this->getLast7DaysStats();
                    break;
                case 'last_30_days':
                    $response['data'] = $this->getLast30DaysStats();
                    break;
                case 'last_3_months':
                    $response['data'] = $this->getLast3MonthsStats();
                    break;
                default:
                    $response['data'] = $this->getLast7DaysStats();
                    break;
            }

            echo json_encode($response);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    // Get customer chart data for mini charts
    public function get_customers_chart_data()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $period = $this->input->get('period', true);

            $response = [
                'error' => false,
                'data' => []
            ];

            switch ($period) {
                case 'last_7_days':
                    $response['data'] = $this->getLast7DaysCustomerData();
                    break;
                case 'last_30_days':
                    $response['data'] = $this->getLast30DaysCustomerData();
                    break;
                case 'last_3_months':
                    $response['data'] = $this->getLast3MonthsCustomerData();
                    break;
                default:
                    $response['data'] = $this->getLast7DaysCustomerData();
                    break;
            }

            echo json_encode($response);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    private function getLast7DaysCustomerData()
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime('-' . $i . ' days'));
            $start_date = $date . ' 00:00:00';
            $end_date = $date . ' 23:59:59';

            $count = $this->db->select('count(u.id) as counter')
                ->join('users_groups ug', 'ug.user_id = u.id')
                ->where('ug.group_id', '2')
                ->where('u.created_at >=', $start_date)
                ->where('u.created_at <=', $end_date)
                ->get('users u')
                ->result_array();

            $data[] = (int) $count[0]['counter'];
        }
        return $data;
    }

    private function getLast30DaysCustomerData()
    {
        $data = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime('-' . $i . ' days'));
            $start_date = $date . ' 00:00:00';
            $end_date = $date . ' 23:59:59';

            $count = $this->db->select('count(u.id) as counter')
                ->join('users_groups ug', 'ug.user_id = u.id')
                ->where('ug.group_id', '2')
                ->where('u.created_at >=', $start_date)
                ->where('u.created_at <=', $end_date)
                ->get('users u')
                ->result_array();

            $data[] = (int) $count[0]['counter'];
        }
        return $data;
    }

    private function getLast3MonthsCustomerData()
    {
        $data = [];
        for ($i = 89; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime('-' . $i . ' days'));
            $start_date = $date . ' 00:00:00';
            $end_date = $date . ' 23:59:59';

            $count = $this->db->select('count(u.id) as counter')
                ->join('users_groups ug', 'ug.user_id = u.id')
                ->where('ug.group_id', '2')
                ->where('u.created_at >=', $start_date)
                ->where('u.created_at <=', $end_date)
                ->get('users u')
                ->result_array();

            $data[] = (int) $count[0]['counter'];
        }
        return $data;
    }

    private function getLast7DaysStats()
    {
        $seven_days_ago = date('Y-m-d H:i:s', strtotime('-7 days'));

        // Count orders in last 7 days
        $orders_count = $this->db->where('date_added >=', $seven_days_ago)->count_all_results('orders');

        // Count new customers (users with group_id = 2) in last 7 days
        $customers_count = $this->db->select('count(u.id) as counter')
            ->join('users_groups ug', 'ug.user_id = u.id')
            ->where('ug.group_id', '2')
            ->where('u.created_at >=', $seven_days_ago)
            ->get('users u')
            ->result_array();
        $customers_count = $customers_count[0]['counter'];

        // Count active products
        $products_count = $this->db->where(['status' => '1'])->count_all_results('products');

        // Count delivery boys (users with group_id = 3) in last 7 days
        $delivery_boys_count = $this->db->select('count(u.id) as counter')
            ->join('users_groups ug', 'ug.user_id = u.id')
            ->where('ug.group_id', '3')
            ->where('u.created_at >=', $seven_days_ago)
            ->get('users u')
            ->result_array();
        $delivery_boys_count = $delivery_boys_count[0]['counter'];

        return [
            'orders' => $orders_count,
            'customers' => $customers_count,
            'products' => $products_count,
            'delivery_boys' => $delivery_boys_count,
            'low_stock_products' => $this->Home_model->count_products_stock_low_status(),
            'out_of_stock_products' => $this->Home_model->count_products_availability_status()
        ];
    }

    private function getLast30DaysStats()
    {
        $thirty_days_ago = date('Y-m-d H:i:s', strtotime('-30 days'));

        // Count orders in last 30 days
        $orders_count = $this->db->where('date_added >=', $thirty_days_ago)->count_all_results('orders');

        // Count new customers (users with group_id = 2) in last 30 days
        $customers_count = $this->db->select('count(u.id) as counter')
            ->join('users_groups ug', 'ug.user_id = u.id')
            ->where('ug.group_id', '2')
            ->where('u.created_at >=', $thirty_days_ago)
            ->get('users u')
            ->result_array();
        $customers_count = $customers_count[0]['counter'];

        // Count active products
        $products_count = $this->db->where(['status' => '1'])->count_all_results('products');

        // Count delivery boys (users with group_id = 3) in last 30 days
        $delivery_boys_count = $this->db->select('count(u.id) as counter')
            ->join('users_groups ug', 'ug.user_id = u.id')
            ->where('ug.group_id', '3')
            ->where('u.created_at >=', $thirty_days_ago)
            ->get('users u')
            ->result_array();
        $delivery_boys_count = $delivery_boys_count[0]['counter'];

        return [
            'orders' => $orders_count,
            'customers' => $customers_count,
            'products' => $products_count,
            'delivery_boys' => $delivery_boys_count,
            'low_stock_products' => $this->Home_model->count_products_stock_low_status(),
            'out_of_stock_products' => $this->Home_model->count_products_availability_status()
        ];
    }

    private function getLast3MonthsStats()
    {
        $three_months_ago = date('Y-m-d H:i:s', strtotime('-3 months'));

        // Count orders in last 3 months
        $orders_count = $this->db->where('date_added >=', $three_months_ago)->count_all_results('orders');

        // Count new customers (users with group_id = 2) in last 3 months
        $customers_count = $this->db->select('count(u.id) as counter')
            ->join('users_groups ug', 'ug.user_id = u.id')
            ->where('ug.group_id', '2')
            ->where('u.created_at >=', $three_months_ago)
            ->get('users u')
            ->result_array();
        $customers_count = $customers_count[0]['counter'];

        // Count active products
        $products_count = $this->db->where(['status' => '1'])->count_all_results('products');

        // Count delivery boys (users with group_id = 3) in last 3 months
        $delivery_boys_count = $this->db->select('count(u.id) as counter')
            ->join('users_groups ug', 'ug.user_id = u.id')
            ->where('ug.group_id', '3')
            ->where('u.created_at >=', $three_months_ago)
            ->get('users u')
            ->result_array();
        $delivery_boys_count = $delivery_boys_count[0]['counter'];

        return [
            'orders' => $orders_count,
            'customers' => $customers_count,
            'products' => $products_count,
            'delivery_boys' => $delivery_boys_count,
            'low_stock_products' => $this->Home_model->count_products_stock_low_status(),
            'out_of_stock_products' => $this->Home_model->count_products_availability_status()
        ];
    }

    // Get dynamic product stats based on filter
    public function get_product_stats()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $filter = $this->input->get('filter', true);

            $response = [
                'error' => false,
                'count' => 0
            ];

            switch ($filter) {
                case 'active':
                    $response['count'] = $this->db->where(['status' => '1'])->count_all_results('products');
                    break;
                case 'all':
                    $response['count'] = $this->db->count_all_results('products');
                    break;
                case 'low_stock':
                    $response['count'] = $this->Home_model->count_products_stock_low_status();
                    break;
                default:
                    $response['count'] = $this->db->where(['status' => '1'])->count_all_results('products');
                    break;
            }

            echo json_encode($response);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    // Get dynamic delivery boy stats based on filter
    public function get_delivery_boy_stats()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $filter = $this->input->get('filter', true);

            $response = [
                'error' => false,
                'count' => 0
            ];

            // Base query for delivery boys (users with group_id = 3)
            $this->db->select('count(u.id) as counter')
                ->join('users_groups ug', 'ug.user_id = u.id')
                ->where('ug.group_id', '3');

            switch ($filter) {
                case 'active':
                    $this->db->where('u.status', '1');
                    break;
                case 'all':
                    // No additional filter needed
                    break;
                case 'inactive':
                    $this->db->where('u.status', '0');
                    break;
                default:
                    $this->db->where('u.status', '1');
                    break;
            }

            $result = $this->db->get('users u')->result_array();
            $response['count'] = $result[0]['counter'];

            echo json_encode($response);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    public function get_revenue_chart_data()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $period = $this->input->get('period', true);

            $response = [
                'error' => false,
                'data' => [],
                'categories' => []
            ];

            switch ($period) {
                case 'daily':
                    $revenueData = $this->getDailyRevenueData();
                    break;
                case 'weekly':
                    $revenueData = $this->getWeeklyRevenueData();
                    break;
                case 'monthly':
                default:
                    $revenueData = $this->getMonthlyRevenueData();
                    break;
            }

            $response['data'] = $revenueData['data'];
            $response['categories'] = $revenueData['categories'];

            echo json_encode($response);
        } else {
            redirect('admin/login', 'refresh');
        }
    }

    private function getDailyRevenueData()
    {
        $data = [];
        $categories = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

        // Get last 7 days revenue
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime('-' . $i . ' days'));
            $start_date = $date . ' 00:00:00';
            $end_date = $date . ' 23:59:59';

            $result = $this->db->select('COALESCE(SUM(sub_total), 0) as revenue')
                ->where('date_added >=', $start_date)
                ->where('date_added <=', $end_date)
                ->where_in('active_status', ['delivered'])
                ->get('order_items')
                ->result_array();

            $data[] = round((float) $result[0]['revenue'], 2);
        }

        return ['data' => $data, 'categories' => $categories];
    }

    private function getWeeklyRevenueData()
    {
        $data = [];
        $categories = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];

        // Get last 4 weeks revenue
        for ($i = 3; $i >= 0; $i--) {
            $start_date = date('Y-m-d 00:00:00', strtotime('-' . (($i + 1) * 7) . ' days'));
            $end_date = date('Y-m-d 23:59:59', strtotime('-' . ($i * 7) . ' days'));

            $result = $this->db->select('COALESCE(SUM(sub_total), 0) as revenue')
                ->where('date_added >=', $start_date)
                ->where('date_added <=', $end_date)
                ->where_in('active_status', ['delivered'])
                ->get('order_items')
                ->result_array();

            $data[] = round((float) $result[0]['revenue'], 2);
        }

        return ['data' => $data, 'categories' => $categories];
    }

    private function getMonthlyRevenueData()
    {
        $data = [];
        $categories = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        $current_year = date('Y');

        // Get revenue for each month of the current year
        for ($month = 1; $month <= 12; $month++) {
            $start_date = date('Y-m-01 00:00:00', strtotime($current_year . '-' . $month . '-01'));
            $end_date = date('Y-m-t 23:59:59', strtotime($current_year . '-' . $month . '-01'));

            $result = $this->db->select('COALESCE(SUM(sub_total), 0) as revenue')
                ->where('date_added >=', $start_date)
                ->where('date_added <=', $end_date)
                ->where_in('active_status', ['delivered'])
                ->get('order_items')
                ->result_array();

            $data[] = round((float) $result[0]['revenue'], 2);
        }

        return ['data' => $data, 'categories' => $categories];
    }
}
