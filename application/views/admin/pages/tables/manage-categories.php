<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">

                <!-- Mobile View (xs / sm) -->
                <div class="d-flex flex-column text-center d-sm-none py-2">
                    <h2 class="page-title fs-5 fw-semibold mb-1">Manage Category</h2>
                    <nav class="breadcrumb breadcrumb-arrows small justify-content-start mb-0">
                        <a href="<?= base_url('admin/home') ?>" class="breadcrumb-item">Home</a>
                        <span class="breadcrumb-item">Blogs</span>
                        <span class="breadcrumb-item active">Category</span>
                    </nav>
                </div>

                <!-- Tablet & Desktop View (sm+) -->
                <div class="row g-2 align-items-center d-none d-sm-flex">
                    <div class="col">
                        <h2 class="page-title mb-0">Manage Category</h2>
                    </div>
                    <div class="col-auto ms-auto">
                        <ol class="breadcrumb breadcrumb-arrows mb-0 small">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('admin/home') ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('admin/blogs') ?>">Blogs</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Blog Category
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
                            <h3 class="card-title"><i class="ti ti-language"></i> Manage Blog Category</h3>
                            <a href="#" class="btn btn-primary addBlogCategoryBtn btn-sm bg-primary-lt"
                                data-bs-toggle="offcanvas" data-bs-target="#addBlogCategory">Add Blog Category</a>
                        </div>
                        <div class="card-body">
                            <table class='table-striped' id='blog_category_table' data-toggle="table"
                                data-url="<?= base_url('admin/blogs/view_categories') ?>" data-click-to-select="true"
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
                                        <th data-field="image" data-sortable="false" data-align='center'>Image</th>
                                        <th data-field="status" data-sortable="false" data-align='center'>Status</th>
                                        <th data-field="operate" data-sortable="false" data-align='center'>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="offcanvas offcanvas-end offcanvas-medium" tabindex="-1" id="addBlogCategory"
                            aria-labelledby="addBlogCategoryLabel">
                            <div class="offcanvas-header">
                                <h2 class="offcanvas-title" id="addBlogCategoryLabel">Add Blog Category</h2>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <form x-data="ajaxForm({
                                            url: base_url + 'admin/blogs/add_category',
                                            offcanvasId: 'addBlogCategory',
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
                                                    <div
                                                        class="col-sm-6 shadow rounded text-center grow image">
                                                        <div class=''>
                                                            <img id="slider_uploaded_image"
                                                                src="<?= base_url() . NO_IMAGE ?>" alt="Image Not Found"
                                                                class="img-thumbnail object-fit-contain bg-light p-2"
                                                                style="width: 120px; height: 120px;"
                                                                alt="Image Not Found">
                                                            <input type="hidden" name="category_input_image"
                                                                id="category_input_image"
                                                                class="uploaded_image_here form-control form-input">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="text-end">
                                        <!-- <button type="reset" class="btn btn-warning ">Reset</button> -->
                                        <button type="button" class="btn" data-bs-dismiss="offcanvas"
                                            aria-label="Close">Close</button>
                                        <button type="submit" class="btn btn-primary save_blog_category"
                                            id="submit_btn">Add Blog Category</button>
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