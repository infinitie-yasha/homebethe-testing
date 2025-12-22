<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">Manage Products Stock</h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="d-flex">
                            <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/home') ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">Product Stock</a>
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
                            <h3 class="card-title"><i class="ti ti-box"></i> Manage Products Stock</h3>
                        </div>
                        <div class="card-body">
                            <div id="filterTemplate" class="row g-3 align-items-end">

                                <!-- Seller Filter -->
                                <div class="col-12 col-sm-6 col-lg-4" x-data x-init="initTomSelect({
             element: $refs.sellerSelect,
             url: '<?= base_url('admin/product/get_sellers_data') ?>',
             placeholder: 'Search Seller...',
             offcanvasId: 'filterOffcanvas',
             maxItems: 1,
             preloadOptions: true
         })">
                                    <label class="form-label" for="sellerSelect">Seller</label>
                                    <select x-ref="sellerSelect" class="form-select" name="seller_id"
                                        id="seller_filter"></select>
                                </div>

                                <!-- Category Filter -->
                                <div class="col-12 col-sm-6 col-lg-4" x-data x-init="initTomSelect({
             element: $refs.categorySelect,
             url: '<?= base_url('admin/product/get_categories_data') ?>',
             placeholder: 'Search Category...',
             offcanvasId: 'filterOffcanvas',
             maxItems: 1,
             preloadOptions: true
         })">
                                    <label class="form-label" for="categorySelect">Category</label>
                                    <select x-ref="categorySelect" class="form-select" name="category_parent"
                                        id="categorySelect"></select>
                                </div>

                                <!-- Reset Button -->
                                <div
                                    class="col-12 col-sm-6 col-lg-4 d-flex justify-content-start justify-content-lg-end mt-2">
                                    <button type="button" class="btn btn-outline-secondary w-sm-auto"
                                        onclick="resetfilters()">
                                        <i class="ti ti-refresh"></i> Reset
                                    </button>
                                </div>

                            </div>


                            <table class='table-striped' id='product_stock_table' data-toggle="table"
                                data-filter-template="filterTemplate" data-filter-title="Stock Filters"
                                data-filter-button-text="🔍 Filter Stock" data-filter-button-icon="ti-filter"
                                data-url="<?= isset($_GET['flag']) ? base_url('admin/manage_stock/get_stock_list?flag=') . $_GET['flag'] : base_url('admin/manage_stock/get_stock_list') ?>"
                                data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                                data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                                data-sort-order="desc" data-mobile-responsive="true" data-toolbar=""
                                data-show-export="true" data-maintain-selected="true"
                                data-export-types='["txt","excel","csv"]' data-export-options='{
                            "fileName": "products-list",
                            "ignoreColumn": ["state"]
                            }' data-query-params="stock_query_params">
                                <thead>
                                    <tr>
                                        <th data-field="product_id" data-sortable="true" data-align='center'>Product ID
                                        </th>
                                        <th data-field="name" data-sortable="false" data-align='center'>Name</th>
                                        <th data-field="seller_name" data-sortable="false" data-visible="false">Seller
                                            Name</th>
                                        <th data-field="category_name" data-sortable="false" data-visible="false">
                                            Category</th>
                                        <th data-field="stock_type" data-sortable="false" data-align='center'>Stock Type
                                        </th>
                                        <th data-field="image" data-sortable="false" data-align='center'>Image</th>
                                        <th data-field="operate" data-sortable="false" data-align='center'>Variants -
                                            Stock</th>
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

<!-- Stock Management Offcanvas -->
<div class="offcanvas offcanvas-end offcanvas-medium" id="editVariantOffcanvas" tabindex="-1"
    aria-labelledby="stockOffcanvasLabel" aria-hidden="true">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="stockOffcanvasLabel">Manage Stock</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <form x-data="ajaxForm({
                                            url: base_url + 'admin/manage_stock/update_stock',
                                            offcanvasId: 'editVariantOffcanvas',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="stock_adjustment_form"
        enctype="multipart/form-data">
        <div class="offcanvas-body" id="stock_modal_body">
            <input type="hidden" name="variant_id" value="">

            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <label class="col-form-label" for="product_name">Product</label>
                        <input type="text" class="form-control" id="product_name" placeholder="Product name"
                            name="product_name" value="" readonly>
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-3">
                        <label class="col-form-label"
                            for="current_stock"><?= labels('current_stock', 'Current Stock') ?></label>
                        <input type="text" class="form-control current_stock" name="current_stock" id="current_stock"
                            value="" readonly>
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-3">
                        <label class="col-form-label required"
                            for="quantity"><?= labels('quantity', 'Quantity') ?></label>
                        <input type="number" class="form-control" name="quantity" id="quantity" min="1" required>
                    </div>
                </div>

                <div class="col-4">
                    <div class="mb-3">
                        <label class="col-form-label" for="type"><?= labels('type', 'Type') ?></label>
                        <select class="form-select" id="type" name="type">
                            <option value='add'><?= labels('add', 'Add') ?></option>
                            <option value='subtract'><?= labels('subtract', 'Subtract') ?></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="text-end">
                <!-- <button type="reset" class="btn btn-warning ">Reset</button> -->
                <button type="submit" class="btn btn-primary" id="submit_btn">Update Stock</button>
                <button type="button" class="btn" data-bs-dismiss="offcanvas" aria-label="Close">Close</button>
            </div>

        </div>
    </form>
</div>