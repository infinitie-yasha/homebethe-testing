<div class="page page-center">
  <div class="container container-tight py-4">

    <!-- Logo and Header -->
    <div class="text-center mb-4">
      <a href="<?= base_url('affiliate/login') ?>" class="navbar-brand navbar-brand-autodark">
        <img src="<?= base_url($logo) ?>" alt="App Logo" height="60" class="navbar-brand-image">
      </a>
    </div>

    <div class="card card-md">
      <div class="card-body">
        <h2 class="h2 text-center mb-4">Create your affiliate account</h2>
        <form x-data="ajaxForm({
                                            url: base_url + 'affiliate/auth/add_user',
                                            modalId: '',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="login_form">

          <!-- Hidden Fields -->
          <input type="hidden" name="edit_affiliate_user"
            value="<?= isset($fetched_data) ? $fetched_data[0]['user_id'] : ''; ?>">
          <input type="hidden" name="edit_affiliate_data_id"
            value="<?= isset($fetched_data) ? $fetched_data[0]['id'] : ''; ?>">
          <input type="hidden" name="affiliate_uuid"
            value="<?= isset($fetched_data) ? $fetched_data[0]['uuid'] : ''; ?>">
          <input type="hidden" name="is_affiliate_user" value="1">

          <!-- Personal Information Section -->
          <div class="mb-3">
            <label class="col-form-label required">Full Name</label>
            <input type="text" class="form-control" name="full_name" placeholder="Enter your full name"
              value="<?= isset($fetched_data) ? $fetched_data[0]['username'] : ''; ?>">
          </div>

          <div class="mb-3">
            <label class="col-form-label required">Email Address</label>
            <input type="email" class="form-control" name="email" placeholder="your-email@example.com"
              value="<?= isset($fetched_data) ? $fetched_data[0]['email'] : ''; ?>">
            <small class="form-hint">We'll never share your email with anyone else.</small>
          </div>

          <div class="mb-3">
            <label class="col-form-label required">Mobile Number</label>
            <div class="input-group input-group-flat">
              <span class="input-group-text">
                <i class="ti ti-phone icon"></i>
              </span>
              <input type="text" class="form-control" name="mobile" maxlength="16" oninput="validateNumberInput(this)"
                placeholder="+1 234 567 8900" value="<?= isset($fetched_data) ? $fetched_data[0]['mobile'] : ''; ?>">
            </div>
          </div>

          <!-- Password Section -->
          <div class="mb-3">
            <label class="col-form-label required">
              Password
            </label>
            <div class="input-group input-group-flat col">
              <input type="password" class="form-control passwordToggle" name="password" id="password" value=""
                placeholder="Enter Your Password" />
              <span class="input-group-text togglePassword" title="Show password" data-bs-toggle="tooltip"
                style="cursor: pointer;">
                <i class="ti ti-eye fs-3"></i>
              </span>
            </div>
          </div>
          <div class="mb-3">
            <label class="col-form-label required">Confirm Password</label>
            <div class="input-group input-group-flat col">
              <input type="password" class="form-control passwordToggle" name="confirm_password" id="confirm_password"
                value="" placeholder="Enter Your Confirm Password" />
              <span class="input-group-text togglePassword" title="Show password" data-bs-toggle="tooltip"
                style="cursor: pointer;">
                <i class="ti ti-eye fs-3"></i>
              </span>
            </div>
          </div>

          <!-- Address Section -->
          <div class="mb-3">
            <label class="col-form-label required">Address</label>
            <textarea class="form-control" name="address" rows="3"
              placeholder="Enter your complete address"><?= isset($fetched_data) ? $fetched_data[0]['address'] : ''; ?></textarea>
          </div>

          <!-- Platform Information -->
          <div class="hr-text hr-text-left">Platform Information</div>

          <div class="mb-3">
            <label class="col-form-label required">Your Website</label>
            <div class="input-group input-group-flat">
              <span class="input-group-text">
                <i class="ti ti-world icon"></i>
              </span>
              <input type="url" class="form-control" name="my_website" placeholder="https://www.example.com/myblog"
                value="<?= isset($fetched_data) ? $fetched_data[0]['website_url'] : ''; ?>">
            </div>
            <small class="form-hint">Enter the URL where you'll promote our products.</small>
          </div>

          <div class="mb-3">
            <label class="col-form-label required">Your Mobile App</label>
            <div class="input-group input-group-flat">
              <span class="input-group-text">
                <i class="ti ti-device-mobile icon"></i>
              </span>
              <input type="url" class="form-control" name="my_app"
                placeholder="https://play.google.com/store/apps/details?id=your.app"
                value="<?= isset($fetched_data) ? $fetched_data[0]['mobile_app_url'] : ''; ?>">
            </div>
            <small class="form-hint">Link to your app on Google Play or App Store.</small>
          </div>


          <!-- Submit Button -->
          <div class="form-footer">
            <button type="submit" class="btn btn-primary w-100">
              <i class="ti ti-user-plus icon"></i>
              Create Account
            </button>
          </div>
        </form>
      </div>

      <div class="hr-text">or</div>

      <div class="text-center text-secondary my-4">
        <div class="mb-2">Already have an account? <a href="<?= base_url('affiliate/login') ?>"
            class="link-primary fw-bold">Sign in here</a></div>
        <small class="text-muted">By registering, you agree to our <a
            href="<?= base_url('admin/affiliate_policies/privacy-policy-page') ?>" target='_blank'
            class="text-decoration-none" title='View Privacy Policy'> Privacy Policy </a> and
          <a href="<?= base_url('admin/affiliate_policies/terms-and-conditions-page') ?>" target='_blank'
            class="text-decoration-none" title='View Terms & Conditions'> Terms & Conditions</a></small>
      </div>
    </div>

  </div>
</div>