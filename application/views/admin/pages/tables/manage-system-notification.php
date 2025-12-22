<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">System Notifications</h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="d-flex">
                            <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/home') ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">System Notifications</a>
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
                            <h3 class="card-title"><i class="ti ti-world"></i> Notifications </h3>

                        </div>
                        <div class="card-body">
                            <div class="col-md-3">
                                <label for="message_type" class="col-form-label">Filter By Message Type</label>
                                <select id="message_type" name="message_type" placeholder="Select Message Type"
                                    required="" class="form-control">
                                    <option value="">All Messages</option>
                                    <option value="1">Read</option>
                                    <option value="0">Un-Read</option>
                                </select>
                            </div>
                            <table class='table-striped' id="system_notofication_table" data-toggle="table"
                                data-url="<?= base_url('admin/Notification_settings/get_notifications_data') ?>"
                                data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                                data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                                data-sort-order="desc" data-mobile-responsive="true" data-toolbar=""
                                data-show-export="true" data-maintain-selected="true"
                                data-export-types='["txt","excel","csv"]' data-export-options='{
                                    "fileName": "notification-list",
                                    "ignoreColumn": ["state"] 
                                    }' data-query-params="noti_query_params">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true" data-align='center'>ID</th>
                                        <th data-field="title" data-sortable="false" data-align='center'>Title</th>
                                        <th data-field="message" data-sortable="false" data-align='center'>Message</th>
                                        <th data-field="type" data-sortable="false" data-align='center'>Type</th>
                                        <th data-field="type_id" data-sortable="false" data-align='center'
                                            data-visible='false'>Type Id</th>
                                        <th data-field="read_by" data-sortable="false" data-align='center'>Read By</th>
                                        <th data-field="operate" data-sortable="false" data-align='center'>Actions</th>
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