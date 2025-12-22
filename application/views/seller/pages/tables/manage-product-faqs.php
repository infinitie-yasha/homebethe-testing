<div class="page-wrapper">


    <!-- BEGIN PAGE HEADER -->
    <div class="page-header d-print-none" aria-label="Page header">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">Product FAQs</h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="d-flex">
                        <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('seller/home') ?>">Home</a>
                            </li>
                              <li class="breadcrumb-item active" aria-current="page">
                                <a href="#">Product </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="#">Product FAQs</a>
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
                        <h3 class="card-title">
                            <i class="ti ti-message-question me-2"></i> Product FAQs
                        </h3>


                        <!-- Trigger Modal Instead of Redirect -->
                        <button type="button" class="btn btn-primary bg-primary-lt btn-sm addProductFaq"
                            data-bs-toggle="offcanvas" data-bs-target="#product_faq_value_id">
                            Add Product FAQs
                        </button>
                    </div>

                    <div class="card-body">
                        <table class="table table-striped" id="products_faqs_table" data-toggle="table"
                            data-url="<?= base_url('seller/product_faqs/get_faqs_list') ?>" data-click-to-select="true"
                            data-side-pagination="server" data-pagination="true"
                            data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                            data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                            data-sort-order="desc" data-mobile-responsive="true" data-toolbar="" data-show-export="true"
                            data-maintain-selected="true" data-export-types='["txt","excel","csv"]' data-export-options='{
                                "fileName": "products-list",
                                "ignoreColumn": ["state"]
                            }' data-query-params="faqParams">
                            <thead>
                                <tr>
                                    <th data-field="id" data-sortable="true">ID</th>
                                    <th data-field="user_id" data-sortable="false" data-visible="false">User Id</th>
                                    <th data-field="product_id" data-sortable="false" data-visible="false">Product Id
                                    </th>
                                    <th data-field="product_name" data-sortable="false" data-visible="false">Product
                                        Name</th>
                                    <th data-field="question" data-sortable="false"
                                        data-formatter="itemsReadMoreFormatter">Question</th>
                                    <th data-field="answer" data-sortable="false"
                                        data-formatter="itemsReadMoreFormatter">Answer</th>
                                    <th data-field="answered_by" data-sortable="false" data-visible="false">Answered by
                                    </th>
                                    <th data-field="answered_by_name" data-sortable="false">Answered by Name</th>
                                    <th data-field="username" data-width="500" data-sortable="false" class="col-md-6">
                                        Username</th>
                                    <th data-field="date_added" data-sortable="false">Date added</th>
                                    <th data-field="operate" data-sortable="false">Operate</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- Offcanvas for Product FAQ -->
                    <div class="offcanvas offcanvas-end offcanvas-medium"  aria-labelledby="faqOffcanvasLabel"
                        id="product_faq_value_id">
                        <!-- Offcanvas Header -->
                        <div class="offcanvas-header">
                            <h2 class="offcanvas-title" id="faqOffcanvasLabel">Add FAQs</h2>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <!-- Offcanvas Body -->
                        <div class="offcanvas-body">
                        


                                  <form x-data="ajaxForm({
                                            url: base_url + 'seller/product_faqs/add_faqs',
                                            offcanvasId: 'product_faq_value_id',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="product_edit_faq_form">
                                <!-- CSRF -->
                                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                                    value="<?= $this->security->get_csrf_hash(); ?>" class="csrf_token">
                                <!-- Hidden Fields -->
                                <input type="hidden" name="user_id" id="user_id" value="<?= $_SESSION['user_id'] ?>">
                                <input type="hidden" name="edit_product_faq" id="edit_product_faq" value="">
                                <input type="hidden" name="hidden_question" id="hidden_question" value="">
                                <input type="hidden" name="hidden_product_id" id="hidden_product_id" value="">

                                <!-- Product Select -->
                                <div class="mb-3 row ProductSelect">
                                            <div x-data x-init="initTomSelect({
                                                    element: $refs.ProductSelect,
                                                    url: '<?= base_url('seller/product/get_product_data') ?>?from_select=1',
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
                                
                                <!-- Question -->
                                <div class="mb-3 row">
                                    <label for="question" class="col-12 col-md-4 col-form-label fw-semibold">Question</label>
                                    <div class="col">
                                        <textarea class="form-control" id="question" name="question"
                                            rows="4"></textarea>
                                    </div>
                                </div>

                                <!-- Answer --> 
                                <div class="mb-3 row">
                                    <label for="answer" class="col-12 col-md-4 col-form-label fw-semibold required">Answer</label>
                                    <div class="col">
                                        <input type="text" class="form-control" id="answer" name="answer"
                                            placeholder="Answer">
                                    </div>
                                </div>

                                <!-- Footer Buttons -->
                                <div class="d-flex justify-content-end gap-2 mt-3">
                                    <button type="reset" class="btn btn-warning">
                                        <i class="ti ti-refresh me-1"></i> Reset
                                    </button>

                                    <button type="submit" class="btn btn-primary" id="submit_btn">
                                        <i class="ti ti-device-floppy me-1"></i> Update FAQs
                                    </button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>