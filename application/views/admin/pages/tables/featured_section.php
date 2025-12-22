<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-fluid">
                <div class="row g-2 align-items-center">
                    <!-- Title -->
                    <div class="col-12 col-md">
                        <h2 class="page-title mb-0">Manage Featured Section (Show Products Exclusively)</h2>
                    </div>

                    <!-- Breadcrumbs -->
                    <div class="col-12 col-md-auto mt-2 mt-md-0">
                        <ol class="breadcrumb breadcrumb-arrows mb-0" aria-label="breadcrumbs">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('admin/home') ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                <a href="javascript:void(0);">Featured Section</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="#">Manage Featured Section</a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- END PAGE HEADER -->

        <div class="page-body">
            <div class="container-xl">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title"><i class="ti ti-star"></i> Featured Section</h3>
                            <a href="#" class="btn btn-primary addFeatureSectionBtn btn-sm bg-primary-lt"
                                data-bs-toggle="offcanvas" data-bs-target="#addFeatureSection">Add Feature
                                Section</a>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="product_type_filter" class="form-label">Filter by Product Type</label>
                                    <select class="form-select" id="product_type_filter">
                                        <option value="">All Product Types</option>
                                        <option value="new_added_products">New Added Products</option>
                                        <option value="products_on_sale">Products On Sale</option>
                                        <option value="top_rated_products">Top Rated Products</option>
                                        <option value="most_selling_products">Most Selling Products</option>
                                        <option value="custom_products">Custom Products</option>
                                        <option value="digital_product">Digital Product</option>
                                    </select>
                                </div>
                            </div>
                            <table class='table-striped' id="feature_section_table" data-toggle="table"
                                data-url="<?= base_url('admin/Featured_sections/get_section_list') ?>"
                                data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                                data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                                data-sort-order="desc" data-mobile-responsive="true" data-toolbar=""
                                data-show-export="true" data-maintain-selected="true"
                                data-export-types='["txt","excel"]' data-export-options='{
                            "fileName": "feature-section-list",
                            "ignoreColumn": ["state"]
                            }' data-query-params="featured_section_query_params">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true">ID</th>
                                        <th data-field="title" class="col-md-3" data-sortable="true">Title</th>
                                        <th data-field="short_description" class="col-md-2" data-sortable="false">Short
                                            description</th>
                                        <th data-field="style" data-sortable="false">Style</th>
                                        <th data-field="categories" data-sortable="true">Categories</th>
                                        <th data-field="product_ids" data-sortable="true" data-visible="false">Product
                                            Names</th>
                                        <th data-field="product_type" data-sortable="true">Product Type</th>
                                        <th data-field="date" data-sortable="false" data-visible="false">Date</th>
                                        <th data-field="operate" data-sortable="false">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="offcanvas offcanvas-end offcanvas-medium" tabindex="-1" id="addFeatureSection"
                            aria-labelledby="addFeatureSectionLabel">
                            <div class="offcanvas-header">
                                <h2 class="offcanvas-title" id="addFeatureSectionLabel">Add Feature Section</h2>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <form x-data="ajaxForm({
                                            url: base_url + 'admin/Featured_sections/add_featured_section',
                                            offcanvasId: 'addFeatureSection',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="add_feature_section_form">
                                <div class="offcanvas-body">
                                    <div>
                                        <input type="hidden" id="edit_featured_section" name="edit_featured_section"
                                            value="">
                                        <input type="hidden" id="update_id" name="update_id" value="1">

                                        <div class="mb-3 row">
                                            <label class="col-12 col-sm-3 col-form-label required" for="title">Title for
                                                section </label>
                                            <div class="col">
                                                <input type="text" class="form-control" name="title" id="title"
                                                    placeholder="Title" />
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-12 col-sm-3 col-form-label required"
                                                for="short_description">Short
                                                description </label>
                                            <div class="col">
                                                <input type="text" class="form-control" name="short_description"
                                                    id="short_description" placeholder="Short description" />
                                            </div>
                                        </div>
                                        <div class="mb-3 row select-categories">
                                            <div x-data x-init="initTomSelect({
                                                    element: $refs.CategorySelect,
                                                    url: '/admin/category/get_categories?from_select=1',
                                                    placeholder: 'Search Category...',
                                                    offcanvasId: 'addFeatureSection',
                                                    dataAttribute: 'data-category-id',
                                                    maxItems: 40,
                                                    preloadOptions: true
                                                })" class="mb-3 row">

                                                <label class="col-12 col-sm-3 col-form-label required"
                                                    for="CategorySelect">Select
                                                    Categories</label>
                                                <div class="col">
                                                    <select x-ref="CategorySelect" name="categories[]"
                                                        class="form-select" id="CategorySelect"></select>
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                        $style = ['default', 'style_1', 'style_2', 'style_3', 'style_4'];
                                        ?>
                                        <div class="mb-3 row">
                                            <label class="col-12 col-sm-3 col-form-label required"
                                                for="style">Style</label>
                                            <div class="col">
                                                <select name="style" id="style" class="form-control style">
                                                    <option value=" ">Select Style</option>
                                                    <?php foreach ($style as $row) { ?>
                                                        <option value="<?= $row ?>" <?= (isset($fetched_data[0]['style']) && $fetched_data[0]['style'] == $row) ? 'Selected' : '' ?>>
                                                            <?= ucwords(str_replace('_', ' ', $row)) ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <?php
                                        $product_type = ['new_added_products', 'products_on_sale', 'top_rated_products', 'most_selling_products', 'custom_products', 'digital_product'];
                                        ?>
                                        <div class="mb-3 row">
                                            <label class="col-12 col-sm-3 col-form-label required"
                                                for="product_type">Product
                                                Types</label>
                                            <div class="col">
                                                <select name="product_type" id="product_type"
                                                    class="form-control product_type">
                                                    <option value=" ">Select Types</option>
                                                    <?php foreach ($product_type as $row) { ?>
                                                        <option value="<?= $row ?>" <?= (isset($fetched_data[0]['id']) && $fetched_data[0]['product_type'] == $row) ? "Selected" : "" ?>>
                                                            <?= ucwords(str_replace('_', ' ', $row)) ?>
                                                        </option>
                                                        <?php
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- For custom products -->

                                        <div class="mb-3 row custom_products d-none ">
                                            <div x-data x-init="initTomSelect({
                                                    element: $refs.ProductSelect,
                                                    url: '/admin/product/get_product_data?from_select=1',
                                                    placeholder: 'Search Products...',
                                                    offcanvasId: 'addFeatureSection',
                                                    dataAttribute: 'data-product-ids',
                                                    maxItems: 40,
                                                    preloadOptions: true
                                                })" class="mb-3 row">

                                                <label class="col-12 col-sm-3 col-form-label required"
                                                    for="ProductSelect">Select
                                                    Products</label>
                                                <div class="col">
                                                    <select x-ref="ProductSelect" name="product_ids[]"
                                                        class="form-select" id="ProductSelect"></select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- For digital products -->
                                        <div class="mb-3 row digital_products d-none ">
                                            <div x-data x-init="initTomSelect({
                                                    element: $refs.ProductSelect,
                                                    url: '/admin/product/get_digital_product_data?from_select=1',
                                                    placeholder: 'Search Digital Products...',
                                                    offcanvasId: 'addFeatureSection',
                                                    dataAttribute: 'data-type-id',
                                                    maxItems: 40,
                                                    preloadOptions: true
                                                })" class="mb-3 row">

                                                <label class="col-12 col-sm-3 col-form-label required"
                                                    for="ProductSelect">Select
                                                    Products</label>
                                                <div class="col">
                                                    <select x-ref="ProductSelect" name="product_ids[]"
                                                        class="form-select" id="ProductSelect"></select>
                                                </div>
                                            </div>
                                        </div>

                                        <hr class="mt-4">
                                        <h4 class="m-0 px-2 py-3">SEO Configuration</h4>

                                        <div class="mb-3 row">
                                            <label class="col-12 col-sm-3 col-form-label" for="seo_page_title">SEO Page
                                                Title</label>
                                            <div class="col">
                                                <input type="text" class="form-control" name="seo_page_title"
                                                    id="seo_page_title" placeholder="SEO Page title" />
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-12 col-sm-3 col-form-label" for="seo_meta_description">SEO
                                                Meta Description</label>
                                            <div class="col">
                                                <textarea name="seo_meta_description" class="textarea form-control"
                                                    placeholder="SEO Meta Description"
                                                    data-bs-toggle="autosize"> </textarea>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-12 col-sm-3 col-form-label" for="seo_meta_keywords">SEO
                                                Meta Keywords</label>
                                            <div class="col">
                                                <input type="text tags" class="form-control" name="seo_meta_keywords"
                                                    id="seo_meta_keywords" placeholder="SEO Meta Keywords" />
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-12 col-sm-3 col-form-label" for="image">SEO Open
                                                Graph Image </label>
                                            <div class="col form-group">
                                                <a class="uploadFile img text-decoration-none" data-input='seo_og_image'
                                                    data-is-multiple-uploads-allowed='0' data-bs-toggle="modal"
                                                    data-bs-target="#media-upload-modal" value="Upload Photo">
                                                    <input type="file" class="form-control" name="seo_og_image_file"
                                                        id="seo_og_image_file" />
                                                </a>

                                                <div class="container-fluid row image-upload-section">
                                                    <label class="text-danger mt-3 edit_promo_upload_image_note">*Only
                                                        Choose When Update is necessary</label>
                                                    <div
                                                        class="col-sm-6 shadow rounded text-center grow image">
                                                        <div class=''>
                                                            <img class="img-fluid mb-2" id="uploaded_og_image_here"
                                                                src="<?= base_url() . NO_IMAGE ?>"
                                                                alt="Image Not Found">
                                                            <input type="hidden" name="seo_og_image" id="seo_og_image"
                                                                class="uploaded_image_here form-control form-input">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="text-end">
                                        <button type="button" class="btn" data-bs-dismiss="offcanvas"
                                            aria-label="Close">Close</button>
                                        <button type="submit" class="btn btn-primary save_feature_section"
                                            id="submit_btn">Add Feature Section</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>