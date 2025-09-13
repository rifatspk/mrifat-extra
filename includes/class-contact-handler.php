<?php

if (!defined('ABSPATH'))
    exit;

class Mrifat_Extra_Form_Handler
{
    private $database;

    public function __construct()
    {
        $this->database = new Mrifat_Extra_Database();

        add_action('wp_ajax_mrifat_submit_contact', [$this, 'handle_form_submission']);
        add_action('wp_ajax_nopriv_mrifat_submit_contact', [$this, 'handle_form_submission']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
    }

    public function enqueue_scripts()
    {
        wp_enqueue_script('mrifat-particle-lib', MRIFAT_EXTRA_URL . 'assets/js/particles.min.js', [], '1.0.0', true);
        wp_enqueue_script('mrifat-particle-wrapper', 'https://cdn.jsdelivr.net/npm/@tsparticles/jquery', [], '1.0.0', true);
        wp_enqueue_script('mrifat-particle-script', MRIFAT_EXTRA_URL . 'assets/js/particle-script.js', [], '1.0.0', true);
        wp_enqueue_script('mrifat-extra-script', MRIFAT_EXTRA_URL . 'assets/js/script.js', [], '1.0.0', true);
        wp_localize_script('mrifat-extra-script', 'mrifat_contact_ajax', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('mrifat_contact_nonce'),
            'recaptcha_enabled' => get_option('mrifat_recaptcha_enabled', 0),
            'recaptcha_site_key' => get_option('mrifat_recaptcha_site_key', '')
        ]);

        if (get_option('mrifat_recaptcha_enabled', 0) && get_option('mrifat_recaptcha_site_key')) {
            wp_enqueue_script('google-recaptcha', 'https://www.google.com/recaptcha/api.js', [], null, true);
        }
    }

    public function handle_form_submission()
    {
        check_ajax_referer('mrifat_contact_nonce', 'mrifat_contact_nonce');

        // Basic validation
        if (!isset($_POST['privacy_policy']) || $_POST['privacy_policy'] !== 'on') {
            wp_send_json_error('You must accept the privacy policy.');
        }

        // reCAPTCHA validation
        if (get_option('mrifat_recaptcha_enabled', 0)) {
            if (empty($_POST['g-recaptcha-response'])) {
                wp_send_json_error('Please complete the reCAPTCHA verification.');
            }
            if (!$this->verify_recaptcha($_POST['g-recaptcha-response'])) {
                wp_send_json_error('reCAPTCHA verification failed. Please try again.');
            }
        }

        $form_name = sanitize_text_field($_POST['form_name'] ?? 'Unnamed Form');
        $email_body = "You have received a new submission from the '" . $form_name . "' form.\n\n";
        $submitted_data = [];
        $ignore_fields = ['action', 'mrifat_contact_nonce', '_wp_http_referer', 'form_name', 'g-recaptcha-response', 'privacy_policy'];

        // Loop through all submitted fields
        foreach ($_POST as $key => $value) {
            if (in_array($key, $ignore_fields)) {
                continue;
            }

            $label = ucwords(str_replace('_', ' ', $key));
            if (is_array($value)) {
                $sanitized_value = implode(', ', array_map('sanitize_text_field', $value));
            } else {
                $sanitized_value = sanitize_textarea_field($value);
            }

            $submitted_data[$key] = $sanitized_value;
            $email_body .= esc_html($label) . ": " . esc_html($sanitized_value) . "\n";
        }

        // Find a required email field for reply-to header
        $reply_to_email = get_option('admin_email');
        if (!empty($submitted_data['email'])) {
             if (is_email($submitted_data['email'])) {
                $reply_to_email = $submitted_data['email'];
             }
        } else {
            // Fallback to find any field with 'email' in the name
            foreach($submitted_data as $key => $value) {
                if (strpos($key, 'email') !== false && is_email($value)) {
                    $reply_to_email = $value;
                    break;
                }
            }
        }
        
        $name = $submitted_data['name'] ?? 'N/A';

        // Prepare data for database (storing all dynamic fields in the message body)
        $contact_data = [
            'name' => $name,
            'email' => $reply_to_email,
            'subject' => 'Submission from ' . $form_name,
            'message' => $email_body, // Store the full submission body
            'privacy_policy' => 'yes',
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'created_at' => current_time('mysql'),
            'status' => 'unread'
        ];

        $contact_id = $this->database->insert_contact($contact_data);

        if ($contact_id) {
            if (get_option('mrifat_email_notifications', 1)) {
                $this->send_email_notification($contact_data, $reply_to_email, $name);
            }
            wp_send_json_success('Thank you for your message. We will get back to you soon!');
        } else {
            wp_send_json_error('Sorry, there was an error submitting your message. Please try again.');
        }
    }

    private function verify_recaptcha($response)
    {
        $secret_key = get_option('mrifat_recaptcha_secret_key');
        if (empty($secret_key)) return false;

        $response = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', [
            'body' => [
                'secret' => $secret_key,
                'response' => $response,
                'remoteip' => $_SERVER['REMOTE_ADDR']
            ]
        ]);

        if (is_wp_error($response)) return false;

        $result = json_decode(wp_remote_retrieve_body($response), true);
        return isset($result['success']) && $result['success'] === true;
    }

    private function send_email_notification($contact_data, $reply_to_email, $reply_to_name)
    {
        $admin_email = get_option('mrifat_admin_email', get_option('admin_email'));
        $site_name = get_bloginfo('name');
        $subject = 'New Submission from ' . $site_name . ': ' . $contact_data['subject'];

        $headers = [
            'Content-Type: text/plain; charset=UTF-8',
            'From: ' . $site_name . ' <' . get_option('admin_email') . '>',
            'Reply-To: ' . $reply_to_name . ' <' . $reply_to_email . '>'
        ];

        // The message is already pre-formatted in the main handler
        wp_mail($admin_email, $subject, $contact_data['message'], $headers);
    }
}