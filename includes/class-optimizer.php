<?php

if (!defined('ABSPATH'))
    exit;

class Mrifat_Extra_Optimizer
{

    public function __construct()
    {
        add_action('wp_head', [$this, 'inject_critical_elements'], 1);
        add_action('wp_body_open', [$this, 'gtm_noscript'], -100000);
        add_action('after_setup_theme', [$this, 'disable_block_widgets']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets'], 100);
        add_action('widgets_init', array($this, 'register_widgets'));
    }

    public function inject_critical_elements()
    {
        echo '<meta name="google-site-verification" content="FOp37flnmMZtDjaW_YW4A4K3RfcBdJ5Ew6M4btBUV9w" />' . "\n";


        // GTM Async
        ?>
        <script>(function (w, d, s, l, i) {
                w[l] = w[l] || []; w[l].push({
                    'gtm.start':
                        new Date().getTime(), event: 'gtm.js'
                }); var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src =
                        'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', 'GTM-N455LRZ4');</script>
        <?php
    }

    public function gtm_noscript()
    {
        echo '<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N455LRZ4"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>' . "\n";
    }

    public function disable_block_widgets()
    {
        remove_theme_support('widgets-block-editor');
    }

    public function enqueue_assets()
    {
        wp_enqueue_style('mrifat-extra-style', MRIFAT_EXTRA_URL . 'assets/css/style.css', [], '1.0.0');
        if (!is_user_logged_in()) {
            wp_deregister_style('dashicons');
            remove_action('wp_head', 'print_emoji_detection_script', 7);
            remove_action('wp_print_styles', 'print_emoji_styles');
        }
    }

    /**
     * Register widgets
     */
    public function register_widgets()
    {
        require_once MRIFAT_EXTRA_PATH . 'widgets/class-about-me-widget.php';
        register_widget('About_Me_Widget');
    }
}
