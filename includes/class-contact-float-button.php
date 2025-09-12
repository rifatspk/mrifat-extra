<?php

class MRifat_WhatsApp_Button {
    
    private $option_name = 'mrifat_whatsapp_settings';
    
    public function __construct() {
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('wp_footer', [$this, 'display_whatsapp_button']);
        add_action('admin_init', [$this, 'register_settings']);
    }
    
    public function add_admin_menu() {
        add_submenu_page(
            'mrifat-contacts',
            'WhatsApp Button Settings',
            'WhatsApp Button',
            'manage_options',
            'mrifat-whatsapp-settings',
            [$this, 'settings_page']
        );
    }
    
    public function register_settings() {
        register_setting('mrifat_whatsapp_group', $this->option_name);
    }
    
    public function settings_page() {
        $settings = get_option($this->option_name, [
            'phone_number' => '',
            'position' => 'bottom-left',
            'message' => 'Hello! I need help.'
        ]);
        ?>
        <div class="wrap">
            <h1>WhatsApp Button Settings</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('mrifat_whatsapp_group');
                do_settings_sections('mrifat_whatsapp_group');
                ?>
                <table class="form-table">
                    <tr>
                        <th scope="row">WhatsApp Number</th>
                        <td>
                            <input type="text" 
                                   name="<?php echo $this->option_name; ?>[phone_number]" 
                                   value="<?php echo esc_attr($settings['phone_number']); ?>" 
                                   placeholder="e.g., +1234567890" 
                                   class="regular-text" />
                            <p class="description">Enter your WhatsApp number with country code (e.g., +1234567890)</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Button Position</th>
                        <td>
                            <select name="<?php echo $this->option_name; ?>[position]">
                                <option value="bottom-left" <?php selected($settings['position'], 'bottom-left'); ?>>Bottom Left</option>
                                <option value="bottom-right" <?php selected($settings['position'], 'bottom-right'); ?>>Bottom Right</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Default Message</th>
                        <td>
                            <input type="text" 
                                   name="<?php echo $this->option_name; ?>[message]" 
                                   value="<?php echo esc_attr($settings['message']); ?>" 
                                   class="regular-text" />
                            <p class="description">Pre-filled message when user clicks the button</p>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
    
    public function display_whatsapp_button() {
        $settings = get_option($this->option_name);
        
        if (empty($settings['phone_number'])) {
            return;
        }
        
        $phone = $settings['phone_number'];
        $message = urlencode($settings['message']);
        $position = $settings['position'] ?? 'bottom-left';
        $whatsapp_url = "https://wa.me/{$phone}?text={$message}";
        ?>
        <div class="mrifat-whatsapp-button mrifat-whatsapp-<?php echo esc_attr($position); ?>">
            <a href="<?php echo esc_url($whatsapp_url); ?>" target="_blank" rel="noopener">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.465 3.488"/>
                </svg>
            </a>
        </div>
        <?php
    }
}