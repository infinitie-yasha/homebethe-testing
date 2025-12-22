<div class="page-wrapper">
    


        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">Manage Media Gallery</h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="d-flex">
                            <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('seller/home') ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">Manage Media Gallery</a>
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
                            <h5 class="card-title">Uploaded Media Files</h5>
                        </div>
                        <div class="card-body">
                            <div id="dropzone" class="dropzone dz-clickable"></div>
                            <a href="" id="upload-files-btn" class="btn btn-primary bg-primary-lt float-right mt-3">Upload</a>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title">Media Gallery</h5>
                        </div>
                        <div class="card-body">
                           <div class="row g-3 align-items-end mb-3">

    <!-- Date Range -->
    <div class="col-12 col-md-5">
        <label class="col-form-label" for="datepicker">Date and time range:</label>
        <div class="input-icon">
            <input type="text" class="form-control" id="datepicker" autocomplete="off">
            <input type="hidden" id="start_date">
            <input type="hidden" id="end_date">

            <span class="input-icon-addon">
                <i class="ti ti-clock"></i>
            </span>
        </div>
    </div>

    <!-- Media Type Dropdown -->
    <div class="col-12 col-md-4">
        <label class="col-form-label" for="media-type">Media Type</label>
        <select name="media-type" id="media-type" class="form-select">
            <option value="">All Media Items</option>
            <option value="image">Images</option>
            <option value="audio">Audio</option>
            <option value="video">Video</option>
            <option value="archive">Archive</option>
            <option value="spreadsheet">Spreadsheet</option>
            <option value="documents">Documents</option>
        </select>
    </div>

    <!-- Search & Reset -->
    <div class="col-12 col-md-3">
        <label class="col-form-label">&nbsp;</label>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary w-50" onclick="status_date_wise_search()">
                <i class="ti ti-search"></i> Search
            </button>
            <button type="button" class="btn btn-outline-secondary w-50" onclick="resetfilters()">
                <i class="ti ti-refresh"></i> Reset
            </button>
        </div>
    </div>
</div>

<!-- Bulk Delete Toolbar -->
<div id="mediaToolbar" 
     x-data="bulkDelete({
         url: '<?= base_url('seller/media/media_delete') ?>',
         tableSelector: '#media-table',
         confirmTitle: 'Delete Selected Media',
         confirmMessage: 'Are you sure you want to delete the selected media items?',
         confirmOkText: 'Yes, delete them!',
         confirmCancelText: 'Cancel'
     })"
     class="mb-3">

    <button @click="deleteSelected()" :disabled="isLoading"
        class="btn btn-danger bg-danger-lt">
        <i class="fa fa-trash me-2" x-show="!isLoading"></i>
        <i class="fa fa-spinner fa-spin me-2" x-show="isLoading"></i>
        <span x-text="isLoading ? 'Deleting...' : 'Delete Selected'"></span>
    </button>
</div>

                            <table class='table-striped' data-toolbar="#mediaToolbar" id='media-table' data-page-size="5" data-toggle="table" data-url="<?= base_url('seller/media/fetch') ?>" data-click-to-select="true" data-single-select='false' data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true" data-show-refresh="true" data-trim-on-search="false" data-sort-name="id" data-sort-order="desc" data-mobile-responsive="true" data-toolbar="" data-show-export="true" data-query-params="mediaUploadParams">
                                        <thead>
                                            <tr>
                                                <th data-field="state" data-checkbox="true"></th>
                                                <th data-field="id" data-sortable="true" data-visible='false'>ID</th>
                                                <th data-field="seller_id" data-sortable="true" data-visible='false'>Seller ID</th>
                                                <th data-field="name" data-sortable="false">Name</th>
                                                <th data-field="image" data-sortable="false">Image</th>
                                                <th data-field="extension" data-sortable="false">Extension</th>
                                                <th data-field="sub_directory" data-sortable="false">Sub directory</th>
                                                <th data-field="size" data-sortable="false">Size</th>
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