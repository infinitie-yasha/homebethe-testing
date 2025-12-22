<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">Manage Promo Code</h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="d-flex">
                            <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/home') ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">Manage Promo Code</a>
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
                                    <label class="col-form-label" for="discount_type_filter">Filter By Discount Type</label>
                                    <select class="form-select" name="discount_type_filter" id="discount_type_filter">
                                        <option value="">Select Discount Type</option>
                                        <option value="percentage">Percentage</option>
                                        <option value="amount">Amount</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="status_filter">Filter By Status</label>
                                    <select class="form-select" name="status_filter" id="status_filter">
                                        <option value="">Select Status</option>
                                        <option value="1">Active</option>
                                        <option value="0">Deactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title"><i class="ti ti-language"></i> Manage Promo Codes</h3>
                            <a href="#" class="btn btn-primary addPromocodeBtn btn-sm bg-primary-lt"
                                data-bs-toggle="offcanvas" data-bs-target="#addPromocode">Add Promo Code</a>
                        </div>
                        <div class="card-body">
                            <table class='table-striped' id="promo_code_table" data-toggle="table"
                                data-url="<?= base_url('admin/promo_code/view_promo_code') ?>"
                                data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                                data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                                data-sort-order="desc" data-mobile-responsive="true" data-toolbar=""
                                data-show-export="true" data-maintain-selected="true"
                                data-export-types='["txt","excel"]' data-export-options='{
                            "fileName": "promocode-list",
                            "ignoreColumn": ["state"]
                            }' data-query-params="promo_code_queryParams">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true" data-align='center'
                                            data-visible='false'>ID</th>
                                        <th data-field="promo_code" data-sortable="false" data-align='center'>Promo Code
                                        </th>
                                        <th data-field="image" data-sortable="false" data-align='center'>Image</th>
                                        <th data-field="message" data-sortable="true" data-align='center'>Message</th>
                                        <th data-field="start_date" data-sortable="true" data-align='center'
                                            data-visible='false'>Start Date</th>
                                        <th data-field="end_date" data-sortable="true" data-align='center'
                                            data-visible='false'>End Date</th>
                                        <th data-field="no_of_users" data-sortable="true" data-visible='false'
                                            data-align='center'>No .of users</th>
                                        <th data-field="minimum_order_amount" data-sortable="true" data-visible='false'
                                            data-align='center'>Minimum order amount</th>
                                        <th data-field="discount" data-sortable="true" data-align='center'>Discount</th>
                                        <th data-field="discount_type" data-sortable="false" data-align='center'>
                                            Discount
                                            type</th>
                                        <th data-field="max_discount_amount" data-sortable="true" data-visible='false'
                                            data-align='center'>Max discount amount</th>
                                        <th data-field="repeat_usage" data-sortable="true" data-visible='false'
                                            data-align='center'>Repeat usage</th>
                                        <th data-field="no_of_repeat_usage" data-sortable="true" data-visible='false'
                                            data-align='center'>No of repeat usage</th>
                                        <th data-field="status" data-sortable="false" data-align='center'>Status</th>
                                        <th data-field="is_cashback" data-sortable="true" data-align='center'>Is
                                            Cashback</th>
                                        <th data-field="list_promocode" data-sortable="true" data-align='center'
                                            data-visible='false'>View Promocode</th>
                                        <th data-field="is_cashback_value" data-sortable="false" data-align='center'
                                            data-visible='false'>cash back value</th>
                                        <th data-field="operate" data-sortable="false" data-align='center'>Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="offcanvas offcanvas-end offcanvas-medium" tabindex="-1" id="addPromocode"
                            aria-labelledby="addPromocodeLabel">
                            <div class="offcanvas-header">
                                <h2 class="offcanvas-title" id="addPromocodeLabel">Add Promo Code</h2>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <form x-data="ajaxForm({
                                            url: base_url + 'admin/promo_code/add_promo_code',
                                            offcanvasId: 'addPromocode',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="add_zipcode_form">
                                <div class="offcanvas-body">
                                    <div>
                                        <input type="hidden" name="edit_promo_code" id="edit_promo_code" value="">

                                        <div class="mb-3 row">
                                            <label class="col-12 col-sm-3 col-form-label required"
                                                for="promo_code">Promo
                                                Code</label>
                                            <div class="col">
                                                <input type="text" class="form-control" name="promo_code"
                                                    id="promo_code" placeholder="Promo code title" />
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-12 col-sm-3 col-form-label required"
                                                for="message">Message</label>
                                            <div class="col">
                                                <input type="text" class="form-control" name="message" id="message"
                                                    placeholder="Promo code message" />
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-12 col-sm-3 col-form-label required"
                                                for="start_date">Start
                                                Date</label>
                                            <div class="col">
                                                <input type="date" class="form-control" name="start_date"
                                                    id="start_date" min="<?= date('Y-m-d') ?>" />
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-12 col-sm-3 col-form-label required" for="end_date">End
                                                Date</label>
                                            <div class="col">
                                                <input type="date" class="form-control" name="end_date" id="end_date"
                                                    min="<?= date('Y-m-d') ?>" />
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-12 col-sm-3 col-form-label required" for="no_of_users">No.
                                                of Users</label>
                                            <div class="col">
                                                <input type="number" min="0" class="form-control" name="no_of_users"
                                                    id="no_of_users" />
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-12 col-sm-3 col-form-label required"
                                                for="minimum_order_amount">Minimum Order Amount</label>
                                            <div class="col">
                                                <input type="number" min="1" class="form-control"
                                                    name="minimum_order_amount" id="minimum_order_amount" />
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-12 col-sm-3 col-form-label required"
                                                for="discount">Discount</label>
                                            <div class="col">
                                                <input type="number" min="1" class="form-control discount"
                                                    name="discount" id="discount" />
                                                <div class="error"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-12 col-sm-3 col-form-label required"
                                                for="discount_type">Discount
                                                Type</label>
                                            <div class="col">
                                                <select name="discount_type" id="discount_type_select"
                                                    class="form-control discount_type">
                                                    <option value="">Select</option>
                                                    <option value="percentage">Percentage</option>
                                                    <option value="amount">Amount</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3 row <?= (isset($fetched_details[0]['discount_type']) && $fetched_details[0]['discount_type'] == 'percentage') ? '' : 'd-none' ?>"
                                            id="max_discount_amount_html">
                                            <label class="col-12 col-sm-3 col-form-label required"
                                                for="max_discount_amount">Max
                                                Discount Amount</label>
                                            <div class="col">
                                                <input type="number" min="1" class="form-control"
                                                    name="max_discount_amount" id="max_discount_amount" />
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-12 col-sm-3 col-form-label required"
                                                for="repeat_usage">Repeat
                                                Usage</label>
                                            <div class="col">
                                                <select name="repeat_usage" id="repeat_usage" class="form-control">
                                                    <option value="">Select</option>
                                                    <option value="1">Allowed</option>
                                                    <option value="0">Not Allowed</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3 row d-none" id="repeat_usage_html">
                                            <label class="col-12 col-sm-3 col-form-label required"
                                                for="no_of_repeat_usage">No of
                                                Repeat Usage</label>
                                            <div class="col">
                                                <input type="number" class="form-control" min='0'
                                                    name="no_of_repeat_usage" id="no_of_repeat_usage" />
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-12 col-sm-3 col-form-label required" for="image">Main
                                                Image</label>
                                            <div class="col form-group">
                                                <a class="uploadFile img text-decoration-none" data-input='image'
                                                    data-isremovable='0' data-is-multiple-uploads-allowed='0'
                                                    data-bs-toggle="modal" data-bs-target="#media-upload-modal"
                                                    value="Upload Photo">
                                                    <input type="file" class="form-control" name="image" id="image" />
                                                </a>
                                                <label class="text-danger mt-3 edit_promo_upload_image_note">*Only
                                                    Choose When Update is necessary</label>

                                                <div class="container-fluid row image-upload-section">
                                                    <div
                                                        class="col-sm-6 shadow rounded text-center grow image">
                                                        <div class=''>
                                                            <img class="img-fluid mb-2" id="slider_uploaded_image"
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
                                        <div class="mb-3 row">
                                            <label class="col-12 col-sm-3 col-form-label required"
                                                for="status">Status</label>
                                            <div class="col">
                                                <select name="status" id="status" class="form-control">
                                                    <option value="">Select</option>
                                                    <option value="1">Active</option>
                                                    <option value="0">Deactive</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-12 col-sm-3 col-form-label" for="is_cashback">Is
                                                Cashback?</label>
                                            <div class="col col-form-label">
                                                <label class="form-check form-switch form-switch-3">
                                                    <input class="form-check-input" name="is_cashback" id="is_cashback"
                                                        type="checkbox" />
                                                </label>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-12 col-sm-3 col-form-label" for="list_promocode">List
                                                Promocode?</label>
                                            <div class="col col-form-label">
                                                <label class="form-check form-switch form-switch-3">
                                                    <input class="form-check-input" name="list_promocode"
                                                        id="list_promocode" type="checkbox" />
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="text-end">
                                        <!-- <button type="reset" class="btn btn-warning ">Reset</button> -->
                                        <button type="button" class="btn" data-bs-dismiss="offcanvas"
                                            aria-label="Close">Close</button>
                                        <button type="submit" class="btn btn-primary save_promocode" id="submit_btn">Add
                                            Promo Code</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- View Promo Code Offcanvas -->
                        <div class="offcanvas offcanvas-end offcanvas-medium" tabindex="-1" id="viewPromocode"
                            aria-labelledby="viewPromocodeLabel">
                            <div class="offcanvas-header">
                                <h2 class="offcanvas-title" id="viewPromocodeLabel">Promo Code Details</h2>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3 row">
                                            <label class="col-4 col-form-label fw-bold">Promo Code:</label>
                                            <div class="col-8">
                                                <p class="form-control-plaintext" id="view_promo_code"></p>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-4 col-form-label fw-bold">Image:</label>
                                            <div class="col-8">
                                                <img src="" id="view_image" class="rounded img-fluid promo-view-image"
                                                    alt="Promo Code Image">
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-4 col-form-label fw-bold">Message:</label>
                                            <div class="col-8">
                                                <p class="form-control-plaintext" id="view_message"></p>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-4 col-form-label fw-bold">Start Date:</label>
                                            <div class="col-8">
                                                <p class="form-control-plaintext" id="view_start_date"></p>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-4 col-form-label fw-bold">End Date:</label>
                                            <div class="col-8">
                                                <p class="form-control-plaintext" id="view_end_date"></p>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-4 col-form-label fw-bold">No. of Users:</label>
                                            <div class="col-8">
                                                <p class="form-control-plaintext" id="view_no_of_users"></p>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-4 col-form-label fw-bold">Minimum Order Amount:</label>
                                            <div class="col-8">
                                                <p class="form-control-plaintext" id="view_minimum_order_amount"></p>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-4 col-form-label fw-bold">Discount:</label>
                                            <div class="col-8">
                                                <p class="form-control-plaintext" id="view_discount"></p>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-4 col-form-label fw-bold">Discount Type:</label>
                                            <div class="col-8">
                                                <p class="form-control-plaintext" id="view_discount_type"></p>
                                            </div>
                                        </div>

                                        <div class="mb-3 row" id="view_max_discount_row">
                                            <label class="col-4 col-form-label fw-bold">Max Discount Amount:</label>
                                            <div class="col-8">
                                                <p class="form-control-plaintext" id="view_max_discount_amount"></p>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-4 col-form-label fw-bold">Repeat Usage:</label>
                                            <div class="col-8">
                                                <p class="form-control-plaintext" id="view_repeat_usage"></p>
                                            </div>
                                        </div>

                                        <div class="mb-3 row" id="view_repeat_usage_row">
                                            <label class="col-4 col-form-label fw-bold">No. of Repeat Usage:</label>
                                            <div class="col-8">
                                                <p class="form-control-plaintext" id="view_no_of_repeat_usage"></p>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-4 col-form-label fw-bold">Status:</label>
                                            <div class="col-8">
                                                <p class="form-control-plaintext" id="view_status"></p>
                                            </div>
                                        </div>

                                        <div class="row mb-3 align-items-center">

                                            <!-- Is Cashback -->
                                            <div class="col-12 col-md-6 d-flex">
                                                <label class="col-form-label fw-bold me-2 w-50">Is Cashback:</label>
                                                <p class="form-control-plaintext mb-0 w-50" id="view_is_cashback"></p>
                                            </div>

                                            <!-- List Promocode -->
                                            <div class="col-12 col-md-6 d-flex mt-2 mt-md-0">
                                                <label class="col-form-label fw-bold me-2 w-50">List Promocode:</label>
                                                <p class="form-control-plaintext mb-0 w-50" id="view_list_promocode">
                                                </p>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="button" class="btn" data-bs-dismiss="offcanvas"
                                        aria-label="Close">Close</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>