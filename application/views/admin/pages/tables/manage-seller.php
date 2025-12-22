<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">Manage Seller</h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="d-flex">
                            <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/home') ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">Sellers</a>
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
                        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                            <h3 class="card-title mb-2 mb-sm-0">
                                <i class="ti ti-user-circle"></i> Manage Sellers
                            </h3>

                            <div class="d-flex flex-wrap gap-2">
                                <a href="javascript:void(0);"
                                    class="btn btn-success btn-sm update-seller-commission bg-success-lt"
                                    title="If you found seller commission not crediting using cron job you can update seller commission from here!">
                                    Update Seller Commission
                                </a>

                                <a href="<?= base_url('admin/sellers/manage-seller') ?>"
                                    class="btn btn-primary add_seller_btn btn-sm bg-primary-lt">
                                    Add Seller
                                </a>
                            </div>
                        </div>


                        <div class="card-body">
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <div class="alert-icon">
                                    <i class="ti ti-info-circle"></i>
                                </div>
                                <div>
                                    <div class="alert-heading">
                                        Note : If you found seller commission not crediting using cron job you can
                                        update seller commission manually from here! ( click on update seller commission
                                        button )
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-3">
                                <label for="seller_status_filter" class="col-form-label">Filter By Seller Status</label>
                                <select id="seller_status_filter" name="seller_status_filter"
                                    placeholder="Select Status" required="" class="form-control">
                                    <option value="">All</option>
                                    <option value="approved">Approved</option>
                                    <option value="not_approved">Not Approved</option>
                                    <option value="deactive">Deactive</option>
                                    <option value="removed">Removed</option>
                                </select>
                            </div>
                            <table class='table-striped' id="seller_table" data-toggle="table"
                                data-url="<?= base_url('admin/sellers/view_sellers') ?>" data-click-to-select="true"
                                data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                                data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                                data-sort-order="desc" data-mobile-responsive="true" data-toolbar=""
                                data-show-export="true" data-maintain-selected="true"
                                data-export-types='["txt","excel"]' data-export-options='{
                            "fileName": "seller-list",
                            "ignoreColumn": ["state"]
                            }' data-query-params="seller_status_params">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true">ID</th>
                                        <th data-field="name" data-sortable="false">Name</th>
                                        <th data-field="email" data-sortable="false">Email</th>
                                        <th data-field="mobile" data-sortable="true">Mobile No</th>
                                        <th data-field="address" data-sortable="true" data-visible="false">Address</th>
                                        <th data-field="balance" data-sortable="true">
                                            Balance(<?php echo $currency ?>)</th>
                                        <th data-field="rating" data-sortable="true">Rating</th>
                                        <th data-field="store_name" data-sortable="true">Store Name</th>
                                        <th data-field="store_url" data-sortable="true" data-visible="false">Store URL
                                        </th>
                                        <th data-field="store_description" data-sortable="true" data-visible="false">
                                            Store Description</th>
                                        <th data-field="latitude" data-sortable="true" data-visible="false">Latitude
                                        </th>
                                        <th data-field="longitude" data-sortable="true" data-visible="false">Longitude
                                        </th>
                                        <th data-field="status" data-sortable="false">Status</th>
                                        <th data-field="category_ids" data-sortable="true" data-visible="false">
                                            Categories</th>
                                        <th data-field="logo" data-sortable="false">Logo</th>
                                        <th data-field="address_proof" data-sortable="true" data-visible="false">Address
                                            Proof</th>
                                        <th data-field="permissions" data-sortable="true" data-visible="false">
                                            Permissions</th>
                                        <th data-field="date" data-sortable="true" data-visible="false">Date</th>
                                        <th data-field="operate" data-sortable="false">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Seller Commission Offcanvas -->
<div class="offcanvas offcanvas-end offcanvas-medium" tabindex="-1" id="sellerCommissionOffcanvas"
    aria-labelledby="sellerCommissionOffcanvasLabel">
    <div class="offcanvas-header">
        <h2 class="offcanvas-title" id="sellerCommissionOffcanvasLabel">Manage Seller Commission</h2>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form class="form-submit-event" action="<?= base_url('admin/sellers/update_seller_commission') ?>" method="POST"
            id="seller_commission_form" enctype="multipart/form-data">

            <div class="mb-3 row">
                <label class="col-3 col-form-label required" for="seller_id">Select Seller</label>
                <div class="col">
                    <select name="seller_id" id="seller_id" class="form-select" required>
                        <option value="">Select Seller</option>
                        <?php if (!empty($sellers)): ?>
                            <?php foreach ($sellers as $seller): ?>
                                <option value="<?= $seller['id'] ?>">
                                    <?= htmlspecialchars($seller['first_name'] . ' ' . $seller['last_name']) ?>
                                    (<?= htmlspecialchars($seller['email']) ?>)
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>

            <div id="repeater">
                <div class="repeater-item">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="col-md-5">
                            <label class="col-form-label">Category</label>
                            <select name="category_id[]" class="form-select" required>
                                <option value="">Select Category</option>
                                <?php if (!empty($categories)): ?>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['id'] ?>">
                                            <?= htmlspecialchars($category['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label class="col-form-label">Commission (%)</label>
                            <input type="number" class="form-control" name="commission[]" placeholder="Commission (%)"
                                min="0" max="100" step="0.01" required>
                        </div>
                        <div class="col-md-2">
                            <label class="col-form-label">&nbsp;</label>
                            <a type="button" class="remove-btn text-decoration-none d-block" title="Remove Category">
                                <i class="fs-2 text-danger ti ti-xbox-x"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <button type="button" id="add-more" class="btn btn-primary bg-primary-lt btn-sm">
                    Add More <i class="ti ti-plus ms-2"></i>
                </button>
            </div>

            <div class="space-y mt-5">
                <div class="form-group text-end">
                    <button type="reset" class="btn btn-1">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-2" id="submit_btn">Update Seller
                        Commission <i class="cursor-pointer ms-2 ti ti-arrow-right"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    const categoriesData = <?= json_encode($categories) ?>;
    const sellersData = <?= json_encode($sellers) ?>;
    console.log('Categories Data from PHP:', categoriesData);
</script>