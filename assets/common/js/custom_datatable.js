

// Define a global namespace for datatable utilities
window.DatatableUtils = {
    // Public method to refresh a specific datatable by ID or all datatables
    refreshDatatable: function (tableId = null) {
        if (tableId && $.fn.DataTable.isDataTable('#' + tableId)) {
            // Refresh specific table if ID is provided and table exists
            $('#' + tableId).DataTable().ajax.reload(function () {
                console.log('Datatable ' + tableId + ' refreshed successfully');
            }, false);
        } else {
            // Refresh all datatables if no ID provided or table not found
            const datatables = $.fn.dataTable.tables();
            if (datatables.length > 0) {
                $(datatables).each(function () {
                    $(this).DataTable().ajax.reload(function () {
                        console.log('Datatable refreshed successfully');
                    }, false);
                });
            }
        }
    }
};

document.addEventListener("DOMContentLoaded", function () {

    // Show spinner on AJAX start, hide on complete
    $(document).on('ajaxStart', function () {
        $('#datatable-loading').removeClass('d-none');
    }).on('ajaxStop', function () {
        $('#datatable-loading').addClass('d-none');
    });
    // Reset filters
    $('#resetFilters').on('click', function () {
        $('#statusFilter, #brandFilter, #categoryFilter').val('');
        $('#reportrange').val('');
        // Trigger filter update if needed
    });


    const datatableElements = document.querySelectorAll("[data-datatable]");

    datatableElements.forEach((el) => {
        const route = el.getAttribute("data-route");
        const columns = JSON.parse(el.getAttribute("data-columns"));
        const options = el.getAttribute("data-options")
            ? JSON.parse(el.getAttribute("data-options"))
            : {};

        // Check if the DataTable is already initialized
        if ($.fn.DataTable.isDataTable(el)) {
            return; // Skip initialization if already initialized
        }


        // Default options
        let defaultOptions = {
            language: {
                emptyTable: "<div class='text-center text-secondary p-3'><i class='ti ti-database fs-1'></i><br>No data available.</div>"
            },
            select: false,
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: route,
                type: "POST",
            },
            columns: columns,
            
        };

        // Merge options (user defined overrides defaults)
        let finalOptions = Object.assign({}, defaultOptions, options);

        // Initialize DataTable
        $(el).DataTable(finalOptions);
    });
});

$(document).ready(function () {
    // Add click event listener for refresh button
    $('#refresh, .refresh-table').on('click', function () {
        // Try to find the closest datatable to the clicked button
        const closestTable = $(this).closest('.card').find('table.dataTable');

        if (closestTable.length > 0) {
            // If found, refresh only that table
            const tableId = closestTable.attr('id');
            if (tableId) {
                // Use the global method to refresh the specific table
                window.DatatableUtils.refreshDatatable(tableId);
                return;
            }
        }

        // If no specific table found, refresh all datatables
        window.DatatableUtils.refreshDatatable();
    });
});