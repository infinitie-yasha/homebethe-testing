<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">Manage Attribute Value</h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="d-flex">
                            <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/home') ?>">Home</a>
                                </li>
                                 <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">product</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">Manage Attribute Value</a>
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
                            <h3 class="card-title"><i class="ti ti-user-circle"></i> Manage Attribute Values</h3>
                            <div>
                                <a href="#" class="btn btn-primary addAttributeValueBtn btn-sm bg-primary-lt"
                                    data-bs-toggle="offcanvas" data-bs-target="#addAttributeValue"
                                    aria-controls="addAttributeValue">Add Attribute
                                    Value</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class='table-striped' id='attribute_values_table' data-toggle="table"
                                data-url="<?= base_url('admin/attribute_value/attribute_value_list') ?>"
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
                                        <th data-field="attributes" data-sortable="false">Attributes</th>
                                        <th data-field="name" data-sortable="false">Name</th>
                                        <th data-field="status" data-sortable="false">Status</th>
                                        <th data-field="operate" data-sortable="false">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="offcanvas offcanvas-end offcanvas-medium" tabindex="-1" id="addAttributeValue"
                            aria-labelledby="addAttributeValueLabel">
                            <div class="offcanvas-header">
                                <h2 class="offcanvas-title" id="addAttributeValueLabel">Add Attribute Value</h2>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>

                            <form x-data="ajaxForm({
                                            url: base_url + 'admin/attribute_value/add_attribute_value',
                                            offcanvasId: 'addAttributeValue',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="add_attribute_value_form">
                                <div class="offcanvas-body">
                                    <div>

                                        <input type="hidden" id="edit_attribute_value" name="edit_attribute_value">
                                        <input type="hidden" id="update_id" name="update_id" value="1">



                                        <div class="mb-3 row">
                                            <div x-data x-init="initTomSelect({
                                                    element: $refs.attributeSelect,
                                                    url: base_url + 'admin/attribute_value/get_attributes?from_select=1',
                                                    placeholder: 'Search attributes...',
                                                    <!-- onItemAdd: addAttributeModal, -->
                                                    offcanvasId: 'addAttributeValue',
                                                    dataAttribute: 'data-attribute-id',
                                                    maxItems: 1,
                                                    preloadOptions:true
                                                })" class="mb-3 row">

                                                <label class="col-3 col-form-label required"
                                                    for="attributeSelect">Attribute</label>
                                                <div class="col">
                                                    <select x-ref="attributeSelect" name="attributes_id"
                                                        class="form-select" id="attributeSelect"></select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="value" class="col-3 col-form-label required">Value</label>
                                            <div class="col">
                                                <input type="text" class="form-control" name="value" pattern="^[^,]*$"
                                                    id="value" placeholder="Value" />
                                            </div>

                                        </div>

                                        <div class="mb-3 row">
                                            <label for="attribute_value_type"
                                                class="col-3 col-form-label required">Select
                                                Attribute Swatche Type </label>
                                            <div class="col">
                                                <select class="form-control swatche_type" name="swatche_type"
                                                    id="swatche_type">
                                                    <option value="0"> Default </option>
                                                    <option value="1"> Color </option>
                                                    <option value="2"> Image </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3 row" id="swatche_color">
                                            <label for="value" class="col-3 col-form-label required">Select Color
                                            </label>
                                            <div class="col">
                                                <input type="color" class="form-control form-control-color w-100"
                                                    name="swatche_value" id="swatche_value" />
                                            </div>
                                        </div>
                                        <div class="mb-3 row" id="swatche_image">
                                            <label class="col-3 col-form-label required" for="value">Select
                                                Image</label>
                                            <div class="col form-group">
                                                <a class="uploadFile img text-decoration-none"
                                                    data-input='swatche_value' data-isremovable='0'
                                                    data-is-multiple-uploads-allowed='0' data-bs-toggle="modal"
                                                    data-bs-target="#media-upload-modal" value="Upload Photo">
                                                    <input type="file" class="form-control" name="swatche_value"
                                                        id="swatche_value" />
                                                </a>

                                                <div class="container-fluid row image-upload-section">
                                                    <label class="text-danger mt-3 edit_slider_upload_image_note">*Only
                                                        Choose When Update is necessary</label>
                                                    <div
                                                        class="col-sm-12 shadow rounded text-center grow image">
                                                        <div class=''>
                                                            <img class="img-fluid mb-2" id="slider_uploaded_image"
                                                                src="<?= base_url() . NO_IMAGE ?>"
                                                                alt="Image Not Found">
                                                            <input type="hidden" name="image"
                                                                id="uploaded_slider_uploaded_image"
                                                                class="uploaded_image_here form-control form-input">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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




                        <!-- Modal -->
                        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id='addAttributeModal'>
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title city_title">Add Attribute</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <form x-data="ajaxForm({
                                            url: base_url + 'admin/attributes/add_attributes',
                                            modalId: 'addAttributeModal',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="add_attribute_form">
                                        <div class="modal-body">
                                            <div class="card-body">

                                                <input type="hidden" id="edit_attribute" name="edit_attribute">
                                                <input type="hidden" id="update_id" name="update_id" value="1">

                                                <div class="mb-3 row">
                                                    <div x-data x-init="initTomSelect({
                                                    element: $refs.attributeSetSelect,
                                                    url: base_url + 'admin/attributes/attribute_set_list?from_select=1',
                                                    placeholder: 'Search attributes...',
                                                    onItemAdd: addAttributeSetModal,
                                                    offcanvasId: 'addAttributeValue',
                                                     switchModal: { from: '#addAttributeModal', to: '#addAttributeSetModal' },  <!-- 👈 dynamic switching -->
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



                                            </div>
                                            <div class="text-end">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="reset" class="btn btn-warning">Reset</button>
                                            <button type="button" class="btn" data-bs-dismiss="modal"
                                                aria-label="Close">Close</button>
                                            <button type="submit" class="btn btn-primary save_attribute_value_btn"
                                                id="submit_btn">Add Attribute Value</button>

                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"
                            id='addAttributeSetModal'>
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add Attribute Set</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <form x-data="ajaxForm({
                                            url: base_url + 'admin/attribute_set/add_attribute_set',
                                            modalId: 'addAttributeSetModal',
                                            switchModal: 'addAttributeModal',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="add_attribute_set_form">
                                        <div class="modal-body">
                                            <div>

                                                <div class="mb-3 row">
                                                    <label for="name" class="col-3 col-form-label required">Name</label>
                                                    <div class="col">
                                                        <input type="text" class="form-control" name="name" id="name"
                                                            placeholder="Name" />
                                                    </div>

                                                </div>


                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="reset" class="btn btn-warning">Reset</button>
                                            <button type="button" class="btn" data-bs-dismiss="modal"
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