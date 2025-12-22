<div class="page-wrapper">
    <!-- BEGIN PAGE HEADER -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        Settings
                    </div>
                    <h2 class="page-title">
                        Account Settings
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="<?= base_url('seller/home') ?>" class="btn btn-white">
                            <i class="ti ti-arrow-left me-2"></i>
                            Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE HEADER -->


    <!-- BEGIN PAGE BODY -->
    <div class="page-body">
        <div class="container-xl">
            <form x-data="ajaxForm({
                             url: base_url + 'seller/login/update_user',
                             loaderText: 'Updating...',
                             onSuccess: () => {
                                 showToast('Profile updated successfully!', 'success');
                                 
                             }
                              })" method="POST" enctype="multipart/form-data" class="form-horizontal"
                id="update_user_profile">
                <?php if (isset($fetched_data[0]['id'])) { ?>
                    <input type="hidden" name="edit_seller" value="<?= $fetched_data[0]['user_id'] ?>">
                    <input type="hidden" name="status" value="1">
                    <input type="hidden" name="edit_seller_data_id" value="<?= $fetched_data[0]['id'] ?>">
                    <input type="hidden" name="old_address_proof" value="<?= $fetched_data[0]['address_proof'] ?>">
                    <input type="hidden" name="old_store_logo" value="<?= $fetched_data[0]['logo'] ?>">
                    <input type="hidden" name="old_authorized_signature"
                        value="<?= $fetched_data[0]['authorized_signature'] ?>">
                    <input type="hidden" name="old_seo_og_image" value="<?= $fetched_data[0]['seo_og_image'] ?>">
                    <input type="hidden" name="old_national_identity_card"
                        value="<?= $fetched_data[0]['national_identity_card'] ?>">
                    <input type="hidden" name="old_profile_image" value="<?= $fetched_data[0]['image'] ?>">
                <?php } ?>

                <!-- Profile Overview Card -->
                <div class="row row-deck row-cards mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="ti ti-user-circle me-2"></i>
                                    Profile Overview
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 text-center">
                                        <div class="mb-3">
                                            <?php if (!empty($fetched_data[0]['image'])) { ?>
                                                <img class="avatar avatar-2xl rounded-circle"
                                                    src="<?= base_url($fetched_data[0]['image']) ?>" alt="Profile Image">
                                            <?php } else { ?>
                                                <img class="avatar avatar-2xl rounded-circle"
                                                    src="<?= base_url() . NO_USER_IMAGE ?>" alt="Profile Image">
                                            <?php } ?>
                                        </div>
                                        <h3 class="mb-1"><?= @$fetched_data[0]['username'] ?></h3>
                                        <p class="text-secondary mb-3"><?= @$fetched_data[0]['email'] ?></p>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mt-3">
                                            <label for="image" class="col-form-label">
                                                <i class="ti ti-camera me-1"></i>
                                                Change Avatar
                                            </label>
                                            <input type="file" class="form-control" name="image" id="image"
                                                accept="image/*">
                                            <small class="text-muted mt-1 d-block">Select an image to update your
                                                profile picture</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Personal Information & Contact Details -->
                <div class="row row-deck row-cards mb-4">
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="ti ti-id me-2"></i>
                                    Personal Information
                                </h3>
                            </div>
                            <div class="card-body">
                                <p class="text-secondary mb-4">Update your personal details and contact information</p>
                                <div class="mb-3">
                                    <label for="name" class="col-form-label required">
                                        <i class="ti ti-user me-1"></i>
                                        Name
                                    </label>
                                    <input type="text" class="form-control" id="name" placeholder="Enter your full name"
                                        name="name" value="<?= @$fetched_data[0]['username'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="mobile" class="col-form-label required">
                                        <i class="ti ti-phone me-1"></i>
                                        Mobile
                                    </label>
                                    <input type="number" class="form-control" id="mobile"
                                        placeholder="Enter Mobile Number" name="mobile"
                                        value="<?= @$fetched_data[0]['mobile'] ?>" readonly>
                                    <small class="text-muted">Mobile number cannot be changed</small>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="col-form-label required">
                                        <i class="ti ti-mail me-1"></i>
                                        Email
                                    </label>
                                    <input type="email" class="form-control" id="email"
                                        placeholder="Enter Email Address" name="email"
                                        value="<?= @$fetched_data[0]['email'] ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="ti ti-map-pin me-2"></i>
                                    Location Details
                                </h3>
                            </div>
                            <div class="card-body">
                                <p class="text-secondary mb-4">Set your location and geographical coordinates</p>
                                <div class="mb-3">
                                    <label for="address" class="col-form-label required">
                                        <i class="ti ti-home me-1"></i>
                                        Address
                                    </label>
                                    <textarea class="form-control" id="address" placeholder="Enter your full address"
                                        name="address"
                                        rows="3"><?= isset($fetched_data[0]['address']) ? @$fetched_data[0]['address'] : "" ?></textarea>
                                </div>
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="latitude" class="col-form-label required">
                                                <i class="ti ti-compass me-1"></i> Latitude
                                            </label>
                                            <input type="text" class="form-control" id="latitude" name="latitude"
                                                placeholder="Latitude" value="<?= @$fetched_data[0]['latitude'] ?>"
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="longitude" class="col-form-label required">
                                                <i class="ti ti-compass me-1"></i> Longitude
                                            </label>
                                            <input type="text" class="form-control" id="longitude" name="longitude"
                                                placeholder="Longitude" value="<?= @$fetched_data[0]['longitude'] ?>"
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                required>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>

                <!-- Authorization & Signature -->
                <div class="row row-deck row-cards mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="ti ti-writing-sign me-2"></i>
                                    Authorization Details
                                </h3>
                            </div>
                            <div class="card-body">
                                <p class="text-secondary mb-4">Upload your authorized signature for official documents
                                </p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="authorized_signature" class="col-form-label required">
                                            <i class="ti ti-pencil me-1"></i>
                                            Authorized Signature
                                        </label>
                                        <input type="file" class="form-control" name="authorized_signature"
                                            id="authorized_signature" accept="image/*">
                                        <?php if (isset($fetched_data[0]['authorized_signature']) && !empty($fetched_data[0]['authorized_signature'])) { ?>
                                            <small class="text-danger d-block mt-1">*Leave blank if no change needed</small>
                                        <?php } ?>
                                    </div>
                                    <?php if (isset($fetched_data[0]['authorized_signature']) && !empty($fetched_data[0]['authorized_signature'])) { ?>
                                        <div class="col-md-6">
                                            <label class="col-form-label">Current Signature</label>
                                            <div>
                                                <a href="<?= base_url($fetched_data[0]['authorized_signature']) ?>"
                                                    data-toggle="lightbox" data-gallery="gallery_seller">
                                                    <img src="<?= base_url($fetched_data[0]['authorized_signature']) ?>"
                                                        class="img-fluid rounded border" id="authorized-signature-preview"
                                                        style="max-width: 200px; max-height: 100px; object-fit: contain;">
                                                </a>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Store Details -->
                <div class="row row-deck row-cards mb-4">
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="ti ti-building-store me-2"></i>
                                    Store Information
                                </h3>
                            </div>
                            <div class="card-body">
                                <p class="text-secondary mb-4">Manage your store details and branding</p>
                                <div class="mb-3">
                                    <label for="store_name" class="col-form-label required">
                                        <i class="ti ti-shopping-bag me-1"></i>
                                        Store Name
                                    </label>
                                    <input type="text" class="form-control" id="store_name"
                                        placeholder="Enter Store Name" name="store_name"
                                        value="<?= @$fetched_data[0]['store_name'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="store_url" class="col-form-label">
                                        <i class="ti ti-world me-1"></i>
                                        Store URL
                                    </label>
                                    <input type="text" class="form-control" id="store_url" placeholder="Enter Store URL"
                                        name="store_url" value="<?= @$fetched_data[0]['store_url'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="store_description" class="col-form-label required">
                                        <i class="ti ti-file-text me-1"></i>
                                        Store Description
                                    </label>
                                    <textarea class="form-control" id="store_description"
                                        placeholder="Describe your store" rows="3"
                                        name="store_description"><?= isset($fetched_data[0]['store_description']) ? @$fetched_data[0]['store_description'] : "" ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="ti ti-photo me-2"></i>
                                    Store Branding
                                </h3>
                            </div>
                            <div class="card-body">
                                <p class="text-secondary mb-4">Upload your store logo and branding assets</p>
                                <div class="mb-3">
                                    <label for="store_logo" class="col-form-label required">
                                        <i class="ti ti-brand-shopee me-1"></i>
                                        Store Logo
                                    </label>
                                    <input type="file" class="form-control" name="store_logo" id="store_logo"
                                        accept="image/*">
                                    <?php if (isset($fetched_data[0]['logo']) && !empty($fetched_data[0]['logo'])) { ?>
                                        <small class="text-danger d-block mt-1">*Leave blank if no change needed</small>
                                    <?php } ?>
                                </div>
                                <?php if (isset($fetched_data[0]['logo']) && !empty($fetched_data[0]['logo'])) { ?>
                                    <div class="mb-3">
                                        <label class="col-form-label">Current Logo</label>
                                        <div>
                                            <a href="<?= base_url($fetched_data[0]['logo']) ?>" data-toggle="lightbox"
                                                data-gallery="gallery_seller">
                                                <img src="<?= base_url($fetched_data[0]['logo']) ?>"
                                                    class="img-fluid rounded border" id="store-logo-preview"
                                                    style="max-width: 200px; max-height: 100px; object-fit: contain;">
                                            </a>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security Settings -->
                <div class="row row-deck row-cards mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="ti ti-shield-lock me-2"></i>
                                    Security Settings
                                </h3>
                            </div>
                            <div class="card-body">
                                <p class="text-secondary mb-4">Change your password to keep your account secure. Leave
                                    blank if you don't want to change it.</p>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="col-form-label" for="old">
                                                <i class="ti ti-lock me-1"></i>
                                                Old Password
                                            </label>
                                            <div class="input-group input-group-flat">
                                                <input type="password" class="form-control" name="old" id="old"
                                                    autocomplete="off" placeholder="Enter Old Password">
                                                <span class="input-group-text togglePassword" title="Show password"
                                                    data-bs-toggle="tooltip" style="cursor: pointer;">
                                                    <i class="ti ti-eye fs-3"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="col-form-label" for="new">
                                                <i class="ti ti-lock-open me-1"></i>
                                                New Password
                                            </label>
                                            <div class="input-group input-group-flat">
                                                <input type="password" class="form-control" name="new" id="new"
                                                    autocomplete="off" placeholder="Enter New Password">
                                                <span class="input-group-text togglePassword" title="Show password"
                                                    data-bs-toggle="tooltip" style="cursor: pointer;">
                                                    <i class="ti ti-eye fs-3"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="col-form-label" for="new_confirm">
                                                <i class="ti ti-lock-check me-1"></i>
                                                Confirm New Password
                                            </label>
                                            <div class="input-group input-group-flat">
                                                <input type="password" class="form-control" name="new_confirm"
                                                    id="new_confirm" autocomplete="off"
                                                    placeholder="Confirm New Password">
                                                <span class="input-group-text togglePassword" title="Show password"
                                                    data-bs-toggle="tooltip" style="cursor: pointer;">
                                                    <i class="ti ti-eye fs-3"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="alert alert-info mt-3" role="alert">
                                    <div class="d-flex">
                                        <div>
                                            <i class="ti ti-info-circle me-2"></i>
                                        </div>
                                        <div>
                                            <h4 class="alert-title">Password Requirements</h4>
                                            <div class="text-secondary">Make sure your password is at least 8 characters
                                                long and contains a mix of uppercase, lowercase, numbers, and special
                                                characters.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Business Details -->
                <div class="row row-deck row-cards mb-4">
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="ti ti-receipt-tax me-2"></i>
                                    Tax Information
                                </h3>
                            </div>
                            <div class="card-body">
                                <p class="text-secondary mb-4">Configure your tax details for business compliance</p>
                                <div class="mb-3">
                                    <label for="tax_name" class="col-form-label required">
                                        <i class="ti ti-file-invoice me-1"></i>
                                        Tax Name
                                    </label>
                                    <input type="text" class="form-control" id="tax_name" name="tax_name"
                                        placeholder="e.g., GST, VAT, Sales Tax"
                                        value="<?= @$fetched_data[0]['tax_name'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="tax_number" class="col-form-label required">
                                        <i class="ti ti-hash me-1"></i>
                                        Tax Number
                                    </label>
                                    <input type="text" class="form-control" id="tax_number" name="tax_number"
                                        placeholder="Enter Tax Registration Number"
                                        value="<?= @$fetched_data[0]['tax_number'] ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="ti ti-settings me-2"></i>
                                    Inventory Settings
                                </h3>
                            </div>
                            <div class="card-body">
                                <p class="text-secondary mb-4">Manage your inventory alerts and stock levels</p>
                                <div class="mb-3">
                                    <label for="low_stock_limit" class="col-form-label">
                                        <i class="ti ti-alert-triangle me-1"></i>
                                        Low Stock Alert Limit
                                    </label>
                                    <input type="number" class="form-control" id="low_stock_limit"
                                        name="low_stock_limit" placeholder="e.g., 10"
                                        value="<?= @$fetched_data[0]['low_stock_limit'] ?>">
                                    <small class="text-muted">You'll be notified when product stock falls below this
                                        limit</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delivery Settings -->
                <?php
                $pincode_wise_deliverability = isset($shipping_method['pincode_wise_deliverability']) && $shipping_method['pincode_wise_deliverability'] == 1 ? '1' : '0';
                $city_wise_deliverability = isset($shipping_method['city_wise_deliverability']) && $shipping_method['city_wise_deliverability'] == 1 ? '1' : '0';
                ?>
                <input type="hidden" name="city_wise_deliverability" value="<?= $city_wise_deliverability ?>">
                <input type="hidden" name="pincode_wise_deliverability" value="<?= $pincode_wise_deliverability ?>">

                <?php if ($pincode_wise_deliverability == 1 || $city_wise_deliverability == 1 || (isset($shipping_method['local_shipping_method'], $shipping_method['shiprocket_shipping_method']) && $shipping_method['local_shipping_method'] == 1 && $shipping_method['shiprocket_shipping_method'] == 1)): ?>
                    <div class="row row-deck row-cards mb-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="ti ti-truck-delivery me-2"></i>
                                        Delivery Configuration
                                    </h3>
                                </div>


                                <div class="card-body">
                                    <p class="text-secondary mb-4">Configure your delivery zones and serviceable areas</p>

                                    <?php if ((isset($shipping_method['pincode_wise_deliverability']) && $shipping_method['pincode_wise_deliverability'] == 1) || (isset($shipping_method['local_shipping_method']) && isset($shipping_method['shiprocket_shipping_method']) && $shipping_method['local_shipping_method'] == 1 && $shipping_method['shiprocket_shipping_method'] == 1)) { ?>

                                        <div class="row g-3 mb-3">
                                            <div class="col-md-6" x-data x-init="
                                                        initTomSelect({
                                                        element: $refs.zipcodeSelect,
                                                        placeholder: 'Select Zipcode Type...',
                                                        maxItems: 1,
                                                        preloadOptions: true,
                                                        preselected: <?= isset($fetched_data[0]['deliverable_zipcode_type']) ? $fetched_data[0]['deliverable_zipcode_type'] : 'null' ?>
                                                        })
                                                    ">
                                                <label class="form-label">Deliverable Zipcode Type</label>
                                                <select class="form-select" id="deliverable_zipcode_type1"
                                                    name="deliverable_zipcode_type" x-ref="zipcodeSelect">
                                                    <option value="<?= ALL ?>">All Zipcodes</option>
                                                    <option value="<?= EXCLUDED ?>">Excluded Zipcodes</option>
                                                </select>
                                            </div>

                                            <!-- <div x-data x-init="
                                                         initTomSelect({
                                                           element: $refs.serviceableSelect,
                                                           url: '<?= base_url('seller/area/get_zipcodes?for_select2=1') ?>',
                                                           placeholder: 'Select Serviceable Zipcodes...',
                                                           maxItems: null,
                                                           create: true,
                                                           preloadOptions: true,
                                                            preselected: <?= isset($fetched_data[0]['serviceable_zipcodes']) && !empty($fetched_data[0]['serviceable_zipcodes'])
                                                                ? json_encode(explode(',', $fetched_data[0]['serviceable_zipcodes']))
                                                                : 'null' ?>
                                                         })
                                                       " class="col-md-6"> -->
                                            <div x-data x-init="
                                                            initTomSelect({
                                                            element: $refs.serviceableSelect,
                                                            url: '<?= base_url('seller/area/get_zipcodes?for_select2=1') ?>',
                                                            placeholder: 'Select Serviceable Zipcodes...',
                                                            maxItems: null,
                                                            create: true,
                                                            preloadOptions: true,
                                                            preselected: <?= isset($fetched_data[0]['serviceable_zipcodes']) && !empty($fetched_data[0]['serviceable_zipcodes'])
                                                                ? htmlspecialchars(json_encode(explode(',', $fetched_data[0]['serviceable_zipcodes'])), ENT_QUOTES, 'UTF-8')
                                                                : 'null' ?>
                                                            });
                                                        " class="col-md-6">
                                                <label class="form-label required">Serviceable Zipcodes</label>
                                                <select class="form-select" id="deliverable_zipcodes"
                                                    name="serviceable_zipcodes[]" multiple x-ref="serviceableSelect">
                                                    <option value="">Select zipcodes</option>
                                                </select>
                                            </div>
                                        </div>
                                    <?php }
                                    if (isset($shipping_method['city_wise_deliverability']) && $shipping_method['city_wise_deliverability'] == 1 && $shipping_method['shiprocket_shipping_method'] != 1) { ?>

                                        <div class="row g-3 mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Deliverable City Type</label>
                                                <select class="form-select" id="deliverable_city_type"
                                                    name="deliverable_city_type">
                                                    <option value="<?= ALL ?>" selected>All Cities</option>
                                                    <option value="<?= EXCLUDED ?>">Excluded Cities</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6" x-data x-init="
                initTomSelect({
                  element: $refs.citiesSelect,
                  url: '<?= base_url('seller/area/get_cities') ?>',
                  placeholder: 'Select Serviceable Cities...',
                  maxItems: null,
                  create: true
                })
              ">
                                                <label class="form-label required">Serviceable Cities</label>
                                                <select class="form-select" id="deliverable_cities" name="serviceable_cities[]"
                                                    multiple x-ref="citiesSelect">
                                                    <option value="">Select cities</option>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- SEO Configuration -->
                <div class="row row-deck row-cards mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="ti ti-zoom-code me-2"></i>
                                    SEO Configuration
                                </h3>
                            </div>
                            <div class="card-body">
                                <p class="text-secondary mb-4">Optimize your store for search engines and social media
                                </p>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="seo_page_title" class="col-form-label">
                                            <i class="ti ti-heading me-1"></i>
                                            SEO Page Title
                                        </label>
                                        <input type="text" class="form-control" id="seo_page_title"
                                            placeholder="Enter SEO Page Title" name="seo_page_title"
                                            value="<?= isset($fetched_data[0]['seo_page_title']) ? output_escaping($fetched_data[0]['seo_page_title']) : "" ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="seo_meta_keywords" class="col-form-label">
                                            <i class="ti ti-tags me-1"></i>
                                            SEO Meta Keywords
                                        </label>
                                        <input class="form-control tags" id="seo_meta_keywords"
                                            placeholder="Enter keywords separated by commas" name="seo_meta_keywords"
                                            value="<?= isset($fetched_data[0]['seo_meta_keywords']) ? output_escaping($fetched_data[0]['seo_meta_keywords']) : "" ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="seo_meta_description" class="col-form-label">
                                            <i class="ti ti-text me-1"></i>
                                            SEO Meta Description
                                        </label>
                                        <textarea class="form-control" id="seo_meta_description"
                                            placeholder="Enter SEO Meta Description" rows="3"
                                            name="seo_meta_description"><?= isset($fetched_data[0]['seo_meta_description']) ? output_escaping($fetched_data[0]['seo_meta_description']) : "" ?></textarea>
                                        <small class="text-muted">Recommended length: 150-160 characters</small>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label required" for="seo_og_image">SEO Open Graph
                                            Image </label>
                                        <div class="col">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="">
                                                    <input type="file" class="form-control" name="seo_og_image"
                                                        id="seo_og_image" />
                                                </div>

                                                <?php if (isset($fetched_data[0]['seo_og_image']) && !empty($fetched_data[0]['seo_og_image'])) { ?>
                                                    <div class="form-group row">
                                                        <div class="mx-auto image-box-100">
                                                            <a href="<?= base_url($fetched_data[0]['seo_og_image']); ?>"
                                                                data-toggle="lightbox" data-gallery="seo_og_image"><img
                                                                    src="<?= base_url($fetched_data[0]['seo_og_image']); ?>"
                                                                    class="img-fluid rounded">
                                                            </a>
                                                            <input type="hidden" name="seo_og_image"
                                                                value='<?= $fetched_data[0]['seo_og_image'] ?>'>
                                                        </div>
                                                    </div>
                                                <?php } ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent">
                                <div class="btn-list justify-content-end">
                                    <button type="button" class="btn"
                                        onclick="window.location.href='<?= base_url('seller/home') ?>'">
                                        <i class="ti ti-x me-2"></i>
                                        Cancel
                                    </button>
                                    <button type="submit" class="btn btn-primary" id="submit_btn">
                                        <i class="ti ti-device-floppy me-2"></i>
                                        Update Profile
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END PAGE BODY -->
</div>