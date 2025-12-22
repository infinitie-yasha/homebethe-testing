<div class="page-wrapper">
  

 

    <!-- BEGIN PAGE HEADER -->
    <div class="page-header d-print-none" aria-label="Page header">
      <div class="container-xl">
        <div class="row g-2 align-items-center">
          <div class="col">
            <h2 class="page-title">Manage countries</h2>
          </div>
          <div class="col-auto ms-auto d-print-none">
            <div class="d-flex">
              <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                <li class="breadcrumb-item">
                  <a href="<?= base_url('seller/home') ?>">Home</a>
                </li>
                   <li class="breadcrumb-item active" aria-current="page">
                  <a href="#">location</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                  <a href="#">countries</a>
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
              <h3 class="card-title"><i class="ti ti-world"></i> countries Details</Details></h3>

            </div>
            <div class="card-body">
             <table class='table-striped'
          id='countries_table'
          data-toggle="table"
          data-url="<?= base_url('seller/area/country_list') ?>"
          data-click-to-select="true"
          data-side-pagination="server"
          data-pagination="true"
          data-page-list="[5, 10, 20, 50, 100, 200]"
          data-search="true"
          data-show-columns="true"
          data-show-refresh="true"
          data-trim-on-search="false"
          data-sort-name="id"
          data-sort-order="asc"
          data-mobile-responsive="true"
          data-toolbar=""
          data-show-export="true"
          data-maintain-selected="true"
          data-export-types='["txt","excel","csv"]'
          data-export-options='{
            "fileName": "countries-list",
            "ignoreColumn": ["state"]
          }'
          data-query-params="queryParams"
        >
          <thead>
            <tr>
              <th data-field="id" data-sortable="true">ID</th>
              <th data-field="numeric_code" data-sortable="false">Numeric Code</th>
              <th data-field="name" data-sortable="false">Name</th>
              <th data-field="capital" data-sortable="false" data-visible="false">Capital</th>
              <th data-field="phonecode" data-sortable="false">Phonecode</th>
              <th data-field="currency" data-sortable="false">Currency</th>
              <th data-field="currency_name" data-sortable="false" data-visible="false">Currency Name</th>
              <th data-field="currency_symbol" data-sortable="false" data-visible="false">Currency Symbol</th>
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