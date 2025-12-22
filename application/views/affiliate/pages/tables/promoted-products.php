<div class="page-wrapper">
    <!-- Content Header (Page header) -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">Manage Promoted Products</h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="d-flex">
                        <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                            <li class="breadcrumb-item"><a href="<?= base_url('admin/home') ?>">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"> Promoted Products</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Promoted Products</h3>
                        </div>
                        <div class="card-body">
                            <!-- Category Filter -->
                            <div class="mb-3">
                                <label for="category_filter" class="form-label">Filter by Category</label>
                                <select id="category_filter" class="form-select" style="max-width:300px;">
                                    <option value="">All Categories</option>
                                    <?php if (isset($categories) && is_array($categories)): ?>
                                        <?php foreach ($categories as $cat): ?>
                                            <option value="<?= htmlspecialchars($cat['id']) ?>"><?= htmlspecialchars($cat['name']) ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-vcenter table-striped" id="products_table" data-toggle="table" 
                                    data-url="<?= isset($_GET['flag']) ? base_url('affiliate/product/get_my_promoted_products_list?flag=') . $_GET['flag'] : base_url('affiliate/product/get_my_promoted_products_list') ?>"
                                    data-click-to-select="true" data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]"
                                    data-search="true" data-show-columns="true" data-show-refresh="true" data-trim-on-search="false" data-sort-name="id" data-sort-order="desc"
                                    data-mobile-responsive="true" data-toolbar="" data-show-export="true" data-maintain-selected="true" data-export-types='["txt","excel","csv"]' 
                                    data-export-options='{"fileName": "products-list", "ignoreColumn": ["state"]}' data-query-params="category_query_params">
                                    <thead>
                                        <tr>
                                            <th data-field="id" data-sortable="true" data-visible="true" data-align="center">ID</th>
                                            <th data-field="product_id" data-sortable="true" data-align="center">Product ID</th>
                                            <th data-field="image" data-sortable="false" data-align="center">Image</th>
                                            <th data-field="name" data-sortable="false" data-align="center">Name</th>
                                            <th data-field="category_name" data-sortable="false" data-align="center">Category Name</th>
                                            <th data-field="affiliate_commission" data-sortable="true" data-align="center">Category Commission</th>
                                            <th data-field="usage_count" data-sortable="true" data-align="center">Usage Count</th>
                                            <th data-field="commission_earned" data-sortable="true" data-align="center">Commission Earned</th>
                                            <th data-field="date" data-sortable="true" data-align="center">Date</th>
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
</div>