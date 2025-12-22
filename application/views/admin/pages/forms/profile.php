<div class="page-wrapper">
    <!-- BEGIN PAGE HEADER -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        Settings
                    </div>
                    <h2 class="page-title">
                        Account Settings
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="<?= base_url('admin/home') ?>" class="btn btn-white">
                            <i class="ti ti-arrow-left me-2"></i>
                            Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE HEADER -->

    <!-- BEGIN PAGE BODY -->
    <div class="page-body">
        <div class="container-xl">
            <form x-data="ajaxForm({
                                            url: base_url + 'admin/login/update_user',
                                            modalId: '',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="update_user_form">
                <input type="hidden" name="old_profile_image" value="<?= $users->image ?>">

                <!-- Profile Overview Card -->
                <div class="row row-deck row-cards mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="ti ti-user-circle me-2"></i>
                                    Profile Overview
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <!-- Profile Image and Info -->
                                    <div class="col-12 col-md-4 text-center mb-3 mb-md-0">
                                        <?php if (!empty($users->image)) { ?>
                                            <img class="avatar avatar-2xl rounded-circle mb-2"
                                                src="<?= base_url($users->image) ?>"
                                                alt="<?= !empty($this->lang->line('profile_image')) ? str_replace('\\', '', $this->lang->line('profile_image')) : 'Profile Image' ?>">
                                        <?php } else { ?>
                                            <img class="avatar avatar-2xl rounded-circle mb-2"
                                                src="<?= base_url() . NO_USER_IMAGE ?>"
                                                alt="<?= !empty($this->lang->line('profile_image')) ? str_replace('\\', '', $this->lang->line('profile_image')) : 'Profile Image' ?>">
                                        <?php } ?>
                                        <h3 class="mb-1"><?= $users->username ?></h3>
                                        <p class="text-secondary mb-0">
                                            <?= $identity_column == 'email' ? $users->email : $users->mobile ?>
                                        </p>
                                    </div>

                                    <!-- Change Avatar Input -->
                                    <div class="col-12 col-md-4 offset-md-0">
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Change Avatar</label>
                                            <input type="file" class="form-control" name="image" id="image"
                                                accept="image/*" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Personal Information Card -->
                <div class="row row-deck row-cards mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="ti ti-id me-2"></i>
                                    Personal Information
                                </h3>
                            </div>
                            <div class="card-body">
                                <p class="text-secondary mb-4">Update your personal details and contact information</p>
                                <div class="mb-3">
                                    <label class="col-form-label required" for="username">
                                        <i class="ti ti-user me-1"></i>
                                        Username
                                    </label>
                                    <input type="text" class="form-control" id="username"
                                        placeholder="Type Username here" name="username"
                                        value="<?= $users->username ?>">
                                </div>

                                <?php if ($identity_column == 'email') { ?>
                                    <div class="mb-3">
                                        <label for="email" class="col-form-label required">
                                            <i class="ti ti-mail me-1"></i>
                                            Email Address
                                        </label>
                                        <input type="text" class="form-control" id="email" placeholder="Type Email ID here"
                                            name="email" value="<?= $users->email ?>" disabled>
                                    </div>
                                <?php } else { ?>
                                    <div class="mb-3">
                                        <label for="mobile" class="col-form-label required">
                                            <i class="ti ti-phone me-1"></i>
                                            Mobile Number
                                        </label>
                                        <input type="text" class="form-control" maxlength="16"
                                            oninput="validateNumberInput(this)" id="mobile"
                                            placeholder="Type Mobile Number here" name="mobile"
                                            value="<?= $users->mobile ?>">
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <!-- Location Information Card -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="ti ti-map-pin me-2"></i>
                                    Location Details
                                </h3>
                            </div>
                            <div class="card-body">
                                <p class="text-secondary mb-4">Set your location and geographical coordinates</p>
                                <div class="mb-3">
                                    <label class="col-form-label required" for="address">
                                        <i class="ti ti-home me-1"></i>
                                        Address
                                    </label>
                                    <input type="text" class="form-control" id="address"
                                        placeholder="Add your address here" name="address"
                                        value="<?= $users->address ?>">
                                </div>

                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="col-form-label required" for="latitude">
                                                <i class="ti ti-compass me-1"></i>
                                                Latitude
                                            </label>
                                            <input type="text" class="form-control no-spinner" id="latitude"
                                                placeholder="Add latitude" name="latitude"
                                                value="<?= $users->latitude ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="col-form-label required" for="longitude">
                                                <i class="ti ti-compass me-1"></i>
                                                Longitude
                                            </label>
                                            <input type="text" class="form-control no-spinner" id="longitude"
                                                placeholder="Add longitude" name="longitude"
                                                value="<?= $users->longitude ?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security Card -->
                <div class="row row-deck row-cards mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="ti ti-shield-lock me-2"></i>
                                    Security Settings
                                </h3>
                            </div>
                            <div class="card-body">
                                <p class="text-secondary mb-4">Change your password to keep your account secure. Leave
                                    blank if you don't want to change it.</p>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="col-form-label" for="old">
                                                <i class="ti ti-lock me-1"></i>
                                                Old Password
                                            </label>
                                            <div class="input-group input-group-flat col">
                                                <input type="password" class="form-control" autocomplete="false"
                                                    placeholder="Enter Old Password" />
                                                <span class="input-group-text togglePassword" title="Show password"
                                                    data-bs-toggle="tooltip" style="cursor: pointer;">
                                                    <i class="ti ti-eye fs-3"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="col-form-label" for="new">
                                                <i class="ti ti-lock-open me-1"></i>
                                                New Password
                                            </label>
                                            <div class="input-group input-group-flat col">
                                                <input type="password" class="form-control" name="new" id="new"
                                                    autocomplete="false" placeholder="Enter New Password" />
                                                <span class="input-group-text togglePassword" title="Show password"
                                                    data-bs-toggle="tooltip" style="cursor: pointer;">
                                                    <i class="ti ti-eye fs-3"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="col-form-label" for="new_confirm">
                                                <i class="ti ti-lock-check me-1"></i>
                                                Confirm New Password
                                            </label>
                                            <div class="input-group input-group-flat col">
                                                <input type="password" class="form-control" name="new_confirm"
                                                    id="new_confirm" autocomplete="false"
                                                    placeholder="Confirm New Password" />
                                                <span class="input-group-text togglePassword" title="Show password"
                                                    data-bs-toggle="tooltip" style="cursor: pointer;">
                                                    <i class="ti ti-eye fs-3"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="alert alert-info mt-3" role="alert">
                                    <div class="d-flex">
                                        <div>
                                            <i class="ti ti-info-circle me-2"></i>
                                        </div>
                                        <div>
                                            <h4 class="alert-title">Password Requirements</h4>
                                            <div class="text-secondary">Make sure your password is at least 8 characters
                                                long and contains a mix of uppercase, lowercase, numbers, and special
                                                characters.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent">
                                <div class="btn-list justify-content-end">
                                    <button type="reset" class="btn">
                                        <i class="ti ti-x me-2"></i>
                                        Cancel
                                    </button>
                                    <button type="submit" class="btn btn-primary" id="submit_btn">
                                        <i class="ti ti-device-floppy me-2"></i>
                                        Update Profile
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END PAGE BODY -->
</div>