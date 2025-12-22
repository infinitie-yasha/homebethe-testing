<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">Manage Products</h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="d-flex">
                            <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/home') ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">Products</a>
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
                            <h3 class="card-title"><i class="ti ti-user-circle"></i> Manage Products</h3>
                            <div>
                                <a href="<?= base_url() . 'admin/product/create_product' ?>"
                                    class="btn btn-primary add_product_btn btn-sm bg-primary-lt">Add Product</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="filterTemplate" class="d-flex gap-3 justify-content-beetween flex-wrap">
                                <!-- <div class="offcanvas-body"> -->

                                <div x-data x-init="initTomSelect({
                                                        element: $refs.categorySelect,
                                                        url: '<?= base_url('admin/product/get_categories_data') ?>',
                                                        placeholder: 'Search Category...',
                                                        offcanvasId: 'filterOffcanvas',
                                                        maxItems: 1,
                                                        preloadOptions: true
                                                    })" class="mb-3 row">

                                    <label class="col-form-label" for="categorySelect">Category</label>
                                    <div class="col">
                                        <select x-ref="categorySelect" class="form-select" name="category_id"
                                            id="category_parent"></select>
                                    </div>
                                </div>

                                <!-- <div class="mb-3">
                                    <label for="status_filter" class="col-form-label">Status</label>
                                    <select class="form-select" name="status" id="status_filter">
                                        <option value=''>Select Status</option>
                                        <option value='1'>Approved</option>
                                        <option value='2'>Not-Approved</option>
                                        <option value='0'>Deactivated</option>
                                    </select>



                                </div> -->
                                <div class="mb-3">
                                    <label class="col-form-label" for="status_filter">Status</label>
                                    <select class="form-select" name="status" id="status_filter">
                                        <option value=''>Select Status</option>
                                        <option value='1'>Approved</option>
                                        <option value='2'>Not-Approved</option>
                                        <option value='0'>Deactivated</option>
                                    </select>
                                </div>

                                <div x-data x-init="initTomSelect({
                                                        element: $refs.sellerSelect,
                                                        url: '<?= base_url('admin/product/get_sellers_data') ?>',
                                                        placeholder: 'Search Seller...',
                                                        offcanvasId: 'filterOffcanvas',
                                                        maxItems: 1,
                                                        preloadOptions: true
                                                    })" class="mb-3 row  col-md-3">

                                    <label class="col-form-label" for="sellerSelect">Seller</label>
                                    <div class="col">
                                        <select x-ref="sellerSelect" class="form-select" name="seller_id"
                                            id="seller_filter"></select>
                                    </div>
                                </div>

                                <div x-data x-init="initTomSelect({
                                                        element: $refs.brandSelect,
                                                        url: '<?= base_url('admin/product/get_brands_data') ?>',
                                                        placeholder: 'Search Brand...',
                                                        offcanvasId: 'filterOffcanvas',
                                                        dataAttribute: '',
                                                        maxItems: 1,
                                                        preloadOptions: true
                                                    })" class="mb-3 row col-md-3">

                                    <label class="col-form-label" for="brandSelect">Brand</label>
                                    <div class="col">
                                        <select x-ref="brandSelect" class="form-select" name="brand"
                                            id="brand_filter"></select>
                                    </div>
                                </div>

                                <div class="mt-4 pt-3">
                                    <button type="button" class="btn btn-outline-secondary" onclick="resetfilters()">
                                        <i class="ti ti-refresh"></i> Reset
                                    </button>

                                </div>
                                <!-- <div class="mt-4 pt-3">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <button type="button" class="btn btn-primary" onclick="applyFilters()">
                                            <i class="ti ti-filter"></i> Apply Filters
                                        </button>
                                    </div>
                                </div> -->
                                <!-- </div> -->
                            </div>

                            <table class='table-striped' id='products_table' data-toggle="table"
                                data-filter-template="filterTemplate" data-filter-title="Product Filters"
                                data-filter-button-text="🔍 Filter Products" data-filter-button-icon="ti-filter"
                                data-url="<?= isset($_GET['flag']) ? base_url('admin/product/get_product_data?flag=') . $_GET['flag'] : base_url('admin/product/get_product_data') ?>"
                                data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                                data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                                data-sort-order="desc" data-mobile-responsive="true" data-toolbar="#custom-toolbar"
                                data-show-export="true" data-maintain-selected="true"
                                data-export-types='["txt","excel","csv"]' data-export-options='{
                            "fileName": "products-list",
                            "ignoreColumn": ["state"]
                            }' data-query-params="product_query_params">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true" data-visible='false'
                                            data-align='center'>ID</th>
                                        <th data-field="image" data-sortable="true" data-align='center'>Image</th>
                                        <th data-field="name" data-sortable="false" data-align='center'>Name</th>
                                        <th data-field="brand" data-sortable="false" data-align='center'>Brand</th>
                                        <th data-field="category_name" data-sortable="true" data-align='center'>
                                            Category Name</th>
                                        <th data-field="rating" data-sortable="true" data-align='center'>Rating</th>
                                        <th data-field="variations" data-sortable="false" data-visible='false'
                                            data-align='center'>Variations</th>
                                        <th data-field="approval_status" data-sortable="false" data-align='center'>
                                            Approval Status</th>
                                        <th data-field="rejection_reason" data-visible="false" data-sortable="false" data-align='center'>
                                            Rejection Reason</th>
                                        <th data-field="status" data-sortable="false" data-align='center'>Status</th>
                                        <th data-field="operate" data-sortable="false" data-align='center'>Action</th>
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

<!-- Product View Offcanvas (Dynamic Loading) -->
<div class="offcanvas offcanvas-end offcanvas-medium" tabindex="-1" id="viewProductOffcanvas"
    aria-labelledby="productOffcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="productOffcanvasLabel">
            <i class="ti ti-box me-2"></i>Product Details
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body" id="productOffcanvasBody">
        <!-- Loading placeholder -->
        <div class="d-flex justify-content-center align-items-center p-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
</div>