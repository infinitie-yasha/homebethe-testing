<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
     <div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">

        <!-- Mobile View -->
        <div class="d-flex flex-column text-center d-sm-none py-2">
            <h2 class="page-title fs-5 fw-semibold mb-1">Manage Cities</h2>
            <nav class="breadcrumb breadcrumb-arrows small justify-content-center mb-0">
                <a href="<?= base_url('admin/home') ?>" class="breadcrumb-item">Home</a>
                <span class="breadcrumb-item">Location</span>
                <span class="breadcrumb-item active">Cities</span>
            </nav>
        </div>

        <!-- Tablet & Desktop View -->
        <div class="row g-2 align-items-center d-none d-sm-flex">
            <div class="col">
                <h2 class="page-title mb-0">Manage Cities</h2>
            </div>
            <div class="col-auto ms-auto">
                <ol class="breadcrumb breadcrumb-arrows mb-0 small">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('admin/home') ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0)">Location</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Cities
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
                            <h3 class="card-title"><i class="ti ti-world"></i> City Details</h3>
                            <a class="btn btn-primary AddCityBtn btn-sm bg-primary-lt" data-bs-toggle="offcanvas"
                                href="#addCity" role="button" aria-controls="addCity"> Add City </a>
                        </div>
                        <div class="card-body">
                            <table class='table-striped' id="cities_table" data-toggle="table"
                                data-url="<?= base_url('admin/area/view_city') ?>" data-click-to-select="true"
                                data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                                data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                                data-sort-order="desc" data-mobile-responsive="true" data-toolbar=""
                                data-show-export="true" data-maintain-selected="true"
                                data-export-types='["txt","excel","csv"]' data-export-options='{
                                "fileName": "city-list",
                                "ignoreColumn": ["state"] 
                                }' data-query-params="queryParams">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true">ID</th>
                                        <th data-field="name" data-sortable="false">Name</th>
                                        <th data-field="minimum_free_delivery_order_amount" data-sortable="false">
                                            Minimum Free Delivery Order Amount</th>
                                        <th data-field="delivery_charges" data-sortable="false">Delivery Charges</th>
                                        <th data-field="operate" data-sortable="false">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="offcanvas offcanvas-end offcanvas-medium" tabindex="-1" id="addCity"
                            aria-labelledby="addCityLabel">
                            <div class="offcanvas-header">
                                <h2 class="offcanvas-title" id="addCityLabel">Add City</h2>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <form x-data="ajaxForm({
                                        url: base_url + 'admin/area/add_city',
                                        offcanvasId: 'addCity',
                                        loaderText: 'Saving...'
                                    })" method="POST" class="form-horizontal" id="add_city_form">
                                <div class="offcanvas-body">
                                    <div>

                                        <input type="hidden" id="edit_city" name="edit_city">
                                        <input type="hidden" id="update_id" name="update_id" value="1">
                                        <input type="hidden" id="city_name_hidden" name="city_name">

                                        <div class="card-body">

                                            <div class="mb-3 row">
                                                <label class="col-12 col-md-4 col-form-label required" for="city_name">City Name
                                                </label>
                                                <div class="col">
                                                    <input type="text" class="form-control" name="city_name"
                                                        id="city_name" placeholder="City Name" />
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <label class="col-12 col-md-4 col-form-label required"
                                                    for="minimum_free_delivery_order_amount">Minimum Free Delivery Order
                                                    Amount</label>
                                                <div class="col">
                                                    <input type="number" class="form-control"
                                                        name="minimum_free_delivery_order_amount"
                                                        id="minimum_free_delivery_order_amount" min="0"
                                                        placeholder="Minimum Free Delivery Order Amount" />
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label class="col-12 col-md-4 col-form-label required"
                                                    for="delivery_charges">Delivery Charges</label>
                                                <div class="col">
                                                    <input type="number" class="form-control" name="delivery_charges"
                                                        min="0" id="delivery_charges" placeholder="Delivery Charges" />
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="text-end">
                                        <!-- <button type="reset" class="btn btn-warning bg-warning-lt reset_city_btn">Reset</button> -->
                                        <button type="submit" class="btn btn-primary save_city_btn" id="submit_btn">Add
                                            City</button>
                                        <button type="button" class="btn btn-secondary bg-secondary-lt"
                                            data-bs-dismiss="offcanvas" aria-label="Close">Close</button>
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