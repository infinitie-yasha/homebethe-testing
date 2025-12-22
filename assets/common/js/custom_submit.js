"use strict";

// document.addEventListener('alpine:init', () => {
//     Alpine.data('ajaxForm', (config = {}) => ({
//         // Default configuration
//         form: null,
//         isLoading: false,
//         loaderText: config.loaderText || 'Submitting...',
//         url: config.url || '',
//         modalId: config.modalId || null,
//         offcanvasId: config.offcanvasId || null,
//         switchModal: config.switchModal || null,
//         error: null,
//         success: null,

//         // Initialize the form
//         init() {
//             this.form = this.$el;
//             this.url = config.url || this.form.action;

//             // Bind submit event
//             this.form.addEventListener('submit', (e) => {
//                 e.preventDefault();
//                 this.submitForm();
//             });
//         },

//         // Handle form submission with Axios
//         async submitForm() {
//             this.isLoading = true;
//             this.error = null;
//             this.success = null;

//             try {

//                 // ✅ Sync HugeRTE editors before collecting form data
//                 // document.querySelectorAll('textarea[data-hugerte]').forEach((el) => {
//                 //     let editorId = el.id;
//                 //     if (typeof hugeRTE !== 'undefined' && hugeRTE.get(editorId)) {
//                 //         el.value = hugeRTE.get(editorId).getContent();
//                 //     }
//                 // });


//                 const formData = new FormData(this.form);
//                 const response = await axios({
//                     method: this.form.method || 'POST',
//                     url: this.url,
//                     data: formData,
//                     headers: {
//                         'X-Requested-With': 'XMLHttpRequest',
//                     },
//                 });


//                 let responseData = JSON.parse(response.request.response);

//                 if (responseData.error === false) {
//                     // Pass switchModal config to the success handler
//                     ajaxFormOnSuccess(responseData, this.form, this.modalId, this.switchModal, this.offcanvasId);
//                 } else {
//                     ajaxFormOnError(responseData, this.form);
//                 }
//             } catch (err) {


//                 // const fallbackRes = {
//                 //     message: err.response?.data?.message || 'An error occurred while submitting the form'
//                 // };
//                 // this.error = fallbackRes.message;
//                 // ajaxFormOnError(fallbackRes, this.form);
//             } finally {
//                 this.isLoading = false;
//             }
//         }
//     }));
// });

document.addEventListener('alpine:init', () => {
    Alpine.data('ajaxForm', (config = {}) => ({
        // Default configuration
        form: null,
        isLoading: false,
        loaderText: config.loaderText || 'Submitting...',
        url: config.url || '',
        modalId: config.modalId || null,
        offcanvasId: config.offcanvasId || null,
        switchModal: config.switchModal || null,
        error: null,
        success: null,

        // Initialize the form
        init() {
            this.form = this.$el;
            this.url = config.url || this.form.action;

            // Bind submit event
            this.form.addEventListener('submit', (e) => {
                e.preventDefault();
                this.submitForm();
            });
        },

        // Handle form submission with Axios
        async submitForm() {
            this.isLoading = true;
            this.error = null;
            this.success = null;

            // 🔹 Find and store all submit buttons (in case form has more than one)
            const submitBtns = this.form.querySelectorAll('[type="submit"]');
            submitBtns.forEach(btn => {
                btn.disabled = true;
                btn.dataset.originalHtml = btn.innerHTML;
                btn.innerHTML = `<i class="fa fa-spinner fa-spin"></i> Please Wait...`;
            });

            try {


                // ✅ If you’re using HugeRTE editor, sync its content before submitting
                document.querySelectorAll('.hugerte-mytextarea').forEach((el) => {

                    let editorId = el.id;   // "about_us_editor"

                    if (typeof hugeRTE !== 'undefined' && hugeRTE.get(editorId)) {
                        el.value = hugeRTE.get(editorId).getContent();
                    }
                });

                const formData = new FormData(this.form);
                // console.log(this.form);
                const response = await axios({
                    method: this.form.method || 'POST',
                    url: this.url,
                    data: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });

                let responseData = JSON.parse(response.request.response);

                if (responseData.error === false) {
                    // Pass switchModal config to the success handler
                    ajaxFormOnSuccess(responseData, this.form, this.modalId, this.switchModal, this.offcanvasId);
                } else {
                    ajaxFormOnError(responseData, this.form);
                }

            } catch (err) {
                // Optional: handle error logging here
                // const fallbackRes = {
                //     message: err.response?.data?.message || 'An error occurred while submitting the form'
                // };
                // this.error = fallbackRes.message;
                // ajaxFormOnError(fallbackRes, this.form);
            } finally {
                // 🔹 Re-enable all submit buttons and restore their text
                submitBtns.forEach(btn => {
                    btn.disabled = false;
                    if (btn.dataset.originalHtml) {
                        btn.innerHTML = btn.dataset.originalHtml;
                    }
                });
                this.isLoading = false;
            }
        }
    }));
});




// Global Success Handler
function ajaxFormOnSuccess(res, form, modalId = null, switchModal = null, openOffcanvas = null) {
    // console.log(modalId);
    try {
        // Replace $.notify with showToast, use default green success styling
        showToast(res.message || "Action successful!", "success");

        // Handle redirect if redirect_url is present




        if (res.redirect_url) {
            setTimeout(() => {
                window.location.href = res.redirect_url;
            }, 1000); // Small delay to show success message
            return;
        }

        // Close any open offcanvas and reload page

        if (openOffcanvas) {
            try {
                let offcanvasEl = openOffcanvas;


                // If openOffcanvas is passed as an ID string (e.g., "addTax")
                if (typeof openOffcanvas === 'string') {
                    offcanvasEl = document.getElementById(openOffcanvas);
                }

                if (offcanvasEl) {
                    // Reset the form immediately
                    if (form?.reset) form.reset();

                    // Fallback: close with jQuery/Bootstrap method
                    $(offcanvasEl).offcanvas('hide');

                    // Wait a bit then clean up
                    setTimeout(() => {
                        if (form?.reset) form.reset();
                        document.querySelectorAll('.offcanvas-backdrop').forEach(backdrop => backdrop.remove());
                        document.body.classList.remove('modal-open', 'offcanvas-open');
                        document.body.style.overflow = '';
                        document.body.style.paddingRight = '';
                        $('.table-striped').bootstrapTable('refresh');
                    }, 400);
                    // }
                } else {
                    console.warn("⚠️ Offcanvas element not found for:", openOffcanvas);
                }
            } catch (offcanvasError) {
                console.error("Error closing offcanvas:", offcanvasError);
            }

            return;
        }


        // Modal handling code unchanged
        if (modalId) {

            const modalEl = document.getElementById(modalId);

            if (!modalEl) {
                console.error("❌ Modal element not found! Check modalId:", modalId);
            } else {
                $(modalEl).modal('hide');
                $(modalEl).on('hidden.bs.modal', function () {
                    $('.modal-backdrop').remove();
                    $('body').removeClass('modal-open');
                    $('.table-striped').bootstrapTable('refresh');
                    if (switchModal) {
                        const switchModalEl = document.getElementById(switchModal);
                        if (switchModalEl) {
                            $(switchModalEl).modal('show');

                        } else {
                            console.error("❌ Switch modal element not found! Check switchModal:", switchModal);
                        }
                    }
                });
            }
        }
        if (modalId == null) {
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        }
        if (form?.reset) form.reset();
    } catch (error) {
        // console.error("⚠️ Error in ajaxFormOnSuccess:", error);
        showToast("Something went wrong while closing the modal.", "error");
    }
}

// Global Error Handler
function ajaxFormOnError(res, form) {

    let msg = res?.message || "Something went wrong!";
    showToast(msg, "error", 5000); // Use default error toast styling if needed (customize CSS)
    // console.error("Form submission error:", res);
}

function showToast(message, type = 'success', duration = 3000) {

    var toast = document.getElementById('toast');
    var toastHeader = toast.querySelector('.toast-header');
    var toastTitle = toastHeader.querySelector('strong.me-auto');
    var toastMsg = document.getElementById('toast-message');

    // Reset classes first
    toastHeader.classList.remove('bg-success-lt', 'bg-danger-lt', 'text-white', 'text-success', 'text-danger');
    toast.classList.remove('show');

    // Set styling and title text based on type
    if (type === 'success') {
        toastHeader.classList.add('bg-success-lt', 'text-success');
        toastTitle.innerText = 'Success';
    } else if (type === 'error') {
        toastHeader.classList.add('bg-danger-lt', 'text-danger');
        toastTitle.innerText = 'Oops';
    } else {
        toastHeader.classList.add('bg-secondary-lt', 'text-white');
        toastTitle.innerText = 'Notification';
    }

    // Handle array or string message
    if (Array.isArray(message)) {
        let listHtml = '<ul style="margin:0; padding-left:18px;">';
        message.forEach((msg) => {
            listHtml += `<li>${msg}</li>`;
        });
        listHtml += '</ul>';
        toastMsg.innerHTML = listHtml;
    } else {
        toastMsg.innerText = message;
    }

    // Show toast
    toast.style.display = 'block';
    toast.classList.add('show');

    // Auto hide after duration
    setTimeout(() => {
        hideToast();
    }, duration);
}


// function showToast(message, type = 'success', duration = 3000) {

//     console.log(message);

//     var toast = document.getElementById('toast');
//     var toastHeader = toast.querySelector('.toast-header');
//     var toastTitle = toastHeader.querySelector('strong.me-auto');
//     var toastMsg = document.getElementById('toast-message');

//     toastMsg.innerText = message;

//     // Reset classes first
//     toastHeader.classList.remove('bg-success-lt', 'bg-danger-lt', 'text-white', 'text-success', 'text-danger');
//     toast.classList.remove('show');

//     // Set styling and title text based on type
//     if (type === 'success') {
//         toastHeader.classList.add('bg-success-lt', 'text-success');
//         toastTitle.innerText = 'Success';
//     } else if (type === 'error') {
//         toastHeader.classList.add('bg-danger-lt', 'text-danger');
//         toastTitle.innerText = 'Opps';
//     } else {
//         toastHeader.classList.add('bg-secondary-lt', 'text-white');
//         toastTitle.innerText = 'Notification';
//     }

//     toast.style.display = 'block';
//     toast.classList.add('show');

//     // Auto hide after duration
//     setTimeout(() => {
//         hideToast();
//     }, duration);
// }

function hideToast() {
    var toast = document.getElementById('toast');
    toast.classList.remove('show');
    toast.style.display = 'none';
}


