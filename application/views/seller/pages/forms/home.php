<div class="page-wrapper">


    <section class="custom-container">
        <div class="container-xl">
            <!-- Stats Cards Section -->

            <div class="container-fluid py-4 px-1">
                <div class="row g-3">

                    <!-- Orders Card -->
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="card card-sm h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="col-auto">
                                        <span class="bg-danger-lt avatar avatar-lg rounded-circle">
                                            <i class="ti ti-shopping-cart fs-1"></i>
                                        </span>
                                    </div>

                                    <div class="flex-grow-1">
                                        <a href="<?= base_url('seller/orders'); ?>"
                                            class="text-decoration-none text-reset">
                                            <div class="fw-medium fs-6 fs-sm-5 fs-md-5 fs-lg-6">Total Orders</div>
                                            <div class="fs-3 fs-sm-2 fs-md-2 mb-0"><?= $order_counter ?></div>
                                            <span
                                                class="text-success d-inline-flex align-items-center lh-1 fs-6 fs-sm-6">
                                                <i class="ti ti-trending-up me-1"></i>
                                                <?= $order_status_message ?? 'Performance improving' ?>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Products Card -->
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="card card-sm h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="col-auto">
                                        <span class="bg-teal-lt avatar avatar-lg rounded-circle">
                                            <i class="ti ti-package fs-1"></i>
                                        </span>
                                    </div>

                                    <div class="flex-grow-1">
                                        <a href="<?= base_url('seller/products'); ?>"
                                            class="text-decoration-none text-reset">
                                            <div class="fw-medium fs-6 fs-sm-5 fs-md-5 fs-lg-6">Products</div>
                                            <div class="fs-3 fs-sm-2 fs-md-2 mb-0"><?= $products ?></div>
                                            <span class="text-info d-inline-flex align-items-center lh-1 fs-6 fs-sm-6">
                                                <i class="ti ti-info-circle me-1"></i>
                                                <?= $product_status_message ?? 'New items added recently' ?>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Rating Card -->
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="card card-sm h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="col-auto">
                                        <span class="bg-warning-lt avatar avatar-lg rounded-circle">
                                            <i class="ti ti-star-filled fs-1"></i>
                                        </span>
                                    </div>

                                    <div class="flex-grow-1">
                                        <div class="fw-medium fs-6 fs-sm-5 fs-md-5 fs-lg-6">Rating</div>
                                        <div class="fs-3 fs-sm-2 fs-md-2 mb-0"><?= intval($ratings[0]['rating']) ?>/5
                                        </div>
                                        <span class="text-warning d-inline-flex align-items-center lh-1 fs-6 fs-sm-6">
                                            <i class="ti ti-users me-1"></i>
                                            <?= $ratings[0]['no_of_ratings'] ?> reviews
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Balance Card -->
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="card card-sm h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="col-auto">
                                        <span class="bg-success-lt avatar avatar-lg rounded-circle">
                                            <i class="ti ti-wallet fs-1"></i>
                                        </span>
                                    </div>

                                    <div class="flex-grow-1">
                                        <div class="fw-medium fs-6 fs-sm-5 fs-md-5 fs-lg-6">Balance</div>
                                        <div class="fs-3 fs-sm-2 fs-md-2 mb-0"><?= $curreny ?>
                                            <?= number_format($balance, 2) ?>
                                        </div>
                                        <span class="text-success d-inline-flex align-items-center lh-1 fs-6 fs-sm-6">
                                            <i class="ti ti-info-circle me-1"></i>
                                            <?= $balance_status_message ?? 'Available funds' ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>





            <!-- Progress Cards Section -->
            <div class="row g-3 mb-4">
                <!-- Product Stock Overview (Radial Chart) -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ti ti-chart-pie-2 me-2"></i> Product Stock Overview
                            </h3>
                        </div>
                        <div class="card-body">
                            <div id="product-status-radial" style="height: 310px;"></div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="ti ti-bolt me-2"></i> Quick Actions
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-6">
                                    <a href="<?= base_url('seller/point_of_sale'); ?>" class="text-decoration-none">
                                        <div
                                            class="btn btn-outline-primary w-100 btn-sm d-flex align-items-center justify-content-center">
                                            <i class="ti ti-plus me-1"></i> Add POS Order
                                        </div>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="<?= base_url('seller/product/create-product'); ?>"
                                        class="text-decoration-none">
                                        <div
                                            class="btn btn-outline-success w-100 btn-sm d-flex align-items-center justify-content-center">
                                            <i class="ti ti-package me-1"></i> Add Product
                                        </div>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="<?= base_url('seller/sales-inventory'); ?>" class="text-decoration-none">
                                        <div
                                            class="btn btn-outline-info w-100 btn-sm d-flex align-items-center justify-content-center">
                                            <i class="ti ti-report-analytics me-1"></i> Reports
                                        </div>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="<?= base_url('seller/payment-request/withdrawal-requests'); ?>"
                                        class="text-decoration-none">
                                        <div
                                            class="btn btn-outline-warning w-100 btn-sm d-flex align-items-center justify-content-center">
                                            <i class="ti ti-wallet me-1"></i> Withdrawal
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Cards Below Quick Actions -->
                    <div class="row g-3 mt-3">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="ti ti-info-circle me-2"></i> Return Order Status
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <!-- Status Rows -->
                                    <div class="row g-3">
                                        <!-- Return Declined -->
                                        <div class="col-sm-6 col-md-6">
                                            <div class="d-flex align-items-center p-2 border rounded">
                                                <span class="bg-red-lt text-red avatar me-3">
                                                    <i class="ti ti-circle"></i>
                                                </span>
                                                <div>
                                                    <div class="font-weight-medium">
                                                        <?= $status_counts['return_request_decline'] ?? 0 ?>
                                                    </div>
                                                    <div class="text-muted">Return Declined</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Return Pending -->
                                        <div class="col-sm-6 col-md-6">
                                            <div class="d-flex align-items-center p-2 border rounded">
                                                <span class="bg-yellow-lt text-yellow avatar me-3">
                                                    <i class="ti ti-clock"></i>
                                                </span>
                                                <div>
                                                    <div class="font-weight-medium">
                                                        <?= $status_counts['return_request_pending'] ?? 0 ?>
                                                    </div>
                                                    <div class="text-muted">Return Pending</div>
                                                </div>
                                            </div>
                                        </div>



                                        <!-- Return Picked Up -->
                                        <div class="col-sm-6 col-md-6">
                                            <div class="d-flex align-items-center p-2 border rounded">
                                                <span class="bg-blue-lt text-blue avatar me-3">
                                                    <i class="ti ti-truck-delivery"></i>
                                                </span>
                                                <div>
                                                    <div class="font-weight-medium">
                                                        <?= $status_counts['return_pickedup'] ?? 0 ?>
                                                    </div>
                                                    <div class="text-muted">Return Picked Up</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Return Approved -->
                                        <div class="col-sm-6 col-md-6">
                                            <div class="d-flex align-items-center p-2 border rounded">
                                                <span class="bg-green-lt text-green avatar me-3">
                                                    <i class="ti ti-check"></i>
                                                </span>
                                                <div>
                                                    <div class="font-weight-medium">
                                                        <?= $status_counts['return_request_approved'] ?? 0 ?>
                                                    </div>
                                                    <div class="text-muted">Return Approved</div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- End Status Rows -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- End Status Cards -->
                </div>
            </div>

            <!-- Charts Section -->
<div class="row mb-4">

    <!-- Sales Summary -->
    <div class="col-12 col-lg-6 mb-4 mb-lg-0">
        <div class="card shadow-sm border-0 rounded-3 h-100">
            <div class="card-header d-flex justify-content-between align-items-center py-3 px-4 border-bottom-0">
                <h5 class="card-title fw-bold mb-0 d-flex align-items-center text-primary">
                    <i class="ti ti-chart-bar me-2"></i>
                    Sales Summary
                </h5>
                <ul class="nav nav-pills nav-pills-sm sales-tab ms-auto" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active px-3 py-2" data-bs-toggle="pill" href="#Monthly">Month</a>
                    </li>
                    <li class="nav-item ms-2">
                        <a class="nav-link px-3 py-2" data-bs-toggle="pill" href="#Weekly">Week</a>
                    </li>
                    <li class="nav-item ms-2">
                        <a class="nav-link px-3 py-2" data-bs-toggle="pill" href="#Daily">Day</a>
                    </li>
                </ul>
            </div>

            <div class="card-body p-4 d-flex align-items-center justify-content-center" style="min-height: 350px;">
                <div id="Chart" class="w-100"></div>
            </div>
        </div>
    </div>

    <!-- Top Selling Products -->
    <div class="col-12 col-lg-6">
        <div class="card shadow-sm border-0 rounded-3 h-100">
            <div class="card-header d-flex justify-content-between align-items-center py-3 px-4 border-bottom-0">
                <h5 class="card-title fw-bold mb-0 d-flex align-items-center text-primary">
                    <i class="ti ti-chart-pie me-2"></i>
                    Top Selling Products
                </h5>
            </div>

            <div class="card-body p-4 d-flex align-items-center justify-content-center" style="min-height: 350px;">
                <div id="piechart_3d" class="w-100"></div>
            </div>
        </div>
    </div>

</div>




            <!-- Alerts Section -->
            <div class="row g-4 mb-4">

                <!-- Sold Out Alert -->
                <div class="col-12 col-md-6">
                    <div class="alert alert-warning alert-dismissible fade show h-100 d-flex flex-column justify-content-between"
                        role="alert">
                        <div class="d-flex gap-3">
                            <i class="ti ti-alert-triangle flex-shrink-0" style="font-size: 1.8rem"></i>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold text-danger mb-1"><?= $count_products_availability_status ?>
                                    Product(s) Sold Out</h6>
                                <p class="mb-2">Immediate restocking required to avoid sales loss.</p>
                                <a href="<?= base_url('seller/product/?flag=sold') ?>" class="text-danger fw-medium">
                                    View details <i class="ti ti-arrow-narrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>

                <!-- Low Stock Alert -->
                <div class="col-12 col-md-6">
                    <div class="alert alert-info alert-dismissible fade show h-100 d-flex flex-column justify-content-between"
                        role="alert">
                        <div class="d-flex gap-3">
                            <i class="ti ti-info-circle flex-shrink-0" style="font-size: 1.8rem"></i>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold text-info mb-1"><?= $count_products_low_status ?> Product(s) Low in
                                    Stock</h6>
                                <p class="mb-2">Below limit of
                                    <?= isset($settings['low_stock_limit']) ? $settings['low_stock_limit'] : '5' ?>
                                    items.
                                </p>
                                <a href="<?= base_url('seller/product/?flag=low') ?>" class="text-info fw-medium">
                                    View details <i class="ti ti-arrow-narrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>

            </div>




            <!-- Order Status Overview -->
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title d-flex align-items-center fs-5 fs-md-4">
                        <i class="ti ti-list-details me-2"></i>
                        Order Status Overview
                    </h3>
                </div>

                <div class="card-body">
                    <div class="row g-3">

                        <!-- Received -->
                        <div class="col-6 col-md-4 col-lg-2">
                            <div class="card card-sm h-100">
                                <div class="card-body d-flex align-items-center gap-3 flex-wrap">
                                    <span class="avatar bg-blue-lt text-blue flex-shrink-0">
                                        <i class="ti ti-download"></i>
                                    </span>
                                    <div class="flex-fill">
                                        <div class="fw-bold fs-4 fs-md-3 text-break"><?= $status_counts['received'] ?>
                                        </div>
                                        <div class="text-muted fs-6">Received</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Processed -->
                        <div class="col-6 col-md-4 col-lg-2">
                            <div class="card card-sm h-100">
                                <div class="card-body d-flex align-items-center gap-3 flex-wrap">
                                    <span class="avatar bg-cyan-lt text-cyan flex-shrink-0">
                                        <i class="ti ti-progress-check"></i>
                                    </span>
                                    <div class="flex-fill">
                                        <div class="fw-bold fs-4 fs-md-3 text-break"><?= $status_counts['processed'] ?>
                                        </div>
                                        <div class="text-muted fs-6">Processed</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Shipped -->
                        <div class="col-6 col-md-4 col-lg-2">
                            <div class="card card-sm h-100">
                                <div class="card-body d-flex align-items-center gap-3 flex-wrap">
                                    <span class="avatar bg-purple-lt text-purple flex-shrink-0">
                                        <i class="ti ti-truck"></i>
                                    </span>
                                    <div class="flex-fill">
                                        <div class="fw-bold fs-4 fs-md-3 text-break"><?= $status_counts['shipped'] ?>
                                        </div>
                                        <div class="text-muted fs-6">Shipped</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Delivered -->
                        <div class="col-6 col-md-4 col-lg-2">
                            <div class="card card-sm h-100">
                                <div class="card-body d-flex align-items-center gap-3 flex-wrap">
                                    <span class="avatar bg-green-lt text-green flex-shrink-0">
                                        <i class="ti ti-checks"></i>
                                    </span>
                                    <div class="flex-fill">
                                        <div class="fw-bold fs-4 fs-md-3 text-break"><?= $status_counts['delivered'] ?>
                                        </div>
                                        <div class="text-muted fs-6">Delivered</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cancelled -->
                        <div class="col-6 col-md-4 col-lg-2">
                            <div class="card card-sm h-100">
                                <div class="card-body d-flex align-items-center gap-3 flex-wrap">
                                    <span class="avatar bg-red-lt text-red flex-shrink-0">
                                        <i class="ti ti-ban"></i>
                                    </span>
                                    <div class="flex-fill">
                                        <div class="fw-bold fs-4 fs-md-3 text-break"><?= $status_counts['cancelled'] ?>
                                        </div>
                                        <div class="text-muted fs-6">Cancelled</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Returned -->
                        <div class="col-6 col-md-4 col-lg-2">
                            <div class="card card-sm h-100">
                                <div class="card-body d-flex align-items-center gap-3 flex-wrap">
                                    <span class="avatar bg-orange-lt text-orange flex-shrink-0">
                                        <i class="ti ti-arrow-back-up"></i>
                                    </span>
                                    <div class="flex-fill">
                                        <div class="fw-bold fs-4 fs-md-3 text-break"><?= $status_counts['returned'] ?>
                                        </div>
                                        <div class="text-muted fs-6">Returned</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Order Items Table Section -->
            <div class="row g-4 mb-5">
                <div class="col-12">
                    <div class="card content-area p-4">
                        <div class="card-inner">
                            <div class="row g-3 align-items-end">

                                <!-- Date Range -->
                                <div class="col-12 col-md-6 col-lg-3">
                                    <label class="form-label" for="datepicker">Date and Time Range</label>
                                    <div class="input-icon">
                                        <input type="text" class="form-control" id="datepicker" autocomplete="off" />
                                        <input type="hidden" id="start_date" class="form-control">
                                        <input type="hidden" id="end_date" class="form-control">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-clock"></i>
                                        </span>
                                    </div>
                                </div>

                                <!-- Filter By Status -->
                                <div class="col-12 col-md-6 col-lg-3" x-data
                                    x-init="initTomSelect({element: $refs.orderStatus, placeholder: 'Select Status', maxItems: 1, preloadOptions: true})">
                                    <label class="form-label" for="order_status">Filter By Status</label>
                                    <select id="order_status" name="order_status" x-ref="orderStatus"
                                        class="form-control">
                                        <option value="">All Orders</option>
                                        <option value="received">Received</option>
                                        <option value="processed">Processed</option>
                                        <option value="shipped">Shipped</option>
                                        <option value="delivered">Delivered</option>
                                        <option value="cancelled">Cancelled</option>
                                        <option value="returned">Returned</option>
                                    </select>
                                </div>

                                <!-- Filter by Payment Method -->
                                <div class="col-12 col-md-6 col-lg-3" x-data
                                    x-init="initTomSelect({element: $refs.paymentMethod, placeholder: 'Select Payment Method', maxItems: 1, preloadOptions: true})">
                                    <label class="form-label" for="payment_method">Filter By Payment Method</label>
                                    <select id="payment_method" name="payment_method" x-ref="paymentMethod"
                                        class="form-control">
                                        <option value="">All Payment Methods</option>
                                        <option value="COD">Cash On Delivery</option>
                                        <option value="Paypal">Paypal</option>
                                        <option value="RazorPay">RazorPay</option>
                                        <option value="Paystack">Paystack</option>
                                        <option value="Flutterwave">Flutterwave</option>
                                        <option value="Paytm">Paytm</option>
                                        <option value="Stripe">Stripe</option>
                                        <option value="bank_transfer">Direct Bank Transfer</option>
                                    </select>
                                </div>

                                <!-- Buttons -->
                                <div class="col-12 col-md-6 col-lg-3 d-flex gap-2">
                                    <button type="button" class="btn btn-secondary w-50" onclick="resetfilters()">
                                        <i class="ti ti-refresh"></i> Clear
                                    </button>
                                    <button type="button" class="btn btn-primary w-50"
                                        onclick="status_date_wise_search()">
                                        <i class="ti ti-search"></i> Filter
                                    </button>
                                </div>

                            </div>


                            <!-- Table Container with proper overflow handling -->
                            <div class="table-container-wrapper overflow-hidden">
                                <table id="order-items-table" class="table table-striped table-bordered table-hover"
                                    data-toggle="table" data-url="<?= base_url('seller/orders/view_order_items') ?>"
                                    data-side-pagination="server" data-pagination="true"
                                    data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-sort-name="o.id"
                                    data-sort-order="desc" data-query-params="orders_query_params"
                                    data-pagination-h-align="right" data-pagination-detail-h-align="left">
                                    <thead>
                                        <tr>
                                            <th data-field="id" data-sortable='true'
                                                data-footer-formatter="totalFormatter">ID</th>
                                            <th data-field="order_item_id" data-sortable='true'>Order Item ID</th>
                                            <th data-field="order_id" data-sortable='true'>Order ID</th>
                                            <th data-field="user_id" data-sortable='true' data-visible="false">User ID
                                            </th>
                                            <th data-field="seller_id" data-sortable='true' data-visible="false">Seller
                                                ID</th>
                                            <th data-field="is_credited" data-sortable='true' data-visible="false">
                                                Commission</th>
                                            <th data-field="quantity" data-sortable='true' data-visible="false">Quantity
                                            </th>
                                            <th data-field="username" data-sortable='true'>User Name</th>
                                            <!-- <th data-field="seller_name" data-sortable='true'>Seller Name</th> -->
                                            <th data-field="product_name" data-sortable='true'>Product Name</th>
                                            <th data-field="mobile" data-sortable='true'>Mobile</th>
                                            <th data-field="sub_total" data-sortable='true' data-visible="true">
                                                Total(<?= $curreny ?>)</th>
                                            <th data-field="payment_method" data-sortable='true' data-visible='true'>
                                                Payment Method</th>
                                            <th data-field="delivery_boy" data-sortable='true' data-visible='false'>
                                                Deliver By</th>
                                            <th data-field="delivery_boy_id" data-sortable='true' data-visible='false'>
                                                Delivery Boy Id</th>
                                            <th data-field="product_variant_id" data-sortable='true'
                                                data-visible='false'>Product Variant Id</th>
                                            <th data-field="delivery_date" data-sortable='true' data-visible='false'>
                                                Delivery Date</th>
                                            <th data-field="delivery_time" data-sortable='true' data-visible='false'>
                                                Delivery Time</th>
                                            <th data-field="status" data-sortable='true' data-visible='false'>Status
                                            </th>
                                            <th data-field="active_status" data-sortable='true' data-visible='true'>
                                                Active Status</th>
                                            <th data-field="date_added" data-sortable='true'>Order Date</th>
                                            <th data-field="operate" data-sortable="false">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


</div>





<script>
document.addEventListener("DOMContentLoaded", function () {
    const sold_out = parseInt("<?= $count_products_availability_status ?? 0 ?>") || 0;
    const low_stock = parseInt("<?= $count_products_low_status ?? 0 ?>") || 0;
    const in_stock = parseInt("<?= $products - ($count_products_availability_status + $count_products_low_status) ?>") || 0;

    const total = sold_out + low_stock + in_stock;

    const series = total > 0 ? [
        Math.round((sold_out / total) * 100),
        Math.round((low_stock / total) * 100),
        Math.round((in_stock / total) * 100)
    ] : [0, 0, 0];

    const options = {
        series: series,
        chart: {
            type: 'radialBar',
            height: 350,
            toolbar: { show: false }
        },
        plotOptions: {
            radialBar: {
                dataLabels: {
                    name: { fontSize: '16px', color: '#333' },
                    value: { fontSize: '20px', fontWeight: '600', formatter: val => val + "%" },
                    total: {
                        show: true,
                        label: 'Total Products',
                        formatter: () => total
                    }
                },
                hollow: { size: '35%' },
            }
        },
        labels: ['Sold Out', 'Low Stock', 'In Stock'],
        colors: ['#FF4B5C', '#FFC107', '#007BFF'],
        legend: {
            show: true,
            position: 'bottom'
        },
    };

    const chart = new ApexCharts(document.querySelector("#product-status-radial"), options);
    chart.render();
});
</script>
