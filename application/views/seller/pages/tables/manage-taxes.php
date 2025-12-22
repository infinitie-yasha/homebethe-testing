<div class="page-wrapper">
    

    

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">Tax</h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="d-flex">
                            <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('seller/home') ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">product</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">tax</a>
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
                            <h3 class="card-title"><i class="ti ti-tax"></i> Tax</h3>
                        </div>

                        <div class="card-body">
                              <table class='table-striped'
                            data-toggle="table"
                            data-url="<?= base_url('seller/taxes/get_tax_list') ?>"
                            data-click-to-select="true"
                            data-side-pagination="server"
                            data-pagination="true"
                            data-page-list="[5, 10, 20, 50, 100, 200]"
                            data-search="true"
                            data-show-columns="true"
                            data-show-refresh="true"
                            data-trim-on-search="false"
                            data-sort-name="id"
                            data-sort-order="desc"
                            data-mobile-responsive="true"
                            data-toolbar=""
                            data-show-export="true"
                            data-maintain-selected="true"
                            data-query-params="queryParams">
                            <thead>
                                <tr>
                                    <th data-field="id" data-sortable="true">ID</th>
                                    <th data-field="title" data-sortable="false">Title</th>
                                    <th data-field="percentage" data-sortable="true">Percentage</th>
                                </tr>
                            </thead>
                        </table>                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>
</div>