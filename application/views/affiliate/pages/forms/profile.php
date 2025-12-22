<div class="page-wrapper">
    <div class="container-xl">
        <!-- Page Header -->
        <div class="page-header d-print-none mb-4">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">Update Profile</h2>
                    <div class="text-muted mt-1">Manage your personal information and account settings</div>
                </div>
            </div>
        </div>

        <form action="<?= base_url('affiliate/login/update_user') ?>" id="profileform" method="POST" enctype="multipart/form-data">
            <!-- Profile Image Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <h3 class="card-title">Profile Image</h3>
                    <div class="row align-items-center">
                        <div class="col-md-4 text-center mb-3 mb-md-0">
                            <?php if (!empty($users->image)) { ?>
                                <img class="avatar avatar-xl rounded-circle" 
                                     src="<?= base_url($users->image) ?>" 
                                     alt="<?= !empty($this->lang->line('profile_image')) ? str_replace('\\', '', $this->lang->line('profile_image')) : 'Profile Image' ?>">
                            <?php } else { ?>
                                <img class="avatar avatar-xl rounded-circle" 
                                     src="<?= base_url() . NO_USER_IMAGE ?>" 
                                     alt="<?= !empty($this->lang->line('profile_image')) ? str_replace('\\', '', $this->lang->line('profile_image')) : 'Profile Image' ?>">
                            <?php } ?>
                        </div>
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="image" class="form-label">Change Avatar</label>
                                <input type="file" class="form-control" name="image" id="image" accept="image/*" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Personal Info Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <h3 class="card-title">Personal Information</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Username</label>
                                <input type="text" class="form-control" name="full_name" placeholder="Type Username here" value="<?= $fetched_data[0]['username'] ?? '' ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Mobile</label>
                                <input type="text" class="form-control" maxlength="16" oninput="validateNumberInput(this)" name="mobile" placeholder="Type Mobile Number here" value="<?= $fetched_data[0]['mobile'] ?? '' ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Enter Email" value="<?= $fetched_data[0]['email'] ?? '' ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Address</label>
                                <input type="text" class="form-control" name="address" placeholder="Add your address here" value="<?= $fetched_data[0]['address'] ?? '' ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Website & App Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <h3 class="card-title">Website & Mobile App</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Your Website</label>
                                <input type="url" class="form-control" name="my_website" placeholder="https://www.example.com/myblog" value="<?= $fetched_data[0]['website_url'] ?? '' ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Mobile App URL</label>
                                <input type="url" class="form-control" name="my_app" placeholder="https://xxxx/dp/xxxx" value="<?= $fetched_data[0]['mobile_app_url'] ?? '' ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Password Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <h3 class="card-title">Change Password</h3>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Old Password</label>
                                <div class="input-group input-group-flat">
                                    <input type="password" class="form-control" name="old" placeholder="Type Password here">
                                    <span class="input-group-text togglePassword" style="cursor: pointer;">
                                        <i class="ti ti-eye"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <div class="input-group input-group-flat">
                                    <input type="password" class="form-control" name="new" placeholder="New Password">
                                    <span class="input-group-text togglePassword" style="cursor: pointer;">
                                        <i class="ti ti-eye"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Confirm New Password</label>
                                <div class="input-group input-group-flat">
                                    <input type="password" class="form-control" name="new_confirm" placeholder="Type Confirm Password here">
                                    <span class="input-group-text togglePassword" style="cursor: pointer;">
                                        <i class="ti ti-eye"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card">
                <div class="card-footer d-flex justify-content-end gap-2">
                    <button type="reset" class="btn btn-ghost-warning">Reset</button>
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </div>
            </div>

            <!-- Hidden Fields -->
            <input type="hidden" name="old_profile_image" value="<?= $fetched_data[0]['image'] ?>">
            <input type="hidden" name="edit_affiliate_user" value="<?= $fetched_data[0]['user_id'] ?? '' ?>">
            <input type="hidden" name="edit_affiliate_data_id" value="<?= $fetched_data[0]['id'] ?? '' ?>">
            <input type="hidden" name="affiliate_uuid" value="<?= $fetched_data[0]['uuid'] ?? '' ?>">
            <input type="hidden" name="is_affiliate_user" value="<?= $fetched_data[0]['is_affiliate_user'] ?? '' ?>">
            <input type="hidden" name="status" value="<?= $fetched_data[0]['affiliate_user_status'] ?? '' ?>">
        </form>
    </div>
</div>

<script>
    document.querySelectorAll('.togglePassword').forEach(item => {
        item.addEventListener('click', () => {
            const input = item.previousElementSibling;
            const icon = item.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('ti-eye');
                icon.classList.add('ti-eye-off');
            } else {
                input.type = 'password';
                icon.classList.remove('ti-eye-off');
                icon.classList.add('ti-eye');
            }
        });
    });

    function validateNumberInput(input) {
        input.value = input.value.replace(/[^0-9]/g, '');
    }
</script>