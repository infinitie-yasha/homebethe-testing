<!DOCTYPE html>
<html>
<?php $this->load->view('delivery_boy/include-css.php'); ?>

<body class="hold-transition login-page  bg-admin">
	<div class="overlay"></div>
	<?php $this->load->view('layouts/toast.php'); ?>
	<?php $this->load->view('delivery_boy/pages/' . $main_page); ?>
	<!-- Footer -->
	<?php $this->load->view('admin/include-script.php'); ?>
</body>

</html>