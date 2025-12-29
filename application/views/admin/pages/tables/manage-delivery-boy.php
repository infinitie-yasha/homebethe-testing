<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row align-items-center g-2">
                    <!-- Page Title -->
                    <div class="col-12 col-md">
                        <h2 class="page-title mb-0">Manage Delivery Boy</h2>
                    </div>

                    <!-- Breadcrumb -->
                    <div class="col-12 col-md-auto mt-2 mt-md-0">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-arrows mb-0">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/home') ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Manage Delivery Boy
                                </li>
                            </ol>
                        </nav>
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
                            <h3 class="card-title"><i class="ti ti-user-circle"></i> Manage Delivery Boy</h3>
                            <a href="#" class="btn btn-primary addDeliveryBoyBtn btn-sm bg-primary-lt"
                                data-bs-toggle="offcanvas" data-bs-target="#addDeliveryBoy"
                                aria-controls="addDeliveryBoy">Add Delivery Boy</a>
                        </div>
                        <div class="card-body">
                            <div class="col-md-3">
                                <label for="delivery_boy_status_filter" class="col-form-label">Filter By Delivery Boy
                                    Status</label>
                                <select id="delivery_boy_status_filter" name="delivery_boy_status_filter"
                                    placeholder="Select Status" required="" class="form-control">
                                    <option value="">All</option>
                                    <option value="approved">Approved</option>
                                    <option value="not_approved">Not Approved</option>
                                </select>
                            </div>
                            <table class='table-striped' id="delivery_boy_data" data-toggle="table"
                                data-url="<?= base_url('admin/delivery_boys/view_delivery_boys') ?>"
                                data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                                data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                                data-sort-order="desc" data-mobile-responsive="true" data-toolbar=""
                                data-show-export="true" data-maintain-selected="true"
                                data-export-types='["txt","excel"]' data-export-options='{
                            "fileName": "promocode-list",
                            "ignoreColumn": ["state"]
                            }' data-query-params="delivery_boy_status_params">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true">ID</th>
                                        <th data-field="name" data-sortable="false">Name</th>
                                        <th data-field="email" data-sortable="false">Email</th>
                                        <th data-field="mobile" data-sortable="true">Mobile No</th>
                                        <th data-field="address" data-sortable="false" data-visible='false'>Address</th>
                                        <th data-field="bonus_type" data-sortable="false">Bonus Type</th>
                                        <th data-field="bonus" data-sortable="false">Bonus</th>
                                        <!-- <th data-field="bonus_amount" data-visible="false" data-sortable="false">
                                            Bonus Amount(<?= $currency ?>)</th> -->
                                        <th data-field="balance" data-sortable="true">Balance(<?= $currency ?>)</th>
                                        <th data-field="status" data-sortable="true">Status</th>
                                        <th data-field="date" data-sortable="true" data-visible='false'>Date</th>
                                        <th data-field="operate" data-sortable="false">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="offcanvas offcanvas-end offcanvas-medium" tabindex="-1" id="addDeliveryBoy"
                            aria-labelledby="addDeliveryBoyLabel">
                            <div class="offcanvas-header">
                                <h2 class="offcanvas-title" id="addDeliveryBoyLabel">Add Delivery Boy</h2>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>

                            <form x-data="ajaxForm({
                                            url: base_url + 'admin/delivery_boys/add_delivery_boy',
                                            offcanvasId: 'addDeliveryBoy',
                                            isLoading: true,
                                            loaderText: 'Saving...',
                                          
                                        })"method="POST" class="form-horizontal" id="add_delivery_boy_form">
                                <div class="offcanvas-body">
                                    <div>
                                        <div class="card-body">
                                            <input type="hidden" name="edit_delivery_boy" class="edit_delivery_boy"
                                                value="">
                                            <div class="mb-3 row">
                                                <label class="col-12 col-md-2 col-form-label required"
                                                    for="name">Name</label>
                                                <div class="col">
                                                    <input type="text" class="form-control" name="name" id="name"
                                                        placeholder="Delivery Boy Name" />
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label class="col-12 col-md-2 col-form-label required"
                                                    for="mobile">Mobile</label>
                                                <div class="col">
                                                    <input type="text" class="form-control" name="mobile" id="mobile"
                                                        placeholder="Enter Mobile" maxlength="16"
                                                        oninput="validateNumberInput(this)" />
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <label class="col-12 col-md-2 col-form-label required"
                                                    for="email">Email</label>
                                                <div class="col">
                                                    <input type="text" class="form-control" name="email" id="email"
                                                        placeholder="Enter Email" />
                                                </div>
                                            </div>

                                            <!-- Password -->
                                            <div class="mb-3 row">
                                                <label class="col-12 col-md-2 col-form-label required"
                                                    for="password">Password</label>
                                                <div class="col-12 col-md-10">
                                                    <div class="input-group input-group-flat">
                                                        <input type="password" class="form-control passwordToggle"
                                                            name="password" id="password"
                                                            value="<?= @$fetched_data[0]['username'] ?>"
                                                            placeholder="Type Password here">
                                                        <span class="input-group-text togglePassword"
                                                            title="Show password" data-bs-toggle="tooltip"
                                                            style="cursor:pointer;">
                                                            <i class="ti ti-eye fs-3"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Confirm Password -->
                                            <div class="mb-3 row">
                                                <label class="col-12 col-md-2 col-form-label required"
                                                    for="confirm_password">Confirm Password</label>
                                                <div class="col-12 col-md-10">
                                                    <div class="input-group input-group-flat">
                                                        <input type="password" class="form-control passwordToggle"
                                                            name="confirm_password" id="confirm_password"
                                                            placeholder="Type Confirm Password here">
                                                        <span class="input-group-text togglePassword"
                                                            title="Show password" data-bs-toggle="tooltip"
                                                            style="cursor:pointer;">
                                                            <i class="ti ti-eye fs-3"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="mb-3 row">
                                                <label class="col-12 col-md-2 col-form-label required"
                                                    for="address">Address</label>
                                                <div class="col">
                                                    <input type="text" class="form-control" name="address" id="address"
                                                        placeholder="Enter Address" />
                                                </div>
                                            </div>

                                            <?php
                                            $bonus_type = ['fixed_amount_per_order_item', 'percentage_per_order_item'];
                                            ?>
                                            <div class="mb-3 row">
                                                <label class="col-12 col-md-2 col-form-label required"
                                                    for="bonus_type">Bonus
                                                    Types</label>
                                                <div class="col">
                                                    <select name="bonus_type" id="bonus_type"
                                                        class="form-control bonus_type">
                                                        <option value=" ">Select Types</option>
                                                        <option value="<?= 'fixed_amount_per_order_item' ?>"
                                                            <?= (isset($fetched_data[0]['id']) && $fetched_data[0]['bonus_type'] == 'fixed_amount_per_order_item') ? "Selected" : "" ?>>
                                                            Fixed amount per Parcel</option>
                                                        <option value="<?= 'percentage_per_order_item' ?>"
                                                            <?= (isset($fetched_data[0]['id']) && $fetched_data[0]['bonus_type'] == 'percentage_per_order_item') ? "Selected" : "" ?>>
                                                            Percentage per Parcel</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div
                                                class="mb-3 row fixed_amount_per_order <?= (isset($fetched_data[0]['id']) && $fetched_data[0]['bonus_type'] == 'fixed_amount_per_order_item') ? '' : 'd-none' ?>">
                                                <label class="col-12 col-md-2 col-form-label required"
                                                    for="bonus_amount">Amount</label>
                                                <div class="col">
                                                    <input type="number" class="form-control" name="bonus_amount"
                                                        min="0" id="bonus_amount"
                                                        placeholder="Enter amount to be given to the delivery boy on successful parcel delivery" />
                                                </div>
                                            </div>

                                            <div
                                                class="mb-3 row percentage_per_order <?= (isset($fetched_data[0]['id']) && $fetched_data[0]['bonus_type'] == 'percentage_per_order_item') ? '' : 'd-none' ?>">
                                                <label class="col-12 col-md-2 col-form-label required"
                                                    for="bonus_percentage">Bonus(%)
                                                </label>
                                                <div class="col">
                                                    <input type="number" min="1" class="form-control"
                                                        name="bonus_percentage" id="bonus_percentage" min="0" max="100"
                                                        placeholder="Enter Bonus(%) to be given to the delivery boy on successful parcel delivery" />
                                                </div>
                                            </div>

                                            <?php if ((isset($shipping_method['pincode_wise_deliverability']) && $shipping_method['pincode_wise_deliverability'] == 1) || (isset($shipping_method['local_shipping_method']) && isset($shipping_method['shiprocket_shipping_method']) && $shipping_method['local_shipping_method'] == 1 && $shipping_method['shiprocket_shipping_method'] == 1)) { ?>

                                                <div x-data x-init="initTomSelect({
                                                    element: $refs.zipCodeSelect,
                                                    url: '/admin/area/get_zipcodes',
                                                    placeholder: 'Search Zipcode...',
                                                    onItemAdd: openNewZipcodeModal,
                                                    offcanvasId: 'addDeliveryBoy',
                                                    dataAttribute: 'data-zipcode-ids',
                                                    maxItems: 20, 
                                                    preloadOptions: true
                                                })" class="mb-3 row">

                                                    <label class="col-12 col-md-2 col-form-label required"
                                                        for="zipCodeSelect">Serviceable
                                                        Zipcode</label>
                                                    <div class="col">
                                                        <select x-ref="zipCodeSelect" class="form-select"
                                                            name="serviceable_zipcodes[]" id="zipCodeSelect"></select>
                                                    </div>
                                                </div>

                                            <?php }
                                            if (isset($shipping_method['city_wise_deliverability']) && $shipping_method['city_wise_deliverability'] == 1 && $shipping_method['shiprocket_shipping_method'] != 1) { ?>

                                                <div x-data x-init="initTomSelect({
                                                    element: $refs.citySelect,
                                                    url: '<?= base_url('admin/area/get_cities') ?>',
                                                    placeholder: 'Search City...',
                                                    onItemAdd: openNewCityModal,
                                                    offcanvasId: 'addDeliveryBoy',
                                                    dataAttribute: 'data-city-id',
                                                    preloadOptions: true
                                                })" class="mb-3 row">

                                                    <label class="col-12 col-md-2 col-form-label required"
                                                        for="citySelect">City</label>
                                                    <div class="col">
                                                        <select x-ref="citySelect" class="form-select"
                                                            name="serviceable_cities[]" id="citySelect"></select>
                                                    </div>
                                                </div>


                                            <?php } ?>

                                            <div class="mb-3 row">
                                                <label class="col-12 col-md-2 col-form-label required"
                                                    for="driving_license">Driving
                                                    License</label>
                                                <div class="col">
                                                    <?php if (isset($fetched_data[0]['driving_license']) && !empty($fetched_data[0]['driving_license'])) { ?>
                                                        <small class="form-hint">*Leave blank if there is no
                                                            change</small>
                                                    <?php } else { ?>
                                                        <small class="form-hint">*Add Driving License's front and back
                                                            image(select multiple)</small>
                                                    <?php } ?>
                                                    <input type="file" class="form-control file_upload_height"
                                                        name="driving_license[]" id="driving_license" accept="image/*"
                                                        multiple />
                                                    <!-- Image preview shown on edit -->
                                                    <div id="driving_license_preview"></div>
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <?php
                                                if (isset($fetched_data[0]['driving_license']) && !empty($fetched_data[0]['driving_license'])) {
                                                    $images = explode(",", $fetched_data[0]['driving_license']);

                                                    foreach ($images as $row) { ?>
                                                        <label class="col-sm-3 col-form-label"></label>
                                                        <div class="mx-auto col-sm-9 driving-license-image">
                                                            <a href="<?= base_url($row); ?>" data-toggle="lightbox"
                                                                data-gallery="gallery_seller">
                                                                <img src="<?= base_url($row); ?>" class="img-fluid rounded">
                                                            </a>
                                                        </div>
                                                        <?php
                                                    }
                                                } ?>
                                            </div>

                                            <div class="mb-3 row">
                                                <label class="col-12 col-md-2 col-form-label required"
                                                    for="status">Status</label>

                                                <div class="col-12 col-md-10">
                                                    <div id="status" class="d-flex flex-column flex-sm-row gap-2">

                                                        <label
                                                            class="btn btn-danger bg-danger-lt d-flex align-items-center">
                                                            <input type="radio" name="status" value="0" class="me-2"
                                                                <?= (isset($fetched_data[0]['status']) && $fetched_data[0]['status'] == '0') ? 'checked' : '' ?>>
                                                            Not Approved
                                                        </label>

                                                        <label
                                                            class="btn btn-primary bg-primary-lt d-flex align-items-center">
                                                            <input type="radio" name="status" value="1" class="me-2"
                                                                <?= (isset($fetched_data[0]['status']) && $fetched_data[0]['status'] == '1') ? 'checked' : '' ?>>
                                                            Approved
                                                        </label>

                                                    </div>
                                                </div>
                                            </div>



                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <!-- <button type="reset" class="btn btn-warning ">Reset</button> -->
                                        <button type="button" class="btn btn-secondary bg-secondary-lt"
                                            data-bs-dismiss="offcanvas">Close</button>
                                        <button type="submit" class="btn btn-primary save_delivery_boy"
                                            id="submit_btn_delivery_boy">Add
                                            Delivery Boy</button>

                                    </div>
                                </div>
                            </form>


                        </div>



                        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"
                            id='fund_transfer_delivery_boy'>
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Fund Transfer Delivery boy</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form x-data="ajaxForm({
                                        url: base_url + 'admin/fund_transfer/add-fund-transfer',
                                        modalId: 'fund_transfer_delivery_boy',
                                        loaderText: 'Saving...'
                                    })" method="POST" class="form-horizontal" id="add_fund_transfer_form">

                                        <div class="modal-body">
                                            <input type="hidden" name='delivery_boy_id'
                                                id="fund_transfer_delivery_boy_id">

                                            <div class="mb-3 row">
                                                <label class="col-12 col-md-2 col-form-label required"
                                                    for="fund_transfer_name">Name</label>
                                                <div class="col">
                                                    <input type="text" class="form-control" name="name"
                                                        id="fund_transfer_name" readonly />
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label class="col-12 col-md-2 col-form-label required"
                                                    for="fund_transfer_mobile">Mobile</label>
                                                <div class="col">
                                                    <input type="number" class="form-control" name="mobile"
                                                        id="fund_transfer_mobile" readonly />
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label class="col-12 col-md-2 col-form-label required"
                                                    for="balance">Balance</label>
                                                <div class="col">
                                                    <input type="number" class="form-control" name="balance" min="0"
                                                        id="balance" readonly />
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label class="col-12 col-md-2 col-form-label required"
                                                    for="transfer_amt">Transfer
                                                    Amount</label>
                                                <div class="col">
                                                    <input type="number" class="form-control" name="transfer_amt"
                                                        min="0" id="transfer_amt" />
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label class="col-12 col-md-2 col-form-label"
                                                    for="message">Message</label>
                                                <div class="col">
                                                    <input type="text" class="form-control" name="message"
                                                        id="message" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary"
                                                id="submit_btn_fund_transfer">Transfer Fund</button>
                                            <button type="button" class="btn" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>





                    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id='AddZipcodeModal'>
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title city_title">Add Zipcode</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <form x-data="ajaxForm({
                                            url: base_url + 'admin/area/add_zipcode',
                                            modalId: 'AddZipcodeModal',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="add_zipcode_form">

                                    <div class="modal-body">

                                        <input type="hidden" id="edit_city_zipcode" name="edit_city">
                                        <input type="hidden" id="update_id_zipcode" name="update_id" value="1">
                                        <!-- <input type="hidden" id="city_name_hidden" name="city_name"> -->

                                        <div class="card-body">

                                            <div class="mb-3 row">
                                                <label class="col-12 col-md-2 col-form-label required"
                                                    for="zipcode">Zipcode
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
                                                    onItemAdd: 'openNewCityModal',
                                                    switchModal: { from: '#AddZipcodeModal', to: '#AddCityModal' },  <!-- 👈 dynamic switching -->
                                                    preloadOptions: true
                                                })" class="mb-3 row">

                                                <label class="col-12 col-md-2 col-form-label required"
                                                    for="citySelect">City</label>
                                                <div class="col">
                                                    <select x-ref="citySelect" class="form-select" name="city"
                                                        id="citySelect"></select>
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <label class="col-12 col-md-2 col-form-label required"
                                                    for="minimum_free_delivery_order_amount_zipcode">Minimum Free
                                                    Delivery Order
                                                    Amount</label>
                                                <div class="col">
                                                    <input type="number" class="form-control"
                                                        name="minimum_free_delivery_order_amount" min="0"
                                                        id="minimum_free_delivery_order_amount_zipcode"
                                                        placeholder="Minimum Free Delivery Order Amount" />
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label class="col-12 col-md-2 col-form-label required"
                                                    for="delivery_charges_zipcode">Delivery Charges</label>
                                                <div class="col">
                                                    <input type="number" class="form-control" name="delivery_charges"
                                                        min="0" id="delivery_charges_zipcode"
                                                        placeholder="Delivery Charges" />
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="reset" class="btn btn-warning">Reset</button>
                                        <button type="submit" class="btn btn-primary save_city_btn"
                                            id="submit_btn_add_zipcode">Add Zipcode</button>
                                        <button type="button" class="btn " data-bs-dismiss="modal">Close</button>
                                    </div>
                                </form>

                            </div>
                        </div>
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
                                            loaderText: 'Saving...',
                                            switchModal: 'AddZipcodeModal',
                                           
                                        })" method="POST" class="form-horizontal" id="add_city_form">

                                    <div class="modal-body">

                                        <input type="hidden" id="edit_city_city" name="edit_city">
                                        <input type="hidden" id="update_id_city" name="update_id" value="1">
                                        <input type="hidden" id="city_name_hidden" name="city_name">

                                        <div class="card-body">

                                            <div class="mb-3 row">
                                                <label class="col-12 col-md-2 col-form-label required"
                                                    for="city_name">City
                                                    Name </label>
                                                <div class="col">
                                                    <input type="text" class="form-control" name="city_name"
                                                        id="city_name" placeholder="City Name" />
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label class="col-12 col-md-2 col-form-label required"
                                                    for="minimum_free_delivery_order_amount_city">Minimum Free Delivery
                                                    Order Amount</label>
                                                <div class="col">
                                                    <input type="number" class="form-control"
                                                        name="minimum_free_delivery_order_amount"
                                                        id="minimum_free_delivery_order_amount_city" min="0"
                                                        placeholder="Minimum Free Delivery Order Amount" />
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label class="col-12 col-md-2 col-form-label required"
                                                    for="delivery_charges_city">Delivery Charges</label>
                                                <div class="col">
                                                    <input type="number" class="form-control" name="delivery_charges"
                                                        min="0" id="delivery_charges_city"
                                                        placeholder="Delivery Charges" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="reset" class="btn btn-warning">Reset</button>
                                        <button type="submit" class="btn btn-primary save_city_btn"
                                            id="submit_btn_add_city">Add City</button>
                                        <button type="button" class="btn" data-bs-dismiss="modal">Close</button>
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