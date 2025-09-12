<?php

if (!defined('ABSPATH')) {
    exit;
}

class Mrifat_Contact_Form_Widget extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'mrifat-contact-form';
    }

    public function get_title()
    {
        return esc_html__('Mrifat Contact Form', 'mrifat-extra');
    }

    public function get_icon()
    {
        return 'eicon-form-horizontal';
    }

    public function get_categories()
    {
        return ['mrifat-widgets'];
    }

    public function get_keywords()
    {
        return ['contact', 'form', 'email', 'message', 'mrifat'];
    }

    protected function register_controls()
    {
        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Form Fields', 'mrifat-extra'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_business_name',
            [
                'label' => esc_html__('Show Business Name Field', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'mrifat-extra'),
                'label_off' => esc_html__('Hide', 'mrifat-extra'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_service_field',
            [
                'label' => esc_html__('Show Service Field', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'mrifat-extra'),
                'label_off' => esc_html__('Hide', 'mrifat-extra'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_timeline_field',
            [
                'label' => esc_html__('Show Timeline Field', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'mrifat-extra'),
                'label_off' => esc_html__('Hide', 'mrifat-extra'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_audit_field',
            [
                'label' => esc_html__('Show Website Audit Field', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'mrifat-extra'),
                'label_off' => esc_html__('Hide', 'mrifat-extra'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Form Style', 'mrifat-extra'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'form_padding',
            [
                'label' => esc_html__('Form Padding', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .mrifat-contact-form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'form_border',
                'selector' => '{{WRAPPER}} .mrifat-contact-form',
            ]
        );

        $this->add_control(
            'form_border_radius',
            [
                'label' => esc_html__('Border Radius', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mrifat-contact-form' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'form_box_shadow',
                'selector' => '{{WRAPPER}} .mrifat-contact-form',
            ]
        );

        $this->end_controls_section();

        // Button Style Section
        $this->start_controls_section(
            'button_style_section',
            [
                'label' => esc_html__('Button Style', 'mrifat-extra'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .mrifat-submit-button',
            ]
        );

        $this->start_controls_tabs('button_style_tabs');

        $this->start_controls_tab(
            'button_normal_tab',
            [
                'label' => esc_html__('Normal', 'mrifat-extra'),
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => esc_html__('Text Color', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mrifat-submit-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'button_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .mrifat-submit-button',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'button_hover_tab',
            [
                'label' => esc_html__('Hover', 'mrifat-extra'),
            ]
        );

        $this->add_control(
            'button_hover_text_color',
            [
                'label' => esc_html__('Text Color', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mrifat-submit-button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'button_hover_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .mrifat-submit-button:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => esc_html__('Padding', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mrifat-submit-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'selector' => '{{WRAPPER}} .mrifat-submit-button',
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mrifat-submit-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $widget_id = $this->get_id();

        $recaptcha_enabled = get_option('mrifat_recaptcha_enabled', 0);
        $recaptcha_site_key = get_option('mrifat_recaptcha_site_key', '');
        ?>
        <div class="mrifat-contact-form" id="mrifat-contact-form-<?php echo esc_attr($widget_id); ?>">

            <form id="mrifat-contact-form" method="post" class="mrifat-form">
                <?php wp_nonce_field('mrifat_contact_nonce', 'mrifat_contact_nonce'); ?>

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
                    <?php if ($settings['show_business_name'] === 'yes'): ?>
                        <div class="mrifat-form-group">
                            <label for="mrifat_business_name">Your Business / Project Name</label>
                            <input type="text" id="mrifat_business_name" name="business_name"
                                placeholder="Your business or project name">
                        </div>
                    <?php endif; ?>

                    <?php if ($settings['show_service_field'] === 'yes'): ?>
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
                    <?php endif; ?>
                </div>

                <div class="mrifat-form-row">
                    <div class="mrifat-form-group">
                        <label for="mrifat_subject">Subject <span class="required">*</span></label>
                        <input type="text" id="mrifat_subject" name="subject" placeholder="What's this about?" required>
                    </div>

                    <?php if ($settings['show_timeline_field'] === 'yes'): ?>
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
                    <?php endif; ?>
                </div>

                <div class="mrifat-form-group">
                    <label for="mrifat_message">Message <span class="required">*</span></label>
                    <textarea id="mrifat_message" name="message" rows="6"
                        placeholder="Tell me about your project, goals, and any specific requirements..." required></textarea>
                </div>

                <?php if ($settings['show_audit_field'] === 'yes'): ?>
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
                <?php endif; ?>

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
        <?php
    }
}