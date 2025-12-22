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


<aside class="navbar navbar-vertical navbar-expand-lg " data-bs-theme="dark">
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

    <div class="d-block navbar-brand navbar-brand-autodark align-iteam-center justify-contain-center px-2">
      <a href="<?= base_url('admin/home') ?>" aria-label="Tabler" class="navbar-favicon">
        <img src="<?= base_url() . get_settings('logo') ?>" alt="<?= $settings['app_name']; ?>"
          title="<?= $settings['app_name']; ?>" class="navbar-brand-image">
        <!--<div class="brand-text font-weight-light small"><?= $settings['app_name']; ?></div>-->
      </a>
    </div>

    <div class="collapse navbar-collapse" id="sidebar-menu">
      <!-- BEGIN NAVBAR MENU -->
      <ul class="navbar-nav pt-lg-3">
        <!-- Dashboard -->
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('admin/home') ?>">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-dashboard"></i></span>
            <span class="nav-link-title">Dashboard</span>
          </a>
        </li>

        <!-- Orders -->

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle dropdown-toggle-sidebar" href="#orders-menu" data-bs-toggle="dropdown"
            role="button" aria-expanded="false">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-shopping-cart"></i></span>
            <span class="nav-link-title">Orders</span>
          </a>
          <div class="dropdown-menu ">
            <a class="dropdown-item" href="<?= base_url('admin/orders/') ?>">All Orders</a>
            <a class="dropdown-item" href="<?= base_url('admin/orders/order-tracking') ?>">Order Tracking</a>
            <a class="dropdown-item"
              href="<?= base_url('admin/notification_settings/manage_system_notifications') ?>">System Notifications</a>
          </div>
        </li>

        <!-- Products -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle dropdown-toggle-sidebar" href="#products-menu" data-bs-toggle="dropdown"
            role="button">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-package"></i></span>
            <span class="nav-link-title">Products</span>
          </a>
          <div class="dropdown-menu ">
            <a class="dropdown-item " href="<?= base_url('admin/products') ?>">Manage Products</a>
            <a class="dropdown-item" href="<?= base_url('admin/product/create-product') ?>">Add Product</a>
            <a class="dropdown-item" href="<?= base_url('admin/product/bulk-upload') ?>">Bulk Upload</a>
            <a class="dropdown-item" href="<?= base_url('admin/product/product_bulk_edit') ?>">Product Affiliate</a>
            <a class="dropdown-item" href="<?= base_url('admin/attribute_set/manage-attribute-set') ?>">Attribute
              Sets</a>
            <a class="dropdown-item" href="<?= base_url('admin/attributes/manage-attribute') ?>">Attributes</a>
            <a class="dropdown-item" href="<?= base_url('admin/attribute_value/manage-attribute-value') ?>">Attribute
              Values</a>
            <a class="dropdown-item" href="<?= base_url('admin/taxes/manage-taxes') ?>">Tax</a>
            <a class="dropdown-item" href="<?= base_url('admin/product_faqs/') ?>">Product FAQs</a>
            <a class="dropdown-item" href="<?= base_url('admin/product_ratings/') ?>">Product Ratings</a>
          </div>
        </li>

        <!-- Categories & Brands -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="categoriesDropdown" role="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-category"></i>
            </span>
            <span class="nav-link-title">Categories</span>
          </a>
          <ul class="dropdown-menu" aria-labelledby="categoriesDropdown">
            <li><a class="dropdown-item" href="<?= base_url('admin/category/') ?>">Manage Categories</a></li>
            <li><a class="dropdown-item" href="<?= base_url('admin/category/category-order') ?>">Category Order</a></li>
            <li><a class="dropdown-item" href="<?= base_url('admin/category/bulk-upload') ?>">Bulk Upload</a></li>
          </ul>
        </li>


        <!-- Brands -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle dropdown-toggle-sidebar" href="#brands-menu" data-bs-toggle="dropdown"
            role="button" aria-expanded="false">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-badge"></i></span>
            <span class="nav-link-title">Brands</span>
          </a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="<?= base_url('admin/brands') ?>">Manage Brands</a>
            <a class="dropdown-item" href="<?= base_url('admin/brand/bulk-upload') ?>">Bulk Upload</a>
          </div>
        </li>


        <!-- Sellers -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle dropdown-toggle-sidebar" href="#sellers-menu" data-bs-toggle="dropdown"
            role="button" aria-expanded="false">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-building-store"></i></span>
            <span class="nav-link-title">Sellers</span>
          </a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="<?= base_url('admin/sellers/') ?>">Manage Sellers</a>
            <a class="dropdown-item" href="<?= base_url('admin/transaction/wallet-transactions') ?>">Wallet
              Transactions</a>
          </div>
        </li>

        <!-- Customers -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle dropdown-toggle-sidebar" href="#customers-menu" data-bs-toggle="dropdown"
            role="button" aria-expanded="false">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-users"></i></span>
            <span class="nav-link-title">Customers</span>
          </a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="<?= base_url('admin/customer/') ?>">View Customers</a>
            <a class="dropdown-item" href="<?= base_url('admin/customer/addresses') ?>">Addresses</a>
            <a class="dropdown-item" href="<?= base_url('admin/transaction/view-transaction') ?>">Transactions</a>
            <a class="dropdown-item" href="<?= base_url('admin/transaction/customer-wallet') ?>">Wallet Transactions</a>
          </div>
        </li>

        <!-- Return Request -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle dropdown-toggle-sidebar" href="#return-menu" data-bs-toggle="dropdown"
            role="button" aria-expanded="false">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-rotate-clockwise-2"></i></span>
            <span class="nav-link-title">Return Requests</span>
          </a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="<?= base_url('admin/return-request') ?>">Manage Return Requests</a>
            <a class="dropdown-item" href="<?= base_url('admin/return_reasons') ?>">Reasons For return</a>
          </div>
        </li>


        <!-- Delivery Boys & Fund Transfers -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle dropdown-toggle-sidebar" href="#deliveryboys-menu"
            data-bs-toggle="dropdown" role="button" aria-expanded="false">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-bike"></i></span>
            <span class="nav-link-title">Delivery Boys</span>
          </a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="<?= base_url('admin/delivery-boys/manage-delivery-boy') ?>">Manage Delivery
              Boys</a>
            <a class="dropdown-item" href="<?= base_url('admin/delivery-boys/manage-cash') ?>">Manage Cash
              Collection</a>
            <a class="dropdown-item" href="<?= base_url('admin/fund-transfer/') ?>">Fund Transfer</a>
          </div>
        </li>

        <!-- Stock & Location -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle dropdown-toggle-sidebar" href="#stocklocation-menu"
            data-bs-toggle="dropdown" role="button" aria-expanded="false">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-map-pin"></i></span>
            <span class="nav-link-title">Location</span>
          </a>
          <div class="dropdown-menu">
            <!-- <div class="dropdown-menu"> -->
            <a class="dropdown-item" href="<?= base_url('admin/Pickup_location/manage-pickup-locations') ?>">Pickup
              Locations</a>
            <a class="dropdown-item" href="<?= base_url('admin/area/manage-zipcodes') ?>">Zipcodes</a>
            <a class="dropdown-item" href="<?= base_url('admin/area/manage-cities') ?>">Cities</a>
            <a class="dropdown-item" href="<?= base_url('admin/area/manage_countries') ?>">Countries</a>
            <a class="dropdown-item" href="<?= base_url('admin/area/location-bulk-upload') ?>">Bulk Upload</a>

          </div>
        </li>


        <!-- Manage Stock -->
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('admin/manage_stock') ?>">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-building-warehouse"></i></span>
            <span class="nav-link-title">Manage Stock</span>
          </a>
        </li>
        <!-- Media -->
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('admin/media/') ?>">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-photo"></i></span>
            <span class="nav-link-title">Media</span>
          </a>
        </li>
        <!-- Payment Request -->
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('admin/payment-request') ?>">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-cash"></i></span>
            <span class="nav-link-title">Payment Request</span>
          </a>
        </li>

        <!-- Offers & Sliders -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle dropdown-toggle-sidebar" href="#media-slider-menu"
            data-bs-toggle="dropdown" role="button" aria-expanded="false">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-ad"></i></span>
            <span class="nav-link-title">Offers & Sliders</span>
          </a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="<?= base_url('admin/slider/manage-slider') ?>">Sliders</a>
            <a class="dropdown-item" href="<?= base_url('admin/offer/manage-offer') ?>">Offers</a>
          </div>
        </li>

        <!-- Blog & Content -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle dropdown-toggle-sidebar" href="#blog-content-menu"
            data-bs-toggle="dropdown" role="button" aria-expanded="false">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-article"></i></span>
            <span class="nav-link-title">Blog & Content</span>
          </a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="<?= base_url('admin/blogs') ?>">Blog Categories</a>
            <a class="dropdown-item" href="<?= base_url('admin/blogs/manage_blogs') ?>">Manage Blogs</a>
          </div>
        </li>

        <!-- Support & Communication -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle dropdown-toggle-sidebar" href="#support-menu" data-bs-toggle="dropdown"
            role="button" aria-expanded="false">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-message-circle"></i></span>
            <span class="nav-link-title">Support Desk</span>
          </a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="<?= base_url('admin/chat') ?>">Chat</a>
            <a class="dropdown-item" href="<?= base_url('admin/tickets/ticket-types') ?>">Ticket Types</a>
            <a class="dropdown-item" href="<?= base_url('admin/tickets') ?>">Tickets</a>

          </div>
        </li>

        <!-- Notifications  -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle dropdown-toggle-sidebar" href="#notification-menu"
            data-bs-toggle="dropdown" role="button" aria-expanded="false">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-bell"></i></span>
            <span class="nav-link-title">Notifications </span>
          </a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="<?= base_url('admin/Notification-settings/manage-notifications') ?>">Send
              Notification</a>
            <a class="dropdown-item" href="<?= base_url('admin/custom_notification') ?>">Custom Message</a>
          </div>
        </li>

        <!-- System Settings -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle dropdown-toggle-sidebar" href="#system-settings-menu"
            data-bs-toggle="dropdown" role="button" aria-expanded="false">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-settings"></i></span>
            <span class="nav-link-title">System Settings</span>
          </a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="<?= base_url('admin/setting') ?>">Store Settings</a>
            <a class="dropdown-item" href="<?= base_url('admin/system_health') ?>">System Health</a>
            <a class="dropdown-item" href="<?= base_url('admin/email-settings') ?>">Email Settings</a>
            <a class="dropdown-item" href="<?= base_url('admin/payment-settings') ?>">Payment Methods</a>
            <a class="dropdown-item" href="<?= base_url('admin/shipping-settings') ?>">Shipping Methods</a>
            <a class="dropdown-item" href="<?= base_url('admin/time-slots') ?>">Time Slots</a>
            <a class="dropdown-item" href="<?= base_url('admin/authentication-settings') ?>">Authentication Mode</a>
            <a class="dropdown-item" href="<?= base_url('admin/notification-settings') ?>">Notification Settings</a>
            <a class="dropdown-item" href="<?= base_url('admin/sms-gateway-settings') ?>">SMS Gateway Settings</a>
            <a class="dropdown-item" href="<?= base_url('admin/contact-us') ?>">Contact Us</a>
            <a class="dropdown-item" href="<?= base_url('admin/client-api-keys/') ?>">API Keys</a>
            <a class="dropdown-item" href="<?= base_url('admin/updater') ?>">System Updater</a>
            <a class="dropdown-item" href="<?= base_url('admin/purchase-code') ?>">System Registration</a>
            <a class="dropdown-item" href="<?= base_url('admin/faq/') ?>">FAQ</a>
          </div>
        </li>

        <!-- Web Settings -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle dropdown-toggle-sidebar" href="#web-settings-menu"
            data-bs-toggle="dropdown" role="button" aria-expanded="false">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-world"></i></span>
            <span class="nav-link-title">Web Settings</span>
          </a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="<?= base_url('admin/web-setting') ?>">General Settings</a>
            <a class="dropdown-item" href="<?= base_url('admin/themes') ?>">Themes</a>
            <a class="dropdown-item" href="<?= base_url('admin/language') ?>">Languages</a>
            <a class="dropdown-item" href="<?= base_url('admin/web-setting/firebase') ?>">Firebase</a>
          </div>
        </li>

        <!-- Policy Pages -->
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('admin/privacy-policy') ?>">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-shield-check"></i></span>
            <span class="nav-link-title">Policies</span>
          </a>
        </li>

        <!-- Affiliate System -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle dropdown-toggle-sidebar" href="#affiliate-system-menu"
            data-bs-toggle="dropdown" role="button" aria-expanded="false">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-affiliate"></i></span>
            <span class="nav-link-title">Affiliate System</span>
          </a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="<?= base_url('admin/affiliate/') ?>">Dashboard</a>
            <a class="dropdown-item" href="<?= base_url('admin/affiliate_users') ?>">Affiliate Users</a>
            <a class="dropdown-item" href="<?= base_url('admin/affiliate_settings') ?>">Settings</a>
            <a class="dropdown-item" href="<?= base_url('admin/affiliate_policies') ?>">Terms & Policies</a>
          </div>
        </li>

        <!-- Promo Codes -->
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('admin/promo-code/manage-promo-code') ?>">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-discount-2"></i></span>
            <span class="nav-link-title">Promo Codes</span>
          </a>
        </li>

        <!-- Promo Codes & Featured Sections -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle dropdown-toggle-sidebar" href="#promo-featured-menu"
            data-bs-toggle="dropdown" role="button" aria-expanded="false">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-star"></i></span>
            <span class="nav-link-title">Featured Sections</span>
          </a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="<?= base_url('admin/featured-sections/') ?>">Manage Sections</a>
            <a class="dropdown-item" href="<?= base_url('admin/featured-sections/section-order') ?>">Sections Order</a>
          </div>
        </li>

        <!-- Reports -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle dropdown-toggle-sidebar" href="#reports-menu" data-bs-toggle="dropdown"
            role="button" aria-expanded="false">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-chart-bar"></i></span>
            <span class="nav-link-title">Reports</span>
          </a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="<?= base_url('admin/sales-report') ?>">Sales Report</a>
            <a class="dropdown-item" href="<?= base_url('admin/sales-inventory') ?>">Sale Inventory Reports</a>
          </div>
        </li>

        <!-- System Users -->
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('admin/system-users/') ?>">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-users-group"></i></span>
            <span class="nav-link-title">System Users</span>
          </a>
        </li>
      </ul>
      <!-- END NAVBAR MENU -->
    </div>

  </div>
</aside>
