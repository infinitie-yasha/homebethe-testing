
// Product query params (no category filter)
function product_query_params(p) {
    return {
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}

// Category wise filter query params for promoted products
function category_query_params(p) {
    return {
        category_id: $('#category_filter').val(), 
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}

$(document).on('change', '#category_filter', function () {
    $('#products_table').bootstrapTable('refresh');
});

function wallet_transaction_queryParams(p) {
    return {
        transaction_type: $('#transaction_type_filter').val(), 
        payment_type: $('#transaction_type').val(),
        limit: p.limit,
        sort: p.sort,
        order: p.order,
        offset: p.offset,
        search: p.search
    };
}
$(document).on('change', '#transaction_type_filter, #transaction_type', function () {
    $('#affiliate_wallet_transaction_table').bootstrapTable('refresh');
});


$(document).on('click', '.copy-affiliate-link-btn', function () {
    const btn = $(this);
    const productId = btn.data('product_id');
    const productSlug = btn.data('slug');
    const userId = btn.data('user_id');
    const productName = btn.data('name');
    const categoryId = btn.data('category_id');
    const affiliateCommission = btn.data('affiliate_commission');

    // Get CSRF values
   
    // Disable button
    btn.prop('disabled', true).html('<i class="ti ti-loader-2 spinner me-2"></i> Generating...');

    $.ajax({
        url: base_url + 'affiliate/product/get_or_generate_token',
        type: 'POST',
        dataType: 'json',
        data: {
            product_id: productId,
            product_name: productName,
            user_id: userId,
            category_id: categoryId,
            affiliate_commission: affiliateCommission,
            [csrfName]: csrfHash  // Dynamic key
        },
        success: function (res) {
           
            // Update CSRF hash for next request
           csrfHash = res.csrfHash;

            if (!res.error && res.token) {
                const url = `${base_url}products/details/${productSlug}?ref=${res.token}`;

                navigator.clipboard.writeText(url).then(() => {
                    showToast('Affiliate link copied!', 'success');
                    btn.html('<i class="ti ti-check me-2"></i> Copied!');
                    setTimeout(() => resetButton(btn), 2000);
                }).catch(() => {
                    fallbackCopy(url, btn);
                });
            } else {
                showToast(res.message || 'Failed to generate link.', 'error');
                resetButton(btn);
            }
        },
        error: function (xhr) {
            console.error('AJAX Error:', xhr.responseText);
            showToast('Request failed. Please try again.', 'error');
            resetButton(btn);
        }
    });
});

// Fallback copy
function fallbackCopy(text, btn) {
    const textarea = document.createElement('textarea');
    textarea.value = text;
    textarea.style.position = 'fixed';
    document.body.appendChild(textarea);
    textarea.select();
    try {
        document.execCommand('copy');
        showToast('Copied (fallback)!', 'success');
    } catch (e) {
        showToast('Copy failed. URL: ' + text, 'warning');
    }
    document.body.removeChild(textarea);
    resetButton(btn);
}

function resetButton(btn) {
    btn.html('<i class="ti ti-copy me-2"></i> Copy Affiliate Link').prop('disabled', false);
}
function resetButton(btn) {
    btn.html('<i class="ti ti-copy me-2"></i> Copy Affiliate Link').prop('disabled', false);
}

// Fallback for older browsers or permission issues
function fallbackCopy(text, btn) {
    const tempInput = document.createElement('textarea');
    tempInput.style.position = 'absolute';
    tempInput.style.left = '-9999px';
    tempInput.value = text;
    document.body.appendChild(tempInput);
    tempInput.select();
    try {
        document.execCommand('copy');
        showToast('Link copied (fallback)!', 'success');
    } catch (err) {
        showToast('Copy failed. Please copy manually: ' + text, 'warning');
    }
    document.body.removeChild(tempInput);
    resetButton(btn);
}

function resetButton(btn) {
    btn.html('<i class="ti ti-copy me-2"></i> Copy Affiliate Link').prop('disabled', false);
}

$(document).ready(function () {

    if (window.location.href.indexOf('affiliate/home') > -1) {
        var fetch_sales_url = base_url + "affiliate/home/fetch_sales"
        var most_selling_affiliate_categories_url = base_url + "affiliate/home/most_selling_affiliate_categories"
        // Function to fetch sales data and render the charts
        function fetchAndRenderAffiliateCharts() {
            $.ajax({
                url: fetch_sales_url,
                type: "GET",
                dataType: "json",
                success: function (response) {
                    // Assuming response data structure as you provided
                    let monthlyData = response[0];
                    let weeklyData = response[1];
                    let dailyData = response[2];

                    const data = {
                        Monthly: {
                            series: [{
                                name: 'Monthly Earning',
                                data: monthlyData.total_sale || []
                            }],
                            categories: monthlyData.month_name || [],
                            colors: ['#1E90FF']

                        },
                        Weekly: {
                            series: [{
                                name: 'Weekly Earning',
                                data: weeklyData.total_sale || []
                            }],
                            categories: weeklyData.week || [],
                            colors: ['#32CD32']
                        },
                        Daily: {
                            series: [{
                                name: 'Daily Earning',
                                data: dailyData.total_sale || []
                            }],
                            categories: dailyData.day || [],
                            colors: ['#990099']

                        }
                    };

                    let chartData = data['Monthly'];


                    const options = {
                        chart: {
                            type: 'bar',
                            height: 350
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '55%',
                                endingShape: 'rounded'
                            },
                        },
                        series: chartData.series,
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            show: true,
                            width: 2,
                            colors: ['transparent']
                        },
                        xaxis: {
                            categories: chartData.categories
                        },
                        yaxis: {
                            labels: {
                                formatter: function (value) {
                                    return (value / 1000) +
                                        '00k'; // Divide by 1000 to convert to thousands and then add '00k'
                                }
                            }
                        },
                        fill: {
                            opacity: 1,
                        },
                        tooltip: {
                            y: {
                                formatter: function (val) {
                                    var currencySymbol = "<?php echo $currency_symbol; ?>";
                                    return currencySymbol + val;
                                }
                            }
                        }
                    };


                    const chart = new ApexCharts(document.querySelector(".affiliate-chart-container"), options);
                    chart.render();

                    $(".sales-tab a").on("click", function (e) {
                        e.preventDefault(); // Prevent default anchor behavior

                        // Remove active class from all tabs
                        $(".sales-tab a").removeClass('active');

                        // Add active to clicked tab
                        $(this).addClass('active');

                        // Get the period from href (#Monthly, #Weekly, #Daily)
                        let period = $(this).attr("href").replace('#', '');

                        // Update chart data
                        chartData = data[period];

                        chart.updateOptions({
                            series: chartData.series,
                            xaxis: {
                                categories: chartData.categories
                            }
                        });
                    });
                },
                error: function (error) {
                    console.error("Error fetching data: ", error);
                }
            });
        }

        // Function to fetch sales data and render the charts
        function fetchAndRenderCategoryCharts() {
            $.ajax({
                url: most_selling_affiliate_categories_url,
                type: "GET",
                dataType: "json",
                success: function (response) {
                    // Assuming response data structure as you provided
                    console.log('AJAX Success:', response);

                    var options = {
    series: response.sales.map(Number),
    chart: {
        type: 'donut',
        height: '100%',
        width: '100%',
        toolbar: { show: false },
        redrawOnWindowResize: true,
        redrawOnParentResize: true
    },
    plotOptions: {
        pie: {
            startAngle: -90,
            endAngle: 270,
            donut: {
                size: '75%'     // better fit
            }
        }
    },
    fill: { type: 'gradient' },
    labels: response.category,
    legend: {
        position: 'bottom',
        fontSize: '13px',
        labels: { colors: '#333' }
    },
    responsive: [
        {
            breakpoint: 992,
            options: {
                chart: { height: 260 },
                legend: { position: 'bottom' }
            }
        },
        {
            breakpoint: 576,
            options: {
                chart: { height: 240 },
                plotOptions: {
                    pie: { donut: { size: '70%' } }
                }
            }
        }
    ]
};



                    var chartCategory = new ApexCharts(document.querySelector("#piechart_3d_affiliate"), options);
                    chartCategory.render();

                    $(".chart-height li a").on("click", function () {
                        $(".chart-height li a").removeClass('active');
                        $(this).addClass('active');

                    });
                },
                error: function (error) {
                    console.error("Error fetching data: ", error);
                }
            });
        }
        // Initial chart rendering
        fetchAndRenderAffiliateCharts();
        fetchAndRenderCategoryCharts();

    }

});
$(document).ready(function () {
    $('#add_user_form').on('submit', function (e) {
        e.preventDefault(); // stop form submit initially

        const website = $('#my_website').val().trim();
        const app = $('#my_app').val().trim();

        // URL validation regex
        const urlPattern = /^(https?:\/\/)[\w.-]+(\.[\w\.-]+)+[\/#?]?.*$/;

        // check validity
        if (!urlPattern.test(website)) {
            showToast('Please enter a valid Website URL starting with http:// or https://', 'error');
            return false;
        }

        if (!urlPattern.test(app)) {
            showToast('Please enter a valid App URL starting with http:// or https://', 'error');
            return false;
        }

        // if valid → continue with form submission (AJAX or normal)
        this.submit();
    });
});