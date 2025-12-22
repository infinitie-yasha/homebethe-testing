<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">View Customer Address</h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="d-flex">
                            <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/home') ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/customer') ?>">Customer</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">Addresses</a>
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
                            <h3 class="card-title"><i class="ti ti-home"></i> Customer Address</h3>
                        </div>
                        <div class="card-body">
                            <input type='hidden' id='address_user_id'
                                value='<?= (isset($_GET['user_id']) && !empty($_GET['user_id'])) ? $_GET['user_id'] : '' ?>'>


                            <table class='table-striped' id="customer-address-table" data-toggle="table"
                                data-url="<?= base_url('admin/customer/get_address') ?>" data-click-to-select="true"
                                data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                                data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                                data-sort-order="desc" data-mobile-responsive="true" data-toolbar=""
                                data-show-export="true" data-maintain-selected="true"
                                data-export-types='["txt","excel"]' data-export-options='{
                            "fileName": "address-list",
                            "ignoreColumn": ["state"]
                            }' data-query-params="address_query_params">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true">Id</th>
                                        <th data-field="name" data-sortable="false">User Name</th>
                                        <th data-field="type" data-sortable="false">Type</th>
                                        <th data-field="mobile" data-sortable="false">mobile</th>
                                        <th data-field="alternate_mobile" data-sortable="false">Alternate mobile</th>
                                        <th data-field="address" data-sortable="false" data-visible="false">Address</th>
                                        <th data-field="landmark" data-sortable="false">Landmark</th>
                                        <th data-field="area" data-sortable="false">Area</th>
                                        <th data-field="city" data-sortable="false">City</th>
                                        <th data-field="state" data-sortable="false">State</th>
                                        <th data-field="pincode" data-sortable="false">Pincode</th>
                                        <th data-field="country" data-sortable="false">Country</th>
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