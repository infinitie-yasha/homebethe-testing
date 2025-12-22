<?php $current_version = get_current_version(); ?>
<div class="sticky-top">
    <header class="navbar navbar-expand-md sticky-top d-print-none">
        <div class="container-xl navbar-container">
            <!-- BEGIN NAVBAR TOGGLER -->
            <!-- <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbar-menu"
                aria-controls="navbar-menu"
                aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button> -->
            <!-- END NAVBAR TOGGLER -->

            <!-- BEGIN NAVBAR LOGO -->
            <div class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                <!-- <span class="badge bg-cyan-lt">v <?= (isset($current_version) && !empty($current_version)) ? $current_version : '1.0' ?></span> -->
            </div>
            <!-- END NAVBAR LOGO -->

            <div class="navbar-nav flex-row order-md-last">
                <!-- Google Translate -->
                <!-- <div class="nav-item d-none d-md-flex me-3">
                    <div id="google_translate_element"></div>
                </div> -->

                <?php if (ALLOW_MODIFICATION == 0) { ?>
                    <div class="nav-item">
                        <a class="nav-link px-0" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                                <path d="M4 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                <path d="M4 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                <path d="M14 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                <path d="M14 7l6 0" />
                                <path d="M17 4l0 6" />
                            </svg>
                        </a>
                    </div>
                <?php } ?>

                <div class="nav-item dropdown">
                    <div class="nav-link d-flex lh-1 p-0 px-2">
                        <!-- Dark Mode Icon -->
                        <a href="#" id="theme-dark" class="nav-link px-2 me-4" title="Enable dark mode" data-bs-toggle="tooltip" data-bs-placement="bottom">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" />
                            </svg>
                        </a>

                        <!-- Light Mode Icon -->
                        <a href="#" id="theme-light" class="nav-link px-2 me-4" style="display: none;" title="Enable light mode" data-bs-toggle="tooltip" data-bs-placement="bottom">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                <path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" />
                            </svg>
                        </a>
                        <a href="#" class="nav-link d-flex lh-1px-2" data-bs-toggle="dropdown" aria-label="Open user menu">
                            <span class="avatar avatar-sm">
                                <?php if (!empty($this->ion_auth->user()->row()->image)) { ?>
                                    <img src="<?= base_url($this->ion_auth->user()->row()->image) ?>" alt="">
                                <?php } else { ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                <?php } ?>
                            </span>
                            <div class="d-none d-xl-block ps-2">
                                <div><?= ucfirst($this->ion_auth->user()->row()->username) ?></div>
                                <div class="mt-1 small text-secondary">
                                    <?php if ($this->ion_auth->is_admin()) { ?>
                                        Administrator
                                    <?php } else { ?>
                                        Delivery Boy
                                    <?php } ?>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <div class="dropdown-header">
                                Welcome <strong><?= ucfirst($this->ion_auth->user()->row()->username) ?></strong>!
                            </div>
                            <div class="dropdown-divider"></div>

                            <?php if ($this->ion_auth->is_admin()) { ?>
                                <a href="<?= base_url('admin/home/profile') ?>" class="dropdown-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon dropdown-item-icon">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="<?= base_url('admin/home/logout') ?>" class="dropdown-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon dropdown-item-icon">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                        <polyline points="16,17 21,12 16,7"></polyline>
                                        <line x1="21" y1="12" x2="9" y2="12"></line>
                                    </svg>
                                    Logout
                                </a>
                            <?php } else { ?>
                                <a href="<?= base_url('delivery-boy/home/profile') ?>" class="dropdown-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon dropdown-item-icon">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="<?= base_url('delivery-boy/home/logout') ?>" class="dropdown-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon dropdown-item-icon">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                        <polyline points="16,17 21,12 16,7"></polyline>
                                        <line x1="21" y1="12" x2="9" y2="12"></line>
                                    </svg>
                                    Logout
                                </a>
                            <?php } ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </header>
</div>