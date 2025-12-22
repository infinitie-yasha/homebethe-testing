"use strict";

var auth_settings = $('#auth_settings').val();
//forgot password
$(document).ready(function () {
    var telInput = $("#forgot_password_number");

    // Set defaultCountry before calling intlTelInput
    telInput.intlTelInput({
        allowExtensions: true,
        formatOnDisplay: true,
        autoFormat: true,
        autoHideDialCode: true,
        autoPlaceholder: true,
        defaultCountry: "in",
        ipinfoToken: "yolo",
        nationalMode: false,
        numberType: "MOBILE",
        preferredCountries: ["in", "ae", "qa", "om", "bh", "kw", "ma"],
        preventInvalidNumbers: true,
        separateDialCode: true,
        geoIpLookup: function (callback) {
            $.get("https://ipinfo.io", function () { }, "jsonp").always(function (resp) {
                var countryCode = (resp && resp.country) ? resp.country : "";
                callback(countryCode);
            });
        },
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js"
    });
});
$(document).ready(function () {
    var telInput = $("#seller_mobile");

    // Set defaultCountry before calling intlTelInput
    telInput.intlTelInput({
        allowExtensions: true,
        formatOnDisplay: true,
        autoFormat: true,
        autoHideDialCode: true,
        autoPlaceholder: true,
        defaultCountry: "in",
        ipinfoToken: "yolo",
        nationalMode: false,
        numberType: "MOBILE",
        preferredCountries: ["in", "ae", "qa", "om", "bh", "kw", "ma"],
        preventInvalidNumbers: true,
        separateDialCode: true,
        geoIpLookup: function (callback) {
            $.get("https://ipinfo.io", function () { }, "jsonp").always(function (resp) {
                var countryCode = (resp && resp.country) ? resp.country : "";
                callback(countryCode);
            });
        },
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js"
    });
});
$(document).ready(function () {
    var telInput = $("#delivery_boy_mobile");

    // Set defaultCountry before calling intlTelInput
    telInput.intlTelInput({
        allowExtensions: true,
        formatOnDisplay: true,
        autoFormat: true,
        autoHideDialCode: true,
        autoPlaceholder: true,
        defaultCountry: "in",
        ipinfoToken: "yolo",
        nationalMode: false,
        numberType: "MOBILE",
        preferredCountries: ["in", "ae", "qa", "om", "bh", "kw", "ma"],
        preventInvalidNumbers: true,
        separateDialCode: true,
        geoIpLookup: function (callback) {
            $.get("https://ipinfo.io", function () { }, "jsonp").always(function (resp) {
                var countryCode = (resp && resp.country) ? resp.country : "";
                callback(countryCode);
            });
        },
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js"
    });
});

$(document).on('click', "#forgot_password_link", function (e) {
    e.preventDefault();
    $('.auth-modal').find('header a').removeClass('active');
    $('#forgot_password_div').removeClass('hide');
    if ($('#recaptcha-container-2').length) {
        $('#recaptcha-container-2').html('');
        window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container-2');
        window.recaptchaVerifier.render().then(function (widgetId) {
            grecaptcha.reset(widgetId);
        });
    }
    var telInput = $("#forgot_password_number");

    // Set defaultCountry before calling intlTelInput
    telInput.intlTelInput({
        allowExtensions: true,
        formatOnDisplay: true,
        autoFormat: true,
        autoHideDialCode: true,
        autoPlaceholder: true,
        defaultCountry: "in",
        ipinfoToken: "yolo",
        nationalMode: false,
        numberType: "MOBILE",
        preferredCountries: ["in", "ae", "qa", "om", "bh", "kw", "ma"],
        preventInvalidNumbers: true,
        separateDialCode: true,
        geoIpLookup: function (callback) {
            $.get("https://ipinfo.io", function () { }, "jsonp").always(function (resp) {
                var countryCode = (resp && resp.country) ? resp.country : "";
                callback(countryCode);
            });
        },
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js"
    });

});


function is_user_exist(phone_number = '') {
    if (phone_number == '') {
        var phoneNumber = $('#phone-number').val();
    } else {
        var phoneNumber = phone_number;
    }
    var forgot_password_value = $('#forget_password_val').val();
    var country_code = $(".selected-dial-code").text();

    var from_seller = $('#from_seller').val();
    var from_admin = $('#from_admin').val();
    var from_delivery_boy = $('#from_delivery_boy').val();

    var response;
    $.ajax({
        type: 'POST',
        async: false,
        url: base_url + 'auth/verify_user',
        data: {
            mobile: phoneNumber,
            country_code: country_code,
            [csrfName]: csrfHash,
            forget_password_val: forgot_password_value,
            from_seller: from_seller,
            from_admin: from_admin,
            from_delivery_boy: from_delivery_boy
        },
        dataType: 'json',
        success: function (result) {
            csrfName = result['csrfName'];
            csrfHash = result['csrfHash'];
            response = result
        }
    });
    return response;
}


$(document).ready(function () {

    if ($('#recaptcha-container-2').length) {
        $('#recaptcha-container-2').html('');
        window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container-2');
        window.recaptchaVerifier.render().then(function (widgetId) {
            grecaptcha.reset(widgetId);
        });
    }
    var telInput = $("#forgot_password_number"),
        errorMsg = $("#error-msg"),
        validMsg = $("#valid-msg");

    // initialise plugin
    telInput.intlTelInput({

        allowExtensions: true,
        formatOnDisplay: true,
        autoFormat: true,
        autoHideDialCode: true,
        autoPlaceholder: true,
        defaultCountry: "in",
        ipinfoToken: "yolo",

        nationalMode: false,
        numberType: "MOBILE",
        preferredCountries: ['in', 'ae', 'qa', 'om', 'bh', 'kw', 'ma'],
        preventInvalidNumbers: true,
        separateDialCode: true,
        initialCountry: "auto",
        geoIpLookup: function (callback) {
            $.get("https://ipinfo.io", function () { }, "jsonp").always(function (resp) {
                var countryCode = (resp && resp.country) ? resp.country : "";
                callback(countryCode);
            });
        },
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js"
    });

    var reset = function () {
        telInput.removeClass("error");
        errorMsg.addClass("hide");
        validMsg.addClass("hide");
    };
});

$(document).on('submit', '#send_forgot_password_otp_form', function (e) {
    e.preventDefault();
    var send_otp_btn = $('#forgot_password_send_otp_btn').html();
    $('#forgot_password_send_otp_btn').html('Please Wait...').attr('disabled', true);
    var phoneNumber = $('.selected-dial-code').html() + $('#forgot_password_number').val();
    var appVerifier = window.recaptchaVerifier;
    var formdata = new FormData(this);


    var response = is_user_exist($('#forgot_password_number').val());
    if (response.error == true) {
        $('#forgot_password_send_otp_btn').html(send_otp_btn).attr('disabled', true);
        showToast(response.message, 'error');
        setTimeout(function () {
            window.location.reload();
        }, 2000)

    } else {
        if (auth_settings == "firebase") {
            firebase.auth().signInWithPhoneNumber(phoneNumber, appVerifier).then(function (confirmationResult) {
                resetRecaptcha();
                $('#verify_forgot_password_otp_form').removeClass('d-none');
                $('#send_forgot_password_otp_form').hide();
                $('#forgot_pass_error_box').html(response.message);
                $('#forgot_password_send_otp_btn').html(send_otp_btn).attr('disabled', false);
                $(document).on('submit', '#verify_forgot_password_otp_form', function (e) {
                    e.preventDefault();

                    var reset_pass_btn_html = $('#reset_password_submit_btn').html();
                    var code = $('#forgot_password_otp').val();
                    var formdata2 = new FormData(this);
                    var url = base_url + "admin/home/reset-password";
                    $('#reset_password_submit_btn').html('Please Wait...').attr('disabled', true);
                    confirmationResult.confirm(code).then(function (result) {
                        formdata2.append(csrfName, csrfHash);
                        formdata2.append('mobile', $('#forgot_password_number').val());
                        formdata2.append('password', $('#password').val());
                        $.ajax({
                            type: 'POST',
                            url: url,
                            data: formdata2,
                            processData: false,
                            contentType: false,
                            cache: false,
                            dataType: 'json',
                            beforeSend: function () {
                                $('#reset_password_submit_btn').html('Please Wait...').attr('disabled', true);
                            },
                            success: function (result) {
                                console.log(result);

                                csrfName = result.csrfName;
                                csrfHash = result.csrfHash;
                                $('#reset_password_submit_btn').html(reset_pass_btn_html).attr('disabled', false);
                                // $("#set_password_error_box").html(result.message).show();
                                showToast(result.message, 'success');

                                if (result.error == false) {
                                    setTimeout(function () {
                                        // Redirect based on user type
                                        var from_admin = $('#from_admin').val();
                                        var from_seller = $('#from_seller').val();
                                        var from_delivery_boy = $('#from_delivery_boy').val();
                                        
                                        if (from_admin == '1') {
                                            window.location.href = base_url + 'admin/login';
                                        } else if (from_seller == '1') {
                                            window.location.href = base_url + 'seller/login';
                                        } else if (from_delivery_boy == '1') {
                                            window.location.href = base_url + 'delivery_boy/login';
                                        } else {
                                            window.location.href = base_url + 'admin/login';
                                        }
                                    }, 2000)
                                } else {
                                    $('#reset_password_submit_btn').html(reset_pass_btn_html).attr('disabled', false);
                                    setTimeout(function () {
                                        showToast(e.message, 'error');
                                    }, 2000)
                                }
                            }
                        });
                    }).catch(function (error) {
                        $('#reset_password_submit_btn').html(reset_pass_btn_html).attr('disabled', false);
                        showToast('Invalid OTP. Please Enter Valid OTP', 'error');
                    });
                });
            }).catch(function (error) {
                // $("#forgot_pass_error_box").html(error.message).show();
                showToast(error.message, 'error');
                $('#forgot_password_send_otp_btn').html(send_otp_btn).attr('disabled', false);
                resetRecaptcha();
            });

        }
    }
})
if (auth_settings == "sms") {
    $(document).on("click", ".forgot-send-otp-btn", function (e) {
        e.preventDefault();
        var forgot_password_number = $('#forgot_password_number').val();
        var forget_password_val = $('#forget_password_val').val();
        var country_code = $(".selected-dial-code").text();

        $.ajax({
            type: "POST",
            async: !1,
            url: base_url + "auth/verify_user",
            data: {
                mobile: forgot_password_number,
                country_code: country_code,
                forget_password_val: forget_password_val,
                [csrfName]: csrfHash
            },
            dataType: "json",
            success: function (e) {
                if (e.error == false) {
                    csrfName = e.csrfName,
                        csrfHash = e.csrfHash,
                        resetRecaptcha(),
                        $('#verify_forgot_password_otp_form').removeClass('d-none');
                    $('#send_forgot_password_otp_form').hide();

                    $("#verify-otp-form").removeClass("d-none");

                } else {
                    showToast(e.message, 'error');
                }
            }
        })
    });

    $(document).on('submit', '#verify_forgot_password_otp_form', function (e) {
        e.preventDefault();
        var reset_pass_btn_html = $('#reset_password_submit_btn').html();
        var code = $('#forgot_password_otp').val();
        var formdata = new FormData(this);
        var url = base_url + "admin/home/reset-password";
        $('#reset_password_submit_btn').html('Please Wait...').attr('disabled', true);
        formdata.append(csrfName, csrfHash);
        formdata.append('mobile', $('#forgot_password_number').val());
        $.ajax({
            type: 'POST',
            url: url,
            data: formdata,
            processData: false,
            contentType: false,
            cache: false,
            dataType: 'json',
            beforeSend: function () {
                $('#reset_password_submit_btn').html('Please Wait...').attr('disabled', true);
            },
            success: function (result) {
                csrfName = result.csrfName;
                csrfHash = result.csrfHash;
                // $('#reset_password_submit_btn').html(reset_pass_btn_html).attr('disabled', false);
                showToast(result.message, 'error');
                $("#set_password_error_box").html(result.message).show();
                if (result.error == false) {
                    setTimeout(function () {
                        var from_admin = $('#from_admin').val();
                        var from_seller = $('#from_seller').val();
                        var from_delivery_boy = $('#from_delivery_boy').val();
                        
                        if (from_admin == '1') {
                            window.location.href = base_url + 'admin/login';
                        } else if (from_seller == '1') {
                            window.location.href = base_url + 'seller/login';
                        } else if (from_delivery_boy == '1') {
                            window.location.href = base_url + 'delivery_boy/login';
                        } else {
                            window.location.href = base_url + 'admin/login';
                        }
                    }, 2000)
                }
            }
        });
    });

}

function resetRecaptcha() {
    return window.recaptchaVerifier.render().then(function (widgetId) {
        grecaptcha.reset(widgetId);
    });
}