<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">

                    <!-- Page Title -->
                    <div class="col-12 col-md-6">
                        <h2 class="page-title mb-2 mb-md-0">Manage Affiliate Users</h2>
                    </div>

                    <!-- Breadcrumb -->
                    <div class="col-12 col-md-6 d-flex justify-content-md-end align-items-center">
                        <ol class="breadcrumb breadcrumb-arrows m-0 w-100 justify-content-start justify-content-md-end"
                            aria-label="breadcrumbs">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('admin/home') ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('admin/affiliate') ?>">Affiliate</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="#">Affiliate Users</a>
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
                        <div class="card-header">
                            <div class="row w-100 align-items-center g-2">

                                <!-- Title (full width on small, left on large) -->
                                <div class="col-12 col-md-6 d-flex align-items-center">
                                    <h3 class="card-title m-0">
                                        <i class="ti ti-user-circle"></i> Manage Affiliate User
                                    </h3>
                                </div>

                                <!-- Buttons (stack on small, align right on large) -->
                                <div class="col-12 col-md-6 d-flex flex-wrap justify-content-md-end gap-2">
                                    <a href="#"
                                        class="btn btn-success bg-success-lt btn-sm  w-md-auto update-affiliate-commission"
                                        title="If you found affiliate commission not crediting using cron job you can update Affiliate commission from here!">
                                        Update Affiliate Commission
                                    </a>

                                    <a class="btn btn-primary addAffiliateUserBtn btn-sm bg-primary-lt  w-md-auto"
                                        data-bs-toggle="offcanvas" data-bs-target="#addAffiliateUser" href="#"
                                        role="button" aria-controls="addAffiliateUser">
                                        Add Affiliate User
                                    </a>
                                </div>

                            </div>
                        </div>

                        <div class="card-body">
                            <div class="col-md-3">
                                <label for="affiliate_status_filter" class="col-form-label">Filter By Affiliate
                                    Status</label>
                                <select id="affiliate_status_filter" name="affiliate_status_filter"
                                    placeholder="Select Status" required="" class="form-control">
                                    <option value="">All</option>
                                    <option value="approved">Approved</option>
                                    <option value="not_approved">Not Approved</option>
                                    <option value="deactive">Deactive</option>
                                    <option value="removed">Removed</option>
                                </select>
                            </div>
                            <table class='table-striped' id="affiliate_users_table" data-toggle="table"
                                data-url="<?= base_url('admin/affiliate_users/get_users') ?>"
                                data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                                data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                                data-sort-order="desc" data-mobile-responsive="true" data-toolbar=""
                                data-show-export="true" data-maintain-selected="true"
                                data-export-types='["txt","excel"]' data-query-params="affiliate_status_params">
                                <thead>
                                    <tr>
                                        <th data-field="user_id" data-sortable="true">ID</th>
                                        <th data-field="name" data-sortable="false">Name</th>
                                        <th data-field="email" data-sortable="true">Email</th>
                                        <th data-field="mobile" data-sortable="true">Mobile No</th>
                                        <th data-field="balance" data-sortable="true">Balance</th>
                                        <th data-field="date" data-sortable="false">Date</th>
                                        <th data-field="status" data-sortable="false">Status</th>
                                        <th data-field="operate" data-sortable="false">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="offcanvas offcanvas-end offcanvas-medium" tabindex="-1" id="addAffiliateUser"
                            aria-labelledby="addAffiliateUserLabel">
                            <div class="offcanvas-header">
                                <h2 class="offcanvas-title" id="addAffiliateUserLabel">Add Affiliate User</h2>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <form x-data="ajaxForm({
                                            url: base_url + 'admin/affiliate_users/add_user',
                                            offcanvasId: 'addAffiliateUser',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="add_affiliate_user_form">
                                <div class="offcanvas-body">
                                    <div>

                                        <input type="hidden" name="edit_affiliate_user" id="edit_affiliate_user"
                                            value="">
                                        <input type="hidden" name="edit_affiliate_data_id" id="edit_affiliate_data_id"
                                            value="">
                                        <input type="hidden" name="affiliate_uuid" id="affiliate_uuid" value="">

                                        <input type="hidden" name="is_affiliate_user" id="is_affiliate_user" value="1">


                                        <div class="mb-3 row">
                                            <label class="col-12 col-sm-3 col-form-label required" for="full_name">Full
                                                Name</label>
                                            <div class="col">
                                                <input type="text" class="form-control" name="full_name" id="full_name"
                                                    placeholder="User Name" />
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-12 col-sm-3 col-form-label required" for="email">Email
                                                Address</label>
                                            <div class="col">
                                                <input type="email" class="form-control" name="email" id="email"
                                                    placeholder="Enter Email" />
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-12 col-sm-3 col-form-label required"
                                                for="mobile">Mobile</label>
                                            <div class="col">
                                                <input type="text" class="form-control" name="mobile" id="mobile"
                                                    placeholder="Enter Mobile" maxlength="16"
                                                    oninput="validateNumberInput(this)" />
                                            </div>
                                        </div>

                                        <div class="mb-3 row password_field">
                                            <label class="col-12 col-sm-3 col-form-label required"
                                                for="password">Password</label>
                                            <div class="col-12 col-sm-9">
                                                <div class="input-group input-group-flat">
                                                    <input type="password" class="form-control passwordToggle"
                                                        name="password" id="password"
                                                        placeholder="Type Password here" />
                                                    <span class="input-group-text togglePassword" title="Show password"
                                                        data-bs-toggle="tooltip" style="cursor: pointer;">
                                                        <i class="ti ti-eye fs-3"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3 row confirm_password_field">
                                            <label class="col-12 col-sm-3 col-form-label required"
                                                for="confirm_password">Confirm Password</label>
                                            <div class="col-12 col-sm-9">
                                                <div class="input-group input-group-flat">
                                                    <input type="password" class="form-control passwordToggle"
                                                        name="confirm_password" id="confirm_password"
                                                        placeholder="Type confirm Password here" />
                                                    <span class="input-group-text togglePassword" title="Show password"
                                                        data-bs-toggle="tooltip" style="cursor: pointer;">
                                                        <i class="ti ti-eye fs-3"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="mb-3 row">
                                            <label class="col-12 col-sm-3 col-form-label required"
                                                for="address">Address</label>
                                            <div class="col">
                                                <textarea name="address" id="address" class="textarea form-control"
                                                    placeholder="Enter Address" data-bs-toggle="autosize"></textarea>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-12 col-sm-3 col-form-label required"
                                                for="my_website">Enter
                                                Your Website URL</label>
                                            <div class="col">
                                                <input type="url" class="form-control" name="my_website" id="my_website"
                                                    placeholder="https://www.example.com/myblog" />
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-12 col-sm-3 col-form-label required" for="my_app">Enter
                                                Your
                                                Mobile APP URL</label>
                                            <div class="col">
                                                <input type="url" class="form-control" name="my_app" id="my_app"
                                                    placeholder="https://xxxx/dp/xxxx" />
                                                <small class="form-hint mt-2">Enter your application app
                                                    store
                                                    or playstore link</small>
                                            </div>
                                        </div>


                                        <div class="mb-3 row">
                                            <label class="col-12 col-sm-3 col-form-label required"
                                                for="status">Status</label>

                                            <div class="col-12 col-sm-9">
                                                <div id="status" class="d-flex flex-wrap gap-2">

                                                    <label
                                                        class="btn btn-danger bg-danger-lt d-flex align-items-center">
                                                        <input type="radio" name="status" value="2"
                                                            class="not-approved me-2">
                                                        Not-Approved
                                                    </label>

                                                    <label
                                                        class="btn btn-primary bg-primary-lt d-flex align-items-center">
                                                        <input type="radio" name="status" value="1"
                                                            class="approved me-2">
                                                        Approved
                                                    </label>

                                                </div>
                                            </div>
                                        </div>



                                    </div>
                                    <div class="text-end">
                                        <!-- <button type="reset" class="btn btn-warning ">Reset</button> -->
                                        <button type="button" class="btn" data-bs-dismiss="offcanvas"
                                            aria-label="Close">Close</button>
                                        <button type="submit" class="btn btn-primary save_affiliate_user"
                                            id="submit_btn">Add Affiliate User</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"
                            id='add-affiliate_user-modal'>
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add Affiliate User</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form class="form-horizontal form-submit-event add_delivery_boy"
                                        id="add_product_form" method="POST">
                                        <div class="modal-body p-0">

                                            <div class="card-body">

                                                <input type="hidden" name="edit_affiliate_user" id="edit_affiliate_user"
                                                    value="<?= isset($fetched_data) ? $fetched_data[0]['user_id'] : ''; ?>">
                                                <input type="hidden" name="edit_affiliate_data_id"
                                                    id="edit_affiliate_data_id"
                                                    value="<?= isset($fetched_data) ? $fetched_data[0]['id'] : ''; ?>">
                                                <input type="hidden" name="affiliate_uuid" id="affiliate_uuid"
                                                    value="<?= isset($fetched_data) ? $fetched_data[0]['uuid'] : ''; ?>">

                                                <input type="hidden" name="is_affiliate_user" id="is_affiliate_user"
                                                    value="1">

                                                <div class="mb-3 row">
                                                    <label class="col-3 col-form-label required" for="full_name">Full
                                                        Name</label>
                                                    <div class="col">
                                                        <input type="text" class="form-control" name="full_name"
                                                            id="full_name" placeholder="User Name" />
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-3 col-form-label required" for="email">Email
                                                        Address</label>
                                                    <div class="col">
                                                        <input type="email" class="form-control" name="email" id="email"
                                                            placeholder="Enter Email" />
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-3 col-form-label required"
                                                        for="mobile">Mobile</label>
                                                    <div class="col">
                                                        <input type="text" class="form-control" name="mobile"
                                                            id="mobile" placeholder="Enter Mobile" maxlength="16"
                                                            oninput="validateNumberInput(this)" />
                                                    </div>
                                                </div>

                                                <div class="mb-3 d-flex password_field">
                                                    <label class="col-3 col-form-label required"
                                                        for="password">Password</label>
                                                    <div class="input-group input-group-flat col">
                                                        <input type="password" class="form-control passwordToggle"
                                                            name="password" id="password"
                                                            placeholder="Type Password here" />
                                                        <span class="input-group-text togglePassword"
                                                            title="Show password" data-bs-toggle="tooltip"
                                                            style="cursor: pointer;">
                                                            <i class="ti ti-eye fs-3"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="mb-3 d-flex confirm_password_field">
                                                    <label class="col-3 col-form-label required"
                                                        for="confirm_password">Confirm Password</label>
                                                    <div class="input-group input-group-flat col">
                                                        <input type="confirm_password"
                                                            class="form-control passwordToggle" name="confirm_password"
                                                            id="confirm_password"
                                                            placeholder="Type confirm Password here" />
                                                        <span class="input-group-text togglePassword"
                                                            title="Show password" data-bs-toggle="tooltip"
                                                            style="cursor: pointer;">
                                                            <i class="ti ti-eye fs-3"></i>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label class="col-3 col-form-label required"
                                                        for="address">Address</label>
                                                    <div class="col">
                                                        <textarea name="address" id="address"
                                                            class="textarea form-control" placeholder="Enter Address"
                                                            data-bs-toggle="autosize"></textarea>
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label class="col-3 col-form-label required" for="my_website">Enter
                                                        Your Website URL</label>
                                                    <div class="col">
                                                        <input type="url" class="form-control" name="my_website"
                                                            id="my_website"
                                                            placeholder="https://www.example.com/myblog" />
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-3 col-form-label required" for="my_app">Enter
                                                        Your
                                                        Mobile APP URL</label>
                                                    <div class="col">
                                                        <input type="url" class="form-control" name="my_app" id="my_app"
                                                            placeholder="https://xxxx/dp/xxxx" />
                                                        <small class="form-hint mt-2">Enter your application app
                                                            store
                                                            or playstore link</small>
                                                    </div>
                                                </div>


                                                <div class="mb-3 row">
                                                    <label class="col-3 col-form-label required"
                                                        for="status">Status</label>
                                                    <div class="col">
                                                        <div id="status" class="">
                                                            <label class="btn btn-danger bg-danger-lt"
                                                                data-toggle-class="btn-primary"
                                                                data-toggle-passive-class="btn-default">
                                                                <input type="radio" name="status" value="2"
                                                                    class='not-approved mx-2'> Not-Approved
                                                            </label>
                                                            <label class="btn btn-primary bg-primary-lt"
                                                                data-toggle-class="btn-primary"
                                                                data-toggle-passive-class="btn-default">
                                                                <input type="radio" name="status" value="1"
                                                                    class='approved mx-2'> Approved
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>



                                            </div>

                                            <!-- /.card-footer -->
                                        </div>
                                        <div class="modal-footer">
                                            <button type="reset" class="btn btn-warning bg-warning-lt">Reset</button>
                                            <button type="submit"
                                                class="btn btn-success bg-success-lt save_affiliate_user"
                                                id="submit_btn">Add Affiliate User</button>
                                            <button type="button" class="btn btn-secondary bg-secondary-lt"
                                                data-bs-dismiss="modal">Close</button>
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