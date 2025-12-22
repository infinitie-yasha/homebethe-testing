<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row align-items-center g-2">
                    <!-- Page Title -->
                    <div class="col-12 col-md">
                        <h2 class="page-title mb-0">
                            <?= isset($fetched_data[0]['id']) ? 'Edit System User' : 'Add System User' ?>
                        </h2>
                    </div>

                    <!-- Breadcrumb -->
                    <div class="col-12 col-md-auto mt-2 mt-md-0">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-arrows mb-0">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/home') ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/system_users') ?>">System Users</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <?= isset($fetched_data[0]['id']) ? 'Edit' : 'Add' ?> System User
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

                <form x-data="ajaxForm({
                                            url: base_url + 'admin/system_users/update_system_user',
                                            modalId: '',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="add_system_user_form">

                    <?php if (isset($fetched_data[0]['id'])) { ?>
                        <input type='hidden' name='edit_system_user' value="<?= $fetched_data[0]['id'] ?>">
                    <?php } ?>

                    <div class="row g-3">
                        <!-- User Information Card -->
                        <div class="col-12 col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="ti ti-user-circle"></i> User Information</h3>
                                </div>
                                <div class="card-body">

                                    <!-- Username -->
                                    <div class="mb-3 row align-items-center">
                                        <label class="col-12 col-md-4 col-form-label required"
                                            for="username">Username</label>
                                        <div class="col-12 col-md-8">
                                            <input type="text" class="form-control" name="username" id="username"
                                                value="<?= (isset($fetched_data[0]['username'])) ? $fetched_data[0]['username'] : '' ?>"
                                                placeholder="Enter Username" />
                                        </div>
                                    </div>

                                    <!-- Mobile -->
                                    <div class="mb-3 row align-items-center">
                                        <label class="col-12 col-md-4 col-form-label required"
                                            for="mobile">Mobile</label>
                                        <div class="col-12 col-md-8">
                                            <input type="text" maxlength="16" oninput="validateNumberInput(this)"
                                                class="form-control" name="mobile" id="mobile"
                                                value="<?= (isset($fetched_data[0]['mobile'])) ? $fetched_data[0]['mobile'] : '' ?>"
                                                placeholder="Enter Mobile Number" />
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div class="mb-3 row align-items-center">
                                        <label class="col-12 col-md-4 col-form-label required" for="email">Email</label>
                                        <div class="col-12 col-md-8">
                                            <input type="email" class="form-control" name="email" id="email"
                                                value="<?= (isset($fetched_data[0]['email'])) ? $fetched_data[0]['email'] : '' ?>"
                                                placeholder="Enter Email Address" />
                                        </div>
                                    </div>

                                    <!-- Password -->
                                    <div class="mb-3 row align-items-center">
                                        <label class="col-12 col-md-4 col-form-label required"
                                            for="password">Password</label>
                                        <div class="col-12 col-md-8">
                                            <?php if (isset($fetched_data[0]['id'])) { ?>
                                                <small class="form-hint text-danger">*Leave blank if there is no
                                                    change</small>
                                            <?php } ?>
                                            <div class="input-group input-group-flat mt-1">
                                                <input type="password" class="form-control passwordToggle"
                                                    name="password" id="password" placeholder="Enter Password" />
                                                <span class="input-group-text togglePassword" title="Show password"
                                                    data-bs-toggle="tooltip" style="cursor: pointer;">
                                                    <i class="ti ti-eye fs-3"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Confirm Password (if adding new user) -->
                                    <?php if (!isset($fetched_data[0]['id'])) { ?>
                                        <div class="mb-3 row align-items-center">
                                            <label class="col-12 col-md-4 col-form-label required"
                                                for="confirm_password">Confirm Password</label>
                                            <div class="col-12 col-md-8">
                                                <div class="input-group input-group-flat mt-1">
                                                    <input type="password" class="form-control passwordToggle"
                                                        name="confirm_password" id="confirm_password"
                                                        placeholder="Confirm Password" />
                                                    <span class="input-group-text togglePassword" title="Show password"
                                                        data-bs-toggle="tooltip" style="cursor: pointer;">
                                                        <i class="ti ti-eye fs-3"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <!-- Role -->
                                    <div class="mb-3 row align-items-center">
                                        <label class="col-12 col-md-4 col-form-label required" for="role">Role</label>
                                        <div class="col-12 col-md-8">
                                            <select class="form-control form-select system-user-role" name="role">
                                                <option value="">---Select role---</option>
                                                <?php foreach ($user_roles as $key => $value) { ?>
                                                    <option value="<?= $key ?>" <?= (isset($fetched_data[0]['role']) && $fetched_data[0]['role'] == $key) ? "selected" : "" ?>>
                                                        <?= ucwords(str_replace('_', ' ', $value)) ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Buttons -->
                                    <div class="d-flex flex-column flex-md-row justify-content-end gap-2 mt-4">
                                        <button type="reset" class="btn btn-outline-secondary">
                                            <i class="ti ti-refresh"></i> Reset
                                        </button>
                                        <button type="submit" class="btn btn-primary" id="submit_btn">
                                            <i class="ti ti-user-plus me-1"></i>
                                            <?= isset($fetched_data[0]['id']) ? 'Update User' : 'Add User' ?>
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <!-- Permissions Card -->
                        <div class="col-12 col-lg-8">
                            <?php
                            if (isset($fetched_data[0]['id'])) {
                                $user_permissions = json_decode((string) $fetched_data[0]['permissions'], 1);
                            }

                            $actions = ['create', 'read', 'update', 'delete'];
                            ?>

                            <div
                                class="card permission-table <?= (isset($fetched_data[0]['role']) && $fetched_data[0]['role'] == 0) ? 'd-none' : '' ?>">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="ti ti-shield-lock"></i> Module Permissions</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="w-25">Module/Permissions</th>
                                                    <?php foreach ($actions as $row) { ?>
                                                        <th class="text-center"><?= ucfirst($row) ?></th>
                                                    <?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($system_modules as $key => $value) { ?>
                                                    <tr>
                                                        <td><strong><?= $key ?></strong></td>
                                                        <?php for ($i = 0; $i < count($actions); $i++) {
                                                            $index = array_search($actions[$i], $value);
                                                            if ($index !== false) {
                                                                $checked = '';
                                                                if (isset($user_permissions)) {
                                                                    if (isset($user_permissions[$key][$value[$index]])) {
                                                                        $checked = 'checked';
                                                                    }
                                                                } else {
                                                                    $checked = 'checked';
                                                                }
                                                                ?>
                                                                <td class="text-center">
                                                                    <label class="form-check form-switch form-switch-3">
                                                                        <input class="form-check-input system-users-switch"
                                                                            name="<?= 'permissions[' . $key . '][' . $value[$index] . ']' ?>"
                                                                            type="checkbox" <?= $checked ?>>
                                                                    </label>
                                                                </td>
                                                            <?php } else { ?>
                                                                <td></td>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <?php if (isset($fetched_data[0]['id'])) { ?>
                                        <div class="d-flex justify-content-end gap-2 mt-4">
                                            <button type="submit" class="btn btn-primary bg-primary-lt" id="submit_btn">
                                                <i class="ti ti-device-floppy me-1"></i> Update User
                                            </button>
                                        </div>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

</div>