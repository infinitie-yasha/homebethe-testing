<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">Manage System Users</h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="d-flex">
                            <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/home') ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">System Users</a>
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
                            <h3 class="card-title"><i class="ti ti-users"></i> System Users</h3>
                            <a href="<?= base_url('admin/system_users/add-system-users') ?>"
                                class="btn btn-primary btn-sm bg-primary-lt">Add System User</a>
                        </div>
                        <div class="card-body">
                            <table class='table-striped' id="system_users_table" data-toggle="table"
                                data-url="<?= base_url('admin/system_users/view_system_users') ?>"
                                data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                                data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                                data-sort-order="desc" data-mobile-responsive="true" data-toolbar=""
                                data-show-export="true" data-maintain-selected="true"
                                data-export-types='["txt","excel"]' data-export-options='{
                                    "fileName": "system-users-list",
                                    "ignoreColumn": ["operate"]
                                }' data-query-params="queryParams">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true">ID</th>
                                        <th data-field="username" data-sortable="false">Username</th>
                                        <th data-field="mobile" data-sortable="false">Mobile</th>
                                        <th data-field="email" data-sortable="false">Email</th>
                                        <th data-field="role" data-sortable="false">Role</th>
                                        <?php if (defined('ALLOW_MODIFICATION') && ALLOW_MODIFICATION == 1) { ?>
                                            <th data-field="operate" data-sortable="false">Actions</th>
                                        <?php } ?>
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

<!-- Edit System User Modal -->
<div class="modal fade edit-modal-lg" tabindex="-1" role="dialog" aria-labelledby="editSystemUserModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSystemUserModalLabel">Edit System User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>