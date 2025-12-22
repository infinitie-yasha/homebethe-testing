<!DOCTYPE html>
<html>
<?php $this->load->view('seller/include-css.php'); ?>

<body class="hold-transition login-page  bg-admin">
	<!-- <img src="<?//= base_url('assets/admin/images/eshop_img.jpg') ?>" class="h-100 w-100"> -->
	<div class="overlay"></div>
	<?php $this->load->view('layouts/toast.php'); ?>
	<?php $this->load->view('seller/pages/' . $main_page); ?>
	<!-- Footer -->
	<?php $this->load->view('seller/include-script.php'); ?>
</body>

</html>