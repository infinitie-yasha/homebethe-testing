<div class="page-wrapper">
    <div class="page">

        <!-- PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col-12 col-md">
                        <h2 class="page-title">Bulk upload</h2>
                    </div>
                    <div class="col-12 col-md-auto ms-auto d-print-none">
                        <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                            <li class="breadcrumb-item"><a href="<?= base_url('seller/home') ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Product</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Product Bulk Upload</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- / PAGE HEADER -->

        <div class="page-body">
            <div class="container-xl">

                <div class="col-12">

                    <!-- INFO ALERT -->
                    <div class="alert alert-info alert-dismissible" role="alert">
                        <div class="d-flex align-items-start flex-wrap gap-3">
                            <div class="alert-icon">
                                <i class="ti ti-info-circle"></i>
                            </div>

                            <div class="flex-grow-1">
                                <?php
                                $date = date('Ymd');
                                $filename = "products_" . $date . ".csv";
                                ?>
                                <h4 class="alert-heading mb-2">Bulk Upload Instruction:</h4>
                                <ul class="alert-list mb-0">
                                    <li>Read and follow instructions carefully while preparing data</li>
                                    <li>Download and save the sample file to reduce errors</li>
                                    <li>Only <b>.csv</b> format supported</li>
                                    <li>You can copy image path from media section</li>
                                    <li><b>Make sure all data follows instructions</b></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- CARD: Upload Form -->
                    <div class="card">
                        <div class="card-header">
                            <div class="row w-100 g-2 align-items-center">
                                <div class="col-12 col-md-6">
                                    <h3 class="card-title mb-0 d-flex align-items-center">
                                        <i class="ti ti-world me-2"></i>
                                        Bulk Upload / Download
                                    </h3>
                                </div>

                                <div class="col-12 col-md-6 text-md-end">
                                    <a href="<?= base_url('seller/product/bulk_download') ?>"
                                        class="btn btn-info bg-info-lt  w-md-auto" download="<?= $filename ?>">
                                        <i class="ti ti-file fs-3"></i> Product Bulk Download
                                    </a>
                                </div>
                            </div>
                        </div>


                        <form x-data="ajaxForm({
                            url: base_url + 'seller/product/process_bulk_upload',
                            modalId: '',
                            loaderText: 'Saving...'
                        })" method="POST" class="form-horizontal" id="location_bulk_upload_form">

                            <div class="card-body">

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label required" for="type">
                                            Type <small>[upload/update]</small>
                                        </label>
                                        <select name="type" id="type" class="form-control type">
                                            <option value=''>Select</option>
                                            <option value='upload'>Upload</option>
                                            <option value='update'>Update</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label required" for="upload_file">File</label>
                                        <input type="file" name="upload_file" id="upload_file"
                                            class="form-control file_upload_height" accept=".csv">
                                    </div>
                                </div>

                                <div class="text-center mt-4">
                                    <div id="upload_result" class="p-3"></div>
                                </div>

                                <div class="text-end mt-2">
                                    <button type="reset" class="btn btn-outline-secondary">
                                        <i class="ti ti-refresh"></i> Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary btn-2" id="submit_btn">
                                        <i class="ti ti-device-floppy ms-2"></i> Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- DOWNLOAD SECTIONS -->
                    <div class="card mt-3">
                        <div class="card-body">

                            <!-- Bulk Upload -->
                            <h4 class="text-primary mb-3">
                                <i class="ti ti-upload me-2"></i>Bulk Upload
                            </h4>

                            <div class="row g-3">
                                <div class="col-12 col-sm-6 col-md-4">
                                    <a href="<?= base_url('uploads/seller-product-bulk-upload-sample.csv') ?>"
                                        class="btn btn-primary bg-primary-lt w-100"
                                        download="product-bulk-upload-sample.csv">
                                        <i class="ti ti-download fs-3"></i>
                                        <small>Bulk upload sample file</small>
                                    </a>
                                </div>

                                <div class="col-12 col-sm-6 col-md-4">
                                    <a href="<?= base_url('uploads/bulk-upload-instructions.txt') ?>"
                                        class="btn btn-primary bg-primary-lt w-100"
                                        download="product-bulk-upload-instructions.txt">
                                        <i class="ti ti-download fs-3"></i>
                                        <small>Bulk upload instructions</small>
                                    </a>
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- Bulk Update -->
                            <h4 class="text-success mb-3">
                                <i class="ti ti-upload me-2"></i>Bulk Update
                            </h4>

                            <div class="row g-3">
                                <div class="col-12 col-sm-6 col-md-4">
                                    <a href="<?= base_url('uploads/product-bulk-update-sample.csv') ?>"
                                        class="btn btn-success bg-success-lt w-100"
                                        download="seller-product-bulk-update-sample.csv">
                                        <i class="ti ti-download fs-3"></i>
                                        <small>Bulk update sample file</small>
                                    </a>
                                </div>

                                <div class="col-12 col-sm-6 col-md-4">
                                    <a href="<?= base_url('uploads/bulk-update-instructions.txt') ?>"
                                        class="btn btn-success bg-success-lt w-100"
                                        download="bulk-update-instructions.txt">
                                        <i class="ti ti-download fs-3"></i>
                                        <small>Bulk update instructions</small>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>