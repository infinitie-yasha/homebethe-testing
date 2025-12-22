<div class="page-wrapper">




  <!-- BEGIN PAGE HEADER -->
  <div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <h2 class="page-title">Manage withdrawal</h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
          <div class="d-flex">
            <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
              <li class="breadcrumb-item">
                <a href="<?= base_url('seller/home') ?>">Home</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">
                <a href="#">Wallet withdrawal</a>
              </li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- END PAGE HEADER -->

  <!-- Main Content -->
  <div class="page-body">
    <div class="container-xl">
      <div class="col-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">
              <i class="ti ti-wallet me-2"></i> Withdrawal Details
            </h3>
            <button type="button" class="btn btn-primary bg-primary-lt text-primary btn-sm" data-bs-toggle="offcanvas"
              data-bs-target="#withdrawalOffcanvas" aria-controls="withdrawalOffcanvas">
              Send Withdrawal Request
            </button>

          </div>
          <div class="card-body">
            <div class="row g-3 align-items-end mb-3">
              <!-- Payment Type Filter -->
              <div class="col-12 col-sm-6 col-md-3">
                <label for="status" class="form-label">Payment status</label>
                <select class="form-select" id="status" name="status">
                  <option value="">All Status</option>
                  <option value="0">Pending</option>
                  <option value="1">Approved</option>
                  <option value="2">Rejected</option>
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



            <table class='table-striped' id='payment_request_table' data-toggle="table"
              data-url="<?= base_url('seller/payment-request/view_withdrawal_request_list') ?>"
              data-click-to-select="true" data-side-pagination="server" data-pagination="true"
              data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
              data-show-refresh="true" data-trim-on-search="false" data-sort-name="pr.id" data-sort-order="desc"
              data-mobile-responsive="true" data-toolbar="" data-show-export="true" data-maintain-selected="true"
              data-query-params="withdrawal_request_query_params">
              <thead>
                <tr>
                  <th data-field="id" data-sortable="true">ID</th>
                  <!-- <th data-field="user_name" data-sortable="false">Username</th>
                                    <th data-field="payment_type" data-sortable="true">Type</th> -->
                  <th data-field="payment_address" data-sortable="false">Payment Address</th>
                  <th data-field="amount_requested" data-sortable="false">Amount Requested</th>
                  <th data-field="remarks" data-sortable="false">Remarks</th>
                  <th data-field="status" data-sortable="false">Status</th>
                  <th data-field="date_created" data-sortable="false">Date Created</th>
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

<!-- Withdrawal Request Offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="withdrawalOffcanvas" aria-labelledby="withdrawalOffcanvasLabel">
  <div class="offcanvas-header bg-light text-black">
    <h5 class="offcanvas-title" id="withdrawalOffcanvasLabel">Send Withdrawal Request</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>


  <form x-data="ajaxForm({
        url: base_url + 'seller/payment-request/add-withdrawal-request',
        loaderText: 'Updating...',
        offcanvas: '#withdrawalOffcanvas',
    })" id="withdrawalForm" method="POST" enctype="multipart/form-data">
    <div class="offcanvas-body">

      <!-- CSRF Token -->
      <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
        value="<?= $this->security->get_csrf_hash(); ?>">

      <!-- Logged-in User ID -->
      <input type="hidden" name="user_id" value="<?= $this->ion_auth->user()->row()->id; ?>">

      <!-- Payment Details -->
      <div class="mb-3">
        <label for="payment_address" class="form-label">
          Payment Details <span class="text-danger">*</span>
        </label>
        <textarea class="form-control" id="payment_address" name="payment_address"
          placeholder="Enter your payment details" required></textarea>
      </div>

      <!-- Amount -->
      <div class="mb-3">
        <label for="amount" class="form-label">
          Amount <span class="text-danger">*</span>
        </label>
        <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter amount" min="1"
          step="any" required>
      </div>

      <!-- Buttons (Moved Below Inputs) -->
      <div class="d-flex justify-content-end mt-4">
        <button type="reset" class="btn btn-warning me-2">Reset</button>
        <button type="submit" class="btn btn-success" id="submit_btn">Send</button>
      </div>
    </div>
  </form>
</div>