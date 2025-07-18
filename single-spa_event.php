<?php
/**
 * Single SPA Event Template - Fixed Structure According to Design
 */

// Disable debug output
if (!is_admin()) {
    error_reporting(0);
    ini_set('display_errors', 0);
}

get_header(); ?>

    <main class="main-content single-event-page">
        <?php if (have_posts()): ?>
            <?php while (have_posts()): the_post(); ?>

                <!-- Event Layout Container -->
                <div class="event-layout-container">

                    <!-- Main Content Area -->
                    <div class="event-main-content">

                        <!-- Event Title -->
                        <h1 class="event-main-title"><?php the_title(); ?></h1>

                        <!-- Event Featured Image with Date and Social -->
                        <?php
                        $featured_image = get_field('featured_image');
                        $start_date = get_field('start_date');
                        $end_date = get_field('end_date');

                        // Extract start date components for blue date block
                        if ($start_date) {
                            $start_timestamp = strtotime($start_date);
                            $event_month = strtoupper(date('M', $start_timestamp));
                            $event_day = date('j', $start_timestamp);
                            $event_year = date('Y', $start_timestamp);
                        } else {
                            $event_month = '';
                            $event_day = '';
                            $event_year = '';
                        }
                        ?>

                        <!-- Image and Date Container -->
                        <div class="event-image-date-container">
                            <?php if ($featured_image): ?>
                                <div class="event-main-image">
                                    <img src="<?php echo esc_url($featured_image['url']); ?>"
                                         alt="<?php echo esc_attr($featured_image['alt'] ?: get_the_title()); ?>">
                                </div>
                            <?php elseif (has_post_thumbnail()): ?>
                                <div class="event-main-image">
                                    <?php the_post_thumbnail('large'); ?>
                                </div>
                            <?php endif; ?>

                            <div class="event-date-right">
                                <?php if ($event_month): ?>
                                    <div class="date-month"><?php echo esc_html($event_month); ?></div>
                                <?php endif; ?>
                                <?php if ($event_day): ?>
                                    <div class="date-day"><?php echo esc_html($event_day); ?></div>
                                <?php endif; ?>
                                <?php if ($event_year): ?>
                                    <div class="date-year"><?php echo esc_html($event_year); ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- Social Icons - Right Side of Image -->
                            <div class="event-social-right-horizontal">
                                <?php if (get_field('social_facebook')): ?>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>"
                                       target="_blank" class="social-circle social-facebook">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                <?php endif; ?>

                                <?php if (get_field('social_twitter')): ?>
                                    <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>"
                                       target="_blank" class="social-circle social-twitter">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                <?php endif; ?>

                                <?php if (get_field('social_linkedin')): ?>
                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(get_permalink()); ?>"
                                       target="_blank" class="social-circle social-linkedin">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Event Description -->
                        <?php
                        $event_description = get_field('event_description_wysiwyg');
                        if ($event_description): ?>
                            <div class="event-main-description">
                                <?php echo wp_kses_post($event_description); ?>
                            </div>
                        <?php elseif (get_the_content()): ?>
                            <div class="event-main-description">
                                <?php the_content(); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Quote Section -->
                        <?php
                        $quote_text = get_field('event_quote_text');
                        $quote_bg_color = get_field('quote_background_color') ?: '#00bcd4';
                        if ($quote_text): ?>
                            <div class="event-quote-highlight">
                                <?php echo nl2br(esc_html($quote_text)); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Additional Text -->
                        <?php
                        $additional_text = get_field('event_additional_text');
                        if ($additional_text): ?>
                            <div class="event-additional-text">
                                <?php echo wp_kses_post($additional_text); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Event Map -->
                        <?php if ($event_map = get_field('event_location_map')): ?>
                            <div class="event-map-container">
                                <div class="event-map-display">
                                    <div class="marker" data-lat="<?php echo $event_map['lat']; ?>" data-lng="<?php echo $event_map['lng']; ?>"
                                         data-marker-icon="<?php echo get_template_directory_uri(); ?>/assets/images/event.png">
                                        <div class="map-marker">
                                            <div class="marker-label"><?= __('Event', 'fwp'); ?></div>
                                            <div class="marker-address"><?php echo esc_html($event_map['address']); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Event Details Grid -->
                        <div class="event-details-grid">
                            <!-- WHEN -->
                            <div class="detail-column">
                                <h3 class="detail-heading"><?= __('When', 'fwp'); ?></h3>
                                <div class="detail-info">
                                    <?php
                                    $start_date_field = get_field('start_date');
                                    $end_date_field = get_field('end_date');
                                    ?>
                                    <div class="detail-value">
                                        <?php if ($start_date_field): ?>
                                            <?php
                                            $start_timestamp = strtotime($start_date_field);
                                            $end_timestamp = strtotime($end_date_field);

                                            $start_formatted = date('F j, Y', $start_timestamp);
                                            $start_time = date('H:i', $start_timestamp);

                                            echo esc_html($start_formatted);
                                            echo " " . esc_html($start_time);

                                            if ($end_date_field && $end_date_field !== $start_date_field) {
                                                $end_formatted = date('F j, Y', $end_timestamp);
                                                $end_time = date('H:i', $end_timestamp);

                                                if (date('Y-m-d', $start_timestamp) === date('Y-m-d', $end_timestamp)) {
                                                    echo ' – ' . esc_html($end_time);
                                                } else {
                                                    echo ' – ' . esc_html($end_formatted) . ' ' . esc_html($end_time);
                                                }
                                            }
                                            ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- WHERE -->
                            <div class="detail-column">
                                <h3 class="detail-heading">WHERE</h3>
                                <div class="detail-info">
                                    <?php
                                    $venue_name = get_field('where_venue_name');
                                    $address_line1 = get_field('where_address_line1');
                                    $address_line2 = get_field('where_address_line2');
                                    ?>
                                    <?php if ($venue_name): ?>
                                        <div><?php echo esc_html($venue_name); ?></div>
                                    <?php else: ?>
                                        <div>Biomedicum Helsinki 1</div>
                                    <?php endif; ?>
                                    <?php if ($address_line1): ?>
                                        <div><?php echo esc_html($address_line1); ?></div>
                                    <?php else: ?>
                                        <div>Haartmaninkatu 8</div>
                                    <?php endif; ?>
                                    <?php if ($address_line2): ?>
                                        <div><?php echo esc_html($address_line2); ?></div>
                                    <?php else: ?>
                                        <div>00290 Helsinki</div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- ATTENDANCE -->
                            <div class="detail-column">
                                <h3 class="detail-heading">ATTENDANCE</h3>
                                <div class="detail-info">
                                    <?php
                                    $attendance_text = get_field('attendance_text');
                                    ?>
                                    <?php if ($attendance_text): ?>
                                        <div class="attendance-text"><?php echo nl2br(esc_html($attendance_text)); ?></div>
                                    <?php else: ?>
                                        <div class="attendance-text">The event is free, but seating is limited to 50.</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Sign Up Button -->
                        <?php $signup_button = get_field('signup_button_link'); ?>
                        <?php if ($signup_button): ?>
                            <div class="signup-button-container">
                                <a href="<?php echo esc_url($signup_button['url']); ?>"
                                   class="signup-button"
                                   <?php if ($signup_button['target']): ?>target="<?php echo esc_attr($signup_button['target']); ?>"<?php endif; ?>>
                                    <?php echo esc_html($signup_button['title'] ?: 'SIGN UP'); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <!-- Supporters Title Section - After Sign Up Button -->
                        <?php
                        $supporter_logos = get_field('supporter_logos_repeater');
                        $supporters_title = get_field('supporters_title');
                        if ($supporter_logos): ?>
                            <div class="supporters-title-section">
                                <h3 class="supporters-heading-main">
                                    <?php echo esc_html($supporters_title ?: 'THE EVENT IS SUPPORTED BY'); ?>
                                </h3>
                            </div>
                        <?php endif; ?>

                    </div>

                    <!-- Event Supporters - Full Width Outside Content -->
                    <?php if ($supporter_logos): ?>
                        <div class="event-supporters-full-width">
                            <div class="supporters-container">
                                <div class="supporters-logos">
                                    <?php foreach ($supporter_logos as $supporter): ?>
                                        <div class="supporter-logo">
                                            <?php if ($supporter['url']): ?>
                                            <a href="<?php echo esc_url($supporter['url']); ?>"
                                               target="_blank"
                                               rel="noopener noreferrer">
                                                <?php endif; ?>

                                                <img src="<?php echo esc_url($supporter['logo']['url']); ?>"
                                                     alt="<?php echo esc_attr($supporter['name']); ?>">

                                                <?php if ($supporter['url']): ?>
                                            </a>
                                        <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>

            <?php endwhile; ?>
        <?php else: ?>
            <div class="no-event-found">
                <h2>Event not found</h2>
                <p>Sorry, the requested event does not exist.</p>
                <a href="<?php echo home_url(); ?>" class="btn-back-home">Return to home page</a>
            </div>
        <?php endif; ?>
    </main>

<?php get_footer(); ?>
