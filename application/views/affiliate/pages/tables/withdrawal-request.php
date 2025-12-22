<div class="page-wrapper">
  <!-- Content Header (Page header) -->
  <div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <!-- Page Title -->
        <div class="col-12 col-md-6">
          <h2 class="page-title text-center text-md-start mb-2 mb-md-0">
            Withdrawal Request
          </h2>
        </div>

        <!-- Breadcrumb -->
        <div class="col-12 col-md-6">
          <div class="d-flex justify-content-center justify-content-md-end">
            <ol class="breadcrumb breadcrumb-arrows mb-0 flex-wrap justify-content-start">
              <li class="breadcrumb-item">
                <a href="<?= base_url('seller/home') ?>">Home</a>
              </li>
                <li class="breadcrumb-item active" aria-current="page">
                finance 
              </li>
              <li class="breadcrumb-item active" aria-current="page">
                Withdrawal Request
              </li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="page-body">
    <div class="container-xl">
      <!-- Withdrawal Request Modal -->
      <div class="offcanvas offcanvas-end" tabindex="-1" id="withdrawalModal" aria-labelledby="withdrawalModalLabel">
        <div class="offcanvas-header border-bottom">
          <h5 class="offcanvas-title" id="withdrawalModalLabel">Send Withdrawal Request</h5>
          <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">
        

             <form x-data="ajaxForm({
                                            url: base_url + 'affiliate/transaction/add_withdrawal_request',
                                            offcanvasId: '',
                                            
                                        })" method="POST" class="form-horizontal" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="withdrawalAmount" class="form-label">
                Amount <span class="text-danger">*</span>
              </label>
              <div class="input-group">
                <span class="input-group-text"><?= $currency ?></span>
                <input type="number" class="form-control" id="withdrawalAmount" name="withdrawalAmount"
                  placeholder="Enter amount" > 
              </div>
              <small class="form-text text-muted">
                Available balance: <?= $currency ?> <?= number_format($earning_data['confirm'], 2) ?>
              </small>
            </div>

            <div class="mb-3">
              <label for="payment_address" class="form-label">
                Payment Details <span class="text-danger">*</span>
              </label>
              <textarea class="form-control" id="payment_address" placeholder="Enter your payment details"
                name="payment_address" rows="3"></textarea>
            </div>

            <div class="text-end border-top pt-3">
              <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="offcanvas">Cancel</button>
              <button type="submit" class="btn btn-primary" id="submitWithdrawal">Send Request</button>
            </div>
          </form>
        </div>
      </div>


      <div class="row row-cards">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Withdrawal Requests</h3>
              <div class="card-actions">
                <a href="#" class="btn btn-primary bg-primary-lt btn-sm" data-bs-toggle="offcanvas"
                  data-bs-target="#withdrawalModal">
                  Send Withdrawal Request
                </a>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-vcenter table-striped" id="payment_request_table" data-toggle="table"
                  data-url="<?= base_url('affiliate/transaction/view_withdrawal_request_list') ?>"
                  data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                  data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                  data-show-refresh="true" data-trim-on-search="false" data-sort-name="pr.id" data-sort-order="desc"
                  data-mobile-responsive="true" data-toolbar="" data-show-export="true" data-maintain-selected="true"
                  data-query-params="queryParams">
                  <thead>
                    <tr>
                      <th data-field="id" data-sortable="true">ID</th>
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
</div>