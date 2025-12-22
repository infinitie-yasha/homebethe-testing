<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">

                <!-- Mobile View -->
                <div class="d-flex flex-column text-center d-sm-none py-2">
                    <h2 class="page-title fs-5 fw-semibold mb-1">Manage Return Reasons</h2>
                    <nav class="breadcrumb breadcrumb-arrows small justify-content-start mb-0">
                        <a href="<?= base_url('admin/home') ?>" class="breadcrumb-item">Home</a>
                        <span class="breadcrumb-item">Return Request</span>
                        <span class="breadcrumb-item active">Return Reasons</span>
                    </nav>
                </div>

                <!-- Tablet & Desktop View -->
                <div class="row g-2 align-items-center d-none d-sm-flex">
                    <div class="col">
                        <h2 class="page-title mb-0">Manage Return Reasons</h2>
                    </div>
                    <div class="col-auto ms-auto">
                        <ol class="breadcrumb breadcrumb-arrows mb-0 small">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('admin/home') ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0)">Return Request</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Return Reasons
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
                            <h3 class="card-title"><i class="ti ti-rotate-clockwise-2"></i> Manage Return Reasons</h3>
                            <a class="btn btn-primary AddReturnReasonBtn btn-sm bg-primary-lt"
                                data-bs-toggle="offcanvas" data-bs-target="#addReturnReason" href="#" role="button"
                                aria-controls="addReturnReason"> Add
                                Return Reason </a>
                        </div>
                        <div class="card-body">
                            <table class='table-striped' id="return_reason_table" data-toggle="table"
                                data-url="<?= base_url('admin/return_reasons/view_return_reason') ?>"
                                data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                                data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                                data-sort-order="desc" data-mobile-responsive="true" data-toolbar=""
                                data-show-export="true" data-maintain-selected="true"
                                data-export-types='["txt","excel"]' data-export-options='{
                            "fileName": "return-reason-list",
                            "ignoreColumn": ["state"]
                            }' data-query-params="queryParams">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true" data-align='center'>ID</th>
                                        <th data-field="return_reason" data-sortable="false" data-align='center'>Return
                                            Reason</th>
                                        <th data-field="image" data-sortable="false" data-align='center'>Image</th>
                                        <th data-field="operate" data-sortable="false" data-align='center'>Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="offcanvas offcanvas-end offcanvas-medium" tabindex="-1" id="addReturnReason"
                            aria-labelledby="addReturnReasonLabel">
                            <div class="offcanvas-header">
                                <h2 class="offcanvas-title" id="addReturnReasonLabel">Add Return Reason</h2>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>

                            <form x-data="ajaxForm({
                                            url: base_url + 'admin/return_reasons/add_return_reasons',
                                            offcanvasId: 'addReturnReason',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="add_return_reason_form">

                                <div class="offcanvas-body">
                                    <div>
                                        <input type="hidden" name="edit_return_reason_id" id="edit_return_reason_id"
                                            value="">
                                        <div class="mb-3 row">
                                            <label class="col-3 col-form-label required"
                                                for="return_reason">Title</label>
                                            <div class="col">
                                                <input type="text" class="form-control" name="return_reason"
                                                    id="return_reason" placeholder="Return Reason title" />
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-3 col-form-label required" for="image">Main Image</label>
                                            <div class="col form-group">
                                                <a class="uploadFile img text-decoration-none" data-input='image'
                                                    data-isremovable='0' data-is-multiple-uploads-allowed='0'
                                                    data-bs-toggle="modal" data-bs-target="#media-upload-modal"
                                                    value="Upload Photo">
                                                    <input type="file" class="form-control" name="image" id="image" />
                                                </a>

                                                <div class="container-fluid row image-upload-section">
                                                    <label class="text-danger mt-3 edit_promo_upload_image_note">*Only
                                                        Choose When Update is necessary</label>
                                                    <div
                                                        class="col-sm-6 shadow rounded text-center grow image">
                                                        <div class=''>
                                                            <img class="img-fluid mb-2" id="uploaded_image_here"
                                                                src="<?= base_url() . NO_IMAGE ?>"
                                                                alt="Image Not Found">
                                                            <input type="hidden" name="image"
                                                                id="uploaded_image_here_val"
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
                                        <button type="submit" class="btn btn-primary save_return_reason"
                                            id="submit_btn">Add Return Reason</button>
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