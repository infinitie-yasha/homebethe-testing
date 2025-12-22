<div class="page-wrapper">
    <div class="page">
        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title"><?= isset($product_details[0]['id']) ? 'Update' : 'Add' ?> Product</h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="d-flex">
                            <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/home') ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/product') ?>">Products</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <?= isset($product_details[0]['id']) ? 'Update' : 'Add' ?>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE HEADER -->

        <input type="hidden" id="is_admin" value="true">

        <div class="page-body">
            <div class="container-xl">
                <form action="<?= base_url('admin/product/add_product'); ?>" method="POST" enctype="multipart/form-data"
                    id="save-product">

                    <!-- Hidden Fields -->
                    <?php if (isset($product_details[0]['id'])) { ?>
                        <input type="hidden" name="edit_product_id" value="<?= $product_details[0]['id'] ?>">
                        <input type="hidden" name="category_id" value="<?= $product_details[0]['category_id'] ?>">
                        <input type="hidden" id="subcategory_id_js"
                            value="<?= $product_details[0]['subcategory_id'] ?? '' ?>">
                    <?php } ?>
                    <input type="hidden" id="affiliate_categories" value="<?= $affiliate_categories ?? '' ?>">

                    <div class="row row-cards" x-data="productCategoryManager()">
                        <!-- LEFT COLUMN -->
                        <div class="col-lg-8">

                            <!-- Basic Information Card -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h3 class="card-title required">
                                        <i class="ti ti-info-circle me-1"></i>
                                        Basic Information
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="col-form-label required" for="pro_input_name">Product Name</label>
                                        <input type="text" class="form-control" name="pro_input_name"
                                            id="pro_input_name" placeholder="Enter product name"
                                            value="<?= isset($product_details[0]['name']) ? output_escaping(str_replace('\r\n', '&#13;&#10;', $product_details[0]['name'])) : '' ?>"
                                            required>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div x-data="{ 
                                                    sellerTomSelect: null,
                                                    init() {
                                                        this.sellerTomSelect = initTomSelect({
                                                            element: $refs.sellerSelect,
                                                            url: '<?= base_url('admin/product/get_sellers_data') ?>',
                                                            placeholder: 'Search Seller...',
                                                            offcanvasId: '',
                                                            maxItems: 1,
                                                            preloadOptions: true,
                                                            preselected: <?= isset($product_details[0]['seller_id']) ? $product_details[0]['seller_id'] : 'null' ?>
                                                        });
                                                        <?php if (isset($product_details[0]['id'])) { ?>
                                                        // Disable the select when editing
                                                        setTimeout(() => {
                                                            if (this.sellerTomSelect) {
                                                                this.sellerTomSelect.disable();
                                                            }
                                                        }, 100);
                                                        <?php } ?>

                                                    },
                                                    

                                                }" class="mb-3">

                                                <label class="col-form-label required" for="sellerSelect">Select a
                                                    seller</label>
                                                <?php if (empty($product_details[0]['id']) && !isset($product_details[0]['id'])) { ?>
                                                    <input type="hidden" id="seller_id" name="seller_id" value="">
                                                <?php } ?>

                                                <select x-ref="sellerSelect" class="form-select"
                                                    name="<?= isset($product_details[0]['id']) ? '' : 'seller_id' ?>"
                                                    id="sellerSelect" <?= isset($product_details[0]['id']) ? '' : 'required' ?>></select>
                                                <?php if (isset($product_details[0]['id'])) { ?>
                                                    <input type="hidden" id="seller_id" name="seller_id"
                                                        value="<?= $product_details[0]['seller_id'] ?>">
                                                    <small class="form-hint text-muted">Seller cannot be changed after
                                                        product creation</small>
                                                <?php } ?>
                                            </div>

                                        </div>

                                        <?php if (empty($product_details[0]['id'])) { ?>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="col-form-label" for="product_type_menu">Product
                                                        Type</label>
                                                    <select class="form-select" name="product_type_menu"
                                                        id="product_type_menu">
                                                        <option value="physical_product">Physical Product</option>
                                                        <option value="digital_product">Digital Product</option>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <div class="mb-3">
                                        <label class="col-form-label required" for="short_description">Short
                                            Description</label>
                                        <textarea class="hugerte-mytextarea" name="short_description"
                                            id="short_description"
                                            placeholder="Place some text here"><?= isset($product_details[0]['short_description']) ? output_escaping(str_replace('\r\n', '&#13;&#10;', $product_details[0]['short_description'])) : '' ?></textarea>
                                    </div>

                                </div>
                            </div>

                            <!-- Product Details Card -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="ti ti-file-description me-1"></i>
                                        Product Details
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div x-data x-init="initTomSelect({
                                                        element: $refs.taxSelect,
                                                        url: '<?= base_url('admin/taxes/get_taxes') ?>',
                                                        placeholder: 'Search tax...',
                                                        maxItems: 10,
                                                        preloadOptions: true,
                                                        plugins: ['remove_button']
                                                    })" class="mb-3">

                                                <label class="col-form-label" for="taxSelect">Select a tax</label>
                                                <select x-ref="taxSelect" class="form-select" name="pro_input_tax[]"
                                                    id="taxSelect" multiple>
                                                    <?php if (isset($product_details[0]['tax']) && !empty($product_details[0]['tax'])) {
                                                        $tax_ids = explode(',', $product_details[0]['tax']);
                                                        foreach ($tax_ids as $tax_id) {
                                                            $tax_id = trim($tax_id);
                                                            // Fetch tax details to get name and percentage
                                                            $tax_details = fetch_details('taxes', ['id' => $tax_id], 'title,percentage');
                                                            if (!empty($tax_details)) {
                                                                $tax_name = $tax_details[0]['title'];
                                                                $tax_percentage = $tax_details[0]['percentage'];
                                                                echo '<option value="' . $tax_id . '" selected>' . $tax_name . ' (' . $tax_percentage . '%)</option>';
                                                            } else {
                                                                echo '<option value="' . $tax_id . '" selected>' . $tax_id . '</option>';
                                                            }
                                                        }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div
                                            class="col-12 col-md-6 col-lg-4 indicator <?= (isset($product_details[0]['type']) && $product_details[0]['type'] == 'digital_product') ? 'd-none' : '' ?>">
                                            <div class="mb-3">
                                                <label class="col-form-label" for="indicator_select">Select an
                                                    Indicator</label>
                                                <select id="indicator_select" class="form-select indicator_select">
                                                    <option value="0" <?= (isset($product_details[0]['indicator']) && $product_details[0]['indicator'] == '0') ? 'selected' : '' ?>>None
                                                    </option>
                                                    <option value="1" <?= (isset($product_details[0]['indicator']) && $product_details[0]['indicator'] == '1') ? 'selected' : '' ?>>Veg
                                                    </option>
                                                    <option value="2" <?= (isset($product_details[0]['indicator']) && $product_details[0]['indicator'] == '2') ? 'selected' : '' ?>>
                                                        Non-Veg
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div x-data x-init="initTomSelect({
                                                        element: $refs.countrySelect,
                                                        url: '<?= base_url('admin/product/get_countries_data') ?>',
                                                        placeholder: 'Search country...',
                                                        maxItems: 1,
                                                        preloadOptions: true
                                                    })" class="mb-3">

                                                <label class="col-form-label" for="countrySelect">Made in
                                                    Country</label>
                                                <select x-ref="countrySelect" class="form-select" name="made_in"
                                                    id="countrySelect">
                                                    <?php if (isset($product_details[0]['made_in']) && !empty($product_details[0]['made_in'])) {
                                                        echo '<option value="' . $product_details[0]['made_in'] . '" selected>' . $product_details[0]['made_in'] . '</option>';
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div x-data x-init="initTomSelect({
                                                            element: $refs.brandSelect,
                                                            url: '<?= base_url('admin/product/get_brands_data') ?>',
                                                            placeholder: 'Search Brand...',
                                                            offcanvasId: 'filterOffcanvas',
                                                            dataAttribute: '',
                                                            maxItems: 1,
                                                            preloadOptions: true,
                                                            preselected: <?= isset($product_details[0]['brand']) && !empty($product_details[0]['brand']) ? $product_details[0]['brand'] : 'null' ?>
                                                        })" class="mb-3">

                                                <label class="col-form-label" for="brandSelect">Brand</label>
                                                <select x-ref="brandSelect" class="form-select" name="brand"
                                                    id="brandSelect"></select>
                                            </div>
                                        </div>

                                        <div
                                            class="col-12 col-md-6 col-lg-4 total_allowed_quantity <?= (isset($product_details[0]['type']) && $product_details[0]['type'] == 'digital_product') ? 'd-none' : '' ?>">
                                            <div class="mb-3">
                                                <label class="col-form-label" for="total_allowed_quantity">Total Allowed
                                                    Quantity</label>
                                                <input type="number" class="form-control" name="total_allowed_quantity"
                                                    id="total_allowed_quantity" min="1"
                                                    value="<?= $product_details[0]['total_allowed_quantity'] ?? '' ?>"
                                                    placeholder="Total Allowed Quantity">
                                            </div>
                                        </div>

                                        <div
                                            class="col-12 col-md-6 col-lg-4 minimum_order_quantity <?= (isset($product_details[0]['type']) && $product_details[0]['type'] == 'digital_product') ? 'd-none' : '' ?>">
                                            <div class="mb-3">
                                                <label class="col-form-label" for="minimum_order_quantity">Minimum Order
                                                    Quantity</label>
                                                <input type="number" class="form-control" name="minimum_order_quantity"
                                                    id="minimum_order_quantity" min="1"
                                                    value="<?= $product_details[0]['minimum_order_quantity'] ?? 1 ?>"
                                                    placeholder="Minimum Order Quantity">
                                            </div>
                                        </div>

                                        <div
                                            class="col-12 col-md-6 col-lg-4 quantity_step_size <?= (isset($product_details[0]['type']) && $product_details[0]['type'] == 'digital_product') ? 'd-none' : '' ?>">
                                            <div class="mb-3">
                                                <label class="col-form-label" for="quantity_step_size">Quantity Step
                                                    Size</label>
                                                <input type="number" class="form-control" name="quantity_step_size"
                                                    id="quantity_step_size" min="1"
                                                    value="<?= $product_details[0]['quantity_step_size'] ?? 1 ?>"
                                                    placeholder="Quantity Step Size">
                                            </div>
                                        </div>

                                        <div
                                            class="col-12 col-md-6 col-lg-4 warranty_period <?= (isset($product_details[0]['type']) && $product_details[0]['type'] == 'digital_product') ? 'd-none' : '' ?>">
                                            <div class="mb-3">
                                                <label class="col-form-label" for="warranty_period">Warranty
                                                    Period</label>
                                                <input type="text" class="form-control" name="warranty_period"
                                                    id="warranty_period"
                                                    value="<?= $product_details[0]['warranty_period'] ?? '' ?>"
                                                    placeholder="e.g., 1 Year">
                                            </div>
                                        </div>

                                        <div
                                            class="col-12 col-md-6 col-lg-4 guarantee_period <?= (isset($product_details[0]['type']) && $product_details[0]['type'] == 'digital_product') ? 'd-none' : '' ?>">
                                            <div class="mb-3">
                                                <label class="col-form-label" for="guarantee_period">Guarantee
                                                    Period</label>
                                                <input type="text" class="form-control" name="guarantee_period"
                                                    id="guarantee_period"
                                                    value="<?= $product_details[0]['guarantee_period'] ?? '' ?>"
                                                    placeholder="e.g., 6 Months">
                                            </div>
                                        </div>

                                        <div
                                            class="col-12 col-md-6 col-lg-4 hsn_code <?= (isset($product_details[0]['type']) && $product_details[0]['type'] == 'digital_product') ? 'd-none' : '' ?>">
                                            <div class="mb-3">
                                                <label class="col-form-label" for="hsn_code">HSN Code</label>
                                                <input type="text" class="form-control" name="hsn_code" id="hsn_code"
                                                    value="<?= $product_details[0]['hsn_code'] ?? '' ?>"
                                                    placeholder="HSN Code">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 ">
                                            <div class="mb-3">
                                                <label class="col-form-label required" for="tags">Product Tags</label>
                                                <input type="text tags" class="form-control" name="tags" id="tags"
                                                    placeholder="AC, Cooler, Smartphones, etc"
                                                    value="<?= isset($product_details[0]['tags']) && !empty($product_details[0]['tags']) ? $product_details[0]['tags'] : '' ?>" />
                                                <small class="form-hint">These tags help in search results</small>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Media Card -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="ti ti-photo me-1"></i>
                                        Product Media
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <!-- Main Image -->
                                    <div class="mb-4">

                                        <div class="form-group">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div>
                                                    <label class="col-form-label mb-1 required"
                                                        for="pro_input_image">Main
                                                        Image</label>
                                                    <small class="text-muted d-block">
                                                        <i class="ti ti-info-circle"></i>
                                                        Recommended: 180 x 180 pixels
                                                    </small>
                                                </div>
                                                <a class="uploadFile btn btn-primary btn-sm img text-decoration-none"
                                                    data-input='pro_input_image' data-isremovable='0'
                                                    data-is-multiple-uploads-allowed='0' data-bs-toggle="modal"
                                                    data-bs-target="#media-upload-modal" value="Upload Photo">
                                                    <i class="ti ti-upload"></i> Upload
                                                </a>
                                            </div>
                                            <div class="container-fluid row  mt-2">
                                                <?php if (isset($product_details[0]['id']) && !empty($product_details[0]['id'])) { ?>
                                                    <div class="image-uploaded-div">
                                                        <div class="border rounded p-3 d-inline-block">
                                                            <img class="img-fluid" style="max-width: 150px;"
                                                                src="<?= BASE_URL() . $product_details[0]['image'] ?>"
                                                                alt="Product Image">
                                                            <input type="hidden" name="pro_input_image"
                                                                value="<?= $product_details[0]['image'] ?>">
                                                        </div>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="image-upload-section">
                                                        <div class="card border-dashed">
                                                            <div class="card-body text-center py-5">
                                                                <i class="ti ti-photo-plus text-muted fs-3"></i>
                                                                <p class="text-muted mt-3 mb-0">No gallery images added yet
                                                                </p>
                                                                <small class="text-muted">Click "Add Images" button to
                                                                    upload</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Other Images -->
                                    <div class="mb-4">
                                        <div class="form-group">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div>
                                                    <label class="col-form-label mb-1">Product Gallery</label>
                                                    <small class="text-muted d-block">
                                                        <i class="ti ti-info-circle"></i>
                                                        Recommended: 500 x 500 pixels, Max 10 images
                                                    </small>
                                                </div>
                                                <a class="btn btn-primary btn-sm uploadFile" data-input="other_images[]"
                                                    data-isremovable="1" data-is-multiple-uploads-allowed="1"
                                                    data-bs-toggle="modal" data-bs-target="#media-upload-modal">
                                                    <i class="ti ti-photo-plus"></i> Add Images
                                                </a>
                                            </div>

                                            <div class="container-fluid row mt-2">
                                                <div class="row g-3 image-upload-div">
                                                    <?php
                                                    $other_images = [];
                                                    if (isset($product_details[0]['id']) && !empty($product_details[0]['id'])) {
                                                        $other_images = json_decode($product_details[0]['other_images']);
                                                        if (!is_array($other_images)) {
                                                            $other_images = [];
                                                        }
                                                    }

                                                    if (!empty($other_images)) {
                                                        foreach ($other_images as $index => $row) { ?>
                                                            <div class="col-6 col-md-4 col-lg-3">
                                                                <div class="card shadow-sm h-100">
                                                                    <div class="card-img-top position-relative"
                                                                        style="padding-top: 100%; overflow: hidden;">
                                                                        <img src="<?= BASE_URL() . $row ?>"
                                                                            alt="Product Image <?= $index + 1 ?>"
                                                                            class="position-absolute top-0 start-0 w-100 h-100"
                                                                            style="object-fit: cover;">
                                                                        <div class="position-absolute top-0 start-0 p-2">
                                                                            <span class="badge bg-dark-lt">
                                                                                <i class="ti ti-photo"></i> <span
                                                                                    class="image-number"><?= $index + 1 ?></span>
                                                                            </span>
                                                                        </div>
                                                                        <div class="position-absolute top-0 end-0 p-2">
                                                                            <a href="javascript:void(0)"
                                                                                class="remove-image btn btn-danger btn-sm btn-icon p-1"
                                                                                data-id="<?= isset($product_details[0]['id']) ? $product_details[0]['id'] : '' ?>"
                                                                                data-field="other_images" data-img="<?= $row ?>"
                                                                                data-table="products" data-path="<?= $row ?>"
                                                                                data-isjson="true" title="Remove image">
                                                                                <i class="ti ti-trash"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <input type="hidden" name="other_images[]"
                                                                        value="<?= $row ?>">
                                                                </div>
                                                            </div>
                                                        <?php }
                                                    } else { ?>
                                                        <!-- Show placeholder when no images -->
                                                        <div class="col-12">
                                                            <div class="image-upload-section">
                                                                <div class="card border-dashed">
                                                                    <div class="card-body text-center py-5">
                                                                        <i class="ti ti-photo-plus text-muted fs-3"></i>
                                                                        <p class="text-muted mt-3 mb-0">No gallery images
                                                                            added yet</p>
                                                                        <small class="text-muted">Click "Add Images" button
                                                                            to upload</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Video Section -->
                                    <div class="row mb-4">
                                        <div class="form-group col-md-6">
                                            <label for="video_type" class="col-form-label">Video
                                                Type</label>
                                            <select class='form-control' name='video_type' id='video_type'>
                                                <option value='' <?= (isset($product_details[0]['video_type']) && ($product_details[0]['video_type'] == '' || $product_details[0]['video_type'] == NULL)) ? 'selected' : ''; ?>>None
                                                </option>
                                                <option value='self_hosted' <?= (isset($product_details[0]['video_type']) && $product_details[0]['video_type'] == 'self_hosted') ? 'selected' : ''; ?>>
                                                    Self Hosted</option>
                                                <option value='youtube' <?= (isset($product_details[0]['video_type']) && $product_details[0]['video_type'] == 'youtube') ? 'selected' : ''; ?>>
                                                    Youtube</option>
                                                <option value='vimeo' <?= (isset($product_details[0]['video_type']) && $product_details[0]['video_type'] == 'vimeo') ? 'selected' : ''; ?>>
                                                    Vimeo</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 <?= (isset($product_details[0]['video_type']) && ($product_details[0]['video_type'] == 'youtube' || $product_details[0]['video_type'] == 'vimeo')) ? '' : 'd-none'; ?>"
                                            id="video_link_container">
                                            <label for="video" class="col-form-label" for="video">Video Link <span
                                                    class='text-danger text-sm'>*</span></label>
                                            <input type="text" class='form-control' name='video' id='video'
                                                value="<?= (isset($product_details[0]['video_type']) && ($product_details[0]['video_type'] == 'youtube' || $product_details[0]['video_type'] == 'vimeo')) ? $product_details[0]['video'] : ''; ?>"
                                                placeholder="Paste Youtube / Vimeo Video link or URL here">
                                        </div>
                                        <div class="col-md-6 mt-2 <?= (isset($product_details[0]['video_type']) && ($product_details[0]['video_type'] == 'self_hosted')) ? '' : 'd-none'; ?>"
                                            id="video_media_container">
                                            <label for="pro_input_video" class="ml-2 col-form-label">Video <span
                                                    class='text-danger text-sm'>*</span></label>
                                            <div class='col-md-3'><a
                                                    class="uploadFile img btn btn-primary text-white btn-sm"
                                                    data-input='pro_input_video' data-isremovable='1'
                                                    data-media_type='video' data-is-multiple-uploads-allowed='0'
                                                    data-bs-toggle="modal" data-bs-target="#media-upload-modal"
                                                    value="Upload Photo"><i class='ti ti-upload'></i>
                                                    Upload</a></div>
                                            <?php if (isset($product_details[0]['id']) && !empty($product_details[0]['id']) && isset($product_details[0]['video_type']) && $product_details[0]['video_type'] == 'self_hosted') { ?>
                                                <label class="text-danger mt-3">*Only Choose When Update is
                                                    necessary</label>
                                                <div class="container-fluid row image-upload-section ">
                                                    <div
                                                        class="col-md-3 col-sm-12 shadow p-3 mb-5 rounded m-4 text-center grow image">
                                                        <div class='image-upload-div'><img class="img-fluid mb-2"
                                                                src="<?= base_url('assets/admin/images/video-file.png') ?>"
                                                                alt="Product Video" title="Product Video"></div>
                                                        <input type="hidden" name="pro_input_video"
                                                            value='<?= $product_details[0]['video'] ?>'>
                                                    </div>
                                                </div>
                                            <?php } else { ?>
                                                <div class="container-fluid row image-upload-section">
                                                    <div
                                                        class="col-md-3 col-sm-12 shadow p-3 mb-5 rounded m-4 text-center grow image d-none">
                                                    </div>
                                                </div>
                                            <?php } ?>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- RIGHT COLUMN -->
                        <div class="col-lg-4">

                            <!-- Category Card -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h3 class="card-title required">
                                        <i class="ti ti-category me-1"></i>
                                        Categories
                                    </h3>
                                </div>
                                <div class="card-body category-card">
                                    <div id="product_category_tree_view_html" class="category-tree-container"></div>
                                </div>
                            </div>

                            <!-- Product Settings -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="ti ti-settings me-1"></i>
                                        Product Settings
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <?php if (isset($payment_method['cod_method']) && $payment_method['cod_method'] == 1) { ?>
                                            <div
                                                class="mb-3 cod_allowed <?= (isset($product_details[0]['type']) && $product_details[0]['type'] == 'digital_product') ? 'd-none' : '' ?>">
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="cod_allowed"
                                                        id="cod_allowed" <?= (isset($product_details[0]['cod_allowed']) && $product_details[0]['cod_allowed'] == '1') ? 'checked' : '' ?>>
                                                    <span class="form-check-label">COD Allowed</span>
                                                </label>
                                            </div>
                                        <?php } ?>

                                        <div
                                            class="mb-3 is_returnable <?= (isset($product_details[0]['type']) && $product_details[0]['type'] == 'digital_product') ? 'd-none' : '' ?>">
                                            <label class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="is_returnable"
                                                    id="is_returnable" <?= (isset($product_details[0]['is_returnable']) && $product_details[0]['is_returnable'] == '1') ? 'checked' : '' ?>>
                                                <span class="form-check-label">Returnable</span>
                                            </label>
                                        </div>

                                        <div
                                            class="mb-3 is_cancelable <?= (isset($product_details[0]['type']) && $product_details[0]['type'] == 'digital_product') ? 'd-none' : '' ?>">
                                            <label class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="is_cancelable"
                                                    id="is_cancelable" class="switch"
                                                    <?= (isset($product_details[0]['is_cancelable']) && $product_details[0]['is_cancelable'] == '1') ? 'checked' : '' ?>>
                                                <span class="form-check-label">Cancelable</span>
                                            </label>
                                        </div>

                                        <div class="mb-3 <?= (isset($product_details[0]['is_cancelable']) && $product_details[0]['is_cancelable'] == 1) ? '' : 'd-none' ?>"
                                            id="cancelable_till">
                                            <label class="col-form-label">Till Which Status? <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" value="received" disabled>
                                            <input type="hidden" name="cancelable_till" value="received">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox"
                                                    name="is_prices_inclusive_tax" id="is_prices_inclusive_tax"
                                                    <?= (isset($product_details[0]['is_prices_inclusive_tax']) && $product_details[0]['is_prices_inclusive_tax'] == '1') ? 'checked' : '' ?>>
                                                <span class="form-check-label">Tax Included in Prices</span>
                                            </label>
                                        </div>

                                        <div
                                            class="mb-3 is_attachment_required <?= (isset($product_details[0]['type']) && $product_details[0]['type'] == 'digital_product') ? 'd-none' : '' ?>">
                                            <label class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox"
                                                    name="is_attachment_required" id="is_attachment_required"
                                                    <?= (isset($product_details[0]['is_attachment_required']) && $product_details[0]['is_attachment_required'] == '1') ? 'checked' : '' ?>>
                                                <span class="form-check-label">Attachment Required</span>
                                            </label>
                                        </div>

                                        <div
                                            class="mb-3 is_in_affiliate <?= (isset($product_details[0]['type']) && $product_details[0]['type'] == 'digital_product') ? 'd-none' : '' ?>">
                                            <label class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="is_in_affiliate"
                                                    id="is_in_affiliate"
                                                    <?= (isset($product_details[0]['is_in_affiliate']) && $product_details[0]['is_in_affiliate'] == '1') ? 'checked' : '' ?>>
                                                <span class="form-check-label">In Affiliate</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Stock and Shipping Settings -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="ti ti-truck me-1"></i>
                                        Stock and Shipping Settings
                                    </h3>
                                </div>
                                <div class="card-body">

                                    <!-- Deliverability Section -->
                                    <div
                                        class="deliverable_type <?= (isset($product_details[0]['type']) && $product_details[0]['type'] == 'digital_product') ? 'd-none' : '' ?>">
                                        <?php if ((isset($shipping_method['pincode_wise_deliverability']) && $shipping_method['pincode_wise_deliverability'] == 1) || (isset($shipping_method['local_shipping_method']) && isset($shipping_method['shiprocket_shipping_method']) && $shipping_method['local_shipping_method'] == 1 && $shipping_method['shiprocket_shipping_method'] == 1)) { ?>

                                            <div class="row">
                                                <div class="mb-3">
                                                    <label class="col-form-label">Deliverable Type</label>
                                                    <select class="form-select" name="deliverable_type"
                                                        id="deliverable_type">
                                                        <option value="<?= NONE ?>"
                                                            <?= (isset($product_details[0]['deliverable_type']) && $product_details[0]['deliverable_type'] == NONE) ? 'selected' : '' ?>>
                                                            None</option>
                                                        <option value="<?= ALL ?>" <?= (!isset($product_details) || (isset($product_details[0]['deliverable_type']) && $product_details[0]['deliverable_type'] == ALL)) ? 'selected' : '' ?>>
                                                            All</option>
                                                        <option value="<?= EXCLUDED ?>"
                                                            <?= (isset($product_details[0]['deliverable_type']) && $product_details[0]['deliverable_type'] == EXCLUDED) ? 'selected' : '' ?>>Excluded</option>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="col-form-label">Deliverable Zipcodes</label>
                                                    <?php $zipcodes = (isset($product_details[0]['deliverable_zipcodes']) && $product_details[0]['deliverable_zipcodes'] != NULL) ? explode(",", $product_details[0]['deliverable_zipcodes']) : ""; ?>

                                                    <div x-data x-init="initTomSelect({
                                                    element: $refs.zipCodeSelect,
                                                    url: '/admin/area/get_zipcodes',
                                                    placeholder: 'Search Zipcode...',
                                                    dataAttribute: 'data-zipcode-ids',
                                                    maxItems: 20, 
                                                    preloadOptions: true,
                                                    plugins: ['remove_button']
                                                })" class="mb-3 row">


                                                        <div class="col">
                                                            <select x-ref="zipCodeSelect" class="form-select"
                                                                name="deliverable_zipcodes[]" id="zipCodeSelect" multiple>
                                                                <?php if (isset($product_details[0]['deliverable_zipcodes']) && !empty($product_details[0]['deliverable_zipcodes'])) {
                                                                    $zipcode_ids = explode(',', $product_details[0]['deliverable_zipcodes']);
                                                                    foreach ($zipcode_ids as $zipcode_id) {
                                                                        $zipcode_id = trim($zipcode_id);
                                                                        // Fetch zipcode details to get name
                                                                        $zipcode_details = fetch_details('zipcodes', ['id' => $zipcode_id], 'zipcode');
                                                                        if (!empty($zipcode_details)) {
                                                                            $zipcode_name = $zipcode_details[0]['zipcode'];
                                                                            echo '<option value="' . $zipcode_id . '" selected>' . $zipcode_name . '</option>';
                                                                        } else {
                                                                            echo '<option value="' . $zipcode_id . '" selected>' . $zipcode_id . '</option>';
                                                                        }
                                                                    }
                                                                } ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        <?php }
                                        if (isset($shipping_method['city_wise_deliverability']) && $shipping_method['city_wise_deliverability'] == 1 && $shipping_method['shiprocket_shipping_method'] != 1) { ?>
                                            <div class="row">
                                                <div class="mb-3">
                                                    <label class="col-form-label">Deliverable City Type</label>
                                                    <select class="form-select" name="deliverable_city_type"
                                                        id="deliverable_city_type">
                                                        <option value="<?= NONE ?>"
                                                            <?= (isset($product_details[0]['deliverable_city_type']) && $product_details[0]['deliverable_city_type'] == NONE) ? 'selected' : '' ?>>None</option>
                                                        <option value="<?= ALL ?>" <?= (!isset($product_details) || (isset($product_details[0]['deliverable_city_type']) && $product_details[0]['deliverable_city_type'] == ALL)) ? 'selected' : '' ?>>All</option>
                                                        <option value="<?= EXCLUDED ?>"
                                                            <?= (isset($product_details[0]['deliverable_city_type']) && $product_details[0]['deliverable_city_type'] == EXCLUDED) ? 'selected' : '' ?>>Excluded</option>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="col-form-label">Deliverable Cities</label>
                                                    <div x-data x-init="initTomSelect({
                                                    element: $refs.citySelect,
                                                    url: '<?= base_url('admin/area/get_cities') ?>',
                                                    placeholder: 'Search City...',  
                                                    dataAttribute: 'data-city-id',
                                                    maxItems: 10,
                                                    preloadOptions: true,
                                                    plugins: ['remove_button']
                                                })" class="mb-3 row">
                                                        <label class="col-3 col-form-label required"
                                                            for="citySelect">City</label>
                                                        <div class="col">
                                                            <select x-ref="citySelect" class="form-select"
                                                                name="deliverable_cities[]" id="citySelect" multiple>
                                                                <?php if (isset($product_details[0]['deliverable_cities']) && !empty($product_details[0]['deliverable_cities'])) {
                                                                    $city_ids = explode(',', $product_details[0]['deliverable_cities']);
                                                                    foreach ($city_ids as $city_id) {
                                                                        $city_id = trim($city_id);
                                                                        // Fetch city details to get name
                                                                        $city_details = fetch_details('cities', ['id' => $city_id], 'name');
                                                                        if (!empty($city_details)) {
                                                                            $city_name = $city_details[0]['name'];
                                                                            echo '<option value="' . $city_id . '" selected>' . $city_name . '</option>';
                                                                        } else {
                                                                            echo '<option value="' . $city_id . '" selected>' . $city_id . '</option>';
                                                                        }
                                                                    }
                                                                } ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="mb-3">
                                        <label class="col-form-label">Low Stock Limit <small
                                                class="text-secondary">(Seller's
                                                default will apply if not
                                                specified)</small></label>
                                        <input type="number" class="form-control" name="low_stock_limit"
                                            value="<?= @$product_details[0]['low_stock_limit'] ?>"
                                            placeholder="Low stock limit">
                                    </div>

                                    <div
                                        class="mb-3 pickup_locations <?= (isset($product_details[0]['type']) && $product_details[0]['type'] == 'digital_product') ? 'd-none' : '' ?>">
                                        <label class="col-form-label">Pickup Location for Standard Shipping
                                            <?php if (isset($shipping_method['shiprocket_shipping_method']) && $shipping_method['shiprocket_shipping_method'] == 1) { ?>
                                                <span class="text-danger">*</span>
                                            <?php } ?>
                                        </label>
                                        <select class="form-select shiprocket_type" name="pickup_location"
                                            id="pickup_location">
                                            <option value="">Select Pickup Location</option>
                                            <?php foreach ($shipping_data as $row) {
                                                $pickup_location_id = (isset($product_details[0]['pickup_location']) && !empty($product_details[0]['pickup_location']) ? $product_details[0]['pickup_location'] : "") ?>
                                                <option <?php if ($row['id'] == $pickup_location_id) { ?> selected <?php } ?>
                                                    value="<?= $row['id'] ?>">
                                                    <?= $row['pickup_location'] ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                </div>
                            </div>


                            <!-- SEO Settings Card -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="ti ti-search me-1"></i>
                                        SEO Settings
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="col-form-label">SEO Page Title</label>
                                        <input type="text" class="form-control" name="seo_page_title"
                                            placeholder="SEO page title"
                                            value="<?= isset($product_details[0]['seo_page_title']) ? output_escaping($product_details[0]['seo_page_title']) : '' ?>">
                                        <small class="form-hint">Optimize your page title for search engines</small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="col-form-label">SEO Meta Keywords</label>
                                        <input type="text" class="form-control tagify" name="seo_meta_keywords"
                                            id="seo_meta_keywords" placeholder="Type and press enter to add keywords"
                                            value="<?= isset($product_details[0]['seo_meta_keywords']) ? output_escaping($product_details[0]['seo_meta_keywords']) : '' ?>"
                                            data-whitelist="">
                                        <small class="form-hint">Type keywords and press enter to create tags</small>

                                    </div>

                                    <div class="mb-3">
                                        <label class="col-form-label">SEO Meta Description</label>
                                        <textarea class="form-control" name="seo_meta_description" rows="3"
                                            placeholder="SEO meta description"><?= isset($product_details[0]['seo_meta_description']) ? output_escaping($product_details[0]['seo_meta_description']) : '' ?></textarea>
                                        <small class="form-hint">Write a compelling description for search
                                            results</small>
                                    </div>

                                    <div class="mb-3">
                                        <div class="form-group">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div>
                                                    <label class="col-form-label mb-1" for="seo_og_image">SEO Open Graph
                                                        Image</label>
                                                    <small class="text-muted d-block">
                                                        <i class="ti ti-info-circle"></i>
                                                        Recommended: 1200 x 630 pixels for social media
                                                    </small>
                                                </div>
                                                <a class="uploadFile btn btn-primary btn-sm img text-decoration-none"
                                                    data-input='seo_og_image' data-isremovable='0'
                                                    data-is-multiple-uploads-allowed='0' data-bs-toggle="modal"
                                                    data-bs-target="#media-upload-modal" value="Upload Photo">
                                                    <i class="ti ti-upload"></i> Upload
                                                </a>
                                            </div>
                                            <div class="container-fluid row mt-2">
                                                <?php if (!empty(@$product_details[0]['seo_og_image'])) { ?>
                                                    <div class="image-uploaded-div">
                                                        <div class="border rounded p-3 d-inline-block">
                                                            <img class="img-fluid" style="max-width: 150px;"
                                                                src="<?= BASE_URL() . $product_details[0]['seo_og_image'] ?>"
                                                                alt="SEO OG Image">
                                                            <input type="hidden" name="seo_og_image"
                                                                value="<?= $product_details[0]['seo_og_image'] ?>">
                                                        </div>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="image-upload-section">
                                                        <div class="card border-dashed">
                                                            <div class="card-body text-center py-5">
                                                                <i class="ti ti-photo-plus text-muted fs-3"></i>
                                                                <p class="text-muted mt-3 mb-0">No SEO image added yet</p>
                                                                <small class="text-muted">Click "Upload" button to add SEO
                                                                    image</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>




                    </div>
                    <div class="mb-3">
                        <div class="card mb-3">
                            <div class="card-header">
                                <ul class="nav nav-tabs card-header-tabs"
                                    data-hp-theme-mode="<?= isset($_COOKIE['tablerTheme']) ? $_COOKIE['tablerTheme'] : 'light' ?>"
                                    role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a href="#general-tab" class="nav-link active" data-bs-toggle="tab"
                                            aria-selected="true" role="tab">General</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a href="#product-attributes"
                                            class="nav-link <?= !isset($product_details[0]['id']) ? 'disabled' : '' ?>"
                                            data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1"
                                            id="tab-for-attributes">Attributes</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a href="#product-variants"
                                            class="nav-link <?= !isset($product_details[0]['id']) || (isset($product_details[0]['type']) && ($product_details[0]['type'] == 'simple_product' || $product_details[0]['type'] == 'digital_product')) ? 'disabled d-none' : '' ?>"
                                            data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1"
                                            id="tab-for-variations">Variations</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <!-- General Tab -->
                                    <div class="tab-pane active show" id="general-tab" role="tabpanel">
                                        <div class="mb-3">
                                            <label class="col-form-label">Type of Product</label>
                                            <select name="type" id="product-type" class="form-select"
                                                <?= isset($product_details[0]['id']) ? 'disabled' : '' ?>>
                                                <option value="">Select Type</option>
                                                <option value="simple_product" <?= (isset($product_details[0]['type']) && $product_details[0]['type'] == "simple_product") ? 'selected' : '' ?>>
                                                    Simple Product</option>
                                                <option value="variable_product" <?= (isset($product_details[0]['type']) && $product_details[0]['type'] == "variable_product") ? 'selected' : '' ?>>Variable Product</option>
                                                <option value="digital_product" <?= (isset($product_details[0]['type']) && $product_details[0]['type'] == "digital_product") ? 'selected' : '' ?>>Digital Product</option>
                                            </select>
                                            <?php if (isset($product_details[0]['id'])) {
                                                @$variant_stock_level = !empty($product_details[0]['stock_type']) && $product_details[0]['stock_type'] == '1' ? 'product_level' : 'variant_level';
                                                ?>
                                                <input type="hidden" name="product_type"
                                                    value="<?= $product_details[0]['type'] ?>">
                                                <input type="hidden" name="simple_product_stock_status"
                                                    <?= isset($product_details[0]['stock_type']) && !empty($product_details[0]['stock_type']) && $product_details[0]['type'] == 'simple_product' ? 'value="' . $product_details[0]['stock_type'] . '"' : '' ?>>
                                                <input type="hidden" name="variant_stock_level_type"
                                                    <?= isset($product_details[0]['stock_type']) && !empty($product_details[0]['stock_type']) && $product_details[0]['type'] == 'variable_product' ? 'value="' . $variant_stock_level . '"' : '' ?>>
                                                <input type="hidden" name="variant_stock_status"
                                                    <?= isset($product_details[0]['stock_type']) && !empty($product_details[0]['stock_type']) && $product_details[0]['type'] == 'variable_product' ? 'value="0"' : '' ?>>
                                            <?php } ?>
                                        </div>

                                        <div id="product-general-settings">
                                            <!-- This will be populated dynamically based on product type -->
                                            <div id="simple-product-settings"
                                                class="<?= (isset($product_details[0]['type']) && ($product_details[0]['type'] == 'simple_product' || $product_details[0]['type'] == 'digital_product')) ? '' : 'd-none' ?>">
                                                <div class="mb-3">
                                                    <label class="col-form-label required">Price</label>
                                                    <input type="number" name="simple_price"
                                                        class="form-control price stock-simple-mustfill-field"
                                                        step="0.01" min="0"
                                                        value="<?= isset($product_variants[0]['price']) ? $product_variants[0]['price'] : '' ?>"
                                                        placeholder="0.00">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label">Special Price</label>
                                                    <input type="number" name="simple_special_price"
                                                        class="form-control discounted_price" step="0.01" min="0"
                                                        value="<?= isset($product_variants[0]['special_price']) ? $product_variants[0]['special_price'] : '' ?>"
                                                        placeholder="0.00">
                                                </div>

                                                <!-- Dimensions for Physical Products -->
                                                <div
                                                    class="dimensions <?= (isset($product_details[0]['type']) && $product_details[0]['type'] == 'digital_product') ? 'd-none' : '' ?>">
                                                    <label class="col-form-label">Product Dimensions</label>
                                                    <div class="row">
                                                        <div class="col-6 mb-2">
                                                            <input type="number" class="form-control" name="weight"
                                                                step="0.001"
                                                                value="<?= isset($product_variants[0]['weight']) ? $product_variants[0]['weight'] : '' ?>"
                                                                placeholder="Weight (kg)">
                                                        </div>
                                                        <div class="col-6 mb-2">
                                                            <input type="number" class="form-control" name="height"
                                                                step="0.001"
                                                                value="<?= isset($product_variants[0]['height']) ? $product_variants[0]['height'] : '' ?>"
                                                                placeholder="Height (cm)">
                                                        </div>
                                                        <div class="col-6 mb-2">
                                                            <input type="number" class="form-control" name="breadth"
                                                                step="0.001"
                                                                value="<?= isset($product_variants[0]['breadth']) ? $product_variants[0]['breadth'] : '' ?>"
                                                                placeholder="Breadth (cm)">
                                                        </div>
                                                        <div class="col-6 mb-2">
                                                            <input type="number" class="form-control" name="length"
                                                                step="0.001"
                                                                value="<?= isset($product_variants[0]['length']) ? $product_variants[0]['length'] : '' ?>"
                                                                placeholder="Length (cm)">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Stock Management -->
                                                <div
                                                    class="<?= (isset($product_details[0]['type']) && $product_details[0]['type'] == 'digital_product') ? 'd-none' : '' ?>">
                                                    <hr class="my-3">
                                                    <label class="form-check form-switch mb-3">
                                                        <input class="form-check-input simple_stock_management_status"
                                                            type="checkbox" name="simple_stock_management_status"
                                                            <?= (isset($product_details[0]['id']) && $product_details[0]['stock_type'] != NULL) ? 'checked' : '' ?>>
                                                        <span class="form-check-label">Enable Stock
                                                            Management</span>
                                                    </label>

                                                    <div
                                                        class="simple-product-level-stock-management <?= (isset($product_details[0]['id']) && $product_details[0]['stock_type'] == NULL) ? 'd-none' : '' ?>">
                                                        <div class="mb-3">
                                                            <label class="col-form-label required">SKU</label>
                                                            <input type="text" name="product_sku"
                                                                class="form-control simple-pro-sku stock-simple-mustfill-field"
                                                                value="<?= (isset($product_details[0]['id']) && $product_details[0]['stock_type'] != NULL) ? $product_details[0]['sku'] : '' ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="col-form-label required">Total Stock</label>
                                                            <input type="number" min="1" name="product_total_stock"
                                                                class="form-control stock-simple-mustfill-field"
                                                                value="<?= (isset($product_details[0]['id']) && $product_details[0]['stock_type'] != NULL) ? $product_details[0]['stock'] : '' ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="col-form-label required">Stock Status</label>
                                                            <select class="form-select stock-simple-mustfill-field"
                                                                id="simple_product_stock_status">
                                                                <option value="1"
                                                                    <?= (isset($product_details[0]['stock_type']) && $product_details[0]['stock_type'] != NULL && $product_details[0]['availability'] == "1") ? 'selected' : '' ?>>In Stock</option>
                                                                <option value="0"
                                                                    <?= (isset($product_details[0]['stock_type']) && $product_details[0]['stock_type'] != NULL && $product_details[0]['availability'] == "0") ? 'selected' : '' ?>>Out Of Stock</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Digital Product Settings (Always included, visibility controlled by JS) -->
                                                <div id="digital_product_setting"
                                                    class="<?= (!isset($product_details[0]['type']) || $product_details[0]['type'] != 'digital_product') ? 'd-none' : '' ?>">
                                                    <hr class="my-3">
                                                    <div class="mb-3">
                                                        <label class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="download_allowed" id="download_allowed"
                                                                <?= (isset($product_details[0]['download_allowed']) && $product_details[0]['download_allowed'] == '1') ? 'checked' : '' ?>>
                                                            <span class="form-check-label">Download Allowed</span>
                                                        </label>
                                                    </div>

                                                    <div id="download_type"
                                                        class="<?= (isset($product_details[0]['download_type'])) ? '' : 'd-none' ?>">
                                                        <div class="mb-3">
                                                            <label class="col-form-label required">Download Link
                                                                Type</label>
                                                            <select class="form-select" name="download_link_type"
                                                                id="download_link_type">
                                                                <option value="">None</option>
                                                                <option value="self_hosted"
                                                                    <?= (isset($product_details[0]['download_link_type']) && $product_details[0]['download_link_type'] == 'self_hosted') ? 'selected' : '' ?>>Self Hosted</option>
                                                                <option value="add_link"
                                                                    <?= (isset($product_details[0]['download_link_type']) && $product_details[0]['download_link_type'] == 'add_link') ? 'selected' : '' ?>>Add Link</option>
                                                            </select>
                                                        </div>

                                                        <div id="self_hosted_link"
                                                            class="mb-3 <?= (isset($product_details[0]['download_link_type']) && $product_details[0]['download_link_type'] == 'self_hosted') ? '' : 'd-none' ?>">
                                                            <label class="col-form-label">Upload File</label>
                                                            <a class="btn btn-primary btn-sm uploadFile"
                                                                data-input="pro_input_zip" data-isremovable="1"
                                                                data-is-multiple-uploads-allowed="0"
                                                                data-media_type="archive,document" data-toggle="modal"
                                                                data-target="#media-upload-modal">
                                                                <i class="ti ti-upload"></i> Upload File
                                                            </a>
                                                            <?php if (isset($product_details[0]['id']) && !empty($product_details[0]['id']) && isset($product_details[0]['download_link_type']) && $product_details[0]['download_link_type'] == 'self_hosted') { ?>
                                                                <small class="text-danger d-block mt-2">*Only Choose
                                                                    When Update is necessary</small>
                                                                <div class="container-fluid row image-upload-section">
                                                                    <div
                                                                        class="col-md-3 col-sm-12 shadow p-3 mb-5 rounded m-4 text-center grow image">
                                                                        <div class='image-upload-div'><img
                                                                                class="img-fluid mb-2"
                                                                                src="<?= base_url('assets/admin/images/archive-file.png') ?>"
                                                                                alt="Image Not Found"></div>
                                                                        <input type="hidden" name="pro_input_zip"
                                                                            value='<?= $product_details[0]['download_link'] ?>'>
                                                                    </div>
                                                                </div>
                                                            <?php } else { ?>
                                                                <div class="container-fluid row image-upload-section">
                                                                    <div
                                                                        class="col-md-3 col-sm-12 shadow p-3 mb-5 rounded m-4 text-center grow image d-none">
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                        </div>

                                                        <div id="add_link"
                                                            class="mb-3 <?= (isset($product_details[0]['download_link_type']) && $product_details[0]['download_link_type'] == 'add_link') ? '' : 'd-none' ?>">
                                                            <label class="col-form-label">Download Link</label>
                                                            <input type="url" class="form-control" name="download_link"
                                                                id="download_link"
                                                                placeholder="Paste digital product link or URL here"
                                                                value="<?= (isset($product_details[0]['download_link_type']) && $product_details[0]['download_link_type'] == 'add_link') ? $product_details[0]['download_link'] : '' ?>">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Save/Reset Buttons for Simple/Digital Products -->
                                                <div class="simple-product-save">
                                                    <hr class="my-3">
                                                    <div class="d-flex gap-2">
                                                        <a href="javascript:void(0);"
                                                            class="btn btn-success save-settings">
                                                            <i class="ti ti-device-floppy"></i> Save Settings
                                                        </a>
                                                        <a href="javascript:void(0);"
                                                            class="btn btn-warning reset-settings <?= (isset($product_details[0]['type']) && $product_details[0]['type'] == "digital_product") ? 'd-none' : ''; ?>"
                                                            data-type="<?= isset($product_details[0]['type']) ? $product_details[0]['type'] : 'simple_product' ?>">
                                                            <i class="ti ti-refresh"></i> Reset Settings
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Variable Product Settings -->
                                            <div id="variable-product-settings"
                                                class="<?= (isset($product_details[0]['type']) && $product_details[0]['type'] == 'variable_product') ? '' : 'd-none' ?>">

                                                <div id="variant_stock_level">
                                                    <div class="mb-3">
                                                        <label class="form-check form-switch">
                                                            <input class="form-check-input variant_stock_status"
                                                                type="checkbox" name="variant_stock_management_status"
                                                                <?= (isset($product_details[0]['id']) && $product_details[0]['stock_type'] != NULL) ? 'checked' : '' ?>>
                                                            <span class="form-check-label">Enable Stock
                                                                Management</span>
                                                        </label>
                                                    </div>

                                                    <div class="mb-3 <?= (isset($product_details[0]['id']) && intval($product_details[0]['stock_type']) > 0) ? '' : 'd-none' ?>"
                                                        id="stock_level">
                                                        <label class="col-form-label">Choose Stock Management
                                                            Type</label>
                                                        <select id="stock_level_type"
                                                            class="form-select variant-stock-level-type">
                                                            <option value="">Select Stock Type</option>
                                                            <option value="product_level"
                                                                <?= (isset($product_details[0]['id']) && $product_details[0]['stock_type'] == '1') ? 'selected' : '' ?>>
                                                                Product Level (Stock Will Be Managed Generally)
                                                            </option>
                                                            <option value="variable_level"
                                                                <?= (isset($product_details[0]['id']) && $product_details[0]['stock_type'] == '2') ? 'selected' : '' ?>>
                                                                Variable Level (Stock Will Be Managed Variant Wise)
                                                            </option>
                                                        </select>

                                                        <!-- Product Level Stock Management -->
                                                        <div
                                                            class="variant-product-level-stock-management <?= (isset($product_details[0]['id']) && intval($product_details[0]['stock_type']) == 1) ? '' : 'd-none' ?>">
                                                            <div class="mb-3 mt-3">
                                                                <label class="col-form-label required">SKU</label>
                                                                <input type="text" name="sku_variant_type"
                                                                    id="sku_variant_type" class="form-control"
                                                                    value="<?= (isset($product_details[0]['id']) && intval($product_details[0]['stock_type']) == 1 && isset($product_variants[0]['id']) && !empty($product_variants[0]['sku'])) ? $product_variants[0]['sku'] : '' ?>">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="col-form-label required"
                                                                    for="total_stock_variant_type">Total
                                                                    Stock</label>
                                                                <input type="number" min="1"
                                                                    name="total_stock_variant_type"
                                                                    id="total_stock_variant_type"
                                                                    class="form-control variant-stock-mustfill-field"
                                                                    value="<?= (isset($product_details[0]['id']) && intval($product_details[0]['stock_type']) == 1 && isset($product_variants[0]['id']) && !empty($product_variants[0]['stock'])) ? $product_variants[0]['stock'] : '' ?>">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="col-form-label required">Stock
                                                                    Status</label>
                                                                <select type="text" id="stock_status_variant_type"
                                                                    name="variant_status"
                                                                    class="form-select variant-stock-mustfill-field">
                                                                    <option value="1"
                                                                        <?= (isset($product_details[0]['id']) && intval($product_details[0]['stock_type']) == 1 && isset($product_variants[0]['id']) && $product_variants[0]['availability'] == '1') ? 'selected' : '' ?>>
                                                                        In Stock
                                                                    </option>
                                                                    <option value="0"
                                                                        <?= (isset($product_details[0]['id']) && intval($product_details[0]['stock_type']) == 1 && isset($product_variants[0]['id']) && $product_variants[0]['availability'] == '0') ? 'selected' : '' ?>>
                                                                        Out Of Stock
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Save Button for Variable Products -->
                                                    <div class="mb-3">
                                                        <a href="javascript:void(0);"
                                                            class="btn btn-success save-variant-general-settings">
                                                            <i class="ti ti-device-floppy"></i> Save Settings
                                                        </a>
                                                    </div>
                                                </div>

                                                <div class="alert alert-info mt-3">
                                                    <i class="ti ti-info-circle"></i> Please add attributes and then
                                                    configure variations.
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Attributes Tab -->
                                    <div class="tab-pane" id="product-attributes" role="tabpanel"
                                        aria-labelledby="product-attributes-tab">
                                        <div class="alert alert-secondary d-none" id="note">
                                            <div class="d-flex align-items-center">
                                                <strong>Note:</strong>
                                                <input type="checkbox" checked class="ms-3 form-check-input" disabled>
                                                <span class="ms-2">Check if the attribute is to be used for
                                                    variation</span>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end mb-3">
                                            <a href="javascript:void(0);" id="add_attributes"
                                                class="btn btn-primary btn-sm">
                                                <i class="ti ti-plus"></i> Add Attributes
                                            </a>
                                            <a href="javascript:void(0);" id="save_attributes"
                                                class="btn btn-success btn-sm ms-2 d-none">
                                                <i class="ti ti-device-floppy"></i> Save Attributes
                                            </a>
                                        </div>

                                        <div id="attributes_process">
                                            <div
                                                class="form-group text-center row my-auto p-2 border rounded no-attributes-added">
                                                <div class="col-md-12 text-center">No Product Attributes Are
                                                    Added!
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Hidden attributes data -->
                                        <div id="attributes_values_json_data" class="d-none">
                                            <select class="select_single">
                                                <option value=""></option>
                                                <?php foreach ($attributes_refind as $key => $value) { ?>
                                                    <optgroup label="<?= $key ?>">
                                                        <?php foreach ($value as $attr_key => $attr_value) { ?>
                                                            <option name="<?= $attr_key ?>" value="<?= $attr_key ?>"
                                                                data-values='<?= json_encode($attr_value, 1) ?>'>
                                                                <?= $attr_key ?>
                                                            </option>
                                                        <?php } ?>
                                                    </optgroup>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Variations Tab -->
                                    <div class="tab-pane" id="product-variants" role="tabpanel"
                                        aria-labelledby="product-variants-tab">
                                        <div class="d-flex justify-content-end mb-3">
                                            <a href="javascript:void(0);" id="reset_variants"
                                                class="btn btn-warning btn-sm d-none">
                                                <i class="ti ti-refresh"></i> Reset Variants
                                            </a>
                                        </div>

                                        <div
                                            class="form-group text-center row my-auto p-2 border rounded no-variants-added">
                                            <div class="col-md-12 text-center">No Product Variations Are Added!
                                            </div>
                                        </div>

                                        <div id="variants_process" class="ui-sortable">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <!-- Description Card -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3 class="card-title required">
                                    <i class="ti ti-text me-1"></i>
                                    Product Description
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">

                                    <div class="col-12 col-md-6">
                                        <label class="col-form-label required"
                                            for="pro_input_description">Description</label>
                                        <textarea class="hugerte-mytextarea form-control" name="pro_input_description"
                                            placeholder="Place some text here"><?= (isset($product_details[0]['id'])) ? output_escaping(str_replace('\r\n', '&#13;&#10;', $product_details[0]['description'] ?? '')) : ''; ?></textarea>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="col-form-label required" for="extra_input_description">Extra
                                            Description</label>
                                        <textarea class="hugerte-mytextarea form-control" name="extra_input_description"
                                            placeholder="Place some text here"><?= (isset($product_details[0]['id'])) ? output_escaping(str_replace('\r\n', '&#13;&#10;', $product_details[0]['extra_description'] ?? '')) : ''; ?></textarea>
                                    </div>

                                </div>

                                <div class="my-3 row">
                                    <div class="col-12 col-md-9">
                                        <label class="col-form-label required" for="approval_status">Approval
                                            Status</label>
                                        <div id="approval_status"
                                            class="d-flex flex-column flex-sm-row flex-wrap gap-2">

                                            <label class="btn bg-warning-lt d-flex align-items-center px-3 py-2">
                                                <input type="radio" <?= (isset($product_details[0]['approval_status']) && $product_details[0]['approval_status'] == 'pending') ? 'checked' : '' ?> name="approval_status" id="pending" value="pending" class="me-2">
                                                Pending
                                            </label>

                                            <label class="btn bg-primary-lt d-flex align-items-center px-3 py-2">
                                                <input type="radio" <?= (isset($product_details[0]['approval_status']) && $product_details[0]['approval_status'] == 'approved') ? 'checked' : '' ?> name="approval_status" id="approved" value="approved"
                                                    class="me-2">
                                                Approved
                                            </label>

                                            <label class="btn bg-danger-lt d-flex align-items-center px-3 py-2">
                                                <input type="radio" data-bs-toggle="modal"
                                                    data-bs-target="#rejectReasonModal"
                                                    <?= (isset($product_details[0]['approval_status']) && $product_details[0]['approval_status'] == 'rejected') ? 'checked' : '' ?> name="approval_status" id="rejected" value="rejected"
                                                    class="me-2">
                                                Not-Approved
                                            </label>
                                        </div>
                                    </div>
                                    <input type="hidden" id="product_rejection_reason"
                                        value="  <?= (isset($product_details[0]['rejection_reason']) && !empty($product_details[0]['rejection_reason'])) ? trim($product_details[0]['rejection_reason']) : '' ?>"
                                        name="product_rejection_reason">
                                </div>
                            </div>

                            <div class="space-y m-3">
                                <div class="form-group text-end">
                                    <button type="reset" class="btn">Cancel</button>
                                    <button type="submit" class="btn btn-primary " id="save_product_button">
                                        <i class="ti ti-device-floppy"></i>
                                        <?= isset($product_details[0]['id']) ? 'Update' : 'Save' ?> Product <i
                                            class="cursor-pointer ms-2 ti ti-arrow-right"></i>
                                    </button>
                                    <!-- <button type="submit" class="btn btn-primary " id="submit_btn">Update
                                        Settings <i class="cursor-pointer ms-2 ti ti-arrow-right"></i></button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- rejection reason Modal  -->
<div class="modal modal-blur fade" id="rejectReasonModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rejection Reason</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label class="form-label required">Reason</label>
                <textarea name="rejection_reason" id="rejection_reason" class="form-control" rows="4" required>
                <?= trim($product_details[0]['rejection_reason'] ?? '') ?>
                </textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn me-auto" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                    id="saveRejectionReason">Save</button>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const productForm = document.getElementById('save-product');
        if (productForm) {
            productForm.addEventListener('submit', function (e) {
                const sellerSelect = document.getElementById('sellerSelect');
                // console.log('Seller Select Element:', sellerSelect);
                const hiddenSellerInput = document.querySelector('input[name="seller_id"][type="hidden"]');

                // Check if we're in edit mode (hidden input exists)
                const isEditMode = hiddenSellerInput !== null;

                if (sellerSelect && !isEditMode) {
                    const sellerValue = sellerSelect.value;
                    // console.log('Seller ID on submit:', sellerValue);

                    if (!sellerValue || sellerValue === '' || sellerValue === 'null') {
                        e.preventDefault();
                        alert('Please select a seller before submitting the form.');
                        return false;
                    }
                }
            });
        }
    });
</script>