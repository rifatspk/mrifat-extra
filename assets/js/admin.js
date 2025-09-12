class MrifatInbox {
    constructor() {
        this.currentContactId = null;
        this.init();
    }

    init() {
        this.bindEvents();
        this.loadFirstContact();
    }

    bindEvents() {
        jQuery(document).on('click', '.mrifat-inbox-item', this.handleContactClick.bind(this));
        jQuery(document).on('click', '.mrifat-reply-button', this.handleReplyClick.bind(this));
        jQuery(document).on('click', '.mrifat-delete-button', this.handleDeleteClick.bind(this));
        jQuery(document).on('change', '.mrifat-status-select', this.handleStatusChange.bind(this));
    }

    handleContactClick(e) {
        e.preventDefault();
        const contactId = jQuery(e.currentTarget).data('id');
        this.loadContact(contactId);
    }

    loadContact(contactId) {
        if (contactId === this.currentContactId) return;

        this.currentContactId = contactId;
        this.updateActiveItem(contactId);
        this.showLoading();

        jQuery.ajax({
            url: mrifat_admin_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'mrifat_get_contact_details',
                contact_id: contactId,
                nonce: mrifat_admin_ajax.nonce
            },
            success: (response) => {
                if (response.success) {
                    this.displayContact(response.data);
                    this.markAsRead(contactId);
                } else {
                    this.showError(response.data);
                }
            },
            error: () => {
                this.showError('Failed to load contact details');
            }
        });
    }

    updateActiveItem(contactId) {
        jQuery('.mrifat-inbox-item').removeClass('active');
        jQuery(`.mrifat-inbox-item[data-id="${contactId}"]`).addClass('active');
    }

    showLoading() {
        jQuery('.mrifat-inbox-content').html('<div class="mrifat-loading"></div>');
    }

    displayContact(contactData) {
        jQuery('.mrifat-inbox-content').html(contactData);
    }

    showError(message) {
        jQuery('.mrifat-inbox-content').html(`
            <div class="mrifat-inbox-empty">
                <p>Error: ${message}</p>
            </div>
        `);
    }

    markAsRead(contactId) {
        const item = jQuery(`.mrifat-inbox-item[data-id="${contactId}"]`);
        if (item.hasClass('unread')) {
            item.removeClass('unread');
            item.find('.mrifat-inbox-status').removeClass('unread').addClass('read').text('read');

            jQuery.ajax({
                url: mrifat_admin_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'mrifat_update_status',
                    contact_id: contactId,
                    status: 'read',
                    nonce: mrifat_admin_ajax.nonce
                }
            });
        }
    }

    handleReplyClick(e) {
        e.preventDefault();
        const email = jQuery(e.currentTarget).data('email');
        const subject = jQuery(e.currentTarget).data('subject');
        window.location.href = `mailto:${email}?subject=Re: ${subject}`;
    }

    handleDeleteClick(e) {
        e.preventDefault();
        if (!confirm('Are you sure you want to delete this contact?')) return;

        const contactId = jQuery(e.currentTarget).data('id');

        jQuery.ajax({
            url: mrifat_admin_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'mrifat_delete_contact',
                contact_id: contactId,
                nonce: mrifat_admin_ajax.nonce
            },
            success: (response) => {
                if (response.success) {
                    jQuery(`.mrifat-inbox-item[data-id="${contactId}"]`).remove();
                    jQuery('.mrifat-inbox-content').html('<div class="mrifat-inbox-empty">Select a message to view</div>');
                    this.currentContactId = null;
                    this.loadFirstContact();
                } else {
                    alert('Error: ' + response.data);
                }
            }
        });
    }

    handleStatusChange(e) {
        const contactId = jQuery(e.currentTarget).data('id');
        const status = jQuery(e.currentTarget).val();

        jQuery.ajax({
            url: mrifat_admin_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'mrifat_update_status',
                contact_id: contactId,
                status: status,
                nonce: mrifat_admin_ajax.nonce
            },
            success: (response) => {
                if (response.success) {
                    const item = jQuery(`.mrifat-inbox-item[data-id="${contactId}"]`);
                    item.find('.mrifat-inbox-status').removeClass('unread read replied').addClass(status).text(status);
                }
            }
        });
    }

    loadFirstContact() {
        const firstContact = jQuery('.mrifat-inbox-item:first');
        if (firstContact.length > 0) {
            firstContact.trigger('click');
        }
    }
}

jQuery(document).ready(() => {
    if (jQuery('.mrifat-inbox-container').length > 0) {
        new MrifatInbox();
    }
});