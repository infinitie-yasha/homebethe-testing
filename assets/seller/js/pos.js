"use strict";

/* POS - Point of Sale system starts */
if (document.readyState == 'loading') {
    document.addEventListener('DOMContentLoaded', ready);
} else {
    ready();
}
$('#clear_user_search').on('click', function () {
    // Try to find the TomSelect instance safely
    const selectElement = document.getElementById('select_user');

    if (selectElement && selectElement.tomselect) {
        // ✅ Clear TomSelect selected value properly
        selectElement.tomselect.clear();
    } else {
        // 🔄 Fallback for plain <select>
        $('#select_user').val('').trigger('change');
    }

    // Optional: confirmation feedback
    if (typeof showToast === 'function') {
        showToast('User selection cleared successfully.', 'success');
    } else {
        console.log('✅ User selection cleared');
    }
});


function ready() {
    display_cart();
    var addToCartButtons = document.getElementsByClassName('shop-item-button');
    for (var i = 0; i < addToCartButtons.length; i++) {
        var button = addToCartButtons[i];
        button.addEventListener('click', add_to_cart);
    }
}

function purchaseClicked() {
    var cartItems = document.getElementsByClassName('cart-items')[0];
    while (cartItems.hasChildNodes()) {
        cartItems.removeChild(cartItems.firstChild);
    }
    update_cart_total();
    update_final_cart_total();

}
$(document).on("click", ".remove-cart-item", function (e) {
    e.preventDefault();
    showToast('Item removed from cart', 'success');
    if (e.delegateTarget.activeElement.classList.value.includes("remove-cart-item")) {

        var variant_id = $(this).data("variant_id");
        $(this).parent().parent().remove();
        var cart = localStorage.getItem("cart");
        cart = (localStorage.getItem("cart") !== null) ? JSON.parse(cart) : null;
        if (cart) {
            var new_cart = cart.filter(function (item) { return item.variant_id != variant_id });
            localStorage.setItem("cart", JSON.stringify(new_cart));
            display_cart();
        }
    }
});

$(document).on("click", ".cart-quantity-input", function (e) {

    var operation = $(this).data("operation");
    var variant_id = $(this).siblings().val();
    var input = (operation == "plus") ? $(this).siblings()[1] : $(this).siblings()[2];
    var qty = $(this).parent().siblings('.item-quantity').find('.cart-quantity-input').val();
    var qty = parseInt(input.value, 10);
    var data = input.value = (operation == "minus") ? qty - 1 : qty + 1;

    update_quantity(data, variant_id);
});

$(document).on("change", ".cart-quantity-input-new", function (e) {

    var variant_id = $(this).siblings().val();
    var quantity = $(this).val();
    var data = quantity;

    update_quantity(data, variant_id);
});

function update_quantity(data, variant_id) {
    if (isNaN(data) || data <= 0) {
        data = 1;
    }
    var cart = localStorage.getItem("cart");
    cart = (localStorage.getItem("cart") !== null) ? JSON.parse(cart) : null;
    if (cart) {
        var i = cart.map(i => i.variant_id).indexOf(variant_id);
        cart[i].quantity = data;
        localStorage.setItem("cart", JSON.stringify(cart));
        display_cart();
    }
}

function SafeParseFloat(val) {
    if (isNaN(val)) {
        if ((val = val.match(/([0-9\.,]+\d)/g))) {
            val = val[0].replace(/[^\d\.]+/g, '');
        }
    }
    return parseFloat(val);
}

function add_to_cart(e) {
    var button = e.target.closest("button"); // safer reference
    var shopItem = button.closest(".card");  // get the card container

    // Find elements inside the card
    var variant_dropdown = shopItem.querySelector(".variant_value");
    var display_price = variant_dropdown.value;
    var product_id = shopItem.querySelector(".shop-item-id")
        ? shopItem.querySelector(".shop-item-id").innerText
        : ""; // fallback if missing
    var seller_id = shopItem.querySelector(".shop-item-partner-id")
        ? shopItem.querySelector(".shop-item-partner-id").innerText
        : "";

    var variant_id = variant_dropdown.options[variant_dropdown.selectedIndex].dataset.variant_id;
    var variant_values = variant_dropdown.options[variant_dropdown.selectedIndex].dataset.variant_values;
    var special_price = variant_dropdown.options[variant_dropdown.selectedIndex].dataset.special_price;
    var price = variant_dropdown.options[variant_dropdown.selectedIndex].dataset.price;
    var title = shopItem.querySelector(".shop-item-title").innerText.trim();
    var image = shopItem.querySelector(".card-img-top").src;

    /* create JSON array object */
    var cart_item = {
        "product_id": product_id.trim(),
        "seller_id": seller_id.trim(),
        "variant_id": variant_id,
        "title": title,
        "variant": variant_values,
        "image": image,
        "display_price": display_price.trim(),
        "quantity": 1,
        "special_price": special_price,
        "price": price
    };

    var cart = localStorage.getItem("cart");
    cart = (localStorage.getItem("cart") !== null) ? JSON.parse(cart) : null;

    if (cart !== null && cart !== undefined) {
        if (cart.find((item) => item.variant_id === variant_id)) {
            Notiflix.Report.warning(
                'Already in Cart',
                'This item is already present in your cart',
                'Okay'
            );
            return;
        } else {
            showToast('Product added to cart', 'success');
        }
        cart.push(cart_item);
    } else {
        cart = [cart_item];
    }

    localStorage.setItem("cart", JSON.stringify(cart));
    display_cart();
}


function wordLimit(string, length = 22, dots = "...") {
    return string.length > length ? string.slice(0, length - dots.length) + dots : string;
}

function display_cart() {
    let cart = localStorage.getItem("cart");
    cart = cart ? JSON.parse(cart) : [];
    let currency = $(".cart-total-price").attr('data-currency') || '';

    let cartRowContents = "";

    if (cart.length > 0) {
        cart.forEach((item) => {
            cartRowContents += `
            <div class="cart-card card mb-3 shadow-sm border-0">
                <div class="card-body d-flex align-items-center">

                        <!-- Image -->
                    <div class="cart-image me-3">
                            <img src="${item.image}" alt="${item.title}"
                             class="rounded" style="width:70px; height:70px; object-fit:cover;">
                        </div>

                    <!-- Title + Price -->
                    <div class="flex-grow-1">
                        <h6 class="mb-1 fw-semibold text-dark">${wordLimit(item.title)}</h6>
                        <p class="mb-0 text-muted small">${currency}${parseFloat(item.display_price).toLocaleString()}</p>
                        </div>

                        <!-- Quantity Controls -->
                       <div class="d-flex align-items-center me-3">
                            <input type="hidden" class="product-variant" name="variant_ids[]" value="${item.variant_id}">
                            
                           <div class="input-group input-group-sm rounded overflow-hidden shadow-sm">
                               <!-- Minus Button -->
                               <button type="button" class="btn btn-secondary text-dark fw-bold px-2 quantity-btn" 
                                    data-operation="minus" data-variant_id="${item.variant_id}">
                                    <i class="ti ti-minus"></i>
                                </button>

                               <!-- Quantity Input -->
                               <input type="number" min="1" class="form-control text-center border-0 cart-qty-input" 
                                      value="${item.quantity}" data-variant_id="${item.variant_id}" 
                                    style="max-width:60px; font-weight:500;">

                               <!-- Plus Button -->
                               <button type="button" class="btn btn-secondary text-dark fw-bold px-2 quantity-btn" 
                                    data-operation="plus" data-variant_id="${item.variant_id}">
                                    <i class="ti ti-plus"></i>
                                </button>
                            </div>
                        </div>


                    <!-- Remove Button -->
                    <button class="btn btn-sm btn-action bg-danger-lt remove-cart-item p-2" data-variant_id="${item.variant_id}">
                        <i class="ti ti-trash"></i>
                            </button>

                    </div>
            </div>`;
        });
    } else {
        cartRowContents = `
        <div class="text-center text-primary py-5">
            <i class="fas fa-shopping-cart fa-2x mb-3"></i>
            <h5 class="fw-semibold">Your cart is empty</h5>
            <p class="text-muted small">Start adding products to see them here.</p>
        </div>`;
    }

    $(".cart-items").html(cartRowContents);

    // Quantity button click handler
    $(".quantity-btn").off("click").on("click", function () {
        let variantId = $(this).data("variant_id");
        let operation = $(this).data("operation");
        let input = $(`.cart-qty-input[data-variant_id="${variantId}"]`);
        let currentVal = parseInt(input.val()) || 1;

        if (operation === "plus") input.val(currentVal + 1);
        else if (operation === "minus" && currentVal > 1) input.val(currentVal - 1);

        updateQuantityInCart(variantId, parseInt(input.val()));
    });

    $(".cart-qty-input").off("change").on("change", function () {
        let variantId = $(this).data("variant_id");
        let value = parseInt($(this).val());
        if (isNaN(value) || value < 1) value = 1;
        $(this).val(value);
        updateQuantityInCart(variantId, value);
    });

    $(".remove-cart-item").off("click").on("click", function () {
        let variantId = $(this).data("variant_id");
        removeFromCart(variantId);
    });

    update_cart_total();
    update_final_cart_total();
}



function updateQuantityInCart(variantId, newQty) {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    cart = cart.map(item => {
        if (item.variant_id == variantId) {
            item.quantity = newQty;
        }
        return item;
    });
    localStorage.setItem("cart", JSON.stringify(cart));
    update_cart_total();
    update_final_cart_total();  // ← ADD THIS LINE
}

function removeFromCart(variantId) {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    cart = cart.filter(item => item.variant_id != variantId);
    localStorage.setItem("cart", JSON.stringify(cart));
    display_cart(); // re-render
}



function get_cart_total() {
    var cart = localStorage.getItem("cart");
    var cart = (cart !== null && cart !== undefined) ? JSON.parse(cart) : null;
    var cart_total = 0;
    if (cart !== null && cart !== undefined) {
        cart_total = cart.reduce((cart_total, item) =>
            cart_total + (parseFloat(item.display_price) * parseFloat(item.quantity)), 0);
    }
    var currency = $('#cart-total-price').attr('data-currency');
    var total = { "currency": currency, "cart_total": cart_total, "cart_total_formated": parseFloat(cart_total).toLocaleString() }
    return total;
}

function update_cart_total() {
    var total = get_cart_total();
    $('#cart-total-price').html(total.currency + "" + total.cart_total_formated);
    return;
}


//final total
function get_final_cart_total() {
    var cart = localStorage.getItem("cart");
    var cart = (cart !== null && cart !== undefined) ? JSON.parse(cart) : null;
    var cart_total = 0;
    if (cart !== null && cart !== undefined) {
        cart_total = cart.reduce((cart_total, item) =>
            cart_total + (parseFloat(item.display_price) * parseFloat(item.quantity)), 0);
    }
    var currency = $('#cart-total-price').attr('data-currency');
    var total = {
        "currency": currency,
        "total": cart_total,
        "cart_total_formated": parseFloat(cart_total).toLocaleString()
    }
    return total;
}

$(document).on("change", ".delivery_charge_service", function (e) {
    e.preventDefault();

    update_final_cart_total();
    return;
});

$(document).on("change", ".discount_service", function (e) {
    update_final_cart_total();
    return;
});

function update_final_cart_total() {
    var cart = get_cart_total();
    var sub_total = parseFloat(cart.cart_total) || 0;
    var delivery_charges = parseFloat($(".delivery_charge_service").val()) || 0;
    var discount = parseFloat($("#discount_service").val()) || 0;
    var currency = $('#cart-total-price').attr('data-currency');

    // Check if discount is greater than subtotal
    if (discount > sub_total) {
        showToast('Discount cannot be greater than the subtotal.', 'error');
        $("#discount_service").val(0);
        discount = 0;
    }

    // Calculate final total
    var final_total = sub_total + delivery_charges - discount;

    // Ensure final total is not negative
    if (final_total < 0) {
        final_total = 0;
    }

    // Display the final total
    $('#final_total').html(currency + " " + parseFloat(final_total).toLocaleString());
    
    return final_total;
}

$(".final_total").on("click", function () {
    final_total();
    update_final_cart_total();
});
$(".final_total").on("change", function () {
    final_total();
    update_final_cart_total();
});


// get products
function get_products(category_id = '', limit = 2, offset = 0, search_parameter = '') {
    $.ajax({
        type: 'GET',
        url: `${base_url}seller/point_of_sale/get_products?category_id=${category_id}&limit=${limit}&offset=${offset}&search=${search_parameter}`,
        dataType: 'json',
        beforeSend: function () {
            $("#get_products").html(`<div class="text-center" style='min-height:450px;' ><h4>Please wait.. . loading products..</h4></div>`);
        },
        success: function (data) {
            if (data.error == false) {
                $("#total_products").val(data.products.total);
                $('#get_products').empty();
                display_products(data.products);
                var total = $("#total_products").val();
                var current_page = $("#current_page").val();
                var limit = $("#limit").val();
                var search_parameter = $("#search_products").val();
                paginate(total, current_page, limit, search_parameter);
            } else {
                $('#get_products').html(data.message);
                $('#get_products').empty();
            }

        }
    });
}

// display products



function display_products(products) {
    let html = '';
    products = products.product;

    if (products && products.length > 0) {
        let currency = $('#cart-total-price').length
            ? $('#cart-total-price').attr('data-currency')
            : '';

        for (let i = 0; i < products.length; i++) {
            const product = products[i];
            let allOutOfStock = false;
            let hasLowStock = false;
            let showStockStatus = true;

            const stock_type = product.stock_type;

            if (stock_type === null || stock_type === undefined) {
                showStockStatus = false;
            } else if (stock_type == 0) {
                const stock = parseInt(product.stock);
                allOutOfStock = (stock <= 0);
                hasLowStock = (stock > 0 && stock <= 5);
            } else if (stock_type == 1 || stock_type == 2) {
                const variants = product.variants;
                allOutOfStock = true;
                hasLowStock = false;
                for (let j = 0; j < variants.length; j++) {
                    const vStock = parseInt(variants[j].stock);
                    if (vStock > 0) {
                        allOutOfStock = false;
                        if (vStock <= 5) {
                            hasLowStock = true;
                        }
                    }
                }
            }

           html += `
<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 mb-4">
  <div class="card h-100 border shadow-sm">

    <!-- Hidden IDs -->
    <span class="d-none shop-item-id">${product.id}</span>
    <span class="d-none shop-item-partner-id">${product.seller_id}</span>

    <!-- Product Image -->
    <div class="">
      <img src="${product.image || 'path/to/placeholder-image.jpg'}"
           class="card-img-top item-image"
           alt="${product.name}"
           style="width: 100%; object-fit: cover; aspect-ratio: 4 / 3;">
    </div>

    <div class="card-body d-flex flex-column">

      <!-- Product Name -->
      <h5 class="card-title mb-3 shop-item-title" style="min-height: 48px;">
        <a href="${base_url}seller/product/view_product?edit_id=${product.id}"
           target="_blank"
           class="text-dark text-decoration-none">
          ${product.name}
        </a>
      </h5>

      <!-- Variant Dropdown -->
      <div class="mb-3">
        <select class="form-select product-variants variant_value">
          ${
            product.variants && product.variants.length > 0
              ? product.variants
                  .map((variant) => {
                    const variant_values =
                      (variant.variant_values || '') +
                      (variant.variant_values ? ' - ' : '');
                    const variant_price =
                      variant.special_price > 0
                        ? variant.special_price
                        : variant.price;

                    return `
              <option
                data-variant_values="${variant.variant_values || ''}"
                data-price="${variant.price || 0}"
                data-special_price="${variant.special_price || 0}"
                data-variant_id="${variant.id || ''}"
                value="${variant_price}">
                ${variant_values}${currency} ${parseFloat(variant_price).toLocaleString()}
              </option>`;
                  })
                  .join('')
              : `<option value="0">No variants available</option>`
          }
        </select>
      </div>

      <!-- Add to Cart / Stock Button -->
      <div class="mt-auto">
        ${
          !showStockStatus
            ? ''
            : allOutOfStock
            ? `
            <button class="btn btn-outline-secondary w-100" type="button" disabled>
              Out of Stock
            </button>`
            : hasLowStock
            ? `
            <button class="btn btn-outline-warning w-100" type="button" disabled>
              Low Stock
            </button>`
            : `
            <button class="btn btn-primary w-100" onclick="add_to_cart(event)" type="button">
              Add to Cart
            </button>`
        }
      </div>

    </div>
  </div>
</div>
`;

        }
        $('#get_products').html(html);
    } else {
        $("#get_products").html(`
<div class="text-center py-5">
  <p class="text-muted mb-0">No products available in this category</p>
</div>`);
    }
}

var session_user_id = $('#session_user_id').val()
var cart = localStorage.getItem('cart')
cart = (cart != null || cart == '') ? JSON.parse(cart) : ''
if (cart != '') {
    if (cart.find(item => item.seller_id != session_user_id)) {
        localStorage.removeItem('cart')
        display_cart()
    }
}
$(document).ready(function () {
    var category_id = $('#product_categories').val();
    var limit = $('#limit').val();
    var offset = $('#offset').val();
    get_products(category_id, limit, offset);
});

// category wise product change
$('#product_categories').on("change", function () {
    var category_id = $('#product_categories').val();
    var limit = $('#limit').val();
    $('#current_page').val("0");
    get_products(category_id, limit, 0);
});

$(document).ready(function () {
    $("#product_categories").on("change", function () {
        $("#get_products").empty();
    });
});

// transaction id input 
$(document).ready(function () {
    $('.transaction_id').hide();
    $('.payment_method_name').hide();
});

/* payment method selected event  */
$(".payment_method").on('click', function () {
    var payment_method = $(this).val();
    var exclude_txn_id = ["COD"];
    var include_payment_method_name = ["other"];

    if (exclude_txn_id.includes(payment_method)) {
        $(".transaction_id").hide();
    } else {
        $(".transaction_id").show();
    }

    if (include_payment_method_name.includes(payment_method)) {
        $('.payment_method_name').show();
    } else {
        $('.payment_method_name').hide();
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const paymentInputs = document.querySelectorAll(".payment_method");
    const paymentBoxes = document.querySelectorAll(".payment-box");
    const otherMethodField = document.querySelector(".payment_method_name");
    const transactionField = document.querySelector(".transaction_id");

    paymentInputs.forEach((input) => {
        input.addEventListener("change", function () {
            // Remove active styles from all cards
            paymentBoxes.forEach(box => box.classList.remove("active", "border-primary", "shadow"));

            // Add Tabler’s "active" look to the selected one
            const selectedBox = input.closest("label").querySelector(".payment-box");
            selectedBox.classList.add("active", "border-primary", "shadow");

            // Show extra fields only for "other"
            if (input.value === "other") {
                otherMethodField.style.display = "block";
                transactionField.style.display = "block";
            } else {
                otherMethodField.style.display = "none";
                transactionField.style.display = "none";
            }
        });
    });
});


// clear selected values in select2

$("#clear_user_search").on('click', function () { $(".select_user").empty(); });

// Register in pos

$(document).on('submit', '#register_form', function (e) {
    e.preventDefault();
    var name = $('#name').val();
    var mobile = $('#mobile').val();
    var formData = new FormData(this);
    formData.append(csrfName, csrfHash);
    $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        dataType: 'json',
        data: formData,
        processData: false,
        contentType: false,

        beforeSend: function () {
            $('#save-register-result-btn').html('Please Wait..');
            $('#save-register-result-btn').attr('disabled', true);
        },
        success: function (result) {
    csrfName = result['csrfName'];
    csrfHash = result['csrfHash'];

    if (result.error == false) {
        showToast(result.message, 'success');

        $('#register_form')[0].reset();

        // ✅ Close offcanvas manually (no Bootstrap JS)
        const offcanvas = document.getElementById('register');
        offcanvas.classList.remove('show'); // hide offcanvas
        offcanvas.setAttribute('aria-hidden', 'true');
        offcanvas.style.visibility = 'hidden';

        // Remove backdrop if present
        document.querySelectorAll('.offcanvas-backdrop').forEach(el => el.remove());
        document.body.classList.remove('offcanvas-backdrop', 'show', 'overflow-hidden');
    } else {
        showToast(result.message, 'error');
    }

    $('#save-register-result-btn').html('Register').attr('disabled', false);
}

    });
});

var pos_user_id = 0;
$('#select_user_id').on('change', function () {
    pos_user_id = ($('#select_user_id').val());
});

$('#pos_form').on('submit', function (e) {
    e.preventDefault();


    Notiflix.Confirm.show(
        'Confirm Checkout',
        'Are you sure? Want to check out?',
        'Yes',
        'No',
        function okCb() {
            runCheckout();
        },
        function cancelCb() {
            showToast('Checkout cancelled', 'warning');
        }
    );
});

function runCheckout() {
    const cartJSON = localStorage.getItem("cart");
    if (!cartJSON) {
        showToast('Your cart is empty', 'warning');
        return;
    }

    let cart;
    try { cart = JSON.parse(cartJSON); }
    catch (e) { showToast('Cart data is corrupted', 'error'); return; }

    /* ---------- BASIC VALIDATIONS ---------- */
    const delivery = $('.delivery_charge_service').val() || '0';
    const discount = parseFloat($('.discount_service').val()) || 0;
    const cartTotal = get_cart_total().cart_total;   // <-- you already have this helper

    if (discount > cartTotal) {
        showToast('Discount cannot exceed subtotal', 'warning');
        return;
    }

    const payment = $('.payment_method:checked').val();
    if (!payment) {
        showToast('Select a payment method', 'error');
        return;
    }

    const txn = $('#transaction_id').val() || '';
    if (!txn && payment !== 'COD') {
        showToast('Transaction ID required for non-COD', 'error');
        return;
    }

    /* ---------- BUILD FormData (multipart) ---------- */
    const fd = new FormData();
    fd.append('data', JSON.stringify(cart));               // <-- THIS IS THE FIX
    fd.append('user_id', pos_user_id);
    fd.append('delivery_charges', delivery);
    fd.append('discount', discount);
    fd.append('payment_method', payment);
    fd.append('payment_method_name', $('#payment_method_name').val() || '');
    fd.append('txn_id', txn);
    fd.append(csrfName, csrfHash);

    const $btn = $('#place_order_btn');
    const originalHTML = $btn.html();

    $.ajax({
        url: base_url + 'seller/point_of_sale/place_order',
        type: 'POST',
        data: fd,
        processData: false,
        contentType: false,
        dataType: 'json',
        beforeSend: function () {
            Notiflix.Loading.dots('Placing order…');
            $btn.prop('disabled', true).html('<i class="ti ti-loader"></i> Processing…');
        },
        success: function (res) {
            // Update CSRF for next request
            if (res.csrfName) csrfName = res.csrfName;
            if (res.csrfHash) csrfHash = res.csrfHash;

            if (res.error) {
                showToast(res.message, 'error');
            } else {
                showToast('Order placed successfully!', 'success');
                delete_cart_items();
                setTimeout(() => location.reload(), 800);
            }
        },
        error: function (xhr) {
            console.error('AJAX error:', xhr.responseText);
            showToast('Something went wrong. Please try again.', 'error');
        },
        complete: function () {
            Notiflix.Loading.remove();
            $btn.prop('disabled', false).html(originalHTML);
        }
    });
}

/* --------------------------------------------------------------
   OPTIONAL: Notiflix confirm before checkout
   -------------------------------------------------------------- */
$('#place_order_btn').on('click', function (e) {
    e.preventDefault();

    const selectedUserId = $('#select_user').val();

    if (!selectedUserId || selectedUserId == '0') {
        showToast('Please select a customer first!', 'error');
        return;
    }

    // Update global variable
    pos_user_id = selectedUserId;

    // Now run checkout
    Notiflix.Confirm.show(
        'Confirm Order',
        'Place this order?',
        'Yes', 'No',
        () => runCheckout(),
        () => {}
    );
});



// Clear Cart

$(document).on("click", "#clear_cart", function (e) {
    e.preventDefault();
    delete_cart_items();
});

function delete_cart_items() {
    localStorage.removeItem("cart");
    display_cart();
       $("#delivery_charge_service").val("");
         $("#final_total").text("");
}

function show_message(prefix = "Great!", message, type = 'success') {
    Swal.fire(prefix, message, type);
}

function paginate(total, current_page, limit) {
    var number_of_pages = Math.ceil(total / limit);
    var pagination = `<div class="row p-2">
    <div class="col-12">
        <div class="d-flex justify-content-center">
            <ul class="pagination mb-0">`;

    // Previous button
    pagination += `<li class="page-item ${current_page === 0 ? 'disabled' : ''}">
                    <a class="page-link" href="javascript:void(0)" onclick="prev_page()">Previous</a>
                  </li>`;

    // Page numbers
    var startPage = Math.max(current_page - 1, 0);
    var endPage = Math.min(current_page + 1, number_of_pages - 1);

    if (startPage > 0) {
        pagination += `<li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="go_to_page(${limit}, 0)">1</a></li>`;
        if (startPage > 1) {
            pagination += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        }
    }

    for (var i = startPage; i <= endPage; i++) {
        var active = (current_page === i) ? "active" : "";
        pagination += `<li class="page-item ${active}">
                        <a class="page-link" href="javascript:void(0)" onclick="go_to_page(${limit}, ${i})">${i + 1}</a>
                      </li>`;
    }

    if (endPage < number_of_pages - 1) {
        if (endPage < number_of_pages - 2) {
            pagination += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        }
        pagination += `<li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="go_to_page(${limit}, ${number_of_pages - 1})">${number_of_pages}</a></li>`;
    }

    // Next button
    pagination += `<li class="page-item ${current_page === number_of_pages - 1 ? 'disabled' : ''}">
                    <a class="page-link" href="javascript:void(0)" onclick="next_page()">Next</a>
                  </li>`;

    pagination += `</ul>
                </div>
            </div>
        </div>`;
    $(".pagination-container").html(pagination);
}

function go_to_page(limit, page_number) {
    var total = $("#total_products").val();
    var category_id = $("#product_categories").val();
    var offset = page_number * limit;

    get_products(category_id, limit, offset);
    paginate(total, page_number, limit);

    $("#limit").val(limit);
    $("#offset").val(offset);
    $("#current_page").val(page_number);
}

function prev_page() {
    var current_page = $("#current_page").val();
    var total = $("#total_products").val();
    var limit = $("#limit").val();
    var prev_page = parseFloat(current_page) - 1;

    if (prev_page >= 0) {
        go_to_page(limit, prev_page);
    }
}

function next_page() {
    var current_page = $("#current_page").val();
    var total = $("#total_products").val();
    var limit = $("#limit").val();

    var number_of_pages = total / limit;
    var next_page = parseFloat(current_page) + 1;

    if (next_page < number_of_pages) {
        go_to_page(limit, next_page);
    }
}

// search products 
$('#search_products').on('keyup', function (e) {
    e.preventDefault();
    var search = $(this).val();
    get_products('', 25, 0, search)
});

/* POS - Point of Sale system ends */