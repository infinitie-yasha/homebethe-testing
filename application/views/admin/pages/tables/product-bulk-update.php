<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
     <div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">
        <div class="row g-2 align-items-center">

            <!-- Page Title -->
            <div class="col-12 col-md">
                <h2 class="page-title mb-2 mb-md-0">Manage Affiliate Products</h2>
            </div>

            <!-- Breadcrumb -->
            <div class="col-12 col-md-auto">
                <div class="d-flex justify-content-md-end">
                    <ol class="breadcrumb breadcrumb-arrows mb-0">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('admin/home') ?>">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Affiliate Product Management
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
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title"><i class="ti ti-user-circle"></i> Manage Affiliate Products</h3>
                            <div id="productToolbar">
                                <button type="button" class="btn btn-primary bg-primary-lt"
                                    id="openBulkAffiliateOffcanvas">
                                    <i class="ti ti-settings"></i> Bulk Affiliate Settings
                                </button>
                            </div>
                        </div>
                        <div class="card-body">

                            <table class='table-striped' id='products_affiliate_table' data-toggle="table"
                                data-url="<?= base_url('admin/product/get_affiliate_product_data_list') ?>"
                                data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                                data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                                data-sort-order="desc" data-mobile-responsive="true" data-toolbar=""
                                data-show-export="true" data-maintain-selected="true"
                                data-export-types='["txt","excel","csv"]' data-export-options='{
                            "fileName": "products-list",
                            "ignoreColumn": ["state"]
                            }' data-query-params="product_query_params">
                                <thead>
                                    <tr>
                                        <th data-field="state" data-checkbox="true"></th>

                                        <th data-field="id" data-sortable="true" data-visible='false'
                                            data-align='center'>ID</th>
                                        <th data-field="image" data-sortable="true" data-align='center'>Image</th>
                                        <th data-field="name" data-sortable="false" data-align='center'>Name</th>
                                        <th data-field="brand" data-sortable="false" data-align='center'
                                            data-visible="false">Brand</th>
                                        <th data-field="is_in_affiliate_status" data-sortable="false"
                                            data-align='center'>Is In Affiliate</th>
                                        <th data-field="category_name" data-sortable="false" data-align='center'>
                                            Category Name</th>
                                        <th data-field="operate" data-sortable="false" data-align='center'>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="offcanvas offcanvas-end offcanvas-medium" tabindex="-1" id="productAffiliateSetting"
                            aria-labelledby="productAffiliateSettingLabel">
                            <div class="offcanvas-header">
                                <h2 class="offcanvas-title" id="productAffiliateSettingLabel">Product Affiliate Setting
                                </h2>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <form x-data="ajaxForm({
                                            url: base_url + 'admin/product/update_affiliate_settings',
                                            offcanvasId: 'productAffiliateSetting',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="add_zipcode_form">
                                <div class="offcanvas-body">
                                    <div>

                                        <input type="hidden" name="product_id" id="modal_product_id">

                                        <div class="mb-3 row">
                                            <label class="col-3 col-form-label required"
                                                for="modal_product_name">Product Name</label>

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

                        <!-- Bulk Affiliate Settings Offcanvas -->
                        <div class="offcanvas offcanvas-end offcanvas-medium" tabindex="-1"
                            id="bulkProductAffiliateSetting" aria-labelledby="bulkProductAffiliateSettingLabel">
                            <div class="offcanvas-header">
                                <h2 class="offcanvas-title" id="bulkProductAffiliateSettingLabel">
                                    <i class="ti ti-settings"></i> Bulk Affiliate Settings
                                </h2>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <form x-data="ajaxForm({
                                            url: base_url + 'admin/product/bulk_update_affiliate',
                                            offcanvasId: 'bulkProductAffiliateSetting',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="bulkAffiliateForm">
                                <div class="offcanvas-body">
                                    <div class="alert alert-info" role="alert">
                                        <i class="ti ti-info-circle"></i>
                                        <span id="selectedProductCount">0</span> product(s) selected for bulk update.
                                    </div>

                                    <input type="hidden" name="product_ids" id="product_ids">
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label required" for="bulk_is_in_affiliate">
                                            Is in Affiliate
                                        </label>
                                        <div class="col">
                                            <select class="form-select" name="is_in_affiliate" id="bulk_is_in_affiliate"
                                                required>
                                                <option value="">Select Status</option>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                            <small class="form-hint">
                                                This will update affiliate status for all selected products.
                                            </small>
                                        </div>
                                    </div>

                                    <div class="text-end mt-4">
                                        <button type="button" class="btn" data-bs-dismiss="offcanvas"
                                            aria-label="Close">Cancel</button>
                                        <button type="submit" class="btn btn-primary" id="bulkSubmitBtn">
                                            Update Affiliate Settings
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