<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">Customer Wallet Transactions</h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="d-flex">
                            <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/home') ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/customer') ?>">Customer</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">Wallet</a>
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
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs nav-fill">
                                <li class="nav-item">
                                    <a href="#tabs-users" class="nav-link active" data-bs-toggle="tab">
                                        <i class="ti ti-users"></i> Users
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#tabs-wallet" class="nav-link" data-bs-toggle="tab">
                                        <i class="ti ti-wallet"></i> Customer Wallet Transactions
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <div class="tab-content">

                                <!-- USERS TAB -->
                                <div class="tab-pane active show" id="tabs-users">
                                    <table class="table-striped" id="customers" data-toggle="table"
                                        data-url="<?= base_url('admin/customer/view_customer') ?>"
                                        data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                                        data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true"
                                        data-show-columns="true" data-show-refresh="true" data-sort-name="id"
                                        data-sort-order="desc">
                                        <thead>
                                            <tr>
                                                <th data-field="id">ID</th>
                                                <th data-field="name">Name</th>
                                                <th data-field="email">Email</th>
                                                <th data-field="balance">Balance</th>
                                                <th data-field="actions_1">Actions</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>

                                <!-- WALLET TAB -->
                                <div class="tab-pane" id="tabs-wallet">

                                    <!-- FILTERS -->
                                    <div class="row g-3">
                                        <div class="col-md-3 col-12">
                                            <label class="form-label">Customer</label>
                                            <select x-ref="customerSelect" class="form-select"></select>
                                        </div>

                                        <div class="col-md-3 col-12">
                                            <label class="form-label">Status</label>
                                            <select class="form-select" id="transaction_status_filter">
                                                <option value="">All</option>
                                                <option value="awaiting">Awaiting</option>
                                                <option value="success">Success</option>
                                                <option value="failed">Failed</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3 col-12">
                                            <label class="form-label">Transaction Type</label>
                                            <select class="form-select" id="transaction_type">
                                                <option value="">All</option>
                                                <option value="bank_transfer">Bank Transfer</option>
                                                <option value="credit">Credit</option>
                                                <option value="debit">Debit</option>
                                                <option value="cod">COD</option>
                                                <option value="phonepe">PhonePe</option>
                                                <option value="razorpay">Razorpay</option>
                                                <option value="stripe">Stripe</option>
                                            </select>
                                        </div>

                                        <div class="col-12 col-sm-6 col-md-4 col-lg-2 d-flex gap-2 align-items-end">
                                            <button class="btn btn-primary w-50" onclick="status_date_wise_search()">
                                                <i class="ti ti-search"></i> Filter
                                            </button>
                                            <button class="btn btn-outline-secondary w-50" onclick="resetfilters()">
                                                <i class="ti ti-refresh"></i> Reset
                                            </button>
                                        </div>
                                    </div>

                                    <!-- WALLET TABLE - MUST BE INSIDE TAB -->
                                    <div class="mt-3">
                                        <table class="table-striped" id="customer_wallet_transactions_table"
                                            data-toggle="table"
                                            data-url="<?= base_url('admin/transaction/view_transactions') ?>"
                                            data-click-to-select="true" data-side-pagination="server"
                                            data-pagination="true" data-search="true" data-show-columns="true"
                                            data-show-refresh="true" data-sort-name="id" data-sort-order="desc">
                                            <thead>
                                                <tr>
                                                    <th data-field="id">ID</th>
                                                    <th data-field="name">User Name</th>
                                                    <th data-field="type">Type</th>
                                                    <th data-field="amount">Amount</th>
                                                    <th data-field="status">Status</th>
                                                    <th data-field="message">Message</th>
                                                    <th data-field="date">Date</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>

                                </div> <!-- end WALLET TAB -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas offcanvas-end offcanvas-medium" tabindex="-1" id="manageCustomerWallet"
        aria-labelledby="manageCustomerWalletLabel">
        <div class="offcanvas-header">
            <h2 class="offcanvas-title" id="manageCustomerWalletLabel">Manage Wallet</h2>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <form x-data="ajaxForm({
                                            url: base_url + 'admin/customer/update_customer_wallet',
                                            offcanvasId: 'manageCustomerWallet',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="update_customer_wallet_form">
            <div class="offcanvas-body">
                <div>
                    <input type="hidden" id='user_id' name='user_id'>
                    <div class="mb-3 row">
                        <label class="col-3 col-form-label required" for="customer_dtls">Customer</label>
                        <div class="col">
                            <input type="text" class="form-control" name="customer_dtls" id="customer_dtls" readonly />
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-3 col-form-label required" for="type">Select Type</label>
                        <div class="col">
                            <select name="type" id="type" class="form-control">
                                <option value="credit">Credit </option>
                                <option value="debit">Debit</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-3 col-form-label required" for="amount">Amount</label>
                        <div class="col">
                            <input type="number" class="form-control" name="amount" id="amount" min="0"
                                placeholder="Enter Amount" />
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-3 col-form-label required" for="message">Message</label>
                        <div class="col">
                            <textarea name="message" id="message" class="textarea form-control" placeholder="message"
                                data-bs-toggle="autosize"> </textarea>
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <button type="button" class="btn" data-bs-dismiss="offcanvas" aria-label="Close">Close</button>
                    <button type="submit" class="btn btn-primary save_zipcode_btn" id="submit_btn">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>