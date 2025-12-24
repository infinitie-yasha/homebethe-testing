<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-fluid">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">Manage Order</h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="d-flex">
                            <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('seller/home') ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('seller/orders') ?>">Orders</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">Order Detail</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE HEADER -->

        <div class="page-body">
            <div class="container-fluid">
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
                        <!-- Tabs: Order Items | Return Requests | Parcels -->
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
                                    <?php if ($order_detls[0]['is_pos_order'] == 0) { ?>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="parcels-tab" data-bs-toggle="tab"
                                                data-bs-target="#parcels" type="button" role="tab" aria-controls="parcels"
                                                aria-selected="false">
                                                <i class="ti ti-truck me-1"></i> Parcels
                                            </button>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="orderTabsContent">
                                    <!-- Order Items Pane -->
                                    <div class="tab-pane fade show active" id="order-items" role="tabpanel"
                                        aria-labelledby="order-items-tab">
                                        <?php if (isset($items) && !empty($items)): ?>
                                            <?php foreach ($items as $index => $item):
                                                $attachments = json_decode($item['attachment'], true);
                                                $order_attachment = '';

                                                if (!empty($attachments) && isset($attachments[$item['product_variant_id']])) {
                                                    foreach ($attachments[$item['product_variant_id']] as $url) {
                                                        $file_name = basename($url);  // Get the file name from the URL
                                                        $order_attachment .= '<a href="' . base_url($url) . '" target="_blank" class="attachment-link">
                                                            ' . htmlspecialchars($file_name) . ' (Attachment)
                                                        </a><br>';
                                                    }
                                                } else {
                                                    // No attachment → show default message
                                                    $order_attachment = 'No attachment available';
                                                }
                                                ?>
                                                <div class="row align-items-center mb-3 p-3 border rounded">
                                                    <div class="col-auto">
                                                        <div class="avatar avatar-lg"
                                                            style="background-image: url('<?= base_url($item['product_image']) ?>')">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="fw-bold"><?= $item['pname'] ?></div>
                                                        <div class="text-muted small">
                                                            <?php if (isset($item['product_variant_id']) && !empty($item['product_variant_id'])): ?>
                                                                SKU: <?= $item['product_variant_id'] ?>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="text-muted small">Qty: <?= $item['quantity'] ?></div>
                                                         <!--  ATTACHMENTS -->
                                                        <?php if (!empty($order_attachment)): ?>
                                                            <div class="mt-2">
                                                                <label class="text-muted small">Attachments:</label><br>
                                                                <?= $order_attachment ?>
                                                            </div>
                                                        <?php endif; ?>
                                                        <!--  END ATTACHMENTS -->
                                                        <?php
                                                        // Get pickup location name from ID
                                                        $pickup_location_name = '';
                                                        if (!empty($item['pickup_location']) && !empty($pickup_locations)) {
                                                            foreach ($pickup_locations as $loc) {
                                                                if ($loc['id'] == $item['pickup_location']) {
                                                                    $pickup_location_name = $loc['pickup_location'];
                                                                    break;
                                                                }
                                                            }
                                                        }

                                                        $parcel_item_payload = [
                                                            'id' => isset($item['id']) ? $item['id'] : (isset($item['order_item_id']) ? $item['order_item_id'] : ''),
                                                            'product_name' => $item['pname'],
                                                            'product_variant_id' => $item['product_variant_id'],
                                                            'quantity' => (int) $item['quantity'],
                                                            'total_quantity' => (int) $item['quantity'],
                                                            'unit_price' => isset($item['price']) ? (int) $item['price'] : 0,
                                                            'pickup_location' => isset($item['pickup_location']) ? $item['pickup_location'] : '',
                                                            'pickup_location_name' => $pickup_location_name,
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
                                                        <div class="fw-bold text-end">
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



                                    <!-- Parcels Pane (only for non-digital products) -->
                                    <div class="tab-pane fade" id="parcels" role="tabpanel" aria-labelledby="parcels-tab-tab">
                                        <?php if (isset($items[0]['product_type']) && $items[0]['product_type'] != 'digital_product') { ?>

                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h4 class="mb-0"><i class="ti ti-package"></i> Parcels</h4>
                                                <button type="button"
                                                    class="btn btn-primary btn-sm"
                                                    id="create_parcel_btn"
                                                    data-bs-toggle="offcanvas"
                                                    data-bs-target="#create_consignment_offcanvas"
                                                    aria-controls="addParcelOffcanvas">

                                                    <i class="ti ti-plus"></i> Create Parcel
                                                </button>
                                            </div>

                                            <table class='table-striped' id="consignment_table" data-toggle="table"
                                                data-url="<?= base_url('seller/orders/consignment_view?order_id=' . (isset($order_detls[0]['id']) ? $order_detls[0]['id'] : 0)) ?>"
                                                data-click-to-select="true" data-side-pagination="server"
                                                data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]"
                                                data-search="true" data-show-columns="true" data-show-refresh="true"
                                                data-trim-on-search="false" data-sort-name="o.id" data-sort-order="desc"
                                                data-mobile-responsive="true" data-toolbar="" data-show-export="true"
                                                data-maintain-selected="true" data-export-types='["txt","excel","csv"]'
                                                data-export-options='{"fileName": "orders-list","ignoreColumn": ["state"] }'
                                                data-query-params="consignment_query_params">
                                                <thead>
                                                    <tr>
                                                        <th data-field="id" data-sortable='true' data-footer-formatter="totalFormatter">ID</th>
                                                        <th data-field="order_id" data-sortable='false'>Order ID</th>
                                                        <th data-field="name" data-sortable='false'>Name</th>
                                                        <th data-field="status" data-sortable='false'>Status</th>
                                                        <th data-field="created_date" data-sortable='false'>Created Date</th>
                                                        <th data-field="operate" data-sortable="false">Action</th>
                                                    </tr>
                                                </thead>
                                            </table>

                                        <?php } else { ?>
                                            <div class="text-muted">Parcels are not applicable for digital products.</div>
                                        <?php } ?>
                                    </div>

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
                                        <?= isset($settings['currency']) ? $settings['currency'] : '$' ?>
                                        <?php
                                        echo $order_detls[0]['order_total'];
                                        $total = $order_detls[0]['order_total'];
                                        ?>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">Shipping</div>
                                    <div class="col-auto">
                                        <?= isset($settings['currency']) ? $settings['currency'] : '$' ?>
                                        <?php echo $order_detls[0]['delivery_charge'];
                                        $total = $total + $order_detls[0]['delivery_charge']; ?>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">Tax
                                        <small>
                                            <?= $is_prices_inclusive_tax = ($order_detls[0]['is_prices_inclusive_tax'] == 1) ? '(included in price)' : '(not included in price)'; ?></small>
                                    </div>
                                    <div class="col-auto">
                                        <?= isset($settings['currency']) ? $settings['currency'] : '$' ?><?php echo $tax_amount;
                                                                                                            ?>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">Wallet Balance</div>
                                    <div class="col-auto">
                                        <?= isset($settings['currency']) ? $settings['currency'] : '$' ?>
                                        <?php echo $order_detls[0]['wallet_balance'];
                                        $total = $total - $order_detls[0]['wallet_balance']; ?>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">Promo Code Discount</div>
                                    <div class="col-auto text-success">
                                        -<?= isset($settings['currency']) ? $settings['currency'] : '$' ?>
                                        <?php echo $order_detls[0]['promo_discount'];
                                        $total = floatval($total -
                                            $order_detls[0]['promo_discount']); ?>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col">Discount</div>
                                    <div class="col-auto text-success">
                                        -<?= isset($settings['currency']) ? $settings['currency'] : '$' ?>
                                        <?php echo $order_detls[0]['discount'];
                                        $total = floatval($total -
                                            $order_detls[0]['discount']); ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col fw-bold">Total</div>
                                    <div class="col-auto fw-bold">
                                        <?= isset($settings['currency']) ? $settings['currency'] : '$' ?><?= $total; ?>
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


<!-- Order Tracking Offcanvas -->
<div class="offcanvas offcanvas-end offcanvas-medium" tabindex="-1" id="order_tracking_offcanvas"
    aria-labelledby="orderTrackingLabel">
    <div class="offcanvas-header">
        <h2 class="offcanvas-title" id="orderTrackingLabel">Order Tracking</h2>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <form x-data="ajaxForm({
        url: base_url + 'seller/orders/update-order-tracking',
        offcanvasId: 'order_tracking_offcanvas',
        loaderText: 'Saving...'
    })" method="POST" class="form-horizontal" id="order_tracking_form"
        enctype="multipart/form-data">
        <div class="offcanvas-body">
            <input type="hidden" name="order_id" id="order_id"
                value="<?= isset($_GET["edit_id"]) ? $_GET["edit_id"] : '' ?>">
            <input type="hidden" name="order_item_id" id="order_item_id">
            <input type="hidden" name="seller_id" id="seller_id">
            <input type="hidden" name="consignment_id" id="consignment_id" class="consignment_id">

            <div class="row g-3">
                <div class="col-12">
                    <label for="courier_agency" class="col-form-label">Courier Agency</label>
                    <input type="text" class="form-control" name="courier_agency" id="courier_agency"
                        placeholder="Enter courier agency name" />
                </div>
                <div class="col-12">
                    <label for="tracking_id" class="col-form-label">Tracking ID</label>
                    <input type="text" class="form-control" name="tracking_id" id="tracking_id"
                        placeholder="Enter tracking ID" />
                </div>
                <div class="col-12">
                    <label for="url" class="col-form-label">Tracking URL</label>
                    <input type="url" class="form-control" name="url" id="url" placeholder="Enter tracking URL" />
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary" id="submit_btn">
                    <i class="ti ti-check"></i> Save
                </button>
            </div>
        </div>
    </form>
</div>








<div class="offcanvas offcanvas-end offcanvas-medium" tabindex="-1" id="trackingOffcanvas"
    aria-labelledby="trackingLabel">
    <div class="offcanvas-header">
        <h2 class="offcanvas-title" id="trackingLabel">Parcel Items</h2>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">

    </div>
</div>



<div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="create_consignment_offcanvas"
    aria-labelledby="create_consignment_label">
    <div class="offcanvas-header border-bottom bg-light">
        <h5 class="offcanvas-title fw-bold mb-0" id="create_consignment_label">
            <i class="ti ti-package me-2"></i>Create Parcel
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body py-4">
        <!-- Empty Box / Info Message -->
        <div id="empty_box_body" class="alert alert-warning d-none text-center mb-4" role="alert">
            <!-- dynamically filled -->
        </div>

        <div id="modal-body">
            <!-- Hidden Input -->
            <input type="hidden" name="is_shiprocket_order" id="is_shiprocket_order"
                value="<?= $order_detls[0]['is_shiprocket_order'] ?>">

            <!-- Parcel Title -->
            <div class="mb-4">
                <label for="consignment_title" class="form-label fw-semibold">
                    <i class="ti ti-tag me-1 text-primary"></i>Parcel Title
                </label>
                <input type="text" class="form-control form-control-lg" id="consignment_title"
                    placeholder="Enter parcel title" required>
            </div>

            <?php if ($order_detls[0]["is_shiprocket_order"] == "1") { ?>
                <!-- Pickup Location -->
                <div class="mb-4">
                    <label for="parcel_pickup_locations" class="form-label fw-semibold">
                        <i class="ti ti-map-pin me-1 text-primary"></i>Pickup Location
                    </label>
                    <select class="form-select form-select-lg" id="parcel_pickup_locations" name="parcel_pickup_locations">
                        <option value="">-- Select Pickup Location --</option>
                        <?php
                        if (!empty($pickup_locations)) {
                            foreach ($pickup_locations as $loc) {
                                echo '<option value="' . htmlspecialchars($loc['id']) . '">' . htmlspecialchars($loc['pickup_location']) . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            <?php } ?>

            <!-- Products Table -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light py-3">
                    <h6 class="card-title fw-bold mb-0">
                        <i class="ti ti-shopping-bag me-1 text-primary"></i>Products
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:5%">#</th>
                                    <th>Product Name</th>
                                    <th>Variant ID</th>
                                    <th>Order Qty</th>
                                    <th>Unit Price</th>
                                    <th style="width:10%">Select</th>
                                </tr>
                            </thead>
                            <tbody id="product_details">
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-3">
                                        Select a pickup location to load products.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="d-flex justify-content-end mt-4 gap-2">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">
                    <i class="ti ti-x me-1"></i>Cancel
                </button>
                <button type="button" class="btn btn-primary" id="ship_parcel_btn">
                    <i class="ti ti-send me-1"></i>Ship Parcel
                </button>
            </div>
        </div>
    </div>
</div>


<!-- view consignment item offcanvas -->
<div class="offcanvas offcanvas-end offcanvas-medium" tabindex="-1" id="viewConsignmentItemsOffcanvas"
    aria-labelledby="viewConsignmentItemsLabel">
    <div class="offcanvas-header">
        <h2 class="offcanvas-title" id="viewConsignmentItemsLabel">Parcel Items</h2>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div id="consignment_details" class="list-group list-group-flush mb-2 border rounded">
            <!-- JS will inject items here -->
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end offcanvas-medium" tabindex="-1" id="consignment_status_offcanvas"
    aria-labelledby="consignmentStatusLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="consignmentStatusLabel">Update Parcel Status</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">

        <h3 class="mb-4">Consignment Name : <?= $order_detls[0]['consignment_name'] ?></h3>
        <input type="hidden" name="consignment_id" id="consignment_id">
        <input type="hidden" name="delivery_boy_otp_system" id="delivery_boy_otp_system"
            value="<?= $order_detls[0]['deliveryboy_otp_setting_on'] ?>">

        <!-- Consignment items will be injected here -->
        <?php if (isset($items[0]['product_type']) && $items[0]['product_type'] != 'digital_product') { ?>
            <div class="col-md-12 mb-2">
                <lable class="badge badge-success">Select status
                    <?= get_seller_permission($seller_id, 'assign_delivery_boy') ? 'and delivery boy' : '' ?> which you want
                    to update
                </lable>
            </div>
            <div id="consignment-items-container"></div>
        <?php } ?>

        <ul class="nav nav-pills my-4 d-block" id="pills-tab" role="tablist">
            <?php if ($order_detls[0]['is_shiprocket_order'] == 0) { ?>
                <div class="d-flex justify-content-center align-items-center">
                    <h5 class="text-middle-line" type="button"><span>Local Shipping</span></h5>
                </div>
            <?php } else { ?>
                <div class="d-flex justify-content-center align-items-center">
                    <h5 class="text-middle-line" type="button"><span>Standard Shipping (Shiprocket)</span></h5>
                </div>
                <div>
                    <div>

                        <div class="collapse" id="collapseTracking">
                            <div class="card card-body">
                                <div id="tracking_box_old"></div>
                            </div>
                        </div>
                    </div>
                    <div id="tracking_box" class="card p-3"></div>
                </div>
                <div class="py-2 manage_shiprocket_box d-none">
                    <p class="m-0">If the Order Status Does Not Change Automatically, Please Click the Refresh Button.</p>
                    <button class="btn btn-outline-danger cancel_shiprocket_order">Cancle Shiprocket Order</button>
                    <button class="btn btn-success refresh_shiprocket_status">Refresh</button>
                </div>
                <?php

                $pickup_location = array_values(array_unique(array_column((array) $seller_order, "pickup_location")));

                for ($j = 0; $j < count($pickup_location); $j++) {
                    $ids = "";
                    foreach ($seller_order as $row) {

                        if ($row['pickup_location'] == $pickup_location[$j]) {
                            $ids .= $row['order_item_id'] . ',';
                        }
                    }
                    $order_item_ids = explode(',', trim($ids, ','));
                    $order_tracking_data = get_shipment_id($order_item_ids[0], $order_detls[0]['order_id']);
                    $shiprocket_order = get_shiprocket_order($order_tracking_data[0]['shiprocket_order_id']);

                    foreach ($order_item_ids as $id) {
                        $active_status = fetch_details('order_items', ['id' => $id, 'seller_id' => $this->ion_auth->get_user_id()], 'active_status')[0]['active_status'];

                        if ($shiprocket_order['data']['status'] == 'PICKUP SCHEDULED' && $active_status != 'shipped') {
                            $this->Order_model->update_order(['active_status' => 'shipped'], ['id' => $id, 'seller_id' => $this->ion_auth->get_user_id()], false, 'order_items');
                            $this->Order_model->update_order(['status' => 'shipped'], ['id' => $id, 'seller_id' => $this->ion_auth->get_user_id()], true, 'order_items');
                            $type = ['type' => "customer_order_shipped"];
                            $order_status = 'shipped';
                        }
                        if ($shiprocket_order['data']['status'] == 'CANCELED' && $active_status != 'cancelled') {
                            $this->Order_model->update_order(['active_status' => 'cancelled'], ['id' => $id, 'seller_id' => $this->ion_auth->get_user_id()], false, 'order_items');
                            $this->Order_model->update_order(['status' => 'cancelled'], ['id' => $id, 'seller_id' => $this->ion_auth->get_user_id()], true, 'order_items');
                            $type = ['type' => "customer_order_cancelled"];
                            $order_status = 'cancelled';
                        }
                        if (strtolower($shiprocket_order['data']['status']) == 'delivered' && $active_status != 'delivered') {
                            $this->Order_model->update_order(['active_status' => 'delivered'], ['id' => $id, 'seller_id' => $this->ion_auth->get_user_id()], false, 'order_items');
                            $this->Order_model->update_order(['status' => 'delivered'], ['id' => $id, 'seller_id' => $this->ion_auth->get_user_id()], true, 'order_items');
                            $type = ['type' => "customer_order_delivered"];
                            $order_status = 'delivered';
                        }
                        if ($shiprocket_order['data']['status'] == 'READY TO SHIP' && $active_status != 'processed') {
                            $this->Order_model->update_order(['active_status' => 'processed'], ['id' => $id, 'seller_id' => $this->ion_auth->get_user_id()], false, 'order_items');
                            $this->Order_model->update_order(['status' => 'processed'], ['id' => $id, 'seller_id' => $this->ion_auth->get_user_id()], true, 'order_items');
                            $type = ['type' => "customer_order_processed"];
                            $order_status = 'processed';
                        }
                    }
                ?>
                    <?php if (isset($pickup_location[$j]) && !empty($pickup_location[$j]) && $pickup_location[$j] != 'NULL') {
                    ?>

                        <div class="row m-2 ml-6 shiprocket_field_box d-none"
                            id="<?= $order_tracking_data[0]['shipment_id'] . '_shipment_id' ?>">

                            <div class="col-md-5 col-md-5 d-flex gap-2">
                                <?php


                                if (isset($order_tracking_data[0])) {

                                ?>
                                    <?php if (isset($order_tracking_data[0]['shipment_id']) && (empty($order_tracking_data[0]['awb_code']) || $order_tracking_data[0]['awb_code'] == 'NULL') && $shiprocket_order['data']['status'] != 'CANCELED') { ?>
                                        <a href="" title="Generate AWB" class="btn btn-primary btn-sm bg-primary-lt mr-1 generate_awb" data-fromseller="1"
                                            id=<?php print_r($order_tracking_data[0]['shipment_id']); ?>>AWB</a>
                                    <?php } else { ?>
                                        <?php if (empty($order_tracking_data[0]['pickup_scheduled_date']) && ($shiprocket_order['data']['status_code'] != 4 || $shiprocket_order['data']['status'] != 'PICKUP SCHEDULED') && $shiprocket_order['data']['status'] != 'CANCELED' && $shiprocket_order['data']['status'] != 'CANCELLATION REQUESTED') { ?>
                                            <a href="" title="Send Pickup Request" class="btn btn-primary bg-primary-lt btn-sm mr-1 send_pickup_request"
                                                data-fromseller="1" name=<?php print_r($order_tracking_data[0]['shipment_id']); ?>><i
                                                    class="fas fa-shipping-fast "></i></a>
                                        <?php }
                                        if (isset($order_tracking_data[0]['is_canceled']) && $order_tracking_data[0]['is_canceled'] == 0) { ?>
                                            <a href="" title="Cancel Order" class="btn btn-primary btn-sm bg-primary-lt mr-1 cancel_shiprocket_order"
                                                data-fromseller="1" name=<?php print_r($order_tracking_data[0]['shiprocket_order_id']); ?>><i
                                                    class="ti ti-cancel fs-3"></i> Cancle Shiprocket Order  </a>
                                        <?php } ?>

                                        <?php if (isset($order_tracking_data[0]['label_url']) && !empty($order_tracking_data[0]['label_url'])) { ?>
                                            <a href="<?php print_r($order_tracking_data[0]['label_url']); ?>" title="Download Label"
                                                data-fromseller="1" class="btn btn-primary btn-sm bg-primary-lt mr-1 download_label"><i
                                                    class="ti ti-download fs-3"></i> Label</a>
                                        <?php } else { ?>
                                            <a href="" title="Generate Label" class="btn btn-primary btn-sm bg-primary-lt mr-1 generate_label"
                                                data-fromseller="1" name=<?php print_r($order_tracking_data[0]['shipment_id']); ?>><i
                                                    class="ti ti-tag fs-3"></i> Generate Label </a>
                                        <?php } ?>

                                        <?php if (isset($order_tracking_data[0]['invoice_url']) && !empty($order_tracking_data[0]['invoice_url'])) { ?>
                                            <a href="<?php print_r($order_tracking_data[0]['invoice_url']); ?>" data-fromseller="1"
                                                title="Download Invoice" class="btn btn-primary  btn-sm bg-primary-lt mr-1 download_invoice"><i
                                                    class="ti ti-download fs-3"></i> Invoice</a>
                                        <?php } else { ?>
                                            <a href="" title="Generate Invoice" class="btn btn-primary btn-sm bg-primary-lt mr-1 generate_invoice"
                                                data-fromseller="1" name=<?php print_r($order_tracking_data[0]['shiprocket_order_id']); ?>><i
                                                    class="fs-3 ti ti-invoice"></i> Generate Invoice </a>
                                        <?php }
                                        if (isset($order_tracking_data[0]['awb_code']) && !empty($order_tracking_data[0]['awb_code'])) { ?>
                                            <a href="https://shiprocket.co/tracking/<?php echo $order_tracking_data[0]['awb_code']; ?>"
                                                target=" _blank" title="Track Order" class="btn btn-primary action-btn btn-sm bg-primary-lt mr-1 track_order"
                                                name=<?php print_r($order_tracking_data[0]['shiprocket_order_id']); ?>>
                                                <i class="fs-3 ti ti-map-pin"></i>  Track Order  </a>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        </ul>


        <div class="tab-content" id="pills-tabContent">
            <?php if ($order_detls[0]['is_shiprocket_order'] == 0) { ?>
                <div class="">
                    <div class="mb-3 row">
                        <label class="col-3 col-form-label" for="status">Select Status
                        </label>

                        <div class="col">
                            <select name="status" class="form-control consignment_status mb-3">
                                <option value=''>Select Status</option>
                                <option value="received">Received</option>
                                <option value="processed">Processed</option>
                                <option value="shipped">Shipped</option>
                                <option value="delivered">Delivered</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-3 col-form-label" for="deliver_by">Select Delivery Boy
                        </label>

                        <div class="col">

                            <select name="deliver_by" id="deliver_by" class="form-control deliver_by mb-3">
                                <option value=''>Select Delivery Boy</option>
                                <?php foreach ($delivery_res as $row) { ?>
                                    <option value="<?= $row['id'] ?>" <?= ($order_detls[0]['delivery_boy_id'] == $row['id']) ? 'selected' : '' ?>>
                                        <?= $row['username'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row otp-field">
                        <label class="col-3 col-form-label required" for="parcel-otp">Enter user OTP</label>
                        <div class="col">
                            <input type="number" class="form-control" name="parcel-otp" id="parcel-otp" minlength="6"
                                maxlength="6" placeholder="Enter user OTP" />
                        </div>
                    </div>

                </div>
            <?php } else { ?>
                <div class="tab-pane fade show active" id="pills-standard" role="tabpanel"
                    aria-labelledby="pills-standard-tab">
                    <div class="card card-info shiprocket_order_box">

                         <form class="form-horizontal" id="shiprocket_order_parcel_form" action="" method="POST">

                            <?php
                            $total_items = count($items);
                            ?>
                            <div class="card-body pad">
                                <div class="form-group">

                                    <input type="hidden" id="order_id" name="order_id"
                                        value="<?php print_r($order_detls[0]['id']); ?>" />
                                    <input type="hidden" name="user_id" id="user_id"
                                        value="<?php echo $order_detls[0]['user_id']; ?>" />
                                    <input type="hidden" name="total_order_items" id="total_order_items"
                                        value="<?php echo $total_items; ?>" />
                                    <input type="hidden" name="shiprocket_seller_id" value="<?= $seller_id ?>" />
                                    <input type="hidden" name="fromseller" value="1" id="fromseller" />
                                    <textarea id="order_items" name="order_items[]"
                                        hidden><?= json_encode($items, JSON_FORCE_OBJECT); ?></textarea>
                                    <input type="hidden" name="order_tracking[]" id="order_tracking"
                                        value='<?= json_encode($order_tracking); ?>' />
                                    <input type="hidden" name="consignment_data[]" id="consignment_data" />
                                </div>
                                <div class="mt-1 p-2 bg-danger text-white rounded">
                                    <p><b>Note:</b> Make your pickup location associated with the order is verified from <a
                                            href="https://app.shiprocket.in/company-pickup-location?redirect_url="
                                            target="_blank" class="text-decoration-none text-white"> Shiprocket Dashboard
                                        </a> and then in <a
                                            href="<?php base_url('admin/Pickup_location/manage-pickup-locations'); ?>"
                                            target="_blank" class="text-decoration-none text-white"> admin panel </a>. If it
                                        is not verified you will not be able to generate AWB later on.</p>
                                </div>
                                <div class="form-group row mt-4">
                                    <div class="col-4">
                                        <label for="txn_amount">Pickup location</label>
                                    </div>
                                    <div class="col-8">
                                        <?php
                                        // Get pickup location name from ID
                                        $display_pickup_location = $order_detls[0]['pickup_location'];
                                        if (!empty($order_detls[0]['pickup_location']) && !empty($pickup_locations)) {
                                            foreach ($pickup_locations as $loc) {
                                                if ($loc['id'] == $order_detls[0]['pickup_location']) {
                                                    $display_pickup_location = $loc['pickup_location'];
                                                    break;
                                                }
                                            }
                                        }
                                        ?>
                                        <input type="text" class="form-control" name="pickup_location_name" id="pickup_location"
                                            placeholder="Pickup Location" value="<?= $display_pickup_location ?>"
                                            readonly />

                                        <input type="hidden" class="form-control" name="pickup_location" id="pickup_location"
                                            placeholder="Pickup Location" value="<?= $loc['id'] ?>" />

                                    </div>
                                </div>

                                <div class="form-group row mt-4">
                                    <div class="col-3">
                                        <label for="parcel_weight" class="control-label col-md-12">Weight
                                            <small>(kg)</small> <span class='text-danger text-xs'>*</span></label>
                                        <input type="number" class="form-control" name="parcel_weight"
                                            placeholder="Parcel Weight" id="parcel_weight" value="" step=".01">
                                    </div>
                                    <div class="col-3">
                                        <label for="parcel_height" class="control-label col-md-12">Height
                                            <small>(cms)</small> <span class='text-danger text-xs'>*</span></label>
                                        <input type="number" class="form-control" name="parcel_height"
                                            placeholder="Parcel Height" id="parcel_height" value="" min="1">
                                    </div>
                                    <div class="col-3">
                                        <label for="parcel_breadth" class="control-label col-md-12">Breadth
                                            <small>(cms)</small> <span class='text-danger text-xs'>*</span></label>
                                        <input type="number" class="form-control" name="parcel_breadth"
                                            placeholder="Parcel Breadth" id="parcel_breadth" value="" min="1">
                                    </div>
                                    <div class="col-3">
                                        <label for="parcel_length" class="control-label col-md-12">Length
                                            <small>(cms)</small> <span class='text-danger text-xs'>*</span></label>
                                        <input type="number" class="form-control" name="parcel_length"
                                            placeholder="Parcel Length" id="parcel_length" value="" min="1">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success create_shiprocket_parcel">Create Order</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php } ?>
        </div>

        <!-- Action -->

        <?php if ($order_detls[0]['is_shiprocket_order'] == 0) { ?>
            <div class="d-flex justify-content-end p-2 gap-2">
                <a href="javascript:void(0);" class="btn btn-primary consignment_order_status_update <?= ($order_detls[0]['oi_active_status'] == 'delivered') ? 'disabled' : '' ?>">
                    Update
                </a>
                <a href="javascript:void(0);" class="btn" data-toggle="offcanvas" data-bs-dismiss="offcanvas"
                    aria-label="Close">
                    Cancel
                </a>
            </div>
        <?php } ?>

    </div>
</div>

<script>
    // Pickup locations mapping (ID to name)
    const pickupLocationsMap = {
        <?php if (!empty($pickup_locations)) {
            $location_entries = [];
            foreach ($pickup_locations as $loc) {
                $location_entries[] = "'" . htmlspecialchars($loc['id'], ENT_QUOTES, 'UTF-8') . "': '" . htmlspecialchars($loc['pickup_location'], ENT_QUOTES, 'UTF-8') . "'";
            }
            echo implode(",\n        ", $location_entries);
        } ?>
    };

    function trackPackage() {
        // Open the tracking offcanvas
        const offcanvasElement = document.getElementById('transaction_modal');
        const bsOffcanvas = new bootstrap.Offcanvas(offcanvasElement);
        bsOffcanvas.show();
    }

    function printInvoice() {
        // Implement print invoice functionality
        window.print();
    }

    // Additional functionality for digital products
    function sendDigitalProduct(orderItemId) {
        $('#ManageOrderSendMailModal').modal('show');
    }

    // Status update functionality
    function updateOrderStatus(status) {
        // Implement status update logic
        console.log('Updating order status to:', status);
    }
</script>