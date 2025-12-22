<div class="page-wrapper">
   

 
    <!-- BEGIN PAGE HEADER -->
    <div class="page-header d-print-none" aria-label="Page header">
      <div class="container-xl">
        <div class="row g-2 align-items-center">
          <div class="col">
            <h2 class="page-title">Manage City</h2>
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
                  <a href="#">City</a>
                </li>
              </ol>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- END PAGE HEADER -->


  <!-- Main Content -->
  <section class="content">
    <div class="container-fluid d-flex justify-content-center">
      <div class="main-content w-100" style="max-width: 80%;">
        <div class="card content-area p-4">
          <div class="card-innr">
            <div class="gaps-1-5x"></div>
           <table class='table-striped'
          data-toggle="table"
          data-url="<?= base_url('seller/area/view_city') ?>"
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
          data-export-types='["txt","excel"]'
          data-query-params="queryParams"
        >
          <thead>
            <tr>
              <th data-field="id" data-sortable="true">ID</th>
              <th data-field="name" data-sortable="false">Name</th>
              <th data-field="minimum_free_delivery_order_amount" data-sortable="false">Minimum Free Delivery Order Amount</th>
              <th data-field="delivery_charges" data-sortable="false">Delivery Charges</th>
            </tr>
          </thead>
        </table>
          </div><!-- .card-innr -->
        </div><!-- .card -->
      </div><!-- .main-content -->
    </div><!-- /.container-fluid -->
  </section>
</div>
