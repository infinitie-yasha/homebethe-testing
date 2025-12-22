<div class="page-wrapper">

    <div class="page">

        <!-- BEGIN PAGE HEADER -->
        <div class="page-header d-print-none" aria-label="Page header">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col-12 col-md-6">
                        <h2 class="page-title">Firebase Settings</h2>
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
                                    <a href="#">Firebase Settings</a>
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
                        <div class="card-header">
                            <h3 class="card-title"><i class="ti ti-brand-firebase"></i> Firebase Settings</h3>
                        </div>
                        <div class="card-body">
                            <form x-data="ajaxForm({
                                            url: base_url + 'admin/web-setting/store_firebase',
                                            modalId: '',
                                            loaderText: 'Saving...'
                                        })" method="POST" class="form-horizontal" id="firebase_form"
                                enctype="multipart/form-data">
                                <div class="mb-3 row">
                                    <label class="col-12 col-sm-4 col-form-label required" for="apiKey">API Key</label>
                                    <div class="col">
                                        <input type="text" class="form-control" name="apiKey"
                                            placeholder="Enter API Key" id="apiKey"
                                            value="<?= (isset($firebase_settings['apiKey'])) ? $firebase_settings['apiKey'] : '' ?>" />
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-12 col-sm-4 col-form-label required" for="authDomain">authDomain</label>
                                    <div class="col">
                                        <input type="text" class="form-control" name="authDomain"
                                            placeholder="Enter authDomain" id="authDomain"
                                            value="<?= (isset($firebase_settings['authDomain'])) ? $firebase_settings['authDomain'] : '' ?>" />
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-12 col-sm-4 col-form-label required" for="databaseURL">Database URL</label>
                                    <div class="col">
                                        <input type="text" class="form-control" name="databaseURL"
                                            placeholder="Enter Database URL" id="databaseURL"
                                            value="<?= (isset($firebase_settings['databaseURL'])) ? $firebase_settings['databaseURL'] : '' ?>" />
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-12 col-sm-4 col-form-label required" for="projectId">Project ID</label>
                                    <div class="col">
                                        <input type="text" class="form-control" name="projectId"
                                            placeholder="Enter Project ID" id="projectId"
                                            value="<?= (isset($firebase_settings['projectId'])) ? $firebase_settings['projectId'] : '' ?>" />
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-12 col-sm-4 col-form-label required" for="storageBucket">Storage
                                        Bucket</label>
                                    <div class="col">
                                        <input type="text" class="form-control" name="storageBucket"
                                            placeholder="Enter Storage Bucket" id="storageBucket"
                                            value="<?= (isset($firebase_settings['storageBucket'])) ? $firebase_settings['storageBucket'] : '' ?>" />
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-12 col-sm-4 col-form-label required" for="messagingSenderId">Messaging
                                        Sender ID</label>
                                    <div class="col">
                                        <input type="text" class="form-control" name="messagingSenderId"
                                            placeholder="Enter Messaging Sender ID" id="messagingSenderId"
                                            value="<?= (isset($firebase_settings['messagingSenderId'])) ? $firebase_settings['messagingSenderId'] : '' ?>" />
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-12 col-sm-4 col-form-label required" for="appId">App ID</label>
                                    <div class="col">
                                        <input type="text" class="form-control" name="appId" placeholder="Enter App ID"
                                            id="appId"
                                            value="<?= (isset($firebase_settings['appId'])) ? $firebase_settings['appId'] : '' ?>" />
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-12 col-sm-4 col-form-label required" for="measurementId">Measurement
                                        ID</label>
                                    <div class="col">
                                        <input type="text" class="form-control" name="measurementId"
                                            placeholder="Enter Measurement ID" id="measurementId"
                                            value="<?= (isset($firebase_settings['measurementId'])) ? $firebase_settings['measurementId'] : '' ?>" />
                                    </div>
                                </div>



                                <div class="space-y mt-5">

                                    <div class="form-group text-end">
                                        <button type="reset" class="btn">Cancel</button>
                                        <button type="submit" class="btn btn-primary" id="submit_btn">Update Settings <i
                                                class="cursor-pointer ms-2 ti ti-arrow-right"></i></button>
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