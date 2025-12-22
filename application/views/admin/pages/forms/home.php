<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        Overview
                    </div>
                    <h2 class="page-title">
                        Dashboard
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <span class="d-none d-sm-inline">
                            <a href="<?= base_url('admin/orders') ?>" class="btn btn-white">
                                <i class="ti ti-eye me-2"></i>
                                View Orders
                            </a>
                        </span>
                        <a href="<?= base_url('admin/product') ?>" class="btn btn-primary">
                            <i class="ti ti-eye me-2"></i>
                            View Products
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <!-- Stats Cards Row -->
            <div class="row row-deck row-cards mb-4">
                <?php if (has_permissions('read', 'orders')) { ?>
                    <div class="col-sm-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="subheader">Orders</div>
                                    <div class="ms-auto lh-1">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle text-secondary" href="#" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">Last 7 days</a>
                                            <div class="dropdown-menu dropdown-menu-end table-dropdown-menu">
                                                <a class="dropdown-item home-dropdown-item active" href="#">Last 7 days</a>
                                                <a class="dropdown-item home-dropdown-item" href="#">Last 30 days</a>
                                                <a class="dropdown-item home-dropdown-item" href="#">Last 3 months</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="h1 mb-3"><?= $order_counter ?></div>
                                <div class="d-flex mb-2">
                                    <div>Total orders received</div>
                                </div>
                                <div id="orders-mini-chart" style="height: 60px; margin-bottom: 10px;"></div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if (has_permissions('read', 'customers')) { ?>
                    <div class="col-sm-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="subheader">Customers</div>
                                    <div class="ms-auto lh-1">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle text-secondary" href="#" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">Last 7 days</a>
                                            <div class="dropdown-menu dropdown-menu-end table-dropdown-menu">
                                                <a class="dropdown-item home-dropdown-item active" href="#">Last 7 days</a>
                                                <a class="dropdown-item home-dropdown-item" href="#">Last 30 days</a>
                                                <a class="dropdown-item home-dropdown-item" href="#">Last 3 months</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="h1 mb-3"><?= $user_counter ?></div>
                                <div class="d-flex mb-2">
                                    <div>New signups</div>
                                </div>
                                <div id="customers-mini-chart" style="height: 60px; margin-bottom: 10px;"></div>

                            </div>
                        </div>
                    </div>
                <?php } ?>

                <!--<?php if (has_permissions('read', 'delivery_boy')) { ?>-->
                <!--    <div class="col-sm-6 col-lg-3">-->
                <!--        <div class="card">-->
                <!--            <div class="card-body">-->
                <!--                <div class="d-flex align-items-center">-->
                <!--                    <div class="subheader">Delivery Boys</div>-->
                <!--                    <div class="ms-auto lh-1">-->
                <!--                        <div class="dropdown">-->
                <!--                            <a class="dropdown-toggle text-secondary" href="#" data-bs-toggle="dropdown"-->
                <!--                                aria-haspopup="true" aria-expanded="false">Active</a>-->
                <!--                            <div class="dropdown-menu dropdown-menu-end table-dropdown-menu">-->
                <!--                                <a class="dropdown-item home-dropdown-item active" href="#">Active</a>-->
                <!--                                <a class="dropdown-item home-dropdown-item" href="#">All</a>-->
                <!--                                <a class="dropdown-item home-dropdown-item" href="#">Inactive</a>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->
                <!--                <div class="h1 mb-3"><?= $delivery_boy_counter ?></div>-->
                <!--                <div class="d-flex mb-2">-->
                <!--                    <div>Active delivery personnel</div>-->

                <!--                </div>-->
                <!--                <div id="delivery-boys-mini-chart" style="height: 60px; margin-bottom: 10px;"></div>-->

                <!--            </div>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--<?php } ?>-->

                <?php if (has_permissions('read', 'product')) { ?>
                    <div class="col-sm-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="subheader">Products</div>
                                    <div class="ms-auto lh-1">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle text-secondary" href="#" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">Active</a>
                                            <div class="dropdown-menu dropdown-menu-end table-dropdown-menu">
                                                <a class="dropdown-item home-dropdown-item active" href="#">Active</a>
                                                <a class="dropdown-item home-dropdown-item" href="#">All</a>
                                                <a class="dropdown-item home-dropdown-item" href="#">Low Stock</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="h1 mb-3"><?= $product_counter ?></div>
                                <div class="d-flex mb-2">
                                    <div>Total products</div>

                                </div>
                                <div id="products-mini-chart" style="height: 60px; margin-bottom: 10px;"></div>

                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <!-- Charts and Analytics Row -->
            <div class="row row-deck row-cards mb-4">
                <?php if (has_permissions('read', 'orders')) { ?>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Sales Analytics</h3>
                                <div class="card-actions">
                                    <div class="dropdown">
                                        <a href="#" class="btn-action dropdown-toggle" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end table-dropdown-menu">
                                            <a class="dropdown-item home-dropdown-item" href="#"
                                                id="monthlyChart">Monthly</a>
                                            <a class="dropdown-item home-dropdown-item" href="#" id="weeklyChart">Weekly</a>
                                            <a class="dropdown-item home-dropdown-item" href="#" id="dailyChart">Daily</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="sales-chart" style="height: 350px;"></div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if (has_permissions('read', 'categories')) { ?>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Top Selling Categories</h3>
                            </div>
                            <div class="card-body">
                                <div id="category-chart" style="height: 250px;"></div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <!-- Revenue and Top Products Row -->
            <div class="row row-deck row-cards mb-4">
                <?php if (has_permissions('read', 'orders')) { ?>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Revenue Overview</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="text-center">
                                            <div class="h1 mb-1"><?= number_format($total_earnings, 2) ?></div>
                                            <div class="text-secondary">Total Earnings (<?= $currency ?>)</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-center">
                                            <div class="h1 mb-1"><?= number_format($admin_earnings, 2) ?></div>
                                            <div class="text-secondary">Admin Earnings (<?= $currency ?>)</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Admin Commission</span>
                                        <?php if (isset($total_earnings) && $total_earnings > 0) { ?>

                                            <span><?= number_format(($admin_earnings / $total_earnings) * 100, 1) ?>%</span>
                                        <?php } else { ?>
                                            <span>0%</span>

                                        <?php } ?>
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-primary"
                                            style="width: <?= isset($total_earnings) && $total_earnings > 0 ? ($admin_earnings / $total_earnings) * 100 : '' ?>%"
                                            role="progressbar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <div class="col-md-6">
                    <div class="card">
                        <div
                            class="card-header d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
                            <h3 class="card-title d-flex align-items-center gap-2">
                                <i class="ti ti-users"></i> Sellers Overview
                            </h3>
                            <a href="<?= base_url('admin/sellers') ?>" class="btn btn-primary btn-sm">
                                <i class="ti ti-users me-1"></i> Manage Sellers
                            </a>
                        </div>

                        <div class="card-body">
                            <div class="row g-3 mb-4 justify-content-center">

                                <!-- Approved -->
                                <div class="col-12 col-sm-6 col-lg-4 d-flex" style="min-width: 260px;">
                                    <div class="card card-sm w-100 h-100">
                                        <div class="card-body d-flex align-items-center gap-3">
                                            <span
                                                class="bg-green text-white avatar avatar-md d-flex justify-content-center align-items-center">
                                                <i class="fs-2 ti ti-check"></i>
                                            </span>
                                            <div class="flex-grow-1">
                                                <div class="fw-medium">Approved</div>
                                                <div class="text-secondary fs-5">
                                                    <?= $count_approved_sellers ?? 0; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pending -->
                                <div class="col-12 col-sm-6 col-lg-4 d-flex" style="min-width: 260px;">
                                    <div class="card card-sm w-100 h-100">
                                        <div class="card-body d-flex align-items-center gap-3">
                                            <span
                                                class="bg-dark text-white avatar avatar-md d-flex justify-content-center align-items-center">
                                                <i class="fs-2 ti ti-hourglass-empty"></i>
                                            </span>
                                            <div class="flex-grow-1">
                                                <div class="fw-medium">Pending</div>
                                                <div class="text-secondary fs-5">
                                                    <?= $count_not_approved_sellers ?? 0; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Deactivated -->
                                <div class="col-12 col-sm-6 col-lg-4 d-flex" style="min-width: 260px;">
                                    <div class="card card-sm w-100 h-100">
                                        <div class="card-body d-flex align-items-center gap-3">
                                            <span
                                                class="bg-danger text-white avatar avatar-md d-flex justify-content-center align-items-center">
                                                <i class="fs-2 ti ti-circle-x"></i>
                                            </span>
                                            <div class="flex-grow-1">
                                                <div class="fw-medium">Deactivated</div>
                                                <div class="text-secondary fs-5">
                                                    <?= $count_deactive_sellers ?? 0; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>



                </div>


            </div>

            <!-- Additional Charts Row -->
            <div class="row row-deck row-cards mb-4">
                <?php if (has_permissions('read', 'orders')) { ?>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Order Status Distribution</h3>
                            </div>
                            <div class="card-body">
                                <div id="order-status-chart" data-status-data='[
                                        <?= isset($status_counts['awaiting']) ? $status_counts['awaiting'] : 12 ?>,
                                        <?= isset($status_counts['received']) ? $status_counts['received'] : 25 ?>, 
                                        <?= isset($status_counts['processed']) ? $status_counts['processed'] : 18 ?>, 
                                        <?= isset($status_counts['shipped']) ? $status_counts['shipped'] : 32 ?>, 
                                        <?= isset($status_counts['delivered']) ? $status_counts['delivered'] : 45 ?>, 
                                        <?= isset($status_counts['cancelled']) ? $status_counts['cancelled'] : 8 ?>,
                                        <?= isset($status_counts['returned']) ? $status_counts['returned'] : 8 ?>
                                        ]' style="height: 250px;"></div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if (has_permissions('read', 'orders')) { ?>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Revenue Trend</h3>
                                <div class="card-actions">
                                    <div class="dropdown">
                                        <a href="#" class="btn-action dropdown-toggle" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end table-dropdown-menu">
                                            <a class=" dropdown-item home-dropdown-item" href="#"
                                                id="revenue-monthly">Monthly</a>
                                            <a class="dropdown-item home-dropdown-item" href="#"
                                                id="revenue-weekly">Weekly</a>
                                            <a class="dropdown-item home-dropdown-item" href="#"
                                                id="revenue-daily">Daily</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="revenue-chart" style="height: 250px;"></div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <!-- Order Status Overview -->
            <?php if (has_permissions('read', 'orders')) { ?>
                <div class="row row-deck row-cards mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <h3 class="card-title mb-0">Order Status Overview</h3>
                                <a href="<?= base_url('admin/orders') ?>" class="btn btn-primary btn-sm">
                                    <i class="ti ti-eye me-1"></i> View All Orders
                                </a>
                            </div>

                            <div class="card-body">
                                <div class="row g-3">

                                    <?php
                                    $statuses = [
                                        'received' => ['icon' => 'ti-download', 'bg' => 'bg-green'],
                                        'processed' => ['icon' => 'ti-settings', 'bg' => 'bg-warning'],
                                        'shipped' => ['icon' => 'ti-truck', 'bg' => 'bg-primary'],
                                        'delivered' => ['icon' => 'ti-box', 'bg' => 'bg-green'],
                                        'cancelled' => ['icon' => 'ti-x', 'bg' => 'bg-danger'],
                                        'returned' => ['icon' => 'ti-arrow-back-up-double', 'bg' => 'bg-facebook'],
                                    ];

                                    foreach ($statuses as $key => $data) { ?>
                                        <div class="col-12 col-sm-6 col-md-4 col-xl-2">
                                            <div class="card card-sm h-100">
                                                <div class="card-body d-flex align-items-center gap-3">
                                                    <span class="<?= $data['bg'] ?> text-white avatar">
                                                        <i class="ti <?= $data['icon'] ?> fs-2 fs-md-1"></i>
                                                    </span>
                                                    <div class="flex-fill">
                                                        <div class="fw-medium text-truncate text-nowrap"><?= ucfirst($key) ?>
                                                        </div>
                                                        <div class="text-secondary small"><?= $status_counts[$key] ?> orders
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-3 mb-4">
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
                                            <span class="bg-red text-white avatar me-3">
                                                <i class="ti ti-circle"></i>
                                            </span>
                                            <div>
                                                <div class="font-weight-medium">
                                                    <?= $status_counts['return_request_decline'] ?? 0 ?>
                                                </div>
                                                <div class="">Return Declined</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Return Pending -->
                                    <div class="col-sm-6 col-md-6">
                                        <div class="d-flex align-items-center p-2 border rounded">
                                            <span class="bg-yellow text-white avatar me-3">
                                                <i class="ti ti-clock"></i>
                                            </span>
                                            <div>
                                                <div class="font-weight-medium">
                                                    <?= $status_counts['return_request_pending'] ?? 0 ?>
                                                </div>
                                                <div class="">Return Pending</div>
                                            </div>
                                        </div>
                                    </div>



                                    <!-- Return Picked Up -->
                                    <div class="col-sm-6 col-md-6">
                                        <div class="d-flex align-items-center p-2 border rounded">
                                            <span class="bg-blue text-white avatar me-3">
                                                <i class="ti ti-truck-delivery"></i>
                                            </span>
                                            <div>
                                                <div class="font-weight-medium">
                                                    <?= $status_counts['return_pickedup'] ?? 0 ?>
                                                </div>
                                                <div class="">Return Picked Up</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Return Approved -->
                                    <div class="col-sm-6 col-md-6">
                                        <div class="d-flex align-items-center p-2 border rounded">
                                            <span class="bg-green text-white avatar me-3">
                                                <i class="ti ti-check"></i>
                                            </span>
                                            <div>
                                                <div class="font-weight-medium">
                                                    <?= $status_counts['return_request_approved'] ?? 0 ?>
                                                </div>
                                                <div class="">Return Approved</div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- End Status Rows -->
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>




            <!-- Sellers Overview -->
            <?php if (has_permissions('read', 'seller')) { ?>
                <!-- Top Sellers and Categories Tables -->
                <div class="row row-deck row-cards mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Top Sellers</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-vcenter card-table table-striped" id="top_sellers_table"
                                        data-toggle="table" data-url="<?= base_url('admin/sellers/top_seller') ?>"
                                        data-click-to-select="true" data-side-pagination="server" data-show-columns="true"
                                        data-show-refresh="true" data-sort-name="sd.id" data-sort-order="DESC"
                                        data-mobile-responsive="true" data-toolbar="" data-show-export="true"
                                        data-maintain-selected="true" data-export-types='["txt","excel"]'
                                        data-query-params="queryParams">
                                        <thead>
                                            <tr>
                                                <th data-field="seller_id" data-sortable="false">ID</th>
                                                <th data-field="seller_name" data-sortable="false">Seller Name</th>
                                                <th data-field="store_name" data-sortable="false">Store Name</th>
                                                <th data-field="total" data-sortable="false">Total Sales</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if (has_permissions('read', 'categories')) { ?>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Top Categories</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-vcenter card-table table-striped" id="top_categories_table"
                                            data-toggle="table" data-url="<?= base_url('admin/Category/top_category') ?>"
                                            data-click-to-select="true" data-side-pagination="server" data-show-columns="true"
                                            data-show-refresh="true" data-sort-name="sd.id" data-sort-order="DESC"
                                            data-mobile-responsive="true" data-toolbar="" data-show-export="true"
                                            data-maintain-selected="true" data-export-types='["txt","excel"]'
                                            data-query-params="queryParams">
                                            <thead>
                                                <tr>
                                                    <th data-field="id" data-sortable="false">ID</th>
                                                    <th data-field="name" data-sortable="false">Category Name</th>
                                                    <th data-field="clicks" data-sortable="false">Clicks</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>


            <?php } ?>

            <!-- Recent Orders -->
            <?php if (has_permissions('read', 'orders')) { ?>
                <div class="row row-deck row-cards mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Recent Orders</h3>
                                <div class="card-actions">
                                    <a href="<?= base_url('admin/orders') ?>" class="btn btn-primary btn-sm">
                                        <i class="ti ti-eye me-1"></i>
                                        View All Orders
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-vcenter card-table table-striped" data-toggle="table"
                                        data-url="<?= base_url('admin/orders/view_orders') ?>" data-click-to-select="true"
                                        data-side-pagination="server" data-pagination="true"
                                        data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true"
                                        data-show-columns="true" data-show-refresh="true" data-trim-on-search="false"
                                        data-sort-name="id" data-sort-order="desc" data-mobile-responsive="true"
                                        data-toolbar="" data-show-export="true" data-maintain-selected="true"
                                        data-export-types='["txt","excel","csv"]' data-export-options='{
                                    "fileName": "order-list",
                                    "ignoreColumn": ["state"]
                                }' data-query-params="home_query_params">
                                        <thead>
                                            <tr>
                                                <th data-field="id" data-sortabl e='true'
                                                    data-footer-formatter="totalFormatter">Order ID</th>

                                                <th data-field="user_id" data-sortable='true' data-visible="false">User ID
                                                </th>
                                                <th data-field="sellers" data-sortable='true'>Sellers</th>
                                                <th data-field="qty" data-sortable='true' data-visible="false">Q
                                                    ty</th>
                                                <th data-field="name" data-sortable='true'>User Name</th>
                                                <th data-field="mobile" data-sortable='true' data-visibl e="false">Mobile
                                                </th>

                                                <th data-field="items" data-sortable='true' data-visible="false"
                                                    data-formatter="itemsReadMoreFormatter">Items</th>

                                                <th data-field="total" data-sortable='true' data-visible="true">


                                                    Total( <?= $currency ?>)</th>

                                                <th data-field="delivery_charge" data-sortable='true'
                                                    data-footer-formatter="delivery_chargeFormatter" data-visible="true">
                                                    D.Charge</th>

                                                <th data-field="wallet_balance" data-sortable='false' data-visible="false">
                                                    Wallet Used(<?= $currency ?>)</th>


                                                <th data-field="promo_discount" data-sortable='false' data-visible="false">
                                                    Promo disc.(<?= $currency ?>)</th>
                                                <th data-field="final_total" data-sortable='true'>Final
                                                    Total(<?= $currency ?>)</th>
                                                <th data-field="deliver_by" data-sortable='true' data-visible='false'>
                                                    Deliver By</th>
                                                <th data-field="payment_method" data-sortable='true' data-visible="true">
                                                    Payment Method</th>
                                                <th data-field="address" data-sortable='true' data-visible="true">Address
                                                </th>
                                                <th data-field="delivery_date" data-sortable='true' data-visible='false'>
                                                    Delivery Date</th>
                                                <th data-field="delivery_time" data-sortable='true' data-visible='false'>
                                                    Delivery Time</th>
                                                <th data-field="notes" data-sortable='false' data-visible='false'>O. Notes
                                                </th>
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
            <?php } ?>
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
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
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