<div class="page-wrapper">




    <!-- BEGIN PAGE HEADER -->
    <div class="page-header d-print-none" aria-label="Page header">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">Manage point of sales</h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="d-flex">
                        <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('seller/home') ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="#">point of saless</a>
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
                        <h3 class="card-title"><i class="ti ti-shopping-cart"></i> Point of Sales</h3>

                    </div>

                    <div class="card-body">
                        <table class='table-striped' data-toggle="table"
                            data-url="<?= base_url('seller/point_of_sale/point_of_sale_orders') ?>"
                            data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                            data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                            data-show-refresh="true" data-trim-on-search="false" data-sort-name="o.id"
                            data-sort-order="desc" data-mobile-responsive="true" data-toolbar="" data-show-export="true"
                            data-maintain-selected="true" data-export-types='["txt","excel","csv"]'
                            data-export-options='{"fileName": "orders-list","ignoreColumn": ["state"] }'
                            data-query-params="orders_query_params">
                            <thead>
                                <tr>
                         
                                    <th data-field="id">ID</th>
                                    <th data-field="order_item_id">Order Item ID</th>
                                    <th data-field="order_id">Order ID</th>
                                    <th data-field="user_id" data-visible="false">User ID</th>
                                    <th data-field="seller_id" data-visible="false">Seller ID</th>
                                    <th data-field="is_credited" data-visible="false">Commission</th>
                                    <th data-field="quantity" data-visible="false">Quantity</th>
                                    <th data-field="username">User Name</th>
                                    <th data-field="seller_name" data-visible="false">Seller Name</th>
                                    <th data-field="product_name">Product Name</th>
                                    <th data-field="mobile" data-visible="false">Mobile</th>
                                    <th data-field="notes" data-visible="false">Order Note</th>
                                    <th data-field="sub_total">Total(<?= $currency ?>)</th>
                                    <th data-field="payment_method" data-visible="false">Payment Method</th>
                                    <th data-field="product_variant_id" data-visible="false">Product Variant ID</th>
                                    <th data-field="active_status">Active Status</th>
                                    <th data-field="date_added">Order Date</th>
                                    <th data-field="operate">Action</th>
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


<!-- models -->


<!-- Digital Order Mails Modal -->
<div id="digital-order-mails" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Digital Order Mails</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
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
                            <th data-field="id">ID</th>
                            <th data-field="order_id">Order ID</th>
                            <th data-field="order_item_id">Order Item ID</th>
                            <th data-field="subject">Subject</th>
                            <th data-field="message" data-visible="false">Message</th>
                            <th data-field="file_url">URL</th>
                            <th data-field="date_added" data-visible="false">Date</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Send Mail Modal -->
<div id="ManageOrderSendMailModal" class="modal fade editSendMail" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Manage Digital Product</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-submit-event" id="digital_product_management"
                    action="<?= base_url('seller/orders/send_digital_product'); ?>" method="POST"
                    enctype="multipart/form-data">
                    <div class="card-body">
                        <input type="hidden" name="order_id" value="<?= $order_item_data[0]['order_id'] ?>">
                        <input type="hidden" name="order_item_id" value="<?= $this->input->get('edit_id') ?>">
                        <input type="hidden" name="username" value="<?= $user_data['username'] ?>">

                        <div class="form-group">
                            <label>Customer Email-ID</label>
                            <input type="text" class="form-control ManageOrderEmail" name="email" readonly>
                        </div>

                        <div class="form-group">
                            <label>Subject</label>
                            <input type="text" class="form-control" name="subject"
                                placeholder="Enter Subject for email">
                        </div>

                        <div class="form-group">
                            <label>Message</label>
                            <textarea class="form-control textarea" rows="6"
                                name="message"><?= isset($product_details[0]['short_description']) ? output_escaping(str_replace('\r\n', '&#13;&#10;', $product_details[0]['short_description'])) : ""; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>File <span class='text-danger'>*</span></label>
                            <div>
                                <a class="uploadFile btn btn-primary btn-sm text-white" data-input='pro_input_file'
                                    data-isremovable='1' data-media_type='archive,document'
                                    data-is-multiple-uploads-allowed='0' data-toggle="modal"
                                    data-target="#media-upload-modal">
                                    <i class='fa fa-upload'></i> Upload
                                </a>
                            </div>
                            <div class="row image-upload-section mt-3">
                                <div class="col-md-6 shadow p-3 mb-5 rounded d-none image text-center"></div>
                            </div>
                        </div>

                        <button type="submit"
                            class="btn btn-success mt-3"><?= labels('send_mail', 'Send Mail') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Tracking Modal -->
<div class="modal fade" id="transaction_modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Order Tracking</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="order_tracking_form"
                    action="<?= base_url('seller/orders/update-order-tracking/'); ?>" method="POST">
                    <input type="hidden" name="order_id" id="order_id">
                    <input type="hidden" name="order_item_id" id="order_item_id">
                    <input type="hidden" name="seller_id" id="seller_id">
                    <div class="form-group">
                        <label>Courier Agency</label>
                        <input type="text" class="form-control" name="courier_agency" placeholder="Courier Agency">
                    </div>
                    <div class="form-group">
                        <label>Tracking ID</label>
                        <input type="text" class="form-control" name="tracking_id" placeholder="Tracking ID">
                    </div>
                    <div class="form-group">
                        <label>URL</label>
                        <input type="text" class="form-control" name="url" placeholder="URL">
                    </div>
                    <div class="form-group">
                        <button type="reset" class="btn btn-warning">Reset</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="digital-order-mails" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Digital Order Mails</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
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
                            <th data-field="id">ID</th>
                            <th data-field="order_id">Order ID</th>
                            <th data-field="order_item_id">Order Item ID</th>
                            <th data-field="subject">Subject</th>
                            <th data-field="message" data-visible="false">Message</th>
                            <th data-field="file_url">URL</th>
                            <th data-field="date_added" data-visible="false">Date</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Send Mail Modal -->
<div id="ManageOrderSendMailModal" class="modal fade editSendMail" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Manage Digital Product</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-submit-event" id="digital_product_management"
                    action="<?= base_url('seller/orders/send_digital_product'); ?>" method="POST"
                    enctype="multipart/form-data">
                    <div class="card-body">
                        <input type="hidden" name="order_id" value="<?= $order_item_data[0]['order_id'] ?>">
                        <input type="hidden" name="order_item_id" value="<?= $this->input->get('edit_id') ?>">
                        <input type="hidden" name="username" value="<?= $user_data['username'] ?>">

                        <div class="form-group">
                            <label>Customer Email-ID</label>
                            <input type="text" class="form-control ManageOrderEmail" name="email" readonly>
                        </div>

                        <div class="form-group">
                            <label>Subject</label>
                            <input type="text" class="form-control" name="subject"
                                placeholder="Enter Subject for email">
                        </div>

                        <div class="form-group">
                            <label>Message</label>
                            <textarea class="form-control textarea" rows="6"
                                name="message"><?= isset($product_details[0]['short_description']) ? output_escaping(str_replace('\r\n', '&#13;&#10;', $product_details[0]['short_description'])) : ""; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>File <span class='text-danger'>*</span></label>
                            <div>
                                <a class="uploadFile btn btn-primary btn-sm text-white" data-input='pro_input_file'
                                    data-isremovable='1' data-media_type='archive,document'
                                    data-is-multiple-uploads-allowed='0' data-toggle="modal"
                                    data-target="#media-upload-modal">
                                    <i class='fa fa-upload'></i> Upload
                                </a>
                            </div>
                            <div class="row image-upload-section mt-3">
                                <div class="col-md-6 shadow p-3 mb-5 rounded d-none image text-center"></div>
                            </div>
                        </div>

                        <button type="submit"
                            class="btn btn-success mt-3"><?= labels('send_mail', 'Send Mail') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Tracking Modal -->
<div class="modal fade" id="transaction_modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Order Tracking</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="order_tracking_form"
                    action="<?= base_url('seller/orders/update-order-tracking/'); ?>" method="POST">
                    <input type="hidden" name="order_id" id="order_id">
                    <input type="hidden" name="order_item_id" id="order_item_id">
                    <input type="hidden" name="seller_id" id="seller_id">
                    <div class="form-group">
                        <label>Courier Agency</label>
                        <input type="text" class="form-control" name="courier_agency" placeholder="Courier Agency">
                    </div>
                    <div class="form-group">
                        <label>Tracking ID</label>
                        <input type="text" class="form-control" name="tracking_id" placeholder="Tracking ID">
                    </div>
                    <div class="form-group">
                        <label>URL</label>
                        <input type="text" class="form-control" name="url" placeholder="URL">
                    </div>
                    <div class="form-group">
                        <button type="reset" class="btn btn-warning">Reset</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>