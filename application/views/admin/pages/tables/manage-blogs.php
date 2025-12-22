<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">Manage blogs</h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="d-flex">
                            <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/home') ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">Blogs</a>
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
                            <h3 class="card-title"><i class="ti ti-language"></i> Blogs</h3>
                            <a href="#" class="btn btn-primary addBlogBtn btn-sm bg-primary-lt"
                                data-bs-toggle="offcanvas" data-bs-target="#addBlog">Add Blogs</a>
                        </div>

                        <div class="card-body">
                            <div class="col-md-3">
                                <label for="category_parent" class="col-form-label">Filter By Category</label>
                                <select id="category_parent" name="category_parent" placeholder="Select Status"
                                    required="" class="form-control">
                                    <option value="">
                                        <?= !empty($this->lang->line('select_category')) ? $this->lang->line('select_category') : 'Select Category' ?>
                                    </option>
                                    <?php foreach ($fetched_data as $categories) { ?>
                                        <option value="<?= $categories['id'] ?>" <?= (isset($categories[0]['id']) && $categories[0]['id'] == $categories['id']) ? 'selected' : "" ?>>
                                            <?= $categories['name'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <table class='table-striped' id="blogs_table" data-toggle="table"
                                data-url="<?= base_url('admin/blogs/view_blogs') ?>" data-click-to-select="true"
                                data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                                data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                                data-sort-order="desc" data-mobile-responsive="true" data-toolbar=""
                                data-show-export="true" data-maintain-selected="true"
                                data-export-types='["txt","excel"]' data-export-options='{
                                "fileName": "blog-list",
                                "ignoreColumn": ["state"]
                                }' data-query-params="blog_query_params">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true" data-visible='true'>ID</th>
                                        <th data-field="blog_category" data-sortable="false" data-align='center'>
                                            Category</th>
                                        <th data-field="title" data-sortable="false" data-align='center'
                                            class="col-md-2">Title</th>
                                        <th data-field="description" data-sortable="false" data-align='center'
                                            class="col-md-4">Description</th>
                                        <th data-field="image" data-sortable="false" data-align='center'>Image</th>
                                        <th data-field="status" data-sortable="false" data-align='center'>Status</th>
                                        <th data-field="operate" data-sortable="false" data-align='center'>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="offcanvas offcanvas-end offcanvas-medium" tabindex="-1" id="addBlog"
                            aria-labelledby="addBlogsLabel">
                            <div class="offcanvas-header">
                                <h2 class="offcanvas-title" id="addBlogsLabel">Add Blog</h2>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>

                            <form x-data="ajaxForm({
                                            url: base_url + 'admin/blogs/add_blog',
                                            offcanvasId: 'addBlog',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="add_blog_form">

                                <div class="offcanvas-body">
                                    <div>
                                        <div class="card-body">

                                            <input type="hidden" name="edit_blog" id="edit_blog" value="">

                                            <div class="mb-3 row">
                                                <label class="col-3 col-form-label required"
                                                    for="blog_title">Title</label>
                                                <div class="col">
                                                    <input type="text" class="form-control" name="blog_title"
                                                        id="blog_title" placeholder="Add Blog title" />
                                                </div>
                                            </div>

                                            <div class="mb-3 row">

                                                <div x-data x-init="initTomSelect({
                                                    element: $refs.blogCategorySelect,
                                                    url: '/admin/blogs/get_blog_category',
                                                    placeholder: 'Search Blog Category...',
                                                    onItemAdd: addBlogCategoryModal,
                                                    offcanvasId: 'addBlog',
                                                    dataAttribute: 'data-category-id',
                                                    maxItems: 1,
                                                    preloadOptions:true
                                                })" class="mb-3 row">

                                                    <label class="col-3 col-form-label required"
                                                        for="blogCategorySelect">Select Categories</label>
                                                    <div class="col">
                                                        <select x-ref="blogCategorySelect" name="blog_category"
                                                            class="form-select" id="blogCategorySelect"></select>
                                                    </div>
                                                </div>


                                            </div>

                                            <div class="mb-3 row">
                                                <label class="col-3 col-form-label required" for="image">Main
                                                    Image</label>
                                                <div class="col form-group">
                                                    <a class="uploadFile img text-decoration-none"
                                                        data-input='blog_image' data-isremovable='0'
                                                        data-is-multiple-uploads-allowed='0' data-bs-toggle="modal"
                                                        data-bs-target="#media-upload-modal" value="Upload Photo">
                                                        <input type="file" class="form-control" name="image"
                                                            id="blog_image" />
                                                    </a>

                                                    <div class="container-fluid row image-upload-section d-none">
                                                        <label
                                                            class="text-danger mt-3 edit_promo_upload_image_note">*Only
                                                            Choose When Update is necessary</label>
                                                        <div class="col-sm-6 shadow rounded text-center grow image">
                                                            <div class=''>
                                                                <img class="img-fluid mb-2" id="blog_uploaded_image"
                                                                    src="<?= base_url() . NO_IMAGE ?>"
                                                                    alt="Image Not Found">
                                                                <input type="hidden" name="blog_image"
                                                                    id="uploaded_blog_uploaded_image"
                                                                    class="uploaded_image_here form-control form-input">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <label class="col-3 col-form-label required" for="blog_description">Blog
                                                    Description</label>
                                                <div class="col">
                                                    <textarea class="hugerte-mytextarea" name="blog_description"
                                                        id="blog_description" placeholder="Place some text here"
                                                        data-hugerte></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <!-- <button type="reset" class="btn btn-warning ">Reset</button> -->
                                        <button type="button" class="btn" data-bs-dismiss="offcanvas"
                                            aria-label="Close">Close</button>
                                        <button type="submit" class="btn btn-primary save_blog_btn" id="submit_btn">Add
                                            Blog</button>
                                    </div>
                                </div>

                            </form>
                        </div>

                        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"
                            id='addBlogCategoryModal'>
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add Blog Category</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <!-- <form class="form-horizontal add_blog_category_form" id="add_blog_category_form"
                                        method="POST"> -->
                                    <form x-data="ajaxForm({
                                        url: base_url + 'admin/blogs/add_category',
                                        modalId: 'addBlogCategoryModal',
                                        loaderText: 'Saving...'
                                    })" method="POST" class="form-horizontal" id="add_blog_category_form">

                                        <div class="modal-body p-0">

                                            <div class="card-body">

                                                <input type="hidden" name="edit_category" id="edit_category">

                                                <div class="mb-3 row">
                                                    <label class="col-3 col-form-label required"
                                                        for="category_input_name">Name</label>
                                                    <div class="col">
                                                        <input type="text" class="form-control"
                                                            name="category_input_name" id="category_input_name"
                                                            placeholder="Category Name" />
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

                                                        <div class="container-fluid row image-upload-section">
                                                            <label class="text-danger mt-3 edit_promo_upload_image_note"
                                                                style="display: none;">*Only
                                                                Choose When Update is necessary</label>
                                                            <div class="col-sm-6 shadow rounded text-center grow image">
                                                                <div class=''>
                                                                    <img class="img-fluid mb-2"
                                                                        id="slider_uploaded_image"
                                                                        src="<?= base_url() . NO_IMAGE ?>"
                                                                        alt="Image Not Found">
                                                                    <input type="hidden" name="category_input_image"
                                                                        id="category_input_image"
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
                                            <button type="reset"
                                                class="btn btn-warning reset_blog_category">Reset</button>
                                            <button type="submit" class="btn btn-primary save_blog_category"
                                                id="submit_btn">Add Blog Category</button>
                                            <button type="button" class="btn" data-bs-dismiss="modal">Close</button>
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