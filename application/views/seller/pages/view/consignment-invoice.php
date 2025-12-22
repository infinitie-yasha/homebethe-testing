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
                                    <a href="<?= base_url('seller/home') ?>">Home</a>
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

        <?php

        $order_caharges_data = fetch_details('order_charges', ['order_id' => $order_detls[0]['order_id'], 'seller_id' => $order_detls[0]['seller_id']]);
        // echo "   <pre>";
        // print_r($seller_data);
        ?>

        <!-- Main content -->
        <div class="page-body">
            <div class="container-xl">
                <div class="card card-lg">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <p class="h3">Company</p>
                                <address>
                                    <b>Email:</b> <?= $s_user_data[0]['email'] ?><br>
                                    <b>Customer Care:</b>
                                    <?= (isset($s_user_data[0]['country_code']) && !empty($s_user_data[0]['country_code'])) ? "+" . $s_user_data[0]['country_code'] . " " . $s_user_data[0]['mobile'] : "+91 " . $s_user_data[0]['mobile'] ?><br>
                                    <b>Store Name:</b> <?= $seller_data[0]['store_name'] ?><br />
                                    <b>Address:</b> <?= $s_user_data[0]['address']; ?>
                                </address>
                            </div>
                            <div class="col-6 text-end">
                                <p class="h3">Client</p>
                                <address>
                                    <b>Name:</b>
                                    <?= ($order_detls[0]['user_name'] != "") ? $order_detls[0]['user_name'] : $order_detls[0]['uname'] ?><br />
                                    <b>Address:</b> <?= $order_detls[0]['address'] ?><br>
                                    <b>Mobile:</b>
                                    <?= ((!defined('ALLOW_MODIFICATION') && ALLOW_MODIFICATION == 0) || ($this->ion_auth->is_seller() && get_seller_permission($seller_id, 'customer_privacy') == false)) ? str_repeat("X", strlen($order_detls[0]['mobile']) - 3) . substr($order_detls[0]['mobile'], -3) : $order_detls[0]['mobile']; ?><br>
                                    <?php if (!empty($order_detls[0]['email'])): ?>
                                        <b>Email:</b>
                                        <?= ((!defined('ALLOW_MODIFICATION') && ALLOW_MODIFICATION == 0) || ($this->ion_auth->is_seller() && get_seller_permission($seller_id, 'customer_privacy') == false)) ? str_repeat("X", strlen($order_detls[0]['email']) - 3) . substr($order_detls[0]['email'], -3) : $order_detls[0]['email']; ?><br>
                                    <?php endif; ?>
                                </address>
                            </div>
                            <div class="col-12 my-5">
                                <h1>Order #<?= $order_detls[0]['id'] ?></h1>
                            </div>
                        </div>
                        <table class="table table-transparent table-responsive">
                            <thead>
                                <tr>
                                    <th>Sr No.</th>
                                    <th>Product Code</th>
                                    <th>Name</th>
                                    <th>variants</th>
                                    <th>HSN Code</th>
                                    <th>Price</th>
                                    <th>Tax (%)</th>
                                    <th>Tax Amount (
                                        <?= $settings['currency'] ?>)
                                    </th>
                                    <th>Qty</th>
                                    <th>SubTotal (
                                        <?= $settings['currency'] ?>)
                                    </th>
                                    <th class="d-none">Order Status</th>
                                </tr>
                            </thead>
                            <?php $i = 1;
                            $total = $quantity = $total_tax = $total_discount = $cal_final_total = 0;
                            foreach ($consignment_items as $row) {

                                $total_tax = 0;
                                $product_id = $row['product_id'];  // ensure $row['product_id'] contains the correct product ID
                            
                                $order_tax_ids = (isset($row['tax_ids']) && !empty($row['tax_ids'])) ? explode(',', $row['tax_ids']) : array();

                                $taxes = [];
                                foreach ($order_tax_ids as $tax_id) {
                                    $tax = getTtaxById($tax_id);
                                    if ($tax) {
                                        $taxes[] = $tax;
                                    }
                                }

                                $product_variants = get_variants_values_by_id($row['product_variant_id']);
                                $product_variants = isset($product_variants[0]['variant_values']) && !empty($product_variants[0]['variant_values']) ? str_replace(',', ' | ', $product_variants[0]['variant_values']) : '-';
                                $tax_amount = $row['price'] - ($row['price'] * (100 / (100 + floatval($row['tax_percent']))));
                                $hsn_code = ($row['hsn_code']) ? $row['hsn_code'] : '-';

                                $quantity += floatval($row['quantity']);

                                $price_without_tax = $row['price'] - $tax_amount;
                                $sub_total = floatval($row['price']) * $row['quantity'];
                                $final_sub_total += $sub_total;
                                ?>
                                <tr>
                                    <td>
                                        <?= $i ?>
                                    </td>
                                    <td>
                                        <?= $row['product_variant_id'] ?>
                                    </td>
                                    <td class="w-25 fw-bold">
                                        <?= $row['pname'] ?>
                                    </td>
                                    <td class="w-25">
                                        <?= $product_variants ?>
                                    </td>
                                    <td><?= $hsn_code ?></td>
                                    <td>
                                        <?= $settings['currency'] . ' ' . number_format($price_without_tax, 2) ?>
                                    </td>

                                    <td><?php foreach ($taxes as $tax) { ?>
                                            <div class="d-flex"><span><?= $tax['title'] ?></span>
                                                <span>-</span>
                                                <span><?= $tax['percentage'] . '%' ?> </span>
                                            </div>
                                        <?php } ?>
                                    </td>

                                    <td><?php foreach ($taxes as $tax) { ?>
                                            <div class="d-flex"><span><?= $tax['title'] ?></span>
                                                <span>-</span>
                                                <?php $total_tax += ($price_without_tax * $tax['percentage']) / 100 ?>
                                                <span><?= number_format(($price_without_tax * $tax['percentage']) / 100, 2) ?>
                                                </span>
                                            </div>
                                        <?php }
                                    ?>
                                        <div class="d-flex">
                                            <span><b><?= 'Total - ' . number_format($total_tax, 2) ?></b></span>
                                        </div>
                                    </td>
                                    <td>
                                        <?= $row['quantity'] ?>
                                        <br>
                                    </td>
                                    <td>
                                        <?= $settings['currency'] . ' ' . number_format($sub_total, 2) ?>
                                        <br>
                                    </td>
                                    <td class="d-none">
                                        <?= $row['active_status'] ?>
                                        <br>
                                    </td>
                                </tr>
                                <?php $i++;
                                $cal_final_total += ($sub_total);
                            }

                            ?>

                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td colspan="4" class="strong text-end">Total Order Price (
                                    <?= $settings['currency'] ?>)
                                </td>
                                <td class="text-end">+
                                    <?= number_format($cal_final_total, 2) ?>
                                </td>
                            </tr>
                            <?php if ($order_detls[0]['type'] != 'digital_product') { ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td colspan="4" class="strong text-end">Delivery Charge (
                                        <?= $settings['currency'] ?>)
                                    </td>
                                    <td class="text-end">+
                                        <?php
                                        if (isset($consignment_details) && !empty($consignment_details)) {
                                            $cal_final_total += $consignment_details['delivery_charge'];
                                            echo number_format($consignment_details['delivery_charge'], 2);
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr class="d-none">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td colspan="4" class="strong text-end">Tax
                                    <?= $settings['currency'] ?>
                                </td>
                                <td class="text-end">+
                                    <?php echo $total_tax; ?>
                                </td>
                            </tr>
                            <?php
                            if (isset($consignment_details['promo_code']) && $consignment_details['promo_code'] != 0) { ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td colspan="4" class="strong text-end">Promo (
                                        <?= $promo_code[0]['promo_code'] ?>) Discount (
                                        <?= floatval($promo_code[0]['promo_discount']); ?>
                                        <?= ($promo_code[0]['discount_type'] == 'percentage') ? '%' : ' '; ?> )
                                    </td>
                                    <td class="text-end">-
                                        <?php
                                        echo $consignment_details['promo_discount'];
                                        $cal_final_total = $cal_final_total - $consignment_details['promo_discount'];
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            <?php
                            if (isset($consignment_details['wallet_balance']) && $consignment_details['wallet_balance'] != 0) { ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td colspan="4" class="strong text-end">Wallet Balance
                                    </td>
                                    <td class="text-end">-
                                        <?php
                                        echo $consignment_details['wallet_balance'];
                                        $cal_final_total = $cal_final_total - $consignment_details['wallet_balance'];
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            <?php
                            if (isset($consignment_details['discount']) && $consignment_details['discount'] > 0 && $consignment_details['discount'] != NULL) { ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td colspan="4" class="strong text-end">Special Discount
                                        <?= $settings['currency'] ?>(<?= $consignment_details['discount'] ?> %)
                                    </td>
                                    <td class="text-end">-
                                        <?php echo $special_discount = round($cal_final_total * $consignment_details['discount'] / 100, 2);
                                        $cal_final_total = floatval($cal_final_total - $special_discount);
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr class="d-none">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td colspan="4" class="strong text-end">Total Payable (
                                    <?= $settings['currency'] ?>)
                                </td>
                                <td class="text-end">
                                    <?= $settings['currency'] . '  ' . number_format($cal_final_total, 2) ?>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td colspan="4" class="strong text-end">Final Total (
                                    <?= $settings['currency'] ?>)
                                </td>
                                <td class="text-end">
                                    <?= $settings['currency'] . '  ' . number_format($cal_final_total, 2); ?>
                                </td>
                            </tr>

                        </table>
                        <?php if (isset($seller_data[0]['authorized_signature']) && !empty($seller_data[0]['authorized_signature'])) { ?>
                            <div class="row m-3">
                                <div class="text-end">
                                    <p><strong>For <?= ucfirst($seller_data[0]['store_name']); ?> :</strong></p>
                                    <img src='<?= base_url($seller_data[0]['authorized_signature']) ?>'
                                        class="float-right image-box-table"><br><br>
                                    <p><strong>Authorized Signatory</strong></p>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- this row will not appear when printing -->
                        <div class="row m-3" id="section-not-to-print">
                            <div class="col-xs-12">
                                <button type='button' value='Print this page' onclick='{window.print()};'
                                    class="btn btn-default"><i class="fa fa-print"></i> Print</button>
                            </div>
                        </div>
                        <p class="text-secondary text-center mt-5">Thank you very much for doing business with us. We
                            look forward to working with you again!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content Header (Page header) -->
</div>