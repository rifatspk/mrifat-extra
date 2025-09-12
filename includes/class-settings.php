<?php

if (!defined('ABSPATH'))
    exit;

class Mrifat_Extra_Settings
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'add_settings_page']);
        add_action('admin_init', [$this, 'register_settings']);
    }

    public function add_settings_page()
    {
        add_submenu_page(
            'mrifat-contacts',
            'Contact Form Settings',
            'Settings',
            'manage_options',
            'mrifat-contact-settings',
            [$this, 'settings_page']
        );
    }

    public function register_settings()
    {
        register_setting('mrifat_contact_settings', 'mrifat_recaptcha_enabled');
        register_setting('mrifat_contact_settings', 'mrifat_recaptcha_site_key');
        register_setting('mrifat_contact_settings', 'mrifat_recaptcha_secret_key');
        register_setting('mrifat_contact_settings', 'mrifat_admin_email');
        register_setting('mrifat_contact_settings', 'mrifat_email_notifications');
    }

    public function settings_page()
    {
        ?>
        <div class="wrap">
            <h1>Contact Form Settings</h1>

            <form method="post" action="options.php">
                <?php
                settings_fields('mrifat_contact_settings');
                do_settings_sections('mrifat_contact_settings');
                ?>

                <table class="form-table">
                    <tr>
                        <th scope="row">Admin Email</th>
                        <td>
                            <input type="email" name="mrifat_admin_email"
                                value="<?php echo esc_attr(get_option('mrifat_admin_email', get_option('admin_email'))); ?>"
                                class="regular-text" />
                            <p class="description">Email address to receive contact form notifications</p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">Email Notifications</th>
                        <td>
                            <label>
                                <input type="checkbox" name="mrifat_email_notifications" value="1" <?php checked(get_option('mrifat_email_notifications', 1), 1); ?> />
                                Send email notifications for new contacts
                            </label>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">Enable reCAPTCHA</th>
                        <td>
                            <label>
                                <input type="checkbox" name="mrifat_recaptcha_enabled" value="1" <?php checked(get_option('mrifat_recaptcha_enabled', 0), 1); ?> />
                                Enable Google reCAPTCHA v2
                            </label>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">reCAPTCHA Site Key</th>
                        <td>
                            <input type="text" name="mrifat_recaptcha_site_key"
                                value="<?php echo esc_attr(get_option('mrifat_recaptcha_site_key')); ?>" class="regular-text" />
                            <p class="description">Get your keys from <a href="https://www.google.com/recaptcha/admin"
                                    target="_blank">Google reCAPTCHA</a></p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">reCAPTCHA Secret Key</th>
                        <td>
                            <input type="text" name="mrifat_recaptcha_secret_key"
                                value="<?php echo esc_attr(get_option('mrifat_recaptcha_secret_key')); ?>"
                                class="regular-text" />
                        </td>
                    </tr>
                </table>

                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
}