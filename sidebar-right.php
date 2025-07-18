<?php
/**
 * Sidebar Right - with Custom Twitter Feeds Integration
 */

// Check if we have any widgets
$sidebar_widgets = wp_get_sidebars_widgets();
$has_widgets = !empty($sidebar_widgets['foundation_sidebar_right']);

// Twitter feed configuration
$twitter_config = array(
    'feed_id' => 1,
    'num_tweets' => 2,
    'cols_desktop' => 2,
    'cols_tablet' => 2,
    'cols_mobile' => 1,
    'username' => 'HEALTHSPAFI'
);

if (!$has_widgets) {
    // Auto-display Twitter feed if no widgets
    if (function_exists('ctf_init')) {
        echo '<div class="widget widget_ctf_widget">';
        echo do_shortcode(sprintf(
            '[custom-twitter-feeds feed=%d num=%d cols=%d colsmobile=%d colstablet=%d]',
            $twitter_config['feed_id'],
            $twitter_config['num_tweets'],
            $twitter_config['cols_desktop'],
            $twitter_config['cols_mobile'],
            $twitter_config['cols_tablet']
        ));
        echo '</div>';
    } else {
        // Fallback display
        render_twitter_fallback($twitter_config);
    }
} else {
    // Display regular sidebar widgets
    if (is_active_sidebar('foundation_sidebar_right')) {
        dynamic_sidebar('foundation_sidebar_right');
    }
}

/**
 * Render Twitter fallback HTML
 */
function render_twitter_fallback($config) {
    $username = '@' . esc_html($config['username']);
    $fallback_tweets = array(
        array(
            'time' => 'ABOUT 1 HOUR AGO',
            'text' => 'Our friends @cofoundermag had a look at what the #health #technology scene in Estonia looks like @htcluster'
        ),
        array(
            'time' => 'ABOUT 1 HOUR AGO',
            'text' => 'Join the #Wellness and #Health Tech fair tomorrow in @messukesku! Meet @Nurse_Buddy, @Sensorend_Fi and others!'
        ),
        array(
            'time' => 'ABOUT 1 HOUR AGO',
            'text' => 'Heard about the @WearableTech event coming up Feb 2-3? It\'s #huge! #wearables #mhealth'
        )
    );
    ?>
    <div class="widget widget_ctf_widget">
        <div class="ctf twitter-feed-fallback spa-twitter-fallback">
            <div class="ctf-header">
                <div class="twitter-username">
                    <svg class="twitter-logo" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                    </svg>
                    <?php echo $username; ?>
                </div>
            </div>
            <div class="ctf-tweets">
                <?php foreach ($fallback_tweets as $tweet): ?>
                    <div class="ctf-tweet">
                        <div class="ctf-tweet-time"><?php echo esc_html($tweet['time']); ?></div>
                        <div class="ctf-tweet-text"><?php echo esc_html($tweet['text']); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php
}
?>
