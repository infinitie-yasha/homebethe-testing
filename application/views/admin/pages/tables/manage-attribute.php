<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">Manage Attribute</h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="d-flex">
                            <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/home') ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item " aria-current="page">
                                    <a href="<?= base_url('admin/product') ?>">Products</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">Attribute</a>
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
                            <h3 class="card-title"><i class="ti ti-user-circle"></i> Manage Attribute</h3>
                            <div>
                                <a href="#" class="btn btn-primary addAttributeBtn btn-sm bg-primary-lt"
                                    data-bs-toggle="offcanvas" data-bs-target="#addAttribute"
                                    aria-controls="addAttribute">Add Attribute
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class='table-striped' id='attribute_table' data-toggle="table"
                                data-url="<?= base_url('admin/attributes/attribute_list') ?>"
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
                                        <th data-field="id" data-sortable="true" data-align='center'>ID</th>
                                        <th data-field="attribute_set" data-sortable="false" data-align='center'>
                                            Attribute Set</th>
                                        <th data-field="name" data-sortable="false" data-align='center'>Name</th>
                                        <th data-field="status" data-sortable="false" data-align='center'>Status</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="addAttribute"
                            aria-labelledby="addAttributeLabel">
                            <div class="offcanvas-header">
                                <h2 class="offcanvas-title" id="addAttributeLabel">Add Attribute</h2>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>

                            <form x-data="ajaxForm({
                                            url: base_url + 'admin/attributes/add_attributes',
                                            offcanvasId: 'addAttribute',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="add_attribute_form">
                                <div class="offcanvas-body">
                                    <div>

                                        <input type="hidden" id="edit_attribute" name="edit_attribute">
                                        <input type="hidden" id="update_id" name="update_id" value="1">

                                        <div class="mb-3 row">
                                            <div x-data x-init="initTomSelect({
                                                    element: $refs.attributeSetSelect,
                                                    url: base_url + 'admin/attributes/attribute_set_list?from_select=1',
                                                    placeholder: 'Search attributes...',
                                                    onItemAdd: addAttributeSetModal,
                                                    offcanvasId: 'addAttribute',
                                                    dataAttribute: 'data-category-id',
                                                    maxItems: 1,
                                                    preloadOptions:true
                                                })" class="mb-3 row">

                                                <label class="col-3 col-form-label required"
                                                    for="attributeSetSelect">Attribute Set</label>
                                                <div class="col">
                                                    <select x-ref="attributeSetSelect" name="attribute_set"
                                                        class="form-select" id="attributeSetSelect"></select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="mb-3 row">
                                            <label for="name" class="col-3 col-form-label required">Attribute
                                                Name</label>
                                            <div class="col">
                                                <input type="text" class="form-control" name="name" id="name"
                                                    placeholder="Attribute Name" />
                                            </div>

                                        </div>

                                        <!-- Attribute Values Section -->
                                        <div class="mb-3 row">
                                            <label class="col-3 col-form-label required">Attribute Values</label>
                                            <div class="col">
                                                <button type="button" id="add_attribute_value"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="ti ti-plus"></i> Add Attribute Value
                                                </button>
                                            </div>
                                        </div>
                                        <div id="attribute_section"></div>

                                    </div>
                                    <div class="text-end">
                                        <button type="button" class="btn" data-bs-dismiss="offcanvas"
                                            aria-label="Close">Close</button>
                                        <button type="submit" class="btn btn-primary save_attribute_value_btn"
                                            id="submit_btn">Add Attribute Value</button>
                                    </div>
                                </div>
                            </form>
                        </div>


                        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"
                            id='addAttributeSetModal'>
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title attribute_title">Add Attribute Set</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <form x-data="ajaxForm({
                                            url: base_url + 'admin/attribute_set/add_attribute_set',
                                            modalId: 'addAttributeSetModal',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="add_attribute_set_form">
                                        <form action="">
                                            <div class="modal-body">

                                                <div>

                                                    <input type="hidden" id="edit_attribute_set"
                                                        name="edit_attribute_set">
                                                    <input type="hidden" id="update_id" name="update_id" value="1">

                                                    <div class="mb-3 row">
                                                        <label for="name"
                                                            class="col-3 col-form-label required">Name</label>
                                                        <div class="col">
                                                            <input type="text" class="form-control" name="name"
                                                                id="name" placeholder="Name" />
                                                        </div>

                                                    </div>

                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn" data-bs-dismiss="offcanvas"
                                                    aria-label="Close">Close</button>
                                                <button type="submit" class="btn btn-primary save_attribute_set_btn"
                                                    id="submit_btn">Add Attribute Set</button>
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
</div>