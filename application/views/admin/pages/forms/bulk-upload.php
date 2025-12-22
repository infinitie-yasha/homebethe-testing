<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">Bulk upload</h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="d-flex">
                            <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/home') ?>">Home</a>
                                </li>
                                 <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">Product </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">Product Bulk Upload</a>
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
                    <div class="alert alert-info alert-dismissible" role="alert">
                        <div class="alert-icon">
                            <i class="ti ti-info-circle"></i>
                        </div>
                        <?php
                        $date = date('Ymd');
                        $filename = "products_" . $date . ".csv";
                        ?>
                        <div>
                            <h4 class="alert-heading">Bulk Upload Instruction:</h4>
                            <div class="alert-description">
                                <ul class="alert-list">
                                    <li>Read and follow instructions carefully while preparing data</li>
                                    <li>Download and save the sample file to reduce errors</li>
                                    <li>For adding bulk Product file should be .csv format</li>
                                    <li>You can copy image path from media section</li>
                                    <li><b>Make sure you entered valid data as per instructions before proceed</b></li>
                                </ul>
                            </div>
                        </div>

                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div
                                class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2 w-100">

                                <h3 class="card-title d-flex align-items-center gap-2 mb-0">
                                    <i class="ti ti-world"></i> Bulk Upload / Download
                                </h3>

                                <a href="<?= base_url('admin/product/bulk_download') ?>"
                                    class="btn btn-info bg-info-lt btn-sm w-sm-auto text-start text-sm-center"
                                    download="<?= $filename ?>">
                                    <i class="d-block fs-3 mx-2 ti ti-file"></i>
                                    Product Bulk Download
                                </a>

                            </div>
                        </div>

                        <!-- form start -->
                        <form x-data="ajaxForm({
                                            url: base_url + 'admin/product/process_bulk_upload',
                                            modalId: '',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="location_bulk_upload_form">
                            <div class="card-body">

                                <div class="mb-3 row">
                                    <label class="col-12 col-md-4 col-form-label required" for="type">Type
                                        <small>[upload/update]</small> </label>
                                    <div class="col">
                                        <select name="type" id="type" class="form-control type">
                                            <option value=''>Select</option>
                                            <option value='upload'>Upload</option>
                                            <option value='update'>Update</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-12 col-md-4 col-form-label required"
                                        for="upload_file">File</label>
                                    <div class="col">
                                        <input type="file" name="upload_file" id="upload_file"
                                            class="form-control file_upload_height" accept=".csv" />
                                    </div>
                                </div>


                                <div class="d-flex justify-content-center form-group">
                                    <div id="upload_result" class="p-3"></div>
                                </div>

                                <div class="form-group text-end">
                                    <button type="reset" class="btn btn-outline-secondary"><i
                                            class="ti ti-refresh"></i>Reset</button>
                                    <button type="submit" class="btn btn-primary btn-2" id="submit_btn"><i
                                            class="cursor-pointer ms-2 ti ti-device-floppy"></i>Submit </button>
                                </div>
                            </div>
                        </form>

                    </div>

                    <div class="card mt-3">

                        <div class="card-body">
                            <!-- Zipcode Section -->
                            <div class="mb-4">
                                <h4 class="text-primary mb-3">
                                    <i class="ti ti-upload me-2"></i>Bulk Upload
                                </h4>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <a href="<?= base_url('uploads/product-bulk-upload-sample.csv') ?>"
                                            class="bg-primary-lt btn btn-primary w-100"
                                            download="product-bulk-upload-sample.csv">
                                            <i class="d-block fs-3 mx-2 ti ti-download"></i>
                                            <small class="text-muted"> Bulk upload sample file</small>
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="<?= base_url('uploads/bulk-upload-instructions.txt') ?>"
                                            class="bg-primary-lt btn btn-primary w-100"
                                            download="product-bulk-upload-instructions.txt">
                                            <i class="d-block fs-3 mx-2 ti ti-download"></i>
                                            <small class="text-muted"> Bulk upload instructions</small>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- City Section -->
                            <div class="mb-4">
                                <h4 class="text-success mb-3">
                                    <i class="ti ti-upload me-2"></i>Bulk Update
                                </h4>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <a href="<?= base_url('uploads/product-bulk-update-sample.csv') ?>"
                                            class="btn btn-success bg-success-lt w-100"
                                            download="product-bulk-update-sample.csv">
                                            <i class="d-block fs-3 mx-2 ti ti-download"></i>
                                            <small class="text-muted">Bulk update sample file</small>
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="<?= base_url('uploads/bulk-update-instructions.txt') ?>"
                                            class="btn btn-success bg-success-lt w-100"
                                            download="bulk-update-instructions.txt">
                                            <i class="d-block fs-3 mx-2 ti ti-download"></i>
                                            <small class="text-muted">Bulk update instructions</small>
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
</div>