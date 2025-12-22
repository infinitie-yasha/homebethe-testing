<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">Custom message</h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="d-flex">
                            <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/home') ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">Custom message</a>
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
                            <h3 class="card-title"><i class="ti ti-bell-ringing"></i> Custom message List</h3>
                            <a href="#" class="btn btn-primary addCustomNessageBtn btn-sm bg-primary-lt"
                                data-bs-toggle="offcanvas" data-bs-target="#customNotification">Add Custom Message</a>
                        </div>
                        <div class="card-body">
                            <table class='table-striped' id="custom_notification_table" data-toggle="table"
                                data-url="<?= base_url('admin/custom_notification/view_notification') ?>"
                                data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                                data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                                data-sort-order="desc" data-mobile-responsive="true" data-toolbar=""
                                data-show-export="true" data-maintain-selected="true" data-query-params="queryParams">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true">ID</th>
                                        <th data-field="title" data-sortable="false">Title</th>
                                        <th data-field="type" data-sortable="true">Type</th>
                                        <th data-field="message" data-sortable="true" class="col-md-4">Message</th>
                                        <th data-field="operate" data-sortable="false">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                    </div>

                    <div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="customNotification"
                        aria-labelledby="customNotificationLabel">
                        <div class="offcanvas-header">
                            <h2 class="offcanvas-title" id="customNotificationLabel">Custom Notification</h2>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <form x-data="ajaxForm({
                                            url: base_url + 'admin/custom_notification/add_notification',
                                            offcanvasId: 'customNotification',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="add_custom_notification_form">
                            <div class="offcanvas-body">
                                <div>

                                    <input type="hidden" id="edit_custom_notification" name="edit_custom_notification"
                                        value="">
                                    <input type="hidden" id="update_id" name="update_id" value="1">
                                    <input type="hidden" id="udt_title" value="">


                                    <div class="mb-3 row">
                                        <label class="col-12 col-md-4 col-form-label required" for="type">Types</label>
                                        <div class="col">
                                            <select name="type" id="type" class="form-control type">
                                                <option value=" ">Select Types</option>
                                                <?php foreach ($notification_modules as $row => $value) { ?>
                                                    <option value="<?= $row ?>">
                                                        <?= ucwords(str_replace('_', ' ', $row)) ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Place Order -->
                                    <div class="mb-3 row">
                                        <label class="col-12 col-md-4 col-form-label required" for="update_title">title</label>
                                        <div class="col">
                                            <input type="text" class="form-control update_title" name="title"
                                                id="update_title" placeholder="Title" />
                                        </div>
                                    </div>

                                    <div class="mb-3 row place_order ">
                                        <label class="col-12 col-md-4 col-form-label" for="message"></label>
                                        <?php
                                        $hashtag = ['< order_id >'];
                                        foreach ($hashtag as $row) { ?>
                                            <div class="col">
                                                <div class="hashtag_input"><?= $row ?></div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-12 col-md-4 col-form-label required" for="text-box">Message</label>
                                        <div class="col">
                                            <textarea name="message" id="text-box"
                                                class="textarea form-control text-box" placeholder="Message"
                                                data-bs-toggle="autosize"> </textarea>
                                        </div>
                                    </div>

                                    <div class="mb-3 row place_order ">
                                        <label class="col-12 col-md-4 col-form-label" for="message"></label>
                                        <?php
                                        $hashtag = ['< application_name >'];
                                        foreach ($hashtag as $row) { ?>
                                            <div class="col">
                                                <div class="hashtag"><?= $row ?></div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <!-- Seller Place Order -->
                                    <div class="mb-3 row seller_place_order">
                                        <label class="col-12 col-md-4 col-form-label" for="message"></label>
                                        <?php
                                        $hashtag = ['< cutomer_name >', '< application_name >', '< order_id >'];
                                        foreach ($hashtag as $row) { ?>
                                            <div class="col">
                                                <div class="hashtag"><?= $row ?></div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <!-- Settle Cashback Discount -->
                                    <div class="mb-3 row settle_cashback_discount">
                                        <label class="col-12 col-md-4 col-form-label" for="message"></label>
                                        <?php
                                        $hashtag = ['< cutomer_name >', '< application_name >'];
                                        foreach ($hashtag as $row) { ?>
                                            <div class="col">
                                                <div class="hashtag"><?= $row ?></div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <!-- settle Seller Commission -->
                                    <div class="mb-3 row settle_seller_commission">
                                        <label class="col-12 col-md-4 col-form-label" for="message"></label>
                                        <?php
                                        $hashtag = ['< cutomer_name >', '< application_name >'];
                                        foreach ($hashtag as $row) { ?>
                                            <div class="col">
                                                <div class="hashtag"><?= $row ?></div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <!-- Customer Order Received -->
                                    <div class="mb-3 row customer_order_received">
                                        <label class="col-12 col-md-4 col-form-label" for="message"></label>
                                        <?php
                                        $hashtag = ['< cutomer_name >', '< order_item_id >', '< application_name >'];
                                        foreach ($hashtag as $row) { ?>
                                            <div class="col">
                                                <div class="hashtag"><?= $row ?></div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <!-- Customer Order Received -->
                                    <div class="mb-3 row customer_order_processed">
                                        <label for="message" class="col-12 col-md-4 col-form-label"></label>
                                        <?php
                                        $hashtag = ['< cutomer_name >', '< order_item_id >', '< application_name >'];
                                        foreach ($hashtag as $row) { ?>
                                            <div class="col">
                                                <div class="hashtag"><?= $row ?></div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <!-- Delivery Boy Order Processed -->
                                    <div class="mb-3 row delivery_boy_order_processed">
                                        <label for="message" class="col-12 col-md-4 col-form-label"></label>
                                        <?php
                                        $hashtag = ['< cutomer_name >', '< order_item_id >', '< application_name >'];
                                        foreach ($hashtag as $row) { ?>
                                            <div class="col">
                                                <div class="hashtag"><?= $row ?></div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <!-- Customer Order Shipped  -->
                                    <div class="mb-3 row customer_order_shipped">
                                        <label for="message" class="col-12 col-md-4 col-form-label"></label>
                                        <?php
                                        $hashtag = ['< cutomer_name >', '< order_item_id >', '< application_name >'];
                                        foreach ($hashtag as $row) { ?>
                                            <div class="col">
                                                <div class="hashtag"><?= $row ?></div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <!-- customer order delivered  -->
                                    <div class="mb-3 row customer_order_delivered">
                                        <label for="message" class="col-12 col-md-4 col-form-label"></label>
                                        <?php
                                        $hashtag = ['< cutomer_name >', '< order_item_id >', '< application_name >'];
                                        foreach ($hashtag as $row) { ?>
                                            <div class="col">
                                                <div class="hashtag"><?= $row ?></div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <!-- Customer Order Cancelled -->
                                    <div class="mb-3 row customer_order_cancelled">
                                        <label for="message" class="col-12 col-md-4 col-form-label"></label>
                                        <?php
                                        $hashtag = ['< cutomer_name >', '< order_item_id >', '< application_name >'];
                                        foreach ($hashtag as $row) { ?>
                                            <div class="col">
                                                <div class="hashtag"><?= $row ?></div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <!-- customer order Returned -->
                                    <div class="mb-3 row customer_order_returned">
                                        <label for="message" class="col-12 col-md-4 col-form-label"></label>
                                        <?php
                                        $hashtag = ['< cutomer_name >', '< order_item_id >', '< application_name >'];
                                        foreach ($hashtag as $row) { ?>
                                            <div class="col">
                                                <div class="hashtag"><?= $row ?></div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <!-- Delivery Boy return Order Assign -->
                                    <div class="mb-3 row delivery_boy_return_order_assign">
                                        <label for="message" class="col-12 col-md-4 col-form-label"></label>
                                        <?php
                                        $hashtag = ['< cutomer_name >', '< order_item_id >', '< application_name >'];
                                        foreach ($hashtag as $row) { ?>
                                            <div class="col">
                                                <div class="hashtag"><?= $row ?></div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <!-- Customer Order Return request approved -->
                                    <div class="mb-3 row customer_order_returned_request_approved">
                                        <label for="message" class="col-12 col-md-4 col-form-label"></label>
                                        <?php
                                        $hashtag = ['< cutomer_name >', '< order_item_id >', '< application_name >'];
                                        foreach ($hashtag as $row) { ?>
                                            <div class="col">
                                                <div class="hashtag"><?= $row ?></div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <!-- customer order return request decline -->
                                    <div class="mb-3 row customer_order_returned_request_decline">
                                        <label for="message" class="col-12 col-md-4 col-form-label"></label>
                                        <?php
                                        $hashtag = ['< cutomer_name >', '< order_item_id >', '< application_name >'];
                                        foreach ($hashtag as $row) { ?>
                                            <div class="col">
                                                <div class="hashtag"><?= $row ?></div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <!-- wallet transaction -->
                                    <div class="mb-3 row wallet_transaction">
                                        <label for="message" class="col-12 col-md-4 col-form-label"></label>
                                        <?php
                                        $hashtag = ['< currency >', '< returnable_amount >'];
                                        foreach ($hashtag as $row) { ?>
                                            <div class="col">
                                                <div class="hashtag"><?= $row ?></div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <!-- ticket status -->
                                    <div class="mb-3 row ticket_status">
                                        <label for="message" class="col-12 col-md-4 col-form-label"></label>
                                        <?php
                                        $hashtag = ['< application_name >'];
                                        foreach ($hashtag as $row) { ?>
                                            <div class="col">
                                                <div class="hashtag"><?= $row ?></div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <!-- Ticket message -->
                                    <div class="mb-3 row ticket_message">
                                        <label for="message" class="col-12 col-md-4 col-form-label"></label>
                                        <?php
                                        $hashtag = ['< application_name >'];
                                        foreach ($hashtag as $row) { ?>
                                            <div class="col">
                                                <div class="hashtag"><?= $row ?></div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <!-- Bank receipt status -->
                                    <div class="mb-3 row bank_transfer_receipt_status">
                                        <label for="message" class="col-12 col-md-4 col-form-label"></label>
                                        <?php
                                        $hashtag = ['< status >', '< order_id >'];
                                        foreach ($hashtag as $row) { ?>
                                            <div class="col">
                                                <div class="hashtag"><?= $row ?></div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <!-- Bank Transfer proof -->
                                    <div class="mb-3 row bank_transfer_proof">
                                        <label for="message" class="col-12 col-md-4 col-form-label"></label>
                                        <?php
                                        $hashtag = ['< order_id >', '< application_name >'];
                                        foreach ($hashtag as $row) { ?>
                                            <div class="col">
                                                <div class="hashtag"><?= $row ?></div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                </div>
                                <div class="text-end">
                                    <!-- <button type="reset" class="btn btn-warning ">Reset</button> -->
                                    <button type="button" class="btn" data-bs-dismiss="offcanvas"
                                        aria-label="Close">Close</button>
                                    <button type="submit" class="btn btn-primary save_custom_notification"
                                        id="submit_btn">Add Custom message </button>

                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>