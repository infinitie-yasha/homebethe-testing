"use strict";

/* ---------------------------------------------------------------------------------------------------------------------------------------------------

Common-Functions or events
 1.login-Module
 2.Product-Module
 3.Category-Module
 4.Order-Module
 5.Featured_Section-Module
 6.Notifation-Module
 7.Faq-Module
 8.Slider-Module
 9.Offer-Module
 10.Promo_code-Module
 11.Delivery_boys-Module 
 12.Settings-Module 
 13.City-Module
 14.Transaction_Module
 15.Customer-Wallet-Module   
 16.Fund-Transfer-Module
 17.Return-Request-Module
 18.Tax-Module
 19.Image Upload 
 20.Client Api Key Module  
 21.System Users
 22.custom-notification-Module
 23. whatsapp status
--------------------------------------------------------------------------------------------------------------------------------------------------- */

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

var auth_settings = $('#auth_settings').val();
var currency = $('#currency').val();

$(document).ready(function () {
    $('#loading').hide();

    // Initialize variants section on page load
    initializeVariantsSection();

    // Also run it after a short delay to catch any late-loading content
    setTimeout(function () {
        initializeVariantsSection();
    }, 500);

    // Don't run initialization when variants tab is clicked - let variants load naturally
});

if (window.location.href.indexOf('admin') > -1) {
    // send admin notification
    $(document).ready(function () {
        setInterval(function () {
            $.ajax({
                type: 'GET',
                url: base_url + 'admin/home/get_notification',
                dataType: 'json',
                success: function (result) {
                    var html = '';
                    html += '<a href="javascript:void(0);" id="notification_count" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg"><i class="ti ti-bell fs-3"></i><span class="badge bg-danger-lt navbar-badge order_notification mt-1">' + result.count_notifications + '</span></a>';
                    $('#refresh_notification').html(html);
                }
            });
        }, 3000);
    });

}

$(document).on('click', '#notification_count', function (e, rows) {
    e.preventDefault();
    $('#list').toggle();
    if ($('#list').is(":visible")) {
        // Display a "Please Wait" message or spinner while waiting for the response
        $('#list').html('<div class="card"><div class="card-body text-center">Please Wait...</div></div>').addClass("show");

        $.ajax({
            type: 'GET',
            url: base_url + 'admin/home/new_notification_list',
            dataType: 'json',
            success: function (result) {
                var html = '';
                var statusDot;
                var seconds_ago;

                // Start card wrapper
                html += '<div class="card">';
                html += '<div class="card-header d-flex">';
                html += '<h3 class="card-title">Notifications</h3>';
                html += '<div class="btn-close ms-auto" id="close-notification-dropdown" style="cursor: pointer;"></div>';
                html += '</div>';

                // Start list-group
                html += '<div class="list-group list-group-flush list-group-hoverable">';

                if (result.notifications.length > 0) {
                    $.each(result.notifications, function (i, a) {
                        // Status dot: red for unread, grey for read
                        statusDot = (a.read_by && a.read_by == 0)
                            ? '<span class="status-dot status-dot-animated bg-red d-block"></span>'
                            : '<span class="status-dot d-block"></span>';

                        seconds_ago = a.date_sent;

                        html += '<div class="list-group-item">';
                        html += '<div class="row align-items-center">';
                        html += '<div class="col-auto">' + statusDot + '</div>';
                        html += '<div class="col text-truncate">';
                        html += '<a href="' + base_url + 'admin/orders/edit_orders?edit_id=' + a.type_id + '&noti_id=' + a.id + '" class="text-body d-block">' + a.title + '</a>';
                        html += '<div class="d-block text-secondary text-truncate mt-n1">' + a.message + '</div>';
                        html += '</div>';
                        html += '<div class="col-auto">';
                        // html += '<a href="#" class="list-group-item-actions">';
                        // html += '<i class="fs-2 text-secondary ti ti-star"></i>';
                        // html += '</a>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                    });
                } else {
                    html += '<div class="list-group-item text-center text-muted py-4">';
                    html += '<div>No New Notifications</div>';
                    html += '</div>';
                }

                // Close list-group
                html += '</div>';

                // Card footer with action buttons - matching the image layout
                html += '<div class="card-body">';
                html += '<div class="d-flex gap-2">';

                if (result.notifications.length > 0) {
                    html += '<div class="col-6">';
                    html += '<a href="' + base_url + 'admin/Notification_settings/manage_system_notifications" class="btn btn-2 w-100">See All Notifications</a>';
                    html += '</div>';
                    html += '<div class="col-6">';
                    html += '<a href="javascript:void(0);" class="btn w-100 mark-all-as-read">Mark all as read</a>';
                    html += '</div>';
                } else {
                    html += '<div class="col-12">';
                    html += '<div class="dropdown-footer mt-2">No New Notifications</div>';
                    html += '</div>';
                }

                html += '</div>';
                html += '</div>';

                // Close card wrapper
                html += '</div>';

                $('#list').html(html);
            }
        });
    }
});

$(document).on('click', '.mark-all-as-read', function () {

    Notiflix.Confirm.show(
        'Are You Sure!',
        "You won't be able to revert this!",
        'Yes, mark as read!',
        'Cancel',
        function () {
            Notiflix.Loading.circle('Please wait...');

            $.ajax({
                url: base_url + 'admin/Notification_settings/mark_all_as_read',
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    Notiflix.Loading.remove();
                    if (response.error == false) {
                        showToast(response.message, 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 800);
                    } else {
                        showToast(response.message, 'error');
                    }
                },
                error: function () {
                    Notiflix.Loading.remove();
                    showToast('Something went wrong with ajax!', 'error');
                }
            });
        },
        function () {
            // Cancel callback (optional)
        }
    );
});

// Close notification dropdown when clicking the X button
$(document).on('click', '#close-notification-dropdown', function (e) {
    e.preventDefault();
    $('#list').hide();
    $('#list').removeClass('show');
});

// Close notification dropdown when clicking outside
$(document).on('click', function (e) {
    // Check if the click is outside the notification dropdown
    if (!$(e.target).closest('#list').length && !$(e.target).closest('#notification_count').length) {
        $('#list').hide();
    }
});




function mediaParams(p) {
    return {
        'type': $('#media_type').val(),
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search,
        'seller_id': $('input[name="seller_id"]').val(),
    };
}

/**
 * Initialize variants section on page load
 * Check if there are existing variants and show/hide appropriate elements
 */
function initializeVariantsSection() {
    // Only run this on initial page load, not during active variant loading
    // Just hide the "no variants" message if there are actual variants present
    var existingVariants = $('.product-variant-selectbox').length;

    if (existingVariants > 0) {
        // Check if the variant has actual content (not just the placeholder)
        var hasRealVariants = false;
        $('.product-variant-selectbox').each(function () {
            // If the variant has input fields with values or more than just the sort icon, it's a real variant
            if ($(this).find('input[type="text"]').length > 0 || $(this).find('.col-2').length > 0) {
                hasRealVariants = true;
                return false; // Break the loop
            }
        });

        if (hasRealVariants) {
            $('.no-variants-added').hide();
        }
    }
}

function mediaUploadParams(p) {
    return {
        'type': $('#media-type').val(),
        "start_date": $('#start_date').val(),
        "end_date": $('#end_date').val(),
        "seller_id": $('#seller_id').val(),
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}

function noti_query_params(p) {
    return {
        "message_type": $('#message_type').val(),
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}

function home_query_params(p) {
    return {
        "start_date": $('#start_date').val(),
        "end_date": $('#end_date').val(),
        "order_status": $('#order_status').val(),
        "payment_method": $('#payment_method').val(),
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}

function queryParams(p) {
    return {
        "filter_d_boy": $('#filter_d_boy').val(),
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}

function ticket_queryParams(p) {
    return {
        ticket_type_filter: $('#ticket_type_filter').val(),
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}

function slider_queryParams(p) {
    return {
        type_filter: $('#type_filter').val(),
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}

function offer_queryParams(p) {
    return {
        type_filter: $('#type_filter').val(),
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}

function promo_code_queryParams(p) {
    return {
        discount_type_filter: $('#discount_type_filter').val(),
        status_filter: $('#status_filter').val(),
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}

function return_request_queryParams(p) {
    return {
        status_filter: $('#status_filter').val(),
        seller_filter: $('#seller_filter').val(),
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}

function ticket_type_queryParams(p) {
    return {
        ticket_type_filter: $('#ticket_type_filter').val(),
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}

function customer_wallet_query_params(p) {
    return {
        user_id: $('#customerSelect').val(),
        status: $('#transaction_status_filter').val(),
        payment_type: $('#transaction_type').val(),
        transaction_type: 'wallet',
        user_type: 'members',
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}

// Refresh table on all filter changes
$(document).on('change', '#customerSelect, #transaction_status_filter, #transaction_type', function () {
    $('#customer-transaction-table').bootstrapTable('refresh');
});

function seller_wallet_query_params(p) {
    return {
        "transaction_status_type_filter": $('#transaction_status_type_filter').val(),
        "seller_filter": $('#seller_filter').val(),
        transaction_type: 'wallet',
        user_type: 'seller',
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}
$(document).on('change', '#seller_filter', function () {
    $('#seller_wallet_transaction_table').bootstrapTable('refresh');
});

function seller_status_params(s) {
    return {
        "seller_status": $('#seller_status_filter').val(),
        limit: s.limit,
        sort: s.sort,
        order: s.order,
        offset: s.offset,
        search: s.search
    };
}

function product_query_params(p) {
    return {
        "category_id": $('#category_parent').val(),
        "seller_id": $('#seller_filter').val(),
        "status": $('#status_filter').val(),
        "brand_id": $('#brand_filter').val(),
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}

function cash_collection_query_params(p) {
    return {
        filter_date: $('#filter_date').val(),
        filter_status: $('#filter_status').val(),
        filter_d_boy: $('#filter_d_boy').val(),
        "start_date": $('#start_date').val(),
        "end_date": $('#end_date').val(),
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}

function transaction_query_params(p) {
    return {
        transaction_type: 'transaction',
        user_id: $('#transaction_user_id').val(),
        filter_user_id: $('#customerSelect').val(),
        // status filter (empty => all)
        status: $('#transaction_status_filter').val(),
        // payment/transaction type filter (empty => all)
        payment_type: $('#transaction_type').val(),
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}

function address_query_params(p) {
    return {
        user_id: $('#address_user_id').val(),
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}

function order_tracking_query_params(p) {
    return {
        "order_id": $('input[name="order_id"]').val(),
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}

// Handle View Order Tracking Offcanvas
$(document).on('click', '.view_order_tracking', function (e) {
    e.preventDefault();
    var order_id = $(this).data("order_id");
    $('#view_order_id').val(order_id);

    // Show loading state
    $('#tracking-loading').show();
    $('#tracking-empty').hide();
    $('#tracking-cards-container').empty().hide();

    // Fetch order tracking data
    $.ajax({
        url: base_url + 'admin/orders/get-order-tracking',
        type: 'GET',
        data: {
            order_id: order_id,
            limit: 100,
            offset: 0,
            sort: 'id',
            order: 'DESC'
        },
        dataType: 'json',
        success: function (response) {
            $('#tracking-loading').hide();

            if (response.rows && response.rows.length > 0) {
                displayTrackingCards(response.rows);
                $('#tracking-cards-container').show();
            } else {
                $('#tracking-empty').show();
            }
        },
        error: function (xhr, status, error) {
            $('#tracking-loading').hide();
            $('#tracking-empty').show();
            console.error('Error fetching tracking data:', error);
        }
    });
});

// Function to display tracking data in cards
function displayTrackingCards(trackingData) {
    var container = $('#tracking-cards-container');
    container.empty();

    trackingData.forEach(function (item) {
        var card = `
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h3 class="card-title mb-1">
                                    <i class="ti ti-package text-primary me-2"></i>
                                    Tracking #${item.id}
                                </h3>
                                <span class="badge bg-primary-lt">Order ID: ${item.order_id}</span>
                            </div>
                            <div class="text-end">
                                <small class="text-muted">
                                    <i class="ti ti-calendar me-1"></i>${item.date}
                                </small>
                            </div>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <div class="bg-primary-lt p-2 rounded me-3">
                                        <i class="ti ti-building text-primary fs-3"></i>
                                    </div>
                                    <div>
                                        <label class="form-label text-muted mb-1 small">Courier Agency</label>
                                        <div class="fw-bold">${item.courier_agency || 'N/A'}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <div class="bg-success-lt p-2 rounded me-3">
                                        <i class="ti ti-barcode text-success fs-3"></i>
                                    </div>
                                    <div>
                                        <label class="form-label text-muted mb-1 small">Tracking ID</label>
                                        <div class="fw-bold">${item.tracking_id || 'N/A'}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <div class="bg-info-lt p-2 rounded me-3">
                                        <i class="ti ti-list-numbers text-info fs-3"></i>
                                    </div>
                                    <div>
                                        <label class="form-label text-muted mb-1 small">Order Item ID</label>
                                        <div class="fw-bold">${item.order_item_id || 'N/A'}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <div class="bg-warning-lt p-2 rounded me-3">
                                        <i class="ti ti-link text-warning fs-3"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <label class="form-label text-muted mb-1 small">Tracking URL</label>
                                        <div class="fw-bold text-truncate" style="max-width: 250px;">
                                            ${item.url ? '<a href="' + item.url + '" target="_blank" class="text-primary">' + item.url + '</a>' : 'N/A'}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        ${item.url ? `
                        <div class="mt-3 pt-3 border-top">
                            <a href="${item.url}" target="_blank" class="btn btn-primary w-100">
                                <i class="ti ti-external-link me-2"></i>Track Shipment
                            </a>
                        </div>
                        ` : ''}
                        
                        ${item.operate ? `
                        <div class="mt-3 pt-3 border-top">
                            <div class="d-flex justify-content-end gap-2">
                                ${item.operate}
                            </div>
                        </div>
                        ` : ''}
                    </div>
                </div>
            </div>
        `;

        container.append(card);
    });
}

function digital_order_mails_query_params(p) {
    return {
        "order_item_id": $('input[name="order_item_id"]').val(),
        "order_id": $('input[name="order_id"]').val(),
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}

function category_query_params(p) {
    return {
        "category_id": $('#category_id').val(),
        "status": $('#category_status_filter').val(),
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}

function blog_query_params(p) {
    return {
        "category_id": $('#category_parent').val(),
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}

function brand_query_params(p) {
    return {
        "brand_id": $('#brand_id').val(),
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}

function delivery_boy_status_params(p) {
    return {
        "delivery_boy_status": $('#delivery_boy_status_filter').val(),
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}

function affiliate_status_params(s) {
    return {
        "affiliate_status": $('#affiliate_status_filter').val(),
        limit: s.limit,
        sort: s.sort,
        order: s.order,
        offset: s.offset,
        search: s.search
    };
}
function customer_query_params(p) {
    return {
        "customer_status": $('#customer_status_filter').val(),
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}

function pickup_location_query_params(p) {
    return {
        "verified_status": $('#verified_status_filter').val(),
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}

function orders_query_params(p) {
    return {
        "start_date": $('#start_date').val(),
        "end_date": $('#end_date').val(),
        "order_status": $('#order_status').val(),
        "user_id": $('#order_user_id').val(),
        "seller_id": $('#order_seller_id').val(),
        "payment_method": $('#payment_method').val(),
        "order_type": $('#order_type').val(),
        "seller_id": $('#seller_id').val(),
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}

function consignment_query_params(p) {

    return {
        order_id: $('#order_id').val(),
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}

function product_faq_query_params(p) {
    return {
        "product_id": $('#ProductSelect').val(),
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}

function product_rating_query_params(p) {
    return {
        "product_id": $('#ProductSelect').val(),
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}
function stock_query_params(p) {
    return {
        "category_id": $('#categorySelect').val(),
        "seller_id": $('#seller_filter').val(),
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}

function sales_report_query_params(p) {
    return {
        "start_date": $('#start_date').val(),
        "end_date": $('#end_date').val(),
        "seller_id": $('#seller_filter').val(),
        "payment_method": $('#payment_method_filter').val(),
        "order_status": $('#order_status_filter').val(),
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}

function sales_inventory_report_query_params(p) {
    return {
        "start_date": $('#start_date').val(),
        "end_date": $('#end_date').val(),
        "seller_id": $('#seller_ids').val(),
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}

// Sales Inventory Pie Chart
let salesInventoryChart = null;

// Initialize Sales Inventory Chart on page load
function initializeSalesInventoryChart() {
    if (document.getElementById('sales_piechart_3d')) {
        // Wait for ApexCharts to be available
        function waitForApexCharts() {
            if (typeof ApexCharts !== 'undefined') {
                loadSalesInventoryChart();
            } else {
                setTimeout(waitForApexCharts, 100);
            }
        }
        waitForApexCharts();
    }
}

// Load Sales Inventory Chart
function loadSalesInventoryChart() {
    const apiUrl = (typeof base_url !== 'undefined' ? base_url : '') + 'admin/sales_inventory/top_selling_products';

    // Get filter values
    const startDate = $('#start_date').val();
    const endDate = $('#end_date').val();
    const sellerId = $('#seller_ids').val();

    // Build URL with parameters
    const params = {};
    if (startDate) params.start_date = startDate;
    if (endDate) params.end_date = endDate;
    if (sellerId) params.seller_id = sellerId;

    const queryString = $.param(params);
    const fullUrl = apiUrl + (queryString ? '?' + queryString : '');

    fetch(fullUrl)
        .then(response => response.json())
        .then(result => {


            // Validate data
            if (!result || result.length <= 1) {
                $('#sales_piechart_3d').html('<div class="text-center text-muted p-4"><p>No data available</p></div>');
                return;
            }

            // Convert data to ApexCharts format
            const labels = [];
            const series = [];

            for (let i = 1; i < result.length; i++) {
                if (result[i] && result[i][0] && result[i][1] !== undefined) {
                    let productName = String(result[i][0]).trim();
                    if (productName.length > 25) productName = productName.substring(0, 22) + '...';
                    labels.push(productName);
                    series.push(parseFloat(result[i][1]) || 0);
                }
            }

            if (labels.length === 0) {
                $('#sales_piechart_3d').html('<div class="text-center text-muted p-4"><p>No valid data available</p></div>');
                return;
            }

            // Destroy previous chart if exists
            if (window.salesInventoryChart && typeof window.salesInventoryChart.destroy === 'function') {
                window.salesInventoryChart.destroy();
            }
            $('#sales_piechart_3d').html('');

            // Chart options
            const options = {
                chart: {
                    type: 'donut',
                    height: '100%',
                    width: '100%',
                    fontFamily: 'inherit',
                    toolbar: { show: false },
                    animations: { enabled: true },
                },
                colors: ['#1e40af', '#3b82f6', '#60a5fa', '#93c5fd', '#9bc3f7ff', '#1e3a8a', '#2563eb', '#1d4ed8', '#1e90ff', '#4169e1'],
                series: series,
                labels: labels,
                legend: {
                    position: 'right',
                    fontSize: '14px',
                    offsetY: 0,
                    itemMargin: { horizontal: 5, vertical: 5 },
                    markers: { width: 8, height: 8, radius: 2 },
                    formatter: function (seriesName, opts) {
                        return seriesName + ': ' + opts.w.globals.series[opts.seriesIndex];
                    }
                },
                plotOptions: {
                    pie: {
                        expandOnClick: true,
                        donut: {
                            size: '65%',
                            labels: {
                                show: true,
                                name: {
                                    show: true,
                                    fontSize: '16px',
                                    fontWeight: 600,
                                    color: '#374151',
                                    offsetY: -10,
                                },
                                value: {
                                    show: true,
                                    fontSize: '24px',
                                    fontWeight: 700,
                                    color: '#1f2937',
                                    offsetY: 16,
                                },
                                total: {
                                    show: true,
                                    label: 'Total Orders',
                                    fontSize: '14px',
                                    fontWeight: 600,
                                    color: '#6b7280',
                                    formatter: function (w) {
                                        return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                    },
                                }
                            }
                        }
                    }
                },
                dataLabels: { enabled: false },
                tooltip: { enabled: true, y: { formatter: val => val + " orders" } },

                // 🧩 RESPONSIVE BREAKPOINTS
                responsive: [
                    {
                        breakpoint: 1400,
                        options: {
                            chart: { height: 400 },
                            legend: { position: 'right', fontSize: '13px' },
                            plotOptions: { pie: { donut: { size: '60%' } } },
                        },
                    },
                    {
                        breakpoint: 1200,
                        options: {
                            chart: { height: 380 },
                            legend: { position: 'right', fontSize: '12px' },
                            plotOptions: { pie: { donut: { size: '55%' } } },
                        },
                    },
                    {
                        breakpoint: 992,
                        options: {
                            chart: { height: 350 },
                            legend: { position: 'bottom', fontSize: '12px', offsetY: 10 },
                            plotOptions: { pie: { donut: { size: '50%' } } },
                        },
                    },
                    {
                        breakpoint: 768,
                        options: {
                            chart: { height: 320 },
                            legend: { position: 'bottom', fontSize: '11px', offsetY: 8 },
                            plotOptions: { pie: { donut: { size: '45%' } } },
                        },
                    },
                    {
                        breakpoint: 576,
                        options: {
                            chart: { height: 300 },
                            legend: { position: 'bottom', fontSize: '10px', offsetY: 5 },
                            plotOptions: { pie: { donut: { size: '40%' } } },
                            dataLabels: { style: { fontSize: '9px' } },
                        },
                    },
                    {
                        breakpoint: 400,
                        options: {
                            chart: { height: 260 },
                            legend: { position: 'bottom', fontSize: '9px', offsetY: 5 },
                            plotOptions: { pie: { donut: { size: '38%' } } },
                            tooltip: { style: { fontSize: '9px' } },
                        },
                    },
                ],
            };

            // Render chart
            window.salesInventoryChart = new ApexCharts(document.querySelector("#sales_piechart_3d"), options);
            window.salesInventoryChart.render();
        })
        .catch(error => {
            console.error('Error loading sales inventory chart:', error);
            $('#sales_piechart_3d').html('<div class="text-center text-muted p-4"><p>Error loading chart</p></div>');
        });
}


// Update Sales Inventory Chart (called when filters change)
function updateSalesInventoryChart() {
    if (document.getElementById('sales_piechart_3d')) {
        loadSalesInventoryChart();
    }
}

// Initialize chart when document is ready
$(document).ready(function () {
    initializeSalesInventoryChart();
});

$(document).on('change', '#seller_status_filter', function () {
    $('#seller_table').bootstrapTable('refresh');
});
$(document).on('change', '#customer_status_filter', function () {
    $('#customer-address-table').bootstrapTable('refresh');
});
$(document).on('change', '#customerSelect', function () {
    $('#customer-transaction-table').bootstrapTable('refresh');
});
// refresh transaction table when status filter changes
$(document).on('change', '#transaction_status_filter', function () {
    $('#customer-transaction-table').bootstrapTable('refresh');
});
// refresh when transaction type filter changes
$(document).on('change', '#transaction_type', function () {
    $('#customer-transaction-table').bootstrapTable('refresh');
});
$(document).on('change', '#seller_filter, #status_filter, #category_parent, #brand_filter', function () {
    $('#products_table').bootstrapTable('refresh');
});
$(document).on('change', '#message_type', function () {
    $('#system_notofication_table').bootstrapTable('refresh');
});
$(document).on('change', '#category_parent', function () {
    $('#category_table').bootstrapTable('refresh');
    $('#blogs_table').bootstrapTable('refresh');
});
$(document).on('change', '#delivery_boy_status_filter', function () {
    $('#delivery_boy_data').bootstrapTable('refresh');
});
$(document).on('change', '#verified_status_filter', function () {
    $('#pickup_location_table').bootstrapTable('refresh');
});
$(document).on('change', '#transaction_status_type_filter', function () {
    $('#seller_wallet_transaction_table').bootstrapTable('refresh');
});
$(document).on('change', '#affiliate_status_filter', function () {
    $('#affiliate_users_table').bootstrapTable('refresh');
});
$(document).on('change', '#ProductSelect', function () {
    $('#products_faqs_table').bootstrapTable('refresh');
    $('#products_ratings_table').bootstrapTable('refresh');
});
$(document).on('change', '#user_filter, #status_filter', function () {
    $('#payment_request_table').bootstrapTable('refresh');
});
$(document).on('change', '#type_filter', function () {
    $('#slider_table').bootstrapTable('refresh');
    $('#offer_table').bootstrapTable('refresh');
});
$(document).on('change', '#discount_type_filter', function () {
    $('#promo_code_table').bootstrapTable('refresh');
});
$(document).on('change', '#status_filter', function () {
    // Only refresh promo_code_table if it exists on the page (promo code page)
    if ($('#promo_code_table').length) {
        $('#promo_code_table').bootstrapTable('refresh');
    }
    // Also refresh return_request_table if on return request page
    if ($('#return_request_table').length) {
        $('#return_request_table').bootstrapTable('refresh');
    }
});

// Refresh table when seller filter changes
$(document).on('change', '#seller_filter', function () {
    if ($('#return_request_table').length) {
        $('#return_request_table').bootstrapTable('refresh');
    }
});
$(document).on('change', '#ticket_type_filter', function () {
    $('#ticket_type_table').bootstrapTable('refresh');
    $('#ticket_table').bootstrapTable('refresh');
});


$(document).on('change', '#categorySelect, #seller_filter', function () {
    $('#product_stock_table').bootstrapTable('refresh');
    // $('#products_ratings_table').bootstrapTable('refresh');
});






$(document).on('change', '.type_event_trigger', function (e, data) {
    e.preventDefault();
    var type_val = $(this).val();

    if (type_val != 'default' && type_val != '') {
        if (type_val == 'categories') {
            $('.slider-categories').removeClass('d-none');
            $('.notification-categories').removeClass('d-none');
            $('.offer-products').addClass('d-none');
            $('.offer-categories').removeClass('d-none');
            $('.slider-products').addClass('d-none');
            $('.notification-products').addClass('d-none');
            $('.slider-url').addClass('d-none');
            $('.offer-url').addClass('d-none');
            $('.notification-url').addClass('d-none');
            $('#slider_url_val').prop('disabled', true).prop('required', false);
        } else if (type_val == 'products') {
            $('.offer-products').removeClass('d-none');
            $('.offer-categories').addClass('d-none');
            $('.slider-products').removeClass('d-none');
            $('.notification-products').removeClass('d-none');
            $('.slider-categories').addClass('d-none');
            $('.notification-categories').addClass('d-none');
            $('.offer-url').addClass('d-none');
            $('.slider-url').addClass('d-none');
            $('.notification-url').addClass('d-none');
            $('#slider_url_val').prop('disabled', true).prop('required', false);
        } else if (type_val == 'sliderurl') {
            $('.slider-url').removeClass('d-none');
            $('.slider-categories').addClass('d-none');
            $('.notification-categories').addClass('d-none');
            $('.slider-products').addClass('d-none');
            $('.offer-url').removeClass('d-none');
            $('.offer-categories').addClass('d-none');
            $('.notification-products').addClass('d-none');
            $('.notification-url').addClass('d-none');
            $('#sliderurl_val').prop('disabled', false).prop('required', true);
        } else if (type_val == 'offer_url') {
            $('.offer-url').removeClass('d-none');
            $('.offer-categories').addClass('d-none');
            $('.offer-products').addClass('d-none');
            $('.slider-categories').addClass('d-none');
            $('.notification-categories').addClass('d-none');
            $('.slider-products').addClass('d-none');
            $('.notification-products').addClass('d-none');
            $('.notification-url').addClass('d-none');
        } else if (type_val == 'notification_url') {
            $('.offer-products').addClass('d-none');
            $('.offer-categories').addClass('d-none');
            $('.notification-url').removeClass('d-none');
            $('.offer-url').addClass('d-none');
            $('.slider-categories').addClass('d-none');
            $('.notification-categories').addClass('d-none');
            $('.slider-products').addClass('d-none');
            $('.notification-products').addClass('d-none');
        }
    } else {
        $('.slider-categories').addClass('d-none');
        $('.slider-url').addClass('d-none');
        $('.slider-products').addClass('d-none');
        $('.offer-url').addClass('d-none');
        $('.offer-products').addClass('d-none');
        $('.offer-categories').addClass('d-none');
        $('.notification-categories').addClass('d-none');
        $('.notification-products').addClass('d-none');
        $('.notification-url').addClass('d-none');
        $('#slider_url_val').prop('disabled', true).prop('required', false);
    }
});


function beforeSubmit(e) {

    try {
        if ($(e).attr('action').includes("admin/sellers/add_seller")) {
            if (document.getElementById("category_flag").value == "1") {
                $("#seller_model").click()
                showToast('Please set commision for the given categories', 'error');
                return false
            }
        }
    } catch (e) {

    }

    return true;
}


// For authentication method
$(document).ready(function () {
    // Define the function for handling authentication method
    function handleAuthenticationMethod() {
        var firebaseRadio = $('input[type=radio][id="firebaseRadio"]:checked').val();
        var smsRadio = $('input[type=radio][id="smsRadio"]:checked').val();

        if (firebaseRadio == 'firebase') {
            $('.firebase_config').removeClass('d-none');
            $('.sms_gateway').addClass('d-none');
        } else if (smsRadio == 'sms') {
            $('.sms_gateway').removeClass('d-none');
            $('.firebase_config').addClass('d-none');
        }
    }

    // Run the function on page load
    handleAuthenticationMethod();

    // Also run it on radio button change
    $('input[type=radio][name=authentication_method]').change(function () {
        handleAuthenticationMethod();
    });
});

$('#area_wise_delivery_charge').on('change', function (event, state) {

    if (!$('#area_wise_delivery_charge').is(':checked')) {
        if ($(".delivery_charge").hasClass("d-none")) {
            $(".delivery_charge").removeClass("d-none")
        }
        if ($(".min_amount").hasClass("d-none")) {
            $(".min_amount").removeClass("d-none")
        }
        if ($(".area_wise_delivery_charge").hasClass("col-md-6")) {
            $(".area_wise_delivery_charge").removeClass("col-md-6")
            $(".area_wise_delivery_charge").addClass("col-md-4")
        }
    } else {
        if (!$(".delivery_charge").hasClass("d-none")) {
            $(".delivery_charge").addClass("d-none")
        }
        if (!$(".min_amount").hasClass("d-none")) {
            $(".min_amount").addClass("d-none")
        }
        if ($(".area_wise_delivery_charge").hasClass("col-md-4")) {
            $(".area_wise_delivery_charge").removeClass("col-md-4")
            $(".area_wise_delivery_charge").addClass("col-md-6")
        }


    }
});

// for system setting of whatsapp status
$('#whatsapp_status').on('change', function (event, state) {

    if ($('#whatsapp_status').is(':checked')) {
        if ($("#whatsapp_number_div").hasClass("d-none")) {
            $("#whatsapp_number_div").removeClass("d-none")
        }
    } else {
        $("#whatsapp_number_div").addClass("d-none")

    }
});



function update_theme(update_id, status, table) {

    $.ajax({
        type: 'POST',
        url: base_url + 'admin/themes/switch',
        data: {
            id: update_id,
            status: status,
            table: table
        },
        dataType: 'json',
        success: function (result) {
            if (result['error'] == false) {
                showToast(result.message, "success");

                $('.table').bootstrapTable('refresh');
            } else {
                showToast(result.message, "error");
            }
        }
    });
}

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
            if (result['error'] == true) {
                showToast(result.message + ' Status Updated', "success");
                $('.table').bootstrapTable('refresh');
            } else {
                showToast(result.message + ' Status Not Updated', "error");
            }
        }
    });
}


// status change for panel all active/deactive
$(document).on('click', '.update_active_status', function () {
    console.log('clicked');
    var update_id = $(this).data('id');
    var status = $(this).data('status');
    var table = $(this).data('table');
    if (table == "themes") {
        update_theme(update_id, status, table, 'admin');
    } else {
        update_status(update_id, status, table, 'admin');
    }

});

// web language add form submission
$('#add-new-language-form').on('submit', function (e) {
    e.preventDefault();
    var formdata = new FormData(this);
    formdata.append(csrfName, csrfHash);
    $.ajax({
        type: 'POST',
        data: formdata,
        url: $(this).attr('action'),
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {
            $('#submit_btn').val('Please Wait...').attr('disabled', true);
        },
        success: function (result) {
            csrfName = result.csrfName;
            csrfHash = result.csrfHash;
            if (result.error == false) {
                $('#result').show().removeClass('msg_error').addClass('msg_success').html(result.message).delay(1500).fadeOut();
                $('#add-new-language-form')[0].reset();
                setTimeout(function () {
                    $('#language-modal').modal('hide');
                    location.reload();
                }, 2000)
            } else {
                $('#result').show().removeClass('msg_success').addClass('msg_error').html(result.message).delay(1500).fadeOut();
            }
            $('#submit_btn').val('Save').attr('disabled', false);
        }
    })
})


$("#web_theme_table").on("click-cell.bs.table", function (field, value, row, $el) {

    $('.offcanvas-title').text('Update Language');
    $('.save_language_btn').text('Update Language');
    $('#language_id').val($el.id);
    $('#language').val($el.language);
    $('#code').val($el.code);
    $('#native_language').val($el.native_language);

    if ($el.is_rtl_main == 1) {
        $('#is_rtl_create').prop('checked', true);
    }

})

$(document).on('click', '.addLanguageBtn', function (e) {
    $('.offcanvas-title').text('Add Language');
    $('.save_language_btn').text('Add Language');
    $('#language_id').val('');
    $('#language').val('');
    $('#code').val('');
    $('#native_language').val('');
    $('#is_rtl_create').prop('checked', false);
});


$("#promo_code_table").on("click-cell.bs.table", function (field, value, row, $el) {

    // console.log($(this).val());
    // For edit 
    $('.save_promocode').text('Update Promo Code');
    $('.offcanvas-title').text('update promocode');

    $('#add_promocode').val('');
    $('#edit_promo_code').val($el.id);
    $('#promo_code').val($el.promo_code);
    $('#message').val($el.message);
    $('#start_date').val($el.start_date);
    $('#end_date').val($el.end_date);
    $('#no_of_users').val($el.no_of_users);
    $('#minimum_order_amount').val($el.minimum_order_amount);
    $('#discount').val($el.discount);
    $('#max_discount_amount').val($el.max_discount_amount);
    $('#no_of_repeat_usage').val($el.no_of_repeat_usage);
    $('#uploaded_slider_uploaded_image').val($el.image_main_url);
    $('#slider_uploaded_image').attr('src', $el.image_main_url);


    $('#discount_type_select option').each(function () {
        if ($(this).val() === $el.discount_type_main) {
            $(this).prop('selected', true);
        }
    });
    $('#status option').each(function () {
        if ($(this).val() === $el.status_main) {
            $(this).prop('selected', true);
        }
    });
    $('#repeat_usage option').each(function () {
        if ($(this).val() === $el.repeat_usage_main) {
            $(this).prop('selected', true);
        }
    });
    // console.log($el.is_cashback);
    if ($el.is_cashback_value == 1) {
        $('#is_cashback').prop('checked', true);

    }
    if ($el.list_promocode_value == '1') {
        $('#list_promocode').prop('checked', true);
    }
    $('#status option').each(function () {
        if ($(this).val() === $el.status) {
            $(this).prop('selected', true);
        }
    });
    if ($el.repeat_usage_main == "1") {
        $('#repeat_usage_html').removeClass('d-none');
    }

    $('.image-upload-section').removeClass('d-none');


    // For view promo code details
    $('.offcanvas-title').text('Manage Promo Code');
    // Populate the offcanvas fields
    $('#view_promo_code').text($el.promo_code || '-');
    $('#view_message').text($el.message || '-');
    $('#view_start_date').text($el.start_date || '-');
    $('#view_end_date').text($el.end_date || '-');
    $('#view_no_of_users').text($el.no_of_users || '-');
    $('#view_minimum_order_amount').text($el.minimum_order_amount || '-');
    $('#view_discount').text($el.discount || '-');
    $('#view_image').attr('src', $el.image_main_url || base_url + 'assets/no-image.png');
    

    // Discount Type with badge 
    if ($el.discount_type_main === 'percentage') {
        $('#view_discount_type').html('<span class="badge bg-info-lt">Percentage %</span>');
        $('#view_max_discount_row').removeClass('d-none');
        $('#view_max_discount_amount').text($el.max_discount_amount || '-');
    } else {
        $('#view_discount_type').html('<span class="badge bg-success-lt">Amount ' + currency + '</span>');
        $('#view_max_discount_row').addClass('d-none');
    }

    // Repeat Usage with badge
    if ($el.repeat_usage == '1') {
        $('#view_repeat_usage').html('<span class="badge bg-info-lt">Allowed</span>');
        $('#view_repeat_usage_row').removeClass('d-none');
        $('#view_no_of_repeat_usage').text($el.no_of_repeat_usage || '-');
    } else {
        $('#view_repeat_usage').html('<span class="badge bg-danger-lt">Not Allowed</span>');
        $('#view_repeat_usage_row').addClass('d-none');
    }

    // Status with badge
    var currentDate = new Date();
    var endDate = new Date($el.end_date);
    if (endDate < currentDate) {
        $('#view_status').html('<span class="badge bg-danger-lt">Expired</span>');
    } else if ($el.status == '1') {
        $('#view_status').html('<span class="badge bg-success-lt">Active</span>');
    } else {
        $('#view_status').html('<span class="badge bg-secondary-lt">Inactive</span>');
    }

    // Is Cashback with badge
    // console.log($el);
    if ($el.is_cashback_value == '1') {
        $('#view_is_cashback').html('<span class="badge bg-success-lt">ON</span>');
    } else {
        $('#view_is_cashback').html('<span class="badge bg-warning-lt">OFF</span>');
    }

    // List Promocode with badge
    if ($el.list_promocode_value == '1') {
        $('#view_list_promocode').html('<span class="badge bg-primary-lt">SHOW</span>');
    } else {
        $('#view_list_promocode').html('<span class="badge bg-secondary-lt">HIDDEN</span>');
    }

    // Image
    if ($el.image_main_url && $el.image_main_url !== '') {
        $('#view_image').attr('src', $el.image_main_url);
    } else {
        $('#view_image').attr('src', base_url + 'assets/no-image.png');
    }

});


$(document).on('click', '.addPromocodeBtn', function (e) {
    $('.offcanvas-title').text('Add Promo Code');
    $('.save_promocode').text('Add Promo Code');
    $('#edit_promo_code').val('');
    $('#promo_code').val('');
    $('#message').val('');
    $('#start_date').val('');
    $('#end_date').val('');
    $('#no_of_users').val('');
    $('#minimum_order_amount').val('');
    $('#discount').val('');
    $('#discount_type_select').val('');
    $('#max_discount_amount').val('');
    $('#repeat_usage').val('');
    $('#no_of_repeat_usage').val('');
    $('#status').val('');
    $('#is_cashback').prop('checked', false);
    $('#list_promocode').prop('checked', false);
    $('#slider_uploaded_image').attr('src', base_url + 'assets/no-image.png');
    $('#max_discount_amount_html').addClass('d-none');
    $('#repeat_usage_html').addClass('d-none');
    $('.edit_promo_upload_image_note').text('');
    $('.image-upload-section').addClass('d-none');

});

$(document).on('change', '#repeat_usage', function () {
    var repeat_usage = $(this).val();

    if (typeof repeat_usage != 'undefined' && repeat_usage == '1') {
        $('#repeat_usage_html').removeClass('d-none');
    } else {
        $('#repeat_usage_html').addClass('d-none');
    }
});

$(document).on('change', '#discount_type_select', function () {
    var discount_type = $(this).val();

    if (typeof discount_type != 'percentage' && discount_type == 'percentage') {
        $('#max_discount_amount_html').removeClass('d-none');
    } else {
        $('#max_discount_amount_html').addClass('d-none');
    }

});


// Handle delete image functionality for other images and variant images
$(document).on('click', '.delete-img', function (e) {
    e.preventDefault();

    var $this = $(this);
    var field = $this.data('field');
    var isJson = $this.data('isjson');
    var $imageCard = $this.closest('.col-6, .col-md-4, .col-lg-3, .col-md-3');

    Notiflix.Confirm.show(
        'Delete Image',
        'Are you sure you want to delete this image? This action cannot be undone.',
        'Yes, delete it!',
        'Cancel',
        function okCb() {
            // Add loading state to the image being deleted
            $imageCard.addClass('image-processing');

            // Remove the image from the UI with animation
            $imageCard.fadeOut(300, function () {
                $(this).remove();

                // Update image numbers after removal
                updateImageNumbers();

                // Check if no images left, show placeholder
                if ($('.image-upload-div .card').length === 0) {
                    $('.image-upload-div').remove();
                    $('.container-fluid.row.mt-2').append(`
                        <div class="d-flex gap-2 image-upload-section">
                            <div class="card border-dashed">
                                <div class="card-body text-center py-5">
                                    <i class="ti ti-photo-plus text-muted fs-3"></i>
                                    <p class="text-muted mt-3 mb-0">No gallery images added yet</p>
                                    <small class="text-muted">Click "Add Images" button to add images</small>
                                </div>
                            </div>
                        </div>
                    `);
                }

                showToast('Image deleted successfully', 'success');
            });
        },
        function cancelCb() {
            // User cancelled, do nothing
        }
    );
});

// Function to update other_images hidden inputs after deletion
function updateOtherImagesHiddenInputs() {
    var $imageContainer = $('.image-upload-div');
    var $hiddenInputs = $imageContainer.find('input[name="other_images[]"]');

    // Remove all existing hidden inputs
    $hiddenInputs.remove();

    // Add new hidden inputs for remaining images
    $imageContainer.find('img').each(function () {
        var imgSrc = $(this).attr('src');
        if (imgSrc && imgSrc.includes('uploads/')) {
            var imgPath = imgSrc.replace(base_url, '');
            $(this).closest('.card').append('<input type="hidden" name="other_images[]" value="' + imgPath + '">');
        }
    });
}






$(document).on('change', '#media-type', function () {
    $('table').bootstrapTable('refresh');
});

Dropzone.autoDiscover = false;

if (document.getElementById('dropzone')) {

    var myDropzone = new Dropzone("#dropzone", {
        url: base_url + 'admin/media/upload',
        paramName: "documents",
        autoProcessQueue: false,
        parallelUploads: 12,
        maxFiles: 12,
        autoDiscover: false,
        addRemoveLinks: true,
        timeout: 180000,
        dictRemoveFile: 'x',
        dictMaxFilesExceeded: 'Only 12 files can be uploaded at a time ',
        dictResponseError: 'Error',
        uploadMultiple: true,
        dictDefaultMessage: '<p>Drag & Drop Media Files Here</p>',
    });

    myDropzone.on("addedfile", function (file) {
        var i = 0;
        if (this.files.length) {
            var _i, _len;
            for (_i = 0, _len = this.files.length; _i < _len - 1; _i++) {
                if (this.files[_i].name === file.name && this.files[_i].size === file.size && this.files[_i].lastModifiedDate.toString() === file.lastModifiedDate.toString()) {
                    this.removeFile(file);
                    i++;
                }
            }
        }
    });

    myDropzone.on("error", function (file, response) { });


    myDropzone.on('sending', function (file, xhr, formData) {
        formData.append(csrfName, csrfHash);
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var response = JSON.parse(this.response);
                csrfName = response.csrfName;
                csrfHash = response.csrfHash;
                if (response['error'] == false) {
                    Dropzone.forElement('#dropzone').removeAllFiles(true);
                    $("#media-upload-table").bootstrapTable('refresh');

                    showToast(response['message'], "success");
                    $('#media-table').bootstrapTable('refresh');
                } else {
                    showToast(response['message'], "error");
                }
                $(file.previewElement).find('.dz-error-message').text(response.message);
            }
        };
    });
}

if (document.getElementById('system-update-dropzone')) {

    var systemDropzone = new Dropzone("#system-update-dropzone", {
        url: base_url + 'admin/updater/upload_update_file',
        paramName: "update_file",
        autoProcessQueue: false,
        parallelUploads: 1,
        maxFiles: 1,
        timeout: 360000,
        autoDiscover: false,
        addRemoveLinks: true,
        dictRemoveFile: 'x',
        dictMaxFilesExceeded: 'Only 1 file can be uploaded at a time ',
        dictResponseError: 'Error',
        uploadMultiple: true,
        dictDefaultMessage: '<p>Drag & Drop System Update / Installable / Plugin\'s .zip file Here</p>',
    });

    systemDropzone.on("addedfile", function (file) {
        var i = 0;
        if (this.files.length) {
            var _i, _len;
            for (_i = 0, _len = this.files.length; _i < _len - 1; _i++) {
                if (this.files[_i].name === file.name && this.files[_i].size === file.size && this.files[_i].lastModifiedDate.toString() === file.lastModifiedDate.toString()) {
                    this.removeFile(file);
                    i++;
                }
            }
        }
    });

    systemDropzone.on("error", function (file, response) { });


    systemDropzone.on('sending', function (file, xhr, formData) {
        formData.append(csrfName, csrfHash);
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var response = JSON.parse(this.response);
                csrfName = response.csrfName;
                csrfHash = response.csrfHash;
                if (response['error'] == false) {
                    showToast(response['message'], "success");
                } else {
                    showToast(response['message'], "error");
                }
                $(file.previewElement).find('.dz-error-message').text(response.message);
            }
        };
    });
    $('#system_update_btn').on('click', function (e) {
        e.preventDefault();
        if (systemDropzone.files.length === 0) {
            showToast('Please select a file to upload', 'error');
            return;
        }
        systemDropzone.processQueue();
    });
}

$('#upload-files-btn').on('click', function (e) {
    e.preventDefault();
    myDropzone.processQueue();
    if (myDropzone.files.length === 0) {
        showToast('Please upload at least one file.', 'error');
        return;
    }
});


function status_date_wise_search() {
    $('.table-striped').bootstrapTable('refresh');
    // Update sales inventory chart if it exists
    updateSalesInventoryChart();
}
function status_date_wise_search_cash_collection() {
    $('.table-striped').bootstrapTable('refresh');
}

function resetfilters() {
    // Clear date pickers and other legacy filters
    $('#datepicker').val('');
    $('#media-type').val('');
    $('#start_date').val('');
    $('#end_date').val('');
    //Clear daterange picker
    if ($('#datepicker').data('daterangepicker')) {
        $('#datepicker').data('daterangepicker').remove();
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
            locale: {
                "format": "DD/MM/YYYY",
                "separator": " - ",
                "cancelLabel": 'Clear',
                'label': 'Select range of dates to filter'
            }
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
    }

    // Clear product filters
    // Reset status filter
    $('#status_filter').val('').trigger('change');
    $('#payment_method').val('').trigger('change');
    $('#order_status').val('').trigger('change');
    $('#order_type').val('').trigger('change');
    $('#filter_status').val('').trigger('change');

    // Clear TomSelect instances
    const categorySelect = document.getElementById('categorySelect');
    if (categorySelect && categorySelect.tomselect) {
        categorySelect.tomselect.clear();  // remove selected option
        $('#categorySelect').trigger('change'); // refresh logic if needed
    }

    const sellerSelect = document.getElementById('seller_filter');
    if (sellerSelect && sellerSelect.tomselect) {
        sellerSelect.tomselect.clear();
    }

    const orderStatusSelect = document.getElementById('order_status_filter');
    if (orderStatusSelect && orderStatusSelect.tomselect) {
        orderStatusSelect.tomselect.clear();
    }

    const paymentSelect = document.getElementById('payment_method_filter');
    if (paymentSelect && paymentSelect.tomselect) {
        paymentSelect.tomselect.clear();
    }

    const brandSelect = document.getElementById('brand_filter');
    if (brandSelect && brandSelect.tomselect) {
        brandSelect.tomselect.clear();
    }
    const statusSelect = document.getElementById('status_filter');
    if (statusSelect && statusSelect.tomselect) {
        statusSelect.tomselect.clear();
    }

    // Clear seller_ids dropdown (for sales inventory page)
    const sellerIdsSelect = document.getElementById('seller_ids');
    if (sellerIdsSelect) {
        $(sellerIdsSelect).val('').trigger('change');
    }

    // Refresh the products table if it exists
    if ($('#products_table').length && typeof $('#products_table').bootstrapTable === 'function') {
        $('#products_table').bootstrapTable('refresh');
    }

    // Call legacy search function for other pages
    if (typeof status_date_wise_search === 'function') {
        status_date_wise_search();
    }

    // Show success message if toast function exists
    if (typeof showToast === 'function') {
        showToast('All filters cleared!', 'info');
    }
}

// Offers all functions
$(document).on('click', '.addOfferBtn', function (e) {
    e.preventDefault();
    $('.offcanvas-title').text('Add Offer');
    $('.save_offer').text('Add Offer');

    $('#edit_offer').val('');
    $('#category_parent').val('').trigger('change');
    $('#offer_type').val('').trigger('change');
    $('#product_offer_id').val('').trigger('change');
    $('.edit_offer_upload_image_note').text('');
    $('.offer-categories').addClass('d-none');
    $('.offer-products').addClass('d-none');
    $('.offer-url').addClass('d-none');
    $('#offer_uploaded_image').hide();
});

$('#offer_table').on('click-cell.bs.table', function (field, value, row, $el) {

    $('.offcanvas-title').text('Update Offer');
    $('.save_offer').text('Update Offer');


    $('.image-upload-section').removeClass('d-none');
    $('#edit_offer').val($el.id);
    $('#edit_offeroffer_url_val').val($el.link);
    $('#offer_type').val($el.type).trigger('change');

    if ($el.type == "default") {
        $('.offer-url').addClass('d-none');
        $('.offer-products').addClass('d-none');
        $('.offer-categories').addClass('d-none');
    } else if ($el.type == "categories") {
        $('.offer-categories').removeClass('d-none');
        $('.offer-url').addClass('d-none');
        $('.offer-products').addClass('d-none');
    } else if ($el.type == "products") {
        $('.offer-products').removeClass('d-none');
        $('.offer-url').addClass('d-none');
        $('.offer-categories').addClass('d-none');
    } else if ($el.type == "offer_url") {
        $('.offer-url').removeClass('d-none');
        $('.offer-products').addClass('d-none');
        $('.offer-categories').addClass('d-none');
    }

    $('#uploaded_offer_uploaded_image').attr('src', $el.image_main_url);
    $('#offer_uploaded_image').attr('src', base_url + $el.image_main_url);
});


// Slider functions


$('#slider_table').on('click-cell.bs.table', function (field, value, row, $el) {

    $('.offcanvas-title').text('Update Slider');
    $('.save_slider').text('Update Slider');

    $('.image-upload-section').removeClass('d-none');

    $('#edit_slider').val($el.id);
    $('#slider_url_val').val($el.link);
    $('#slider_type').val($el.type).trigger('change');


    $('#slider_uploaded_image').attr('src', base_url + $el.image_main_url);
    $('#uploaded_slider_uploaded_image').val($el.image_main_url);


    // $('.no-image-container').hide();

    $('.edit_slider_upload_image_note').removeClass('d-none');

    // Type display logic
    if ($el.type == "default") {
        $('.slider-url, .slider-products, .slider-categories').addClass('d-none');
    } else if ($el.type == "categories") {
        $('.slider-categories').removeClass('d-none');
        $('.slider-url, .slider-products').addClass('d-none');
    } else if ($el.type == "products") {
        $('.slider-products').removeClass('d-none');
        $('.slider-url, .slider-categories').addClass('d-none');
    } else if ($el.type == "slider_url") {
        $('.slider-url').removeClass('d-none');
        $('.slider-products').addClass('d-none');
        $('.slider-categories').addClass('d-none');
    }
});


// Add Slider
$(document).on('click', '.addSliderBtn', function (e) {
    e.preventDefault();

    // Reset form
    $('#add_slider_form')[0].reset();
    $('#edit_slider').val('');
    $('#type_id').val('');

    // Update UI text
    $('.offcanvas-title').text('Add Slider');
    $('.save_slider').text('Add Slider');

    // Hide all type sections
    $('.slider-categories, .slider-products, .slider-url').addClass('d-none');

    // Reset select
    $('#slider_type').val('').trigger('change');

    // Clear and reset image section
    $('.image-upload-section').addClass('d-none');
    $('.edit_slider_upload_image_note').addClass('d-none');

    // Reset to default "no image" placeholder
    const defaultImage = base_url + 'path/to/no-image.png'; // Update this path
    $('#slider_uploaded_image').attr('src', defaultImage).attr('alt', 'No Image');
    $('#uploaded_slider_uploaded_image').val('');

    // Clear file input
    $('#image').val('');

    // Show offcanvas
    var offcanvas = new bootstrap.Offcanvas('#addSlider');
    offcanvas.show();
});






var noti_user_id = 0;
$('#select_user_id').on('change', function () {
    noti_user_id = ($('#select_user_id').val());
});


$(document).on("change", "#send_to", function (e) {
    e.preventDefault();
    var type_val = $(this).val();
    if (type_val == 'specific_user') {
        // to specific user
        $('.notification-users').removeClass('d-none');
    } else {
        $('.notification-users').addClass('d-none');
    }
});

//custom-notification-Module
$(document).on('change', '.type', function (e, data) {
    e.preventDefault();
    var sort_type_val = $(this).val();
    if (sort_type_val == 'place_order' && sort_type_val != ' ') {
        $('.place_order').removeClass('d-none');
    } else {
        $('.place_order').addClass('d-none');
    }
    if (sort_type_val == 'seller_place_order' && sort_type_val != ' ') {
        $('.seller_place_order').removeClass('d-none');
    } else {
        $('.seller_place_order').addClass('d-none');
    }
    if (sort_type_val == 'delivery_boy_order_processed' && sort_type_val != ' ') {
        $('.delivery_boy_order_processed').removeClass('d-none');
    } else {
        $('.delivery_boy_order_processed').addClass('d-none');
    }
    if (sort_type_val == 'delivery_boy_return_order_assign' && sort_type_val != ' ') {
        $('.delivery_boy_return_order_assign').removeClass('d-none');
    } else {
        $('.delivery_boy_return_order_assign').addClass('d-none');
    }
    if (sort_type_val == 'settle_cashback_discount' && sort_type_val != ' ') {
        $('.settle_cashback_discount').removeClass('d-none');
    } else {
        $('.settle_cashback_discount').addClass('d-none');
    }
    if (sort_type_val == 'settle_seller_commission' && sort_type_val != ' ') {
        $('.settle_seller_commission').removeClass('d-none');
    } else {
        $('.settle_seller_commission').addClass('d-none');
    }
    if (sort_type_val == 'customer_order_received' && sort_type_val != ' ') {
        $('.customer_order_received').removeClass('d-none');
    } else {
        $('.customer_order_received').addClass('d-none');
    }
    if (sort_type_val == 'customer_order_processed' && sort_type_val != ' ') {
        $('.customer_order_processed').removeClass('d-none');
    } else {
        $('.customer_order_processed').addClass('d-none');
    }
    if (sort_type_val == 'customer_order_shipped' && sort_type_val != ' ') {
        $('.customer_order_shipped').removeClass('d-none');
    } else {
        $('.customer_order_shipped').addClass('d-none');
    }
    if (sort_type_val == 'customer_order_delivered' && sort_type_val != ' ') {
        $('.customer_order_delivered').removeClass('d-none');
    } else {
        $('.customer_order_delivered').addClass('d-none');
    }
    if (sort_type_val == 'customer_order_cancelled' && sort_type_val != ' ') {
        $('.customer_order_cancelled').removeClass('d-none');
    } else {
        $('.customer_order_cancelled').addClass('d-none');
    }
    if (sort_type_val == 'customer_order_returned' && sort_type_val != ' ') {
        $('.customer_order_returned').removeClass('d-none');
    } else {
        $('.customer_order_returned').addClass('d-none');
    }
    if (sort_type_val == 'customer_order_returned_request_approved' && sort_type_val != ' ') {
        $('.customer_order_returned_request_approved').removeClass('d-none');
    } else {
        $('.customer_order_returned_request_approved').addClass('d-none');
    }
    if (sort_type_val == 'customer_order_returned_request_decline' && sort_type_val != ' ') {
        $('.customer_order_returned_request_decline').removeClass('d-none');
    } else {
        $('.customer_order_returned_request_decline').addClass('d-none');
    }
    if (sort_type_val == 'delivery_boy_order_deliver' && sort_type_val != ' ') {
        $('.delivery_boy_order_deliver').removeClass('d-none');
    } else {
        $('.delivery_boy_order_deliver').addClass('d-none');
    }
    if (sort_type_val == 'wallet_transaction' && sort_type_val != ' ') {
        $('.wallet_transaction').removeClass('d-none');
    } else {
        $('.wallet_transaction').addClass('d-none');
    }
    if (sort_type_val == 'ticket_status' && sort_type_val != ' ') {
        $('.ticket_status').removeClass('d-none');
    } else {
        $('.ticket_status').addClass('d-none');
    }
    if (sort_type_val == 'ticket_message' && sort_type_val != ' ') {
        $('.ticket_message').removeClass('d-none');
    } else {
        $('.ticket_message').addClass('d-none');
    }
    if (sort_type_val == 'bank_transfer_receipt_status' && sort_type_val != ' ') {
        $('.bank_transfer_receipt_status').removeClass('d-none');
    } else {
        $('.bank_transfer_receipt_status').addClass('d-none');
    }
    if (sort_type_val == 'bank_transfer_proof' && sort_type_val != ' ') {
        $('.bank_transfer_proof').removeClass('d-none');
    } else {
        $('.bank_transfer_proof').addClass('d-none');
    }

});


// custom_notification_message
$(document).ready(function () {
    // Handle clicks on elements with class 'hashtag' or 'hashtag_input'
    $('.hashtag, .hashtag_input').on('click', function () {
        // Get the text content of the clicked hashtag
        var hashtagText = $(this).text().trim();

        // Get the textarea element
        var textarea = $('#text-box');

        // Get current content of textarea
        var currentText = textarea.val();

        // Get current cursor position
        var cursorPos = textarea[0].selectionStart;
        // Insert hashtag at cursor position
        var newText = currentText.substring(0, cursorPos) + hashtagText + currentText.substring(cursorPos);
        // Update textarea value
        textarea.val(newText);

        // Set cursor position after inserted text
        var newCursorPos = cursorPos + hashtagText.length;
        textarea[0].setSelectionRange(newCursorPos, newCursorPos);

        // Trigger autosize update if using autosize plugin
        if (textarea.data('bs-toggle') === 'autosize') {
            textarea.trigger('input');
        }

        // Focus the textarea
        textarea.focus();

    });
});

$(document).on('click', '.addCustomNessageBtn', function (e) {
    e.preventDefault();

    $('.offcanvas-title').text('Add Custom Notification');
    $('.save_custom_notification').text('Add Custom Notification');

    $('#edit_custom_notification').val();
    $('#update_id').val();
    $('#update_title').val('');
    $('#text-box').val('');
    $('#type').val(' ').trigger('change');

})

$('#custom_notification_table').on('click-cell.bs.table', function (field, value, row, $el) {

    $('.offcanvas-title').text('Update Custom Notification');
    $('.save_custom_notification').text('Update Custom Notification');

    // Set the hidden input for edit mode
    $('#edit_custom_notification').val($el.id);
    $('#update_id').val(1); // Assuming you want to set update_id to 1 for edit mode

    // Set the title
    $('#udt_title').val($el.title);
    $('#update_title').val($el.title);

    // Set the message in the textarea
    $('#text-box').val($el.message);

    // Set and convert type if needed
    let convertedType = $el.type.toLowerCase().replace(/\s+/g, '_');
    $('#type').val(convertedType).trigger('change');

    // $('.mb-3.row').addClass('d-none'); // Hide all conditional divs
    $(`.mb-3.row.${$el.type}`).removeClass('d-none'); // Show the relevant div

    var type = $el.type;
    if (type) {
        $('.' + type).removeClass('d-none');
    }

    $(".hashtag").click(function () {
        var data = $("textarea#text-box").text();
        var tab = $.trim($(this).text());
        var message = data + tab;
        $('textarea#text-box').val(message);
    });
    $(".hashtag_input").click(function () {
        var data = $("#udt_title").val();
        var tab = $.trim($(this).text());
        var message = data + tab;
        $('input#update_title').val(message);
    });



})
function payment_request_queryParams(p) {
    return {
        user_filter: $('#user_filter').val(),
        status_filter: $('#status_filter').val(),
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}
// Initialize Bootstrap Table
$('#payment_request_table').bootstrapTable({
    url: base_url + 'admin/payment-request/view-payment-request-list',
    queryParams: payment_request_queryParams, // 👈 this passes user_filter to URL
    pagination: true,
    search: true,
    sidePagination: 'server',
    sortName: 'id',
    sortOrder: 'desc'
});

// When user filter changes, reload table
$('#user_filter').on('change', function () {
    $('#payment_request_table').bootstrapTable('refresh');
});

// --- Payment Request Row Click ---
$("#payment_request_table").on("click-cell.bs.table", function (field, value, row, $el) {

    $('input[name="payment_request_id"]').val($el.id);
    $('input[name="payment_type"]').val($el.payment_type);
    $('#update_remarks').html($el.remarks);

    if ($el.status_digit == 0) {
        $('.pending').prop('checked', true);
    } else if ($el.status_digit == 1) {
        $('.approved').prop('checked', true);
    } else if ($el.status_digit == 2) {
        $('.rejected').prop('checked', true);
    }
});


//bonus_type
$(document).on('change', '.bonus_type', function (e, data) {
    e.preventDefault();
    var sort_type_val = $(this).val();
    if (sort_type_val == 'fixed_amount_per_order_item' && sort_type_val != ' ') {
        $('.fixed_amount_per_order').removeClass('d-none');
    } else {
        $('.fixed_amount_per_order').addClass('d-none');
    }
    if (sort_type_val == 'percentage_per_order_item' && sort_type_val != ' ') {
        $('.percentage_per_order').removeClass('d-none');
    } else {
        $('.percentage_per_order').addClass('d-none');
    }
});

//16.Fund-Transder-Module
$("#delivery_boy_data").on("click-cell.bs.table", function (field, value, row, $el) {




    var fund_transfer_balance = $el.balance_main;
    var fund_transfer_balance = fund_transfer_balance.replace(',', '');

    console.log($el);



    $('#fund_transfer_name').val($el.name);
    $('#fund_transfer_mobile').val($el.mobile);
    $('#balance').val(fund_transfer_balance);
    $('#fund_transfer_delivery_boy_id').val($el.id);

    $('.offcanvas-title').text('Update Delivery Boy');
    $('.save_delivery_boy').text('Update Delivery Boy');


    $('.edit_delivery_boy').val($el.id);
    $('#name').val($el.name);
    $('#mobile').val($el.mobile);
    $('#email').val($el.email);
    $('#address').val($el.address);
    $('.password_field').addClass('d-none');
    $('.confirm_password_field').addClass('d-none');

    // Bonus type
    $('#bonus_type').val($el.bonus_type_main).trigger('change');

    if ($el.bonus_type_main === 'fixed_amount_per_order_item') {
        $('.fixed_amount_per_order').removeClass('d-none');
        $('.percentage_per_order').addClass('d-none');
        $('#bonus_amount').val($el.bonus_amount);
    } else if ($el.bonus_type_main === 'percentage_per_order_item') {
        $('.percentage_per_order').removeClass('d-none');
        $('.fixed_amount_per_order').addClass('d-none');
        $('#bonus_percentage').val($el.bonus_amount);
    }

    // Status
    $("input[name='status'][value='" + $el.status_main + "']").prop('checked', true);

    $('#driving_license_preview').empty();
    // Show the license image if exists
    if ($el.driving_license) {
        var images = $el.driving_license.split(',');
        images.forEach(function (img) {
            var fullPath = base_url + img.trim();

            $('#driving_license_preview').append(
                `<img src="${fullPath}" class="img-fluid m-1" style="max-height: 120px;">`
            );
        });
    } else {
        $('#driving_license_preview').html('');
    }


});


$('.addDeliveryBoyBtn').on('click', function () {

    $('.offcanvas-title').text('Add Delivery Boy');
    $('.save_delivery_boy').text('Add Delivery Boy');

    //     // Clear fields that aren't reset by .reset()
    $('.edit_delivery_boy').val('');
    $('#name').val('');
    $('#email').val('');
    $('#mobile').val('');
    $('#address').val('');
    $('.password_field').removeClass('d-none');
    $('.confirm_password_field').removeClass('d-none');
    $('#bonus_type').val('').trigger('change');
    $('#driving_license_preview').empty();
    $("input[name='status']").prop('checked', false);
    $('.fixed_amount_per_order, .percentage_per_order').addClass('d-none');

});

$(document).on('click', '.edit_cash_collection_btn', function () {
    var id = $(this).data('id');
    var order_id = $(this).data('order-id');
    var amount = $(this).data('amount');
    var dboy_id = $(this).data('dboy-id');

    $('#details').val("Id: " + id + " | order id:" + order_id + " | Amount: " + amount + " | Cash: " + amount);
    $('#transaction_id').val(id);
    $('#order_id').val(order_id);
    $('#amount').val(amount);
    $('#order_amount').val(amount);
    $('#delivery_boy_id').val(dboy_id);

});

$(document).on('click', '[data-bs-target="#manageCustomerWallet"]', function (e) {
    e.preventDefault();
    var customerId = $(this).data('id');

    // Find the customer data from the table
    var customers = $('#customers').bootstrapTable('getData');
    var customer = customers.find(function (item) {
        return item.id == customerId;
    });

    if (customer) {
        $('#customer_dtls').val(customer.name + " | " + customer.email);
        $('#user_id').val(customer.id);
        $('#amount').val('');
        $('#message').val('');
        $('#type').val('credit');
    }
});

// Clear form and prepare offcanvas when hidden
var manageCustomerWalletEl = document.getElementById('manageCustomerWallet');
if (manageCustomerWalletEl) {
    manageCustomerWalletEl.addEventListener('hidden.bs.offcanvas', function () {
        // Clear form
        $('#update_customer_wallet_form')[0].reset();
        $('#customer_dtls').val('');
        $('#user_id').val('');
        $('#amount').val('');
        $('#message').val('');
        $('#type').val('credit');
    });
}

$('#customers').on('click-cell.bs.table', function (field, value, row, $el) {
    $('#customer_dtls').val($el.name + " | " + $el.email);
    $('#user_id').val($el.id);
    $('#amount').val('');
    $('#message').val('');
});

// pickup location
$("#pickup_location_table").on("click-cell.bs.table", function (field, value, row, $el) {

    $('#edit_pickup_location').val($el.id);
    $('#seller_id').val($el.seller_id);
    $('#pickup_location_name').val($el.pickup_location);
    $('#name').val($el.name);
    $('#email').val($el.email);
    $('#phone').val($el.phone);
    $('#city').val($el.city);
    $('#state').val($el.state);
    $('#country').val($el.country);
    $('#pincode').val($el.pin_code);
    $('#address').val($el.address);
    $('#address2').val($el.address2);
    $('#latitude').val($el.latitude);
    $('#longitude').val($el.longitude);
});

// City
$('#cities_table').on('click-cell.bs.table', function (field, value, row, $el) {
    $('.offcanvas-title').text('Update City');
    $('.save_city_btn').text('Update City');
    $('#edit_city').val($el.id);
    $('#city_name').val($el.name);
    $('#city_name').prop('disabled', true);
    $('#city_name_hidden').val($el.name);
    $('#minimum_free_delivery_order_amount').val($el.minimum_free_delivery_order_amount);
    $('#delivery_charges').val($el.delivery_charges);
    $('.reset_city_btn').addClass('d-none');

});

$('.AddCityBtn').on('click', function () {

    $('.offcanvas-title').text('Add City');
    $('.save_city_btn').text('Add City');
    $('.reset_city_btn').removeClass('d-none');

    // Clear fields that aren't reset by .reset()
    $('#edit_city').val('');
    $('#city_name').val('');
    $('#city_name').prop('disabled', false);

    $('#city_name_hidden').val('');
    $('#minimum_free_delivery_order_amount').val('');
    $('#delivery_charges').val('');
});

// Zipcode
$('#zipcode-table').on('click-cell.bs.table', function (field, value, row, $el) {

    $('.offcanvas-title').text('Update Zipcode');
    $('.save_zipcode_btn').text('Update Zipcode');

    $('#edit_zipcode').val($el.id);
    $('#zipcode').val($el.zipcode);
    $('#minimum_free_delivery_order_amount').val($el.minimum_free_delivery_order_amount);
    $('#delivery_charges').val($el.delivery_charges);

});

$('.AddZipcodeBtn').on('click', function () {

    $('.offcanvas-title').text('Add Zipcode');
    $('.save_zipcode_btn').text('Add Zipcode');

    // Clear fields that aren't reset by .reset()
    $('#edit_zipcode').val('');
    $('#zipcode').val('');

    $('#minimum_free_delivery_order_amount').val('');
    $('#delivery_charges').val('');
});
$('.SendNotification').on('click', function () {
    $('#send_notification_form')[0].reset();
    $('.image-upload-section').addClass('d-none');

});

$('#location_bulk_upload_form').on('submit', function (e) {
    e.preventDefault();
    var type = $('#type').val();
    var location_type = $('#location_type').val();
    if (type != '' && location_type != "" && type != "undefined" && location_type != "undefined") {
        var formdata = new FormData(this);
        formdata.append(csrfName, csrfHash);
        $.ajax({
            type: 'POST',
            data: formdata,
            url: $(this).attr('action'),
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('#submit_btn').html('Please Wait...').attr('disabled', true);
            },
            success: function (result) {
                csrfName = result.csrfName;
                csrfHash = result.csrfHash;
                if (result.error == false) {
                    $('#upload_result').show().removeClass('msg_error').addClass('msg_success').html(result.message).delay(3000).fadeOut();
                } else {
                    $('#upload_result').show().removeClass('msg_success').addClass('msg_error').html(result.message).delay(3000).fadeOut();
                }
                $('#submit_btn').html('Submit').attr('disabled', false);
            }
        });
    } else {
        showToast('Please select Type and Location Type', 'error');
    }

});

//17.Return-Request-Module
$("#return_request_table").on("click-cell.bs.table", function (field, value, row, $el) {


    $('input[name="return_request_id"]').val($el.id);
    $('input[name="user_id"]').val($el.user_id);
    $('input[name="order_item_id"]').val($el.order_item_id);
    $('#user_id').val($el.user_id);
    $('#order_item_id').val($el.order_item_id);
    $('#seller_id').val($el.seller_id);
    $('#update_remarks').html($el.remarks);


    // Set the selected delivery boy based on $el.delivery_boy_id
    $('#delivery_boy_id').val($el.delivery_boy_id);

    // Set the selected status in the dropdown
    $('#status').val($el.status_digit);

    // Show/hide delivery boy section based on status
    if ($el.status_digit == 1 || $el.status_digit == 8) {
        $('#return_request_delivery_by').removeClass('d-none');
    } else {
        $('#return_request_delivery_by').addClass('d-none');
    }
});

$('#status').change(function () {
    var status = $(this).val();
    if (status == 1 || status == 8) {
        $('#return_request_delivery_by').removeClass('d-none');
    } else {
        $('#return_request_delivery_by').addClass('d-none');
    }
});

$(document).on('click', '.edit_return_request', function () {
    var order_item_id = $(this).data('id');

    $.ajax({
        type: 'GET',
        url: base_url + 'admin/return-request/get_seller_id/' + order_item_id,
        dataType: 'json',

        success: function (result) {

            csrfName = result['csrfName'];
            csrfHash = result['csrfHash'];
            var delivery_boy_id = $('#delivery_boy_id').val();

            // Append new options from the result data
            $.each(result.data, function (index, deliveryBoy) {
                var option = $('<option></option>')
                    .attr('value', deliveryBoy.id)
                    .text(deliveryBoy.name);

                // Set selected if the delivery boy matches the delivery_boy_id
                if (deliveryBoy.id == delivery_boy_id) {
                    option.attr('selected', 'selected');
                }

                $('#deliver_by').append(option);
            });

        }
    });
});

$("#return_reason_table").on("click-cell.bs.table", function (field, value, row, $el) {

    $('.offcanvas-title').text('Update Retrun Reason');
    $('.save_return_reason').text('Update Return Reason');

    $('#edit_return_reason_id').val($el.id);
    $('#return_reason').val($el.return_reason);
    $('#message').val($el.message);

    $('#uploaded_image_here_val').val($el.image_url);

    $('.image-upload-section').removeClass('d-none');

    $('#uploaded_image_here').attr('src', base_url + $el.image_url);


});

$(document).on('click', '.AddReturnReasonBtn', function (e) {
    $('.offcanvas-title').text('Add Return Reason');
    $('.save_return_reason').text('Add Return Reason');
    $('.edit_promo_upload_image_note').text('');
    $('.reset_return_reason').trigger('click');
    $('#return_reason').val('');
    $('#uploaded_image_here_val').val('');
    $('.image-upload-section').addClass('d-none');

    $('#uploaded_image_here').attr('src', base_url + 'assets/no-image.png');
});


// features section module 
$(document).on('change', '.product_type', function () {
    var product_type = $('.product_type').val();
    var exclude_product_type = ["custom_products"];
    if (exclude_product_type.includes(product_type)) {
        $(".select-categories").hide();
    } else {
        $(".select-categories").show();
    }
});

$(document).on('change', '.product_type', function (e, data) {
    e.preventDefault();
    var sort_type_val = $(this).val();
    if (sort_type_val == 'custom_products' && sort_type_val != ' ') {
        $('.custom_products').removeClass('d-none');
    } else {
        $('.custom_products').addClass('d-none');
    }
    if (sort_type_val == 'digital_product' && sort_type_val != ' ') {
        $('.digital_products').removeClass('d-none');
    } else {
        $('.digital_products').addClass('d-none');
    }
});

if ($('#seo_meta_keywords').length) {
    var tags_element = document.querySelector('input[name=seo_meta_keywords]');
    new Tagify(tags_element);
}
if ($('#tags').length) {
    var tags_element = document.querySelector('input[name=tags]');
    new Tagify(tags_element);
}

function featured_section_query_params(p) {
    return {
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search,
        product_type: $('#product_type_filter').val()
    };
}

$(document).on('change', '#product_type_filter', function () {
    $('#feature_section_table').bootstrapTable('refresh');
});

$("#feature_section_table").on("click-cell.bs.table", function (field, value, row, $el) {

    $('.offcanvas-title').text('Edit Feature Section');
    $('.save_feature_section').text('Update Feature Section');

    $('#edit_featured_section').val($el.id);
    $('#title').val($el.title);
    $('#short_description').val($el.short_description);
    $('.image-upload-section').removeClass('d-none');


    // Style
    let normalizedStyle = $el.style.toLowerCase().replace(/\s+/g, '_'); // "Style 4" => "style_4"
    $('#style').val(normalizedStyle).trigger('change');

    // Product Type
    let normalizedProductType = $el.product_type.toLowerCase().replace(/\s+/g, '_'); // "Products On Sale" => "products_on_sale"
    $('#product_type').val(normalizedProductType).trigger('change');


    $('#uploaded_image_here_val').val($el.image_url);


    $('#uploaded_image_here').attr('src', base_url + $el.image_url);

    // Set SEO fields
    $('#seo_page_title').val($el.seo_page_title);
    $('textarea[name="seo_meta_description"]').val($el.seo_meta_description);
    $('#seo_meta_keywords').val($el.seo_meta_keywords);

    // Clear and set SEO OG Image
    $('.image-upload-section').empty();
    if ($el.seo_og_image && $el.seo_og_image !== '') {
        var imageHtml = '<div class="col-6 col-md-4 col-lg-3">' +
            '<div class="card shadow-sm h-100">' +
            '<div class="card-img-top position-relative" style="padding-top: 100%; overflow: hidden;">' +
            '<img src="' + base_url + $el.seo_og_image + '" alt="SEO OG Image" class="position-absolute top-0 start-0 w-100 h-100" style="object-fit: cover;">' +
            '<div class="position-absolute top-0 start-0 p-2">' +
            '<span class="badge bg-dark-lt"><i class="ti ti-photo"></i> <span class="image-number">1</span></span>' +
            '</div>' +
            '<div class="position-absolute top-0 end-0 p-2">' +
            '<a href="javascript:void(0)" class="remove-image btn btn-danger btn-sm btn-icon p-1" title="Remove image">' +
            '<i class="ti ti-trash"></i></a>' +
            '</div>' +
            '</div>' +
            '<input type="hidden" name="seo_og_image" value="' + $el.seo_og_image + '">' +
            '</div>' +
            '</div>';
        $('.image-upload-section').html(imageHtml);
    } else {
        $('.image-upload-section').empty();
    }


});

$(document).on('click', '.addFeatureSectionBtn', function (e) {

    $('.offcanvas-title').text('Add Feature Section');
    $('.save_feature_section').text('Add Feature Section');

    $('#edit_featured_section').val('');
    $('#title').val('');
    $('#short_description').val('');


    // Style
    $('#style').val(' ').trigger('change');

    // Product Type
    $('#product_type').val(' ').trigger('change');
    $('#uploaded_image_here_val').val('');

    $('.image-upload-section').addClass('d-none');

    // Clear and reset SEO fields
    $('#seo_page_title').val('');
    $('textarea[name="seo_meta_description"]').val('');
    $('#seo_meta_keywords').val('');

    // Clear SEO OG Image section completely
    $('.image-upload-section').empty();

});

$('#addFeatureSection').on('hidden.bs.offcanvas', function () {
    $('#add_feature_section_form')[0].reset();

    // Reset SEO fields explicitly
    $('#seo_page_title').val('');
    $('textarea[name="seo_meta_description"]').val('');
    $('#seo_meta_keywords').val('');

    // Clear SEO OG Image section completely
    $('.image-upload-section').empty();

    // Reset other fields
    $('#edit_featured_section').val('');
    $('#title').val('');
    $('#short_description').val('');
    $('#style').val(' ');
    $('#product_type').val(' ');

    // Hide image upload section
    $('.image-upload-section').addClass('d-none');
});


// for feature section order 
$('#sortable').sortable({
    axis: 'y',
    opacity: 0.6,
    cursor: 'move',
    placeholder: 'sortable-placeholder',

    start: function (event, ui) {
        ui.item.addClass('sorting-active');
    },

    stop: function (event, ui) {
        ui.item.removeClass('sorting-active');
    }
});

$(document).on('click', '#save_section_order', function (e) {
    e.preventDefault();
    let data = $('#sortable').sortable('serialize'); // string like "section_id[]=1&section_id[]=2"

    if (!data) {
        showToast("No sections to save!", 'error');
        return;
    }

    axios.get(base_url + 'admin/featured_sections/update_section_order?' + data)
        .then(function (response) {
            let res = response.data;
            if (res.error === false) {
                showToast(res.message, 'success');
                setTimeout(() => {
                    location.reload();
                }, 1500);
            } else {
                showToast(res.message, 'error');
            }
        })
        .catch(function (error) {
            showToast("Something went wrong!", 'error');
            console.error(error);
        });
});

$(document).on('click', '#save_category_order', function (e) {
    e.preventDefault();
    let data = $('#sortable').sortable('serialize'); // string like "category_id[]=1&category_id[]=2"

    if (!data) {
        showToast("No categories to save!", 'error');
        return;
    }

    axios.get(base_url + 'admin/category/update_category_order?' + data)
        .then(function (response) {
            let res = response.data;
            if (res.error === false) {
                showToast(res.message, 'success');
                setTimeout(() => {
                    location.reload();
                }, 1500);
            } else {
                showToast(res.message, 'error');
            }
        })
        .catch(function (error) {
            showToast("Something went wrong!", 'error');
            console.error(error);
        });
});



// For blog category
$(document).on('change', '#category_parent', function () {
    $('#category_table').bootstrapTable('refresh');
    $('#blogs_table').bootstrapTable('refresh');
});

$('#blog_category_table').on('click-cell.bs.table', function (field, value, row, $el) {

    $('.offcanvas-title').text('Update Blog Category');
    $('.save_blog_category').text('Update Blog Category');
    $('#edit_category').val($el.id);
    $('#category_input_name').val($el.main_name);
    if ($el.image_url) {
        $('#slider_uploaded_image').val($el.image_url);
        $('#slider_uploaded_image').attr('src', $el.image_url);
    }
    $('.image-upload-section').removeClass('d-none');
    $('.image-upload-section').val($el.image);
});

$('.addBlogCategoryBtn').on('click', function () {

    $('.offcanvas-title').text('Add Blog Category');
    $('.save_blog_category').text('Add Blog Category');

    $('#edit_category').val('');
    $('#category_input_name').val('');
    $('#slider_uploaded_image').attr('src', base_url + 'assets/no-image.png');
    $('.image-upload-section').addClass('d-none');
});


$('#blogs_table').on('click-cell.bs.table', function (field, value, row, $el) {

    // console.log($el.description_main);
    $('.offcanvas-title').text('Update Blog');
    $('.save_blog_btn').text('Update Blog');

    $('#edit_blog').val($el.id);
    $('#blog_title').val($el.title);
    $('#blog_uploaded_image').attr('src', base_url + $el.image_main_url);
    $('#uploaded_blog_uploaded_image').val($el.image_main_url);
    $('#addBlog .image-upload-section').removeClass('d-none');

    let textareaId = 'blog_description';
    if (hugeRTE.get(textareaId)) {

        hugeRTE.get(textareaId).setContent($el.description_main || '');
    } else {
        $('#' + textareaId).val($el.description_main || '');
    }

});

$('.addBlogBtn').on('click', function () {
    $('.offcanvas-title').text('Add blog');
    $('.save_blog_btn').text('Add blog');

    $('#edit_blog').val('');
    $('#blog_title').val('');
    $('#blog').val('');
    $('#blog_uploaded_image').attr('src', base_url + 'assets/no-image.png');
    $('#uploaded_blog_uploaded_image').val('');

    // Hide the "Only Choose When Update is necessary" label when adding new blog
    $('#addBlog .edit_promo_upload_image_note').hide();

    let textareaId = 'blog_description';

    $('#' + textareaId).val($el.description_main || '');


    // Reset the Select2 dropdown
    $('#blog_category').val(null).trigger('change');

});


// Brands 
$('#brand_table').on('click-cell.bs.table', function (field, value, row, $el) {
    // console.log($el.image_main_url);
    $('.offcanvas-title').text('Update Brand');
    $('.save_brand_btn').text('Update Brand');

    $('.image-upload-section').removeClass('d-none');
    $('#edit_brand').val($el.id);
    $('#brand_input_name').val($el.name);

    if ($el.image_main_url == '') {

        $('#brand_uploaded_image').attr('src', base_url + 'assets/no-image.png');
    } else {
        $('#brand_uploaded_image').attr('src', $el.image_main_url);
    }

});

$('.addBrandBtn').on('click', function () {

    $('.offcanvas-title').text('Add Brand');
    $('.save_brand_btn').text('Add Brand');

    $('#edit_brand').val('');
    $('#brand_input_name').val('');
    $('#brand_uploaded_image').attr('src', base_url + 'assets/no-image.png');
    $('.image-upload-section').addClass('d-none');
});

//add /edit time sloate offcanvas handeler
$(document).on('click', '.edit-time-slot', function () {
    const id = $(this).data('id');

    $('#offcanvasTitle').text('Update Time Slot');
    $('#submitText').text('Update Time Slot');
    $('#update_time_slots_form')[0].reset();

    $('#edit_time_slot').val(id);
    $('#add_time_slot').val('');

    $.ajax({
        url: base_url + 'admin/Time_slots/get_time_slot_details',
        type: 'GET',
        data: { id: id },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                const data = response.data;
                $('#title').val(data.title);
                $('#from_time').val(data.from_time);
                $('#to_time').val(data.to_time);
                $('#last_order_time').val(data.last_order_time);
                $('#status').val(data.status);

                const offcanvasEl = document.getElementById('addEditTimeSlot');
                const bsOffcanvas = new bootstrap.Offcanvas(offcanvasEl);
                bsOffcanvas.show();
            } else {
                alert(response.message || 'Error loading time slot details.');
            }
        },
        error: function () {
            alert('Error while loading time slot details.');
        }
    });
});

var input = document.querySelector('#seo_meta_description');



// When user clicks "Add Time Slot" button (using class selector)
$(document).on('click', '.add-slot-btn', function () {
    $('#offcanvasTitle').text('Add Time Slot');
    $('.save_time_sloate_btn').text('Add Time Slot');
    $('#edit_time_slot').val('');
    $('#add_time_slot').val('1');
    $('#update_time_slots_form')[0].reset();
});

// Reset form when offcanvas is hidden
$('#addEditTimeSlot').on('hidden.bs.offcanvas', function () {
    $('#update_time_slots_form')[0].reset();
    $('#edit_time_slot').val('');
    $('#add_time_slot').val('1');
    $('#offcanvasTitle').text('Add Time Slot');
    $('.save_time_sloate_btn').text('Add Time Slot');
});


$(document).ready(function () {

    // When "From Time" changes
    $('#from_time').on('change', function () {
        const fromTime = $(this).val();

        if (fromTime) {
            // Set the minimum selectable time for "To Time"
            $('#to_time').attr('min', fromTime);

            // Also set the minimum selectable time for "Last Order Time"
            $('#last_order_time').attr('min', fromTime);
        } else {
            $('#to_time').removeAttr('min');
            $('#last_order_time').removeAttr('min');
        }
    });

    // When "To Time" changes
    $('#to_time').on('change', function () {
        const toTime = $(this).val();

        if (toTime) {
            // Set maximum allowed time for "Last Order Time"
            $('#last_order_time').attr('max', toTime);
        } else {
            $('#last_order_time').removeAttr('max');
        }
    });
});


// Product FAQs 
$('#products_faqs_table').on('click-cell.bs.table', function (field, value, row, $el) {


    $('.offcanvas-title').text('Update Product FAQ');
    $('.save_product_faq_btn').text('Update Product FAQ');

    $('.ProductSelect').addClass('d-none');
    $('#question').val($el.question);
    $('#question').prop('disabled', true);
    $('#answer').val($el.answer);
    $('#edit_product_faq').val($el.id);
    $('#hidden_question').val($el.question);
    $('#seller_id').val(0);

    // $('#seller_id').val($el.user_id);

});


$('.AddProductFAQBtn').on('click', function () {


    $('.offcanvas-title').text('Add Product FAQ');
    $('.save_product_faq_btn').text('Add Product FAQ');

    $('.ProductSelect').removeClass('d-none');
    $('#question').prop('disabled', false);
    $('#question').val('');
    $('#hidden_question').val('');
    $('#seller_id').val('');
    $('#answer').val('');
    $('#edit_product_faq').val('');
    $('#product_id').val('');
});

// Attribute set
$('#attribute_sets_table').on('click-cell.bs.table', function (field, value, row, $el) {

    $('.offcanvas-title').text('Update Attribute Set');
    $('.save_attribute_set_btn').text('Update Attribute Set');

    $('#edit_attribute_set').val($el.id);
    $('#name').val($el.name);

});

$('.addAttributeSetBtn').on('click', function () {

    $('.offcanvas-title').text('Add Attribute Set');
    $('.save_attribute_set_btn').text('Add Attribute Set');
    $('#edit_attribute_set').val('');
    $('#name').val('');
});


// Attributes
// Attribute Value Repeater Functionality
$(document).on('click', '#add_attribute_value', function (e) {
    e.preventDefault();
    load_attribute_section();
});

$(document).on('change', '.swatche_type', function () {
    if ($(this).val() == '1') {
        $(this).siblings('.color_picker').show();
        $(this).siblings('.upload_media').hide();
        $(this).siblings('.grow').hide();
    }
    if ($(this).val() == "2") {
        $(this).siblings(".color_picker").hide();
        $(this).siblings(".color_picker").attr('name', null);
        $(this).siblings(".upload_media").show();
        $(this).siblings(".grow").show();
    }
    if ($(this).val() == "0") {
        $(".color_picker").hide();
        $(".upload_media").hide();
        $('.grow').hide();
    }
});

function load_attribute_section() {
    var html =
        '<div class="align-items-center d-flex form-group gap-3 justify-content-between mb-3">' +
        '<div class="col-md-4">' +
        '<input type="text" step="any" class="form-control" placeholder="Enter Attribute Value" name="attribute_value[]">' +
        '</div>' +
        '<div class="col-md-4">' +
        '<select class="form-select swatche_type" name="swatche_type[]">' +
        '<option value="0">Default</option>' +
        '<option value="1">Color</option>' +
        '<option value="2">Image</option>' +
        '</select>' +
        '<input type="color" class="form-control color_picker mt-2" id="swatche_value" name="swatche_value[]" style="display: none;">' +
        '<a style="display: none;" class="btn btn-primary btn-sm upload_media mt-2" data-input="swatche_value[]" name="attribute_img[]" data-isremovable="0" data-is-multiple-uploads-allowed="0" data-bs-toggle="modal" data-bs-target="#media-upload-modal" value="Upload Photo"><i class="ti ti-upload"></i> Upload</a>' +
        '</div>' +
        '<div class="">' +
        '<button type="button" class="btn btn-danger btn-sm remove_attribute_section">' +
        '<i class="ti ti-trash"></i>' +
        '</button>' +
        '</div>' +
        '<div class="container-fluid image-upload-section">' +
        '<div style="display: none;" class="shadow rounded text-center grow">' +
        '<div class="image-upload-div"><img class="img-fluid mb-2 image" src="" alt="Image Not Found"></div>' +
        '<input type="hidden" value="">' +
        '</div>' +
        '</div>' +
        '</div>';

    $('#attribute_section').append(html);

    // Initialize Tom Select for the newly added swatch type dropdown
    const lastSwatchSelect = $('#attribute_section').find('.swatche_type').last()[0];
    if (lastSwatchSelect) {
        new TomSelect(lastSwatchSelect, {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            }
        });
    }
}

$(document).on('click', '.remove_attribute_section', function () {
    $(this).closest('.form-group').remove();
});

// Reset attribute section when offcanvas is closed
$('#addAttribute').on('hidden.bs.offcanvas', function () {
    // Clear all dynamically added attribute value fields
    $('#attribute_section').empty();

    // Reset form fields
    $('#edit_attribute').val('');
    $('#name').val('');

    // Reset attribute set select if it exists
    const attributeSetSelect = $('#attributeSetSelect')[0];
    if (attributeSetSelect && attributeSetSelect.tomselect) {
        attributeSetSelect.tomselect.clear();
    }
});

$('.addAttributeBtn').on('click', function () {

    $('#edit_attribute').val('');
    $('#attribute_set').val('');
    $('#swatche_type').val(0);

    $('#swatche_color').hide();
    $('#swatche_image').hide();
    $(document.body).on('change', '.swatche_type', function (e) {
        e.preventDefault();
        var swatche_type = $(this).val();
        if (swatche_type == "1") {
            $('#swatche_image').hide();
            $('#swatche_color').show();
            $('#swatche_image').val('');
        } else if (swatche_type == "2") {
            $('#swatche_color').hide();
            $('#swatche_image').show();
            $('#swatche_color').val('');
        } else {
            $('#swatche_color').hide();
            $('#swatche_image').hide();
            $('#swatche_color').val('');
            $('#swatche_image').val('');
        }
    });


    $('.offcanvas-title').text('Add Attribute');
    $('.save_attribute_value_btn').text('Add Attribute');

    $('#edit_brand').val('');
    $('#brand_input_name').val('');
    $('#brand_uploaded_image').attr('src', base_url + 'assets/no-image.png');
});



// Attribute values  
$('#attribute_values_table').on('click-cell.bs.table', function (field, value, row, $el) {
    $('.offcanvas-title').text('Update Attribute Value');
    $('.save_attribute_value_btn').text('Update Attribute Value');

    $('#edit_attribute_value').val($el.id);
    $('#value').val($el.name);

    $('#swatche_type option').each(function () {
        if ($(this).val() === $el.swatche_type) {
            $(this).prop('selected', true);
        }
    });
    if ($el.swatche_type == "1") {
        $('#swatche_image').hide();
        $('#swatche_color').show();
        $('#swatche_image').val('');
    } else if ($el.swatche_type == "2") {
        $('#swatche_color').hide();
        $('#swatche_image').show();
        $('#swatche_color').val($el.swatche_value);
    } else {
        $('#swatche_color').hide();
        $('#swatche_image').hide();
        $('#swatche_color').val('');
        $('#swatche_image').val('');
    }

    $('#attribute_uploaded_image').attr('src', $el.image_main_url);
});

$('.addAttributeValueBtn').on('click', function () {

    $('#edit_attribute_value').val('');
    $('#value').val('');
    $('#swatche_type').val(0);

    $('#swatche_color').hide();
    $('#swatche_image').hide();
    $(document.body).on('change', '.swatche_type', function (e) {
        e.preventDefault();
        var swatche_type = $(this).val();
        if (swatche_type == "1") {
            $('#swatche_image').hide();
            $('#swatche_color').show();
            $('#swatche_image').val('');
        } else if (swatche_type == "2") {
            $('#swatche_color').hide();
            $('#swatche_image').show();
            $('#swatche_color').val('');
        } else {
            $('#swatche_color').hide();
            $('#swatche_image').hide();
            $('#swatche_color').val('');
            $('#swatche_image').val('');
        }
    });


    $('.offcanvas-title').text('Add Attribute Value');
    $('.save_attribute_value_btn').text('Add Attribute Value');

    $('#edit_brand').val('');
    $('#brand_input_name').val('');
    $('#brand_uploaded_image').attr('src', base_url + 'assets/no-image.png');
});

// Product Affiliate settings
$(document).on('click', '.open-affiliate-modal', function () {
    const id = $(this).data('id');
    const name = $(this).data('name');
    const isInAffiliate = $(this).data('is_in_affiliate');

    $('#modal_product_id').val(id);
    $('#modal_product_name').val(name);
    $('#modal_is_in_affiliate').val(isInAffiliate);
});


// Category
$('#category_table').on('click-cell.bs.table', function (field, value, row, $el) {

    $('.offcanvas-title').text('Update Category');
    $('.save_category_btn').text('Update Category');

    $('#edit_category').val($el.id);
    $('#category_input_name').val($el.name);
    $('#seo_page_title').val($el.seo_page_title);
    $('#seo_meta_description').val($el.seo_meta_description);
    $('#seo_meta_keywords').val($el.seo_meta_keywords);
    $('#uploaded_og_image_here').attr('src', base_url + $el.seo_og_image);

    $('#commission_perc').val($el.commission_perc);

    $('.image-upload-section').removeClass('d-none');

    if ($el.image_main_url == '') {

        $('#category_input_image_img').attr('src', base_url + 'assets/no-image.png');
    } else {
        $('#category_input_image_img').attr('src', base_url + $el.image_main_url);
    }

    $('#seo_og_image_hidden').val($el.seo_og_image);
    $('#category_input_image_hidden').val($el.image_main_url);


});


$('.addCategoryBtn').on('click', function () {

    $('.offcanvas-title').text('Add Category');
    $('.save_category_btn').text('Add Category');

    $('#edit_category').val('');
    $('#category_input_name').val('');
    $('#seo_page_title').val('');
    $('#seo_meta_description').val('');
    $('#seo_meta_keywords').val('');
    // $('#uploaded_og_image_here').attr('src', base_url);
    $('#category_input_image_img').attr('src', base_url + 'assets/no-image.png');
    $('.image-upload-section').addClass('d-none');

});

// When category status filter changes, reload table
$('#category_status_filter').on('change', function () {
    $('#category_table').bootstrapTable('refresh');
});

$(document).on('click', '#list_view', function () {
    $('#list_view_html').show();
    if ($('#list_view').hasClass('bg-primary-lt')) {
        $('#list_view').removeClass('bg-primary-lt');

        $('#tree_view').addClass('bg-primary-lt');
    }
    $('#tree_view_html').hide();
});

$(document).on('click', '#tree_view', function () {
    $('#tree_view_html').show();

    if ($('#tree_view').hasClass('bg-primary-lt')) {
        $('#tree_view').removeClass('bg-primary-lt');

        $('#list_view').addClass('bg-primary-lt');
    }
    $('#list_view_html').hide();

    // var category_url = base_url + '/admin/category/get_categories?from_select=1';
    var category_url = base_url + '/admin/category/get_categories';

    $.ajax({
        type: 'GET',
        url: category_url,
        dataType: 'json',
        success: function (result) {

            $('#tree_view_html').jstree({
                'core': {
                    'data': result
                },
            });
        }
    });
});

document.addEventListener('alpine:init', () => {
    Alpine.data('ajaxForm', (config) => ({
        ...config,

        init() {
            // Initialize TomSelect after the offcanvas is shown
            const offcanvas = document.getElementById(this.offcanvasId);
            if (offcanvas) {
                offcanvas.addEventListener('shown.bs.offcanvas', () => {
                    this.preventSelfSelection();
                });
            }
        },

        // Function to prevent selecting self as parent
        preventSelfSelection() {
            const categoryNameInput = document.querySelector('#category_input_name');
            const categorySelect = document.querySelector('#categorySelect');

            if (!categorySelect || !categoryNameInput) return;

            // When user types category name, re-check the options
            categoryNameInput.addEventListener('input', () => {
                const currentName = categoryNameInput.value.trim().toLowerCase();

                // Loop through options and disable matching one
                Array.from(categorySelect.options).forEach((opt) => {
                    if (opt.textContent.trim().toLowerCase() === currentName && currentName !== '') {
                        opt.disabled = true;
                    } else {
                        opt.disabled = false;
                    }
                });

                // If using TomSelect, refresh it dynamically
                if (categorySelect.tomselect) {
                    categorySelect.tomselect.sync();
                }
            });
        },
    }));
});


// Tax
$('#tax_table').on('click-cell.bs.table', function (field, value, row, $el) {

    $('.offcanvas-title').text('Update Tax');
    $('.save_tax_btn').text('Update Tax');

    $('#edit_tax_id').val($el.id);
    $('#title').val($el.title);
    $('#percentage').val($el.percentage);

});


$('.addTaxBtn').on('click', function () {

    $('.offcanvas-title').text('Add Tax');
    $('.save_tax_btn').text('Add Tax');

    $('#edit_tax_id').val('');
    $('#title').val('');
    $('#percentage').val('');

});

$('#ticket_type_table').on('click-cell.bs.table', function (field, value, row, $el) {

    $('.offcanvas-title').text('Update Ticket Type');
    $('.save_ticket_type_btn').text('Update Ticket Type');

    $('#type_for').val($el.user_type.toLowerCase()).trigger('change');

    $('#edit_ticket_type').val($el.id);
    $('#title').val($el.title);

});

$('.AddTicketTypeBtn').on('click', function () {

    $('.offcanvas-title').text('Add Ticket Type');
    $('.save_ticket_type_btn').text('Add Ticket Type');

    $('#edit_ticket_type').val('');
    $('#title').val('');
});


// 1. Promo Code Discount Settlement
$(document).on('click', '.add_promo_code_discount', function () {
    Notiflix.Confirm.show(
        'Are You Sure!',
        "You won't be able to revert this!",
        'Yes, settle Discounted!',
        'Cancel',
        function okCb() {
            Notiflix.Loading.standard('Processing...');

            $.ajax({
                url: base_url + 'admin/cron_job/settle_cashback_discount',
                type: 'GET',
                data: { is_date: true },
                dataType: 'json',
                success: function (response) {
                    Notiflix.Loading.remove();

                    if (response.error === false) {
                        showToast(response.message, "success");
                        $('table').bootstrapTable('refresh');
                    } else {
                        showToast(response.message, "error");
                    }
                },
                error: function () {
                    Notiflix.Loading.remove();
                    showToast(response.message, "error");
                }
            });
        },
        function cancelCb() {
            showToast('Cancelled! No changes were made.', "info");
        }
    );
});

// 2. Referral Cashback Discount Settlement
$(document).on('click', '.settle_referal_cashback_discount', function () {
    Notiflix.Confirm.show(
        'Are You Sure!',
        "You won't be able to revert this!",
        'Yes, settle Discounted!',
        'Cancel',
        function okCb() {
            Notiflix.Loading.standard('Processing...');

            $.ajax({
                url: base_url + 'admin/cron_job/settle_referal_cashback_discount',
                type: 'GET',
                data: { is_date: true },
                dataType: 'json',
                success: function (response) {
                    Notiflix.Loading.remove();

                    if (response.error === false) {
                        showToast(response.message, "success");
                        $('table').bootstrapTable('refresh');
                    } else {
                        showToast(response.message, "error");
                    }
                },
                error: function () {
                    Notiflix.Loading.remove();
                    showToast(response.message, "error");
                }
            });
        },
        function cancelCb() {
            showToast('Cancelled! No changes were made.', "info");
        }
    );
});

$(document).on('click', '.settle_referal_cashback_discount_for_referal', function () {
    Notiflix.Confirm.show(
        'Are You Sure!',
        'You won\'t be able to revert this!',
        'Yes, settle Discounted!',
        'Cancel',
        function okCb() {
            Notiflix.Loading.standard('Processing...');

            $.ajax({
                url: base_url + 'admin/cron_job/settle_referal_cashback_discount_for_referal',
                type: 'GET',
                data: { is_date: true },
                dataType: 'json',
                success: function (response) {
                    Notiflix.Loading.remove();

                    if (response.error === false) {
                        showToast(response.message, "success");
                        $('table').bootstrapTable('refresh');
                    } else {
                        showToast(response.message, "error");
                    }
                },
                error: function () {
                    Notiflix.Loading.remove();
                    showToast(response.message, "error");
                }
            });
        },
        function cancelCb() {
            showToast('Cancelled! No changes were made.', "info");
        }
    );
});

$(document).on('click', '.update-affiliate-commission', function () {

    Notiflix.Confirm.show(
        'Are You Sure!',
        "You won't be able to revert this!",
        'Yes, settle commission!',
        'Cancel',
        function () { // ✅ On Confirm
            Notiflix.Loading.circle('Processing...');

            $.ajax({
                url: base_url + 'admin/cron-job/settle_affiliate_commission?is_date=true',
                type: 'GET',
                data: { 'is_date': true },
                dataType: 'json',
                success: function (response) {
                    Notiflix.Loading.remove();

                    if (response.error == false) {
                        showToast(response.message, 'success');
                        // Notiflix.Report.success('Done!', response.message, 'Okay');
                        $('table').bootstrapTable('refresh');
                    } else {
                        showToast(response.message, 'error');
                        // Notiflix.Report.warning('Oops...', response.message, 'Close');
                    }
                },
                error: function () {
                    Notiflix.Loading.remove();
                    Notiflix.Report.failure('Oops...', 'Something went wrong with ajax!', 'Close');
                }
            });
        },
        function () {
            // ❌ Cancel clicked (optional to handle)
        }
    );

});

// 3. Seller Commission Settlement
$(document).on('click', '.update-seller-commission', function () {
    Notiflix.Confirm.show(
        'Are You Sure!',
        "You won't be able to revert this!",
        'Yes, settle commission!',
        'Cancel',
        function () { // ✅ On Confirm
            Notiflix.Loading.circle('Settling Seller Commission...');

            $.ajax({
                url: base_url + 'admin/cron-job/settle-seller-commission',
                type: 'GET',
                data: { 'is_date': true },
                dataType: 'json',
                success: function (response) {
                    Notiflix.Loading.remove();

                    if (response.error === false) {
                        showToast(response.message, 'success');
                        $('table').bootstrapTable('refresh');
                    } else {
                        showToast(response.message, 'error');
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
});



// seller removal
$(document).on('click', '.remove-sellers', function () {
    var id = $(this).data('id');
    var status = $(this).data('seller_status');

    Notiflix.Confirm.show(
        'Are You Sure!',
        'You want to remove this Seller. You won\'t be able to revert this!',
        'Yes, Remove it!',
        'Cancel',
        function okCb() {
            Notiflix.Loading.standard('Removing seller...');

            $.ajax({
                type: 'GET',
                url: base_url + 'admin/sellers/remove_sellers',
                data: { id: id, status: status },
                dataType: 'json',
                success: function (response) {

                    Notiflix.Loading.remove();

                    csrfName = response['csrfName'];
                    csrfHash = response['csrfHash'];

                    if (response.error === false) {
                        showToast(response.message || 'Seller removed successfully', 'success');
                        $('table').bootstrapTable('refresh');
                    } else {
                        showToast(response.message, 'error');
                    }
                },
                error: function (jqXHR) {
                    Notiflix.Loading.remove();
                    showToast('Something went wrong with ajax!', 'error');

                    if (jqXHR.responseJSON) {
                        csrfName = jqXHR.responseJSON['csrfName'];
                        csrfHash = jqXHR.responseJSON['csrfHash'];
                    }
                }
            });
        },
        function cancelCb() {
            showToast('Cancelled! Your data is safe.', 'info');

        }
    );
});

var cat_html = "";
var count_view = 0;

$(document).on('click', '#seller_model', function (e) {
    e.preventDefault();
    cat_html = $('#cat_html').html();
    var cat_ids = $(this).data('cat_ids') + ',';
    var cat_array = cat_ids.split(",");
    cat_array = cat_array.filter(function (v) {
        return v !== ''
    });
    cat_array.sort(function (a, b) {
        return a - b;
    });

    document.getElementById("category_flag").value = "0";
    var seller_id = $(this).data('seller_id');

    count_view = 0;

    $('#repeater').empty();

    if (cat_ids != "" && cat_ids != "," && cat_ids != 'undefined' && seller_id != "" && seller_id != 'undefined') {
        $.ajax({
            type: 'POST',
            data: {
                'id': seller_id,
                [csrfName]: csrfHash
            },
            url: base_url + 'admin/sellers/get_seller_commission_data',
            dataType: 'json',
            success: function (result) {

                csrfName = result.csrfName;
                csrfHash = result.csrfHash;
                if (result.error == false) {
                    let format = false;
                    if (result.data.length == 0) {
                        format = false;
                        addDefaultRepeaterRow();
                    } else {
                        if (result.data[0].category_id == undefined) {
                            format = true;
                        }
                        $.each(result.data, function (i, e) {
                            if (format) {


                                var is_selected = cat_array.includes(e.id) ? true : false;
                                if (is_selected) {
                                    addRepeaterRowWithData(e.id, e.name, e.commission);
                                }
                            } else {


                                var is_selected = (e.category_id == cat_array[i] && e.seller_id == seller_id) ? true : false;
                                if (is_selected) {
                                    addRepeaterRowWithData(e.category_id, e.name, e.commission);
                                }
                            }
                        });
                        if ($('#repeater').children().length === 0) {
                            addDefaultRepeaterRow();
                        }
                    }
                } else {
                    showToast(result.message, 'error');
                    addDefaultRepeaterRow();
                }
            },
            error: function () {
                showToast('Error loading commission data', 'error');
                addDefaultRepeaterRow();
            }
        });
    } else {
        addDefaultRepeaterRow();
    }
});

function addRepeaterRowWithData(categoryId, categoryName, commission) {
    const item = `
        <div class="d-flex align-items-center gap-3 repeater-item my-2">
            <div class="col-md-5">
                <select name="category_id" class="form-select category-select-${categoryId}" required>
                    <option value="">Select Category</option>
                </select>
            </div>
            <div class="col-md-5">
                <input type="number" class="form-control" name="commission" min="0" step="0.001"
                    placeholder="Commission" value="${commission}" required>
            </div>
            <a type="button" class="remove-btn text-decoration-none" title="Remove Category">
                <i class="fs-2 text-danger ti ti-xbox-x"></i>
            </a>
        </div>
    `;

    $('#repeater').append(item);

    const newSelect = $('#repeater').find('.category-select-' + categoryId)[0];

    initTomSelect({
        element: newSelect,
        url: '/admin/category/get_categories?from_select=1',
        placeholder: 'Select Category...',
        onItemAdd: null,
        preselected: categoryId,
        offcanvasId: null,
        dataAttribute: null,
        maxItems: 1,
        preloadOptions: true
    });
}

function addDefaultRepeaterRow() {
    const item = `
        <div class="d-flex align-items-center gap-3 repeater-item my-2">
            <div class="col-md-5">
                <select name="category_id" class="form-select default-category-select" required>
                    <option value="">Select Category</option>
                </select>
            </div>
            <div class="col-md-5">
                <input type="number" class="form-control" name="commission" min="0" step="0.001"
                    placeholder="Commission" required>
            </div>
            <a type="button" class="remove-btn text-decoration-none" title="Remove Category">
                <i class="fs-2 text-danger ti ti-xbox-x"></i>
            </a>
        </div>
    `;

    $('#repeater').append(item);

    const newSelect = $('#repeater').find('.default-category-select').last()[0];
    initTomSelect({
        element: newSelect,
        url: '/admin/category/get_categories?from_select=1',
        placeholder: 'Select Category...',
        onItemAdd: null,
        offcanvasId: null,
        dataAttribute: null,
        maxItems: 1,
        preloadOptions: true
    });
}

$(document).on('click', '.remove_category_section', function () {
    var $row = $(this).closest('.d-flex');
    var commission = $row.find('input[name="commission"]').val();
    if (parseFloat(commission) !== 0) {
        // If commission is not 0, disable the button
        $(this).prop('disabled', true);
        showToast('Cannot remove. Commission must be 0 to remove this section.', 'error');
        return;
    }
    if ($('#category_section').children('.form-group').length > 1) {
        $row.remove();
    } else {
        alert('At least one category section must be present.');
    }
});

$('#add-seller-commission-form').on('submit', function (e) {
    e.preventDefault();
    var formData = new FormData(this);

    var object = {};
    formData.forEach((value, key) => {
        // Reflect.has in favor of: object.hasOwnProperty(key)
        if (!Reflect.has(object, key)) {
            object[key] = value;
            return;
        }
        if (!Array.isArray(object[key])) {
            object[key] = [object[key]];
        }
        object[key].push(value);
    });
    var json = JSON.stringify(object);

    $('#cat_data').val(json);
    setTimeout(function () {
        $('#sellerCommission').offcanvas('hide');
    }, 500);

});

// Reset count_view when offcanvas is closed so data reloads on next open
$('#sellerCommission').on('hidden.bs.offcanvas', function () {
    count_view = 0;
});

// Store Tom Select instances for management
let tomSelectInstances = [];

function initializeTomSelectForRepeater(selectElement) {
    const preselected = selectElement.getAttribute('data-preselected');

    const ts = initTomSelect({
        element: selectElement,
        url: '/admin/category/get_categories?from_select=1',
        placeholder: 'Select Category...',
        onItemAdd: null, // No add new functionality for categories
        preselected: preselected ? parseInt(preselected) : null,
        offcanvasId: null,
        dataAttribute: null,
        maxItems: 1,
        preloadOptions: true
    });

    // Store the instance for later management
    tomSelectInstances.push(ts);

    // Add event listener for change events to refresh disabled options
    ts.on('change', function () {
        setTimeout(() => {
            refreshDisabledOptions();
        }, 50);
    });

    return ts;
}

function getSelectedCategoryValues() {
    const selectedValues = [];
    tomSelectInstances.forEach(ts => {
        const value = ts.getValue();
        if (value && value !== '') {
            selectedValues.push(value);
        }
    });
    return selectedValues;
}

function refreshDisabledOptions() {
    const selectedValues = getSelectedCategoryValues();

    tomSelectInstances.forEach(ts => {
        const currentValue = ts.getValue();

        // Get all options and disable already selected ones
        const options = ts.options;
        Object.keys(options).forEach(key => {
            if (key !== '__addnew__' && key !== currentValue && selectedValues.includes(key)) {
                ts.updateOption(key, { disabled: true });
            } else if (key !== '__addnew__' && key !== currentValue) {
                ts.updateOption(key, { disabled: false });
            }
        });
    });
}


function refreshDisabledOptions() {
    let selectedValues = [];

    $('.category_parent').each(function () {
        let val = $(this).val();
        if (val !== '') {
            selectedValues.push(val);
        }
    });

    $('.category_parent').each(function () {
        let currentSelect = $(this);
        let currentVal = currentSelect.val();

        currentSelect.find('option').each(function () {
            let optionVal = $(this).val();
            if (!optionVal) return;

            if (selectedValues.includes(optionVal) && optionVal !== currentVal) {
                $(this).attr('disabled', true);
            } else {
                $(this).attr('disabled', false);
            }
        });
    });

}

$(document).ready(function () {
    // Initialize Tom Select for existing repeater items (only in affiliate settings)
    $('.category_parent_tomselect').each(function () {
        // Only initialize if not inside seller commission offcanvas
        if (!$(this).closest('#sellerCommissionOffcanvas').length) {
            initializeTomSelectForRepeater(this);
        }
    });

    // Initialize disabled options after all Tom Select instances are created
    setTimeout(() => {
        refreshDisabledOptions();
    }, 100);

    // Handle "Add More" button for both affiliate settings and seller commission
    $('#add-more').on('click', function () {
        // Check if inside seller commission offcanvas
        if ($(this).closest('#sellerCommission').length || $(this).closest('form#add-seller-commission-form').length) {
            // Seller commission offcanvas - add repeater row
            const uniqueClass = 'category-select-new-' + Date.now();
            const item = `
                <div class="d-flex align-items-center gap-3 repeater-item my-2">
                    <div class="col-md-5">
                        <select name="category_id" class="form-select ${uniqueClass}" required>
                            <option value="">Select Category</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <input type="number" class="form-control" name="commission" min="0" step="0.001"
                            placeholder="Commission" required>
                    </div>
                    <a type="button" class="remove-btn text-decoration-none" title="Remove Category">
                        <i class="fs-2 text-danger ti ti-xbox-x"></i>
                    </a>
                </div>
            `;

            $('#repeater').append(item);

            // Initialize Tom Select for the new select
            const newSelect = $('#repeater').find('.' + uniqueClass)[0];
            initTomSelect({
                element: newSelect,
                url: '/admin/category/get_categories?from_select=1',
                placeholder: 'Select Category...',
                onItemAdd: null,
                offcanvasId: null,
                dataAttribute: null,
                maxItems: 1,
                preloadOptions: true
            });
            return;
        }

        // Affiliate settings page
        const item = `
            <div class="repeater-item">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="col-md-5">
                        <select name="category_parent[]" class="category_parent_tomselect form-select" required>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <input type="number" class="form-control" name="commission[]" placeholder="Commission (%)" 
                            min="0" max="100" step="0.01" required>
                    </div>
                    <div class="col-md-2">
                        <a type="button" class="remove-btn text-decoration-none" title="Remove Category">
                            <i class="fs-2 text-danger ti ti-xbox-x"></i>
                        </a>
                    </div>
                </div>
            </div>
        `;

        $('#repeater').append(item);

        // Initialize Tom Select for the new item
        const newSelect = $('#repeater').find('.category_parent_tomselect').last()[0];
        initializeTomSelectForRepeater(newSelect);

        // Refresh disabled options after initialization
        setTimeout(() => {
            refreshDisabledOptions();
        }, 100);
    });

    $(document).on('click', '.remove-btn', function () {
        // Check if inside seller commission offcanvas
        if ($(this).closest('#sellerCommission').length || $(this).closest('form#add-seller-commission-form').length) {
            // Seller commission offcanvas - remove repeater row
            const $repeaterItem = $(this).closest('.repeater-item');
            const commission = $repeaterItem.find('input[name="commission"]').val();

            if (commission && parseFloat(commission) !== 0) {
                showToast('Cannot remove. Commission must be 0 to remove this section.', 'warning');
                return;
            }

            if ($('#repeater').children('.repeater-item').length > 1) {
                $repeaterItem.remove();
            } else {
                showToast('At least one category section must be present.', 'warning');
            }
            return;
        }

        // Affiliate settings page
        const $repeaterItem = $(this).closest('.repeater-item');
        const $select = $repeaterItem.find('.category_parent_tomselect')[0];

        // Find and destroy the Tom Select instance if it exists
        if ($select) {
            const instanceIndex = tomSelectInstances.findIndex(ts => ts.input === $select);
            if (instanceIndex > -1) {
                tomSelectInstances[instanceIndex].destroy();
                tomSelectInstances.splice(instanceIndex, 1);
            }
        }

        $repeaterItem.remove();

        // Refresh disabled options after removal
        setTimeout(() => {
            refreshDisabledOptions();
        }, 100);
    });

});


// affiliate user


$('.addAffiliateUserBtn').on('click', function () {


    $('.offcanvas-title').text('Add Affiliate User');
    $('.save_affiliate_user').text('Add Affiliate User');

    // Clear fields that aren't reset by .reset()
    $('.edit_affiliate_user').val('');
    $('.edit_affiliate_data_id').val('');
    $('.affiliate_uuid').val('');
    $('#full_name').val('');
    $('#email').val('');
    $('#mobile').val('');
    $('#address').val('');
    $('#my_website').val('');
    $('#my_app').val('');
    $('.password_field').removeClass('d-none');
    $('.confirm_password_field').removeClass('d-none');

    $("input[name='status']").prop('checked', false);

});

$("#affiliate_users_table").on("click-cell.bs.table", function (field, value, row, $el) {

    $('.offcanvas-title').text('Update Affiliate User');
    $('.save_affiliate_user').text('Update Affiliate User');

    $('#edit_affiliate_user').val($el.user_id);
    $('#edit_affiliate_data_id').val($el.id);
    $('#affiliate_uuid').val($el.uuid);

    $('#full_name').val($el.name);
    $('#mobile').val($el.mobile);
    $('#email').val($el.email);
    $('#address').val($el.address);
    $('#my_website').val($el.website_url);
    $('#my_app').val($el.mobile_app_url);

    $('.password_field').addClass('d-none');
    $('.confirm_password_field').addClass('d-none');

    $("input[name='status'][value='" + $el.status_main + "']").prop('checked', true);

});


// Consignment 

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
        return showToast('Order status is still awaiting. You cannot create a parcel.', 'error');
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
                data: {
                    id
                },
                dataType: "json",
                success: function (response) {
                    if (response.error == true) {
                        showToast(response.message, 'error');
                    } else {
                        response.data.map(val => {
                            $("#product_variant_id_" + val.product_variant_id).html(JSON.stringify(val))
                        })
                        showToast(response.message, 'success');
                        Notiflix.Report.success(
                            'Success',
                            'Consignment Deleted !',
                            'Okay'
                        );
                    }
                    $("#consignment_table").bootstrapTable('refresh')
                }
            });
        },
        function cancelCb() {
            // User cancelled
        }
    );
}

$(document).on('click', '#ship_parcel_btn', function (e) {
    e.preventDefault();
    let product_to_ship = $('.product-to-ship:checked');
    let consignment_title = $('#consignment_title').val();
    let order_id = $('#order_id').val();

    let selected_items = [];
    product_to_ship.each(function () {
        selected_items.push($(this).data("item-id"));
    });
    $.ajax({
        type: "POST",
        url: base_url + "admin/orders/create_consignment",
        data: {
            consignment_title,
            selected_items,
            order_id,
            [csrfName]: csrfHash,
        },
        success: function (response) {
            response = (JSON.parse(response));
            csrfName = response['csrfName'];
            csrfHash = response['csrfHash'];
            if (response.error == false) {
                response.data.map(val => {
                    $("#product_variant_id_" + val.product_variant_id).html(JSON.stringify(val))
                })
                $("#consignment_table").bootstrapTable('refresh')
                $("#create_consignment_modal").modal('hide')
                showToast(response.message, 'success');
            } else {
                showToast(response.message, 'error');
            }
        }
    });
})


$('#viewConsignmentItemsOffcanvas').on('show.bs.offcanvas', function (event) {
    let triggerElement = $(event.relatedTarget);
    // let consignment_items = $(triggerElement).data('items');
    current_selected_image = triggerElement;
    let consignment_items = $(current_selected_image).data('items');
    let container = document.getElementById('consignment_details');

    container.innerHTML = ''; // clear old items

    consignment_items.forEach(element => {
        let item = `
            <div class="list-group-item d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="me-3" style="width:60px;height:60px;overflow:hidden;border-radius:8px;">
                        <img src="${element.image}" alt="${element.product_name}" 
                             style="width:100%;height:100%;object-fit:cover;">
                    </div>
                    <div>
                        <div class="fw-bold">${element.product_name}</div>
                        <small class="text-muted">Qty: ${element.quantity}</small>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', item);
    });
});

// Reset on close
$(document).on('hide.bs.offcanvas', '#consignment_status_offcanvas', function () {
    $("#consignment-items-container").empty();
    $("#tracking_box").empty();
    $("#tracking_box_old").empty();
    $('.shiprocket_order_box').removeClass('d-none');
    $('.manage_shiprocket_box').addClass('d-none');
});

// Show & render
$(document).on('show.bs.offcanvas', '#consignment_status_offcanvas', function (event) {
    let triggerElement = $(event.relatedTarget);
    let consignment_items = $(triggerElement).data('items');

    $('#consignment_data').val(JSON.stringify(consignment_items));
    const container = document.getElementById('consignment-items-container');
    container.innerHTML = '';

    let count = 1;
    consignment_items.forEach(element => {
        $('#consignment_id').val(element.consignment_id);
        $('#deliver_by').val(element.delivery_boy_id);
        $('.consignment_status').val(element.active_status).change();

        let card = `
        <div class="card mb-2 shadow-sm border rounded-3">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="me-3" style="width:60px;height:60px;overflow:hidden;border-radius:8px;">
                        <img src="${element.image}" alt="${element.product_name}" 
                             style="width:100%;height:100%;object-fit:cover;">
                    </div>
                    <div>
                        <div class="fw-bold">${count++}. ${element.product_name}</div>
                        <small class="text-muted">Qty: ${element.quantity}</small>
                    </div>
                </div>
            </div>
        </div>`;
        container.insertAdjacentHTML('beforeend', card);
    });
});

$(document).on('change', '.consignment_status', function (e) {
    let status = $(this).val();

    let delivery_boy_otp_system = $('#delivery_boy_otp_system').val();

    if (status == "delivered" && (delivery_boy_otp_system == 1 || delivery_boy_otp_system == '1')) {
        return $('.otp-field').removeClass('d-none');
    }
    $('.otp-field').addClass('d-none');
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
                $('#consignment_status_modal').modal("hide");

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



// Digital Order Status Update
$(document).on('click', '.digital_order_status_update', function (e) {
    let status = $('.digital_order_status').val();
    let order_id = $('#order_id').val();

    if (status == "" || status == null) {
        showToast('Please Select Status', 'error');
        return false;
    }

    Notiflix.Confirm.show(
        'Are You Sure!',
        "You won't be able to revert this!",
        'Yes, update it!',
        'Cancel',
        function okCb() {
            Notiflix.Loading.standard('Updating...');

            $.ajax({
                type: 'POST',
                url: base_url + 'admin/orders/update_order_status',
                data: {
                    order_id,
                    status,
                    type: "digital",
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




// Language Management Functions

$(document).on('click', '.set-as-default-language', function () {
    var languageId = $(this).data('id');

    $.ajax({
        url: base_url + 'admin/language/set_default_for_web',
        method: 'POST',
        data: {
            is_default: '1',
            language_id: languageId
        },
        success: function (response) {

            // Handle success response
            // var response = JSON.parse(response);
            if (response.error == false) {
                showToast(response.message, 'success');
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else {
                showToast(response.message, 'error');
            }
        }
    });


})

// Handle upload button clicks
$(document).on('click', '.upload-language', function () {
    const languageId = $(this).data('id');
    // Store the language ID for the upload form
    $('#uploadLanguageFile').data('language-id', languageId);
    // Pre-select the language in the dropdown
    $('#language_id').val(languageId);
    // Show the upload offcanvas
    $('#uploadLanguageFile').offcanvas('show');
});

// Handle offcanvas show event to pre-select language
$('#uploadLanguageFile').on('show.bs.offcanvas', function () {
    const languageId = $(this).data('language-id');
    if (languageId) {
        $('#language_id').val(languageId);
    }
});

// =====================================
// Product Bulk Affiliate Settings
// =====================================

// Store selected product IDs globally
var bulkSelectedProductIds = [];

// Open bulk affiliate settings offcanvas
$(document).on('click', '#openBulkAffiliateOffcanvas', function () {
    // Get selected products from the table
    var selectedProducts = $('#products_affiliate_table').bootstrapTable('getSelections');

    // Check if any products are selected
    if (selectedProducts.length === 0) {
        showToast('Please select at least one product to update.', 'error');
        return;
    }

    // Extract product IDs
    bulkSelectedProductIds = $.map(selectedProducts, function (row) {
        return row.id;
    });

    $('#product_ids').val(bulkSelectedProductIds);

    // Update the count display
    $('#selectedProductCount').text(selectedProducts.length);

    // Reset the form
    $('#bulk_is_in_affiliate').val('');

    // Show the offcanvas
    $('#bulkProductAffiliateSetting').offcanvas('show');
});

// Handle bulk affiliate form submission
// $(document).on('submit', '#bulkAffiliateForm', function (e) {
//     e.preventDefault();

//     var is_in_affiliate = $('#bulk_is_in_affiliate').val();

//     // Validate selection
//     if (is_in_affiliate === "") {
//         showToast('Please select affiliate status.', 'error');
//         // iziToast.error({
//         //     title: 'Error',
//         //     message: 'Please select affiliate status.',
//         //     position: 'topRight'
//         // });
//         return false;
//     }

//     if (bulkSelectedProductIds.length === 0) {
//         showToast('No products selected.', 'error');
//         // iziToast.error({
//         //     title: 'Error',
//         //     message: 'No products selected.',
//         //     position: 'topRight'
//         // });
//         return false;
//     }

//     // Disable submit button and show loading state
//     var submitBtn = $('#bulkSubmitBtn');
//     var originalBtnText = submitBtn.html();
//     submitBtn.prop('disabled', true).html('<i class="ti ti-loader"></i> Updating...');

//     // Send AJAX request
//     $.ajax({
//         url: base_url + 'admin/product/bulk_update_affiliate',
//         method: 'POST',
//         data: {
//             product_ids: bulkSelectedProductIds,
//             is_in_affiliate: is_in_affiliate
//         },
//         dataType: 'json',
//         success: function (response) {
//             if (response.error === false) {
//                 // Success
//                 showToast(response.message, 'success');

//                 // Refresh the products table
//                 $('#products_affiliate_table').bootstrapTable('refresh');

//                 // Clear selections
//                 $('#products_affiliate_table').bootstrapTable('uncheckAll');
//                 bulkSelectedProductIds = [];

//                 // Close the offcanvas
//                 $('#bulkProductAffiliateSetting').offcanvas('hide');

//                 // Reset form
//                 $('#bulkAffiliateForm')[0].reset();
//             } else {
//                 // Error
//                 showToast(response.message, 'error');
//             }
//         },
//         error: function (xhr, status, error) {
//             console.error('Error:', error);
//             showToast('An error occurred while updating affiliate settings.', 'error');

//         },
//         complete: function () {
//             // Re-enable submit button
//             submitBtn.prop('disabled', false).html(originalBtnText);
//         }
//     });

//     return false;
// });




// ============================================
// Stock Management Functionality
// ============================================
// Handle edit button clicks
$(document).on('click', '.edit_stock_btn', function (e) {
    e.preventDefault();
    var variant_id = $(this).data('id');

    // Fetch variant data via AJAX
    $.ajax({
        url: base_url + 'admin/manage_stock/get_variant_data',
        type: 'GET',
        data: { edit_id: variant_id },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                $('#product_name').val(response.data.product_name);
                $('#current_stock').val(response.data.current_stock);
                $('#quantity').val('');
                $('#type').val('add');
                $('input[name="variant_id"]').val(response.data.variant_id);
            }
        },
        error: function () {
            showToast('Failed to load product data', 'error');
        }
    });
});

// Handle form submission
$('#stock_adjustment_form').on('submit', function (e) {
    e.preventDefault();

    var formData = new FormData(this);

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
            if (!response.error) {
                showToast(response.message, 'success');

                // Update the current stock field
                if (response.data && response.data.new_stock) {
                    $('#current_stock').val(response.data.new_stock);
                }

                // Refresh table
                $('#products_table').bootstrapTable('refresh');

            } else {
                showToast(response.message, 'error');
            }
        },
        error: function () {
            showToast('Failed to update stock', 'error');
        }
    });
});



$(document).on('click', '.edit_faq_btn', function (e) {
    e.preventDefault();

    var question = $(this).data('question');
    var answer = $(this).data('answer');
    var edit_faq = $(this).data('id');

    $('#question').val(question);
    $('#answer').text(answer);
    $('input[name="edit_faq"]').val(edit_faq);
    $('#submit_btn').text('Update FAQ');
    $('#addFAQLabel').text('Edit FAQ');
})

$(document).on('show.bs.offcanvas', '#addFAQ', function (e) {
    var relatedTarget = e.relatedTarget;

    if (relatedTarget && !$(relatedTarget).hasClass('edit_faq_btn')) {
        $('#add_faq_form')[0].reset();
        $('#question').val('');
        $('#answer').text('');
        $('input[name="edit_faq"]').val('');
        $('#submit_btn').text('Add FAQ');
        $('#addFAQLabel').text('Add FAQs');
    }
})

// ============================================
// Ticket System Functions
// ============================================


var ticket_id = "";
var scrolled = 0;

// View Ticket Modal
$(document).on('click', '.view_ticket', function (e, row) {
    e.preventDefault();
    scrolled = 0;
    $(".ticket_msg").data('max-loaded', false);
    ticket_id = $(this).data("id");
    var username = $(this).data("username");
    var date_created = $(this).data("date_created");
    var subject = $(this).data("subject");
    var status = $(this).data("status");
    var ticket_type = $(this).data("ticket_type");

    $('input[name="ticket_id"]').val(ticket_id);
    $('#user_name').html(username);
    $('#ticket_id_display').html(ticket_id);
    $('#date_created').html(date_created);
    $('#subject').html(subject);
    $('.change_ticket_status').data('ticket_id', ticket_id);

    $('.change_ticket_status').val(status);

    if (status == 1) {
        $('#status').html('<span class="badge bg-secondary-lt text-secondary">PENDING</span>');
        $('.ticket_status_footer').addClass('d-none');
    } else if (status == 2) {
        $('#status').html('<span class="badge bg-blue-lt text-blue">OPENED</span>');
        $('.ticket_status_footer').removeClass('d-none');
    } else if (status == 3) {
        $('#status').html('<span class="badge bg-green-lt text-green">RESOLVED</span>');
        $('.ticket_status_footer').removeClass('d-none');
    } else if (status == 4) {
        $('#status').html('<span class="badge bg-red-lt text-red">CLOSED</span>');
        $('.ticket_status_footer').addClass('d-none');
    } else if (status == 5) {
        $('.ticket_status_footer').removeClass('d-none');
        $('#status').html('<span class="badge bg-yellow-lt text-yellow">REOPENED</span>');
    }

    $('#ticket_type').html(ticket_type);
    $('.ticket_msg').html("");
    $('.ticket_msg').data('limit', 5);
    $('.ticket_msg').data('offset', 0);
    load_messages($('.ticket_msg'), ticket_id);

    // Show offcanvas
    // var ticketOffcanvas = new bootstrap.Offcanvas(document.getElementById('ticket_offcanvas'));
    // ticketOffcanvas.show();
});

// Scroll handlers for loading more messages
$(document).ready(function () {
    if ($("#element").length) {
        $("#element").scrollTop($("#element")[0].scrollHeight);
        $('#element').scroll(function () {
            if ($('#element').scrollTop() == 0) {
                load_messages($('.ticket_msg'), ticket_id);
            }
        });

        $('#element').bind('mousewheel', function (e) {
            if (e.originalEvent.wheelDelta / 120 > 0) {
                if ($(".ticket_msg")[0].scrollHeight < 370 && scrolled == 0) {
                    load_messages($('.ticket_msg'), ticket_id);
                    scrolled = 1;
                }
            }
        });
    }
});

// Load ticket messages
function load_messages(element, ticket_id) {
    var limit = element.data('limit');
    var offset = element.data('offset');

    element.data('offset', limit + offset);
    var max_loaded = element.data('max-loaded');
    if (max_loaded == false) {
        var loader = '<div class="loader"><div class="spinner"></div></div>';
        $.ajax({
            type: 'get',
            data: 'ticket_id=' + ticket_id + '&limit=' + limit + '&offset=' + offset,
            url: base_url + 'admin/tickets/get_ticket_messages',
            beforeSend: function () {
                $('.ticket_msg').prepend(loader);
            },
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function (result) {
                if (result.error == false) {
                    if (result.error == false && result.data.length > 0) {
                        var messages_html = "";
                        var is_left = "";
                        var is_right = "";
                        var atch_html = "";
                        var i = 1;
                        result.data.reverse().forEach(messages => {
                            is_left = (messages.user_type == 'user' || messages.user_type == '') ? 'left' : 'right';
                            is_right = (messages.user_type == 'user' || messages.user_type == '') ? 'right' : 'left';
                            atch_html = "";
                            if (messages.attachments && messages.attachments.length > 0) {
                                messages.attachments.forEach(atch => {
                                    // Check if it's an image file
                                    if (atch.media && (atch.media.includes('.jpg') || atch.media.includes('.jpeg') || atch.media.includes('.png') || atch.media.includes('.gif'))) {
                                        atch_html += "<div class='mt-2'>" +
                                            "<img src='" + atch.media + "' class='img-fluid rounded' style='max-height: 200px;' />" +
                                            "</div>";
                                    } else {
                                        // Handle other file types as download links
                                        atch_html += "<div class='container-fluid image-upload-section'>" +
                                            "<a class='btn btn-danger btn-sm me-1 mb-1' href='" + atch.media + "'  target='_blank' alt='Attachment Not Found'>Attachment " + i + "</a>" +
                                            "<div class='col-md-3 col-sm-12 shadow p-3 mb-5 rounded m-4 text-center d-none image'></div>" +
                                            "</div>";
                                    }
                                    i++;
                                });
                            } else if (messages.attachments && typeof messages.attachments === 'string') {
                                // Handle string format attachments (JSON or single path)
                                try {
                                    var attachmentArray = JSON.parse(messages.attachments);
                                    if (Array.isArray(attachmentArray)) {
                                        attachmentArray.forEach(function (attachment) {
                                            if (attachment.includes('.jpg') || attachment.includes('.jpeg') || attachment.includes('.png') || attachment.includes('.gif')) {
                                                atch_html += "<div class='mt-2'>" +
                                                    "<img src='" + attachment + "' class='img-fluid rounded' style='max-height: 200px;' />" +
                                                    "</div>";
                                            } else {
                                                atch_html += "<div class='mt-2'>" +
                                                    "<a class='btn btn-sm btn-outline-primary' href='" + attachment + "' target='_blank'>Download File</a>" +
                                                    "</div>";
                                            }
                                        });
                                    }
                                } catch (e) {
                                    // If not JSON, treat as single image/file
                                    if (messages.attachments.includes('.jpg') || messages.attachments.includes('.jpeg') || messages.attachments.includes('.png') || messages.attachments.includes('.gif')) {
                                        atch_html += "<div class='mt-2'>" +
                                            "<img src='" + messages.attachments + "' class='img-fluid rounded' style='max-height: 200px;' />" +
                                            "</div>";
                                    } else {
                                        atch_html += "<div class='mt-2'>" +
                                            "<a class='btn btn-sm btn-outline-primary' href='" + messages.attachments + "' target='_blank'>Download File</a>" +
                                            "</div>";
                                    }
                                }
                            }
                            // Ensure we have the required fields with fallbacks
                            var messageName = messages.name || 'Unknown User';
                            var messageText = messages.message || '';
                            var messageTime = messages.last_updated || new Date().toLocaleString();

                            messages_html += "<div class='direct-chat-msg " + is_left + "'>" +
                                "<div class='direct-chat-infos clearfix'>" +
                                "<span class='direct-chat-name float-" + is_left + "' id='name'>" + messageName + "</span>" +
                                "<span class='direct-chat-timestamp float-" + is_left + "' id='last_updated'>" + messageTime + "</span>" +
                                "</div>" +
                                "<div class='direct-chat-text' id='message'>" + messageText + "</br>" + atch_html + "</div>" +
                                "</div>";
                        });
                        $('.ticket_msg').prepend(messages_html);
                        $('.ticket_msg').find('.loader').remove();
                        $('.empty-messages').hide(); // Hide empty state when messages are loaded
                        $(element).animate({
                            scrollTop: $(element).offset().top
                        });
                    }
                } else {
                    element.data('offset', offset);
                    element.data('max-loaded', true);
                    $('.ticket_msg').find('.loader').remove();
                    $('.ticket_msg').prepend('<div class="text-center"> <p>You have reached the top most message!</p></div>');
                }
                $('#element').scrollTop(20); // Scroll alittle way down, to allow user to scroll more
                $(element).animate({
                    scrollTop: $(element).offset().top
                });
                return false;
            }
        });
    }
}

// Send ticket message
$('#ticket_send_msg_form').on('submit', function (e) {
    e.preventDefault();
    var formdata = new FormData(this);
    formdata.append(csrfName, csrfHash);

    $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: formdata,
        beforeSend: function () {
            $('#submit_btn').html('<div class="spinner" style="width: 16px; height: 16px; border-width: 2px;"></div>').attr('disabled', true);
        },
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function (result) {
            console.log(result);
            csrfHash = result.csrfHash;
            csrfName = result.csrfName;
            $('#submit_btn').html('<i class="ti ti-send"></i>').attr('disabled', false);
            if (result.error == false) {
                if (result.data) {
                    var message = result.data.data;

                    var is_left = (message.user_type == 'user' || message.user_type == '') ? 'left' : 'right';
                    var is_right = (message.user_type == 'user' || message.user_type == '') ? 'right' : 'left';
                    var atch_html = "";
                    var i = 1;
                    var message_html = "";
                    if (message.attachments && message.attachments.length > 0) {
                        message.attachments.forEach(atch => {
                            atch_html += "<div class='container-fluid image-upload-section'>" +
                                "<a class='btn btn-danger btn-sm me-1 mb-1' href='" + atch.media + "'  target='_blank' alt='Attachment Not Found'>Attachment " + i + "</a>" +
                                "<div class='col-md-3 col-sm-12 shadow p-3 mb-5 rounded m-4 text-center d-none image'></div>" +
                                "</div>";
                            i++;
                        });
                    }

                    // Ensure we have the required fields with fallbacks
                    var messageName = message.name || 'Admin';
                    var messageText = message.message || '';
                    var messageTime = message.last_updated || new Date().toLocaleString();

                    message_html += "<div class='direct-chat-msg " + is_left + "'>" +
                        "<div class='direct-chat-infos clearfix'>" +
                        "<span class='direct-chat-name float-" + is_left + "' id='name'>" + messageName + "</span>" +
                        "<span class='direct-chat-timestamp float-" + is_left + "' id='last_updated'>" + messageTime + "</span>" +
                        "</div>" +
                        "<div class='direct-chat-text' id='message'>" + messageText + "</br>" + atch_html + "</div>" +
                        "</div>";

                    $('.ticket_msg').append(message_html);
                    $('.empty-messages').hide();
                    $("#message_input").val('');
                    $("#element").scrollTop($("#element")[0].scrollHeight);
                    // $('input[name="attachments[]"]').val('');
                }
                showToast(result.message, 'success');
            } else {
                $("#element").data('max-loaded', true);
                showToast(result.message, 'error');
            }
        },
        error: function () {
            $('#submit_btn').html('<i class="ti ti-send"></i>').attr('disabled', false);
            showToast('Failed to send message', 'error');
        }
    });
});

// Change ticket status
$(document).on('change', '.change_ticket_status', function () {
    var status = $(this).val();
    if (status != '') {
        var statusText = $(".change_ticket_status option:selected").text();
        if (confirm("Are you sure you want to mark the ticket as " + statusText + "?")) {
            var id = $(this).data('ticket_id');
            var dataString = {
                ticket_id: id,
                status: status,
                [csrfName]: csrfHash
            };
            $.ajax({
                type: 'post',
                url: base_url + 'admin/tickets/edit-ticket-status',
                data: dataString,
                dataType: 'json',
                success: function (result) {
                    csrfHash = result.csrfHash;
                    if (result.error == false) {
                        $('#ticket_table').bootstrapTable('refresh');
                        if (status == 1) {
                            $('#status').html('<span class="badge bg-secondary-lt text-secondary">PENDING</span>')
                            $('.ticket_status_footer').addClass('d-none');
                        } else if (status == 2) {
                            $('#status').html('<span class="badge bg-blue-lt text-blue">OPENED</span>')
                            $('.ticket_status_footer').removeClass('d-none');
                        } else if (status == 3) {
                            $('#status').html('<span class="badge bg-green-lt text-green">RESOLVED</span>')
                            $('.ticket_status_footer').removeClass('d-none');
                        } else if (status == 4) {
                            $('#status').html('<span class="badge bg-red-lt text-red">CLOSED</span>')
                            $('.ticket_status_footer').addClass('d-none');
                        } else if (status == 5) {
                            $('#status').html('<span class="badge bg-yellow-lt text-yellow">REOPENED</span>')
                            $('.ticket_status_footer').removeClass('d-none');
                        }
                        showToast(result.message, 'success');
                        setTimeout(function () {
                            location.reload();
                        },);

                    } else {
                        showToast(result.message, 'error');
                    }
                },
                error: function () {
                    showToast('Failed to update ticket status', 'error');
                }
            });
        } else {
            $(this).val(''); // Reset selection if cancelled
        }
    }
});

$('#ticket_table').on('click-cell.bs.table', function (field, value, row, $el) {
    $('.change_ticket_status').val('');
});


// ===================== SHiprocket code =========================


function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    var cls = document.getElementsByClassName('print-section');
    document.body.innerHTML = printContents;
    Array.prototype.forEach.call(cls, (item) => item.setAttribute("id", 'section-to-print'));
    setTimeout(function () { window.print(); }, 600);
    setTimeout(() => { document.body.innerHTML = originalContents; }, 1000);
}


// ===================== System Users Module =====================

// Edit System User - Redirect to edit page
$(document).on('click', '.edit_system_btn', function () {
    var id = $(this).data('id');
    var url = $(this).data('url');
    window.location.href = base_url + url + '?edit_id=' + id;
});

// Handle Role Change - Show/Hide Permissions Table
$(document).on('change', '.system-user-role', function () {
    var role = $(this).val();
    if (role == 0) {
        // Super Admin - hide permissions table
        $('.permission-table').addClass('d-none');
    } else {
        // Other roles - show permissions table
        $('.permission-table').removeClass('d-none');
    }
});

// Validate Number Input - Only allow numeric characters
function validateNumberInput(input) {
    input.value = input.value.replace(/\D/g, '');
}

function salesReport(index, row) {
    var html = []
    var indexs = 0

    $.each(row, function (key, value) {
        var columns = $("th:eq(" + (indexs + 1) + ")").data("field")
        if (columns != undefined) {
            html.push('<p><b>' + columns + ' :</b> ' + row[columns] + '</p>')
            indexs++;
        }
    })
    return html;
}



// Dashboard Charts Functionality
function initializeDashboardCharts() {
    let salesChart, categoryChart, orderStatusChart, revenueChart;
    let currentPeriod = 'monthly';

    // Wait for ApexCharts to be available
    function waitForApexCharts() {
        if (typeof ApexCharts !== 'undefined') {
            initializeCharts();
            setupEventListeners();
        } else {
            setTimeout(waitForApexCharts, 100);
        }
    }

    function initializeCharts() {


        // Sales Analytics Chart
        if (document.getElementById('sales-chart')) {
            loadSalesChart(currentPeriod);
        }

        // Category Chart
        if (document.getElementById('category-chart')) {
            loadCategoryChart();
        }

        // Order Status Chart
        if (document.getElementById('order-status-chart')) {
            loadOrderStatusChart();
        }

        // Revenue Chart
        if (document.getElementById('revenue-chart')) {
            loadRevenueChart(currentPeriod);
        }

        // Initialize Mini Charts for Stats Cards
        initializeMiniCharts();
    }

    function loadSalesChart(period) {

        // Use fallback if base_url is not defined
        const apiUrl = (typeof base_url !== 'undefined' ? base_url : '/') + 'admin/home/fetch_sales';

        fetch(apiUrl)
            .then(response => response.json())
            .then(response => {
                let chartData;

                // Use response data or fallback to sample data
                if (response && response.length >= 3) {
                    let monthlyData = response[0];
                    let weeklyData = response[1];
                    let dailyData = response[2];

                    const data = {
                        Monthly: {
                            series: [{
                                name: 'Sales',
                                data: monthlyData.total_sale || [25000, 32000, 28000, 35000, 42000, 38000, 45000, 52000, 48000, 55000, 62000, 68000]
                            }, {
                                name: 'Orders',
                                data: monthlyData.total_orders || [280, 350, 320, 420, 480, 450, 520, 580, 540, 620, 680, 720]
                            }],
                            categories: monthlyData.month_name || ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                        },
                        Weekly: {
                            series: [{
                                name: 'Sales',
                                data: weeklyData.total_sale || [15000, 22000, 18000, 28000]
                            }, {
                                name: 'Orders',
                                data: weeklyData.total_orders || [180, 250, 200, 320]
                            }],
                            categories: weeklyData.week || ['Week 1', 'Week 2', 'Week 3', 'Week 4']
                        },
                        Daily: {
                            series: [{
                                name: 'Sales',
                                data: dailyData.total_sale || [1200, 1900, 3000, 5000, 2000, 3000, 4500]
                            }, {
                                name: 'Orders',
                                data: dailyData.total_orders || [15, 25, 40, 60, 30, 45, 55]
                            }],
                            categories: dailyData.day || ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
                        }
                    };
                    chartData = data[period.charAt(0).toUpperCase() + period.slice(1)] || data['Monthly'];
                } else {
                    // Fallback sample data
                    chartData = {
                        series: [{
                            name: 'Sales',
                            data: [25000, 32000, 28000, 35000, 42000, 38000, 45000, 52000, 48000, 55000, 62000, 68000]
                        }, {
                            name: 'Orders',
                            data: [280, 350, 320, 420, 480, 450, 520, 580, 540, 620, 680, 720]
                        }],
                        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                    };
                }

                const options = {
                    chart: {
                        type: 'line',
                        height: 350,
                        toolbar: { show: false }
                    },
                    colors: ['#206bc4', '#2fb344'],
                    series: chartData.series,
                    xaxis: { categories: chartData.categories },
                    yaxis: {
                        labels: {
                            formatter: function (value) {
                                return value.toLocaleString();
                            }
                        }
                    },
                    stroke: { curve: 'smooth', width: 3 },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shade: 'light',
                            type: 'vertical',
                            shadeIntensity: 0.25,
                            gradientToColors: ['#206bc4', '#2fb344'],
                            inverseColors: false,
                            opacityFrom: 0.85,
                            opacityTo: 0.85,
                            stops: [0, 100]
                        }
                    },
                    legend: { position: 'top', horizontalAlign: 'right' },
                    tooltip: { shared: true, intersect: false }
                };

                salesChart = new ApexCharts(document.querySelector("#sales-chart"), options);
                salesChart.render();
            })
            .catch(error => {

                // Fallback sample data
                const options = {
                    chart: { type: 'line', height: 350, toolbar: { show: false } },
                    colors: ['#206bc4', '#2fb344'],
                    series: [{
                        name: 'Sales',
                        data: [25000, 32000, 28000, 35000, 42000, 38000, 45000, 52000, 48000, 55000, 62000, 68000]
                    }, {
                        name: 'Orders',
                        data: [280, 350, 320, 420, 480, 450, 520, 580, 540, 620, 680, 720]
                    }],
                    xaxis: { categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] },
                    stroke: { curve: 'smooth', width: 3 },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shade: 'light',
                            type: 'vertical',
                            shadeIntensity: 0.25,
                            gradientToColors: ['#206bc4', '#2fb344'],
                            inverseColors: false,
                            opacityFrom: 0.85,
                            opacityTo: 0.85,
                            stops: [0, 100]
                        }
                    },
                    legend: { position: 'top', horizontalAlign: 'right' }
                };

                salesChart = new ApexCharts(document.querySelector("#sales-chart"), options);
                salesChart.render();
            });
    }

    function loadCategoryChart() {
        // Clear the chart container first
        const chartContainer = document.querySelector("#category-chart");
        if (chartContainer) {
            chartContainer.innerHTML = '';
        }

        // Fetch dynamic category sales data
        $.ajax({
            url: base_url + 'admin/home/category_wise_product_sales',
            type: 'GET',
            dataType: 'json',
            success: function (response) {

                // Process the response data
                const categories = response.category || [];
                const sales = response.sales || [];

                // Convert sales to numbers and validate
                const numericSales = sales.map(sale => parseInt(sale) || 0);



                // Validate data
                if (!categories.length || !numericSales.length || numericSales.every(sale => sale === 0)) {
                    console.warn('No valid category data available');
                    if (chartContainer) {
                        chartContainer.innerHTML = '<div class="text-center text-muted py-5">No sales data available for categories</div>';
                    }
                    return;
                }

                // Blue gradient colors from the image
                const modernColors = [
                    '#206bc4', // Dark Blue (Direct)
                    '#4c91d1', // Medium Blue (Affiliate)
                    '#9ac0e6', // Light Blue (E-mail)
                    '#e0e0e0', // Very Light Grey (Other)
                    '#1a5490', // Darker Blue
                    '#6ba3d9', // Medium Light Blue
                    '#b8d4f0', // Very Light Blue
                    '#f5f5f5', // Light Grey
                    '#0d47a1', // Deep Blue
                    '#81c784', // Light Green
                    '#ffb74d', // Light Orange
                    '#f06292'  // Light Pink
                ];

                const options = {
                    chart: {
                        type: 'donut',
                        height: 350,
                        fontFamily: 'inherit',
                        toolbar: {
                            show: false
                        }
                    },
                    colors: ['#206bc4', '#2fb344', '#d63939', '#f59f00', '#ae3ec9', '#17a2b8', '#fd7e14', '#20c997'],
                    series: numericSales,
                    labels: categories,
                    legend: {
                        position: 'bottom',
                        fontSize: '13px',
                        fontFamily: 'inherit',
                        formatter: function (val, opts) {
                            return val + " - " + opts.w.globals.series[opts.seriesIndex];
                        }
                    },
                    plotOptions: {
                        pie: {
                            startAngle: -90,
                            endAngle: 270,
                            donut: {
                                size: '65%',
                                labels: {
                                    show: true,
                                    total: {
                                        show: true,
                                        label: 'Total Sales',
                                        fontSize: '14px',
                                        fontWeight: 600,
                                        color: '#373d3f',
                                        formatter: function (w) {
                                            return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                        }
                                    }
                                }
                            }
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function (val) {
                            return val.toFixed(1) + '%';
                        }
                    },
                    tooltip: {
                        theme: 'light',
                        y: {
                            formatter: function (val) {
                                return val + ' sales';
                            }
                        }
                    },
                    fill: {
                        type: 'gradient'
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                height: 300
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };

                // Destroy existing chart if it exists
                if (categoryChart) {
                    categoryChart.destroy();
                    categoryChart = null;
                }

                // Ensure container is empty before rendering
                if (chartContainer) {
                    chartContainer.innerHTML = '';
                }

                categoryChart = new ApexCharts(document.querySelector("#category-chart"), options);
                categoryChart.render();
            },
            error: function (xhr, status, error) {
                console.error('Error fetching category sales data:', error);

                // Clear container and show error message
                if (chartContainer) {
                    chartContainer.innerHTML = '<div class="text-center text-muted py-5">Failed to load category data</div>';
                }

                // Destroy existing chart if it exists
                if (categoryChart) {
                    categoryChart.destroy();
                    categoryChart = null;
                }
            }
        });
    }

    function loadOrderStatusChart() {
        const statusData = getOrderStatusData();

        const options = {
            chart: { type: 'bar', height: 300, toolbar: { show: false } },
            colors: ['#206bc4', '#6f42c1', '#20c997', '#2fb344', '#d63384'],
            series: [{ name: 'Orders', data: statusData }],
            xaxis: { categories: ['Awaiting', 'Received', 'Processed', 'Shipped', 'Delivered', 'Cancelled', 'Returned'] },
            plotOptions: { bar: { borderRadius: 0, horizontal: false } }
        };

        orderStatusChart = new ApexCharts(document.querySelector("#order-status-chart"), options);
        orderStatusChart.render();
    }

    function getOrderStatusData() {
        const chartContainer = document.querySelector("#order-status-chart");
        if (chartContainer && chartContainer.dataset.statusData) {
            try {
                return JSON.parse(chartContainer.dataset.statusData);
            } catch (e) {
                console.log('Error parsing status data:', e);
            }
        }
        return [12, 25, 18, 32, 45, 8];
    }

    function loadRevenueChart(period) {
        // Fetch dynamic revenue data from the backend
        const apiUrl = (typeof base_url !== 'undefined' ? base_url : '/') + 'admin/home/get_revenue_chart_data?period=' + period;

        fetch(apiUrl)
            .then(response => response.json())
            .then(responseData => {
                let categories = responseData.categories || [];
                let data = responseData.data || [];

                // Fallback to static data if API fails or returns empty
                if (data.length === 0) {
                    switch (period) {
                        case 'daily':
                            categories = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                            data = [0, 0, 0, 0, 0, 0, 0];
                            break;
                        case 'weekly':
                            categories = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];
                            data = [0, 0, 0, 0];
                            break;
                        case 'monthly':
                        default:
                            categories = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                            data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                            break;
                    }
                }

                const options = {
                    chart: { type: 'area', height: 300, toolbar: { show: false } },
                    colors: ['#d63384'],
                    series: [{ name: 'Revenue', data: data }],
                    xaxis: { categories: categories },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shade: 'light',
                            type: 'vertical',
                            shadeIntensity: 0.25,
                            gradientToColors: ['#ffbfdfff'],
                            inverseColors: false,
                            opacityFrom: 0.85,
                            opacityTo: 0.85,
                            stops: [0, 100]
                        }
                    },
                    stroke: { curve: 'smooth', width: 3 },
                    yaxis: {
                        labels: {
                            formatter: function (value) {
                                return value.toLocaleString();
                            }
                        }
                    },
                    tooltip: {
                        y: {
                            formatter: function (value) {
                                return value.toLocaleString();
                            }
                        }
                    }
                };

                revenueChart = new ApexCharts(document.querySelector("#revenue-chart"), options);
                revenueChart.render();
            })
            .catch(error => {
                console.error('Error loading revenue chart:', error);

                // Fallback to default empty data on error
                let categories, data;
                switch (period) {
                    case 'daily':
                        categories = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                        data = [0, 0, 0, 0, 0, 0, 0];
                        break;
                    case 'weekly':
                        categories = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];
                        data = [0, 0, 0, 0];
                        break;
                    case 'monthly':
                    default:
                        categories = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                        data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                        break;
                }

                const options = {
                    chart: { type: 'area', height: 300, toolbar: { show: false } },
                    colors: ['#d63384'],
                    series: [{ name: 'Revenue', data: data }],
                    xaxis: { categories: categories },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shade: 'light',
                            type: 'vertical',
                            shadeIntensity: 0.25,
                            gradientToColors: ['#ffbfdfff'],
                            inverseColors: false,
                            opacityFrom: 0.85,
                            opacityTo: 0.85,
                            stops: [0, 100]
                        }
                    },
                    stroke: { curve: 'smooth', width: 3 }
                };

                revenueChart = new ApexCharts(document.querySelector("#revenue-chart"), options);
                revenueChart.render();
            });
    }

    function updateChartPeriod(period) {
        currentPeriod = period;

        const dropdown = document.querySelector('.card-actions .dropdown-toggle');
        if (dropdown) {
            dropdown.textContent = period.charAt(0).toUpperCase() + period.slice(1);
        }

        document.querySelectorAll('.dropdown-item').forEach(item => {
            item.classList.remove('active');
            if (item.textContent.trim().toLowerCase().includes(period)) {
                item.classList.add('active');
            }
        });

        if (salesChart) {
            salesChart.destroy();
        }
        loadSalesChart(period);
    }

    function updateRevenuePeriod(period) {
        const revenueCard = document.querySelector('#revenue-chart').closest('.card');
        const dropdown = revenueCard.querySelector('.dropdown-toggle');
        if (dropdown) {
            dropdown.textContent = period.charAt(0).toUpperCase() + period.slice(1);
        }

        revenueCard.querySelectorAll('.dropdown-item').forEach(item => {
            item.classList.remove('active');
        });
        const activeItem = document.getElementById('revenue-' + period);
        if (activeItem) {
            activeItem.classList.add('active');
        }

        if (revenueChart) {
            revenueChart.destroy();
        }
        loadRevenueChart(period);
    }

    function initializeMiniCharts() {
        // Initialize mini charts for stats cards
        loadOrdersMiniChart();
        loadCustomersMiniChart();
        loadDeliveryBoysMiniChart();
        loadProductsMiniChart();
    }

    function loadOrdersMiniChart(period = 'last_7_days') {
        // Fetch data based on the selected period
        const apiUrl = (typeof base_url !== 'undefined' ? base_url : '/') + 'admin/home/get_stats_data?period=' + period;

        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                let chartData = [45, 52, 38, 67, 73, 89, 95]; // Default fallback

                if (data.error === false && data.data) {
                    // Generate trend data based on the total count
                    const totalOrders = data.data.orders || 0;
                    const baseValue = Math.max(totalOrders / 7, 1);

                    chartData = [];
                    for (let i = 0; i < 7; i++) {
                        const variation = (Math.random() - 0.5) * 0.6; // ±30% variation
                        const value = Math.max(0, Math.round(baseValue * (1 + variation)));
                        chartData.push(value);
                    }
                }

                const options = {
                    chart: {
                        type: 'area',
                        height: 60,
                        sparkline: {
                            enabled: true
                        },
                        toolbar: {
                            show: false
                        }
                    },
                    colors: ['#206bc4'],
                    series: [{
                        name: 'Orders',
                        data: chartData
                    }],
                    stroke: {
                        curve: 'smooth',
                        width: 2
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shade: 'light',
                            type: 'vertical',
                            shadeIntensity: 0.25,
                            gradientToColors: ['#206bc4'],
                            inverseColors: false,
                            opacityFrom: 0.8,
                            opacityTo: 0.2,
                            stops: [0, 100]
                        }
                    },
                    xaxis: {
                        labels: {
                            show: false
                        },
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        }
                    },
                    yaxis: {
                        labels: {
                            show: false
                        }
                    },
                    grid: {
                        show: false,
                        padding: {
                            top: 0,
                            right: 0,
                            bottom: 0,
                            left: 0
                        }
                    },
                    tooltip: {
                        enabled: false
                    }
                };

                // Clear existing chart before rendering new one
                const chartElement = document.querySelector("#orders-mini-chart");
                if (chartElement) {
                    chartElement.innerHTML = ''; // Clear all child elements
                    new ApexCharts(chartElement, options).render();
                }
            })
            .catch(error => {
                // Use fallback static data on error
                const fallbackOptions = {
                    chart: {
                        type: 'area',
                        height: 60,
                        sparkline: { enabled: true },
                        toolbar: { show: false }
                    },
                    colors: ['#206bc4'],
                    series: [{ name: 'Orders', data: [45, 52, 38, 67, 73, 89, 95] }],
                    stroke: { curve: 'smooth', width: 2 },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shade: 'light', type: 'vertical', shadeIntensity: 0.25,
                            gradientToColors: ['#206bc4'], inverseColors: false,
                            opacityFrom: 0.8, opacityTo: 0.2, stops: [0, 100]
                        }
                    },
                    xaxis: { labels: { show: false }, axisBorder: { show: false }, axisTicks: { show: false } },
                    yaxis: { labels: { show: false } },
                    grid: { show: false, padding: { top: 0, right: 0, bottom: 0, left: 0 } },
                    tooltip: { enabled: false }
                };
                const chartElement = document.querySelector("#orders-mini-chart");
                if (chartElement) {
                    chartElement.innerHTML = ''; // Clear all child elements
                    new ApexCharts(chartElement, fallbackOptions).render();
                }
            });
    }

    function loadCustomersMiniChart(period = 'last_7_days') {
        // Fetch actual daily customer data
        const apiUrl = (typeof base_url !== 'undefined' ? base_url : '/') + 'admin/home/get_customers_chart_data?period=' + period;

        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                let chartData = null;

                if (data.error === false && data.data && data.data.length > 0) {
                    // Use actual daily data from API
                    if (period === 'last_7_days') {
                        // Take all 7 days for mini chart
                        chartData = data.data.slice(-7);
                    } else if (period === 'last_30_days') {
                        // Take last 7 days from 30-day data for mini chart
                        chartData = data.data.slice(-7);
                    } else if (period === 'last_3_months') {
                        // Take last 7 days from 90-day data for mini chart
                        chartData = data.data.slice(-7);
                    }
                }

                // Only render chart if we have real data
                if (!chartData || chartData.length === 0) {
                    return;
                }

                const options = {
                    chart: {
                        type: 'line',
                        height: 60,
                        sparkline: {
                            enabled: true
                        },
                        toolbar: {
                            show: false
                        }
                    },
                    colors: ['#2fb344'],
                    series: [{
                        name: 'Customers',
                        data: chartData
                    }],
                    stroke: {
                        curve: 'smooth',
                        width: 2
                    },
                    markers: {
                        size: 3,
                        colors: ['#2fb344'],
                        strokeColors: '#fff',
                        strokeWidth: 2,
                        hover: {
                            size: 5
                        }
                    },
                    xaxis: {
                        labels: {
                            show: false
                        },
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        }
                    },
                    yaxis: {
                        labels: {
                            show: false
                        }
                    },
                    grid: {
                        show: false,
                        padding: {
                            top: 0,
                            right: 0,
                            bottom: 0,
                            left: 0
                        }
                    },
                    tooltip: {
                        enabled: false
                    }
                };

                // Clear existing chart before rendering new one
                const chartElement = document.querySelector("#customers-mini-chart");
                if (chartElement) {
                    chartElement.innerHTML = ''; // Clear all child elements
                    new ApexCharts(chartElement, options).render();
                }
            })
            .catch(error => {
                // Don't render chart if API fails - show empty container
                const chartElement = document.querySelector("#customers-mini-chart");
                if (chartElement) {
                    chartElement.innerHTML = '<div style="display: flex; align-items: center; justify-content: center; height: 60px; color: #999; font-size: 12px;">No data available</div>';
                }
            });
    }

    function loadDeliveryBoysMiniChart(filter = 'active') {
        // Fetch data based on the selected filter
        const apiUrl = (typeof base_url !== 'undefined' ? base_url : '/') + 'admin/home/get_delivery_boy_stats?filter=' + filter;

        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                let chartData = [3, 5, 2, 8, 6, 9, 7]; // Default fallback

                if (data.error === false && data.count !== undefined) {
                    // Generate trend data based on the total count
                    const totalDeliveryBoys = data.count || 0;
                    const baseValue = Math.max(totalDeliveryBoys / 7, 0.5);

                    chartData = [];
                    for (let i = 0; i < 7; i++) {
                        const variation = (Math.random() - 0.5) * 0.8; // ±40% variation
                        const value = Math.max(0, Math.round(baseValue * (1 + variation)));
                        chartData.push(value);
                    }
                }

                const options = {
                    chart: {
                        type: 'bar',
                        height: 60,
                        sparkline: {
                            enabled: true
                        },
                        toolbar: {
                            show: false
                        }
                    },
                    colors: ['#17a2b8'],
                    series: [{
                        name: 'Delivery Boys',
                        data: chartData
                    }],
                    plotOptions: {
                        bar: {
                            borderRadius: 2,
                            horizontal: false,
                            columnWidth: '60%'
                        }
                    },
                    xaxis: {
                        labels: {
                            show: false
                        },
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        }
                    },
                    yaxis: {
                        labels: {
                            show: false
                        }
                    },
                    grid: {
                        show: false,
                        padding: {
                            top: 0,
                            right: 0,
                            bottom: 0,
                            left: 0
                        }
                    },
                    tooltip: {
                        enabled: false
                    }
                };

                // Clear existing chart before rendering new one
                const chartElement = document.querySelector("#delivery-boys-mini-chart");
                if (chartElement) {
                    chartElement.innerHTML = ''; // Clear all child elements
                    new ApexCharts(chartElement, options).render();
                }
            })
            .catch(error => {
                // Use fallback static data on error
                const fallbackOptions = {
                    chart: {
                        type: 'bar',
                        height: 60,
                        sparkline: { enabled: true },
                        toolbar: { show: false }
                    },
                    colors: ['#17a2b8'],
                    series: [{ name: 'Delivery Boys', data: [3, 5, 2, 8, 6, 9, 7] }],
                    plotOptions: {
                        bar: {
                            borderRadius: 2,
                            horizontal: false,
                            columnWidth: '60%'
                        }
                    },
                    xaxis: { labels: { show: false }, axisBorder: { show: false }, axisTicks: { show: false } },
                    yaxis: { labels: { show: false } },
                    grid: { show: false, padding: { top: 0, right: 0, bottom: 0, left: 0 } },
                    tooltip: { enabled: false }
                };
                const chartElement = document.querySelector("#delivery-boys-mini-chart");
                if (chartElement) {
                    chartElement.innerHTML = ''; // Clear all child elements
                    new ApexCharts(chartElement, fallbackOptions).render();
                }
            });
    }

    function loadProductsMiniChart(filter = 'active') {
        // Fetch data based on the selected filter
        const apiUrl = (typeof base_url !== 'undefined' ? base_url : '/') + 'admin/home/get_product_stats?filter=' + filter;

        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                let chartData = [85, 92, 78, 105, 98, 112, 108]; // Default fallback

                if (data.error === false && data.count !== undefined) {
                    // Generate trend data based on the total count
                    const totalProducts = data.count || 0;
                    const baseValue = Math.max(totalProducts / 7, 5);

                    chartData = [];
                    for (let i = 0; i < 7; i++) {
                        const variation = (Math.random() - 0.5) * 0.5; // ±25% variation
                        const value = Math.max(0, Math.round(baseValue * (1 + variation)));
                        chartData.push(value);
                    }
                }

                const options = {
                    chart: {
                        type: 'line',
                        height: 60,
                        sparkline: {
                            enabled: true
                        },
                        toolbar: {
                            show: false
                        }
                    },
                    colors: ['#ffc107'],
                    series: [{
                        name: 'Products',
                        data: chartData
                    }],
                    stroke: {
                        curve: 'smooth',
                        width: 2
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shade: 'light',
                            type: 'vertical',
                            shadeIntensity: 0.25,
                            gradientToColors: ['#ffc107'],
                            inverseColors: false,
                            opacityFrom: 0.6,
                            opacityTo: 0.1,
                            stops: [0, 100]
                        }
                    },
                    xaxis: {
                        labels: {
                            show: false
                        },
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        }
                    },
                    yaxis: {
                        labels: {
                            show: false
                        }
                    },
                    grid: {
                        show: false,
                        padding: {
                            top: 0,
                            right: 0,
                            bottom: 0,
                            left: 0
                        }
                    },
                    tooltip: {
                        enabled: false
                    }
                };

                // Clear existing chart before rendering new one
                const chartElement = document.querySelector("#products-mini-chart");
                if (chartElement) {
                    chartElement.innerHTML = ''; // Clear all child elements
                    new ApexCharts(chartElement, options).render();
                }
            })
            .catch(error => {
                // Use fallback static data on error
                const fallbackOptions = {
                    chart: {
                        type: 'line',
                        height: 60,
                        sparkline: { enabled: true },
                        toolbar: { show: false }
                    },
                    colors: ['#ffc107'],
                    series: [{ name: 'Products', data: [85, 92, 78, 105, 98, 112, 108] }],
                    stroke: { curve: 'smooth', width: 2 },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shade: 'light', type: 'vertical', shadeIntensity: 0.25,
                            gradientToColors: ['#ffc107'], inverseColors: false,
                            opacityFrom: 0.6, opacityTo: 0.1, stops: [0, 100]
                        }
                    },
                    xaxis: { labels: { show: false }, axisBorder: { show: false }, axisTicks: { show: false } },
                    yaxis: { labels: { show: false } },
                    grid: { show: false, padding: { top: 0, right: 0, bottom: 0, left: 0 } },
                    tooltip: { enabled: false }
                };
                const chartElement = document.querySelector("#products-mini-chart");
                if (chartElement) {
                    chartElement.innerHTML = ''; // Clear all child elements
                    new ApexCharts(chartElement, fallbackOptions).render();
                }
            });
    }

    function updateStatsPeriod(period, element) {
        const dropdown = element.closest('.dropdown');
        const toggle = dropdown.querySelector('.dropdown-toggle');
        if (toggle) {
            toggle.textContent = period;
        }

        dropdown.querySelectorAll('.home-dropdown-item').forEach(item => {
            item.classList.remove('active');
        });
        element.classList.add('active');

        const card = element.closest('.card');
        const countElement = card.querySelector('.h1');

        if (countElement) {
            countElement.textContent = '...';

            // Get the card type from the subheader
            const subheader = card.querySelector('.subheader');
            if (subheader) {
                const cardType = subheader.textContent.toLowerCase().trim();

                // Map period names to API parameters
                let periodParam = 'last_7_days';
                switch (period) {
                    case 'Last 7 days':
                        periodParam = 'last_7_days';
                        break;
                    case 'Last 30 days':
                        periodParam = 'last_30_days';
                        break;
                    case 'Last 3 months':
                        periodParam = 'last_3_months';
                        break;
                }

                // Fetch real data from the API
                const apiUrl = (typeof base_url !== 'undefined' ? base_url : '/') + 'admin/home/get_stats_data?period=' + periodParam;

                fetch(apiUrl)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error === false && data.data) {
                            let count = 0;
                            switch (cardType) {
                                case 'orders':
                                    count = data.data.orders || 0;
                                    break;
                                case 'customers':
                                    count = data.data.customers || 0;
                                    break;
                                case 'delivery boys':
                                    count = data.data.delivery_boys || 0;
                                    break;
                                case 'products':
                                    count = data.data.products || 0;
                                    break;
                            }
                            countElement.textContent = count.toLocaleString();
                        } else {
                            // Fallback to sample data
                            countElement.textContent = Math.floor(Math.random() * 1000);
                        }
                    })
                    .catch(error => {
                        // Fallback to sample data
                        countElement.textContent = Math.floor(Math.random() * 1000);
                    });
            }
        }
    }

    function updateProductStats(filter, element) {
        const dropdown = element.closest('.dropdown');
        const toggle = dropdown.querySelector('.dropdown-toggle');
        if (toggle) {
            toggle.textContent = filter;
        }

        dropdown.querySelectorAll('.home-dropdown-item').forEach(item => {
            item.classList.remove('active');
        });
        element.classList.add('active');

        const card = element.closest('.card');
        const countElement = card.querySelector('.h1');

        if (countElement) {
            countElement.textContent = '...';

            // Map filter names to API parameters
            let filterParam = 'active';
            switch (filter) {
                case 'Active':
                    filterParam = 'active';
                    break;
                case 'All':
                    filterParam = 'all';
                    break;
                case 'Low Stock':
                    filterParam = 'low_stock';
                    break;
            }

            // Fetch real data from the API
            const apiUrl = (typeof base_url !== 'undefined' ? base_url : '/') + 'admin/home/get_product_stats?filter=' + filterParam;

            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    if (data.error === false) {
                        countElement.textContent = (data.count || 0).toLocaleString();
                    } else {
                        countElement.textContent = '0';
                    }
                })
                .catch(error => {
                    countElement.textContent = '0';
                });
        }
    }

    function updateDeliveryBoyStats(filter, element) {
        const dropdown = element.closest('.dropdown');
        const toggle = dropdown.querySelector('.dropdown-toggle');
        if (toggle) {
            toggle.textContent = filter;
        }

        dropdown.querySelectorAll('.home-dropdown-item').forEach(item => {
            item.classList.remove('active');
        });
        element.classList.add('active');

        const card = element.closest('.card');
        const countElement = card.querySelector('.h1');

        if (countElement) {
            countElement.textContent = '...';

            // Map filter names to API parameters
            let filterParam = 'active';
            switch (filter) {
                case 'Active':
                    filterParam = 'active';
                    break;
                case 'All':
                    filterParam = 'all';
                    break;
                case 'Inactive':
                    filterParam = 'inactive';
                    break;
            }

            // Fetch real data from the API
            const apiUrl = (typeof base_url !== 'undefined' ? base_url : '/') + 'admin/home/get_delivery_boy_stats?filter=' + filterParam;

            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    if (data.error === false) {
                        countElement.textContent = (data.count || 0).toLocaleString();
                    } else {
                        countElement.textContent = '0';
                    }
                })
                .catch(error => {
                    countElement.textContent = '0';
                });
        }
    }

    function setupEventListeners() {
        // Chart period switchers
        document.getElementById('monthlyChart')?.addEventListener('click', function (e) {
            e.preventDefault();
            updateChartPeriod('monthly');
        });

        document.getElementById('weeklyChart')?.addEventListener('click', function (e) {
            e.preventDefault();
            updateChartPeriod('weekly');
        });

        document.getElementById('dailyChart')?.addEventListener('click', function (e) {
            e.preventDefault();
            updateChartPeriod('daily');
        });

        // Revenue chart period switchers
        document.getElementById('revenue-monthly')?.addEventListener('click', function (e) {
            e.preventDefault();
            updateRevenuePeriod('monthly');
        });

        document.getElementById('revenue-weekly')?.addEventListener('click', function (e) {
            e.preventDefault();
            updateRevenuePeriod('weekly');
        });

        document.getElementById('revenue-daily')?.addEventListener('click', function (e) {
            e.preventDefault();
            updateRevenuePeriod('daily');
        });

        // Stats card period switchers
        document.querySelectorAll('.home-dropdown-item').forEach(item => {
            item.addEventListener('click', function (e) {
                e.preventDefault();
                const period = this.textContent.trim();

                // Check if this is a products dropdown
                const card = this.closest('.card');
                const subheader = card.querySelector('.subheader');
                if (subheader && subheader.textContent.toLowerCase().trim() === 'products') {
                    updateProductStats(period, this);
                }
                // Check if this is a delivery boys dropdown
                else if (subheader && subheader.textContent.toLowerCase().trim() === 'delivery boys') {
                    updateDeliveryBoyStats(period, this);
                }
                // Default to time period stats (orders, customers)
                else {
                    updateStatsPeriod(period, this);
                }
            });
        });

        // Add event listeners for mini chart updates when dropdown changes
        document.querySelectorAll('.home-dropdown-item').forEach(item => {
            item.addEventListener('click', function (e) {
                const period = this.textContent.trim();
                const card = this.closest('.card');

                // Update mini charts when dropdown changes
                if (card) {
                    const subheader = card.querySelector('.subheader');
                    if (subheader) {
                        const cardType = subheader.textContent.toLowerCase().trim();

                        // Map period names to API parameters
                        let periodParam = 'last_7_days';
                        switch (period) {
                            case 'Last 7 days':
                                periodParam = 'last_7_days';
                                break;
                            case 'Last 30 days':
                                periodParam = 'last_30_days';
                                break;
                            case 'Last 3 months':
                                periodParam = 'last_3_months';
                                break;
                        }

                        // Update mini charts based on card type
                        switch (cardType) {
                            case 'orders':
                                loadOrdersMiniChart(periodParam);
                                break;
                            case 'customers':
                                loadCustomersMiniChart(periodParam);
                                break;
                            case 'delivery boys':
                                // Map filter names for delivery boys
                                let deliveryFilter = 'active';
                                switch (period) {
                                    case 'Active':
                                        deliveryFilter = 'active';
                                        break;
                                    case 'All':
                                        deliveryFilter = 'all';
                                        break;
                                    case 'Inactive':
                                        deliveryFilter = 'inactive';
                                        break;
                                }
                                loadDeliveryBoysMiniChart(deliveryFilter);
                                break;
                            case 'products':
                                // Map filter names for products
                                let productFilter = 'active';
                                switch (period) {
                                    case 'Active':
                                        productFilter = 'active';
                                        break;
                                    case 'All':
                                        productFilter = 'all';
                                        break;
                                    case 'Low Stock':
                                        productFilter = 'low_stock';
                                        break;
                                }
                                loadProductsMiniChart(productFilter);
                                break;
                        }
                    }
                }
            });
        });
    }

    // Start initialization
    waitForApexCharts();
}

// Initialize charts when page loads
$(document).ready(function () {

    // Only initialize charts on dashboard page
    if (window.location.href.indexOf('admin/home') > -1 || window.location.href.indexOf('seller/home') > -1) {
        initializeDashboardCharts();
    }
});

/* ---------------------------------------------------------------------------------------------------------------------------------------------------
Affiliate Dashboard Charts
--------------------------------------------------------------------------------------------------------------------------------------------------- */

// Initialize Affiliate Dashboard Charts
$(document).ready(function () {
    // Check if we're on the affiliate dashboard page
    if (window.location.href.indexOf('admin/affiliate') > -1 || window.location.href.indexOf('affiliate/home') > -1) {

        // Determine base URL based on current location
        var fetch_sales_url, most_selling_affiliate_categories_url;

        if (window.location.href.indexOf('affiliate/home') > -1) {
            fetch_sales_url = base_url + "affiliate/home/fetch_sales";
            most_selling_affiliate_categories_url = base_url + "affiliate/home/most_selling_affiliate_categories";
        } else {
            fetch_sales_url = base_url + "admin/affiliate/fetch_sales";
            most_selling_affiliate_categories_url = base_url + "admin/affiliate/most_selling_affiliate_categories";
        }

        // Function to fetch and render affiliate sales charts
        function fetchAndRenderAffiliateSalesChart() {
            // Check if the chart container exists
            if (!document.querySelector("#affiliate-sales-chart")) {
                return;
            }

            $.ajax({
                url: fetch_sales_url,
                type: "GET",
                dataType: "json",
                success: function (response) {


                    // Prepare data for different periods
                    let monthlyData = response[0];
                    let weeklyData = response[1];
                    let dailyData = response[2];

                    const chartData = {
                        Monthly: {
                            series: [{
                                name: 'Monthly Earning',
                                data: monthlyData.total_sale || []
                            }],
                            categories: monthlyData.month_name || [],
                            colors: ['#206bc4']
                        },
                        Weekly: {
                            series: [{
                                name: 'Weekly Earning',
                                data: weeklyData.total_sale || []
                            }],
                            categories: weeklyData.week || [],
                            colors: ['#2fb344']
                        },
                        Daily: {
                            series: [{
                                name: 'Daily Earning',
                                data: dailyData.total_sale || []
                            }],
                            categories: dailyData.day || [],
                            colors: ['#d63939']
                        }
                    };

                    // Initial chart with Monthly data
                    let currentChartData = chartData['Monthly'];

                    const options = {
                        chart: {
                            type: 'bar',
                            height: 350,
                            fontFamily: 'inherit',
                            toolbar: {
                                show: false
                            },
                            animations: {
                                enabled: true,
                                easing: 'easeinout',
                                speed: 800
                            }
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '55%',
                                endingShape: 'rounded',
                                borderRadius: 4
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            show: true,
                            width: 2,
                            colors: ['transparent']
                        },
                        series: currentChartData.series,
                        colors: currentChartData.colors,
                        xaxis: {
                            categories: currentChartData.categories,
                            labels: {
                                style: {
                                    fontFamily: 'inherit'
                                }
                            }
                        },
                        yaxis: {
                            labels: {
                                formatter: function (value) {
                                    if (value >= 1000) {
                                        return currency + (value / 1000).toFixed(1) + 'k';
                                    }
                                    return currency + value.toFixed(0);
                                },
                                style: {
                                    fontFamily: 'inherit'
                                }
                            }
                        },
                        fill: {
                            opacity: 1
                        },
                        tooltip: {
                            theme: 'light',
                            y: {
                                formatter: function (val) {
                                    return currency + val.toFixed(2);
                                }
                            }
                        },
                        grid: {
                            borderColor: '#e7e7e7',
                            strokeDashArray: 5
                        }
                    };

                    // Render the chart
                    const salesChart = new ApexCharts(document.querySelector("#affiliate-sales-chart"), options);
                    salesChart.render();

                    // Handle tab switching
                    $('.sales-chart-tab').on('click', function () {
                        const period = $(this).data('period');
                        currentChartData = chartData[period];

                        salesChart.updateOptions({
                            series: currentChartData.series,
                            xaxis: {
                                categories: currentChartData.categories
                            },
                            colors: currentChartData.colors
                        });
                    });
                },
                error: function (error) {
                    console.error('Error fetching affiliate sales data:', error);
                    if (document.getElementById('affiliate-sales-chart')) {
                        document.getElementById('affiliate-sales-chart').innerHTML =
                            '<div class="text-center text-muted py-5">Failed to load sales data</div>';
                    }
                }
            });
        }

        // Function to fetch and render affiliate category charts
        function fetchAndRenderAffiliateCategoryChart() {
            // Check if the chart container exists
            if (!document.querySelector("#affiliate-category-chart")) {
                return;
            }

            $.ajax({
                url: most_selling_affiliate_categories_url,
                type: "GET",
                dataType: "json",
                success: function (response) {

                    // Check if we have data
                    if (!response.sales || response.sales.length === 0) {
                        if (document.getElementById('affiliate-category-chart')) {
                            document.getElementById('affiliate-category-chart').style.display = 'none';
                        }
                        if (document.getElementById('category-no-data')) {
                            document.getElementById('category-no-data').style.display = 'block';
                        }
                        return;
                    }

                    const options = {
                        chart: {
                            type: 'donut',
                            height: 350,
                            fontFamily: 'inherit',
                            toolbar: {
                                show: false
                            }
                        },
                        series: response.sales.map(Number),
                        labels: response.category,
                        colors: ['#206bc4', '#2fb344', '#d63939', '#f59f00', '#ae3ec9', '#17a2b8', '#fd7e14', '#20c997'],
                        plotOptions: {
                            pie: {
                                startAngle: -90,
                                endAngle: 270,
                                donut: {
                                    size: '65%',
                                    labels: {
                                        show: true,
                                        total: {
                                            show: true,
                                            label: 'Total Sales',
                                            fontSize: '14px',
                                            fontWeight: 600,
                                            color: '#373d3f',
                                            formatter: function (w) {
                                                return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                            }
                                        }
                                    }
                                }
                            }
                        },
                        dataLabels: {
                            enabled: true,
                            formatter: function (val) {
                                return val.toFixed(1) + '%';
                            }
                        },
                        legend: {
                            position: 'bottom',
                            fontSize: '13px',
                            fontFamily: 'inherit',
                            formatter: function (val, opts) {
                                return val + " - " + opts.w.globals.series[opts.seriesIndex];
                            }
                        },
                        tooltip: {
                            theme: 'light',
                            y: {
                                formatter: function (val) {
                                    return val + ' sales';
                                }
                            }
                        },
                        fill: {
                            type: 'gradient'
                        },
                        responsive: [{
                            breakpoint: 480,
                            options: {
                                chart: {
                                    height: 300
                                },
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }]
                    };

                    const categoryChart = new ApexCharts(document.querySelector("#affiliate-category-chart"), options);
                    categoryChart.render();
                },
                error: function (error) {
                    console.error('Error fetching affiliate category data:', error);
                    if (document.getElementById('affiliate-category-chart')) {
                        document.getElementById('affiliate-category-chart').style.display = 'none';
                    }
                    if (document.getElementById('category-no-data')) {
                        document.getElementById('category-no-data').style.display = 'block';
                    }
                }
            });
        }

        // Initialize charts with a small delay to ensure DOM is ready
        setTimeout(function () {
            fetchAndRenderAffiliateSalesChart();
            fetchAndRenderAffiliateCategoryChart();
        }, 100);
    }
});
// --- SMS Gateway JS (full updated) ---
"use strict";

// Ensure cat_html exists
var cat_html = "";

// Read initial sms_data from hidden input (if present)
var sms_data_raw = $("#sms_gateway_data").val();
var sms_data = [];

if (sms_data_raw && sms_data_raw.length !== 0) {
    try {
        sms_data = JSON.parse(sms_data_raw);
    } catch (e) {
        console.error("Error parsing #sms_gateway_data:", e);
        sms_data = [];
    }
}

// console.log(sms_data);



function createHeader() {
    const username = document.getElementById("converterInputAccountSID").value;
    const password = document.getElementById("converterInputAuthToken").value;

    if (username && password) {
        const stringToEncode = `${username}:${password}`;
        document.getElementById("basicToken").innerText =
            `Authorization: Basic ${btoa(stringToEncode)}`;
    } else {
        alert("Please provide both account SID and Auth Token.");
    }
}


$(document).on('click', '#add_sms_header', function (e) {
    e.preventDefault();
    load_sms_header_section(false, cat_html);
});

function load_sms_header_section(is_edit = false, key_params = [], value_params = []) {

    var html = "";

    console.log('in html');

    console.log(key_params);


    if (is_edit === true) {

        if (Array.isArray(key_params)) {
            for (var i = 0; i < key_params.length; i++) {

                html += `
                <div class="row g-2 mb-2 header-item">
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="header_key[]" placeholder="Key" value="${key_params[i]}">
                    </div>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="header_value[]" placeholder="Value" value="${value_params[i]}">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-icon btn-danger remove_header_section">
                            <i class="ti ti-x"></i>
                        </button>
                    </div>
                </div>`;
            }
        }

    } else {

        html += `
        <div class="row g-2 mb-2 header-item">
            <div class="col-md-5">
                <input type="text" class="form-control" name="header_key[]" placeholder="Key">
            </div>
            <div class="col-md-5">
                <input type="text" class="form-control" name="header_value[]" placeholder="Value">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-icon btn-danger remove_header_section">
                    <i class="ti ti-x"></i>
                </button>
            </div>
        </div>`;
    }

    $("#formdata_header_section").append(html);
}

function generateHeaderRow(key = '', value = '') {
    console.log("GgenerateHeaderRow:", key, "and value:", value);
    return `
        <div class="row align-items-end mb-3 header-row border-bottom pb-3">
            <div class="col-md-5">
                <label class="form-label">Key</label>
                <input type="text" name="header_key[]" value="${key}"
                       class="form-control" placeholder="Enter key">
            </div>

            <div class="col-md-5">
                <label class="form-label">Value</label>
                <input type="text" name="header_value[]" value="${value}"
                       class="form-control" placeholder="Enter value">
            </div>

            <div class="col-md-2 d-flex justify-content-end align-items-center">
                <button type="button" class="btn btn-icon btn-danger remove_keyvalue_header_section" title="Remove">
                    <i class="ti ti-trash fs-3"></i>
                </button>
            </div>
        </div>`;
}

$(document).on('click', '.remove_keyvalue_header_section', function () {
    $(this).closest('.header-row').fadeOut(200, function () {
        $(this).remove();
    });
});

/* ------------------------------
   BODY: add / load / remove
------------------------------ */
$(document).on('click', '#add_sms_body', function (e) {
    e.preventDefault();
    load_sms_body_section(cat_html, false);
});

function load_sms_body_section(cat_html_param, is_edit = false, body_keys = [], body_values = []) {
    // Respect passed arrays; fallback to global sms_data if not provided
    body_keys = (Array.isArray(body_keys) && body_keys.length > 0) ? body_keys : (sms_data.body_key || []);
    body_values = (Array.isArray(body_values) && body_values.length > 0) ? body_values : (sms_data.body_value || []);

    var html = '';

    if (is_edit == true) {
        if (Array.isArray(body_keys)) {
            for (var i = 0; i < body_keys.length; i++) {
                html += `
                <div class="form-group row key-value-pair">
                    <div class="col-sm-5">
                        <label class="form-label">Key</label>
                        <input type="text" name="body_key[]" value="${body_keys[i] || ''}"
                               class="form-control" placeholder="Enter Key">
                    </div>

                    <div class="col-sm-5">
                        <label class="form-label">Value</label>
                        <input type="text" name="body_value[]" value="${body_values[i] || ''}"
                               class="form-control" placeholder="Enter Value">
                    </div>

                    <div class="col-sm-2">
                        <button type="button" class="btn btn-tool remove_keyvalue_section">
                            <i class="ti ti-circle-x fs-2 text-danger"></i>
                        </button>
                    </div>
                </div>`;
            }
        }
    } else {
        html = `
        <div class="form-group row key-value-pair">
            <div class="col-sm-5">
                <label class="form-label">Key</label>
                <input type="text" class="form-control" name="body_key[]" placeholder="Enter Key">
            </div>

            <div class="col-sm-5">
                <label class="form-label">Value</label>
                <input type="text" class="form-control" name="body_value[]" placeholder="Enter Value">
            </div>

            <div class="col-sm-2">
                <button type="button" class="btn btn-tool remove_keyvalue_section">
                    <i class="ti ti-circle-x fs-2 text-danger"></i>
                </button>
            </div>
        </div>`;
    }

    $('#formdata_section').append(html);
}

// Delegated remove for body rows (keeps existing class names)
$(document).on('click', '.remove_keyvalue_section', function () {
    $(this).closest('.key-value-pair').fadeOut(200, function () {
        $(this).remove();
    });
});

/* ------------------------------
   PARAMS: add / load / remove
------------------------------ */
$(document).on('click', '#add_sms_params', function (e) {
    e.preventDefault();
    load_sms_params_section(cat_html, false);
});

function load_sms_params_section(cat_html_param, is_edit = false, key_params = [], value_params = []) {

    // Respect passed arrays; fallback to global sms_data if not provided
    key_params = (Array.isArray(key_params) && key_params.length > 0) ? key_params : (sms_data.params_key || []);
    value_params = (Array.isArray(value_params) && value_params.length > 0) ? value_params : (sms_data.params_value || []);

    var html = '';

    if (is_edit === true) {
        if (Array.isArray(key_params)) {
            for (var i = 0; i < key_params.length; i++) {
                html += `
                <div class="row mb-3 form-group align-items-end">
                    <div class="col-sm-5">
                        <label for="params_key" class="form-label">Key</label>
                        <input type="text" class="form-control" placeholder="Enter Key" name="params_key[]" value="${key_params[i] || ''}" id="params_key">
                    </div>

                    <div class="col-sm-5">
                        <label for="params_value" class="form-label">Value</label>
                        <input type="text" class="form-control" placeholder="Enter Value" name="params_value[]" value="${value_params[i] || ''}" id="params_value">
                    </div>

                    <div class="col-sm-2 d-flex justify-content-center">
                        <button type="button" class="btn btn-icon btn-danger remove_keyvalue_paramas_section" title="Remove">
                            <i class="ti ti-trash fs-3"></i>
                        </button>
                    </div>
                </div>
                `;
            }
        }
    } else {
        html = `
        <div class="row mb-3 form-group align-items-end">
            <div class="col-sm-5">
                <label for="params_key" class="form-label">Key</label>
                <input type="text" class="form-control" placeholder="Enter Key" name="params_key[]" id="params_key">
            </div>

            <div class="col-sm-5">
                <label for="params_value" class="form-label">Value</label>
                <input type="text" class="form-control" placeholder="Enter Value" name="params_value[]" id="params_value">
            </div>

            <div class="col-sm-2 d-flex justify-content-center">
                <button type="button" class="btn btn-icon btn-danger remove_keyvalue_paramas_section" title="Remove">
                    <i class="ti ti-trash fs-3"></i>
                </button>
            </div>
        </div>`;
    }

    $('#formdata_params_section').append(html);
}

// Delegated remove for param rows
$(document).on('click', '.remove_keyvalue_paramas_section', function () {
    $(this).closest('.row').fadeOut(200, function () {
        $(this).remove();
    });
});

/* ------------------------------
   AJAX submit (save settings)
------------------------------ */
$(document).ready(function () {
    $("#sms_gateway_submit").click(function (event) {
        event.preventDefault();

        var form = document.getElementById("smsgateway_setting_form");
        var formData = new FormData(form);

        var csrfName = $('input[name="csrfname"]').val();
        var csrfHash = $('input[name="csrfhash"]').val();
        formData.append(csrfName, csrfHash);

        $.ajax({
            type: $(form).attr("method"),
            url: base_url + 'admin/Sms_gateway_settings/add_sms_data',
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",   // IMPORTANT!!!
            success: function (response) {

                // Update CSRF Tokens
                if (response.csrfName && response.csrfHash) {
                    $('input[name="csrfname"]').val(response.csrfName);
                    $('input[name="csrfhash"]').val(response.csrfHash);
                }

                if (response.error === false) {
                    showToast(response.message, "success");

                    /*
               ----------------------------------------------
               Rebuild Header Section
               ----------------------------------------------
               */
                    $("#formdata_header_section").empty();
                    if (response.data.header_key.length > 0) {
                        load_sms_header_section(
                            true,
                            response.data.header_key,
                            response.data.header_value
                        );
                    }

                    /*
                    ----------------------------------------------
                    Rebuild Body Section
                    ----------------------------------------------
                    */
                    $("#formdata_section").empty();
                    if (response.data.body_key.length > 0) {
                        load_sms_body_section(
                            true,
                            response.data.body_key,
                            response.data.body_value
                        );
                    }


                    setTimeout(function () {
                        location.reload();
                    }, 1500);

                } else {
                    showToast(response.message, "error");
                }
            },

            error: function (xhr) {
                console.error("Server error:", xhr.responseText);
                showToast("Something went wrong!", "error");
            }
        });
    });
});

$(document).ready(function () {
    $('#sms-gateway-modal').on('hidden.bs.modal', function () {

        $('.smsgateway_setting_form').removeClass('d-none');
        $('.update_notification_module').removeClass('d-none');
    });
});



$(document).on('click', '.edit_sms_modal', function () {

    $('#sms-gateway-modal').modal('show');
    var id = $(this).data('id');
    var url = $(this).data('url');
    $.ajax({
        type: "POST",
        url: base_url + "admin/custom_sms/view_sms_by_id",
        data: {
            'id': id,
            [csrfName]: csrfHash,

        },
        dataType: "json",
        success: function (response) {

            // Replace all \r\n (escaped)
            var cleanMessage = response.data.message.replace(/\\r\\n/g, ' ');

            $('#edit_id').val(response.data.id);
            $('#edit_title').val(response.data.title);
            $('#edit-text-box').val(cleanMessage);
            $('#selected_type').val(response.data.type);
            $('#selected_type_hidden').val(response.data.type);
            var type = response.data.type;
            if (type) {
                $('.' + type).removeClass('d-none');
            }

            $(".hashtag").click(function () {
                var data = $("textarea#text-box").text();
                var tab = $.trim($(this).text());
                var message = data + tab;
                $('textarea#text-box').val(message);
            });
            $(".hashtag_input").click(function () {
                var data = $("#udt_title").val();
                var tab = $.trim($(this).text());
                var message = data + tab;
                $('input#update_title').val(message);
            });

            setTimeout(function () {
                $('.sms-modal').unblock();
            }, 2000);

        }
    });

})
// $(document).on("submit", "#add_product_form", function (event) {
//     event.preventDefault();

//     var form = document.getElementById("add_product_form");
//     var formData = new FormData(form);

//     // CSRF
//     var csrfName = $('input[name="csrfname"]').val();
//     var csrfHash = $('input[name="csrfhash"]').val();
//     formData.append(csrfName, csrfHash);

//     $.ajax({
//         url: form.getAttribute("action"),
//         type: form.getAttribute("method"),
//         data: formData,
//         contentType: false,
//         processData: false,
//         dataType: "json",

//         beforeSend: function () {
//             $("#add_product_form button[type='submit']")
//                 .prop("disabled", true)
//                 .html('<span class="spinner-border spinner-border-sm"></span> Saving...');
//         },

//         success: function (response) {

//             // Update CSRF
//             if (response.csrfName && response.csrfHash) {
//                 $('input[name="csrfname"]').val(response.csrfName);
//                 $('input[name="csrfhash"]').val(response.csrfHash);
//             }

//             if (!response.error) {
//                 showToast(response.message, "success");

//                 // Reset form after success
//                 $("#add_product_form")[0].reset();

//             } else {
//                 showToast(response.message, "error");
//             }
//         },

//         complete: function () {
//             $("#add_product_form button[type='submit']")
//                 .prop("disabled", false)
//                 .html("Save Template");
//         },

//         error: function (xhr) {
//             console.error(xhr.responseText);
//             showToast("Something went wrong!", "error");
//         }
//     });
// });


/* ------------------------------
   Initialize UI on page load
------------------------------ */
$(document).ready(function () {
    // Load sections using initial sms_data
    load_sms_header_section(true, sms_data.header_key || [], sms_data.header_value || []);
    console.log("Loading SMS body section with data:", sms_data.body_key, sms_data.body_value);
    load_sms_body_section(cat_html, true, sms_data.body_key || [], sms_data.body_value || []);
    load_sms_params_section(cat_html, true, sms_data.params_key || [], sms_data.params_value || []);
});

// Code for customization Start. 
document.addEventListener("DOMContentLoaded", function () {
    const saveBtn = document.getElementById("saveRejectionReason");
    const reasonTextarea = document.getElementById("rejection_reason");
    const hiddenInput = document.getElementById("product_rejection_reason");



    saveBtn.addEventListener("click", function () {
        // Copy textarea value to hidden input
        hiddenInput.value = reasonTextarea.value.trim();

        console.log({
            'reasonTextarea': reasonTextarea.value,
            'hiddenInput': hiddenInput.value
        });

        // Modal will automatically close because of data-bs-dismiss="modal"
    });
});


// Code for customization End. 

$(document).ready(function () {
    if ($('#commission_perc')) {

        $("#categorySelect").on('change', function (e) {
            let cat_id = e.target.value;

            if (cat_id.length > 0) {
                let formData = new FormData();
                formData.append('cat_id', cat_id);
                $.ajax({
                    type: "POST",
                    url: base_url + "admin/category/get_category_detail",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if (!response.error) {
                            const commissionPerc = response?.category?.commission_perc || '';
                            $('#commission_perc').val(commissionPerc);
                            $('#commission_perc').prop('readonly', true);
                        }
                    }
                });
            } else {
                $('#commission_perc').prop('readonly', false);
            }


        });
    }

    if ($("[name='category_id']")) {

        $("[name='category_id']").on('change', function (e) {
            let commision_input = $(this).parent().siblings().children("[name='commission']");
            console.log(commision_input);

        });


    }
});
document.addEventListener("DOMContentLoaded", function () {
    const deliverableType = document.getElementById('deliverable_zipcode_type');

    if (!deliverableType) return;

    function toggleDeliverabilitySelects(value) {
        const zipSelect = document.getElementById('zipCodeSelect');
        const citySelect = document.getElementById('citySelect');

        const disable = value === "1";

        if (zipSelect) {
            zipSelect.disabled = disable;
            if (zipSelect.tomselect) {
                disable ? zipSelect.tomselect.disable() : zipSelect.tomselect.enable();
            }
        }

        if (citySelect) {
            citySelect.disabled = disable;
            if (citySelect.tomselect) {
                disable ? citySelect.tomselect.disable() : citySelect.tomselect.enable();
            }
        }
    }

    // ✅ On change
    deliverableType.addEventListener('change', function (event) {
        toggleDeliverabilitySelects(event.target.value);
    });

    // ✅ On page load
    toggleDeliverabilitySelects(deliverableType.value);
});






// Lightbox functionality for modals (using Bootstrap)
document.querySelectorAll('.lightbox-link').forEach(link => {
    link.addEventListener('click', function (e) {
        e.preventDefault();
        const modalId = this.getAttribute('data-bs-target');
        const imgId = modalId === '#panImageModal' ? 'panImageModalImg' : 'bankImageModalImg';
        document.getElementById(imgId).src = this.href;
    });
});

// Example JS for IFSC Verify (integrate with your backend)
$("#verify_bank_ifsc").on('click', function (e) {
    e.preventDefault();

    const bank_ifsc = $('#bank_ifsc').val().trim();

    if (bank_ifsc.length !== 11) {
        return showToast("Bank IFSC must be exactly 11 characters", "error");
    }

    // Valid IFSC format
    const ifscRegex = /^[A-Z]{4}0[A-Z0-9]{6}$/i;
    if (!ifscRegex.test(bank_ifsc)) {
        return showToast("Enter valid 11-character alphanumeric IFSC Code", "error");
    }

    $.ajax({
        url: `https://ifsc.razorpay.com/${bank_ifsc}`,
        type: 'GET',
        success: function (data) {
            $("#bank_name").val(data.BANK);
            showToast("IFSC code verified", "success");
            bank_ifsc_is_verified = true;

        },
        error: function () {
            showToast("Invalid IFSC code", "error");
            $("#bank_name").val('');

        }
    });
})
// document.querySelectorAll('.lightbox-link').forEach(link => {
//     link.addEventListener('click', function (e) {
//         e.preventDefault();
//         const modalId = this.getAttribute('data-bs-target');
//         const imgId = modalId === '#panImageModal' ? 'panImageModalImg' : 'bankImageModalImg';
//         document.getElementById(imgId).src = this.href;
//     });
// });
if (document.getElementById('pan_image')) {

    document.getElementById('pan_image').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;
    
        const preview = document.getElementById('panPreview');
        const lightboxLink = document.querySelector('.pan-lightbox');
    
        const reader = new FileReader();
        reader.onload = function (event) {
            preview.src = event.target.result;
            preview.style.display = 'block';
    
            // Update lightbox href
            lightboxLink.href = event.target.result;
        };
        reader.readAsDataURL(file);
    });
 }


$("#pan_number").on("input", function () {

    let value = $(this).val().toUpperCase();
    // Allow only A-Z and 0-9
    value = value.replace(/[^A-Z0-9]/g, '');
    // Enforce PAN structure step-by-step
    let formatted = "";
    for (let i = 0; i < value.length && i < 10; i++) {
        // First 5 characters → Alphabets
        if (i < 5 && /[A-Z]/.test(value[i])) {
            formatted += value[i];
        }
        // Next 4 characters → Numbers
        else if (i >= 5 && i < 9 && /[0-9]/.test(value[i])) {
            formatted += value[i];
        }
        // Last character → Alphabet
        else if (i === 9 && /[A-Z]/.test(value[i])) {
            formatted += value[i];
        }
    }

    $(this).val(formatted);
});

$("#bank_ifsc").on("input", function (e) {
    let value = $(this).val().toUpperCase();
    // Allow only A-Z and 0-9
    value = value.replace(/[^A-Z0-9]/g, '');
    let formatted = "";
    for (let i = 0; i < value.length && i < 11; i++) {
        // First 4 characters → Alphabets
        if (i < 4 && /[A-Z]/.test(value[i])) {
            formatted += value[i];
        }
        // 5th character → Mandatory 0
        else if (i === 4) {
            formatted += '0';
        }
        // Last 6 characters → Alphanumeric
        else if (i > 4 && /[A-Z0-9]/.test(value[i])) {
            formatted += value[i];
        }
    }
    $(this).val(formatted);
});

$("#tax_number").on("input", function () {

    let value = $(this).val().toUpperCase();
    value = value.replace(/[^A-Z0-9]/g, '');
    let formatted = "";
    for (let i = 0; i < value.length && i < 15; i++) {

        // 1–2 → State code (digits)
        if (i < 2 && /[0-9]/.test(value[i])) {
            formatted += value[i];
        }
        // 3–7 → PAN alphabets
        else if (i >= 2 && i < 7 && /[A-Z]/.test(value[i])) {
            formatted += value[i];
        }
        // 8–11 → PAN numbers
        else if (i >= 7 && i < 11 && /[0-9]/.test(value[i])) {
            formatted += value[i];
        }
        // 12 → PAN alphabet
        else if (i === 11 && /[A-Z]/.test(value[i])) {
            formatted += value[i];
        }
        // 13 → Entity code (alphanumeric)
        else if (i === 12 && /[A-Z0-9]/.test(value[i])) {
            formatted += value[i];
        }
        // 14 → Mandatory Z
        else if (i === 13) {
            formatted += 'Z';
        }
        // 15 → Checksum (alphanumeric)
        else if (i === 14 && /[A-Z0-9]/.test(value[i])) {
            formatted += value[i];
        }
    }
    $(this).val(formatted);
});
