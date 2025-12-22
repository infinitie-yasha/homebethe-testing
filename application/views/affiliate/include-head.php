<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= $title ?></title>
  <meta name="csrf-hash" content="<?= $this->security->get_csrf_hash(); ?>">
  <meta name="csrf-name" content="<?= $this->security->get_csrf_token_name(); ?>">


  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="<?= base_url() . get_settings('favicon') ?>" type="image/gif" sizes="16x16">

  <!-- Tom Select -->
  <link rel="stylesheet"
    href="<?= base_url('assets/common/dist/libs/tom-select/dist/css/tom-select.bootstrap5.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/common/css/common.css') ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('assets/common/dist/css/tabler.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/common/dist/css/tabler-vendors.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/common/css/ekko-lightbox.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/common/css/lightbox.css') ?>" />

  <link rel="stylesheet" href="<?= base_url('assets/common/dist/css/tabler-themes.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/common/css/bootstrap-table.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/common/css/tabler-icons/tabler-icons.min.css') ?>">
  <script type="text/javascript">
    base_url = "<?= base_url() ?>";
    csrfName = "<?= $this->security->get_csrf_token_name() ?>";
    csrfHash = "<?= $this->security->get_csrf_hash() ?>";
    form_name = '<?= '#' . $main_page . '_form' ?>';
  </script>
</head>