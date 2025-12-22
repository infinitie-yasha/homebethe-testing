<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">Affiliate Settings</h2>
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
                                    <a href="#">Affiliate Settings</a>
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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="ti ti-settings-2"></i> Basic Settings</h3>
                        </div>
                        <div class="card-body">
                            <form x-data="ajaxForm({
                                            url: base_url + 'admin/affiliate_settings/update_affiliate_settings',
                                            modalId: '',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="update_affiliate_setting_form"
                                enctype="multipart/form-data">


                                <div class="mb-3 row">
                                    <label class="col-12 col-sm-3 col-form-label required" for="account_delete_days">Permanent
                                        Account Delete Days
                                        <span class="form-help bg-azure-lt" data-bs-toggle="popover"
                                            data-bs-placement="top"
                                            data-bs-content="After days account will permanent delete."
                                            data-bs-html="true"><i class="text-azure ti ti-info-circle"></i></span>
                                    </label>
                                    <div class="col">
                                        <input type="number" class="form-control" name="account_delete_days"
                                            placeholder="Account Delete Days" id="account_delete_days"
                                            value="<?= (isset($affiliate_settings['account_delete_days'])) ? $affiliate_settings['account_delete_days'] : '' ?>" />
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-12 col-sm-3 col-form-label required" for="max_amount_for_withwrawal_req">Max
                                        Amount for Withdrawal Request
                                        <span class="form-help bg-azure-lt" data-bs-toggle="popover"
                                            data-bs-placement="top"
                                            data-bs-content="Maximum limit a user can request to withdraw at a time."
                                            data-bs-html="true"><i class="text-azure ti ti-info-circle"></i></span>
                                    </label>
                                    <div class="col">
                                        <input type="number" class="form-control" name="max_amount_for_withwrawal_req"
                                            placeholder="Max Amount for Withdrawal Request"
                                            id="max_amount_for_withwrawal_req" min="0"
                                            value="<?= (isset($affiliate_settings['max_amount_for_withwrawal_req'])) ? $affiliate_settings['max_amount_for_withwrawal_req'] : '' ?>" />
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-12 col-sm-3 col-form-label required" for="min_amount_for_withwrawal_req">Min
                                        Balance for Withdrawal Request
                                        <span class="form-help bg-azure-lt" data-bs-toggle="popover"
                                            data-bs-placement="top"
                                            data-bs-content="Minimum balance required to place a withdrawal request."
                                            data-bs-html="true"><i class="text-azure ti ti-info-circle"></i></span>
                                    </label>
                                    <div class="col">
                                        <input type="number" class="form-control" name="min_amount_for_withwrawal_req"
                                            placeholder="Min Amount for Withdrawal Request"
                                            id="min_amount_for_withwrawal_req" min="0"
                                            value="<?= (isset($affiliate_settings['min_amount_for_withwrawal_req'])) ? $affiliate_settings['min_amount_for_withwrawal_req'] : '' ?>" />
                                    </div>
                                </div>



                                <div class="space-y mt-5">

                                    <div class="form-group text-end">
                                        <button type="reset" class="btn btn-1">Cancel</button>
                                        <button type="submit" class="btn btn-primary btn-2" id="submit_btn">Update
                                            Affiliate Settings <i
                                                class="cursor-pointer ms-2 ti ti-arrow-right"></i></button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h3 class="card-title"><i class="ti ti-circle-percentage"></i> Affiliate Commission
                                <small>(%)</small>
                            </h3>
                        </div>
                        <div class="card-body">
                            <form x-data="ajaxForm({
                                            url: base_url + 'admin/affiliate_settings/update_commission',
                                            modalId: '',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="affiliate_commission_form"
                                enctype="multipart/form-data">
                                <div id="repeater">
                                    <?php
                                    // Build list of used category IDs (having commission > 0)
                                    $used_category_ids = [];
                                    if (!empty($affiliate_commissions)) {
                                        foreach ($affiliate_commissions as $ac) {
                                            if (floatval($ac['affiliate_commission']) > 0) {
                                                $used_category_ids[] = $ac['id'];
                                            }
                                        }
                                    }

                                    if (!empty($affiliate_commissions)) {
                                        foreach ($affiliate_commissions as $commission_data) {
                                            if (floatval($commission_data['affiliate_commission']) > 0) {
                                                ?>
                                                <div class="repeater-item">
                                                    <div class="row g-3 mb-3 align-items-center">
                                                        <div class="col-12 col-md-5">
                                                            <select name="category_parent[]"
                                                                class="category_parent_tomselect form-select"
                                                                data-preselected="<?= $commission_data['id'] ?>" required>
                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-md-5">
                                                            <input type="number" class="form-control" name="commission[]"
                                                                placeholder="Commission (%)"
                                                                value="<?= htmlspecialchars($commission_data['affiliate_commission']) ?>"
                                                                min="0" max="100" step="0.01" required>
                                                        </div>
                                                        <div class="col-12 col-md-2 ">
                                                            <a type="button" class="remove-btn text-decoration-none"
                                                                title="Remove Category">
                                                                <i class="fs-2 text-danger ti ti-xbox-x"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                    } else {
                                        ?>
                                        <div class="repeater-item">
                                            <div class="d-flex align-items-center gap-3 mb-3">
                                                <div class="col-md-5">
                                                    <select name="category_parent[]"
                                                        class="category_parent_tomselect form-select" required>
                                                    </select>
                                                </div>
                                                <div class="col-md-5">
                                                    <input type="number" class="form-control" name="commission[]"
                                                        placeholder="Commission (%)" min="0" max="100" step="0.01" required>
                                                </div>
                                                <div class="col-md-2">
                                                    <a type="button" class="remove-btn text-decoration-none"
                                                        title="Remove Category">
                                                        <i class="fs-2 text-danger ti ti-xbox-x"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div>
                                    <button type="button" id="add-more" class="btn btn-primary bg-primary-lt btn-sm">
                                        More <i class="ti ti-plus ms-2"></i></button>
                                </div>


                                <div class="space-y mt-5">

                                    <div class="form-group text-end">
                                        <button type="submit" class="btn btn-primary btn-2" id="submit_btn">Update
                                            Affiliate Commission <i
                                                class="cursor-pointer ms-2 ti ti-arrow-right"></i></button>
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
<script>
    const categoriesData = <?= json_encode($categories) ?>;
    const usedCategoryIds = <?= json_encode($used_category_ids) ?>;
</script>