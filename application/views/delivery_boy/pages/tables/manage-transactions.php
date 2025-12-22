<div class="container-xl">
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    View Transactions
                </h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                        <li class="breadcrumb-item"><a href="<?= base_url('delivery-boy/home') ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Transactions</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="row">
            <div class="col-md-12 main-content">
                <div class="card content-area p-4">
                    <div class="card-innr">

                        <div class="gaps-1-5x"></div>
                        <div class="gaps-1-5x row d-flex adjust-items-center">
                            <div class="row col-md-12 mt-4">
                                <div class="form-group col-md-3">
                                    <label class="form-label" for="datepicker">Date and time range:</label>
                                    <div class="input-icon">
                                        <input type="text" value="" class="form-control" id="datepicker"
                                            autocomplete="off" />
                                        <input type="hidden" id="start_date" class="form-control float-right">
                                        <input type="hidden" id="end_date" class="form-control float-right">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-clock"></i>
                                        </span>
                                    </div>

                                </div>
                               
                                <div class="form-group col-md-3 d-flex align-items-center pt-4 gap-2">
                                    <button type="button" class="btn btn-primary " onclick="status_date_wise_search()">
                                        <i class="ti ti-search"></i> Filter
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" onclick="resetfilters()">
                                        <i class="ti ti-refresh"></i> Reset
                                    </button>
                                </div>
                            </div>
                        </div>
                        <table class='table-striped' data-toggle="table"
                            data-url="<?= base_url('delivery_boy/fund_transfer/get_deliveryboy_transactions/' . $this->ion_auth->user()->row()->id) ?>"
                            data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                            data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                            data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                            data-sort-order="desc" data-mobile-responsive="true" data-toolbar="" data-show-export="true"
                            data-maintain-selected="true" data-export-types='["txt","excel"]'
                            data-query-params="transaction_query_params">
                            <thead>
                                <tr>
                                    <th data-field="id" data-sortable="true">ID</th>
                                    <th data-field="order_id" data-sortable="true">Order ID</th>
                                    <th data-field="amount" data-sortable="true">Amount</th>
                                    <th data-field="message" data-sortable="true">Message</th>
                                    <th data-field="txn_date" data-sortable="true">Transaction Date</th>
                                    <!-- <th data-field="date" data-sortable="true">Date</th> -->
                                </tr>
                            </thead>
                        </table>
                    </div><!-- .card-innr -->
                </div><!-- .card -->
            </div>
        </div>
    </div>
</div>