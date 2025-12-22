<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">Privacy Policy And Terms & Conditions</h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="d-flex">
                            <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/home') ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/affiliate') ?>">Affiliate</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">Privacy Policy And Terms & Conditions</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE HEADER -->

        <div class="page-body">
            <div class="container-xl">
                <div class="card">
                    <form x-data="ajaxForm({
                                            url: base_url + 'admin/Privacy_policy/update-privacy-policy-settings',
                                            modalId: '',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="update_privacy_policy_form"
                        enctype="multipart/form-data">
                        <div class="card-body">
                            <!-- privacy policy -->
                            <div class="d-flex gap-3 align-items-center mb-0">
                                <label class="col-form-label fw-bolder" for="view_privacy_policy"><i
                                        class="ti ti-align-left"></i> Privacy Policy
                                </label>
                                <a href="<?= base_url('admin/affiliate_policies/privacy-policy-page') ?>"
                                    target='_blank' class="btn btn-primary btn-sm bg-primary-lt"
                                    id="view_privacy_policy" title='View Privacy Policy'><i class='ti ti-eye'></i></a>
                            </div>

                            <div class="my-5">
                                <textarea class="hugerte-mytextarea" id="privacy_policy_input" name="privacy_policy_input_description"
                                    placeholder="Place some text here"><?= @$privacy_policy ?></textarea>
                            </div>

                            <!-- terms and conditions -->
                            <div class="d-flex gap-3 align-items-center">
                                <label class="col-form-label fw-bolder mb-0"><i class="ti ti-align-left"></i> Terms &
                                    Conditions </label>
                                <a href="<?= base_url('admin/affiliate_policies/terms-and-conditions-page') ?>"
                                    target='_blank' class="btn btn-primary btn-sm bg-primary-lt"
                                    title='View Terms && Condition'><i class='ti ti-eye'></i></a>

                            </div>
                            <div class="my-5">
                                <textarea class="hugerte-mytextarea" id="terms_n_conditions_input" name="terms_n_conditions_input_description"
                                    placeholder="Place some text here"><?= @$terms_n_condition ?></textarea>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12 d-flex flex-column flex-sm-row justify-content-end gap-2">
                                    <button type="reset" class="btn btn-secondary  w-sm-auto">Cancel</button>

                                    <button type="submit" class="btn btn-primary w-sm-auto" id="submit_btn">
                                        Update
                                        <i class="cursor-pointer ms-2 ti ti-arrow-right"></i>
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