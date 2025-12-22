<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
      <div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">
        <div class="row g-2 align-items-center">

            <!-- Page Title -->
            <div class="col-12">
                <h2 class="page-title mb-2">Purchase Code Validator</h2>
            </div>

            <!-- Breadcrumb -->
            <div class="col-12">
                <ol class="breadcrumb breadcrumb-arrows mb-0 flex-column flex-sm-row small" aria-label="breadcrumbs">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('admin/home') ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#">Settings</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Purchase Code Validator
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
                            <h3 class="card-title"><i class="ti ti-circle-check"></i> Purchase Code Validator</h3>
                        </div>
                        <div class="card-body">
                            <form x-data="ajaxForm({ url: '<?= base_url('admin/purchase-code/validator'); ?>' })" 
                                action="<?= base_url('admin/purchase-code/validator'); ?>"
                                method="POST" id="add_product_form" enctype="multipart/form-data">
                                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

                                <div class="space-y">
                                    <div>
                                        <label class="col-form-label required" for="web_purchase_code"> Purchase Code for
                                            WEB
                                        </label>
                                        <input type="text" id="web_purchase_code"
                                            placeholder="Enter your WEB purchase code here" class="form-control"
                                            name="web_purchase_code" />
                                    </div>
                                    <div>
                                        <label class="col-form-label required" for="app_purchase_code"> Purchase Code for
                                            APP
                                        </label>
                                        <input type="text" id="app_purchase_code"
                                            placeholder="Enter your APP purchase code here" class="form-control"
                                            name="app_purchase_code" />
                                    </div>

                                    <div class="form-group">
                                        <button type="reset" class="btn">Cancel</button>
                                        <button type="submit" class="btn btn-primary" id="submit_btn" 
                                            :disabled="isLoading">
                                            <span x-show="!isLoading">Register Now <i class="cursor-pointer ms-2 ti ti-arrow-right"></i></span>
                                            <span x-show="isLoading" x-text="loaderText"></span>
                                        </button>
                                    </div>

                                </div>
                            </form>

                            <?php $doctor_brown = get_settings('doctor_brown', true);
                            if (!empty($doctor_brown) && isset($doctor_brown['code_bravo'])) { ?>
                                <div class="alert alert-dismissible alert-important alert-success mt-5" role="alert">
                                    <div class="alert-icon">
                                        <i class="ti ti-checks"></i>
                                    </div>
                                    <div>
                                        <h4 class="alert-heading">Your system is successfully registered with us! Enjoy
                                            selling online!</h4>
                                    </div>
                                </div>

                            <?php } ?>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>