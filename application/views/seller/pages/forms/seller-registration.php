<div class="page page-center">
  <div class="container py-4" style="max-width: 900px;">

    <!-- Logo -->
    <div class="text-center mb-4 login-logo">
      <a href="<?= base_url('seller/login') ?>">
        <img src="<?= base_url($logo) ?>" alt="App Logo" class="img-fluid">
      </a>
      <h1 class="mt-3 mb-1">Seller Registration</h1>
      <p class="text-secondary">Join our marketplace and start selling today</p>
    </div>

    <!-- Registration Form Card -->
    <div class="card">
      <div class="card-body">

        <!-- Steps Indicator -->
        <div class="steps steps-counter steps-lime mb-4">
          <a href="#step-1" class="step-item active" data-hp-step="1">
            <span class="h4 mb-0">Mobile Verification</span>
          </a>
          <a href="#step-2" class="step-item active" data-hp-step="1">
            <span class="h4 mb-0">Personal</span>
          </a>
          <a href="#step-3" class="step-item" data-hp-step="2">
            <span class="h4 mb-0">Business</span>
          </a>
          <a href="#step-4" class="step-item" data-hp-step="3">
            <span class="h4 mb-0">Store</span>
          </a>
          <a href="#step-5" class="step-item" data-hp-step="4">
            <span class="h4 mb-0">Tax</span>
          </a>
        </div>

        <!-- Registration Form -->
        <form action="<?= base_url('seller/auth/sign_up') ?>" method="POST" id="add_seller_form" autocomplete="off"
          novalidate enctype="multipart/form-data">

          <div class="step-content" id="step-1">
            <div class="mb-3">
              <h3 class="mb-3">
                <i class="ti ti-user me-2"></i>
                Mobile Verification
              </h3>
            </div>

            <div class="row g-3 mb-3 justify-content-center">
              <div class="col-md-4 ">
                <label class="form-label required d-block">Mobile Number</label>
                <input type="tel" class="form-control mx-auto" id="seller_mobile_otp" name="mobile"
                  placeholder="9876543210" pattern="[0-9]{10}" maxlength="10" required
                  oninput="this.value = this.value.replace(/[^0-9]/g, '');">
              </div>
            </div>

            <div class="row g-3 mb-3 justify-content-center d-none" id="enter-otp-div">
              <div class="col-md-4 ">
                <label class="form-label required d-block">OTP</label>
                <input type="text" class="form-control mx-auto" id="seller_otp" name="otp" placeholder="Enter OTP"
                  required>
              </div>
            </div>

            <div id="recaptcha-container"></div>

            <div class="row g-3 mb-3 justify-content-center">
              <div class="col-md-4 ">
                <button class="btn btn-primary col-12" id="seller_send_otp" type="button"> Send OTP </button>
                <button class="btn btn-outline-primary col-12 d-none" id="seller_verify_otp" type="button"> Verify OTP
                </button>
              </div>
            </div>

          </div>

          <!-- Step 1: Personal Details -->
          <div class="step-content" id="step-2" style="display: none;">
            <div class="mb-3">
              <h3 class="mb-3">
                <i class="ti ti-user me-2"></i>
                Personal Details
              </h3>
              <div class="hr-text text-muted">Basic Information</div>
            </div>

            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label class="form-label required">Full Name</label>
                <input type="text" class="form-control" id="name" placeholder="Enter your full name" name="name"
                  required>
              </div>
              <div class="col-md-6">
                <label class="form-label required">Mobile Number</label>
                <input type="tel" class="form-control" id="seller_mobile" name="mobile" placeholder="9876543210"
                  pattern="[0-9]{10}" maxlength="10" required oninput="this.value = this.value.replace(/[^0-9]/g, '');">
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label required">Email Address</label>
              <div class="input-icon">
                <span class="input-icon-addon">
                  <i class="ti ti-mail"></i>
                </span>
                <input type="email" class="form-control" id="email" placeholder="email@example.com" name="email"
                  required>
              </div>
            </div>

            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label class="form-label required">Password</label>
                <div class="input-group input-group-flat">
                  <input type="password" class="form-control" id="password" placeholder="Enter password" name="password"
                    autocomplete="off" required>
                  <span class="input-group-text">
                    <a href="#" class="link-secondary toggle-password" data-hp-target="password">
                      <i class="ti ti-eye"></i>
                    </a>
                  </span>
                </div>
              </div>
              <div class="col-md-6">
                <label class="form-label required">Confirm Password</label>
                <div class="input-group input-group-flat">
                  <input type="password" class="form-control" id="confirm_password" placeholder="Re-enter password"
                    name="confirm_password" autocomplete="off" required>
                  <span class="input-group-text">
                    <a href="#" class="link-secondary toggle-password" data-hp-target="confirm_password">
                      <i class="ti ti-eye"></i>
                    </a>
                  </span>
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label required">Business Address</label>
              <textarea class="form-control" id="address" placeholder="Enter your complete business address"
                name="address" rows="3" required></textarea>
            </div>

            <div class="mb-3">
              <label class="form-label required">Authorized Signature</label>
              <input type="file" class="form-control" id="authorized_signature" name="authorized_signature"
                accept="image/*" required>
              <small class="form-hint">Upload a clear image of your authorized signature</small>
            </div>
          </div>

          <!-- Step 2: Business & Service Area -->
          <div class="step-content" id="step-3" style="display: none;">
            <div class="mb-3">
              <h3 class="mb-3">
                <i class="ti ti-map-pin me-2"></i>
                Business & Service Area
              </h3>
              <div class="hr-text text-muted">Categories & Coverage</div>
            </div>

            <div class="mb-3">
              <label class="form-label ">Select Categories</label>
              <div x-data x-init="initTomSelect({
                                                    element: $refs.CategorySelect,
                                                    url: '/seller/auth/get_categories?from_select=1',
                                                    placeholder: 'Search Category...',
                                                    maxItems: 20,
                                                    preloadOptions: true
                                                })" class="row">
                <div class="col">
                  <select x-ref="CategorySelect" name="categories[]" class="form-select" id="CategorySelect "
                    required></select>
                </div>
              </div>
            </div>
            <?php if ((isset($shipping_method['pincode_wise_deliverability']) && $shipping_method['pincode_wise_deliverability'] == 1) || (isset($shipping_method['local_shipping_method']) && isset($shipping_method['shiprocket_shipping_method']) && $shipping_method['local_shipping_method'] == 1 && $shipping_method['shiprocket_shipping_method'] == 1)) { ?>

              <div class="row g-3 mb-3">
                <div class="col-md-6" x-data x-init="
                initTomSelect({
                  element: $refs.zipcodeSelect,
                  placeholder: 'Select Zipcode Type...',
                  maxItems: 1
                })
              ">
                  <label class="form-label">Deliverable Zipcode Type</label>
                  <select class="form-select" id="deliverable_zipcode_type" name="deliverable_zipcode_type"
                    x-ref="zipcodeSelect">
                    <option value="<?= ALL ?>" selected>All Zipcodes</option>
                    <option value="<?= EXCLUDED ?>">Excluded Zipcodes</option>
                  </select>
                </div>
                <div class="col-md-6" x-data x-init="
                initTomSelect({
                  element: $refs.serviceableSelect,
                  url: '<?= base_url('seller/area/get_zipcodes?for_select2=1') ?>',
                  placeholder: 'Select Serviceable Zipcodes...',
                  maxItems: null,
                  create: true
                })
              ">
                  <label class="form-label required">Serviceable Zipcodes</label>
                  <select class="form-select" id="deliverable_zipcodes" name="serviceable_zipcodes[]" multiple
                    x-ref="serviceableSelect">
                    <option value="">Select zipcodes</option>
                  </select>
                </div>
              </div>
            <?php }
            if (isset($shipping_method['city_wise_deliverability']) && $shipping_method['city_wise_deliverability'] == 1 && $shipping_method['shiprocket_shipping_method'] != 1) { ?>

              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <label class="form-label">Deliverable City Type</label>
                  <select class="form-select" id="deliverable_city_type" name="deliverable_city_type">
                    <option value="<?= ALL ?>" selected>All Cities</option>
                    <option value="<?= EXCLUDED ?>">Excluded Cities</option>
                  </select>
                </div>
                <div class="col-md-6" x-data x-init="
                initTomSelect({
                  element: $refs.citiesSelect,
                  url: '<?= base_url('seller/area/get_cities') ?>',
                  placeholder: 'Select Serviceable Cities...',
                  maxItems: null,
                  create: true
                })
              ">
                  <label class="form-label required">Serviceable Cities</label>
                  <select class="form-select" id="deliverable_cities" name="serviceable_cities[]" multiple
                    x-ref="citiesSelect">
                    <option value="">Select cities</option>
                  </select>
                </div>
              </div>
            <?php } ?>
          </div>

          <!-- Step 3: Store Details -->
          <div class="step-content" id="step-4" style="display: none;">
            <div class="mb-3">
              <h3 class="mb-3">
                <i class="ti ti-building-store me-2"></i>
                Store Details
              </h3>
              <div class="hr-text text-muted">Your Store Information</div>
            </div>

            <div class="mb-3">
              <label class="form-label required">Store Name</label>
              <input type="text" class="form-control" id="store_name" placeholder="Enter your store name"
                name="store_name" required>
            </div>

            <div class="mb-3">
              <label class="form-label required">Store Logo</label>
              <input type="file" class="form-control" id="store_logo" name="store_logo" accept="image/*" required>
              <small class="form-hint">Upload a high-quality logo (recommended: 500x500px)</small>
            </div>

            <div class="mb-3">
              <label class="form-label">Store URL</label>
              <div class="input-icon">
                <span class="input-icon-addon">
                  <i class="ti ti-link"></i>
                </span>
                <input type="url" class="form-control" id="store_url" placeholder="https://yourstore.com"
                  name="store_url">
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label">Store Description</label>
              <textarea class="form-control" id="store_description" placeholder="Describe your store and what you offer"
                name="store_description" rows="4"></textarea>
              <small class="form-hint">Help customers understand what makes your store unique</small>
            </div>
          </div>

          <!-- Step 4: Tax Details -->
          <div class="step-content" id="step-5" style="display: none;">
            <div class="mb-3">
              <h3 class="mb-3">
                <i class="ti ti-receipt-tax me-2"></i>
                Tax Details
              </h3>
              <div class="hr-text text-muted">Tax Information</div>
            </div>

            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label class="form-label required">PAN Number</label>
                <input type="text" class="form-control" id="pan_number" placeholder="PAN Numebr" name="pan_number"
                  required>
              </div>
              <div class="col-md-6">
                <label class="form-label required">Upload PAN</label>
                <input type="file" class="form-control" id="pan_image" name="pan_image" required>
              </div>
            </div>

            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label class="form-label required">Bank IFSC</label>
                <div class="input-group input-group-flat">
                  <input type="text" class="form-control" id="bank_ifsc" placeholder="Bank IFSC" name="bank_ifsc"
                    autocomplete="off" required>
                  <span class="input-group-text">
                    <button type="button" class="btn btn-sm btn-primary" id="verify_bank_ifsc">Verify</button>
                  </span>
                </div>

              </div>

              <div class="col-md-6">
                <label class="form-label required">Bank Name</label>
                <input type="text" class="form-control" id="bank_name" placeholder="Bank Name" name="bank_name"
                  required>
              </div>
            </div>

            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label class="form-label required">Bank Accournt Numebr</label>
                <input type="text" class="form-control" id="bank_acc" placeholder="Bank Accournt Number" name="bank_acc"
                  required>
              </div>

              <div class="col-md-6">
                <label class="form-label required">Withdrawal Payment Gateway</label>
                <select class="form-control" name="payment_gateway" id="payment_gateway" required>
                  <option value="">-- Select Payment Gateway --</option>
                  <?php foreach ($available_payment_gateways as $gateway => $config): ?>
                    <option value="<?= $gateway ?>">
                      <?= ucfirst($gateway) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

            </div>

            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label class="form-check">
                  <input id="have_gst" name="have_gst" class="form-check-input" type="checkbox">
                  <span class="form-check-label">I Have GSt</span>
                </label>
              </div>
            </div>

            <div id="gst_div" class="row g-3 mb-3 d-none">
              <div class="col-md-6">
                <label class="form-label ">GST Name</label>
                <input type="text" class="form-control" id="tax_name" placeholder="GST Name" name="tax_name">
              </div>
              <div class="col-md-6">
                <label class="form-label ">GST Number</label>
                <input type="text" class="form-control" id="tax_number" placeholder="Enter tax identification number"
                  name="tax_number">
              </div>

            </div>

            <div class="mb-3">
              <label class="form-label">Low Stock Alert Limit</label>
              <input type="number" class="form-control" id="low_stock_limit" placeholder="10" name="low_stock_limit"
                min="0">
              <small class="form-hint">Set a default threshold for low stock notifications (applied if product-specific
                limit is not set)</small>
            </div>

            <div class="alert alert-info" role="alert">
              <div class="d-flex">
                <div>
                  <i class="ti ti-info-circle me-2"></i>
                </div>
                <div>
                  <h4 class="alert-title">Review Your Information</h4>
                  <div class="text-secondary">Please review all the information you've entered before submitting your
                    registration.</div>
                </div>
              </div>
            </div>
          </div>

          <!-- Navigation Buttons -->
          <div class="d-flex justify-content-between mt-4">
            <button type="button" class="btn" id="prev_btn" style="display: none;">
              <i class="ti ti-arrow-left me-2"></i>
              Previous
            </button>
            <button type="button" class="btn btn-primary ms-auto" id="next_btn">
              Next
              <i class="ti ti-arrow-right ms-2"></i>
            </button>
            <button type="submit" class="btn btn-primary ms-auto" id="submit_btn" style="display: none;">
              <i class="ti ti-check me-2"></i>
              Register as Seller
            </button>
          </div>

        </form>

      </div>
    </div>

    <!-- Footer -->
    <div class="text-center text-secondary mt-4">
      <div class="mb-2">Already have an account? <a href="<?= base_url('seller/login') ?>"
          class="link-primary fw-bold">Sign in here</a></div>
      <small class="text-muted">By registering, you agree to our <a
          href="<?= base_url('admin/seller-privacy-policy/privacy-policy-page') ?>" target='_blank'
          class="text-decoration-none" title='View Privacy Policy'> Privacy Policy </a> and
        <a href="<?= base_url('admin/seller-privacy-policy/terms-and-conditions-page') ?>" target='_blank'
          class="text-decoration-none" title='View Terms & Conditions'> Terms & Conditions</a></small>
    </div>
  </div>
</div>