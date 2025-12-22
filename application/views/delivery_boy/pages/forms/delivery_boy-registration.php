<div class="page page-center">
  <div class="container py-4" style="max-width: 900px;">

    <!-- Logo -->
    <div class="text-center mb-4 login-logo">
      <a href="<?= base_url('delivery_boy/login') ?>">
        <img src="<?= base_url($logo) ?>" alt="App Logo" class="img-fluid">
      </a>
      <h1 class="mt-3 mb-1 fw-bold">Delivery Boy Registration</h1>
      <p class="text-muted">Fill out the form below to register as a delivery partner.</p>
    </div>

    <!-- Registration Card -->
    <div class="card shadow-sm border-0">
      <div class="card-body p-5">

        <form class="form-horizontal" method="POST" id="add_dboy_form" enctype="multipart/form-data">
          <?php if (isset($user_data) && !empty($user_data)) { ?>
            <input type="hidden" name="user_id" value="<?= $user_data['to_be_seller_id'] ?>">
            <input type="hidden" name="user_name" value="<?= $user_data['to_be_seller_name'] ?>">
            <input type="hidden" name="user_mobile" value="<?= $user_data['to_be_seller_mobile'] ?>">
          <?php } ?>

          <!-- Name -->
          <div class="mb-3">
            <label for="name" class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter full name">
          </div>

          <!-- Mobile -->
          <div class="mb-3">
            <label for="delivery_boy_mobile" class="form-label fw-semibold">Mobile <span
                class="text-danger">*</span></label>
            <input type="text" maxlength="16" oninput="validateNumberInput(this)" class="form-control"
              id="delivery_boy_mobile" name="mobile" placeholder="Enter mobile number">
          </div>

          <!-- Email -->
          <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address">
          </div>

          <!-- Password -->
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


          <!-- Address -->
          <div class="mb-3">
            <label for="address" class="form-label fw-semibold">Address <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="address" name="address" placeholder="Enter complete address">
          </div>

          <?php
          $pincode_wise_deliverability = (isset($shipping_method['pincode_wise_deliverability']) && $shipping_method['pincode_wise_deliverability'] == 1) ? $shipping_method['pincode_wise_deliverability'] : '0';
          $city_wise_deliverability = (isset($shipping_method['city_wise_deliverability']) && $shipping_method['city_wise_deliverability'] == 1) ? $shipping_method['city_wise_deliverability'] : '0';
          ?>
          <input type="hidden" name="city_wise_deliverability" value="<?= $city_wise_deliverability ?>">
          <input type="hidden" name="pincode_wise_deliverability" value="<?= $pincode_wise_deliverability ?>">

          <!-- Serviceable Zipcodes -->
          <?php if (
            (isset($shipping_method['pincode_wise_deliverability']) && $shipping_method['pincode_wise_deliverability'] == 1) ||
            (isset($shipping_method['local_shipping_method']) && isset($shipping_method['shiprocket_shipping_method']) &&
              $shipping_method['local_shipping_method'] == 1 && $shipping_method['shiprocket_shipping_method'] == 1)
          ) { ?>
            <div class="mb-3" x-data x-init="
                   initTomSelect({
                     element: $refs.serviceableSelect,
                     url: '<?= base_url('seller/area/get_zipcodes?for_select2=1') ?>',
                     placeholder: 'Select Serviceable Zipcodes...',
                     maxItems: null,
                     create: true
                   })
                 ">
              <label class="form-label fw-semibold">Serviceable Zipcodes <span class="text-danger">*</span></label>
              <select class="form-select" id="deliverable_zipcodes" name="serviceable_zipcodes[]" multiple
                x-ref="serviceableSelect">
                <option value="">Select zipcodes</option>
              </select>
            </div>
          <?php } ?>

          <!-- Serviceable Cities -->
          <?php if (isset($shipping_method['city_wise_deliverability']) && $shipping_method['city_wise_deliverability'] == 1 && $shipping_method['shiprocket_shipping_method'] != 1) { ?>
            <div class="mb-3">
              <label for="deliverable_cities" class="form-label fw-semibold">Serviceable Cities <span
                  class="text-danger">*</span></label>
              <?php $selected_city_ids = (isset($fetched_data[0]['serviceable_cities']) && $fetched_data[0]['serviceable_cities'] != NULL)
                ? explode(",", $fetched_data[0]['serviceable_cities']) : []; ?>
              <select class="form-select deliveryboy_search_cities" name="serviceable_cities[]" id="deliverable_cities"
                multiple>
                <?php foreach ($cities as $row) { ?>
                  <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                <?php } ?>
              </select>
            </div>
          <?php } ?>

          <!-- Driving License -->
          <div class="mb-4">
            <label for="driving_license" class="form-label fw-semibold">Driving License <span
                class="text-danger">*</span></label>
            <input type="file" class="form-control file_upload_height" name="driving_license[]" id="driving_license"
              accept="image/*" multiple>
          </div>

          <!-- Submit Button -->
          <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary px-4">
              <i class="ti ti-send me-1"></i> Submit
            </button>
          </div>

        </form>
      </div>
    </div>
    <!-- footer -->
    <div class="text-center text-secondary mt-4">
      <div class="mb-2">Already have an account? <a href="<?= base_url('delivery_boy/login') ?>"
          class="link-primary fw-bold">Sign in here</a></div>
    </div>
  </div>