<?php

if (!defined('ABSPATH'))
    exit;

class Mrifat_Extra_Admin
{
    private $database;

    public function __construct()
    {
        $this->database = new Mrifat_Extra_Database();

        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_scripts']);
        add_action('wp_ajax_mrifat_delete_contact', [$this, 'ajax_delete_contact']);
        add_action('wp_ajax_mrifat_update_status', [$this, 'ajax_update_status']);
        add_action('wp_ajax_mrifat_get_contact_details', [$this, 'ajax_get_contact_details']);
    }

    public function add_admin_menu()
    {
        add_menu_page(
            'Contacts',
            'Contacts',
            'manage_options',
            'mrifat-contacts',
            [$this, 'admin_page'],
            'dashicons-email-alt',
            26
        );
    }

    public function enqueue_admin_scripts($hook)
    {
        if ($hook !== 'toplevel_page_mrifat-contacts') {
            return;
        }

        wp_enqueue_style(
            'mrifat-admin-inbox-css',
            MRIFAT_EXTRA_URL . 'assets/css/admin.css',
            [],
            '1.0.0'
        );

        wp_enqueue_script(
            'mrifat-admin-inbox-js',
            MRIFAT_EXTRA_URL . 'assets/js/admin.js',
            ['jquery'],
            '1.0.0',
            true
        );

        wp_localize_script('mrifat-admin-inbox-js', 'mrifat_admin_ajax', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('mrifat_admin_nonce')
        ]);
    }

    public function admin_page()
    {
        $contacts = $this->database->get_contacts(100, 0);
        $total_contacts = $this->database->get_contact_count();

        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline">Contacts</h1>
            <hr class="wp-header-end">

            <?php if (empty($contacts)): ?>
                <div class="notice notice-info">
                    <p>No contact messages found.</p>
                </div>
            <?php else: ?>
                <div class="mrifat-inbox-container">
                    <div class="mrifat-inbox-sidebar">
                        <div class="mrifat-inbox-header">
                            Messages (<?php echo $total_contacts; ?>)
                        </div>
                        <ul class="mrifat-inbox-list">
                            <?php foreach ($contacts as $contact): ?>
                                <li class="mrifat-inbox-item <?php echo $contact->status === 'unread' ? 'unread' : ''; ?>"
                                    data-id="<?php echo $contact->id; ?>">
                                    <div class="mrifat-inbox-sender">
                                        <?php echo esc_html($contact->name); ?>
                                    </div>
                                    <div class="mrifat-inbox-subject">
                                        <?php echo esc_html($contact->subject); ?>
                                    </div>
                                    <div class="mrifat-inbox-meta">
                                        <span><?php echo human_time_diff(strtotime($contact->created_at), current_time('timestamp')); ?>
                                            ago</span>
                                        <span class="mrifat-inbox-status <?php echo $contact->status; ?>">
                                            <?php echo $contact->status; ?>
                                        </span>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <div class="mrifat-inbox-content">
                        <div class="mrifat-inbox-empty">
                            Select a message to view
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }

    public function ajax_get_contact_details()
    {
        check_ajax_referer('mrifat_admin_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }

        $contact_id = intval($_POST['contact_id']);
        global $wpdb;
        $table_name = $wpdb->prefix . 'mrifat_contacts';

        $contact = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $contact_id));

        if ($contact) {
            ob_start();
            $this->render_contact_details($contact);
            $html = ob_get_clean();
            wp_send_json_success($html);
        } else {
            wp_send_json_error('Contact not found');
        }
    }

    private function render_contact_details($contact)
    {
        ?>
        <div class="mrifat-message-header">
            <h2 class="mrifat-message-title"><?php echo esc_html($contact->subject); ?></h2>
            <div class="mrifat-message-meta">
                <span><strong>From:</strong> <?php echo esc_html($contact->name); ?>
                    &lt;<?php echo esc_html($contact->email); ?>&gt;</span>
                <span><strong>Date:</strong> <?php echo date('M j, Y \a\t g:i A', strtotime($contact->created_at)); ?></span>
                <div class="mrifat-message-actions">
                    <select class="mrifat-status-select" data-id="<?php echo $contact->id; ?>">
                        <option value="unread" <?php selected($contact->status, 'unread'); ?>>Unread</option>
                        <option value="read" <?php selected($contact->status, 'read'); ?>>Read</option>
                        <option value="replied" <?php selected($contact->status, 'replied'); ?>>Replied</option>
                    </select>
                    <button class="mrifat-action-button mrifat-reply-button"
                        data-email="<?php echo esc_attr($contact->email); ?>"
                        data-subject="<?php echo esc_attr($contact->subject); ?>">
                        Reply
                    </button>
                    <button class="mrifat-action-button danger mrifat-delete-button" data-id="<?php echo $contact->id; ?>">
                        Delete
                    </button>
                </div>
            </div>
        </div>

        <div class="mrifat-message-body">
            <div class="mrifat-message-details">
                <h4>Contact Details</h4>
                <div class="mrifat-details-grid">
                    <div class="mrifat-detail-item">
                        <span class="mrifat-detail-label">Name</span>
                        <span class="mrifat-detail-value"><?php echo esc_html($contact->name); ?></span>
                    </div>
                    <div class="mrifat-detail-item">
                        <span class="mrifat-detail-label">Email</span>
                        <span class="mrifat-detail-value"><?php echo esc_html($contact->email); ?></span>
                    </div>
                    <?php if (!empty($contact->business_name)): ?>
                        <div class="mrifat-detail-item">
                            <span class="mrifat-detail-label">Business/Project</span>
                            <span class="mrifat-detail-value"><?php echo esc_html($contact->business_name); ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($contact->service)): ?>
                        <div class="mrifat-detail-item">
                            <span class="mrifat-detail-label">Service</span>
                            <span class="mrifat-detail-value"><?php echo esc_html($contact->service); ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($contact->timeline)): ?>
                        <div class="mrifat-detail-item">
                            <span class="mrifat-detail-label">Timeline</span>
                            <span class="mrifat-detail-value"><?php echo esc_html($contact->timeline); ?></span>
                        </div>
                    <?php endif; ?>
                    <div class="mrifat-detail-item">
                        <span class="mrifat-detail-label">Website Audit</span>
                        <span class="mrifat-detail-value"><?php echo esc_html($contact->website_audit); ?></span>
                    </div>
                    <div class="mrifat-detail-item">
                        <span class="mrifat-detail-label">IP Address</span>
                        <span class="mrifat-detail-value"><?php echo esc_html($contact->ip_address); ?></span>
                    </div>
                </div>
            </div>

            <div class="mrifat-message-text">
                <h4>Message</h4>
                <div><?php echo nl2br(esc_html($contact->message)); ?></div>
            </div>
        </div>
        <?php
    }

    public function ajax_delete_contact()
    {
        check_ajax_referer('mrifat_admin_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }

        $contact_id = intval($_POST['contact_id']);
        $result = $this->database->delete_contact($contact_id);

        if ($result) {
            wp_send_json_success('Contact deleted successfully');
        } else {
            wp_send_json_error('Failed to delete contact');
        }
    }

    public function ajax_update_status()
    {
        check_ajax_referer('mrifat_admin_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }

        $contact_id = intval($_POST['contact_id']);
        $status = sanitize_text_field($_POST['status']);

        $result = $this->database->update_status($contact_id, $status);

        if ($result) {
            wp_send_json_success('Status updated successfully');
        } else {
            wp_send_json_error('Failed to update status');
        }
    }
}