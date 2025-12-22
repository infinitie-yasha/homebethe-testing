<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
       <div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">

        <!-- Mobile View (xs / sm) -->
        <div class="d-flex flex-column text-center d-sm-none py-2">
            <h2 class="page-title fs-5 fw-semibold mb-1">Shipping Settings</h2>
            <nav class="breadcrumb breadcrumb-arrows small justify-content-start mb-0">
                <a href="<?= base_url('admin/home') ?>" class="breadcrumb-item">Home</a>
                <span class="breadcrumb-item">System</span>
                <span class="breadcrumb-item active">Shipping</span>
            </nav>
        </div>

        <!-- Tablet & Desktop View (md+) -->
        <div class="row g-2 align-items-center d-none d-sm-flex">
            <div class="col">
                <h2 class="page-title mb-0">Shipping Settings</h2>
            </div>
            <div class="col-auto ms-auto">
                <ol class="breadcrumb breadcrumb-arrows mb-0 small">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('admin/home') ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#">System Settings</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Shipping Settings
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
                    <form x-data="ajaxForm({
                                            url: base_url + 'admin/Shipping_settings/update_shipping_settings',
                                            modalId: '',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="update_shipping_settings_form"
                        enctype="multipart/form-data">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><i class="ti ti-rocket"></i> Product Deliverability </h3>
                            </div>
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="form-check auth-option ">
                                        <input class="form-check-input" type="radio" name="deliverability_method"
                                            id="pincode_wise_deliverability" value="pincode"
                                            <?= (isset($settings['pincode_wise_deliverability']) && $settings['pincode_wise_deliverability'] == true) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="pincode_wise_deliverability">
                                            <strong>Pincode Wise Deliverability</strong>
                                            <div class="small text-muted mt-1">Use For local and Standard shipping both
                                            </div>
                                        </label>
                                    </div>

                                    <div class="auth-option form-check mx-6">
                                        <input class="form-check-input" type="radio" name="deliverability_method"
                                            id="city_wise_deliverability" value="city"
                                            <?= (isset($settings['city_wise_deliverability']) && $settings['city_wise_deliverability'] == true) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="city_wise_deliverability">
                                            <strong>City Wise Deliverability</strong>
                                            <div class="small text-muted mt-1">Use Only for local Shipping method</div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-header">
                                <h3 class="card-title"><i class="ti ti-car"></i> Local Shipping Settings</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label" for="local_shipping_method">Enable Local
                                        Shipping </label>
                                    <div class="col col-form-label">
                                        <label class="form-check form-switch form-switch-3">
                                            <input class="form-check-input" name="local_shipping_method" type="checkbox"
                                                <?= (@$settings['local_shipping_method']) == '1' ? 'Checked' : '' ?> />
                                            <small class="form-hint"> ( Use Local Delivery Boy For Shipping) </small>
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required" for="default_delivery_charge">Default
                                        Delivery Charge
                                    </label>
                                    <div class="col">
                                        <input type="text" class="form-control" name="default_delivery_charge"
                                            placeholder="Enter Default Delivery Charge" id="default_delivery_charge"
                                            value="<?= (isset($settings['default_delivery_charge']) && !empty($settings['default_delivery_charge'])) ? $settings['default_delivery_charge'] : '' ?>" />
                                        <small class="form-hint"><a href="" class="text-decoration-none"
                                                data-bs-toggle="modal" data-bs-target="#modal-delivery-charges"> How
                                                Default delivery charge work? </a></small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-header">
                                <h3 class="card-title"><i class="ti ti-truck"></i> Standard Shipping Settings</h3>
                            </div>
                            <div class="card-body">

                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label" for="shiprocket_shipping_method">Enable Standard
                                        Shipping Method (Shiprocket) </label>
                                    <div class="col col-form-label">
                                        <label class="form-check form-switch form-switch-3">
                                            <input class="form-check-input" name="shiprocket_shipping_method"
                                                type="checkbox" <?= (@$settings['shiprocket_shipping_method']) == '1' ? 'Checked' : '' ?> />
                                            <small class="form-hint">( Enable/Disable ) <a
                                                    href="https://app.shiprocket.in/api-user" target="_blank"> Click
                                                    here </a> to get credentials. <a href="https://www.shiprocket.in/"
                                                    target="_blank">What is shiprocket? </a></small>
                                        </label>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required" for="email">Email</label>
                                    <div class="col">
                                        <input type="email" class="form-control" name="email" id="email"
                                            value="<?= (defined('ALLOW_MODIFICATION') && ALLOW_MODIFICATION == 0) ? str_repeat("X", strlen(@$settings['email']) - 3) . substr(@$settings['email'], -3) : @$settings['email'] ?>"
                                            placeholder="Shiprocket account email" />
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required" for="password">Password</label>
                                    <div class="col">
                                        <input type="password" class="form-control" name="password" id="password"
                                            value="<?= @$settings['password'] ?>"
                                            placeholder="Shiprocket account Password" />
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label required" for="webhook_url">Shiprocket Webhook
                                        Url</label>
                                    <div class="col">
                                        <input type="text" class="form-control" name="webhook_url" id="webhook_url"
                                            value="<?= base_url('admin/webhook/spr_webhook'); ?>" disabled />
                                    </div>
                                </div>

                              <div class="mb-3 row">
    <label class="col-3 col-form-label" for="standard_shipping_free_delivery">
        Enable Free Delivery Charge
    </label>
    <div class="col">
        <div class="form-check form-switch form-switch-3">
            <input 
                class="form-check-input" 
                type="checkbox" 
                name="standard_shipping_free_delivery"
                id="standard_shipping_free_delivery"
                <?= (@$settings['standard_shipping_free_delivery']) == '1' ? 'checked' : '' ?>
            />
        </div>
        <small class="form-hint text-danger d-block mt-1">
            <b>Note:</b> You can give free delivery charge only when 
            <b>Standard delivery method</b> is enabled.
        </small>
    </div>
</div>

<div class="mb-3 row align-items-center">
    <label class="col-3 col-form-label" for="minimum_free_delivery_order_amount">
        Minimum Free Delivery Order Amount
    </label>
    <div class="col">
        <input 
            type="text" 
            class="form-control"
            name="minimum_free_delivery_order_amount"
            id="minimum_free_delivery_order_amount"
            value="<?= @$settings['minimum_free_delivery_order_amount'] ?>"
            min="0"
            step="any"
            placeholder="Enter amount"
            required
        />
    </div>
</div>


                                <div class="space-y mt-5">

                                    <div class="form-group text-end">
                                        <button type="reset" class="btn">Cancel</button>
                                        <button type="submit" class="btn btn-primary" id="submit_btn">Update Shipping
                                            Settings <i class="cursor-pointer ms-2 ti ti-arrow-right"></i></button>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </form>
                    <!-- Modal -->
                    <div class="modal fade" id="modal-delivery-charges" tabindex="-1"
                        aria-labelledby="modal-delivery-charges" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title" id="exampleModalLabel">How Default Delivery charges work?
                                    </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>The default delivery charges are applied to all orders unless specified
                                        otherwise. Here's how it works:</p>
                                    <ul>
                                        <li>This is For if seller is not from users area.</li>
                                        <li>This is only apply when get delivery boy based on seller button is on from
                                            admin panel -> store settings .</li>
                                        <li>We have two seller products in user cart . say seller1 and seller2.</li>
                                        <li>User's selected zipcode is 123456. seller1's serviceable zipcode is
                                            123456,456789. seller2's serviceable zipcode is 654987.</li>
                                        <li>so user get delivery charge of seller1 is from zipcode based and seller2's
                                            delivery charge from here (default delivery charge) </li>
                                        <li>reason : user's pincode is in seller's serviceable zipcodes and not in
                                            seller2's serviceable zipode</li>
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary bg-secondary-lt"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary bg-primary-lt"
                                        data-bs-dismiss="modal">Got it!</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>