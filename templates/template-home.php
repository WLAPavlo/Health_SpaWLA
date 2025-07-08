<?php
/**
 * Template Name: Home Page.
 */
get_header(); ?>

<!--HOME PAGE SLIDER-->
<?php if (shortcode_exists('slider')) {
    echo do_shortcode('[slider]');
} ?>
<!--END of HOME PAGE SLIDER-->

<!-- BEGIN of main content -->
<div class="grid-container">
    <div class="grid-x grid-margin-x">
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
        <?php endif; ?>

        <!-- Sidebar CTA -->
        <?php
        $sidebar_cta = get_field('sidebar_cta');
        if ($sidebar_cta): ?>
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
        <?php endif; ?>
    </div>
</div>

<!-- SPA Events Section -->
<?php
$events_section_title = get_field('events_section_title');
$events_section_link = get_field('events_section_link');
$events_background_image = get_field('events_background_image');
$featured_event = get_field('featured_event');
$regular_events = get_field('regular_events');

if ($events_section_title || $featured_event || $regular_events): ?>
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

                    <!-- White container for all events -->
                    <div class="cell">
                        <div class="spa-events-white-container">
                            <div class="decorative-stripe events-stripe">
                                <span>FEATURED EVENT</span>
                                <span>FEATURED EVENT</span>
                                <span>FEATURED EVENT</span>
                                <span>FEATURED EVENT</span>
                                <span>FEATURED EVENT</span>
                                <span>FEATURED EVENT</span>
                                <span>FEATURED EVENT</span>
                                <span>FEATURED EVENT</span>
                                <span>FEATURED EVENT</span>
                                <span>FEATURED EVENT</span>
                                <span>FEATURED EVENT</span>
                                <span>FEATURED EVENT</span>
                                <span>FEATURED EVENT</span>
                                <span>FEATURED EVENT</span>
                            </div>
                            <!-- Featured Event -->
                            <?php if ($featured_event): ?>
                                <div class="featured-event">
                                    <div class="event-date-block">
                                        <?php
                                        $home_month = get_field('home_month', $featured_event->ID);
                                        $event_day = get_field('event_day', $featured_event->ID);
                                        ?>
                                        <?php if ($home_month): ?>
                                            <div class="event-month"><?php echo esc_html($home_month); ?></div>
                                        <?php endif; ?>
                                        <?php if ($event_day): ?>
                                            <div class="event-day"><?php echo esc_html($event_day); ?></div>
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
                                        <?php endif; ?>

                                        <h3 class="event-title"><?php echo esc_html($featured_event->post_title); ?></h3>

                                        <?php if ($home_decripthion): ?>
                                            <div class="event-description">
                                                <?php echo wp_kses_post($home_decripthion); ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($home_link): ?>
                                            <a href="<?php echo esc_url($home_link['url']); ?>"
                                               class="event-read-more"
                                               <?php if ($home_link['target']): ?>target="<?php echo esc_attr($home_link['target']); ?>"<?php endif; ?>>
                                                <?php echo esc_html($home_link['title'] ?: 'READ MORE'); ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>

                                    <?php if ($event_logo): ?>
                                        <div class="event-logo">
                                            <img src="<?php echo esc_url($event_logo['url']); ?>"
                                                 alt="<?php echo esc_attr($event_logo['alt'] ?: $featured_event->post_title); ?>">
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <!-- Regular Events -->
                            <?php if ($regular_events): ?>
                                <div class="regular-events">
                                    <?php foreach ($regular_events as $event): ?>
                                        <div class="regular-event">
                                            <div class="event-date-block">
                                                <?php
                                                $home_month = get_field('home_month', $event->ID);
                                                $event_day = get_field('event_day', $event->ID);
                                                ?>
                                                <?php if ($home_month): ?>
                                                    <div class="event-month"><?php echo esc_html($home_month); ?></div>
                                                <?php endif; ?>
                                                <?php if ($event_day): ?>
                                                    <div class="event-day"><?php echo esc_html($event_day); ?></div>
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
                                                <?php endif; ?>

                                                <h4 class="event-title"><?php echo esc_html($event->post_title); ?></h4>

                                                <?php if ($event_subtitle): ?>
                                                    <div class="event-subtitle"><?php echo esc_html($event_subtitle); ?></div>
                                                <?php endif; ?>

                                                <?php if ($home_decripthion): ?>
                                                    <div class="event-description">
                                                        <?php echo wp_kses_post($home_decripthion); ?>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if ($home_link): ?>
                                                    <a href="<?php echo esc_url($home_link['url']); ?>"
                                                       class="event-read-more"
                                                       <?php if ($home_link['target']): ?>target="<?php echo esc_attr($home_link['target']); ?>"<?php endif; ?>>
                                                        <?php echo esc_html($home_link['title']); ?>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- Stories Section -->
<?php
$stories_query = new WP_Query([
    'post_type' => 'post',
    'posts_per_page' => 3,
    'post_status' => 'publish'
]);

if ($stories_query->have_posts()): ?>
    <section class="stories-section">


        <div class="grid-container">
            <div class="grid-x grid-margin-x">
                <div class="cell">
                    <!-- Decorative stripe for stories -->
                    <div class="decorative-stripe stories-stripe">
                        <span>STORIES</span>
                        <span>STORIES</span>
                        <span>STORIES</span>
                        <span>STORIES</span>
                        <span>STORIES</span>
                        <span>STORIES</span>
                        <span>STORIES</span>
                        <span>STORIES</span>
                        <span>STORIES</span>
                        <span>STORIES</span>
                        <span>STORIES</span>
                        <span>STORIES</span>
                        <span>STORIES</span>
                        <span>STORIES</span>
                    </div>
                    <div class="stories-header">
                        <h2 class="stories-title">Stories</h2>

                        <?php
                        $story_link = get_field('story_link'); // отримуємо посилання з ACF
                        if ($story_link): ?>
                            <a href="<?php echo esc_url($story_link['url']); ?>" class="stories-see-all">
                                <?php echo esc_html($story_link['title']); // або будь-який текст ?>
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
                                        $story_date = get_field('story_date');
                                        $story_category = get_field('story_category');
                                        $story_author = get_field('story_author');
                                        $story_news = get_field('story_news');

                                        // Якщо немає кастомної дати, використовуємо дату публікації
                                        if (!$story_date) {
                                            $story_date = get_the_date('M j');
                                        }

                                        if(!$story_news) {
                                            $story_news = '';
                                        }

                                        // Якщо немає кастомного автора, використовуємо WordPress автора
                                        if (!$story_author) {
                                            $story_author = get_the_author();
                                        }

                                        // Якщо немає кастомної категорії, використовуємо першу категорію WordPress
                                        if (!$story_category) {
                                            $categories = get_the_category();
                                            if (!empty($categories)) {
                                                $story_category = strtoupper($categories[0]->name);
                                            } else {
                                                $story_category = '';
                                            }
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
                                                <span class="story-category"><?php echo esc_html($story_news); ?></span>
                                            <?php endif; ?>

                                            <?php if ($story_category): ?>
                                                <?php if ($story_date || $story_news): ?>
                                                    <span class="story-separator">|</span>
                                                <?php endif; ?>
                                                <span class="story-category"><?php echo esc_html($story_category); ?></span>
                                            <?php endif; ?>
                                        </div>

                                        <div class="story-author"><?php echo esc_html($story_author); ?></div>
                                    </div>

                                    <h3 class="story-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>

                                    <div class="story-excerpt">
                                        <?php
                                        $story_excerpt = get_field('story_excerpt');
                                        if ($story_excerpt) {
                                            echo wp_kses_post($story_excerpt);
                                        } else {
                                            // Обрізаємо excerpt до 120 символів
                                            $excerpt = get_the_excerpt();
                                            if (strlen($excerpt) > 120) {
                                                $excerpt = substr($excerpt, 0, 120) . '...';
                                            }
                                            echo $excerpt;
                                        }
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

<!-- Standard Page Content (якщо потрібно) -->
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
<!-- END of main content -->

<?php get_footer(); ?>
