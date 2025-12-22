<div class="page-wrapper">

    <div class="page">
        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">Order Management</h2>
                        <div class="text-muted mt-1">Manage and track all orders efficiently</div>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="d-flex">
                            <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/home') ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">Orders</a>
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
                <!-- Order Statistics Cards -->
                <div class="row row-deck row-cards mb-4">
                    <div class="col-sm-6 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="subheader">Awaiting</div>
                                </div>
                                <div class="h1 mb-3"><?= $status_counts['awaiting'] ?></div>
                                <div class="d-flex mb-2">
                                    <div>Pending orders</div>
                                    <div class="ms-auto">
                                        <span class="text-green d-inline-flex align-items-center lh-1">
                                            <i class="ti ti-clock fs-1"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="subheader">Received</div>
                                </div>
                                <div class="h1 mb-3"><?= $status_counts['received'] ?></div>
                                <div class="d-flex mb-2">
                                    <div>Confirmed orders</div>
                                    <div class="ms-auto">
                                        <span class="text-blue d-inline-flex align-items-center lh-1">
                                            <i class="ti ti-check fs-1"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="subheader">Processed</div>
                                </div>
                                <div class="h1 mb-3"><?= $status_counts['processed'] ?></div>
                                <div class="d-flex mb-2">
                                    <div>In preparation</div>
                                    <div class="ms-auto">
                                        <span class="text-orange d-inline-flex align-items-center lh-1">
                                            <i class="ti ti-settings fs-1"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="subheader">Shipped</div>
                                </div>
                                <div class="h1 mb-3"><?= $status_counts['shipped'] ?></div>
                                <div class="d-flex mb-2">
                                    <div>In transit</div>
                                    <div class="ms-auto">
                                        <span class="text-yellow d-inline-flex align-items-center lh-1">
                                            <i class="ti ti-truck fs-1"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Status Cards -->
                <div class="row row-deck row-cards mb-4">
                    <div class="col-sm-6 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="subheader">Delivered</div>
                                </div>
                                <div class="h1 mb-3"><?= $status_counts['delivered'] ?></div>
                                <div class="d-flex mb-2">
                                    <div>Completed orders</div>
                                    <div class="ms-auto">
                                        <span class="text-green d-inline-flex align-items-center lh-1">
                                            <i class="ti ti-circle-check fs-1"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="subheader">Cancelled</div>
                                </div>
                                <div class="h1 mb-3"><?= $status_counts['cancelled'] ?></div>
                                <div class="d-flex mb-2">
                                    <div>Cancelled orders</div>
                                    <div class="ms-auto">
                                        <span class="text-red d-inline-flex align-items-center lh-1">
                                            <i class="ti ti-xbox-x fs-1"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="subheader">Returned</div>
                                </div>
                                <div class="h1 mb-3"><?= $status_counts['returned'] ?></div>
                                <div class="d-flex mb-2">
                                    <div>Returned orders</div>
                                    <div class="ms-auto">
                                        <span class="text-purple d-inline-flex align-items-center lh-1">
                                            <i class="ti ti-arrow-back-up fs-1"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="subheader">Total Orders</div>
                                </div>
                                <div class="h1 mb-3"><?= array_sum($status_counts) ?></div>
                                <div class="d-flex mb-2">
                                    <div>All time</div>
                                    <div class="ms-auto">
                                        <span class="text-muted d-inline-flex align-items-center lh-1">
                                            <i class="ti ti-chart-line fs-1"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Filters and Search Section -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Filters & Search</h3>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 align-items-end">
                            <!-- Date Range -->
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                <label for="datepicker" class="form-label">Date and Time Range</label>
                                <div class="input-icon">
                                    <input type="text" class="form-control" id="datepicker" autocomplete="off" />
                                    <input type="hidden" id="start_date">
                                    <input type="hidden" id="end_date">
                                    <span class="input-icon-addon"><i class="ti ti-clock"></i></span>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                <label for="order_status" class="form-label">Status</label>
                                <select id="order_status" name="order_status" class="form-select">
                                    <option value="">All Orders</option>
                                    <option value="awaiting">Awaiting</option>
                                    <option value="received">Received</option>
                                    <option value="processed">Processed</option>
                                    <option value="shipped">Shipped</option>
                                    <option value="delivered">Delivered</option>
                                    <option value="return_request_pending">Return Request Pending</option>
                                    <option value="return_request_approved">Return Request Approved</option>
                                    <option value="return_picked_up">Return Picked Up</option>
                                    <option value="cancelled">Cancelled</option>
                                    <option value="returned">Returned</option>
                                </select>
                            </div>

                            <!-- Payment Method -->
                            <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                                <label for="payment_method" class="form-label">Payment Method</label>
                                <select id="payment_method" name="payment_method" class="form-select">
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
                                </select>
                            </div>

                            <!-- Order Type -->
                            <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                                <label for="order_type" class="form-label">Order Type</label>
                                <select id="order_type" name="order_type" class="form-select">
                                    <option value="">All Orders</option>
                                    <option value="physical_order">Physical Orders</option>
                                    <option value="digital_order">Digital Orders</option>
                                </select>
                            </div>

                            <!-- Seller -->
                            <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                                <label for="seller_filter" class="form-label">Seller</label>
                                <div x-data x-init="initTomSelect({
                element: $refs.sellerSelect,
                url: '<?= base_url('admin/product/get_sellers_data') ?>',
                placeholder: 'Search Seller...',
                offcanvasId: 'filterOffcanvas',
                maxItems: 1,
                preloadOptions: true
            })">
                                    <select x-ref="sellerSelect" class="form-select" name="seller_id"
                                        id="seller_id"></select>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="col-12 col-sm-6 col-md-4 col-lg-2 d-flex gap-2 align-items-end">
                                <button type="button" class="btn btn-primary w-50" onclick="status_date_wise_search()">
                                    <i class="ti ti-search"></i> Filter
                                </button>
                                <button type="button" class="btn btn-outline-secondary w-50" onclick="resetfilters()">
                                    <i class="ti ti-refresh"></i> Reset
                                </button>
                            </div>
                        </div>


                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="btn-list">
                            <a href="javascript:void(0)" class="btn btn-primary add_promo_code_discount"
                                title="Settle Promo Code Discount">
                                <i class="ti ti-discount"></i> Settle Promo Code Discount
                            </a>
                            <a href="javascript:void(0)" class="btn btn-info settle_referal_cashback_discount"
                                title="Settle User Cashback Discount">
                                <i class="ti ti-coin"></i> Settle User Cashback
                            </a>
                            <a href="javascript:void(0)"
                                class="btn btn-secondary settle_referal_cashback_discount_for_referal"
                                title="Settle Referral Cashback Discount">
                                <i class="ti ti-users"></i> Settle Referral Cashback
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Orders Table -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Orders List</h3>

                    </div>
                    <div class="card-body">
                        <table class="table-striped" data-toggle="table" id="orders_table"
                            data-url="<?= base_url('admin/orders/view_orders') ?>" data-click-to-select="true"
                            data-side-pagination="server" data-pagination="true"
                            data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                            data-show-refresh="true" data-trim-on-search="false" data-sort-name="o.id"
                            data-sort-order="desc" data-mobile-responsive="true" data-toolbar="" data-show-export="true"
                            data-maintain-selected="true" data-export-types='["txt","excel","csv"]'
                            data-export-options='{"fileName": "orders-list","ignoreColumn": ["state"] }'
                            data-query-params="orders_query_params">
                            <thead>
                                <tr>
                                    <th data-field="id" data-sortable='true' data-footer-formatter="totalFormatter">
                                        Order ID</th>
                                    <th data-field="user_id" data-sortable='true' data-visible="false">User ID</th>
                                    <th data-field="qty" data-sortable='true' data-visible="false">Qty</th>
                                    <th data-field="name" data-sortable='true'>Customer</th>
                                    <th data-field="sellers" data-sortable='false'>Sellers</th>
                                    <th data-field="mobile" data-sortable='true' data-visible='false'>Mobile</th>
                                    <th data-field="notes" data-sortable='false' data-visible='false'>Notes</th>
                                    <th data-field="items" data-sortable='true' data-visible="true"
                                        data-formatter="itemsReadMoreFormatter">Items</th>
                                    <th data-field="total" data-sortable='true' data-visible="true">
                                        Total(
                                        <?= $curreny ?>)
                                    </th>
                                    <th data-field="delivery_charge" data-sortable='true'
                                        data-footer-formatter="delivery_chargeFormatter" data-visible="false">Delivery
                                    </th>
                                    <th data-field="wallet_balance" data-sortable='true' data-visible="false">
                                        Wallet(
                                        <?= $curreny ?>)
                                    </th>
                                    <th data-field="promo_code" data-sortable='true' data-visible="false">Promo Code
                                    </th>
                                    <th data-field="promo_discount" data-sortable='true' data-visible="false">
                                        Promo(
                                        <?= $curreny ?>)
                                    </th>
                                    <th data-field="final_total" data-sortable='true'>Final Total(
                                        <?= $curreny ?>)
                                    </th>
                                    <th data-field="payment_method" data-sortable='true' data-visible="true">Payment
                                    </th>
                                    <th data-field="address" data-sortable='true' data-visible='false'>Address</th>
                                    <th data-field="delivery_date" data-sortable='true' data-visible='false'>
                                        Delivery Date</th>
                                    <th data-field="delivery_time" data-sortable='true' data-visible='false'>
                                        Delivery Time</th>
                                    <th data-field="date_added" data-sortable='true'>Order Date</th>
                                    <th data-field="operate" data-sortable="false">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <!-- Digital Order Mails Modal -->
                <div id="digital-order-mails" class="modal fade" tabindex="-1" role="dialog"
                    aria-labelledby="digitalOrderMailsLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="digitalOrderMailsLabel">Digital Order Mails</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="order_id" id="order_id">
                                <input type="hidden" name="order_item_id" id="order_item_id">
                                <div class="table-responsive">
                                    <table class="table table-vcenter card-table" id="digital_order_mail_table"
                                        data-toggle="table"
                                        data-url="<?= base_url('admin/orders/get-digital-order-mails') ?>"
                                        data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                                        data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true"
                                        data-show-columns="true" data-show-refresh="true" data-trim-on-search="false"
                                        data-sort-name="id" data-sort-order="desc" data-mobile-responsive="true"
                                        data-toolbar="" data-show-export="true" data-maintain-selected="true"
                                        data-query-params="digital_order_mails_query_params">
                                        <thead>
                                            <tr>
                                                <th data-field="id" data-sortable="true">ID</th>
                                                <th data-field="order_id" data-sortable="true">Order ID</th>
                                                <th data-field="order_item_id" data-sortable="false">Order Item ID</th>
                                                <th data-field="subject" data-sortable="false">Subject</th>
                                                <th data-field="message" data-sortable="false" data-visible="false">
                                                    Message</th>
                                                <th data-field="file_url" data-sortable="false">URL</th>
                                                <th data-field="date_added" data-sortable="false" data-visible="false">
                                                    Date</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Send Mail Modal for Digital Orders -->
                <div id="ManageOrderSendMailModal" class="modal fade editSendMail" tabindex="-1" role="dialog"
                    aria-labelledby="sendMailLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="sendMailLabel">Manage Digital Product</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal form-submit-event"
                                    action="<?= base_url('admin/orders/send_digital_product'); ?>" method="POST"
                                    enctype="multipart/form-data">
                                    <input type="hidden" name="order_id"
                                        value="<?= isset($order_item_data[0]['order_id']) ? $order_item_data[0]['order_id'] : '' ?>">
                                    <input type="hidden" name="order_item_id"
                                        value="<?= $this->input->get('edit_id') ?>">
                                    <input type="hidden" name="username"
                                        value="<?= isset($user_data['username']) ? $user_data['username'] : '' ?>">

                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label for="email" class="col-form-label">Customer Email</label>
                                            <input type="text" class="form-control ManageOrderEmail" id="email"
                                                name="email" value="" readonly>
                                        </div>
                                        <div class="col-12"> <label for="subject" class="col-form-label">Subject</label>
                                            <input type="text" class="form-control" id="subject"
                                                placeholder="Enter Subject for email" name="subject" value="">
                                        </div>
                                        <div class="col-12">
                                            <label for="message" class="col-form-label">Message</label>
                                            <textarea class="form-control" id="message" placeholder="Message for Email"
                                                name="message" rows="4"></textarea>
                                        </div>
                                        <div class="col-12" id="digital_media_container">
                                            <label for="image" class="col-form-label">File <span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <a class="btn btn-primary uploadFile img" data-input='pro_input_file'
                                                    data-isremovable='1' data-media_type='archive,document'
                                                    data-is-multiple-uploads-allowed='0' data-toggle="modal"
                                                    data-target="#media-upload-modal">
                                                    <i class="ti ti-upload"></i> Upload File
                                                </a>
                                            </div>
                                            <div class="container-fluid row image-upload-section mt-2">
                                                <div
                                                    class="col-md-6 col-12 shadow p-3 mb-3 rounded text-center grow image d-none">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-success" id="submit_btn">
                                            <i class="ti ti-send"></i> Send Mail
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Tracking Modal -->
                <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="transaction_modal"
                    data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="user_name">Order Tracking</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form x-data="ajaxForm({
        url: base_url + 'admin/orders/update-order-tracking',
        modalId: 'transaction_modal',
        loaderText: 'Saving...'
    })" method="POST" class="form-horizontal" id="order_tracking_form" enctype="multipart/form-data">
                                    <input type="hidden" name="order_id" id="order_id">
                                    <input type="hidden" name="order_item_id" id="order_item_id">
                                    <input type="hidden" name="seller_id" id="seller_id">

                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label for="courier_agency" class="col-form-label">Courier Agency</label>
                                            <input type="text" class="form-control" name="courier_agency"
                                                id="courier_agency" placeholder="Enter courier agency name" />
                                        </div>
                                        <div class="col-12">
                                            <label for="tracking_id" class="col-form-label">Tracking ID</label>
                                            <input type="text" class="form-control" name="tracking_id" id="tracking_id"
                                                placeholder="Enter tracking ID" />
                                        </div>
                                        <div class="col-12">
                                            <label for="url" class="col-form-label">Tracking URL</label>
                                            <input type="url" class="form-control" name="url" id="url"
                                                placeholder="Enter tracking URL" />
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="reset" class="btn btn-warning">
                                            <i class="ti ti-refresh"></i> Reset
                                        </button>
                                        <button type="submit" class="btn btn-success" id="submit_btn">
                                            <i class="ti ti-check"></i> Save
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- View Order Tracking Offcanvas -->
                <div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="order-tracking-offcanvas"
                    aria-labelledby="orderTrackingOffcanvasLabel">
                    <div class="offcanvas-header">
                        <h2 class="offcanvas-title" id="orderTrackingOffcanvasLabel">
                            <i class="ti ti-package me-2"></i>Order Tracking
                        </h2>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <input type="hidden" name="view_order_id" id="view_order_id">

                        <!-- Loading State -->
                        <div id="tracking-loading" class="text-center py-5" style="display: none;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2 text-muted">Loading tracking information...</p>
                        </div>

                        <!-- Empty State -->
                        <div id="tracking-empty" class="text-center py-5" style="display: none;">
                            <i class="ti ti-package-off display-1 text-muted"></i>
                            <h3 class="mt-3">No Tracking Information</h3>
                            <p class="text-muted">No tracking data available for this order.</p>
                        </div>

                        <!-- Tracking Cards Container -->
                        <div id="tracking-cards-container" class="row g-3">
                            <!-- Cards will be dynamically inserted here -->
                        </div>
                    </div>
                </div>

                <!-- Hidden inputs -->
                <input type='hidden' id='order_user_id'
                    value='<?= (isset($_GET['user_id']) && !empty($_GET['user_id'])) ? $_GET['user_id'] : '' ?>'>
                <input type='hidden' id='order_seller_id'
                    value='<?= (isset($_GET['seller_id']) && !empty($_GET['seller_id'])) ? $_GET['seller_id'] : '' ?>'>

            </div>
        </div>
    </div>
</div>