"use strict";
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
            console.log(config);
            
            this.form = this.$el;
            this.url = config.url || this.form.action;

            // Bind submit event
            this.form.addEventListener('submit', (e) => {
                console.log('snfjsf');
                e.preventDefault();
                this.submitForm();
            });
        },

        // Handle form submission with Axios
        async submitForm() {
            this.isLoading = true;
            this.error = null;
            this.success = null;

            try {
                const formData = new FormData(this.form);
                
                if (typeof csrfName !== 'undefined' && typeof csrfHash !== 'undefined') {
                    if (!formData.has(csrfName)) {
                        formData.append(csrfName, csrfHash);
                    }
                }
                
                const response = await axios({
                    method: this.form.method || 'POST',
                    url: this.url,
                    data: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });

                
                let responseData = JSON.parse(response.request.response);
                
                if (responseData.csrfName && responseData.csrfHash) {
                    csrfName = responseData.csrfName;
                    csrfHash = responseData.csrfHash;
                }

                if (responseData.error === false) {
                    // Pass switchModal and offcanvasId config to the success handler
                    ajaxFormOnSuccess(responseData, this.form, this.modalId, this.offcanvasId, this.switchModal);
                } else {
                    ajaxFormOnError(responseData, this.form);
                }
            } catch (err) {
                

                // const fallbackRes = {
                //     message: err.response?.data?.message || 'An error occurred while submitting the form'
                // };
                // this.error = fallbackRes.message;
                // ajaxFormOnError(fallbackRes, this.form);
            } finally {
                this.isLoading = false;
            }
        }
    }));
});

// Global Success Handler
function ajaxFormOnSuccess(res, form, modalId = null, offcanvasId = null, switchModal = null) {
    try {
        // Replace $.notify with showToast, use default green success styling
        showToast(res.message || "Action successful!", "success");

        // Handle redirect if redirect_url is present
        if (res.redirect_url) {
            setTimeout(() => {
                window.location.href = res.redirect_url;
            }, 500); // Small delay to show success message
            return;
        }

        if (offcanvasId) {
            const offcanvasEl = document.getElementById(offcanvasId);
            if (!offcanvasEl) {
                console.error("❌ Offcanvas element not found! Check offcanvasId:", offcanvasId);
            } else {
                const bsOffcanvas = bootstrap.Offcanvas.getInstance(offcanvasEl);
                if (bsOffcanvas) {
                    bsOffcanvas.hide();
                }
                
                offcanvasEl.addEventListener('hidden.bs.offcanvas', function handler() {
                    if (typeof $.fn.bootstrapTable !== 'undefined') {
                        $('.table').bootstrapTable('refresh');
                    }
                    offcanvasEl.removeEventListener('hidden.bs.offcanvas', handler);
                }, { once: true });
            }
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

                    if (typeof $.fn.bootstrapTable !== 'undefined') {
                        $('.table').bootstrapTable('refresh');
                    }

                    if (switchModal) {
                        const switchModalEl = document.getElementById(switchModal);
                        if (switchModalEl) {
                            $(switchModalEl).modal('show');
                            console.log("Switched to modal:", switchModal);
                        } else {
                            console.error("❌ Switch modal element not found! Check switchModal:", switchModal);
                        }
                    }
                });
            }
        }

        if (!modalId && !offcanvasId) {
            if (typeof $.fn.bootstrapTable !== 'undefined') {
                $('.table').bootstrapTable('refresh');
            }
        }

        if (form?.reset) form.reset();
    } catch (error) {
        console.error("⚠️ Error in ajaxFormOnSuccess:", error);
        showToast("Something went wrong while closing the modal.", "error");
    }
}

// Global Error Handler
function ajaxFormOnError(res, form) {
    let msg = res?.message || "Something went wrong!";
    showToast(msg, "error"); // Use default error toast styling if needed (customize CSS)
    console.error("Form submission error:", res);
}



function showToast(message, type = 'success', duration = 3000) {
    var toast = document.getElementById('toast');
    var toastHeader = toast.querySelector('.toast-header');
    var toastTitle = toastHeader.querySelector('strong.me-auto');
    var toastMsg = document.getElementById('toast-message');

    toastMsg.innerText = message;

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

    toast.style.display = 'block';
    toast.classList.add('show');

    // Auto hide after duration
    setTimeout(() => {
        hideToast();
    }, duration);
}

function hideToast() {
    var toast = document.getElementById('toast');
    toast.classList.remove('show');
    toast.style.display = 'none';
}


