<!-- END NAVBAR  -->
<div class="page-wrapper">
    <!-- BEGIN PAGE HEADER -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">chat</h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="d-flex">
                        <ol class="breadcrumb breadcrumb-arrows">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('seller/home') ?>">Home</a>
                            </li>

                            <li class="breadcrumb-item active">
                                <a href="#">chat</a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- BEGIN PAGE BODY -->
    <div class="page-body">
        <div class="container-xl flex-fill d-flex flex-column">
            <div class="card flex-fill">
                <div class="row g-0 flex-fill">
                    <div class="col-12 col-lg-5 col-xl-3 border-end d-flex flex-column">
                        <!-- user selection list  -->
                        <div class="card-header d-none d-md-block" x-data x-init="
                         new TomSelect($refs.userSelect, {
                           create: false,
                           maxItems: 1,
                           placeholder: 'Type to search and select users',
                           sortField: { field: 'text', direction: 'asc' },
                         });
                       ">

                            <div class="input-icon w-100">
                                <span class="input-icon-addon">
                                    <i class="ti ti-search"></i>
                                </span>

                                <select x-ref="userSelect" name="select_user_id[]" id="chat_user"
                                    class="form-control w-100" autocomplete="off">
                                    <option value="">Select User...</option>
                                    <?php
                                    $user_details = fetch_details('users', ['active' => 1]);
                                    if (!empty($user_details)) {
                                        foreach ($user_details as $user) {
                                            $username = !empty($user['opponent_username']) ? $user['opponent_username'] : $user['username'];
                                            echo '<option value="' . $user['id'] . '">' . htmlspecialchars($username) . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="card-body p-0 scrollable flex-fill">

                            <!-- Personal Chat Section -->
                            <div class="card-header py-2 border-bottom">
                                <h4 class="m-0 fs-3">Personal Chat</h4>
                            </div>

                            <div class="nav flex-column nav-pills" role="tablist" id="personal-chat-list">

                                <?php if (!empty($users)) { ?>
                                    <?php foreach ($users as $user) {
                                        $isYou = ($user['opponent_user_id'] == $_SESSION['user_id']);
                                        $isOnline = ($user['is_online'] == 1);
                                        $avatar = !empty($user['picture']) ? base_url($user['picture']) : base_url('assets/img/default-avatar.png');
                                        $username = htmlspecialchars($user['opponent_username']);
                                        $unread = isset($user['unread_msg']) ? (int) $user['unread_msg'] : 0;
                                    ?>

                                        <a href="#"
                                            class="nav-link text-start mw-100 p-3 d-flex align-items-center chat-person <?= ($unread > 0) ? 'bg-light' : '' ?>"
                                            data-id="<?= $user['opponent_user_id'] ?>" data-type="person"
                                            data-picture="<?= $avatar ?>" data-unread_msg="<?= $unread ?>" role="tab">

                                            <div class="row align-items-center flex-fill">
                                                <div class="col-auto position-relative">
                                                    <span class="avatar avatar-1"
                                                        style="background-image: url('<?= $avatar ?>')"></span>
                                                    <i
                                                        class="<?= $isOnline ? 'fas fa-circle text-success' : 'far fa-circle text-secondary' ?> position-absolute bottom-0 end-0 small"></i>
                                                </div>

                                                <div class="col text-body">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="fw-semibold">
                                                            <?= $isYou ? $username . ' (You)' : $username ?>
                                                        </div>
                                                        <?php if ($unread > 0): ?>
                                                            <span
                                                                class="badge bg-primary-lt ms-2"><?= ($unread > 9) ? '9+' : $unread ?></span>
                                                        <?php endif; ?>
                                                    </div>

                                                    <div class="text-secondary text-truncate w-100">
                                                        <?= !empty($user['last_message']) ? htmlspecialchars($user['last_message']) : 'No messages yet.' ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>

                                    <?php } ?>
                                <?php } else { ?>
                                    <div class="text-center text-muted py-3">No personal chats found.</div>
                                <?php } ?>
                            </div>

                            <!-- Support Chat -->
                            <div class="card-header py-2 border-top border-bottom mt-2">
                                <h4 class="m-0 fs-3">
                                    <?= !empty($this->lang->line('support_chat')) ? $this->lang->line('support_chat') : 'Support Team'; ?>
                                </h4>
                            </div>

                            <div class="nav flex-column nav-pills" role="tablist" id="support-chat-list">
                                <?php if (!empty($supporters)) { ?>
                                    <?php foreach ($supporters as $supporter) {
                                        $isOnline = isset($supporter['is_online']) && $supporter['is_online'] == 1;
                                        $avatar = !empty($supporter['picture']) ? base_url($supporter['picture']) : base_url('assets/img/default-avatar.png');
                                        $username = htmlspecialchars($supporter['username']);
                                    ?>
                                        <a href="#" class="nav-link text-start mw-100 p-3 d-flex align-items-center chat-person"
                                            data-id="<?= $supporter['userto_id'] ?>" data-type="support"
                                            data-picture="<?= $avatar ?>" role="tab">

                                            <div class="row align-items-center flex-fill">
                                                <div class="col-auto position-relative">
                                                    <span class="avatar avatar-1"
                                                        style="background-image: url('<?= $avatar ?>')"></span>
                                                    <i
                                                        class="<?= $isOnline ? 'fas fa-circle text-success' : 'far fa-circle text-secondary' ?> position-absolute bottom-0 end-0 small"></i>
                                                </div>
                                                <div class="col text-body">
                                                    <div class="fw-semibold"><?= $username ?></div>
                                                    <div class="text-secondary text-truncate w-100">Support Team Member</div>
                                                </div>
                                            </div>
                                        </a>
                                    <?php } ?>
                                <?php } else { ?>
                                    <div class="text-center text-muted py-3">No support agents available.</div>
                                <?php } ?>
                            </div>




                        </div>

                    </div>
                    <div class="col-12 col-lg-9 d-flex justify-content-center align-items-center vh-100"
                        id="chat_area_wait">
                        <div class="text-center text-muted">
                            <i class="ti ti-message-circle-2 text-primary display"></i>
                            <p class="mt-2 mb-0 fs-3">Select a user to start chatting</p>
                        </div>
                    </div>

                    <div class="col-12 col-lg-9 d-none" id="chat_area">
                        <div class="card card-body border-0 shadow-sm scrollable" id="mychatbox2">
                            <!-- Chat Header -->
                            <!-- <div class="card-header d-flex align-items-center bg-body-tertiary">
                <div id="chat-avtar-main" class="me-3">
                  <span class="avatar avatar-sm bg-primary text-white fw-bold">#</span>
                </div>
                <div class="flex-fill">
                  <div id="chat_title" class="fw-bold fs-6">Chat Title</div>
                </div>
                <div id="chat_online_status" class="text-success small">Online</div>
              </div> -->

                            <!-- Chat Body -->
                            <div id="chat-box-content" class="chat-content chat-bubbles overflow-none p-2 vh-100">
                                <div class="chat">
                                    <div class="chat-bubbles" id="chat-bubbles">
                                        <div class="text-center text-muted mt-5 chat_loader">
                                            <div class="spinner-border text-primary" role="status"></div>
                                            <p class="mt-3 mb-0">Loading messages...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- File Upload / Dropbox -->
                            <div class="card-body d-none" id="chat-dropbox">
                                <div class="dropzone" id="myAlbum"></div>
                                <div class="text-center mt-3">
                                    <button class="btn btn-outline-danger btn-sm" onclick="closeDropZone()">
                                        <i class="ti ti-x me-1"></i> Close
                                    </button>
                                </div>
                            </div>



                        </div>
                        <!-- Chat Input -->
                        <div class="card-footer bg-body border-top chat-input-footer">
                            <form id="chat-form2" autocomplete="off" class="d-flex flex-column ">
                                <input type="hidden" id="opposite_user_id" name="opposite_user_id">
                                <input type="hidden" id="my_user_id" name="my_user_id"
                                    value="<?= $_SESSION['user_id'] ?>">
                                <input type="hidden" id="chat_type" name="chat_type">

                                <div class="input-group align-items-center">
                                    <!-- Message Input -->
                                    <textarea class="form-control flex-grow-1 border-0 shadow-none"
                                        id="chat-input-textarea" name="chat-input-textarea" rows="1"
                                        placeholder="Type your message..."
                                        style="resize: none; min-height: 45px;"></textarea>

                                    <!-- Attach File Button -->
                                    <button type="button" class="btn btn-link text-muted px-2" onclick="showDropZone()"
                                        title="Attach File">
                                        <i class="ti ti-paperclip fs-3"></i>
                                    </button>

                                    <!-- Send Button -->
                                    <button type="submit" class="btn btn-link btn-sm text-decoration-none"
                                        title="Send Message">
                                        <i class="ti ti-send fs-3"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE BODY -->

</div>
</div>



<script>
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('<?= base_url('/firebase-messaging-sw.js'); ?>')
            .then(function(registration) {
                console.log('Service Worker registered with scope:', registration.scope);
            })
            .catch(function(error) {
                console.error('Service Worker registration failed:', error);
            });
    }
</script>

<script defer type="text/babel" src="https://www.gstatic.com/firebasejs/9.23.0/firebase-app.js"></script>
<script defer type="text/babel" src="https://www.gstatic.com/firebasejs/9.23.0/firebase-auth.js"></script>
<script defer type="text/babel" src="https://www.gstatic.com/firebasejs/9.23.0/firebase-messaging.js"></script>
<!-- chat -->

<script type="text/javascript" src="<?= base_url('assets/admin/js/Markdown.Converter.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/admin/js/Markdown.Sanitizer.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/admin/js/Markdown.Editor.js'); ?>"></script>

<script type="module" src="<?= base_url('assets/seller/components-chat-box.js') ?>"></script>
</body>

</html>