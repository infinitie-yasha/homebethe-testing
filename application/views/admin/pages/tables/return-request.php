<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">

                <!-- Mobile View -->
                <div class="d-flex flex-column text-center d-sm-none py-2">
                    <h2 class="page-title fs-5 fw-semibold mb-1">View Return Request</h2>
                    <nav class="breadcrumb breadcrumb-arrows small justify-content-start mb-0">
                        <a href="<?= base_url('admin/home') ?>" class="breadcrumb-item">Home</a>
                        <span class="breadcrumb-item">Return Request</span>
                        <span class="breadcrumb-item active">Manage Return Request</span>
                    </nav>
                </div>

                <!-- Tablet & Desktop View -->
                <div class="row g-2 align-items-center d-none d-sm-flex">
                    <div class="col">
                        <h2 class="page-title mb-0">View Return Request</h2>
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
                                Manage Return Request
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
                            <div class="row g-3 align-items-end">
                                <!-- Filter by Status -->
                                <div class="col-md-4 col-sm-6">
                                    <label for="status_filter" class="form-label">Filter By Status</label>
                                    <select class="form-select" name="status_filter" id="status_filter">
                                        <option value="">Select Status</option>
                                        <option value="0">Pending</option>
                                        <option value="1">Approved</option>
                                        <option value="2">Rejected</option>
                                        <option value="8">Return Pickedup</option>
                                        <option value="3">Returned</option>
                                    </select>
                                </div>

                                <!-- Filter by Seller -->
                                <div class="col-md-4 col-sm-6">
                                    <label for="seller_filter" class="form-label">Seller</label>
                                    <div x-data x-init="initTomSelect({
                 element: $refs.sellerSelect,
                 url: '<?= base_url('admin/product/get_sellers_data') ?>',
                 placeholder: 'Search Seller...',
                 offcanvasId: 'filterOffcanvas',
                 maxItems: 1,
                 preloadOptions: true
             })">
                                        <select x-ref="sellerSelect" class="form-select" name="seller_filter"
                                            id="seller_filter"></select>
                                    </div>
                                </div>

                                <!-- Filter by Product -->
                                <div class="col-md-4 col-sm-6">
                                    <label for="ProductSelect" class="form-label">Filter By Product</label>
                                    <div x-data x-init="initTomSelect({
                 element: $refs.ProductSelect,
                 url: '<?= base_url('admin/product/get_product_data') ?>?from_select=1',
                 placeholder: 'Search Products...',
                 maxItems: 1,
                 preloadOptions: true
             })">
                                        <select x-ref="ProductSelect" name="product_ids[]" class="form-select"
                                            id="ProductSelect"></select>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title"><i class="ti ti-rotate"></i> Return request</h3>
                    </div>
                    <div class="card-body">
                        <table class='table-striped' id="return_request_table" data-toggle="table"
                            data-url="<?= base_url('admin/return_request/view_return_request_list') ?>"
                            data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                            data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                            data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                            data-sort-order="desc" data-mobile-responsive="true" data-toolbar="" data-show-export="true"
                            data-maintain-selected="true" data-query-params="return_request_queryParams">
                            <thead>
                                <tr>
                                    <th data-field="id" data-sortable="true">ID</th>
                                    <th data-field="order_id" data-sortable="true">Order ID</th>
                                    <th data-field="order_item_id" data-sortable="true">Order Item ID</th>
                                    <th data-field="user_name" data-sortable="false">Username</th>
                                    <th data-field="product_name" data-sortable="false">Product Name</th>
                                    <th data-field="variant_name" data-sortable="false">Variant Name</th>
                                    <th data-field="return_reason" data-sortable="false">Return Reason</th>
                                    <th data-field="return_item_image" data-sortable="false">Return item image</th>
                                    <th data-field="price" data-sortable="false" data-visible="false">Price(
                                        <?= $currency ?> )
                                    </th>
                                    <th data-field="seller_id" data-sortable="false" data-visible="false">Seller ID
                                    </th>
                                    <th data-field="seller_name" data-sortable="false" data-visible="false">Seller
                                        Name</th>
                                    <th data-field="quantity" data-sortable="false">Quantity
                                    </th>
                                    <th data-field="sub_total" data-sortable="false">Sub Total( <?= $currency ?> )
                                    </th>
                                    <th data-field="status" data-sortable="false">Status</th>
                                    <th data-field="operate" data-sortable="false">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>


                    <div class="offcanvas offcanvas-end offcanvas-medium" tabindex="-1" id="updateReturnRequest"
                        aria-labelledby="updateReturnRequestLabel">
                        <div class="offcanvas-header">
                            <h2 class="offcanvas-title" id="updateReturnRequestLabel">Update Return Request</h2>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>

                        <form x-data="ajaxForm({
                                            url: base_url + 'admin/return_request/update-return-request',
                                            offcanvasId: 'updateReturnRequest',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="add_return_reason_form">

                            <div class="offcanvas-body">
                                <div>
                                    <div class="card-body">
                                        <input type="hidden" name="return_request_id" id="return_request_id">
                                        <input type="hidden" name="user_id" id="user_id">
                                        <input type="hidden" name="order_item_id" id="order_item_id">
                                        <input type="hidden" name="seller_id" id="seller_id">
                                        <input type="hidden" name="delivery_boy_id" id="delivery_boy_id">

                                        <div class="mb-3 row">
                                            <label class="col-3 col-form-label required" for="status">Status</label>
                                            <div class="col">
                                                <select id="status" name="status" class="form-control">
                                                    <option value="0">Pending</option>
                                                    <option value="1">Approved</option>
                                                    <option value="2">Rejected</option>
                                                    <option value="8">Return Pickedup</option>
                                                    <option value="3">Returned</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3 row d-none" id="return_request_delivery_by">
                                            <label class="col-3 col-form-label" for="deliver_by">Delivery
                                                Boy</label>
                                            <div class="col">
                                                <select id='deliver_by' name='deliver_by' class='form-control'>
                                                    <option value=''>Select Delivery Boy</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-3 col-form-label required"
                                                for="update_remarks">Remarks</label>
                                            <div class="col">
                                                <textarea name="update_remarks" id="update_remarks"
                                                    class="textarea form-control" placeholder="Answer"
                                                    data-bs-toggle="autosize"> </textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="button" class="btn" data-bs-dismiss="offcanvas"
                                        aria-label="Close">Close</button>
                                    <button type="submit" class="btn btn-primary" id="submit_btn">Update Return
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