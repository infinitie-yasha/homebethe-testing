<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">

                <!-- Mobile View (xs/sm) -->
                <div class="d-flex flex-column text-center d-sm-none py-2">
                    <h2 class="page-title fs-5 fw-semibold mb-1">Notification</h2>
                    <nav class="breadcrumb breadcrumb-arrows small justify-content-start mb-0">
                        <a href="<?= base_url('admin/home') ?>" class="breadcrumb-item">Home</a>
                        <span class="breadcrumb-item active">Manage Notifications</span>
                    </nav>
                </div>

                <!-- Tablet & Desktop View (md+) -->
                <div class="row g-2 align-items-center d-none d-sm-flex">
                    <div class="col">
                        <h2 class="page-title mb-0">Notification</h2>
                    </div>
                    <div class="col-auto ms-auto">
                        <ol class="breadcrumb breadcrumb-arrows mb-0 small">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('admin/home') ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Manage Notifications
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
                            <h3 class="card-title"><i class="ti ti-bell-ringing"></i> Notification Details</h3>
                            <a class="btn btn-primary SendNotification btn-sm bg-primary-lt" data-bs-toggle="offcanvas"
                                data-bs-target="#sendNotification" href="#" role="button"
                                aria-controls="sendNotification"> Send Notification </a>
                        </div>
                        <div class="card-body">
                            <table class='table-striped' id="send_notification_table" data-toggle="table"
                                data-url="<?= base_url('admin/Notification_settings/get_notification_list') ?>"
                                data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                                data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                                data-sort-order="desc" data-mobile-responsive="true" data-toolbar=""
                                data-show-export="true" data-maintain-selected="true" data-query-params="queryParams">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true">ID</th>
                                        <th data-field="title" data-sortable="false">Title</th>
                                        <th data-field="type" data-sortable="false">Type</th>
                                        <th data-field="image" data-sortable="false" class="col-md-5">Image</th>
                                        <th data-field="link" data-sortable="false" class="col-md-5">Link</th>
                                        <th data-field="message" data-sortable="false">Message</th>
                                        <th data-field="send_to" data-sortable="false">Send to</th>
                                        <th data-field="users_id" data-sortable="false">User(s) Name</th>
                                        <th data-field="operate" data-sortable="false">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>


                        <div class="offcanvas offcanvas-end offcanvas-medium" tabindex="-1" id="sendNotification"
                            aria-labelledby="sendNotificationLabel">
                            <div class="offcanvas-header">
                                <h2 class="offcanvas-title" id="sendNotificationLabel">Send Notification</h2>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <form x-data="ajaxForm({
                                            url: base_url + 'admin/Notification_settings/send_notifications',
                                            offcanvasId: 'sendNotification',
                                        })" method="POST" class="form-horizontal" id="send_notification_form">
                                <div class="offcanvas-body">
                                    <div>
                                        <input type="hidden" id="update_id" name="update_id" value="1">

                                        <div class="mb-3 row">
                                            <label class="col-12 col-md-3  col-form-label required" for="send_to">Send
                                                to</label>
                                            <div class="col">
                                                <select name="send_to" id="send_to"
                                                    class="form-control type_event_trigger">
                                                    <option value="all_users">All Users</option>
                                                    <option value="specific_user">Specific User</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="mb-3 row notification-users d-none">
                                            <div x-data x-init="initTomSelect({
                                                    element: $refs.userSelect,
                                                    url: '<?= base_url('admin/customer/search_user') ?>',
                                                    placeholder: 'Search User...',
                                                    offcanvasId: 'sendNotification',
                                                    maxItems: 20,
                                                    preloadOptions: true
                                                })" class="mb-3 row">

                                                <label class="col-12 col-md-3  col-form-label required"
                                                    for="userSelect">Users</label>
                                                <div class="col">
                                                    <select x-ref="userSelect" class="form-select"
                                                        name="select_user_id[]" id="userSelect"></select>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-12 col-md-3  col-form-label required"
                                                for="type">Type</label>
                                            <div class="col">
                                                <select name="type" id="type" class="form-control type_event_trigger">
                                                    <option value=" ">Select Type</option>
                                                    <option value="default">Default</option>
                                                    <option value="categories">Category</option>
                                                    <option value="products">Product</option>
                                                    <option value="notification_url">Notification URL</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div id="type_add_html">
                                            <!-- for category -->
                                            <div class="mb-3 row notification-categories d-none ">
                                                <div x-data x-init="initTomSelect({
                                                    element: $refs.CategorySelect,
                                                    url: '/admin/category/get_categories?from_select=1',
                                                    placeholder: 'Search Category...',
                                                    onItemAdd: addCategoryModal,
                                                    offcanvasId: 'sendNotification',
                                                    dataAttribute: 'data-type-id',
                                                    maxItems: 1,
                                                    preloadOptions: true
                                                })" class="mb-3 row">

                                                    <label class="col-12 col-md-3  col-form-label required"
                                                        for="CategorySelect">Select Categories</label>
                                                    <div class="col">
                                                        <select x-ref="CategorySelect" name="category_id"
                                                            class="form-select" id="CategorySelect"></select>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- for notification url -->
                                            <div class="mb-3 row notification-url d-none">
                                                <label class="col-12 col-md-3  col-form-label required"
                                                    for="notification_url">Link</label>
                                                <div class="col">
                                                    <input type="text" class="form-control" name="link"
                                                        id="notification_url" placeholder="https://example.com" />
                                                </div>
                                            </div>

                                            <!-- for products -->
                                            <div class="mb-3 row notification-products d-none ">
                                                <div x-data x-init="initTomSelect({
                                                    element: $refs.ProductSelect,
                                                    url: '/admin/product/get_product_data?from_select=1',
                                                    placeholder: 'Search Products...',
                                                    offcanvasId: 'sendNotification',
                                                    dataAttribute: 'data-type-id',
                                                    maxItems: 1,
                                                    preloadOptions: true
                                                })" class="mb-3 row">

                                                    <label class="col-12 col-md-3  col-form-label required"
                                                        for="ProductSelect">Select Products</label>
                                                    <div class="col">
                                                        <select x-ref="ProductSelect" name="product_id"
                                                            class="form-select" id="ProductSelect"></select>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-12 col-md-3  col-form-label required"
                                                for="title">Title</label>
                                            <div class="col">
                                                <input type="text" class="form-control" name="title" id="title"
                                                    placeholder="Title for notification" />
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-12 col-md-3  col-form-label required"
                                                for="message">Message</label>
                                            <div class="col">
                                                <textarea name="message" class="textarea form-control"
                                                    placeholder="Message for notification"
                                                    data-bs-toggle="autosize"> </textarea>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="form-check" for="image_checkbox">
                                                <input class="form-check-input" type="checkbox" name="image_checkbox"
                                                    id="image_checkbox" />
                                                <span class="form-check-label">Include Image</span>
                                            </label>
                                        </div>

                                        <div class="mb-3 row d-none include_image">
                                            <label class="col-12 col-md-3  col-form-label required"
                                                for="image">Image</label>
                                            <div class="col form-group">
                                                <a class="uploadFile img text-decoration-none" data-input='image'
                                                    data-isremovable='0' data-is-multiple-uploads-allowed='0'
                                                    data-bs-toggle="modal" data-bs-target="#media-upload-modal"
                                                    value="Upload Photo">
                                                    <input type="file" class="form-control" name="image" id="image" />
                                                </a>

                                                <div class="container-fluid row image-upload-section">
                                                    <label class="text-danger mt-3 edit_slider_upload_image_note">*Only
                                                        Choose When Update is necessary</label>
                                                    <div class="col-sm-6 shadow rounded text-center grow image">
                                                        <div class=''>
                                                            <img class="img-fluid mb-2" id="slider_uploaded_image"
                                                                src="<?= base_url() . NO_IMAGE ?>"
                                                                alt="Image Not Found">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <!-- <button type="reset" class="btn btn-warning ">Reset</button> -->
                                        <button type="button" class="btn" data-bs-dismiss="offcanvas"
                                            aria-label="Close">Close</button>
                                        <button type="submit" class="btn btn-primary" x-bind:disabled="isLoading">
                                            Send <i class="ms-2 ti ti-arrow-right"></i>
                                        </button>

                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id='addCategoryModal'>
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add Category</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form x-data="ajaxForm({
                                            url: base_url + 'admin/category/add_category',
                                            modalId: 'addCategoryModal',
                                        })" method="POST" class="form-horizontal" id="add_category_form">

                                        <div class="modal-body p-0">

                                            <div class="card-body">

                                                <input type="hidden" name="edit_category" id="edit_category">

                                                <!-- Category Name -->
                                                <div class="mb-3 row">
                                                    <label class="col-3 col-form-label required"
                                                        for="category_input_name">Name</label>
                                                    <div class="col">
                                                        <input type="text" class="form-control"
                                                            name="category_input_name" id="category_input_name"
                                                            placeholder="Category Name" />
                                                    </div>
                                                </div>

                                                <!-- Select Parent -->
                                                <div class="mb-3 row" x-data x-init="initTomSelect({
        element: $refs.CategoryParentSelect,
        url: '/admin/category/get_categories?from_select=1',
        placeholder: 'Select Parent',
        dataAttribute: 'data-category-parent-id',
        maxItems: 5,
        preloadOptions: true
     })">

                                                    <label for="CategoryParentSelect"
                                                        class="col-3 col-form-label required">
                                                        Select Parent
                                                    </label>
                                                    <div class="col">
                                                        <select x-ref="CategoryParentSelect" name="category_parent"
                                                            id="CategoryParentSelect" class="form-control">
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="mb-3 row">
                                                    <label class="col-3 col-form-label required" for="image">Main
                                                        Image</label>
                                                    <div class="col form-group">
                                                        <a class="uploadFile img text-decoration-none"
                                                            data-input='category_input_image' data-isremovable='0'
                                                            data-is-multiple-uploads-allowed='0' data-bs-toggle="modal"
                                                            data-bs-target="#media-upload-modal" value="Upload Photo">
                                                            <input type="file" class="form-control" name="image"
                                                                id="category_input_image" />
                                                        </a>
                                                        <label
                                                            class="text-danger mt-3 edit_slider_upload_image_note d-none"
                                                            id="no-image-slider">
                                                            *Only Choose When Update is necessary
                                                        </label>

                                                        <div class="container-fluid row image-upload-section d-none">
                                                            <div
                                                                class="col-sm-12 shadow rounded text-center grow image">
                                                                <div>
                                                                    <img class="img-fluid mb-2"
                                                                        id="slider_uploaded_image"
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

                                                <hr>
                                                <h4 class="bg-light m-0 px-2 py-3">SEO Configuration</h4>
                                                <hr>

                                                <div class="mb-3 row">
                                                    <label class="col-3 col-form-label required"
                                                        for="seo_page_title">SEO Page Title</label>
                                                    <div class="col">
                                                        <input type="text" class="form-control" name="seo_page_title"
                                                            id="seo_page_title" placeholder="SEO Page title" />
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-3 col-form-label required"
                                                        for="seo_meta_description">SEO Meta Description</label>
                                                    <div class="col">
                                                        <textarea name="seo_meta_description" id="seo_meta_description"
                                                            class="textarea form-control"
                                                            placeholder="SEO Meta Description"
                                                            data-bs-toggle="autosize"> </textarea>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-3 col-form-label required"
                                                        for="seo_meta_keywords">SEO Meta Keywords</label>
                                                    <div class="col">
                                                        <input type="text tags" class="form-control"
                                                            name="seo_meta_keywords" id="seo_meta_keywords"
                                                            placeholder="SEO Meta Keywords" />
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label class="col-3 col-form-label required" for="image">SEO Open
                                                        Graph Image </label>
                                                    <div class="col form-group">
                                                        <a class="uploadFile img text-decoration-none"
                                                            data-input='seo_og_image' data-isremovable='1'
                                                            data-is-multiple-uploads-allowed='0' data-bs-toggle="modal"
                                                            data-bs-target="#media-upload-modal" value="Upload Photo">
                                                            <input type="file" class="form-control" name="seo_og_image"
                                                                id="seo_og_image" />
                                                        </a>
                                                        <label
                                                            class="text-danger mt-3 edit_promo_upload_image_note">*Only
                                                            Choose When Update is necessary</label>

                                                        <div class="container-fluid row image-upload-section">
                                                            <div class="col-sm-6 shadow rounded text-center grow image">
                                                                <div class=''>
                                                                    <img class="img-fluid mb-2"
                                                                        id="uploaded_og_image_here"
                                                                        src="<?= base_url() . NO_IMAGE ?>"
                                                                        alt="Image Not Found">
                                                                    <input type="hidden" name="seo_og_image"
                                                                        id="seo_og_image_hidden"
                                                                        class="uploaded_image_here form-control form-input">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- /.card-footer -->
                                        </div>
                                        <div class="modal-footer">
                                            <div class="d-flex justify-content-center form-group">
                                                <div id="result" class="p-3"></div>
                                            </div>
                                            <button type="reset" class="btn btn-warning reset_category">Reset</button>
                                            <button type="submit" class="btn btn-primary save_category_btn"
                                                id="submit_btn">Add Category</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
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