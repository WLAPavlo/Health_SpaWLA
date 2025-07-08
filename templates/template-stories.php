<?php
/**
 * Template Name: Stories Page
 */
get_header(); ?>

    <main class="main-content stories-page">
        <div class="grid-container">
            <div class="grid-x grid-margin-x">
                <div class="cell">
                    <!-- Page Title -->
                    <div class="stories-page-header">
                        <h1 class="stories-page-title">Stories</h1>
                    </div>

                    <!-- Stories List -->
                    <div class="stories-list">
                        <!-- Stories Info Stripe -->
                        <div class="stories-info-stripe">
                            <p class="stripe-text">HEALTH TECH INNOVATION STORIES</p>
                        </div>

                        <?php
                        // Pagination setup
                        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

                        // Get Stories with pagination
                        $stories_query = new WP_Query([
                            'post_type' => 'post',
                            'posts_per_page' => 6,
                            'paged' => $paged,
                            'post_status' => 'publish',
                            'orderby' => 'date',
                            'order' => 'DESC'
                        ]);

                        if ($stories_query->have_posts()):
                            ?>
                            <div class="stories-grid">
                                <?php while ($stories_query->have_posts()): $stories_query->the_post(); ?>
                                    <div class="story-item">
                                        <?php if (has_post_thumbnail()): ?>
                                            <div class="story-image">
                                                <a href="<?php the_permalink(); ?>">
                                                    <?php the_post_thumbnail('medium_large', array('loading' => 'lazy')); ?>
                                                </a>
                                            </div>
                                        <?php endif; ?>

                                        <div class="story-content">
                                            <div class="story-meta">
                                                <?php
                                                $story_date = get_field('story_date');
                                                $story_category = get_field('story_category');
                                                $story_author = get_field('story_author');

                                                // Якщо немає кастомної дати, використовуємо дату публікації
                                                if (!$story_date) {
                                                    $story_date = get_the_date('M j');
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
                                                        $story_category = 'NEWS';
                                                    }
                                                }
                                                ?>

                                                <div class="story-meta-line">
                                                    <?php if ($story_date): ?>
                                                        <span class="story-date"><?php echo esc_html($story_date); ?></span>
                                                    <?php endif; ?>

                                                    <?php if ($story_category): ?>
                                                        <?php if ($story_date): ?>
                                                            <span class="story-separator">|</span>
                                                        <?php endif; ?>
                                                        <span class="story-category"><?php echo esc_html($story_category); ?></span>
                                                    <?php endif; ?>
                                                </div>

                                                <div class="story-author"><?php echo esc_html($story_author); ?></div>
                                            </div>

                                            <h2 class="story-title">
                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            </h2>

                                            <div class="story-excerpt">
                                                <?php
                                                $story_excerpt = get_field('story_excerpt');
                                                if ($story_excerpt) {
                                                    echo wp_kses_post($story_excerpt);
                                                } else {
                                                    // Обрізаємо excerpt до 150 символів
                                                    $excerpt = get_the_excerpt();
                                                    if (strlen($excerpt) > 150) {
                                                        $excerpt = substr($excerpt, 0, 150) . '...';
                                                    }
                                                    echo $excerpt;
                                                }
                                                ?>
                                            </div>

                                            <div class="story-read-more">
                                                <a href="<?php the_permalink(); ?>" class="story-read-more-btn">
                                                    READ MORE
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php
                        else:
                            ?>
                            <div class="no-stories">
                                <p>No stories found.</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Pagination -->
                    <?php if ($stories_query->max_num_pages > 1): ?>
                        <div class="stories-pagination">
                            <div class="pagination-controls">
                                <?php
                                $pagination_args = array(
                                    'total' => $stories_query->max_num_pages,
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
