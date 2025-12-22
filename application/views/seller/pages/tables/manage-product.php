<div class="page-wrapper">

    <div class="page-header d-print-none" aria-label="Page header">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">Manage Products </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="d-flex">
                        <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('seller/home') ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="#">products</a>
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
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title"><i class="ti ti-package"></i> Manage Products</h3>
                        <a href="<?= base_url() . 'seller/product/create_product' ?>"
                            class="btn btn-primary bg-primary-lt btn-sm">
                            Add Product
                        </a>
                    </div>
                    <div class="card-body p-4">
                        <div id="filterTemplate" class="d-flex flex-wrap gap-3 align-items-end">

                            <!-- Product Category -->
                            <div class="filter-item" x-data x-init="initTomSelect({
                                        element: $refs.categoryParent,
                                        placeholder: 'Select Category',
                                        maxItems: 1,
                                        preloadOptions: true
                                    })" style="flex: 1 1 250px; min-width: 220px;">
                                <label for="category_parent" class="form-label mb-1">Product Category</label>
                                <select id="category_parent" name="category_parent" x-ref="categoryParent"
                                    class="form-select">
                                    <option value="">
                                        <?= (isset($categories) && empty($categories)) ? 'No Categories Exist' : 'Select Category' ?>
                                    </option>
                                    <?php echo get_categories_option_html($categories); ?>
                                </select>
                            </div>

                            <!-- Product Status -->
                            <div class="filter-item" style="flex: 1 1 200px; min-width: 180px;">
                                <label for="status_filter" class="form-label mb-1">Status</label>
                                <select class="form-select" name="status" id="status_filter">
                                    <option value="">Select Status</option>
                                    <option value="1">Approved</option>
                                    <option value="2">Not-Approved</option>
                                    <option value="0">Deactivated</option>
                                </select>
                            </div>

                            <!-- Reset Button -->
                            <div class="filter-item d-flex align-items-end" style="flex: 0 0 auto;">
                                <button type="button" class="btn btn-outline-secondary" onclick="resetfilters()">
                                    <i class="ti ti-refresh"></i> Reset
                                </button>
                            </div>

                        </div>

                        <table class='table-striped' id='products_table' data-toggle="table"
                            data-filter-template="filterTemplate" data-filter-title="Product Filters"
                            data-filter-button-text="🔍 Filter Products" data-filter-button-icon="ti-filter"
                            data-url="<?= isset($_GET['flag']) ? base_url('seller/product/get_product_data?flag=') . $_GET['flag'] : base_url('seller/product/get_product_data') ?>"
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
                                    <th data-field="id" data-sortable="true" data-visible='false' data-align='center'>ID
                                    </th>
                                    <th data-field="image" data-sortable="true" data-align='center'>Image</th>
                                    <th data-field="name" data-sortable="false" data-align='center'>Name</th>
                                    <th data-field="brand" data-sortable="false" data-align='center'>Brand</th>
                                    <th data-field="category_name" data-sortable="false" data-align='center'>
                                        Category Name</th>
                                    <th data-field="rating" data-sortable="true" data-align='center'>Rating</th>
                                    <th data-field="variations" data-sortable="false" data-visible='false'
                                        data-align='center'>Variations</th>
                                    <th data-field="approval_status" data-sortable="false" data-align='center'>Approval
                                        Status</th>
                                    <th data-field="rejection_reason" data-visible="false" data-sortable="false" data-align='center'>
                                        Rejection Reason</th>
                                    <th data-field="status" data-sortable="false" data-align='center'>Status</th>
                                    <th data-field="operate" data-sortable="false" data-align='center'>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                </div>
            </div><!-- .card -->
        </div>
</div>
<!-- /.row -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="product-faqs-modal"
    aria-labelledby="product-faqs-modalLabel">
    <div class="offcanvas-header">
        <h2 class="offcanvas-title" id="product-faqs-modalLabel">
            <i class="ti ti-message-question me-2"></i>
            Product FAQs
        </h2>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body">
        <div class="card">
            <div class="card-body p-0">
                <div class="">
                    <table class='table table-vcenter card-table' id='product-faqs-table' data-toggle="table"
                        data-url="<?= base_url('seller/product/get_faqs_list') ?>" data-click-to-select="true"
                        data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]"
                        data-search="true" data-show-columns="true" data-show-refresh="true" data-trim-on-search="false"
                        data-sort-name="id" data-sort-order="desc" data-mobile-responsive="true" data-toolbar=""
                        data-show-export="true" data-maintain-selected="true" data-export-types='["txt","excel"]'
                        data-export-options='{
                        "fileName": "product-faqs-list",
                        "ignoreColumn": ["operate"] 
                        }' data-query-params="queryParams">
                        <thead>
                            <tr>
                                <th data-field="id" data-sortable="true" data-width="60">ID</th>
                                <th data-field="username" data-sortable="false">Customer</th>
                                <th data-field="question" data-sortable="false">Question</th>
                                <th data-field="answer" data-sortable="false">Answer</th>
                                <th data-field="date_added" data-sortable="false" data-width="130">Date</th>
                                <th data-field="operate" data-sortable="false" data-width="100">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <div class="alert alert-info" role="alert">
                <div class="d-flex">
                    <div>
                        <i class="ti ti-info-circle icon alert-icon"></i>
                    </div>
                    <div>
                        <h4 class="alert-title">About Product FAQs</h4>
                        <div class="text-secondary">Manage customer questions and your answers about this product. Clear
                            answers help boost customer confidence and sales.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>


<!-- Product Rating Offcanvas -->




<!-- Product View Offcanvas (Dynamic Loading) -->
<div class="offcanvas offcanvas-end offcanvas-medium" tabindex="-1" id="viewProductOffcanvas"
    aria-labelledby="productOffcanvasLabel" data-bs-backdrop="static">
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