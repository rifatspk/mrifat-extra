<?php
/**
 * Portfolio Filter Widget
 * Combines Icon List (filters), Image Box (cards), and Tabs (organization) functionality
 */

class Mrifat_Projects_Widget extends \Elementor\Widget_Base
{
    // use \Elementor\Includes\Widgets\Traits\Button_Trait;
    public function get_name()
    {
        return 'portfolio_filter';
    }

    public function get_title()
    {
        return esc_html__('Portfolio Filter', 'portfolio-filter');
    }

    public function get_icon()
    {
        return 'fas fa-th-large';
    }

    public function get_categories()
    {
        return ['general'];
    }

    public function get_keywords()
    {
        return ['portfolio', 'filter', 'projects', 'gallery', 'carousel', 'slider'];
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

        // Portfolio Items Section (Image Box functionality)
        $this->start_controls_section(
            'portfolio_section',
            [
                'label' => esc_html__('Portfolio Items', 'portfolio-filter'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $portfolio_repeater = new \Elementor\Repeater();

        $portfolio_repeater->add_control(
            'project_category',
            [
                'label' => esc_html__('Category', 'portfolio-filter'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );

        $portfolio_repeater->add_control(
            'project_title',
            [
                'label' => esc_html__('Project Title', 'portfolio-filter'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $portfolio_repeater->add_control(
            'project_image',
            [
                'label' => esc_html__('Project Image', 'portfolio-filter'),
                'type' => \Elementor\Controls_Manager::MEDIA,
            ]
        );

        $portfolio_repeater->add_control(
            'category_color',
            [
                'label' => esc_html__('Badge Color', 'portfolio-filter'),
                'type' => \Elementor\Controls_Manager::COLOR,
            ]
        );
        $portfolio_repeater->add_control(
            'live_url',
            [
                'label' => esc_html__('Live Preview', 'portfolio-filter'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://www.domain.tld/', 'portfolio-filter'),
                'show_external' => true,
                'default' => [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );

        $this->add_control(
            'portfolio_items',
            [
                'label' => esc_html__('Portfolio Items', 'portfolio-filter'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $portfolio_repeater->get_controls(),
                'title_field' => '{{{ project_title }}}',
            ]
        );

        $this->end_controls_section();

        // Carousel Settings
        $this->start_controls_section(
            'carousel_settings',
            [
                'label' => esc_html__('Carousel Settings', 'portfolio-filter'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'slides_to_show_desktop',
            [
                'label' => esc_html__('Slides to Show (Desktop)', 'portfolio-filter'),
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
                'label' => esc_html__('Slides to Show (Tablet)', 'portfolio-filter'),
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
                'label' => esc_html__('Slides to Show (Mobile)', 'portfolio-filter'),
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
                'label' => esc_html__('Spacing Between Slides', 'portfolio-filter'),
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
                'label' => esc_html__('Enable Navigation Arrows', 'portfolio-filter'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'portfolio-filter'),
                'label_off' => esc_html__('Hide', 'portfolio-filter'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'enable_pagination',
            [
                'label' => esc_html__('Enable Dots', 'portfolio-filter'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'portfolio-filter'),
                'label_off' => esc_html__('Hide', 'portfolio-filter'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => esc_html__('Autoplay', 'portfolio-filter'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'portfolio-filter'),
                'label_off' => esc_html__('No', 'portfolio-filter'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'autoplay_delay',
            [
                'label' => esc_html__('Autoplay Delay (ms)', 'portfolio-filter'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 3000,
                'condition' => [
                    'autoplay' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();


        // Image
        $this->start_controls_section(
            'image_style_section',
            [
                'label' => esc_html__('Image', 'portfolio-filter'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'image_height',
            [
                'label' => esc_html__('Image Height', 'portfolio-filter'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 900,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .project-image img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'image_object_fit',
            [
                'label' => esc_html__('Object Fit', 'portfolio-filter'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'cover' => esc_html__('Cover', 'portfolio-filter'),
                    'contain' => esc_html__('Contain', 'portfolio-filter'),
                    'fill' => esc_html__('Fill', 'portfolio-filter'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .project-image img' => 'object-fit: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label' => esc_html__('Border Radius', 'portfolio-filter'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .project-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_box_shadow',
                'selector' => '{{WRAPPER}} .project-image img',
            ]
        );

        $this->end_controls_section();


        // Badge
        $this->start_controls_section(
            'category_style_section',
            [
                'label' => esc_html__('Badge', 'portfolio-filter'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'category_typography',
                'selector' => '{{WRAPPER}} .category-badge',
            ]
        );

        $this->add_control(
            'category_text_color',
            [
                'label' => esc_html__('Text Color', 'portfolio-filter'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .category-badge' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'category_padding',
            [
                'label' => esc_html__('Padding', 'portfolio-filter'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .category-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'category_border_radius',
            [
                'label' => esc_html__('Border Radius', 'portfolio-filter'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .category-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Project Title
        $this->start_controls_section(
            'title_style_section',
            [
                'label' => esc_html__('Title', 'portfolio-filter'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .project-title',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'portfolio-filter'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .project-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'portfolio-filter'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .project-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Navigation
        $this->start_controls_section(
            'style_navigation',
            [
                'label' => esc_html__('Navigation Arrows', 'portfolio-filter'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'enable_navigation' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'nav_size',
            [
                'label' => esc_html__('Arrow Size', 'portfolio-filter'),
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
                'label' => esc_html__('Arrow Color', 'portfolio-filter'),
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
                'label' => esc_html__('Arrow Background', 'portfolio-filter'),
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
                'label' => esc_html__('Border Radius', 'portfolio-filter'),
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
                'label' => esc_html__('Dots', 'portfolio-filter'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'enable_pagination' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'dot_size',
            [
                'label' => esc_html__('Dot Size', 'portfolio-filter'),
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
                'label' => esc_html__('Dot Color', 'portfolio-filter'),
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
                'label' => esc_html__('Active Dot Color', 'portfolio-filter'),
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
                'label' => esc_html__('Spacing Between Dots', 'portfolio-filter'),
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

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        if (empty($settings['portfolio_items'])) {
            return;
        }

        $this->add_render_attribute('swiper-container', 'class', ['swiper', 'portfolio-swiper']);

        $swiper_settings = [
            'loop' => true,
            'breakpoints' => [
                '320' => [
                    'slidesPerView' => $settings['slides_to_show_mobile'],
                    'spaceBetween' => $settings['slide_spacing']['size'] ?? 10,
                ],
                '768' => [
                    'slidesPerView' => $settings['slides_to_show_tablet'],
                    'spaceBetween' => $settings['slide_spacing']['size'] ?? 15,
                ],
                '1024' => [
                    'slidesPerView' => $settings['slides_to_show_desktop'],
                    'spaceBetween' => $settings['slide_spacing']['size'] ?? 20,
                ],
            ]
        ];

        if ($settings['enable_navigation'] === 'yes') {
            $swiper_settings['navigation'] = [
                'nextEl' => '.elementor-element-' . $this->get_id() . ' .swiper-button-next',
                'prevEl' => '.elementor-element-' . $this->get_id() . ' .swiper-button-prev',
            ];
        }

        if ($settings['enable_pagination'] === 'yes') {
            $swiper_settings['pagination'] = [
                'el' => '.elementor-element-' . $this->get_id() . ' .swiper-pagination',
                'clickable' => true,
            ];
        }

        if ($settings['autoplay'] === 'yes') {
            $swiper_settings['autoplay'] = ['delay' => $settings['autoplay_delay']];
        }

        $this->add_render_attribute('swiper-container', 'data-swiper-settings', wp_json_encode($swiper_settings));

        ?>
        <div class="portfolio-carousel-container">
            <div <?php $this->print_render_attribute_string('swiper-container'); ?>>
                <div class="swiper-wrapper">
                    <?php foreach ($settings['portfolio_items'] as $item):

                        $category_style = !empty($item['category_color']) ? 'style="background-color: ' . esc_attr($item['category_color']) . ';"' : '';
                        ?>
                        <div class="swiper-slide">
                            <div class="project-content">
                                <?php if (!empty($item['project_image']['url'])): ?>
                                    <div class="project-image">
                                        <img src="<?php echo esc_url($item['project_image']['url']); ?>"
                                            alt="<?php echo esc_attr($item['project_title']); ?>" />
                                    </div>
                                <?php endif; ?>
                                <div class="project-box">
                                    <a href="<?php echo esc_url($item['live_url']['url']); ?>" class="live-preview">
                                        <i class="fas fa-long-arrow-alt-right"></i>
                                    </a>
                                    <h3 class="project-title"><?php echo esc_html($item['project_title']); ?></h3>
                                    <span class="category-badge" <?php echo $category_style; ?>>
                                        <?php echo esc_html($item['project_category']); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
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
            </div>
        </div>

        <script>
            jQuery(document).ready(function ($) {
                var carousel = $('.elementor-element-<?php echo $this->get_id(); ?> .portfolio-swiper');
                if (carousel.length > 0) {
                    var settings = carousel.data('swiper-settings');
                    new Swiper(carousel[0], settings);
                }
            });
        </script>
        <?php
    }
}
