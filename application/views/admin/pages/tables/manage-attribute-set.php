<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
    <div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">
        <div class="row g-2 align-items-center">

            <!-- Page Title -->
            <div class="col-12 col-md">
                <h2 class="page-title mb-2 mb-md-0">Manage Attribute Set</h2>
            </div>

            <!-- Breadcrumb -->
            <div class="col-12 col-md-auto">
                <div class="d-flex justify-content-md-end">
                    <ol class="breadcrumb breadcrumb-arrows mb-0">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('admin/home') ?>">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Product
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                           Manage Attribute Set
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
                            <h3 class="card-title"><i class="ti ti-user-circle"></i> Manage Attribute Sets</h3>
                            <div>
                                <a href="#" class="btn btn-primary addAttributeSetBtn btn-sm bg-primary-lt"
                                    data-bs-toggle="offcanvas" data-bs-target="#addAttributeSet"
                                    aria-controls="addAttributeSet">Add Attribute
                                    Set</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class='table-striped' id='attribute_sets_table' data-toggle="table"
                                data-url="<?= base_url('admin/attribute_set/attribute_set_list') ?>"
                                data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                                data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                                data-sort-order="desc" data-mobile-responsive="true" data-toolbar=""
                                data-show-export="true" data-maintain-selected="true"
                                data-export-types='["txt","excel","csv"]' data-export-options='{
                        "fileName": "attribute-value-list",
                        "ignoreColumn": ["state"]
                        }' data-query-params="queryParams">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true">ID</th>
                                        <th data-field="name" data-sortable="false">Name</th>
                                        <th data-field="status" data-sortable="false">Status</th>
                                        <th data-field="operate" data-sortable="false">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="offcanvas offcanvas-end offcanvas-medium" tabindex="-1" id="addAttributeSet"
                            aria-labelledby="addAttributeSetLabel">
                            <div class="offcanvas-header">
                                <h2 class="offcanvas-title" id="addAttributeSetLabel">Add Attribute Set</h2>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>

                            <form x-data="ajaxForm({
                                            url: base_url + 'admin/attribute_set/add_attribute_set',
                                            offcanvasId: 'addAttributeSet',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="add_attribute_set_form">
                                <div class="offcanvas-body">
                                    <div>

                                        <input type="hidden" id="edit_attribute_set" name="edit_attribute_set">
                                        <input type="hidden" id="update_id" name="update_id" value="1">

                                        <div class="mb-3 row">
                                            <label for="name" class="col-3 col-form-label required">Name</label>
                                            <div class="col">
                                                <input type="text" class="form-control" name="name" id="name"
                                                    placeholder="Name" />
                                            </div>

                                        </div>


                                    </div>
                                    <div class="text-end">
                                        <button type="button" class="btn" data-bs-dismiss="offcanvas"
                                            aria-label="Close">Close</button>
                                        <button type="submit" class="btn btn-primary save_attribute_set_btn"
                                            id="submit_btn">Add Attribute Set</button>
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