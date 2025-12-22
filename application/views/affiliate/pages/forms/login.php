<?php if (ALLOW_MODIFICATION == 0) { ?>
    <div class="alert alert-warning">
        Note: If you cannot login here, please close the codecanyon frame by clicking on x Remove Frame button from top
        right corner on the page or <a href="<?= base_url('/affiliate') ?>" target="_blank" class="text-danger">>> Click
            here << </a>
    </div>
<?php } ?>

<div class="page page-center">
    <div class="container container-tight py-4">
        <div class="text-center mb-4">
            <!-- BEGIN NAVBAR LOGO -->
            <a href="<?= base_url() . 'affiliate/login' ?>" aria-label="Tabler"
                class="navbar-brand navbar-brand-autodark">
                <img src="<?= get_image_url($logo, 'thumb', 'sm'); ?>">
            </a><!-- END NAVBAR LOGO -->
        </div>
        <div class="card card-md">
            <div class="card-body">
                <h2 class="h2 text-center mb-4">Login to your account</h2>
                <form x-data="ajaxForm({
                                            url: base_url + 'auth/login',
                                            modalId: '',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="login_form">

                    <div class="mb-3">
                        <label class="col-form-label">Mobile Number</label>
                        <input type="<?= $identity_column ?>" class="form-control" id="mobile"
                            placeholder="Enter Your <?= ucfirst($identity_column) ?>" name="identity" autocomplete="off"
                            value="<?= (ALLOW_MODIFICATION == 0) ? '9519519519' : '' ?>" />
                    </div>
                    <div class="mb-2">
                        <label class="col-form-label">
                            Password
                            <span class="form-label-description">
                                <a href="<?= base_url('/affiliate/login/forgot_password') ?>">I forgot password</a>
                            </span>
                        </label>
                        <div class="input-group input-group-flat col">
                            <input type="password" class="form-control passwordToggle" name="password" id="password"
                                value="<?= (ALLOW_MODIFICATION == 0) ? '12345678' : '' ?>"
                                placeholder="Enter Your Password" />
                            <span class="input-group-text togglePassword" title="Show password" data-bs-toggle="tooltip"
                                style="cursor: pointer;">
                                <i class="ti ti-eye fs-3"></i>
                            </span>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-check">
                            <input type="checkbox" class="form-check-input" />
                            <span class="form-check-label">Remember me on this device</span>
                        </label>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100 btn-signin">Sign in</button>
                    </div>
                </form>
                <!-- Forgot Password -->
                <div class="text-center text-secondary mt-3">Don't have any
                    account? <a href="<?= base_url('affiliate/auth/sign_up') ?>" tabindex="-1">Sign Up</a></div>


            </div>

        </div>

    </div>
</div>

<!-- /.login-box -->