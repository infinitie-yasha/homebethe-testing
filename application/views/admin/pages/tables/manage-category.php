<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">Manage Category</h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="d-flex">
                            <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/home') ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">Category</a>
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
                    <div class="card">
                        <div
                            class="card-header d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
                            <h3 class="card-title mb-0">
                                <i class="ti ti-language"></i> Manage Category
                            </h3>
                            <div class="d-flex flex-wrap justify-content-start justify-content-sm-end gap-2">
                                <button type="button" class="btn btn-primary btn-sm" id="list_view">
                                    <i class="ti ti-list"></i> List View
                                </button>
                                <button type="button" class="btn btn-primary btn-sm bg-primary-lt" id="tree_view">
                                    <i class="ti ti-list-tree"></i> Tree View
                                </button>
                                <a href="#" class="btn btn-primary addCategoryBtn btn-sm bg-primary-lt"
                                    data-bs-toggle="offcanvas" data-bs-target="#addCategory">
                                    Add Category
                                </a>
                            </div>
                        </div>

                        <div class="card-body" id="list_view_html">
                            <div id="filterTemplate" class="d-flex gap-3 justify-content-start flex-wrap mb-3">
                                <div class="mb-3">
                                    <label class="col-form-label" for="category_status_filter">Status</label>
                                    <select class="form-select" name="status" id="category_status_filter">
                                        <option value=''>Select Status</option>
                                        <option value='1'>Active</option>
                                        <option value='0'>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <table class='table-striped' id='category_table' data-toggle="table"
                                data-url="<?= base_url('admin/category/category_list') ?>" data-click-to-select="true"
                                data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                                data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                                data-sort-order="desc" data-mobile-responsive="true" data-toolbar=""
                                data-show-export="true" data-maintain-selected="true"
                                data-export-types='["txt","excel","csv"]' data-export-options='{
                                "fileName": "category-list",
                                "ignoreColumn": ["state"]
                                }' data-query-params="category_query_params">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true" data-visible='false'>ID</th>
                                        <th data-field="name" data-sortable="false" data-align='center'>Name</th>
                                        <th data-field="image" data-sortable="true" data-align='center'>Image</th>
                                        <th data-field="status" data-sortable="true" data-align='center'>Status</th>
                                        <th data-field="operate" data-sortable="false" data-align='center'>Action</th>
                                    </tr>
                                </thead>
                            </table>


                        </div>
                        <div class="card-body">
                            <div id="tree_view_html">
                            </div>
                        </div>

                        <div class="offcanvas offcanvas-end offcanvas-medium" tabindex="-1" id="addCategory"
                            aria-labelledby="addCategoryLabel">
                            <div class="offcanvas-header">
                                <h2 class="offcanvas-title" id="addCategoryLabel">Add Category</h2>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <form x-data="ajaxForm({
                                            url: base_url + 'admin/category/add_category',
                                            offcanvasId: 'addCategory',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="add_category_form">
                                <div class="offcanvas-body">
                                    <div>

                                        <input type="hidden" name="edit_category" id="edit_category">

                                        <div class="mb-3 row">
                                            <label class="col-3 col-form-label required"
                                                for="category_input_name">Name</label>
                                            <div class="col">
                                                <input type="text" class="form-control" name="category_input_name"
                                                    id="category_input_name" placeholder="Category Name" />
                                            </div>
                                        </div>

                                        <div x-data x-init="initTomSelect({
                                                    element: $refs.categorySelect,
                                                    url: '/admin/category/get_categories?from_select=1',
                                                    placeholder: 'Select Parent',
                                                    offcanvasId: 'addCategory',
                                                    dataAttribute: 'data-category-parent-id',
                                                    dataAttribute: 'commission-perc',
                                                    maxItems: 1,
                                                    preloadOptions: true
                                                })" class="mb-3 row">

                                            <label class="col-3 col-form-label" for="categorySelect">Category
                                                Parent</label>
                                            <div class="col">
                                                <select x-ref="categorySelect" name="category_parent"
                                                    class="form-select" id="categorySelect"></select>
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
                                                    <label class="text-danger mt-3 edit_promo_upload_image_note">*Only
                                                        Choose When Update is necessary</label>
                                                    <div class="col-sm-6 shadow rounded text-center grow image">
                                                        <div class=''>
                                                            <img class="img-fluid mb-2" id="category_input_image_img"
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
                                        <div class="mb-3 row">
                                            <label class="col-3 col-form-label required" for="commission_perc">Commission
                                                percantage</label>
                                            <div class="col">
                                                <input type="number" name="commission_perc"
                                                    class="form-control form-input" placeholder="Commission Percantage"
                                                    step="0.1" id="commission_perc">
                                            </div>
                                        </div>

                                        <hr>
                                        <h4 class=" m-0 px-2 py-3">SEO Configuration</h4>
                                        <hr>

                                        <div class="mb-3 row">
                                            <label class="col-3 col-form-label" for="seo_page_title">SEO Page
                                                Title</label>
                                            <div class="col">
                                                <input type="text" class="form-control" name="seo_page_title"
                                                    id="seo_page_title" placeholder="SEO Page title" />
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-3 col-form-label" for="seo_meta_description">SEO
                                                Meta Description</label>
                                            <div class="col">
                                                <textarea name="seo_meta_description" id="seo_meta_description"
                                                    class="textarea form-control" placeholder="SEO Meta Description"
                                                    data-bs-toggle="autosize"> </textarea>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-3 col-form-label" for="seo_meta_keywords">SEO
                                                Meta Keywords</label>
                                            <div class="col">
                                                <input type="text tags" class="form-control" name="seo_meta_keywords"
                                                    id="seo_meta_keywords" placeholder="SEO Meta Keywords" />
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-3 col-form-label" for="image">SEO Open
                                                Graph Image </label>
                                            <div class="col form-group">
                                                <a class="uploadFile img text-decoration-none" data-input='seo_og_image'
                                                    data-isremovable='1' data-is-multiple-uploads-allowed='0'
                                                    data-bs-toggle="modal" data-bs-target="#media-upload-modal"
                                                    value="Upload Photo">
                                                    <input type="file" class="form-control" name="seo_og_image"
                                                        id="seo_og_image" />
                                                </a>

                                                <div class="container-fluid row image-upload-section">
                                                    <label class="text-danger mt-3 edit_promo_upload_image_note">*Only
                                                        Choose When Update is necessary</label>
                                                    <div class="col-sm-6 shadow rounded text-center grow image">
                                                        <div class=''>
                                                            <img class="img-fluid mb-2" id="uploaded_og_image_here"
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
                                    <div class="text-end">
                                        <!-- <button type="reset" class="btn btn-warning ">Reset</button> -->
                                        <button type="submit" class="btn btn-primary save_category_btn"
                                            id="submit_btn">Add Category</button>
                                        <button type="button" class="btn" data-bs-dismiss="offcanvas">Close</button>
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