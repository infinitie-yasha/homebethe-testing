<!-- Updated Tabler UI version of Manage Pickup Location Page with Offcanvas -->

<div class="page-wrapper">
    <div class="page">

        <!-- Page Header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title text-capitalize">Manage Pickup Location</h2>
                    </div>



                    <div class="col-auto d-print-none">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-arrows">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin/home') ?>">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Pickup Location</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Body -->
        <section class="page-body">
            <div class="container-xl">
                <div class="row g-3">

                    <!-- Table Card -->
                    <div class="col-12">
                        <div class="card p-3">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3 class="card-title"><i class="ti ti-user-circle"></i> pick up location Detail</h3>
                                <div>
                                    <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas"
                                        data-bs-target="#pickupLocationOffcanvas">
                                        <i class="ti ti-plus"></i> Add Pickup Location
                                    </button>
                                </div>
                            </div>
                        <div class="card-body">


                            <table class='table-striped' data-toggle="table"
                                data-url="<?= base_url('seller/pickup_location/view_pickup_location') ?>"
                                data-pagination="true" data-page-list="[5,10,20,50,100]" data-search="true"
                                data-side-pagination="server" data-sort-name="id" data-sort-order="desc"
                                data-mobile-responsive="true" data-show-export="true"
                                data-export-types='["txt","excel"]'
                                data-export-options='{"fileName": "pickup_location_list","ignoreColumn": ["operate"]}'>
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true">ID</th>
                                        <th data-field="pickup_location" data-sortable="true">Pickup Location</th>
                                        <th data-field="name" data-sortable="true">Name</th>
                                        <th data-field="email" data-sortable="true">Email</th>
                                        <th data-field="phone" data-sortable="true">Phone</th>
                                        <th data-field="address">Address</th>
                                        <th data-field="address2">Address 2</th>
                                        <th data-field="city" data-sortable="true">City</th>
                                        <th data-field="pin_code" data-sortable="true">Pincode</th>
                                        <th data-field="status" data-sortable="true">Status</th>
                                    </tr>
                                </thead>
                            </table>

                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
</div>

<!-- Offcanvas Form -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="pickupLocationOffcanvas"
    aria-labelledby="pickupLocationOffcanvasLabel" style="width: 600px;">
    <div class="offcanvas-header">
        <h3 class="offcanvas-title" id="pickupLocationOffcanvasLabel">
            <span id="offcanvasFormTitle">Add Pickup Location</span>
        </h3>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body overflow-hidden">
        <form class="form-submit-event" method="POST"
            action="<?= base_url('seller/pickup_location/add_pickup_location'); ?>" enctype="multipart/form-data">

            <?php if (isset($fetched_data[0]['id'])): ?>
                <input type="hidden" name="edit_pickup_location" value="<?= $fetched_data[0]['id'] ?>">
                <input type="hidden" name="update_id" value="1">
            <?php endif; ?>

            <input type="hidden" name="csrf_token" value="$csrf_token()">

            <div class="row g-3">

                <div class="col-12">
                    <label class="form-label">Pickup Location <span class="text-danger">*</span></label>
                    <input type="text" name="pickup_location" class="form-control" placeholder="Nickname (max 36 chars)"
                        value="<?= @$fetched_data[0]['pickup_location'] ?>">
                </div>

                <div class="col-12">
                    <label class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="Shipper's name"
                        value="<?= @$fetched_data[0]['name'] ?>">
                </div>

                <div class="col-12">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" placeholder="Shipper's email"
                        value="<?= @$fetched_data[0]['email'] ?>">
                </div>

                <div class="col-12">
                    <label class="form-label">Phone <span class="text-danger">*</span></label>
                    <input type="text" name="phone" class="form-control" placeholder="Phone number"
                        value="<?= @$fetched_data[0]['phone'] ?>">
                </div>

                <div class="col-12">
                    <label class="form-label">City <span class="text-danger">*</span></label>
                    <input type="text" name="city" class="form-control" placeholder="City"
                        value="<?= @$fetched_data[0]['city'] ?>">
                </div>

                <div class="col-12">
                    <label class="form-label">State <span class="text-danger">*</span></label>
                    <input type="text" name="state" class="form-control" placeholder="State"
                        value="<?= @$fetched_data[0]['state'] ?>">
                </div>

                <div class="col-12">
                    <label class="form-label">Country <span class="text-danger">*</span></label>
                    <input type="text" name="country" class="form-control" placeholder="Country"
                        value="<?= @$fetched_data[0]['country'] ?>">
                </div>

                <div class="col-12">
                    <label class="form-label">Pincode <span class="text-danger">*</span></label>
                    <input type="text" name="pincode" class="form-control" placeholder="Pincode"
                        value="<?= @$fetched_data[0]['pin_code'] ?>">
                </div>

                <div class="col-12">
                    <label class="form-label">Address <span class="text-danger">*</span></label>
                    <textarea name="address" class="form-control" rows="3"
                        placeholder="Primary address (max 80 chars)"><?= @$fetched_data[0]['address'] ?></textarea>
                </div>

                <div class="col-12">
                    <label class="form-label">Address 2</label>
                    <textarea name="address2" class="form-control" rows="3"
                        placeholder="Additional address details"><?= @$fetched_data[0]['address_2'] ?></textarea>
                </div>

                <div class="col-12">
                    <label class="form-label">Latitude</label>
                    <input type="text" name="latitude" class="form-control" placeholder="Latitude"
                        value="<?= @$fetched_data[0]['latitude'] ?>">
                </div>

                <div class="col-12">
                    <label class="form-label">Longitude</label>
                    <input type="text" name="longitude" class="form-control" placeholder="Longitude"
                        value="<?= @$fetched_data[0]['longitude'] ?>">
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="reset" class="btn btn-outline-secondary flex-fill">Reset</button>
                <button type="submit" id="submit_btn" class="btn btn-primary flex-fill">
                    <?= isset($fetched_data[0]['id']) ? 'Update Location' : 'Add Location' ?>
                </button>
            </div>

        </form>
    </div>
</div>