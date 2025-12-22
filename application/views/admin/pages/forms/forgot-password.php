<body class="d-flex flex-column">
  <?php
  $auth_settings = get_settings('authentication_settings', true);
  ?>
  <div class="page page-center">
    <div class="container container-tight py-4">
      <div class="text-center mb-4 login-logo">
        <!-- BEGIN NAVBAR LOGO --><a href="<?= base_url('admin') ?>" aria-label="Tabler"
          class="navbar-brand navbar-brand-autodark"><img src="<?= base_url() . $logo ?>"></a><!-- END NAVBAR LOGO -->
      </div>
      <form class="card card-md" action="#" id="send_forgot_password_otp_form" method="post" autocomplete="off"
        novalidate>
        <div class="card-body">
          <h2 class="card-title text-center mb-4">Forgot password</h2>
          <p class="text-secondary mb-4">Enter your mobile number and you get OTP .
          </p>

          <input type="hidden" id="auth_settings" name="auth_settings"
            value='<?= isset($auth_settings['authentication_method']) ? $auth_settings['authentication_method'] : ''; ?>'>

          <input type="hidden" name="forget_password_val" value="1" id="forget_password_val">
          <input type="hidden" name="from_seller" value="0" id="from_seller">
          <input type="hidden" name="from_admin" value="1" id="from_admin">
          <input type="hidden" name="from_delivery_boy" value="0" id="from_delivery_boy">

          <div class="mb-3">
            <label class="col-form-label">Mobile number</label>
            <input type="text" class="form-control" name="mobile_number" id="forgot_password_number"
              placeholder="Mobile number" />
          </div>
          <div class="col-md-12 d-flex justify-content-center pb-4 mt-3">
            <div id="recaptcha-container-2"></div>
          </div>
          <div class="d-flex justify-content-center">
            <div class="form-group" id="forgot_password_error_box"></div>
          </div>

          <div class="form-footer">
            <button class="submit_btn  btn btn-primary btn-block forgot-send-otp-btn w-100"
              id="forgot_password_send_otp_btn">
              <i class="ti ti-message fs-3 mx-2"></i>
              Send OTP
            </button>
          </div>
        </div>
      </form>


      <form class="card card-md d-none" action="#" id="verify_forgot_password_otp_form" method="post" autocomplete="off"
        novalidate>
        <div class="card-body">
          <h2 class="card-title text-center mb-4">Verify OTP </h2>


          <div class="mb-3">  
            <input type="text" class="form-control" name="otp" placeholder="OTP" value="" id="forgot_password_otp" />
          </div>
          <div class="input-group input-group-flat col">
            <input type="password" class="form-control passwordToggle" name="new_password" id="password" value=""
              placeholder="Enter Your New Password" />
            <span class="input-group-text togglePassword" title="Show password" data-bs-toggle="tooltip"
              style="cursor: pointer;">
              <i class="ti ti-eye fs-3"></i>
            </span>
          </div>

          <div class="form-footer">
            <button class="submit_btn  btn btn-primary btn-block w-100" id="reset_password_submit_btn">
              <i class="ti ti-message fs-3 mx-2"></i>
              Submit
            </button>
          </div>
        </div>
      </form>



      <div class="text-center text-secondary mt-3">Forget it, <a href="<?= base_url() . 'admin/login' ?>">send me
          back</a> to the sign in
        screen.</div>
    </div>
  </div>


  <!-- END PAGE SCRIPTS -->
</body>