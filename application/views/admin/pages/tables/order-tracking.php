<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">Order Tracking</h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="d-flex">
                            <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/home') ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/orders') ?>">Orders</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">Order Tracking</a>
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
                            <h3 class="card-title"><i class="ti ti-location"></i> Order Tracking </h3>

                        </div>
                        <div class="card-body">

                            <table class='table-striped' id="system_notofication_table" data-toggle="table"
                                data-url="<?= base_url('admin/orders/get-order-tracking') ?>"
                                data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                                data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                                data-sort-order="desc" data-mobile-responsive="true" data-toolbar=""
                                data-show-export="true" data-maintain-selected="true"
                                data-export-types='["txt","excel","csv"]' data-export-options='{
                        "fileName": "order-tracking-list",
                                    "ignoreColumn": ["state"] 
                                    }' data-query-params="customer_wallet_query_params">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true" data-align='center'>ID</th>
                                        <th data-field="order_id" data-sortable="true" data-align='center'>Order ID</th>
                                        <th data-field="order_item_id" data-sortable="false" data-align='center'>Order
                                            Item ID</th>
                                        <th data-field="courier_agency" data-sortable="false" data-align='center'>
                                            Courier agency</th>
                                        <th data-field="tracking_id" data-sortable="false" data-align='center'>Tracking
                                            Id</th>
                                        <th data-field="url" data-sortable="false" data-align='center'>URL</th>
                                        <th data-field="date" data-sortable="false" data-align='center'>Date</th>
                                        <th data-field="operate" data-sortable="false" data-align='center'>Actions</th>
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