"use strict";
/**
 * UNIVERSAL FILTER OFFCANVAS SYSTEM
 * =================================
 * 
 * This system provides a reusable offcanvas filter functionality for all bootstrap tables.
 * The offcanvas body itself is a form, making it cleaner and more semantic.
 * 
 * HOW TO USE:
 * 1. Add data attributes to your table element:
 *    - data-filter-template="yourFilterTemplateId" (required)
 *    - data-filter-title="Your Filter Title" (optional, defaults to "Filters")
 *    - data-filter-button-text="🔍 Your Button Text" (optional, defaults to "🔍 Filter")
 *    - data-filter-button-icon="ti-your-icon" (optional, defaults to "ti-filter")
 * 
 * 2. Create a hidden filter template with your form content (NO form tag needed):
 *    <div id="yourFilterTemplateId" class="d-none">
 *        <!-- Your filter inputs here with 'name' attributes -->
 *        <div class="mb-3">
 *            <label for="status" class="form-label">Status</label>
 *            <select name="status" class="form-select">
 *                <option value="">All</option>
 *                <option value="active">Active</option>
 *            </select>
 *        </div>
 *        <div class="mt-4 pt-3 border-top">
 *            <button type="button" onclick="clearFilters()">Clear All</button>
 *            <button type="button" onclick="applyFilters()">Apply Filters</button>
 *        </div>
 *    </div>
 * 
 * 3. The system will automatically:
 *    - Add a filter button to your table toolbar
 *    - Open offcanvas with your filter content injected into the form
 *    - Apply filters by sending form data as query parameters
 *    - Clear all filters and refresh table
 */

// Auto-init DataTables for all tables with [data-datatable]
$('.table-striped').each(function () {
    const table = $(this);
    const tableId = table.attr('id');
    const filterTemplateId = table.data('filter-template') || 'filterTemplate';
    const filterTitle = table.data('filter-title') || 'Filters';
    const filterButtonText = table.data('filter-button-text') || '🔍 Filter';
    const filterButtonIcon = table.data('filter-button-icon') || 'ti-filter';

    // Check if filter template exists and has meaningful content
    const filterTemplate = document.getElementById(filterTemplateId);
    let hasFilterContent = false;

    if (filterTemplate) {
        // Check if template has actual filter inputs (not just empty divs)
        const filterInputs = filterTemplate.querySelectorAll('input, select, textarea');
        const hasVisibleInputs = Array.from(filterInputs).some(input => {
            // Check if input is not hidden and has meaningful options/content
            if (input.type === 'hidden') return false;
            if (input.tagName === 'SELECT') {
                // Check if select has more than just placeholder options
                const options = Array.from(input.options);
                const hasRealOptions = options.some(option => {
                    const value = option.value.trim();
                    const text = option.textContent.trim();
                    // Skip empty values and placeholder text like "Select...", "Choose...", etc.
                    return value !== '' &&
                        !text.toLowerCase().includes('select') &&
                        !text.toLowerCase().includes('choose') &&
                        !text.toLowerCase().includes('no') && // Skip "No Categories Exist" etc.
                        text !== 'All';
                });
                return hasRealOptions;
            }
            return true; // For other input types, assume they have content
        });
        hasFilterContent = hasVisibleInputs;
    }

    // Prepare buttons configuration
    const buttonsConfig = {};

    // Only add filter button if template exists and has content
    if (hasFilterContent) {
        console.log(`Filter button will be shown for table '${tableId}' - filter template has content`);
        buttonsConfig.myCustom = {
            text: filterButtonText,
            icon: filterButtonIcon,
            event: function () {
                // Check if filter template exists
                const filterTemplate = document.getElementById(filterTemplateId);
                if (filterTemplate) {
                    let filterContent = filterTemplate.innerHTML;
                    openOffcanvas(filterContent, filterTitle, tableId);
                } else {
                    console.warn(`Filter template with ID '${filterTemplateId}' not found for table '${tableId}'`);
                    if (typeof showToast === 'function') {
                        showToast('Filter template not found!', 'error');
                    }
                }
            },
            attributes: {
                title: `Open ${filterTitle}`,
            }
        };
    } else {
        console.log(`Filter button will be hidden for table '${tableId}' - no filter content found`);
    }

    // Initialize bootstrap table with dynamic configuration
    table.bootstrapTable({
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
        toolbar: '#custom-toolbar',
        buttons: buttonsConfig,
        formatNoMatches: function () {
            return '⚠️ No records available at the moment';
        }
    });
});

// Define global function for opening offcanvas with dynamic content
function openOffcanvas(content, title = 'Panel', tableId = null) {
    // Clear previous content
    document.getElementById('filterOffcanvasForm').innerHTML = '';

    // Set new content and title
    document.getElementById('filterOffcanvasForm').innerHTML = content;
    document.getElementById('filterOffcanvasLabel').textContent = title;

    // Ensure the form has the offcanvas-body class for proper styling
    // document.getElementById('filterOffcanvasForm').classList.add('offcanvas-body');

    // Store table ID for later use in filter functions
    if (tableId) {
        document.getElementById('filterOffcanvasForm').setAttribute('data-current-table', tableId);
    }

    // Show the offcanvas using Tabler's approach
    const offcanvasElement = document.getElementById('filterOffcanvas');

    // Method 1: Try Tabler's offcanvas API if available
    if (typeof window.tabler !== 'undefined' && window.tabler.offcanvas) {
        window.tabler.offcanvas.show(offcanvasElement);
    }
    // Method 2: Try Bootstrap 5 API if available
    else if (typeof bootstrap !== 'undefined' && bootstrap.Offcanvas) {
        let myOffcanvas = new bootstrap.Offcanvas(offcanvasElement);
        myOffcanvas.show();
    }
    // Method 3: Manual show using data attributes and classes
    else {
        offcanvasElement.classList.add('show');
        offcanvasElement.setAttribute('aria-modal', 'true');
        offcanvasElement.setAttribute('role', 'dialog');

        // Add backdrop
        const backdrop = document.createElement('div');
        backdrop.className = 'offcanvas-backdrop fade show';
        backdrop.id = 'offcanvasBackdrop';
        document.body.appendChild(backdrop);

        // Add body class to prevent scrolling
        // document.body.classList.add('offcanvas-open');

        // Handle backdrop click
        backdrop.addEventListener('click', function () {
            hideOffcanvas();
        });

        // Handle escape key
        const escapeHandler = function (e) {
            if (e.key === 'Escape') {
                hideOffcanvas();
                document.removeEventListener('keydown', escapeHandler);
            }
        };
        document.addEventListener('keydown', escapeHandler);
    }

    // Initialize any form controls that might need it
    initializeOffcanvasContent();
}

// Function to initialize content after it's loaded into offcanvas
function initializeOffcanvasContent() {
    // Initialize any select2 dropdowns if they exist
    if (typeof $ !== 'undefined' && $.fn.select2) {
        $('#filterOffcanvasForm select').select2({
            dropdownParent: $('#filterOffcanvas'),
            width: '100%'
        });
    }

    // Initialize Alpine.js components after content is loaded
    if (typeof Alpine !== 'undefined') {
        // Use nextTick to ensure DOM is fully updated
        Alpine.nextTick(() => {
            // Re-initialize Alpine.js components in the offcanvas form
            Alpine.initTree(document.getElementById('filterOffcanvasForm'));
        });
    }

    // Initialize Tom Select components manually if needed
    setTimeout(() => {
        // Look for any elements with x-init="initTomSelect"
        const tomSelectElements = document.querySelectorAll('#filterOffcanvasForm [x-init*="initTomSelect"]');
        tomSelectElements.forEach(element => {
            try {
                // Check if Tom Select is already initialized on this element
                if (element.tomselect) {
                    console.log('Tom Select already initialized on element:', element);
                    return;
                }

                // Get the x-init attribute and parse the initTomSelect call
                const initCode = element.getAttribute('x-init');
                if (initCode && initCode.includes('initTomSelect')) {
                    // Extract the parameters from the initTomSelect call
                    const match = initCode.match(/initTomSelect\s*\(\s*({[\s\S]*?})\s*\)/);
                    if (match) {
                        // Parse the parameters object
                        const paramsStr = match[1];
                        const params = eval(`(${paramsStr})`);

                        // Ensure the element reference is correct
                        params.element = element;

                        // Call initTomSelect with the parsed parameters
                        if (typeof initTomSelect === 'function') {
                            console.log('Initializing Tom Select with params:', params);
                            initTomSelect(params);
                        }
                    }
                }
            } catch (error) {
                console.warn('Failed to initialize Tom Select element:', error);
                // Fallback: try to re-initialize Alpine.js for this element
                if (typeof Alpine !== 'undefined' && Alpine.initTree) {
                    try {
                        Alpine.initTree(element);
                    } catch (alpineError) {
                        console.warn('Failed to re-initialize Alpine.js for element:', alpineError);
                    }
                }
            }
        });
    }, 200);
}

// Function to hide offcanvas
function hideOffcanvas() {
    // Clean up Tom Select instances before closing
    cleanupTomSelectInstances();

    const offcanvasElement = document.getElementById('filterOffcanvas');

    // Method 1: Try Tabler's offcanvas API if available
    if (typeof window.tabler !== 'undefined' && window.tabler.offcanvas) {
        window.tabler.offcanvas.hide(offcanvasElement);
    }
    // Method 2: Try Bootstrap 5 API if available
    else if (typeof bootstrap !== 'undefined' && bootstrap.Offcanvas) {
        const offcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement);
        if (offcanvas) {
            offcanvas.hide();
        }
    }
    // Method 3: Manual hide
    else {
        offcanvasElement.classList.remove('show');
        offcanvasElement.removeAttribute('aria-modal');
        offcanvasElement.removeAttribute('role');

        // Remove backdrop
        const backdrop = document.getElementById('offcanvasBackdrop');
        if (backdrop) {
            backdrop.remove();
        }

        // Remove body class
        document.body.classList.remove('offcanvas-open');
    }
}

// Function to clean up Tom Select instances
function cleanupTomSelectInstances() {
    const tomSelectElements = document.querySelectorAll('#filterOffcanvasForm select');
    tomSelectElements.forEach(element => {
        if (element.tomselect) {
            try {
                element.tomselect.destroy();
                console.log('Destroyed Tom Select instance on:', element);
            } catch (error) {
                console.warn('Failed to destroy Tom Select instance:', error);
            }
        }
    });
}

// Function to apply filters to the bootstrap table
function applyFilters() {
    // Get current table ID from offcanvas form
    const currentTableId = document.getElementById('filterOffcanvasForm').getAttribute('data-current-table');

    if (!currentTableId) {
        console.error('No table ID found for applying filters');
        if (typeof showToast === 'function') {
            showToast('Error: No table specified for filters', 'error');
        }
        return;
    }

    // Get all form inputs from the offcanvas form
    const filterForm = document.getElementById('filterOffcanvasForm');

    // Collect all filter values dynamically
    const filterData = {};
    const inputs = filterForm.querySelectorAll('input, select, textarea');

    inputs.forEach(input => {
        if (input.name && input.value) {
            filterData[input.name] = input.value;
        }
    });

    // Update the table with new filter parameters
    const tableElement = $('#' + currentTableId);
    if (tableElement.length && typeof tableElement.bootstrapTable === 'function') {
        tableElement.bootstrapTable('refresh', {
            query: filterData
        });
    } else {
        console.error(`Table with ID '${currentTableId}' not found or not a bootstrap table`);
        if (typeof showToast === 'function') {
            showToast('Error: Table not found', 'error');
        }
        return;
    }

    // Close the offcanvas
    hideOffcanvas();

    // Show success message
    if (typeof showToast === 'function') {
        showToast('Filters applied successfully!', 'success');
    }
}

// Function to clear all filters
function clearFilters() {
    // Get current table ID from offcanvas form
    const currentTableId = document.getElementById('filterOffcanvasForm').getAttribute('data-current-table');

    if (!currentTableId) {
        console.error('No table ID found for clearing filters');
        if (typeof showToast === 'function') {
            showToast('Error: No table specified for filters', 'error');
        }
        return;
    }

    // Reset all form elements in the offcanvas form
    const filterForm = document.getElementById('filterOffcanvasForm');
    const inputs = filterForm.querySelectorAll('input, select, textarea');

    inputs.forEach(input => {
        // Reset input value
        if (input.type === 'checkbox' || input.type === 'radio') {
            input.checked = false;
        } else {
            input.value = '';
        }

        // Trigger change event if select2 is being used
        if ($(input).hasClass('select2-hidden-accessible')) {
            $(input).trigger('change');
        }

        // Trigger change event for Tom Select
        if (input.tomselect) {
            input.tomselect.clear();
            input.tomselect.clearOptions();
        }
    });

    // Refresh table without filters
    const tableElement = $('#' + currentTableId);
    if (tableElement.length && typeof tableElement.bootstrapTable === 'function') {
        tableElement.bootstrapTable('refresh', {
            query: {}
        });
    }

    // Show success message
    if (typeof showToast === 'function') {
        showToast('All filters cleared!', 'info');
    }
}


