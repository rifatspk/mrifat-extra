<?php
$form_title = isset($attributes['formTitle']) ? $attributes['formTitle'] : 'Get In Touch';
$show_title = isset($attributes['showTitle']) ? $attributes['showTitle'] : true;
$form_alignment = isset($attributes['formAlignment']) ? $attributes['formAlignment'] : 'left';

$wrapper_attributes = get_block_wrapper_attributes([
    'class' => 'mrifat-contact-form-wrapper alignment-' . $form_alignment
]);

$recaptcha_enabled = get_option('mrifat_recaptcha_enabled', 0);
$recaptcha_site_key = get_option('mrifat_recaptcha_site_key', '');
?>

<div <?php echo $wrapper_attributes; ?>>
    <?php if ($show_title): ?>
        <h3 class="mrifat-form-title"><?php echo esc_html($form_title); ?></h3>
    <?php endif; ?>

    <form id="mrifat-contact-form" method="post" class="mrifat-contact-form">
        <?php wp_nonce_field('mrifat_contact_nonce', 'mrifat_contact_nonce'); ?>

        <div class="mrifat-form-message" style="display: none;"></div>

        <div class="mrifat-form-row">
            <div class="mrifat-form-group">
                <label for="mrifat_name">Name <span class="required">*</span></label>
                <input type="text" id="mrifat_name" name="name" placeholder="Your full name" required>
            </div>
            <div class="mrifat-form-group">
                <label for="mrifat_email">Email <span class="required">*</span></label>
                <input type="email" id="mrifat_email" name="email" placeholder="your@email.com" required>
            </div>
        </div>

        <div class="mrifat-form-row">
            <div class="mrifat-form-group">
                <label for="mrifat_business_name">Your Business / Project Name</label>
                <input type="text" id="mrifat_business_name" name="business_name"
                    placeholder="Your business or project name">
            </div>
            <div class="mrifat-form-group">
                <label for="mrifat_service">Service</label>
                <select id="mrifat_service" name="service">
                    <option value="">Select service</option>
                    <option value="business-website-design">Business Website Design (WordPress)</option>
                    <option value="business-tool-customization">Business Tool Customization & Automation</option>
                    <option value="website-speed-fixes">Website Speed & Technical Fixes</option>
                    <option value="shopify-ecommerce-design">Shopify Ecommerce Store Design</option>
                    <option value="custom-laravel-ecommerce">Custom Laravel E-commerce App</option>
                    <option value="ecommerce-website-wordpress">Ecommerce website design (WordPress)</option>
                </select>
            </div>
        </div>

        <div class="mrifat-form-row">
            <div class="mrifat-form-group">
                <label for="mrifat_subject">Subject <span class="required">*</span></label>
                <input type="text" id="mrifat_subject" name="subject" placeholder="What's this about?" required>
            </div>
            <div class="mrifat-form-group">
                <label for="mrifat_timeline">Timeline</label>
                <select id="mrifat_timeline" name="timeline">
                    <option value="">Select timeline</option>
                    <option value="asap">ASAP</option>
                    <option value="1-2-weeks">1-2 weeks</option>
                    <option value="1-month">1 month</option>
                    <option value="2-3-months">2-3 months</option>
                    <option value="flexible">Flexible</option>
                </select>
            </div>
        </div>

        <div class="mrifat-form-group">
            <label for="mrifat_message">Message <span class="required">*</span></label>
            <textarea id="mrifat_message" name="message" rows="6"
                placeholder="Tell me about your project, goals, and any specific requirements..." required></textarea>
        </div>

        <div class="mrifat-form-group">
            <label class="mrifat-radio-label">Want a FREE website audit? (Recommended)</label>
            <div class="mrifat-radio-group">
                <label class="mrifat-radio-option">
                    <input type="radio" name="website_audit" value="yes" checked>
                    <span>Yes</span>
                </label>
                <label class="mrifat-radio-option">
                    <input type="radio" name="website_audit" value="no">
                    <span>No</span>
                </label>
            </div>
        </div>

        <?php if ($recaptcha_enabled && !empty($recaptcha_site_key)): ?>
            <div class="mrifat-form-group">
                <div class="g-recaptcha" data-sitekey="<?php echo esc_attr($recaptcha_site_key); ?>"></div>
            </div>
        <?php endif; ?>

        <div class="mrifat-form-group">
            <label class="mrifat-checkbox-label">
                <input type="checkbox" name="privacy_policy" required>
                <span>I accept the privacy policy <span class="required">*</span></span>
            </label>
        </div>

        <div class="mrifat-button-wrapper">
            <button type="submit" class="mrifat-submit-button">
                <span class="mrifat-button-text">Send Message</span>
                <span class="mrifat-button-loading" style="display: none;">Sending...</span>
            </button>
        </div>
    </form>
</div>