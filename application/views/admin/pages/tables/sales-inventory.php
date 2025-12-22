<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row align-items-center g-2">
                    <!-- Page Title -->
                    <div class="col-12 col-md">
                        <h2 class="page-title mb-0">View Sale Inventory Reports</h2>
                    </div>

                    <!-- Breadcrumb -->
                    <div class="col-12 col-md-auto mt-2 mt-md-0">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-arrows mb-0">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/home') ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="javascript:void(0)">Reports</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Sales Inventory Reports
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- END PAGE HEADER -->

        <div class="page-body">
            <div class="container-xl">
                <!-- Top Section: Pie Chart and Filters -->
                <div class="row g-3 align-items-stretch">
                    <!-- Pie Chart (Left) -->
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                        <div class="card h-100 shadow-sm">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <h3 class="card-title mb-0">
                                    <i class="ti ti-chart-pie me-2"></i>Top Selling Products
                                </h3>
                            </div>
                            <div class="card-body">
                                <div id="sales_piechart_3d" class="piechart-container"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Filters (Right) -->
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                        <div class="card h-100 shadow-sm">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <h3 class="card-title mb-0">
                                    <i class="ti ti-filter me-2"></i>Filters
                                </h3>
                            </div>

                            <div class="card-body d-flex flex-column">
                                <!-- Date Range -->
                                <div class="mb-3">
                                    <label class="col-form-label fw-semibold small" for="datepicker">Date and Time
                                        Range:</label>
                                    <div class="input-icon">
                                        <input type="text" value="" class="form-control" id="datepicker"
                                            autocomplete="off" />
                                        <input type="hidden" id="start_date">
                                        <input type="hidden" id="end_date">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-clock"></i>
                                        </span>
                                    </div>
                                </div>

                                <!-- Seller Select -->
                                <div class="mb-3">
                                    <label class="col-form-label fw-semibold small" for="seller_ids">Seller</label>
                                    <div x-data x-init="initTomSelect({
                            element: $refs.sellerSelect,
                            url: '<?= base_url('admin/product/get_sellers_data') ?>',
                            placeholder: 'Search Seller...',
                            offcanvasId: 'filterOffcanvas',
                            maxItems: 1,
                            preloadOptions: true
                        })">
                                        <select x-ref="sellerSelect" class="form-select" name="seller_ids"
                                            id="seller_ids"></select>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex flex-wrap gap-2 mt-auto pt-3">
                                    <button type="button" class="btn btn-outline-primary w-sm-100"
                                        onclick="status_date_wise_search()" aria-label="Apply Filters">
                                        <i class="ti ti-filter me-1"></i>Apply
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary w-sm-100"
                                        onclick="resetfilters()">
                                        <i class="ti ti-refresh me-1"></i>Reset
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Bottom Section: Table -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><i class="ti ti-list"></i> Sales Inventory Details</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped" data-toggle="table"
                                    data-url="<?= base_url('admin/Sales_inventory/get_sales_inventory_list') ?>"
                                    data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                                    data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true"
                                    data-show-columns="true" data-show-columns-search="true" data-show-refresh="true"
                                    data-trim-on-search="false" data-sort-name="id" data-sort-order="desc"
                                    data-mobile-responsive="true" data-toolbar="" data-show-export="true"
                                    data-maintain-selected="true" data-export-types='["txt","excel"]'
                                    data-export-options='{
                                        "fileName": "Admin-sales-inventory-list",
                                        "ignoreColumn": ["operate"]
                                    }' data-query-params="sales_inventory_report_query_params">
                                    <thead>
                                        <tr>
                                            <th data-field="id" data-sortable="true">Item ID</th>
                                            <th data-field="name" data-sortable="true">Product name</th>
                                            <th data-field="stock" data-sortable="true">Stock</th>
                                            <th data-field="qty" data-sortable="true">Orders Placed</th>
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
</div>