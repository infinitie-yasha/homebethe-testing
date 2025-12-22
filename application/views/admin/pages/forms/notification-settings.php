<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
       <div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">
        <div class="row g-2 align-items-center">

            <!-- Page Title -->
            <div class="col-12 col-md-6">
                <h2 class="page-title mb-2 mb-md-0">Notification Settings</h2>
            </div>

            <!-- Breadcrumb -->
            <div class="col-12 col-md-6 d-flex justify-content-md-end">
                <ol class="breadcrumb breadcrumb-arrows mb-0 flex-column flex-sm-row small" aria-label="breadcrumbs">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('admin/home') ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#">System Settings</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Notification Settings
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
                            <h3 class="card-title"><i class="ti ti-bell"></i> Notification Settings</h3>
                        </div>
                        <div class="card-body">

                            <form x-data="ajaxForm({
                                            url: base_url + 'admin/Notification_settings/update_notification_settings',
                                            modalId: '',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="add_notification_settings_form"
                                enctype="multipart/form-data">
                                <div class="mb-3 row">
                                    <label class="col-12 col-md-3 col-form-label required" for="vap_id_Key">Vap Id
                                        Key</label>
                                    <div class="col">
                                        <textarea class="form-control" name="vap_id_Key" id="vap_id_Key"
                                            data-bs-toggle="autosize"
                                            placeholder="Enter Vap Id Key"><?= $vap_id_Key ?></textarea>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-12 col-md-3 col-form-label required"
                                        for="firebase_project_id">Firebase
                                        Project ID</label>
                                    <div class="col">
                                        <input type="text" class="form-control" name="firebase_project_id"
                                            placeholder="Enter Firebase Project ID" id="firebase_project_id"
                                            value="<?= (isset($firebase_project_id) && !empty($firebase_project_id)) ? $firebase_project_id : '' ?>" />
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-12 col-md-3 col-form-label required"
                                        for="service_account_file">Service
                                        Account File</label>

                                    <div class="col">
                                        <input type="file" class="form-control service_account_file"
                                            name="service_account_file" id="service_account_file" accept=".json" />
                                        <small
                                            class="form-hint <?= (isset($service_account_file) && !empty($service_account_file)) ? 'text-info' : 'text-danger' ?>"><?= (isset($service_account_file) && !empty($service_account_file)) ? 'File is uploaded' : 'No file uploaded yet' ?></small>
                                    </div>
                                </div>


                                <div class="mt-5">
                                    <div class="row g-2 justify-content-end">

                                        <div class="col-12 col-sm-auto">
                                            <button type="reset" class="btn w-100 w-sm-auto">Cancel</button>
                                        </div>

                                        <div class="col-12 col-sm-auto">
                                            <button type="submit" class="btn btn-primary w-100 w-sm-auto"
                                                id="submit_btn">
                                                Update <i class="ms-2 ti ti-arrow-right"></i>
                                            </button>
                                        </div>

                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>