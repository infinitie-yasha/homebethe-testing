<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">

                <!-- Mobile View (xs/sm) -->
                <div class="d-flex flex-column text-center d-sm-none py-2">
                    <h2 class="page-title fs-5 fw-semibold mb-1">Manage Ticket Types</h2>
                    <nav class="breadcrumb breadcrumb-arrows small justify-content-start mb-0">
                        <a href="<?= base_url('admin/home') ?>" class="breadcrumb-item">Home</a>
                        <span class="breadcrumb-item">Support</span>
                        <span class="breadcrumb-item active">Ticket Types</span>
                    </nav>
                </div>

                <!-- Tablet & Desktop View (sm+) -->
                <div class="row g-2 align-items-center d-none d-sm-flex">
                    <div class="col">
                        <h2 class="page-title mb-0">Manage Ticket Types</h2>
                    </div>
                    <div class="col-auto ms-auto">
                        <ol class="breadcrumb breadcrumb-arrows mb-0 small">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('admin/home') ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0)">Support & Communication</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Ticket Types
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
                    <!-- Filters Section -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Filters & Search</h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="col-form-label" for="ticket_type_filter">Filter By Ticket Type</label>
                                    <select class="form-select" name="ticket_type_filter" id="ticket_type_filter">
                                        <option value="">Select Ticket Type</option>
                                        <?php foreach ($ticket_types as $type): ?>
                                            <option value="<?= $type['id'] ?>"><?= $type['title'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title"><i class="ti ti-ticket"></i> Ticket Types</h3>
                            <a class="btn btn-primary AddTicketTypeBtn btn-sm bg-primary-lt" data-bs-toggle="offcanvas"
                                data-bs-target="#addTicketType" href="#" role="button" aria-controls="addTicketType">
                                Add
                                Ticket Type </a>
                        </div>
                        <div class="card-body">
                            <table class='table-striped' id='ticket_type_table' data-toggle="table"
                                data-url="<?= base_url('admin/tickets/view_ticket_type_list') ?>"
                                data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                                data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                                data-sort-order="desc" data-mobile-responsive="true" data-toolbar=""
                                data-show-export="true" data-maintain-selected="true"
                                data-export-types='["txt","excel"]' data-export-options='{
                        "fileName": "ticket-type-list",
                        "ignoreColumn": ["state"]
                        }' data-query-params="ticket_type_queryParams">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true" data-align='center'>ID</th>
                                        <th data-field="title" data-sortable="false" data-align='center'>Title</th>
                                        <th data-field="user_type" data-sortable="false" data-align='center'>User Type</th>
                                        <th data-field="date_created" data-sortable="date_created" data-visible="false"
                                            data-align='center'>Date Created</th>
                                        <th data-field="operate" data-sortable="false" data-align='center'>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="offcanvas offcanvas-end offcanvas-medium" tabindex="-1" id="addTicketType"
                            aria-labelledby="addTicketTypeLabel">
                            <div class="offcanvas-header">
                                <h2 class="offcanvas-title" id="addTicketTypeLabel">Add Ticket Type</h2>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <form x-data="ajaxForm({
                                            url: base_url + 'admin/tickets/add_ticket_type',
                                            offcanvasId: 'addTicketType',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="add_ticket_type_form">
                                <div class="offcanvas-body">
                                    <div>

                                        <input type="hidden" id="edit_ticket_type" name="edit_ticket_type">

                                        <div class="mb-3 row">
                                            <label class="col-3 col-form-label required" for="title">Title
                                            </label>
                                            <div class="col">
                                                <input type="text" class="form-control" name="title" id="title"
                                                    placeholder="Title" />
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-3 col-form-label required" for="type_for">For
                                            </label>
                                            <div class="col">
                                                <select class="form-control" name="type_for" id="type_for">
                                                    <option value="customer">Customers</option>
                                                    <option value="seller">Sellers</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="text-end">
                                        <!-- <button type="reset" class="btn btn-warning ">Reset</button> -->
                                        <button type="submit" class="btn btn-primary save_ticket_type_btn"
                                            id="submit_btn">Add
                                            Ticket Type</button>
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