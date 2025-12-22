<!DOCTYPE html>
<html>
<?php $this->load->view('delivery_boy/include-css.php'); ?>
<div id="loading">
    <div class="lds-ring">
        <div></div>
    </div>
</div>

<body>
    <div class="page">
        <?php $this->load->view('delivery_boy/include-sidebar.php'); ?>
        <?php $this->load->view('layouts/toast.php'); ?>
        <?php $this->load->view('delivery_boy/include-navbar.php') ?>
        <div class="page-wrapper p-4">
            <?php $this->load->view('delivery_boy/pages/' . $main_page); ?>
            <?php $this->load->view('delivery_boy/include-footer.php'); ?>
        </div>
    </div>
    <?php $this->load->view('delivery_boy/include-script.php'); ?>
</body>

</html>