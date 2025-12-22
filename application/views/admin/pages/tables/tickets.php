<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
       <div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">

        <!-- Mobile View (xs/sm) -->
        <div class="d-flex flex-column text-center d-sm-none py-2">
            <h2 class="page-title fs-5 fw-semibold mb-1">Ticket System</h2>
            <nav class="breadcrumb breadcrumb-arrows small justify-content-start mb-0">
                <a href="<?= base_url('admin/home') ?>" class="breadcrumb-item">Home</a>
                <span class="breadcrumb-item">Support</span>
                <span class="breadcrumb-item active">Tickets</span>
            </nav>
        </div>

        <!-- Tablet & Desktop View (md+) -->
        <div class="row g-2 align-items-center d-none d-sm-flex">
            <div class="col">
                <h2 class="page-title mb-0">Ticket System</h2>
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
                        Ticket System
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
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title"><i class="ti ti-ticket"></i> Ticket System</h3>
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
                        <div class="card-body">
                            <table class='table-striped' id="ticket_table" data-toggle="table"
                                data-url="<?= base_url('admin/tickets/view_ticket_list') ?>" data-click-to-select="true"
                                data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                                data-show-refresh="true" data-trim-on-search="false" data-sort-name="t.id"
                                data-sort-order="desc" data-mobile-responsive="true" data-toolbar=""
                                data-show-export="true" data-maintain-selected="true"
                                data-export-types='["txt","excel","csv"]' data-export-options='{
                                    "fileName": "tickets-list",
                                    "ignoreColumn": ["operate"]
                                }' data-query-params="ticket_type_queryParams">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true" data-align='center'>ID</th>
                                        <th data-field="ticket_type_id" data-sortable="false" data-visible="false"
                                            data-align='center'>Ticket Type Id</th>
                                        <th data-field="ticket_type" data-sortable="false" data-align='center'>Ticket
                                            Type</th>
                                        <th data-field="user_id" data-sortable="true" data-visible="false"
                                            data-align='center'>User Id</th>
                                        <th data-field="username" data-sortable="true" data-align='center'>User Name
                                        </th>
                                        <th data-field="subject" data-sortable="false" data-align='center'>subject</th>
                                        <th data-field="email" data-sortable="false" data-align='center'>email</th>
                                        <th data-field="description" data-sortable="false" data-align='center'>
                                            description</th>
                                        <th data-field="status" data-sortable="false" data-align='center'>Status</th>
                                        <th data-field="last_updated" data-sortable="false" data-visible="false"
                                            data-align='center'>Last Updated</th>
                                        <th data-field="date_created" data-sortable="false" data-align='center'>Date
                                            Created</th>
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

<!-- Ticket Offcanvas -->
<div class="offcanvas offcanvas-end offcanvas-large" id="ticket_offcanvas" tabindex="-1"
    aria-labelledby="ticketOffcanvasLabel" data-bs-keyboard="false">
    <div class="offcanvas-header">
        <div class="w-100">
            <!-- User Info Section -->
            <div class="d-flex align-items-center">
                <div class="avatar avatar-sm me-3">
                    <span class="avatar-initial">
                        <i class="ti ti-user"></i>
                    </span>
                </div>
                <div class="flex-fill">
                    <h4 class="mb-0" id="user_name"></h4>
                    <div class="text-muted">
                        <span class="badge bg-blue-lt me-1" id="ticket_type"></span>
                        <small class="text-muted">Ticket #<span id="ticket_id_display"></span></small>
                    </div>
                </div>
                <!-- Ticket Subject -->
                <div class="flex-fill ms-4">
                    <h5 class="text-dark mb-1" id="subject"></h5>
                    <div class="d-flex align-items-center justify-content-between">
                        <small class="text-muted" id="date_created"></small>

                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

        </div>
    </div>
    <?php
    $offset = 0;
    $limit = 15;
    ?>
    <div class="offcanvas-body p-0 d-flex flex-column">
        <!-- Ticket Info & Status Change -->
        <div class="p-3 border-bottom ">
            <div class="row g-2 align-items-center">
                <div class="col-md-6">
                    <span id="status"></span>
                </div>
                <div class="col-md-6">
                    <label class="form-label mb-1">Change Status</label>
                    <select class="form-select form-select-sm change_ticket_status">
                        <option value=<?= OPENED ?>>OPEN</option>
                        <option value=<?= RESOLVED ?>>RESOLVE</option>
                        <option value=<?= CLOSED ?>>CLOSE</option>
                        <option value=<?= REOPEN ?>>REOPEN</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Messages Area -->
        <div class="flex-fill overflow-auto p-4" id="element">
            <div class="ticket_msg" data-limit="<?= $limit ?>" data-offset="<?= $offset ?>" data-max-loaded="false">
                <!-- Empty state -->
                <div class="empty-messages" style="display: none;">
                    <i class="ti ti-message-circle"></i>
                    <p>No messages yet. Start the conversation!</p>
                </div>
            </div>
            <div class="scroll_div"></div>
        </div>

        <!-- Message Input Footer -->
        <div class="message-input-area ticket_status_footer">
            <form method="POST" class="form-horizontal" action="tickets/send-message" id="ticket_send_msg_form"
                enctype="multipart/form-data">
                <input type="hidden" name="user_id" id="user_id">
                <input type="hidden" name="user_type" id="user_type">
                <input type="hidden" name="ticket_id" id="ticket_id">

                <div class="form-group">
                    <!-- Image Upload Section -->
                    <div class="mb-2">
                        <?php

                        if (file_exists(FCPATH . @$fetched_data[0]['attachments']) && !empty(@$fetched_data[0]['attachments'])) {
                            $fetched_data[0]['attachments'] = get_image_url($fetched_data[0]['attachments']);
                            ?>
                            <div class="container-fluid row image-upload-section">
                                <div class="col-md-3 col-sm-12 shadow rounded m-3 p-3 text-center grow">
                                    <div class='image-upload-div'><img class="img-fluid mb-2"
                                            src="<?= $fetched_data[0]['attachments'] ?>" alt="Image Not Found"></div>
                                    <input type="hidden" name="attachments[]"
                                        value='<?= $fetched_data[0]['attachments'] ?>'>
                                </div>
                            </div>
                            <?php
                        } else { ?>
                            <div class="container-fluid row image-upload-section">
                            </div>
                        <?php } ?>
                    </div>
                    <div class="message-input-group d-flex">
                        <input type="text" name="message" id="message_input" placeholder="Type your message..."
                            class="message-input-field">
                        <a class="uploadFile img attachment-btn text-decoration-none" data-input='attachments[]'
                            data-isremovable='1' data-is-multiple-uploads-allowed='1' data-bs-toggle="modal"
                            data-bs-target="#media-upload-modal" value="Upload Photo" title="Attach File">
                            <i class="ti ti-paperclip"></i>
                        </a>
                        <button type="submit" class="send-btn text-decoration-none" id="submit_btn"
                            title="Send Message">
                            <i class="ti ti-send"></i>
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>