<div class="page-wrapper">




    <!-- BEGIN PAGE HEADER -->
    <div class="page-header d-print-none" aria-label="Page header">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">Manage Orders</h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="d-flex">
                        <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('seller/home') ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="#">Orders</a>
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
                        <h3 class="card-title">
                            <i class="ti ti-table"></i> Manage Orders
                        </h3>
                    </div>
                    <div class="card-body ">
                         <div class="row g-3 align-items-end">

                                <!-- Date Range -->
                                <div class="col-12 col-md-6 col-lg-3">
                                    <label class="form-label" for="datepicker">Date and Time Range</label>
                                    <div class="input-icon">
                                        <input type="text" class="form-control" id="datepicker" autocomplete="off" />
                                        <input type="hidden" id="start_date" class="form-control">
                                        <input type="hidden" id="end_date" class="form-control">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-clock"></i>
                                        </span>
                                    </div>
                                </div>

                                <!-- Filter By Status -->
                                <div class="col-12 col-md-6 col-lg-3" x-data
                                    x-init="initTomSelect({element: $refs.orderStatus, placeholder: 'Select Status', maxItems: 1, preloadOptions: true})">
                                    <label class="form-label" for="order_status">Filter By Status</label>
                                    <select id="order_status" name="order_status" x-ref="orderStatus"
                                        class="form-control">
                                        <option value="">All Orders</option>
                                        <option value="received">Received</option>
                                        <option value="processed">Processed</option>
                                        <option value="shipped">Shipped</option>
                                        <option value="delivered">Delivered</option>
                                        <option value="cancelled">Cancelled</option>
                                        <option value="returned">Returned</option>
                                    </select>
                                </div>

                                <!-- Filter by Payment Method -->
                                <div class="col-12 col-md-6 col-lg-3" x-data
                                    x-init="initTomSelect({element: $refs.paymentMethod, placeholder: 'Select Payment Method', maxItems: 1, preloadOptions: true})">
                                    <label class="form-label" for="payment_method">Filter By Payment Method</label>
                                    <select id="payment_method" name="payment_method" x-ref="paymentMethod"
                                        class="form-control">
                                        <option value="">All Payment Methods</option>
                                        <option value="COD">Cash On Delivery</option>
                                        <option value="Paypal">Paypal</option>
                                        <option value="RazorPay">RazorPay</option>
                                        <option value="Paystack">Paystack</option>
                                        <option value="Flutterwave">Flutterwave</option>
                                        <option value="Paytm">Paytm</option>
                                        <option value="Stripe">Stripe</option>
                                        <option value="bank_transfer">Direct Bank Transfer</option>
                                    </select>
                                </div>

                                <!-- Buttons -->
                                <div class="col-12 col-md-6 col-lg-3 d-flex gap-2">
                                    <button type="button" class="btn btn-secondary w-50" onclick="resetfilters()">
                                        <i class="ti ti-refresh"></i> Clear
                                    </button>
                                    <button type="button" class="btn btn-primary w-50"
                                        onclick="status_date_wise_search()">
                                        <i class="ti ti-search"></i> Filter
                                    </button>
                                </div>

                            </div>

                        <table class='table-striped' data-toggle="table"
                            data-url="<?= base_url('seller/orders/view_order_items') ?>" data-click-to-select="true"
                            data-side-pagination="server" data-pagination="true"
                            data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                            data-show-refresh="true" data-trim-on-search="false" data-sort-name="o.id"
                            data-sort-order="desc" data-mobile-responsive="true" data-toolbar="" data-show-export="true"
                            data-maintain-selected="true" data-export-types='["txt","excel","csv"]'
                            data-export-options='{"fileName": "orders-list","ignoreColumn": ["state"] }'
                            data-query-params="orders_query_params">
                            <thead>
                                <tr>
                                    <th data-field="id" data-sortable='true' data-footer-formatter="totalFormatter">ID
                                    </th>
                                    <th data-field="order_item_id" data-sortable='true'>Order Item ID</th>
                                    <th data-field="order_id" data-sortable='true'>Order ID</th>
                                    <th data-field="user_id" data-sortable='true' data-visible="false">User ID</th>
                                    <th data-field="seller_id" data-sortable='true' data-visible="false">Seller ID</th>
                                    <th data-field="is_credited" data-sortable='true' data-visible="false">Commission
                                    </th>
                                    <th data-field="quantity" data-sortable='true' data-visible="false">Quantity</th>
                                    <th data-field="username" data-sortable='true'>User Name</th>
                                    <th data-field="seller_name" data-sortable='true' data-visible="false">Seller Name
                                    </th>
                                    <th data-field="product_name" data-sortable='true'>Product Name</th>
                                    <th data-field="mobile" data-sortable='true' data-visible='false'>Mobile</th>
                                    <th data-field="notes" data-sortable='true' data-visible='false'>Order Note</th>
                                    <th data-field="sub_total" data-sortable='true' data-visible="true">
                                        Total(<?= $curreny ?>)</th>
                                    <th data-field="payment_method" data-sortable='true' data-visible='true'>Payment
                                        Method</th>
                                    <th data-field="delivery_boy" data-sortable='true' data-visible='false'>Deliver By
                                    </th>
                                    <th data-field="delivery_boy_id" data-sortable='true' data-visible='false'>Delivery
                                        Boy Id</th>
                                    <th data-field="product_variant_id" data-sortable='true' data-visible='false'>
                                        Product Variant Id</th>
                                    <th data-field="delivery_date" data-sortable='true' data-visible='false'>Delivery
                                        Date</th>
                                    <th data-field="delivery_time" data-sortable='true' data-visible='false'>Delivery
                                        Time</th>
                                    <th data-field="updated_by" data-sortable='true' data-visible="false">Updated by
                                    </th>
                                    <!-- <th data-field="status" data-sortable='true' data-visible='false'>Status</th> -->
                                    <th data-field="active_status" data-sortable='true' data-visible='true'>Active
                                        Status</th>
                                    <th data-field="transaction_status" data-sortable='true' data-visible='false'>
                                        Transaction Status</th>
                                    <th data-field="date_added" data-sortable='true'>Order Date</th>
                                    <th data-field="operate" data-sortable="false">Action</th>
                                    <th data-field="mail_status">Mail Status</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                </div><!-- .card-innr -->
            </div><!-- .card -->
        </div>
    </div>
    <!-- /.row -->
</div>
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>


<div id="digital-order-mails" class="offcanvas offcanvas-end" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="offcanvas-dialog offcanvas-xl">
        <div class="offcanvas-content">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="exampleModalLongTitle">Digital Order Mails</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>


            <div class="offcanVAS-body ">
                <input type="hidden" name="order_id" id="order_id">
                <input type="hidden" name="order_item_id" id="order_item_id">
                <table class='table-striped' id="digital_order_mail_table" data-toggle="table"
                    data-url="<?= base_url('seller/orders/get-digital-order-mails') ?>" data-click-to-select="true"
                    data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]"
                    data-search="true" data-show-columns="true" data-show-refresh="true" data-trim-on-search="false"
                    data-sort-name="id" data-sort-order="desc" data-mobile-responsive="true" data-toolbar=""
                    data-show-export="true" data-maintain-selected="true"
                    data-query-params="digital_order_mails_query_params">
                    <thead>
                        <tr>
                            <th data-field="id" data-sortable="true">ID</th>
                            <th data-field="order_id" data-sortable="true">Order ID</th>
                            <th data-field="order_item_id" data-sortable="false">Order Item ID</th>
                            <th data-field="subject" data-sortable="false">Subject</th>
                            <th data-field="message" data-sortable="false" data-visible="false">Message</th>
                            <th data-field="file_url" data-sortable="false">URL</th>
                            <th data-field="date_added" data-sortable="false" data-visible="false">Date</th>
                        </tr>
                    </thead>
                </table>
            </div>

        </div>
    </div>
</div>
<!-- modal for send mail for digital orders -->
<div id="ManageOrderSendMailModal" class="offcanvas offcanvas-end editSendMail" tabindex="-1"
    aria-labelledby="ManageOrderSendMailModalLabel" aria-hidden="true">

    <!-- Header -->
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="ManageOrderSendMailModalLabel">Manage Digital Product</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <!-- Body -->
    <div class="offcanvas-body">
        <form class="form-horizontal form-submit-event" id="digital_product_management"
            action="<?= base_url('seller/orders/send_digital_product'); ?>" method="POST" enctype="multipart/form-data">

            <input type="hidden" name="order_id" value="<?= $order_item_data[0]['order_id'] ?>">
            <input type="hidden" name="order_item_id" value="<?= $this->input->get('edit_id') ?>">
            <input type="hidden" name="username" value="<?= $user_data['username'] ?>">



            <!-- Subject -->
            <div class="mb-3">
                <label for="subject" class="form-label">Subject</label>
                <input type="text" class="form-control" id="subject" placeholder="Enter Subject for email"
                    name="subject" value="">
            </div>

            <!-- Message -->
            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control textarea" rows="6" id="message" placeholder="Message for Email"
                    name="message"><?= isset($product_details[0]['short_description']) ? output_escaping(str_replace('\r\n', '&#13;&#10;', $product_details[0]['short_description'])) : ""; ?></textarea>
            </div>

            <!-- File Upload -->
            <div class="mb-3" id="digital_media_container">
                <label for="image" class="form-label required">File</label>
                <div class="mb-2">
                    <a class="uploadFile btn btn-outline btn-primary btn-sm" data-input='pro_input_file'
                        data-isremovable='1' data-media_type='archive,document' data-is-multiple-uploads-allowed='0'
                        data-bs-toggle="modal" data-bs-target="#media-upload-modal">
                        <i class='ti ti-upload'></i> Upload
                    </a>
                </div>
                <div class="row image-upload-section">
                    <div class="col-md-6 col-12 shadow p-3 mb-3 rounded text-center grow image d-none"></div>
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="text-end mt-3">
                <button type="button" class="btn btn-secondary bg-secondary-lt"
                    data-bs-dismiss="offcanvas">Close</button>
                <button type="submit"
                    class="btn btn-success bg-success-lt"><?= labels('send_mail', 'Send Mail') ?></button>
            </div>
        </form>
    </div>

</div>


<!-- modal for assign tracking data for order -->

<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="transaction_modal" data-backdrop="static"
    data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="user_name">Order Tracking</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-info">
                            <!-- form start -->
                            <form class="form-horizontal " id="order_tracking_form"
                                action="<?= base_url('seller/orders/update-order-tracking/'); ?>" method="POST"
                                enctype="multipart/form-data">
                                <input type="hidden" name="order_id" id="order_id">
                                <input type="hidden" name="order_item_id" id="order_item_id">
                                <input type="hidden" name="seller_id" id="seller_id">
                                <div class="pad">
                                    <div class="form-group ">
                                        <label for="courier_agency">Courier Agency</label>
                                        <input type="text" class="form-control" name="courier_agency"
                                            id="courier_agency" placeholder="Courier Agency" />
                                    </div>
                                    <div class="form-group ">
                                        <label for="tracking_id">Tracking Id</label>
                                        <input type="text" class="form-control" name="tracking_id" id="tracking_id"
                                            placeholder="Tracking Id" />
                                    </div>
                                    <div class="form-group ">
                                        <label for="url">URL</label>
                                        <input type="text" class="form-control" name="url" id="url" placeholder="URL" />
                                    </div>
                                    <div class="form-group">
                                        <button type="reset" class="btn btn-warning">Reset</button>
                                        <button type="submit" class="btn btn-success" id="submit_btn">Save</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <!--/.card-->
                    </div>
                    <!--/.col-md-12-->
                </div>
                <!-- /.row -->

            </div>
            </form>
        </div>
    </div>
</div>