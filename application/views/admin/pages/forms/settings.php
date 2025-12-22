<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">Store Settings</h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="d-flex">
                            <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/home') ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="javascript:void(0)">Settings</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">Store Settings</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE HEADER -->

        <div class="page-body">
            <div class="container-xl payment-container">
                <div class="row g-5">
                    <div class="col-sm-2">
                        <div class="sticky-top" style="top: 80px;">
                            <nav class="nav nav-vertical nav-pills" id="pills">
                                <a class="nav-link" href="#store_information">Store Information</a>
                                <a class="nav-link" href="#logo_settings">Logo Settings</a>
                                <a class="nav-link" href="#system_settings">Localization & Regional Settings</a>
                                <a class="nav-link" href="#app_settings">App Versioning</a>
                                <a class="nav-link" href="#order_settings">Cart & Order Settings</a>
                                <a class="nav-link" href="#delivery_system">Delivery Settings</a>
                                <a class="nav-link" href="#referral_settings">Referral Settings</a>
                                <a class="nav-link" href="#wallet_settings">Wallet Settings</a>
                                <a class="nav-link" href="#delivery_boy_settings">Delivery Boy Settings</a>
                                <a class="nav-link" href="#app_features">App Features</a>
                                <a class="nav-link" href="#native_app_links">Native App Links & Deep Linking</a>
                                <a class="nav-link" href="#cron_job_urls">Cron Jobs</a>
                                <a class="nav-link" href="#maintenance_mode">Maintenance Mode</a>
                            </nav>
                        </div>
                    </div>
                    <div class="col-sm" data-bs-spy="scroll" data-bs-target="#pills" data-bs-offset="80" tabindex="0">
                        <form x-data="ajaxForm({
                                            url: base_url + 'admin/setting/update_system_settings',
                                            modalId: '',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="system_settings_form"
                            enctype="multipart/form-data">
                            <input type="hidden" id="system_configurations" name="system_configurations" required=""
                                value="1" aria-required="true">
                            <input type="hidden" id="system_timezone_gmt" name="system_timezone_gmt"
                                value="<?= (isset($settings['system_timezone_gmt']) && !empty($settings['system_timezone_gmt'])) ? $settings['system_timezone_gmt'] : '+05:30'; ?>"
                                aria-required="true">
                            <input type="hidden" id="system_configurations_id" name="system_configurations_id"
                                value="13" aria-required="true">

                            <!-- store_information -->
                            <div class="card" id="store_information">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="ti ti-settings-2"></i> Store Information</h3>
                                </div>
                                <div class="card-body">

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="app_name">App Name</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="app_name" id="app_name"
                                                value="<?= (isset($settings['app_name'])) ? $settings['app_name'] : '' ?>"
                                                placeholder="Name of the App - used in whole system" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="support_number">Support Number</label>
                                        <div class="col">
                                            <input type="number" class="form-control" name="support_number" min="0"
                                                id="support_number"
                                                value="<?= (isset($settings['support_number'])) ? $settings['support_number'] : '' ?>"
                                                placeholder="Support Number" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="support_email">Support Email</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="support_email"
                                                id="support_email"
                                                value="<?= (isset($settings['support_email'])) ? $settings['support_email'] : '' ?>"
                                                placeholder="Support Email" />
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="copyright_details">Copyright
                                            Details</label>
                                        <div class="col">
                                            <textarea name="copyright_details" class="textarea form-control"
                                                placeholder="Copyright Details"
                                                data-bs-toggle="autosize">  <?= @str_replace('\"', '', str_replace('\r\n', '&#13;&#10;', $settings['copyright_details'])) ?></textarea>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="tax_name">Tax Name</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="tax_name" id="tax_name"
                                                value="<?= (isset($settings['tax_name'])) ? $settings['tax_name'] : '' ?>"
                                                placeholder="Example: GST Number / VAT / TIN Number" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="tax_number">Tax Number</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="tax_number" id="tax_number"
                                                value="<?= (isset($settings['tax_number'])) ? $settings['tax_number'] : '' ?>"
                                                placeholder="Example: GSTIN240000120" />
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- logo_settings -->
                            <div class="card my-3" id="logo_settings">
                                <div
                                    class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                                    <h3 class="card-title mb-0 d-flex align-items-center gap-2">
                                        <i class="ti ti-library-photo"></i> Logo Settings
                                    </h3>
                                </div>

                                <div class="card-body">

                                    <!-- LOGO UPLOAD -->
                                    <div class="mb-4 row form-group">
                                        <label class="col-12 col-md-3 col-form-label" for="logo">Logo</label>
                                        <div class="col-12 col-md-9">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <small class="text-muted">
                                                    <i class="ti ti-info-circle"></i>
                                                    Recommended: 500 x 200 pixels
                                                </small>
                                                <a class="btn btn-primary btn-sm uploadFile" data-input="logo"
                                                    data-isremovable="0" data-is-multiple-uploads-allowed="0"
                                                    data-bs-toggle="modal" data-bs-target="#media-upload-modal">
                                                    <i class="ti ti-photo-plus"></i> Upload Logo
                                                </a>
                                            </div>

                                            <div class="row g-3 image-upload-div">
                                                <?php if (!empty($logo)): ?>
                                                    <div class="col-6 col-md-4 col-lg-3">
                                                        <div class="card shadow-sm h-100">
                                                            <div
                                                                class="card-img-top position-relative ratio ratio-16x9 overflow-hidden">
                                                                <img src="<?= BASE_URL() . $logo ?>" alt="Logo"
                                                                    class="position-absolute top-0 start-0 w-100 h-100 object-fit-contain bg-light">
                                                                <div class="position-absolute top-0 start-0 p-2">
                                                                    <span class="badge bg-dark-lt">
                                                                        <i class="ti ti-photo"></i> Logo
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="logo" value="<?= $logo ?>">
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- FAVICON UPLOAD -->
                                    <div class="mb-4 row form-group">
                                        <label class="col-12 col-md-3 col-form-label" for="favicon">Favicon</label>
                                        <div class="col-12 col-md-9">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <small class="text-muted">
                                                    <i class="ti ti-info-circle"></i>
                                                    Recommended: 32 x 32 pixels (square)
                                                </small>
                                                <a class="btn btn-primary btn-sm uploadFile" data-input="favicon"
                                                    data-isremovable="0" data-is-multiple-uploads-allowed="0"
                                                    data-bs-toggle="modal" data-bs-target="#media-upload-modal">
                                                    <i class="ti ti-photo-plus"></i> Upload Favicon
                                                </a>
                                            </div>

                                            <div class="row g-3 image-upload-div">
                                                <?php if (!empty($favicon)): ?>
                                                    <div class="col-6 col-md-4 col-lg-3">
                                                        <div class="card shadow-sm h-100">
                                                            <div
                                                                class="card-img-top position-relative ratio ratio-1x1 overflow-hidden">
                                                                <img src="<?= BASE_URL() . $favicon ?>" alt="Favicon"
                                                                    class="position-absolute top-0 start-0 w-100 h-100 object-fit-contain bg-light p-4">
                                                                <div class="position-absolute top-0 start-0 p-2">
                                                                    <span class="badge bg-dark-lt">
                                                                        <i class="ti ti-photo"></i> Favicon
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="favicon" value="<?= $favicon ?>">
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            <!-- System Settings -->
                            <div class="card my-3" id="system_settings">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="ti ti-world-cog"></i> Localization & Regional
                                        Settings</h3>
                                </div>
                                <div class="card-body">

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="system_timezone">System
                                            Timezone</label>
                                        <div class="col">
                                            <select name="system_timezone" id="system_timezone" class="form-select">
                                                <option value="">--Select Timezone--</option>
                                                <?php foreach ($timezone as $t): ?>
                                                    <option value="<?= $t["zone"] ?>" data-gmt="<?= $t['diff_from_GMT']; ?>"
                                                        <?= (isset($settings['system_timezone']) && $settings['system_timezone'] == $t["zone"]) ? 'selected' : ''; ?>>
                                                        <?= $t['zone'] . ' - ' . $t['diff_from_GMT'] . ' - ' . $t['time']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="supported_locals">Country Currency
                                            Code</label>
                                        <div class="col">
                                            <select name="supported_locals" id="supported_locals" class="form-select">
                                                <?php
                                                $CI = &get_instance();
                                                $CI->config->load('eshop');
                                                $supported_methods = $CI->config->item('supported_locales_list');
                                                foreach ($supported_methods as $key => $value) {
                                                    $text = "$key - $value "; ?>
                                                    <option value="<?= $key ?>" <?= (isset($settings['supported_locals']) && !empty($settings['supported_locals']) && $key == $settings['supported_locals']) ? "selected" : "" ?>>
                                                        <?= $key . ' - ' . $value ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="currency">System Currency
                                            Symbol</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="currency" id="currency"
                                                value="<?= (isset($settings['currency'])) ? $settings['currency'] : '' ?>"
                                                placeholder="Either Symbol or Code - For Example $ or USD" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label required" for="decimal_point">Decimal
                                            Point</label>
                                        <div class="col">
                                            <select name="decimal_point" id="decimal_point" class="form-select">
                                                <?php
                                                $CI = &get_instance();
                                                $CI->config->load('eshop');
                                                $decimal_points = $CI->config->item('decimal_point');
                                                foreach ($decimal_points as $key => $value) {
                                                    $text = "$key - $value "; ?>
                                                    <option value="<?= $key ?>" <?= (isset($settings['decimal_point']) && !empty($settings['decimal_point']) && $key == $settings['decimal_point']) ? "selected" : "" ?>>
                                                        <?= $value ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- app_settings -->
                            <div class="card my-3" id="app_settings">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="ti ti-settings"></i> App Settings</h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="current_version">Current Version Of
                                            Android APP</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="current_version"
                                                id="current_version"
                                                value="<?= (isset($settings['current_version'])) ? $settings['current_version'] : '' ?>"
                                                placeholder="Current Version For Android APP" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="current_version_ios">Current Version Of
                                            IOS APP</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="current_version_ios"
                                                id="current_version_ios"
                                                value="<?= (isset($settings['current_version_ios'])) ? $settings['current_version_ios'] : '' ?>"
                                                placeholder="Current Version For IOS APP" />
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="is_version_system_on">Version System
                                            Status</label>
                                        <div class="col">
                                            <label class="form-check form-switch form-switch-3">
                                                <input class="form-check-input" name="is_version_system_on"
                                                    id="is_version_system_on" type="checkbox"
                                                    <?= (@$settings['is_version_system_on']) == '1' ? 'Checked' : '' ?> />
                                            </label>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- order_settings -->
                            <div class="card my-3" id="order_settings">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="ti ti-shopping-cart"></i> Cart & Order Settings
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="minimum_cart_amt">Minimum Cart Amount
                                            (<?= $currency ?>)</label>
                                        <div class="col">
                                            <input type="number" class="form-control" name="minimum_cart_amt" min="0"
                                                id="minimum_cart_amt"
                                                value="<?= (isset($settings['minimum_cart_amt'])) ? $settings['minimum_cart_amt'] : '' ?>"
                                                placeholder="Minimum Cart Amount" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="max_items_cart">Maximum Items Allowed
                                            In Cart</label>
                                        <div class="col">
                                            <input type="number" class="form-control" name="max_items_cart"
                                                id="max_items_cart"
                                                value="<?= (isset($settings['max_items_cart'])) ? $settings['max_items_cart'] : '' ?>"
                                                placeholder="Maximum Items Allowed In Cart" min="1" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="low_stock_limit">Low stock
                                            limit</label>
                                        <div class="col">
                                            <input type="number" class="form-control" name="low_stock_limit"
                                                id="low_stock_limit"
                                                value="<?= (isset($settings['low_stock_limit'])) ? $settings['low_stock_limit'] : '10' ?>"
                                                placeholder="Maximum Items Allowed In Cart" min="1" />
                                            <small class="form-hint">Product will be considered as low stock</small>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="max_product_return_days">Max days to
                                            return item</label>
                                        <div class="col">
                                            <input type="number" class="form-control" name="max_product_return_days"
                                                id="max_product_return_days"
                                                value="<?= (isset($settings['max_product_return_days'])) ? $settings['max_product_return_days'] : '' ?>"
                                                placeholder="Max days to return item" />
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="is_single_seller_order">Single Seller
                                            Order System</label>
                                        <div class="col">
                                            <label class="form-check form-switch form-switch-3">
                                                <input class="form-check-input" name="is_single_seller_order"
                                                    id="is_single_seller_order" type="checkbox"
                                                    <?= (isset($settings['is_single_seller_order']) && $settings['is_single_seller_order'] == '1') ? 'checked' : '' ?> />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="update_seller_flow">Show Delivery boy
                                            based on seller's zipcode/city</label>
                                        <div class="col">
                                            <label class="form-check form-switch form-switch-3">
                                                <input class="form-check-input" name="update_seller_flow"
                                                    id="update_seller_flow" type="checkbox"
                                                    <?= (isset($settings['update_seller_flow']) && $settings['update_seller_flow'] == '1') ? 'checked' : '' ?> />
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- delivery_system -->
                            <div class="card my-3" id="delivery_system">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="ti ti-truck"></i> Delivery Settings</h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="area_wise_delivery_charge">Zipcode/City
                                            Wise Delivery Charge</label>
                                        <div class="col">
                                            <label class="form-check form-switch form-switch-3">
                                                <input class="form-check-input" name="area_wise_delivery_charge"
                                                    id="area_wise_delivery_charge" type="checkbox"
                                                    <?= (@$settings['area_wise_delivery_charge']) == '1' ? 'Checked' : '' ?> />
                                            </label>
                                        </div>
                                    </div>

                                    <div
                                        class="mb-3 row delivery_charge <?= (isset($settings['area_wise_delivery_charge']) && $settings['area_wise_delivery_charge'] == '1') ? 'd-none' : '' ?>">
                                        <label class="col-3 col-form-label required" for="delivery_charge">Delivery
                                            Charge Amount (<?= $currency ?>)</label>
                                        <div class="col">
                                            <input type="number" class="form-control" name="delivery_charge" min="0"
                                                id="delivery_charge"
                                                value="<?= (isset($settings['delivery_charge'])) ? $settings['delivery_charge'] : '' ?>"
                                                placeholder="Delivery Charge on Shopping" min="0" />
                                        </div>
                                    </div>

                                    <div
                                        class="mb-3 row min_amount <?= (isset($settings['area_wise_delivery_charge']) && $settings['area_wise_delivery_charge'] == '1') ? 'd-none' : '' ?>">
                                        <label class="col-3 col-form-label required" for="min_amount">Minimum Amount for
                                            Free Delivery (<?= $currency ?>)</label>
                                        <div class="col">
                                            <input type="number" class="form-control" name="min_amount" id="min_amount"
                                                min="0"
                                                value="<?= (isset($settings['min_amount'])) ? $settings['min_amount'] : '' ?>"
                                                placeholder="Minimum Order Amount for Free Delivery" min="0" />
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- referral_settings -->
                            <div class="card my-3" id="referral_settings">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="ti ti-coins"></i> Refer & Earn Settings</h3>
                                </div>

                                <div class="card-body">
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="is_refer_earn_on">Refer & Earn
                                            Status</label>
                                        <div class="col">
                                            <label class="form-check form-switch form-switch-3">
                                                <input class="form-check-input" name="is_refer_earn_on"
                                                    id="is_refer_earn_on" type="checkbox"
                                                    <?= (isset($settings['is_refer_earn_on']) && $settings['is_refer_earn_on'] == '1') ? 'checked' : '' ?> />
                                                <small class="form-hint"><a href="" class="text-decoration-none"
                                                        data-bs-toggle="modal" data-bs-target="#ReferAndEarnModal"> How
                                                        Refer & Earn works? </a></small>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="min_refer_earn_order_amount">Minimum
                                            Order Amount(<?= $currency ?>)</label>
                                        <div class="col">
                                            <input type="number" class="form-control" name="min_refer_earn_order_amount"
                                                min="0" id="min_refer_earn_order_amount"
                                                value="<?= (isset($settings['min_refer_earn_order_amount'])) ? $settings['min_refer_earn_order_amount'] : '' ?>"
                                                placeholder="Amount of order eligible for bonus" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="refer_earn_bonus_times">Number of times
                                            Code can be redeemed</label>
                                        <div class="col">
                                            <input type="number" class="form-control" name="refer_earn_bonus_times"
                                                min="0" id="refer_earn_bonus_times"
                                                value="<?= (isset($settings['refer_earn_bonus_times'])) ? $settings['refer_earn_bonus_times'] : '' ?>"
                                                placeholder="No of times customer will get bonus" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="refer_earn_method_for_user">Refer &
                                            Earn Method For User</label>
                                        <div class="col">
                                            <select name="refer_earn_method_for_user" id="refer_earn_method_for_user"
                                                class="form-select">
                                                <option value="">Select</option>
                                                <option value="percentage"
                                                    <?= (isset($settings['refer_earn_method_for_user']) && $settings['refer_earn_method_for_user'] == "percentage") ? "selected" : "" ?>>Percentage</option>
                                                <option value="amount"
                                                    <?= (isset($settings['refer_earn_method_for_user']) && $settings['refer_earn_method_for_user'] == "amount") ? "selected" : "" ?>>Amount</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="refer_earn_bonus_for_user">Refer & Earn
                                            Bonus For User (<?= $currency ?> OR %)</label>
                                        <div class="col">
                                            <input type="number" class="form-control" name="refer_earn_bonus_for_user"
                                                min="0" id="refer_earn_bonus_for_user"
                                                value="<?= (isset($settings['refer_earn_bonus_for_user'])) ? $settings['refer_earn_bonus_for_user'] : '' ?>"
                                                placeholder="Amount of order eligible for bonus" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="max_refer_earn_amount_for_user">Maximum
                                            Refer & Earn Amount For User (<?= $currency ?>)</label>
                                        <div class="col">
                                            <input type="number" class="form-control"
                                                name="max_refer_earn_amount_for_user" min="0"
                                                id="max_refer_earn_amount_for_user"
                                                value="<?= (isset($settings['max_refer_earn_amount_for_user'])) ? $settings['max_refer_earn_amount_for_user'] : '' ?>"
                                                placeholder="Maximum Refer & Earn Bonus Amount For User" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="refer_earn_method_for_referal">Refer &
                                            Earn Method For Referral (<?= $currency ?>)</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="refer_earn_method_for_referal"
                                                id="refer_earn_method_for_referal" value="amount" disabled
                                                placeholder="Amount" />
                                            <input type="hidden" class="form-control"
                                                name="refer_earn_method_for_referal" id="refer_earn_method_for_referal"
                                                value="amount" placeholder="Amount" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="refer_earn_bonus_for_referal">Refer &
                                            Earn Bonus For Referral (<?= $currency ?>)</label>
                                        <div class="col">
                                            <input type="number" class="form-control"
                                                name="refer_earn_bonus_for_referal" id="refer_earn_bonus_for_referal"
                                                min="0"
                                                value="<?= (isset($settings['refer_earn_bonus_for_referal'])) ? $settings['refer_earn_bonus_for_referal'] : '' ?>"
                                                placeholder="In amount or percentages For Referral" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- wallet_settings -->
                            <div class="card" id="wallet_settings">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="ti ti-wallet"></i> Welcome Wallet Balance</h3>
                                </div>
                                <div class="card-body">

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="welcome_wallet_balance_on">Wallet
                                            Balance Status</label>
                                        <div class="col">
                                            <label class="form-check form-switch form-switch-3">
                                                <input class="form-check-input" name="welcome_wallet_balance_on"
                                                    id="welcome_wallet_balance_on" type="checkbox"
                                                    <?= (isset($settings['welcome_wallet_balance_on']) && $settings['welcome_wallet_balance_on'] == '1') ? 'checked' : '' ?> />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="wallet_balance_amount">Wallet Balance
                                            Amount (<?= $currency ?>)</label>
                                        <div class="col">
                                            <input type="number" class="form-control" name="wallet_balance_amount"
                                                id="wallet_balance_amount" min="0"
                                                value="<?= (isset($settings['wallet_balance_amount'])) ? $settings['wallet_balance_amount'] : '' ?>"
                                                placeholder="Wallet Balance Amount" />
                                        </div>
                                    </div>



                                </div>
                            </div>

                            <!-- delivery_boy_settings -->
                            <div class="card my-3" id="delivery_boy_settings">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="ti ti-user"></i> Delivery Boy Settings</h3>
                                </div>

                                <div class="card-body">
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="is_delivery_boy_otp_setting_on">Order
                                            Delivery OTP System</label>
                                        <div class="col">
                                            <label class="form-check form-switch form-switch-3">
                                                <input class="form-check-input" name="is_delivery_boy_otp_setting_on"
                                                    id="is_delivery_boy_otp_setting_on" type="checkbox"
                                                    <?= (@$settings['is_delivery_boy_otp_setting_on']) == '1' ? 'Checked' : '' ?> />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="delivery_boy_bonus_percentage">Delivery
                                            Boy Bonus (%)</label>
                                        <div class="col col-form-label">
                                            <input type="number" class="form-control"
                                                name="delivery_boy_bonus_percentage" id="delivery_boy_bonus_percentage"
                                                min="0" max="100"
                                                value="<?= (isset($settings['delivery_boy_bonus_percentage'])) ? $settings['delivery_boy_bonus_percentage'] : '' ?>"
                                                placeholder="Delivery Boy Bonus (%)" />
                                        </div>
                                    </div>


                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="single_seller_system">Single Seller
                                            System</label>
                                        <div class="col col-form-label">
                                            <label class="form-check form-switch form-switch-3">
                                                <input class="form-check-input" name="single_seller_system"
                                                    id="single_seller_system" type="checkbox"
                                                    <?= (@$settings['single_seller_system']) == '1' ? 'Checked' : '' ?> />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="single_seller_system_seller_id">Select
                                            a seller</label>
                                        <div class="col col-form-label" x-data x-init="initTomSelect({
                                                    element: $refs.sellerSelect,
                                                    url: '<?= base_url('admin/product/get_all_sellers_data') ?>',
                                                    placeholder: 'Search Seller...',
                                                    offcanvasId: '',
                                                    maxItems: 1,
                                                    preloadOptions: true,
                                                    preselected: <?= isset($settings['single_seller_system_seller_id']) && $settings['single_seller_system_seller_id'] ? $settings['single_seller_system_seller_id'] : 'null' ?>
                                                })">
                                            <select x-ref="sellerSelect" class="form-select"
                                                name="single_seller_system_seller_id"
                                                id="single-seller-select"></select>
                                        </div>
                                    </div>


                                </div>
                            </div>

                            <!-- app_features -->
                            <div class="card" id="app_features">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="ti ti-apps"></i> App & System Features Settings
                                    </h3>
                                </div>
                                <div class="card-body">

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="cart_btn_on_list">Cart Button on
                                            Products List</label>
                                        <div class="col">
                                            <label class="form-check form-switch form-switch-3">
                                                <input class="form-check-input" name="cart_btn_on_list"
                                                    id="cart_btn_on_list" type="checkbox"
                                                    <?= (isset($settings['cart_btn_on_list']) && $settings['cart_btn_on_list'] == '1') ? 'checked' : '' ?> />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="expand_product_images">Expand Product
                                            Images</label>
                                        <div class="col">
                                            <label class="form-check form-switch form-switch-3">
                                                <input class="form-check-input" name="expand_product_images"
                                                    id="expand_product_images" type="checkbox"
                                                    <?= (isset($settings['expand_product_images']) && $settings['expand_product_images'] == '1') ? 'checked' : '' ?> />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="google_login">Google Login</label>
                                        <div class="col">
                                            <label class="form-check form-switch form-switch-3">
                                                <input class="form-check-input" name="google_login" id="google_login"
                                                    type="checkbox" <?= (isset($settings['google_login']) && $settings['google_login'] == '1') ? 'checked' : '' ?> />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="apple_login">Apple Login</label>
                                        <div class="col">
                                            <label class="form-check form-switch form-switch-3">
                                                <input class="form-check-input" name="apple_login" id="apple_login"
                                                    type="checkbox" <?= (isset($settings['apple_login']) && $settings['apple_login'] == '1') ? 'checked' : '' ?> />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="whatsapp_status">Enable WhatsApp
                                            Settings</label>
                                        <div class="col">
                                            <label class="form-check form-switch form-switch-3">
                                                <input class="form-check-input" name="whatsapp_status"
                                                    id="whatsapp_status" type="checkbox"
                                                    <?= (isset($settings['whatsapp_status']) && $settings['whatsapp_status'] == '1') ? 'checked' : '' ?> />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mb-3 row <?= (isset($settings['whatsapp_status']) && $settings['whatsapp_status'] == 1) ? '' : 'd-none' ?>"
                                        id="whatsapp_number_div">
                                        <label class="col-3 col-form-label" for="whatsapp_number">WhatsApp
                                            Number</label>
                                        <div class="col">
                                            <input type="number" class="form-control" name="whatsapp_number"
                                                id="whatsapp_number"
                                                value="<?= (isset($settings['whatsapp_number'])) ? $settings['whatsapp_number'] : '' ?>"
                                                placeholder="WhatsApp Number" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- native_app_links -->
                            <div class="card my-3" id="native_app_links">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="ti ti-apps"></i> Native App Links & Deep Linking
                                    </h3>
                                </div>

                                <div class="card-body">
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label required"
                                            for="android_app_store_link">Android Play Store Link</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="android_app_store_link"
                                                id="android_app_store_link"
                                                value="<?= (isset($settings['android_app_store_link'])) ? output_escaping($settings['android_app_store_link']) : '' ?>"
                                                placeholder="Android App Store Link" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="ios_app_store_link">iOS App Store
                                            Link</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="ios_app_store_link"
                                                id="ios_app_store_link"
                                                value="<?= (isset($settings['ios_app_store_link'])) ? output_escaping($settings['ios_app_store_link']) : '' ?>"
                                                placeholder="iOS App Store Link" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label required" for="scheme">Scheme For APP</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="scheme" id="scheme"
                                                value="<?= (isset($settings['scheme'])) ? output_escaping($settings['scheme']) : '' ?>"
                                                placeholder="Scheme For APP" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="host">Domain name For APP</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="host" id="host"
                                                value="<?= (isset($settings['host'])) ? output_escaping($settings['host']) : '' ?>"
                                                placeholder="Domain name For APP" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label required" for="app_store_id">App Store
                                            Id</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="app_store_id"
                                                id="app_store_id"
                                                value="<?= (isset($settings['app_store_id'])) ? output_escaping($settings['app_store_id']) : '' ?>"
                                                placeholder="App Store Id" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="default_country_code">Default Country
                                            Code</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="default_country_code"
                                                id="default_country_code"
                                                value="<?= (isset($settings['default_country_code'])) ? output_escaping($settings['default_country_code']) : '' ?>"
                                                placeholder="Default Country Code (e.g., IN)" />
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- cron_job_urls -->
                            <div class="card my-3" id="cron_job_urls">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="ti ti-link"></i> Cron Job URLs</h3>
                                </div>

                                <div class="card-body">
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="seller_commission_url">Seller
                                            Commission URL</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="seller_commission_url"
                                                id="seller_commission_url"
                                                value="<?= base_url('admin/cron-job/settle_seller_commission') ?>"
                                                disabled />
                                            <small class="form-hint"><a class="text-decoration-none"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#how-settle-seller-commission-work"
                                                    title="How it works">How Settle Seller Commission works?</a></small>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="cashback_url">Promo Code Cashback
                                            Discount URL </label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="cashback_url"
                                                id="cashback_url"
                                                value="<?= base_url('admin/cron_job/settle_cashback_discount') ?>"
                                                disabled />
                                            <small class="form-hint"><a class="text-decoration-none"
                                                    data-bs-toggle="modal" data-bs-target="#how-cashback-discount-work"
                                                    title="How it works">How cashback discount works?</a></small>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="settle_affiliate_commission">Settle
                                            Affiliate Commission URL </label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="settle_affiliate_commission"
                                                id="settle_affiliate_commission"
                                                value="<?= base_url('admin/cron_job/settle_affiliate_commission') ?>"
                                                disabled />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label"
                                            for="permanent_delete_affiliate_account">Permanent Delete Affiliate Account
                                            URL </label>
                                        <div class="col">
                                            <input type="text" class="form-control"
                                                name="permanent_delete_affiliate_account"
                                                id="permanent_delete_affiliate_account"
                                                value="<?= base_url('admin/cron_job/permanent_delete_affiliate_account') ?>"
                                                disabled />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label"
                                            for="settle_referal_cashback_discount">Settle Referal Cashback Discount URL
                                        </label>
                                        <div class="col">
                                            <input type="text" class="form-control"
                                                name="settle_referal_cashback_discount"
                                                id="settle_referal_cashback_discount"
                                                value="<?= base_url('admin/cron_job/settle_referal_cashback_discount') ?>"
                                                disabled />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label"
                                            for="settle_referal_cashback_discount_for_referal">Settle Referal Cashback
                                            Discount for Referal URL </label>
                                        <div class="col">
                                            <input type="text" class="form-control"
                                                name="settle_referal_cashback_discount_for_referal"
                                                id="settle_referal_cashback_discount_for_referal"
                                                value="<?= base_url('admin/cron_job/settle_referal_cashback_discount_for_referal') ?>"
                                                disabled />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="remaining_cart_items_url">Remaining
                                            Cart Items URL </label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="remaining_cart_items_url"
                                                id="remaining_cart_items_url"
                                                value="<?= base_url('admin/cron_job/remaining_cart') ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="delete_draft_orders_url">Delete Draft
                                            Orders URL </label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="delete_draft_orders_url"
                                                id="delete_draft_orders_url"
                                                value="<?= base_url('admin/cron_job/draft_order_settle') ?>" disabled />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- maintenance_mode -->
                            <div class="card my-3" id="maintenance_mode">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="ti ti-world-cog"></i> Maintenance Mode</h3>
                                </div>

                                <div class="card-body">
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label"
                                            for="is_customer_app_under_maintenance">Customer App Maintenance
                                            Mode</label>
                                        <div class="col">
                                            <label class="form-check form-switch form-switch-3">
                                                <input class="form-check-input" name="is_customer_app_under_maintenance"
                                                    id="is_customer_app_under_maintenance" type="checkbox"
                                                    <?= (isset($settings['is_customer_app_under_maintenance']) && $settings['is_customer_app_under_maintenance'] == '1') ? 'checked' : '' ?> />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="message_for_customer_app">Message for
                                            Customer App</label>
                                        <div class="col">
                                            <textarea name="message_for_customer_app" class="textarea form-control"
                                                placeholder="Message for Customer App"
                                                data-bs-toggle="autosize"><?= isset($settings['message_for_customer_app']) ? output_escaping(str_replace('\r\n', '&#13;&#10;', $settings['message_for_customer_app'])) : ""; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="is_seller_app_under_maintenance">Seller
                                            App Maintenance Mode</label>
                                        <div class="col">
                                            <label class="form-check form-switch form-switch-3">
                                                <input class="form-check-input" name="is_seller_app_under_maintenance"
                                                    id="is_seller_app_under_maintenance" type="checkbox"
                                                    <?= (isset($settings['is_seller_app_under_maintenance']) && $settings['is_seller_app_under_maintenance'] == '1') ? 'checked' : '' ?> />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="message_for_seller_app">Message for
                                            Seller App</label>
                                        <div class="col">
                                            <textarea name="message_for_seller_app" class="textarea form-control"
                                                placeholder="Message for Seller App"
                                                data-bs-toggle="autosize"><?= isset($settings['message_for_seller_app']) ? output_escaping(str_replace('\r\n', '&#13;&#10;', $settings['message_for_seller_app'])) : ""; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label"
                                            for="is_delivery_boy_app_under_maintenance">Delivery Boy App Maintenance
                                            Mode</label>
                                        <div class="col">
                                            <label class="form-check form-switch form-switch-3">
                                                <input class="form-check-input"
                                                    name="is_delivery_boy_app_under_maintenance"
                                                    id="is_delivery_boy_app_under_maintenance" type="checkbox"
                                                    <?= (isset($settings['is_delivery_boy_app_under_maintenance']) && $settings['is_delivery_boy_app_under_maintenance'] == '1') ? 'checked' : '' ?> />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="message_for_delivery_boy_app">Message
                                            for Delivery Boy App</label>
                                        <div class="col">
                                            <textarea name="message_for_delivery_boy_app" class="textarea form-control"
                                                placeholder="Message for Delivery Boy App"
                                                data-bs-toggle="autosize"><?= isset($settings['message_for_delivery_boy_app']) ? output_escaping(str_replace('\r\n', '&#13;&#10;', $settings['message_for_delivery_boy_app'])) : ""; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="is_web_under_maintenance">Web
                                            Maintenance Mode</label>
                                        <div class="col">
                                            <label class="form-check form-switch form-switch-3">
                                                <input class="form-check-input" name="is_web_under_maintenance"
                                                    id="is_web_under_maintenance" type="checkbox"
                                                    <?= (isset($settings['is_web_under_maintenance']) && $settings['is_web_under_maintenance'] == '1') ? 'checked' : '' ?> />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="message_for_web">Message for
                                            Web</label>
                                        <div class="col">
                                            <textarea name="message_for_web" class="textarea form-control"
                                                placeholder="Message for Web"
                                                data-bs-toggle="autosize"><?= isset($settings['message_for_web']) ? output_escaping(str_replace('\r\n', '&#13;&#10;', $settings['message_for_web'])) : ""; ?></textarea>
                                        </div>
                                    </div>


                                    <div class="space-y my-3">
                                        <div class="form-group text-end">
                                            <button type="reset" class="btn">Cancel</button>
                                            <button type="submit" class="btn btn-primary " id="submit_btn">Update
                                                Settings <i class="cursor-pointer ms-2 ti ti-arrow-right"></i></button>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </form>

                        <div class="modal fade" id="ReferAndEarnModal" tabindex="-1" role="dialog"
                            aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">How Refer and Earn work For referal
                                            and users?</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body ">
                                        <h4 class="text-bold">Field Details : </h4>
                                        <ol>
                                            <li>
                                                <div class="d-flex flex-column">
                                                    <p class="mb-0 fw-bold">Referal Code On / Off:</p>
                                                    <p>This is For if you want to on refer and earn functionality in
                                                        your system.</p>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="d-flex flex-column">
                                                    <p class="mb-0 fw-bold">Minimum Refer & Earn Order Amount :</p>
                                                    <p class="mb-0"><span class="text-bold"> Description :</span> This
                                                        is the minimum
                                                        order amount required for a referral to be considered valid for
                                                        earning rewards.
                                                    </p>
                                                    <p><span class="text-bold">Example : </span> if this amount is set
                                                        to $500, a
                                                        referred user must place an order of at least $500 for the
                                                        referrer to earn a
                                                        bonus.</p>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="d-flex flex-column">
                                                    <p class="mb-0 fw-bold"> Number of times Code can be redeemed:</p>
                                                    <p class="mb-0"><span class="text-bold"> Description :</span> This
                                                        specifies how
                                                        many times a referral code can be used by different users.</p>
                                                    <p><span class="text-bold">Example :</span> if the limit is set to
                                                        5, the referral
                                                        code can only be redeemed five times across different users.</p>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="d-flex flex-column">
                                                    <p class="mb-0 fw-bold">Refer & Earn Method For User :</p>
                                                    <p class="mb-0"><span class="text-bold"> Description:</span> This
                                                        indicates how the
                                                        user (the one who use the referral code) earns their reward when
                                                        they makes a
                                                        firat order. It could be in the form of a percentage of the
                                                        order amount or fix
                                                        amount.<br>
                                                    <p><span class="text-bold"> Example:</span> If the method is set as
                                                        "Fixed Amount,"
                                                        the user might earn $10 for each successful referral.</p>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="d-flex flex-column">
                                                    <p class="mb-0 fw-bold"> Refer & Earn Bonus For User :</p>
                                                    <p class="mb-0"><span class="text-bold"> Description:</span> This is
                                                        the actual
                                                        bonus or reward amount the user(the one who use the referral
                                                        code) earns per
                                                        successful referral. The bonus could be a fixed amount, a
                                                        percentage of the
                                                        first order.</p>
                                                    <p><span class="text-bold"> Example:</span> If the bonus is set to
                                                        $10, the referrer
                                                        earns $10 for user(the one who use the referral code) first
                                                        order.</p>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="d-flex flex-column">
                                                    <p class="mb-0 fw-bold"> Maximum Refer & Earn Amount For User :</p>
                                                    <p class="mb-0"><span class="text-bold"> Description:</span> This is
                                                        the maximum
                                                        total amount a user can earn through the referral program. Once
                                                        this limit is
                                                        reached, the user can no longer earn rewards from further
                                                        referrals.</p>
                                                    <p><span class="text-bold"> Example:</span> If the maximum amount is
                                                        set to $100,
                                                        the user can earn up to $100 cashback, after which no more
                                                        rewards will be
                                                        given.</p>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="d-flex flex-column">
                                                    <p class="mb-0 fw-bold"> Refer & Earn Method For Referral :</p>
                                                    <p class="mb-0"><span class="text-bold"> Description:</span> This
                                                        specifies how the
                                                        referred person (the one who share the referral code) receives
                                                        their reward.
                                                        Like the referrer, the referral can also receive a reward in
                                                        cashback.</p>
                                                    <p><span class="text-bold"> Example:</span> The method could be a
                                                        "Fixed Amount"
                                                        giving the referred user 100$ off their first purchase.</p>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="d-flex flex-column">
                                                    <P class="mb-0 fw-bold">Refer & Earn Bonus For Referral :</P>
                                                    <P class="mb-0"><span class="text-bold"> Description: </span> This
                                                        is the bonus or
                                                        reward that the referred person receives when they use the
                                                        referral code and
                                                        complete a qualifying action, such as making a purchase.</P>
                                                    <P class="mb-0"><span class="text-bold">Example:</span> If the bonus
                                                        is $50 off
                                                        their first purchase of user(the one who use the referral code),
                                                        the referal(the
                                                        one who share the referral code) receives a $50 for user order.
                                                    </P>
                                                </div>
                                            </li>

                                        </ol>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary bg-secondary-lt"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary bg-primary-lt"
                                            data-bs-dismiss="modal">Got it!</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="how-cashback-discount-work" tabindex="-1" role="dialog"
                            aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">How Promo Code Discount will get
                                            credited?</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body ">
                                        <ol>
                                            <li>Cron job must be set on your server for Promo Code Discount to be work.
                                            </li>

                                            <li> Cron job will run every mid night at 12:00 AM. </li>

                                            <li> Formula for Add Promo Code Discount is <b>Sub total (Excluding delivery
                                                    charge) - promo
                                                    code discount percentage / Amount</b> </li>

                                            <li> For example sub total is 1300 and promo code discount is 100 then 1300
                                                - 100 = 1200 so
                                                100 will get credited into Users's wallet </li>

                                            <li> If Order status is delivered And Return Policy is expired then only
                                                users will get
                                                Promo Code Discount. </li>

                                            <li> Ex - 1. Order placed on 10-Sep-22 and return policy days are set to 1
                                                so 10-Sep + 1
                                                days = 11-Sep Promo code discount will get credited on 11-Sep-22 at
                                                12:00 AM (Mid night)
                                            </li>

                                            <li> If Promo Code Discount doesn't works make sure cron job is set properly
                                                and it is
                                                working. If you don't know how to set cron job for once in a day please
                                                take help of
                                                server support or do search for it. </li>
                                        </ol>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary bg-secondary-lt"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary bg-primary-lt"
                                            data-bs-dismiss="modal">Got it!</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="how-settle-seller-commission-work" tabindex="-1" role="dialog"
                            aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">How seller commission will get
                                            credited?</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body ">
                                        <ol>
                                            <li>
                                                Cron job must be set (For once in a day) on your server for seller
                                                commission to be
                                                work.
                                            </li>
                                            <li>
                                                Cron job will run every mid night at 12:00 AM.
                                            </li>
                                            <li>
                                                Formula for seller commision is <b>Sub total (Excluding delivery charge)
                                                    / 100 * seller
                                                    commission percentage</b>
                                            </li>
                                            <li>
                                                For example sub total is 1378 and seller commission is 20% then 1378 /
                                                100 X 20 = 275.6
                                                so 1378 - 275.6 = 1102.4 will get credited into seller's wallet
                                            </li>
                                            <li>
                                                If Order item's status is delivered then only seller will get
                                                commisison.
                                            </li>
                                            <li>
                                                Ex - 1. Order placed on 11-Aug-21 and product return days are set to 0
                                                so 11-Aug + 0
                                                days = 11-Aug seller commission will get credited on 12-Aug-21 at 12:00
                                                AM (Mid night)
                                            </li>
                                            <li>
                                                Ex - 2. Order placed on 11-Aug-21 and product return days are set to 7
                                                so 11-Aug + 7
                                                days = 18-Aug seller commission will get credited on 19-Aug-21 at 12:00
                                                AM (Mid night)
                                            </li>
                                            <li>
                                                If seller commission doesn't works make sure cron job is set properly
                                                and it is working.
                                                If you don't know how to set cron job for once in a day please take help
                                                of server
                                                support or do search for it.
                                            </li>
                                        </ol>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary bg-primary-lt"
                                            data-bs-dismiss="modal">Got it!</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>