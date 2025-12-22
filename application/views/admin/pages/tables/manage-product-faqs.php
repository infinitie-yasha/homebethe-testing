<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
<div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">
        <div class="row g-2 align-items-center">

            <!-- Page Title -->
            <div class="col-12 col-md">
                <h2 class="page-title mb-2 mb-md-0">Manage Products FAQs</h2>
            </div>

            <!-- Breadcrumb -->
            <div class="col-12 col-md-auto">
                <div class="d-flex justify-content-md-end">
                    <ol class="breadcrumb breadcrumb-arrows mb-0">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('admin/home') ?>">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('admin/product') ?>">Products</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Product FAQs
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
                            <h3 class="card-title"><i class="ti ti-help-hexagon"></i> FAQ</h3>
                            <a class="btn btn-primary AddProductFAQBtn btn-sm bg-primary-lt" data-bs-toggle="offcanvas"
                                data-bs-target="#addProductFAQ" href="#" role="button" aria-controls="addProductFAQ">
                                Add Product FAQs </a>
                        </div>
                        <div class="card-body">
                            <div class="col-md-3">
                                <label for="ProductSelect" class="col-form-label">Filter By Product</label>
                                <div x-data x-init="initTomSelect({
                                                    element: $refs.ProductSelect,
                                                    url: '<?= base_url('admin/product/get_product_data') ?>?from_select=1',
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
                            <table class='table-striped' id="products_faqs_table" data-toggle="table"
                                data-url="<?= base_url('admin/product_faqs/get_faqs_list') ?>"
                                data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                                data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                                data-sort-order="desc" data-mobile-responsive="true" data-toolbar=""
                                data-show-export="true" data-maintain-selected="true"
                                data-export-types='["txt","excel","csv"]' data-export-options='{
                                    "fileName": "faq-list",
                                    "ignoreColumn": ["state"] 
                                    }' data-query-params="product_faq_query_params">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true" data-align='center'>ID</th>
                                        <th data-field="user_id" data-sortable="false" data-visible='false'
                                            data-align='center'>User Id</th>
                                        <th data-field="product_id" data-sortable="false" data-visible='false'
                                            data-align='center'>Product Id</th>
                                        <th data-field="product_name" data-sortable="false" data-align='center'
                                            class="col-md-4">Product
                                            Name</th>
                                        <th data-field="question" data-sortable="false" data-align='center'
                                            data-formatter="itemsReadMoreFormatter">Question</th>
                                        <th data-field="answer" data-sortable="false" data-align='center'
                                            data-formatter="itemsReadMoreFormatter">Answer</th>
                                        <!-- <th data-field="answered_by" data-sortable="false" data-visible='false'
                                            data-align='center'>Answered by</th> -->
                                        <th data-field="answered_by_name" data-sortable="false" data-align='center'>
                                            Answered by</th>
                                        <th data-field="username" data-sortable="false" data-align='center'>Username
                                        </th>
                                        <th data-field="date_added" data-sortable="false" data-visible="false"
                                            data-align='center'>Date added
                                        </th>
                                        <th data-field="operate" data-sortable="false" data-align='center'>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="offcanvas offcanvas-end offcanvas-medium" tabindex="-1" id="addProductFAQ"
                            aria-labelledby="addProductFAQLabel">
                            <div class="offcanvas-header">
                                <h2 class="offcanvas-title" id="addProductFAQLabel">Add Product FAQs</h2>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <form x-data="ajaxForm({
                                            url: base_url + 'admin/product_faqs/add_faqs',
                                            offcanvasId: 'addProductFAQ',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="add_product_faq_form">
                                <div class="offcanvas-body">
                                    <div>

                                        <input type="hidden" name="edit_product_faq" id="edit_product_faq" value="">
                                        <input type="hidden" name="seller_id" id="seller_id" value="">
                                        <input type="hidden" name="question" id="hidden_question" value="">

                                        <div class="mb-3 row ProductSelect">
                                            <div x-data x-init="initTomSelect({
                                                    element: $refs.ProductSelect,
                                                    url: '<?= base_url('admin/product/get_product_data') ?>?from_select=1',
                                                    placeholder: 'Search Products...',
                                                    offcanvasId: 'addProductFAQ',
                                                    dataAttribute: 'data-product-id',
                                                    maxItems: 1,
                                                    preloadOptions: true
                                                })" class="mb-3 row">

                                                <label class="col-12 col-md-4 col-form-label required" for="ProductSelect">Select
                                                    Products</label>
                                                <div class="col">
                                                    <select x-ref="ProductSelect" name="product_id" class="form-select"
                                                        id="ProductSelect"></select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="mb-3 row">
                                            <div class="mb-3 row ">
                                                <label class="col-12 col-md-4 col-form-label required"
                                                    for="question">Question</label>
                                                <div class="col">
                                                    <input type="text" class="form-control" name="question"
                                                        id="question" placeholder="Question" />
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <label class="col-12 col-md-4 col-form-label required" for="answer">Answer</label>
                                                <div class="col">
                                                    <textarea name="answer" class="textarea form-control" id="answer"
                                                        placeholder="Answer" data-bs-toggle="autosize"> </textarea>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="text-end">
                                            <!-- <button type="reset" class="btn btn-warning ">Reset</button> -->
                                            <button type="button" class="btn" data-bs-dismiss="offcanvas"
                                                aria-label="Close">Close</button>
                                            <button type="submit" class="btn btn-primary save_product_faq_btn"
                                                id="submit_btn">Add Product FAQs</button>
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