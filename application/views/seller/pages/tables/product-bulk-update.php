<div class="page-wrapper">


    <!-- BEGIN PAGE HEADER -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">Bulk Update</h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="d-flex">
                        <ol class="breadcrumb breadcrumb-arrows">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('seller/home') ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <a href="#">Product</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <a href="#">Product Bulk Updates</a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE HEADER -->

    <section class="page-body">
        <div class="container-xl">
            <div class="offcanvas offcanvas-end offcanvas-medium" tabindex="-1" id="productAffiliateSetting"
                aria-labelledby="productAffiliateSettingLabel">
                <div class="offcanvas-header">
                    <h2 class="offcanvas-title" id="productAffiliateSettingLabel">Product Affiliate Setting
                    </h2>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <form x-data="ajaxForm({
                                            url: base_url + 'seller/product/update_affiliate_settings',
                                            offcanvasId: 'productAffiliateSetting',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="add_zipcode_form">
                    <div class="offcanvas-body">
                        <div>

                            <input type="hidden" name="product_id" id="modal_product_id">

                            <div class="mb-3 row">
                                <label class="col-3 col-form-label required" for="modal_product_name">Product
                                    Name</label>

                                <div class="col">
                                    <input type="text" class="form-control" name="modal_product_name"
                                        id="modal_product_name" readonly />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label required" for="modal_is_in_affiliate">Is
                                    in Affiliate</label>
                                <div class="col">
                                    <select class="form-select modal_is_in_affiliate" name="is_in_affiliate"
                                        id="modal_is_in_affiliate">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="text-end">
                            <!-- <button type="reset" class="btn btn-warning ">Reset</button> -->
                            <button type="button" class="btn" data-bs-dismiss="offcanvas"
                                aria-label="Close">Close</button>
                            <button type="submit" class="btn btn-primary Save" id="submit_btn">Save</button>
                        </div>
                    </div>
                </form>
            </div>


            <!-- Bulk Affiliate Offcanvas -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="bulkAffiliateModal">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title">Bulk Update Affiliate Status</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="offcanvas-body">

                    <form x-data="ajaxForm({
                                            url: base_url + 'seller/product/bulk_update_affiliate',
                                            offcanvasId: 'bulkAffiliateModal',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="bulkAffiliateModal">

                        <div class="mb-3">
                            <input type="hidden" name="csrf_test_name" value="<?= $this->security->get_csrf_hash(); ?>">
                            <input type="hidden" name="product_ids[]" id="product_ids">
                            <label for="bulk_affiliate_status" class="form-label">Is In Affiliate:</label>
                            <select name="is_in_affiliate" id="bulk_affiliate_status" class="form-control" required>
                                <option value="">Select Status</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary me-2">Update</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Table -->
            <div class="card p-4">
                <div id="mediaToolbar">
                    <button type="button" class="btn btn-danger bg-danger-lt btn-m mb-3" id="openBulkModal">Bulk
                        Update</button>
                </div>
                <table class="table-striped" id="products_affiliate_table" data-toggle="table"
                    data-url="<?= base_url('seller/product/get_affiliate_product_data_list') ?>"
                    data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                    data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                    data-show-refresh="true" data-sort-name="id" data-sort-order="desc" data-mobile-responsive="true"
                    data-show-export="true" data-maintain-selected="true" data-export-types='["txt","excel","csv"]'
                    data-export-options='{"fileName": "products-list"}'>
                    <thead>
                        <tr>
                            <th data-field="state" data-checkbox="true"></th>
                            <th data-field="id" data-sortable="true" data-visible='false'>ID</th>
                            <th data-field="image" data-align='center'>Image</th>
                            <th data-field="name" data-align='center'>Name</th>
                            <th data-field="is_in_affiliate_status" data-align='center'>Is In Affiliate</th>
                            <th data-field="category_name" data-align='center'>Category</th>
                            <th data-field="operate" data-align='center'>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </section>
</div>