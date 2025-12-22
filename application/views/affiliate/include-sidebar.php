




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
      <a href="<?= base_url('affiliate/home') ?>" aria-label="Tabler" class="navbar-favicon">
        <img src="<?= base_url()  . get_settings('favicon') ?>" alt="<?= $settings['app_name']; ?>" title="<?= $settings['app_name']; ?>" class="navbar-brand-image">
        <!--<span class="brand-text font-weight-light small"><?= $settings['app_name']; ?></span>-->
      </a>
    </div>

     <div class="collapse navbar-collapse" id="sidebar-menu">
      <!-- BEGIN NAVBAR MENU -->
      <ul class="navbar-nav pt-lg-3">
        <!-- Dashboard -->
       <li class="nav-item">
          <a class="nav-link" href="<?= base_url('affiliate/home') ?>">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-dashboard"></i></span>
            <span class="nav-link-title">Dashboard</span>
          </a>
        </li>


        <!-- Categories & Brands -->
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('affiliate/category') ?>">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-category"></i></span>
            <span class="nav-link-title">Categories</span>
          </a>
        </li>

        <!-- Brands -->
        <li class="nav-item">
         <a class="nav-link" href="<?= base_url('affiliate/product/manage_promoted_products') ?>">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-trademark"></i></span>
            <span class="nav-link-title">Promoted Products</span>
          </a>
        </li>
      
     
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#stocklocation-menu" data-bs-toggle="dropdown" role="button" aria-expanded="false">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-home"></i></span>
            <span class="nav-link-title">Finance</span>
          </a>
          <div class="dropdown-menu">
            <!-- <div class="dropdown-menu"> -->
            <a class="dropdown-item" href="<?= base_url('affiliate/transaction') ?>">My Earnings</a>
            <a class="dropdown-item" href="<?= base_url('affiliate/transaction/payment_request') ?>">Request Payment</a>
            
   

          </div>
        </li>

          
        <!-- Policy Pages -->
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('affiliate/policy') ?>">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="ti ti-shield"></i></span>
            <span class="nav-link-title">Policies</span>
          </a>
        </li>
        <!-- terms and condition -->
    <li class="nav-item">
          <a class="nav-link" href="<?= base_url('affiliate/policy/terms_conditions') ?>">
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
