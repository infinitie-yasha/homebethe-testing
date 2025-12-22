$(document).on('change', '.consignment_status', function (e) {
    console.log('otp filed logic called');
    let status = $(this).val();
    console.log(status);


    let delivery_boy_otp_system = $('#delivery_boy_otp_system').val();
    console.log(delivery_boy_otp_system);

    if (status == "delivered" && (delivery_boy_otp_system == 1 || delivery_boy_otp_system == '1')) {
        return $('#otp-field-container').removeClass('d-none');
    }
    $('#otp-field-container').addClass('d-none');
});




//update order status

$(document).on('click', '.update_status_delivery_boy', function (e) {
    console.log('update status clicked');
    console.log('update status clicked');
    let consignment_id = $(this).data('id');
    let otp_system = $(this).data('otp-system');

    let status = $('.consignment_status').val();
    let post_otp = $('#otp').val();

    if (status == "" || status == undefined) {
        return showToast('Please select status to proceed.', 'error');
    }

    if (otp_system == 1 && status == 'delivered' && (post_otp == "" || post_otp == undefined)) {
        showToast('Please enter OTP to proceed.', 'error');
    }

    Notiflix.Confirm.show(
        'Are You Sure!',
        "You won't be able to revert this!",
        'Yes, update it!',
        'Cancel',
        function okCb() {
            Notiflix.Loading.circle('Updating...');
            $.ajax({
                type: 'GET',
                url: base_url + 'delivery_boy/orders/update_order_status',
                data: {
                    id: consignment_id,
                    status: status,
                    otp: post_otp
                },
                dataType: 'json',
                success: function (result) {
                    csrfName = result['csrfName'];
                    csrfHash = result['csrfHash'];

                    Notiflix.Loading.remove();

                    if (result['error'] == false) {
                        showToast(result['message'], 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    } else {
                        showToast(result['message'], 'error');
                    }
                },
                error: function () {
                    Notiflix.Loading.remove();
                    showToast('Some error occurred, please try again.', 'error');
                }
            });
        },
        function cancelCb() {
            // Cancel button clicked — nothing to do
        },
        {
            width: '320px',
            borderRadius: '8px',
            titleColor: '#222',
            okButtonBackground: '#3085d6',
            cancelButtonBackground: '#d33',
        }
    );
});

//update return order item status
$(document).on('click', '.update_return_status_delivery_boy', function (e) {
    let order_item_id = $(this).data('id');
    let status = $('.order_item_status').val();

    Notiflix.Confirm.show(
        'Are You Sure!',
        "You won't be able to revert this!",
        'Yes, update it!',
        'Cancel',
        function okCb() {
            Notiflix.Loading.circle('Updating...');
            $.ajax({
                type: 'POST',
                url: base_url + 'delivery_boy/orders/update_return_order_item_status',
                data: {
                    order_item_id: order_item_id,
                    status: status,
                    csrfName: csrfHash
                },
                dataType: 'json',
                success: function (result) {
                    csrfName = result['csrfName'];
                    csrfHash = result['csrfHash'];

                    Notiflix.Loading.remove();

                    if (result['error'] == false) {
                        showToast(result['message'], 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    } else {
                        showToast(result['message'], 'error');
                    }
                },
                error: function () {
                    Notiflix.Loading.remove();
                    showToast('Some error occurred, please try again.', 'error');
                }
            });
        },
        function cancelCb() {
            // Cancel clicked — do nothing
        },
        {
            width: '320px',
            borderRadius: '8px',
            titleColor: '#222',
            okButtonBackground: '#3085d6',
            cancelButtonBackground: '#d33',
        }
    );
});
$(document).ready(function () {
    // Preview selected image instantly
    $("#image").on("change", function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $("#profile-image-preview").attr("src", e.target.result);
            };
            reader.readAsDataURL(file);
        }
    });


    // AJAX submit
    $(".form-submit-event").on("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        const submitBtn = $("#submit_btn");

        submitBtn.prop("disabled", true).html('<i class="ti ti-loader spin me-1"></i> Updating...');

        $.ajax({
            type: "POST",
            url: $(this).attr("action"),
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (response) {
                submitBtn.prop("disabled", false).html('<i class="ti ti-device-floppy me-1"></i> Update Profile');
                if (!response.error) {
                    showToast(response.message, "success");
                    if (response.updated_image) {
                        $("#profile-image-preview").attr("src", response.updated_image);
                    }
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showToast(response.message, "error");
                }
                // Update CSRF token
                $(".csrf_token").val(response.csrfHash);
            },
            error: function (xhr, status, error) {
                submitBtn.prop("disabled", false).html('<i class="ti ti-device-floppy me-1"></i> Update Profile');
                let errorMessage = "An error occurred. Please try again.";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                showToast(errorMessage, "error");
                // Log error to console for debugging
                console.error("AJAX Error:", xhr.responseText, status, error);
                // Update CSRF token if provided
                if (xhr.responseJSON && xhr.responseJSON.csrfHash) {
                    $(".csrf_token").val(xhr.responseJSON.csrfHash);
                }
            }
        });
    });
});
function status_date_wise_search() {
    $('.table-striped').bootstrapTable('refresh');
    update_sales_chart();
}
function status_date_wise_search_cash_collection() {
    $('.table-striped').bootstrapTable('refresh');
}
function idFormatter() {
    return 'Total'
}

function priceFormatter(data) {
    var field = this.field
    var store_currency = $('input[name="store_currency"]').val();

    return '<span class="badge bg-success-lt text-success" style="font-weight:bold; font-size:small;">' + store_currency + data.map(function (row) {
        return +row[field]
    })
        .reduce(function (sum, i) {
            return sum + i
        }, 0);
}
function queryParams(p) {
    return {
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
function return_order_query_params(p) {
    return {
        "order_status": $('#return_order_status').val(),
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
        "start_date": $('#start_date').val(),
        "end_date": $('#end_date').val(),
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}

function resetfilters() {
    // Clear date pickers and other legacy filters
    $('#datepicker').val('');
    $('#media-type').val('');
    $('#start_date').val('');
    $('#end_date').val('');

    // Clear product filters
    // Reset status filter
    $('#status_filter').val('').trigger('change');
    $('#payment_method').val('').trigger('change');
    $('#order_status').val('').trigger('change');
    $('#return_order_status').val('').trigger('change');
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

