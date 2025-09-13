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
        check_ajax_referer('mrifat_contact_nonce', 'nonce');

        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_email($_POST['email']);
        $business_name = sanitize_text_field($_POST['business_name']);
        $service = sanitize_text_field($_POST['service']);
        $subject = sanitize_text_field($_POST['subject']);
        $timeline = sanitize_text_field($_POST['timeline']);
        $message = sanitize_textarea_field($_POST['message']);
        $website_audit = sanitize_text_field($_POST['website_audit']);
        $privacy_policy = isset($_POST['privacy_policy']) ? 'yes' : 'no';

        // Validation
        if (empty($name) || empty($email) || empty($subject) || empty($message)) {
            wp_send_json_error('Please fill in all required fields.');
        }

        if (!is_email($email)) {
            wp_send_json_error('Please enter a valid email address.');
        }

        if ($privacy_policy !== 'yes') {
            wp_send_json_error('You must accept the privacy policy.');
        }

        // reCAPTCHA validation
        if (get_option('mrifat_recaptcha_enabled', 0)) {
            $recaptcha_response = $_POST['g-recaptcha-response'];

            if (empty($recaptcha_response)) {
                wp_send_json_error('Please complete the reCAPTCHA verification.');
            }

            if (!$this->verify_recaptcha($recaptcha_response)) {
                wp_send_json_error('reCAPTCHA verification failed. Please try again.');
            }
        }

        // Prepare data for database
        $contact_data = [
            'name' => $name,
            'email' => $email,
            'business_name' => $business_name,
            'service' => $service,
            'subject' => $subject,
            'timeline' => $timeline,
            'message' => $message,
            'website_audit' => $website_audit,
            'privacy_policy' => $privacy_policy,
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'created_at' => current_time('mysql'),
            'status' => 'unread'
        ];

        $contact_id = $this->database->insert_contact($contact_data);

        if ($contact_id) {
            // Send email notification
            if (get_option('mrifat_email_notifications', 1)) {
                $this->send_email_notification($contact_data, $contact_id);
            }

            wp_send_json_success('Thank you for your message. We will get back to you soon!');
        } else {
            wp_send_json_error('Sorry, there was an error submitting your message. Please try again.');
        }
    }

    private function verify_recaptcha($response)
    {
        $secret_key = get_option('mrifat_recaptcha_secret_key');

        if (empty($secret_key)) {
            return false;
        }

        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = [
            'secret' => $secret_key,
            'response' => $response,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        ];

        $options = [
            'body' => $data,
            'timeout' => 10,
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ]
        ];

        $response = wp_remote_post($url, $options);

        if (is_wp_error($response)) {
            return false;
        }

        $body = wp_remote_retrieve_body($response);
        $result = json_decode($body, true);

        return isset($result['success']) && $result['success'] === true;
    }

    private function send_email_notification($contact_data, $contact_id)
    {
        $admin_email = get_option('mrifat_admin_email', get_option('admin_email'));
        $site_name = get_bloginfo('name');

        $subject = 'New Contact Form Submission - ' . $contact_data['subject'];

        $message = "You have received a new contact form submission.\n\n";
        $message .= "Name: " . $contact_data['name'] . "\n";
        $message .= "Email: " . $contact_data['email'] . "\n";
        $message .= "Business/Project: " . $contact_data['business_name'] . "\n";
        $message .= "Service: " . $contact_data['service'] . "\n";
        $message .= "Subject: " . $contact_data['subject'] . "\n";
        $message .= "Timeline: " . $contact_data['timeline'] . "\n";
        $message .= "Website Audit: " . $contact_data['website_audit'] . "\n";
        $message .= "Message:\n" . $contact_data['message'] . "\n\n";
        $message .= "IP Address: " . $contact_data['ip_address'] . "\n";
        $message .= "Submitted on: " . $contact_data['created_at'] . "\n\n";
        $message .= "View all contacts: " . admin_url('admin.php?page=mrifat-contacts');

        $headers = [
            'Content-Type: text/plain; charset=UTF-8',
            'From: ' . $site_name . ' <' . get_option('admin_email') . '>',
            'Reply-To: ' . $contact_data['name'] . ' <' . $contact_data['email'] . '>'
        ];

        wp_mail($admin_email, $subject, $message, $headers);
    }
}