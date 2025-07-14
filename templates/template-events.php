<?php
/**
 * Template Name: Events Page
 */
get_header(); ?>

<main class="main-content events-page">
    <div class="grid-container">
        <div class="grid-x grid-margin-x">
            <div class="cell">
                <!-- Page Title - Centered -->
                <div class="events-page-header">
                    <h1 class="events-page-title">Upcoming events</h1>
                </div>

                <!-- Single Featured Events Stripe - Outside of posts loop -->
                <div class="featured-events-stripe">
                    <div class="stripe-content">
                        FEATURED EVENTS - FEATURED EVENTS - FEATURED EVENTS - FEATURED EVENTS
                    </div>
                </div>

                <!-- Events List -->
                <div class="events-list">
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
                            $two_month = get_field('two_month');
                            $two_day = get_field('two_day');
                            $event_location = get_field('event_location');
                            $event_subtitle = get_field('event_subtitle');
                            $event_description = get_field('event_description_wysiwyg');
                            $event_link = get_field('event_link');
                            $event_logo = get_field('event_logo');
                            $post_featured_image = get_field('post_featured_image');
                            ?>

                            <div class="event-item">
                                <div class="event-item-wrapper">
                                    <!-- Event Date Block - Left side, outside content -->
                                    <div class="event-date-block">
                                        <?php if ($two_month): ?>
                                            <div class="event-month"><?php echo esc_html($two_month); ?></div>
                                        <?php endif; ?>
                                        <?php if ($two_day): ?>
                                            <div class="event-day"><?php echo esc_html($two_day); ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Event Content -->
                                    <div class="event-content">
                                        <h2 class="event-title"><?php the_title(); ?></h2>

                                        <!-- Event Featured Image -->
                                        <?php if ($post_featured_image): ?>
                                            <div class="event-image">
                                                <img src="<?php echo esc_url($post_featured_image['url']); ?>"
                                                     alt="<?php echo esc_attr($post_featured_image['alt'] ?: get_the_title()); ?>">
                                            </div>
                                        <?php elseif (has_post_thumbnail()): ?>
                                            <div class="event-image">
                                                <?php the_post_thumbnail('large'); ?>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Event Description -->
                                        <?php if ($event_description): ?>
                                            <div class="event-description">
                                                <?php echo wp_kses_post($event_description); ?>
                                            </div>
                                        <?php elseif (get_the_content()): ?>
                                            <div class="event-description">
                                                <?php the_content(); ?>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Read More Button -->
                                        <div class="event-read-more-section">
                                            <a href="<?php echo get_permalink(); ?>" class="event-read-more-btn">
                                                TO THE EVENT PAGE
                                            </a>
                                        </div>

                                        <!-- Event Details Table - 3 columns -->
                                        <div class="event-details">
                                            <div class="event-details-row">
                                                <div class="event-detail-item">
                                                    <div class="detail-label">WHEN</div>
                                                    <div class="detail-value">
                                                        <?php
                                                        $event_year = get_field('event_year') ?: '2025';
                                                        $event_time_start = get_field('event_time_start') ?: '16:30';
                                                        $event_time_end = get_field('event_time_end') ?: '21:00';
                                                        $when_full_date = get_field('when_full_date');
                                                        $when_time_range = get_field('when_time_range');
                                                        ?>
                                                        <?php if ($when_full_date): ?>
                                                            <?php echo esc_html($when_full_date); ?><br>
                                                        <?php elseif ($event_month && $event_day): ?>
                                                            <?php echo esc_html($event_month . ' ' . $event_day); ?>, <?php echo esc_html($event_year); ?><br>
                                                        <?php endif; ?>
                                                        <?php if ($when_time_range): ?>
                                                            <?php echo esc_html($when_time_range); ?>
                                                        <?php else: ?>
                                                            <?php echo esc_html($event_time_start . ' - ' . $event_time_end); ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="event-detail-item">
                                                    <div class="detail-label">WHERE</div>
                                                    <div class="detail-value">
                                                        <?php
                                                        $event_venue_name = get_field('event_venue_name') ?: get_field('where_venue_name') ?: 'Biomedicum Helsinki 1';
                                                        $event_venue_address = get_field('event_venue_address');
                                                        $where_address_line1 = get_field('where_address_line1');
                                                        $where_address_line2 = get_field('where_address_line2');
                                                        ?>
                                                        <?php echo esc_html($event_venue_name); ?><br>
                                                        <?php if ($event_venue_address): ?>
                                                            <?php echo esc_html($event_venue_address); ?>
                                                        <?php elseif ($where_address_line1): ?>
                                                            <?php echo esc_html($where_address_line1); ?><br>
                                                            <?php if ($where_address_line2): ?>
                                                                <?php echo esc_html($where_address_line2); ?>
                                                            <?php endif; ?>
                                                        <?php else: ?>
                                                            Haartmaninkatu 8<br>00290 Helsinki
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="event-detail-item">
                                                    <div class="detail-label">ATTENDANCE</div>
                                                    <div class="detail-value">
                                                        <?php
                                                        $event_attendance_info = get_field('event_attendance_info') ?: get_field('attendance_text') ?: 'The event is free, but seating is limited to 50.';
                                                        $event_registration_link = get_field('event_registration_link') ?: get_field('signup_button_link');
                                                        ?>
                                                        <?php echo nl2br(esc_html($event_attendance_info)); ?><br>

                                                        <?php
                                                        if ($event_registration_link):
                                                            $button_title = $event_registration_link['title'] ?: 'BOOK TICKETS';

                                                            $button_class = (strtolower(trim($button_title)) === 'sold out') ? 'btn-sold-out' : 'btn-available';
                                                            ?>
                                                            <a href="<?php echo esc_url($event_registration_link['url']); ?>"
                                                               class="book-tickets-btn <?php echo esc_attr($button_class); ?>"
                                                               <?php if ($event_registration_link['target']): ?>target="<?php echo esc_attr($event_registration_link['target']); ?>"<?php endif; ?>>
                                                                <?php echo esc_html($button_title); ?>
                                                            </a>
                                                        <?php else: ?>
                                                            <a href="#" class="book-tickets-btn btn-available">BOOK TICKETS</a>
                                                        <?php endif; ?>
                                                    </div>
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
