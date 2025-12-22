<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">Payment Methods Settings</h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="d-flex">
                            <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/home') ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="javascript:void(0)">Settings</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">Payment Methods</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE HEADER -->

        <div class="page-body">
            <div class="container-xl payment-container">
                <div class="row g-5">
                    <div class="col-sm-2">
                        <div class="sticky-top" style="top: 80px;">
                            <nav class="nav nav-vertical nav-pills" id="pills">
                                <a class="nav-link" href="#paypal_payment_method">Paypal Payment Method</a>
                                <a class="nav-link" href="#razorpay_payment_method">Razorpay Payment Method</a>
                                <a class="nav-link" href="#paystack_payment_method">Paystack Payment Method</a>
                                <a class="nav-link" href="#stripe_payment_method">Stripe Payment Method</a>
                                <a class="nav-link" href="#flutterwave_payment_method">Flutterwave Payment Method</a>
                                <a class="nav-link" href="#paytm_payment_method">Paytm Payment Method</a>
                                <a class="nav-link" href="#midtrans_payment_method">Midtrans Payment Method</a>
                                <a class="nav-link" href="#myfatoorah_payment_method">MyFatoorah Payment Method</a>
                                <a class="nav-link" href="#instamojo_payment_method">Instamojo Payment Method</a>
                                <a class="nav-link" href="#phonepe_payment_method">PhonePe Payment Method</a>
                                <a class="nav-link" href="#direct_bank_transfer">Direct Bank Transfer</a>
                                <a class="nav-link" href="#cod_method">Cash On Delivery</a>
                            </nav>
                        </div>
                    </div>
                    <div class="col-sm" data-bs-spy="scroll" data-bs-target="#pills" data-bs-offset="80" tabindex="0">
                        <form x-data="ajaxForm({
                                            url: base_url + 'admin/Payment_settings/update_payment_settings',
                                            modalId: '',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="update_payment_settings_form"
                            enctype="multipart/form-data">

                            <!-- paypal -->
                            <div class="card" id="paypal_payment_method">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="ti ti-coins"></i> Paypal Payments</h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="paypal_payment_method">Paypal Payments
                                            <small>[ Enable / Disable ] </small></label>
                                        <div class="col col-form-label">
                                            <label class="form-check form-switch form-switch-3 ">
                                                <input class="form-check-input " name="paypal_payment_method"
                                                    type="checkbox" <?= (@$settings['paypal_payment_method']) == '1' ? 'Checked' : '' ?> />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label">Payment Mode <small>[ sandbox / live
                                                ]</small></label>
                                        <div class="col">
                                            <select class="form-select" name="paypal_mode" id="paypal_mode">
                                                <option value="">Select Mode</option>
                                                <option value="sandbox" <?= (isset($settings['paypal_mode']) && $settings['paypal_mode'] == 'sandbox') ? 'selected' : '' ?>>Sandbox (
                                                    Testing )</option>
                                                <option value="production" <?= (isset($settings['paypal_mode']) && $settings['paypal_mode'] == 'production') ? 'selected' : '' ?>>
                                                    Production ( Live )</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="paypal_business_email">Paypal Business
                                            Email</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="paypal_business_email"
                                                id="paypal_business_email"
                                                value="<?= (isset($settings['paypal_mode'])) ? $settings['paypal_business_email'] : '' ?>"
                                                placeholder="Paypal Business Email" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="paypal_client_id">Paypal Client id
                                        </label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="paypal_client_id"
                                                id="paypal_client_id"
                                                value="<?= (isset($settings['paypal_mode'])) ? $settings['paypal_client_id'] : '' ?>"
                                                placeholder="Paypal Client id " />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="paypal_secret_key">Paypal Secret
                                            Key</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="paypal_secret_key"
                                                id="paypal_secret_key"
                                                value="<?= (isset($settings['paypal_mode'])) ? $settings['paypal_secret_key'] : '' ?>"
                                                placeholder="Paypal Secret Key" />
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="currency_code">Currency Code</label>
                                        <div class="col">
                                            <select class="form-select" name="currency_code" id="currency_code"
                                                value="<?= @$settings['currency_code'] ?>">
                                                <option value="AUD" <?= (isset($settings["currency_code"]) && $settings["currency_code"] == "AUD") ? "selected" : '' ?>>AUD</option>
                                                <option value="BRL" <?= (isset($settings["currency_code"]) && $settings["currency_code"] == "BRL") ? "selected" : '' ?>>BRL</option>
                                                <option value="CAD" <?= (isset($settings["currency_code"]) && $settings["currency_code"] == "CAD") ? "selected" : '' ?>>CAD</option>
                                                <option value="CNY" <?= (isset($settings["currency_code"]) && $settings["currency_code"] == "CNY") ? "selected" : '' ?>>CNY</option>
                                                <option value="CZK" <?= (isset($settings["currency_code"]) && $settings["currency_code"] == "CZK") ? "selected" : '' ?>>CZK</option>
                                                <option value="DKK" <?= (isset($settings["currency_code"]) && $settings["currency_code"] == "DKK") ? "selected" : '' ?>>DKK</option>
                                                <option value="EUR" <?= (isset($settings["currency_code"]) && $settings["currency_code"] == "EUR") ? "selected" : '' ?>>EUR</option>
                                                <option value="HKD" <?= (isset($settings["currency_code"]) && $settings["currency_code"] == "HKD") ? "selected" : '' ?>>HKD</option>
                                                <option value="HUF" <?= (isset($settings["currency_code"]) && $settings["currency_code"] == "HUF") ? "selected" : '' ?>>HUF</option>
                                                <option value="INR" <?= (isset($settings["currency_code"]) && $settings["currency_code"] == "INR") ? "selected" : '' ?>>INR</option>
                                                <option value="ILS" <?= (isset($settings["currency_code"]) && $settings["currency_code"] == "ILS") ? "selected" : '' ?>>ILS</option>
                                                <option value="JPY" <?= (isset($settings["currency_code"]) && $settings["currency_code"] == "JPY") ? "selected" : '' ?>>JPY</option>
                                                <option value="MYR" <?= (isset($settings["currency_code"]) && $settings["currency_code"] == "MYR") ? "selected" : '' ?>>MYR</option>
                                                <option value="MXN" <?= (isset($settings["currency_code"]) && $settings["currency_code"] == "MXN") ? "selected" : '' ?>>MXN</option>
                                                <option value="TWD" <?= (isset($settings["currency_code"]) && $settings["currency_code"] == "TWD") ? "selected" : '' ?>>TWD</option>
                                                <option value="NZD" <?= (isset($settings["currency_code"]) && $settings["currency_code"] == "NZD") ? "selected" : '' ?>>NZD</option>
                                                <option value="NOK" <?= (isset($settings["currency_code"]) && $settings["currency_code"] == "NOK") ? "selected" : '' ?>>NOK</option>
                                                <option value="PHP" <?= (isset($settings["currency_code"]) && $settings["currency_code"] == "PHP") ? "selected" : '' ?>>PHP</option>
                                                <option value="PLN" <?= (isset($settings["currency_code"]) && $settings["currency_code"] == "PLN") ? "selected" : '' ?>>PLN</option>
                                                <option value="GBP" <?= (isset($settings["currency_code"]) && $settings["currency_code"] == "GBP") ? "selected" : '' ?>>GBP</option>
                                                <option value="RUB" <?= (isset($settings["currency_code"]) && $settings["currency_code"] == "RUB") ? "selected" : '' ?>>RUB</option>
                                                <option value="SGD" <?= (isset($settings["currency_code"]) && $settings["currency_code"] == "SGD") ? "selected" : '' ?>>SGD</option>
                                                <option value="SEK" <?= (isset($settings["currency_code"]) && $settings["currency_code"] == "SEK") ? "selected" : '' ?>>SEK</option>
                                                <option value="CHF" <?= (isset($settings["currency_code"]) && $settings["currency_code"] == "CHF") ? "selected" : '' ?>>CHF</option>
                                                <option value="THB" <?= (isset($settings["currency_code"]) && $settings["currency_code"] == "THB") ? "selected" : '' ?>>THB</option>
                                                <option value="USD" <?= (isset($settings["currency_code"]) && $settings["currency_code"] == "USD") ? "selected" : '' ?>>USD</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="paypal_webhook">Notification URL
                                            <small>(Set this as IPN notification URL in you PayPal
                                                account)</small></label>
                                        <div class="col">
                                            <input type="text" class="form-control" id="paypal_webhook" disabled
                                                value="<?= base_url('app/v1/api/ipn') ?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Razorpay -->
                            <div class="card my-3" id="razorpay_payment_method">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="ti ti-coins"></i> Razorpay Payments</h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="razorpay_payment_method">Razorpay
                                            Payments <small>[ Enable / Disable ] </small></label>
                                        <div class="col col-form-label">
                                            <label class="form-check form-switch form-switch-3">
                                                <input class="form-check-input" name="razorpay_payment_method"
                                                    type="checkbox" <?= (@$settings['razorpay_payment_method']) == '1' ? 'Checked' : '' ?> />
                                            </label>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="razorpay_key_id">Razorpay key
                                            ID</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="razorpay_key_id"
                                                id="razorpay_key_id" value="<?= @$settings['razorpay_key_id'] ?>"
                                                placeholder="Razorpay key Id" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="razorpay_secret_key">Secret Key
                                        </label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="razorpay_secret_key"
                                                id="razorpay_secret_key"
                                                value="<?= @$settings['razorpay_secret_key'] ?>"
                                                placeholder="Razorpay Secret Key " />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="razorpay__webhook_url">Payment Endpoint
                                            URL <small>(Set this as Endpoint URL in your Razorpay
                                                account)</small></label>
                                        <div class="col">
                                            <input type="text" class="form-control" id="razorpay__webhook_url" disabled
                                                value="<?= base_url("admin/webhook/razorpay"); ?>" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="refund_webhook_secret_key">Webhoook
                                            Secret Key</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="refund_webhook_secret_key"
                                                id="refund_webhook_secret_key"
                                                value="<?= @$settings['refund_webhook_secret_key'] ?>"
                                                placeholder="Webhook Secret Key" />
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- Paystack -->
                            <div class="card my-3" id="paystack_payment_method">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="ti ti-coins"></i> Paystack Payments</h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="paystack_payment_method">Paystack
                                            Payments <small>[ Enable / Disable ] </small></label>
                                        <div class="col col-form-label">
                                            <label class="form-check form-switch form-switch-3">
                                                <input class="form-check-input" name="paystack_payment_method"
                                                    type="checkbox" <?= (@$settings['paystack_payment_method']) == '1' ? 'Checked' : '' ?> />
                                            </label>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="paystack_key_id">Paystack key
                                            ID</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="paystack_key_id"
                                                id="paystack_key_id" value="<?= @$settings['paystack_key_id'] ?>"
                                                placeholder="Paystack key Id" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="paystack_secret_key">Secret Key
                                        </label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="paystack_secret_key"
                                                id="paystack_secret_key"
                                                value="<?= @$settings['paystack_secret_key'] ?>"
                                                placeholder="Paystack Secret Key " />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="paystack_webhook_url">Payment Endpoint
                                            URL <small>(Set this as Endpoint URL in your Razorpay
                                                account)</small></label>
                                        <div class="col">
                                            <input type="text" class="form-control" id="paystack_webhook_url" disabled
                                                value="<?= base_url("app/v1/api/paystack-webhook"); ?>" />
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- Stripe -->
                            <div class="card my-3" id="stripe_payment_method">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="ti ti-coins"></i> Stripe Payments</h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="stripe_payment_method">Stripe Payments
                                            <small>[ Enable / Disable ] </small></label>
                                        <div class="col">
                                            <label class="form-check form-switch form-switch-3">
                                                <input class="form-check-input" name="stripe_payment_method"
                                                    type="checkbox" <?= (@$settings['stripe_payment_method']) == '1' ? 'Checked' : '' ?> />
                                            </label>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label">Payment Mode <small>[ sandbox / live
                                                ]</small></label>
                                        <div class="col">
                                            <select class="form-select" name="stripe_payment_mode"
                                                id="stripe_payment_mode">
                                                <option value="">Select Mode</option>
                                                <option value="test" <?= (isset($settings['stripe_payment_mode']) && $settings['stripe_payment_mode'] == 'test') ? 'selected' : '' ?>>
                                                    Sandbox ( Testing )</option>
                                                <option value="live" <?= (isset($settings['stripe_payment_mode']) && $settings['stripe_payment_mode'] == 'live') ? 'selected' : '' ?>>
                                                    Production ( Live )</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="stripe_publishable_key">Publishable
                                            Key</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="stripe_publishable_key"
                                                id="stripe_publishable_key"
                                                value="<?= @$settings['stripe_publishable_key'] ?>"
                                                placeholder="Stripe Publishable Key" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="stripe_secret_key">Secret Key</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="stripe_secret_key"
                                                id="stripe_secret_key" value="<?= @$settings['stripe_secret_key'] ?>"
                                                placeholder="Stripe Secret Key" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="stripe_webhook_secret_key">Webhook
                                            Secret Key</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="stripe_webhook_secret_key"
                                                id="stripe_webhook_secret_key"
                                                value="<?= @$settings['stripe_webhook_secret_key'] ?>"
                                                placeholder="Stripe Webhook Secret Key" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="stripe_currency_code">Currency Code
                                            <small>[ Stripe supported ]</small><a
                                                href="https://stripe.com/docs/currencies" target="_BLANK"><i
                                                    class="ti ti-link"></i></a></label>
                                        <div class="col">
                                            <select class="form-select" name="stripe_currency_code"
                                                id="stripe_currency_code"
                                                value="<?= @$settings['stripe_currency_code'] ?>">
                                                <option value="">Select Currency Code </option>
                                                <option value="INR" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'INR') ? "selected" : "" ?>>
                                                    Indian rupee </option>
                                                <option value="USD" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'USD') ? "selected" : "" ?>>
                                                    United States dollar </option>
                                                <option value="AED" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'AED') ? "selected" : "" ?>>
                                                    United Arab Emirates Dirham </option>
                                                <option value="AFN" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'AFN') ? "selected" : "" ?>>
                                                    Afghan Afghani </option>
                                                <option value="ALL" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'ALL') ? "selected" : "" ?>>
                                                    Albanian Lek </option>
                                                <option value="AMD" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'AMD') ? "selected" : "" ?>>
                                                    Armenian Dram </option>
                                                <option value="ANG" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'ANG') ? "selected" : "" ?>>
                                                    Netherlands Antillean Guilder </option>
                                                <option value="AOA" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'AOA') ? "selected" : "" ?>>
                                                    Angolan Kwanza </option>
                                                <option value="ARS" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'ARS') ? "selected" : "" ?>>
                                                    Argentine Peso</option>
                                                <option value="AUD" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'AUD') ? "selected" : "" ?>>
                                                    Australian Dollar</option>
                                                <option value="AWG" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'AWG') ? "selected" : "" ?>>
                                                    Aruban Florin</option>
                                                <option value="AZN" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'AZN') ? "selected" : "" ?>>
                                                    Azerbaijani Manat </option>
                                                <option value="BAM" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'BAM') ? "selected" : "" ?>>
                                                    Bosnia-Herzegovina Convertible Mark </option>
                                                <option value="BBD" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'BBD') ? "selected" : "" ?>>
                                                    Bajan dollar </option>
                                                <option value="BDT" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'BDT') ? "selected" : "" ?>>
                                                    Bangladeshi Taka</option>
                                                <option value="BGN" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'BGN') ? "selected" : "" ?>>
                                                    Bulgarian Lev </option>
                                                <option value="BIF" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'BIF') ? "selected" : "" ?>>
                                                    Burundian Franc</option>
                                                <option value="BMD" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'BMD') ? "selected" : "" ?>>
                                                    Bermudan Dollar</option>
                                                <option value="BND" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'BND') ? "selected" : "" ?>>
                                                    Brunei Dollar </option>
                                                <option value="BOB" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'BOB') ? "selected" : "" ?>>
                                                    Bolivian Boliviano </option>
                                                <option value="BRL" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'BRL') ? "selected" : "" ?>>
                                                    Brazilian Real </option>
                                                <option value="BSD" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'BSD') ? "selected" : "" ?>>
                                                    Bahamian Dollar </option>
                                                <option value="BWP" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'BWP') ? "selected" : "" ?>>
                                                    Botswanan Pula </option>
                                                <option value="BZD" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'BZD') ? "selected" : "" ?>>
                                                    Belize Dollar </option>
                                                <option value="CAD" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'CAD') ? "selected" : "" ?>>
                                                    Canadian Dollar </option>
                                                <option value="CDF" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'CDF') ? "selected" : "" ?>>
                                                    Congolese Franc </option>
                                                <option value="CHF" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'CHF') ? "selected" : "" ?>>
                                                    Swiss Franc </option>
                                                <option value="CLP" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'CLP') ? "selected" : "" ?>>
                                                    Chilean Peso </option>
                                                <option value="CNY" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'CNY') ? "selected" : "" ?>>
                                                    Chinese Yuan </option>
                                                <option value="COP" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'COP') ? "selected" : "" ?>>
                                                    Colombian Peso </option>
                                                <option value="CRC" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'CRC') ? "selected" : "" ?>>
                                                    Costa Rican Colón </option>
                                                <option value="CVE" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'CVE') ? "selected" : "" ?>> Cape
                                                    Verdean Escudo </option>
                                                <option value="CZK" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'CZK') ? "selected" : "" ?>>
                                                    Czech Koruna </option>
                                                <option value="DJF" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'DJF') ? "selected" : "" ?>>
                                                    Djiboutian Franc </option>
                                                <option value="DKK" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'DKK') ? "selected" : "" ?>>
                                                    Danish Krone </option>
                                                <option value="DOP" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'DOP') ? "selected" : "" ?>>
                                                    Dominican Peso </option>
                                                <option value="DZD" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'DZD') ? "selected" : "" ?>>
                                                    Algerian Dinar </option>
                                                <option value="EGP" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'EGP') ? "selected" : "" ?>>
                                                    Egyptian Pound </option>
                                                <option value="ETB" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'ETB') ? "selected" : "" ?>>
                                                    Ethiopian Birr </option>
                                                <option value="EUR" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'EUR') ? "selected" : "" ?>> Euro
                                                </option>
                                                <option value="FJD" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'FJD') ? "selected" : "" ?>>
                                                    Fijian Dollar </option>
                                                <option value="FKP" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'FKP') ? "selected" : "" ?>>
                                                    Falkland Island Pound </option>
                                                <option value="GBP" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'GBP') ? "selected" : "" ?>>
                                                    Pound sterling </option>
                                                <option value="GEL" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'GEL') ? "selected" : "" ?>>
                                                    Georgian Lari </option>
                                                <option value="GIP" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'GIP') ? "selected" : "" ?>>
                                                    Gibraltar Pound </option>
                                                <option value="GMD" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'GMD') ? "selected" : "" ?>>
                                                    Gambian dalasi </option>
                                                <option value="GNF" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'GNF') ? "selected" : "" ?>>
                                                    Guinean Franc </option>
                                                <option value="GTQ" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'GTQ') ? "selected" : "" ?>>
                                                    Guatemalan Quetzal </option>
                                                <option value="GYD" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'GYD') ? "selected" : "" ?>>
                                                    Guyanaese Dollar </option>
                                                <option value="HKD" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'HKD') ? "selected" : "" ?>> Hong
                                                    Kong Dollar </option>
                                                <option value="HNL" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'HNL') ? "selected" : "" ?>>
                                                    Honduran Lempira </option>
                                                <option value="HRK" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'HRK') ? "selected" : "" ?>>
                                                    Croatian Kuna </option>
                                                <option value="HTG" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'HTG') ? "selected" : "" ?>>
                                                    Haitian Gourde </option>
                                                <option value="HUF" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'HUF') ? "selected" : "" ?>>
                                                    Hungarian Forint </option>
                                                <option value="IDR" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'IDR') ? "selected" : "" ?>>
                                                    Indonesian Rupiah </option>
                                                <option value="ILS" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'ILS') ? "selected" : "" ?>>
                                                    Israeli New Shekel </option>
                                                <option value="ISK" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'ISK') ? "selected" : "" ?>>
                                                    Icelandic Króna </option>
                                                <option value="JMD" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'JMD') ? "selected" : "" ?>>
                                                    Jamaican Dollar </option>
                                                <option value="JPY" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'JPY') ? "selected" : "" ?>>
                                                    Japanese Yen </option>
                                                <option value="KES" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'KES') ? "selected" : "" ?>>
                                                    Kenyan Shilling </option>
                                                <option value="KGS" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'KGS') ? "selected" : "" ?>>
                                                    Kyrgystani Som </option>
                                                <option value="KHR" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'KHR') ? "selected" : "" ?>>
                                                    Cambodian riel </option>
                                                <option value="KMF" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'KMF') ? "selected" : "" ?>>
                                                    Comorian franc </option>
                                                <option value="KRW" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'KRW') ? "selected" : "" ?>>
                                                    South Korean won </option>
                                                <option value="KYD" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'KYD') ? "selected" : "" ?>>
                                                    Cayman Islands Dollar </option>
                                                <option value="KZT" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'KZT') ? "selected" : "" ?>>
                                                    Kazakhstani Tenge </option>
                                                <option value="LAK" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'LAK') ? "selected" : "" ?>>
                                                    Laotian Kip </option>
                                                <option value="LBP" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'LBP') ? "selected" : "" ?>>
                                                    Lebanese pound </option>
                                                <option value="LKR" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'LKR') ? "selected" : "" ?>> Sri
                                                    Lankan Rupee </option>
                                                <option value="LRD" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'LRD') ? "selected" : "" ?>>
                                                    Liberian Dollar </option>
                                                <option value="LSL" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'LSL') ? "selected" : "" ?>>
                                                    Lesotho loti </option>
                                                <option value="MAD" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'MAD') ? "selected" : "" ?>>
                                                    Moroccan Dirham </option>
                                                <option value="MDL" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'MDL') ? "selected" : "" ?>>
                                                    Moldovan Leu </option>
                                                <option value="MGA" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'MGA') ? "selected" : "" ?>>
                                                    Malagasy Ariary </option>
                                                <option value="MKD" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'MKD') ? "selected" : "" ?>>
                                                    Macedonian Denar </option>
                                                <option value="MMK" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'MMK') ? "selected" : "" ?>>
                                                    Myanmar Kyat </option>
                                                <option value="MNT" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'MNT') ? "selected" : "" ?>>
                                                    Mongolian Tugrik </option>
                                                <option value="MOP" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'MOP') ? "selected" : "" ?>>
                                                    Macanese Pataca </option>
                                                <option value="MRO" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'MRO') ? "selected" : "" ?>>
                                                    Mauritanian Ouguiya </option>
                                                <option value="MUR" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'MUR') ? "selected" : "" ?>>
                                                    Mauritian Rupee</option>
                                                <option value="MVR" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'MVR') ? "selected" : "" ?>>
                                                    Maldivian Rufiyaa </option>
                                                <option value="MWK" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'MWK') ? "selected" : "" ?>>
                                                    Malawian Kwacha </option>
                                                <option value="MXN" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'MXN') ? "selected" : "" ?>>
                                                    Mexican Peso </option>
                                                <option value="MYR" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'MYR') ? "selected" : "" ?>>
                                                    Malaysian Ringgit </option>
                                                <option value="MZN" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'MZN') ? "selected" : "" ?>>
                                                    Mozambican metical </option>
                                                <option value="NAD" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'NAD') ? "selected" : "" ?>>
                                                    Namibian dollar </option>
                                                <option value="NGN" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'NGN') ? "selected" : "" ?>>
                                                    Nigerian Naira </option>
                                                <option value="NIO" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'NIO') ? "selected" : "" ?>>
                                                    Nicaraguan Córdoba </option>
                                                <option value="NOK" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'NOK') ? "selected" : "" ?>>
                                                    Norwegian Krone </option>
                                                <option value="NPR" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'NPR') ? "selected" : "" ?>>
                                                    Nepalese Rupee </option>
                                                <option value="NZD" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'NZD') ? "selected" : "" ?>> New
                                                    Zealand Dollar </option>
                                                <option value="PAB" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'PAB') ? "selected" : "" ?>>
                                                    Panamanian Balboa </option>
                                                <option value="PEN" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'PEN') ? "selected" : "" ?>> Sol
                                                </option>
                                                <option value="PGK" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'PGK') ? "selected" : "" ?>>
                                                    Papua New Guinean Kina </option>
                                                <option value="PHP" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'PHP') ? "selected" : "" ?>>
                                                    Philippine peso </option>
                                                <option value="PKR" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'PKR') ? "selected" : "" ?>>
                                                    Pakistani Rupee </option>
                                                <option value="PLN" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'PLN') ? "selected" : "" ?>>
                                                    Poland złoty </option>
                                                <option value="PYG" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'PYG') ? "selected" : "" ?>>
                                                    Paraguayan Guarani </option>
                                                <option value="QAR" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'QAR') ? "selected" : "" ?>>
                                                    Qatari Rial </option>
                                                <option value="RON" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'RON') ? "selected" : "" ?>>
                                                    Romanian Leu </option>
                                                <option value="RSD" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'RSD') ? "selected" : "" ?>>
                                                    Serbian Dinar </option>
                                                <option value="RUB" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'RUB') ? "selected" : "" ?>>
                                                    Russian Ruble </option>
                                                <option value="RWF" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'RWF') ? "selected" : "" ?>>
                                                    Rwandan franc </option>
                                                <option value="SAR" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'SAR') ? "selected" : "" ?>>
                                                    Saudi Riyal </option>
                                                <option value="SBD" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'SBD') ? "selected" : "" ?>>
                                                    Solomon Islands Dollar </option>
                                                <option value="SCR" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'SCR') ? "selected" : "" ?>>
                                                    Seychellois Rupee </option>
                                                <option value="SEK" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'SEK') ? "selected" : "" ?>>
                                                    Swedish Krona </option>
                                                <option value="SGD" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'SGD') ? "selected" : "" ?>>
                                                    Singapore Dollar </option>
                                                <option value="SHP" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'SHP') ? "selected" : "" ?>>
                                                    Saint Helenian Pound </option>
                                                <option value="SLL" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'SLL') ? "selected" : "" ?>>
                                                    Sierra Leonean Leone </option>
                                                <option value="SOS" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'SOS') ? "selected" : "" ?>>
                                                    Somali Shilling </option>
                                                <option value="SRD" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'SRD') ? "selected" : "" ?>>
                                                    Surinamese Dollar </option>
                                                <option value="STD" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'STD') ? "selected" : "" ?>> Sao
                                                    Tome Dobra </option>
                                                <option value="SZL" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'SZL') ? "selected" : "" ?>>
                                                    Swazi Lilangeni </option>
                                                <option value="THB" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'THB') ? "selected" : "" ?>> Thai
                                                    Baht </option>
                                                <option value="TJS" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'TJS') ? "selected" : "" ?>>
                                                    Tajikistani Somoni </option>
                                                <option value="TOP" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'TOP') ? "selected" : "" ?>>
                                                    Tongan Paʻanga </option>
                                                <option value="TRY" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'TRY') ? "selected" : "" ?>>
                                                    Turkish lira </option>
                                                <option value="TTD" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'TTD') ? "selected" : "" ?>>
                                                    Trinidad & Tobago Dollar </option>
                                                <option value="TWD" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'TWD') ? "selected" : "" ?>> New
                                                    Taiwan dollar </option>
                                                <option value="TZS" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'TZS') ? "selected" : "" ?>>
                                                    Tanzanian Shilling </option>
                                                <option value="UAH" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'UAH') ? "selected" : "" ?>>
                                                    Ukrainian hryvnia </option>
                                                <option value="UGX" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'UGX') ? "selected" : "" ?>>
                                                    Ugandan Shilling </option>
                                                <option value="UYU" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'UYU') ? "selected" : "" ?>>
                                                    Uruguayan Peso </option>
                                                <option value="UZS" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'UZS') ? "selected" : "" ?>>
                                                    Uzbekistani Som </option>
                                                <option value="VND" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'VND') ? "selected" : "" ?>>
                                                    Vietnamese dong </option>
                                                <option value="VUV" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'VUV') ? "selected" : "" ?>>
                                                    Vanuatu Vatu </option>
                                                <option value="WST" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'WST') ? "selected" : "" ?>>
                                                    Samoa Tala</option>
                                                <option value="XAF" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'XAF') ? "selected" : "" ?>>
                                                    Central African CFA franc </option>
                                                <option value="XCD" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'XCD') ? "selected" : "" ?>> East
                                                    Caribbean Dollar </option>
                                                <option value="XOF" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'XOF') ? "selected" : "" ?>> West
                                                    African CFA franc </option>
                                                <option value="XPF" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'XPF') ? "selected" : "" ?>> CFP
                                                    Franc </option>
                                                <option value="YER" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'YER') ? "selected" : "" ?>>
                                                    Yemeni Rial </option>
                                                <option value="ZAR" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'ZAR') ? "selected" : "" ?>>
                                                    South African Rand </option>
                                                <option value="ZMW" <?= (isset($settings['stripe_currency_code']) && $settings['stripe_currency_code'] == 'ZMW') ? "selected" : "" ?>>
                                                    Zambian Kwacha </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="stripe_webhook_url">Payment Endpoint
                                            URL <small>(Set this as Endpoint URL in your Stripe account)</small></label>
                                        <div class="col">
                                            <input type="text" class="form-control" id="stripe_webhook_url" disabled
                                                value="<?= base_url("app/v1/api/stripe_webhook"); ?>" />
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- Flutterwave -->
                            <div class="card my-3" id="flutterwave_payment_method">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="ti ti-coins"></i> Flutterwave Payments</h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="flutterwave_payment_method">Flutterwave
                                            Payments <small>[ Enable / Disable ] </small></label>
                                        <div class="col">
                                            <label class="form-check form-switch form-switch-3">
                                                <input class="form-check-input" name="flutterwave_payment_method"
                                                    type="checkbox" <?= (@$settings['flutterwave_payment_method']) == '1' ? 'Checked' : '' ?> />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="flutterwave_public_key">Public
                                            Key</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="flutterwave_public_key"
                                                id="flutterwave_public_key"
                                                value="<?= @$settings['flutterwave_public_key'] ?>"
                                                placeholder="Flutterwave Public Key" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="flutterwave_secret_key">Secret
                                            Key</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="flutterwave_secret_key"
                                                id="flutterwave_secret_key"
                                                value="<?= @$settings['flutterwave_secret_key'] ?>"
                                                placeholder="Flutterwave Secret Key" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="flutterwave_encryption_key">Flutterwave
                                            Encryption key</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="flutterwave_encryption_key"
                                                id="flutterwave_encryption_key"
                                                value="<?= @$settings['flutterwave_encryption_key'] ?>"
                                                placeholder="Flutterwave Encryption Key" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="flutterwave_currency_code">Currency
                                            Code <small>[ Flutterwave supported ]</small><a
                                                href="https://flutterwave.com/tz/support/general/what-are-the-currencies-accepted-on-flutterwave"
                                                target="_BLANK"><i class="ti ti-link"></i></a></label>
                                        <div class="col">
                                            <select class="form-select" name="flutterwave_currency_code"
                                                id="flutterwave_currency_code">
                                                <option value="">Select Currency Code </option>
                                                <option value="NGN" <?= (isset($settings['flutterwave_currency_code']) && $settings['flutterwave_currency_code'] == 'NGN') ? "selected" : "" ?>>
                                                    Nigerian Naira</option>
                                                <option value="USD" <?= (isset($settings['flutterwave_currency_code']) && $settings['flutterwave_currency_code'] == 'USD') ? "selected" : "" ?>>
                                                    United States dollar</option>
                                                <option value="TZS" <?= (isset($settings['flutterwave_currency_code']) && $settings['flutterwave_currency_code'] == 'TZS') ? "selected" : "" ?>>
                                                    Tanzanian Shilling</option>
                                                <option value="SLL" <?= (isset($settings['flutterwave_currency_code']) && $settings['flutterwave_currency_code'] == 'SLL') ? "selected" : "" ?>>
                                                    Sierra Leonean Leone</option>
                                                <option value="MUR" <?= (isset($settings['flutterwave_currency_code']) && $settings['flutterwave_currency_code'] == 'MUR') ? "selected" : "" ?>>
                                                    Mauritian Rupee</option>
                                                <option value="MWK" <?= (isset($settings['flutterwave_currency_code']) && $settings['flutterwave_currency_code'] == 'MWK') ? "selected" : "" ?>>
                                                    Malawian Kwacha </option>
                                                <option value="GBP" <?= (isset($settings['flutterwave_currency_code']) && $settings['flutterwave_currency_code'] == 'GBP') ? "selected" : "" ?>>
                                                    UK Bank Accounts</option>
                                                <option value="GHS" <?= (isset($settings['flutterwave_currency_code']) && $settings['flutterwave_currency_code'] == 'GHS') ? "selected" : "" ?>>
                                                    Ghanaian Cedi</option>
                                                <option value="RWF" <?= (isset($settings['flutterwave_currency_code']) && $settings['flutterwave_currency_code'] == 'RWF') ? "selected" : "" ?>>
                                                    Rwandan franc</option>
                                                <option value="UGX" <?= (isset($settings['flutterwave_currency_code']) && $settings['flutterwave_currency_code'] == 'UGX') ? "selected" : "" ?>>
                                                    Ugandan Shilling</option>
                                                <option value="ZMW" <?= (isset($settings['flutterwave_currency_code']) && $settings['flutterwave_currency_code'] == 'ZMW') ? "selected" : "" ?>>
                                                    Zambian Kwacha</option>
                                                <option value="KES" <?= (isset($settings['flutterwave_currency_code']) && $settings['flutterwave_currency_code'] == 'KES') ? "selected" : "" ?>>
                                                    Mpesa</option>
                                                <option value="ZAR" <?= (isset($settings['flutterwave_currency_code']) && $settings['flutterwave_currency_code'] == 'ZAR') ? "selected" : "" ?>>
                                                    South African Rand</option>
                                                <option value="XAF" <?= (isset($settings['flutterwave_currency_code']) && $settings['flutterwave_currency_code'] == 'XAF') ? "selected" : "" ?>>
                                                    Central African CFA franc</option>
                                                <option value="XOF" <?= (isset($settings['flutterwave_currency_code']) && $settings['flutterwave_currency_code'] == 'XOF') ? "selected" : "" ?>>
                                                    West African CFA franc</option>
                                                <option value="AUD" <?= (isset($settings['flutterwave_currency_code']) && $settings['flutterwave_currency_code'] == 'AUD') ? "selected" : "" ?>>
                                                    Australian Dollar</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="flutterwave_webhook_secret_key">Webhook
                                            Secret Key</label>
                                        <div class="col">
                                            <input type="text" class="form-control"
                                                name="flutterwave_webhook_secret_key"
                                                id="flutterwave_webhook_secret_key"
                                                value="<?= @$settings['flutterwave_webhook_secret_key'] ?>"
                                                placeholder="Flutterwave Webhook Secret Key" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="flutterwave_webhook_url">Payment
                                            Endpoint URL <small>(Set this as Endpoint URL in your Flutterwave
                                                account)</small></label>
                                        <div class="col">
                                            <input type="text" class="form-control" id="flutterwave_webhook_url"
                                                disabled value="<?= base_url("app/v1/api/flutterwave_webhook"); ?>" />
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- Paytm -->
                            <div class="card my-3" id="paytm_payment_method">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="ti ti-coins"></i> Paytm Payments</h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="paytm_payment_method">Paytm Payments
                                            <small>[ Enable / Disable ] </small></label>
                                        <div class="col">
                                            <label class="form-check form-switch form-switch-3">
                                                <input class="form-check-input" name="paytm_payment_method"
                                                    type="checkbox" <?= (@$settings['paytm_payment_method']) == '1' ? 'Checked' : '' ?> />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label">Payment Mode <small>[ sandbox / live
                                                ]</small></label>
                                        <div class="col">
                                            <select class="form-select" name="paytm_payment_mode"
                                                id="paytm_payment_mode">
                                                <option value="">Select Mode</option>
                                                <option value="sandbox" <?= (isset($settings['paytm_payment_mode']) && $settings['paytm_payment_mode'] == 'sandbox') ? 'selected' : '' ?>>
                                                    Sandbox ( Testing )</option>
                                                <option value="production" <?= (isset($settings['paytm_payment_mode']) && $settings['paytm_payment_mode'] == 'production') ? 'selected' : '' ?>>
                                                    Production ( Live )</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="paytm_merchant_key">Merchant
                                            Key</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="paytm_merchant_key"
                                                id="paytm_merchant_key" value="<?= @$settings['paytm_merchant_key'] ?>"
                                                placeholder="Paytm Merchant Key" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="paytm_merchant_id">Merchant ID</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="paytm_merchant_id"
                                                id="paytm_merchant_id" value="<?= @$settings['paytm_merchant_id'] ?>"
                                                placeholder="Paytm Merchant ID" />
                                        </div>
                                    </div>
                                    <?php if (isset($settings['paytm_payment_mode']) && $settings['paytm_payment_mode'] == 'production') { ?>

                                        <div class="mb-3 row">
                                            <label class="col-3 col-form-label" for="paytm_website">Paytm Website <small>[<a
                                                        href="https://dashboard.paytm.com/next/apikeys?src=dev"
                                                        target="_blank">click here</a>]</small></label>
                                            <div class="col">
                                                <input type="text" class="form-control" name="paytm_website"
                                                    id="paytm_website" value="<?= @$settings['paytm_website'] ?>"
                                                    placeholder="Paytm Website" />
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-3 col-form-label" for="paytm_industry_type_id">Industry Type
                                                ID <small>[<a href="https://dashboard.paytm.com/next/apikeys?src=dev"
                                                        target="_blank">click here</a>]</small></label>
                                            <div class="col">
                                                <input type="text" class="form-control" name="paytm_industry_type_id"
                                                    id="paytm_industry_type_id"
                                                    value="<?= @$settings['paytm_industry_type_id'] ?>"
                                                    placeholder="Paytm Industry Type ID" />
                                            </div>
                                        </div>

                                    <?php } else { ?>

                                        <div class="mb-3 row">
                                            <label class="col-3 col-form-label" for="paytm_website">Paytm Website <small>[<a
                                                        href="https://dashboard.paytm.com/next/apikeys?src=dev"
                                                        target="_blank">click here</a>]</small></label>
                                            <div class="col">
                                                <input type="text" class="form-control" name="paytm_website"
                                                    id="paytm_website" placeholder="Paytm Website" />
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-3 col-form-label" for="paytm_industry_type_id">Industry Type
                                                ID <small>[<a href="https://dashboard.paytm.com/next/apikeys?src=dev"
                                                        target="_blank">click here</a>]</small></label>
                                            <div class="col">
                                                <input type="text" class="form-control" name="paytm_industry_type_id"
                                                    id="paytm_industry_type_id" placeholder="Paytm Industry Type ID" />
                                            </div>
                                        </div>

                                    <?php } ?>

                                </div>
                            </div>
                            <!-- Midtrans -->
                            <div class="card my-3" id="midtrans_payment_method">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="ti ti-coins"></i> Midtrans Payments</h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="midtrans_payment_method">Midtrans
                                            Payments <small>[ Enable / Disable ] </small></label>
                                        <div class="col">
                                            <label class="form-check form-switch form-switch-3">
                                                <input class="form-check-input" name="midtrans_payment_method"
                                                    type="checkbox" <?= (@$settings['midtrans_payment_method']) == '1' ? 'Checked' : '' ?> />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label">Midtrans Mode <small>[ sandbox / live
                                                ]</small></label>
                                        <div class="col">
                                            <select class="form-select" name="midtrans_payment_mode"
                                                id="midtrans_payment_mode">
                                                <option value="">Select Mode</option>
                                                <option value="sandbox" <?= (isset($settings['midtrans_payment_mode']) && $settings['midtrans_payment_mode'] == 'sandbox') ? 'selected' : '' ?>>
                                                    Sandbox ( Testing )</option>
                                                <option value="production" <?= (isset($settings['midtrans_payment_mode']) && $settings['midtrans_payment_mode'] == 'production') ? 'selected' : '' ?>>Production ( Live )</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="midtrans_client_key">Client Key</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="midtrans_client_key"
                                                id="midtrans_client_key"
                                                value="<?= @$settings['midtrans_client_key'] ?>"
                                                placeholder="Midtrans Client Key" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="midtrans_merchant_id">Merchant
                                            ID</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="midtrans_merchant_id"
                                                id="midtrans_merchant_id"
                                                value="<?= @$settings['midtrans_merchant_id'] ?>"
                                                placeholder="Midtrans Merchant ID" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="midtrans_server_key">Server Key</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="midtrans_server_key"
                                                id="midtrans_server_key"
                                                value="<?= @$settings['midtrans_server_key'] ?>"
                                                placeholder="Midtrans Server Key" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="midtrans_webhook_url">Notification URL
                                            <small>(Set this as Webhook URL in your Midtrans account)</small></label>
                                        <div class="col">
                                            <input type="text" class="form-control" id="midtrans_webhook_url" disabled
                                                value="<?= base_url('app/v1/api/midtrans_webhook') ?>" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="midtrans_payment_return_url">Payment
                                            Return URL <small>(Set this as Finish URL in your Midtrans
                                                account)</small></label>
                                        <div class="col">
                                            <input type="text" class="form-control" id="midtrans_payment_return_url"
                                                disabled
                                                value="<?= base_url('app/v1/api/midtrans_payment_process') ?>" />
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- Myfatoorah -->
                            <div class="card my-3" id="myfatoorah_payment_method">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="ti ti-coins"></i> Myfatoorah Payments</h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="myfaoorah_payment_method">Myfatoorah
                                            Payments <small>[ Enable / Disable ] </small></label>
                                        <div class="col">
                                            <label class="form-check form-switch form-switch-3">
                                                <input class="form-check-input" name="myfaoorah_payment_method"
                                                    type="checkbox" <?= (@$settings['myfaoorah_payment_method']) == '1' ? 'Checked' : '' ?> />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label">Midtrans Mode <small>[ sandbox / live
                                                ]</small></label>
                                        <div class="col">
                                            <select class="form-select" name="myfatoorah_payment_mode"
                                                id="myfatoorah_payment_mode">
                                                <option value="">Select Mode</option>
                                                <option value="test" <?= (isset($settings['myfatoorah_payment_mode']) && $settings['myfatoorah_payment_mode'] == 'test') ? 'selected' : '' ?>>
                                                    Sandbox ( Testing )</option>
                                                <option value="live" <?= (isset($settings['myfatoorah_payment_mode']) && $settings['myfatoorah_payment_mode'] == 'live') ? 'selected' : '' ?>>
                                                    Production ( Live )</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="myfatoorah_language">Myfatoorah
                                            Language</label>
                                        <div class="col">
                                            <select class="form-select" name="myfatoorah_language"
                                                id="myfatoorah_language">
                                                <option value="">Select Language</option>
                                                <option value="english" <?= (isset($settings['myfatoorah_language']) && $settings['myfatoorah_language'] == 'english') ? 'selected' : '' ?>>
                                                    English</option>
                                                <option value="arabic" <?= (isset($settings['myfatoorah_language']) && $settings['myfatoorah_language'] == 'arabic') ? 'selected' : '' ?>>
                                                    Arabic</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="myfatoorah_country">Myfatoorah Country
                                            <small>[ test / live ]</small></label>
                                        <div class="col">
                                            <select class="form-select" name="myfatoorah_country"
                                                id="myfatoorah_country">
                                                <option value="">Select country</option>
                                                <option value="Kuwait" <?= (isset($settings['myfatoorah_country']) && $settings['myfatoorah_country'] == 'Kuwait') ? 'selected' : '' ?>>
                                                    Kuwait</option>
                                                <option value="SaudiArabia" <?= (isset($settings['myfatoorah_country']) && $settings['myfatoorah_country'] == 'SaudiArabia') ? 'selected' : '' ?>>SaudiArabia</option>
                                                <option value="Bahrain" <?= (isset($settings['myfatoorah_country']) && $settings['myfatoorah_country'] == 'Bahrain') ? 'selected' : '' ?>>
                                                    Bahrain</option>
                                                <option value="UAE" <?= (isset($settings['myfatoorah_country']) && $settings['myfatoorah_country'] == 'UAE') ? 'selected' : '' ?>>UAE
                                                </option>
                                                <option value="Qatar" <?= (isset($settings['myfatoorah_country']) && $settings['myfatoorah_country'] == 'Qatar') ? 'selected' : '' ?>>Qatar
                                                </option>
                                                <option value="Oman" <?= (isset($settings['myfatoorah_country']) && $settings['myfatoorah_country'] == 'Oman') ? 'selected' : '' ?>>Oman
                                                </option>
                                                <option value="Jordan" <?= (isset($settings['myfatoorah_country']) && $settings['myfatoorah_country'] == 'Jordan') ? 'selected' : '' ?>>
                                                    Jordan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="myfatoorah_token">Myfatoorah Token
                                        </label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="myfatoorah_token"
                                                id="myfatoorah_token" value="<?= @$settings['myfatoorah_token'] ?>"
                                                placeholder="myfatoorah_token" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="myfatoorah_secret_key">Payment secret
                                            key</label>
                                        <div class="col">
                                            <input type="text" class="form-control" id="myfatoorah_secret_key"
                                                name="myfatoorah_secret_key"
                                                value="<?= @$settings['myfatoorah_secret_key'] ?>" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="myfatoorah_webhook_url">Notification
                                            URL <small>(Set this as Webhook URL in your MyFatoorah
                                                account)</small></label>
                                        <div class="col">
                                            <input type="text" class="form-control" id="myfatoorah_webhook_url" disabled
                                                value="<?= base_url("admin/webhook/myfatoorah"); ?>" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="myfatoorah_successUrl">Payment success
                                            Url</label>
                                        <div class="col">
                                            <input type="text" class="form-control" id="myfatoorah_successUrl" disabled
                                                value="<?= base_url("admin/webhook/myfatoorah_success_url"); ?>" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="myfatoorah_errorUrl">Payment error
                                            Url</label>
                                        <div class="col">
                                            <input type="text" class="form-control" id="myfatoorah_errorUrl" disabled
                                                value="<?= base_url("admin/webhook/myfatoorah_error_url"); ?>" />
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <!-- Instamojo -->
                            <div class="card my-3" id="instamojo_payment_method">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="ti ti-coins"></i> Instamojo Payments</h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="instamojo_payment_method">Instamojo
                                            Payments <small>[ Enable / Disable ] </small></label>
                                        <div class="col">
                                            <label class="form-check form-switch form-switch-3">
                                                <input class="form-check-input" name="instamojo_payment_method"
                                                    type="checkbox" <?= (@$settings['instamojo_payment_method']) == '1' ? 'Checked' : '' ?> />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label">Instamojo Mode <small>[ sandbox / live
                                                ]</small></label>
                                        <div class="col">
                                            <select class="form-select" name="instamojo_payment_mode"
                                                id="instamojo_payment_mode">
                                                <option value="">Select Mode</option>
                                                <option value="sandbox" <?= (isset($settings['instamojo_payment_mode']) && $settings['instamojo_payment_mode'] == 'sandbox') ? 'selected' : '' ?>>Sandbox ( Testing )</option>
                                                <option value="production"
                                                    <?= (isset($settings['instamojo_payment_mode']) && $settings['instamojo_payment_mode'] == 'production') ? 'selected' : '' ?>>Production ( Live )</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="instamojo_client_id">Client ID</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="instamojo_client_id"
                                                id="instamojo_client_id"
                                                value="<?= @$settings['instamojo_client_id'] ?>"
                                                placeholder="Instamojo Client ID" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="instamojo_client_secret">Client
                                            Secret</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="instamojo_client_secret"
                                                id="instamojo_client_secret"
                                                value="<?= @$settings['instamojo_client_secret'] ?>"
                                                placeholder="Instamojo Client Secret" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="instamojo_webhook_url">Payment Endpoint
                                            URL <small>(Set this as Endpoint URL in your Instamojo
                                                account)</small></label>
                                        <div class="col">
                                            <input type="text" class="form-control" id="instamojo_webhook_url" disabled
                                                value="<?= base_url("admin/webhook/instamojo_webhook"); ?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Phone Pe -->
                            <div class="card my-3" id="phonepe_payment_method">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="ti ti-coins"></i> Phone Pe Payments</h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="phonepe_payment_method">Phone Pe
                                            Payments <small>[ Enable / Disable ] </small></label>
                                        <div class="col">
                                            <label class="form-check form-switch form-switch-3">
                                                <input class="form-check-input" name="phonepe_payment_method"
                                                    type="checkbox" <?= (@$settings['phonepe_payment_method']) == '1' ? 'Checked' : '' ?> />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label">PhonePe Mode <small>[ SANDBOX / UAT /
                                                PRODUCTION ]</small></label>
                                        <div class="col">
                                            <select class="form-select" name="phonepe_payment_mode"
                                                id="phonepe_payment_mode">
                                                <option value="">Select Mode</option>
                                                <option value="SANDBOX" <?= (isset($settings['phonepe_payment_mode']) && $settings['phonepe_payment_mode'] == 'SANDBOX') ? 'selected' : '' ?>>
                                                    SANDBOX</option>
                                                <option value="UAT" <?= (isset($settings['phonepe_payment_mode']) && $settings['phonepe_payment_mode'] == 'UAT') ? 'selected' : '' ?>>UAT
                                                </option>
                                                <option value="PRODUCTION" <?= (isset($settings['phonepe_payment_mode']) && $settings['phonepe_payment_mode'] == 'PRODUCTION') ? 'selected' : '' ?>>PRODUCTION</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="phonepe_marchant_id">Marchant
                                            ID</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="phonepe_marchant_id"
                                                id="phonepe_marchant_id"
                                                value="<?= @$settings['phonepe_marchant_id'] ?>"
                                                placeholder="PhonePe Marchant ID" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="phonepe_client_id">Client ID</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="phonepe_client_id"
                                                id="phonepe_client_id" value="<?= @$settings['phonepe_client_id'] ?>"
                                                placeholder="PhonePe Client ID" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="phonepe_client_secret">Client
                                            Secret</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="phonepe_client_secret"
                                                id="phonepe_client_secret"
                                                value="<?= @$settings['phonepe_client_secret'] ?>"
                                                placeholder="PhonePe Client Secret" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="phonepe_webhook_url">Payment Endpoint
                                            URL <small>(Set this as Endpoint URL in your PhonePe
                                                account)</small></label>
                                        <div class="col">
                                            <input type="text" class="form-control" id="phonepe_webhook_url" disabled
                                                value="<?= base_url("admin/webhook/phonepe_webhook"); ?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Direct Bank Transfer -->
                            <div class="card my-3" id="direct_bank_transfer">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="ti ti-coins"></i> Direct Bank Transfer</h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="direct_bank_transfer">Direct Bank
                                            Transfer <small>[ Enable / Disable ] </small></label>
                                        <div class="col">
                                            <label class="form-check form-switch form-switch-3">
                                                <input class="form-check-input" name="direct_bank_transfer"
                                                    type="checkbox" <?= (@$settings['direct_bank_transfer']) == '1' ? 'Checked' : '' ?> />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="account_name">Account Name</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="account_name"
                                                id="account_name" value="<?= @$settings['account_name'] ?>"
                                                placeholder="Account Name" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="account_number">Account Number</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="account_number"
                                                id="account_number" value="<?= @$settings['account_number'] ?>"
                                                placeholder="Account Number" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="bank_name">Bank Name</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="bank_name" id="bank_name"
                                                value="<?= @$settings['bank_name'] ?>" placeholder="Bank Name" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="bank_code">Bank Code</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="bank_code" id="bank_code"
                                                value="<?= @$settings['bank_code'] ?>" placeholder="Bank Code" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="notes">Notes</label>
                                        <div class="col">
                                            <textarea class="hugerte-mytextarea" name="notes"
                                                placeholder="Extra Notes"><?= @str_replace('\"', '', str_replace('\r\n', '&#13;&#10;', $settings['notes'])) ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Cash On Delivery -->
                            <div class="card my-3" id="cod_method">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="ti ti-coins"></i> Cash On Delivery</h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="cod_method">Cash On Delivery <small>[
                                                Enable / Disable ] </small></label>
                                        <div class="col">
                                            <label class="form-check form-switch form-switch-3">
                                                <input class="form-check-input" name="cod_method" type="checkbox"
                                                    <?= (@$settings['cod_method']) == '1' ? 'Checked' : '' ?> />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="min_cod_amount">Minimum Cash On
                                            Delivery Amount</label>
                                        <div class="col">
                                            <input type="number" class="form-control" name="min_cod_amount"
                                                id="min_cod_amount" value="<?= @$settings['min_cod_amount'] ?>"
                                                placeholder="Minimum Cash On Delivery Amount" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="max_cod_amount">Maximum Cash On
                                            Delivery Amount</label>
                                        <div class="col">
                                            <input type="number" class="form-control" name="max_cod_amount"
                                                id="max_cod_amount" value="<?= @$settings['max_cod_amount'] ?>"
                                                placeholder="Maximum Cash On Delivery Amount" />
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y m-4">

                                    <div class="form-group text-end">
                                        <button type="reset" class="btn">Cancel</button>
                                        <button type="submit" class="btn btn-primary" id="submit_btn">Update Payment
                                            Settings <i class="cursor-pointer ms-2 ti ti-arrow-right"></i></button>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>