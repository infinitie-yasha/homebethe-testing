<div class="page-wrapper">



  <!-- BEGIN PAGE HEADER -->
  <div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <h2 class="page-title">Manage Wallet transaction</h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
          <div class="d-flex">
            <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
              <li class="breadcrumb-item">
                <a href="<?= base_url('seller/home') ?>">Home</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">
                <a href="#">Wallet Transaction</a>
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
            <h3 class="card-title"><i class="ti ti-transfer"></i> wallet transaction Details</h3>

          </div>
          <div class="card-body ">

            <div class="row g-3 align-items-end mb-3">
              <!-- Payment Type Filter -->
              <div class="col-12 col-sm-6 col-md-3">
                <label for="payment_type" class="form-label">Payment Type</label>
                <select class="form-select" id="payment_type" name="payment_type">
                  <option value="">All Payment Types</option>
                  <option value="bank_transfer">Bank Transfer</option>
                  <option value="credit">Credit</option>
                  <option value="debit">Debit</option>
                  <option value="cod">COD</option>
                </select>
              </div>

              <!-- Buttons -->
              <div class="col-12 col-sm-6 col-md-3 d-flex gap-2">
                <button type="button" class="btn btn-secondary flex-fill" onclick="resetfilters()">
                  <i class="ti ti-refresh"></i> Clear
                </button>
                <button type="button" class="btn btn-primary flex-fill" onclick="status_date_wise_search()">
                  <i class="ti ti-search"></i> Filter
                </button>
              </div>
            </div>




            <table class='table-striped' data-toggle="table"
              data-url="<?= base_url('seller/transaction/view_transactions') ?>" data-click-to-select="true"
              data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]"
              data-search="true" data-show-columns="true" data-show-refresh="true" data-trim-on-search="false"
              data-sort-name="id" data-sort-order="desc" data-mobile-responsive="true" data-toolbar=""
              data-show-export="true" data-maintain-selected="true" data-query-params="seller_wallet_query_params">
              <thead>
                <tr>
                  <th data-field="id" data-sortable="true">ID</th>
                  <!-- <th data-field="name" data-sortable="false">User Name</th> -->
                  <th data-field="type" data-sortable="false">Type</th>
                  <th data-field="amount" data-sortable="false">Amount</th>
                  <th data-field="status" data-sortable="false">Status</th>
                  <th data-field="message" data-sortable="false">Message</th>
                  <th data-field="date" data-sortable="false">Date</th>
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