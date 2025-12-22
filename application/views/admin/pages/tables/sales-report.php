<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">View Sale Reports</h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="d-flex">
                            <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/home') ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="javascript:void(0)">Reports</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">Sales Reports</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE HEADER -->

        <div class="page-body">
            <div class="container-xl">
                <div class="col-12">
                    <div class="card">
                        <div
                            class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                            <!-- Card Title -->
                            <h3 class="card-title mb-2 mb-md-0">
                                <i class="ti ti-world me-1"></i> Sale Report Details
                            </h3>

                            <!-- Total Order Value -->
                            <h3 class="fw-bold text-primary">
                                <i class="ti ti-coins me-1"></i> Total Order Value:
                                <span id="total-order-sum"
                                    class="text-dark"><?= isset($currency) ? $currency : '$' ?></span>
                            </h3>
                        </div>

                        <div class="card-body">
                            <div id="filterTemplate" class="row g-3 align-items-end">
                                <!-- Filter 1: Date Range -->
                                <div class="col-12 col-sm-6 col-md-6 col-lg-2">
                                    <label class="form-label" for="datepicker">Date and time range:</label>
                                    <div class="input-icon">
                                        <input type="text" class="form-control" id="datepicker" autocomplete="off" />
                                        <input type="hidden" id="start_date">
                                        <input type="hidden" id="end_date">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-clock"></i>
                                        </span>
                                    </div>
                                </div>

                                <!-- Filter 2: Payment Method -->
                                <div class="col-12 col-sm-6 col-md-6 col-lg-2">
                                    <label class="form-label" for="payment_method_filter">Payment Method</label>
                                    <select id="payment_method_filter" class="form-select">
                                        <option value="">All Methods</option>
                                        <option value="COD">Cash On Delivery</option>
                                        <option value="Paypal">Paypal</option>
                                        <option value="RazorPay">RazorPay</option>
                                        <option value="Paystack">Paystack</option>
                                        <option value="Flutterwave">Flutterwave</option>
                                        <option value="Paytm">Paytm</option>
                                        <option value="Stripe">Stripe</option>
                                        <option value="bank_transfer">Bank Transfer</option>
                                        <option value="midtrans">Midtrans</option>
                                        <option value="my_fatoorah">My Fatoorah</option>
                                        <option value="instamojo">Instamojo</option>
                                        <option value="phonepe">PhonePe</option>
                                        <option value="wallet">Wallet</option>
                                    </select>
                                </div>

                                <!-- Filter 3: Status -->
                                <div class="col-12 col-sm-6 col-md-6 col-lg-2">
                                    <label class="form-label" for="order_status_filter">Status</label>
                                    <select id="order_status_filter" class="form-select">
                                        <option value="">All</option>
                                        <?php
                                        $preferred_order = [
                                            'awaiting' => 'Awaiting',
                                            'received' => 'Received',
                                            'processed' => 'Processed',
                                            'shipped' => 'Shipped',
                                            'delivered' => 'Delivered',
                                            'cancelled' => 'Cancelled',
                                            'returned' => 'Returned',
                                            'return_request_pending' => 'Return Request Pending',
                                            'return_request_approved' => 'Return Request Approved',
                                            'return_request_decline' => 'Return Request Declined'
                                        ];
                                        $this->db->select('active_status')->from('order_items')->distinct();
                                        $db_statuses = $this->db->get()->result_array();
                                        $db_status_values = array_column($db_statuses, 'active_status');

                                        foreach ($preferred_order as $value => $label) {
                                            if (in_array($value, $db_status_values)) {
                                                echo '<option value="' . htmlspecialchars($value) . '">' . htmlspecialchars($label) . '</option>';
                                            }
                                        }

                                        $other_statuses = array_diff($db_status_values, array_keys($preferred_order));
                                        sort($other_statuses);
                                        foreach ($other_statuses as $status_value) {
                                            $status_label = ucfirst(str_replace('_', ' ', $status_value));
                                            echo '<option value="' . htmlspecialchars($status_value) . '">' . htmlspecialchars($status_label) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- Filter 4: Seller -->
                                <div class="col-12 col-sm-6 col-md-6 col-lg-2">
                                    <div x-data x-init="initTomSelect({
            element: $refs.sellerSelect,
            url: '<?= base_url('admin/product/get_sellers_data') ?>',
            placeholder: 'Search Seller...',
            offcanvasId: 'filterOffcanvas',
            maxItems: 1,
            preloadOptions: true
        })">
                                        <label class="form-label" for="seller_filter">Seller</label>
                                        <select x-ref="sellerSelect" class="form-select" name="seller_id"
                                            id="seller_filter"></select>
                                    </div>
                                </div>

                                <!-- Button 1: Filter -->
                                <div class="col-12 col-sm-6 col-md-6 col-lg-2 d-grid">
                                    <button type="button" class="btn btn-primary me-2"
                                        onclick="status_date_wise_search()"><i class="ti ti-search"></i>Filter</button>
                                </div>

                                <!-- Button 2: Reset -->
                                <div class="col-12 col-sm-6 col-md-6 col-lg-2 d-grid">
                                    <button type="button" class="btn btn-outline-secondary " onclick="resetfilters()">
                                        <i class="ti ti-refresh"></i> Reset
                                    </button>
                                </div>
                            </div>





                            <table id="sales-report-table" class="table table-striped" data-detail-view="true"
                                data-detail-formatter="salesReport" data-auto-refresh="true" data-toggle="table"
                                data-url="<?= base_url('admin/Sales_report/get_sales_report_list') ?>"
                                data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 25, 50, 100, 200]" data-search="true"
                                data-trim-on-search="false" data-show-columns="true" data-show-refresh="true"
                                data-mobile-responsive="true" data-sort-name="id" data-sort-order="DESC" data-toolbar=""
                                data-show-export="true" data-maintain-selected="true"
                                data-query-params="sales_report_query_params" data-export-types='["txt","excel"]'
                                data-export-options='{
                                       "fileName": "Admin-sale-list",
                                       "ignoreColumn": ["operate"]
                                   }'>
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true">Item ID</th>
                                        <th data-field="product name" data-sortable="true">Product name</th>
                                        <th data-field="final total" data-sortable="true">Final Total (<?= $currency ?>)
                                        </th>
                                        <th data-field="payment method" data-sortable="true">Payment Method</th>
                                        <th data-field="store name" data-sortable="true">Store Name</th>
                                        <th data-field="seller name" data-sortable="true">Sales Representative</th>
                                        <th data-field="date added" data-sortable="true"> Order Date </th>
                                        <th data-field="active status" data-sortable="true">Order Status</th>

                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>