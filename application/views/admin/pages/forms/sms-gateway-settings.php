<!-- Begin Page Content -->
<div class="page-wrapper">
    <!-- Page Header -->
    <div class="page">
        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">Sms Gatway Settings </h2>

                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="d-flex">
                            <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/home') ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">Settings </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">Sms Gateway </a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php

            use function PHPSTORM_META\type;


            $sms = json_encode($sms_gateway_settings);

            ?>

        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">
            <input type="hidden" id="sms_gateway_settings" name="sms_gateway_settings" value='<?= $sms ?>'>
            <input type="hidden" id="sms_gateway_data" value='<?= isset($sms) ? ($sms) : [] ?>' />
                <!-- Tab Navigation -->
                <ul class="nav nav-tabs" id="smsTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#config-tab" role="tab">
                            <i class="ti ti-settings"></i> Configuration
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#sms-matrix" role="tab">
                            <i class="ti ti-table"></i> SMS Matrix
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#sms-templates" role="tab">
                            <i class="ti ti-template"></i> Templates
                        </a>
                    </li>
                </ul>

                <div class="tab-content mt-4">
                    <!-- CONFIG TAB -->
                    <div class="tab-pane fade show active" id="config-tab" role="tabpanel">
                        <div class="alert alert-info mb-3">
                            <strong>Confused?</strong> Follow the setup guide below.
                            <a href="#" data-bs-toggle="modal" data-bs-target="#sms_instuction_modal"
                                class="text-primary">
                                View Instructions
                            </a>
                        </div>

                       


                             <form x-data="ajaxForm({
                                            url: base_url + 'admin/Sms_gateway_settings/add_sms_data',
                                            offcanvasId: '',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-submit-event" id="smsgateway_setting_form" enctype="multipart/form-data">
                            <input type="hidden" name="csrfname" value="<?= $this->security->get_csrf_token_name(); ?>">
                            <input type="hidden" name="csrfhash" value="<?= $this->security->get_csrf_hash(); ?>">

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">Base URL</label>
                                    <input type="text" class="form-control" id="base_url" name="base_url"
                                        placeholder="Enter Base URL" value="<?= @$sms_gateway_settings['base_url'] ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Method</label>
                                    <select id="sms_gateway_method" name="sms_gateway_method" class="form-select">
                                        <option value="POST" <?= (@$sms_gateway_settings['sms_gateway_method'] == 'POST') ? 'selected' : '' ?>>POST</option>
                                        <option value="GET" <?= (@$sms_gateway_settings['sms_gateway_method'] == 'GET') ? 'selected' : '' ?>>GET</option>
                                    </select>
                                </div>
                            </div>

                            <h4 class="mb-3">Authorization Token</h4>
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Account SID</label>
                                    <input type="text" id="converterInputAccountSID" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Auth Token</label>
                                    <input type="text" id="converterInputAuthToken" class="form-control">
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="button" class="btn btn-success " onclick="createHeader()">
                                        <i class="ti ti-key"></i> Create
                                    </button>
                                </div>
                            </div>
                            <div class="mb-4">
                                <h5 id="basicToken" class="text-success"></h5>
                            </div>

                            <!-- Nested Tabs -->
                            <ul class="nav nav-tabs">
                                <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#header"
                                        role="tab">Header</a></li>
                                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#body"
                                        role="tab">Body</a></li>
                                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#params"
                                        role="tab">Params</a></li>
                            </ul>

                            <div class="tab-content mt-3">
                                <!-- Header -->
                                <div class="tab-pane fade show active" id="header" role="tabpanel">
                                    <div class="d-flex justify-content-between mb-3">
                                        <h5>Add Header Data</h5>
                                        <a href="#" id="add_sms_header" class="btn btn-primary btn-sm"><i
                                                class="ti ti-plus"></i> Add Header</a>
                                    </div>
                                    <div id="formdata_header_section"></div>
                                </div>

                                <!-- Body -->
                                <div class="tab-pane fade" id="body" role="tabpanel">
                                    <ul class="nav nav-tabs mb-3">
                                        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab"
                                                href="#text-json" role="tab">Text/JSON</a></li>
                                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#formdata"
                                                role="tab">Form Data</a></li>
                                    </ul>

                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="text-json">
                                            <textarea name="text_format_data" class="form-control" rows="5"
                                                placeholder="Enter JSON or Text"><?= isset($sms_gateway_settings['text_format_data']) ? str_replace('\\', '', $sms_gateway_settings['text_format_data']) : '' ?></textarea>
                                        </div>
                                        <div class="tab-pane fade" id="formdata">
                                            <div class="d-flex justify-content-between mb-3">
                                                <h5>Add Body Parameters</h5>
                                                <a href="#" id="add_sms_body" class="btn btn-primary btn-sm"><i
                                                        class="ti ti-plus"></i> Add Parameter</a>
                                            </div>
                                            <div id="formdata_section"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Params -->
                                <div class="tab-pane fade" id="params" role="tabpanel">
                                    <div class="d-flex justify-content-between mb-3">
                                        <h5>Add Params</h5>
                                        <a href="#" id="add_sms_params" class="btn btn-primary btn-sm"><i
                                                class="ti ti-plus"></i> Add Param</a>
                                    </div>
                                    <div id="formdata_params_section"></div>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-2 my-4">
                                <pre>{only_mobile_number}</pre>
                                <pre>{mobile_number_with_country_code}</pre>
                                <pre>{country_code}</pre>
                                <pre>{message}</pre>
                                <pre>{otp}</pre>
                            </div>

                            <div class="mt-4">
                                <button type="reset" class="btn btn-warning me-2">Reset</button>
                                <button type="submit" class="btn btn-success" id="sms_gateway_submit">Update SMS Gateway
                                    Settings</button>
                            </div>
                        </form>
                    </div>

                    <!-- MATRIX TAB -->
                    <div class="tab-pane fade card" id="sms-matrix" role="tabpanel" aria-labelledby="sms-matrix-tab">
                        <div class="align-items-center">
                           

                                            <form x-data="ajaxForm({
                                            url: base_url + 'admin/Sms_gateway_settings/update_notification_module',
                                            offcanvasId: '',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal form-submit-event update_notification_module" id="add_product_form" enctype="multipart/form-data">

                                <div class="card-body row">
                                    <div class="col-md-12">
                                        <?php
                                        $actions = [
                                            'customer',
                                            'admin',
                                            'seller',
                                            'delivery_boy',
                                            'notification_via_sms',
                                            'notification_via_mail'
                                        ];
                                        ?>
                                        <table class="table table-responsive permission-table">
                                            <tr>
                                                <th>Module/Permissions</th>
                                                <?php foreach ($actions as $row) { ?>
                                                    <th><?= ucfirst($row) ?></th>
                                                <?php }
                                                ?>
                                            </tr>
                                            <tbody>
                                                <?php
                                                foreach ($notification_modules as $key => $value) {
                                                    $flag = 0;
                                                    ?>
                                                    <tr>
                                                        <td><?= $key ?></td>
                                                        <?php for ($i = 0; $i < count($actions); $i++) {
                                                            $index = array_search($actions[$i], $value);
                                                            if ($index !== false) {
                                                                $checked = '';
                                                                if (isset($send_notification_settings)) {
                                                                    if (isset($send_notification_settings[$key][$value[$index]])) {
                                                                        $checked = 'checked';
                                                                    } else {
                                                                        $checked = '';
                                                                    }
                                                                } else {
                                                                    $checked = 'checked';
                                                                }
                                                                ?>
                                                                <td> <input type="checkbox"
                                                                        name="<?= 'permissions[' . $key . '][' . $value[$index] . ']' ?>"
                                                                        data-bootstrap-switch data-off-color="danger"
                                                                        class='system-users-switch' data-on-color="success"
                                                                        <?= $checked ?>></td>
                                                                <?php
                                                            } else { ?>
                                                                <td></td>
                                                            <?php }
                                                            ?>
                                                        <?php } ?>
                                                    </tr>
                                                    <?php

                                                }

                                                ?>

                                            </tbody>
                                        </table>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success" id="submit_btn">Update
                                                User</button>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- sms templates -->
                 <div class="tab-pane fade" id="sms-templates" role="tabpanel" aria-labelledby="sms-templates-tab">

    <div class="align-items-center">

        <div class="card shadow-sm">
          
                   <form x-data="ajaxForm({
                                            url: base_url + 'admin/custom_sms/add_sms',
                                            offcanvasId: '',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal form-submit-event add_sms" id="add_product_form" enctype="multipart/form-data">

                <?php if (isset($fetched_data[0]['id'])): ?>
                    <input type="hidden" id="edit_custom_sms" name="edit_custom_sms" value="<?= @$fetched_data[0]['id'] ?>">
                    <input type="hidden" id="update_id" name="update_id" value="1">
                    <input type="hidden" id="udt_title" value="<?= @$fetched_data[0]['title'] ?>">
                <?php endif; ?>

                <div class="card-body p-4">

                    <!-- TYPE -->
                    <div class="row mb-4">
                        <label class="col-sm-2 col-form-label fw-bold">Type <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <select name="type" class="form-control type">
                                <option value="">Select Type</option>
                                <?php foreach ($notification_modules as $key => $value): ?>
                                    <option value="<?= $key ?>" <?= (isset($fetched_data[0]['id']) && $fetched_data[0]['type'] == $key) ? 'selected' : '' ?>>
                                        <?= ucwords(str_replace('_', ' ', $key)) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- TITLE -->
                    <div class="row mb-4">
                        <label class="col-sm-2 col-form-label fw-bold">Title <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text"
                                   name="title"
                                   id="update_title"
                                   class="form-control update_title"
                                   placeholder="Enter SMS Title"
                                   value="<?= isset($fetched_data[0]['title']) ? $fetched_data[0]['title'] : '' ?>">
                        </div>
                    </div>

                    <!-- OTP HASHTAGS -->
                    <div class="row mb-4 otp <?= (isset($fetched_data[0]['type']) && $fetched_data[0]['type'] == 'otp') ? '' : 'd-none' ?>">
                        <label class="col-sm-2"></label>
                        <div class="col-sm-10 d-flex flex-wrap gap-2">
                            <?php foreach (get_notification_variables() as $row): ?>
                                <span class="badge bg-blue-lt px-3 py-2 hashtag" style="cursor:pointer;">
                                    <?= $row ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- PLACE ORDER HASHTAGS -->
                    <div class="row mb-4 place_order <?= (isset($fetched_data[0]['type']) && $fetched_data[0]['type'] == 'place_order') ? '' : 'd-none' ?>">
                        <label class="col-sm-2"></label>
                        <div class="col-sm-10 d-flex flex-wrap gap-2">
                            <?php foreach (get_notification_variables() as $row): ?>
                                <span class="badge bg-blue-lt px-3 py-2 hashtag_input" style="cursor:pointer;">
                                    <?= $row ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- MESSAGE -->
                    <div class="row mb-4">
                        <label class="col-sm-2 col-form-label fw-bold">Message <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <textarea name="message"
                                      id="text-box"
                                      class="form-control text-box"
                                      rows="5"
                                      placeholder="Write SMS content here..."><?= isset($fetched_data[0]['message']) ? $fetched_data[0]['message'] : '' ?></textarea>
                        </div>
                    </div>

                    <!-- OTHER DYNAMIC HASHTAG GROUPS -->
                    <?php
                    $types = [
                        'seller_place_order', 'settle_cashback_discount', 'settle_seller_commission',
                        'customer_order_received', 'customer_order_processed', 'delivery_boy_order_processed',
                        'customer_order_shipped', 'customer_order_delivered', 'customer_order_cancelled',
                        'customer_order_returned', 'delivery_boy_return_order_assign',
                        'customer_order_returned_request_approved', 'customer_order_returned_request_decline',
                        'wallet_transaction', 'ticket_status', 'ticket_message',
                        'bank_transfer_receipt_status', 'bank_transfer_proof'
                    ];
                    ?>

                    <?php foreach ($types as $type): ?>
                        <div class="row mb-4 <?= $type ?> <?= (isset($fetched_data[0]['type']) && $fetched_data[0]['type'] == $type) ? '' : 'd-none' ?>">
                            <label class="col-sm-2"></label>
                            <div class="col-sm-10 d-flex flex-wrap gap-2">

                                <?php
                                $hashtag_list = ($type == 'ticket_status' || $type == 'ticket_message')
                                    ? ['< application_name >']
                                    : get_notification_variables();
                                ?>

                                <?php foreach ($hashtag_list as $row): ?>
                                    <span class="badge bg-blue-lt px-3 py-2 hashtag" style="cursor:pointer;"><?= $row ?></span>
                                <?php endforeach; ?>

                            </div>
                        </div>
                    <?php endforeach; ?>

                    <!-- BUTTONS -->
                    <div class="row mt-4 pt-2">
                        <div class="col-sm-10 offset-sm-2 d-flex gap-3">
                            <button type="reset" class="btn btn-secondary">Reset</button>
                            <button type="submit" class="btn btn-success" id="submit_btn">
                                <?= isset($fetched_data[0]['id']) ? 'Update Custom Message' : 'Add Custom Message' ?>
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>


       
        <div class="main-content mt-4">
            <div class="card shadow-sm p-4">

                <h4 class="card-title text-center mb-4">Custom Message List</h4>

                <table class="table table-striped"
                       data-toggle="table"
                       data-url="<?= base_url('admin/custom_sms/view_sms') ?>"
                       data-click-to-select="true"
                       data-side-pagination="server"
                       data-pagination="true"
                       data-page-list="[5, 10, 20, 50, 100, 200]"
                       data-search="true"
                       data-show-columns="true"
                       data-show-refresh="true"
                       data-sort-name="id"
                       data-sort-order="desc"
                       data-mobile-responsive="true"
                       data-show-export="true"
                       data-maintain-selected="true"
                       data-export-types='["txt","excel"]'
                       data-export-options='{"fileName": "custom-sms-list", "ignoreColumn":["operate"]}'
                       data-query-params="queryParams">

                    <thead>
                        <tr>
                            <th data-field="id" data-sortable="true">ID</th>
                            <th data-field="title" data-sortable="false">Title</th>
                            <th data-field="type" data-sortable="true">Type</th>
                            <th data-field="message" data-sortable="true">Message</th>
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
    </div>
  
    <!-- Modal -->
    <div class="modal modal-blur fade sms-modal" id="sms-gateway-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title">Custom Message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body p-4">
               
                       <form x-data="ajaxForm({
                                            url: base_url + 'admin/custom_sms/update_sms',
                                            offcanvasId: '',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal form-submit-event add_sms" id="add_product_form" enctype="multipart/form-data">

                    <div class="card-body">

                        <!-- Hidden Fields -->
                        <?php if (isset($fetched_data[0]['id'])): ?>
                            <input type="hidden" id="edit_custom_sms" name="edit_custom_sms" value="<?= @$fetched_data[0]['id'] ?>">
                            <input type="hidden" id="update_id" name="update_id" value="1">
                            <input type="hidden" id="udt_title" value="<?= @$fetched_data[0]['title'] ?>">
                        <?php endif; ?>

                        <!-- TYPE -->
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Type <span class="text-danger">*</span></label>
                            <div class="col-sm-10">

                                <select name="type" class="form-control type" id="selected_type" disabled>
                                    <option value="">Select Type</option>
                                    <?php foreach ($notification_modules as $key => $value): ?>
                                        <option value="<?= $key ?>"
                                            <?= (isset($fetched_data[0]['id']) && $fetched_data[0]['type'] == $key) ? 'selected' : '' ?>>
                                            <?= ucwords(str_replace('_', ' ', $key)) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                                <!-- hidden, required for backend -->
                                <input type="hidden" name="type" id="selected_type_hidden">
                                <input type="hidden" name="edit_custom_sms" id="edit_id">

                            </div>
                        </div>

                        <!-- TITLE -->
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Title <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" name="title" id="edit_title"
                                       class="form-control update_title"
                                       placeholder="Title Name"
                                       value="<?= isset($fetched_data[0]['title']) ? $fetched_data[0]['title'] : '' ?>">
                            </div>
                        </div>

                        <!-- MESSAGE -->
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Message <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <textarea name="message"
                                          id="edit-text-box"
                                          class="form-control"
                                          rows="4"
                                          placeholder="Enter your SMS message here"><?= isset($fetched_data[0]['message']) ? $fetched_data[0]['message'] : '' ?></textarea>
                            </div>
                        </div>

                        <!-- Dynamic Hashtags -->
                        <?php
                            $types = [
                                'otp', 'place_order', 'seller_place_order',
                                'settle_cashback_discount', 'settle_seller_commission',
                                'customer_order_received', 'customer_order_processed',
                                'customer_order_shipped', 'customer_order_delivered',
                                'customer_order_cancelled', 'customer_order_returned',
                                'customer_order_returned_request_approved',
                                'customer_order_returned_request_decline',
                                'wallet_transaction', 'delivery_boy_processed',
                                'delivery_boy_return_order_assign',
                                'ticket_status', 'ticket_message',
                                'bank_transfer_receipt_status', 'bank_transfer_proof'
                            ];
                        ?>

                        <?php foreach ($types as $type): ?>

                            <?php
                                $hashtags = ($type == 'ticket_status' || $type == 'ticket_message')
                                    ? ['< application_name >']
                                    : get_notification_variables();
                            ?>

                            <div class="row mb-3 <?= $type ?> <?= (isset($fetched_data[0]['type']) && $fetched_data[0]['type'] == $type) ? '' : 'd-none' ?>">
                                <label class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10 d-flex flex-wrap gap-2">

                                    <?php foreach ($hashtags as $tag): ?>
                                        <div class="badge bg-blue-lt p-2 hashtag" style="cursor:pointer;">
                                            <?= $tag ?>
                                        </div>
                                    <?php endforeach; ?>

                                </div>
                            </div>

                        <?php endforeach; ?>

                        <!-- FOOTER BUTTONS -->
                        <div class="row mt-4">
                            <div class="col-sm-10 offset-sm-2 d-flex gap-2">

                                <button type="reset" class="btn btn-warning">
                                    Reset
                                </button>

                                <button type="submit" class="btn btn-success update_sms_data" id="submit_btn">
                                    <?= isset($fetched_data[0]['id']) ? 'Update Custom Message' : 'Add Custom Message' ?>
                                </button>

                            </div>
                        </div>

                    </div>

                </form>
            </div>

        </div>
    </div>
</div>






    <!-- Instruction Modal -->
    <div class="modal modal-blur fade" id="sms_instuction_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">SMS Gateway Configuration Guide</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <ul>
                        <li>Open your SMS gateway account and locate API keys.</li>
                        <li>Use Account SID and Auth Token for authentication.</li>
                        <li>Refer to the below screenshots for setup.</li>
                        <img src="<?= base_url('assets/admin/images/sms_gateway_1.png') ?>"
                            class="img-fluid rounded mb-3">
                        <img src="<?= base_url('assets/admin/images/sms_gateway_2.png') ?>" class="img-fluid rounded">
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>


<script>

</script>