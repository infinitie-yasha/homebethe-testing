<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">

                <!-- Mobile View -->
                <div class="d-flex flex-column text-center d-sm-none py-2">
                    <h2 class="page-title fs-5 fw-semibold mb-1">View Fund Transfers</h2>
                    <nav class="breadcrumb breadcrumb-arrows small justify-content-center mb-0">
                        <a href="<?= base_url('admin/home') ?>" class="breadcrumb-item">Home</a>
                        <span class="breadcrumb-item">Delivery Boy</span>
                        <span class="breadcrumb-item active">Fund Transfers</span>
                    </nav>
                </div>

                <!-- Tablet & Desktop View -->
                <div class="row g-2 align-items-center d-none d-sm-flex">
                    <div class="col">
                        <h2 class="page-title mb-0">View Fund Transfers</h2>
                    </div>
                    <div class="col-auto ms-auto">
                        <ol class="breadcrumb breadcrumb-arrows mb-0 small">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('admin/home') ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('admin/delivery-boys/manage-delivery-boy') ?>">Delivery Boy</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Fund Transfers
                            </li>
                        </ol>
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
                            <h3 class="card-title d-flex align-items-center gap-2">
                                <i class="ti ti-arrows-transfer-down"></i> Fund Transfers
                            </h3>
                        </div>
                        <div class="row g-3 align-items-end mb-3 p-3">
                            <!-- Filter by Delivery Boy -->
                            <div class="col-12 col-md-3">
                                <label for="filter_d_boy" class="form-label">Filter by Delivery Boy</label>
                                <select name="filter_d_boy" id="filter_d_boy" class="form-select">
                                    <option value="">Select Delivery Boy</option>
                                    <?php if (!empty($delivery_boys)) { ?>
                                        <?php foreach ($delivery_boys as $row) { ?>
                                            <option value="<?= htmlspecialchars($row['user_id']) ?>">
                                                <?= htmlspecialchars($row['username']) ?>
                                            </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>

                            <!-- Action Buttons -->
                            <div class="col-12 col-md-3 col-lg-2">
                                <div class="d-flex flex-wrap flex-md-nowrap gap-2">
                                    <button type="button" class="btn btn-primary w-100 w-md-auto"
                                        onclick="status_date_wise_search()">
                                        <i class="ti ti-search me-1"></i> Filter
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary w-100 w-md-auto"
                                        onclick="resetfilters()">
                                        <i class="ti ti-refresh me-1"></i> Reset
                                    </button>
                                </div>
                            </div>
                        </div>


                        <div class="card-body">
                            <table class='table-striped' id="promo-code-table" data-toggle="table"
                                data-url="<?= base_url('admin/fund_transfer/view_fund_transfers') ?>"
                                data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                                data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                                data-sort-order="desc" data-mobile-responsive="true" data-toolbar=""
                                data-show-export="true" data-maintain-selected="true"
                                data-export-types='["txt","excel"]' data-export-options='{
                            "fileName": "promocode-list",
                            "ignoreColumn": ["state"]
                            }' data-query-params="queryParams">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true">ID</th>
                                        <th data-field="name" data-sortable="false">Name</th>
                                        <th data-field="mobile" data-sortable="false">Mobile</th>
                                        <th data-field="opening_balance" data-sortable="true">Opening balance</th>
                                        <th data-field="closing_balance" data-sortable="true">Closing balance</th>
                                        <th data-field="amount" data-sortable="true">Amount</th>
                                        <th data-field="status" data-sortable="true">Status</th>
                                        <th data-field="message" data-sortable="true">Message</th>
                                        <th data-field="date_created" data-sortable="true">Date</th>
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