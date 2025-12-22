<!DOCTYPE html>
<html>

<?php $this->load->view('admin/include-css.php'); ?>
<div id="loading">
    <div class="lds-ring">
        <div></div>
    </div>
</div>

<body class="hold-transition sidebar-mini layout-fixed ">
    <div class="page">
        <?php $this->load->view('admin/include-sidebar.php'); ?>
        <?php $this->load->view('layouts/toast.php'); ?>
        <?php $this->load->view('layouts/filter_offcanvas.php'); ?>
        <?php $this->load->view('admin/include-navbar.php') ?>

        <button id="filterOffcanvasTrigger" type="button" class="d-none" data-bs-toggle="offcanvas"
            data-bs-target="#filterOffcanvas"></button>


        <?php if (isset($_GET['error']) && $_GET['error'] === "true"): ?>
            <?php
            $api = isset($_GET['api']) ? htmlspecialchars($_GET['api']) : "unknown";
            $httpStatus = isset($_GET['http_status']) ? (int) $_GET['http_status'] : 0;
            ?>

            <div class="container mt-4">
                <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded" role="alert">
                    <h5 class="alert-heading">⚠️ CSRF Token Missing</h5>
                    <p>
                        The request to <code><?= $api ?></code> failed because the CSRF token was not provided or expired.
                    </p>
                    <p>
                        <strong>HTTP Status:</strong> <?= $httpStatus ?>
                    </p>

                    <hr>
                    <p class="mb-0">
                        Please refresh the page and try again.
                    </p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
            <div id="errorText">

            </div>

            <script>
                (function () {
                    const params = new URLSearchParams(window.location.search);
                    let errorResponse = localStorage.getItem("errorResponse", "");
                    if (errorResponse !== "") {
                        localStorage.setItem("errorResponse", "");
                        console.log(errorResponse)
                        document.getElementById(errorText).innerText = errorResponse
                    }
                    // Remove known query parameters
                    params.delete("error");
                    params.delete("api");
                    params.delete("http_status");

                    const newUrl =
                        window.location.pathname + (params.toString() ? "?" + params.toString() : "");

                    // Update URL without reloading
                    window.history.replaceState({}, document.title, newUrl);
                })();
            </script>
        <?php endif; ?>


        <?php $this->load->view('admin/pages/' . $main_page); ?>
        <?php $this->load->view('admin/include-footer.php'); ?>
    </div>
    <?php $this->load->view('admin/include-script.php'); ?>
</body>

</html>