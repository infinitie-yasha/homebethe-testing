<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">Manage Brand</h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="d-flex">
                            <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/home') ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">Brands</a>
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
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title"><i class="ti ti-language"></i> Brand</h3>
                            <a href="#" class="btn btn-primary addBrandBtn btn-sm bg-primary-lt"
                                data-bs-toggle="offcanvas" data-bs-target="#addBrands">Add Brand</a>
                        </div>

                        <div class="card-body">
                            <table class='table-striped' id="brand_table" data-toggle="table"
                                data-url="<?= base_url('admin/brand/brand_list') ?>" data-click-to-select="true"
                                data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                                data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                                data-sort-order="desc" data-mobile-responsive="true" data-toolbar=""
                                data-show-export="true" data-maintain-selected="true"
                                data-export-types='["txt","excel"]' data-export-options='{
                                "fileName": "brand-list",
                                "ignoreColumn": ["state"]
                                }' data-query-params="brand_query_params">
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

                        <div class="offcanvas offcanvas-end offcanvas-medium" tabindex="-1" id="addBrands"
                            aria-labelledby="addBrandsLabel">
                            <div class="offcanvas-header">
                                <h2 class="offcanvas-title" id="addBrandsLabel">Add Brand</h2>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <form x-data="ajaxForm({
                                            url: base_url + 'admin/brand/add_brand',
                                            offcanvasId: 'addBrands',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="add_brand_form">
                                <div class="offcanvas-body">
                                    <div>
                                        <input type="hidden" name="edit_brand" id="edit_brand" value="">

                                        <div class="mb-3 row">
                                            <label class="col-3 col-form-label required"
                                                for="brand_input_name">Name</label>
                                            <div class="col">
                                                <input type="text" class="form-control" name="brand_input_name"
                                                    id="brand_input_name" placeholder="Add Brand Name" />
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-3 col-form-label required" for="image">Main Image</label>
                                            <div class="col form-group">
                                                <a class="uploadFile img text-decoration-none"
                                                    data-input='brand_input_image' data-isremovable='0'
                                                    data-is-multiple-uploads-allowed='0' data-bs-toggle="modal"
                                                    data-bs-target="#media-upload-modal" value="Upload Photo">
                                                    <input type="file" class="form-control" name="image"
                                                        id="brand_input_image" />
                                                </a>

                                                <div class="container-fluid row image-upload-section">
                                                    <label class="text-danger mt-3 edit_promo_upload_image_note">*Only
                                                        Choose When Update is necessary</label>
                                                    <div
                                                        class="col-sm-6 shadow rounded text-center grow image">
                                                        <div class=''>
                                                            <img class="img-fluid mb-2" id="brand_uploaded_image"
                                                                src="<?= base_url() . NO_IMAGE ?>"
                                                                alt="Image Not Found">
                                                            <input type="hidden" name="brand_input_image"
                                                                id="uploaded_brand_uploaded_image"
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
                                        <button type="submit" class="btn btn-primary save_brand_btn"
                                            id="submit_btn">Update Brand</button>
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