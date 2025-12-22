<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">View Transaction</h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="d-flex">
                            <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/home') ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item " aria-current="page">
                                    <a href="<?= base_url('admin/customer') ?>">customer</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">Customer Transaction</a>
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
                            <h3 class="card-title"><i class="ti ti-credit-card-pay"></i> Transaction</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-3 mb-3">
                                <!-- Customer Filter -->
                                <div class="col-md-3 col-12">
                                    <div x-data x-init="initTomSelect({
                element: $refs.customerSelect,
                url: '<?= base_url('admin/customer/search_customer') ?>',
                placeholder: 'Search Customer...',
                maxItems: 1,
                preloadOptions: true
            })">
                                        <label for="customerSelect" class="form-label">Customer</label>
                                        <select x-ref="customerSelect" class="form-select" name="customer"
                                            id="customerSelect"></select>
                                    </div>
                                </div>

                                <!-- Status Filter -->
                                <div class="col-md-3 col-12">
                                    <label for="transaction_status_filter" class="form-label">Status</label>
                                    <select class="form-select" id="transaction_status_filter"
                                        name="transaction_status_filter">
                                        <option value="">All</option>
                                        <option value="awaiting">Awaiting</option>
                                        <option value="success">Success</option>
                                        <option value="failed">Failed</option>
                                    </select>
                                </div>
                                <div class="col-md-3 col-12">
                                    <label for="transaction_type" class="form-label">Transaction Type</label>
                                    <select class="form-select" id="transaction_type" name="transaction_type">
                                        <option value="">All</option>
                                        <option value="bank_transfer">Bank Transfer</option>
                                        <option value="credit">Credit</option>
                                        <option value="debit">Debit</option>
                                        <option value="cod">COD</option>
                                        <option value="phonepe">Phonepe</option>
                                        <option value="razorpay">Razorpay</option>
                                        <option value="stripe">Stripe</option>
                                    </select>
                                </div>
                            </div>

                            <input type='hidden' id='transaction_user_id'
                                value='<?= (isset($_GET['user_id']) && !empty($_GET['user_id'])) ? $_GET['user_id'] : '' ?>'>
                            <table class='table-striped' id="customer-transaction-table" data-toggle="table"
                                data-url="<?= base_url('admin/transaction/view_transactions') ?>"
                                data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                                data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                                data-sort-order="desc" data-mobile-responsive="true" data-toolbar=""
                                data-show-export="true" data-maintain-selected="true"
                                data-export-types='["txt","excel"]' data-export-options='{
                            "fileName": "tranction-list",
                            "ignoreColumn": ["state"]
                            }' data-query-params="transaction_query_params">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true">Id</th>
                                        <th data-field="name" data-sortable="false">User Name</th>
                                        <th data-field="order_id" data-sortable="false">Order Id</th>
                                        <th data-field="txn_id" data-sortable="false">Transaction Id</th>
                                        <th data-field="type" data-sortable="false">Transaction type</th>
                                        <th data-field="payu_txn_id" data-sortable="false" data-visible="false">Pay
                                            Transaction Id</th>
                                        <th data-field="amount" data-sortable="false">Amount</th>
                                        <th data-field="status" data-sortable="false">Status</th>
                                        <th data-field="message" data-sortable="false" data-visible="false">Message</th>
                                        <th data-field="txn_date" data-sortable="false">Date</th>
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