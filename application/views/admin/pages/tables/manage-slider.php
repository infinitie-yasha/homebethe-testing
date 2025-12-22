<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">Sliders For Add-on Offers and other benefits</h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="d-flex">
                            <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/home') ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">Manage Slider</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE HEADER -->

        <div class="page-body">
            <div class="container-xl">
                <div class="col-12">
                    <!-- Filters Section -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Filters & Search</h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="col-form-label" for="type_filter">Filter By Type</label>
                                    <select class="form-select" name="type_filter" id="type_filter">
                                        <option value="">Select Type</option>
                                        <option value="default">Default</option>
                                        <option value="categories">Category</option>
                                        <option value="products">Product</option>
                                        <option value="sliderurl">Slider URL</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title"><i class="ti ti-language"></i> Manage Sliders</h3>
                            <a href="#" class="btn btn-primary addSliderBtn btn-sm bg-primary-lt"
                                data-bs-toggle="offcanvas" data-bs-target="#addSlider">Add Slider</a>
                        </div>
                        <div class="card-body">
                            <table class='table-striped' id="slider_table" data-toggle="table"
                                data-url="<?= base_url('admin/slider/view_slider') ?>" data-click-to-select="true"
                                data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                                data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                                data-sort-order="desc" data-mobile-responsive="true" data-toolbar=""
                                data-show-export="true" data-maintain-selected="true"
                                data-query-params="slider_queryParams">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true" data-align='center'>ID</th>
                                        <th data-field="type" data-sortable="false" data-align='center'>Type</th>
                                        <th data-field="type_id" data-sortable="true" data-align='center'
                                            data-visible='false'>Type id</th>
                                        <th data-field="name" data-sortable="false" data-align='center'>Name</th>
                                        <th data-field="image" data-sortable="false" data-align='center'>Image</th>
                                        <th data-field="link" data-sortable="true" data-align='center'
                                            data-visible='false'>Link</th>
                                        <th data-field="operate" data-sortable="false" data-align='center'>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="offcanvas offcanvas-end offcanvas-medium" tabindex="-1" id="addSlider"
                            aria-labelledby="addSliderLabel">
                            <div class="offcanvas-header">
                                <h2 class="offcanvas-title" id="addSliderLabel">Add Slider</h2>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>

                            <form x-data="ajaxForm({
                    url: base_url + 'admin/slider/add_slider',
                    offcanvasId: 'addSlider',
                    loaderText: 'Saving...'
                })" method="POST" class="form-horizontal" id="add_slider_form">

                                <div class="offcanvas-body">
                                    <div>
                                        <div class="card-body">

                                            <input type="hidden" name="edit_slider" id="edit_slider" value="">
                                            <input type="hidden" name="type_id" id="type_id" value="">

                                            <div class="mb-3 row">
                                                <label class="col-3 col-form-label required"
                                                    for="slider_type">Type</label>
                                                <div class="col">
                                                    <select name="slider_type" id="slider_type"
                                                        class="form-control type_event_trigger">
                                                        <option value="">Select Type</option>
                                                        <option value="default">Default</option>
                                                        <option value="categories">Category</option>
                                                        <option value="products">Product</option>
                                                        <option value="sliderurl">Slider URL</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div id="type_add_html">

                                                <div class="mb-3 row slider-categories d-none">
                                                    <div x-data x-init="initTomSelect({
                                                        element: $refs.CategorySelect,
                                                        url: '/admin/category/get_categories?from_select=1',
                                                        placeholder: 'Search Category...',
                                                        onItemAdd: addCategoryModal,
                                                        offcanvasId: 'addSlider',
                                                        dataAttribute: 'data-type-id',
                                                        maxItems: 1,
                                                        preloadOptions: true
                                                    })" class="mb-3 row">

                                                        <label class="col-3 col-form-label required"
                                                            for="CategorySelect">Select Category</label>
                                                        <div class="col">
                                                            <select x-ref="CategorySelect" name="category_id"
                                                                class="form-select" id="CategorySelect"></select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-3 row slider-products d-none">
                                                    <div x-data x-init="initTomSelect({
                                                                        element: $refs.ProductSelect,
                                                                        url: '/admin/product/get_product_data?from_select=1',
                                                                        placeholder: 'Search Product...',
                                                                        offcanvasId: 'addSlider',
                                                                        dataAttribute: 'data-type-id',
                                                                        maxItems: 1,
                                                                        preloadOptions: true
                                                                    })" class="mb-3 row">

                                                        <label class="col-3 col-form-label required"
                                                            for="ProductSelect">Select Product</label>
                                                        <div class="col">
                                                            <select x-ref="ProductSelect" name="product_id"
                                                                class="form-select" id="ProductSelect"></select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-3 row slider-url d-none">
                                                    <label class="col-3 col-form-label required"
                                                        for="sliderurl_val">Link</label>
                                                    <div class="col">
                                                        <input type="url" class="form-control" name="link"
                                                            id="z" placeholder="https://example.com"
                                                            pattern="https?://.+" disabled />
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="mb-3 row">
                                                <label class="col-3 col-form-label required" for="image">Slider
                                                    Image</label>
                                                <div class="col form-group">
                                                    <a class="uploadFile img text-decoration-none" data-input='image'
                                                        data-isremovable='0' data-is-multiple-uploads-allowed='0'
                                                        data-bs-toggle="modal" data-bs-target="#media-upload-modal"
                                                        value="Upload Photo">
                                                        <input type="file" class="form-control" name="image"
                                                            id="image" />
                                                    </a>

                                                    <label
                                                        class="text-danger mt-3 edit_slider_upload_image_note d-none">
                                                        *Choose a new image only if you want to update
                                                    </label>

                                                    <div class="container-fluid row image-upload-section mt-2">
                                                        <div
                                                            class="col-sm-12 shadow rounded text-center grow image p-2 no-image-container">
                                                            <div>
                                                                <img class="img-fluid mb-2" id="slider_uploaded_image"
                                                                    src="<?= base_url('assets/images/no-image.png') ?>"
                                                                    alt="No Image" style="max-width: 150px;">
                                                                <p class="text-muted small no-image-msg">No image
                                                                    selected</p>

                                                                <input type="hidden" name="uploaded_image"
                                                                    id="uploaded_slider_uploaded_image"
                                                                    class="uploaded_image_here form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <button type="button" class="btn" data-bs-dismiss="offcanvas"
                                            aria-label="Close">Close</button>
                                        <button type="submit" class="btn btn-primary save_slider" id="submit_btn">Add
                                            Slider</button>
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
                                    <form x-data="ajaxForm({
                                            url: base_url + 'admin/category/add_category',
                                            modalId: 'addCategoryModal',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="add_category_form">

                                        <div class="modal-body p-0">

                                            <div class="card-body">

                                                <input type="hidden" name="edit_category" id="edit_category">

                                                <!-- Category Name -->
                                                <div class="mb-3 row">
                                                    <label class="col-3 col-form-label required"
                                                        for="category_input_name">Name</label>
                                                    <div class="col">
                                                        <input type="text" class="form-control"
                                                            name="category_input_name" id="category_input_name"
                                                            placeholder="Category Name" />
                                                    </div>
                                                </div>

                                                <!-- Select Parent -->
                                                <div class="mb-3 row" x-data x-init="initTomSelect({
        element: $refs.CategoryParentSelect,
        url: '/admin/category/get_categories?from_select=1',
        placeholder: 'Select Parent',
        dataAttribute: 'data-category-parent-id',
        maxItems: 5,
        preloadOptions: true
     })">

                                                    <label for="CategoryParentSelect"
                                                        class="col-3 col-form-label required">
                                                        Select Parent
                                                    </label>
                                                    <div class="col">
                                                        <select x-ref="CategoryParentSelect" name="category_parent"
                                                            id="CategoryParentSelect" class="form-control">
                                                        </select>
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
                                                        <label
                                                            class="text-danger mt-3 edit_slider_upload_image_note d-none"
                                                            id="no-image-slider">
                                                            *Only Choose When Update is necessary
                                                        </label>

                                                        <div class="container-fluid row image-upload-section d-none">
                                                            <div
                                                                class="col-sm-12 shadow rounded text-center grow image">
                                                                <div>
                                                                    <img class="img-fluid mb-2"
                                                                        id="slider_uploaded_image"
                                                                        src="<?= base_url() . NO_IMAGE ?>"
                                                                        alt="Image Not Found">
                                                                    <input type="hidden" name="image"
                                                                        id="uploaded_slider_uploaded_image"
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
                                                        for="seo_page_title">SEO Page Title</label>
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
                                                        for="seo_meta_keywords">SEO Meta Keywords</label>
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
                                                        <label
                                                            class="text-danger mt-3 edit_promo_upload_image_note">*Only
                                                            Choose When Update is necessary</label>

                                                        <div class="container-fluid row image-upload-section">
                                                            <div class="col-sm-6 shadow rounded text-center grow image">
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