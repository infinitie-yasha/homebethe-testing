<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">
        <div class="row align-items-center g-2">
            <!-- Page Title -->
            <div class="col-12 col-md mb-2 mb-md-0">
                <h2 class="page-title mb-0 text-truncate" style="max-width:100%">Manage Order</h2>
            </div>

            <!-- Breadcrumbs -->
            <div class="col-12 col-md-auto">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-arrows mb-0 flex-wrap justify-content-md-end">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('delivery_boy/home') ?>">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('delivery_boy/orders') ?>">Orders</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Order Details
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>


        <!-- END PAGE HEADER -->
        <?php
        // echo "<pre>";
        $sellers = array_values(array_unique(array_column($order_detls, "seller_id")));

        for ($i = 0; $i < count($sellers); $i++) {
            $seller_data = fetch_details('users', ['id' => $sellers[$i]], 'username');
            $seller_otp_data = fetch_details('order_items', ['order_id' => $order_detls['order_id'], 'seller_id' => $sellers[$i]], ['otp', 'deliveryboy_otp_setting_on']);
            $seller_otp = $seller_otp_data[0]['otp'];
            $otp_system = $seller_otp_data[0]['deliveryboy_otp_setting_on'];

            $total = 0;
            $tax_amount = 0;
        }
        ?>




        <div class="page-body">
            <div class="container-xl">
                <input type="hidden" id="order_id"
                    value="<?= isset($order_detls[0]['order_id']) ? $order_detls[0]['order_id'] : (isset($order_detls[0]['id']) ? $order_detls[0]['id'] : '') ?>">
                <input type="hidden" id="is_shiprocket_order_check"
                    value="<?= isset($order_detls[0]['is_shiprocket_order']) ? $order_detls[0]['is_shiprocket_order'] : 0 ?>">
                <!-- Order Header Card -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <h1 class="h2 mb-0">Order
                                            #<?= isset($order_detls[0]['order_id']) ? $order_detls[0]['order_id'] : 'ORD-2024-001234' ?>
                                        </h1>
                                        <div class="text-muted">Placed on
                                            <?= isset($order_detls[0]['created_date']) ? date('F j, Y', strtotime($order_detls[0]['created_date'])) : '' ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-auto">
                                <?php

                                $status = (!empty($order_detls) && isset($order_detls[0]['active_status']) && !empty($order_detls[0]['active_status']))
                                    ? $order_detls[0]['active_status']
                                    : 'awaiting';

                                // Define valid statuses to prevent unexpected values
                                $valid_statuses = ['awaiting', 'received', 'processed', 'shipped', 'delivered', 'cancelled'];
                                if (!in_array($status, $valid_statuses)) {
                                    $status = 'awaiting';
                                }


                                $status_class = match ($status) {
                                    'awaiting' => 'bg-secondary-lt',
                                    'received' => 'bg-primary-lt',
                                    'processed' => 'bg-info-lt',
                                    'shipped' => 'bg-warning-lt',
                                    'delivered' => 'bg-success-lt',
                                    'cancelled' => 'bg-danger-lt',
                                    default => 'bg-secondary-lt',
                                };
                                ?>
                                <span
                                    class="badge <?= $status_class ?> fs-6 px-3 py-2"><?= strtoupper(str_replace('_', ' ', $status)) ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-lg-8">

                        <div class="card mb-4">
                            <div class="card-header">
                                <ul class="nav nav-pills flex-wrap" id="orderTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="order-items-tab" data-bs-toggle="tab"
                                            data-bs-target="#order-items" type="button" role="tab"
                                            aria-controls="order-items" aria-selected="true">
                                            <i class="ti ti-box me-1"></i> Order Items
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body p-2 p-md-3">
                                <div class="tab-content" id="orderTabsContent">
                                    <!-- Order Items Pane -->
                                    <div class="tab-pane fade show active" id="order-items" role="tabpanel"
                                        aria-labelledby="order-items-tab">
                                        <?php if (isset($items) && !empty($items)): ?>
                                            <?php foreach ($items as $index => $item): ?>
                                                <div class="row align-items-center mb-3 p-2 p-md-3 border rounded flex-wrap">
                                                    <!-- Product Image -->
                                                    <div class="col-12 col-sm-auto mb-2 mb-sm-0 d-flex justify-content-center justify-content-sm-start">
                                                        <div class="avatar avatar-lg" style="
                                                                      width: clamp(60px, 12vw, 100px);
                                                                      height: clamp(60px, 12vw, 100px);
                                                                      background-image: url('<?= $item['product_image'] ?>');
                                                                      background-size: cover;
                                                                      background-position: center;
                                                                      border-radius: 0.5rem;
                                                                  ">
                                                        </div>
                                                    </div>

                                                    <!-- Product Info -->
                                                    <div class="col-12 col-sm flex-grow-1 mb-2 mb-sm-0">
                                                        <div class="fw-bold text-truncate" style="max-width:100%">
                                                            <?= $item['pname'] ?></div>
                                                        <div class="text-muted small text-truncate" style="max-width:100%">
                                                            <?php if (!empty($item['product_variant_id'])): ?>
                                                                SKU: <?= $item['product_variant_id'] ?>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="text-muted small">Qty: <?= $item['quantity'] ?></div>
                                                        <input type="hidden" class="product_variant_id"
                                                            value="<?= $item['product_variant_id'] ?>">
                                                        <div id="product_variant_id_<?= $item['product_variant_id'] ?>"
                                                            class="d-none">
                                                            <?= htmlspecialchars(json_encode([
                                                                'id' => $item['id'] ?? $item['order_item_id'],
                                                                'product_name' => $item['pname'],
                                                                'product_variant_id' => $item['product_variant_id'],
                                                                'quantity' => (int) $item['quantity'],
                                                                'total_quantity' => (int) $item['quantity'],
                                                                'unit_price' => (int) ($item['price'] ?? 0),
                                                                'pickup_location' => $item['pickup_location'] ?? '',
                                                                'active_status' => $item['active_status'] ?? $item['oi_active_status'] ?? '',
                                                                'delivered_quantity' => (int) ($item['delivered_quantity'] ?? 0)
                                                            ]), ENT_QUOTES, 'UTF-8') ?>
                                                        </div>
                                                    </div>

                                                    <!-- Price -->
                                                    <div class="col-12 col-sm-auto text-end text-sm-end">
                                                        <div class="fw-bold text-truncate">
                                                            <?= $settings['currency'] ?? '$' ?>
                                                            <?= number_format($item['price'] * $item['quantity'], 2) ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="text-muted">No items found.</div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Update Status Section -->
                                    <div class="d-flex justify-content-center align-items-center mb-2">
                                        <h5 class="text-middle-line"><span>Update Status</span></h5>
                                    </div>

                                    <input type="hidden" name="total_amount" id="total_amount"
                                        value="<?= $order_detls['total_payable'] ?>">
                                    <input type="hidden" name="final_amount" id="final_amount"
                                        value="<?= $order_detls['total_payable'] ?>">
                                    <input type="hidden" name="delivery_boy_otp_system" id="delivery_boy_otp_system"
                                        value="<?= $otp_system ?>">

                                    <select name="status" class="form-control consignment_status mb-3">
                                        <option value=''>Select Status</option>
                                        <option value="received" <?= $item['active_status'] == 'received' ? "selected" : "" ?>>Received</option>
                                        <option value="processed" <?= $item['active_status'] == 'processed' ? "selected" : "" ?>>Processed</option>
                                        <option value="shipped" <?= $item['active_status'] == 'shipped' ? "selected" : "" ?>>Shipped</option>
                                        <option value="delivered" <?= $item['active_status'] == 'delivered' ? "selected" : "" ?>>Delivered</option>
                                    </select>

                                    <?php if ($otp_system == 1 || $otp_system == '1') { ?>
                                        <div id="otp-field-container" class="d-none">
                                            <input type="number" name="otp" id="otp" class="form-control my-2"
                                                placeholder="Enter OTP Here">
                                        </div>
                                    <?php } ?>

                                    <div class="d-flex justify-content-end align-items-center mt-2">
                                        <button type="button" class="btn btn-primary update_status_delivery_boy"
                                            data-id='<?= $order_detls['consignment_id'] ?>'
                                            data-otp-system='<?= $otp_system != 0 ? '1' : '0' ?>'>
                                            Submit
                                        </button>
                                    </div>

                                    <?php
                                    $total = $order_detls['total_payable'];
                                    if (!empty($order_detls['discount']) && $order_detls['discount'] > 0) {
                                        $discount = $order_detls['total_payable'] * ($order_detls['discount'] / 100);
                                        $total = round($order_detls['total_payable'] - $discount, 2);
                                    }
                                    ?>

                                    <?php if ($order_detls['payment_method'] == "COD" && $order_detls['is_cod_collected'] == 1) { ?>
                                        <p class="m-0 mt-2 fw-bold h5 text-success">Cash Collected</p>
                                    <?php } elseif ($order_detls['payment_method'] != "COD") { ?>
                                        <p class="m-0 mt-2 fw-bold h5 text-success">Payment Online Done</p>
                                    <?php } elseif ($order_detls['payment_method'] == "COD" && $order_detls['is_cod_collected'] == 0) { ?>
                                        <p class="m-0 mt-2 fw-bold h5">
                                            Cash On Delivery. Collect
                                            <span class="text-middle-line">
                                                <?= $settings['currency'] . intval($total) ?>
                                            </span>
                                        </p>
                                    <?php } ?>
                                </div>

                            </div>
                        </div>

                        <!-- End Tabs -->


                        <!-- Order Status Section -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Order Status</h3>
                            </div>
                            <div class="card-body order_timeline_card">
                                <div class="timeline">
                                    <?php
                                    // Define full order status progression (ordered)
                                    $status_progression = [
                                        'awaiting',
                                        'received',
                                        'processed',
                                        'shipped',
                                        'delivered',
                                        'return_request_pending',
                                        'return_request_approved',
                                        'return_picked_up',
                                        'cancelled',
                                        'returned'
                                    ];

                                    // Parse order_status array to get completed statuses with timestamps
                                    $completed_statuses = [];
                                    if (isset($order_detls[0]['status']) && !empty($order_detls[0]['status'])) {

                                        $order_status_data = $order_detls[0]['status'];
                                        if (is_array($order_status_data)) {
                                            foreach ($order_status_data as $status_entry) {
                                                if (is_array($status_entry) && count($status_entry) >= 2) {
                                                    $completed_statuses[$status_entry[0]] = $status_entry[1];
                                                }
                                            }
                                        }
                                    }


                                    // Check if there are any return-related statuses
                                    $return_statuses = ['return_request_pending', 'return_request_approved', 'return_picked_up', 'returned', 'cancelled'];
                                    $has_return_status = false;
                                    foreach ($return_statuses as $return_status) {
                                        if (isset($completed_statuses[$return_status])) {
                                            $has_return_status = true;
                                            break;
                                        }
                                    }

                                    // Filter status progression based on return status
                                    if (!$has_return_status) {
                                        // If no return status, show only up to delivered (exclude return statuses)
                                        $status_progression = array_filter($status_progression, function ($status) {
                                            return !in_array($status, ['return_request_pending', 'return_request_approved', 'return_picked_up', 'returned', 'cancelled']);
                                        });
                                    }

                                    // Always show "Order Placed" as completed
                                    ?>
                                    <div class="timeline-item">
                                        <div class="timeline-marker bg-success"></div>
                                        <div class="timeline-content">
                                            <div class="fw-bold">Order Placed</div>
                                            <div class="text-muted small">
                                                <?= isset($order_detls[0]['created_date']) ? date('F j, Y \\a\\t g:i A', strtotime($order_detls[0]['created_date'])) : '' ?>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    // Determine last completed status index
                                    $last_completed_index = -1;
                                    foreach ($status_progression as $idx => $st) {
                                        if (isset($completed_statuses[$st])) {
                                            $last_completed_index = $idx;
                                        }
                                    }

                                    // Human-friendly labels
                                    $labels = [
                                        'awaiting' => 'Awaiting',
                                        'received' => 'Received',
                                        'processed' => 'Processed',
                                        'shipped' => 'Shipped',
                                        'delivered' => 'Delivered',
                                        'return_request_pending' => 'Return Request Pending',
                                        'return_request_approved' => 'Return Request Approved',
                                        'return_picked_up' => 'Return Picked Up',
                                        'cancelled' => 'Cancelled',
                                        'returned' => 'Returned',
                                    ];


                                    // Render each status in order
                                    foreach ($status_progression as $idx => $status) {
                                        $is_completed = $idx <= $last_completed_index;
                                        $marker_class = $is_completed ? 'bg-success' : 'bg-secondary';
                                        $status_text = isset($completed_statuses[$status])
                                            ? date('F j, Y \\a\\t g:i A', strtotime($completed_statuses[$status]))
                                            : 'Pending';
                                        $status_label = isset($labels[$status]) ? $labels[$status] : ucfirst(str_replace('_', ' ', $status));
                                        ?>
                                        <div class="timeline-item">
                                            <div class="timeline-marker <?= $marker_class ?>"></div>
                                            <div class="timeline-content">
                                                <div class="fw-bold"><?= $status_label ?></div>
                                                <div class="text-muted small"><?= $status_text ?></div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- Right Column -->
                    <div class="col-lg-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h3 class="card-title">Customer Details</h3>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar avatar-md me-3"
                                        style="background-image: url('<?= isset($order_detls[0]['user_profile']) && !empty($order_detls[0]['user_profile']) ? base_url($order_detls[0]['user_profile']) : base_url('assets/no-user-img.png') ?>')">
                                    </div>
                                    <div>
                                        <div class="fw-bold">
                                            <?= isset($order_detls[0]['username']) ? $order_detls[0]['username'] : 'N/A' ?>
                                        </div>
                                        <div class="text-muted small">Customer</div>
                                    </div>
                                </div>
                                <?php if (isset($order_detls[0]['user_id']) && !empty($order_detls[0]['user_id'])): ?>
                                    <div class="align-items-center d-flex justify-content-between mb-2">
                                        <div class="text-muted small">Customer ID</div>
                                        <div><?= $order_detls[0]['user_id'] ?></div>
                                    </div>
                                <?php endif; ?>
                                <div class="align-items-center d-flex justify-content-between mb-2">
                                    <div class="text-muted small">Email</div>
                                    <div>
                                        <a href="mailto:<?= isset($order_detls[0]['email']) ? $order_detls[0]['email'] : '' ?>"
                                            class="text-decoration-none">
                                            <?= isset($order_detls[0]['email']) ? $order_detls[0]['email'] : 'N/A' ?>
                                        </a>
                                    </div>
                                </div>
                                <div class="align-items-center d-flex justify-content-between mb-2">
                                    <div class="text-muted small">Phone</div>
                                    <div>
                                        <a href="tel:<?= isset($order_detls[0]['mobile']) ? $order_detls[0]['mobile'] : '' ?>"
                                            class="text-decoration-none">
                                            <?= isset($order_detls[0]['mobile']) ? $order_detls[0]['mobile'] : 'N/A' ?>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>



                        <!-- Shipping Address -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h3 class="card-title">Shipping Address</h3>
                            </div>
                            <div class="card-body">
                                <div class="fw-bold">
                                    <?= isset($order_detls[0]['username']) ? $order_detls[0]['username'] : '' ?>
                                </div>
                                <div class="text-muted">
                                    <?= isset($order_detls[0]['user_address']) ? $order_detls[0]['user_address'] : '' ?>
                                </div>
                                <?php if ($order_detls[0]['is_pos_order'] == 1) { ?>
                                    <div class="text-muted small mt-2">Standard Shipping (5-7 business days)</div>
                                <?php } else { ?>
                                    <div class="text-muted small mt-2">
                                        <?= isset($order_detls[0]['delivery_date']) && !empty($order_detls[0]['delivery_date']) ? date('d-M-Y', strtotime($order_detls[0]['delivery_date'])) . " - " . $order_detls[0]['delivery_time'] : "Anytime" ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h3 class="card-title">Payment Method</h3>
                            </div>
                            <div class="card-body">
                                <?php
                                // Get payment method from order details
                                $payment_method = isset($order_detls[0]['payment_method']) ? strtolower($order_detls[0]['payment_method']) : 'cash_on_delivery';

                                // Define payment gateway images mapping
                                $payment_gateway_images = [
                                    'paypal' => 'assets/admin/images/payments/paypal.png',
                                    'stripe' => 'assets/admin/images/payments/stripe.png',
                                    'razorpay' => 'assets/admin/images/payments/razorpay.png',
                                    'paystack' => 'assets/admin/images/payments/paystack.png',
                                    'flutterwave' => 'assets/admin/images/payments/flutterwave.png',
                                    'paytm' => 'assets/admin/images/payments/paytm.png',
                                    'phonepe' => 'assets/admin/images/payments/phonepe.jpg',
                                    'midtrans' => 'assets/admin/images/payments/midtrans.jpg',
                                    'my_fatoorah' => 'assets/admin/images/payments/myfatoorah.jpg',
                                    'instamojo' => 'assets/admin/images/payments/instamojo.jpg',
                                    'bank_transfer' => 'assets/admin/images/payments/bank_transfer.png',
                                    'cash_on_delivery' => 'assets/admin/images/payments/cod.png',
                                    'cod' => 'assets/admin/images/payments/cod.png',
                                    'wallet' => 'assets/admin/images/wallet.png'
                                ];

                                // Get the appropriate image path
                                $payment_image = isset($payment_gateway_images[$payment_method])
                                    ? base_url($payment_gateway_images[$payment_method])
                                    : base_url('assets/admin/images/credit-card.png'); // fallback image
                                
                                // Define human-readable payment method names
                                $payment_method_names = [
                                    'paypal' => 'PayPal',
                                    'stripe' => 'Stripe',
                                    'razorpay' => 'Razorpay',
                                    'paystack' => 'Paystack',
                                    'flutterwave' => 'Flutterwave',
                                    'paytm' => 'Paytm',
                                    'phonepe' => 'PhonePe',
                                    'midtrans' => 'Midtrans',
                                    'my_fatoorah' => 'My Fatoorah',
                                    'instamojo' => 'Instamojo',
                                    'bank_transfer' => 'Bank Transfer',
                                    'cash_on_delivery' => 'Cash on Delivery',
                                    'cod' => 'Cash on Delivery',
                                    'wallet' => 'Wallet'
                                ];

                                $payment_display_name = isset($payment_method_names[$payment_method])
                                    ? $payment_method_names[$payment_method]
                                    : ucwords(str_replace('_', ' ', $payment_method));
                                ?>

                                <div class="d-flex align-items-center mb-2">
                                    <div class="avatar avatar-sm me-2"
                                        style="background-image: url('<?= $payment_image ?>')">
                                    </div>
                                    <div>
                                        <div class="fw-bold"><?= $payment_display_name ?></div>
                                        <?php if (in_array($payment_method, ['paypal', 'stripe', 'razorpay', 'paystack', 'flutterwave', 'paytm', 'phonepe', 'midtrans', 'my_fatoorah', 'instamojo'])): ?>
                                            <div class="text-muted small">Online Payment</div>
                                        <?php elseif (in_array($payment_method, ['bank_transfer'])): ?>
                                            <div class="text-muted small">Bank Transfer</div>
                                        <?php elseif (in_array($payment_method, ['cash_on_delivery', 'cod'])): ?>
                                            <div class="text-muted small">Pay on Delivery</div>
                                        <?php elseif ($payment_method == 'wallet'): ?>
                                            <div class="text-muted small">Wallet Balance</div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <?php if (in_array($payment_method, ['cash_on_delivery', 'cod', 'bank_transfer', 'wallet'])): ?>
                                    <div class="text-muted small">Payment completed on delivery</div>
                                <?php else: ?>
                                    <div class="text-muted small">Payment completed online</div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <!-- Order Summary -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h3 class="card-title">Order Summary</h3>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col">Subtotal</div>
                                    <div class="col-auto">
                                        <?= isset($settings['currency']) ? $settings['currency'] : '$' ?><?= isset($order_detls[0]['total']) ? number_format($order_detls[0]['total'], 2) : '' ?>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">Shipping</div>
                                    <div class="col-auto">
                                        <?= isset($settings['currency']) ? $settings['currency'] : '$' ?><?= isset($order_detls[0]['delivery_charge']) ? number_format($order_detls[0]['delivery_charge'], 2) : '8.99' ?>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">Tax</div>
                                    <div class="col-auto">
                                        <?= isset($settings['currency']) ? $settings['currency'] : '$' ?><?php echo round($tax_amount, 2); ?>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">Discount</div>
                                    <div class="col-auto text-success">
                                        -<?= isset($settings['currency']) ? $settings['currency'] : '$' ?><?= isset($order_detls[0]['promo_discount']) ? number_format($order_detls[0]['promo_discount'], 2) : '12.50' ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col fw-bold">Total</div>
                                    <div class="col-auto fw-bold">
                                        <?= isset($settings['currency']) ? $settings['currency'] : '$' ?><?= isset($order_detls[0]['final_total']) ? number_format($order_detls[0]['final_total'], 2) : '132.14' ?>
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






<script>


    // Status update functionality
    function updateOrderStatus(status) {
        // Implement status update logic
        console.log('Updating order status to:', status);
    }
</script>