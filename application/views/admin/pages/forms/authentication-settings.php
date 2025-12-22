<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">

                <!-- MOBILE VIEW -->
                <div class="d-flex flex-column text-center d-sm-none py-2">
                    <h2 class="page-title fs-5 fw-semibold mb-1">Authentication Settings</h2>
                    <nav class="breadcrumb breadcrumb-arrows small justify-content-start mb-0">
                        <a href="<?= base_url('admin/home') ?>" class="breadcrumb-item">Home</a>
                        <span class="breadcrumb-item">System</span>
                        <span class="breadcrumb-item active">Authentication Settings</span>
                    </nav>
                </div>

                <!-- DESKTOP / TABLET VIEW -->
                <div class="row align-items-center g-2 d-none d-sm-flex">
                    <div class="col">
                        <h2 class="page-title mb-0">Authentication Settings</h2>
                    </div>
                    <div class="col-auto">
                        <ol class="breadcrumb breadcrumb-arrows mb-0 small">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('admin/home') ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">System Settings</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Authentication Settings
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
                            <h3 class="card-title"><i class="ti ti-key"></i> Authentication Settings</h3>
                        </div>
                        <div class="card-body">
                            <form x-data="ajaxForm({
                                            url: base_url + 'admin/Authentication_settings/update_authentication_settings',
                                            modalId: '',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="update_authentication_form"
                                enctype="multipart/form-data">

                                <input type="hidden" id="auth_setting" name="firebase_config" required=""
                                    value='<?= json_encode($authentication_config) ?>' aria-required="true">

                                <div class="mb-3">
                                    <label class="form-label">Authentication Method</label>
                                    <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column">
                                        <label class="form-selectgroup-item flex-fill">
                                            <input type="radio" name="authentication_method" value="firebase"
                                                class="form-selectgroup-input" id="firebaseRadio"
                                                <?= (@$authentication_config['authentication_method']) == 'firebase' ? 'checked' : '' ?>>
                                            <div class="form-selectgroup-label d-flex align-items-center p-3">
                                                <div class="me-3">
                                                    <span class="form-selectgroup-check"></span>
                                                </div>
                                                <div class="flex-fill">
                                                    <div class="font-weight-medium mb-1">Firebase Authentication</div>
                                                    <div class="text-muted small">Use Google Firebase for secure
                                                        authentication with multiple sign-in methods</div>
                                                </div>
                                            </div>
                                        </label>
                                        <label class="form-selectgroup-item flex-fill">
                                            <input type="radio" name="authentication_method" value="sms"
                                                class="form-selectgroup-input" id="smsRadio"
                                                <?= (@$authentication_config['authentication_method']) == 'sms' ? 'checked' : '' ?>>
                                            <div class="form-selectgroup-label d-flex align-items-center p-3">
                                                <div class="me-3">
                                                    <span class="form-selectgroup-check"></span>
                                                </div>
                                                <div class="flex-fill">
                                                    <div class="font-weight-medium mb-1">Custom SMS Gateway OTP based
                                                    </div>
                                                    <div class="text-muted small">Use your custom SMS gateway for
                                                        OTP-based authentication</div>
                                                </div>
                                            </div>
                                        </label>
                                    </div>

                                    <div class="d-flex mt-3">
                                        <div class="firebase_config d-none">
                                            <a href="<?= base_url('admin/web-setting/firebase') ?>"
                                                class="text-decoration-none">
                                                <p class="text-info mb-0">Please config firebase config here<i
                                                        class="ti ti-arrow-right mx-2"></i></p>
                                            </a>
                                        </div>
                                        <div class="sms_gateway d-none">
                                            <a href="<?= base_url('admin/sms-gateway-settings') ?>"
                                                class="text-decoration-none">
                                                <p class="text-info mb-0">Please config SMS gateway config here<i
                                                        class="ti ti-arrow-right mx-2"></i></p>
                                            </a>
                                        </div>
                                    </div>
                                </div>


                                <div class="mt-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <button type="reset" class="btn">Cancel</button>
                                        <button type="submit" class="btn btn-primary" id="submit_btn">
                                            Update Authentication Settings
                                            <i class="ms-2 ti ti-arrow-right"></i>
                                        </button>
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