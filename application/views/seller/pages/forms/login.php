<?php if (ALLOW_MODIFICATION == 0) { ?>
  <div class="alert alert-warning">
    Note: If you cannot login here, please close the codecanyon frame by clicking on x Remove Frame button from top
    right corner on the page or <a href="<?= base_url('/seller') ?>" target="_blank" class="text-danger">>> Click here
      << </a>
  </div>
<?php } ?>
<div class="page page-center">
  <div class="container container-tight py-4">
    <div class="text-center mb-4 login-logo">
      <!-- BEGIN NAVBAR LOGO -->
      <a href="<?= base_url() . 'seller/login' ?>" aria-label="Tabler" class="navbar-brand navbar-brand-autodark ">
        <img src="<?= get_image_url($logo, 'thumb', 'sm'); ?>">
      </a><!-- END NAVBAR LOGO -->
    </div>
    <div class="card card-md">
      <div class="card-body">
        <h2 class="h2 text-center mb-4">Login to your account</h2>
        <form action="<?= base_url() . 'auth/login' ?>" method="POST" class="form-horizontal" id="seller_login_form">
          <input type="hidden" name="type_otp" id="type_otp" value="false">

          <div class="mb-3">
            <label class="col-form-label">Mobile Number</label>
            <input type="<?= $identity_column ?>" class="form-control" id="mobile"
              placeholder="Enter Your <?= ucfirst($identity_column) ?>" name="identity" autocomplete="off"
              value="<?= (ALLOW_MODIFICATION == 0) ? '9988776655' : '' ?>" />
          </div>

          <label class="form-check">
            <input class="form-check-input" type="checkbox" id="seller-login-toggle-type">
            <span class="form-check-label" id="seller-login-toggle-type-lable">use OTP</span>
          </label>

          <div id="seller-login-full-password-div">
            <div class="mb-2">
              <label class="col-form-label">
                <span id="seller-login-password-label"> Password </span>
                <span class="form-label-description">
                  <a href="<?= base_url('/seller/login/forgot_password') ?>">I forgot password</a>
                </span>
              </label>

              <div id="seller-login-password-div">
                <div class="input-group input-group-flat col">
                  <input type="password" class="form-control passwordToggle" name="password" id="password"
                    value="<?= (ALLOW_MODIFICATION == 0) ? '12345678' : '' ?>" placeholder="Enter Your Password" />
                  <span class="input-group-text togglePassword" title="Show password" data-bs-toggle="tooltip"
                    style="cursor: pointer;">
                    <i class="ti ti-eye fs-3"></i>
                  </span>
                </div>
              </div>


            </div>
            <div class="mb-3">
              <label class="form-check">
                <input type="checkbox" class="form-check-input" />
                <span class="form-check-label">Remember me on this device</span>
              </label>
            </div>
          </div>

          <div id="seller-login-otp-div" class="d-none">
            <div class="input-group col d-none" id="otp-input-wrapper">
              <input type="text" class="form-control" name="otp" id="otp" placeholder="Enter Your OTP" />
            </div>
          </div>

          <div id="recaptcha-container"></div>

          <div class="form-footer">
            <button type="submit" id="btn-password" class="btn btn-primary w-100 btn-signin">Sign
              in</button>
            <button type="button" id="btn-send-otp" class="btn btn-outline-primary w-100 d-none">
              Send OTP
            </button>
          </div>

        </form>
        <div class="text-center text-secondary mt-3">Don't have any
          account? <a href="<?= base_url('seller/auth/sign_up') ?>" tabindex="-1">Sign Up</a></div>
      </div>

    </div>

  </div>
</div>