<?php
$currency = get_settings('currency');

?>
<input type="hidden" id="currency" class="form-control" value="<?= $currency ?>">
<div class="sticky-top">
    <header class="navbar navbar-expand-md sticky-top d-print-none">
        <div class="container-xl navbar-container">

            <!-- BEGIN NAVBAR LOGO -->
            <div class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">

            </div>
            <!-- END NAVBAR LOGO -->
            <div class="navbar-nav flex-row order-md-last gap-2">

                <div class="d-flex">
                    <div class="nav-item">
                        <!-- Dark Mode Icon -->
                        <a href="#" id="theme-dark" class="nav-link" style="display: none;" title="Enable dark mode"
                            data-bs-toggle="tooltip" data-bs-placement="bottom">
                            <i class="ti ti-moon fs-3"></i>
                        </a>
                        <!-- Light Mode Icon -->
                        <a href="#" id="theme-light" class="nav-link" title="Enable light mode" data-bs-toggle="tooltip"
                            data-bs-placement="bottom">
                            <i class="ti ti-sun fs-3"></i>
                        </a>

                    </div>
                    <!-- start send admin notification  -->
                    <?php
                    $notifications = fetch_details('system_notification', NULL, '*', '3', '0', 'read_by', 'ASC', '', '');
                    $count_noti = fetch_details('system_notification', ["read_by" => 0], 'count(id) as total');
                    // print_r($count_noti);
                    ?>

                    <div id="refresh_notification"> </div>
                    <div id="list" class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
                    </div>



                </div>
                <input type="hidden" id="profile_img" value="<?= base_url($this->ion_auth->user()->row()->image) ?>">
                <div class="nav-item dropdown" id="user-profile-dropdown">
                    <a href="#" class="nav-link d-flex lh-1 p-0 px-2" data-bs-toggle="dropdown" data-bs-auto-close="true"
                        aria-label="Open user menu" aria-expanded="false">
                        <span class="avatar avatar-sm">
                            <img src="<?= base_url($this->ion_auth->user()->row()->image) ?>" alt="">
                        </span>
                        <div class="d-none d-xl-block ps-2">
                            <div><?= ucfirst($this->ion_auth->user()->row()->username) ?></div>
                            <div class="mt-1 small text-secondary">
                                <?php if ($this->ion_auth->is_admin()) { ?>
                                    admin
                                <?php } ?>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <?php if ($this->ion_auth->is_admin()) {
                            // echo "<pre>";
                            // print_r($this->ion_auth->user()->row());
                            ?>
                            <a href="<?= base_url('admin/home/profile') ?>" class="dropdown-item">Profile</a>
                            

                        <?php } ?>
                        <div class="dropdown-divider"></div>
                        <a href="<?= base_url('admin/home/logout') ?>" class="dropdown-item">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

</div>

