<?php
/**
 * Elementor Post Card Carousel Widget
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Post_Card_Carousel_Widget extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'post_carousel';
    }

    public function get_title()
    {
        return esc_html__('Post Carousel', 'mrifat-extra');
    }

    public function get_icon()
    {
        return 'eicon-posts-carousel';
    }

    public function get_categories()
    {
        return ['mrifat-widgets'];
    }

    public function get_keywords()
    {
        return ['posts', 'carousel', 'cards', 'blog'];
    }

    public function get_script_depends()
    {
        return ['swiper'];
    }

    public function get_style_depends()
    {
        return ['swiper'];
    }

    protected function register_controls()
    {

        // Content Tab
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'mrifat-extra'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => esc_html__('Number of Posts', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 6,
                'min' => 1,
                'max' => 20,
            ]
        );

        $this->add_control(
            'post_type',
            [
                'label' => esc_html__('Post Type', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'post',
                'options' => $this->get_post_types(),
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label' => esc_html__('Order By', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'date' => esc_html__('Date', 'mrifat-extra'),
                    'title' => esc_html__('Title', 'mrifat-extra'),
                    'menu_order' => esc_html__('Menu Order', 'mrifat-extra'),
                    'rand' => esc_html__('Random', 'mrifat-extra'),
                ],
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => esc_html__('Order', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'DESC',
                'options' => [
                    'ASC' => esc_html__('Ascending', 'mrifat-extra'),
                    'DESC' => esc_html__('Descending', 'mrifat-extra'),
                ],
            ]
        );

        $this->add_control(
            'show_image',
            [
                'label' => esc_html__('Show Featured Image', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'mrifat-extra'),
                'label_off' => esc_html__('Hide', 'mrifat-extra'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label' => esc_html__('Show Title', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'mrifat-extra'),
                'label_off' => esc_html__('Hide', 'mrifat-extra'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_excerpt',
            [
                'label' => esc_html__('Show Excerpt', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'mrifat-extra'),
                'label_off' => esc_html__('Hide', 'mrifat-extra'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'excerpt_length',
            [
                'label' => esc_html__('Excerpt Length', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 20,
                'condition' => [
                    'show_excerpt' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_date',
            [
                'label' => esc_html__('Show Date', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'mrifat-extra'),
                'label_off' => esc_html__('Hide', 'mrifat-extra'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_author',
            [
                'label' => esc_html__('Show Author', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'mrifat-extra'),
                'label_off' => esc_html__('Hide', 'mrifat-extra'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_read_more',
            [
                'label' => esc_html__('Show Read More', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'mrifat-extra'),
                'label_off' => esc_html__('Hide', 'mrifat-extra'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'read_more_text',
            [
                'label' => esc_html__('Read More Text', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Read More', 'mrifat-extra'),
                'condition' => [
                    'show_read_more' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // Carousel Settings
        $this->start_controls_section(
            'carousel_settings',
            [
                'label' => esc_html__('Carousel Settings', 'mrifat-extra'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'slides_to_show_desktop',
            [
                'label' => esc_html__('Slides to Show (Desktop)', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 10,
                'step' => 1,
                'default' => 3,
            ]
        );

        $this->add_control(
            'slides_to_show_tablet',
            [
                'label' => esc_html__('Slides to Show (Tablet)', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 10,
                'step' => 1,
                'default' => 2,
            ]
        );

        $this->add_control(
            'slides_to_show_mobile',
            [
                'label' => esc_html__('Slides to Show (Mobile)', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 10,
                'step' => 1,
                'default' => 1,
            ]
        );

        $this->add_responsive_control(
            'slide_spacing',
            [
                'label' => esc_html__('Spacing Between Slides', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 15,
                ],
            ]
        );

        $this->add_control(
            'enable_navigation',
            [
                'label' => esc_html__('Enable Navigation Arrows', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'mrifat-extra'),
                'label_off' => esc_html__('Hide', 'mrifat-extra'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'enable_pagination',
            [
                'label' => esc_html__('Enable Dots', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'mrifat-extra'),
                'label_off' => esc_html__('Hide', 'mrifat-extra'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => esc_html__('Autoplay', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'mrifat-extra'),
                'label_off' => esc_html__('No', 'mrifat-extra'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'autoplay_delay',
            [
                'label' => esc_html__('Autoplay Delay (ms)', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 3000,
                'condition' => [
                    'autoplay' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // Layout Style
        $this->start_controls_section(
            'layout_style_section',
            [
                'label' => esc_html__('Layout', 'mrifat-extra'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'card_gap',
            [
                'label' => esc_html__('Gap Between Cards', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .post-carousel-container' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Card Style
        $this->start_controls_section(
            'card_style_section',
            [
                'label' => esc_html__('Card Style', 'mrifat-extra'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'card_height',
            [
                'label' => esc_html__('Card Height', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 200,
                        'max' => 800,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .post-card' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'card_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .post-card',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'card_border',
                'selector' => '{{WRAPPER}} .post-card',
            ]
        );

        $this->add_responsive_control(
            'card_border_radius',
            [
                'label' => esc_html__('Border Radius', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .post-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'card_box_shadow',
                'selector' => '{{WRAPPER}} .post-card',
            ]
        );

        $this->add_responsive_control(
            'card_padding',
            [
                'label' => esc_html__('Padding', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .post-card-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Image Style
        $this->start_controls_section(
            'image_style_section',
            [
                'label' => esc_html__('Image Style', 'mrifat-extra'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_image' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_height',
            [
                'label' => esc_html__('Image Height', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 400,
                    ],
                    '%' => [
                        'min' => 20,
                        'max' => 80,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .post-image' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'image_object_fit',
            [
                'label' => esc_html__('Object Fit', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'cover',
                'options' => [
                    'cover' => esc_html__('Cover', 'mrifat-extra'),
                    'contain' => esc_html__('Contain', 'mrifat-extra'),
                    'fill' => esc_html__('Fill', 'mrifat-extra'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .post-image img' => 'object-fit: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'image_border',
                'selector' => '{{WRAPPER}} .post-image',
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label' => esc_html__('Border Radius', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .post-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        //Category Style
        $this->start_controls_section(
            'category_style_section',
            [
                'label' => esc_html__('Category Style', 'mrifat-extra'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_read_more' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'category_typography',
                'selector' => '{{WRAPPER}} .category a',
            ]
        );

        $this->start_controls_tabs('category_style_tabs');

        $this->start_controls_tab(
            'category_normal_tab',
            [
                'label' => esc_html__('Normal', 'mrifat-extra'),
            ]
        );

        $this->add_control(
            'category_color',
            [
                'label' => esc_html__('Text Color', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .category a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'category_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .category a',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'category_border',
                'selector' => '{{WRAPPER}} .category a',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'category_hover_tab',
            [
                'label' => esc_html__('Hover', 'mrifat-extra'),
            ]
        );

        $this->add_control(
            'category_hover_color',
            [
                'label' => esc_html__('Text Color', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .category a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'category_hover_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .category a:hover',
            ]
        );

        $this->add_control(
            'category_hover_border_color',
            [
                'label' => esc_html__('Border Color', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .category a:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'category_border_radius',
            [
                'label' => esc_html__('Border Radius', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .category a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'category_padding',
            [
                'label' => esc_html__('Padding', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .category a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'category_margin',
            [
                'label' => esc_html__('Margin', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .category a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        // Title Style
        $this->start_controls_section(
            'title_style_section',
            [
                'label' => esc_html__('Title Style', 'mrifat-extra'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .post-title',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label' => esc_html__('Hover Color', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .post-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Excerpt Style
        $this->start_controls_section(
            'excerpt_style_section',
            [
                'label' => esc_html__('Excerpt Style', 'mrifat-extra'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_excerpt' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'excerpt_typography',
                'selector' => '{{WRAPPER}} .excerpt',
            ]
        );

        $this->add_control(
            'excerpt_color',
            [
                'label' => esc_html__('Color', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .excerpt' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'excerpt_margin',
            [
                'label' => esc_html__('Margin', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Meta Style
        $this->start_controls_section(
            'meta_style_section',
            [
                'label' => esc_html__('Meta Style', 'mrifat-extra'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'meta_typography',
                'selector' => '{{WRAPPER}} .meta',
            ]
        );

        $this->add_control(
            'meta_color',
            [
                'label' => esc_html__('Color', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .meta' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'meta_margin',
            [
                'label' => esc_html__('Margin', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Read More Button Style
        $this->start_controls_section(
            'button_style_section',
            [
                'label' => esc_html__('Read More', 'mrifat-extra'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_read_more' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .read-btn',
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
            'button_color',
            [
                'label' => esc_html__('Text Color', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .read-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'button_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .read-btn',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'selector' => '{{WRAPPER}} .read-btn',
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
            'button_hover_color',
            [
                'label' => esc_html__('Text Color', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .read-btn:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'button_hover_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .read-btn:hover',
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label' => esc_html__('Border Color', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .read-btn:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .read-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => esc_html__('Padding', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .read-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_margin',
            [
                'label' => esc_html__('Margin', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .read-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style_navigation',
            [
                'label' => esc_html__('Navigation Arrows', 'mrifat-extra'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'enable_navigation' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'nav_size',
            [
                'label' => esc_html__('Arrow Size', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 80,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 40,
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .swiper-button-next:after, {{WRAPPER}} .swiper-button-prev:after' => 'font-size: calc({{SIZE}}{{UNIT}} / 2);;',
                ],
            ]
        );

        $this->add_control(
            'nav_color',
            [
                'label' => esc_html__('Arrow Color', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#007cba',
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'nav_bg_color',
            [
                'label' => esc_html__('Arrow Background', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(255,255,255,0.8)',
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'nav_border_radius',
            [
                'label' => esc_html__('Border Radius', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Pagination
        $this->start_controls_section(
            'style_pagination',
            [
                'label' => esc_html__('Dots', 'mrifat-extra'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'enable_pagination' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'dot_size',
            [
                'label' => esc_html__('Dot Size', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 25,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 8,
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'dot_color',
            [
                'label' => esc_html__('Dot Color', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(0,0,0,0.3)',
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'dot_active_color',
            [
                'label' => esc_html__('Active Dot Color', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#007cba',
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'dot_spacing',
            [
                'label' => esc_html__('Spacing Between Dots', 'mrifat-extra'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 2,
                        'max' => 20,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 4,
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'margin: 0 {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    private function get_post_types()
    {
        $post_types = get_post_types(['public' => true], 'objects');
        $options = [];
        foreach ($post_types as $post_type) {
            $options[$post_type->name] = $post_type->label;
        }
        return $options;
    }

    private function get_excerpt($post_id, $length = 20)
    {
        $post = get_post($post_id);
        if ($post->post_excerpt) {
            $excerpt = $post->post_excerpt;
        } else {
            $excerpt = $post->post_content;
        }
        return wp_trim_words($excerpt, $length);
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $widget_id = $this->get_id();

        $this->add_render_attribute('swiper-container', 'class', ['swiper', 'post-carousel-swiper']);

        $swiper_settings = [
            'loop' => true,
            'breakpoints' => [
                '320' => [
                    'slidesPerView' => $settings['slides_to_show_mobile'] ?? 1,
                    'spaceBetween' => $settings['slide_spacing']['size'] ?? 15,
                ],
                '768' => [
                    'slidesPerView' => $settings['slides_to_show_tablet'] ?? 2,
                    'spaceBetween' => $settings['slide_spacing']['size'] ?? 20,
                ],
                '1024' => [
                    'slidesPerView' => $settings['slides_to_show_desktop'] ?? 3,
                    'spaceBetween' => $settings['slide_spacing']['size'] ?? 30,
                ],
            ]
        ];

        if ('yes' === $settings['enable_navigation']) {
            $swiper_settings['navigation'] = [
                'nextEl' => ".elementor-element-{$widget_id} .swiper-button-next",
                'prevEl' => ".elementor-element-{$widget_id} .swiper-button-prev",
            ];
        }

        if ('yes' === $settings['enable_pagination']) {
            $swiper_settings['pagination'] = [
                'el' => ".elementor-element-{$widget_id} .swiper-pagination",
                'clickable' => true,
            ];
        }

        if ('yes' === $settings['autoplay']) {
            $swiper_settings['autoplay'] = ['delay' => $settings['autoplay_delay'] ?? 3000];
        }

        $this->add_render_attribute('swiper-container', 'data-swiper-settings', wp_json_encode($swiper_settings));

        $args = [
            'post_type' => $settings['post_type'],
            'posts_per_page' => $settings['posts_per_page'],
            'orderby' => $settings['orderby'],
            'order' => $settings['order'],
            'post_status' => 'publish',
        ];

        $query = new \WP_Query($args);

        if (!$query->have_posts()) {
            if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
                echo '<p>' . esc_html__('No posts found. Please check your query settings.', 'mrifat-extra') . '</p>';
            }
            return;
        }
        ?>
        <div <?php $this->print_render_attribute_string('swiper-container'); ?>>
            <div class="swiper-wrapper">
                <?php while ($query->have_posts()):
                    $query->the_post(); ?>
                    <div class="swiper-slide">
                        <article class="post-card">
                            <div class="post-image">
                                <?php if (has_post_thumbnail()): ?>
                                    <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')); ?>"
                                        alt="<?php echo esc_attr(get_the_title()); ?>">
                                <?php endif; ?>
                                <div class="overlay">
                                    <div class="category">
                                        <?php the_category(' '); ?>
                                    </div>

                                    <h3 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    <div class="meta">
                                        <span><i class="fas fa-user"></i> <?php the_author(); ?></span>
                                        <span><i class="fas fa-calendar-alt"></i> <?php echo get_the_date(); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="post-body">
                                <p class="excerpt">
                                    <?php echo esc_html($this->get_excerpt(get_the_ID(), $settings['excerpt_length'])); ?>
                                </p>
                                <div class="read-row">
                                    <div class="author">
                                        <img src="/wp-content/uploads/2025/05/profile-picture.webp" alt="<?php the_author(); ?>">
                                        <div>
                                            <div class="name"><?php the_author(); ?></div>
                                            <div class="role"><?php echo esc_html(get_the_author_meta('description')); ?></div>
                                        </div>
                                    </div>
                                    <a href="<?php the_permalink(); ?>"
                                        class="read-btn"><?php echo esc_html__('Read More', 'mrifat-extra'); ?></a>
                                </div>
                            </div>
                        </article>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
        <?php if ($settings['enable_navigation'] === 'yes'): ?>
            <div class="navigation-box">
                <div class="swiper-button-prev">
                    <i class="fas fa-long-arrow-alt-left"></i>
                </div>
                <div class="swiper-button-next">
                    <i class="fas fa-long-arrow-alt-right"></i>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($settings['enable_pagination'] === 'yes'): ?>
            <div class="swiper-pagination"></div>
        <?php endif; ?>

        <script>
            jQuery(document).ready(function ($) {
                var carouselContainer = $('.elementor-element-<?php echo $widget_id; ?> .post-carousel-swiper');
                if (carouselContainer.length > 0 && typeof Swiper !== 'undefined') {
                    var settings = carouselContainer.data('swiper-settings');
                    new Swiper(carouselContainer[0], settings);
                }
            });
        </script>
        <?php
        wp_reset_postdata();
    }
}
