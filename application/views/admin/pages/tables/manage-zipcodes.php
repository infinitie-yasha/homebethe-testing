<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
<div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">

        <!-- Mobile View -->
        <div class="d-flex flex-column text-center d-sm-none py-2">
            <h2 class="page-title fs-5 fw-semibold mb-1">Manage Zipcodes</h2>
            <nav class="breadcrumb breadcrumb-arrows small justify-content-start mb-0">
                <a href="<?= base_url('admin/home') ?>" class="breadcrumb-item">Home</a>
                <span class="breadcrumb-item">Location</span>
                <span class="breadcrumb-item active">Zipcodes</span>
            </nav>
        </div>

        <!-- Tablet & Desktop View -->
        <div class="row g-2 align-items-center d-none d-sm-flex">
            <div class="col">
                <h2 class="page-title mb-0">Manage Zipcodes</h2>
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
                        Zipcodes
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
                        <div
                            class="card-header d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">
                            <h3 class="card-title mb-0 d-flex align-items-center gap-2">
                                <i class="ti ti-world"></i> Zipcodes Details
                            </h3>

                            <a class="btn btn-primary btn-sm bg-primary-lt w-sm-auto text-center AddZipcodeBtn"
                                data-bs-toggle="offcanvas" data-bs-target="#addZipcode" role="button">
                                Add Zipcode
                            </a>
                        </div>


                        <div class="card-body">
                            <div id="zipcodeToolbar" x-data="bulkDelete({
                                url: '<?= base_url('admin/area/delete_zipcode_multi') ?>',
                                tableSelector: '#zipcode-table',
                                confirmTitle: 'Delete Selected Zipcodes',
                                confirmMessage: 'Are you sure you want to delete the selected zipcodes?',
                                confirmOkText: 'Yes, delete them!',
                                confirmCancelText: 'Cancel'
                            })">
                                <button @click="deleteSelected()" :disabled="isLoading"
                                    class="btn btn-danger bg-danger-lt">
                                    <i class="fa fa-trash mr-2" x-show="!isLoading"></i>
                                    <i class="fa fa-spinner fa-spin mr-2" x-show="isLoading"></i>
                                    <span x-text="isLoading ? 'Deleting...' : 'Delete Selected Zipcodes'"></span>
                                </button>
                            </div>
                            <table class='table-striped' id="zipcode-table" data-toggle="table"
                                data-url="<?= base_url('admin/area/view_zipcodes') ?>" data-click-to-select="true"
                                data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                                data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                                data-sort-order="desc" data-mobile-responsive="true" data-toolbar=""
                                data-show-export="true" data-maintain-selected="true"
                                data-export-types='["txt","excel","csv"]' data-export-options='{
                                    "fileName": "zipcode-list",
                                    "ignoreColumn": ["state"] 
                                    }' data-query-params="queryParams">
                                <thead>
                                    <tr>
                                        <th data-field="state" data-checkbox="true"></th>
                                        <th data-field="id" data-sortable="true">ID</th>
                                        <th data-field="zipcode" data-sortable="false">Zipcode</th>
                                        <th data-field="city_name" data-sortable="false">City Name</th>
                                        <th data-field="minimum_free_delivery_order_amount" data-sortable="false">
                                            Minimum Free Delivery Order Amount</th>
                                        <th data-field="delivery_charges" data-sortable="false">Delivery Charges</th>
                                        <th data-field="operate" data-sortable="false">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="offcanvas offcanvas-end offcanvas-medium" tabindex="-1" id="addZipcode"
                            aria-labelledby="addZipcodeLabel">
                            <div class="offcanvas-header">
                                <h2 class="offcanvas-title" id="addZipcodeLabel">Add Zipcode</h2>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <form x-data="ajaxForm({
                                            url: base_url + 'admin/area/add_zipcode',
                                            offcanvasId: 'addZipcode',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="add_zipcode_form">
                                <div class="offcanvas-body">
                                    <div>

                                        <input type="hidden" id="edit_zipcode" name="edit_zipcode">
                                        <input type="hidden" id="update_id" name="update_id" value="1">


                                        <div class="mb-3 row">
                                            <label class="col-12 col-md-4 col-form-label required" for="zipcode">Zipcode
                                            </label>
                                            <?php
                                            if (isset($shipping_method['city_wise_deliverability']) && $shipping_method['city_wise_deliverability'] == '1') { ?>
                                                <span class="form-hint"
                                                    title="You can enable Pincode wise deliverability from System -> store settings -> prodct deliverability ">(?)</span>
                                            <?php } ?>
                                            <div class="col">
                                                <input type="text" class="form-control" name="zipcode" id="zipcode"
                                                    placeholder="Zipcode" />
                                            </div>
                                        </div>

                                        <div x-data x-init="initTomSelect({
                                                    element: $refs.citySelect,
                                                    url: '<?= base_url('admin/area/get_cities') ?>',
                                                    placeholder: 'Search City...',
                                                    onItemAdd: openNewCityModal,
                                                    offcanvasId: 'addZipcode',
                                                    dataAttribute: 'data-city-id',
                                                    maxItems: 1,
                                                    preloadOptions: true
                                                })" class="mb-3 row">

                                            <label class="col-12 col-md-4 col-form-label required"
                                                for="citySelect">City</label>
                                            <div class="col">
                                                <select x-ref="citySelect" class="form-select" name="city"
                                                    id="citySelect"></select>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-12 col-md-4 col-form-label required"
                                                for="minimum_free_delivery_order_amount">Minimum Free Delivery Order
                                                Amount</label>
                                            <div class="col">
                                                <input type="number" class="form-control"
                                                    name="minimum_free_delivery_order_amount" min="0"
                                                    id="minimum_free_delivery_order_amount"
                                                    placeholder="Minimum Free Delivery Order Amount" />
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-3 col-form-label required" for="delivery_charges">Delivery
                                                Charges</label>
                                            <div class="col">
                                                <input type="number" class="form-control" name="delivery_charges"
                                                    min="0" id="delivery_charges" placeholder="Delivery Charges" />
                                            </div>
                                        </div>

                                    </div>
                                    <div class="text-end">
                                        <!-- <button type="reset" class="btn btn-warning ">Reset</button> -->
                                        <button type="button" class="btn" data-bs-dismiss="offcanvas"
                                            aria-label="Close">Close</button>
                                        <button type="submit" class="btn btn-primary save_zipcode_btn"
                                            id="submit_btn">Update Zipcode</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id='AddCityModal'>
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title city_title">Add City</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <form x-data="ajaxForm({
                                            url: base_url + 'admin/area/add_city',
                                            modalId: 'AddCityModal',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="add_city_form">
                                        <div class="modal-body p-0">

                                            <input type="hidden" id="edit_city" name="edit_city">
                                            <input type="hidden" id="update_id" name="update_id" value="1">
                                            <input type="hidden" id="city_name_hidden" name="city_name">

                                            <div class="card-body">

                                                <div class="mb-3 row">
                                                    <label class="col-3 col-form-label required" for="city_name">City
                                                        Name </label>
                                                    <div class="col">
                                                        <input type="text" class="form-control" name="city_name"
                                                            id="city_name" placeholder="City Name" />
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-3 col-form-label required"
                                                        for="minimum_free_delivery_order_amount">Minimum Free Delivery
                                                        Order Amount</label>
                                                    <div class="col">
                                                        <input type="number" class="form-control"
                                                            name="minimum_free_delivery_order_amount" min="0"
                                                            id="minimum_free_delivery_order_amount"
                                                            placeholder="Minimum Free Delivery Order Amount" />
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-3 col-form-label required"
                                                        for="delivery_charges">Delivery Charges</label>
                                                    <div class="col">
                                                        <input type="number" class="form-control"
                                                            name="delivery_charges" id="delivery_charges" min="0"
                                                            placeholder="Delivery Charges" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="reset" class="btn btn-warning">Reset</button>
                                            <button type="submit" class="btn btn-primary save_city_btn"
                                                id="submit_btn">Add City</button>
                                            <button type="button" class="btn " data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>