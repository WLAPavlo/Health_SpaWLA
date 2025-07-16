<?php
/**
 * Sidebar Right - with Custom Twitter Feeds Integration
 */

// Check if we have any widgets
$sidebar_widgets = wp_get_sidebars_widgets();
$has_widgets = !empty($sidebar_widgets['foundation_sidebar_right']);

if (!$has_widgets) {
    // Auto-display Twitter feed if no widgets
    if (function_exists('ctf_init')) {
        echo '<div class="widget widget_ctf_widget">';
        echo do_shortcode('[custom-twitter-feeds feed=1 num=3]');
        echo '</div>';
    } else {
        // Fallback display
        ?>
        <div class="widget widget_ctf_widget">
            <div class="ctf twitter-feed-fallback">
                <div class="ctf-header">
                    <div class="ctf-header-text">🐦 @HEALTHSPAFI</div>
                </div>
                <div class="ctf-tweet">
                    <div class="ctf-tweet-time">ABOUT 1 HOUR AGO</div>
                    <div class="ctf-tweet-text">Our friends @cofoundermag had a look at what the #health #technology scene in Estonia looks like @htcluster http://www.healthspa.fi/estonian-health-cluster-from-web-to-</div>
                </div>
                <div class="ctf-tweet">
                    <div class="ctf-tweet-time">ABOUT 1 HOUR AGO</div>
                    <div class="ctf-tweet-text">Join the #Wellness and #Health Tech fair tomorrow in @messukesku! Meet @Nurse_Buddy, @Sensorend_Fi and others! #mhealth</div>
                </div>
                <div class="ctf-tweet">
                    <div class="ctf-tweet-time">ABOUT 1 HOUR AGO</div>
                    <div class="ctf-tweet-text">Heard about the @WearableTech event coming up Feb 2-3? It's #huge! #wearables #mhealth https://www.youtube.com/watch?v=4_6Xu62Ujl4</div>
                </div>
            </div>
        </div>
        <?php
    }
} else {
    // Display regular sidebar widgets
    if (is_active_sidebar('foundation_sidebar_right')) {
        dynamic_sidebar('foundation_sidebar_right');
    }
}
?>
