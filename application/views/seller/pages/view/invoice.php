<div class="page-wrapper">
    <!-- BEGIN PAGE HEADER -->
    <header class="page-header d-print-none" aria-label="Page header">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">Invoice</h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                        <li class="breadcrumb-item"><a href="<?= base_url('seller/home') ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="#">Invoice</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </header>
    <!-- END PAGE HEADER -->

    <section class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    <div class="card card-info" id="section-to-print">

                        <!-- LOGO + SELLER PHONE -->
                        <div class="card-body">
                            <div class="row align-items-center mb-4">
                                <div class="col-md-6 text-start">
                                    <img src="<?= base_url() . get_settings('logo') ?>" class="d-block invoice_logo"
                                        alt="Logo">
                                </div>
                                <div class="col-md-6 text-md-end text-start">
                                    <h4 class="mb-0">
                                        Mo. <?= (isset($s_user_data[0]['country_code']) && !empty($s_user_data[0]['country_code']))
                                            ? '+' . $s_user_data[0]['country_code'] . ' ' . $s_user_data[0]['mobile']
                                            : '+91 ' . $s_user_data[0]['mobile'] ?>
                                    </h4>
                                </div>
                            </div>

                            <?php $order_caharges_data = fetch_details('order_charges', ['order_id' => $order_detls[0]['order_id'], 'seller_id' => $order_detls[0]['seller_id']]); ?>

                            <!-- SOLD BY / SHIPPING ADDRESS -->
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <strong>Sold By</strong>
                                    <address class="mt-2 mb-0">
                                        <?= $settings['app_name'] ?><br>
                                        <b>Email</b> : <?= $s_user_data[0]['email'] ?><br>
                                        <b>Customer Care</b> : <?= (isset($s_user_data[0]['country_code']) && !empty($s_user_data[0]['country_code']))
                                            ? '+' . $s_user_data[0]['country_code'] . ' ' . $s_user_data[0]['mobile']
                                            : '+91 ' . $s_user_data[0]['mobile'] ?><br>
                                        <?php if (!empty($seller_data[0]['store_name'])): ?>
                                            <b>Store Name</b> : <?= $seller_data[0]['store_name'] ?><br>
                                        <?php endif; ?>
                                        <?php if (!empty($seller_data[0]['tax_name'])): ?>
                                            <b>Tax Name</b> : <?= $seller_data[0]['tax_name'] ?><br>
                                        <?php endif; ?>
                                        <?php if (!empty($seller_data[0]['tax_number'])): ?>
                                            <b>Tax Number</b> : <?= $seller_data[0]['tax_number'] ?><br>
                                        <?php endif; ?>
                                        <b>Address</b> : <?= str_replace('\\', '', $s_user_data[0]['address']) ?>
                                    </address>

                                    <?php if (!empty($seller_data[0]['pan_number'])): ?>
                                        <p class="mt-2 mb-0"><b>PAN NO.</b> : <?= $seller_data[0]['pan_number'] ?></p>
                                    <?php endif; ?>
                                    <?php if (!empty($items[0]['delivery_boy'])): ?>
                                        <strong>Delivery By:</strong> <?= $items[0]['delivery_boy'] ?><br>
                                    <?php endif; ?>
                                </div>

                                <div class="col-md-4 d-none d-md-block"></div>

                                <div class="col-md-4">
                                    <strong>Shipping Address</strong>
                                    <address class="mt-2 mb-0">
                                        <?= ($order_detls[0]['user_name'] != "") ? $order_detls[0]['user_name'] : $order_detls[0]['uname'] ?><br>
                                        <?= $order_detls[0]['address'] ?><br>
                                        <?= ((!defined('ALLOW_MODIFICATION') && ALLOW_MODIFICATION == 0) ||
                                            ($this->ion_auth->is_seller() && get_seller_permission($order_detls[0]['seller_id'], 'customer_privacy') == false))
                                            ? (!empty($order_detls[0]['mobile'])
                                                ? str_repeat('X', strlen($order_detls[0]['mobile']) - 3) . substr($order_detls[0]['mobile'], -3)
                                                : $order_detls[0]['mobile_number'])
                                            : $order_detls[0]['mobile']; ?><br>
                                        <?= ((!defined('ALLOW_MODIFICATION') && ALLOW_MODIFICATION == 0) ||
                                            ($this->ion_auth->is_seller() && get_seller_permission($order_detls[0]['seller_id'], 'customer_privacy') == false))
                                            ? str_repeat('X', strlen($order_detls[0]['email']) - 3) . substr($order_detls[0]['email'], -3)
                                            : $order_detls[0]['email']; ?><br>
                                    </address>
                                    <p class="mt-2 mb-0">
                                        <strong>Order No :</strong> #<?= $order_detls[0]['id'] ?><br>
                                        <strong>Order Date :</strong> <?= $order_detls[0]['date_added'] ?>
                                    </p>
                                </div>
                            </div>

                            <!-- PRODUCT DETAILS -->
                            <!-- PRODUCT DETAILS TABLE -->
                            <div class="mb-4">
                                <p class="h5 fw-bold mb-3">Product Details:</p>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered table-hover align-middle text-center">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-nowrap">Sr No.</th>
                                                <th class="text-nowrap">Product Code</th>
                                                <th class="text-start">Name</th>
                                                <th class="text-start">Variants</th>
                                                <th class="text-nowrap">HSN Code</th>
                                                <th class="text-nowrap">Price<br><small class="text-muted">(excl.
                                                        tax)</small></th>
                                                <th class="text-nowrap">Tax (%)</th>
                                                <th class="text-nowrap">Tax Amount<br>(<?= $settings['currency'] ?>)
                                                </th>
                                                <th class="text-nowrap">Qty</th>
                                                <th class="text-nowrap">Sub Total<br>(<?= $settings['currency'] ?>)</th>
                                                <th class="d-none">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            $total = $quantity = $cal_final_total = 0;
                                            foreach ($items as $row):
                                                $product_id = $row['product_id'];

                                                // Tax handling
                                                $order_tax_ids = !empty($row['tax_ids']) ? explode(',', $row['tax_ids']) : [];
                                                $taxes = [];
                                                foreach ($order_tax_ids as $tax_id) {
                                                    $tax = getTtaxById($tax_id);
                                                    if ($tax)
                                                        $taxes[] = $tax;
                                                }

                                                // Variants
                                                $product_variants = get_variants_values_by_id($row['product_variant_id']);
                                                $variant_display = !empty($product_variants[0]['variant_values'])
                                                    ? str_replace(',', ' | ', $product_variants[0]['variant_values'])
                                                    : '-';

                                                // Tax amount per unit
                                                $tax_amount_per_unit = $row['price'] - ($row['price'] * (100 / (100 + floatval($row['tax_percent']))));
                                                $price_excl_tax = $row['price'] - $tax_amount_per_unit;
                                                $hsn_code = $row['hsn_code'] ?? '-';

                                                // Totals
                                                $sub_total = $row['price'] * $row['quantity'];
                                                $cal_final_total += $sub_total;
                                                $quantity += $row['quantity'];
                                                ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td class="text-nowrap"><?= $row['product_variant_id'] ?></td>
                                                    <td class="text-start fw-medium"><?= htmlspecialchars($row['pname']) ?>
                                                    </td>
                                                    <td class="text-start text-muted small"><?= $variant_display ?></td>
                                                    <td><?= $hsn_code ?></td>
                                                    <td><?= $settings['currency'] . ' ' . number_format($price_excl_tax, 2) ?>
                                                    </td>

                                                    <!-- Tax % -->
                                                    <td>
                                                        <?php if (!empty($taxes)): ?>
                                                            <?php foreach ($taxes as $tax): ?>
                                                                <div class="badge bg-light text-dark me-1 mb-1">
                                                                    <?= $tax['title'] . ' ' . $tax['percentage'] ?>%
                                                                </div>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <span class="text-muted">—</span>
                                                        <?php endif; ?>
                                                    </td>

                                                    <!-- Tax Amount -->
                                                    <td>
                                                        <?php
                                                        $row_tax_total = 0;
                                                        if (!empty($taxes)):
                                                            foreach ($taxes as $tax):
                                                                $tax_amt = ($price_excl_tax * $tax['percentage']) / 100;
                                                                $row_tax_total += $tax_amt;
                                                                ?>
                                                                <div class="d-flex justify-content-between small">
                                                                    <span><?= $tax['title'] ?></span>
                                                                    <span><?= number_format($tax_amt, 2) ?></span>
                                                                </div>
                                                            <?php endforeach; ?>
                                                            <div class="border-top pt-1 fw-bold text-end">
                                                                <?= number_format($row_tax_total, 2) ?>
                                                            </div>
                                                        <?php else: ?>
                                                            <span class="text-muted">0.00</span>
                                                        <?php endif; ?>
                                                    </td>

                                                    <td><strong><?= $row['quantity'] ?></strong></td>
                                                    <td class="fw-bold">
                                                        <?= $settings['currency'] . ' ' . number_format($sub_total, 2) ?>
                                                    </td>
                                                    <td class="d-none"><?= $row['active_status'] ?></td>
                                                </tr>
                                                <?php $i++; endforeach; ?>
                                        </tbody>
                                        <tfoot class="table-secondary fw-bold">
                                            <tr>
                                                <td colspan="8" class="text-end">Total</td>
                                                <td><?= $quantity ?></td>
                                                <td><?= $settings['currency'] . ' ' . number_format($cal_final_total, 2) ?>
                                                </td>
                                                <td class="d-none"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <!-- PAYMENT & SUMMARY -->
                            <div class="row">
                                <div class="col-md-6 text-start">
                                    <strong>Payment Method :</strong> <?= $order_detls[0]['payment_method'] ?>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless table-sm">
                                        <tbody>
                                            <tr>
                                                <th class="text-end">Total Order Price (<?= $settings['currency'] ?>)
                                                </th>
                                                <td class="text-end">+ <?= number_format($cal_final_total, 2) ?></td>
                                            </tr>

                                            <?php if ($order_detls[0]['type'] != 'digital_product'): ?>
                                                <tr>
                                                    <th class="text-end">Delivery Charge (<?= $settings['currency'] ?>)</th>
                                                    <td class="text-end">
                                                        + <?php
                                                        $cal_final_total += $order_caharges_data[0]['delivery_charge'];
                                                        echo number_format($order_caharges_data[0]['delivery_charge'], 2);
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>

                                            <?php if (!empty($order_detls[0]['wallet_balance'])): ?>
                                                <tr>
                                                    <th class="text-end">Wallet Balance (<?= $settings['currency'] ?>)</th>
                                                    <td class="text-end">
                                                        - <?php
                                                        $cal_final_total -= $order_detls[0]['wallet_balance'];
                                                        echo number_format($order_detls[0]['wallet_balance'], 2);
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>

                                            <?php if (!empty($promo_code[0]['promo_code'])): ?>
                                                <tr>
                                                    <th class="text-end">
                                                        Promo (<?= $promo_code[0]['promo_code'] ?>) Discount
                                                        (<?= floatval($promo_code[0]['discount']) ?>
                                                        <?= $promo_code[0]['discount_type'] == 'percentage' ? '%' : '' ?>)
                                                    </th>
                                                    <td class="text-end">
                                                        - <?php
                                                        echo $order_caharges_data[0]['promo_discount'];
                                                        $cal_final_total -= $order_caharges_data[0]['promo_discount'];
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>

                                            <?php if (!empty($order_detls[0]['discount'])): ?>
                                                <tr>
                                                    <th class="text-end">
                                                        Special Discount (<?= $order_detls[0]['discount'] ?> %)
                                                    </th>
                                                    <td class="text-end">
                                                        - <?php
                                                        $special_discount = round($cal_final_total * $order_detls[0]['discount'] / 100, 2);
                                                        $cal_final_total = $cal_final_total - $special_discount;
                                                        echo number_format($special_discount, 2);
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>

                                            <tr class="table-active">
                                                <th class="text-end">Final Total (<?= $settings['currency'] ?>)</th>
                                                <td class="text-end fw-bold">
                                                    <?= $settings['currency'] . ' ' . number_format($cal_final_total, 2) ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- AUTHORIZED SIGNATURE -->
                            <?php if (!empty($seller_data[0]['authorized_signature'])): ?>
                                <div class="row mt-5">
                                    <div class="col-md-6"></div>
                                    <div class="col-md-6 text-md-end text-start">
                                        <p class="mb-1"><strong>For <?= ucfirst($seller_data[0]['store_name']) ?> :</strong>
                                        </p>
                                        <p class="mb-4"><strong>Authorized Signature</strong></p>
                                        <img src="<?= base_url($seller_data[0]['authorized_signature']) ?>"
                                            class="product-image float-md-end float-start" style="width:80px; height:auto;"
                                            alt="Signature">
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- PRINT BUTTON (hidden when printing) -->
                            <div class="row mt-4 d-print-none" id="section-not-to-print">
                                <div class="col-12 text-center">
                                    <button type="button" class="btn btn-outline-primary" onclick="window.print()">
                                        <i class="ti ti-printer"></i> Print
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-xl -->
    </section>
</div>