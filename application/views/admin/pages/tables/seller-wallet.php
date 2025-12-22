<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">Seller Wallet Transactions</h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="d-flex">
                            <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/home') ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/sellers') ?>">Sellers</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">Seller Wallet</a>
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
                            <h3 class="card-title"><i class="ti ti-world"></i> Seller Wallet Transactions</h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">

                                <!-- Transaction Status Filter -->
                                <div class="col-md-3 col-12">
                                    <label for="transaction_status_type_filter" class="form-label">Filter By Transaction
                                        Status</label>
                                    <select id="transaction_status_type_filter" name="transaction_status_type_filter"
                                        class="form-select">
                                        <option value="">All</option>
                                        <option value="credit">Credit</option>
                                        <option value="debit">Debit</option>
                                    </select>
                                </div>

                                <!-- Seller Filter -->
                                <div class="col-md-3 col-12" x-data x-init="initTomSelect({
             element: $refs.sellerSelect,
             url: '<?= base_url('admin/product/get_sellers_data') ?>',
             placeholder: 'Search Seller...',
             offcanvasId: 'filterOffcanvas',
             maxItems: 1,
             preloadOptions: true
         })">
                                    <label class="form-label" for="sellerSelect">Seller</label>
                                    <select x-ref="sellerSelect" class="form-select" name="seller_id"
                                        id="seller_filter"></select>
                                </div>

                            </div>

                            <!-- Seller Filter -->
                            <table class='table-striped' id="seller_wallet_transaction_table" data-toggle="table"
                                data-url="<?= base_url('admin/transaction/view_transactions') ?>"
                                data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                                data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                                data-sort-order="desc" data-mobile-responsive="true" data-toolbar=""
                                data-maintain-selected="true" data-query-params="seller_wallet_query_params">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true">ID</th>
                                        <th data-field="name" data-sortable="false">User Name</th>
                                        <th data-field="type" data-sortable="false">Type</th>
                                        <th data-field="amount" data-sortable="false">
                                            Amount(<?= $currency ?>)</th>
                                        <th data-field="status" data-sortable="false">Status</th>
                                        <th data-field="message" data-sortable="false">Message</th>
                                        <th data-field="date" data-sortable="false">Date</th>
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