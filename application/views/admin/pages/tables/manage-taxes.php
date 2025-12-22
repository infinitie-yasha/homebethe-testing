<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">Manage Taxes</h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="d-flex">
                            <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/home') ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/product') ?>">Manage Products</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">Tax</a>
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
                            <h3 class="card-title"><i class="ti ti-circle-percentage"></i> Tax Details</h3>
                            <a class="btn btn-primary addTaxBtn btn-sm bg-primary-lt" data-bs-toggle="offcanvas"
                                data-bs-target="#addTax" href="#" role="button" aria-controls="addTax"> Add
                                Tax</a>
                        </div>
                        <div class="card-body">
                            <table class='table-striped' id="tax_table" data-toggle="table"
                                data-url="<?= base_url('admin/taxes/get_tax_list') ?>" data-click-to-select="true"
                                data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                                data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                                data-sort-order="desc" data-mobile-responsive="true" data-toolbar=""
                                data-show-export="true" data-maintain-selected="true">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true" data-align='center'>ID</th>
                                        <th data-field="title" data-sortable="false" data-align='center'>Title</th>
                                        <th data-field="percentage" data-sortable="true" data-align='center'>Percentage
                                        </th>
                                        <th data-field="operate" data-sortable="false" data-align='center'>Action</th>
                                    </tr>
                                </thead>
                            </table>

                            <div class="offcanvas offcanvas-end offcanvas-medium" tabindex="-1" id="addTax"
                                aria-labelledby="addTaxLabel">
                                <div class="offcanvas-header">
                                    <h2 class="offcanvas-title" id="addTaxLabel">Add Tax</h2>
                                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <form x-data="ajaxForm({
                                            url: base_url + 'admin/taxes/add_tax',
                                            offcanvasId: 'addTax',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="add_tax_form">
                                    <div class="offcanvas-body">
                                        <div>

                                            <input type="hidden" id="edit_tax_id" name="edit_tax_id">

                                            <div class="mb-3 row">
                                                <label class="col-3 col-form-label required" for="title">Title
                                                </label>
                                                <div class="col">
                                                    <input type="text" class="form-control" name="title" id="title"
                                                        placeholder="Title" />
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <label class="col-3 col-form-label required"
                                                    for="percentage">Percentage</label>
                                                <div class="col">
                                                    <input type="number" class="form-control" name="percentage"
                                                        id="percentage" placeholder="Percentage" max="100" min="1" />
                                                </div>
                                            </div>

                                        </div>
                                        <div class="text-end">
                                            <!-- <button type="reset" class="btn btn-warning ">Reset</button> -->
                                            <button type="submit" class="btn btn-primary save_tax_btn"
                                                id="submit_btn">Add Tax</button>
                                            <button type="button" class="btn" data-bs-dismiss="offcanvas"
                                                aria-label="Close">Close</button>
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
</div>