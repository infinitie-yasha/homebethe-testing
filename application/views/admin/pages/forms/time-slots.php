<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
     <div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">

        <!-- Mobile View -->
        <div class="d-flex flex-column text-center d-sm-none py-2">
            <h2 class="page-title fs-5 fw-semibold mb-1">Time Slots Settings</h2>
            <nav class="breadcrumb breadcrumb-arrows small justify-content-start mb-0">
                <a href="<?= base_url('admin/home') ?>" class="breadcrumb-item">Home</a>
                <span class="breadcrumb-item">System</span>
                <span class="breadcrumb-item active">Time Slots</span>
            </nav>
        </div>

        <!-- Tablet & Desktop View -->
        <div class="row g-2 align-items-center d-none d-sm-flex">
            <div class="col">
                <h2 class="page-title mb-0">Time Slots Settings</h2>
            </div>
            <div class="col-auto ms-auto">
                <ol class="breadcrumb breadcrumb-arrows mb-0 small">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('admin/home') ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#">System Settings</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Time Slots
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
                        <!-- Header -->
                        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                            <h3 class="card-title mb-0 d-flex align-items-center gap-2">
                                <i class="ti ti-calendar"></i> Time Slots Settings
                            </h3>
                            <button type="button"
                                class="btn btn-primary bg-primary-lt btn-sm add-slot-btn  w-sm-auto"
                                data-bs-toggle="offcanvas" data-bs-target="#addEditTimeSlot">
                                <i class="ti ti-plus me-1"></i> Add Time Slot
                            </button>
                        </div>

                        <div class="card-body">
                            <form x-data="ajaxForm({
                url: base_url + 'admin/Time_slots/update_time_slots_config',
                modalId: '',
                loaderText: 'Saving...'
            })" method="POST" id="update_time_slots_config_form" enctype="multipart/form-data">

                                <!-- Hidden Config ID -->
                                <input type="hidden" id="time_slot_config" name="time_slot_config" required value="1">

                                <!-- Enable / Disable Time Slots -->
                                <div class="mb-3 row">
                                    <label class="col-12 col-md-3 col-form-label" for="is_time_slots_enabled">
                                        Time Slots <small>[Enable / Disable]</small>
                                    </label>
                                    <div class="col-12 col-md-9 col-form-label">
                                        <label class="form-check form-switch form-switch-3">
                                            <input type="hidden" name="is_time_slots_enabled" value="0">
                                            <input class="form-check-input" name="is_time_slots_enabled" type="checkbox"
                                                value="1" <?= (!empty($settings['is_time_slots_enabled']) && $settings['is_time_slots_enabled'] == '1') ? 'checked' : '' ?>>
                                        </label>
                                    </div>
                                </div>

                                <!-- Delivery Starts From -->
                                <div class="mb-3 row">
                                    <label class="col-12 col-md-3 col-form-label required" for="delivery_starts_from">
                                        Delivery Starts From?
                                    </label>
                                    <div class="col-12 col-md-9">
                                        <select class="form-select" name="delivery_starts_from"
                                            id="delivery_starts_from" required>
                                            <option value="">Select</option>
                                            <?php foreach ([1 => 'Today', 2 => 'Tomorrow', 3 => 'Third Day', 4 => 'Fourth Day', 5 => 'Fifth Day', 6 => 'Sixth Day', 7 => 'Seventh Day'] as $val => $label): ?>
                                                <option value="<?= $val ?>"
                                                    <?= (!empty($time_slot_config['delivery_starts_from']) && $time_slot_config['delivery_starts_from'] == $val) ? 'selected' : '' ?>>
                                                    <?= $label ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Allowed Days -->
                                <div class="mb-3 row">
                                    <label class="col-12 col-md-3 col-form-label required" for="allowed_days">
                                        How many days you want to allow?
                                    </label>
                                    <div class="col-12 col-md-9">
                                        <select class="form-select" name="allowed_days" id="allowed_days" required>
                                            <option value="">Select</option>
                                            <?php foreach ([1, 7, 15, 30] as $d): ?>
                                                <option value="<?= $d ?>" <?= (!empty($time_slot_config['allowed_days']) && $time_slot_config['allowed_days'] == $d) ? 'selected' : '' ?>>
                                                    <?= $d ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Submit Buttons -->
                                <div class="mt-4">
                                    <div class="row g-2 justify-content-end">
                                        <div class="col-12 col-sm-auto">
                                            <button type="reset" class="btn w-100 w-sm-auto">Cancel</button>
                                        </div>
                                        <div class="col-12 col-sm-auto">
                                            <button type="submit" class="btn btn-primary w-100 w-sm-auto"
                                                id="submit_btn">
                                                Save Settings <i class="ms-2 ti ti-arrow-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>

                    <!-- offcanvas for the add/update time sloate -->

                    <!-- Time Slot Offcanvas -->
                    <div class="offcanvas offcanvas-end offcanvas-medium" tabindex="-1" id="addEditTimeSlot"
                        aria-labelledby="addEditTimeSlotLabel" aria-hidden="true">
                        <div class="offcanvas-header">
                            <h3 class="offcanvas-title" id="addEditTimeSlotLabel">
                                <span id="offcanvasTitle">Add Time Slot</span>
                            </h3>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>

                        <div class="offcanvas-body" style="overflow-y: auto; overflow-x: hidden;">
                            <form x-data="ajaxForm({
                                        url: base_url + 'admin/Time_slots/update_time_slots',
                                        modalId: '',
                                        loaderText: 'Saving...'
                                    })" method="POST" class="form-horizontal" id="update_time_slots_form"
                                enctype="multipart/form-data">

                                <!-- Hidden fields -->
                                <input type="hidden" id="edit_time_slot" name="edit_time_slot" value="">
                                <input type="hidden" id="add_time_slot" name="add_time_slot" value="1">

                                <!-- Title -->
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label" for="title">Title</label>
                                    <div class="col">
                                        <input type="text" class="form-control" name="title" id="title"
                                            placeholder="Morning 9AM to 12PM">
                                    </div>
                                </div>

                                <!-- From Time -->
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label" for="from_time">From Time</label>
                                    <div class="col">
                                        <input type="time" class="form-control" name="from_time" id="from_time"
                                            placeholder="09:00:00">
                                    </div>
                                </div>

                                <!-- To Time -->
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label" for="to_time">To Time</label>
                                    <div class="col">
                                        <input type="time" class="form-control" name="to_time" id="to_time"
                                            placeholder="12:00:00">
                                    </div>
                                </div>

                                <!-- Last Order Time -->
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label" for="last_order_time">Last Order Time</label>
                                    <div class="col">
                                        <input type="time" class="form-control" name="last_order_time"
                                            id="last_order_time" placeholder="11:00:00">
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label" for="status">Status</label>
                                    <div class="col">
                                        <select class="form-select" name="status" id="status">
                                            <option value="">Select</option>
                                            <option value="1">Active</option>
                                            <option value="0">Deactive</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Buttons -->
                                <div class="text-end">
                                    <!-- <button type="reset" class="btn btn-warning ">Reset</button> -->
                                    <button type="button" class="btn" data-bs-dismiss="offcanvas"
                                        aria-label="Close">Close</button>
                                    <button type="submit" class="btn btn-primary save_time_sloate_btn"
                                        id="submit_btn">add time slots</button>
                                </div>
                            </form>
                        </div>
                    </div>



                </div>
                <div class="card mt-3">
                    <div class="col-md-12 main-content">
                        <div class="card content-area p-4">
                            <div class="card-innr">
                                <div class="gaps-1-5x"></div>
                                <table class='table-striped' id="timeSloat" data-toggle="table"
                                    data-url="<?= base_url('admin/Time_slots/view_time_slots') ?>"
                                    data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                                    data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true"
                                    data-show-columns="true" data-show-refresh="true" data-trim-on-search="false"
                                    data-sort-name="id" data-sort-order="desc" data-mobile-responsive="true"
                                    data-toolbar="" data-show-export="true" data-maintain-selected="true"
                                    data-export-types='["txt","excel"]' data-query-params="queryParams">
                                    <thead>
                                        <tr>
                                            <th data-field="id" data-sortable="true">ID</th>
                                            <th data-field="title" data-sortable="false">Title</th>
                                            <th data-field="from_time" data-sortable="true">From Time</th>
                                            <th data-field="to_time" data-sortable="true">To Time</th>
                                            <th data-field="last_order_time" data-sortable="true">Last Order Time</th>
                                            <th data-field="status" data-sortable="true">Status</th>
                                            <th data-field="operate" data-sortable="false">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div><!-- .card-innr -->
                        </div><!-- .card -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>