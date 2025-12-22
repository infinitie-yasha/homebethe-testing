<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
     <div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">

        <!-- Mobile View (xs/sm) -->
        <div class="d-flex flex-column text-center d-sm-none py-2">
            <h2 class="page-title fs-5 fw-semibold mb-1">Countries</h2>
            <nav class="breadcrumb breadcrumb-arrows small justify-content-start mb-0">
                <a href="<?= base_url('admin/home') ?>" class="breadcrumb-item">Home</a>
                <span class="breadcrumb-item">Location</span>
                <span class="breadcrumb-item active">Countries</span>
            </nav>
        </div>

        <!-- Tablet & Desktop View (sm+) -->
        <div class="row g-2 align-items-center d-none d-sm-flex">
            <div class="col">
                <h2 class="page-title mb-0">Countries</h2>
            </div>
            <div class="col-auto ms-auto">
                <ol class="breadcrumb breadcrumb-arrows mb-0 small">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('admin/home') ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0)">Location</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Countries
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
                        <?php
                        $date = date('Ymd');
                        $filename_countries = "countries_" . $date . ".csv";
                        ?>
                        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                            <h3 class="card-title mb-0 d-flex align-items-center gap-2">
                                <i class="ti ti-world"></i> Countries
                            </h3>

                            <a href="<?= base_url('admin/area/countries_bulk_dowload') ?>"
                                class="btn btn-info btn-sm bg-info-lt  w-sm-auto text-center"
                                download="<?= $filename_countries ?>">
                                <i class="ti ti-download me-1"></i> Country Download file
                            </a>
                        </div>

                        <div class="card-body">
                            <table class='table-striped' id="countries_table" data-toggle="table"
                                data-url="<?= base_url('admin/area/country_list') ?>" data-click-to-select="true"
                                data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                                data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                                data-sort-order="desc" data-mobile-responsive="true" data-toolbar=""
                                data-show-export="true" data-maintain-selected="true"
                                data-export-types='["txt","excel","csv"]' data-export-options='{
                        "fileName": "countries-list",
                        "ignoreColumn": ["state"] 
                        }' data-query-params="queryParams">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true">ID</th>
                                        <th data-field="numeric_code" data-sortable="false">Numeric Code</th>
                                        <th data-field="name" data-sortable="false">Name</th>
                                        <th data-field="capital" data-sortable="false" data-visible="false">Capital</th>
                                        <th data-field="phonecode" data-sortable="false">Phonecode</th>
                                        <th data-field="currency" data-sortable="false">Currency</th>
                                        <th data-field="currency_name" data-sortable="false" data-visible="false">
                                            Currency Name</th>
                                        <th data-field="currency_symbol" data-sortable="false" data-visible="false">
                                            Currency Symbol</th>
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