<?php
/**
 * Plugin Name:       Mrifat Extra
 * Description:       Custom optimization and enhancements for mrifat.com
 * Version:           1.0.0
 * Author:            Mohammad Rifat Khan
 * Author URI:        https://mrifat.com
 * Text Domain:       mrifat-extra
 * Domain Path:       /languages
 */

if (!defined('ABSPATH'))
    exit;

// Define constants
define('MRIFAT_EXTRA_PATH', plugin_dir_path(__FILE__));
define('MRIFAT_EXTRA_URL', plugin_dir_url(__FILE__));

// Autoload classes
require_once MRIFAT_EXTRA_PATH . 'includes/class-init.php';

// Initialize plugin
add_action('plugins_loaded', ['Mrifat_Extra_Init', 'init']);


remove_filter('the_content', 'wpautop');
remove_filter('the_excerpt', 'wpautop');