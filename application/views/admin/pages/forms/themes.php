<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
      <div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">
        <div class="row g-2 align-items-center">

            <!-- Page Title -->
            <div class="col-12 col-md-6">
                <h2 class="page-title">Themes</h2>
            </div>

            <!-- Breadcrumb (auto wraps on small screens) -->
            <div class="col-12 col-md-6 d-flex justify-content-md-end">
                <ol class="breadcrumb breadcrumb-arrows mb-0 w-100 d-flex justify-content-start justify-content-md-end flex-wrap"
                    aria-label="breadcrumbs">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('admin/home') ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0)">Web Settings</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <a href="#">Themes</a>
                    </li>
                </ol>
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
                            <h3 class="card-title"><i class="ti ti-table-filled"></i> Manage Themes</h3>
                        </div>
                        <div class="card-body">
                            <table class='table-striped' id="web-theme-table" data-toggle="table"
                                data-url="<?= base_url('admin/setting/get-themes') ?>" data-click-to-select="true"
                                data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                                data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                                data-sort-order="desc" data-mobile-responsive="true" data-toolbar=""
                                data-show-export="true" data-maintain-selected="true"
                                data-export-types='["txt","excel"]' data-query-params="queryParams">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true">Id</th>
                                        <th data-field="name" data-sortable="false">Name</th>
                                        <th data-field="image" data-sortable="false">Image</th>
                                        <th data-field="is_default" data-sortable="false">Default</th>
                                        <th data-field="status" data-sortable="false">Status</th>
                                        <th data-field="created_on" data-sortable="false" data-visible="false">Created
                                            On</th>
                                        <th data-field="operate" data-sortable="false">Action</th>
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
<!-- END PAGE BODY -->