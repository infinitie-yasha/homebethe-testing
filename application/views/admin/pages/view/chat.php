<!-- END NAVBAR -->
<div class="page-wrapper">
  <div class="page">
    <!-- BEGIN PAGE HEADER -->
    <div class="page-header d-print-none" aria-label="Page header">
      <div class="container-xl">
        <div class="row g-2 align-items-center flex-column flex-md-row">
          <div class="col">
            <h2 class="page-title mb-2 mb-md-0"><i class="ti ti-message-circle"></i> Chat</h2>
          </div>
          <div class="col-auto ms-md-auto d-print-none">
            <div class="d-flex flex-wrap justify-content-md-end gap-2">
              <ol class="breadcrumb breadcrumb-arrows mb-0" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/home') ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Support Desk</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="#">Chat</a></li>
              </ol>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- END PAGE HEADER -->
    <!-- BEGIN PAGE BODY -->
    <div class="page-body">
      <div class="container-xl flex-fill d-flex flex-column">
        <div class="card flex-fill">
          <div class="row g-0 flex-fill flex-column flex-lg-row">
            
            <!-- Sidebar -->
            <div class="col-12 col-lg-4 col-xl-3 border-end d-flex flex-column p-0">
              <!-- user selection -->
              <div class="card-header  d-md-block p-3" 
                   x-data 
                   x-init="
                     new TomSelect($refs.userSelect, {
                       create: false,
                       maxItems: 1,
                       placeholder: 'Type to search and select users',
                       sortField: { field: 'text', direction: 'asc' },
                     });
                   ">
                <div class="input-icon w-100">
                  <span class="input-icon-addon"><i class="ti ti-search"></i></span>
                  <select x-ref="userSelect" name="select_user_id[]" id="chat_user" class="form-control w-100" autocomplete="off">
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

              <!-- Chat Lists -->
              <div class="card-body p-0 scrollable flex-fill">
                <!-- Personal Chat -->
                <div class="card-header py-2 border-bottom">
                  <h4 class="m-0 fs-4">Personal Chat</h4>
                </div>

                <div class="nav flex-column nav-pills" role="tablist" id="personal-chat-list">
                  <?php if (!empty($users)) { ?>
                    <?php foreach ($users as $user) {
                      $isYou = ($user['opponent_user_id'] == $_SESSION['user_id']);
                      $isOnline = ($user['is_online'] == 1);
                      $avatar = !empty($user['picture']) ? base_url($user['picture']) : base_url('assets/img/default-avatar.png');
                      $username = htmlspecialchars($user['opponent_username']);
                      $unread = isset($user['unread_msg']) ? (int)$user['unread_msg'] : 0;
                    ?>
                      <a href="#"
                         class="nav-link text-start mw-100 p-3 d-flex align-items-center chat-person <?= ($unread > 0) ? 'bg-light' : '' ?>"
                         data-id="<?= $user['opponent_user_id'] ?>"
                         data-type="person"
                         data-picture="<?= $avatar ?>"
                         data-unread_msg="<?= $unread ?>"
                         role="tab">
                        <div class="row align-items-center flex-fill g-1">
                          <div class="col-auto position-relative">
                            <span class="avatar avatar-1" style="background-image: url('<?= $avatar ?>')"></span>
                            <i class="<?= $isOnline ? 'fas fa-circle text-success' : 'far fa-circle text-secondary' ?> position-absolute bottom-0 end-0 small"></i>
                          </div>
                          <div class="col text-body text-truncate">
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                              <div class="fw-semibold text-truncate"><?= $isYou ? $username . ' (You)' : $username ?></div>
                              <?php if ($unread > 0): ?>
                                <span class="badge bg-primary-lt ms-2"><?= ($unread > 9) ? '9+' : $unread ?></span>
                              <?php endif; ?>
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
                  <h4 class="m-0 fs-4"><?= !empty($this->lang->line('support_chat')) ? $this->lang->line('support_chat') : 'Support Team'; ?></h4>
                </div>

                <div class="nav flex-column nav-pills" role="tablist" id="support-chat-list">
                  <?php if (!empty($supporters)) { ?>
                    <?php foreach ($supporters as $supporter) {
                      $isOnline = isset($supporter['is_online']) && $supporter['is_online'] == 1;
                      $avatar = !empty($supporter['picture']) ? base_url($supporter['picture']) : base_url('assets/img/default-avatar.png');
                      $username = htmlspecialchars($supporter['username']);
                    ?>
                      <a href="#" class="nav-link text-start mw-100 p-3 d-flex align-items-center chat-person"
                         data-id="<?= $supporter['userto_id'] ?>"
                         data-type="support"
                         data-picture="<?= $avatar ?>"
                         role="tab">
                        <div class="row align-items-center flex-fill g-1">
                          <div class="col-auto position-relative">
                            <span class="avatar avatar-1" style="background-image: url('<?= $avatar ?>')"></span>
                            <i class="<?= $isOnline ? 'fas fa-circle text-success' : 'far fa-circle text-secondary' ?> position-absolute bottom-0 end-0 small"></i>
                          </div>
                          <div class="col text-body">
                            <div class="fw-semibold text-truncate"><?= $username ?></div>
                            <div class="text-secondary text-truncate w-100 small">Support Team Member</div>
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

            <!-- Chat Area -->
            <div class="col-12 col-lg-8 col-xl-9 d-flex flex-column p-0">
              <!-- Placeholder -->
              <div class="flex-grow-1 d-flex justify-content-center align-items-center p-3" id="chat_area_wait">
                <div class="text-center text-muted">
                  <i class="ti ti-message-circle-2 text-primary fs-1"></i>
                  <p class="mt-2 mb-0 fs-5">Select a user to start chatting</p>
                </div>
              </div>

              <!-- Chat Active -->
              <div class="d-none flex-column flex-grow-1 h-100" id="chat_area">
                <div class="card card-body border-0 shadow-sm scrollable flex-grow-1" id="mychatbox2">
         <div id="chat-box-content" class="chat-content chat-bubbles p-2" style="height:600px; overflow-y:auto;">

                    <div class="chat">
                      <div class="chat-bubbles" id="chat-bubbles">
                        <div class="text-center text-muted mt-5 chat_loader">
                          <div class="spinner-border text-primary" role="status"></div>
                          <p class="mt-3 mb-0">Loading messages...</p>
                        </div>
                      </div>
                    </div>
                  </div>

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
                  <form id="chat-form2" autocomplete="off" class="d-flex flex-column gap-2">
                    <input type="hidden" id="opposite_user_id" name="opposite_user_id">
                    <input type="hidden" id="my_user_id" name="my_user_id" value="<?= $_SESSION['user_id'] ?>">
                    <input type="hidden" id="chat_type" name="chat_type">

                    <div class="input-group align-items-center flex-wrap">
                      <textarea class="form-control flex-grow-1 border-0 shadow-none"
                                id="chat-input-textarea"
                                name="chat-input-textarea"
                                rows="1"
                                placeholder="Type your message..."
                                style="resize:none;min-height:45px;"></textarea>

                      <button type="button" class="btn btn-link text-muted px-2" onclick="showDropZone()" title="Attach File">
                        <i class="ti ti-paperclip fs-4"></i>
                      </button>
                      <button type="submit" class="btn btn-link text-decoration-none px-2" title="Send Message">
                        <i class="ti ti-send fs-4"></i>
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

          </div> <!-- /row -->
        </div> <!-- /card -->
      </div> <!-- /container -->
    </div> <!-- /page-body -->
  </div>
</div>

<!-- Firebase + Chat JS -->
<script>
if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('<?= base_url('/firebase-messaging-sw.js'); ?>')
    .then(reg => console.log('Service Worker registered:', reg.scope))
    .catch(err => console.error('Service Worker registration failed:', err));
}
</script>

<script defer src="https://www.gstatic.com/firebasejs/9.23.0/firebase-app.js"></script>
<script defer src="https://www.gstatic.com/firebasejs/9.23.0/firebase-auth.js"></script>
<script defer src="https://www.gstatic.com/firebasejs/9.23.0/firebase-messaging.js"></script>
<script defer type="module" src="<?= base_url('assets/admin/js/components-chat-box.js') ?>"></script>
