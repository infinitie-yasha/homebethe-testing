<div class="page-wrapper">
    <div class="page-body">
        <div class="container-xl">
            <!-- ===========================
                 STATUS CARDS
            ============================ -->
            <div class="row row-cards g-3 mb-4">
                <!-- Pending -->
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="card shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <span class="avatar avatar-lg rounded-circle me-3">
                                <i class="ti ti-clock fs-2 text-teal"></i>
                            </span>
                            <div>
                                <div class="fw-semibold text-dark">Pending</div>
                                <div class="h5 fw-bold mb-1">
                                    <?= $currency ?><?= number_format($earning_data['pending'], 2) ?>
                                </div>
                                <div class="text-muted small"><?= $product_status_message ?? 'Awaiting confirmation' ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Confirmed -->
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="card shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <span class="avatar avatar-lg rounded-circle me-3">
                                <i class="ti ti-check fs-2 text-green"></i>
                            </span>
                            <div>
                                <div class="fw-semibold text-dark">Confirmed</div>
                                <div class="h5 fw-bold mb-1">
                                    <?= $currency ?><?= number_format($earning_data['confirm'], 2) ?>
                                </div>
                                <div class="text-muted small">Payment confirmed</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Paid -->
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="card shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <span class="avatar avatar-lg rounded-circle me-3">
                                <i class="ti ti-credit-card fs-2 text-warning"></i>
                            </span>
                            <div>
                                <div class="fw-semibold text-dark">Paid</div>
                                <div class="h5 fw-bold mb-1">
                                    <?= $currency ?><?= number_format($earning_data['paid'], 2) ?>
                                </div>
                                <div class="text-muted small">Funds released</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Requested -->
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="card shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <span class="avatar avatar-lg rounded-circle me-3">
                                <i class="ti ti-send fs-2 text-red"></i>
                            </span>
                            <div>
                                <div class="fw-semibold text-dark">Requested</div>
                                <div class="h5 fw-bold mb-1">
                                    <?= $currency ?><?= number_format($earning_data['requested'], 2) ?>
                                </div>
                                <div class="text-muted small">Awaiting approval</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Link -->
            <div class="mb-4">
                <a href="#" class="text-muted small" data-bs-toggle="offcanvas" data-bs-target="#infoModal">
                    What's this?
                </a>
            </div>

            <!-- ===========================
                 EARNINGS + CATEGORIES
            ============================ -->
           <div class="row g-4">
    <!-- Earnings Summary -->
    <div class="col-xl-7 col-lg-7 col-md-12 col-12">
        <div class="card card-shadow h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                    <h3 class="card-title mb-0">Earnings Summary</h3>

                    <ul class="nav nav-pills nav-pills-rounded chart-action btn-group sales-tab flex-nowrap">
                        <li class="nav-item">
                            <a class="btn-sm nav-link px-2 py-1 active monthlyChart" href="#Monthly">Month</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn-sm nav-link px-2 py-1 weeklyChart" href="#Weekly">Week</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn-sm nav-link px-2 py-1 dailyChart" href="#Daily">Day</a>
                        </li>
                    </ul>
                </div>

                <div id="Chart" class="affiliate-chart-container mt-3"
                     style="min-height: 260px; width: 100%; overflow: hidden;">
                </div>
            </div>
        </div>
    </div>

    <!-- Top Selling Categories -->
    <div class="col-xl-5 col-lg-5 col-md-12 col-12">
        <div class="card h-100">
            <div class="card-header">
                <h3 class="card-title mb-0">Top Selling Categories</h3>
            </div>
            <div class="card-body">
                <div id="piechart_3d_affiliate" class="piechat_height"
                     style="min-height: 260px; width:100%; overflow:hidden;">
                </div>
            </div>
        </div>
    </div>
</div>











            
            <!-- ===========================
                 EXPLORE CATEGORIES SECTION
            ============================ -->
           <div class="row mt-4">
    <div class="col-12">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Explore Categories</h3>
                <span class="badge bg-primary-lt"><?= count($affiliate_categories) ?> Categories</span>
            </div>
            <div class="card-body p-4">
                <?php if (!empty($affiliate_categories)) { ?>
                    <!-- Horizontal Scroll Container -->
                    <div style="display: flex; gap: 0.5rem; overflow-x: auto; padding-bottom: 10px; scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch;">
                        <?php foreach ($affiliate_categories as $index => $affiliate_category) { ?>
                            <div style="flex: 0 0 auto; width: 150px; scroll-snap-align: start;">
                                <a href="<?= base_url('affiliate/product/get_categories_products/' . $affiliate_category['id']) ?>"
                                   style="display: block; text-decoration: none; position: relative; animation: fadeInScale 0.6s ease-out forwards; animation-delay: <?= $index * 0.15 ?>s; opacity: 0;">
                                    <div style="border: 0; border-radius: 8px; overflow: hidden; height: 150px;">
                                        <img src="<?= base_url($affiliate_category['image']) ?>"
                                             alt="<?= htmlspecialchars($affiliate_category['name']) ?>"
                                             style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;">
                                        <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(to bottom, rgba(0,0,0,0) 40%, rgba(0,0,0,0.8) 100%); display: flex; flex-direction: column; justify-content: flex-end; padding: 8px;">
                                            <h4 style="color: white; margin: 0 0 4px 0; font-size: 14px; font-weight: 500;">
                                                <?= htmlspecialchars($affiliate_category['name']) ?>
                                            </h4>
                                            <div style="display: flex; align-items: center; color: white; font-size: 12px;">
                                                <small style="font-weight: medium;">Shop Now</small>
                                                <svg xmlns="http://www.w3.org/2000/svg" style="width: 14px; height: 14px; margin-left: 4px;" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M5 12h14" />
                                                    <path d="M15 16l4 -4" />
                                                    <path d="M15 8l4 4" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                <?php } else { ?>
                    <!-- Empty State -->
                    <div style="text-align: center; padding: 40px;">
                        <div style="margin-bottom: 16px;">
                            <img src="./static/illustrations/undraw_empty_cart_co35.svg" style="height: 96px;" alt="No categories">
                        </div>
                        <h3 style="margin-bottom: 8px; font-size: 18px;">No Categories Available</h3>
                        <p style="color: #6c757d; margin-bottom: 16px; font-size: 14px;">
                            It looks like there are no affiliate categories to display right now.
                        </p>
                        <div>
                            <a href="<?= base_url('affiliate/home') ?>" style="display: inline-flex; align-items: center; padding: 8px 16px; border: 1px solid #343a40; border-radius: 4px; color: #343a40; text-decoration: none; font-size: 14px;">
                                <svg xmlns="http://www.w3.org/2000/svg" style="width: 20px; height: 20px; margin-right: 8px;" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                    <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                    <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                </svg>
                                Back to Home
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

            <!-- ===========================
                 MODALS & OFFCANVAS
            ============================ -->
            <div class="modal modal-blur fade" id="profitInfoModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">All Time Total Profit</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p class="text-muted">
                                This is the total profit earned across both Finance and Non-Finance brands since you joined EarnKaro.
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Got it</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Modal -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="infoModal">
                <div class="offcanvas-header border-bottom">
                    <h5 class="offcanvas-title">Profit Status Information</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="offcanvas-body">
                    <div class="mb-3">
                        <h6 class="text-primary">Pending Profit</h6>
                        <p class="text-muted">Your profit has been tracked and will be processed after the return or cancellation period.</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-primary">Confirmed Profit</h6>
                        <p class="text-muted">Your profit is ready to be withdrawn. Tap <span class="text-success fw-bold">'Request Payment'</span> to transfer it to your bank account.</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-primary">Paid Profit</h6>
                        <p class="text-muted">Your profit has been paid. Keep sharing to earn more!</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-primary">Requested Profit</h6>
                        <p class="text-muted">Your withdrawal request is being processed and will be completed soon.</p>
                    </div>
                </div>
                <div class="offcanvas-footer border-top text-end p-3">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.category-card:hover img {
    transform: scale(1.05);
}
@keyframes fadeInScale {
    0% {opacity: 0; transform: scale(0.95);}
    100% {opacity: 1; transform: scale(1);}
}
</style>
