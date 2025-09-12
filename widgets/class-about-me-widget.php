<?php
/**
 * About Me Class
 * 
 * This widget displays personal information including name, bio, social links,
 * and availability status. All content is dynamically configurable through
 * the WordPress admin panel.
 */

class About_Me_Widget extends WP_Widget
{

    /**
     * Constructor - Sets up the widget with basic information
     * This method runs when the widget is first instantiated
     */
    public function __construct()
    {
        parent::__construct(
            'about_me_widget', // Widget ID - unique identifier for this widget
            __('About Me', 'mrifat-extra'), // Widget Name shown in admin
            array(
                'description' => __('Display personal information with photo, bio, and social links', 'mrifat-extra'),
                'customize_selective_refresh' => true, // Enables live preview in customizer
            )
        );

    }


    /**
     * Frontend display of widget
     * This method outputs the HTML that visitors see on your website
     */
    public function widget($args, $instance)
    {
        // Extract widget arguments (before_widget, after_widget, etc.)
        extract($args);

        // Get widget settings with default fallbacks
        $title = apply_filters('widget_title', !empty($instance['title']) ? $instance['title'] : '');
        $name = !empty($instance['name']) ? $instance['name'] : '';
        $bio = !empty($instance['bio']) ? $instance['bio'] : '';
        $photo_url = !empty($instance['photo_url']) ? $instance['photo_url'] : '';
        $email = !empty($instance['email']) ? $instance['email'] : '';
        $github = !empty($instance['github']) ? $instance['github'] : '';
        $linkedin = !empty($instance['linkedin']) ? $instance['linkedin'] : '';
        $twitter = !empty($instance['twitter']) ? $instance['twitter'] : '';
        $availability_title = !empty($instance['availability_title']) ? $instance['availability_title'] : '';
        $availability_text = !empty($instance['availability_text']) ? $instance['availability_text'] : '';

        // Start widget output
        echo $before_widget;

        // Display widget title if provided
        if (!empty($title)) {
            echo $before_title . $title . $after_title;
        }
        ?>

        <div class="about-me">
            <div class="about-me-content">
                <?php if (!empty($name) || !empty($photo_url)): ?>
                    <div class="about-me-header">
                        <?php if (!empty($photo_url)): ?>
                            <div class="about-me-logo">
                                <img src="<?php echo esc_url($photo_url); ?>" alt="<?php echo esc_attr($name); ?>"
                                    class="about-me-logo-image">
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($name)): ?>
                            <h3 class="about-me-name"><?php echo esc_html($name); ?></h3>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($bio)): ?>
                    <p class="about-me-description"><?php echo wp_kses_post($bio); ?></p>
                <?php endif; ?>

                <?php if (!empty($email) || !empty($github) || !empty($linkedin) || !empty($twitter)): ?>
                    <div class="about-me-social-links">
                        <?php if (!empty($email)): ?>
                            <a href="mailto:<?php echo esc_attr($email); ?>" aria-label="Email" class="social-link">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-mail-icon lucide-mail">
                                    <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7" />
                                    <rect x="2" y="4" width="20" height="16" rx="2" />
                                </svg>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($github)): ?>
                            <a href="<?php echo esc_url($github); ?>" target="_blank" rel="noopener noreferrer" aria-label="GitHub"
                                class="social-link">
                                <i class="fab fa-github social-icon"></i>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($linkedin)): ?>
                            <a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"
                                class="social-link">
                                <i class="fab fa-linkedin social-icon"></i>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($twitter)): ?>
                            <a href="<?php echo esc_url($twitter); ?>" target="_blank" rel="noopener noreferrer" aria-label="Twitter"
                                class="social-link">
                                <i class="fab fa-twitter social-icon"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($availability_title) || !empty($availability_text)): ?>
                    <div class="about-me-availability">
                        <?php if (!empty($availability_title)): ?>
                            <p class="availability-title"><?php echo esc_html($availability_title); ?></p>
                        <?php endif; ?>

                        <?php if (!empty($availability_text)): ?>
                            <p class="availability-text"><?php echo esc_html($availability_text); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php
        echo $after_widget;
    }

    /**
     * Backend widget form in admin panel
     * This creates the interface where users can configure the widget settings
     */
    public function form($instance)
    {
        // Set default values for all fields
        $defaults = array(
            'title' => '',
            'name' => '',
            'bio' => '',
            'photo_url' => '',
            'email' => '',
            'github' => '',
            'linkedin' => '',
            'twitter' => '',
            'availability_title' => '',
            'availability_text' => ''
        );

        // Merge user settings with defaults
        $instance = wp_parse_args((array) $instance, $defaults);
        ?>

        <!-- Widget Title Field -->
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title:', 'mrifat-extra'); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
        </p>

        <!-- Name Field -->
        <p>
            <label for="<?php echo $this->get_field_id('name'); ?>"><?php _e('Full Name:', 'mrifat-extra'); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('name'); ?>"
                name="<?php echo $this->get_field_name('name'); ?>" value="<?php echo esc_attr($instance['name']); ?>" />
        </p>

        <!-- Photo URL Field -->
        <p>
            <label for="<?php echo $this->get_field_id('photo_url'); ?>"><?php _e('Photo URL:', 'mrifat-extra'); ?></label>
            <input type="url" class="widefat" id="<?php echo $this->get_field_id('photo_url'); ?>"
                name="<?php echo $this->get_field_name('photo_url'); ?>"
                value="<?php echo esc_url($instance['photo_url']); ?>" />
            <small><?php _e('Enter the full URL to your profile photo (recommended size: 40x40px)', 'mrifat-extra'); ?></small>
        </p>

        <!-- Bio Field -->
        <p>
            <label for="<?php echo $this->get_field_id('bio'); ?>"><?php _e('Bio/Description:', 'mrifat-extra'); ?></label>
            <textarea class="widefat" rows="4" id="<?php echo $this->get_field_id('bio'); ?>"
                name="<?php echo $this->get_field_name('bio'); ?>"><?php echo esc_textarea($instance['bio']); ?></textarea>
        </p>

        <!-- Email Field -->
        <p>
            <label for="<?php echo $this->get_field_id('email'); ?>"><?php _e('Email Address:', 'mrifat-extra'); ?></label>
            <input type="email" class="widefat" id="<?php echo $this->get_field_id('email'); ?>"
                name="<?php echo $this->get_field_name('email'); ?>" value="<?php echo esc_attr($instance['email']); ?>" />
        </p>

        <!-- GitHub URL Field -->
        <p>
            <label for="<?php echo $this->get_field_id('github'); ?>"><?php _e('GitHub URL:', 'mrifat-extra'); ?></label>
            <input type="url" class="widefat" id="<?php echo $this->get_field_id('github'); ?>"
                name="<?php echo $this->get_field_name('github'); ?>" value="<?php echo esc_url($instance['github']); ?>" />
        </p>

        <!-- LinkedIn URL Field -->
        <p>
            <label for="<?php echo $this->get_field_id('linkedin'); ?>"><?php _e('LinkedIn URL:', 'mrifat-extra'); ?></label>
            <input type="url" class="widefat" id="<?php echo $this->get_field_id('linkedin'); ?>"
                name="<?php echo $this->get_field_name('linkedin'); ?>" value="<?php echo esc_url($instance['linkedin']); ?>" />
        </p>

        <!-- Twitter URL Field -->
        <p>
            <label for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e('Twitter URL:', 'mrifat-extra'); ?></label>
            <input type="url" class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>"
                name="<?php echo $this->get_field_name('twitter'); ?>" value="<?php echo esc_url($instance['twitter']); ?>" />
        </p>

        <!-- Availability Title Field -->
        <p>
            <label
                for="<?php echo $this->get_field_id('availability_title'); ?>"><?php _e('Availability Title:', 'mrifat-extra'); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('availability_title'); ?>"
                name="<?php echo $this->get_field_name('availability_title'); ?>"
                value="<?php echo esc_attr($instance['availability_title']); ?>" />
        </p>

        <!-- Availability Text Field -->
        <p>
            <label
                for="<?php echo $this->get_field_id('availability_text'); ?>"><?php _e('Availability Text:', 'mrifat-extra'); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('availability_text'); ?>"
                name="<?php echo $this->get_field_name('availability_text'); ?>"
                value="<?php echo esc_attr($instance['availability_text']); ?>" />
        </p>

        <?php
    }

    /**
     * Update widget settings
     * This method processes and saves the data when the widget form is submitted
     */
    public function update($new_instance, $old_instance)
    {
        $instance = array();

        // Sanitize and save each field
        // strip_tags removes HTML tags, while trim removes extra whitespace
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['name'] = (!empty($new_instance['name'])) ? strip_tags($new_instance['name']) : '';
        $instance['bio'] = (!empty($new_instance['bio'])) ? wp_kses_post($new_instance['bio']) : '';
        $instance['photo_url'] = (!empty($new_instance['photo_url'])) ? esc_url_raw($new_instance['photo_url']) : '';
        $instance['email'] = (!empty($new_instance['email'])) ? sanitize_email($new_instance['email']) : '';
        $instance['github'] = (!empty($new_instance['github'])) ? esc_url_raw($new_instance['github']) : '';
        $instance['linkedin'] = (!empty($new_instance['linkedin'])) ? esc_url_raw($new_instance['linkedin']) : '';
        $instance['twitter'] = (!empty($new_instance['twitter'])) ? esc_url_raw($new_instance['twitter']) : '';
        $instance['availability_title'] = (!empty($new_instance['availability_title'])) ? strip_tags($new_instance['availability_title']) : '';
        $instance['availability_text'] = (!empty($new_instance['availability_text'])) ? strip_tags($new_instance['availability_text']) : '';

        return $instance;
    }
}