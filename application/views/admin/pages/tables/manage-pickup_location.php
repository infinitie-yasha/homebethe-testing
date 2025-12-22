<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
<div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">

        <!-- Mobile View -->
        <div class="d-flex flex-column text-center d-sm-none py-2">
            <h2 class="page-title fs-5 fw-semibold mb-1">Manage Pickup Location</h2>
            <nav class="breadcrumb breadcrumb-arrows small justify-content-start mb-0">
                <a href="<?= base_url('admin/home') ?>" class="breadcrumb-item">Home</a>
                <span class="breadcrumb-item active">Pickup Location</span>
            </nav>
        </div>

        <!-- Tablet & Desktop View -->
        <div class="row g-2 align-items-center d-none d-sm-flex">
            <div class="col">
                <h2 class="page-title mb-0">Manage Pickup Location</h2>
            </div>
            <div class="col-auto ms-auto">
                <ol class="breadcrumb breadcrumb-arrows mb-0 small">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('admin/home') ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Pickup Location
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
                                <i class="ti ti-truck-delivery"></i> Pickup Location Details
                            </h3>

                            <button type="button"
                                class="btn btn-primary bg-primary-lt btn-sm  w-sm-auto text-center"
                                data-bs-toggle="modal" data-bs-target="#verifyPickupLocations">
                                Need to verify the pickup Locations
                            </button>
                        </div>

                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="verified_status_filter" class="col-form-label">Filter By Verified Status</label>
                                    <select id="verified_status_filter" name="verified_status_filter" class="form-control">
                                        <option value="">All</option>
                                        <option value="1">Verified</option>
                                        <option value="0">Not Verified</option>
                                    </select>
                                </div>
                            </div>
                            <table class='table-striped' id="pickup_location_table" data-toggle="table"
                                data-url="<?= base_url('admin/pickup_location/view_pickup_location') ?>"
                                data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                                data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                                data-sort-order="desc" data-mobile-responsive="true" data-toolbar=""
                                data-show-export="true" data-maintain-selected="true"
                                data-query-params="pickup_location_query_params">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true">ID</th>
                                        <th data-field="seller_id" data-sortable="true">Seller ID</th>
                                        <th data-field="seller_name" data-sortable="true">Seller Name</th>
                                        <th data-field="pickup_location" data-sortable="true">Pickup Locations</th>
                                        <th data-field="name" data-sortable="true">Name</th>
                                        <th data-field="email" data-sortable="true" data-visible='false'>Email</th>
                                        <th data-field="phone" data-sortable="true" data-visible='false'>Phone</th>
                                        <th data-field="address">Address</th>
                                        <th data-field="address2" data-visible='false'>Address 2</th>
                                        <th data-field="city" data-sortable="true">City</th>
                                        <th data-field="pin_code" data-sortable="true">Pincode</th>
                                        <th data-field="verified">Verified</th>
                                        <th data-field="operate" data-sortable="false">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="editPickupLocation"
                            aria-labelledby="PickupLocationLabel">
                            <div class="offcanvas-header">
                                <h2 class="offcanvas-title" id="PickupLocationLabel">Update Pickup Location</h2>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>

                            <form x-data="ajaxForm({
                                        url: base_url + 'admin/pickup_location/add_pickup_location',
                                        offcanvasId: 'editPickupLocation',
                                        loaderText: 'Saving...'
                                    })" method="POST" class="form-horizontal" id="add_pickup_location_form">
                                <div class="offcanvas-body">
                                    <div>

                                        <input type="hidden" id="edit_pickup_location" name="edit_pickup_location">
                                        <input type="hidden" id="update_id" name="update_id" value="1">
                                        <input type="hidden" name="seller_id" id="seller_id">


                                        <div class="card-body">
                                            <div class="d-flex form-group gap-3 mb-3">
                                                <div class="col-md-6">
                                                    <label class="col-form-label required" for="pickup_location">Pickup
                                                        Location</label>
                                                    <div class="col">
                                                        <input type="text" class="form-control" name="pickup_location"
                                                            id="pickup_location_name"
                                                            placeholder="The nickname of the new pickup location. Max 36 characters."
                                                            value="" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="col-form-label required" for="name">Name</label>
                                                    <div class="col">
                                                        <input type="text" class="form-control" name="name" id="name"
                                                            placeholder="The shipper's name." value="" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex form-group gap-3 mb-3">
                                                <div class="col-md-6">
                                                    <label class="col-form-label required" for="email">Email</label>
                                                    <div class="col">
                                                        <input type="text" class="form-control" name="email" id="email"
                                                            placeholder="The shipper's email address." value="" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="col-form-label required" for="phone">Phone</label>
                                                    <div class="col">
                                                        <input type="number" class="form-control" name="phone"
                                                            id="phone" min="1" placeholder="Shipper's phone number."
                                                            value="" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex form-group gap-3 mb-3">
                                                <div class="col-md-6">
                                                    <label class="col-form-label required" for="city">City</label>
                                                    <div class="col">
                                                        <input type="text" class="form-control" name="city" id="city"
                                                            placeholder="Pickup location city name." value="" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="col-form-label required" for="state">State</label>
                                                    <div class="col">
                                                        <input type="text" class="form-control" name="state" id="state"
                                                            placeholder="Pickup location state name." value="" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex form-group gap-3 mb-3">
                                                <div class="col-md-6">
                                                    <label class="col-form-label required" for="country">Country</label>
                                                    <div class="col">
                                                        <input type="text" class="form-control" name="country"
                                                            id="country" placeholder="Pickup location country name."
                                                            value="" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="col-form-label required" for="state">Pincode</label>
                                                    <div class="col">
                                                        <input type="text" class="form-control" name="pincode"
                                                            id="pincode" placeholder="Pickup location pincode."
                                                            value="" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex form-group gap-3 mb-3">
                                                <div class="col-md-6">
                                                    <label class="col-form-label required" for="address">Address</label>
                                                    <div class="col">
                                                        <textarea name="address" id="address"
                                                            class="textarea form-control"
                                                            placeholder="Shipper's primary address. Max 80 characters."
                                                            rows="4"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="col-form-label required" for="address2">Address
                                                        2</label>
                                                    <div class="col">
                                                        <textarea name="address2" id="address2"
                                                            class="textarea form-control"
                                                            placeholder="Additional address details."
                                                            rows="4"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex form-group gap-3 mb-3">
                                                <div class="col-md-6">
                                                    <label class="col-form-label required"
                                                        for="latitude">Latitude</label>
                                                    <div class="col">
                                                        <input type="number" class="form-control" name="latitude"
                                                            id="latitude" placeholder="Pickup location latitude."
                                                            step="any" value="" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="col-form-label required"
                                                        for="longitude">Longitude</label>
                                                    <div class="col">
                                                        <input type="number" class="form-control" name="longitude"
                                                            id="longitude" placeholder="Pickup location longitude."
                                                            step="any" value="" />
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="text-end">
                                        <!-- <button type="reset" class="btn btn-warning bg-warning-lt reset_city_btn">Reset</button> -->
                                        <button type="submit" class="btn btn-primary" id="submit_btn">Update Pickup
                                            Location</button>
                                        <button type="button" class="btn btn-secondary bg-secondary-lt"
                                            data-bs-dismiss="offcanvas" aria-label="Close">Close</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="modal fade" id="verifyPickupLocations" tabindex="-1" role="dialog"
                            aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="myModalLabel">Need to verify the pickup Locations
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body ">
                                        <ol>
                                            <li> After adding the pickup location you need to verify the pickup location
                                                on shiprocket dashboard.</li>
                                            <li> Note: You can verify unverified pickup locations from <a
                                                    href="https://app.shiprocket.in/company-pickup-location?redirect_url="
                                                    target="_blank">shiprocket dashboard </a>. New number in pickup
                                                location has to be verified once, Later additions of pickup locations
                                                with a same number will not require verification.</li>
                                            <li> After verifying the pickup location in shiprocket, you need to verify
                                                that location in table.</li>
                                            <li> You will find Verified column in pickup location table in this page.
                                            </li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>