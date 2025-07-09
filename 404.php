<?php
/**
 * 404 Error Page Template - SPA Style
 */
get_header(); ?>

    <main class="main-content single-post-page">
        <div class="grid-container">
            <div class="grid-x grid-margin-x">
                <div class="cell">
                    <div class="single-post-article">
                        <!-- 404 Header -->
                        <header class="single-post-header">
                            <div class="single-post-meta">
                                <div class="meta-line">
                                    <span class="meta-category">ERROR</span>
                                    <span class="meta-separator">|</span>
                                    <span class="meta-date"><?php echo date('M j'); ?></span>
                                </div>
                                <div class="reading-time">
                                    Page not found
                                </div>
                            </div>

                            <h1 class="single-post-title">404: Page Not Found</h1>

                            <!-- 404 Illustration -->
                            <div class="single-post-thumbnail">
                                <div style="background: linear-gradient(135deg, #1e88e5 0%, #0d47a1 100%);
                                        height: 300px;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        border-radius: 12px;
                                        color: white;
                                        font-size: 4rem;
                                        font-weight: 700;">
                                    404
                                </div>
                            </div>
                        </header>

                        <!-- 404 Content -->
                        <div class="single-post-content">
                            <h2>Oops! Something went wrong</h2>

                            <p>The page you're looking for doesn't exist or has been moved. This could happen for several reasons:</p>

                            <ul>
                                <li>The URL was typed incorrectly</li>
                                <li>The page has been moved or deleted</li>
                                <li>The link you followed is outdated</li>
                                <li>You don't have permission to access this page</li>
                            </ul>

                            <h3>What can you do?</h3>

                            <p>Don't worry! Here are some helpful options to get you back on track:</p>

                            <!-- Search Form -->
                            <div style="background: #f8f9fa; padding: 2rem; border-radius: 8px; margin: 2rem 0;">
                                <h4 style="margin-top: 0; color: #1e88e5;">Search our site:</h4>
                                <?php get_search_form(); ?>
                            </div>

                            <!-- Quick Links -->
                            <h4>Quick Links:</h4>
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin: 1.5rem 0;">
                                <a href="<?php echo home_url(); ?>"
                                   style="display: block; padding: 1rem; background: #1e88e5; color: white; text-decoration: none; border-radius: 8px; text-align: center; font-weight: 600; transition: all 0.3s ease;">
                                    🏠 Home Page
                                </a>

                                <?php if (get_page_by_path('events')): ?>
                                    <a href="<?php echo get_permalink(get_page_by_path('events')); ?>"
                                       style="display: block; padding: 1rem; background: #00bcd4; color: white; text-decoration: none; border-radius: 8px; text-align: center; font-weight: 600; transition: all 0.3s ease;">
                                        📅 Events
                                    </a>
                                <?php endif; ?>

                                <?php if (get_page_by_path('stories')): ?>
                                    <a href="<?php echo get_permalink(get_page_by_path('stories')); ?>"
                                       style="display: block; padding: 1rem; background: #e91e63; color: white; text-decoration: none; border-radius: 8px; text-align: center; font-weight: 600; transition: all 0.3s ease;">
                                        📖 Stories
                                    </a>
                                <?php endif; ?>

                                <?php if (get_page_by_path('contact')): ?>
                                    <a href="<?php echo get_permalink(get_page_by_path('contact')); ?>"
                                       style="display: block; padding: 1rem; background: #ff9800; color: white; text-decoration: none; border-radius: 8px; text-align: center; font-weight: 600; transition: all 0.3s ease;">
                                        📞 Contact
                                    </a>
                                <?php endif; ?>
                            </div>

                            <!-- Recent Posts -->
                            <?php
                            $recent_posts = get_posts(array(
                                'numberposts' => 3,
                                'post_status' => 'publish'
                            ));

                            if ($recent_posts): ?>
                                <h4>Recent Stories:</h4>
                                <div style="display: grid; gap: 1rem; margin: 1.5rem 0;">
                                    <?php foreach ($recent_posts as $post): setup_postdata($post); ?>
                                        <a href="<?php the_permalink(); ?>"
                                           style="display: flex; gap: 1rem; padding: 1rem; background: #ffffff; border: 1px solid #e9ecef; border-radius: 8px; text-decoration: none; color: inherit; transition: all 0.3s ease;">
                                            <?php if (has_post_thumbnail()): ?>
                                                <div style="flex-shrink: 0; width: 80px; height: 80px; border-radius: 8px; overflow: hidden;">
                                                    <?php the_post_thumbnail('thumbnail', array('style' => 'width: 100%; height: 100%; object-fit: cover;')); ?>
                                                </div>
                                            <?php endif; ?>
                                            <div>
                                                <h5 style="margin: 0 0 0.5rem 0; color: #1e88e5; font-size: 1rem;"><?php the_title(); ?></h5>
                                                <p style="margin: 0; font-size: 0.875rem; color: #666; line-height: 1.4;">
                                                    <?php echo wp_trim_words(get_the_excerpt(), 15); ?>
                                                </p>
                                            </div>
                                        </a>
                                    <?php endforeach; wp_reset_postdata(); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- 404 Footer -->
                        <footer class="single-post-footer">
                            <div style="text-align: center; padding: 2rem; background: #f8f9fa; border-radius: 8px;">
                                <h4 style="color: #1e88e5; margin-bottom: 1rem;">Still need help?</h4>
                                <p style="margin-bottom: 1.5rem;">If you believe this is an error or need assistance, please don't hesitate to contact us.</p>

                                <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                                    <a href="<?php echo home_url(); ?>"
                                       class="btn-primary"
                                       style="display: inline-block; background: #1e88e5; color: white; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.3s ease;">
                                        ← Back to Home
                                    </a>

                                    <?php if (get_page_by_path('contact')): ?>
                                        <a href="<?php echo get_permalink(get_page_by_path('contact')); ?>"
                                           class="btn-secondary"
                                           style="display: inline-block; background: transparent; color: #1e88e5; padding: 0.75rem 1.5rem; border: 2px solid #1e88e5; border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.3s ease;">
                                            Contact Support
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </footer>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <style>
        /* Hover effects for 404 page links */
        .main-content a[style*="background: #1e88e5"]:hover {
            background: #0d47a1 !important;
            transform: translateY(-2px);
        }

        .main-content a[style*="background: #00bcd4"]:hover {
            background: #00acc1 !important;
            transform: translateY(-2px);
        }

        .main-content a[style*="background: #e91e63"]:hover {
            background: #c2185b !important;
            transform: translateY(-2px);
        }

        .main-content a[style*="background: #ff9800"]:hover {
            background: #f57c00 !important;
            transform: translateY(-2px);
        }

        .main-content a[style*="border: 1px solid #e9ecef"]:hover {
            border-color: #1e88e5 !important;
            transform: translateY(-2px);
            box-shadow: 0 3px 6px rgba(30, 136, 229, 0.1);
        }

        .btn-secondary:hover {
            background: #1e88e5 !important;
            color: white !important;
        }
    </style>

<?php get_footer(); ?>
