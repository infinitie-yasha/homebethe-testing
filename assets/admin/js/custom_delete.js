"use strict";

document.addEventListener('alpine:init', () => {
    Alpine.data('ajaxDelete', (config = {}) => ({
        url: config.url || '',
        id: config.id || null,
        status: config.status || null,
        tableSelector: config.tableSelector || null,
        confirmTitle: config.confirmTitle || 'Are You Sure!',
        confirmMessage: config.confirmMessage || "You won't be able to revert this!",
        confirmOkText: config.confirmOkText || 'Yes, delete it!',
        confirmCancelText: config.confirmCancelText || 'Cancel',
        loadingText: config.loadingText || 'Deleting...',
        isLoading: false,

        async deleteItem(event) {
            event?.preventDefault();

            if (!this.url) {
                console.error("Delete URL is required!");
                return;
            }

            Notiflix.Confirm.show(
                this.confirmTitle,
                this.confirmMessage,
                this.confirmOkText,
                this.confirmCancelText,
                async () => {
                    this.isLoading = true;
                    Notiflix.Loading.standard(this.loadingText);

                    try {
                        const response = await axios.get(this.url, {
                            params: { id: this.id, status: this.status },
                            headers: { 'X-Requested-With': 'XMLHttpRequest' }
                        });

                        const res = response.data;

                        if (res.error === false) {
                            showToast(res.message, 'success');
                        } else {
                            showToast(res.message, 'warning');
                        }

                        if (this.tableSelector) {
                            $(this.tableSelector).bootstrapTable('refresh');
                        } else {
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        }
                    } catch (err) {
                        console.error(err);
                        showToast('Something went wrong while deleting!', 'error');
                    } finally {
                        Notiflix.Loading.remove();
                        this.isLoading = false;
                    }
                },
                () => {
                    showToast('Cancelled! Your data is safe.', 'info');
                }
            );
        }
    }));

    // Alpine.js component for bulk media deletion
    Alpine.data('bulkMediaDelete', (config = {}) => ({
        url: config.url || '',
        tableSelector: config.tableSelector || '#media-table',
        confirmTitle: config.confirmTitle || 'Delete Selected Media',
        confirmMessage: config.confirmMessage || "Are you sure you want to delete the selected media items?",
        confirmOkText: config.confirmOkText || 'Yes, delete them!',
        confirmCancelText: config.confirmCancelText || 'Cancel',
        loadingText: config.loadingText || 'Deleting...',
        isLoading: false,

        async deleteSelected() {
            const selectedRows = $(this.tableSelector).bootstrapTable('getSelections');

            if (selectedRows.length === 0) {
                showToast('Please select at least one media item to delete.', 'warning');
                return;
            }

            const ids = selectedRows.map(row => row.id);

            Notiflix.Confirm.show(
                this.confirmTitle,
                `${this.confirmMessage} (${ids.length} item${ids.length > 1 ? 's' : ''})`,
                this.confirmOkText,
                this.confirmCancelText,
                async () => {
                    this.isLoading = true;
                    Notiflix.Loading.standard(this.loadingText);

                    try {
                        const response = await axios.post(this.url, {
                            ids: ids,
                            [csrfName]: csrfHash
                        }, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Content-Type': 'application/x-www-form-urlencoded'
                            }
                        });

                        const res = response.data;


                        if (res.error === false) {
                            showToast(res.message, 'success');

                            // Remove selected rows from table
                            $(this.tableSelector).bootstrapTable('remove', {
                                field: 'id',
                                values: ids
                            });

                            // Refresh table
                            $(this.tableSelector).bootstrapTable('refresh');
                        } else {
                            showToast(res.message, 'warning');
                        }
                    } catch (err) {
                        console.error(err);
                        showToast('Something went wrong while deleting!', 'error');
                    } finally {
                        Notiflix.Loading.remove();
                        this.isLoading = false;
                    }
                },
                () => {
                    showToast('Cancelled! Your data is safe.', 'info');
                }
            );
        }
    }));
});


