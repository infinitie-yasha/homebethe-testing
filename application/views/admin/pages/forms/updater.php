<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">Update (Version <?= $system['db_current_version'] ?>)</h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="d-flex">
                            <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/home') ?>">Home</a>
                                </li>
                                 <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">Settings</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">System Update</a>
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
                            <h5 class="card-title">Update System</h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <div class="alert-icon">
                                    <i class="ti ti-alert-circle"></i>
                                </div>
                                <div>
                                    <h4 class="alert-heading">NOTE:</h4>
                                    <div class="alert-description">
                                        <ul class="alert-list">
                                            <li>Make sure you update system in sequence.</li>
                                            <li>Like if you have current version 1.0 and you want to update this version
                                                to 1.5 then you can't update it directly.</li>
                                            <li>You must have to update in sequence like first update version 1.2 then
                                                1.3 and 1.4 so on.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <form action="<?= base_url('admin/updater/upload_update_file'); ?>" method="POST"
                                enctype="multipart/form-data" id="system-update-form">
                                <div class="dropzone" id="system-update-dropzone">
                                </div>
                                <button type="button" id="system_update_btn" class="btn btn-primary float-right mt-3">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>