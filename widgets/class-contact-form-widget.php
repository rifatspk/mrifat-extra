<?php

if (!defined('ABSPATH')) {
    exit;
}

class Mrifat_Contact_Form_Widget extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'mrifat-advanced-form';
    }

    public function get_title()
    {
        return esc_html__('Mrifat Advanced Form', 'mrifat-extra');
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
        return ['custom', 'form', 'contact', 'quote', 'booking', 'repeater', 'mrifat'];
    }

    protected function register_controls()
    {

        // Form Fields Section (Repeater)
        $this->start_controls_section(
            'form_fields_section',
            [
                'label' => esc_html__('Form', 'mrifat-extra'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'form_name',
            [
                'label' => esc_html__('Form Name', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('New Form', 'mrifat-extra'),
                'description' => esc_html__('Give your form a unique name (for tracking purposes).', 'mrifat-extra'),
            ]
        );
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'field_type',
            [
                'label' => esc_html__('Field Type', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'text',
                'options' => [
                    'text' => esc_html__('Text', 'mrifat-extra'),
                    'email' => esc_html__('Email', 'mrifat-extra'),
                    'textarea' => esc_html__('Textarea', 'mrifat-extra'),
                    'select' => esc_html__('Select', 'mrifat-extra'),
                    'radio' => esc_html__('Radio', 'mrifat-extra'),
                    'checkbox' => esc_html__('Checkbox', 'mrifat-extra'),
                    'file' => esc_html__('File Upload', 'mrifat-extra'),
                    'tel' => esc_html__('Phone', 'mrifat-extra'),
                    'date' => esc_html__('Date', 'mrifat-extra'),
                    'time' => esc_html__('Time', 'mrifat-extra'),
                    'number' => esc_html__('Number', 'mrifat-extra'),
                    'rating' => esc_html__('Star Rating', 'mrifat-extra'),
                ],
            ]
        );

        $repeater->add_control(
            'field_label',
            [
                'label' => esc_html__('Label', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('New Field', 'mrifat-extra'),
            ]
        );

        $repeater->add_control(
            'field_name',
            [
                'label' => esc_html__('Field Name', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => esc_html__('A unique name for the field (e.g., \'your_name\'). No spaces or special characters.', 'mrifat-extra'),
            ]
        );

        $repeater->add_control(
            'field_placeholder',
            [
                'label' => esc_html__('Placeholder', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'is_required',
            [
                'label' => esc_html__('Required', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $repeater->add_control(
            'field_options',
            [
                'label' => esc_html__('Options', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'description' => esc_html__('Enter each option on a new line.', 'mrifat-extra'),
                'condition' => [
                    'field_type' => ['select', 'radio', 'checkbox'],
                ],
            ]
        );

        $repeater->add_responsive_control(
            'field_width',
            [
                'label' => esc_html__('Field Width', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '100',
                'options' => [
                    '25' => esc_html__('25%', 'mrifat-extra'),
                    '33' => esc_html__('33%', 'mrifat-extra'),
                    '50' => esc_html__('50%', 'mrifat-extra'),
                    '66' => esc_html__('66%', 'mrifat-extra'),
                    '75' => esc_html__('75%', 'mrifat-extra'),
                    '100' => esc_html__('100%', 'mrifat-extra'),
                ],
            ]
        );

        $this->add_control(
            'form_fields',
            [
                'label' => esc_html__('Fields', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'field_type' => 'text',
                        'field_label' => esc_html__('Name', 'mrifat-extra'),
                        'field_name' => 'name',
                        'field_placeholder' => esc_html__('Your Name', 'mrifat-extra'),
                        'is_required' => 'yes',
                        'field_width' => '50',
                    ],
                    [
                        'field_type' => 'email',
                        'field_label' => esc_html__('Email', 'mrifat-extra'),
                        'field_name' => 'email',
                        'field_placeholder' => esc_html__('Your Email', 'mrifat-extra'),
                        'is_required' => 'yes',
                        'field_width' => '50',
                    ],
                    [
                        'field_type' => 'textarea',
                        'field_label' => esc_html__('Message', 'mrifat-extra'),
                        'field_name' => 'message',
                        'field_placeholder' => esc_html__('Your Message', 'mrifat-extra'),
                        'is_required' => 'yes',
                        'field_width' => '100',
                    ],
                ],
                'title_field' => '{{{ field_label }}}',
            ]
        );

        $this->add_control(
            'submit_button_text',
            [
                'label' => esc_html__('Submit Button Text', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Send Message', 'mrifat-extra'),
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $this->render_html_form($settings);
    }

    private function render_html_form($settings)
    {
        $widget_id = $this->get_id();
        $form_name = $settings['form_name'];
        $has_file_upload = false;
        foreach ($settings['form_fields'] as $field) {
            if ($field['field_type'] === 'file') {
                $has_file_upload = true;
                break;
            }
        }

        $recaptcha_enabled = get_option('mrifat_recaptcha_enabled', 0);
        $recaptcha_site_key = get_option('mrifat_recaptcha_site_key', '');

        ?>
        <div class="mrifat-contact-form-wrapper">
            <form id="mrifat-form-<?php echo esc_attr($widget_id); ?>" method="post" class="mrifat-form" <?php if ($has_file_upload)
                   echo 'enctype="multipart/form-data"'; ?>>
                <div class="mrifat-form-message"></div>
                <?php wp_nonce_field('mrifat_contact_nonce', 'mrifat_contact_nonce'); ?>
                <input type="hidden" name="form_name" value="<?php echo esc_attr($form_name); ?>">
                <input type="hidden" name="action" value="mrifat_submit_contact">

                <div class="mrifat-form-row">
                    <?php
                    foreach ($settings['form_fields'] as $field) {
                        $this->render_field($field);
                    }
                    ?>

                    <?php if ($recaptcha_enabled && !empty($recaptcha_site_key)): ?>
                        <div class="mrifat-form-group mrifat-field-width-100">
                            <div class="g-recaptcha" data-sitekey="<?php echo esc_attr($recaptcha_site_key); ?>"></div>
                        </div>
                    <?php endif; ?>

                    <div class="mrifat-form-group mrifat-field-width-100">
                        <label class="mrifat-checkbox-label privacy-policy">
                            <input type="checkbox" name="privacy_policy" required>
                            <span>I accept the privacy policy <span class="required">*</span></span>
                        </label>
                    </div>

                    <div class="mrifat-button-wrapper">
                        <button type="submit" class="mrifat-submit-button">
                            <span class="mrifat-button-text"><?php echo esc_html($settings['submit_button_text']); ?></span>
                            <span class="mrifat-button-loading" style="display: none;">Sending...</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <?php
    }

    private function render_field($field)
    {
        $width_class = 'mrifat-field-width-' . ($field['field_width'] ?? '100');
        $field_name = sanitize_key($field['field_name'] ?: $field['field_label']);
        $required = $field['is_required'] === 'yes';

        echo '<div class="mrifat-form-group ' . esc_attr($width_class) . '">';

        $label = esc_html($field['field_label']);
        $req_span = $required ? ' <span class="required">*</span>' : '';
        echo '<label for="mrifat-field-' . esc_attr($field_name) . '">' . $label . $req_span . '</label>';

        switch ($field['field_type']) {
            case 'textarea':
                $this->render_textarea_field($field_name, $field, $required);
                break;
            case 'select':
            case 'radio':
            case 'checkbox':
                $this->render_options_field($field_name, $field, $required);
                break;
            case 'rating':
                $this->render_rating_field($field_name, $field, $required);
                break;
            default:
                $this->render_input_field($field_name, $field, $required);
                break;
        }

        echo '</div>';
    }

    private function render_input_field($name, $field, $required)
    {
        $placeholder = esc_attr($field['field_placeholder']);
        $req_attr = $required ? 'required' : '';
        echo '<input type="' . esc_attr($field['field_type']) . '" id="mrifat-field-' . esc_attr($name) . '" name="' . esc_attr($name) . '" placeholder="' . $placeholder . '" ' . $req_attr . '>';
    }

    private function render_textarea_field($name, $field, $required)
    {
        $placeholder = esc_attr($field['field_placeholder']);
        $req_attr = $required ? 'required' : '';
        echo '<textarea id="mrifat-field-' . esc_attr($name) . '" name="' . esc_attr($name) . '" rows="6" placeholder="' . $placeholder . '" ' . $req_attr . '></textarea>';
    }

    private function render_options_field($name, $field, $required)
    {
        $options = explode("\n", trim($field['field_options']));
        $type = $field['field_type'];
        $req_attr = $required ? 'required' : '';

        if ($type === 'select') {
            echo '<select id="mrifat-field-' . esc_attr($name) . '" name="' . esc_attr($name) . '" ' . $req_attr . '>';
            if ($field['field_placeholder']) {
                echo '<option value="">' . esc_html($field['field_placeholder']) . '</option>';
            }
            foreach ($options as $option) {
                $option_val = esc_attr(trim($option));
                echo '<option value="' . $option_val . '">' . esc_html(trim($option)) . '</option>';
            }
            echo '</select>';
        } else { // radio or checkbox
            echo '<div class="mrifat-' . $type . '-group">';
            $input_name = ($type === 'checkbox') ? esc_attr($name) . '[]' : esc_attr($name);
            foreach ($options as $option) {
                $option_val = esc_attr(trim($option));
                echo '<label class="mrifat-' . $type . '-option">';
                echo '<input type="' . $type . '" name="' . $input_name . '" value="' . $option_val . '" ' . $req_attr . '>';
                echo '<span>' . esc_html(trim($option)) . '</span>';
                echo '</label>';
            }
            echo '</div>';
        }
    }

    private function render_rating_field($name, $field, $required)
    {
        $req_attr = $required ? 'required' : '';
        echo '<div class="mrifat-rating-group">';
        for ($i = 5; $i >= 1; $i--) {
            echo '<input type="radio" id="rating-' . $i . '" name="' . esc_attr($name) . '" value="' . $i . '" ' . $req_attr . '>';
            echo '<label for="rating-' . $i . '">&#9733;</label>';
        }
        echo '</div>';
    }
}