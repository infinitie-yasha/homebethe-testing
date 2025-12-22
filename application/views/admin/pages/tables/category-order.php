<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">Manage Categories Order</h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="d-flex">
                            <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/home') ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/category') ?>">Categories</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">Categories Order</a>
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
                        <div class="align-items-start card-header d-flex flex-column">
                            <h3 class="card-title"><i class="ti ti-language"></i> Category List</h3>
                        </div>

                        <div class="card-body">
                            <div class="col-12 col-md-10 col-lg-8 mx-auto">

                                <!-- Header Row -->
                                <div class="table-header border rounded p-2 mb-2 d-none d-sm-block">
                                    <div class="row text-center fw-bold">
                                        <div class="col-2">No.</div>
                                        <div class="col-4">Order ID</div>
                                        <div class="col-3">Title</div>
                                        <div class="col-3">Image</div>
                                    </div>
                                </div>

                                <!-- Sortable List -->
                                <ul class="list-group bg-grey-100 move order-container" id="sortable">
                                    <?php if (!empty($categories)) {
                                        foreach ($categories as $row) { ?>
                                            <li class="list-group-item d-flex flex-column flex-sm-row align-items-center gap-2 py-3"
                                                id="category_id_<?= $row['id'] ?>">

                                                <div class="col-12 col-sm-2 text-center fw-bold">
                                                    <i class="ti ti-pencil fs-4 me-1"></i><?= $row['id'] ?>
                                                </div>

                                                <div class="col-12 col-sm-4 text-center text-sm-start">
                                                    Order: <?= $row['row_order'] ?>
                                                </div>

                                                <div class="col-12 col-sm-3 text-center text-sm-start">
                                                    <?= strip_tags(output_escaping(str_replace('\r\n', '&#13;&#10;', $row['name']))) ?>
                                                </div>

                                                <div class="col-12 col-sm-3 text-center">
                                                    <img src="<?= (!empty($row['image']) && $row['image'] != base_url()) ? $row['image'] : base_url() . NO_IMAGE ?>"
                                                        class="img-fluid rounded" style="max-width: 80px;">
                                                </div>

                                            </li>
                                        <?php }
                                    } ?>
                                </ul>

                                <!-- Save Button -->
                                <div class="mt-4 text-center text-sm-end">
                                    <button type="submit" class="btn btn-primary" id="save_category_order">
                                        Save <i class="cursor-pointer ms-2 ti ti-arrow-right"></i>
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