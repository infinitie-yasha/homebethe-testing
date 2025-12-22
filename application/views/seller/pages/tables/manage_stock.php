<div class="page-wrapper">



    <!-- BEGIN PAGE HEADER -->
    <div class="page-header d-print-none" aria-label="Page header">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">Manage Stocks</h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="d-flex">
                        <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('seller/home') ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="#">Manage Stocks</a>
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
                        <h3 class="card-title"><i class="ti ti-stack"></i> Manage Stocks</h3>
                    </div>
                     <div class="col-md-4 col-sm-6 m-4">
                <select class="form-select" id="stock_product_categories" name="category_parent">
                  <option value="">
                    <?= (isset($categories) && empty($categories)) ? 'No Categories Exist' : 'Select Categories' ?>
                  </option>
                  <?php echo get_categories_option_html($categories); ?>
                </select>
              </div>



                    <div class="card-body">

                        <table class="table-striped" id="product_stock_table" data-bs-toggle="table"
                            data-url="<?= base_url('seller/manage_stock/get_stock_list') ?>" data-click-to-select="true"
                            data-side-pagination="server" data-pagination="true"
                            data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                            data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                            data-sort-order="desc" data-mobile-responsive="true" data-toolbar="" data-show-export="true"
                            data-maintain-selected="true" data-export-types='["txt","excel","csv"]'
                            data-export-options='{"fileName": "products-list","ignoreColumn": ["state"] }'
                            data-query-params="stock_query_params">
                            <thead>
                                <tr>
                                    <th data-field="id" data-sortable="true">Variant ID</th>
                                    <th data-field="name" data-sortable="false" class="col-md-2">Name</th>
                                    <th data-field="category_name" data-sortable="false" data-visible="false">Category
                                    </th>
                                    <th data-field="stock_type" data-sortable="false" data-align='center'>Stock Type
                                    </th>
                                    <th data-field="image" data-sortable="false">Image</th>
                                    <th data-field="operate" data-sortable="false">Variants - Stock</th>
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

<!-- offcanvas for edit stock -->
<input type="hidden" name="csrf_token_name" value="<?php echo $this->security->get_csrf_hash(); ?>">
<div id="manage_stock" class="offcanvas offcanvas-end offcanvas-medium edit-offcanvas-medium" tabindex="-1"
    role="dialog" aria-labelledby="myLargeoffcanvasLabel" aria-hidden="true">
    <div class="offcanvas-dialog offcanvas-m">
        <div class="offcanvas-content">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">Manage Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <form x-data="ajaxForm({
        url: base_url + 'seller/manage_stock/update_stock',
        offcanvasId: 'manage_stock',
        loaderText: 'Saving...',
       
    })" method="POST" class="form-horizontal" id="stock_adjustment_form" enctype="multipart/form-data">
                    <div class="offcanvas-body">
                        <div class=" g-3">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="product_name"
                                        class="form-label"><?= labels('product', 'Product') ?></label>
                                    <input type="text" class="form-control" id="product_name" name="product_name"
                                        readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="current_stock"
                                            class="form-label"><?= labels('current_stock', 'Current Stock') ?></label>
                                        <input type="text" class="form-control" name="current_stock" id="current_stock"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="quantity" class="form-label"><?= labels('quantity', 'Quantity') ?>
                                            <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="quantity" id="quantity" min="1"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="type" class="form-label"><?= labels('type', 'Type') ?></label>
                                        <select class="form-select" id="type" name="type">
                                            <option value="add"><?= labels('add', 'Add') ?></option>
                                            <option value="subtract"><?= labels('subtract', 'Subtract') ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-end">
                                <button type="submit"
                                    class="btn btn-success"><?= labels('update_stock', 'Update Stock') ?></button>
                            </div>
                        </div>
                        <!-- Hidden fields -->
                        <input type="hidden" name="variant_id" id="variant_id" value="">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                            value="<?= $this->security->get_csrf_hash(); ?>">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>