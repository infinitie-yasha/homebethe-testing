<!DOCTYPE html>
<html>
<?php $this->load->view('affiliate/include-head.php'); ?>

<body class="hold-transition login-page  bg-admin">

	<div class="overlay"></div>
	<?php $this->load->view('layouts/toast.php'); ?>
	<?php $this->load->view('affiliate/pages/' . $main_page); ?>
	<!-- Footer -->
	<?php $this->load->view('affiliate/include-script.php'); ?>
</body>

</html>