<div class="page-wrapper">




    <!-- BEGIN PAGE HEADER -->
    <div class="page-header d-print-none" aria-label="Page header">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">Sales-inventory Report</h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="d-flex">
                        <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('seller/home') ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="#"> Report</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="#">Sales-inventory Report</a>
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
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title"><i class="ti ti-stack"></i>inventory Reports</h5>
                    </div>

                    <div class="card-body">

                        <div class="container-fluid">
                            <div class="row g-3 mt-3">

                                <!-- Pie Chart -->
                                <div class="col-12 col-md-6">
                                    <div class="card h-100">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">Top Selling Products</h5>
                                        </div>
                                        <div class="card-body">
                                            <div id="piechart_3d" style="min-height: 350px;"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Filters -->
                                <div class="col-12 col-md-6">
                                    <div class="card h-100 d-flex flex-column">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">Filters</h5>
                                        </div>

                                        <div class="card-body d-flex flex-column">

                                            <div class="row g-3">
                                                <!-- Date Time Picker -->
                                                <div class="col-12">
                                                    <label for="datepicker" class="form-label">Date and Time
                                                        Range:</label>
                                                    <div class="input-icon">
                                                        <input type="text" id="datepicker" class="form-control"
                                                            autocomplete="off">
                                                        <input type="hidden" id="start_date">
                                                        <input type="hidden" id="end_date">
                                                        <span class="input-icon-addon">
                                                            <i class="ti ti-clock"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Buttons -->
                                            <div class="mt-auto pt-3 d-flex gap-2 flex-wrap">
                                                <button type="button" class="btn btn-outline-primary btn-sm"
                                                    onclick="status_date_wise_search()">
                                                    <i class="ti ti-search"></i> Filter
                                                </button>
                                                <button type="button" class="btn btn-outline-danger btn-sm"
                                                    onclick="resetfilters()" aria-label="Clear Filters">
                                                    <i class="ti ti-x"></i> Reset
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>

                        <table class="table table-striped table-hover" data-toggle="table"
                            data-url="<?= base_url('seller/Sales_inventory/get_seller_sales_inventory_list') ?>"
                            data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                            data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                            data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                            data-sort-order="desc" data-mobile-responsive="true" data-toolbar="" data-show-export="true"
                            data-maintain-selected="true" data-export-types='["txt","excel"]'
                            data-query-params="sales_inventory_report_query_params">
                            <thead class="thead-light">
                                <tr>
                                    <th data-field="id" data-sortable="true">Item ID</th>
                                    <th data-field="name" data-sortable="true">Product Name</th>
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