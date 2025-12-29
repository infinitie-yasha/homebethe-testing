<div class="page-wrapper">



    <!-- BEGIN PAGE HEADER -->
    <div class="page-header d-print-none" aria-label="Page header">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">Seller Support</h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="d-flex">
                        <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('seller/home') ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="#">Seller Support</a>
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
                        <h3 class="card-title"><i class="ti ti-ticket"></i> Support Tickets</h3>
                        <a class="btn btn-primary AddTicketTypeBtn btn-sm bg-primary-lt" id="add-seller-ticket" data-bs-toggle="offcanvas"
                            data-bs-target="#addTicketType" href="#" role="button" aria-controls="addTicketType">
                            Create
                            Ticket </a>
                    </div>
                    <div class="card-body">
                        <table class='table-striped' id='seller-support-tickets' data-toggle="table"
                            style=" overflow: unset !important;"
                            data-url="<?= base_url('seller/support-tickets/get_seller_tickets') ?>"
                            data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                            data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                            data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                            data-sort-order="desc" data-mobile-responsive="true" data-toolbar="" data-show-export="true"
                            data-maintain-selected="true" data-export-types='["txt","excel","csv"]' data-export-options='{
                                "fileName": "category-list",
                                "ignoreColumn": ["state"]
                                }' data-query-params="category_query_params">
                            <thead>
                                <tr>
                                    <th data-field="id" data-sortable="true" data-visible='false'>ID</th>
                                    <th data-field="ticket_type" data-sortable="true" data-align='center'>Ticket Type
                                    </th>
                                    <th data-field="title" data-sortable="false" data-align='center'>Title</th>
                                    <th data-field="subject" data-sortable="false" data-align='center'>Subject</th>
                                    <th data-field="description" data-sortable="false" data-align='center'>Description
                                    </th>
                                    <th data-field="status" data-sortable="false" data-align='center'>Status</th>
                                    <th data-field="action" data-sortable="false">Action</th>

                                </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="offcanvas offcanvas-end offcanvas-medium" tabindex="-1" id="addTicketType"
                        aria-labelledby="addTicketTypeLabel">
                        <div class="offcanvas-header">
                            <h2 class="offcanvas-title" id="addTicketTypeLabel">Create Ticket</h2>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <form x-data="ajaxForm({
                                            url: base_url + 'seller/support-tickets/create-ticket',
                                            offcanvasId: 'addTicketType',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="add_ticket_type_form">
                            <div class="offcanvas-body">
                                <div>
                                    <input type="hidden" name="seller_ticket_id" id="seller_ticket_id">
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label required" for="ticket_type">Ticket Type
                                        </label>
                                        <div class="col">
                                            <select class="form-control" name="ticket_type" id="ticket_type">
                                                <option value="">Please Select</option>
                                                <?php foreach ($ticket_type as $type) { ?>
                                                    <option value="<?= $type['id'] ?>"><?= ucfirst($type['title']) ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label required" for="email">Title
                                        </label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="email" id="email"
                                                placeholder="Title" />
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label required" for="subject">Subject
                                        </label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="subject" id="subject"
                                                placeholder="Subject" />
                                        </div>
                                    </div>


                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label required" for="title">Description
                                        </label>
                                        <div class="col">
                                            <textarea placeholder="Description" class="form-control" rows="5"
                                                name="description" id="description"></textarea>
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