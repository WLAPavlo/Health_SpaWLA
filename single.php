<?php
/**
 * Single Post Template
 *
 * Enhanced single post layout with modern styling and better UX
 */
get_header(); ?>

    <main class="main-content single-post">
        <div class="grid-container">
            <div class="grid-x grid-margin-x">

                <!-- BEGIN of post content -->
                <div class="large-8 medium-8 small-12 cell">
                    <?php if (have_posts()) { ?>
                        <?php while (have_posts()) {
                            the_post(); ?>

                            <article id="post-<?php the_ID(); ?>" <?php post_class('post-article'); ?>>

                                <!-- Post Header -->
                                <header class="post-header">
                                    <h1 class="post-title"><?php the_title(); ?></h1>

                                    <div class="post-meta">
                                        <div class="meta-item meta-author">
                                            <span class="meta-icon">👤</span>
                                            <?php echo get_the_author_posts_link(); ?>
                                        </div>
                                        <div class="meta-item meta-date">
                                            <span class="meta-icon">📅</span>
                                            <time datetime="<?php echo get_the_date('c'); ?>">
                                                <?php echo get_the_date(); ?>
                                            </time>
                                        </div>
                                        <div class="meta-item meta-reading-time">
                                            <span class="meta-icon">⏱️</span>
                                            <?php echo ceil(str_word_count(get_the_content()) / 200); ?> min of reading
                                        </div>
                                    </div>

                                    <?php if (has_post_thumbnail()) { ?>
                                        <div class="post-thumbnail">
                                            <?php the_post_thumbnail('large', array('loading' => 'lazy')); ?>
                                        </div>
                                    <?php } ?>
                                </header>

                                <!-- Post Content -->
                                <div class="post-content">
                                    <?php the_content('', true); ?>
                                </div>

                                <!-- Post Footer -->
                                <footer class="post-footer">
                                    <?php if (has_category()) { ?>
                                        <div class="post-categories">
                                            <span class="categories-label">Categories:</span>
                                            <?php the_category(', '); ?>
                                        </div>
                                    <?php } ?>

                                    <?php if (has_tag()) { ?>
                                        <div class="post-tags">
                                            <span class="tags-label">Tags:</span>
                                            <?php the_tags('', ', ', ''); ?>
                                        </div>
                                    <?php } ?>

                                    <!-- Post Navigation -->
                                    <nav class="post-navigation">
                                        <div class="nav-previous">
                                            <?php previous_post_link('%link', '<span class="nav-label">← Previous post</span><span class="nav-title">%title</span>'); ?>
                                        </div>
                                        <div class="nav-next">
                                            <?php next_post_link('%link', '<span class="nav-label">Next post →</span><span class="nav-title">%title</span>'); ?>
                                        </div>
                                    </nav>
                                </footer>

                                <!-- Comments Section -->
                                <?php if (comments_open() || get_comments_number()) { ?>
                                    <div class="comments-section">
                                        <?php comments_template(); ?>
                                    </div>
                                <?php } ?>

                            </article>

                        <?php } ?>
                    <?php } else { ?>
                        <div class="no-posts">
                            <h2>Post not found</h2>
                            <p>Sorry, the requested post does not exist..</p>
                            <a href="<?php echo home_url(); ?>" class="btn btn-primary">Return to home page</a>
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
