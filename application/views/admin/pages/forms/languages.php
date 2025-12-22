<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">

                    <!-- Page Title -->
                    <div class="col-12 col-md-6">
                        <h2 class="page-title">Languages</h2>
                    </div>

                    <!-- Breadcrumb (moves below title on small screens) -->
                    <div class="col-12 col-md-6 d-flex justify-content-md-end">
                        <ol class="breadcrumb breadcrumb-arrows mb-0  d-flex justify-content-start justify-content-md-end flex-wrap"
                            aria-label="breadcrumbs">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('admin/home') ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0)">Web Settings</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="#">Languages</a>
                            </li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>

        <!-- END PAGE HEADER -->

        <div class="page-body">
            <div class="container-xl">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row g-2 align-items-center w-100">

                                <!-- Title -->
                                <div class="col-12 col-md-6 d-flex align-items-center">
                                    <h3 class="card-title mb-0">
                                        <i class="ti ti-language"></i> Manage Languages
                                    </h3>
                                </div>

                                <!-- Buttons -->
                                <div
                                    class="col-12 col-md-6 d-flex flex-column flex-sm-row justify-content-md-end gap-2">
                                    <a href="<?= base_url('language_example.json') ?>"
                                        class="btn btn-info bg-info-lt btn-sm w-100 w-sm-auto"
                                        download="language_example.json">
                                        <i class="ti ti-file"></i>
                                        Download Sample File
                                    </a>

                                    <a href="#"
                                        class="btn btn-primary bg-primary-lt btn-sm addLanguageBtn w-100 w-sm-auto"
                                        data-bs-toggle="offcanvas" data-bs-target="#addLanguage">
                                        Add Language
                                    </a>
                                </div>

                            </div>

                        </div>

                        <div class="card-body">
                            <table class='table-striped' id="web_theme_table" data-toggle="table"
                                data-url="<?= base_url('admin/language/get_list') ?>" data-click-to-select="true"
                                data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true"
                                data-show-refresh="true" data-trim-on-search="false" data-sort-name="id"
                                data-sort-order="desc" data-mobile-responsive="true" data-toolbar=""
                                data-show-export="true" data-maintain-selected="true"
                                data-export-types='["txt","excel"]' data-query-params="queryParams">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true">Id</th>
                                        <th data-field="language" data-sortable="false">Language</th>
                                        <th data-field="code" data-sortable="false">Code</th>
                                        <th data-field="is_rtl" data-sortable="false">is RTL</th>
                                        <th data-field="is_default" data-sortable="false">Default</th>
                                        <th data-field="native_language" data-sortable="false">Native language</th>
                                        <th data-field="operate" data-sortable="false">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="offcanvas offcanvas-end offcanvas-medium" tabindex="-1" id="addLanguage"
                            aria-labelledby="addLanguageLabel">
                            <div class="offcanvas-header">
                                <h2 class="offcanvas-title" id="addLanguageLabel">Add Language</h2>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <form x-data="ajaxForm({
                                            url: base_url + 'admin/language/create',
                                            modalId: '',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="add_new_language_form">
                                <input type="hidden" name="language_id" id="language_id" value="">
                                <div class="offcanvas-body">
                                    <div>

                                        <div class="mb-3 row">
                                            <label class="col-3 col-form-label" for="language">Name</label>
                                            <div class="col">
                                                <input type="text" class="form-control" name="language" id="language"
                                                    placeholder="Ex. English , Hindi" />
                                                <small class="form-hint">(Language name should be in
                                                    english)</small>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-3 col-form-label" for="code">Code</label>
                                            <div class="col">
                                                <input type="text" class="form-control" name="code" id="code"
                                                    placeholder="Ex. EN , हिन्दी" />
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="col-3 col-form-label" for="native_language">Native
                                                Language</label>
                                            <div class="col">
                                                <input type="text" class="form-control" name="native_language"
                                                    id="native_language" placeholder="Ex. English , हिन्दी" />
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label class="form-check" for="is_rtl_create">
                                                <input class="form-check-input" type="checkbox" name="is_rtl"
                                                    id="is_rtl_create" value="1" />
                                                <span class="form-check-label">Enable RTL</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <!-- <button type="reset" class="btn btn-warning ">Reset</button> -->
                                        <button type="button" class="btn" data-bs-dismiss="offcanvas"
                                            aria-label="Close">Close</button>
                                        <button type="submit" class="btn btn-primary save_language_btn"
                                            id="submit_btn">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="offcanvas offcanvas-end offcanvas-medium" tabindex="-1" id="uploadLanguageFile"
                            aria-labelledby="uploadLanguageFileLabel">
                            <div class="offcanvas-header">
                                <h2 class="offcanvas-title" id="uploadLanguageFileLabel">Add Language File</h2>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <form x-data="ajaxForm({
                                            url: base_url + 'admin/language/uploadLanguageFile',
                                            offcanvasId: 'uploadLanguageFile',
                                            loaderText: 'Uploading...'
                                        })" method="POST" enctype="multipart/form-data" class="form-horizontal"
                                id="upload_language_file_form">
                                <div class="offcanvas-body">
                                    <div>
                                        <div class="mb-3 row">
                                            <label class="col-3 col-form-label required" for="language_id">Select
                                                Language</label>
                                            <div class="col">
                                                <select name="language_id" id="language_id" class="form-control"
                                                    required>
                                                    <option value="">Select Language</option>
                                                    <?php if (!empty($languages)): ?>
                                                        <?php foreach ($languages as $lang): ?>
                                                            <option value="<?= $lang['id'] ?>"><?= ucfirst($lang['language']) ?>
                                                                (<?= $lang['native_language'] ?>)</option>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </select>
                                                <small class="form-hint">Choose the language to upload translations
                                                    for</small>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-3 col-form-label required" for="upload_file">Language File
                                                (JSON)</label>
                                            <div class="col">
                                                <input type="file" name="upload_file" id="upload_file"
                                                    class="form-control file_upload_height" accept=".json" required />
                                                <small class="form-hint">Upload a JSON file containing language
                                                    translations</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <button type="button" class="btn" data-bs-dismiss="offcanvas"
                                            aria-label="Close">Close</button>
                                        <button type="submit" class="btn btn-primary" id="upload_btn">Upload Language
                                            File</button>
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