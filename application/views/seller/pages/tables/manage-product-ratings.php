<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">
        <div class="row g-2 align-items-center">

            <!-- Page Title -->
            <div class="col-12 col-sm-auto flex-grow-1">
                <h2 class="page-title mb-2 mb-sm-0">Manage Products Ratings</h2>
            </div>

            <!-- Breadcrumb -->
            <div class="col-12 col-sm-auto ms-sm-auto d-print-none">
                <div class="d-flex justify-content-sm-end">
                    <ol class="breadcrumb breadcrumb-arrows flex-wrap" aria-label="breadcrumbs">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('seller/home') ?>">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('seller/product') ?>">Products</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <a href="#">Product Ratings</a>
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
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h3 class="card-title"><i class="ti ti-star"></i> Product Ratings</h3>
                        </div>
                        <div class="card-body">
                            <div class="col-md-3">
                                <label for="ProductSelect" class="col-form-label">Filter By Product</label>
                                <div x-data x-init="initTomSelect({
                                                    element: $refs.ProductSelect,
                                                     url: '<?= base_url('seller/product/get_product_data_for_faq') ?>',
                                                    placeholder: 'Search Products...',
                                                    maxItems: 1,
                                                    preloadOptions: true
                                                })" class="mb-3 row">


                                    <div class="col">
                                        <select x-ref="ProductSelect" name="product_ids[]" class="form-select"
                                            id="ProductSelect"></select>
                                    </div>
                                </div>
                            </div>
                            <table class='table-striped' id="products_ratings_table" data-toggle="table"
                                data-url="<?= base_url('seller/product_ratings/get_ratings_list') ?>"
                                data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                                data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                                data-sort-order="desc" data-mobile-responsive="true" data-toolbar=""
                                data-show-export="true" data-maintain-selected="true"
                                data-export-types='["txt","excel","csv"]' data-export-options='{
                                    "fileName": "ratings-list",
                                    "ignoreColumn": ["state"] 
                                    }' data-query-params="product_rating_query_params">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true" data-align='center'>ID</th>
                                        <th data-field="product_id" data-sortable="true" data-align='center'
                                            data-visible="false">Product ID</th>
                                        <th data-field="username" data-sortable="false" data-align='center'>Username
                                        </th>
                                        <th data-field="product_name" data-sortable="false" data-align='center'>Product
                                            Name
                                        </th>
                                        <th data-field="images" data-sortable="false" data-align='center'>Images</th>
                                        <th data-field="rating" data-sortable="false" data-align='center'>Rating</th>
                                        <th data-field="comment" data-sortable="false" data-align='center'
                                            data-formatter="itemsReadMoreFormatter">Comment</th>
                                        <th data-field="date_added" data-sortable="false" data-align='center'>Date Added
                                        </th>
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