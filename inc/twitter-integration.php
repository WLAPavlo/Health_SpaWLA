<?php
/**
 * Twitter Integration for SPA Theme - Custom Twitter Feeds Plugin Support
 */

// Add custom styling for Custom Twitter Feeds plugin
add_action('wp_enqueue_scripts', function() {
    // Enqueue our custom Twitter styles
    wp_enqueue_style('spa-twitter-feeds', get_template_directory_uri() . '/assets/styles/inc/_spa-twitter-feeds.css', array(), '1.0.0');
});

// Customize Custom Twitter Feeds plugin output
add_filter('ctf_feed_options', function($options, $feed_id) {
    // Set default options for SPA styling
    $spa_options = array(
        'headertext' => '@HEALTHSPAFI',
        'showheader' => true,
        'showfollow' => false,
        'showlogo' => false,
        'num' => 3,
        'width' => '100%',
        'height' => 'auto',
        'bgcolor' => 'transparent',
        'textcolor' => '#ffffff',
        'linkcolor' => '#ffffff',
        'includereplies' => false,
        'includeretweets' => true,
    );

    return array_merge($options, $spa_options);
}, 10, 2);

// Add custom CSS to head for immediate styling
add_action('wp_head', function() {
    ?>
    <style>
        /* Immediate Twitter Feed Styling */
        .ctf {
            background: linear-gradient(135deg, #1da1f2 0%, #0d8bd9 100%) !important;
            color: #ffffff !important;
            border-radius: 0 !important;
            font-family: 'Open Sans', sans-serif !important;
        }

        .ctf-header-text::before {
            content: '🐦 ' !important;
            margin-right: 0.5rem !important;
        }

        .ctf-tweet {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
            background: transparent !important;
            color: #ffffff !important;
        }

        .ctf-tweet-text {
            color: #ffffff !important;
        }

        .ctf-tweet-time {
            color: rgba(255, 255, 255, 0.7) !important;
            text-transform: uppercase !important;
            font-size: 0.75rem !important;
        }
    </style>
    <?php
});

// Widget for Custom Twitter Feeds
class SPA_Custom_Twitter_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'spa_custom_twitter_widget',
            'SPA Custom Twitter Feed',
            array('description' => 'Display Custom Twitter Feeds with SPA styling')
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];

        // Get the shortcode from Custom Twitter Feeds plugin
        $feed_id = !empty($instance['feed_id']) ? $instance['feed_id'] : '1';
        $num_tweets = !empty($instance['num_tweets']) ? $instance['num_tweets'] : '3';

        // Output the Custom Twitter Feeds shortcode
        if (function_exists('ctf_init')) {
            echo do_shortcode('[custom-twitter-feeds feed=' . $feed_id . ' num=' . $num_tweets . ']');
        } else {
            // Fallback if plugin not active
            echo '<div class="ctf twitter-feed-fallback">';
            echo '<div class="ctf-header">';
            echo '<div class="ctf-header-text">🐦 @HEALTHSPAFI</div>';
            echo '</div>';
            echo '<div class="ctf-tweet">';
            echo '<div class="ctf-tweet-time">ABOUT 1 HOUR AGO</div>';
            echo '<div class="ctf-tweet-text">Please install and configure the Custom Twitter Feeds plugin to display tweets.</div>';
            echo '</div>';
            echo '</div>';
        }

        echo $args['after_widget'];
    }

    public function form($instance) {
        $feed_id = !empty($instance['feed_id']) ? $instance['feed_id'] : '1';
        $num_tweets = !empty($instance['num_tweets']) ? $instance['num_tweets'] : '3';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('feed_id'); ?>">Feed ID:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('feed_id'); ?>"
                   name="<?php echo $this->get_field_name('feed_id'); ?>" type="text"
                   value="<?php echo esc_attr($feed_id); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('num_tweets'); ?>">Number of Tweets:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('num_tweets'); ?>"
                   name="<?php echo $this->get_field_name('num_tweets'); ?>" type="number"
                   value="<?php echo esc_attr($num_tweets); ?>" min="1" max="10" />
        </p>
        <p><small>Make sure you have configured your Twitter feed in the Custom Twitter Feeds plugin settings.</small></p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['feed_id'] = (!empty($new_instance['feed_id'])) ? strip_tags($new_instance['feed_id']) : '';
        $instance['num_tweets'] = (!empty($new_instance['num_tweets'])) ? absint($new_instance['num_tweets']) : 3;
        return $instance;
    }
}

// Register the widget
add_action('widgets_init', function() {
    register_widget('SPA_Custom_Twitter_Widget');
});

// Shortcode for Custom Twitter Feeds with SPA styling
add_shortcode('spa_custom_twitter', function($atts) {
    $atts = shortcode_atts(array(
        'feed' => '1',
        'num' => '3',
        'username' => 'HEALTHSPAFI'
    ), $atts);

    if (function_exists('ctf_init')) {
        return do_shortcode('[custom-twitter-feeds feed=' . $atts['feed'] . ' num=' . $atts['num'] . ']');
    } else {
        // Fallback HTML
        ob_start();
        ?>
        <div class="ctf twitter-feed-fallback">
            <div class="ctf-header">
                <div class="ctf-header-text">🐦 @<?php echo esc_html($atts['username']); ?></div>
            </div>
            <div class="ctf-tweet">
                <div class="ctf-tweet-time">ABOUT 1 HOUR AGO</div>
                <div class="ctf-tweet-text">Please install and configure the Custom Twitter Feeds plugin to display tweets.</div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
});

// Auto-add Twitter widget to sidebar if empty
add_action('wp_loaded', function() {
    $sidebars_widgets = get_option('sidebars_widgets');

    if (empty($sidebars_widgets['foundation_sidebar_right']) || count($sidebars_widgets['foundation_sidebar_right']) == 0) {
        // Add Twitter widget automatically
        $sidebars_widgets['foundation_sidebar_right'] = array('spa_custom_twitter_widget-1');

        // Set widget options
        $widget_options = get_option('widget_spa_custom_twitter_widget');
        if (!$widget_options) {
            $widget_options = array();
        }

        $widget_options[1] = array(
            'feed_id' => '1',
            'num_tweets' => '3'
        );

        update_option('widget_spa_custom_twitter_widget', $widget_options);
        update_option('sidebars_widgets', $sidebars_widgets);
    }
});

// Add admin notice for plugin requirement
add_action('admin_notices', function() {
    if (!function_exists('ctf_init')) {
        ?>
        <div class="notice notice-warning">
            <p><strong>SPA Twitter Integration:</strong> Please install and activate the "Custom Twitter Feeds" plugin for full Twitter functionality. <a href="<?php echo admin_url('plugin-install.php?s=custom+twitter+feeds&tab=search&type=term'); ?>">Install Now</a></p>
        </div>
        <?php
    }
});
