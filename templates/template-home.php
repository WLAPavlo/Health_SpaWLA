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
                        <?php echo $hero_section; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Sidebar CTA -->
            <?php
            $sidebar_cta = get_field('sidebar_cta');
            if ($sidebar_cta): ?>
                <div class="cell large-4">
                    <div class="sidebar-cta"
                         style="background-color: <?php echo esc_attr($sidebar_cta['background_color'] ?: '#2980b9'); ?>;
                             color: <?php echo esc_attr($sidebar_cta['text_color'] ?: '#ffffff'); ?>;">

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
                                   class="btn btn-cta"
                                   <?php if ($sidebar_cta['button']['target']): ?>target="<?php echo esc_attr($sidebar_cta['button']['target']); ?>"<?php endif; ?>>
                                    <?php echo esc_html($sidebar_cta['button']['title']); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ACF Buttons -->
            <?php
            $acf_buttons = get_field('acf_buttons');
            if ($acf_buttons): ?>
                <div class="cell">
                    <div class="acf-buttons">
                        <?php foreach ($acf_buttons as $button): ?>
                            <div class="acf-button-item">
                                <?php if ($button['link']): ?>
                                <a href="<?php echo esc_url($button['link']); ?>"
                                   class="btn acf-btn"
                                   style="background-color: <?php echo esc_attr($button['color'] ?: '#f39c12'); ?>;">
                                    <?php endif; ?>

                                    <?php echo esc_html($button['text']); ?>

                                    <?php if ($button['link']): ?>
                                </a>
                            <?php else: ?>
                                <span class="btn acf-btn"
                                      style="background-color: <?php echo esc_attr($button['color'] ?: '#f39c12'); ?>;">
                                    <?php echo esc_html($button['text']); ?>
                                </span>
                            <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
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

                    <!-- Featured Event -->
                    <?php if ($featured_event): ?>
                        <div class="cell">
                            <div class="featured-event">
                                <div class="event-date-block">
                                    <?php
                                    $event_month = get_field('event_month', $featured_event->ID);
                                    $event_day = get_field('event_day', $featured_event->ID);
                                    ?>
                                    <?php if ($event_month): ?>
                                        <div class="event-month"><?php echo esc_html($event_month); ?></div>
                                    <?php endif; ?>
                                    <?php if ($event_day): ?>
                                        <div class="event-day"><?php echo esc_html($event_day); ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="event-content">
                                    <?php
                                    $event_location = get_field('event_location', $featured_event->ID);
                                    $event_logo = get_field('event_logo', $featured_event->ID);
                                    $event_description = get_field('event_description', $featured_event->ID);
                                    $event_link = get_field('event_link', $featured_event->ID);
                                    ?>

                                    <?php if ($event_location): ?>
                                        <div class="event-location"><?php echo esc_html($event_location); ?></div>
                                    <?php endif; ?>

                                    <h3 class="event-title"><?php echo esc_html($featured_event->post_title); ?></h3>

                                    <?php if ($event_description): ?>
                                        <div class="event-description">
                                            <?php echo wp_kses_post($event_description); ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($event_link): ?>
                                        <a href="<?php echo esc_url($event_link['url']); ?>"
                                           class="event-read-more"
                                           <?php if ($event_link['target']): ?>target="<?php echo esc_attr($event_link['target']); ?>"<?php endif; ?>>
                                            <?php echo esc_html($event_link['title'] ?: 'READ MORE'); ?>
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
                        </div>
                    <?php endif; ?>

                    <!-- Regular Events -->
                    <?php if ($regular_events): ?>
                        <div class="cell">
                            <div class="regular-events">
                                <?php foreach ($regular_events as $event): ?>
                                    <div class="regular-event">
                                        <div class="event-date-block">
                                            <?php
                                            $event_month = get_field('event_month', $event->ID);
                                            $event_day = get_field('event_day', $event->ID);
                                            ?>
                                            <?php if ($event_month): ?>
                                                <div class="event-month"><?php echo esc_html($event_month); ?></div>
                                            <?php endif; ?>
                                            <?php if ($event_day): ?>
                                                <div class="event-day"><?php echo esc_html($event_day); ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="event-content">
                                            <?php
                                            $event_location = get_field('event_location', $event->ID);
                                            $event_subtitle = get_field('event_subtitle', $event->ID);
                                            $event_description = get_field('event_description', $event->ID);
                                            $event_link = get_field('event_link', $event->ID);
                                            ?>

                                            <?php if ($event_location): ?>
                                                <div class="event-location"><?php echo esc_html($event_location); ?></div>
                                            <?php endif; ?>

                                            <h4 class="event-title"><?php echo esc_html($event->post_title); ?></h4>

                                            <?php if ($event_subtitle): ?>
                                                <div class="event-subtitle"><?php echo esc_html($event_subtitle); ?></div>
                                            <?php endif; ?>

                                            <?php if ($event_description): ?>
                                                <div class="event-description">
                                                    <?php echo wp_kses_post($event_description); ?>
                                                </div>
                                            <?php endif; ?>

                                            <?php if ($event_link): ?>
                                                <a href="<?php echo esc_url($event_link['url']); ?>"
                                                   class="event-read-more"
                                                   <?php if ($event_link['target']): ?>target="<?php echo esc_attr($event_link['target']); ?>"<?php endif; ?>>
                                                    <?php echo esc_html($event_link['title'] ?: 'READ MORE'); ?>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

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
