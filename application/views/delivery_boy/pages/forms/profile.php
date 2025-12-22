<div class="page-wrapper">
    <!-- BEGIN PAGE HEADER -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center d-flex justify-content-between flex-wrap">
                <!-- Page Title -->
                <div class="col-12 col-md text-truncate mb-2 mb-md-0">
                    <div class="page-pretitle">Settings</div>
                    <h2 class="page-title mb-0">Account Settings</h2>
                </div>

                <!-- Button -->
                <div class="col-12 col-md-auto">
                    <div class="btn-list d-flex justify-content-md-end justify-content-start flex-wrap gap-2">
                        <a href="<?= base_url('delivery-boy/home') ?>" class="btn btn-white">
                            <i class="ti ti-arrow-left me-2"></i> Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- END PAGE HEADER -->
    <div class="page-body">
        <div class="container-xl">
            <div class="row justify-content-center">

                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-header border-bottom-0 pb-0">
                        <h2 class="card-title mb-0">
                            <i class="ti ti-user-circle me-2 text-primary"></i> My Profile
                        </h2>
                    </div>

                    <div class="card-body pt-4">
                        <!-- Profile Form -->
                        <form class="form-submit-event" action="<?= base_url('delivery_boy/login/update_user') ?>"
                            method="POST" enctype="multipart/form-data">
                            <!-- Avatar Section -->
                            <div class="d-flex">
                                <div class="col-md-4 text-center">
                                    <div class="mb-3">
                                        <?php if (!empty($users->image)) { ?>
                                            <img class="avatar avatar-2xl rounded-circle"
                                                src="<?= base_url($users->image) ?>"
                                                alt="<?= !empty($this->lang->line('profile_image')) ? str_replace('\\', '', $this->lang->line('profile_image')) : 'Profile Image' ?>">
                                        <?php } else { ?>
                                            <img class="avatar avatar-2xl rounded-circle"
                                                src="<?= base_url() . NO_USER_IMAGE ?>"
                                                alt="<?= !empty($this->lang->line('profile_image')) ? str_replace('\\', '', $this->lang->line('profile_image')) : 'Profile Image' ?>">
                                        <?php } ?>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="mt-3">
                                        <label for="image" class="col-form-label" name="image" id="image">
                                            Change Avatar
                                        </label>
                                        <input type="file" class="form-control" name="image" id="image"
                                            accept="image/*" />
                                    </div>

                                </div>
                            </div>

                            <input type="hidden" name="old_profile_image" value="<?= rawurlencode($users->image) ?>">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
                                value="<?= $this->security->get_csrf_hash() ?>" class="csrf_token">

                            <!-- Account Info -->
                            <h3 class="card-title mt-3 mb-2 text-primary">Account Information</h3>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label required" for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username"
                                        value="<?= htmlspecialchars($users->username) ?>" placeholder="Enter username">
                                </div>
                                <?php if ($identity_column == 'email') { ?>
                                    <div class="col-md-6">
                                        <label class="form-label required" for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="<?= htmlspecialchars($users->email) ?>" placeholder="Enter email"
                                            readonly>
                                    </div>
                                <?php } else { ?>
                                    <div class="col-md-6">
                                        <label class="form-label required" for="mobile">Mobile</label>
                                        <input type="number" maxlength="16" oninput="validateNumberInput(this)"
                                            class="form-control" id="mobile" name="mobile"
                                            value="<?= htmlspecialchars($users->mobile) ?>"
                                            placeholder="Enter mobile number" readonly>
                                    </div>
                                <?php } ?>
                            </div>

                            <!-- Password Update -->
                            <h3 class="card-title mt-5 mb-2 text-primary">Change Password</h3>
                            <p class="text-muted small mb-3">Leave fields blank if you don’t want to change your
                                password.</p>

                            <div class="row g-3">
                                <div class="col-12 col-sm-12 col-md-4">
                                    <label class="form-label" for="old">Old Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control passwordToggle" name="old" id="old"
                                            placeholder="Old password">
                                        <span class="input-group-text togglePassword cursor-pointer"><i
                                                class="ti ti-eye"></i></span>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-4">
                                    <label class="form-label" for="new">New Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control passwordToggle" name="new" id="new"
                                            placeholder="New password">
                                        <span class="input-group-text togglePassword cursor-pointer"><i
                                                class="ti ti-eye"></i></span>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-4">
                                    <label class="form-label" for="new_confirm">Confirm New Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control passwordToggle" name="new_confirm"
                                            id="new_confirm" placeholder="Confirm password">
                                        <span class="input-group-text togglePassword cursor-pointer"><i
                                                class="ti ti-eye"></i></span>
                                    </div>
                                </div>
                            </div>


                            <!-- Buttons -->
                            <div class="mt-5 d-flex justify-content-end gap-2">
                                <button type="reset" class="btn btn-outline-warning">
                                    <i class="ti ti-refresh me-1"></i> Reset
                                </button>
                                <button type="submit" class="btn btn-primary" id="submit_btn">
                                    <i class="ti ti-device-floppy me-1"></i> Update Profile
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>