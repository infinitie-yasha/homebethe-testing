<div class="page-wrapper">

    <!-- BEGIN PAGE HEADER -->
    <div class="page-header d-print-none" aria-label="Page header">
        <div class="container-xl">

            <!-- Mobile View -->
            <div class="d-flex flex-column text-center d-sm-none py-2">
                <h2 class="page-title fs-5 fw-semibold mb-1">Manage Earnings</h2>
                <nav class="breadcrumb breadcrumb-arrows small justify-content-start mb-0">
                    <a href="<?= base_url('admin/home') ?>" class="breadcrumb-item">Home</a>
                    <span class="breadcrumb-item active"> Manage Earnings</span>
                </nav>
            </div>

            <!-- Tablet & Desktop View -->
            <div class="row g-2 align-items-center d-none d-sm-flex">
                <div class="col">
                    <h2 class="page-title mb-0">Manage Earnings</h2>
                </div>
                <div class="col-auto ms-auto">
                    <ol class="breadcrumb breadcrumb-arrows mb-0 small">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('admin/home') ?>">Home</a>
                        </li>

                        <li class="breadcrumb-item active" aria-current="page">
                            Finance
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Earnings
                        </li>
                    </ol>
                </div>
            </div>

        </div>
    </div>


    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Total Profit Section -->
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <h3 class="card-title">
                                        All Time Total Profit
                                        <a href="#" class="ms-2" data-bs-toggle="modal"
                                            data-bs-target="#profitInfoModal">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-info-circle" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <circle cx="12" cy="12" r="9" />
                                                <line x1="12" y1="8" x2="12" y2="12" />
                                                <line x1="12" y1="16" x2="12.01" y2="16" />
                                            </svg>
                                        </a>
                                    </h3>
                                </div>
                                <div class="col text-end">
                                    <div class="h3 text-success">
                                        <?= $currency ?><?= number_format($earning_data['total_profit'], 2) ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Status Cards Grid -->
                            <div class="row row-cards mt-4">
                                <div class="col-lg-3 col-md-6">
                                    <div class="card card-sm">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <span class="avatar bg-blue-lt">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-clock" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <circle cx="12" cy="12" r="9" />
                                                        <polyline points="12 7 12 12 15 15" />
                                                    </svg>
                                                </span>
                                                <div class="ms-3">
                                                    <div class="text-muted">Pending</div>
                                                    <div class="h5 mb-0">
                                                        <?= $currency ?><?= number_format($earning_data['pending'], 2) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6">
                                    <div class="card card-sm">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <span class="avatar bg-green-lt">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-check" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M5 12l5 5l10 -10" />
                                                    </svg>
                                                </span>
                                                <div class="ms-3">
                                                    <div class="text-muted">Confirmed</div>
                                                    <div class="h5 mb-0">
                                                        <?= $currency ?><?= number_format($earning_data['confirm'], 2) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6">
                                    <div class="card card-sm">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <span class="avatar bg-yellow-lt">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-credit-card" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <rect x="3" y="5" width="18" height="14" rx="3" />
                                                        <line x1="3" y1="10" x2="21" y2="10" />
                                                        <line x1="7" y1="15" x2="7.01" y2="15" />
                                                        <line x1="11" y1="15" x2="13" y2="15" />
                                                    </svg>
                                                </span>
                                                <div class="ms-3">
                                                    <div class="text-muted">Paid</div>
                                                    <div class="h5 mb-0">
                                                        <?= $currency ?><?= number_format($earning_data['paid'], 2) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6">
                                    <div class="card card-sm">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <span class="avatar bg-red-lt">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-paper-plane" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M10 14l11 -11" />
                                                        <path
                                                            d="M21 3l-6.5 18a0.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a0.55 .55 0 0 1 0 -1l18 -6.5" />
                                                    </svg>
                                                </span>
                                                <div class="ms-3">
                                                    <div class="text-muted">Requested</div>
                                                    <div class="h5 mb-0">
                                                        <?= $currency ?><?= number_format($earning_data['requested'], 2) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- What's This Link -->
                            <div class="mt-3">
                                <a href="#" class="text-muted" data-bs-toggle="modal" data-bs-target="#infoModal">What's
                                    this?</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- All Time Total Profit Info Modal -->
                <!-- Profit Info Modal -->
                <div class="modal modal-blur fade" id="profitInfoModal" tabindex="-1"
                    aria-labelledby="profitInfoModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="profitInfoModalLabel">What Does “All-Time Total Profit”
                                    Mean?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-muted mb-0">
                                    This is the total profit you’ve earned from both Finance and Non-Finance brands
                                    since joining EarnKaro.
                                    It represents your complete earnings history on the platform.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profit Status Info Modal -->
                <div class="modal modal-blur fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="infoModalLabel">Understanding Profit Status</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <h6 class="text-primary">Pending Profit</h6>
                                    <p class="text-muted mb-0">
                                        Your profit has been tracked and is awaiting brand confirmation after the return
                                        or cancellation period.
                                        Once approved, it will move to <strong>Confirmed</strong>. If the order is
                                        returned, cancelled, or invalid, the profit will be <strong>Cancelled</strong>.
                                    </p>
                                </div>

                                <div class="mb-3">
                                    <h6 class="text-primary">Confirmed Profit</h6>
                                    <p class="text-muted mb-0">
                                        This profit is verified and ready for withdrawal. Click <span
                                            class="text-success fw-bold">'Request Payment'</span> to transfer it to your
                                        registered bank account.
                                    </p>
                                </div>

                                <div class="mb-3">
                                    <h6 class="text-primary">Requested Profit</h6>
                                    <p class="text-muted mb-0">
                                        Your withdrawal request has been received and is currently being processed.
                                        The amount will be credited to your selected payment method shortly.
                                    </p>
                                </div>

                                <div class="mb-0">
                                    <h6 class="text-primary">Paid Profit</h6>
                                    <p class="text-muted mb-0">
                                        This profit has already been successfully transferred to your bank account.
                                        Great work! Keep sharing and earning more rewards.
                                    </p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-3 col-12">
                                    <label class="form-label">Filter By Transaction Type</label>
                                    <select class="form-select" name="transaction_type_filter"
                                        id="transaction_type_filter">
                                        <option value="">Select Transaction Type</option>
                                        <option value="order">Order</option>
                                        <option value="withdraw">Withdraw</option>
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

                            <div class="mt-4"></div>
                            <table class="table table-striped table-vcenter" id="affiliate_wallet_transaction_table"
                                data-toggle="table"
                                data-url="<?= base_url('affiliate/transaction/view_wallet_transactions_list') ?>"
                                data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                                data-show-refresh="true" data-trim-on-search="false" data-sort-name="awt.id"
                                data-sort-order="desc" data-mobile-responsive="true" data-toolbar=""
                                data-show-export="true" data-maintain-selected="true"
                                data-query-params="wallet_transaction_queryParams">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true">ID</th>
                                        <th data-field="payment_type" data-sortable="true">Type</th>
                                        <th data-field="amount_requested" data-sortable="false">Amount</th>
                                        <th data-field="reference_type" data-sortable="false">Transaction Type</th>
                                        <th data-field="message" data-sortable="false">Message</th>
                                        <th data-field="date_created" data-sortable="false">Date Created</th>
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