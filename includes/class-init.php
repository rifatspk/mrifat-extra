<?php

if (!defined('ABSPATH'))
    exit;

require_once MRIFAT_EXTRA_PATH . 'includes/class-optimizer.php';
require_once MRIFAT_EXTRA_PATH . 'includes/class-database.php';
require_once MRIFAT_EXTRA_PATH . 'includes/class-admin.php';
require_once MRIFAT_EXTRA_PATH . 'includes/class-settings.php';
require_once MRIFAT_EXTRA_PATH . 'includes/class-contact-handler.php';
require_once MRIFAT_EXTRA_PATH . 'includes/class-elementor-widgets.php';
require_once MRIFAT_EXTRA_PATH . 'includes/class-contact-float-button.php';

class Mrifat_Extra_Init
{

    public static function init()
    {
        new Mrifat_Extra_Optimizer();
        new Mrifat_Extra_Database();
        new Mrifat_Extra_Admin();
        new Mrifat_Extra_Settings();
        new Mrifat_Extra_Form_Handler();
        new MRifat_WhatsApp_Button();

        if (did_action('elementor/loaded')) {
            new Mrifat_Extra_Elementor_Widgets();
        }
    }
}
