<div class="page-wrapper">

  <div class="page">

    <!-- BEGIN PAGE HEADER -->
    <div class="page-header d-print-none" aria-label="Page header">
      <div class="container-xl">
        <div class="row g-2 align-items-center">
          <div class="col">
            <h2 class="page-title">Manage FAQ</h2>
          </div>
          <div class="col-auto ms-auto d-print-none">
            <div class="d-flex">
              <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                <li class="breadcrumb-item">
                  <a href="<?= base_url('admin/home') ?>">Home</a>
                </li>
                  <li class="breadcrumb-item active" aria-current="page">
                  <a href="#">Settings</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                  <a href="#">FAQ</a>
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
        <div class="col-12">
          <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
              <h3 class="card-title"><i class="ti ti-help-hexagon"></i> FAQ</h3>
              <button class="btn btn-sm btn-primary bg-primary-lt" data-bs-toggle="offcanvas"
                data-bs-target="#addFAQ">Add
                FAQ</button>
            </div>
            <div class="card-body">
              <div class="space-y-4">
                <div>
                  <div id="faq-1" class="accordion accordion-tabs" role="tablist" aria-multiselectable="true">
                    <?php
                    $i = 1;
                    foreach ($faq as $row) {
                      ?>
                      <div class="accordion-item">
                        <div class="accordion-header">
                          <button class="accordion-button collapsed" data-bs-toggle="collapse"
                            data-bs-target="#faq-1-<?= $i ?>" role="tab">
                            <?= output_escaping(str_replace('\r\n', '&#13;&#10;', $row['question'])) ?>
                            <div class="accordion-button-toggle">
                              <i class="ti ti-chevron-down"></i>
                            </div>
                          </button>
                        </div>
                        <div id="faq-1-<?= $i ?>" class="accordion-collapse collapse" role="tabpanel"
                          data-bs-parent="#faq-1">
                          <div class="accordion-body pt-0">
                            <div>
                              <p>
                                <b>Answer :</b> <span class="faq_answer"><?= $row['answer'] ?></span>
                              </p>
                            </div>
                            <div class="col-md-6 text-right">
                              <a class="btn btn-success bg-success-lt btn-sm edit_faq_btn" data-id="<?= $row['id'] ?>"
                                data-question="<?= output_escaping($row['question']) ?>"
                                data-answer="<?= output_escaping($row['answer']) ?>" type="button"
                                data-bs-toggle="offcanvas" data-bs-target="#addFAQ">
                                <i class="ti ti-pencil"></i>
                              </a>


                              <a href="javascript:void(0)" x-data="ajaxDelete({
                                url: base_url + 'admin/faq/delete_faq',
                                id: <?= $row['id'] ?>,
                                confirmTitle: 'Delete FAQ',
                                confirmMessage: 'Do you really want to delete this FAQ?'
                            })" @click="deleteItem" class="btn btn-danger action-btn btn-sm bg-danger-lt"
                                type="button">
                                <i class="ti ti-trash"></i>
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
                      <?php $i++;
                    } ?>

                  </div>
                </div>
              </div>

              <div class="offcanvas offcanvas-end offcanvas-medium" tabindex="-1" id="addFAQ"
                aria-labelledby="addFAQLabel">
                <div class="offcanvas-header">
                  <h2 class="offcanvas-title" id="addFAQLabel">Add FAQs</h2>
                  <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
                </div>
                <form x-data="ajaxForm({
                                            url: base_url + 'admin/faq/add_faq',
                                            offcanvasId: 'addFAQ',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="add_faq_form">
                  <div class="offcanvas-body">
                    <div>
                      <div class="mb-3 row ">
                        <input type="hidden" name="edit_faq" id="edit_faq" value="">
                        <label class="col-3 col-form-label required" for="question">Question</label>
                        <div class="col">
                          <input type="text" class="form-control" name="question" id="question"
                            placeholder="Question" />
                        </div>
                      </div>

                      <div class="mb-3 row">
                        <label class="col-3 col-form-label required" for="answer">Answer</label>
                        <div class="col">
                          <textarea name="answer" id="answer" class="textarea form-control" placeholder="Answer"
                            data-bs-toggle="autosize"> </textarea>
                        </div>
                      </div>
                    </div>
                    <div class="text-end">
                      <!-- <button type="reset" class="btn btn-warning ">Reset</button> -->
                      <button type="button" class="btn" data-bs-dismiss="offcanvas" aria-label="Close">Close</button>
                      <button type="submit" class="btn btn-primary save_faq_btn" id="submit_btn">Add
                        FAQ</button>
                    </div>
                  </div>
                </form>
              </div>

            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>