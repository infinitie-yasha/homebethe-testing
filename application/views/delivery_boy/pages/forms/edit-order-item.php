<div class="page-wrapper">
    <?php
    // echo "<pre>";
    // print_r($order_detls);
    ?>
    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">Manage Order</h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="d-flex">
                            <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('delivery_boy/home') ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('delivery_boy/orders') ?>">Orders</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">Order Details</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE HEADER -->



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
                                            <?= isset($order_detls[0]['date_added']) ? date('F j, Y', strtotime($order_detls[0]['date_added'])) : 'March 15, 2024' ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <?php
                                $status = isset($order_detls[0]['oi_active_status']) ? $order_detls[0]['oi_active_status'] : 'processing';
                                $status_class = '';
                                switch ($status) {
                                    case 'awaiting':
                                        $status_class = 'bg-secondary-lt';
                                        break;
                                    case 'received':
                                        $status_class = 'bg-primary-lt';
                                        break;
                                    case 'processed':
                                        $status_class = 'bg-info-lt';
                                        break;
                                    case 'shipped':
                                        $status_class = 'bg-warning-lt';
                                        break;
                                    case 'delivered':
                                        $status_class = 'bg-success-lt';
                                        break;
                                    case 'cancelled':
                                        $status_class = 'bg-danger-lt';
                                        break;
                                    case 'returned':
                                        $status_class = 'bg-danger-lt';
                                        break;
                                    default:
                                        $status_class = 'bg-secondary-lt';
                                }
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
                                <ul class="nav nav-pills" id="orderTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="order-items-tab" data-bs-toggle="tab"
                                            data-bs-target="#order-items" type="button" role="tab"
                                            aria-controls="order-items" aria-selected="true">
                                            <i class="ti ti-box me-1"></i> Order Items
                                        </button>
                                    </li>

                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="orderTabsContent">
                                    <!-- Order Items Pane -->
                                    <div class="tab-pane fade show active" id="order-items" role="tabpanel"
                                        aria-labelledby="order-items-tab">
                                        <?php if (isset($items) && !empty($items)): ?>
                                            <?php foreach ($items as $index => $item): ?>
                                                <div class="row align-items-center mb-3 p-3 border rounded">
                                                    <div class="col-12 col-sm-auto mb-2 mb-sm-0 d-flex justify-content-center justify-content-sm-start">
                                                        <div class="avatar avatar-lg"
                                                            style="background-image: url('<?= $item['product_image'] ?>')">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm flex-grow-1 mb-2 mb-sm-0">
                                                        <div class="fw-bold"><?= $item['pname'] ?></div>
                                                        <div class="text-muted small">
                                                            <?php if (isset($item['product_variant_id']) && !empty($item['product_variant_id'])): ?>
                                                                SKU: <?= $item['product_variant_id'] ?>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="text-muted small">Qty: <?= $item['quantity'] ?></div>
                                                        <?php
                                                        $parcel_item_payload = [
                                                            'id' => isset($item['id']) ? $item['id'] : (isset($item['order_item_id']) ? $item['order_item_id'] : ''),
                                                            'product_name' => $item['pname'],
                                                            'product_variant_id' => $item['product_variant_id'],
                                                            'quantity' => (int) $item['quantity'],
                                                            'total_quantity' => (int) $item['quantity'],
                                                            'unit_price' => isset($item['price']) ? (int) $item['price'] : 0,
                                                            'pickup_location' => isset($item['pickup_location']) ? $item['pickup_location'] : '',
                                                            'active_status' => isset($item['active_status']) ? $item['active_status'] : (isset($item['oi_active_status']) ? $item['oi_active_status'] : ''),
                                                            'delivered_quantity' => isset($item['delivered_quantity']) ? (int) $item['delivered_quantity'] : 0,
                                                        ];
                                                        ?>
                                                        <input type="hidden" class="product_variant_id"
                                                            value="<?= $item['product_variant_id'] ?>">
                                                        <div id="product_variant_id_<?= $item['product_variant_id'] ?>"
                                                            class="d-none">
                                                            <?=
                                                                htmlspecialchars(json_encode($parcel_item_payload), ENT_QUOTES, 'UTF-8')
                                                                ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="col-12 col-sm-auto text-end text-sm-end">
                                                            <?= isset($settings['currency']) ? $settings['currency'] : '$' ?>
                                                            <?= number_format($item['price'] * $item['quantity'], 2) ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="text-muted">No items found.</div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="d-flex justify-content-center align-items-center">
                                        <h5 class="text-middle-line" type="button"><span>Update Status</span></h5>
                                    </div>
                                    <select name="status" class="form-control order_item_status mb-3"
                                        <?= isset($order_detls[0]['oi_active_status']) && !empty($order_detls[0]['oi_active_status']) && $order_detls[0]['oi_active_status'] == 'returned' ? 'disabled' : '' ?>>
                                        <option value=''>Select Status</option>
                                        <option value="return_pickedup" <?= $item['active_status'] == 'return_pickedup' ? "selected" : "" ?>>Return pickedup</option>
                                    </select>

                                    <div class="d-flex justify-content-end align-items-center">
                                        <button type="button" class="btn btn-primary update_return_status_delivery_boy"
                                            data-id='<?= $order_detls['order_item_id'] ?>'>Submit</button>
                                    </div>
                                    <?php
                                    if (isset($order_detls['discount']) && $order_detls['discount'] > 0) {
                                        $discount = $order_detls['total_payable'] * ($order_detls['discount'] / 100);
                                        $total = round($order_detls['total_payable'] - $discount, 2);
                                    } ?>


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
                                        'return_pickedup',
                                        'cancelled',
                                        'returned'
                                    ];

                                    // Parse order_status array to get completed statuses with timestamps
                                    $completed_statuses = [];
                                    if (isset($order_detls[0]['order_status']) && !empty($order_detls[0]['order_status'])) {
                                        $order_status_data = json_decode($order_detls[0]['order_status'], true);
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
                                                <?= isset($order_detls[0]['date_added']) ? date('F j, Y \\a\\t g:i A', strtotime($order_detls[0]['date_added'])) : 'March 15, 2024 at 2:30 PM' ?>
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
                                        'return_pickedup' => 'Return Picked Up',
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
                                            <?= isset($order_detls[0]['uname']) ? $order_detls[0]['uname'] : 'N/A' ?>
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
                                    <?= isset($order_detls[0]['user_name']) ? $order_detls[0]['user_name'] : 'John Doe' ?>
                                </div>
                                <div class="text-muted">
                                    <?= isset($order_detls[0]['address']) ? $order_detls[0]['address'] : '123 Main Street, Apartment 4B, New York, NY 10001, United States' ?>
                                </div>
                                <?php if ($order_detls[0]['is_pos_order'] == 1) { ?>
                                    <div class="text-muted small mt-2">Standard Shipping (5-7 business days)</div>
                                <?php } else { ?>
                                    <div class="text-muted small mt-2">
                                        <?= isset($order_detls[0]['delivery_date']) ? date('d-M-Y', strtotime($order_detls[0]['delivery_date'])) . " - " . $order_detls[0]['delivery_time'] : "Anytime" ?>
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
                                        <?= isset($settings['currency']) ? $settings['currency'] : '$' ?><?= isset($order_detls[0]['order_total']) ? number_format($order_detls[0]['order_total'] - ($order_detls[0]['delivery_charge'] ?? 0), 2) : '124.96' ?>
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



<style>
    .timeline {
        position: relative;
        padding-left: 2rem;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 0.5rem;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .timeline-marker {
        position: absolute;
        left: -1.75rem;
        top: 0.25rem;
        width: 0.75rem;
        height: 0.75rem;
        border-radius: 50%;
        border: 2px solid #fff;
        box-shadow: 0 0 0 2px #e9ecef;
    }

    .timeline-content {
        padding-left: 0.5rem;
    }

    .avatar {
        width: 3rem;
        height: 3rem;
        border-radius: 0.5rem;
        background-size: cover;
        background-position: center;
    }

    .avatar-lg {
        width: 4rem;
        height: 4rem;
    }

    .avatar-sm {
        width: 2rem;
        height: 2rem;
    }

    @media (max-width: 768px) {
        .timeline {
            padding-left: 1.5rem;
        }

        .timeline-marker {
            left: -1.25rem;
            width: 0.5rem;
            height: 0.5rem;
        }

        .avatar-lg {
            width: 3rem;
            height: 3rem;
        }
    }
</style>







<script>


    // Status update functionality
    function updateOrderStatus(status) {
        // Implement status update logic
        console.log('Updating order status to:', status);
    }
</script>