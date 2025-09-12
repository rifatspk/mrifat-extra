<?php

if (!defined('ABSPATH')) {
    exit;
}

class Mrifat_Extra_Elementor_Widgets
{
    public function __construct()
    {
        add_action('elementor/widgets/register', [$this, 'register_widgets']);
        add_action('elementor/elements/categories_registered', [$this, 'add_elementor_widget_categories']);
    }

   
    public function register_widgets($widgets_manager)
    {
        require_once MRIFAT_EXTRA_PATH . 'widgets/class-contact-form-widget.php';
        require_once MRIFAT_EXTRA_PATH . 'widgets/class-projects-widget.php';
        require_once MRIFAT_EXTRA_PATH . 'widgets/class-post-carousel-widget.php';
        require_once MRIFAT_EXTRA_PATH . 'widgets/class-youtube-carousel.php';
        $widgets_manager->register(new Mrifat_Contact_Form_Widget());
        $widgets_manager->register(new Mrifat_Projects_Widget());
        $widgets_manager->register(new Post_Card_Carousel_Widget());
        $widgets_manager->register(new YouTube_Carousel_Widget());
    }

    public function add_elementor_widget_categories($elements_manager)
    {
        $elements_manager->add_category(
            'mrifat-widgets',
            [
                'title' => esc_html__('Mrifat Widgets', 'mrifat-extra'),
                'icon' => 'fa fa-plug',
            ]
        );
    }
}