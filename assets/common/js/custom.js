"use strict";
var from = 'admin';
if (window.location.href.indexOf("seller/") > -1) {
    from = 'seller';
}

var currency = $('#currency').val();
var attributes_values_selected = [];
var variant_values_selected = [];
var value_check_array = [];
var attributes_selected_variations = [];
var attributes_values = [];
var pre_selected_attr_values = [];
var current_attributes_selected = [];
var current_variants_selected = [];
var attribute_flag = 0;
var pre_selected_attributes_name = [];
var current_selected_image;
var attributes_values = [];
var all_attributes_values = [];
var counter = 0;
var variant_counter = 0;
var currentDate = new Date();
var currentYear = currentDate.getFullYear();
var all_previous_attributes_values = [];

$(document).ready(function () {
    $('#order_tracking_offcanvas').on('show.bs.offcanvas', function (e) {

        let button = $(e.relatedTarget);
        let consignment_id = button.data('id');
        let tracking_data = button.data('tracking-data');

        $('.consignment_id').val(consignment_id);
        if (tracking_data != [] && tracking_data.length > 0) {
            $('#courier_agency').val(tracking_data[0]['courier_agency']);
            $('#tracking_id').val(tracking_data[0]['tracking_id']);
            $('#url').val(tracking_data[0]['url']);
        } else {
            $('#courier_agency').val('');
            $('#tracking_id').val('');
            $('#url').val('');
        }
    });
});

// For hugeRTE Editor
$(document).ready(function () {
    let options = {
        selector: ".hugerte-mytextarea",
        height: 300,
        menubar: false,
        statusbar: false,
        plugins: [
            'a11ychecker', 'advlist', 'advcode', 'advtable', 'autolink', 'checklist', 'export',
            'lists', 'link', 'image', 'charmap', 'preview', 'code', 'anchor', 'searchreplace', 'visualblocks',
            'powerpaste', 'fullscreen', 'formatpainter', 'insertdatetime', 'media', 'image', 'directionality', 'fullscreen', 'table', 'help', 'wordcount'
        ],
        setup: function (editor) {
            editor.on("change keyup", function (e) {
                editor.save(); // updates this instance's textarea
                $(editor.getElement()).trigger('change'); // for garlic to detect change
            });
        },
        toolbar:
            'undo redo | image media | code fullscreen| formatpainter casechange blocks fontsize | bold italic forecolor backcolor | ' +
            'alignleft aligncenter alignright alignjustify | ' +
            'bullist numlist checklist outdent indent | removeformat | ltr rtl |a11ycheck table help',
        font_size_formats: '8pt 10pt 12pt 14pt 16pt 18pt 24pt 36pt 48pt',
        image_uploadtab: false,
        images_upload_url: base_url + "admin/media/upload",
        relative_urls: false,
        remove_script_host: false,
        file_picker_types: 'image media',
        media_poster: false,
        media_alt_source: false,

        file_picker_callback: function (callback, value, meta) {
            if (meta.filetype == "media" || meta.filetype == "image") {
                const input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/* audio/* video/*');

                input.addEventListener('change', (e) => {
                    const file = e.target.files[0];

                    var reader = new FileReader();
                    var fd = new FormData();
                    var files = file;
                    fd.append("documents[]", files);
                    fd.append('filetype', meta.filetype);
                    fd.append(csrfName, csrfHash);

                    var filename = "";
                    // AJAX
                    jQuery.ajax({
                        url: base_url + "admin/media/upload",
                        type: "post",
                        data: fd,
                        contentType: false,
                        processData: false,
                        async: false,
                        success: function (response) {
                            var response = jQuery.parseJSON(response)
                            filename = response.file_name;
                        }
                    });

                    reader.onload = function (e) {
                        const imageUrl = base_url + "uploads/media/" + currentYear + "/" + filename;
                        callback(imageUrl.replace(/&quot;/g, ''));
                    };
                    reader.readAsDataURL(file);

                });
                input.click();
            }
        },
        content_style:
            "body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; -webkit-font-smoothing: antialiased; }",
    };
    if (localStorage.getItem("tablerTheme") === "dark") {
        options.skin = "oxide-dark";
        options.content_css = "dark";
    }
    hugeRTE.init(options);

});

// Track initialized editors
let hugeRTEInitialized = {};

$(document).on('shown.bs.modal', function (e) {
    $(e.target).find('textarea[data-hugerte]').each(function () {
        let textareaId = $(this).attr('id');

        if (!hugeRTEInitialized[textareaId]) {
            hugeRTE.init({
                selector: "#" + textareaId,
                height: 300,
                menubar: false,
                statusbar: false,
                plugins: [
                    "advlist", "autolink", "lists", "link", "image",
                    "charmap", "preview", "anchor", "searchreplace",
                    "visualblocks", "code", "fullscreen",
                    "insertdatetime", "media", "table", "code", "help", "wordcount"
                ],
                toolbar:
                    "undo | formatselect | bold italic backcolor | " +
                    "alignleft aligncenter alignright alignjustify | " +
                    "bullist numlist outdent indent | removeformat",
                content_style:
                    "body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; }",

                init_instance_callback: function (editor) {
                    hugeRTEInitialized[textareaId] = true;

                    // If we stored some pending content, set it now
                    if (window.pendingEditorContent && window.pendingEditorContent[textareaId]) {
                        editor.setContent(window.pendingEditorContent[textareaId]);
                        delete window.pendingEditorContent[textareaId];
                    }
                }
            });
        }
    });
});

// toggle password visibility
document.querySelectorAll('.togglePassword').forEach(function (toggle) {
    toggle.addEventListener('click', function () {
        const input = this.previousElementSibling; // Find the input just before the button
        const icon = this.querySelector('i'); // Get the eye icon
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('ti-eye');
            icon.classList.add('ti-eye-off');
        } else {
            input.type = 'password';
            icon.classList.remove('ti-eye-off');
            icon.classList.add('ti-eye');
        }
    });
});
// Before anything else
document.documentElement.setAttribute('data-theme-loading', 'true');

document.addEventListener('DOMContentLoaded', () => {
    const lightModeBtn = document.getElementById('theme-light');
    const darkModeBtn = document.getElementById('theme-dark');
    const DEFAULT_THEME = 'light';

    function applyTheme(theme) {
        const newTheme = theme || localStorage.getItem('tablerTheme') || DEFAULT_THEME;
        document.body.setAttribute('data-bs-theme', newTheme);
        document.documentElement.setAttribute('data-bs-theme', newTheme);
        localStorage.setItem('tablerTheme', newTheme);
        updateThemeButtons(newTheme);
    }

    function updateThemeButtons(theme) {
        const currentTheme = theme || localStorage.getItem('tablerTheme') || DEFAULT_THEME;
        if (currentTheme === 'dark') {
            if (darkModeBtn) darkModeBtn.style.display = 'none';
            if (lightModeBtn) lightModeBtn.style.display = 'inline-block';
        } else {
            if (darkModeBtn) darkModeBtn.style.display = 'inline-block';
            if (lightModeBtn) lightModeBtn.style.display = 'none';
        }
    }

    // Apply saved theme first
    applyTheme();

    // Reveal the page after theme applied
    document.documentElement.removeAttribute('data-theme-loading');
    document.documentElement.setAttribute('data-theme-loaded', 'true');

    // Handle toggles
    if (darkModeBtn) {
        darkModeBtn.addEventListener('click', (e) => {
            e.preventDefault();
            applyTheme('dark');
        });
    }
    if (lightModeBtn) {
        lightModeBtn.addEventListener('click', (e) => {
            e.preventDefault();
            applyTheme('light');
        });
    }

    // Reapply on dynamic content
    $(document).on('DOMNodeInserted', function () {
        setTimeout(() => updateThemeButtons(), 100);
    });
});


// Auto-init DataTables for all tables with [data-datatable]

$('.table-striped').bootstrapTable({
    toolbar: '#toolbar',
    showRefresh: true,
    showColumns: true,
    iconsPrefix: 'ti',
    icons: {
        refresh: 'ti-refresh',
        toggleOff: 'ti-toggle-off',
        toggleOn: 'ti-toggle-on',
        columns: 'ti-columns',
        detailOpen: 'ti-plus',
        detailClose: 'ti-minus',
        fullscreen: 'ti-expand',
        search: 'ti-search',
        clearSearch: 'ti-trash'
    },
    formatNoMatches: function () {
        return '⚠️ No records available at the moment';
    }
});


// Read More formatter for Bootstrap Table
function itemsReadMoreFormatter(value, row, index) {
    // if (!value) return '';
    // var plain = value.replace(/(<([^>]+)>)/gi, ""); // Remove HTML tags if any
    var shortText = value.substring(0, 30) + (value.length > 30 ? '...' : '');
    var html = `
        <div class="read-more-container">
            <span class="read-more-short">${shortText}</span>
            <span class="read-more-full" style="display:none;">${value.replace(/\n/g, '<br>')}</span>
            ${value.length > 20 ? '<a class="cursor-pointer read-more-toggle text-decoration-none">Read More</a>' : ''}
        </div>
    `;
    return html;
}

// Toggle logic
$(document).on('click', '.read-more-toggle', function () {
    var $container = $(this).closest('.read-more-container');
    var $short = $container.find('.read-more-short');
    var $full = $container.find('.read-more-full');
    if ($full.is(':visible')) {
        $full.hide();
        $short.show();
        $(this).text('Read More');
    } else {
        $full.show();
        $short.hide();
        $(this).text('Read Less');
    }
});


// media modal for panel 
$('#upload-media').on('click', function () {

    $('.image-upload-section').removeClass('d-none');
    var $result = $('#media-upload-table').bootstrapTable('getSelections');

    var path = base_url + $result[0].sub_directory + $result[0].name;
    var sub_directory = $result[0].sub_directory + $result[0].name;
    var media_type = $('#media-upload-modal').find('input[name="media_type"]').val();
    var input = $('#media-upload-modal').find('input[name="current_input"]').val();

    var is_removable = $('#media-upload-modal').find('input[name="remove_state"]').val();
    var ismultipleAllowed = $('#media-upload-modal').find('input[name="multiple_images_allowed_state"]').val();
    var removable_btn = (is_removable == '1') ? '<button class="remove-image btn btn-danger btn-sm mt-3">Remove</button>' : '';

    // Find the target container - either .image-upload-div or .image-upload-section
    var $targetContainer = $(current_selected_image).closest('.form-group').find('.image-upload-div');

    if ($targetContainer.length === 0) {
        $targetContainer = $(current_selected_image).closest('.form-group').find('.image-upload-section');
    }


    // Clear existing content in the target container
    $targetContainer.empty();

    if (ismultipleAllowed == '1') {
        for (let index = 0; index < $result.length; index++) {
            var imageHtml = '<div class="col-6 col-md-4 col-lg-3">' +
                '<div class="card shadow-sm h-100">' +
                '<div class="card-img-top position-relative" style="padding-top: 100%; overflow: hidden;">' +
                '<img src="' + base_url + $result[index].sub_directory + $result[index].name + '" ' +
                'alt="Product Image" class="position-absolute top-0 start-0 w-100 h-100" style="object-fit: cover;">' +
                '<div class="position-absolute top-0 start-0 p-2">' +
                '<span class="badge bg-dark-lt"><i class="ti ti-photo"></i> <span class="image-number">1</span></span>' +
                '</div>' +
                '<div class="position-absolute top-0 end-0 p-2">' +
                '<a href="javascript:void(0)" class="remove-image btn btn-danger btn-sm btn-icon p-1" title="Remove image">' +
                '<i class="ti ti-trash"></i></a>' +
                '</div>' +
                '</div>' +
                '<input type="hidden" name="' + input + '" value="' + $result[index].sub_directory + $result[index].name + '">' +
                '</div>' +
                '</div>';
            $targetContainer.append(imageHtml);
        }
    } else {
        path = (media_type != 'image') ? base_url + 'assets/admin/images/' + media_type + '-file.png' : path;
        var imageHtml = '<div class="col-6 col-md-4 col-lg-3">' +
            '<div class="card shadow-sm h-100">' +
            '<div class="card-img-top position-relative" style="padding-top: 100%; overflow: hidden;">' +
            '<img src="' + path + '" alt="Product Image" class="position-absolute top-0 start-0 w-100 h-100" style="object-fit: cover;">' +
            '<div class="position-absolute top-0 start-0 p-2">' +
            '<span class="badge bg-dark-lt"><i class="ti ti-photo"></i> <span class="image-number">1</span></span>' +
            '</div>' +
            '<div class="position-absolute top-0 end-0 p-2">' +
            '<a href="javascript:void(0)" class="remove-image btn btn-danger btn-sm btn-icon p-1" title="Remove image">' +
            '<i class="ti ti-trash"></i></a>' +
            '</div>' +
            '</div>' +
            '<input type="hidden" name="' + input + '" value="' + sub_directory + '">' +
            '</div>' +
            '</div>';
        $targetContainer.html(imageHtml);
    }

    // Update image numbers
    updateImageNumbers();

    current_selected_image = '';

    $('#media-upload-modal').modal('hide');

});

$(document).on('show.bs.modal', '#media-upload-modal', function (event) {
    var triggerElement = $(event.relatedTarget);
    current_selected_image = triggerElement;

    var input = $(current_selected_image).data('input');
    var isremovable = $(current_selected_image).data('isremovable');
    var ismultipleAllowed = $(current_selected_image).data('is-multiple-uploads-allowed');
    var media_type = ($(current_selected_image).is('[data-media_type]')) ? $(current_selected_image).data('media_type') : 'image';
    $('#media_type').val(media_type);
    if (ismultipleAllowed == 1) {
        $('#media-upload-table').bootstrapTable('refreshOptions', {
            singleSelect: false,
        });
    } else {
        $('#media-upload-table').bootstrapTable('refreshOptions', {
            singleSelect: true,
        });
    }

    $(this).find('input[name="current_input"]').val(input);
    $(this).find('input[name="remove_state"]').val(isremovable);
    $(this).find('input[name="multiple_images_allowed_state"]').val(ismultipleAllowed);
});



// for media table copy to clipboard
function copyToClipboard(element) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).text()).select();
    document.execCommand("copy");
    $temp.remove();
}
$(document).on('click', '.copy-to-clipboard', function () {
    var $element = $(this).closest('tr').find('.path');
    copyToClipboard($element);
    showToast('Image full path copied to clipboard', "success");
});
$(document).on('click', '.copy-relative-path', function () {
    var $element = $(this).closest('tr').find('.relative-path');
    copyToClipboard($element);
    showToast('Image path copied to clipboard', "success");

});

// Date Range Picker 
$('#datepicker').attr({
    'placeholder': ' Select Date Range To Filter ',
    'autocomplete': 'off'
});
$('#datepicker').on('cancel.daterangepicker', function (ev, picker) {
    $(this).val('');
    $('#start_date').val('');
    $('#end_date').val('');
});
$('#datepicker').on('apply.daterangepicker', function (ev, picker) {
    var drp = $('#datepicker').data('daterangepicker');
    $('#start_date').val(drp.startDate.format('YYYY-MM-DD'));
    $('#end_date').val(drp.endDate.format('YYYY-MM-DD'));
    $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
});

$('#datepicker').daterangepicker({
    showDropdowns: true,
    alwaysShowCalendars: true,
    autoUpdateInput: false,
    ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    startDate: moment().subtract(29, 'days'),
    endDate: moment(),
    locale: {
        "format": "DD/MM/YYYY",
        "separator": " - ",
        "cancelLabel": 'Clear',
        'label': 'Select range of dates to filter'
    }
});

// Handle remove image functionality
$(document).on('click', '.remove-image', function (e) {
    e.preventDefault();
    $(this).closest('.image, .col-6, .col-md-4, .col-lg-3').remove();
    updateImageNumbers();
});

// Function to update image numbers after deletion/addition
function updateImageNumbers() {
    $('.image-upload-div .image-number').each(function (index) {
        $(this).text(index + 1);
    });
}

// ============================================================================
// Product Form - Seller Category Tree Loading (Alpine.js)
// ============================================================================

/**
 * Alpine.js component for Product Category Management
 * Handles seller selection and category tree loading
 */
window.productCategoryManager = function () {
    return {
        selectedSeller: null,
        categoryEditId: null,
        ignoreStatus: 0,
        affiliateCategories: [],

        init() {
            // Get initial values from hidden inputs
            this.categoryEditId = document.querySelector('input[name="category_id"]')?.value || null;
            const sellerIdInput = document.querySelector('input[name="seller_id"]')?.value;
            this.selectedSeller = sellerIdInput || null;
            this.ignoreStatus = this.categoryEditId ? 1 : 0;

            // Get affiliate categories
            const affiliateCategoriesStr = document.getElementById('affiliate_categories')?.value || '';
            this.affiliateCategories = affiliateCategoriesStr ? affiliateCategoriesStr.split(',').map(Number) : [];

            // Load categories on page load
            if (this.selectedSeller && this.selectedSeller > 0) {
                this.loadSellerCategories(this.selectedSeller);
            } else {
                this.loadAllCategories();
            }

            // Watch for seller selection changes (from TomSelect)
            this.watchSellerChange();
        },

        watchSellerChange() {
            // Listen to change event on seller select
            const sellerSelect = document.getElementById('sellerSelect');
            if (sellerSelect) {
                sellerSelect.addEventListener('change', (e) => {
                    // Skip the first event triggered on page load
                    if (this.ignoreStatus === 1) {
                        this.ignoreStatus = 0;
                        return;
                    }
                    const sellerId = e.target.value;
                    this.handleSellerChange(sellerId);
                });
            }
        },

        async handleSellerChange(sellerId) {
            this.selectedSeller = sellerId;

            if (sellerId && sellerId > 0) {
                // Load seller's categories and pickup locations
                await this.loadSellerCategories(sellerId);
                await this.loadSellerPickupLocations(sellerId);
            } else {
                // Clear the tree if no seller is selected
                this.clearCategoryTree();
                this.resetPickupLocations();
            }
        },

        async loadSellerCategories(sellerId) {
            try {
                const response = await fetch(`${base_url}${from}/category/get_seller_categories?seller_id=${sellerId}&ignore_status=${this.ignoreStatus}`);
                const result = await response.json();

                if (result.data && result.data.length > 0) {
                    this.initializeJsTree(result.data);
                } else {
                    showToast('No categories assigned to this seller', 'warning');
                    this.showInfoMessage('No categories are assigned to this seller. Please assign categories to the seller first.');
                }
            } catch (error) {
                console.error('Error loading seller categories:', error);
                showToast('Error loading seller categories', 'error');
            }
        },

        async loadAllCategories() {
            try {
                const response = await fetch(`${base_url}admin/category/get_categories?ignore_status=${this.ignoreStatus}`);
                const result = await response.json();

                if (result.data && result.data.length > 0) {
                    this.initializeJsTree(result.data);
                } else {
                    this.showInfoMessage('No categories available. Please Select Seller First.');
                }
            } catch (error) {
                console.error('Error loading categories:', error);
            }
        },

        initializeJsTree(data) {
            const treeElement = $('#product_category_tree_view_html');

            // Destroy existing jstree if it exists
            treeElement.jstree("destroy").empty();

            // Initialize new jstree
            treeElement.jstree({
                plugins: ["checkbox", 'themes'],
                'core': {
                    multiple: false,
                    'data': data,
                },
                checkbox: {
                    three_state: false,
                    cascade: "none"
                }
            });

            // Select the category in edit mode
            if (this.categoryEditId) {
                treeElement.bind('ready.jstree', () => {
                    treeElement.jstree(true).select_node(this.categoryEditId);
                    // Ensure the hidden field is also updated
                    const categoryIdInput = document.querySelector('input[name="category_id"]');
                    if (categoryIdInput) {
                        categoryIdInput.value = this.categoryEditId;
                    }
                });
            }

            // Handle category selection and affiliate category visibility
            treeElement.off('changed.jstree').on('changed.jstree', (e, data) => {
                const selectedId = parseInt(data.selected[0]);

                // Update the hidden category_id field
                const categoryIdInput = document.querySelector('input[name="category_id"]');
                if (categoryIdInput) {
                    categoryIdInput.value = selectedId;
                }

                if (this.affiliateCategories.includes(selectedId)) {
                    $('.is_in_affiliate').removeClass('d-none');
                } else {
                    $('.is_in_affiliate').addClass('d-none');
                }
            });
        },

        async loadSellerPickupLocations(sellerId) {
            try {
                const response = await fetch(`${base_url}admin/Pickup_location/get_seller_pickup_location?seller_id=${sellerId}`);
                const result = await response.json();

                let html = '<option value="">Select Pickup Location</option>';
                if (result.rows && result.rows.length > 0) {
                    result.rows.forEach((value) => {
                        html += `<option value="${value.id}">${value.pickup_location}</option>`;
                    });
                }
                document.getElementById('pickup_location').innerHTML = html;
            } catch (error) {
                console.error('Error loading pickup locations:', error);
            }
        },

        clearCategoryTree() {
            $('#product_category_tree_view_html').jstree("destroy").empty();
            this.showInfoMessage('Please select a seller first to load categories.');
        },

        showInfoMessage(message) {
            const treeElement = $('#product_category_tree_view_html');
            treeElement.jstree("destroy").empty();

            const infoHtml = `
                <div class="alert alert-info mb-0" role="alert">
                    <div class="d-flex align-items-center">
                        <div>
                            <i class="ti ti-info-circle me-2"></i>
                        </div>
                        <div>
                            ${message}
                        </div>
                    </div>
                </div>
            `;

            treeElement.html(infoHtml);
        },

        resetPickupLocations() {
            const pickupSelect = document.getElementById('pickup_location');
            if (pickupSelect) {
                pickupSelect.innerHTML = '<option value="">Select Pickup Location</option>';
            }
        }
    }
}

/**
 * Initialize Alpine component on product pages
 */
// if (window.location.href.indexOf("admin/product") > -1 && document.getElementById('product_category_tree_view_html')) {
//     document.addEventListener('alpine:init', () => {
//         Alpine.data('productCategoryManager', window.productCategoryManager);
//     });
// }

$(document).on('change', '#video_type', function () {
    var video_type = $(this).val();
    if (video_type == 'youtube' || video_type == 'vimeo') {
        $("#video_link_container").removeClass('d-none');
        $("#video_media_container").addClass('d-none');
    } else if (video_type == 'self_hosted') {
        $("#video_link_container").addClass('d-none');
        $("#video_media_container").removeClass('d-none');
    } else {
        $("#video_link_container").addClass('d-none');
        $("#video_media_container").addClass('d-none');
    }
});
$(document).on('change', '#download_link_type', function () {
    var download_link_type = $(this).val();
    if (download_link_type == 'add_link') {
        $("#add_link").removeClass('d-none');
        $("#self_hosted_link").addClass('d-none');
    } else if (download_link_type == 'self_hosted') {
        $("#add_link").addClass('d-none');
        $("#self_hosted_link").removeClass('d-none');
    } else {
        $("#self_hosted_link").addClass('d-none');
        $("#add_link").addClass('d-none');
    }
});


// ============================================================================
// Product Helper Functions
// ============================================================================

/**
 * Check if haystack contains all needles
 */
function containsAll(needles, haystack) {
    for (var i = 0; i < needles.length; i++) {
        if ($.inArray(needles[i], haystack) == -1) return false;
    }
    return true;
}

/**
 * Get variants by product ID (for edit mode)
 */
function get_variants(edit_id, from) {
    return $.ajax({
        type: 'GET',
        url: base_url + from + '/product/fetch_variants_values_by_pid',
        data: {
            edit_id: edit_id
        },
        dataType: 'json'
    })
        .done(function (data) {
            return data.responseCode != 200 ? $.Deferred().reject(data) : data;
        });
}

// ============================================================================
// Product Form - Additional Info Section JavaScript
// ============================================================================

/**
 * Handle product type menu change (Physical vs Digital)
 * This dropdown only appears in ADD mode (not edit mode)
 */
$(document).on('change', '#product_type_menu', function () {
    var value = $(this).val();

    if (value == 'digital_product') {
        // Switch to digital product mode
        $('#product-type').html('<option value="digital_product">Digital Product</option>');
        $('#product-type').val('digital_product').trigger('change');

        // Hide physical product fields
        $('.indicator').addClass('d-none');
        $('.total_allowed_quantity').addClass('d-none');
        $('.minimum_order_quantity').addClass('d-none');
        $('.quantity_step_size').addClass('d-none');
        $('.warranty_period').addClass('d-none');
        $('.guarantee_period').addClass('d-none');
        $('.hsn_code').addClass('d-none');
        $('.deliverable_type').addClass('d-none');
        $('.pickup_locations').addClass('d-none');
        $('.cod_allowed').addClass('d-none');
        $('.is_returnable').addClass('d-none');
        $('.is_cancelable').addClass('d-none');
        $('.is_attachment_required').addClass('d-none');
        $('.is_in_affiliate').addClass('d-none');
        $('.dimensions').addClass('d-none');

        // Show digital product sections
        $('#simple-product-settings').removeClass('d-none');
        $('#variable-product-settings').addClass('d-none');
        $('.simple-product-save').show();

    } else {
        // Switch to physical product mode
        var html = '<option value="">Select Type</option>' +
            '<option value="simple_product">Simple Product</option>' +
            '<option value="variable_product">Variable Product</option>';
        $('#product-type').html(html);

        // Show physical product fields
        $('.indicator').removeClass('d-none');
        $('.total_allowed_quantity').removeClass('d-none');
        $('.minimum_order_quantity').removeClass('d-none');
        $('.quantity_step_size').removeClass('d-none');
        $('.warranty_period').removeClass('d-none');
        $('.guarantee_period').removeClass('d-none');
        $('.hsn_code').removeClass('d-none');
        $('.deliverable_type').removeClass('d-none');
        $('.pickup_locations').removeClass('d-none');
        $('.cod_allowed').removeClass('d-none');
        $('.is_returnable').removeClass('d-none');
        $('.is_cancelable').removeClass('d-none');
        $('.is_attachment_required').removeClass('d-none');

        // Hide digital product sections
        $('#simple-product-settings').addClass('d-none');
        $('#variable-product-settings').addClass('d-none');
    }
});

// Trigger product_type_menu change on page load to set correct product-type options
$(document).ready(function () {
    if ($('#product_type_menu').length > 0) {
        $('#product_type_menu').trigger('change');
    }
});

$(document).on('switchChange.bootstrapSwitch change', '#is_cancelable', function (event) {
    event.preventDefault();

    // Check if it's Bootstrap Switch or regular checkbox
    var state;
    if ($(this).hasClass('switch') && typeof $(this).bootstrapSwitch === 'function') {
        // Bootstrap Switch
        state = $(this).bootstrapSwitch('state');
    } else {
        // Regular checkbox
        state = $(this).is(':checked');
    }

    if (state) {
        $('#cancelable_till').removeClass('d-none').show();
    } else {
        $('#cancelable_till').addClass('d-none').hide();
    }
});

/**
 * Handle product type change (Simple/Variable/Digital)
 */
$(document).on('change', '#product-type', function () {
    var value = $(this).val();

    if (value == 'simple_product') {
        // Show simple product settings
        $('#simple-product-settings').removeClass('d-none');
        $('#variable-product-settings').addClass('d-none');
        $('.simple-product-save').removeClass('d-none');
        $('#tab-for-variations').addClass('disabled d-none');

        // Show physical product fields (in case coming from digital)
        $('.dimensions').removeClass('d-none');
        $('.simple_stock_management_status').closest('div').parent().removeClass('d-none');

        // Hide stock management fields by default (they will show when checkbox is checked)
        $('.simple-product-level-stock-management').addClass('d-none');

    } else if (value == 'variable_product') {
        // Show variable product settings
        $('#simple-product-settings').addClass('d-none');
        $('#variable-product-settings').removeClass('d-none');
        $('.simple-product-save').addClass('d-none');
        $('#tab-for-variations').removeClass('disabled d-none');

        // Show physical product fields
        $('.dimensions').removeClass('d-none');

    } else if (value == 'digital_product') {
        // Show digital product settings
        $('#simple-product-settings').removeClass('d-none');
        $('#variable-product-settings').addClass('d-none');
        $('#digital_product_setting').removeClass('d-none');
        $('.simple-product-save').removeClass('d-none');
        $('#tab-for-variations').addClass('disabled d-none');

        // Hide physical-only fields
        $('.dimensions').addClass('d-none');
        $('.simple-product-level-stock-management').addClass('d-none');
        $('.simple_stock_management_status').closest('div').parent().addClass('d-none');

        // Ensure stock management fields are hidden for digital products
        $('.simple_stock_management_status').prop('checked', false);

    } else {
        // No type selected - hide all
        $('#simple-product-settings').addClass('d-none');
        $('#variable-product-settings').addClass('d-none');
        $('.simple-product-save').addClass('d-none');
    }
});

/**
 * Toggle simple product stock management
 */
$(document).on('change', '.simple_stock_management_status', function () {
    if ($(this).prop("checked") == true) {
        $(this).attr("checked", true);
        $('.simple-product-level-stock-management').removeClass('d-none');
    } else {
        $(this).attr("checked", false);
        $('.simple-product-level-stock-management').addClass('d-none');
        $('.simple-product-level-stock-management').find('input').val('');
    }
});

/**
 * Toggle variable product stock management
 */
$(document).on('change', '.variant_stock_status', function () {
    if ($(this).prop("checked") == true) {
        $(this).attr("checked", true);
        $('#stock_level').removeClass('d-none');
    } else {
        $(this).attr("checked", false);
        $('#stock_level').addClass('d-none');
    }
});

/**
 * Toggle variant stock level type (product level vs variable level)
 */
$(document).on('change', '.variant-stock-level-type', function () {
    if ($('.variant-stock-level-type').val() == 'product_level') {
        $('.variant-product-level-stock-management').removeClass('d-none');
    }
    if ($.trim($('.variant-stock-level-type').val()) != 'product_level') {
        $('.variant-product-level-stock-management').addClass('d-none');
    }
});

/**
 * Toggle download allowed for digital products
 */
$(document).on('change', '#download_allowed', function () {
    if ($(this).prop("checked") == true) {
        $('#download_type').removeClass('d-none');
    } else {
        $('#download_type').addClass('d-none');
        $('#add_link').addClass('d-none');
        $('#self_hosted_link').addClass('d-none');
    }
});

/**
 * Save settings for simple/digital products
 */
$(document).on('click', '.save-settings', function (e) {
    e.preventDefault();

    // Check if stock management is enabled
    var stockManagementEnabled = $('.simple_stock_management_status').is(':checked');

    // Get visible required fields (price is always required)
    var visibleRequiredFields = $('.stock-simple-mustfill-field:visible').filter(function () {
        return this.value === '';
    });

    // Price is always required, stock fields are only required if stock management is enabled
    var priceField = $('input[name="simple_price"]');
    var hasValidPrice = priceField.val() && priceField.val() !== '';

    // Check if validation passes
    var validationPasses = hasValidPrice && visibleRequiredFields.length === 0;

    if (validationPasses) {
        // Show loading state
        const btn = $(this);
        const originalText = btn.html();
        btn.html('<span class="spinner-border spinner-border-sm me-2"></span>Saving...').prop('disabled', true);

        $('input[name="product_type"]').val($('#product-type').val());
        if (stockManagementEnabled) {
            $('input[name="simple_product_stock_status"]').val($('#simple_product_stock_status').val());
        } else {
            $('input[name="simple_product_stock_status"]').val('');
        }
        $('#product-type').prop('disabled', true);
        $('#tab-for-attributes').removeClass('disabled');
        $('#tab-for-variations').removeClass('disabled');
        $('.simple_stock_management_status').prop('disabled', true);

        setTimeout(function () {
            btn.html(originalText).prop('disabled', false);
            showToast('Settings Saved Successfully!', 'success');
        }, 1000);

    } else {
        showToast('Please fill all the required fields', 'error');
    }
});

/**
 * Reset settings for simple products
 */
$(document).on('click', '.reset-settings', function (e) {
    e.preventDefault();

    Notiflix.Confirm.show(
        'Are You Sure To Reset?',
        "This will reset all attributes && variants too if added.",
        'Yes, Reset it!',
        'Cancel',
        function okCb() {
            // Reset attributes and variants arrays
            attributes_values_selected = [];
            value_check_array = [];
            pre_selected_attr_values = [];

            // Add reset flag to form
            if ($('input[name="reset_settings"]').length === 0) {
                $('#save-product').append('<input type="hidden" name="reset_settings" value="1">');
            }

            // Reset product type dropdowns by reinitializing Tom Select
            const productTypeElement = document.getElementById('product-type');
            if (productTypeElement && productTypeElement.tomselect) {
                // Destroy existing Tom Select instance
                productTypeElement.tomselect.destroy();
            }
            // Reset the select element
            $('#product-type').val('').prop('disabled', false);
            // Reinitialize Tom Select
            if (productTypeElement) {
                initTomSelect({ element: '#product-type' });
            }

            // Also reset product_type_menu if it exists
            const productTypeMenuElement = document.getElementById('product_type_menu');
            if (productTypeMenuElement && productTypeMenuElement.tomselect) {
                productTypeMenuElement.tomselect.destroy();
            }
            $('#product_type_menu').val('').prop('selectedIndex', 0);
            if (productTypeMenuElement) {
                initTomSelect({ element: '#product_type_menu' });
            }

            // Reset all form fields in the product settings
            $('#product-general-settings input[type="text"], #product-general-settings input[type="number"]').val('');
            $('#product-general-settings input[type="checkbox"]').prop('checked', false);
            $('#product-general-settings select').val('').prop('selectedIndex', 0);

            // Re-enable stock management checkbox (it gets disabled after saving)
            $('.simple_stock_management_status').prop('disabled', false);

            // Hide stock management fields by default (they should only show when stock management is enabled)
            $('.simple-product-level-stock-management').addClass('d-none');
            $('.variant-product-level-stock-management').addClass('d-none');
            $('#stock_level').addClass('d-none');

            // Hide all product type specific sections
            $('#simple-product-settings').addClass('d-none');
            $('#variable-product-settings').addClass('d-none');
            $('.simple-product-save').addClass('d-none');

            // Hide digital product specific fields
            $('#digital_product_setting').addClass('d-none');

            // Reset tabs to disabled state
            $('#tab-for-attributes').addClass('disabled');
            $('#tab-for-variations').addClass('disabled d-none');

            // Clear attributes section
            $('#attributes_process').html(`
                <div class="form-group text-center row my-auto p-2 border rounded col-md-12 no-attributes-added">
                    <div class="col-md-12 text-center">No Product Attributes Are Added!</div>
                </div>
            `);

            // Clear variants section
            $('#variants_process').html('');

            // Show the "no variants" message
            if ($('.no-variants-added').length === 0) {
                $('#variants_process').before(`
                    <div class="form-group text-center row my-auto p-2 border rounded col-md-12 no-variants-added">
                        <div class="col-md-12 text-center">No Product Variations Are Added!</div>
                    </div>
                `);
            } else {
                $('.no-variants-added').show();
            }

            showToast('Settings Reset Successfully!', 'success');
        },
        function cancelCb() {
            // User cancelled
        }
    );
});

// ============================================================================
// Product Attributes Functionality
// ============================================================================

/**
 * Add attributes button click handler
 * Combined with tab-for-variations handler (as in admin_old)
 */
// $(document).on('click', '#add_attributes, #tab-for-variations', function (e) {
$(document).on('click', '#add_attributes', function (e) {
    e.preventDefault();

    // Handle #add_attributes click
    if (e.target.id == 'add_attributes') {
        $('.no-attributes-added').hide();
        $('#save_attributes').removeClass('d-none');
        counter++;

        var $attribute = $('#attributes_values_json_data').find('.select_single');
        var $options = '';
        $attribute.find('option').each(function () {
            var $option = $(this);
            var value = $option.val();
            var text = $option.text();
            var dataValues = $option.data('values');

            if (value === '') {
                // Empty option
                $options += `<option value="">${text}</option>`;
            } else {
                // Option with data-values
                $options += `<option value="${value}" data-values='${JSON.stringify(dataValues)}'>${text}</option>`;
            }
        });
        var attr_name = 'pro_attr_' + counter;

        var html = '';

        if ($('#product-type').val() == 'simple_product' || $('#product-type').val() == 'digital_product') {
            // Simple product - no variation checkbox
            html = `
                <div class="row my-2 p-3 border rounded product-attr-selectbox" id="${attr_name}">
                    <div class="col-md-1 col-sm-12 text-center my-auto">
                        <i class="ti ti-arrows-sort"></i>
                    </div>
                    <div class="col-md-3 col-sm-12">
                        <label class="form-label mb-1">Attribute</label>
                        <select name="attribute_id[]" class="attributes select_single form-select">
                            <option value="">Select Attribute</option>
                            ${$options}
                        </select>
                    </div>
                    <div class="col-md-5 col-sm-12">
                        <label class="form-label mb-1">Values</label>
                        <select name="attribute_value_ids[]" class="multiple_values form-select" multiple="">
                            <option value="">Select Values</option>
                        </select>
                    </div>
                    <div class="col-md-2 col-sm-12 text-center align-self-end">
                        <button type="button" class="btn btn-danger btn-sm remove_attributes">
                            <i class="ti ti-trash"></i>
                        </button>
                    </div>
                </div>
            `;
        } else {
            // Variable product - with variation checkbox
            $('#note').removeClass('d-none');

            html = `
<div class="product-attr-selectbox border rounded p-3 my-2 attribute-item">
    <div class="row align-items-center g-3">

        <!-- Drag Handle -->
        <div class="col-12 col-md-auto d-flex justify-content-center align-items-center drag-col">
            <i class="ti ti-arrows-sort fs-4 drag-icon"></i>
        </div>

        <!-- Attribute Dropdown -->
        <div class="col-12 col-md">
            <label class="form-label mb-1">Attribute</label>
            <select name="attribute_id[]" class="attributes select_single form-select">
                <option value="">Select Attribute</option>
                ${$options}
            </select>
        </div>

        <!-- Values Dropdown -->
        <div class="col-12 col-md">
            <label class="form-label mb-1">Values</label>
            <select name="attribute_value_ids[]" class="multiple_values form-select" multiple>
                <option value="">Select Values</option>
            </select>
        </div>

        <!-- Variation Checkbox -->
        <div class="col-6 col-md-auto text-center">
            <label class="form-check">
                <input type="checkbox" name="variations[]" class="is_attribute_checked form-check-input">
                <span class="form-check-label">Variation</span>
            </label>
        </div>

        <!-- Remove Button -->
        <div class="col-6 col-md-auto text-center">
            <button type="button" class="btn btn-danger remove_attributes">
                <i class="ti ti-trash"></i>
            </button>
        </div>

    </div>
</div>
`;


        }


        $('#attributes_process').append(html);

        // Initialize TomSelect for the new attribute dropdown
        const lastAttrSelect = $('#attributes_process').find('.attributes').last()[0];
        if (lastAttrSelect) {
            new TomSelect(lastAttrSelect, {
                placeholder: 'Select Attribute...',
                allowClear: true
            });
        }

        // Initialize TomSelect for the new values dropdown
        const lastValuesSelect = $('#attributes_process').find('.multiple_values').last()[0];
        if (lastValuesSelect) {
            new TomSelect(lastValuesSelect, {
                placeholder: 'Select Values...',
                plugins: ['remove_button'],
                maxItems: null
            });
        }
    }

    // Handle #tab-for-variations click
    if (e.target.id == 'tab-for-variations') {
        // Add loading overlay
        $('.additional-info').css({
            'position': 'relative',
            'pointer-events': 'none',
            'opacity': '0.6'
        }).append('<div class="variants-loading-overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,0.8); display: flex; align-items: center; justify-content: center; z-index: 999;"><h6 style="color: #333;">Loading Variations...</h6></div>');

        if (attributes_values.length > 0) {
            $('.no-variants-added').hide();
            create_fetched_variants_html(false, from);
        }

        setTimeout(function () {
            $('.additional-info').css({
                'pointer-events': 'auto',
                'opacity': '1'
            });
            $('.variants-loading-overlay').remove();
        }, 3000);
    }
});

/**
 * Handle attribute selection to populate values
 */
$(document).on('change', '.attributes', function (e) {
    const selectedOption = $(this).find(':selected');
    const data = selectedOption.data('values');
    const attrValue = $(this).val();

    // Check if attribute already selected
    if (attrValue && $.inArray(attrValue, attributes_values_selected) > -1) {
        showToast('Attribute Already Selected', 'error');
        $(this).val('').trigger('change');
        return;
    }

    // Add to selected attributes
    if (attrValue) {
        attributes_values_selected.push(attrValue);
    }

    // Clear the values dropdown
    const $valuesSelect = $(this).closest('.row').find('.multiple_values');

    if ($valuesSelect[0] && $valuesSelect[0].tomselect) {
        $valuesSelect[0].tomselect.clearOptions();
        $valuesSelect[0].tomselect.clear();

        // Parse the JSON data-values and add options
        if (data) {
            try {
                let parsedData;

                // Check if data is already an object or a JSON string
                if (typeof data === 'string') {
                    parsedData = JSON.parse(data);
                } else {
                    parsedData = data;
                }

                if (parsedData && typeof parsedData === 'object') {
                    // Check if it's an array of objects (new structure) or key-value object (old structure)
                    if (Array.isArray(parsedData)) {
                        // New structure: array of objects with id, text properties
                        parsedData.forEach(function (item) {
                            if (item && typeof item === 'object' && item.id && item.text) {
                                $valuesSelect[0].tomselect.addOption({
                                    value: item.id,
                                    text: item.text
                                });
                            }
                        });
                    } else {
                        // Old structure: key-value object
                        Object.keys(parsedData).forEach(function (key) {
                            $valuesSelect[0].tomselect.addOption({
                                value: key,
                                text: parsedData[key]
                            });
                        });
                    }
                }
            } catch (error) {
                console.error('Error parsing attribute values:', error);
                showToast('Error loading attribute values', 'error');
            }
        }
    }
});

/**
 * Remove edit attribute button click handler (for attributes marked for variations in edit mode)
 */
$(document).on('click', '.remove_edit_attribute', function (e) {
    e.preventDefault();
    $(this).closest('.row').remove();
});

/**
 * Remove attributes button click handler
 */
$(document).on('click', '.remove_attributes', function (e) {
    e.preventDefault();

    // Store reference to the clicked element
    const $buttonElement = $(this);

    Notiflix.Confirm.show(
        'Are you sure want to delete?',
        "You won't be able to revert this after update!",
        'Yes, Delete it!',
        'Cancel',
        function okCb() {
            // Remove from selected attributes array
            const attrValue = $buttonElement.closest('.row').find('.attributes').val();
            const index = attributes_values_selected.indexOf(attrValue);
            if (index > -1) {
                attributes_values_selected.splice(index, 1);
            }

            $buttonElement.closest('.row').remove();
            counter -= 1;

            var numItems = $('.product-attr-selectbox').length;
            if (numItems == 0) {
                $('.no-attributes-added').show();
                $('#save_attributes').addClass('d-none');
                $('#note').addClass('d-none');
            }

            showToast('Attribute removed', 'success');
        },
        function cancelCb() {
            // User cancelled
        }
    );
});

/**
 * Save attributes button click handler
 */
$(document).on('click', '#save_attributes', function (e) {
    e.preventDefault();

    Notiflix.Confirm.show(
        'Are you sure want to save changes?',
        "Adding new attributes will reset all variants and generate new combinations!",
        'Yes, save it!',
        'Cancel',
        function okCb() {
            // Store previous state for comparison
            var previous_attributes_values = JSON.stringify(all_previous_attributes_values || []);
            var previous_all_attributes_values = JSON.stringify(all_previous_attributes_values || []);
            attribute_flag = 1;
            // console.log()
            save_attributes();

            // Check if attributes actually changed
            var current_attributes_values = JSON.stringify(attributes_values || []);
            var current_all_attributes_values = JSON.stringify(all_attributes_values || []);

            // Check against initial state (for edit mode) or previous state
            var initial_state_check = (
                typeof window.initial_attributes_values !== 'undefined' &&
                window.initial_attributes_values === current_attributes_values &&
                window.initial_all_attributes_values === current_all_attributes_values
            );


            var no_changes = (
                previous_attributes_values === current_attributes_values &&
                previous_all_attributes_values === current_all_attributes_values
            );

            var attributes_changed = !no_changes && !initial_state_check;


            if (attributes_changed) {

                updateVariantsWithNewAttributes(from);
                // Update initial state after successful change
                window.initial_attributes_values = current_attributes_values;
                window.initial_all_attributes_values = current_all_attributes_values;
            } else {
                // var existingVariantData2 = captureExistingVariantData();
                // setTimeout(function () {
                //     create_fetched_variants_html(false, from, function () {
                //         restoreVariantData(existingVariantData2);
                //         Notiflix.Loading.remove();
                //         showToast('Attributes Saved - All Variants Reset and Regenerated', 'success');
                //         window.initial_attributes_values = current_attributes_values;
                //         window.initial_all_attributes_values = current_all_attributes_values;
                //     });
                // }, 300);
                showToast('No changes detected in attributes. Variants preserved.', 'info');
            }
        },
        function cancelCb() {
            // User cancelled
        }
    );
});

/**
 * Update existing variants with newly added attributes (intelligent update, not replace)
 */
function updateVariantsWithNewAttributes(from) {

    // Get current attribute combinations
    var newArr1 = [];
    if (typeof pre_selected_attr_values !== 'undefined' && pre_selected_attr_values.length > 0) {
        for (var i = 0; i < pre_selected_attr_values.length; i++) {
            var temp = newArr1.concat(pre_selected_attr_values[i]);
            newArr1 = [...new Set(temp)];
        }
    }

    var newArr2 = [];
    for (var i = 0; i < attributes_values.length; i++) {
        newArr2 = newArr2.concat(attributes_values[i]);
    }

    // Find newly added attribute values
    var current_attributes_selected = $.grep(newArr2, function (x) {
        return $.inArray(x, newArr1) < 0
    });
    if (current_attributes_selected && current_attributes_selected.length > 0) {
        // New attributes were added - check how many values they have
        var totalNewValues = current_attributes_selected.length;

        if (totalNewValues === 1) {
            // Only ONE new value - update existing variants
            $.ajax({
                type: 'GET',
                url: base_url + from + '/product/fetch_attribute_values_by_id',
                data: {
                    id: current_attributes_selected,
                },
                dataType: 'json',
                success: function (result) {

                    // Ensure result is an array
                    var parsedResult = result;
                    if (typeof result === 'string') {
                        try {
                            parsedResult = JSON.parse(result);
                        } catch (e) {
                            console.error('Error parsing result:', e);
                            parsedResult = [];
                        }
                    }

                    if (!Array.isArray(parsedResult)) {
                        parsedResult = [];
                    }

                    // Filter out attributes that were already selected
                    var newAttrData = [];
                    $.each(parsedResult, function (key, value) {

                        if (typeof pre_selected_attributes_name === 'undefined' ||
                            pre_selected_attributes_name.indexOf($.trim(value.name)) === -1) {
                            newAttrData.push(value);
                        }
                    });



                    if (newAttrData.length > 0) {
                        // Update existing variants with single new value

                        updateExistingVariantsHTML(newAttrData);
                    } else {
                        var existingVariantData = captureExistingVariantData();


                        create_fetched_variants_html(true, from, existingVariantData);
                    }
                }
            });
        } else {


            // MULTIPLE new values - regenerate all combinations
            showToast('Multiple new values detected - regenerating all variant combinations...', 'info');

            // Store existing variant data before regenerating
            var existingVariantData = captureExistingVariantData();

            // Regenerate all variants
            create_fetched_variants_html(true, from, existingVariantData);

            // After a short delay, try to restore data for matching variants
            // setTimeout(function () {
            //     restoreVariantData(existingVariantData);
            // }, 500);
        }
    } else {
        var existingVariantData = captureExistingVariantData();

        // No new attributes, just regenerate based on current attributes
        create_fetched_variants_html(false, from, existingVariantData);
    }
}
/**
 * Capture existing variant data before regenerating
 */
function captureExistingVariantData() {
    var variantData = [];

    $('.product-variant-selectbox').each(function () {
        var $variant = $(this);
        var data = {};

        // Get attribute value IDs from variant_col hidden inputs
        var attrValueIds = [];
        $variant.find('.variant_col input[type="hidden"]').each(function () {
            var val = $(this).val();
            if (val) {
                attrValueIds.push(val);
            }
        });
        data.attrValueIds = attrValueIds.join(',');

        // Capture form data
        data.edit_variant_id = $variant.find('input[name="edit_variant_id[]"]').val();
        data.price = $variant.find('input[name="variant_price[]"]').val();
        data.special_price = $variant.find('input[name="variant_special_price[]"]').val();
        data.sku = $variant.find('input[name="variant_sku[]"]').val();
        data.stock = $variant.find('input[name="variant_total_stock[]"]').val();
        data.stock_status = $variant.find('select[name="variant_level_stock_status[]"]').val();
        data.weight = $variant.find('input[name="weight[]"]').val();
        data.height = $variant.find('input[name="height[]"]').val();
        data.breadth = $variant.find('input[name="breadth[]"]').val();
        data.length = $variant.find('input[name="length[]"]').val();

        // Capture images
        var images = [];
        $variant.find('input[name^="variant_images"]').each(function () {
            if ($(this).val()) {
                images.push($(this).val());
            }
        });
        data.images = images;

        variantData.push(data);
    });

    return variantData;
}

/**
 * Restore variant data to matching new variants
 */
function restoreVariantData(existingVariantData) {
    if (!existingVariantData || existingVariantData.length === 0) {
        return;
    }

    // For each new variant, check if we have data from old variants
    $('.product-variant-selectbox').each(function () {
        var $newVariant = $(this);

        // Get the attribute value IDs from this new variant
        var newAttrValueIds = [];
        $newVariant.find('.variant_col input[type="hidden"]').each(function () {
            var val = $(this).val();
            if (val) {
                newAttrValueIds.push(val);
            }
        });
        var newAttrIdsStr = newAttrValueIds.join(',');

        // Find matching old variant data
        // Match if ALL old attribute IDs are present in the new variant IDs
        var matchingOldData = null;
        $.each(existingVariantData, function (index, oldData) {
            var oldIds = oldData.attrValueIds.split(',');
            var allMatch = true;

            for (var i = 0; i < oldIds.length; i++) {
                if (newAttrValueIds.indexOf(oldIds[i]) === -1) {
                    allMatch = false;
                    break;
                }
            }

            if (allMatch) {
                matchingOldData = oldData;
                return false; // Break the loop
            }
        });

        // If we found matching old data, restore it
        if (matchingOldData) {
            if (matchingOldData.edit_variant_id) {
                $newVariant.find('input[name="edit_variant_id[]"]').val(matchingOldData.edit_variant_id);
            }
            if (matchingOldData.price) {
                $newVariant.find('input[name="variant_price[]"]').val(matchingOldData.price);
            }
            if (matchingOldData.special_price) {
                $newVariant.find('input[name="variant_special_price[]"]').val(matchingOldData.special_price);
            }
            if (matchingOldData.sku) {
                $newVariant.find('input[name="variant_sku[]"]').val(matchingOldData.sku);
            }
            if (matchingOldData.stock) {
                $newVariant.find('input[name="variant_total_stock[]"]').val(matchingOldData.stock);
            }
            if (matchingOldData.stock_status) {
                $newVariant.find('select[name="variant_level_stock_status[]"]').val(matchingOldData.stock_status);
            }
            if (matchingOldData.weight) {
                $newVariant.find('input[name="weight[]"]').val(matchingOldData.weight);
            }
            if (matchingOldData.height) {
                $newVariant.find('input[name="height[]"]').val(matchingOldData.height);
            }
            if (matchingOldData.breadth) {
                $newVariant.find('input[name="breadth[]"]').val(matchingOldData.breadth);
            }
            if (matchingOldData.length) {
                $newVariant.find('input[name="length[]"]').val(matchingOldData.length);
            }

            // TODO: Restore images if needed
            // This would require more complex logic to match and restore image sections
        }
    });

    showToast('Variant data restored for matching combinations!', 'success');
}

/**
 * Update existing variant HTML by adding new attribute dropdowns
 */
function updateExistingVariantsHTML(newAttrData) {
    if (!newAttrData || newAttrData.length === 0) {
        return;
    }

    // Find all existing variant rows
    $('.product-variant-selectbox').each(function () {
        var $variantRow = $(this);

        // Find the last variant_col before the actions column
        var $lastVariantCol = $variantRow.find('.variant_col').last();

        // For each new attribute, add a field after the last variant column
        $.each(newAttrData, function (index, attrInfo) {
            var tempVariantsIds = [];
            var tempVariantsValues = [];
            var autoSelectValue = null;
            var autoSelectId = null;

            // Parse attribute values
            if (attrInfo.attribute_values_id) {
                $.each(attrInfo.attribute_values_id.split(','), function () {
                    tempVariantsIds.push($.trim(this));
                });
            }

            if (attrInfo.attribute_values) {
                $.each(attrInfo.attribute_values.split(','), function (key) {
                    var valName = $.trim(this);
                    tempVariantsValues.push(valName);
                });
            }

            // Auto-select if only one value
            if (tempVariantsIds.length === 1) {
                autoSelectValue = tempVariantsValues[0];
                autoSelectId = tempVariantsIds[0];
            }

            var newColHtml;
            if (autoSelectValue) {
                // If only one value, show it as readonly (like existing variant cols)
                newColHtml = '<div class="col-2 variant_col new-variant-col">' +
                    '<input type="hidden" class="new-attr-id" value="' + autoSelectId + '">' +
                    '<input type="text" class="form-control" value="' + autoSelectValue + '" readonly>' +
                    '</div>';
            } else {
                // Multiple values - show dropdown
                var dropdownHtml = '<select class="form-select new-added-variant" data-attr-name="' + attrInfo.name + '">' +
                    '<option value="">Select ' + attrInfo.name + '</option>';

                for (var i = 0; i < tempVariantsIds.length; i++) {
                    dropdownHtml += '<option value="' + tempVariantsIds[i] + '">' + tempVariantsValues[i] + '</option>';
                }

                dropdownHtml += '</select>';
                newColHtml = '<div class="col-2 variant_col new-variant-col">' + dropdownHtml + '</div>';
            }

            // Insert the new column after the last variant_col
            if ($lastVariantCol.length > 0) {
                $lastVariantCol.after(newColHtml);
                $lastVariantCol = $lastVariantCol.next('.variant_col'); // Update reference for next iteration
            }
        });

        // Update the hidden variants_ids input
        var $hiddenInput = $variantRow.find('input[name="variants_ids[]"]');
        var allIds = [];

        // Collect existing attribute value IDs
        $variantRow.find('.variant_col input[type="hidden"]').not('.new-attr-id').each(function () {
            if ($(this).val()) {
                allIds.push($(this).val());
            }
        });

        // Collect new attribute IDs (auto-selected ones)
        $variantRow.find('.new-attr-id').each(function () {
            if ($(this).val()) {
                allIds.push($(this).val());
            }
        });

        $hiddenInput.val(allIds.join(','));

        // Listen for changes on new dropdowns (if any)
        $variantRow.find('.new-added-variant').on('change', function () {
            var updatedIds = [];
            $variantRow.find('.variant_col input[type="hidden"]').not('.new-attr-id').each(function () {
                if ($(this).val()) {
                    updatedIds.push($(this).val());
                }
            });
            $variantRow.find('.new-attr-id').each(function () {
                if ($(this).val()) {
                    updatedIds.push($(this).val());
                }
            });
            $variantRow.find('.new-added-variant').each(function () {
                if ($(this).val()) {
                    updatedIds.push($(this).val());
                }
            });
            $hiddenInput.val(updatedIds.join(','));
        });
    });

    // Check if any dropdowns were added (not auto-selected)
    var hasDropdowns = $('.new-added-variant').length > 0;

    if (hasDropdowns) {
        showToast('New attribute fields added. Please select values for each variant.', 'info');
    } else {
        showToast('New attributes added and auto-selected to existing variants!', 'success');
    }
}

/**
 * Function to save attributes
 */
function save_attributes() {
    attributes_values = [];
    all_attributes_values = [];

    var tmp = $('.product-attr-selectbox');

    $.each(tmp, function (index) {
        const valuesSelect = $(tmp[index]).find('.multiple_values')[0];

        if (valuesSelect && valuesSelect.tomselect) {
            var selectedValues = valuesSelect.tomselect.getValue();

            if (selectedValues && selectedValues.length > 0) {
                all_attributes_values.push(selectedValues);

                // Check if this attribute is marked for variations
                if ($(tmp[index]).find('.is_attribute_checked').is(':checked')) {
                    attributes_values.push(selectedValues);
                }
            }
        }
    });
}

/**
 * Function to create attribute row with existing data (for edit mode)
 */

function create_attributes(value, selected_attr) {
    counter++;
    var $attribute = $('#attributes_values_json_data').find('.select_single');
    var $options = '';

    $attribute.find('option').each(function () {
        var $option = $(this);
        var optVal = $option.val();
        var optText = $option.text();
        var dataValues = $option.data('values');

        if (optVal === '') {
            $options += `<option value="">${optText}</option>`;
        } else {
            $options += `<option value="${optVal}" data-values='${JSON.stringify(dataValues)}'>${optText}</option>`;
        }
    });

    var $selected_attrs = [];
    if (selected_attr) {
        $.each(selected_attr.split(","), function () {
            $selected_attrs.push($.trim(this));
        });
    }

    var attr_name = 'pro_attr_' + counter;
    var html = '';

    if ($('#product-type').val() == 'simple_product' || $('#product-type').val() == 'digital_product') {
        html = `
            <div class="row my-2 p-3 border rounded product-attr-selectbox" id="${attr_name}">
                <div class="col-md-1 col-sm-12 text-center my-auto">
                    <i class="ti ti-arrows-sort"></i>
                </div>
                <div class="col-md-3 col-sm-12">
                    <label class="form-label mb-1">Attribute</label>
                    <select name="attribute_id[]" class="attributes select_single form-select">
                        <option value="">Select Attribute</option>
                        ${$options}
                    </select>
                </div>
                <div class="col-md-5 col-sm-12">
                    <label class="form-label mb-1">Values</label>
                    <select name="attribute_value_ids[]" class="multiple_values form-select" multiple="">
                        <option value="">Select Values</option>
                    </select>
                </div>
                <div class="col-md-2 col-sm-12 text-center align-self-end">
                    <button type="button" class="btn btn-danger btn-sm remove_attributes">
                        <i class="ti ti-trash"></i>
                    </button>
                </div>
            </div>
        `;
    } else {
        $('#note').removeClass('d-none');
        html = `
            <div class="row my-2 p-3 border rounded product-attr-selectbox" id="${attr_name}">
                <div class="col-md-1 col-sm-12 text-center my-auto">
                    <i class="ti ti-arrows-sort"></i>
                </div>
                <div class="col-md-3 col-sm-12">
                    <label class="form-label mb-1">Attribute</label>
                    <select name="attribute_id[]" class="attributes select_single form-select">
                        <option value="">Select Attribute</option>
                        ${$options}
                    </select>
                </div>
                <div class="col-md-4 col-sm-12">
                    <label class="form-label mb-1">Values</label>
                    <select name="attribute_value_ids[]" class="multiple_values form-select" multiple="">
                        <option value="">Select Values</option>
                    </select>
                </div>
                <div class="col-md-2 col-sm-6 align-self-end">
                    <div class="form-check">
                        <input type="checkbox" name="variations[]" class="is_attribute_checked form-check-input">
                        <label class="form-check-label">Variation</label>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6 text-center align-self-end">
                    <button type="button" class="btn btn-danger btn-sm remove_attributes">
                        <i class="ti ti-trash"></i>
                    </button>
                </div>
            </div>
        `;
    }

    $('#attributes_process').append(html);

    // Mark for variation if needed
    if (selected_attr) {
        if ($.inArray(value.name, $selected_attrs) > -1) {
            $("#attributes_process").find('.product-attr-selectbox').last().find('.is_attribute_checked').prop('checked', true);
            $("#attributes_process").find('.product-attr-selectbox').last().find('.remove_attributes').addClass('remove_edit_attribute').removeClass('remove_attributes');
        }
    }

    // Initialize TomSelect for attribute dropdown
    const lastAttrSelect = $('#attributes_process').find('.attributes').last()[0];
    if (lastAttrSelect && !lastAttrSelect.tomselect) {
        new TomSelect(lastAttrSelect, {
            placeholder: 'Select Attribute...',
            allowClear: true
        });
    }

    // Initialize TomSelect for values dropdown
    const lastValuesSelect = $('#attributes_process').find('.multiple_values').last()[0];
    if (lastValuesSelect && !lastValuesSelect.tomselect) {
        new TomSelect(lastValuesSelect, {
            placeholder: 'Select Values...',
            plugins: ['remove_button'],
            maxItems: null
        });
    }

    // Add the attribute to the selected list to prevent duplicates
    if (value.name && $.inArray(value.name, attributes_values_selected) === -1) {
        attributes_values_selected.push(value.name);
    }

    // Set the selected attribute
    if (lastAttrSelect && lastAttrSelect.tomselect && value.name) {
        lastAttrSelect.tomselect.setValue(value.name, true); // true = silent mode, no events

        // Get the data-values from the selected option to populate the values dropdown
        const selectedOption = $(lastAttrSelect).find('option[value="' + value.name + '"]');
        const data = selectedOption.data('values');

        // Manually populate the values dropdown options
        if (data && lastValuesSelect && lastValuesSelect.tomselect) {
            try {
                let parsedData;

                // Check if data is already an object or a JSON string
                if (typeof data === 'string') {
                    parsedData = JSON.parse(data);
                } else {
                    parsedData = data;
                }

                if (parsedData && typeof parsedData === 'object') {
                    // Check if it's an array of objects or key-value object
                    if (Array.isArray(parsedData)) {
                        // Array of objects with id, text properties
                        parsedData.forEach(function (item) {
                            if (item && typeof item === 'object' && item.id && item.text) {
                                lastValuesSelect.tomselect.addOption({
                                    value: item.id,
                                    text: item.text
                                });
                            }
                        });
                    } else {
                        // Key-value object
                        Object.keys(parsedData).forEach(function (key) {
                            lastValuesSelect.tomselect.addOption({
                                value: key,
                                text: parsedData[key]
                            });
                        });
                    }
                }

                // Now set the selected values
                var multiple_values = [];
                if (value.ids) {
                    $.each(value.ids.split(","), function () {
                        multiple_values.push($.trim(this));
                    });

                    lastValuesSelect.tomselect.setValue(multiple_values, true); // true = silent mode
                }
            } catch (error) {
                console.error('Error loading attribute values in create_attributes:', error);
            }
        }
    }
}

/**
 * Function to fetch and load existing attributes when editing a product
 */
function create_fetched_attributes_html(from) {
    var edit_id = $('input[name="edit_product_id"]').val();

    return $.ajax({
        type: 'GET',
        url: base_url + from + '/product/fetch_attributes_by_id',
        data: {
            edit_id: edit_id,
            [csrfName]: csrfHash,
        },
        dataType: 'json',
        success: function (data) {
            console.log('form : create_fetched_attributes_html');


            // Update CSRF token (only for POST requests, but check anyway)
            if (data && data['csrfName'] && data['csrfHash']) {
                csrfName = data['csrfName'];
                csrfHash = data['csrfHash'];
            }

            var result = data && data['data'] && data['data']['result'] ? data['data']['result'] : null;


            // Check if result exists and has attr_values
            if (result && result.attr_values && !$.isEmptyObject(result.attr_values)) {

                $.each(result.attr_values, function (key, value) {
                    create_attributes(value, result.pre_selected_variants_names);
                });

                // Process pre-selected variants if they exist
                if (result['pre_selected_variants_ids']) {
                    $.each(result['pre_selected_variants_ids'], function (key, val) {
                        var tempArray = [];
                        if (val && val.variant_ids) {
                            $.each(val.variant_ids.split(','), function (k, v) {
                                tempArray.push($.trim(v));
                            });
                            pre_selected_attr_values[key] = tempArray;
                        }
                    });
                }

                if (result.pre_selected_variants_names) {
                    $.each(result.pre_selected_variants_names.split(','), function (key, value) {
                        pre_selected_attributes_name.push($.trim(value));
                    });
                }
            } else {
                // No attributes found or result is empty
                $('.no-attributes-added').show();
                $('#save_attributes').addClass('d-none');
            }
        },
        error: function (xhr, status, error) {
            console.error('Error loading attributes:', error);
            $('.no-attributes-added').show();
            $('#save_attributes').addClass('d-none');
        }
    });
}

/**
 * Function to create or update variants based on attributes
 * Enhanced version matching admin_old logic for handling edit mode with newly added attributes
 */
function create_fetched_variants_html(add_newly_created_variants = false, from, old_variants = []) {

    var edit_id = $('input[name="edit_product_id"]').val();

    if (!attributes_values || attributes_values.length === 0) {
        showToast('No attributes selected for variations', 'warning');
        return;
    }

    var permutated_attribute_value = getPermutation(attributes_values);
    var selected_variant_ids = JSON.stringify(permutated_attribute_value);
    var selected_attributes_values = JSON.stringify(attributes_values);

    $('.no-variants-added').hide();

    $.ajax({
        type: 'GET',
        url: base_url + from + '/product/get_variants_by_id',
        data: {
            variant_ids: selected_variant_ids,
            attributes_values: selected_attributes_values
        },
        dataType: 'json',
        success: function (data) {

            let result = data.result || [];

            // ----------------------------------------------------
            // Track changes
            // ----------------------------------------------------
            let removedSet = new Set();
            let isRemoval = false;

            // ----------------------------------------------------
            // Detect REMOVED vs ADDED variants
            // ----------------------------------------------------
            // if (old_variants.length > 0) {

            //     // STEP 1: attach attrValueIds
            //     result.forEach(arr => {
            //         const ids = arr.map(item => item.id).join(',');
            //         arr.forEach(item => item.attrValueIds = ids);
            //     });

            //     const normalizeIds = ids => ids.split(',').sort().join(',');

            //     const oldSet = new Set(
            //         old_variants.map(v => normalizeIds(v.attrValueIds))
            //     );

            //     const newSet = new Set(
            //         result.map(arr => normalizeIds(arr[0].attrValueIds))
            //     );

            //     isRemoval = newSet.size < oldSet.size;

            //     removedSet = new Set(
            //         [...oldSet].filter(id => !newSet.has(id))
            //     );

            //     // 👉 ONLY filter result when ADDING
            //     if (!isRemoval) {
            //         result = result.filter(arr =>
            //             !oldSet.has(normalizeIds(arr[0].attrValueIds))
            //         );
            //     }
            // }


            if (old_variants.length > 0) {

                // STEP 1: attach attrValueIds
                result.forEach(arr => {
                    const ids = arr.map(item => item.id).join(',');
                    arr.forEach(item => item.attrValueIds = ids);
                });

                const normalizeIds = ids => ids.split(',').sort().join(',');

                const oldSet = new Set(
                    old_variants.map(v => normalizeIds(v.attrValueIds))
                );

                const newSet = new Set(
                    result.map(arr => normalizeIds(arr[0].attrValueIds))
                );

                // ✅ Removed variants
                const removedSet = new Set(
                    [...oldSet].filter(id => !newSet.has(id))
                );

                // ✅ Added variants
                const addedSet = new Set(
                    [...newSet].filter(id => !oldSet.has(id))
                );

                // ----------------------------------------------------
                // REMOVE deleted variants from DOM
                // ----------------------------------------------------
                if (removedSet.size > 0) {
                    $('input[name="variants_ids[]"]').each(function () {
                        const currentId = normalizeIds($(this).val());
                        if (removedSet.has(currentId)) {
                            $(this)
                                .closest('.product-variant-selectbox')
                                .remove();
                        }
                    });

                    if ($('.product-variant-selectbox').length === 0) {
                        // $('.no-variants-added').show();
                    }
                }

                // ----------------------------------------------------
                // FILTER result → ONLY newly added variants
                // ----------------------------------------------------
                result = result.filter(arr =>
                    addedSet.has(normalizeIds(arr[0].attrValueIds))
                );
                // ----------------------------------------------------
                // NO ATTRIBUTE CHANGE → ONLY UPDATE STOCK FIELDS
                // ----------------------------------------------------
                if (
                    old_variants.length > 0 &&
                    addedSet.size === 0 &&
                    removedSet.size === 0
                ) {
                    updateExistingVariantStockFields();
                    showToast('Variant stock updated successfully!', 'success');
                    return;
                }
            }

            // ----------------------------------------------------
            // REMOVE variant HTML when attribute is REMOVED
            // ----------------------------------------------------
            if (isRemoval && removedSet.size > 0) {

                const normalizeIds = ids => ids.split(',').sort().join(',');

                $('input[name="variants_ids[]"]').each(function () {
                    const currentId = normalizeIds($(this).val());
                    if (removedSet.has(currentId)) {
                        $(this)
                            .closest('.product-variant-selectbox')
                            .remove();
                    }
                });

                if ($('.product-variant-selectbox').length === 0) {
                    $('.no-variants-added').show();
                }

                showToast('Variants updated successfully!', 'success');
                return; // ❗ STOP — do not regenerate HTML
            }

            // ----------------------------------------------------
            // GENERATE HTML (ADD FLOW ONLY)
            // ----------------------------------------------------
            var html = '';

            if (!add_newly_created_variants) {
                html += `
                <div ondragstart="return false;">
                    <a class="btn btn-outline-primary btn-sm mb-3" href="javascript:void(0)" id="expand_all">
                        <i class="ti ti-arrows-maximize"></i> Expand All
                    </a>
                    <a class="btn btn-outline-primary btn-sm mb-3 ms-3" href="javascript:void(0)" id="collapse_all">
                        <i class="ti ti-arrows-minimize"></i> Collapse All
                    </a>
                </div>`;
            }

            $.each(result, function (a, b) {

                variant_counter++;
                var attr_name = 'pro_attr_' + variant_counter;
                var tmp_variant_value_ids = [];

                html += `
                <div class="form-group move row my-auto p-2 border rounded product-variant-selectbox mb-2">
                    <div class="col-1 text-center my-auto">
                        <i class="ti ti-arrows-sort"></i>
                    </div>`;

                $.each(b, function (key, value) {
                    tmp_variant_value_ids.push(value.id);
                    html += `
                    <div class="col-2 variant_col">
                        <input type="hidden" value="${value.id}">
                        <input type="text" class="form-control" value="${value.value}" readonly>
                    </div>`;
                });

                html += `
                    <input type="hidden" name="variants_ids[]" value="${tmp_variant_value_ids.join(',')}">
                    <div class="col d-flex gap-2 justify-content-center my-auto">
                        <a data-bs-toggle="collapse" class="btn btn-tool text-primary btn-sm"
                           data-bs-target="#${attr_name}" aria-expanded="true">
                            <i class="ti ti-chevron-down"></i>
                        </a>
                        <button type="button" class="btn btn-tool btn-sm remove_variants">
                            <i class="ti ti-trash text-danger"></i>
                        </button>
                    </div>
                    <div class="col-12 variant-stock-management" id="variant_stock_management_html">
                        <div id="${attr_name}" class="collapse show">`;

                if ($('.variant_stock_status').is(':checked') &&
                    $('.variant-stock-level-type').val() === 'variable_level') {
                    html += createVariantFormFields(true);
                } else {
                    html += createVariantFormFields(false);
                }

                html += `
                        <div class="row mt-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Variant Images</label>
                                <small class="text-muted d-block mb-2">Upload images specific to this variant</small>
                                <div class="mb-3">
                                    <a class="uploadFile img btn btn-primary btn-sm"
                                       data-input="variant_images[${a}][]"
                                       data-isremovable="1"
                                       data-is-multiple-uploads-allowed="1"
                                       data-bs-toggle="modal"
                                       data-bs-target="#media-upload-modal">
                                        <i class="ti ti-upload"></i> Upload Images
                                    </a>
                                </div>
                                <div class="container-fluid row image-upload-section g-3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
            });


            if (!add_newly_created_variants) {

                $('#variants_process').html(html);

            } else {

                $('#variants_process').append(html);
            }

            showToast('Variants generated successfully!', 'success');
        },
        error: function () {
            $('#variants_process').html(
                '<div class="text-center p-4 text-danger">Error generating variants. Please try again.</div>'
            );
            showToast('Error generating variants', 'error');
        }
    });
}

function updateExistingVariantStockFields() {

    let enableStock =
        $('.variant_stock_status').is(':checked') &&
        $('.variant-stock-level-type').val() === 'variable_level';

    $('.product-variant-selectbox').each(function () {

        let container = $(this)
            .find('.variant-stock-management .collapse');

        if (!container.length) return;

        // Remove existing stock fields
        container.find('.variant-stock-fields').remove();

        if (enableStock) {

            // 🔹 Find price row
            let priceRow = container
                .find('input[name="variant_price[]"]')
                .closest('.row');

            if (priceRow.length) {
                // ✅ Insert stock fields AFTER price row
                priceRow.after(createVariantStockFields());
            } else {
                // fallback (should not happen)
                container.append(createVariantStockFields());
            }
        }
    });
}

function createVariantStockFields() {
    return `
        <div class="row variant-stock-fields mt-3">
            <div class="col-md-4 mb-3">
                <label class="form-label">SKU <span class="text-danger">*</span>:</label>
                <input type="text" name="variant_sku[]" class="form-control varaint-must-fill-field">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Total Stock <span class="text-danger">*</span>:</label>
                <input type="number" min="1" name="variant_total_stock[]" class="form-control varaint-must-fill-field">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Stock Status <span class="text-danger">*</span>:</label>
                <select name="variant_level_stock_status[]" class="form-control varaint-must-fill-field">
                    <option value="1">In Stock</option>
                    <option value="0">Out Of Stock</option>
                </select>
            </div>
        </div>
    `;
}


$(document).on('change', '.variant_stock_status, .variant-stock-level-type', function () {
    updateExistingVariantStockFields();
});
/**
 * Function to create editable variants with existing data and optional newly selected attributes
 * This matches the advanced logic from admin_old for handling variant editing
 */
function create_editable_variants(data, newly_selected_attr = false, add_newly_created_variants = false) {
    // Ensure data is valid

    if (!data || !Array.isArray(data) || data.length === 0 || !data[0] || !data[0].variant_ids) {
        $('.no-variants-added').show();
        return;
    }

    $('#reset_variants').removeClass('d-none');
    var html = '';

    var permuted_value_result = null;
    if (Array.isArray(attributes_values) && attributes_values.length > 0 && add_newly_created_variants == true) {
        permuted_value_result = getPermutation(attributes_values);
    }

    html += '<div ondragstart="return false;">' +
        '<a class="btn btn-outline-primary btn-sm mb-3" href="javascript:void(0)" id="expand_all">' +
        '<i class="ti ti-arrows-maximize"></i> Expand All</a>' +
        '<a class="btn btn-outline-primary btn-sm mb-3 ms-3" href="javascript:void(0)" id="collapse_all">' +
        '<i class="ti ti-arrows-minimize"></i> Collapse All</a>' +
        '</div>';

    $.each(data, function (a, b) {
        // Remove already existing variants from permutation result
        if (permuted_value_result && Array.isArray(permuted_value_result) && permuted_value_result.length > 0 && add_newly_created_variants == true) {
            var permuted_value_result_temp = permuted_value_result;
            var variant_ids = b.variant_ids.split(',');
            $.each(permuted_value_result_temp, function (index, value) {
                if (containsAll(variant_ids, value)) {
                    permuted_value_result.splice(index, 1);
                }
            });
        }

        variant_counter++;
        var attr_name = 'pro_attr_' + variant_counter;

        html += '<div class="form-group move row my-auto p-2 border rounded product-variant-selectbox mb-2">' +
            '<div class="col-1 text-center my-auto"><i class="ti ti-arrows-sort"></i></div>';

        // Add hidden field for variant ID
        html += '<input type="hidden" name="edit_variant_id[]" value="' + b.id + '">';

        // Parse existing variant values
        var variant_array = [];
        var variant_ids_temp_array = [];

        if (b.variant_ids) {
            $.each(b.variant_ids.split(","), function (key) {
                variant_ids_temp_array[key] = $.trim(this);
            });
        }

        if (b.variant_values) {
            $.each(b.variant_values.split(","), function (key) {
                variant_array[key] = $.trim(this);
            });
        }

        // Add existing variant attribute values as readonly inputs
        for (var i = 0; i < variant_array.length; i++) {
            html += '<div class="col-2 variant_col">' +
                '<input type="hidden" value="' + variant_ids_temp_array[i] + '">' +
                '<input type="text" class="form-control" value="' + variant_array[i] + '" readonly>' +
                '</div>';
        }

        // Add newly selected attributes dropdown if any
        if (newly_selected_attr != false && newly_selected_attr.length > 0) {
            for (var i = 0; i < newly_selected_attr.length; i++) {
                var tempVariantsIds = [];
                var tempVariantsValues = [];
                if (newly_selected_attr[i].attribute_values_id) {
                    $.each(newly_selected_attr[i].attribute_values_id.split(','), function () {
                        tempVariantsIds.push($.trim(this));
                    });
                }
                html += '<div class="col-2"><select class="form-control new-added-variant"><option value="">Select Attribute</option>';
                if (newly_selected_attr[i].attribute_values) {
                    $.each(newly_selected_attr[i].attribute_values.split(','), function (key) {
                        tempVariantsValues.push($.trim(this));
                        html += '<option value="' + tempVariantsIds[key] + '">' + tempVariantsValues[key] + '</option>';
                    });
                }
                html += '</select></div>';
            }
        }

        console.log("b.attribute_value_ids  :  " + b.attribute_value_ids);
        console.log("b.variant_ids  :  " + b.variant_ids);


        html += '<input type="hidden" name="variants_ids[]" value="' + b.attribute_value_ids + '">' +
            '<div class="col d-flex gap-2 justify-content-center my-auto">' +
            '<a data-bs-toggle="collapse" class="btn btn-tool text-primary btn-sm" data-bs-target="#' + attr_name + '" aria-expanded="true">' +
            '<i class="ti ti-chevron-down"></i></a>' +
            '<button type="button" class="btn btn-tool btn-sm remove_variants">' +
            '<i class="ti ti-trash text-danger"></i></button>' +
            '</div>' +
            '<div class="col-12 variant-stock-management" id="variant_stock_management_html">' +
            '<div id="' + attr_name + '" class="collapse show">';

        // Add variant form fields with existing data
        if ($('.variant_stock_status').is(':checked') && $('.variant-stock-level-type').val() == 'variable_level') {
            html += '<div class="row mt-3">' +
                '<div class="col-md-6 mb-3">' +
                '<label class="form-label">Price <span class="text-danger">*</span></label>' +
                '<input type="number" name="variant_price[]" class="form-control price variant-must-fill-field" min="0" step="0.01" value="' + (b.price || '') + '">' +
                '</div>' +
                '<div class="col-md-6 mb-3">' +
                '<label class="form-label">Special Price</label>' +
                '<input type="number" name="variant_special_price[]" class="form-control discounted_price" min="0" step="0.01" value="' + (b.special_price || '') + '">' +
                '</div>' +
                '</div>' +
                '<div class="row mt-3 variant-stock-fields">' +
                '<div class="col-md-4 mb-3">' +
                '<label class="form-label">SKU <span class="text-danger">*</span></label>' +
                '<input type="text" name="variant_sku[]" class="form-control variant-must-fill-field" value="' + (b.sku || '') + '">' +
                '</div>' +
                '<div class="col-md-4 mb-3">' +
                '<label class="form-label">Total Stock <span class="text-danger">*</span></label>' +
                '<input type="number" min="1" name="variant_total_stock[]" class="form-control variant-must-fill-field" value="' + (b.stock || '') + '">' +
                '</div>' +
                '<div class="col-md-4 mb-3">' +
                '<label class="form-label">Stock Status <span class="text-danger">*</span></label>' +
                '<select name="variant_level_stock_status[]" class="form-select variant-must-fill-field">' +
                '<option value="1"' + (b.availability == '1' ? ' selected' : '') + '>In Stock</option>' +
                '<option value="0"' + (b.availability == '0' ? ' selected' : '') + '>Out Of Stock</option>' +
                '</select>' +
                '</div>' +
                '</div>';
        } else {
            html += '<div class="row mt-3">' +
                '<div class="col-md-6 mb-3">' +
                '<label class="form-label">Price <span class="text-danger">*</span></label>' +
                '<input type="number" name="variant_price[]" class="form-control price variant-must-fill-field" min="0" step="0.01" value="' + (b.price || '') + '">' +
                '</div>' +
                '<div class="col-md-6 mb-3">' +
                '<label class="form-label">Special Price</label>' +
                '<input type="number" name="variant_special_price[]" class="form-control discounted_price" min="0" step="0.01" value="' + (b.special_price || '') + '">' +
                '</div>' +
                '</div>';
        }

        // Add dimensions
        html += '<div class="row mt-3">' +
            '<div class="col-md-3 mb-3">' +
            '<label class="form-label">Weight (kg)</label>' +
            '<input type="number" name="weight[]" class="form-control" step="0.01" value="' + (b.weight || '') + '">' +
            '</div>' +
            '<div class="col-md-3 mb-3">' +
            '<label class="form-label">Height (cm)</label>' +
            '<input type="number" name="height[]" class="form-control" step="0.1" value="' + (b.height || '') + '">' +
            '</div>' +
            '<div class="col-md-3 mb-3">' +
            '<label class="form-label">Breadth (cm)</label>' +
            '<input type="number" name="breadth[]" class="form-control" step="0.1" value="' + (b.breadth || '') + '">' +
            '</div>' +
            '<div class="col-md-3 mb-3">' +
            '<label class="form-label">Length (cm)</label>' +
            '<input type="number" name="length[]" class="form-control" step="0.1" value="' + (b.length || '') + '">' +
            '</div>' +
            '</div>';

        // Add variant images section if images exist
        var variant_images = [];
        var image_html = '';
        if (b.images && b.images !== '[]') {
            try {
                variant_images = JSON.parse(b.images);
                if (Array.isArray(variant_images)) {
                    $.each(variant_images, function (img_key, img_value) {
                        image_html += '<div class="col-6 col-md-4 col-lg-2">' +
                            '<div class="card shadow-sm h-100">' +
                            '<div class="card-img-top position-relative" style="padding-top: 100%; overflow: hidden;">' +
                            '<img src="' + base_url + img_value + '" alt="Variant Image" ' +
                            'class="position-absolute top-0 start-0 w-100 h-100" style="object-fit: cover;">' +
                            '<div class="position-absolute top-0 start-0 p-2">' +
                            '<span class="badge bg-dark-lt">' +
                            '<i class="ti ti-photo"></i> <span class="image-number">' + (img_key + 1) + '</span>' +
                            '</span>' +
                            '</div>' +
                            '<div class="position-absolute top-0 end-0 p-2">' +
                            '<a href="javascript:void(0)" class="remove-image btn btn-danger btn-sm btn-icon p-1" ' +
                            'data-id="' + b.id + '" data-field="images" data-img="' + img_value + '" ' +
                            'data-table="product_variants" data-path="uploads/media/" data-isjson="true" ' +
                            'title="Remove image">' +
                            '<i class="ti ti-trash"></i>' +
                            '</a>' +
                            '</div>' +
                            '</div>' +
                            '<input type="hidden" name="variant_images[' + a + '][]" value="' + img_value + '">' +
                            '</div>' +
                            '</div>';
                    });
                }
            } catch (e) {
                console.error('Error parsing variant images:', e);
            }
        }

        // Add variant images section
        html += '<div class="row mt-3">' +
            '<div class="col-12">' +
            '<label class="form-label fw-semibold">Variant Images</label>' +
            '<small class="text-muted d-block mb-2">Upload images specific to this variant</small>' +
            '<div class="mb-3">' +
            '<a class="uploadFile img btn btn-primary btn-sm" data-input="variant_images[' + a + '][]" ' +
            'data-isremovable="1" data-is-multiple-uploads-allowed="1" ' +
            'data-bs-toggle="modal" data-bs-target="#media-upload-modal">' +
            '<i class="ti ti-upload"></i> Upload Images</a>' +
            '</div>';

        if (image_html) {
            html += '<div class="row g-3">' + image_html + '</div>';
        } else {
            html += '<div class="container-fluid row image-upload-section g-3"></div>';
        }

        html += '</div></div>';

        html += '</div></div></div>';
    });

    $('#variants_process').html(html);
    $('.no-variants-added').hide();
}

/**
 * Function to load existing variants with their data when editing a product
 */
function load_existing_variants(from = 'admin') {
    var edit_id = $('input[name="edit_product_id"]').val();

    if (!edit_id) {
        return;
    }

    $.ajax({
        type: 'GET',
        url: base_url + from + '/product/fetch_variants_values_by_pid',
        data: {
            edit_id: edit_id
        },
        dataType: 'json',
        success: function (data) {
            var result = data && data['result'] ? data['result'] : null;

            if (result && result.length > 0) {
                create_editable_variants(result);
            } else {
                $('.no-variants-added').show();
            }
        },
        error: function (xhr, status, error) {
            console.error('Error loading existing variants:', error);
            $('.no-variants-added').show();
        }
    });
}

/**
 * Function to create editable variants with existing data
 */
// function create_editable_variants(data) {
//     if (!data || data.length === 0) {
//         $('.no-variants-added').show();
//         return;
//     }

//     $('.no-variants-added').hide();
//     $('#reset_variants').removeClass('d-none');

//     var html = '';

//     html += '<div ondragstart="return false;">' +
//         '<a class="btn btn-outline-primary btn-sm mb-3" href="javascript:void(0)" id="expand_all">' +
//         '<i class="ti ti-arrows-maximize"></i> Expand All</a>' +
//         '<a class="btn btn-outline-primary btn-sm mb-3 ms-3" href="javascript:void(0)" id="collapse_all">' +
//         '<i class="ti ti-arrows-minimize"></i> Collapse All</a>' +
//         '</div>';

//     $.each(data, function (a, b) {
//         variant_counter++;
//         var attr_name = 'pro_attr_' + variant_counter;

//         // Parse variant images if they exist
//         var variant_images = [];
//         var image_html = '';
//         if (b.images && b.images !== '[]') {
//             try {
//                 variant_images = JSON.parse(b.images);
//                 if (Array.isArray(variant_images)) {
//                     $.each(variant_images, function (img_key, img_value) {
//                         image_html += '<div class="col-6 col-md-4 col-lg-2">' +
//                             '<div class="card shadow-sm h-100">' +
//                             '<div class="card-img-top position-relative" style="padding-top: 100%; overflow: hidden;">' +
//                             '<img src="' + base_url + img_value + '" alt="Variant Image" ' +
//                             'class="position-absolute top-0 start-0 w-100 h-100" style="object-fit: cover;">' +
//                             '<div class="position-absolute top-0 start-0 p-2">' +
//                             '<span class="badge bg-dark-lt">' +
//                             '<i class="ti ti-photo"></i> <span class="image-number">' + (img_key + 1) + '</span>' +
//                             '</span>' +
//                             '</div>' +
//                             '<div class="position-absolute top-0 end-0 p-2">' +
//                             '<a href="javascript:void(0)" class="remove-image btn btn-danger btn-sm btn-icon p-1" ' +
//                             'data-id="' + b.id + '" data-field="images" data-img="' + img_value + '" ' +
//                             'data-table="product_variants" data-path="uploads/media/" data-isjson="true" ' +
//                             'title="Remove image">' +
//                             '<i class="ti ti-trash"></i>' +
//                             '</a>' +
//                             '</div>' +
//                             '</div>' +
//                             '<input type="hidden" name="variant_images[' + a + '][]" value="' + img_value + '">' +
//                             '</div>' +
//                             '</div>';
//                     });
//                 }
//             } catch (e) {
//                 console.error('Error parsing variant images:', e);
//             }
//         }

//         // Parse variant values
//         var variant_array = [];
//         var variant_ids_temp_array = [];

//         if (b.variant_values) {
//             $.each(b.variant_values.split(","), function (key) {
//                 variant_array[key] = $.trim(this);
//             });
//         }

//         if (b.variant_ids) {
//             $.each(b.variant_ids.split(","), function (key) {
//                 variant_ids_temp_array[key] = $.trim(this);
//             });
//         }

//         html += '<div class="form-group move row my-auto p-2 border rounded product-variant-selectbox mb-2">' +
//             '<div class="col-1 text-center my-auto"><i class="ti ti-arrows-sort"></i></div>';

//         // Add hidden field for variant ID
//         html += '<input type="hidden" name="edit_variant_id[]" value="' + b.id + '">';

//         // Add variant attribute values as readonly inputs
//         for (var i = 0; i < variant_array.length; i++) {
//             html += '<div class="col-2 variant_col">' +
//                 '<input type="hidden" value="' + variant_ids_temp_array[i] + '">' +
//                 '<input type="text" class="form-control" value="' + variant_array[i] + '" readonly>' +
//                 '</div>';
//         }

//         html += '<div class="col d-flex gap-2 justify-content-center my-auto">' +
//             '<a data-bs-toggle="collapse" class="btn btn-tool text-primary btn-sm" data-bs-target="#' + attr_name + '" aria-expanded="true">' +
//             '<i class="ti ti-chevron-down"></i></a>' +
//             '<button type="button" class="btn btn-tool btn-sm remove_variants">' +
//             '<i class="ti ti-trash text-danger"></i></button>' +
//             '</div>' +
//             '<div class="col-12" id="variant_stock_management_html">' +
//             '<div id="' + attr_name + '" class="collapse">';

//         // Add variant form fields with existing data
//         if ($('.variant_stock_status').is(':checked') && $('.variant-stock-level-type').val() == 'variable_level') {
//             var selected = (b.availability == '0') ? 'selected' : '';

//             html += '<div class="row mt-3">' +
//                 '<div class="col-md-6 mb-3">' +
//                 '<label class="form-label">Price</label>' +
//                 '<input type="number" name="variant_price[]" class="form-control price variant-must-fill-field" min="0" step="0.01" value="' + (b.price || '') + '">' +
//                 '</div>' +
//                 '<div class="col-md-6 mb-3">' +
//                 '<label class="form-label">Special Price</label>' +
//                 '<input type="number" name="variant_special_price[]" class="form-control discounted_price" min="0" step="0.01" value="' + (b.special_price || '') + '">' +
//                 '</div>' +
//                 '<div class="col-md-6 mb-3">' +
//                 '<label class="form-label">SKU</label>' +
//                 '<input type="text" name="variant_sku[]" class="form-control variant-must-fill-field" value="' + (b.sku || '') + '">' +
//                 '</div>' +
//                 '<div class="col-md-6 mb-3">' +
//                 '<label class="form-label">Total Stock</label>' +
//                 '<input type="number" min="1" name="variant_total_stock[]" class="form-control variant-must-fill-field" value="' + (b.stock || '') + '">' +
//                 '</div>' +
//                 '<div class="col-md-6 mb-3">' +
//                 '<label class="form-label">Stock Status</label>' +
//                 '<select name="variant_level_stock_status[]" class="form-select variant-must-fill-field">' +
//                 '<option value="1"' + (b.availability == '1' ? ' selected' : '') + '>In Stock</option>' +
//                 '<option value="0"' + (b.availability == '0' ? ' selected' : '') + '>Out Of Stock</option>' +
//                 '</select>' +
//                 '</div>' +
//                 '</div>';

//             // Add dimensions
//             html += '<div class="row mt-3">' +
//                 '<div class="col-md-3 mb-3">' +
//                 '<label class="form-label">Weight (kg)</label>' +
//                 '<input type="number" name="weight[]" class="form-control" step="0.01" value="' + (b.weight || '') + '">' +
//                 '</div>' +
//                 '<div class="col-md-3 mb-3">' +
//                 '<label class="form-label">Height (cm)</label>' +
//                 '<input type="number" name="height[]" class="form-control" step="0.1" value="' + (b.height || '') + '">' +
//                 '</div>' +
//                 '<div class="col-md-3 mb-3">' +
//                 '<label class="form-label">Breadth (cm)</label>' +
//                 '<input type="number" name="breadth[]" class="form-control" step="0.1" value="' + (b.breadth || '') + '">' +
//                 '</div>' +
//                 '<div class="col-md-3 mb-3">' +
//                 '<label class="form-label">Length (cm)</label>' +
//                 '<input type="number" name="length[]" class="form-control" step="0.1" value="' + (b.length || '') + '">' +
//                 '</div>' +
//                 '</div>';
//         } else {
//             // Add basic price fields without stock management
//             html += '<div class="row mt-3">' +
//                 '<div class="col-md-6 mb-3">' +
//                 '<label class="form-label">Price <span class="text-danger">*</span></label>' +
//                 '<input type="number" name="variant_price[]" class="form-control price variant-must-fill-field" min="0" step="0.01" value="' + (b.price || '') + '">' +
//                 '</div>' +
//                 '<div class="col-md-6 mb-3">' +
//                 '<label class="form-label">Special Price</label>' +
//                 '<input type="number" name="variant_special_price[]" class="form-control discounted_price" min="0" step="0.01" value="' + (b.special_price || '') + '">' +
//                 '</div>' +
//                 '</div>';

//             // Add dimensions
//             html += '<div class="row mt-3">' +
//                 '<div class="col-md-3 mb-3">' +
//                 '<label class="form-label">Weight (kg)</label>' +
//                 '<input type="number" name="weight[]" class="form-control" step="0.01" value="' + (b.weight || '') + '">' +
//                 '</div>' +
//                 '<div class="col-md-3 mb-3">' +
//                 '<label class="form-label">Height (cm)</label>' +
//                 '<input type="number" name="height[]" class="form-control" step="0.1" value="' + (b.height || '') + '">' +
//                 '</div>' +
//                 '<div class="col-md-3 mb-3">' +
//                 '<label class="form-label">Breadth (cm)</label>' +
//                 '<input type="number" name="breadth[]" class="form-control" step="0.1" value="' + (b.breadth || '') + '">' +
//                 '</div>' +
//                 '<div class="col-md-3 mb-3">' +
//                 '<label class="form-label">Length (cm)</label>' +
//                 '<input type="number" name="length[]" class="form-control" step="0.1" value="' + (b.length || '') + '">' +
//                 '</div>' +
//                 '</div>';
//         }

//         // Add variant images section
//         if (image_html) {
//             html += '<div class="row mt-3">' +
//                 '<div class="col-12">' +
//                 '<label class="form-label fw-semibold">Variant Images</label>' +
//                 '<small class="text-muted d-block mb-2">Images specific to this variant</small>' +
//                 '<div class="row g-3">' + image_html + '</div>' +
//                 '</div>' +
//                 '</div>';
//         }

//         html += '</div></div></div>';
//     });

//     $('#variants_process').html(html);
// }

/**
 * Generate permutation of attribute values
 */
function getPermutation(args) {
    var r = [];
    var max = args.length - 1;

    function helper(arr, i) {
        for (var j = 0, l = args[i].length; j < l; j++) {
            var a = arr.slice(0); // clone arr
            a.push(args[i][j]);
            if (i == max)
                r.push(a);
            else
                helper(a, i + 1);
        }
    }
    helper([], 0);
    return r;
}

/**
 * Create variant form fields HTML
 */
function createVariantFormFields(withStockManagement) {
    var html = '';

    if (withStockManagement) {
        html += '<div class="row">' +
            '<div class="col-md-4 mb-3">' +
            '<label class="form-label">Price <span class="text-danger">*</span>:</label>' +
            '<input type="number" name="variant_price[]" class="form-control price varaint-must-fill-field" min="0" step="0.01">' +
            '</div>' +
            '<div class="col-md-4 mb-3">' +
            '<label class="form-label">Special Price:</label>' +
            '<input type="number" name="variant_special_price[]" class="form-control discounted_price" min="0" step="0.01">' +
            '</div>' +
            '</div>' +
            '<div class="row mt-3 variant-stock-fields">' +
            '<div class="col-md-4 mb-3">' +
            '<label class="form-label">SKU <span class="text-danger">*</span>:</label>' +
            '<input type="text" name="variant_sku[]" class="form-control varaint-must-fill-field">' +
            '</div>' +
            '<div class="col-md-4 mb-3">' +
            '<label class="form-label">Total Stock <span class="text-danger">*</span>:</label>' +
            '<input type="number" min="1" name="variant_total_stock[]" class="form-control varaint-must-fill-field">' +
            '</div>' +
            '<div class="col-md-4 mb-3">' +
            '<label class="form-label">Stock Status <span class="text-danger">*</span>:</label>' +
            '<select name="variant_level_stock_status[]" class="form-control varaint-must-fill-field">' +
            '<option value="1">In Stock</option>' +
            '<option value="0">Out Of Stock</option>' +
            '</select>' +
            '</div>' +
            '</div>';
    } else {
        html += '<div class="row mt-3">' +
            '<div class="col-md-6 mb-3">' +
            '<label class="form-label">Price <span class="text-danger">*</span>:</label>' +
            '<input type="number" name="variant_price[]" class="form-control price varaint-must-fill-field" min="0" step="0.01">' +
            '</div>' +
            '<div class="col-md-6 mb-3">' +
            '<label class="form-label">Special Price:</label>' +
            '<input type="number" name="variant_special_price[]" class="form-control discounted_price" min="0" step="0.01">' +
            '</div>' +
            '</div>';
    }

    // Add dimensions section
    html += '<div class="row mt-3">' +
        '<div class="col-12 mb-2">' +
        '<label class="form-label"><small>(These are the product parcel dimensions.)</small></label>' +
        '</div>' +
        '<div class="col-md-3 mb-3">' +
        '<label class="form-label">Weight (kg) <span class="text-danger">*</span>:</label>' +
        '<input type="number" class="form-control" name="weight[]" placeholder="Weight" step="0.01">' +
        '</div>' +
        '<div class="col-md-3 mb-3">' +
        '<label class="form-label">Height (cms):</label>' +
        '<input type="number" class="form-control" name="height[]" placeholder="Height" step="0.01">' +
        '</div>' +
        '<div class="col-md-3 mb-3">' +
        '<label class="form-label">Breadth (cms):</label>' +
        '<input type="number" class="form-control" name="breadth[]" placeholder="Breadth" step="0.01">' +
        '</div>' +
        '<div class="col-md-3 mb-3">' +
        '<label class="form-label">Length (cms):</label>' +
        '<input type="number" class="form-control" name="length[]" placeholder="Length" step="0.01">' +
        '</div>' +
        '</div>';

    return html;
}

/**
 * Expand all variants
 */
$(document).on('click', '#expand_all', function () {
    $('.product-variant-selectbox').find('.collapse').addClass('show');
});

/**
 * Collapse all variants
 */
$(document).on('click', '#collapse_all', function () {
    $('.product-variant-selectbox').find('.collapse').removeClass('show');
});

/**
 * Remove variants button click handler
 */
$(document).on('click', '.remove_variants', function (e) {
    e.preventDefault();

    Notiflix.Confirm.show(
        'Are you sure want to delete this variant?',
        "You won't be able to revert this after update!",
        'Yes, Delete it!',
        'Cancel',
        function okCb() {
            $(this).closest('.product-variant-selectbox').remove();
            variant_counter -= 1;

            var numItems = $('.product-variant-selectbox').length;
            if (numItems == 0) {
                $('.no-variants-added').show();
            }

            showToast('Variant removed', 'success');
        }.bind(this),
        function cancelCb() {
            // User cancelled
        }
    );
});

/**
 * Initialize sortable for attributes and variants
 */
$(document).ready(function () {
    if (document.getElementById('attributes_process')) {
        $('#attributes_process').sortable({
            handle: '.ti-arrows-sort',
            axis: 'y',
            opacity: 0.6,
            cursor: 'grab',
            placeholder: 'sortable-placeholder'
        });
    }

    if (document.getElementById('variants_process')) {
        $('#variants_process').sortable({
            handle: '.ti-arrows-sort',
            axis: 'y',
            opacity: 0.6,
            cursor: 'grab',
            placeholder: 'sortable-placeholder'
        });
    }
});

/**
 * Load existing attributes and variations when editing a product
 */
$(document).ready(function () {
    var edit_product_id = $('input[name=edit_product_id]').val();

    if (edit_product_id) {
        // Load attributes and variations for the product being edited
        // create_fetched_attributes_html('admin').done(function () {
        create_fetched_attributes_html(from).done(function () {

            $('.no-attributes-added').hide();
            $('#save_attributes').removeClass('d-none');
            $('.no-variants-added').hide();
            save_attributes();

            // Store initial state after loading (so we can detect actual changes later)
            window.initial_attributes_values = JSON.stringify(attributes_values);
            window.initial_all_attributes_values = JSON.stringify(all_attributes_values);

            // Load existing variants with their data instead of generating new ones

            // load_existing_variants('admin');
            load_existing_variants(from);
        });
    }
});

/**
 * Product form submission handler
 */
$('#save-product').on('submit', function (e) {
    e.preventDefault();

    var $form = $(this);

    var $submitBtn = $('#save_product_button');
    var originalText = $submitBtn.html();

    // Basic validation
    // var productName = $('input[name="pro_input_name"]').val().trim();
    // var shortDescription = $('textarea[name="short_description"]').val().trim();
    // var categoryId = $('input[name="category_id"]').val();
    // var productImage = $('input[name="pro_input_image"]').val();
    // var sellerId = $('select[name="seller_id"]').val();

    // if (!productName) {
    //     showToast('Product name is required', 'error');
    //     $('input[name="pro_input_name"]').focus();
    //     return;
    // }

    // if (!shortDescription) {
    //     showToast('Short description is required', 'error');
    //     $('textarea[name="short_description"]').focus();
    //     return;
    // }

    // if (!categoryId) {
    //     showToast('Category is required', 'error');
    //     // Focus on the category tree container
    //     $('#product_category_tree_view_html').focus();
    //     return;
    // }

    // if (!productImage) {
    //     showToast('Product image is required', 'error');
    //     return;
    // }

    // if (!sellerId) {
    //     showToast('Seller is required', 'error');
    //     $('select[name="seller_id"]').focus();
    //     return;
    // }

    // Disable submit button and show loading
    $submitBtn.prop('disabled', true).html('<i class="ti ti-loader-2 spin"></i> Processing...');

    $('input[name="product_type"]').val($('#product-type').val());
    if ($('.simple_stock_management_status').is(':checked')) {
        $('input[name="simple_product_stock_status"]').val($('#simple_product_stock_status').val());
    } else {
        $('input[name="simple_product_stock_status"]').val('');
    }
    // $('#product-type').prop('disabled', true);
    // $('.product-attributes').removeClass('disabled');
    // $('.product-variants').removeClass('disabled');
    // $('.simple_stock_management_status').prop('disabled', true);

    var catid = $('#product_category_tree_view_html').jstree("get_selected");
    var current_sellerId = $('#sellerSelect').val();

    // Prepare form data
    var formData = new FormData(this);


    // Debug: Log other_images count
    var otherImagesCount = $('input[name="other_images[]"]').length;

    $('input[name="other_images[]"]').each(function (index) {
        console.log('other_images[' + index + ']:', $(this).val());
    });


    formData.append(csrfName, csrfHash);


    formData.append('category_id', catid);


    if ($form.attr('action').includes('/admin/')) {
        $('#seller_id').val($('#sellerSelect').val());
    }


    formData.append('seller_id', $('#seller_id').val());


    formData.append('product_type', $('#product-type').val());



    if ($('.simple_stock_management_status').is(':checked')) {
        formData.append('simple_product_stock_status', $('#simple_product_stock_status').val());
    }

    // Add variant stock management settings
    if ($('.variant_stock_status').is(':checked')) {
        formData.append('variant_stock_status', '0');
        formData.append('variant_stock_level_type', $('.variant-stock-level-type').val());
    }

    // Add attributes and variations data
    save_attributes(); // Ensure attributes are saved before form submission

    // Add attribute values to form data
    if (typeof all_attributes_values !== 'undefined' && all_attributes_values.length > 0) {
        formData.append('attribute_values', all_attributes_values);
    }

    // Add variants_ids to form data (only attribute value combination IDs)
    var variantsIds = [];
    $('.product-variant-selectbox').each(function (index) {
        var attributeValueIds = [];
        // Get only the attribute value IDs from variant_col hidden inputs
        $(this).find('.variant_col input[type="hidden"]').each(function () {
            if ($(this).val()) {
                attributeValueIds.push($(this).val());
            }
        });
        if (attributeValueIds.length > 0) {
            variantsIds.push(attributeValueIds.join(','));
        }
    });

    if (variantsIds.length > 0) {
        variantsIds.forEach(function (variantId, index) {
            formData.append('variants_ids[]', variantId);
        });
    }

    // Add additional form data based on product type
    var productType = $('#product-type').val();
    if (productType === 'variable_product') {
        // For variable products, ensure we have variants
        var variantCount = $('.product-variant-selectbox').length;
        if (variantCount === 0) {
            showToast('Please add at least one variant for variable products', 'error');
            $submitBtn.prop('disabled', false).html(originalText);
            return;
        }
    } else {
        // For simple products, add simple product data
        var simplePrice = $('input[name="simple_price"]').val();
        if (!simplePrice || simplePrice <= 0) {
            showToast('Price is required for simple products', 'error');
            $('input[name="simple_price"]').focus();
            $submitBtn.prop('disabled', false).html(originalText);
            return;
        }
    }


    // Submit the form
    $.ajax({
        type: 'POST',
        url: $form.attr('action'),

        data: formData,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {

            // Update CSRF token
            if (response.csrfName && response.csrfHash) {
                csrfName = response.csrfName;
                csrfHash = response.csrfHash;
            }

            if (response.error === false) {
                showToast(response.message || 'Product saved successfully!', 'success');

                // Redirect to product list after successful save
                setTimeout(function () {
                    window.location.href = base_url + from + "/product";
                }, 1500);
            } else {
                showToast(response.message || 'Error saving product', 'error');
            }
        },
        error: function (xhr, status, error) {
            console.error('Form submission error:', error);
            showToast('Error saving product. Please try again.', 'error');
        },
        complete: function () {
            // Re-enable submit button
            $submitBtn.prop('disabled', false).html(originalText);
        }
    });
});

/**
 * Save settings for variable products
 */
$(document).on('click', '.save-variant-general-settings', function (e) {
    e.preventDefault();

    if ($('.variant_stock_status').is(":checked")) {
        if ($('.variant-stock-level-type').filter(function () {
            return this.value === '';
        }).length === 0 && $.trim($('.variant-stock-level-type').val()) != "") {

            if ($('.variant-stock-level-type').val() == 'product_level' && $('.variant-stock-mustfill-field').filter(function () {
                return this.value === '';
            }).length !== 0) {
                showToast('Please fill all the required fields', 'error');
            } else {
                $('input[name="product_type"]').val($('#product-type').val());
                $('input[name="variant_stock_level_type"]').val($('#stock_level_type').val());
                $('input[name="variant_stock_status"]').val("0");
                $('#product-type').prop('disabled', true);
                $('#stock_level_type').prop('disabled', true);
                $(this).removeClass('save-variant-general-settings');
                $('#tab-for-attributes').removeClass('disabled');
                $('#tab-for-variations').removeClass('disabled d-none');
                $('.variant-stock-level-type').prop('readonly', true);
                $('#stock_status_variant_type').attr('readonly', true);
                $('.variant-product-level-stock-management').find('input,select').prop('readonly', true);
                $('.variant_stock_status').prop('disabled', true);

                // Switch to attributes tab (Bootstrap 5)
                $('a[href="#product-attributes"]').tab('show');

                Notiflix.Report.success(
                    'Settings Saved!',
                    'Attributes & Variations Can Be Added Now',
                    'Okay'
                );
            }
        } else {
            showToast('Please fill all the required fields', 'error');
        }

    } else {
        $('input[name="product_type"]').val($('#product-type').val());
        $('input[name="variant_stock_status"]').val("");
        $('input[name="variant_stock_level_type"]').val("");
        $('.variant_stock_status').prop('disabled', true);
        $('#product-type').prop('disabled', true);
        $('#tab-for-attributes').removeClass('disabled');
        $('#tab-for-variations').removeClass('disabled d-none');

        // Switch to attributes tab (Bootstrap 5)
        $('a[href="#product-attributes"]').tab('show');

        Notiflix.Report.success(
            'Settings Saved!',
            'Attributes & Variations Can Be Added Now',
            'Okay'
        );
    }
});

$(document).on('click', '#reset_variants', function () {

    Notiflix.Confirm.show(
        'Are You Sure To Reset!',
        "You won't be able to revert this after update!",
        'Yes, Reset it!',
        'Cancel',
        function () { // ✅ On Confirm
            Notiflix.Loading.circle('Reseting Variations...');

            // Add a simple loading overlay instead of using blockUI
            $('.additional-info').css({
                'position': 'relative',
                'pointer-events': 'none',
                'opacity': '0.6'
            }).append('<div class="variants-loading-overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,0.8); display: flex; align-items: center; justify-content: center; z-index: 999;"><h6 style="color: #333;">Reseting Variations...</h6></div>');

            if (attributes_values.length > 0) {
                $('.no-variants-added').hide();
                var from = (window.location.href.indexOf("seller/") > -1) ? 'seller' : 'admin';
                variant_counter = 0;
                create_fetched_variants_html(false, from);
            } else {
                showToast('No attributes available to generate variants', 'warning');
            }

            setTimeout(function () {
                $('.additional-info').css({
                    'pointer-events': 'auto',
                    'opacity': '1'
                });
                $('.variants-loading-overlay').remove();
                Notiflix.Loading.remove();
            }, 2000);
        },
        function () {
            // ❌ Cancel pressed (optional)
        }
    );

});

function initTomSelectForSearch({ element }) {
    new TomSelect(element, {
        create: false,
        sortField: { field: "text" },
        load: null,  // disable ajax search
    });
}
document.addEventListener("DOMContentLoaded", function () {
    const tomSelectElements = [
        '#indicator_select',
        '#deliverable_type',
        '#deliverable_city_type',
        '#deliverable_zipcode_type',
        '#pickup_location',
        '#status_filter',
        '#payment_method_filter',
        '#order_status_filter',
        '#video_type',
        '#product_type_menu',
        '#product-type',
        '#download_link_type'
    ];
    tomSelectElements.forEach(selector => {
        const el = document.querySelector(selector);
        if (el && !el.tomselect) {
            initTomSelectForSearch({ element: selector });
        } else {
        }
    });
});


$('#sales-report-table').on('load-success.bs.table', function (e, data) {

    if (data && data.total_order_sum) {
        $('#total-order-sum').text(currency + (data.total_order_sum));
    } else {
        $('#total-order-sum').text('0.00');
    }
});

function update_status(update_id, status, table, user) {
    $.ajax({
        type: 'GET',
        url: base_url + user + '/home/update_status',
        data: {
            id: update_id,
            status: status,
            table: table
        },
        dataType: 'json',
        success: function (result) {
            if (result['error'] == false) {
                showToast(result.message, "success");
                $('.table-striped').bootstrapTable('refresh');
            } else {
                showToast(result.message, "error");
            }
        }
    });
}

// Product Offcanvas AJAX View
$(document).on('click', '[data-bs-target="#viewProductOffcanvas"]', function (e) {
    e.preventDefault();
    var productId = $(this).data('id');

    if (!productId) {
        console.error('Product ID not found');
        return;
    }

    // Load product data
    loadProductDetails(productId);
});


function loadProductDetails(productId) {

    $.ajax({
        url: base_url + from + '/product/view_product',
        type: 'GET',
        dataType: 'json',
        data: { edit_id: productId, ajax: 1 },
        beforeSend: function () {
            $('#productOffcanvasBody').html('<div class="d-flex justify-content-center align-items-center p-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        },
        success: function (response) {
            if (response.error) {
                $('#productOffcanvasBody').html('<div class="alert alert-danger m-3">Failed to load product details</div>');
                return;
            }
            var html = buildProductHTML(response);
            $('#productOffcanvasBody').html(html);
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error:', error);
            $('#productOffcanvasBody').html('<div class="alert alert-danger m-3">Failed to load product details. Please try again.</div>');
        }
    });
}

function buildProductHTML(data) {
    var p = data.product_details[0];
    var variants = data.product_variants || [];
    var attributes = data.product_attributes || [];

    var currency = data.currency || '';

    var product_type = p.type || 'N/A';

    var html = '<div class="product-view-container">';

    // Header Section with Product Image and Basic Info
    html += '<div class="border mb-4 p-3 rounded">';
    html += '<div class="d-flex gap-3">';
    html += '<div class="">';
    html += '<div class="border p-2 product-image-container rounded">';
    html += '<img src="' + (p.image || '') + '" class="rounded" alt="' + (p.name || 'Product') + '">';
    html += '</div>';
    html += '</div>';
    html += '<div class="">';
    html += '<div class="product-info">';
    html += '<h2 class="">' + (p.name || 'N/A') + '</h2>';

    // Status and Type badges
    html += '<div class=" mb-3">';
    if (p.status == '1') {
        html += '<span class="badge bg-success-lt mx-2"><i class="ti ti-circle-check me-1"></i>Active</span>';
    } else if (p.status == '2') {
        html += '<span class="badge bg-warning-lt mx-2"><i class="ti ti-clock me-1"></i>Pending Approval</span>';
    } else {
        html += '<span class="badge bg-danger-lt mx-2"><i class="ti ti-circle-x me-1"></i>Inactive</span>';
    }

    if (p.type) {
        html += '<span class="badge bg-info-lt"><i class="ti ti-tag me-1"></i>' + product_type.replace(/_/g, " ") + '</span>';
    }
    html += '</div>';

    // Rating
    if (p.rating && p.rating > 0) {
        html += '<div class="align-items-center d-flex gap-3 mb-3">';
        html += '<div class="d-flex gap-0">';
        var fullStars = Math.floor(p.rating);
        var emptyStars = 5 - fullStars;
        for (var i = 0; i < fullStars; i++) {
            html += '<i class="ti ti-star-filled text-warning fs-2"></i>';
        }
        for (var i = 0; i < emptyStars; i++) {
            html += '<i class="ti ti-star text-muted"></i>';
        }
        html += '</div>';
        html += '<span class="fs-4 text-secondary">' + p.rating + ' out of 5 (' + (p.no_of_ratings || 0) + ' reviews)</span>';
        html += '</div>';
    }

    // Price and Stock Cards
    html += '<div class="d-flex gap-3">';
    html += '<div class="col-md-6">';
    html += '<div class="card d-flex flex-row gap-2 p-2">';
    html += '<div class="align-items-center bg-gray-100 border d-flex fs-1 info-icon justify-content-center rounded"><i class="ti ti-currency-dollar"></i></div>';
    html += '<div class="info-content">';
    html += '<div class="fs-4 fw-bold mb-1 text-muted">Price</div>';

    var price = (variants.length > 0 && variants[0].special_price) ? variants[0].special_price : (p.price || '0');
    html += '<div class="fs-3 fw-bolder text-secondary-emphasis">' + currency + price + '</div>';
    // if (variants.length > 0 && variants[0].special_price && variants[0].special_price != '0') {
    //     html += '<div class="info-discount">' + currency + variants[0].special_price + '</div>';
    // }
    html += '</div></div></div>';

    html += '<div class="col-md-6">';
    html += '<div class="card d-flex flex-row gap-2 p-2">';
    html += '<div class="align-items-center bg-gray-100 border d-flex fs-1 info-icon justify-content-center rounded"><i class="ti ti-package"></i></div>';
    html += '<div class="info-content">';
    html += '<div class="fs-4 fw-bold mb-1 text-muted">Stock</div>';
    html += '<div class="fs-3 fw-bolder text-secondary-emphasis">' + (p.total_stock || '0') + '</div>';
    html += '</div></div></div>';
    html += '</div>';

    html += '</div></div></div></div>';

    // Description Section
    if (p.description) {
        html += '<div class="border mb-4 overflow-auto rounded">';
        html += '<div class=" border-bottom p-3">';
        html += '<h3 class="align-items-center d-flex m-0 "><i class="ti ti-file-text me-2"></i>Description</h3>';
        html += '</div>';
        html += '<div class="p-3">';
        html += '<div class="">' + p.description + '</div>';
        html += '</div></div>';
    }

    // Product Information Section
    html += '<div class="border mb-4 overflow-auto rounded">';
    html += '<div class=" border-bottom p-3">';
    html += '<h3 class="align-items-center d-flex m-0 "><i class="ti ti-info-circle me-2"></i>Product Information</h3>';
    html += '</div>';
    html += '<div class="p-3">';
    html += '<div class="d-grid gap-1">';

    if (p.category_name) {
        html += '<div class="align-items-center border-bottom d-flex justify-content-lg-between p-2"><span class="fw-medium mb-0 ">Category</span><span class="align-items-center d-flex fs-3 gap-2 ">' + p.category_name + '</span></div>';
    }
    if (p.brand_name) {
        html += '<div class="align-items-center border-bottom d-flex justify-content-lg-between p-2"><span class="fw-medium mb-0 ">Brand</span><span class="align-items-center d-flex fs-3 gap-2 ">' + p.brand_name + '</span></div>';
    }
    if (p.seller_name) {
        html += '<div class="align-items-center border-bottom d-flex justify-content-lg-between p-2"><span class="fw-medium mb-0 ">Seller</span><span class="align-items-center d-flex fs-3 gap-2 ">' + p.seller_name + '</span></div>';
    }
    if (p.made_in) {
        html += '<div class="align-items-center border-bottom d-flex justify-content-lg-between p-2"><span class="fw-medium mb-0 ">Made In</span><span class="align-items-center d-flex fs-3 gap-2 ">' + p.made_in + '</span></div>';
    }
    if (p.sku) {
        html += '<div class="align-items-center border-bottom d-flex justify-content-lg-between p-2"><span class="fw-medium mb-0 ">SKU</span><span class="align-items-center d-flex fs-3 gap-2 ">' + p.sku + '</span></div>';
    }
    if (p.manufacturer) {
        html += '<div class="align-items-center border-bottom d-flex justify-content-lg-between p-2"><span class="fw-medium mb-0 ">Manufacturer</span><span class="align-items-center d-flex fs-3 gap-2 ">' + p.manufacturer + '</span></div>';
    }
    if (typeof p.cod_allowed !== 'undefined') {
        html += '<div class="align-items-center border-bottom d-flex justify-content-lg-between p-2"><span class="fw-medium mb-0 ">COD Allowed</span><span class="align-items-center d-flex fs-3 gap-2 ">' + (p.cod_allowed == '1' ? '<i class="ti ti-check text-success"></i> Yes' : '<i class="ti ti-x text-danger"></i> No') + '</span></div>';
    }
    if (typeof p.is_returnable !== 'undefined') {
        html += '<div class="align-items-center border-bottom d-flex justify-content-lg-between p-2"><span class="fw-medium mb-0 ">Returnable</span><span class="align-items-center d-flex fs-3 gap-2 ">' + (p.is_returnable == '1' ? '<i class="ti ti-check text-success"></i> Yes' : '<i class="ti ti-x text-danger"></i> No') + '</span></div>';
    }
    if (typeof p.is_cancelable !== 'undefined') {
        html += '<div class="align-items-center border-bottom d-flex justify-content-lg-between p-2"><span class="fw-medium mb-0 ">Cancelable</span><span class="align-items-center d-flex fs-3 gap-2 ">' + (p.is_cancelable == '1' ? '<i class="ti ti-check text-success"></i> Yes' : '<i class="ti ti-x text-danger"></i> No') + '</span></div>';
    }


    html += '</div></div></div>';

    // Variants Section
    if (variants.length > 0) {
        html += '<div class="border mb-4 overflow-auto rounded">';
        html += '<div class=" border-bottom p-3">';
        html += '<h3 class="align-items-center d-flex m-0 "><i class="ti ti-layers me-2"></i>Product Variants (' + variants.length + ')</h3>';
        html += '</div>';
        html += '<div class="p-3">';
        html += '<div class="d-grid gap-2">';
        for (var i = 0; i < variants.length; i++) {
            var v = variants[i];
            html += '<div class="align-items-center border d-flex justify-content-lg-between p-3 rounded">';
            html += '<div class="variant-info">';
            html += '<div class="fw-bold mb-1 ">' + (v.variant_values || 'Default') + '</div>';
            html += '<div class="d-flex fs-4 gap-3">';
            html += '<span class="fw-bold">' + currency + (v.special_price || '0') + '</span>';
            html += '<span class="text-secondary">Stock: ' + (v.stock || '0') + '</span>';
            html += '</div>';
            html += '</div>';
            html += '<div class="ms-3">';
            if (v.status == '1') {
                html += '<span class="active align-items-center badge border border-success d-flex fs-2 h-5 justify-content-center rounded-circle text-success w-5 active"><i class="ti ti-check"></i></span>';
            } else {
                html += '<span class="active align-items-center badge border border-danger d-flex fs-2 h-5 justify-content-center rounded-circle text-danger w-5 inactive"><i class="ti ti-x"></i></span>';
            }
            html += '</div></div>';
        }
        html += '</div></div></div>';
    }

    // Attributes Section

    if (attributes.length > 0 && attributes[0].ids != "" && attributes[0].ids != null) {
        html += '<div class="border mb-4 overflow-auto rounded">';
        html += '<div class=" border-bottom p-3">';

        html += '<h3 class="align-items-center d-flex m-0 "><i class="ti ti-list me-2"></i>Product Attributes (' + attributes.length + ')</h3>';
        html += '</div>';
        html += '<div class="p-3">';
        html += '<div class="attributes-grid d-grid gap-3">';
        for (var i = 0; i < attributes.length; i++) {
            var attr = attributes[i];
            html += '<div class="align-items-center  border d-flex gap-2 p-3 rounded">';
            html += '<div class="align-items-center attribute-icon border d-flex fs-2 justify-content-center rounded text-secondary"><i class="ti ti-tag"></i></div>';
            html += '<div class="attribute-content">';

            html += '<div class="fs-4 fw-bold mb-1 text-secondary">' + (attr.attr_name || attr.name || 'Attribute') + '</div>';
            html += '<div class="fw-bold ">' + (attr.value || '-') + '</div>';
            html += '</div></div>';
        }
        html += '</div></div></div>';
    }

    // Images Section
    if (p.other_images && p.other_images.length > 0) {
        html += '<div class="border mb-4 overflow-auto rounded">';
        html += '<div class="bg-secondary-lt border-bottom p-3">';
        html += '<h3 class="align-items-center d-flex m-0 "><i class="ti ti-photo me-2"></i>Product Images (' + p.other_images.length + ')</h3>';
        html += '</div>';
        html += '<div class="p-3">';
        html += '<div class="images-gallery d-grid gap-3">';
        for (var i = 0; i < p.other_images.length; i++) {
            html += '<div class="border gallery-item overflow-hidden position-relative rounded">';
            html += '<a href="' + p.other_images[i] + '" data-toggle="lightbox" data-gallery="product-gallery">';
            html += '<img src="' + p.other_images[i] + '" class="gallery-image" alt="Product Image ' + (i + 1) + '">';
            html += '</a></div>';
        }
        html += '</div></div></div>';
    }

    html += '</div>';

    html += '</div>';
    return html;
}


// shiprocket 

// $(document).on('hide.bs.offcanvas', '#consignment_status_offcanvas', function () {

//     $("#consignment-items-container").empty()
//     $("#tracking_box").empty()
//     $("#tracking_box_old").empty()
//     $('.shiprocket_order_box').removeClass('d-none');
//     $('.manage_shiprocket_box').addClass('d-none');

// })
$(document).on('show.bs.offcanvas', '#consignment_status_offcanvas', function (event) {
    let triggerElement = $(event.relatedTarget);
    current_selected_image = triggerElement;

    let consignment_items = $(current_selected_image).data('items');
    let order_tracking = $('#order_tracking').val();

    if (order_tracking != undefined) {
        order_tracking = JSON.parse(order_tracking);
    }

    $('#consignment_data').val(JSON.stringify(consignment_items));
    const container = document.getElementById('consignment-items-container');
    const tracking_box = document.getElementById('tracking_box');
    const tracking_box_old = document.getElementById('tracking_box_old');
    $('.shiprocket_field_box').addClass('d-none');
    $('#pickup_location_product').val(consignment_items[0]['pickup_location']);
    if (order_tracking != undefined) {
        order_tracking.forEach(tracking => {

            if (tracking.consignment_id == consignment_items[0].consignment_id) {

                if (tracking.is_canceled == 0) {
                    $('.shiprocket_order_box').addClass('d-none');
                    $('.manage_shiprocket_box').removeClass('d-none');
                    $('#' + tracking.shipment_id + '_shipment_id').removeClass('d-none');

                    let div = document.createElement('div');

                    div.innerHTML = `
                        <h5><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/></svg> Shiprocket Order Details</h5>
                        <p class="mb-0 text-bold"><span class="text-black-50">Shiprocket Order Id:</span> ${tracking.shiprocket_order_id}</p>
                        <p class="m-0 text-bold"><span class="text-black-50">Shiprocket Tracking Id:</span> ${tracking.tracking_id}</p>
                        <p class="m-0 text-bold"><span class="text-black-50">Shiprocket Tracking Url:</span> <a href="${tracking.url}" target="_blank" class="text-primary">${tracking.url}</a></p>
                        <input type="hidden" name="shiprocket_tracking_id" id="shiprocket_tracking_id" value="${tracking.tracking_id}">
                        <input type="hidden" name="shiprocket_order_id" id="shiprocket_order_id" value="${tracking.shiprocket_order_id}">
                        `;
                    tracking_box.appendChild(div);
                } else {

                    let div = document.createElement('div');


                    div.innerHTML = `
                        <hr><h5>Cancelled Shiprocket Order Details</h5>
                        <p class="mb-0 text-bold"><span class="text-black-50">Shiprocket Order Id:</span> ${tracking.shiprocket_order_id}</p>
                        <p class="m-0 text-bold"><span class="text-black-50">Shiprocket Tracking Id:</span> ${tracking.tracking_id}</p>
                        <p class="m-0 text-bold"><span class="text-black-50">Shiprocket Tracking url:</span> <a href="${tracking.url}" target="_blank" class="text-primary">${tracking.url}</a></p><hr>
                        `;
                    tracking_box_old.appendChild(div);
                }
            }
        });
    }
    const card = document.createElement('div');
    card.className = 'card p-3 border';
    let count = 1;
    card.innerHTML = `
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Image</th>
                <th scope="col">Quantity</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
`;
    const tbody = card.querySelector('tbody');

    consignment_items.forEach(element => {
        $('#consignment_id').val(element.consignment_id);
        $('#deliver_by').val(element.delivery_boy_id);
        $('.consignment_status').val(element.active_status);
        $('.consignment_status').change();
        tbody.innerHTML += `
        <tr>
            <td>${count++}</td>
            <td>${element.product_name}</td>
            <td><a href='${element.image}' class="image-box-100" data-toggle='lightbox' data-gallery='order-images'> <img src='${element.image}' alt="${element.product_name}"></a></td>
            <td>${element.quantity}</td>
        </tr>
    `;
    });
    container.appendChild(card);
});
$(document).on('click', '.refresh_shiprocket_status', function (e) {
    let tracking_id = $('#shiprocket_tracking_id').val();
    if (tracking_id == undefined || tracking_id == "" || tracking_id == null) {
        showToast('Tracking Id is Required', 'error');

        return false
    }
    $.ajax({
        type: "POST",
        url: base_url + from + '/orders/update_shiprocket_order_status',
        data: { tracking_id },
        dataType: "json",
        success: function (response) {
            if (response.error == false) {
                $("#consignment_table").bootstrapTable('refresh')
                showToast(response.message, 'success');

                response.data.forEach(element => {
                    $('.status-' + element['order_item_id']).addClass('badge-info').html(element['status'])
                });

                return
            }
            showToast(response.message, 'error');
            return false
        }
    });

});

$(document).on('change', '[name="create_shiprocket_button"]', function () {
    if ($(this).prop('checked')) {
        $('.shiprocket_order_box').removeClass('d-none')
    } else {
        $('.shiprocket_order_box').addClass('d-none')
    }
});

$(document).on('submit', '#shiprocket_order_parcel_form', function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    var fromAdmin = $('#fromAdmin').val();
    var fromSeller = $('#fromseller').val();

    console.log(fromAdmin);
    console.log(fromSeller);


    formData.append(csrfName, csrfHash);
    if (fromSeller != 'undefined' && fromSeller == 1) {
        var url = base_url + 'seller/orders/create_shiprocket_order';
    }
    if (fromAdmin != 'undefined' && fromAdmin == 1) {
        var url = base_url + 'admin/orders/create_shiprocket_order';
    }

    Notiflix.Confirm.show(
        'Are You Sure!',
        'You want to create Order!',
        'Yes, create order!',
        'Cancel',
        function () { // ✅ On Confirm
            console.log('here');

            Notiflix.Loading.circle('Creating Order...');

            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function (result) {
                    Notiflix.Loading.remove();
                    csrfName = result['csrfName'];
                    csrfHash = result['csrfHash'];
                    if (result.error == false) {
                        showToast(result.message, 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        showToast(result.message, 'warning');
                    }
                },
                error: function () {
                    Notiflix.Loading.remove();
                    showToast('Something went wrong with ajax!', 'error');
                }
            });
        },
        function () {
            // ❌ Cancel pressed - do nothing (optional)
        }
    );

});

$('.generate_awb').on('click', function (e) {
    e.preventDefault()

    var shipment_id = $(this).attr('id')
    var fromSeller = $(this).data('fromseller');
    var fromAdmin = $(this).data('fromadmin');
    if (fromSeller != 'undefined' && fromSeller == 1) {
        var url = base_url + 'seller/orders/generate_awb';
    }
    if (fromAdmin != 'undefined' && fromAdmin == 1) {
        var url = base_url + 'admin/orders/generate_awb';
    }
    Notiflix.Confirm.show(
        'Are You Sure!',
        'You want to generate AWB!',
        'Yes, generate AWB!',
        'Cancel',
        function () { // ✅ On Confirm
            Notiflix.Loading.circle('Generating AWB...');

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    shipment_id: shipment_id,
                    [csrfName]: csrfHash
                },
                dataType: 'json',
                success: function (result) {
                    Notiflix.Loading.remove();

                    if (result['error'] == false) {
                        showToast(result['message'], 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        showToast(result['message'], 'warning');
                    }
                },
                error: function () {
                    Notiflix.Loading.remove();
                    showToast('Something went wrong with ajax!', 'error');
                }
            });
        },
        function () {
            // ❌ Cancel pressed - do nothing (optional)
        }
    );

})

$('.send_pickup_request').on('click', function (e) {
    e.preventDefault()
    var shipment_id = $(this).attr('name')
    var fromSeller = $(this).data('fromseller');
    var fromAdmin = $(this).data('fromadmin');
    if (fromSeller != 'undefined' && fromSeller == 1) {
        var url = base_url + 'seller/orders/send_pickup_request';
    }
    if (fromAdmin != 'undefined' && fromAdmin == 1) {
        var url = base_url + 'admin/orders/send_pickup_request';
    }
    Notiflix.Confirm.show(
        'Are You Sure!',
        'You want to send pickup request!',
        'Yes, send request!',
        'Cancel',
        function () { // ✅ On Confirm
            Notiflix.Loading.circle('Sending Request...');

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    shipment_id: shipment_id,
                    [csrfName]: csrfHash
                },
                dataType: 'json',
                success: function (result) {
                    Notiflix.Loading.remove();

                    if (result['error'] == false) {
                        showToast(result['message'], 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        showToast(result['message'], 'warning');
                    }
                },
                error: function () {
                    Notiflix.Loading.remove();
                    showToast('Something went wrong with ajax!', 'error');
                }
            });
        },
        function () {
            // ❌ Cancel clicked - do nothing
        }
    );

})

$('.generate_label').on('click', function (e) {
    e.preventDefault()
    var shipment_id = $(this).attr('name')
    var fromSeller = $(this).data('fromseller');
    var fromAdmin = $(this).data('fromadmin');
    if (fromSeller != 'undefined' && fromSeller == 1) {
        var url = base_url + 'seller/orders/generate_label';
    }
    if (fromAdmin != 'undefined' && fromAdmin == 1) {
        var url = base_url + 'admin/orders/generate_label';
    }
    Notiflix.Confirm.show(
        'Are You Sure!',
        'You want to generate label!',
        'Yes, generate label!',
        'Cancel',
        function () { // ✅ On Confirm
            Notiflix.Loading.circle('Generating Label...');

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    shipment_id: shipment_id,
                    [csrfName]: csrfHash
                },
                dataType: 'json',
                success: function (result) {
                    Notiflix.Loading.remove();

                    if (result['error'] == false) {
                        showToast(result['message'], 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        showToast(result['message'], 'warning');
                    }
                },
                error: function () {
                    Notiflix.Loading.remove();
                    showToast('Something went wrong with ajax!', 'error');
                }
            });
        },
        function () {
            // ❌ Cancel clicked - no action
        }
    );

})

$('.generate_invoice').on('click', function (e) {
    e.preventDefault()
    var order_id = $(this).attr('name')
    var fromSeller = $(this).data('fromseller');
    var fromAdmin = $(this).data('fromadmin');
    if (fromSeller != 'undefined' && fromSeller == 1) {
        var url = base_url + 'seller/orders/generate_invoice';
    }
    if (fromAdmin != 'undefined' && fromAdmin == 1) {
        var url = base_url + 'admin/orders/generate_invoice';
    }
    Notiflix.Confirm.show(
        'Are You Sure!',
        'You want to generate invoice!',
        'Yes, generate invoice!',
        'Cancel',
        function () { // ✅ On Confirm
            Notiflix.Loading.circle('Generating Invoice...');

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    order_id: order_id,
                    [csrfName]: csrfHash
                },
                dataType: 'json',
                success: function (result) {
                    Notiflix.Loading.remove();

                    if (result['error'] == false) {
                        showToast(result['message'], 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        showToast(result['message'], 'warning');
                    }
                },
                error: function () {
                    Notiflix.Loading.remove();
                    showToast('Something went wrong with ajax!', 'error');
                }
            });
        },
        function () {

        }
    );

})

$('.cancel_shiprocket_order').on('click', function (e) {
    e.preventDefault()
    let shiprocket_order_id = $('#shiprocket_order_id').val()
    if (shiprocket_order_id == undefined || shiprocket_order_id == null || shiprocket_order_id == "") {
        showToast('Shiprocket Order Id Not Found', 'error');
        return
    }

    Notiflix.Confirm.show(
        'Are You Sure!',
        'You want to cancel order!',
        'Yes, cancel it!',
        'Cancel',
        function () { // ✅ On Confirm
            Notiflix.Loading.circle('Cancelling Order...');

            $.ajax({
                type: 'POST',
                url: base_url + from + '/orders/cancel_shiprocket_order',
                data: {
                    shiprocket_order_id: shiprocket_order_id,
                    [csrfName]: csrfHash
                },
                dataType: 'json',
                success: function (result) {
                    Notiflix.Loading.remove();

                    if (result['error'] == false) {
                        showToast(result['message'], 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        showToast(result['message'], 'warning');
                    }
                },
                error: function () {
                    Notiflix.Loading.remove();
                    showToast('Something went wrong with ajax!', 'error');
                }
            });
        },
        function () {
            // ❌ Cancel click - nothing to do (optional)
        }
    );

})

function consignmentModal(seller_id = null) {
    if (from == "admin") {
    }

    let shiprocket_order = $("#is_shiprocket_order_check").val() == "1";

    let productVariantIds = []
    let productName = []
    let orderItemId = []
    let orderPickupLocation = []
    let orderPickupLocationData = [] // Store both ID and name
    let orderItemIds = []

    $('.product_variant_id').each(function () {
        productVariantIds.push($(this).val());
    });

    productVariantIds.map(function (value) {
        let itemData = JSON.parse($("#product_variant_id_" + value).text());
        orderItemIds.push(itemData["id"])
        productName.push(itemData["product_name"] || "Product"); // Get product name from JSON data
        orderPickupLocation.push(itemData["pickup_location"]);

        // Store pickup location with its name
        if (itemData["pickup_location"]) {
            orderPickupLocationData.push({
                id: itemData["pickup_location"],
                name: itemData["pickup_location_name"] || itemData["pickup_location"]
            });
        }
    });

    // Create unique set of pickup locations based on ID
    let pickupLocationMap = {};
    orderPickupLocationData.forEach(function (loc) {
        if (!pickupLocationMap[loc.id]) {
            pickupLocationMap[loc.id] = loc.name;
        }
    });

    // Create options array with ID as value and name as text
    let options = Object.keys(pickupLocationMap).map(function (id) {
        let locationName = pickupLocationMap[id];
        // Fallback to pickupLocationsMap if name is empty or same as ID
        if (!locationName || locationName === id) {
            locationName = (typeof pickupLocationsMap !== 'undefined' && pickupLocationsMap[id]) ? pickupLocationsMap[id] : id;
        }
        return {
            value: id, text: locationName
        }
    });

    $("#parcel_pickup_locations").empty(); // Clear existing options
    $("#parcel_pickup_locations").append(new Option("Select Option", "")); // Add default option
    options.forEach(option => {
        $("#parcel_pickup_locations").append(new Option(option.text, option.value));
    });

    var modalBody = document.getElementById('product_details');
    if (modalBody == null) {
        return iziToast.error({
            message: "Order status is still awaiting. You cannot create a parcel."
        });
    }

    modalBody.innerHTML = '';

    for (var i = 0; i < productVariantIds.length; i++) {
        const data = JSON.parse($("#product_variant_id_" + productVariantIds[i]).html());

        const quantity = parseInt(data.quantity);
        const unit_price = parseInt(data.unit_price);
        const delivered_quantity = parseInt(data.delivered_quantity);
        const pickupLocationId = data.pickup_location || '';

        if (delivered_quantity != quantity && data.active_status != "cancelled" && data.active_status != "delivered") {
            $('#empty_box_body').addClass("d-none");
            $('#modal-body').removeClass("d-none");
            let row = "<tr id='parcel_row_" + productVariantIds[i] + "' data-pickup='" + pickupLocationId + "' >" +
                "<th scope='row'>" + orderItemIds[i] + "</th>" +
                "<td>" + productName[i] + "</td>" +
                "<td>" + productVariantIds[i] + "</td>" +
                "<td>" + quantity + "</td>" +
                "<td>" + unit_price + "</td>" +
                "<td><input type='checkbox' data-item-id='" + orderItemIds[i] + "' name='checkbox-" + productVariantIds[i] + "' id='checkbox-" + productVariantIds[i] + "' class='product-to-ship'></td>" +
                "</tr>";

            modalBody.innerHTML += row;
        }
    }
    if (modalBody.innerHTML == "") {
        $('#empty_box_body').removeClass("d-none");
        $('#modal-body').addClass("d-none");

        let empty_box_body = document.getElementById('empty_box_body');
        empty_box_body.innerHTML = "";
        let row = "<h5 class='text-center'>Items Are Already Shipped.</h5>";
        empty_box_body.innerHTML += row;
    }


    // Add event listener for dropdown change
    $("#parcel_pickup_locations").on("change", function () {
        const selectedPickupLocation = $(this).val();

        // Uncheck all checkboxes
        $(".product-to-ship").prop("checked", false);

        // For non-shiprocket orders, show all rows
        if (!shiprocket_order) {
            $("tr[id^='parcel_row_']").show();
            return;
        }

        // For shiprocket orders, filter by pickup location
        if (selectedPickupLocation === "") {
            // Hide all rows if no option is selected
            $("tr[id^='parcel_row_']").hide();
        } else {
            // Show rows that match the selected location and hide the others
            $("tr[id^='parcel_row_']").each(function () {
                const rowPickupLocation = String($(this).data("pickup"));

                // Convert both to strings for comparison to avoid type mismatch
                if (rowPickupLocation == selectedPickupLocation) {
                    $(this).show(); // Show rows that match
                } else {
                    $(this).hide(); // Hide rows that don't match
                }
            });
        }
    });

    $("#parcel_pickup_locations").change()

}

function delete_consignment(id) {
    Notiflix.Confirm.show(
        'Are You Sure!',
        "You won't be able to revert this!",
        'Yes, delete it!',
        'Cancel',
        function okCb() {
            $.ajax({
                type: "post",
                url: base_url + from + "/orders/delete_consignment",
                data: { id },
                dataType: "json",
                beforeSend: function () {
                    Notiflix.Loading.dots('Deleting...');
                },
                success: function (response) {
                    if (response.error === true) {
                        showToast('error', response.message);
                    } else {
                        response.data.map(val => {
                            $("#product_variant_id_" + val.product_variant_id)
                                .html(JSON.stringify(val));
                        });

                        showToast('success', 'Delete success');
                    }

                    $("#consignment_table").bootstrapTable('refresh');
                },
                complete: function () {
                    Notiflix.Loading.remove();
                }
            });
        },
        function cancelCb() {
            showToast('info', 'Delete cancelled');
        }
    );
}
(function () {
    if (window.sidebarKeepOpenInitialized) return;
    window.sidebarKeepOpenInitialized = true;

    const currentPath = window.location.pathname;
    let openDropdowns = JSON.parse(localStorage.getItem("openDropdowns") || "[]");

    document.querySelectorAll(".navbar-nav .nav-item.dropdown").forEach((item) => {
        const toggle = item.querySelector(".dropdown-toggle");
        const menu = item.querySelector(".dropdown-menu");
        if (!toggle || !menu) return;

        const dropdownKey = toggle.textContent.trim().replace(/\s+/g, "_").toLowerCase();
        toggle.setAttribute("data-bs-auto-close", "false");

        // ====== Highlight Active Submenu (Improved Matching) ======
        let bestMatch = null;
        let bestMatchLength = 0;

        item.querySelectorAll(".dropdown-item[href]").forEach((link) => {
            const href = link.getAttribute("href");
            if (!href || href === "#" || href.startsWith("javascript:")) return;

            let linkPath = "";
            try {
                linkPath = new URL(href, window.location.origin).pathname;
            } catch (e) { }

            // Longest path match = most specific
            if (
                currentPath === linkPath ||
                (currentPath.startsWith(linkPath + "/") && linkPath.length > bestMatchLength)
            ) {
                bestMatch = link;
                bestMatchLength = linkPath.length;
            }
        });

        let isActive = false;
        if (bestMatch) {
            isActive = true;
            bestMatch.classList.add("active-submenu");
            bestMatch.style.backgroundColor = "rgba(32, 107, 196, 0.2)";
            bestMatch.style.color = "#fff";
            bestMatch.style.fontWeight = "600";
            bestMatch.style.borderLeft = "3px solid #206bc4";
            bestMatch.style.paddingLeft = "calc(1rem - 3px)";
        }

        // ====== Restore Open Dropdowns ======
        if (isActive || openDropdowns.includes(dropdownKey)) {
            item.classList.add("show");
            menu.classList.add("show");
            toggle.setAttribute("aria-expanded", "true");
            toggle.style.backgroundColor = "rgba(255, 255, 255, 0.05)";
            toggle.style.fontWeight = "600";
        }

        // ====== Manual Toggle Click Handler ======
        toggle.addEventListener("click", function (e) {
            e.preventDefault();

            const isOpen = item.classList.contains("show");

            // Close all others first
            document.querySelectorAll(".navbar-nav .nav-item.dropdown.show").forEach((other) => {
                if (other !== item) {
                    other.classList.remove("show");
                    const otherMenu = other.querySelector(".dropdown-menu");
                    const otherToggle = other.querySelector(".dropdown-toggle");
                    if (otherMenu) otherMenu.classList.remove("show");
                    if (otherToggle) otherToggle.setAttribute("aria-expanded", "false");
                }
            });

            // Update open dropdown tracking
            if (isOpen) {
                item.classList.remove("show");
                menu.classList.remove("show");
                toggle.setAttribute("aria-expanded", "false");
                openDropdowns = openDropdowns.filter((k) => k !== dropdownKey);
            } else {
                item.classList.add("show");
                menu.classList.add("show");
                toggle.setAttribute("aria-expanded", "true");
                toggle.style.backgroundColor = "rgba(255, 255, 255, 0.05)";
                toggle.style.fontWeight = "600";
                openDropdowns = [dropdownKey];
            }

            localStorage.setItem("openDropdowns", JSON.stringify(openDropdowns));
        });

        // Prevent menu click from closing dropdown
        menu.addEventListener("click", (e) => e.stopPropagation(), true);
    });
})();
$(document).ready(function () {
    $('#sms-gateway-modal').on('hidden.bs.modal', function () {

        $('.smsgateway_setting_form').removeClass('d-none');
        $('.update_notification_module').removeClass('d-none');
    });
});

// ====== Highlight Non-Dropdown Menu Items (Longest Match Rule) ======
(function () {
    const currentPath = window.location.pathname;
    let bestMatch = null;
    let bestMatchLength = 0;

    document.querySelectorAll(".navbar-nav > .nav-item > .nav-link").forEach((link) => {
        if (link.classList.contains("dropdown-toggle")) return;

        const href = link.getAttribute("href");
        if (!href) return;

        let linkPath = "";
        try {
            linkPath = new URL(href, window.location.origin).pathname;
        } catch (e) { }

        // Exact match OR deeper nested path
        if (
            currentPath === linkPath ||
            (currentPath.startsWith(linkPath + "/") && linkPath.length > bestMatchLength)
        ) {
            bestMatch = link;
            bestMatchLength = linkPath.length;
        }
    });

    // Apply highlight ONLY to best match
    if (bestMatch) {
        bestMatch.classList.add("active");
        bestMatch.style.backgroundColor = "rgba(32, 107, 196, 0.2)";
        bestMatch.style.color = "#fff";
        bestMatch.style.fontWeight = "600";
        bestMatch.style.borderLeft = "3px solid #206bc4";
        bestMatch.style.paddingLeft = "calc(1rem - 3px)";
    }
})();

document.querySelectorAll(".navbar-nav > .nav-item > .nav-link:not(.dropdown-toggle)")
    .forEach((link) => {
        link.addEventListener("click", function () {

            // Close ALL open dropdowns
            document.querySelectorAll(".navbar-nav .nav-item.dropdown.show").forEach((openItem) => {
                openItem.classList.remove("show");

                const openMenu = openItem.querySelector(".dropdown-menu");
                const openToggle = openItem.querySelector(".dropdown-toggle");

                if (openMenu) openMenu.classList.remove("show");
                if (openToggle) openToggle.setAttribute("aria-expanded", "false");
            });

            // Clear from localStorage
            localStorage.removeItem("openDropdowns");
        });
    });


$(document).off('click', '[data-toggle="lightbox"]').on('click', '[data-toggle="lightbox"]', function (event) {
    event.preventDefault();
    $(this).ekkoLightbox();
});

//  Consignment Order Status Update
$(document).on('click', '.consignment_order_status_update', function (e) {
    let consignment_id = $("#consignment_id").val();
    let status = $(".consignment_status").val();
    let parcel_otp = $("#parcel-otp").val();
    let delivery_boy_otp_system = $('#delivery_boy_otp_system').val();

    if (status == "" || status == null) {
        showToast('Please Select Status', 'error');
        return false;
    }
    if (status === "delivered" && delivery_boy_otp_system == 1 && parcel_otp == "") {
        showToast('Parcel OTP is Required.', 'error');
        return false;
    }

    let deliver_by = $('#deliver_by').val();

    Notiflix.Confirm.show(
        'Are You Sure!',
        "You won't be able to revert this!",
        'Yes, update it!',
        'Cancel',
        function okCb() {
            Notiflix.Loading.standard('Updating...');

            $.ajax({
                type: 'POST',
                url: base_url + from + '/orders/update_order_status',
                data: {
                    consignment_id,
                    status,
                    parcel_otp,
                    deliver_by,
                    delivery_boy_otp_system,
                    [csrfName]: csrfHash
                },
                dataType: 'json',
                success: function (result) {
                    Notiflix.Loading.remove();
                    csrfName = result['csrfName'];
                    csrfHash = result['csrfHash'];

                    if (result['error'] == false) {
                        $("#consignment_table").bootstrapTable('refresh');
                        showToast(result['message'], 'success');

                        result.data.forEach(element => {
                            $('.status-' + element['order_item_id'])
                                .addClass('badge-info')
                                .html(element['status']);
                        });
                        setTimeout(function () { location.reload(); }, 1000);
                    } else {
                        showToast(result['message'], 'error');
                    }
                },
                error: function () {
                    Notiflix.Loading.remove();
                    showToast('Something went wrong with ajax!', 'error');
                }
            });
        },
        function cancelCb() {
            showToast('Cancelled! No changes were made.', 'info');

        }
    );
});