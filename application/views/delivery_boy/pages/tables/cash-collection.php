<div class="container-xl">
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="row g-2 align-items-center">
            <!-- Page Title -->
            <div class="col-12 col-md mb-2 mb-md-0">
                <h2 class="page-title mb-0 text-truncate">Cash Collection Transactions</h2>
            </div>

            <!-- Breadcrumbs -->
            <div class="col-12 col-md-auto">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-arrows mb-0 flex-wrap justify-content-md-end">
                        <li class="breadcrumb-item"><a href="<?= base_url('delivery-boy/home') ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Cash Collection Transactions</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Page body -->
    <div class="page-body">
        <div class="row">
            <div class="col-12 main-content">
                <div class="card content-area p-3 p-md-4">
                    <div class="card-innr">

                        <!-- Cash Cards -->
                        <div class="row g-3 mb-3">
                            <div class="col-12 col-sm-6">
                                <div class="card card-sm h-100">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="me-3">
                                            <span class="bg-warning-lt avatar avatar-lg rounded">
                                                <i class="ti ti-cash fs-1"></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="fw-medium">Cash In Hand</div>
                                            <div class="text-muted text-h3 mt-1">
                                                <?= $curreny . " " . ((isset($cash_in_hand) && !empty($cash_in_hand[0]['cash_received'])) ? number_format($cash_in_hand[0]['cash_received'], 2) : "0.00") ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6">
                                <div class="card card-sm h-100">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="me-3">
                                            <span class="bg-success-lt avatar avatar-lg rounded">
                                                <i class="ti ti-coins fs-1"></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="fw-medium">Cash Collected</div>
                                            <div class="text-muted text-h3 mt-1">
                                                <?= $curreny . " " . ((isset($cash_collected) && !empty($cash_collected[0]['total_amt'])) ? number_format($cash_collected[0]['total_amt'], 2) : "0.00") ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Filters -->
                        <div class="row g-3 mb-3">
                            <div class="col-12 col-md-4">
                                <label class="form-label">Date and time range:</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ti ti-clock"></i></span>
                                    <input type="text" class="form-control" id="datepicker">
                                    <input type="hidden" id="start_date">
                                    <input type="hidden" id="end_date">
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <label class="form-label">Filter By status</label>
                                <select id="filter_status" name="filter_status" class="form-control">
                                    <option value="">Select Status</option>
                                    <option value="delivery_boy_cash">Delivery boy Cash In Hand</option>
                                    <option value="delivery_boy_cash_collection">Cash Collected by Admin</option>
                                </select>
                            </div>

                            <div class="col-12 col-md-4 d-flex align-items-end gap-2">
                                <button type="button" class="btn btn-primary flex-grow-1" onclick="status_date_wise_search()">
                                    <i class="ti ti-search"></i> Filter
                                </button>
                                <button type="button" class="btn btn-outline-secondary flex-grow-1" onclick="resetfilters()">
                                    <i class="ti ti-refresh"></i> Reset
                                </button>
                            </div>
                        </div>

                        <!-- Hidden Currency -->
                        <input type="hidden" value="<?= $curreny ?>" name="store_currency">

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-striped"
                                data-toggle="table"
                                data-show-footer="true"
                                data-url="<?= base_url('delivery_boy/fund-transfer/get_cash_collection') ?>"
                                data-click-to-select="true"
                                data-side-pagination="server"
                                data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]"
                                data-search="true"
                                data-show-columns="true"
                                data-show-refresh="true"
                                data-trim-on-search="false"
                                data-sort-name="id"
                                data-sort-order="desc"
                                data-mobile-responsive="true"
                                data-toolbar=""
                                data-show-export="true"
                                data-maintain-selected="true"
                                data-export-types='["txt","excel"]'
                                data-export-options='{"fileName": "delivery-boy-cash-collection-list","ignoreColumn": ["operate"]}'
                                data-query-params="cash_collection_query_params">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true">Id</th>
                                        <th data-field="name" data-sortable="false">User Name</th>
                                        <th data-field="mobile" data-sortable="false">Mobile</th>
                                        <th data-field="order_id" data-sortable="false" data-footer-formatter="idFormatter">Order Id</th>
                                        <th data-field="amount" data-sortable="false" data-footer-formatter="priceFormatter">Amount(<?= $curreny ?>)</th>
                                        <th data-field="type" data-sortable="false">Status</th>
                                        <th data-field="message" data-sortable="false" data-visible="false">Message</th>
                                        <th data-field="txn_date" data-sortable="false">Date</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <!-- End Table -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
