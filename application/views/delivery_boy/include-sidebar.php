<?php $settings = get_settings('system_settings', true);
$auth_settings = get_settings('authentication_settings', true);
?>

<aside class="navbar navbar-vertical navbar-expand-lg overflow-auto" data-bs-theme="dark">
    <div class="container-fluid">
        <!-- BEGIN NAVBAR TOGGLER -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
            aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- END NAVBAR TOGGLER -->

        <div class="navbar-brand navbar-brand-autodark">
            <a href="<?= base_url('delivery-boy/home') ?>" aria-label="Delivery Boy Panel"
                class="d-flex align-items-center text-decoration-none">
                <img src="<?= base_url() . get_settings('favicon') ?>" alt="<?= $settings['app_name']; ?>"
                    title="<?= $settings['app_name']; ?>" class="me-2" height="64" width="64">
                <div class="d-flex flex-column">
                    <!--<span class="small brand-text lh-1 text-wrap"><?= $settings['app_name']; ?></span>-->
                </div>
            </a>
        </div>

        <input type="hidden" id="auth_settings" name="auth_settings"
            value='<?= isset($auth_settings['authentication_method']) ? $auth_settings['authentication_method'] : ''; ?>'>

        <div class="collapse navbar-collapse" id="sidebar-menu">
            <!-- BEGIN NAVBAR MENU -->
            <ul class="navbar-nav pt-lg-3">
                <!-- Home/Dashboard -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('delivery-boy/home') ?>">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="ti ti-home"></i>
                        </span>
                        <span class="nav-link-title">Home</span>
                    </a>
                </li>

                <!-- Orders -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('delivery-boy/orders/') ?>">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="ti ti-shopping-cart"></i></span>
                        </span>
                        <span class="nav-link-title">Orders</span>
                    </a>
                </li>

                <!-- Fund Transfers -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('delivery-boy/fund-transfer/') ?>">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="ti ti-transaction-dollar"></i>
                        </span>
                        <span class="nav-link-title">Fund Transfers</span>
                    </a>
                </li>

                <!-- Cash Collection -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('delivery-boy/fund-transfer/manage-cash') ?>">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="ti ti-moneybag"></i></span>
                        <span class="nav-link-title">Cash Collection</span>
                    </a>
                </li>

                <!-- Transactions -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('delivery-boy/fund-transfer/manage-transactions') ?>">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="ti ti-receipt-dollar"></i>
                        </span>
                        <span class="nav-link-title">Transactions</span>
                    </a>
                </li>

                <!-- Privacy Policy -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('delivery-boy/policy') ?>">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="ti ti-shield"></i>
                        </span>
                        <span class="nav-link-title">Privacy Policy</span>
                    </a>
                </li>

                <!-- Terms & Conditions -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('delivery-boy/policy/terms_conditions') ?>">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                           <i class="ti ti-file-certificate"></i>
                        </span>
                        <span class="nav-link-title">Terms & Conditions</span>
                    </a>
                </li>
            </ul>
            <!-- END NAVBAR MENU -->
        </div>
    </div>
</aside>