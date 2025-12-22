<div class="page-wrapper">
    <div class="page">
        <div class="container-xl">
            <!-- Page Header -->
            <div class="page-header d-print-none">
                <div class="row align-items-center">
                    <div class="col">
                        <h2 class="page-title">Affiliate Dashboard</h2>
                        <div class="text-muted mt-1">Overview of your affiliate program performance</div>
                    </div>
                </div>
            </div>

            <!-- Main Statistics Cards -->
            <div class="row row-deck row-cards mb-3">
                <!-- Orders Card -->
                <div class="col-sm-6 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Orders</div>
                                <div class="ms-auto lh-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon text-warning" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <circle cx="9" cy="19" r="2"></circle>
                                        <circle cx="17" cy="19" r="2"></circle>
                                        <path d="M3 3h2l2 12a3 3 0 0 0 3 2h7a3 3 0 0 0 3 -2l1 -7h-15.2"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="h1 mb-0"><?= isset($order_counter) ? number_format($order_counter) : '0' ?>
                            </div>
                            <div class="text-muted mt-1">Total affiliate orders</div>
                        </div>
                    </div>
                </div>

                <!-- Affiliate Users Card -->
                <div class="col-sm-6 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Affiliate Users</div>
                                <div class="ms-auto lh-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon text-primary" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="h1 mb-0"><?= isset($user_counter) ? number_format($user_counter) : '0' ?></div>
                            <div class="text-muted mt-1">Registered affiliates</div>
                        </div>
                    </div>
                </div>

                <!-- Admin Earnings Card -->
                <div class="col-sm-6 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Admin Earnings</div>
                                <div class="ms-auto lh-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon text-success" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path
                                            d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2">
                                        </path>
                                        <path d="M12 3v3m0 12v3"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="h1 mb-0"><?= isset($currency) ? $currency : '$' ?>
                                <?= isset($admin_earnings_via_affiliate) ? number_format($admin_earnings_via_affiliate, 2) : '0.00' ?>
                            </div>
                            <div class="text-muted mt-1">Via affiliate program</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row row-deck row-cards">
                <!-- Sales Summary Chart -->
                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Sales Summary</h3>
                            <div class="card-actions">
                                <ul class="nav nav-pills card-header-pills" data-bs-toggle="tabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a href="#tabs-monthly" class="nav-link active sales-chart-tab"
                                            data-bs-toggle="tab" data-period="Monthly" aria-selected="true" role="tab">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <rect x="4" y="5" width="16" height="16" rx="2"></rect>
                                                <line x1="16" y1="3" x2="16" y2="7"></line>
                                                <line x1="8" y1="3" x2="8" y2="7"></line>
                                                <line x1="4" y1="11" x2="20" y2="11"></line>
                                            </svg>
                                            Month
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a href="#tabs-weekly" class="nav-link sales-chart-tab" data-bs-toggle="tab"
                                            data-period="Weekly" aria-selected="false" role="tab" tabindex="-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <circle cx="12" cy="12" r="9"></circle>
                                                <polyline points="12 7 12 12 15 15"></polyline>
                                            </svg>
                                            Week
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a href="#tabs-daily" class="nav-link sales-chart-tab" data-bs-toggle="tab"
                                            data-period="Daily" aria-selected="false" role="tab" tabindex="-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <circle cx="12" cy="12" r="9"></circle>
                                                <line x1="3.6" y1="9" x2="20.4" y2="9"></line>
                                                <line x1="3.6" y1="15" x2="20.4" y2="15"></line>
                                                <line x1="11.5" y1="3" x2="12.5" y2="21"></line>
                                            </svg>
                                            Day
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="affiliate-sales-chart" style="height: 350px;"></div>
                        </div>
                    </div>
                </div>

                <!-- Top Selling Categories Chart -->
                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Top Selling Categories</h3>
                        </div>
                        <div class="card-body">
                            <div id="affiliate-category-chart" style="height: 350px;"></div>
                        </div>
                        <div class="card-body" id="category-no-data"
                            style="display: none; text-align: center; height: 350px;">
                            <div class="d-flex align-items-center justify-content-center h-100">
                                <div class="text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg text-muted mb-3"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <circle cx="12" cy="12" r="9"></circle>
                                        <line x1="9" y1="10" x2="9.01" y2="10"></line>
                                        <line x1="15" y1="10" x2="15.01" y2="10"></line>
                                        <path d="M9.5 15.25a3.5 3.5 0 0 1 5 0"></path>
                                    </svg>
                                    <h3 class="text-muted">No Data Available</h3>
                                    <p class="text-muted">No category sales data found</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ApexCharts is loaded from the template, charts are initialized in custom.js -->