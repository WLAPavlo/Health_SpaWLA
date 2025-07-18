<?php
/**
 * Template Name: Home Page.
 */

// Disable any debug output for this template
if (!is_admin()) {
    error_reporting(0);
    ini_set('display_errors', 0);
}

get_header(); ?>

<!--HOME PAGE SLIDER-->
<?php if (shortcode_exists('slider')) {
    echo do_shortcode('[slider]');
} ?>
<!--END of HOME PAGE SLIDER-->

<!-- BEGIN of main content -->
<div class="spa-layout">
    <div class="grid-container">
        <div class="grid-x grid-margin-x align-stretch">
            <!-- Hero Section (WYSIWYG) -->
            <?php
            $hero_section = get_field('hero_section');
            if ($hero_section): ?>
                <div class="cell large-8">
                    <div class="hero-section">
                        <div class="hero-content">
                            <?php echo $hero_section; ?>
                        </div>
                    </div>
                </div>

                <!-- Sidebar CTA -->
                <?php
                $sidebar_cta = get_field('sidebar_cta');
                if ($sidebar_cta): ?>
                <section class='cta-block'>
                    <div class="cell large-4">
                        <div class="sidebar-cta">
                            <?php if ($sidebar_cta['title']): ?>
                                <h3 class="cta-title"><?php echo esc_html($sidebar_cta['title']); ?></h3>
                            <?php endif; ?>

                            <?php if ($sidebar_cta['description']): ?>
                                <div class="cta-description">
                                    <?php echo nl2br(esc_html($sidebar_cta['description'])); ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($sidebar_cta['button']): ?>
                                <div class="cta-button">
                                    <a href="<?php echo esc_url($sidebar_cta['button']['url']); ?>"
                                       class="btn-cta"
                                       <?php if ($sidebar_cta['button']['target']): ?>target="<?php echo esc_attr($sidebar_cta['button']['target']); ?>"<?php endif; ?>>
                                        <?php echo esc_html($sidebar_cta['button']['title']); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- SPA Events Section -->
    <?php
    // Get events section settings from ACF, with fallbacks
    $events_section_title = get_field('events_section_title') ?: 'Upcoming Events';
    $events_section_link = get_field('events_section_link') ?: array('url' => get_post_type_archive_link('spa_event'), 'title' => 'SEE ALL');
    $events_background_image = get_field('events_background_image');

    // Get current date for comparison
    $current_date = date('Y-m-d');

    // Query for featured event (upcoming events only)
    $featured_event_query = new WP_Query([
        'post_type' => 'spa_event',
        'posts_per_page' => 1,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC'
    ]);

    $featured_event = $featured_event_query->have_posts() ? $featured_event_query->posts[0] : null;

    // Query for regular events (upcoming events, excluding featured)
    $regular_events_query = new WP_Query([
        'post_type' => 'spa_event',
        'posts_per_page' => 2,
        'post_status' => 'publish',
        'post__not_in' => $featured_event ? [$featured_event->ID] : [],
        'orderby' => 'date',
        'order' => 'DESC'
    ]);

    $regular_events = $regular_events_query->posts;

    // Debug: Let's check if we have any spa_event posts at all
    $all_events_query = new WP_Query([
        'post_type' => 'spa_event',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    ]);

    // Always show the section, even if no events (for debugging)
    ?>
    <section class="spa-events-section"
        <?php if ($events_background_image): ?>
            style="background-image: url('<?php echo esc_url($events_background_image['url']); ?>');"
        <?php endif; ?>>
        <div class="spa-events-overlay">


            <div class="grid-container">
                <div class="grid-x grid-margin-x">
                    <!-- Decorative stripe for events -->

                    <!-- Section Header -->
                    <div class="cell">
                        <div class="spa-events-header">
                            <?php if ($events_section_title): ?>
                                <h2 class="spa-events-title"><?php echo esc_html($events_section_title); ?></h2>
                            <?php endif; ?>

                            <?php if ($events_section_link): ?>
                                <a href="<?php echo esc_url($events_section_link['url']); ?>"
                                   class="spa-events-see-all"
                                   <?php if ($events_section_link['target']): ?>target="<?php echo esc_attr($events_section_link['target']); ?>"<?php endif; ?>>
                                    <?php echo esc_html($events_section_link['title'] ?: 'SEE ALL'); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- White container for all events -->
    <div class="cell">
        <div class="spa-events-white-container">
            <!-- Static stripe for Featured Event -->
            <div class="featured-event-stripe">
                <div class="stripe-text">
                    <?php
                    $stripe_text = get_field('featured_events_stripe_text', 'options');
                    echo esc_html($stripe_text ?: 'FEATURED EVENTS - FEATURED EVENTS - FEATURED EVENTS - FEATURED EVENTS');
                    ?>
                </div>
            </div>

            <!-- Featured Event -->
            <?php if ($featured_event): ?>
                <div class="featured-event">
                    <div class="event-date-block">
                        <?php
                        $event_date = get_field('event_date', $featured_event->ID);?>
                        <?php if ($event_date): ?>
                            <?php
                            $timestamp = strtotime($event_date);
                            if ($timestamp) {
                                $month = strtoupper(date('M', $timestamp));
                                $day = date('j', $timestamp);
                                ?>
                                <div class="event-month"><?php echo esc_html($month); ?></div>
                                <div class="event-day"><?php echo esc_html($day); ?></div>
                            <?php } ?>
                        <?php endif; ?>
                    </div>
                    <div class="event-content">
                        <?php
                        $event_location = get_field('event_location', $featured_event->ID);
                        $event_logo = get_field('event_logo', $featured_event->ID);
                        $home_decripthion = get_field('home_decripthion', $featured_event->ID);
                        $home_link = get_field('home_link', $featured_event->ID);
                        ?>

                        <?php if ($event_location): ?>
                            <div class="event-location"><?php echo esc_html($event_location); ?></div>
                        <?php else: ?>
                            <div class="event-location">Helsinki</div>
                        <?php endif; ?>

                        <h3 class="event-title"><?php echo esc_html($featured_event->post_title); ?></h3>

                        <?php if ($home_decripthion): ?>
                            <div class="event-description">
                                <?php echo wp_kses_post($home_decripthion); ?>
                            </div>
                        <?php else: ?>
                            <div class="event-description">
                            </div>
                        <?php endif; ?>

                        <?php if ($home_link): ?>
                            <a href="<?php echo esc_url($home_link['url']); ?>"
                               class="event-read-more"
                               <?php if ($home_link['target']): ?>target="<?php echo esc_attr($home_link['target']); ?>"<?php endif; ?>>
                                <?php echo esc_html($home_link['title'] ?: 'READ MORE'); ?>
                            </a>
                        <?php else: ?>
                            <a href="<?php echo get_permalink($featured_event->ID); ?>" class="event-read-more">
                                READ MORE
                            </a>
                        <?php endif; ?>
                    </div>
                    <?php if ($event_logo): ?>
                        <div class="event-logo">
                            <img src="<?php echo esc_url($event_logo['url']); ?>" alt="<?php echo esc_attr($event_logo['alt']); ?>">
                        </div>
                    <?php endif; ?>
                </div>
            <?php else: ?>
            <?php endif; ?>

            <hr>

            <!-- Regular Events -->
            <?php if (!empty($regular_events)): ?>
                <div class="regular-events">
                    <?php foreach ($regular_events as $event): ?>
                        <div class="regular-event">
                            <div class="event-date-block">
                                <?php $event_date = get_field('event_date', $featured_event->ID);?>
                                <?php if ($event_date): ?>
                                    <?php
                                    $timestamp = strtotime($event_date);
                                    if ($timestamp) {
                                        $month = strtoupper(date('M', $timestamp));
                                        $day = date('j', $timestamp);
                                        ?>
                                        <div class="event-month"><?php echo esc_html($month); ?></div>
                                        <div class="event-day"><?php echo esc_html($day); ?></div>
                                    <?php } ?>
                                <?php endif; ?>
                            </div>

                            <div class="event-content">
                                <?php
                                $event_location = get_field('event_location', $event->ID);
                                $event_subtitle = get_field('event_subtitle', $event->ID);
                                $home_decripthion = get_field('home_decripthion', $event->ID);
                                $home_link = get_field('home_link', $event->ID);
                                ?>

                                <?php if ($event_location): ?>
                                    <div class="event-location"><?php echo esc_html($event_location); ?></div>
                                <?php else: ?>
                                    <div class="event-location">Tampere</div>
                                <?php endif; ?>

                                <h4 class="event-title"><?php echo esc_html($event->post_title); ?></h4>

                                <?php if ($event_subtitle): ?>
                                    <div class="event-subtitle"><?php echo esc_html($event_subtitle); ?></div>
                                <?php endif; ?>

                                <?php if ($home_decripthion): ?>
                                    <div class="event-description">
                                        <?php echo wp_kses_post($home_decripthion); ?>
                                    </div>
                                <?php else: ?>
                                    <div class="event-description">
                                        <?php echo wp_kses_post($event->post_excerpt ?: wp_trim_words($event->post_content, 20)); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($home_link): ?>
                                    <a href="<?php echo esc_url($home_link['url']); ?>"
                                       class="event-read-more"
                                       <?php if ($home_link['target']): ?>target="<?php echo esc_attr($home_link['target']); ?>"<?php endif; ?>>
                                        <?php echo esc_html($home_link['title'] ?: 'READ MORE'); ?>
                                    </a>
                                <?php else: ?>
                                    <a href="<?php echo get_permalink($event->ID); ?>" class="event-read-more">
                                        READ MORE
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
            <?php endif; ?>
        </div>
    </div>

    <?php
    // Reset post data after custom queries
    wp_reset_postdata();
    ?>

    <!-- Stories Section -->
    <?php
    $stories_count = get_option('spa_stories_count', 3);

    $stories_query = new WP_Query([
        'post_type' => 'post',
        'posts_per_page' => $stories_count,
        'post_status' => 'publish'
    ]);

    if ($stories_query->have_posts()): ?>
        <section class="stories-section">


            <div class="grid-container">
                <div class="grid-x grid-margin-x">
                    <div class="cell">
                        <!-- Simple colored block for stories -->
                        <div class="stories-color-block"></div>
                        <div class="stories-header">
                            <h2 class="stories-title">Stories</h2>

                            <?php
                            $story_link = get_field('story_link');
                            if ($story_link): ?>
                                <a href="<?php echo esc_url($story_link['url']); ?>" class="stories-see-all">
                                    <?php echo esc_html($story_link['title']); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="cell">
                        <div class="stories-grid">
                            <?php while ($stories_query->have_posts()): $stories_query->the_post(); ?>
                                <div class="story-item">
                                    <?php if (has_post_thumbnail()): ?>
                                        <div class="story-image">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail('medium_large'); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>

                                    <div class="story-content">
                                        <div class="story-meta">
                                            <?php
                                            $post_date = get_the_date('Y-m-d');
                                            $timestamp = strtotime($post_date);
                                            $story_date = strtoupper(date('M', $timestamp)) . ' ' . date('j', $timestamp);

                                            $categories = get_the_category();
                                            $story_category = !empty($categories) ? strtoupper($categories[0]->name) : '';

                                            $story_author = get_the_author();

                                            $tags = get_the_tags();
                                            $story_news = '';
                                            if ($tags) {
                                                $story_news = strtoupper($tags[0]->name);
                                            }
                                            ?>

                                            <div class="story-meta-line">
                                                <?php if ($story_date): ?>
                                                    <span class="story-date"><?php echo esc_html($story_date); ?></span>
                                                <?php endif; ?>

                                                <?php if ($story_news): ?>
                                                    <?php if ($story_date): ?>
                                                        <span class="story-separator">|</span>
                                                    <?php endif; ?>
                                                    <span
                                                        class="story-category"><?php echo esc_html($story_news); ?></span>
                                                <?php endif; ?>

                                                <?php if ($story_category): ?>
                                                    <?php if ($story_date || $story_news): ?>
                                                        <span class="story-separator">|</span>
                                                    <?php endif; ?>
                                                    <span
                                                        class="story-category"><?php echo esc_html($story_category); ?></span>
                                                <?php endif; ?>
                                            </div>

                                            <div class="story-author"><?php echo esc_html($story_author); ?></div>
                                        </div>

                                        <h3 class="story-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h3>

                                        <div class="story-excerpt">
                                            <?php
                                            $excerpt = get_the_excerpt();
                                            if (strlen($excerpt) > 120) {
                                                $excerpt = substr($excerpt, 0, 120) . '<span style="color: #f75097;">...</span>';
                                            }
                                            echo $excerpt;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; wp_reset_postdata(); ?>
<section class='home-twitter'>
    <div class="grid-container">
        <div class="grid-x grid-margin-x">
            <div class="cell">
                <?php if (have_posts()) { ?>
                    <?php while (have_posts()) {
                        the_post(); ?>
                        <div class="page-content">
                            <?php the_content(); ?>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
</div>
<!-- END of main content -->

<?php get_footer(); ?>
