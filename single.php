<?php
/**
 * Single Post Template
 *
 * Single post layout in SPA style with modern design
 */
get_header(); ?>

    <main class="main-content single-post-page">
        <div class="grid-container">
            <div class="grid-x grid-margin-x">

                <!-- BEGIN of post content -->
                <div class="large-8 medium-8 small-12 cell">
                    <?php if (have_posts()) { ?>
                        <?php while (have_posts()) {
                            the_post(); ?>

                            <article id="post-<?php the_ID(); ?>" <?php post_class('single-post-article'); ?>>

                                <!-- Post Header -->
                                <header class="single-post-header">
                                    <!-- Post Meta -->
                                    <div class="single-post-meta">
                                        <?php
                                        $story_date = get_field('story_date');
                                        $story_category = get_field('story_category');
                                        $story_author = get_field('story_author');

                                        // Fallbacks
                                        if (!$story_date) {
                                            $story_date = get_the_date('M j, Y');
                                        }
                                        if (!$story_author) {
                                            $story_author = get_the_author();
                                        }
                                        if (!$story_category) {
                                            $categories = get_the_category();
                                            if (!empty($categories)) {
                                                $story_category = strtoupper($categories[0]->name);
                                            } else {
                                                $story_category = 'NEWS';
                                            }
                                        }
                                        ?>

                                        <div class="meta-line">
                                            <?php if ($story_date): ?>
                                                <span class="meta-date"><?php echo esc_html($story_date); ?></span>
                                            <?php endif; ?>

                                            <?php if ($story_category): ?>
                                                <?php if ($story_date): ?>
                                                    <span class="meta-separator">|</span>
                                                <?php endif; ?>
                                                <span class="meta-category"><?php echo esc_html($story_category); ?></span>
                                            <?php endif; ?>

                                            <?php if ($story_author): ?>
                                                <span class="meta-separator">|</span>
                                                <span class="meta-author"><?php echo esc_html($story_author); ?></span>
                                            <?php endif; ?>
                                        </div>

                                        <div class="reading-time">
                                            <?php echo ceil(str_word_count(get_the_content()) / 200); ?> min read
                                        </div>
                                    </div>

                                    <h1 class="single-post-title"><?php the_title(); ?></h1>

                                    <?php if (has_post_thumbnail()) { ?>
                                        <div class="single-post-thumbnail">
                                            <?php the_post_thumbnail('large', array('loading' => 'lazy')); ?>
                                        </div>
                                    <?php } ?>
                                </header>

                                <!-- Post Content -->
                                <div class="single-post-content">
                                    <?php the_content('', true); ?>
                                </div>

                                <!-- Post Footer -->
                                <footer class="single-post-footer">
                                    <?php if (has_category()) { ?>
                                        <div class="post-categories">
                                            <span class="categories-label">Categories:</span>
                                            <div class="categories-list">
                                                <?php
                                                $categories = get_the_category();
                                                foreach ($categories as $category) {
                                                    echo '<a href="' . get_category_link($category->term_id) . '" class="category-tag">' . $category->name . '</a>';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <?php if (has_tag()) { ?>
                                        <div class="post-tags">
                                            <span class="tags-label">Tags:</span>
                                            <div class="tags-list">
                                                <?php
                                                $tags = get_the_tags();
                                                if ($tags) {
                                                    foreach ($tags as $tag) {
                                                        echo '<a href="' . get_tag_link($tag->term_id) . '" class="tag-item">' . $tag->name . '</a>';
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <!-- Post Navigation -->
                                    <nav class="single-post-navigation">
                                        <div class="nav-previous">
                                            <?php
                                            $prev_post = get_previous_post();
                                            if ($prev_post) : ?>
                                                <a href="<?php echo get_permalink($prev_post->ID); ?>" class="nav-link">
                                                    <span class="nav-direction">← Previous</span>
                                                    <span class="nav-title"><?php echo get_the_title($prev_post->ID); ?></span>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                        <div class="nav-next">
                                            <?php
                                            $next_post = get_next_post();
                                            if ($next_post) : ?>
                                                <a href="<?php echo get_permalink($next_post->ID); ?>" class="nav-link">
                                                    <span class="nav-direction">Next →</span>
                                                    <span class="nav-title"><?php echo get_the_title($next_post->ID); ?></span>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </nav>
                                </footer>

                                <!-- Comments Section -->
                                <?php if (comments_open() || get_comments_number()) { ?>
                                    <div class="single-post-comments">
                                        <?php comments_template(); ?>
                                    </div>
                                <?php } ?>

                            </article>

                        <?php } ?>
                    <?php } else { ?>
                        <div class="no-post-found">
                            <h2>Post not found</h2>
                            <p>Sorry, the requested post does not exist.</p>
                            <a href="<?php echo home_url(); ?>" class="btn-back-home">Return to home page</a>
                        </div>
                    <?php } ?>
                </div>
                <!-- END of post content -->

                <!-- BEGIN of sidebar -->
                <div class="large-4 medium-4 small-12 cell sidebar-wrapper">
                    <aside class="sidebar">
                        <?php get_sidebar('right'); ?>
                    </aside>
                </div>
                <!-- END of sidebar -->

            </div>
        </div>
    </main>

<?php get_footer(); ?>
