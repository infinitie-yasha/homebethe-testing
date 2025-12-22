<?php $current_version = get_current_version(); ?>
<div class="sticky-top">
    <header class="navbar navbar-expand-md sticky-top d-print-none">
        <div class="container navbar-container me-0">

            <!-- Navbar Brand / Version -->
            <div class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
              
            </div>

            <!-- Navbar Items -->
            <div class="navbar-nav flex-row order-md-last">

                <div class="nav-item d-none d-md-flex me-3"></div>

                <div class="d-none d-md-flex">

                    <!-- Dark Mode Toggle -->
                    <div class="nav-item">
                        <a href="#" id="theme-dark" class="nav-link px-0" title="Enable dark mode"
                            data-bs-toggle="tooltip" data-bs-placement="bottom">
                            <i class="ti ti-moon"></i>
                        </a>
                        <a href="#" id="theme-light" class="nav-link px-0" style="display: none;"
                            title="Enable light mode" data-bs-toggle="tooltip" data-bs-placement="bottom">
                            <i class="ti ti-sun"></i>
                        </a>
                    </div>

                </div>

                <!-- Navbar End / User Dropdown -->
                <div class="navbar-nav flex-row ms-auto"> <!-- ms-auto pushes items to the right -->
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 p-0 px-2" data-bs-toggle="dropdown"
                            aria-label="Open user menu">
                            <?php
                            $user = $this->ion_auth->user()->row();
                            $avatar = (!empty($user->image)) ? base_url($user->image) : base_url(NO_USER_IMAGE);
                            ?>
                            <span class="avatar avatar-sm">
                                <img src="<?= $avatar ?>"
                                    alt="<?= !empty($user->username) ? $user->username : 'User' ?>">
                            </span>

                            <div class="d-none d-xl-block ps-2">
                                <div><?= ucfirst($this->ion_auth->user()->row()->username) ?></div>
                                <div class="mt-1 small text-secondary">
                                    <?php if ($this->ion_auth->is_affiliate_user()) { ?>Affiliate<?php } ?>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <?php if ($this->ion_auth->is_affiliate_user()) { ?>
                                <a href="<?= base_url('affiliate/home/profile') ?>" class="dropdown-item">
                                    <i class="ti ti-user me-2"></i> Profile
                                </a>
                            <?php } ?>
                            <div class="dropdown-divider"></div>
                            <a href="<?= base_url('affiliate/home/logout') ?>" class="dropdown-item">
                                <i class="ti ti-logout me-2"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </header>
</div>