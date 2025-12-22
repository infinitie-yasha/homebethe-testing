<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
   <div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">

        <!-- Mobile View (xs/sm) -->
        <div class="d-flex flex-column text-center d-sm-none py-2">
            <h2 class="page-title fs-5 fw-semibold mb-1">Email SMTP Settings</h2>
            <nav class="breadcrumb breadcrumb-arrows small justify-content-start mb-0">
                <a href="<?= base_url('admin/home') ?>" class="breadcrumb-item">Home</a>
                <span class="breadcrumb-item">Settings</span>
                <span class="breadcrumb-item active">Email</span>
            </nav>
        </div>

        <!-- Tablet & Desktop View (md+) -->
        <div class="row g-2 align-items-center d-none d-sm-flex">
            <div class="col">
                <h2 class="page-title mb-0">Email SMTP Settings</h2>
            </div>
            <div class="col-auto ms-auto">
                <ol class="breadcrumb breadcrumb-arrows mb-0 small">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('admin/home') ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#">Settings</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Email Settings
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
                            <h3 class="card-title"><i class="ti ti-mail"></i> Email SMTP Settings</h3>
                        </div>
                        <div class="card-body">
                            <form x-data="ajaxForm({
                                            url: base_url + 'admin/email_settings/set_email_settings',
                                            modalId: '',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="email_settings_form"
                                enctype="multipart/form-data">
                                <div class="mb-3 row">
                                    <label class="col-12 col-md-3  col-form-label required" for="email">Email address</label>
                                    <div class="col">
                                        <input type="email" class="form-control" name="email" placeholder="Enter email"
                                            id="email-set"
                                            value="<?= (isset($email_settings)) ? $email_settings['email'] : '' ?>" />
                                        <small class="form-hint">This is the email address that the contact and report
                                            emails will be sent to, aswell as being the from address in signup and
                                            notification emails.</small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-12 col-md-3  col-form-label required" for="password">Password</label>
                                    <div class="col">
                                        <input type="password" class="form-control" name="password"
                                            placeholder="Enter password" id="password"
                                            value="<?= (isset($email_settings)) ? $email_settings['password'] : '' ?>" />
                                        <small class="form-hint">Password of above given email.</small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-12 col-md-3  col-form-label required" for="smtp_host">SMTP Host</label>
                                    <div class="col">
                                        <input type="text" class="form-control" name="smtp_host"
                                            placeholder="Enter smtp host" id="smtp_host"
                                            value="<?= (isset($email_settings)) ? $email_settings['smtp_host'] : '' ?>" />
                                        <small class="form-hint">This is the host address for your smtp server, this is
                                            only needed if you are using SMTP as the Email Send Type.</small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-12 col-md-3  col-form-label required" for="smtp_port">SMTP Port</label>
                                    <div class="col">
                                        <input type="text" class="form-control" name="smtp_port"
                                            placeholder="Enter SMTP Port" id="smtp_port"
                                            value="<?= (isset($email_settings)) ? $email_settings['smtp_port'] : '' ?>" />
                                        <small class="form-hint">SMTP port this will provide your service
                                            provider.</small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-12 col-md-3  col-form-label">Email Content Type</label>
                                    <div class="col">
                                        <select class="form-select" name="mail_content_type" id="mail_content_type">
                                            <option value="text" <?= (isset($email_settings) && $email_settings['mail_content_type'] == 'text') ? 'selected' : '' ?>>Text
                                            </option>
                                            <option value="html" <?= (isset($email_settings) && $email_settings['mail_content_type'] == 'html') ? 'selected' : '' ?>>HTML
                                            </option>
                                        </select>
                                        <small class="form-hint">Text-plain or HTML content chooser.</small>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-12 col-md-3  col-form-label">SMTP Encryption</label>
                                    <div class="col">
                                        <select class="form-select" name="smtp_encryption" id="smtp_encryption">
                                            <option value="off" <?= (isset($email_settings) && $email_settings['smtp_encryption'] == 'off') ? 'selected' : '' ?>>off
                                            </option>
                                            <option value="ssl" <?= (isset($email_settings) && $email_settings['smtp_encryption'] == 'ssl') ? 'selected' : '' ?>>SSL
                                            </option>
                                            <option value="tls" <?= (isset($email_settings) && $email_settings['smtp_encryption'] == 'tls') ? 'selected' : '' ?>>TLS
                                            </option>
                                        </select>
                                        <small class="form-hint">If your e-mail service provider supported secure
                                            connections, you can choose security method on list.</small>
                                    </div>
                                </div>

                                <div class="space-y mt-5">

                                    <div class="form-group text-end">
                                        <button type="reset" class="btn">Cancel</button>
                                        <button type="submit" class="btn btn-primary "
                                            id="submit_btn"><?= (isset($email_settings)) ? 'Update Email Settings' : 'Add Email Settings' ?>
                                            <i class="cursor-pointer ms-2 ti ti-arrow-right"></i></button>
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