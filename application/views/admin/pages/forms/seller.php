<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">

                <!-- Mobile View -->
                <div class="d-flex flex-column text-center d-sm-none py-2">
                    <h2 class="page-title fs-5 fw-semibold mb-1">Add Seller</h2>
                    <nav class="breadcrumb breadcrumb-arrows small justify-content-center mb-0">
                        <a href="<?= base_url('admin/home') ?>" class="breadcrumb-item">Home</a>
                        <a href="<?= base_url('admin/sellers') ?>" class="breadcrumb-item">Sellers</a>
                        <span class="breadcrumb-item active">Manage Seller</span>
                    </nav>
                </div>

                <!-- Tablet & Desktop View -->
                <div class="row g-2 align-items-center d-none d-sm-flex">
                    <div class="col">
                        <h2 class="page-title mb-0">Add Seller</h2>
                    </div>
                    <div class="col-auto ms-auto">
                        <ol class="breadcrumb breadcrumb-arrows mb-0 small">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('admin/home') ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('admin/sellers') ?>">Sellers</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Manage Seller
                            </li>
                        </ol>
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
                                <a class="nav-link" href="#seller-info">Seller Information</a>
                                <a class="nav-link" href="#commission-and-delivery-settings">Commission & Delivery
                                    Settings</a>
                                <a class="nav-link" href="#store-details">Store Details</a>
                                <a class="nav-link" href="#other-details">Other Details</a>
                                <a class="nav-link" href="#permissions">Permissions</a>
                                <a class="nav-link" href="#seo-config">SEO Configuration</a>
                            </nav>
                        </div>
                    </div>
                    <div class="col-sm" data-bs-spy="scroll" data-bs-target="#pills" data-bs-offset="80" tabindex="0">

                        <form x-data="ajaxForm({
                                            url: base_url + 'admin/sellers/add_seller',
                                            offcanvasId: '',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="add_seller_form">
                            <input type="hidden" value="<?= $category_flag ?>" id="category_flag">

                            <?php if (isset($fetched_data[0]['id'])) { ?>
                                <input type="hidden" name="edit_seller" value="<?= $fetched_data[0]['user_id'] ?>">
                                <input type="hidden" name="edit_seller_data_id" value="<?= $fetched_data[0]['id'] ?>">
                                <input type="hidden" name="old_address_proof"
                                    value="<?= $fetched_data[0]['address_proof'] ?>">
                                <input type="hidden" name="old_store_logo" value="<?= $fetched_data[0]['logo'] ?>">
                                <input type="hidden" name="old_authorized_signature"
                                    value="<?= $fetched_data[0]['authorized_signature'] ?>">
                                <input type="hidden" name="old_national_identity_card"
                                    value="<?= $fetched_data[0]['national_identity_card'] ?>">
                            <?php
                            } ?>

                            <!-- seller-info -->
                            <div class="card" id="seller-info">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="ti ti-user"></i> Seller Information</h3>
                                </div>
                                <div class="card-body">

                                    <div class="mb-3 row">
                                        <label class="col-12 col-md-4 col-form-label required" for="name">Name</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="name" id="name"
                                                value="<?= @$fetched_data[0]['username'] ?>"
                                                placeholder="Seller Name" />
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-12 col-md-4 col-form-label required" for="mobile">Mobile</label>
                                        <div class="col">
                                            <input type="number" class="form-control" name="mobile"
                                                maxlength="16" id="mobile" min="1"
                                                value="<?= @$fetched_data[0]['mobile'] ?>" placeholder="Enter Mobile" />
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-12 col-md-4 col-form-label required" for="email">Email</label>
                                        <div class="col">
                                            <input type="email" class="form-control" name="email" id="email"
                                                value="<?= @$fetched_data[0]['email'] ?>" placeholder="Seller Email" />
                                        </div>
                                    </div>

                                    <?php
                                    if (!isset($fetched_data[0]['id'])) {
                                    ?>
                                        <div class="mb-3 row align-items-center">
                                            <label class="col-12 col-md-4 col-form-label required" for="password">
                                                Password
                                            </label>
                                            <div class="col-12 col-md-8">
                                                <div class="input-group input-group-flat">
                                                    <input type="password"
                                                        class="form-control passwordToggle"
                                                        name="password"
                                                        id="password"
                                                        value="<?= @$fetched_data[0]['username'] ?>"
                                                        placeholder="Seller Password" />
                                                    <span class="input-group-text togglePassword" title="Show password"
                                                        data-bs-toggle="tooltip" style="cursor:pointer;">
                                                        <i class="ti ti-eye fs-3"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3 row align-items-center">
                                            <label class="col-12 col-md-4 col-form-label required" for="confirm_password">
                                                Confirm Password
                                            </label>
                                            <div class="col-12 col-md-8">
                                                <div class="input-group input-group-flat">
                                                    <input type="password"
                                                        class="form-control passwordToggle"
                                                        name="confirm_password"
                                                        id="confirm_password"
                                                        placeholder="Seller Confirm Password" />
                                                    <span class="input-group-text togglePassword" title="Show password"
                                                        data-bs-toggle="tooltip" style="cursor:pointer;">
                                                        <i class="ti ti-eye fs-3"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                    <?php
                                    }
                                    ?>

                                    <div class="mb-3 row">
                                        <label class="col-12 col-md-4 col-form-label required" for="address">Address</label>
                                        <div class="col">
                                            <textarea name="address" class="textarea form-control" placeholder="Address"
                                                data-bs-toggle="autosize"> <?= (isset($fetched_data[0]['address'])) ? output_escaping($fetched_data[0]['address']) : '' ?></textarea>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-12 col-md-4 col-form-label" for="authorized_signature">Authorized
                                            Signature</label>
                                        <div class="col">

                                            <div class="d-flex align-items-center gap-3">
                                                <div class="col-md-6">
                                                    <input type="file" class="form-control file_upload_height"
                                                        name="authorized_signature" id="authorized_signature"
                                                        accept="image/*" />
                                                    <small class="form-hint mt-2 text-danger">*Only Choose When Update
                                                        is necessary.</small>
                                                </div>

                                                <?php if (isset($fetched_data[0]['authorized_signature']) && !empty($fetched_data[0]['authorized_signature'])) { ?>
                                                    <div class="form-group row">
                                                        <div class="mx-auto image-box-table">
                                                            <a href="<?= base_url($fetched_data[0]['authorized_signature']); ?>"
                                                                data-toggle="lightbox" data-gallery="gallery_seller"><img
                                                                    src="<?= base_url($fetched_data[0]['authorized_signature']); ?>"
                                                                    class="img-fluid rounded">
                                                            </a>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- commission-and-delivery-settings -->
                            <div class="card mt-3" id="commission-and-delivery-settings">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="ti ti-truck"></i> Commission & Delivery Settings
                                    </h3>
                                </div>
                                <div class="card-body">

                                    <div class="mb-3 row">
                                        <label class="col-12 col-md-4 col-form-label"
                                            for="global_commission">Commission(%)</label>
                                        <div class="col">
                                            <input type="number" class="form-control" name="global_commission"
                                                id="global_commission" max="100" min="0"
                                                value="<?= @$fetched_data[0]['commission'] ?>"
                                                placeholder="Enter Commission(%) to be given to the Super Admin on order item." />
                                            <small class="form-hint">Commission(%) to be given to the Super Admin on
                                                order item globally.</small>
                                        </div>
                                    </div>

                                    <?php
                                    $category_html = get_categories_option_html($categories);
                                    ?>
                                    <div class="d-none" id="cat_html">
                                        <?= $category_html ?>
                                    </div>
                                    <div class="mb-3 row">
                                        <textarea cols="20" rows="20" id="cat_data" name="commission_data"
                                            class="d-none"></textarea>
                                        <label class="col-12 col-md-4 col-form-label" for="commission">Choose Categories &
                                            Commission(%)</label>
                                        <div class="col">
                                            <a href="javascript:void(0)"
                                                class="bg-primary-lt btn btn-primary btn-sm w-33" id="seller_model"
                                                data-seller_id="<?= (isset($fetched_data[0]['user_id']) && !empty($fetched_data[0]['user_id'])) ? $fetched_data[0]['user_id'] : ""; ?>"
                                                data-cat_ids="<?= (isset($fetched_data[0]['id']) && !empty($fetched_data[0]['id'])) ? $fetched_data[0]['category_ids'] : ""; ?>"
                                                title="Manage Categories & Commission"
                                                data-bs-target="#sellerCommission" data-bs-toggle="offcanvas">Manage</a>

                                            <small class="form-hint mt-2">Commission(%) to be given to the Super Admin
                                                on order item
                                                by Category you select.If you do not set the commission beside category
                                                then
                                                it will get global commission other wise perticuler category commission
                                                will
                                                be consider.</small>
                                        </div>
                                    </div>

                                    <?php
                                    $pincode_wise_deliverability = (isset($shipping_method['pincode_wise_deliverability']) && $shipping_method['pincode_wise_deliverability'] == 1) ? $shipping_method['pincode_wise_deliverability'] : '0';
                                    $city_wise_deliverability = (isset($shipping_method['city_wise_deliverability']) && $shipping_method['city_wise_deliverability'] == 1) ? $shipping_method['city_wise_deliverability'] : '0';
                                    ?>

                                    <input type="hidden" name="city_wise_deliverability"
                                        value="<?= $city_wise_deliverability ?>">
                                    <input type="hidden" name="pincode_wise_deliverability"
                                        value="<?= $pincode_wise_deliverability ?>">

                                    <div class="mb-3 row deliverable_type">
                                        <?php if ((isset($shipping_method['pincode_wise_deliverability']) && $shipping_method['pincode_wise_deliverability'] == 1) || (isset($shipping_method['local_shipping_method']) && isset($shipping_method['shiprocket_shipping_method']) && $shipping_method['local_shipping_method'] == 1 && $shipping_method['shiprocket_shipping_method'] == 1)) { ?>
                                            <label class="col-12 col-md-4 col-form-label required"
                                                for="deliverable_zipcode_type">Deliverable Zipcode Type </label>
                                            <div class="col">
                                                <select name="deliverable_zipcode_type" id="deliverable_zipcode_type"
                                                    name="deliverable_zipcode_type"
                                                    class="form-control deliverable_zipcode_type">
                                                    <option value="<?= ALL ?>"
                                                        <?= (isset($fetched_data[0]['deliverable_zipcode_type']) && $fetched_data[0]['deliverable_zipcode_type'] == 1) ? 'selected' : ''; ?>>
                                                        All</option>
                                                    <option value="<?= EXCLUDED ?>"
                                                        <?= (isset($fetched_data[0]['deliverable_zipcode_type']) && $fetched_data[0]['deliverable_zipcode_type'] == 2) ? 'selected' : ''; ?>>
                                                        Excluded</option>
                                                </select>
                                            </div>
                                        <?php }
                                        if (isset($shipping_method['city_wise_deliverability']) && $shipping_method['city_wise_deliverability'] == 1 && $shipping_method['shiprocket_shipping_method'] != 1) { ?>
                                            <label class="col-12 col-md-4 col-form-label required"
                                                for="deliverable_city_type">Deliverable City Type </label>
                                            <div class="col">
                                                <select name="deliverable_city_type" id="deliverable_city_type"
                                                    name="deliverable_city_type" class="form-control deliverable_city_type">
                                                    <option value="<?= ALL ?>"
                                                        <?= (isset($fetched_data[0]['deliverable_city_type']) && $fetched_data[0]['deliverable_city_type'] == 1) ? 'selected' : ''; ?>>
                                                        All</option>
                                                    <option value="<?= EXCLUDED ?>"
                                                        <?= (isset($fetched_data[0]['deliverable_city_type']) && $fetched_data[0]['deliverable_city_type'] == 2) ? 'selected' : ''; ?>>
                                                        Excluded</option>
                                                </select>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <div class="mb-3 row ">
                                        <?php if ((isset($shipping_method['pincode_wise_deliverability']) && $shipping_method['pincode_wise_deliverability'] == 1) || (isset($shipping_method['local_shipping_method']) && isset($shipping_method['shiprocket_shipping_method']) && $shipping_method['local_shipping_method'] == 1 && $shipping_method['shiprocket_shipping_method'] == 1)) { ?>
                                            <div x-data x-init="initTomSelect({
                                                    element: $refs.zipCodeSelect,
                                                    url: '/admin/area/get_zipcodes',
                                                    placeholder: 'Search Zipcode...',
                                                    onItemAdd: openNewZipcodeModal,
                                                    offcanvasId: '',
                                                    dataAttribute: 'data-zipcode-ids',
                                                    maxItems: 20, 
                                                    preloadOptions: true
                                                })" class="mb-3 row">

                                                <label class="col-12 col-md-4 col-form-label required" for="zipCodeSelect">Serviceable
                                                    Zipcode</label>
                                                <div class="col">
                                                    <select x-ref="zipCodeSelect" name="serviceable_zipcodes[]" class="form-select"
                                                        id="zipCodeSelect"></select>
                                                </div>
                                            </div>
                                        <?php }
                                        if (isset($shipping_method['city_wise_deliverability']) && $shipping_method['city_wise_deliverability'] == 1 && $shipping_method['shiprocket_shipping_method'] != 1) { ?>
                                            <div x-data x-init="initTomSelect({
                                                    element: $refs.citySelect,
                                                    url: '<?= base_url('admin/area/get_cities') ?>',
                                                    placeholder: 'Search City...',
                                                    onItemAdd: openNewCityModal,
                                                    offcanvasId: '',
                                                    dataAttribute: 'data-city-id',
                                                    preloadOptions: true
                                                })" class="mb-3 row">

                                                <label class="col-12 col-md-4 col-form-label required" for="citySelect">City</label>
                                                <div class="col">
                                                    <select x-ref="citySelect" name="serviceable_cities[]" class="form-select"
                                                        id="citySelect"></select>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                </div>
                            </div>

                            <!-- store-details -->
                            <div class="card mt-3" id="store-details">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="ti ti-building-store"></i> Store Details</h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3 row">
                                        <label class="col-12 col-md-4 col-form-label required" for="store_name">Name</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="store_name" id="store_name"
                                                value="<?= isset($fetched_data[0]['store_name']) ? @$fetched_data[0]['store_name'] : ""; ?>"
                                                placeholder="Store Name" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-12 col-md-4 col-form-label" for="store_url">Store URL</label>
                                        <div class="col">
                                            <input
                                                type="text"
                                                class="form-control"
                                                name="store_url"
                                                id="store_url"
                                                value="<?= @$fetched_data[0]['store_url'] ?>"
                                                placeholder="https://example.com" />
                                        </div>
                                    </div>


                                    <div class="mb-3 row">
                                        <label class="col-12 col-md-4 col-form-label required"
                                            for="store_description">Description</label>
                                        <div class="col">
                                            <textarea name="store_description" id="store_description"
                                                class="textarea form-control" placeholder="Store Description"
                                                data-bs-toggle="autosize"><?= isset($fetched_data[0]['store_description']) ? @$fetched_data[0]['store_description'] : ""; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-12 col-md-4 col-form-label" for="store_logo">Store Logo</label>
                                        <div class="col">

                                            <div class="d-flex align-items-center gap-3">
                                                <div class="col-md-6">
                                                    <input type="file" class="form-control file_upload_height"
                                                        name="store_logo" id="store_logo" accept="image/*" />
                                                    <small class="form-hint mt-2 text-danger">*Only Choose When Update
                                                        is necessary.</small>
                                                </div>

                                                <?php if (isset($fetched_data[0]['logo']) && !empty($fetched_data[0]['logo'])) { ?>
                                                    <div class="form-group row">
                                                        <div class="mx-auto image-box-table">
                                                            <a href="<?= base_url($fetched_data[0]['logo']); ?>"
                                                            data-lightbox="logo"
                                                                data-toggle="lightbox" data-gallery="logo"><img
                                                                    src="<?= base_url($fetched_data[0]['logo']); ?>"
                                                                    class="img-fluid rounded">
                                                            </a>
                                                            <input type="hidden" name="logo"
                                                                value='<?= $fetched_data[0]['logo'] ?>'>
                                                        </div>
                                                    </div>
                                                <?php } ?>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- other-details -->
                            <div class="card mt-3" id="other-details">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="ti ti-info-circle"></i> Other Details</h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3 row">
                                        <label class="col-12 col-md-3 col-form-label required" for="status">Status</label>

                                        <div class="col-12 col-md-9">
                                            <div id="status" class="d-flex flex-column flex-sm-row flex-wrap gap-2">

                                                <label class="btn bg-warning-lt d-flex align-items-center px-3 py-2">
                                                    <input type="radio" name="status" id="pending" value="0" class="me-2"
                                                        <?= (isset($fetched_data[0]['status']) && $fetched_data[0]['status'] == '0') ? 'checked' : '' ?>>
                                                    Deactive
                                                </label>

                                                <label class="btn bg-primary-lt d-flex align-items-center px-3 py-2">
                                                    <input type="radio" name="status" id="approved" value="1" class="me-2"
                                                        <?= (isset($fetched_data[0]['status']) && $fetched_data[0]['status'] == '1') ? 'checked' : '' ?>>
                                                    Approved
                                                </label>

                                                <label class="btn bg-danger-lt d-flex align-items-center px-3 py-2">
                                                    <input type="radio" name="status" id="rejected" value="2" class="me-2"
                                                        <?= (isset($fetched_data[0]['status']) && $fetched_data[0]['status'] == '2') ? 'checked' : '' ?>>
                                                    Not-Approved
                                                </label>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
    <label class="col-form-label col-3 required" for="pan_number">PAN Number</label>
    <div class="col">
        <input type="text" class="form-control" id="pan_number" name="pan_number" placeholder="Enter PAN Number" value="<?= $seller_data[0]['pan_number'] ?? '' ?>" required>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3 row">
    <label class="col-form-label col-3 required" for="pan_image">PAN Image</label>

    <div class="col">
        <div class="d-flex align-items-center gap-2">

            <!-- Lightbox link -->
            <a href="<?= !empty($seller_data[0]['pan_upload']) 
                ? base_url($seller_data[0]['pan_upload']) 
                : 'javascript:void(0)' ?>"
               class="pan-lightbox"
               target="_blank">

                <img
                    id="panPreview"
                    src="<?= !empty($seller_data[0]['pan_upload']) 
                        ? base_url($seller_data[0]['pan_upload']) 
                        : '' ?>"
                    class="img-thumbnail"
                    style="width:80px;height:60px;object-fit:cover;cursor:pointer;<?= empty($seller_data[0]['pan_upload']) ? 'display:none;' : '' ?>"
                >
            </a>

            <input
                type="file"
                class="form-control"
                id="pan_image"
                name="pan_image"
                accept="image/*">
        </div>
    </div>
</div>

                                    
                                    <!-- PAN Image Lightbox Modal -->
                                    <div class="modal fade" id="panImageModal" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">PAN Image</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <img src="" alt="PAN Image" class="img-fluid" id="panImageModalImg">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3 row">
                                        <label class="col-form-label col-3 required" for="bank_ifsc">Bank IFSC</label>
                                        <div class="col">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="bank_ifsc" name="bank_ifsc" placeholder="Enter Bank IFSC Code"
                                                    value="<?= $seller_data[0]['bank_code'] ?? '' ?>" autocomplete="off" required>
                                                <button class="btn btn-primary" type="button" id="verify_bank_ifsc">
                                                    <i class="ti ti-check me-1"></i>Verify
                                                </button>
                                            </div>
                                            <div class="form-text" id="ifsc_feedback"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3 row">
                                        <label class="col-form-label col-3 required" for="bank_name">Bank Name</label>
                                        <div class="col">
                                            <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Enter Bank Name"
                                                value="<?= $seller_data[0]['bank_name'] ?? '' ?>" required>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3 row">
                                        <label class="col-form-label col-3 required" for="bank_acc">Bank Account Number</label>
                                        <div class="col">
                                            <input type="text" class="form-control" id="bank_acc" name="bank_acc" placeholder="Enter Bank Account Number"
                                                value="<?= $seller_data[0]['account_number'] ?? '' ?>" required>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label required" for="tax_name">Tax Name</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="tax_name" id="tax_name"
                                                value="<?= @$fetched_data[0]['tax_name'] ?>" placeholder="Tax Name" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label required" for="tax_number">Tax Number</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="tax_number" id="tax_number"
                                                value="<?= @$fetched_data[0]['tax_number'] ?>"
                                                placeholder="Tax Number" />
                                        </div>  
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label required" for="tax_number">Withdrawal Payment Gateway</label>
                                        <div class="col">
                                           <select class="form-control" name="payment_gateway" id="payment_gateway" required>
                                            <option value="">-- Select Payment Gateway --</option>
                                            <?php foreach ($available_payment_gateways as $gateway => $config): ?>
                                                <option
                                                <?= $seller_data[0]['withdrawal_payment_gateway'] ==  $gateway ? 'selected' : '' ?>
                                                value="<?= $gateway ?>">
                                                    <?= ucfirst($gateway) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        </div>  
                                    </div>


                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="latitude">Latitude</label>
                                        <div class="col">
                                            <input type="number" class="form-control" name="latitude" id="latitude"
                                                value="<?= @$fetched_data[0]['latitude'] ?>" placeholder="Latitude" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="longitude">Longitude</label>
                                        <div class="col">
                                            <input type="number" class="form-control" name="longitude" id="longitude"
                                                value="<?= @$fetched_data[0]['longitude'] ?>" placeholder="Longitude" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="low_stock_limit">Low Stock
                                            Limit</label>
                                        <div class="col">
                                            <input type="number" class="form-control" name="low_stock_limit"
                                                id="low_stock_limit" value="<?= @$fetched_data[0]['low_stock_limit'] ?>"
                                                placeholder="Product low stock limit" min="0" />
                                            <small class="form-hint mt-2">Default limit if product-wise stock limit is
                                                not set.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- permissions -->
                            <div class="card mt-3" id="permissions">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="ti ti-lock"></i> Permissions</h3>
                                </div>
                                <div class="card-body">
                                    <?php if (isset($fetched_data[0]['permissions']) && !empty($fetched_data[0]['permissions'])) {
                                        $permit = json_decode($fetched_data[0]['permissions'], true);
                                    } ?>

                                    <!-- changed because of customization,every seller product approval is mandatory -->
                                    <div class="mb-3 row d-none">
                                        <label class="col-3 col-form-label" for="require_products_approval">Require
                                            Product's Approval?</label>
                                        <div class="col">
                                            <label class="form-check form-switch form-switch-3">
                                                <input class="form-check-input" name="require_products_approval"
                                                    id="require_products_approval" type="checkbox" Checked
                                                    <?= (isset($permit['require_products_approval']) && $permit['require_products_approval'] == '1') ? 'Checked' : '' ?> />
                                            </label>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="customer_privacy">View Customer's
                                            Details?</label>
                                        <div class="col">
                                            <label class="form-check form-switch form-switch-3">
                                                <input class="form-check-input" name="customer_privacy"
                                                    id="customer_privacy" type="checkbox"
                                                    <?= (isset($permit['customer_privacy']) && $permit['customer_privacy'] == '1') ? 'Checked' : '' ?> />
                                            </label>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- seo-config -->
                            <div class="card mt-3" id="seo-config">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="ti ti-search"></i> SEO Configuration</h3>
                                </div>
                                <div class="card-body">

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label required"
                                            for="seo_meta_keywords">Name</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="seo_page_title"
                                                id="seo_page_title" value="<?= @$fetched_data[0]['seo_page_title'] ?>"
                                                placeholder="SEO page title" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label required" for="seo_meta_keywords">SEO Meta Keywords</label>
                                        <div class="col">
                                            <input type="text"
                                                class="form-control tags"
                                                name="seo_meta_keywords"
                                                id="seo_meta_keywords"
                                                value="<?= @$fetched_data[0]['seo_meta_keywords'] ?>"
                                                placeholder="Enter SEO meta keywords (comma-separated)" />
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label required" for="seo_meta_description">SEO Meta Description</label>
                                        <div class="col">
                                            <textarea name="seo_meta_description"
                                                id="seo_meta_description"
                                                class="textarea form-control"
                                                placeholder="Enter a short SEO meta description for this page"
                                                data-bs-toggle="autosize"><?= isset($fetched_data[0]['seo_meta_description']) ? output_escaping($fetched_data[0]['seo_meta_description']) : "" ?></textarea>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label required" for="seo_og_image">SEO Open Graph
                                            Image </label>
                                        <div class="col">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="col-md-6">
                                                    <a class="uploadFile img text-decoration-none"
                                                        data-input='seo_og_image' data-isremovable='1'
                                                        data-is-multiple-uploads-allowed='0' data-bs-toggle="modal"
                                                        data-bs-target="#media-upload-modal" value="Upload Photo">
                                                        <input type="file" class="form-control" name="seo_og_image"
                                                            id="seo_og_image" />
                                                        <small class="form-hint mt-2 text-danger">*Only Choose When
                                                            Update is necessary.</small>
                                                    </a>
                                                </div>

                                                <?php if (isset($fetched_data[0]['seo_og_image']) && !empty($fetched_data[0]['seo_og_image'])) { ?>
                                                    <div class="form-group row">
                                                        <div class="mx-auto image-box-table">
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


                                    <div class="form-group text-end">
                                        <button type="reset" class="btn btn-1">Cancel</button>
                                        <button type="submit" class="btn btn-primary btn-2"
                                            id="submit_btn"><?= (isset($fetched_data[0]['id'])) ? 'Update Seller' : 'Add Seller' ?>
                                            <i class="cursor-pointer ms-2 ti ti-arrow-right"></i></button>

                                    </div>
                                </div>
                            </div>

                        </form>


                        <div class="offcanvas offcanvas-end offcanvas-medium" tabindex="-1" id="sellerCommission"
                            aria-labelledby="sellerCommissionLabel">
                            <div class="offcanvas-header">
                                <h2 class="offcanvas-title" id="sellerCommissionLabel">Categories & Commission(%)</h2>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <form method="POST" class="form-horizontal" action="<?= base_url('admin/sellers/add-seller-commission'); ?>" id="add-seller-commission-form">
                                <div class="offcanvas-body">
                                    <div>
                                        <div id="repeater">
                                            <div class="row align-items-center g-3 repeater-item my-2">
                                                <div class="col-12 col-md-5">
                                                    <div x-data x-init="initTomSelect({
                                                    element: $refs.CategorySelect,
                                                    url: '/admin/category/get_categories?from_select=1',
                                                    placeholder: 'Search Category...',
                                                    onItemAdd: addCategoryModal,
                                                    offcanvasId: 'sellerCommission',
                                                    dataAttribute: 'data-type-id',
                                                    maxItems: 1,
                                                    preloadOptions: true
                                                    
                                                })" class="row">
                                                        <div class="col">
                                                            <select x-ref="CategorySelect" name="category_id" class="form-select"
                                                                id="CategorySelect"></select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-3">
                                                    <input type="number" class="form-control" name="commission" min="0" step="0.001"
                                                        placeholder="Commission" required>
                                                </div>

                                                <a type="button" class="remove-btn text-decoration-none"
                                                    title="Remove Category"><i
                                                        class="fs-2 text-danger ti ti-xbox-x"></i></a>
                                            </div>


                                        </div>
                                        <div>
                                            <button type="button" id="add-more"
                                                class="btn btn-primary bg-primary-lt btn-sm"> More <i
                                                    class="ti ti-plus ms-2"></i></button>
                                        </div>

                                    </div>
                                    <div class="text-end">
                                        <button type="reset" class="btn btn-warning ">Reset</button>
                                        <button type="submit" class="btn btn-primary"
                                            id="submit_btn_delivery_boy">Save</button>
                                        <button type="button" class="btn btn-secondary bg-secondary-lt"
                                            data-bs-dismiss="offcanvas">Close</button>
                                    </div>
                                </div>
                            </form>
                        </div>


                        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id='addCategoryModal'>
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add Category</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <!-- <form class="form-horizontal add_category_form" id="add_category_form"
                                        method="POST"> -->


                                    <form x-data="ajaxForm({
                                                url: base_url + 'admin/category/add_category',
                                                modalId: 'addCategoryModal',
                                                loaderText: 'Saving...'
                                            })" method="POST" class="form-horizontal" id="add_category_form">
                                        <div class="modal-body">

                                            <div class="card-body">

                                                <input type="hidden" name="edit_category" id="edit_category">

                                                <div class="mb-3 row">
                                                    <label class="col-3 col-form-label required"
                                                        for="category_input_name">Name</label>
                                                    <div class="col">
                                                        <input type="text" class="form-control"
                                                            name="category_input_name" id="category_input_name"
                                                            placeholder="Category Name" />
                                                    </div>
                                                </div>

                                                <div x-data x-init="initTomSelect({
                                                    element: $refs.CategoryParentSelect,
                                                    url: '/admin/category/get_categories?from_select=1',
                                                    placeholder: 'Select Parent',
                                                })" class="mb-3 row">

                                                    <label class="col-3 col-form-label required"
                                                        for="CategoryParentSelect">Select Parent</label>
                                                    <div class="col">
                                                        <select x-ref="CategoryParentSelect" name="category_parent"
                                                            id="CategoryParentSelect"></select>
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label class="col-3 col-form-label required" for="image">Main
                                                        Image</label>
                                                    <div class="col form-group">
                                                        <a class="uploadFile img text-decoration-none"
                                                            data-input='category_input_image' data-isremovable='0'
                                                            data-is-multiple-uploads-allowed='0' data-bs-toggle="modal"
                                                            data-bs-target="#media-upload-modal" value="Upload Photo">
                                                            <input type="file" class="form-control" name="image"
                                                                id="category_input_image" />
                                                        </a>

                                                        <div class="container-fluid row image-upload-section">
                                                            <label
                                                                class="text-danger mt-3 edit_promo_upload_image_note">*Only
                                                                Choose When Update is necessary</label>
                                                            <div
                                                                class="col-sm-6 shadow rounded text-center grow image">
                                                                <div class=''>
                                                                    <img class="img-fluid mb-2"
                                                                        id="category_input_image_img"
                                                                        src="<?= base_url() . NO_IMAGE ?>"
                                                                        alt="Image Not Found">
                                                                    <input type="hidden" name="category_input_image"
                                                                        id="category_input_image_hidden"
                                                                        class="uploaded_image_here form-control form-input">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>
                                                <h4 class="bg-light m-0 px-2 py-3">SEO Configuration</h4>
                                                <hr>

                                                <div class="mb-3 row">
                                                    <label class="col-3 col-form-label required"
                                                        for="seo_page_title">SEO
                                                        Page Title</label>
                                                    <div class="col">
                                                        <input type="text" class="form-control" name="seo_page_title"
                                                            id="seo_page_title" placeholder="SEO Page title" />
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-3 col-form-label required"
                                                        for="seo_meta_description">SEO Meta Description</label>
                                                    <div class="col">
                                                        <textarea name="seo_meta_description" id="seo_meta_description"
                                                            class="textarea form-control"
                                                            placeholder="SEO Meta Description"
                                                            data-bs-toggle="autosize"> </textarea>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-3 col-form-label required"
                                                        for="seo_meta_keywords">SEO
                                                        Meta Keywords</label>
                                                    <div class="col">
                                                        <input type="text tags" class="form-control"
                                                            name="seo_meta_keywords" id="seo_meta_keywords"
                                                            placeholder="SEO Meta Keywords" />
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label class="col-3 col-form-label required" for="image">SEO Open
                                                        Graph Image </label>
                                                    <div class="col form-group">
                                                        <a class="uploadFile img text-decoration-none"
                                                            data-input='seo_og_image' data-isremovable='1'
                                                            data-is-multiple-uploads-allowed='0' data-bs-toggle="modal"
                                                            data-bs-target="#media-upload-modal" value="Upload Photo">
                                                            <input type="file" class="form-control" name="seo_og_image"
                                                                id="seo_og_image" />
                                                        </a>

                                                        <div class="container-fluid row image-upload-section">
                                                            <label
                                                                class="text-danger mt-3 edit_promo_upload_image_note">*Only
                                                                Choose When Update is necessary</label>
                                                            <div
                                                                class="col-sm-6 shadow rounded text-center grow image">
                                                                <div class=''>
                                                                    <img class="img-fluid mb-2"
                                                                        id="uploaded_og_image_here"
                                                                        src="<?= base_url() . NO_IMAGE ?>"
                                                                        alt="Image Not Found">
                                                                    <input type="hidden" name="seo_og_image"
                                                                        id="seo_og_image_hidden"
                                                                        class="uploaded_image_here form-control form-input">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- /.card-footer -->
                                        </div>
                                        <div class="modal-footer">

                                            <div class="d-flex justify-content-center form-group">
                                                <div id="result" class="p-3"></div>
                                            </div>
                                            <button type="reset" class="btn btn-warning reset_category">Reset</button>
                                            <button type="submit" class="btn btn-primary save_category_btn"
                                                id="submit_btn">Add Category</button>
                                            <button type="button" class="btn"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id='AddZipcodeModal'>
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title city_title">Add Zipcode</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <form x-data="ajaxForm({
                                            url: base_url + 'admin/area/add_zipcode',
                                            modalId: 'AddZipcodeModal',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="add_zipcode_form">

                                        <div class="modal-body">

                                            <input type="hidden" id="edit_city_zipcode" name="edit_city">
                                            <input type="hidden" id="update_id_zipcode" name="update_id" value="1">
                                            <!-- <input type="hidden" id="city_name_hidden" name="city_name"> -->

                                            <div class="card-body">

                                                <div class="mb-3 row">
                                                    <label class="col-3 col-form-label required" for="zipcode">Zipcode
                                                    </label>
                                                    <?php
                                                    if (isset($shipping_method['city_wise_deliverability']) && $shipping_method['city_wise_deliverability'] == '1') { ?>
                                                        <span class="form-hint"
                                                            title="You can enable Pincode wise deliverability from System -> store settings -> prodct deliverability ">(?)</span>
                                                    <?php } ?>
                                                    <div class="col">
                                                        <input type="text" class="form-control" name="zipcode" id="zipcode"
                                                            placeholder="Zipcode" />
                                                    </div>
                                                </div>

                                                <div x-data x-init="initTomSelect({
                                                    element: $refs.citySelect,
                                                    url: '<?= base_url('admin/area/get_cities') ?>',
                                                    placeholder: 'Search City...',
                                                    onItemAdd: 'openNewCityModal',
                                                    switchModal: { from: '#AddZipcodeModal', to: '#AddCityModal' },  <!-- 👈 dynamic switching -->
                                                    preloadOptions: true
                                                })" class="mb-3 row">

                                                    <label class="col-3 col-form-label required"
                                                        for="citySelect">City</label>
                                                    <div class="col">
                                                        <select x-ref="citySelect" class="form-select" name="city" id="citySelect"></select>
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label class="col-3 col-form-label required"
                                                        for="minimum_free_delivery_order_amount_zipcode">Minimum Free
                                                        Delivery Order
                                                        Amount</label>
                                                    <div class="col">
                                                        <input type="number" class="form-control"
                                                            name="minimum_free_delivery_order_amount" min="0" step="0.001"
                                                            id="minimum_free_delivery_order_amount_zipcode"
                                                            placeholder="Minimum Free Delivery Order Amount" />
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-3 col-form-label required"
                                                        for="delivery_charges_zipcode">Delivery Charges</label>
                                                    <div class="col">
                                                        <input type="number" class="form-control" name="delivery_charges" min="0" step="0.001"
                                                            id="delivery_charges_zipcode" placeholder="Delivery Charges" />
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="reset" class="btn btn-warning">Reset</button>
                                            <button type="submit" class="btn btn-primary save_city_btn"
                                                id="submit_btn_add_zipcode">Add Zipcode</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id='AddCityModal'>
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title city_title">Add City</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <form x-data="ajaxForm({
                                            url: base_url + 'admin/area/add_city',
                                            modalId: 'AddCityModal',
                                            loaderText: 'Saving...',
                                            switchModal: 'AddZipcodeModal'
                                        })" method="POST" class="form-horizontal" id="add_city_form">




                                        <div class="modal-body">

                                            <input type="hidden" id="edit_city_city" name="edit_city">
                                            <input type="hidden" id="update_id_city" name="update_id" value="1">
                                            <input type="hidden" id="city_name_hidden" name="city_name">

                                            <div class="card-body">

                                                <div class="mb-3 row">
                                                    <label class="col-3 col-form-label required" for="city_name">City
                                                        Name </label>
                                                    <div class="col">
                                                        <input type="text" class="form-control" name="city_name"
                                                            id="city_name" placeholder="City Name" />
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-3 col-form-label required"
                                                        for="minimum_free_delivery_order_amount_city">Minimum Free Delivery
                                                        Order Amount</label>
                                                    <div class="col">
                                                        <input type="number" class="form-control"
                                                            name="minimum_free_delivery_order_amount" min="0" step="0.001"
                                                            id="minimum_free_delivery_order_amount_city"
                                                            placeholder="Minimum Free Delivery Order Amount" />
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-3 col-form-label required"
                                                        for="delivery_charges_city">Delivery Charges</label>
                                                    <div class="col">
                                                        <input type="number" class="form-control" name="delivery_charges" min="0" step="0.001"
                                                            id="delivery_charges_city" placeholder="Delivery Charges" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="reset" class="btn btn-warning">Reset</button>
                                            <button type="submit" class="btn btn-primary save_city_btn"
                                                id="submit_btn_add_city">Add City</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<script>
    const categoriesData = <?= json_encode($categories) ?>;
</script>