<?php
/**
 * Template Name: Events Page
 */
get_header(); ?>

<main class="main-content events-page">
    <div class="grid-container">
        <div class="grid-x grid-margin-x">
            <div class="cell">
                <!-- Page Title -->
                <div class="events-page-header">
                    <h1 class="events-page-title">Upcoming events</h1>
                </div>



                <!-- Events List -->
                <div class="events-list">
                    <!-- Events Info Stripe -->
                    <?php
                    $events_stripe_text = get_field('events_stripe_text', 'options');
                    if ($events_stripe_text): ?>
                        <div class="events-info-stripe">
                            <p class="stripe-text"><?php echo esc_html($events_stripe_text); ?></p>
                        </div>
                    <?php endif; ?>
                    <?php
                    // Pagination setup
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

                    // Get SPA Events with pagination
                    $events_query = new WP_Query([
                        'post_type' => 'spa_event',
                        'posts_per_page' => 3,
                        'paged' => $paged,
                        'post_status' => 'publish',
                        'meta_key' => 'event_day',
                        'orderby' => 'meta_value_num',
                        'order' => 'ASC'
                    ]);

                    if ($events_query->have_posts()):
                        while ($events_query->have_posts()): $events_query->the_post();
                            $event_month = get_field('event_month');
                            $event_day = get_field('event_day');
                            $month = get_field('month');
                            $day = get_field('day');
                            $event_location = get_field('event_location');
                            $event_subtitle = get_field('event_subtitle');
                            $event_description = get_field('event_description');
                            $event_link = get_field('event_link');
                            $event_logo = get_field('event_logo');
                            $event_featured_image = get_field('event_featured_image');
                            ?>
                            <div class="event-item">
                                <!-- Event Date Block -->
                                <div class="event-date-block">
                                    <?php if ($month): ?>
                                        <div class="event-month"><?php echo esc_html($month); ?></div>
                                    <?php endif; ?>
                                    <?php if ($day): ?>
                                        <div class="event-day"><?php echo esc_html($day); ?></div>
                                    <?php endif; ?>
                                </div>

                                <!-- Event Content -->
                                <div class="event-content">
                                    <h2 class="event-title"><?php the_title(); ?></h2>

                                    <!-- Event Logo - перший після заголовка -->
                                    <?php if ($event_logo): ?>
                                        <div class="event-logo-section">
                                            <img src="<?php echo esc_url($event_logo['url']); ?>"
                                                 alt="<?php echo esc_attr($event_logo['alt'] ?: get_the_title()); ?>"
                                                 class="event-logo">
                                        </div>
                                    <?php endif; ?>

                                    <!-- Event Featured Image - після логотипу -->
                                    <?php if ($event_featured_image): ?>
                                        <div class="event-image">
                                            <img src="<?php echo esc_url($event_featured_image['url']); ?>"
                                                 alt="<?php echo esc_attr($event_featured_image['alt'] ?: get_the_title()); ?>">
                                        </div>
                                    <?php endif; ?>

                                    <!-- Event Description -->
                                    <?php if ($event_description): ?>
                                        <div class="event-description">
                                            <?php echo wp_kses_post($event_description); ?>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Read More Button -->
                                    <?php if ($event_link): ?>
                                        <div class="event-read-more-section">
                                            <a href="<?php echo get_permalink(); ?>"
                                               class="register-link" <!-- замінено клас тут -->
                                            >
                                            TO THE EVENT PAGE
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <div class="event-read-more-section">
                                            <a href="<?php echo get_permalink(); ?>" class="register-link">
                                                TO THE EVENT PAGE
                                            </a>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Event Details Table - компактна в один ряд -->
                                    <div class="event-details">
                                        <div class="event-details-row">
                                            <div class="event-detail-item">
                                                <div class="detail-label">WHEN</div>
                                                <div class="detail-value">
                                                    <?php
                                                    $event_year = get_field('event_year') ?: '2025';
                                                    $event_time_start = get_field('event_time_start') ?: '18:00';
                                                    $event_time_end = get_field('event_time_end') ?: '21:00';
                                                    ?>
                                                    <?php if ($event_month && $event_day): ?>
                                                        <?php echo esc_html($event_month . ' ' . $event_day); ?>, <?php echo esc_html($event_year); ?><br>
                                                    <?php endif; ?>
                                                    <?php echo esc_html($event_time_start . ' - ' . $event_time_end); ?>
                                                </div>
                                            </div>
                                            <div class="event-detail-item">
                                                <div class="detail-label">WHERE</div>
                                                <div class="detail-value">
                                                    <?php
                                                    $event_venue_name = get_field('event_venue_name') ?: 'Ravintolasali 8';
                                                    $event_venue_address = get_field('event_venue_address') ?: '00100 HELSINKI';
                                                    ?>
                                                    <?php if ($event_location): ?>
                                                        <?php echo esc_html($event_location); ?><br>
                                                    <?php endif; ?>
                                                    <?php echo esc_html($event_venue_name); ?><br>
                                                    <?php echo esc_html($event_venue_address); ?>
                                                </div>
                                            </div>
                                            <div class="event-detail-item">
                                                <div class="detail-label">ATTENDANCE</div>
                                                <div class="detail-value">
                                                    <?php
                                                    $event_attendance_info = get_field('event_attendance_info') ?: 'The event is free, but seating is limited to 50.';
                                                    $event_registration_link = get_field('event_registration_link');
                                                    ?>
                                                    <?php echo nl2br(esc_html($event_attendance_info)); ?><br>
                                                    <?php if ($event_registration_link): ?>
                                                        <a href="<?php echo esc_url($event_registration_link['url']); ?>"
                                                           class="register-link"
                                                           <?php if ($event_registration_link['target']): ?>target="<?php echo esc_attr($event_registration_link['target']); ?>"<?php endif; ?>>
                                                            <?php echo esc_html($event_registration_link['title'] ?: 'SIGN UP!'); ?>
                                                        </a>
                                                    <?php else: ?>
                                                        <a href="#" class="register-link">SIGN UP!</a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        endwhile;
                    else:
                        ?>
                        <div class="no-events">
                            <p>No events found.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Pagination -->
                <?php if ($events_query->max_num_pages > 1): ?>
                    <div class="events-pagination">
                        <div class="pagination-controls">
                            <?php
                            $pagination_args = array(
                                'total' => $events_query->max_num_pages,
                                'current' => $paged,
                                'prev_text' => '« PREV',
                                'next_text' => 'NEXT »',
                                'type' => 'array',
                                'show_all' => false,
                                'end_size' => 1,
                                'mid_size' => 2,
                            );

                            $pagination_links = paginate_links($pagination_args);

                            if ($pagination_links) {
                                foreach ($pagination_links as $link) {
                                    echo $link;
                                }
                            }
                            ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php wp_reset_postdata(); ?>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
