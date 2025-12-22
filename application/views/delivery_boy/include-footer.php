<?php $current_version = get_current_version();
?>
<footer class="footer footer-transparent d-print-none">
    <div class="container-xl">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center text-center text-sm-start gap-2 py-2">

            <!-- Version Badge -->
            <span class="badge bg-cyan-lt">
                v <?= (isset($current_version) && !empty($current_version)) ? $current_version : '1.0' ?>
            </span>

            <!-- Copyright Text -->
            <?php $settings = get_settings('system_settings', true);
            if (isset($settings['copyright_details']) && !empty($settings['copyright_details'])) { ?>
                <strong class="fw-normal">
                    <?= output_escaping(str_replace('\r\n', '&#13;&#10;', $settings['copyright_details'])) ?>
                </strong>
            <?php } else { ?>
                <strong class="fw-normal">
                    Copyright &copy; <?= date('Y') ?> - <?= date('Y') + 1 ?>
                    <a target="_blank" href="<?= base_url('admin/home') ?>"><?= $settings['app_name']; ?></a>,
                    All Rights Reserved
                    <a target="_blank" href="https://www.wrteam.in/">WRTeam</a>.
                </strong>
            <?php } ?>

        </div>
    </div>
</footer>