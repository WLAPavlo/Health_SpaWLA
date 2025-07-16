<?php
/**
 * Twitter Feed Template Part
 *
 * Usage: get_template_part('parts/twitter-feed');
 */

$twitter_username = get_field('twitter_username', 'options') ?: 'HEALTHSPAFI';
$twitter_posts = get_field('twitter_posts', 'options');
$display_settings = get_field('twitter_display_settings', 'options');
$posts_count = $display_settings['posts_count'] ?? 3;

// Demo data if no posts configured
if (empty($twitter_posts)) {
    $twitter_posts = [
        [
            'text' => 'Our friends @cofoundermag had a look at what the #health #technology scene in Estonia looks like @hicu_ee',
            'link' => 'http://www.healthspa.fi/estonian-health-cluster-from-web-to-',
            'time' => 'ABOUT 1 HOUR AGO'
        ],
        [
            'text' => 'Join the #Wellness and #Health Tech fair tomorrow in @messukeskus! Meet @Nurse_Buddy, @Sensorend_Fi and others!',
            'link' => '',
            'time' => 'ABOUT 1 HOUR AGO'
        ],
        [
            'text' => 'Heard about the @WearableTech event coming up Feb 2-3? It\'s #huge! #wearables #mhealth',
            'link' => 'https://www.youtube.com/watch?v=4_6Xu2UjI4...',
            'time' => 'ABOUT 1 HOUR AGO'
        ]
    ];
}

function format_twitter_text($text) {
    // Format hashtags
    $text = preg_replace('/#([a-zA-Z0-9_]+)/', '<span class="hashtag">#$1</span>', $text);

    // Format mentions
    $text = preg_replace('/@([a-zA-Z0-9_]+)/', '<span class="mention">@$1</span>', $text);

    return $text;
}
?>

<div class="spa-twitter-feed">
    <?php
    $displayed = 0;
    foreach ($twitter_posts as $post):
        if ($displayed >= $posts_count) break;
        ?>
        <div class="twitter-post">
            <div class="twitter-time"><?php echo esc_html($post['time']); ?></div>
            <div class="twitter-text"><?php echo format_twitter_text($post['text']); ?></div>

            <?php if (!empty($post['link'])): ?>
                <div class="twitter-link">
                    <a href="<?php echo esc_url($post['link']); ?>" target="_blank" rel="noopener">
                        <?php echo esc_html($post['link']); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
        <?php
        $displayed++;
    endforeach;
    ?>
</div>
