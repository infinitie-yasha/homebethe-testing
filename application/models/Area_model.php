<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Area_model extends CI_Model
{

    function add_city($data)
    {
        $data = escape_array($data);
        $city_data = [
            'name' => $data['city_name'],
            'minimum_free_delivery_order_amount' => $data['minimum_free_delivery_order_amount'],
            'delivery_charges' => $data['delivery_charges'],
        ];
        if (isset($data['edit_city']) && !empty($data['edit_city'])) {
            $this->db->set($city_data)->where('id', $data['edit_city'])->update('cities');
        } else {
            $this->db->insert('cities', $city_data);
        }
    }
    function add_zipcode($data)
    {
        $data = escape_array($data);
        $zipcode_data = [
            'zipcode' => (isset($data['zipcode']) && !empty($data['zipcode'])) ? $data['zipcode'] : '',
            'city_id' => $data['city'],
            'minimum_free_delivery_order_amount' => $data['minimum_free_delivery_order_amount'],
            'delivery_charges' => $data['delivery_charges'],
        ];
        if (isset($data['edit_zipcode']) && !empty($data['edit_zipcode'])) {
            $this->db->set($zipcode_data)->where('id', $data['edit_zipcode'])->update('zipcodes');
        } else {
            $this->db->insert('zipcodes', $zipcode_data);
        }
    }
    function add_area($data)
    {
        $data = escape_array($data);

        $area_data = [
            'name' => $data['area_name'],
            'city_id' => $data['city'],
            'zipcode_id' => $data['zipcode'],
            'minimum_free_delivery_order_amount' => $data['minimum_free_delivery_order_amount'],
            'delivery_charges' => $data['delivery_charges'],
        ];

        if (isset($data['edit_area']) && !empty($data['edit_area'])) {
            $this->db->set($area_data)->where('id', $data['edit_area'])->update('areas');
        } else {
            $this->db->insert('areas', $area_data);
        }
    }
    function bulk_edit_area($data)
    {
        $data = escape_array($data);

        $area_data = [
            'minimum_free_delivery_order_amount' => $data['bulk_update_minimum_free_delivery_order_amount'],
            'delivery_charges' => $data['bulk_update_delivery_charges'],
        ];
        $this->db->set($area_data)->where('city_id', $data['city'])->update('areas');
    }
    public function get_list($table, $offset = 0, $limit = 10, $sort = 'u.id')
    {
        $multipleWhere = '';

        if (isset($_GET['offset']) && !empty($_GET['offset']))
            $offset = $_GET['offset'];
        if (isset($_GET['limit']) && !empty($_GET['limit']))
            $limit = $_GET['limit'];

        if (isset($_GET['sort']) && !empty($_GET['sort']))
            if ($_GET['sort'] == 'id') {
                $sort = "id";
            } else {
                $sort = $_GET['sort'];
            }
        if (isset($_GET['order']) && !empty($_GET['order']))
            $order = $_GET['order'];

        if (isset($_GET['search']) and $_GET['search'] != '') {
            $search = $_GET['search'];
            if ($table == 'areas') {
                $multipleWhere = ['areas.id' => $search, 'areas.name' => $search, 'cities.name' => $search, 'areas.minimum_free_delivery_order_amount' => $search, 'areas.delivery_charges' => $search, 'zipcodes.zipcode' => $search];
            } else {
                $multipleWhere = ['cities.name' => $search, 'cities.id' => $search];
            }
        }
        if ($table == 'areas') {
            $count_res = $this->db->select(' COUNT(areas.id) as `total` ')->join('cities', 'areas.city_id=cities.id')->join('zipcodes', 'areas.zipcode_id=zipcodes.id');
        } else {
            $count_res = $this->db->select(' COUNT(id) as `total` ');
        }


        if (isset($multipleWhere) && !empty($multipleWhere)) {
            $count_res->or_like($multipleWhere);
        }
        if (isset($where) && !empty($where)) {
            $count_res->where($where);
        }

        $city_count = $count_res->get($table)->result_array();

        foreach ($city_count as $row) {
            $total = $row['total'];
        }

        if ($table == 'areas') {
            $search_res = $this->db->select(' areas.* , cities.name as city_name , zipcodes.zipcode as zipcode')->join('cities', 'areas.city_id=cities.id')->join('zipcodes', 'areas.zipcode_id=zipcodes.id');
        } else {
            $search_res = $this->db->select(' * ');
        }

        if (isset($multipleWhere) && !empty($multipleWhere)) {
            $search_res->or_like($multipleWhere);
        }
        if (isset($where) && !empty($where)) {
            $search_res->where($where);
        }

        $city_search_res = $search_res->order_by($sort, $order)->limit($limit, $offset)->get($table)->result_array();
        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();
        $url = 'manage_' . $table;
        foreach ($city_search_res as $row) {
            $row = output_escaping($row);

            // Create dropdown menu for operate column
            if (!$this->ion_auth->is_seller()) {
                $operate = '
                <div class="dropdown">
                    <button class="btn btn-secondary btn-sm bg-secondary-lt" type="button" 
                            data-bs-toggle="dropdown" aria-expanded="false" title="Actions">
                        <i class="ti ti-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end table-dropdown-menu">';

                // Edit City
                $operate .= '<li>
                    <a class="dropdown-item edit_btn" href="javascript:void(0)" 
                       data-id="' . $row['id'] . '" 
                       data-bs-toggle="offcanvas" 
                       data-bs-target="#addCity">
                        <i class="ti ti-pencil me-2"></i>Edit
                    </a>
                </li>';

                // Divider
                $operate .= '<li><hr class="dropdown-divider"></li>';

                // Delete City
                $operate .= '<li>
                    <a class="dropdown-item text-danger" href="javascript:void(0)"
                       x-data="ajaxDelete({
                           url: base_url + \'admin/Area/delete_city\',
                           id: \'' . $row['id'] . '\',
                           tableSelector: \'#cities_table\',
                           confirmTitle: \'Delete City\',
                           confirmMessage: \'Do you really want to delete this city?\'
                       })"
                       @click="deleteItem">
                        <i class="ti ti-trash me-2"></i>Delete
                    </a>
                </li>';

                $operate .= '
                    </ul>
                </div>';
            } else {
                $operate = '';
            }
            $tempRow['id'] = $row['id'];
            $tempRow['name'] = $row['name'];
            $tempRow['minimum_free_delivery_order_amount'] = $row['minimum_free_delivery_order_amount'];
            $tempRow['delivery_charges'] = $row['delivery_charges'];
            if ($table == 'areas') {
                $tempRow['city_name'] = $row['city_name'];
                $tempRow['zipcode'] = $row['zipcode'];
                $tempRow['minimum_free_delivery_order_amount'] = $row['minimum_free_delivery_order_amount'];
                $tempRow['delivery_charges'] = $row['delivery_charges'];
            }
            if (!$this->ion_auth->is_seller()) {

                $tempRow['operate'] = $operate;
            }
            $rows[] = $tempRow;
        }
        $bulkData['rows'] = $rows;
        print_r(json_encode($bulkData));
    }

    function get_zipcode_list()
    {
        $offset = 0;
        $limit = 10;
        $sort = 'id';
        $order = 'DESC';
        $multipleWhere = '';

        if (isset($_GET['offset']) && !empty($_GET['offset']))
            $offset = $_GET['offset'];
        if (isset($_GET['limit']) && !empty($_GET['limit']))
            $limit = $_GET['limit'];

        if (isset($_GET['sort']) && !empty($_GET['sort']))
            if ($_GET['sort'] == 'id') {
                $sort = "zipcodes.id";
            } else {
                $sort = $_GET['sort'];
            }
        if (isset($_GET['order']) && !empty($_GET['order']))
            $order = $_GET['order'];

        if (isset($_GET['search']) and $_GET['search'] != '') {
            $search = $_GET['search'];
            $multipleWhere = ['`zipcodes.id`' => $search, '`zipcodes.zipcode`' => $search, '`cities.name`' => $search, '`zipcodes.minimum_free_delivery_order_amount`' => $search, '`zipcodes.delivery_charges`' => $search];
        }

        $count_res = $this->db->select(' COUNT(zipcodes.id) as `total`, cities.id as city_id, cities.name as city_name');

        if (isset($multipleWhere) && !empty($multipleWhere)) {
            $count_res->or_like($multipleWhere);
        }
        if (isset($where) && !empty($where)) {
            $count_res->where($where);
        }

        $tax_count = $count_res->join('cities', 'zipcodes.city_id=cities.id', 'left')->get('zipcodes')->result_array();

        foreach ($tax_count as $row) {
            $total = $row['total'];
        }

        if (!$this->db->field_exists('city_id', 'zipcodes')) {
            $search_res = $this->db->select(' * ');
        } else {
            $search_res = $this->db->select(' zipcodes.* ,cities.name as city_name')->join('cities', 'zipcodes.city_id=cities.id', 'left');
        }
        if (isset($multipleWhere) && !empty($multipleWhere)) {
            $search_res->or_like($multipleWhere);
        }
        if (isset($where) && !empty($where)) {
            $search_res->where($where);
        }

        $tax_search_res = $search_res->order_by($sort, $order)->limit($limit, $offset)->get('zipcodes')->result_array();

        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();

        foreach ($tax_search_res as $row) {
            $row = output_escaping($row);

            // Create dropdown menu for operate column
            if (!$this->ion_auth->is_seller()) {
                $operate = '
                <div class="dropdown">
                    <button class="btn btn-secondary btn-sm bg-secondary-lt" type="button" 
                            data-bs-toggle="dropdown" aria-expanded="false" title="Actions">
                        <i class="ti ti-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end table-dropdown-menu">';

                // Edit Zipcode
                $operate .= '<li>
                    <a class="dropdown-item" href="javascript:void(0)" 
                       data-id="' . $row['id'] . '" 
                       data-city-id="' . $row['city_id'] . '" 
                       data-bs-toggle="offcanvas" 
                       data-bs-target="#addZipcode" 
                       role="button" 
                       aria-controls="addZipcode">
                        <i class="ti ti-pencil me-2"></i>Edit
                    </a>
                </li>';

                // Divider
                $operate .= '<li><hr class="dropdown-divider"></li>';

                // Delete Zipcode
                $operate .= '<li>
                    <a class="dropdown-item text-danger" href="javascript:void(0)"
                       x-data="ajaxDelete({
                           url: base_url + \'admin/Area/delete_zipcode\',
                           id: \'' . $row['id'] . '\',
                           tableSelector: \'#zipcode-table\',
                           confirmTitle: \'Delete Zipcode\',
                           confirmMessage: \'Do you really want to delete this zipcode?\'
                       })"
                       @click="deleteItem">
                        <i class="ti ti-trash me-2"></i>Delete
                    </a>
                </li>';

                $operate .= '
                    </ul>
                </div>';
            } else {
                $operate = '';
            }
            $tempRow['id'] = $row['id'];
            $tempRow['zipcode'] = $row['zipcode'];
            $tempRow['city_id'] = $row['city_id'];
            if (!$this->db->field_exists('city_id', 'zipcodes')) {
                $tempRow['city_name'] = '';
                $tempRow['minimum_free_delivery_order_amount'] = 0;
                $tempRow['delivery_charges'] = 0;
            } else {
                $tempRow['city_name'] = $row['city_name'];
                $tempRow['minimum_free_delivery_order_amount'] = $row['minimum_free_delivery_order_amount'];
                $tempRow['delivery_charges'] = $row['delivery_charges'];
            }
            if (!$this->ion_auth->is_seller()) {
                $tempRow['operate'] = $operate;
            }
            $rows[] = $tempRow;
        }
        $bulkData['rows'] = $rows;
        print_r(json_encode($bulkData));
    }


    function get_zipcodes($search = '', $limit = NULL, $offset = NULL, $seller_id = '')
    {
        $where = [];
        $zipcodes = [];
        //Fetch serviceable zipcodes from seller_data
        if (!empty($seller_id)) {
            $seller = $this->db->select('serviceable_zipcodes')
                ->where('user_id', $seller_id)
                ->get('seller_data')
                ->row_array();

            if (!empty($seller['serviceable_zipcodes'])) {
                $zipcodes = explode(',', $seller['serviceable_zipcodes']); // Convert to array
            }
        }

        //Apply search filter
        if (!empty($search)) {
            $where['zipcode LIKE'] = "%$search%";
        }

        //Apply zip code filter (if seller has serviceable zip codes)
        if (!empty($zipcodes)) {
            $this->db->where_in('id', $zipcodes);
        }

        //Get total count
        $total = $this->db->select('COUNT(id) as total')
            ->from('zipcodes')
            ->where($where)
            ->get()
            ->row()
            ->total;

        // Fetch Zipcodes
        $this->db->select('*')->from('zipcodes')->where($where);
        if (!empty($zipcodes)) {
            $this->db->where_in('id', $zipcodes);
        }

        $cat_search_res = $this->db->limit($limit, $offset)->get()->result_array();

        // Prepare Response
        $bulkData = [
            'error' => empty($cat_search_res),
            'message' => empty($cat_search_res) ? 'No serviceable pincodes found' : 'Pincodes retrieved successfully',
            'total' => $total,

            'data' => []
        ];

        foreach ($cat_search_res as $row) {
            $bulkData['data'][] = [
                'id' => output_escaping($row['id']),
                'text' => output_escaping($row['zipcode']),
                'zipcode' => output_escaping($row['zipcode']),
                'city_id' => output_escaping($row['city_id']),
                'minimum_free_delivery_order_amount' => !empty($row['minimum_free_delivery_order_amount']) ? output_escaping($row['minimum_free_delivery_order_amount']) : '',
                'delivery_charges' => !empty($row['delivery_charges']) ? output_escaping($row['delivery_charges']) : '',
            ];

            // $bulkData['data'][] = [
            //     'zipcode' => output_escaping($row['zipcode']),
            // ];
        }


        return $bulkData;
    }

    function get_area_by_city($city_id, $sort = "areas.name", $order = "ASC", $search = "", $limit = '', $offset = '')
    {
        $multipleWhere = '';
        $where = array();
        if (!empty($search)) {
            $multipleWhere = [
                '`z.zipcode`' => $search
            ];
        }
        if ($city_id != '') {
            $where['a.city_id'] = $city_id;
        }
        if ($this->db->field_exists('minimum_free_delivery_order_amount', 'zipcodes')) {

            $search_res = $this->db->select('z.zipcode,z.id as id');
            if (isset($multipleWhere) && !empty($multipleWhere)) {
                $search_res->group_start();
                $search_res->or_like($multipleWhere);
                $search_res->group_end();
            }
            $areas = $search_res->where('city_id', $city_id)->order_by($sort, $order)->limit($limit, $offset)->get('zipcodes z')->result_array();
        } else {
            $search_res = $this->db->select('z.zipcode,z.id as id')->join('zipcodes z', 'z.id=a.zipcode_id');
            if (isset($multipleWhere) && !empty($multipleWhere)) {
                $search_res->group_start();
                $search_res->or_like($multipleWhere);
                $search_res->group_end();
            }
            $areas = $search_res->where('city_id', $city_id)->order_by($sort, $order)->limit($limit, $offset)->get('areas a')->result_array();
        }

        $bulkData = array();
        $bulkData['error'] = (empty($areas)) ? true : false;
        if (!empty($areas)) {
            for ($i = 0; $i < count($areas); $i++) {
                $areas[$i] = output_escaping($areas[$i]);
            }
        }
        $bulkData['data'] = (empty($areas)) ? [] : $areas;
        return $bulkData;
    }

    function get_cities_list($search = "", $limit = 20, $offset = 0, $seller_id = '')
    {
        $where = [];
        $cities = [];
        //Fetch serviceable cities from seller_data
        if (!empty($seller_id)) {
            $seller = $this->db->select('serviceable_cities')
                ->where('user_id', $seller_id)
                ->get('seller_data')
                ->row_array();

            if (!empty($seller['serviceable_cities'])) {
                $cities = explode(',', $seller['serviceable_cities']); // Convert to array
            }
        }

        //Apply search filter
        if (!empty($search)) {
            $where['name LIKE'] = "%$search%";
        }

        //Apply cities filter (if seller has serviceable cities)
        if (!empty($cities)) {
            $this->db->where_in('id', $cities);
        }

        //Get total count
        $total = $this->db->select('COUNT(id) as total')
            ->from('cities')
            ->where($where)
            ->get()
            ->row()
            ->total;

        // Fetch cities
        $this->db->select('*')->from('cities')->where($where);
        if (!empty($cities)) {
            $this->db->where_in('id', $cities);
        }

        $cat_search_res = $this->db->limit($limit, $offset)->get()->result_array();

        $bulkData = array();
        foreach ($cat_search_res as $row) {
            $bulkData[] = [
                'id' => output_escaping($row['id']),
                'text' => output_escaping($row['name'])
            ];
        }

        return $bulkData;
    }

    function get_cities($sort = "c.name", $order = "ASC", $search = "", $limit = '', $offset = '', $seller_id = '')
    {
        $where = [];
        $cities = [];
        //Fetch serviceable cities from seller_data
        if (!empty($seller_id)) {
            $seller = $this->db->select('serviceable_cities')
                ->where('user_id', $seller_id)
                ->get('seller_data')
                ->row_array();

            if (!empty($seller['serviceable_cities'])) {
                $cities = explode(',', $seller['serviceable_cities']); // Convert to array
            }
        }

        //Apply search filter
        if (!empty($search)) {
            $where['name LIKE'] = "%$search%";
        }

        //Apply city filter (if seller has serviceable cities)
        if (!empty($cities)) {
            $this->db->where_in('id', $cities);
        }

        //Get total count
        $total = $this->db->select('COUNT(id) as total')
            ->from('cities')
            ->where($where)
            ->get()
            ->row()
            ->total;

        // Fetch cities
        $this->db->select('*')->from('cities')->where($where);
        if (!empty($cities)) {
            $this->db->where_in('id', $cities);
        }

        $cat_search_res = $this->db->limit($limit, $offset)->get()->result_array();

     

        // Prepare Response
        $bulkData = [
            'error' => empty($cat_search_res),
            'message' => empty($cat_search_res) ? 'No serviceable cities found' : 'Cities retrieved successfully',
            'total' => $total,
            'data' => []
        ];

        foreach ($cat_search_res as $row) {
            $bulkData['data'][] = [
                'id' => output_escaping($row['id']),
                'name' => output_escaping($row['name']),
                'minimum_free_delivery_order_amount' => !empty($row['minimum_free_delivery_order_amount']) ? output_escaping($row['minimum_free_delivery_order_amount']) : '',
                'delivery_charges' => !empty($row['delivery_charges']) ? output_escaping($row['delivery_charges']) : '',
            ];
        }

        return $bulkData;
    }

    function get_zipcode($search = "")
    {
        // Fetch users
        $this->db->select('*');
        $this->db->where("zipcode like '%" . $search . "%'");
        $fetched_records = $this->db->get('zipcodes');
        $zipcodes = $fetched_records->result_array();

        // Initialize Array with fetched data
        $data = array();
        foreach ($zipcodes as $zipcode) {
            $data[] = array("id" => $zipcode['id'], "text" => $zipcode['zipcode']);
        }
        return $data;
    }
    public function get_countries()
    {
        $this->load->helper('file');
        $data = file_get_contents(base_url('countries.sql'));
    }

    public function get_countries_list(
        $offset = 0,
        $limit = 10,
        $sort = 'id',
        $order = 'ASC'
    ) {
        $multipleWhere = '';

        if (isset($_GET['offset']))
            $offset = $_GET['offset'];
        if (isset($_GET['limit']))
            $limit = $_GET['limit'];

        if (isset($_GET['sort']))
            if ($_GET['sort'] == 'id') {
                $sort = "id";
            } else {
                $sort = $_GET['sort'];
            }
        if (isset($_GET['order']))
            $order = $_GET['order'];

        if (isset($_GET['search']) and $_GET['search'] != '') {
            $search = $_GET['search'];
            $multipleWhere = ['numeric_code' => $search, 'name' => $search, 'currency' => $search];
        }

        $count_res = $this->db->select(' COUNT(id) as `total` ');

        if (isset($multipleWhere) && !empty($multipleWhere)) {
            $count_res->or_like($multipleWhere);
        }
        if (isset($where) && !empty($where)) {
            $count_res->where($where);
        }

        $attr_count = $count_res->get('countries')->result_array();

        foreach ($attr_count as $row) {
            $total = $row['total'];
        }

        $search_res = $this->db->select('*');
        if (isset($multipleWhere) && !empty($multipleWhere)) {
            $search_res->or_like($multipleWhere);
        }
        if (isset($where) && !empty($where)) {
            $search_res->where($where);
        }

        $city_search_res = $search_res->order_by($sort, $order)->limit($limit, $offset)->get('countries')->result_array();
        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();
        foreach ($city_search_res as $row) {
            $row = output_escaping($row);
            $tempRow['id'] = $row['id'];
            $tempRow['numeric_code'] = $row['numeric_code'];
            $tempRow['name'] = $row['name'];
            $tempRow['capital'] = $row['capital'];
            $tempRow['phonecode'] = $row['phonecode'];
            $tempRow['currency'] = $row['currency'];
            $tempRow['currency_name'] = $row['currency_name'];
            $tempRow['currency_symbol'] = $row['currency_symbol'];
            $rows[] = $tempRow;
        }
        $bulkData['rows'] = $rows;
        print_r(json_encode($bulkData));
    }

    public function delete_zipcodes($ids)
    {
        // Example: Delete media items from database where id in $ids array
        $this->db->where_in('id', $ids);
        return $this->db->delete('zipcodes'); // Replace with your actual table name
    }

    public function get_download_zipcodes()
    {
        $zipcodes = $this->db->get('zipcodes')->result_array();
        return $zipcodes;
    }
    public function get_download_cities()
    {
        $cities = $this->db->get('cities')->result_array();
        return $cities;
    }
    public function get_download_countries()
    {
        $countries = $this->db->get('countries')->result_array();
        return $countries;
    }
}
