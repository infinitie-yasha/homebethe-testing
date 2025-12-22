<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <!-- Page Title -->
                    <div class="col-12 col-md">
                        <h2 class="page-title mb-1 mb-md-0">Manage Section Order</h2>
                    </div>

                    <!-- Breadcrumb -->
                    <div class="col-12 col-md-auto ms-auto d-flex justify-content-start justify-content-md-end">
                        <ol class="breadcrumb breadcrumb-arrows mb-0" aria-label="breadcrumbs">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('admin/home') ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                <a href="javascript:void(0);">Featured Section</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="#">Section Order</a>
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
                <div class="card shadow-sm">
    <div class="card-body">
        <div class="col-md-10 offset-md-1">
            <!-- Table Header -->
            <div class="d-flex border rounded-top fw-bold text-secondary py-2 px-3">
                <div class="col-2">No.</div>
                <div class="col-5">Order ID</div>
                <div class="col-5">Title</div>
            </div>

            <!-- List Group -->
            <ul class="list-group list-group-flush border rounded-bottom" id="sortable">
                <?php
                $i = 0;
                foreach ($section_result as $row) {
                    ?>
                    <li class="list-group-item d-flex align-items-center py-2" id="section_id-<?= $row['id'] ?>">
                        <div class="col-2 d-flex align-items-center">
                            <i class="ti ti-pencil fs-5 text-primary me-2"></i>
                            <span class="fw-medium"><?= $row['id'] ?></span>
                        </div>
                        <div class="col-5">
                            <span class="text-muted">Order:</span> <?= $row['row_order'] ?>
                        </div>
                        <div class="col-5 text-truncate" title="<?= strip_tags($row['title']) ?>">
                            <?= strip_tags(output_escaping(str_replace('\r\n', '&#13;&#10;', $row['title']))) ?>
                        </div>
                    </li>
                    <?php
                    $i++;
                }
                ?>
            </ul>

            <!-- Save Button -->
            <div class="d-flex justify-content-end mt-4">
                <button type="button" class="btn btn-primary" id="save_section_order">
                    Save
                    <i class="ti ti-arrow-right ms-2"></i>
                </button>
            </div>
        </div>
    </div>
</div>

                </div>
            </div>
        </div>
    </div>
</div>