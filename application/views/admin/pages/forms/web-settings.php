<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">General Website Settings</h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="d-flex">
                            <ol class="breadcrumb breadcrumb-arrows" aria-label="breadcrumbs">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('admin/home') ?>">Home</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="javascript:void(0)">Web Settings</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="#">General Website Settings</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE HEADER -->

        <div class="page-body">
            <div class="container-xl payment-container">
                <div class="row g-5">
                    <div class="col-sm-2">
                        <div class="sticky-top" style="top: 80px;">
                            <nav class="nav nav-vertical nav-pills" id="pills">
                                <a class="nav-link" href="#general_settings">General Settings</a>
                                <a class="nav-link" href="#web_logo_settings">Logo Settings</a>
                                <a class="nav-link" href="#app_download_section">App download Section</a>
                                <a class="nav-link" href="#social_media_links">Social Media Links</a>
                                <a class="nav-link" href="#feature_section">Feature Section & Shipping</a>
                                <a class="nav-link" href="#theme_color_settings">Theme Color Settings</a>
                            </nav>
                        </div>
                    </div>
                    <div class="col-sm" data-bs-spy="scroll" data-bs-target="#pills" data-bs-offset="80" tabindex="0">
                        <form x-data="ajaxForm({
                                            url: base_url + 'admin/setting/update_web_settings',
                                            modalId: '',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="web_settings_form"
                            enctype="multipart/form-data">

                            <!-- general_settings -->
                            <div class="card" id="general_settings">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="ti ti-settings-search"></i> General Settings</h3>
                                </div>
                                <div class="card-body">

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label required" for="site_title">Site Title</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="site_title" id="site_title"
                                                value="<?= (isset($web_settings['site_title'])) ? output_escaping($web_settings['site_title']) : '' ?>"
                                                placeholder="Prefix title for the website. " />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label required" for="support_number">Support
                                            Number</label>
                                        <div class="col">
                                            <input type="text" class="form-control" oninput="validateNumberInput(this)"
                                                name="support_number" id="support_number"
                                                value="<?= (isset($web_settings['support_number'])) ? output_escaping($web_settings['support_number']) : '' ?>"
                                                placeholder="Support Number" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label required" for="support_email">Support
                                            Email</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="support_email"
                                                id="support_email"
                                                value="<?= (isset($web_settings['support_email'])) ? output_escaping($web_settings['support_email']) : '' ?>"
                                                placeholder="Support Email" />
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label required" for="copyright_details">Copyright
                                            Details</label>
                                        <div class="col">
                                            <textarea name="copyright_details" class="textarea form-control"
                                                placeholder="Copyright Details"
                                                data-bs-toggle="autosize"> <?= (isset($web_settings['copyright_details'])) ? output_escaping($web_settings['copyright_details']) : '' ?></textarea>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label required" for="address">Address</label>
                                        <div class="col">
                                            <textarea name="address" class="textarea form-control" placeholder="Address"
                                                data-bs-toggle="autosize"> <?= (isset($web_settings['address'])) ? output_escaping($web_settings['address']) : '' ?></textarea>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label required" for="app_short_description">Short
                                            Description</label>
                                        <div class="col">
                                            <textarea name="app_short_description" class="textarea form-control"
                                                placeholder="app_short_description"
                                                data-bs-toggle="autosize"> <?= (isset($web_settings['app_short_description'])) ? output_escaping($web_settings['app_short_description']) : '' ?></textarea>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label required" for="map_iframe">Map Iframe</label>
                                        <div class="col">
                                            <textarea name="map_iframe" class="textarea form-control"
                                                placeholder="Map Iframe"
                                                data-bs-toggle="autosize"> <?= (isset($web_settings['map_iframe'])) ? output_escaping($web_settings['map_iframe']) : '' ?></textarea>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label required" for="meta_keywords">Meta
                                            Keywords</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="meta_keywords"
                                                id="meta_keywords"
                                                value="<?= (isset($web_settings['meta_keywords'])) ? output_escaping($web_settings['meta_keywords']) : '' ?>"
                                                placeholder="Example: GST Number / VAT / TIN Number" />
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label required" for="meta_description">Meta
                                            Description</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="meta_description"
                                                id="meta_description"
                                                value="<?= (isset($web_settings['meta_description'])) ? output_escaping($web_settings['meta_description']) : '' ?>"
                                                placeholder="Example: GST Number / VAT / TIN Number" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- web_logo_settings -->
                            <div class="card my-3" id="web_logo_settings">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="ti ti-library-photo"></i> Logo Settings</h3>
                                </div>
                                <div class="card-body">
                                    <!-- Header Logo -->
                                    <div class="mb-4 row form-group">
                                        <label class="col-12 col-md-3 col-form-label" for="logo">Header Logo</label>
                                        <div class="col-12 col-md-9">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <small class="text-muted">
                                                    <i class="ti ti-info-circle"></i>
                                                    Recommended: 500 x 200 pixels
                                                </small>
                                                <a class="btn btn-primary btn-sm uploadFile"
                                                    data-input="logo"
                                                    data-isremovable="0"
                                                    data-is-multiple-uploads-allowed="0"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#media-upload-modal">
                                                    <i class="ti ti-photo-plus"></i> Upload Header Logo
                                                </a>
                                            </div>

                                            <div class="row g-3 image-upload-div">
                                                <?php if (!empty($logo)): ?>
                                                <div class="col-6 col-md-4 col-lg-3">
                                                    <div class="card shadow-sm h-100">
                                                        <div class="card-img-top position-relative ratio ratio-16x9 overflow-hidden">
                                                            <img src="<?= BASE_URL() . $logo ?>" alt="Header Logo"
                                                                class="position-absolute top-0 start-0 w-100 h-100 object-fit-contain bg-light">
                                                            <div class="position-absolute top-0 start-0 p-2">
                                                                <span class="badge bg-dark-lt">
                                                                    <i class="ti ti-photo"></i> Header Logo
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="logo" value="<?= $logo ?>">
                                                    </div>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Footer Logo -->
                                    <div class="mb-4 row form-group">
                                        <label class="col-12 col-md-3 col-form-label" for="footer_logo">Footer Logo</label>
                                        <div class="col-12 col-md-9">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <small class="text-muted">
                                                    <i class="ti ti-info-circle"></i>
                                                    Recommended: 500 x 200 pixels
                                                </small>
                                                <a class="btn btn-primary btn-sm uploadFile"
                                                    data-input="footer_logo"
                                                    data-isremovable="0"
                                                    data-is-multiple-uploads-allowed="0"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#media-upload-modal">
                                                    <i class="ti ti-photo-plus"></i> Upload Footer Logo
                                                </a>
                                            </div>

                                            <div class="row g-3 image-upload-div">
                                                <?php if (!empty($footer_logo)): ?>
                                                <div class="col-6 col-md-4 col-lg-3">
                                                    <div class="card shadow-sm h-100">
                                                        <div class="card-img-top position-relative ratio ratio-16x9 overflow-hidden">
                                                            <img src="<?= BASE_URL() . $footer_logo ?>" alt="Footer Logo"
                                                                class="position-absolute top-0 start-0 w-100 h-100 object-fit-contain bg-light">
                                                            <div class="position-absolute top-0 start-0 p-2">
                                                                <span class="badge bg-dark-lt">
                                                                    <i class="ti ti-photo"></i> Footer Logo
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="footer_logo" value="<?= $footer_logo ?>">
                                                    </div>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Favicon -->
                                    <div class="mb-4 row form-group">
                                        <label class="col-12 col-md-3 col-form-label" for="favicon">Favicon</label>
                                        <div class="col-12 col-md-9">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <small class="text-muted">
                                                    <i class="ti ti-info-circle"></i>
                                                    Recommended: 32 x 32 pixels (square)
                                                </small>
                                                <a class="btn btn-primary btn-sm uploadFile"
                                                    data-input="favicon"
                                                    data-isremovable="0"
                                                    data-is-multiple-uploads-allowed="0"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#media-upload-modal">
                                                    <i class="ti ti-photo-plus"></i> Upload Favicon
                                                </a>
                                            </div>

                                            <div class="row g-3 image-upload-div">
                                                <?php if (!empty($favicon)): ?>
                                                <div class="col-6 col-md-4 col-lg-3">
                                                    <div class="card shadow-sm h-100">
                                                        <div class="card-img-top position-relative ratio ratio-1x1 overflow-hidden">
                                                            <img src="<?= BASE_URL() . $favicon ?>" alt="Favicon"
                                                                class="position-absolute top-0 start-0 w-100 h-100 object-fit-contain bg-light p-4">
                                                            <div class="position-absolute top-0 start-0 p-2">
                                                                <span class="badge bg-dark-lt">
                                                                    <i class="ti ti-photo"></i> Favicon
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="favicon" value="<?= $favicon ?>">
                                                    </div>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- app_download_section -->
                            <div class="card my-3" id="app_download_section">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="ti ti-device-tablet-down"></i> App download Section
                                    </h3>
                                </div>
                                <div class="card-body">

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="app_download_section">App Download
                                            Section</label>
                                        <div class="col col-form-label">
                                            <label class="form-check form-switch form-switch-3">
                                                <input class="form-check-input" name="app_download_section"
                                                    id="app_download_section" type="checkbox"
                                                    <?= (isset($web_settings['app_download_section']) && $web_settings['app_download_section'] == '1') ? 'Checked' : '' ?> />
                                            </label>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label required"
                                            for="app_download_section_title">Title</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="app_download_section_title"
                                                id="app_download_section_title"
                                                value="<?= (isset($web_settings['app_download_section_title'])) ? output_escaping($web_settings['app_download_section_title']) : '' ?>"
                                                placeholder="App download section title." />
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label required"
                                            for="app_download_section_tagline">Tagline</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="app_download_section_tagline"
                                                id="app_download_section_tagline"
                                                value="<?= (isset($web_settings['app_download_section_tagline'])) ? output_escaping($web_settings['app_download_section_tagline']) : '' ?>"
                                                placeholder="App download section tagline." />
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label required"
                                            for="app_download_section_short_description">Short Description</label>
                                        <div class="col">
                                            <input type="text" class="form-control"
                                                name="app_download_section_short_description"
                                                id="app_download_section_short_description"
                                                value="<?= (isset($web_settings['app_download_section_short_description'])) ? output_escaping($web_settings['app_download_section_short_description']) : '' ?>"
                                                placeholder="App download section short description." />
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label required"
                                            for="app_download_section_playstore_url">Playstore URL</label>
                                        <div class="col">
                                            <input type="text" class="form-control"
                                                name="app_download_section_playstore_url"
                                                id="app_download_section_playstore_url"
                                                value="<?= (isset($web_settings['app_download_section_playstore_url'])) ? output_escaping($web_settings['app_download_section_playstore_url']) : '' ?>"
                                                placeholder="App download section playstore URL." />
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label required"
                                            for="app_download_section_appstore_url">Appstore URL</label>
                                        <div class="col">
                                            <input type="text" class="form-control"
                                                name="app_download_section_appstore_url"
                                                id="app_download_section_appstore_url"
                                                value="<?= (isset($web_settings['app_download_section_appstore_url'])) ? output_escaping($web_settings['app_download_section_appstore_url']) : '' ?>"
                                                placeholder="App download section appstore URL." />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- social_media_links -->
                            <div class="card my-3" id="social_media_links">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="ti ti-brand-instagram"></i> Social Media Links</h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="twitter_link">Twitter Link</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="twitter_link"
                                                id="twitter_link"
                                                value="<?= (isset($web_settings['twitter_link'])) ? output_escaping($web_settings['twitter_link']) : '' ?>"
                                                placeholder="Twitter Link" />
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="facebook_link">Facebook Link</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="facebook_link"
                                                id="facebook_link"
                                                value="<?= (isset($web_settings['facebook_link'])) ? output_escaping($web_settings['facebook_link']) : '' ?>"
                                                placeholder="Facebook Link" />
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="instagram_link">Instagram Link</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="instagram_link"
                                                id="instagram_link"
                                                value="<?= (isset($web_settings['instagram_link'])) ? output_escaping($web_settings['instagram_link']) : '' ?>"
                                                placeholder="Instagram Link" />
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="youtube_link">Youtube Link</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="youtube_link"
                                                id="youtube_link"
                                                value="<?= (isset($web_settings['youtube_link'])) ? output_escaping($web_settings['youtube_link']) : '' ?>"
                                                placeholder="Youtube Link" />
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- feature_section -->
                            <div class="card my-3" id="feature_section">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="ti ti-section"></i> Feature Section</h3>
                                </div>

                                <div class="card-body">
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="shipping_mode">Shipping Mode</label>
                                        <div class="col">
                                            <label class="form-check form-switch form-switch-3">
                                                <input class="form-check-input" name="shipping_mode" id="shipping_mode"
                                                    type="checkbox" <?= (isset($web_settings['shipping_mode']) && $web_settings['shipping_mode'] == '1') ? 'Checked' : '' ?> />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label required" for="shipping_title">Shipping
                                            Title</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="shipping_title"
                                                id="shipping_title"
                                                value="<?= (isset($web_settings['shipping_title'])) ? output_escaping($web_settings['shipping_title']) : '' ?>"
                                                placeholder="Shipping Title" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="shipping_Description">Shipping
                                            Description</label>
                                        <div class="col">
                                            <textarea name="shipping_Description" class="textarea form-control"
                                                placeholder="Description"
                                                data-bs-toggle="autosize"><?= isset($web_settings['shipping_Description']) ? output_escaping(str_replace('\r\n', '&#13;&#10;', $web_settings['shipping_Description'])) : ""; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="return_mode">Return Mode</label>
                                        <div class="col">
                                            <label class="form-check form-switch form-switch-3">
                                                <input class="form-check-input" name="return_mode" id="return_mode"
                                                    type="checkbox" <?= (isset($web_settings['return_mode']) && $web_settings['return_mode'] == '1') ? 'Checked' : '' ?> />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label required" for="return_title">Return
                                            Title</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="return_title"
                                                id="return_title"
                                                value="<?= (isset($web_settings['return_title'])) ? output_escaping($web_settings['return_title']) : '' ?>"
                                                placeholder="Return Title" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="return_Description">Return
                                            Description</label>
                                        <div class="col">
                                            <textarea name="return_Description" class="textarea form-control"
                                                placeholder="Description"
                                                data-bs-toggle="autosize"><?= isset($web_settings['return_Description']) ? output_escaping(str_replace('\r\n', '&#13;&#10;', $web_settings['return_Description'])) : ""; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="support_mode">Support Mode</label>
                                        <div class="col">
                                            <label class="form-check form-switch form-switch-3">
                                                <input class="form-check-input" name="support_mode" id="support_mode"
                                                    type="checkbox" <?= (isset($web_settings['support_mode']) && $web_settings['support_mode'] == '1') ? 'Checked' : '' ?> />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label required" for="support_title">Support
                                            Title</label>
                                        <div class="col">
                                            <input type="text" class="form-control" name="support_title"
                                                id="support_title"
                                                value="<?= (isset($web_settings['support_title'])) ? output_escaping($web_settings['support_title']) : '' ?>"
                                                placeholder="Support Title" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="support_Description">Support
                                            Description</label>
                                        <div class="col">
                                            <textarea name="support_Description" class="textarea form-control"
                                                placeholder="Description"
                                                data-bs-toggle="autosize"><?= isset($web_settings['support_Description']) ? output_escaping(str_replace('\r\n', '&#13;&#10;', $web_settings['support_Description'])) : ""; ?></textarea>
                                        </div>
                                    </div>



                                </div>
                            </div>

                            <!-- theme_color_settings -->
                            <div class="card my-3" id="theme_color_settings">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="ti ti-color-filter"></i> Theme Color Settings</h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3 row">
                                        <label class="col-lg-3 col-md-4 col-form-label">Classic Theme Color</label>
                                        <div class="col-lg-9 col-md-8">
                                            <div class="row g-3 align-items-center">

                                                <div class="col-12 col-sm-4">
                                                    <label for="primary_color"
                                                        class="form-label text-center w-100">Primary</label>
                                                    <div class="d-flex justify-content-center">
                                                        <input type="color" class="form-control form-control-color"
                                                            style="width:70px; height:40px; padding:0;"
                                                            name="primary_color" id="primary_color"
                                                            value="<?= isset($web_settings['primary_color']) ? output_escaping($web_settings['primary_color']) : '' ?>">
                                                    </div>
                                                </div>

                                                <div class="col-12 col-sm-4">
                                                    <label for="secondary_color"
                                                        class="form-label text-center w-100">Secondary</label>
                                                    <div class="d-flex justify-content-center">
                                                        <input type="color" class="form-control form-control-color"
                                                            style="width:70px; height:40px; padding:0;"
                                                            name="secondary_color" id="secondary_color"
                                                            value="<?= isset($web_settings['secondary_color']) ? output_escaping($web_settings['secondary_color']) : '' ?>">
                                                    </div>
                                                </div>

                                                <div class="col-12 col-sm-4">
                                                    <label for="font_color"
                                                        class="form-label text-center w-100">Font</label>
                                                    <div class="d-flex justify-content-center">
                                                        <input type="color" class="form-control form-control-color"
                                                            style="width:70px; height:40px; padding:0;"
                                                            name="font_color" id="font_color"
                                                            value="<?= isset($web_settings['font_color']) ? output_escaping($web_settings['font_color']) : '' ?>">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>



                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label" for="modern_theme_color">Modern Theme
                                            Color</label>
                                        <div class="col">
                                            <select name="modern_theme_color" id="modern_theme_color"
                                                class="form-select">
                                                <?php
                                                $colors = [
                                                    'aqua' => 'Aqua',
                                                    'fuchsia' => 'Fuchsia',
                                                    'grape' => 'Grape',
                                                    'green' => 'Green',
                                                    'leaf' => 'Leaf',
                                                    'navy' => 'Navy',
                                                    'pink' => 'Pink',
                                                    'purple' => 'Purple',
                                                    'red' => 'Red',
                                                    'sky' => 'Sky',
                                                    'violet' => 'Violet'
                                                ];
                                                ?>
                                                <option value="default">Default</option>
                                                <?php foreach ($colors as $color_value => $color_name): ?>
                                                    <option value="<?= $color_value ?>"
                                                        <?= (isset($web_settings['modern_theme_color']) && $web_settings['modern_theme_color'] == $color_value) ? 'selected' : '' ?>><?= $color_name ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="space-y my-3">
                                        <div class="form-group text-end">
                                            <button type="reset" class="btn">Cancel</button>
                                            <button type="submit" class="btn btn-primary " id="submit_btn">Update
                                                Settings <i class="cursor-pointer ms-2 ti ti-arrow-right"></i></button>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </form>

                        <div class="modal fade" id="ReferAndEarnModal" tabindex="-1" role="dialog"
                            aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">How Refer and Earn work For referal
                                            and users?</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body ">
                                        <h4 class="text-bold">Field Details : </h4>
                                        <ol>
                                            <li>
                                                <div class="d-flex flex-column">
                                                    <p class="mb-0 fw-bold">Referal Code On / Off:</p>
                                                    <p>This is For if you want to on refer and earn functionality in
                                                        your system.</p>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="d-flex flex-column">
                                                    <p class="mb-0 fw-bold">Minimum Refer & Earn Order Amount :</p>
                                                    <p class="mb-0"><span class="text-bold"> Description :</span> This
                                                        is the minimum
                                                        order amount required for a referral to be considered valid for
                                                        earning rewards.
                                                    </p>
                                                    <p><span class="text-bold">Example : </span> if this amount is set
                                                        to $500, a
                                                        referred user must place an order of at least $500 for the
                                                        referrer to earn a
                                                        bonus.</p>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="d-flex flex-column">
                                                    <p class="mb-0 fw-bold"> Number of times Code can be redeemed:</p>
                                                    <p class="mb-0"><span class="text-bold"> Description :</span> This
                                                        specifies how
                                                        many times a referral code can be used by different users.</p>
                                                    <p><span class="text-bold">Example :</span> if the limit is set to
                                                        5, the referral
                                                        code can only be redeemed five times across different users.</p>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="d-flex flex-column">
                                                    <p class="mb-0 fw-bold">Refer & Earn Method For User :</p>
                                                    <p class="mb-0"><span class="text-bold"> Description:</span> This
                                                        indicates how the
                                                        user (the one who use the referral code) earns their reward when
                                                        they makes a
                                                        firat order. It could be in the form of a percentage of the
                                                        order amount or fix
                                                        amount.<br>
                                                    <p><span class="text-bold"> Example:</span> If the method is set as
                                                        "Fixed Amount,"
                                                        the user might earn $10 for each successful referral.</p>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="d-flex flex-column">
                                                    <p class="mb-0 fw-bold"> Refer & Earn Bonus For User :</p>
                                                    <p class="mb-0"><span class="text-bold"> Description:</span> This is
                                                        the actual
                                                        bonus or reward amount the user(the one who use the referral
                                                        code) earns per
                                                        successful referral. The bonus could be a fixed amount, a
                                                        percentage of the
                                                        first order.</p>
                                                    <p><span class="text-bold"> Example:</span> If the bonus is set to
                                                        $10, the referrer
                                                        earns $10 for user(the one who use the referral code) first
                                                        order.</p>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="d-flex flex-column">
                                                    <p class="mb-0 fw-bold"> Maximum Refer & Earn Amount For User :</p>
                                                    <p class="mb-0"><span class="text-bold"> Description:</span> This is
                                                        the maximum
                                                        total amount a user can earn through the referral program. Once
                                                        this limit is
                                                        reached, the user can no longer earn rewards from further
                                                        referrals.</p>
                                                    <p><span class="text-bold"> Example:</span> If the maximum amount is
                                                        set to $100,
                                                        the user can earn up to $100 cashback, after which no more
                                                        rewards will be
                                                        given.</p>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="d-flex flex-column">
                                                    <p class="mb-0 fw-bold"> Refer & Earn Method For Referral :</p>
                                                    <p class="mb-0"><span class="text-bold"> Description:</span> This
                                                        specifies how the
                                                        referred person (the one who share the referral code) receives
                                                        their reward.
                                                        Like the referrer, the referral can also receive a reward in
                                                        cashback.</p>
                                                    <p><span class="text-bold"> Example:</span> The method could be a
                                                        "Fixed Amount"
                                                        giving the referred user 100$ off their first purchase.</p>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="d-flex flex-column">
                                                    <P class="mb-0 fw-bold">Refer & Earn Bonus For Referral :</P>
                                                    <P class="mb-0"><span class="text-bold"> Description: </span> This
                                                        is the bonus or
                                                        reward that the referred person receives when they use the
                                                        referral code and
                                                        complete a qualifying action, such as making a purchase.</P>
                                                    <P class="mb-0"><span class="text-bold">Example:</span> If the bonus
                                                        is $50 off
                                                        their first purchase of user(the one who use the referral code),
                                                        the referal(the
                                                        one who share the referral code) receives a $50 for user order.
                                                    </P>
                                                </div>
                                            </li>

                                        </ol>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary bg-secondary-lt"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary bg-primary-lt"
                                            data-bs-dismiss="modal">Got it!</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="how-cashback-discount-work" tabindex="-1" role="dialog"
                            aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">How Promo Code Discount will get
                                            credited?</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body ">
                                        <ol>
                                            <li>Cron job must be set on your server for Promo Code Discount to be work.
                                            </li>

                                            <li> Cron job will run every mid night at 12:00 AM. </li>

                                            <li> Formula for Add Promo Code Discount is <b>Sub total (Excluding delivery
                                                    charge) - promo
                                                    code discount percentage / Amount</b> </li>

                                            <li> For example sub total is 1300 and promo code discount is 100 then 1300
                                                - 100 = 1200 so
                                                100 will get credited into Users's wallet </li>

                                            <li> If Order status is delivered And Return Policy is expired then only
                                                users will get
                                                Promo Code Discount. </li>

                                            <li> Ex - 1. Order placed on 10-Sep-22 and return policy days are set to 1
                                                so 10-Sep + 1
                                                days = 11-Sep Promo code discount will get credited on 11-Sep-22 at
                                                12:00 AM (Mid night)
                                            </li>

                                            <li> If Promo Code Discount doesn't works make sure cron job is set properly
                                                and it is
                                                working. If you don't know how to set cron job for once in a day please
                                                take help of
                                                server support or do search for it. </li>
                                        </ol>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary bg-secondary-lt"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary bg-primary-lt"
                                            data-bs-dismiss="modal">Got it!</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="how-settle-seller-commission-work" tabindex="-1" role="dialog"
                            aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">How seller commission will get
                                            credited?</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body ">
                                        <ol>
                                            <li>
                                                Cron job must be set (For once in a day) on your server for seller
                                                commission to be
                                                work.
                                            </li>
                                            <li>
                                                Cron job will run every mid night at 12:00 AM.
                                            </li>
                                            <li>
                                                Formula for seller commision is <b>Sub total (Excluding delivery charge)
                                                    / 100 * seller
                                                    commission percentage</b>
                                            </li>
                                            <li>
                                                For example sub total is 1378 and seller commission is 20% then 1378 /
                                                100 X 20 = 275.6
                                                so 1378 - 275.6 = 1102.4 will get credited into seller's wallet
                                            </li>
                                            <li>
                                                If Order item's status is delivered then only seller will get
                                                commisison.
                                            </li>
                                            <li>
                                                Ex - 1. Order placed on 11-Aug-21 and product return days are set to 0
                                                so 11-Aug + 0
                                                days = 11-Aug seller commission will get credited on 12-Aug-21 at 12:00
                                                AM (Mid night)
                                            </li>
                                            <li>
                                                Ex - 2. Order placed on 11-Aug-21 and product return days are set to 7
                                                so 11-Aug + 7
                                                days = 18-Aug seller commission will get credited on 19-Aug-21 at 12:00
                                                AM (Mid night)
                                            </li>
                                            <li>
                                                If seller commission doesn't works make sure cron job is set properly
                                                and it is working.
                                                If you don't know how to set cron job for once in a day please take help
                                                of server
                                                support or do search for it.
                                            </li>
                                        </ol>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary bg-secondary-lt"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary bg-primary-lt"
                                            data-bs-dismiss="modal">Got it!</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>