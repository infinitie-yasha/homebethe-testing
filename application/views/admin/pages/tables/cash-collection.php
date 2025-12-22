<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">

                <!-- Mobile View -->
                <div class="d-flex flex-column text-center d-sm-none py-2">
                    <h2 class="page-title fs-5 fw-semibold mb-1">Manage Cash Collection</h2>
                    <nav class="breadcrumb breadcrumb-arrows small justify-content-start mb-0">
                        <a href="<?= base_url('admin/home') ?>" class="breadcrumb-item">Home</a>
                        <a href="<?= base_url('admin/delivery-boys/manage-delivery-boy') ?>"
                            class="breadcrumb-item">Delivery Boy</a>
                        <span class="breadcrumb-item active">Cash Collection</span>
                    </nav>
                </div>

                <!-- Tablet & Desktop View -->
                <div class="row g-2 align-items-center d-none d-sm-flex">
                    <div class="col">
                        <h2 class="page-title mb-0">Manage Cash Collection</h2>
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
                                Manage Cash Collection
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
                            <h3 class="card-title"><i class="ti ti-coins"></i> Cash Transactions</h3>
                        </div>
                        <div class="card-body">

                            <div class="row g-3 align-items-end mb-3">

                                <!-- Date & Time Range -->
                                <div class="col-12 col-md-4">
                                    <label class="form-label" for="datepicker">Date and time range:</label>
                                    <div class="input-icon">
                                        <input type="text" class="form-control" id="datepicker" autocomplete="off">
                                        <input type="hidden" id="start_date">
                                        <input type="hidden" id="end_date">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-clock"></i>
                                        </span>
                                    </div>
                                </div>

                                <!-- Filter by Status -->
                                <div class="col-12 col-md-3">
                                    <label class="form-label" for="filter_status">Filter By Status</label>
                                    <select name="filter_status" id="filter_status" class="form-select">
                                        <option value="">Select Status</option>
                                        <option value="delivery_boy_cash">Delivery Boy Cash Received</option>
                                        <option value="delivery_boy_cash_collection">Cash Collected by Admin</option>
                                    </select>
                                </div>

                                <!-- Filter by Delivery Boy (only if exists) -->
                                <?php if (isset($delivery_boys) && !empty($delivery_boys)) { ?>
                                    <div class="col-12 col-md-3">
                                        <label class="form-label" for="filter_d_boy">Filter By Delivery Boy</label>
                                        <select name="filter_d_boy" id="filter_d_boy" class="form-select">
                                            <option value="">Select Delivery Boy</option>
                                            <?php foreach ($delivery_boys as $row) { ?>
                                                <option value="<?= $row['user_id'] ?>"><?= $row['username'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                <?php } ?>

                                <!-- Action Buttons -->
                                <div class="col-12 col-md-2 d-flex flex-column flex-md-row gap-2">
                                    <button type="button" class="btn btn-primary w-100"
                                        onclick="status_date_wise_search()">
                                        <i class="ti ti-search"></i> Filter
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary w-100"
                                        onclick="resetfilters()">
                                        <i class="ti ti-refresh"></i> Reset
                                    </button>
                                </div>

                            </div>


                            <input type="hidden" value="<?= $curreny ?>" name="store_currency">

                            <table class='table-striped' id="delivery_boy_cash_collection_data" data-toggle="table"
                                data-url="<?= base_url('admin/delivery_boys/get_cash_collection') ?>"
                                data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                                data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                                data-sort-order="desc" data-mobile-responsive="true" data-toolbar=""
                                data-show-export="true" data-maintain-selected="true"
                                data-export-types='["txt","excel"]' data-export-options='{
                            "fileName": "delivery-boy-cash-collection-list",
                            "ignoreColumn": ["state"]
                            }' data-query-params="cash_collection_query_params">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true">Id</th>
                                        <th data-field="name" data-sortable="false">User Name</th>
                                        <th data-field="mobile" data-visible="false" data-sortable="false">Mobile</th>
                                        <th data-field="order_id" data-sortable="false"
                                            data-footer-formatter="idFormatter">Order Id</th>
                                        <th data-field="amount" data-sortable="false"
                                            data-footer-formatter="priceFormatter">Amount(<?= $curreny ?>)</th>
                                        <th data-field="type" data-sortable="false">Status</th>
                                        <th data-field="message" data-sortable="false" data-visible="false">Message</th>
                                        <th data-field="txn_date" data-sortable="false">Date</th>
                                        <th data-field="operate" data-sortable="false">Operation</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>


                        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"
                            id='cash_collection_modal'>
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Manage Cash Collection</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <form x-data="ajaxForm({
                                            url: base_url + 'admin/delivery_boys/manage-cash-collection',
                                            loader: true,
                                            modalId: 'cash_collection_modal',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal">
                                        <div class="modal-body">
                                            <input type='hidden' name="delivery_boy_id" id="delivery_boy_id" value='' />
                                            <input type='hidden' name="order_id" id="order_id" value='' />
                                            <input type='hidden' name="transaction_id" id="transaction_id" value='' />

                                            <div class="mb-3 row">
                                                <label class="col-3 col-form-label required"
                                                    for="details">Details</label>
                                                <div class="col">
                                                    <input type="text" class="form-control" name="name" rows="3"
                                                        id="details" readonly />
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label class="col-3 col-form-label required" for="amount">Amount to be
                                                    Collect</label>
                                                <div class="col">
                                                    <input type="text" class="form-control" name="order_amount"
                                                        id="amount" readonly />
                                                </div>
                                            </div>
                                            <input type='hidden' name="amount" id="order_amount" value='' />

                                            <div class="mb-3 row">
                                                <label class="col-3 col-form-label required" for="date">Date
                                                    <small>(DD-MM-YYYY)</small></label>
                                                <div class="col">
                                                    <input type="datetime-local" class="form-control" name="date"
                                                        id="date" />
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <label class="col-3 col-form-label" for="message">Message</label>
                                                <div class="col">
                                                    <textarea name="message" class="textarea form-control"
                                                        placeholder="message" data-bs-toggle="autosize"> </textarea>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary"
                                                id="submit_btn">Collect</button>
                                            <button type="button" class="btn" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>