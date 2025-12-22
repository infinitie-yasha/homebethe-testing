<div class="page-wrapper">

  <div class="page">

    <!-- BEGIN PAGE HEADER -->
    <div class="page-header d-print-none" aria-label="Page header">
      <div class="container-xl">
        <div class="row g-2 align-items-center">
          <div class="col">
            <h2 class="page-title">About Us</h2>
          </div>
          <div class="col-auto ms-auto d-print-none">
            <div class="d-flex">
              <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                <li class="breadcrumb-item">
                  <a href="<?= base_url('admin/home') ?>">Home</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                  <a href="<?= base_url('admin/privacy-policy') ?>">Policies</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                  <a href="#">About Us</a>
                </li>
              </ol>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- END PAGE HEADER -->

    <div class="page-body">
      <div class="container-xl">
        <div class="card">
          <form x-data="ajaxForm({
                                            url: base_url + 'admin/About_us/update-about-us-settings',
                                            modalId: '',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="update_about_us_form"
            enctype="multipart/form-data">
            <div class="card-body">
              <div class="d-flex gap-3 align-items-center mb-0">
                <label class="col-form-label fw-bolder mb-0"><i class="ti ti-align-left"></i> About Us </label>
                <a href="<?= base_url('admin/about-us/about-us-page') ?>" target='_blank'
                  class="btn btn-primary btn-sm bg-primary-lt" title='View About Us'><i class='ti ti-eye'></i></a>
              </div>

              <div class="my-5">
                <textarea class="hugerte-mytextarea" name="about_us_input_description"
                  placeholder="Place some text here"><?= @$about_us ?></textarea>
              </div>
              <div class="form-group text-end">
                <button type="reset" class="btn btn-1">Cancel</button>
                <button type="submit" class="btn btn-primary btn-2" id="submit_btn">Update About Us <i
                    class="cursor-pointer ms-2 ti ti-arrow-right"></i></button>

              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

  </div>
</div>