<!-- Page header -->
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Manage Orders
                </h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                        <li class="breadcrumb-item"><a href="<?= base_url('delivery-boy/home') ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Orders</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">

        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs nav-fill" data-bs-toggle="tabs">
                        <li class="nav-item">
                            <a href="#orders_table" class="nav-link active" data-bs-toggle="tab">
                                <i class="ti ti-shopping-cart"></i> Orders</a>
                        </li>
                        <li class="nav-item">
                            <a href="#order_items_table" class="nav-link" data-bs-toggle="tab">
                                <i class="ti ti-package-export"></i> Return Order</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">

                    <div class="tab-content">
                        <div class="tab-pane active show" id="orders_table">
                            <div>
                                <div class="row g-3 align-items-end">
                                    <!-- Date & Time Range -->
                                    <div class="col-12 col-sm-6 col-md-3">
                                        <label class="form-label" for="datepicker">Date and time range:</label>
                                        <div class="input-icon">
                                            <input type="text" value="" class="form-control" id="datepicker"
                                                autocomplete="off" />
                                            <input type="hidden" id="start_date" class="form-control">
                                            <input type="hidden" id="end_date" class="form-control">
                                            <span class="input-icon-addon">
                                                <i class="ti ti-clock"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Filter by Status -->
                                    <div class="col-12 col-sm-6 col-md-3">
                                        <label class="form-label">Filter By Status</label>
                                        <select id="order_status" name="order_status" class="form-control">
                                            <option value="">All Orders</option>
                                            <option value="processed">Processed</option>
                                            <option value="shipped">Shipped</option>
                                            <option value="delivered">Delivered</option>
                                            <option value="returned">Returned</option>
                                        </select>
                                    </div>

                                    <!-- Filter by Payment Method -->
                                    <div class="col-12 col-sm-6 col-md-3">
                                        <label class="form-label">Filter By Payment Method</label>
                                        <select id="payment_method" name="payment_method" class="form-control">
                                            <option value="">All Payment Methods</option>
                                            <option value="COD">Cash On Delivery</option>
                                            <option value="online-payment">Online Payment</option>
                                        </select>
                                    </div>

                                    <!-- Buttons -->
                                    <div class="col-12 col-sm-6 col-md-3 d-flex flex-wrap gap-2">
                                        <button type="button" class="btn btn-primary flex-grow-1"
                                            onclick="status_date_wise_search()">
                                            <i class="ti ti-search"></i> Filter
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary flex-grow-1"
                                            onclick="resetfilters()">
                                            <i class="ti ti-refresh"></i> Reset
                                        </button>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped" id="consignment_table" data-toggle="table"
                                        data-url="<?= base_url('delivery_boy/orders/consignment_view') ?>"
                                        data-side-pagination="server" data-pagination="true" data-show-columns="true"
                                        data-show-refresh="true" data-trim-on-search="false"
                                        data-page-list="[5,10,20,50,100]" data-search="true" data-sort-order="desc"
                                        data-sort-name="id" data-query-params="home_query_params">
                                        <thead>
                                            <tr>
                                                <th data-field="id" data-sortable="true">ID</th>
                                                <th data-field="order_id" data-sortable="true">Order ID</th>
                                                <th data-field="username" data-sortable="true">Buyer Name</th>
                                                <th data-field="mobile" data-sortable="true">Buyer Mobile</th>
                                                <th data-field="product_name" data-sortable="true">Product Name</th>
                                                <th data-field="quantity" data-sortable="true">Quantity</th>
                                                <th data-field="status" data-sortable="true">Status</th>
                                                <th data-field="payment_method" data-sortable="true">Payment Method</th>
                                                <th data-field="order_date" data-sortable="true">Order Date</th>
                                                <th data-field="operate">Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane" id="order_items_table">
                            <div>
                                <div class="gaps-1-5x row d-flex adjust-items-center">
                                    <div class="row col-md-12 mt-4">

                                        <div class="form-group col-md-3">
                                            <div>
                                                <label class="form-label">Filter By status</label>
                                                <select id="return_order_status" name="order_status"
                                                    placeholder="Select Status" required="" class="form-control">
                                                    <option value="">All Orders</option>
                                                    <option value="return_pickedup">Return Pickedup</option>
                                                    <option value="return_request_approved">Return Request
                                                        Approved</option>
                                                    <option value="returned">Returned</option>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-3 d-flex align-items-center pt-4 gap-2">
                                            <button type="button" class="btn btn-primary "
                                                onclick="status_date_wise_search()">
                                                <i class="ti ti-search"></i> Filter
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary"
                                                onclick="resetfilters()">
                                                <i class="ti ti-refresh"></i> Reset
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <table class='table-striped' data-toggle="table"
                                    data-url="<?= base_url('delivery_boy/orders/view_orders') ?>"
                                    data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                                    data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true"
                                    data-show-columns="true" data-show-refresh="true" data-trim-on-search="false"
                                    data-sort-name="oi.id" data-sort-order="desc" data-mobile-responsive="true"
                                    data-toolbar="" data-show-export="true" data-maintain-selected="true"
                                    data-export-types='["txt","excel","csv"]'
                                    data-export-options='{"fileName": "order-item-list","ignoreColumn": ["state"] }'
                                    data-query-params="return_order_query_params">
                                    <thead>
                                        <tr>
                                            <th data-field="id" data-sortable='false'
                                                data-footer-formatter="totalFormatter">ID</th>
                                            <th data-field="order_item_id" data-sortable='true'>Order Item ID
                                            </th>
                                            <th data-field="order_id" data-sortable='true'>Order ID</th>
                                            <th data-field="user_id" data-sortable='true' data-visible="false">
                                                User ID
                                            </th>
                                            <th data-field="seller_id" data-sortable='true' data-visible="false">Seller
                                                ID</th>
                                            <th data-field="is_credited" data-sortable='true' data-visible="false">
                                                Commission</th>
                                            <th data-field="quantity" data-sortable='false' data-visible="false">
                                                Quantity
                                            </th>
                                            <th data-field="username" data-sortable='true'>User Name</th>
                                            <th data-field="seller_name" data-sortable='true'>Seller Name</th>
                                            <th data-field="product_name" data-sortable='true'>Product Name</th>
                                            <th data-field="mobile" data-sortable='false' data-visible='false'>
                                                Mobile
                                            </th>
                                            <th data-field="sub_total" data-sortable='true' data-visible="true">
                                                Total(<?= $curreny ?>)</th>
                                            <th data-field="delivery_boy" data-sortable='false' data-visible='false'>
                                                Deliver By</th>
                                            <th data-field="delivery_boy_id" data-sortable='false' data-visible='false'>
                                                Delivery Boy Id</th>
                                            <th data-field="product_variant_id" data-sortable='true'
                                                data-visible='false'>Product Variant Id</th>
                                            <th data-field="delivery_date" data-sortable='false' data-visible='false'>
                                                Delivery Date</th>
                                            <th data-field="delivery_time" data-sortable='false' data-visible='false'>
                                                Delivery Time</th>
                                            <th data-field="updated_by" data-sortable='true' data-visible="false">
                                                Updated by</th>
                                            <th data-field="active_status" data-sortable='true' data-visible='true'>
                                                Active Status</th>
                                            <th data-field="transaction_status" data-sortable='false'
                                                data-visible='false'>Transaction Status</th>
                                            <th data-field="date_added" data-sortable='true'>Order Date</th>
                                            <th data-field="operate" data-sortable="false">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>