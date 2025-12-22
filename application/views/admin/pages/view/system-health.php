<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">System Health</h2>
                        <div class="text-muted mt-1">Monitor and manage your system requirements and configurations
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- END PAGE HEADER -->

        <div class="page-body">
            <div class="container-xl">

                <!-- PHP Version Status Cards -->
                <div class="row row-deck row-cards mb-4">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-stamp">
                                <div class="card-stamp-icon bg-primary">
                                    <i class="ti ti-code"></i>
                                </div>
                            </div>
                            <div class="card-body">
                                <h3 class="card-title">Current PHP Version</h3>
                                <div class="h1 mb-3">8.3</div>
                                <div class="text-muted">Currently running version</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-stamp">
                                <div class="card-stamp-icon bg-success">
                                    <i class="ti ti-check"></i>
                                </div>
                            </div>
                            <div class="card-body">
                                <h3 class="card-title">Minimum Required</h3>
                                <div class="h1 mb-3">8.2</div>
                                <div class="text-muted">Minimum supported version</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-stamp">
                                <div class="card-stamp-icon bg-warning">
                                    <i class="ti ti-alert-triangle"></i>
                                </div>
                            </div>
                            <div class="card-body">
                                <h3 class="card-title">Maximum Required</h3>
                                <div class="h1 mb-3">8.3</div>
                                <div class="text-muted">Maximum supported version</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- System Requirements Section -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="ti ti-settings me-2"></i>
                                    System Requirements & Extensions
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-vcenter">
                                        <thead>
                                            <tr>
                                                <th class="w-1">#</th>
                                                <th>Extension/Service</th>
                                                <th>Description</th>
                                                <th class="w-1">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><span class="badge bg-primary-lt">1</span></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <i class="ti ti-world me-2"></i>
                                                        <strong>cURL Extension</strong>
                                                    </div>
                                                </td>
                                                <td>Needs to enable this extension on your server(cPanel). This is used
                                                    for payment methods.</td>
                                                <td>
                                                    <span class="badge bg-warning-lt">Required</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><span class="badge bg-primary-lt">2</span></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <i class="ti ti-terminal me-2"></i>
                                                        <strong>shell_exec Extension</strong>
                                                    </div>
                                                </td>
                                                <td>Needs to enable this extension on your server(cPanel).</td>
                                                <td>
                                                    <span class="badge bg-warning-lt">Required</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><span class="badge bg-primary-lt">3</span></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <i class="ti ti-archive me-2"></i>
                                                        <strong>Zip Extension</strong>
                                                    </div>
                                                </td>
                                                <td>Needs to enable this extension on your server(cPanel). This is used
                                                    for update system using zip files.</td>
                                                <td>
                                                    <span class="badge bg-warning-lt">Required</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><span class="badge bg-primary-lt">4</span></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <i class="ti ti-shield-check me-2"></i>
                                                        <strong>Open SSL Extension</strong>
                                                    </div>
                                                </td>
                                                <td>Needs to enable this extension on your server(cPanel).</td>
                                                <td>
                                                    <span class="badge bg-warning-lt">Required</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notification Settings -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="ti ti-bell me-2"></i>
                                    Notification Settings
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="alert alert-info" role="alert">
                                            <h4 class="alert-title">Firebase Push Notifications Setup</h4>
                                            <div class="text-muted">To enable Application Push Notifications, please
                                                complete these steps:</div>
                                        </div>
                                        <div class="list-group list-group-flush">
                                            <div class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <span class="badge bg-primary-lt">1</span>
                                                    </div>
                                                    <div class="col text-truncate">
                                                        <strong>Set your VAP ID key</strong> from Firebase account
                                                        (Firebase → Project Settings → Cloud Messaging → Web
                                                        Configuration → here you have to generate it)
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <span class="badge bg-primary-lt">2</span>
                                                    </div>
                                                    <div class="col text-truncate">
                                                        <strong>Set your Firebase project ID</strong> (Firebase →
                                                        Project Settings → General → Project ID)
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <span class="badge bg-primary-lt">3</span>
                                                    </div>
                                                    <div class="col text-truncate">
                                                        <strong>Upload the service account JSON file</strong> associated
                                                        with your Firebase account (Firebase → Project Settings →
                                                        Service Account → Generate new private key)
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Email Settings -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="ti ti-mail me-2"></i>
                                    Email Settings
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-warning" role="alert">
                                    <h4 class="alert-title">SMTP Configuration Required</h4>
                                    <div class="text-muted">
                                        You need to set SMTP Email Settings for Email Notification. For this setting you
                                        need to check your server SMTP Email settings.
                                        If that is not working then Ask your support to check your SMTP settings.
                                    </div>
                                    <div class="mt-3">
                                        <a href="https://www.gmass.co/smtp-test" target="_blank"
                                            class="btn btn-outline-primary">
                                            <i class="ti ti-external-link me-1"></i>
                                            Test SMTP Settings
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Settings -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="ti ti-credit-card me-2"></i>
                                    Payment Gateway Settings
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row row-cards">
                                    <div class="col-md-6 col-lg-4">
                                        <div class="card card-sm">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <span class="bg-primary text-white avatar">
                                                            <i class="ti ti-brand-paypal"></i>
                                                        </span>
                                                    </div>
                                                    <div class="col">
                                                        <div class="font-weight-medium">PayPal Payments</div>
                                                        <div class="text-muted">Create PayPal business account</div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <a href="https://www.paypal.com/in/business" target="_blank"
                                                            class="btn btn-outline-primary btn-sm">
                                                            <i class="ti ti-external-link"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="card card-sm">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <span class="bg-info text-white avatar">
                                                            <i class="ti ti-credit-card"></i>
                                                        </span>
                                                    </div>
                                                    <div class="col">
                                                        <div class="font-weight-medium">Razorpay Payments</div>
                                                        <div class="text-muted">Create Razorpay business account</div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <a href="https://razorpay.com/" target="_blank"
                                                            class="btn btn-outline-primary btn-sm">
                                                            <i class="ti ti-external-link"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="card card-sm">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <span class="bg-success text-white avatar">
                                                            <i class="ti ti-credit-card"></i>
                                                        </span>
                                                    </div>
                                                    <div class="col">
                                                        <div class="font-weight-medium">Paystack Payments</div>
                                                        <div class="text-muted">Create Paystack business account</div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <a href="https://paystack.com/" target="_blank"
                                                            class="btn btn-outline-primary btn-sm">
                                                            <i class="ti ti-external-link"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="card card-sm">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <span class="bg-dark text-white avatar">
                                                            <i class="ti ti-credit-card"></i>
                                                        </span>
                                                    </div>
                                                    <div class="col">
                                                        <div class="font-weight-medium">Stripe Payments</div>
                                                        <div class="text-muted">Create Stripe business account</div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <a href="https://stripe.com/in" target="_blank"
                                                            class="btn btn-outline-primary btn-sm">
                                                            <i class="ti ti-external-link"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="card card-sm">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <span class="bg-warning text-white avatar">
                                                            <i class="ti ti-credit-card"></i>
                                                        </span>
                                                    </div>
                                                    <div class="col">
                                                        <div class="font-weight-medium">Flutterwave Payments</div>
                                                        <div class="text-muted">Create Flutterwave business account
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <a href="https://flutterwave.com/us/" target="_blank"
                                                            class="btn btn-outline-primary btn-sm">
                                                            <i class="ti ti-external-link"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="card card-sm">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <span class="bg-secondary text-white avatar">
                                                            <i class="ti ti-credit-card"></i>
                                                        </span>
                                                    </div>
                                                    <div class="col">
                                                        <div class="font-weight-medium">Paytm Payments</div>
                                                        <div class="text-muted">Create Paytm business account</div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <a href="https://business.paytm.com/" target="_blank"
                                                            class="btn btn-outline-primary btn-sm">
                                                            <i class="ti ti-external-link"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="card card-sm">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <span class="bg-danger text-white avatar">
                                                            <i class="ti ti-credit-card"></i>
                                                        </span>
                                                    </div>
                                                    <div class="col">
                                                        <div class="font-weight-medium">Midtrans Payments</div>
                                                        <div class="text-muted">Create Midtrans business account</div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <a href="https://midtrans.com/" target="_blank"
                                                            class="btn btn-outline-primary btn-sm">
                                                            <i class="ti ti-external-link"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="card card-sm">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <span class="bg-primary text-white avatar">
                                                            <i class="ti ti-credit-card"></i>
                                                        </span>
                                                    </div>
                                                    <div class="col">
                                                        <div class="font-weight-medium">Myfatoorah Payments</div>
                                                        <div class="text-muted">Create Myfatoorah business account</div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <a href="https://www.myfatoorah.com/" target="_blank"
                                                            class="btn btn-outline-primary btn-sm">
                                                            <i class="ti ti-external-link"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="card card-sm">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <span class="bg-info text-white avatar">
                                                            <i class="ti ti-credit-card"></i>
                                                        </span>
                                                    </div>
                                                    <div class="col">
                                                        <div class="font-weight-medium">Instamojo Payments</div>
                                                        <div class="text-muted">Create Instamojo business account</div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <a href="https://www.instamojo.com/" target="_blank"
                                                            class="btn btn-outline-primary btn-sm">
                                                            <i class="ti ti-external-link"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="card card-sm">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <span class="bg-success text-white avatar">
                                                            <i class="ti ti-credit-card"></i>
                                                        </span>
                                                    </div>
                                                    <div class="col">
                                                        <div class="font-weight-medium">PhonePe Payments</div>
                                                        <div class="text-muted">Create PhonePe business account</div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <a href="https://www.phonepe.com/" target="_blank"
                                                            class="btn btn-outline-primary btn-sm">
                                                            <i class="ti ti-external-link"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Settings -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="ti ti-truck me-2"></i>
                                    Shipping Settings
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card card-sm">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <span class="bg-primary text-white avatar">
                                                            <i class="ti ti-map-pin"></i>
                                                        </span>
                                                    </div>
                                                    <div class="col">
                                                        <div class="font-weight-medium">Local Shipping</div>
                                                        <div class="text-muted">Configure local delivery system</div>
                                                    </div>
                                                </div>
                                                <div class="mt-3">
                                                    <div class="alert alert-info" role="alert">
                                                        <h4 class="alert-title">Setup Steps:</h4>
                                                        <ol class="mb-0">
                                                            <li>Set deliverability system from admin panel → system →
                                                                store setting (enable zipcode wise or city wise)</li>
                                                            <li>Add cities in admin panel → location → city</li>
                                                            <li>Add zipcodes in admin panel → location → zipcodes (for
                                                                zipcode wise deliverability)</li>
                                                        </ol>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card card-sm">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <span class="bg-success text-white avatar">
                                                            <i class="ti ti-truck"></i>
                                                        </span>
                                                    </div>
                                                    <div class="col">
                                                        <div class="font-weight-medium">Shiprocket Integration</div>
                                                        <div class="text-muted">Standard delivery method</div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <a href="https://www.shiprocket.in/" target="_blank"
                                                            class="btn btn-outline-primary btn-sm">
                                                            <i class="ti ti-external-link"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="mt-3">
                                                    <div class="alert alert-info" role="alert">
                                                        <h4 class="alert-title">Setup Steps:</h4>
                                                        <ol class="mb-0">
                                                            <li>Set your Shiprocket API credentials</li>
                                                            <li>Set your Shiprocket warehouse ID</li>
                                                        </ol>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Authentication Settings -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="ti ti-shield-check me-2"></i>
                                    Authentication Settings
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card card-sm">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <span class="bg-warning text-white avatar">
                                                            <i class="ti ti-brand-firebase"></i>
                                                        </span>
                                                    </div>
                                                    <div class="col">
                                                        <div class="font-weight-medium">Firebase Configuration</div>
                                                        <div class="text-muted">Setup Firebase authentication</div>
                                                    </div>
                                                </div>
                                                <div class="mt-3">
                                                    <div class="alert alert-info" role="alert">
                                                        <h4 class="alert-title">Setup Steps:</h4>
                                                        <ol class="mb-0">
                                                            <li>Set Firebase settings from admin panel → Web settings →
                                                                Firebase Settings</li>
                                                            <li>Add 'test' in databaseURL and measurementId</li>
                                                        </ol>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card card-sm">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <span class="bg-info text-white avatar">
                                                            <i class="ti ti-message-circle"></i>
                                                        </span>
                                                    </div>
                                                    <div class="col">
                                                        <div class="font-weight-medium">SMS Gateway</div>
                                                        <div class="text-muted">Custom SMS Gateway configuration</div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <a href="https://www.twilio.com/en-us" target="_blank"
                                                            class="btn btn-outline-primary btn-sm">
                                                            <i class="ti ti-external-link"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="mt-3">
                                                    <div class="alert alert-info" role="alert">
                                                        <h4 class="alert-title">Setup Steps:</h4>
                                                        <ol class="mb-0">
                                                            <li>Set your custom SMS gateway settings from Admin panel →
                                                                System → SMS Gateway Settings</li>
                                                            <li>In base URL add your SMS gateways base URL</li>
                                                            <li>Add authorization token in header</li>
                                                            <li>Add body data in Body</li>
                                                        </ol>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- END PAGE BODY -->
    </div>
    <!-- END PAGE -->
</div>