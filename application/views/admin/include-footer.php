<div class="modal fade " id='media-upload-modal' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Media</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="col-md-12 main-content">
          <div class="content-area p-4">
            <div class="card-innr">
              <div class="gaps-1-5x"></div>
              <input type='hidden' name='media_type' id='media_type' value='image'>
              <input type='hidden' name='current_input'>
              <input type='hidden' name='remove_state'>
              <input type='hidden' name='multiple_images_allowed_state'>
              <div class="col-md-12 mt-3 mb-3 mb-5">
                <!-- Change /upload-target to your upload address -->
                <div id="dropzone" class="dropzone"></div>
                <br>
                <a href="" id="upload-files-btn" class="btn btn-success float-right bg-success-lt">Upload</a>
              </div>
              <div class="alert alert-warning">Select media and click choose media</div>
              <div id="toolbar">
                <button id='upload-media' class="btn btn-danger bg-danger-lt">
                  <i class="ti ti-plus"></i> Choose Media
                </button>
              </div>
              <table class='table-striped' data-toolbar="#toolbar" id='media-upload-table' data-page-size="5"
                data-toggle="table" data-url="<?= base_url('admin/media/fetch') ?>" data-click-to-select="true"
                data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]"
                data-search="true" data-show-columns="true" data-show-refresh="true" data-trim-on-search="false"
                data-sort-name="id" data-sort-order="asc" data-mobile-responsive="true" data-toolbar=""
                data-show-export="true" data-query-params="mediaParams">
                <thead>
                  <tr>
                    <th data-field="state" data-checkbox="true"></th>
                    <th data-field="id" data-sortable="true" data-visible='false'>ID</th>
                    <th data-field="image" data-sortable="false">Image</th>
                    <th data-field="name" data-sortable="false">Name</th>
                    <th data-field="size" data-sortable="false">Size</th>
                    <th data-field="extension" data-sortable="false" data-visible='false'>Extension</th>
                    <th data-field="sub_directory" data-sortable="false" data-visible='false'>Sub directory</th>
                  </tr>
                </thead>
              </table>
            </div><!-- .card-innr -->
          </div><!-- .card -->
        </div>
      </div>
    </div>
  </div>
</div>
<?php $current_version = get_current_version();
?>
<div class="page-wrapper">
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
                    <a class="d-none" target="_blank" href="https://www.wrteam.in/">WRTeam</a>.
                </strong>
            <?php } ?>

        </div>
    </div>
</footer>
