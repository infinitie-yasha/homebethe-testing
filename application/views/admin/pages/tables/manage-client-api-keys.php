<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">Manage Client API Key</h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="d-flex">
                            <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/home') ?>">Home</a>
                                </li>
                                 <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">System Settings</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">Client API Keys</a>
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
                        <div class="card-header">
                            <h3 class="card-title"><i class="ti ti-plus"></i> Client API Key</h3>
                        </div>
                        <div class="card-body">
                            <form x-data="ajaxForm({
                                            url: base_url + 'admin/Client_api_keys/add_client',
                                            modalId: '',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="add_zipcode_form"
                                enctype="multipart/form-data">
                                <?php if (isset($fetched_data[0]['id'])) { ?>
                                    <input type="hidden" id="edit_client_api_keys" name="edit_client_api_keys"
                                        value="<?= @$fetched_data[0]['id'] ?>">
                                    <input type="hidden" id="update_id" name="update_id" value="1">
                                <?php } ?>
                                <div class="space-y">
                                    <div>
                                        <label class="col-form-label required"> Client Name </label>
                                        <input type="text" placeholder="Enter Client Name " name="name"
                                            class="form-control" />
                                    </div>

                                    <div class="form-group">
                                        <button type="reset" class="btn">Cancel</button>
                                        <button type="submit" class="btn btn-primary" id="submit_btn">Add Client
                                            Api <i class="cursor-pointer ms-2 ti ti-arrow-right"></i></button>
                                    </div>

                                </div>
                            </form>


                        </div>


                    </div>

                    <div class="card my-3">
                        <div class="card-header">
                            <h3 class="card-title"><i class="ti ti-info-circle"></i> API Liknks for APP </h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 row">
                                <label class="col-12 col-md-4 col-form-label ">API link for Customer App</label>
                                <div class="col">
                                    <input type="text" class="form-control" id="api_link"
                                        value="<?= base_url('app/v1/api/'); ?>" disabled />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-12 col-md-4 col-form-label ">Delivery boy API Link</label>
                                <div class="col">
                                    <input type="text" class="form-control" id="api_link"
                                        value="<?= base_url('delivery_boy/app/v1/api/'); ?>" disabled />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-12 col-md-4 col-form-label ">Seller API Link</label>
                                <div class="col">
                                    <input type="text" class="form-control" id="api_link"
                                        value="<?= base_url('seller/app/v1/api/'); ?>" disabled />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-12 col-md-4 col-form-label ">API link for Customer App Chat</label>
                                <div class="col">
                                    <input type="text" class="form-control" id="api_link"
                                        value="<?= base_url('app/v1/Chat_Api/'); ?>" disabled />
                                    <small class="form-hint">for chat Feature</small>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-12 col-md-4 col-form-label ">API link for Seller App Chat</label>
                                <div class="col">
                                    <input type="text" class="form-control" id="api_link"
                                        value="<?= base_url('seller/app/v1/Chat_Api/'); ?>" disabled />
                                    <small class="form-hint">for chat Feature</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="ti ti-table-filled"></i> Client API Key</h3>
                        </div>
                        <div class="card-body">
                            <table class='table-striped' id="client_api_key_table" data-toggle="table"
                                data-url="<?= base_url('admin/client_api_keys/get_client_api_keys') ?>"
                                data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                                data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                                data-sort-order="desc" data-mobile-responsive="true" data-toolbar=""
                                data-show-export="true" data-maintain-selected="true"
                                data-export-types='["txt","excel"]' data-query-params="queryParams">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true">ID</th>
                                        <th data-field="name" data-sortable="false">Name</th>
                                        <th data-field="secret" data-sortable="false">Secret</th>
                                        <th data-field="status" data-sortable="false">Status</th>
                                        <th data-field="operate" data-sortable="false">Actions</th>
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