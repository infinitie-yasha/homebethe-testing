<!-- plugins -->
<script src="<?= THEME_ASSETS_URL . 'js/plugins.js' ?>"></script>
<!-- Jquery min -->
<script src="<?= THEME_ASSETS_URL . 'js/jquery.min.js' ?>"></script>
<!-- theme -->
<script src="<?= THEME_ASSETS_URL . 'js/theme.js' ?>"></script>
<script src="<?= THEME_ASSETS_URL . 'js/theme.min.js' ?>"></script>

<!-- IziModal -->
<script src="<?= THEME_ASSETS_URL . 'js/iziModal.min.js' ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
<!-- Popper -->
<script src="<?= THEME_ASSETS_URL . 'js/popper.min.js' ?>"></script>
<!-- Bootstrap -->
<script src="<?= THEME_ASSETS_URL . 'js/bootstrap.min.js' ?>"></script>
<!-- Swiper JS -->
<script src="<?= THEME_ASSETS_URL . 'js/swiper-bundle.min.js' ?>"></script>
<!-- Select -->
<script src="<?= THEME_ASSETS_URL . 'js/select2.full.min.js' ?>"></script>
<!-- Bootstrap Tabs -->
<script src="<?= THEME_ASSETS_URL . 'js/bootstrap-tabs-x.min.js' ?>"></script>
<!-- Bootstrap Table -->
<script src="<?= THEME_ASSETS_URL . 'js/bootstrap-table.min.js' ?>"></script>
<!-- blockUI -->
<script src="<?= THEME_ASSETS_URL . 'js/jquery.blockUI.js' ?>"></script>
<!-- Sweeta Alert 2 -->
<script src="<?= THEME_ASSETS_URL . 'js/sweetalert2.min.js' ?>"></script>
<script src="<?= THEME_ASSETS_URL . 'js/darkmode-min.js' ?>"></script>
<!-- Star rating -->
<script src="<?= THEME_ASSETS_URL . 'js/star-rating.min.js' ?>"></script>
<script src="<?= THEME_ASSETS_URL . 'js/theme.min.js' ?>"></script>
<!-- Modernizr-custom.js -->
<script src="<?= THEME_ASSETS_URL . 'js/modernizr-custom.js' ?>"></script>
<!-- Lazy-Load.js -->
<script src="<?= THEME_ASSETS_URL . 'js/lazyload.min.js' ?>"></script>

<!-- jsSocial -->
<script src="<?= THEME_ASSETS_URL . 'js/jquery.jssocials.min.js' ?>"></script>
<!-- MDB perfect scrollbar -->
<script src="<?= THEME_ASSETS_URL . 'js/perfect-scrollbar.min.js' ?>"></script>



<!-- intlTelInput -->
<script src="<?= THEME_ASSETS_URL . 'js/intlTelInput.js' ?>"></script>
<script src="<?= THEME_ASSETS_URL . 'js/lightbox.js' ?>"></script>
<!-- Dropzone -->
<script src="<?= THEME_ASSETS_URL . 'js/dropzone.js' ?>"></script>
<script src="<?= THEME_ASSETS_URL . 'js/stisla.js' ?>"></script>


<script src="<?= THEME_ASSETS_URL . 'js/firebase-app.js' ?>"></script>
<script src="<?= THEME_ASSETS_URL . 'js/firebase-auth.js' ?>"></script>
<script src="<?= THEME_ASSETS_URL . 'js/firebase-firestore.js' ?>"></script>
<script src="<?= base_url('firebase-config.js') ?>"></script>

<!-- Custom -->
<script src="<?= THEME_ASSETS_URL . 'js/custom.js' ?>"></script>
<script src="<?= THEME_ASSETS_URL . 'js/deeplink.js' ?>"></script>


<?php if ($this->session->flashdata('message')) { ?>
    <script>
        Toast.fire({
            icon: '<?= $this->session->flashdata('message_type'); ?>',
            title: "<?= $this->session->flashdata('message'); ?>"
        });
    </script>
<?php } ?>

<?php
if (isset($data_json_ld) && !empty($data_json_ld)): ?>
    <script type="application/ld+json">
            <?= $data_json_ld ?>
        </script>
<?php else: ?>
    <script type="application/ld+json">
            {
                "@context": "https://schema.org",
                "@type": "WebSite",
                "url": "<?= base_url(); ?>",
                "potentialAction": {
                    "@type": "SearchAction",
                    "target": {
                        "@type": "EntryPoint",
                        "urlTemplate": "<?= base_url() . '/home/get_products/?q={search_term_string}'; ?>"
                    },
                    "query-input": "required name=search_term_string"
                }
            }
        </script>
<?php endif; ?>