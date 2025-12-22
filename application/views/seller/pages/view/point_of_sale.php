<div class="page-wrapper">


  <!-- BEGIN PAGE HEADER -->
  <div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <h2 class="page-title">Manage Point Of Sales</h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
          <ol class="breadcrumb" aria-label="breadcrumbs">
            <li class="breadcrumb-item">
              <a href="<?= base_url('seller/home') ?>">Home</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
              Point Of Sales
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
          <div class="card-header">
            <h3 class="card-title"><i class="ti ti-language"></i> Point of sales</h3>
          </div>
          <div class="card-body">
            <div class="row g-2 align-items-center mb-4">
              <!-- All Products Button -->
              <div class="col-auto">
                <a class="btn btn-info" href="#">
                  All Products
                </a>
              </div>

              <!-- Category Dropdown -->
              <div class="col-md-4 col-sm-6">
                <select class="form-select" id="product_categories" name="category_parent">
                  <option value="">
                    <?= (isset($categories) && empty($categories)) ? 'No Categories Exist' : 'Select Categories' ?>
                  </option>
                  <?php echo get_categories_option_html($categories); ?>
                </select>
              </div>

              <!-- Search Box -->
              <div class="col-md-5 col-sm-6">
                <div class="input-icon">
                  <input type="search" name="search_products" class="form-control" id="search_products"
                    placeholder="Search Products...">
                  <span class="input-icon-addon">
                    <i class="ti ti-search"></i>
                  </span>
                </div>
              </div>
            </div>

            <!-- Product + Sidebar -->
            <div class="row">
              <!-- Products -->
              <div class="col-md-7">
                <div class="card">
                  <input type="hidden" id="session_user_id" value="<?= $_SESSION['user_id'] ?>" />
                  <input type="hidden" id="limit" value="15" />
                  <input type="hidden" id="offset" value="0" />
                  <input type="hidden" id="total_products" />
                  <input type="hidden" id="current_page" value="1" />

                  <div class="card-body">
                    <div class="row g-3" id="get_products" style="max-height: 1090px; overflow-y: auto;">
                      <!-- Product cards injected here -->
                    </div>
                  </div>

                  <div class="card-footer">
                    <div class="pagination-container">
                      <div class="row p-2">
                        <div class="col-12">
                          <div class="d-flex justify-content-center">
                            <ul class="pagination mb-0" id="pagination">
                              <li class="page-item" id="prevPage">
                                <a class="page-link" href="javascript:void(0)" onclick="prev_page()">Previous</a>
                              </li>
                              <li class="page-item active" id="pageNumber">
                                <a class="page-link" href="javascript:void(0)">1</a>
                              </li>
                              <li class="page-item" id="nextPage">
                                <a class="page-link" href="javascript:void(0)" onclick="next_page()">Next</a>
                              </li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>


              <!-- Sidebar -->
              <div class="col-md-5">

                <form x-data="ajaxForm({
                                            url: base_url + 'seller/point_of_sale/place_order',
                                          
                                            loaderText: 'Uploading...'
                                        })" method="POST" enctype="multipart/form-data" class="form-horizontal"
                  id="pos_form">
                  <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                    value="<?= $this->security->get_csrf_hash(); ?>" />
                  <input type="hidden" name="user_id" id="pos_user_id">
                  <input type="hidden" name="product_variant_id">
                  <input type="hidden" name="quantity">
                  <input type="hidden" name="total">

                  <!-- Registered User -->
                  <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between">
                      <h1 class="card-title">Registered User?</h1>
                      <button type="button" class="btn btn-danger btn-sm" id="clear_user_search">Clear</button>
                    </div>
                    <div class="card-body">
                      <div x-data x-init="initTomSelect({
                                          element: $refs.select_user,
                                          url: '<?= base_url('seller/point_of_sale/get_users') ?>',
                                          placeholder: 'Search User...',
                                          offcanvasId: '',
                                          dataAttribute: 'data-user-id',
                                          maxItems: 1,
                                          preloadOptions: true
                                        })" class="mb-3 row align-items-center">
                        <label for="select_user" class="col-3 col-form-label fw-semibold required">
                          Users
                        </label>
                        <div class="col">
                          <select x-ref="select_user" name="user_id" id="select_user"
                            class="form-select w-100"></select>
                        </div>
                      </div>

                      <div class="d-flex justify-content-between align-items-center mt-3">
                        <span>Don't have an account?</span>
                        <a href="#" class="btn btn-success btn-sm" data-bs-toggle="offcanvas"
                          data-bs-target="#register">
                          <i class="ti ti-user-plus me-1"></i> Register
                        </a>
                      </div>
                    </div>
                  </div>

                  <!-- Cart -->
                  <div class="card mb-3">
                    <div class="card-header">
                      <h4 class="card-title"><i class="ti ti-shopping-cart"></i> Cart</h4>
                    </div>
                    <div class="card-body">

                      <div class="cart-items" style="max-height: 250px; overflow-y: auto;"></div>
                      <div class="mt-3 d-flex justify-content-between">
                        <span>Subtotal</span>
                        <strong id="cart-total-price"
                          data-currency="<?= (isset($currency) && !empty($currency)) ? $currency : ''; ?>"></strong>
                      </div>
                      <div class="mt-3">
                        <label class="form-label" for="delivery_charge_service">Shipping Charge</label>
                        <input type="number" class="form-control delivery_charge_service" id="delivery_charge_service"
                          min="0" placeholder="0.00" name="delivery_charge">
                      </div>
                      <div class="mt-3">
                        <label class="form-label" for="discount_service">Discount
                          (<?= (isset($currency) && !empty($currency)) ? $currency : ''; ?>)</label>
                        <input type="number" class="form-control discount_service" id="discount_service" min="0"
                          placeholder="0.00" name="discount"
                          onkeypress="if(event.keyCode === 13) { update_final_cart_total(); }">
                      </div>
                      <div class="mt-3 d-flex justify-content-between">
                        <span>Total</span>
                        <h4 class="final_total" id="final_total"
                          data-currency="<?= (isset($currency) && !empty($currency)) ? $currency : ''; ?>">
                        </h4>
                      </div>
                    </div>
                  </div>

                  <!-- Payment Methods -->
                  <div class="card mb-3">
                    <div class="card-header">
                      <h4 class="card-title">Payment Methods</h4>
                    </div>
                    <div class="card-body">
                      <div class="row g-2">
                        <div class="col-6">
                          <label class="w-100">
                            <input class="form-check-input d-none payment_method" type="radio" name="payment_method"
                              value="COD">
                            <div class="card card-sm payment-box text-center p-3">
                              <i class="ti ti-cash ti-2x"></i>
                              <div>Cash</div>
                            </div>
                          </label>
                        </div>

                        <div class="col-6">
                          <label class="w-100">
                            <input class="form-check-input d-none payment_method" type="radio" name="payment_method"
                              value="card_payment">
                            <div class="card card-sm payment-box text-center p-3">
                              <i class="ti ti-credit-card ti-2x"></i>
                              <div>Card</div>
                            </div>
                          </label>
                        </div>

                        <div class="col-6">
                          <label class="w-100">
                            <input class="form-check-input d-none payment_method" type="radio" name="payment_method"
                              value="bar_code">
                            <div class="card card-sm payment-box text-center p-3">
                              <i class="ti ti-qrcode ti-2x"></i>
                              <div>QR Code</div>
                            </div>
                          </label>
                        </div>

                        <div class="col-6">
                          <label class="w-100">
                            <input class="form-check-input d-none payment_method" type="radio" name="payment_method"
                              value="net_banking">
                            <div class="card card-sm payment-box text-center p-3">
                              <i class="ti ti-building-bank ti-2x"></i>
                              <div>Net Banking</div>
                            </div>
                          </label>
                        </div>

                        <div class="col-6">
                          <label class="w-100">
                            <input class="form-check-input d-none payment_method" type="radio" name="payment_method"
                              value="online_payment">
                            <div class="card card-sm payment-box text-center p-3">
                              <i class="ti ti-world ti-2x"></i>
                              <div>Online</div>
                            </div>
                          </label>
                        </div>

                        <div class="col-6">
                          <label class="w-100">
                            <input class="form-check-input d-none payment_method" type="radio" name="payment_method"
                              value="other" id="other">
                            <div class="card card-sm payment-box text-center p-3">
                              <i class="ti ti-dots ti-2x"></i>
                              <div>Other</div>
                            </div>
                          </label>
                        </div>
                      </div>

                      <!-- Extra fields -->
                      <div class="mt-3 payment_method_name" style="display:none;">
                        <label class="form-label">Payment Method Name</label>
                        <input type="text" class="form-control" id="payment_method_name">
                      </div>
                      <div class="mt-3 transaction_id" style="display:none;">
                        <label class="form-label">Transaction ID</label>
                        <input type="text" class="form-control" id="transaction_id">
                      </div>
                    </div>
                  </div>


                  <div class="mt-3 text-center">
                    <button type="button" class="btn btn-danger" id="clear_cart">
                      <i class="ti ti-trash"></i> Clear Cart
                    </button>
                    <button type="submit" class="btn btn-primary" id="place_order_btn">
                      <i class="ti ti-check"></i> Place Order
                    </button>
                  </div>
                </form>
              </div>
            </div>

            <!-- Register Modal -->
            <div class="offcanvas offcanvas-end fade custom-offcanvas-lg" id="register" tabindex="-1">
              <div class="offcanvas-dialog">
                <div class="offcanvas-content">
                  <div class="offcanvas-header">
                    <h5 class="offcanvas-title">
                      <i class="ti ti-user-plus me-2"></i> Register User
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                  </div>

                  <div class="offcanvas-body">
                    <form method="post" action="<?= base_url('seller/point_of_sale/register_user') ?>"
                      id="register_form">
                      <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                        value="<?= $this->security->get_csrf_hash(); ?>" />

                      <div class="mb-3">
                        <label class="form-label fw-semibold">Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter Your Name">
                      </div>

                      <div class="mb-3">
                        <label class="form-label fw-semibold">Mobile</label>
                        <input type="number" class="form-control" maxlength="16" name="mobile"
                          placeholder="Enter Mobile Number">
                      </div>

                      <div class="mb-3">
                        <label class="form-label fw-semibold">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Enter Password">
                      </div>

                      <div class="d-flex justify-content-end mt-4 gap-2">
                        <button type="submit" class="btn btn-primary">
                          <i class="ti ti-user-plus me-1"></i> Register
                        </button>
                        <button type="button" class="btn  text-secondary" data-bs-dismiss="offcanvas">
                          <i class="ti ti-x me-1"></i> Close
                        </button>
                      </div>

                      <div class="mt-3" id="save-register-result"></div>
                    </form>
                  </div>
                </div>
              </div>
            </div>



          </div> <!-- card-body -->
        </div> <!-- card -->
      </div>
    </div>
  </div>
</div>