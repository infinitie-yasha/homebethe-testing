<div class="page-wrapper">
    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">Invoice</h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="d-flex">
                            <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/home') ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">Invoice</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE HEADER -->

        <?php $sellers = array_values(array_unique(array_column($order_detls, "seller_id"))); ?>

        <!-- BEGIN PAGE BODY -->
        <div class="page-body">
            <div class="container-xl">
                <!-- Order Summary Card -->
                <div class="card card-lg mb-4">
                    <div class="card-body">
                        <h3 class="card-title mb-4">Order Summary</h3>
                        <div class="table-responsive">
                            <table class="table table-transparent table-responsive">
                                <thead>
                                    <tr>
                                        <th class="text-center">Total Order Price (<?= $settings['currency'] ?>)</th>
                                        <?php if ($order_detls[0]['type'] != 'digital_product') { ?>
                                            <th class="text-center">Delivery Charge (<?= $settings['currency'] ?>)</th>
                                        <?php } ?>
                                        <th class="text-center">Wallet Used (<?= $settings['currency'] ?>)</th>
                                        <?php if (isset($promo_code[0]['promo_code'])) { ?>
                                            <th class="text-center">Promo (<?= $promo_code[0]['promo_code'] ?>
                                                <?= ($promo_code[0]['discount_type'] == 'percentage') ? '%' : '' ?>)
                                            </th>
                                        <?php } ?>
                                        <?php if (isset($order_detls[0]['discount']) && $order_detls[0]['discount'] > 0 && $order_detls[0]['discount'] != NULL) { ?>
                                            <th class="text-center">Special Discount (<?= $order_detls[0]['discount'] ?>%)
                                            </th>
                                        <?php } ?>
                                        <th class="text-center">Total Payable (<?= $settings['currency'] ?>)</th>
                                        <th class="text-center">Final Total (<?= $settings['currency'] ?>)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $total = $order_detls[0]['total']; ?>
                                    <tr>
                                        <td class="text-center">
                                            <?= $settings['currency'] . ' ' . number_format($order_detls[0]['total'], 2) ?>
                                        </td>
                                        <?php if ($order_detls[0]['type'] != 'digital_product') { ?>
                                            <td class="text-center">
                                                <?php
                                                $total += $order_detls[0]['delivery_charge'];
                                                echo '+ ' . $settings['currency'] . ' ' . number_format($order_detls[0]['delivery_charge'], 2);
                                                ?>
                                            </td>
                                        <?php } ?>
                                        <td class="text-center">
                                            <?php
                                            $total -= $order_detls[0]['wallet_balance'];
                                            echo '- ' . $settings['currency'] . ' ' . number_format($order_detls[0]['wallet_balance'], 2);
                                            ?>
                                        </td>
                                        <?php if (isset($promo_code[0]['promo_code'])) { ?>
                                            <td class="text-center">
                                                <?php
                                                echo '- ' . $settings['currency'] . ' ' . $order_detls[0]['promo_discount'];
                                                $total = $total - $order_detls[0]['promo_discount'];
                                                ?>
                                            </td>
                                        <?php } ?>
                                        <?php if (isset($order_detls[0]['discount']) && $order_detls[0]['discount'] > 0 && $order_detls[0]['discount'] != NULL) { ?>
                                            <td class="text-center">
                                                <?php
                                                echo '- ' . $settings['currency'] . ' ' . $special_discount = round($total * $order_detls[0]['discount'] / 100, 2);
                                                $total = floatval($total - $special_discount);
                                                ?>
                                            </td>
                                        <?php } ?>
                                        <td class="text-center strong">
                                            <?= $settings['currency'] . ' ' . number_format($total, 2) ?>
                                        </td>
                                        <td class="text-center strong">
                                            <?php $final_total = $order_detls[0]['total'] - $order_detls[0]['discount'] - $order_detls[0]['promo_discount'] + $order_detls[0]['delivery_charge']; ?>
                                            <?= $settings['currency'] . ' ' . number_format($final_total, 2) ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Seller Invoices -->

                <?php for ($i = 0; $i < count($sellers); $i++) {
                    $s_user_data = fetch_details('users', ['id' => $sellers[$i]], 'email,mobile,address,country_code,city,pincode');
                    $seller_data = fetch_details('seller_data', ['user_id' => $sellers[$i]], 'store_name,pan_number,tax_name,tax_number,authorized_signature');
                    $order_caharges_data = fetch_details('order_charges', ['order_id' => $order_detls[0]['order_id'], 'seller_id' => $sellers[$i]]);
                    ?>
                    <div class="card card-lg mb-4" id="<?= 'invoice-' . $sellers[$i] ?>">
                        <div class="card-body">
                            <!-- Invoice Number (d-print-none) -->
                            <div class="row mb-3 d-print-none">
                                <div class="col-12 text-center">
                                    <h3 class="card-title"><strong>Invoice : <?= $i + 1 ?></strong></h3>
                                </div>
                            </div>

                            <!-- Header Section -->
                            <div class="row mb-4">
                                <div class="col-6">
                                    <img src="<?= base_url() . get_settings('logo') ?>" class="invoice_logo"
                                        style="max-height: 60px;">
                                </div>
                                <div class="col-6 text-end">
                                    <p class="h4 mb-0">Mo. <?= $order_detls[0]['mobile_number'] ?></p>
                                </div>
                            </div>

                            <!-- Company and Customer Info -->
                            <div class="row mb-4">
                                <div class="col-6">
                                    <p class="h3 mb-3">Sold By</p>
                                    <address class="mb-0">
                                        <strong><?= ucfirst($seller_data[0]['store_name']); ?></strong><br>
                                        <?= str_replace('\\', '', $seller_data[0]['address']); ?><br>
                                        <?= isset($s_user_data[0]['city']) ? ucfirst($s_user_data[0]['city']) . ', ' : ''; ?>
                                        <?= $s_user_data[0]['pincode'] ?><br>
                                        <strong>Email:</strong> <?= $s_user_data[0]['email']; ?><br>
                                        <strong>Customer Care:</strong> <?= $s_user_data[0]['mobile']; ?><br>
                                        <?php if (isset($seller_data[0]['pan_number']) && !empty($seller_data[0]['pan_number'])) { ?>
                                            <strong>Pan Number:</strong> <?= $seller_data[0]['pan_number']; ?><br>
                                        <?php } ?>
                                        <strong><?= $seller_data[0]['tax_name']; ?>:</strong>
                                        <?= $seller_data[0]['tax_number']; ?><br>
                                        <?php if ($order_detls[0]['type'] != 'digital_product' && !empty($items[$i]['delivery_boy'])) { ?>
                                            <strong>Delivery By:</strong> <?= $items[$i]['delivery_boy']; ?>
                                        <?php } ?>
                                    </address>
                                </div>
                                <div class="col-6 text-end">
                                    <p class="h3 mb-3">Shipping Address</p>
                                    <address class="mb-0">
                                        <?= ($order_detls[0]['user_name'] != "") ? $order_detls[0]['user_name'] : $order_detls[0]['uname'] ?><br>
                                        <?= $order_detls[0]['address'] ?>
                                    </address>
                                    <p class="mt-3 mb-0">
                                        <strong>Order No:</strong> #<?= $order_detls[0]['id'] ?><br>
                                        <strong>Order Date:</strong> <?= $order_detls[0]['date_added'] ?>
                                    </p>
                                </div>
                            </div>

                            <!-- Product Details Table -->
                            <div class="table-responsive mb-4">
                                <table class="table table-transparent table-responsive">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 1%">Sr No.</th>
                                            <th class="text-center" style="width: 8%">Product Code</th>
                                            <th>Product Name</th>
                                            <th>Variants</th>
                                            <th class="text-center" style="width: 8%">HSN Code</th>
                                            <th class="text-end" style="width: 10%">Price</th>
                                            <th class="text-center" style="width: 8%">Tax (%)</th>
                                            <th class="text-end" style="width: 10%">Tax Amount</th>
                                            <th class="text-center" style="width: 5%">Qty</th>
                                            <th class="text-end" style="width: 10%">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $j = 1;
                                        $total = $quantity = $total_discount = $final_sub_total = 0;

                                        foreach ($items as $row) {
                                            $total_tax = 0;
                                            $product_id = $row['product_id'];
                                            $order_tax_ids = (isset($row['tax_ids']) && !empty($row['tax_ids'])) ? explode(',', $row['tax_ids']) : array();

                                            $taxes = [];
                                            foreach ($order_tax_ids as $tax_id) {
                                                $tax = getTtaxById($tax_id);
                                                if ($tax) {
                                                    $taxes[] = $tax;
                                                }
                                            }

                                            $total += floatval($row['price'] + $tax_amount) * floatval($row['quantity']);
                                            if ($sellers[$i] == $row['seller_id']) {
                                                $product_variants = get_variants_values_by_id($row['product_variant_id']);
                                                $product_variants = isset($product_variants[0]['variant_values']) && !empty($product_variants[0]['variant_values']) ? str_replace(',', ' | ', $product_variants[0]['variant_values']) : '-';
                                                $tax_amount = $row['price'] - ($row['price'] * (100 / (100 + floatval($row['tax_percent']))));
                                                $hsn_code = ($row['hsn_code']) ? $row['hsn_code'] : '-';
                                                $quantity += floatval($row['quantity']);
                                                $tax = (floatval($row['price']) * floatval($row['tax_percent'])) / 100;
                                                $price_without_tax = $row['price'] - $tax_amount;
                                                $sub_total = floatval($row['price']) * $row['quantity'];
                                                $final_sub_total += $sub_total;
                                                ?>
                                                <tr>
                                                    <td class="text-center"><?= $j ?></td>
                                                    <td class="text-center"><?= $row['product_variant_id'] ?></td>
                                                    <td>
                                                        <p class="strong mb-0"><?= $row['pname'] ?></p>
                                                    </td>
                                                    <td><?= $product_variants ?></td>
                                                    <td class="text-center"><?= $hsn_code ?></td>
                                                    <td class="text-end">
                                                        <?= $settings['currency'] . ' ' . number_format($price_without_tax, 2) ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php foreach ($taxes as $tax) { ?>
                                                            <div><?= $tax['title'] ?> - <?= $tax['percentage'] . '%' ?></div>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="text-end">
                                                        <?php foreach ($taxes as $tax) {
                                                            $tax_amt = ($price_without_tax * $tax['percentage']) / 100;
                                                            $total_tax += $tax_amt;
                                                            ?>
                                                            <div><?= $tax['title'] ?> - <?= number_format($tax_amt, 2) ?></div>
                                                        <?php } ?>
                                                        <div><strong>Total: <?= number_format($total_tax, 2) ?></strong></div>
                                                    </td>
                                                    <td class="text-center"><?= $row['quantity'] ?></td>
                                                    <td class="text-end">
                                                        <?= $settings['currency'] . ' ' . number_format($sub_total, 2) ?>
                                                    </td>
                                                </tr>
                                                <?php
                                                $j++;
                                            }
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="8" class="strong text-end">Subtotal</td>
                                            <td class="text-center strong"><?= $quantity ?></td>
                                            <td class="text-end strong">
                                                <?= $settings['currency'] . ' ' . number_format($final_sub_total, 2) ?>
                                            </td>
                                        </tr>
                                        <?php if ($order_detls[0]['type'] != 'digital_product') { ?>
                                            <tr>
                                                <td colspan="9" class="strong text-end">Delivery Charge</td>
                                                <td class="text-end">
                                                    <?php
                                                    $total += $order_caharges_data[0]['delivery_charge'];
                                                    echo '+ ' . $settings['currency'] . ' ' . number_format($order_caharges_data[0]['delivery_charge'], 2);
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        <?php if (isset($promo_code[0]['promo_code'])) { ?>
                                            <tr>
                                                <td colspan="9" class="strong text-end">
                                                    Promo (<?= $promo_code[0]['promo_code'] ?>) Discount
                                                    (<?= floatval($promo_code[0]['discount']); ?><?= ($promo_code[0]['discount_type'] == 'percentage') ? '%' : '' ?>)
                                                </td>
                                                <td class="text-end">
                                                    <?php
                                                    echo '- ' . $settings['currency'] . ' ' . number_format($order_caharges_data[0]['promo_discount'], 2);
                                                    $total = $total - $order_caharges_data[0]['promo_discount'];
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        <?php if (isset($order_detls[0]['discount']) && $order_detls[0]['discount'] > 0 && $order_detls[0]['discount'] != NULL) { ?>
                                            <tr>
                                                <td colspan="9" class="strong text-end">
                                                    Special Discount (<?= $order_detls[0]['discount'] ?>%)
                                                </td>
                                                <td class="text-end">
                                                    <?php
                                                    $special_discount = round($total * $order_detls[0]['discount'] / 100, 2);
                                                    $total = floatval($total - $special_discount);
                                                    echo '- ' . $settings['currency'] . ' ' . number_format($special_discount, 2);
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <td colspan="9" class="font-weight-bold text-uppercase text-end">Total Due</td>
                                            <td class="font-weight-bold text-end">
                                                <?php $final_total = $final_sub_total - $order_detls[0]['discount'] - $order_caharges_data[0]['promo_discount'] + $order_caharges_data[0]['delivery_charge']; ?>
                                                <?= $settings['currency'] . ' ' . number_format($final_total, 2) ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Payment Method -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <p class="text-muted"><strong>Payment Method:</strong>
                                        <?= $order_detls[0]['payment_method'] ?></p>
                                </div>
                            </div>

                            <!-- Authorized Signature -->
                            <?php if (isset($seller_data[0]['authorized_signature']) && !empty($seller_data[0]['authorized_signature'])) { ?>
                                <div class="row mt-5">
                                    <div class="col-6"></div>
                                    <div class="col-6 text-end">
                                        <p><strong>For <?= ucfirst($seller_data[0]['store_name']); ?>:</strong></p>
                                        <img src='<?= base_url($seller_data[0]['authorized_signature']) ?>'
                                            id="<?= $sellers[$i] ?>" class="mb-3" style="max-height: 80px;"><br>
                                        <p><strong>Authorized Signatory</strong></p>
                                    </div>
                                </div>
                            <?php } ?>

                            <!-- Thank You Message -->
                            <p class="text-secondary text-center mt-5">Thank you very much for doing business with us. We
                                look forward to working with you again!</p>
                        </div>
                    </div>

                    <!-- Print Button -->
                    <div class="row mt-3 mb-4 d-print-none" id="section-not-to-print">
                        <div class="col-12">
                            <button type='button' class="btn btn-primary"
                                onclick='printDiv("<?= "invoice-" . $sellers[$i] ?>")'>
                                <i class="fa fa-print"></i> Print Invoice
                            </button>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <!-- END PAGE BODY -->
    </div>
</div>