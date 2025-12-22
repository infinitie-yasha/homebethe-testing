<div class="page-wrapper">

    <!-- BEGIN PAGE HEADER -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">Affiliate</div>
                    <h2 class="page-title">Manage Products</h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="d-flex">
                        <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('admin/home') ?>">
                                    <i class="ti ti-home"></i>
                                    Home
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('affiliate/category') ?>">

                                    categories
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Products</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE HEADER -->

    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Affiliate Products</h3>
                            <div class="card-actions">
                                <?php if (!empty($products)) { ?>
                                    <span class="badge bg-primary-lt"><?= $total_products ?> Products</span>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($products)) { ?>
                                <div class="row row-cards g-4">
                                    <?php
                                    $affiliate = fetch_details('affiliates', ['user_id' => $_SESSION['user_id']], 'uuid, status');
                                    $affiliate_uuid = $affiliate[0]['uuid'];

                                    foreach ($products as $product) {
                                        $sale_percentage = find_discount_in_percentage($product['special_price'], $product['price']);

                                        $no_image_url = base_url() . NO_IMAGE;
                                        $image_path = FCPATH . $product['image'];
                                        $image_url = base_url('media/image?path=' . rawurlencode($product['image']) . '&width=610&quality=80');
                                        $final_image_url = (file_exists($image_path) && !empty($product['image'])) ? $image_url : $no_image_url;

                                        $percentage = (isset($product['tax_percentage']) && intval($product['tax_percentage']) > 0 && $product['tax_percentage'] != null) ? $product['tax_percentage'] : '0';

                                        if ((isset($product['is_prices_inclusive_tax']) && $product['is_prices_inclusive_tax'] == 0) || (!isset($product['is_prices_inclusive_tax'])) && $percentage > 0) {
                                            $product['price'] = strval(calculatePriceWithTax($percentage, $product['price']));
                                            $product['special_price'] = strval(calculatePriceWithTax($percentage, $product['special_price']));
                                        } else {
                                            $product['price'] = strval($product['price']);
                                            $product['special_price'] = strval($product['special_price']);
                                        }
                                        ?>
                                        <div class="col-sm-6 col-lg-4 col-xl-3">
                                            <div class="card card-md h-100 shadow-sm border-0 hover-shadow">
                                                <?php if ($product['special_price'] < $product['price']) { ?>
                                                    <span class="ribbon ribbon-top ribbon-bookmark bg-primary text-white">
                                                        <?= $sale_percentage ?>% OFF
                                                    </span>
                                                <?php } ?>

                                                <a href="#" class="d-block position-relative overflow-hidden"
                                                    style="border-radius: 8px 8px 0 0;">
                                                    <img src="<?= $final_image_url ?>" class="card-img-top"
                                                        alt="<?= htmlspecialchars($product['name']) ?>"
                                                        style="height: 220px; width: 100%; object-fit: contain; background: linear-gradient(180deg, #f8f9fa 0%, #e9ecef 100%); transition: transform 0.3s ease;"
                                                        onmouseover="this.style.transform='scale(1.05)'"
                                                        onmouseout="this.style.transform='scale(1)'">
                                                </a>

                                                <div class="card-body d-flex flex-column p-4">
                                                    <h3 class="card-title mb-3 text-truncate fw-bold" style="font-size: 1.1rem;"
                                                        title="<?= htmlspecialchars($product['name']) ?>">
                                                        <?= htmlspecialchars($product['name']) ?>
                                                    </h3>

                                                    <div class="mb-4">
                                                        <div class="d-flex align-items-center justify-content-start gap-2 mb-2">
                                                            <span
                                                                class="h3 mb-0 text-primary fw-bold">₹<?= number_format($product['special_price'], 2) ?></span>
                                                            <?php if ($product['special_price'] < $product['price']) { ?>
                                                                <span
                                                                    class="text-muted text-decoration-line-through fs-5">₹<?= number_format($product['price'], 2) ?></span>
                                                            <?php } ?>
                                                        </div>

                                                        

                                                        <div>
                                                            <span class="badge bg-success-lt text-success">
                                                                <i class="ti ti-coin me-1"></i>
                                                                Commission: <?= $product['affiliate_commission'] ?>%
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="mt-auto">
                                                        <button class="btn btn-primary w-100 copy-affiliate-link-btn"
                                                            data-product_id="<?= $product['product_id'] ?>"
                                                            data-user_id="<?= $affiliate_uuid ?>"
                                                            data-slug="<?= htmlspecialchars($product['slug']) ?>"
                                                            data-name="<?= htmlspecialchars($product['name']) ?>"
                                                            data-affiliate_commission="<?= $product['affiliate_commission'] ?>"
                                                            data-category_id="<?= $product['category_id'] ?>"
                                                            <?= $affiliate[0]['status'] == 7 ? 'disabled' : '' ?>>
                                                            <i class="ti ti-copy me-2"></i>
                                                            Copy Affiliate Link
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>

                                <?php if (!empty($pagination_links)) { ?>
                                    <div class="d-flex align-items-center mt-5">
                                        <div class="ms-auto">
                                            <?= $pagination_links; ?>
                                        </div>
                                    </div>
                                <?php } ?>

                            <?php } else { ?>
                                <div class="empty text-center">
                                    <div class="empty-img mb-4">
                                        <img src="./static/illustrations/undraw_shopping_app_flsj.svg" height="150"
                                            alt="No products">
                                    </div>
                                    <h3 class="empty-title fw-bold">No Products Found</h3>
                                    <p class="empty-subtitle text-muted fs-5">
                                        There are no affiliate products available at the moment. Check back later or contact
                                        support.
                                    </p>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>