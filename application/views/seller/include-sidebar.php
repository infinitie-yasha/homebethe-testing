<?php $settings = get_settings('system_settings', true);
$shipping_settings = get_settings('shipping_method', true);
$doctor_brown_for_app = get_settings('doctor_brown');
$web_doctor_brown = get_settings('web_doctor_brown');

$authentication_settings = get_settings('authentication_settings');

if ($authentication_settings !== null && is_string($authentication_settings)) {
  $authentication = json_decode(get_settings('authentication_settings'), true);
} else {
  $authentication = [];
}
?>


<aside class="navbar navbar-vertical navbar-expand-lg overflow-auto" data-bs-theme="dark">
  <div class="container-fluid">
    <!-- BEGIN NAVBAR TOGGLER -->
    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#sidebar-menu"
      aria-controls="sidebar-menu"
      aria-expanded="false"
      aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <!-- END NAVBAR TOGGLER -->

    <div class="navbar-brand navbar-brand-autodark justify-content-start px-2">
      <a href="<?= base_url('admin/home') ?>" aria-label="Tabler" class="navbar-favicon">
        <img src="<?= base_url()  . get_settings('favicon') ?>" alt="<?= $settings['app_name']; ?>" title="<?= $settings['app_name']; ?>" class="navbar-brand-image">
        <!--<span class="brand-text font-weight-light small"><?= $settings['app_name']; ?></span>-->
      </a>
    </div>

    <div class="collapse navbar-collapse" id="sidebar-menu">
      <!-- BEGIN NAVBAR MENU -->
      <ul class="navbar-nav pt-lg-3">
        <!-- Dashboard -->
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('seller/home') ?>">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-home"></i></span>
            <span class="nav-link-title">Dashboard</span>
          </a>
        </li>

        <!-- Orders -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#orders-menu" data-bs-toggle="dropdown" role="button" aria-expanded="false">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-shopping-cart"></i></span>
            <span class="nav-link-title">Orders</span>
          </a>
          <div class="dropdown-menu">
            <a class="dropdown-item"  href="<?= base_url('seller/orders') ?>">Order Items</a>
            <a class="dropdown-item"  href="<?= base_url('seller/orders/order-tracking') ?>">Order Tracking</a>
            
          </div>
        </li>

        <!-- Products -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#products-menu" data-bs-toggle="dropdown" role="button" aria-expanded="false">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-package"></i></span>
            <span class="nav-link-title">Products</span>
          </a>
          <div class="dropdown-menu">
            <a class="dropdown-item"  href="<?= base_url('seller/products') ?>">Manage Products</a>
            <a class="dropdown-item"  href="<?= base_url('seller/product/create-product') ?>">Add Product</a>
            <a class="dropdown-item"  href="<?= base_url('seller/product/bulk-upload') ?>">Bulk Upload</a>
            <a class="dropdown-item"  href="<?= base_url('seller/product/product_bulk_edit') ?>">Product Bulk Update</a>
            <a class="dropdown-item"  href="<?= base_url('seller/attribute_set') ?>">Attribute Sets</a>
            <a class="dropdown-item"  href="<?= base_url('seller/attributes') ?>">Attributes</a>
            <a class="dropdown-item"  href="<?= base_url('seller/attribute_value') ?>">Attribute Values</a>
            <a class="dropdown-item"  href="<?= base_url('seller/taxes') ?>">Tax</a>
            <a class="dropdown-item"  href="<?= base_url('seller/product_faqs') ?>">Product FAQs</a>
            <a class="dropdown-item" href="<?= base_url('seller/product_ratings') ?>">Product Ratings</a>
         

          </div>
        </li>

        <!--<li class="nav-item dropdown">-->
        <!--  <a class="nav-link dropdown-toggle" href="#stocklocation-menu" data-bs-toggle="dropdown" role="button" aria-expanded="false">-->
        <!--    <span class="nav-link-icon d-md-none d-lg-inline-block">-->
        <!--      <i class="ti ti-credit-card"></i></span>-->
        <!--    <span class="nav-link-title">Point Of Sales</span>-->
        <!--  </a>-->
        <!--  <div class="dropdown-menu">-->
          
        <!--    <a class="dropdown-item" href="<?= base_url('seller/point_of_sale') ?>">Point Of Sale</a>-->
        <!--    <a class="dropdown-item" href="<?= base_url('seller/point_of_sale_table') ?>">Point Of Sale Order</a>-->
          

        <!--  </div>-->
        <!--</li>-->

        <!-- Categories & Brands -->
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('seller/category') ?>">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-category"></i></span>
            <span class="nav-link-title">Categories</span>
          </a>
        </li>

        <!-- Brands -->
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('seller/brands') ?>">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-trademark"></i></span>
            <span class="nav-link-title">Brands</span>
          </a>
        </li>
        <!-- chat -->
         <li class="nav-item">
          <a class="nav-link" href="<?= base_url('/seller/chat') ?>">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-message"></i></span>
            <span class="nav-link-title">Chat</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('/seller/support-tickets') ?>">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-message-circle"></i></span>
            <span class="nav-link-title">Seller Support</span>
          </a>
        </li>
        <!-- pick up location  -->

        <?php if (!empty($shipping_settings['shiprocket_shipping_method']) && $shipping_settings['shiprocket_shipping_method'] == 1) { ?>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('seller/Pickup_location/manage_pickup_locations') ?>">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <i class="ti ti-truck "></i>
            </span>
            <span class="nav-link-title">Pickup Location</span>
        </a>
    </li>
<?php } ?>

   <!-- Stock & Location -->
        <!-- Manage Stock -->
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('seller/manage_stock') ?>">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-stack"></i></span>
            <span class="nav-link-title">Manage Stock</span>
          </a>
        </li>
     
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#stocklocation-menu" data-bs-toggle="dropdown" role="button" aria-expanded="false">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-home"></i></span>
            <span class="nav-link-title">Location</span>
          </a>
          <div class="dropdown-menu">
            <!-- <div class="dropdown-menu"> -->
            <a class="dropdown-item" href="<?= base_url('seller/area/manage-zipcodes') ?>">Zipcodes</a>
            <a class="dropdown-item" href="<?= base_url('seller/area/manage-cities') ?>">Cities</a>
            <a class="dropdown-item" href="<?= base_url('seller/area/manage_countries') ?>">Countries</a>
   

          </div>
        </li>


        
        <!-- Media -->
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('seller/media/') ?>">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-library-photo"></i></span>
            <span class="nav-link-title">Media</span>
          </a>
        </li>
        <!-- wallet transaction -->
         <li class="nav-item">
          <a class="nav-link" href="<?= base_url('seller/transaction/wallet-transactions') ?>">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-wallet"></i></span>
            <span class="nav-link-title">wallet transactions</span>
          </a>
        </li>
        <!-- withdrowal request -->
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('seller/payment-request/withdrawal-requests') ?>">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-cash"></i></span>
              <span class="nav-link-title">withdrawal requests</span>
            </a>
          </li>
          <!-- Reports -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#reports-menu" data-bs-toggle="dropdown" role="button" aria-expanded="false">
              <span class="nav-link-icon d-md-none d-lg-inline-block">
                <i class="ti ti-report"></i></span>
              <span class="nav-link-title">Reports</span>
            </a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="<?= base_url('seller/sales-report') ?>">Sales Report</a>
              <a class="dropdown-item" href="<?= base_url('seller/sales-inventory') ?>">Sale Inventory Reports</a>
            </div>
          </li>
          
        <!-- Policy Pages -->
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('seller/policy') ?>">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-shield"></i></span>
            <span class="nav-link-title">Policies</span>
          </a>
        </li>
        <!-- terms and condition -->
    <li class="nav-item">
          <a class="nav-link" href="<?= base_url('seller/policy/terms_conditions') ?>">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-file-certificate"></i></span>
            <span class="nav-link-title">Terms & Conditions</span>
          </a>
        </li>
  
        
      </ul>
      <!-- END NAVBAR MENU -->
    </div>

  </div>
  
</aside>
