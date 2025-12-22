<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">

                <!-- Mobile View -->
                <div class="d-flex flex-column text-center d-sm-none py-2">
                    <h2 class="page-title fs-5 fw-semibold mb-1">Payment Request</h2>
                    <nav class="breadcrumb breadcrumb-arrows small justify-content-start mb-0">
                        <a href="<?= base_url('admin/home') ?>" class="breadcrumb-item">Home</a>
                        <span class="breadcrumb-item active">Payment</span>
                    </nav>
                </div>

                <!-- Tablet & Desktop View -->
                <div class="row g-2 align-items-center d-none d-sm-flex">
                    <div class="col">
                        <h2 class="page-title mb-0">Payment Request</h2>
                    </div>
                    <div class="col-auto ms-auto">
                        <ol class="breadcrumb breadcrumb-arrows mb-0 small">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('admin/home') ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Payment Request
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

                    <!-- Filters Section -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Filters & Search</h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="col-form-label" for="user_filter">Filter By User</label>
                                    <select class="form-select" name="user_filter" id="user_filter">
                                        <option value="">Select User Type</option>
                                        <option value="customer">Customer</option>
                                        <option value="seller">Seller</option>
                                        <option value="delivery_boy">Delivery Boy</option>
                                        <option value="affiliate">Affiliate User</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="status_filter">Filter By Status</label>
                                    <select class="form-select" name="status_filter" id="status_filter">
                                        <option value="">Select Status</option>
                                        <option value="0">Pending</option>
                                        <option value="1">Approved</option>
                                        <option value="2">Rejected</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title"><i class="ti ti-cash-banknote"></i> Manage Payment Request</h3>
                        </div>
                        <div class="card-body">
                            <div id="toolbar">
                                <button class="btn btn-secondary" data-toggle="tooltip" data-placement="top"
                                    title="Refresh">
                                    <i class="ti ti-refresh"></i>
                                </button>
                            </div>
                            <table class='table-striped' id="payment_request_table"
                                data-url="<?= base_url('admin/payment-request/view-payment-request-list') ?>"
                                data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                                data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                                data-sort-order="desc" data-mobile-responsive="true" data-toolbar="#toolbar"
                                data-show-export="true" data-maintain-selected="true"
                                data-query-params="payment_request_queryParams">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true">ID</th>
                                        <th data-field="user_name" data-sortable="false">Username</th>
                                        <th data-field="payment_type" data-sortable="true">Type</th>
                                        <th data-field="payment_address" data-sortable="false">Payment Address</th>
                                        <th data-field="amount_requested" data-sortable="false">Amount Requested</th>
                                        <th data-field="remarks" data-sortable="false">Remarks</th>
                                        <th data-field="status" data-sortable="false">Status</th>
                                        <!-- <th data-field="status_digit" data-sortable="false" data-visible='false'
                                            class="never">Status Digit</th> -->
                                        <th data-field="date_created" data-sortable="false">Date Created</th>
                                        <th data-field="operate" data-sortable="false">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="offcanvas offcanvas-end offcanvas-medium" tabindex="-1" id="paymentRequest"
                            aria-labelledby="paymentRequestLabel">
                            <div class="offcanvas-header">
                                <h2 class="offcanvas-title" id="paymentRequestLabel">Update Payment Request</h2>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <form x-data="ajaxForm({
                                            url: base_url + 'admin/payment-request/update-payment-request',
                                            offcanvasId: 'paymentRequest',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="update_payment_request_form">
                                <div class="offcanvas-body">
                                    <div>
                                        <input type="hidden" name="payment_request_id" id="payment_request_id">
                                        <input type="hidden" name="payment_type" id="payment_type">
                                        <input type="hidden" id="id" name="id">

                                        <div class="mb-3 row">
                                            <label class="col-3 col-form-label required" for="status">Status</label>
                                            <div class="col">
                                                <div id="status" class="">
                                                    <label class="btn btn-warning bg-warning-lt"
                                                        data-toggle-class="btn-primary"
                                                        data-toggle-passive-class="btn-default">
                                                        <input type="radio" name="status" value="0"
                                                            class='pending mx-2'> Pending
                                                    </label>
                                                    <label class="btn btn-primary bg-primary-lt"
                                                        data-toggle-class="btn-primary"
                                                        data-toggle-passive-class="btn-default">
                                                        <input type="radio" name="status" value="1"
                                                            class='approved mx-2'> Approved
                                                    </label>
                                                    <label class="btn btn-danger bg-danger-lt"
                                                        data-toggle-class="btn-primary"
                                                        data-toggle-passive-class="btn-default">
                                                        <input type="radio" name="status" value="2"
                                                            class='rejected mx-2'> Rejected
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-3 col-form-label " for="update_remarks">Notes</label>
                                            <div class="col">
                                                <textarea name="update_remarks" id="update_remarks"
                                                    class="textarea form-control" placeholder="Answer"
                                                    data-bs-toggle="autosize"> </textarea>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="text-end">
                                        <!-- <button type="reset" class="btn btn-warning ">Reset</button> -->
                                        <button type="button" class="btn" data-bs-dismiss="offcanvas"
                                            aria-label="Close">Close</button>
                                        <button type="submit" class="btn btn-primary" id="submit_btn">Update Payment
                                            Request</button>
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