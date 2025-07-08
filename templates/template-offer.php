<?php
/**
 * Template Name: Offer Page
 */
get_header(); ?>

    <main class="main-content offer-page">
        <div class="grid-container">
            <div class="grid-x grid-margin-x">
                <div class="cell">
                    <!-- Page Title -->
                    <div class="offer-page-header">
                        <h1 class="offer-page-title">Our Offer</h1>
                        <div class="offer-page-subtitle">
                            <p>Comprehensive health tech solutions for startups and enterprises</p>
                        </div>
                    </div>

                    <!-- Offer Info Stripe -->
                    <div class="offer-info-stripe">
                        <p class="stripe-text">HEALTH TECH INNOVATION SOLUTIONS</p>
                    </div>

                    <!-- Offer Services Grid -->
                    <div class="offer-services">
                        <?php
                        // Get offer services from ACF repeater
                        $offer_services = get_field('offer_services');

                        if ($offer_services):
                            foreach ($offer_services as $service):
                                ?>
                                <div class="offer-service-item">
                                    <?php if ($service['service_icon']): ?>
                                        <div class="service-icon">
                                            <img src="<?php echo esc_url($service['service_icon']['url']); ?>"
                                                 alt="<?php echo esc_attr($service['service_title']); ?>">
                                        </div>
                                    <?php endif; ?>

                                    <div class="service-content">
                                        <h3 class="service-title"><?php echo esc_html($service['service_title']); ?></h3>

                                        <?php if ($service['service_description']): ?>
                                            <div class="service-description">
                                                <?php echo wp_kses_post($service['service_description']); ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($service['service_features']): ?>
                                            <ul class="service-features">
                                                <?php foreach ($service['service_features'] as $feature): ?>
                                                    <li><?php echo esc_html($feature['feature']); ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>

                                        <?php if ($service['service_link']): ?>
                                            <div class="service-action">
                                                <a href="<?php echo esc_url($service['service_link']['url']); ?>"
                                                   class="service-btn"
                                                   <?php if ($service['service_link']['target']): ?>target="<?php echo esc_attr($service['service_link']['target']); ?>"<?php endif; ?>>
                                                    <?php echo esc_html($service['service_link']['title'] ?: 'Learn More'); ?>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php
                            endforeach;
                        else:
                            // Default services if no ACF data
                            $default_services = [
                                [
                                    'title' => 'Startup Acceleration',
                                    'description' => 'Comprehensive support for health tech startups from ideation to market launch.',
                                    'features' => ['Mentorship Programs', 'Funding Guidance', 'Market Research', 'Product Development']
                                ],
                                [
                                    'title' => 'Technology Consulting',
                                    'description' => 'Expert guidance on health tech implementation and digital transformation.',
                                    'features' => ['Technical Architecture', 'Platform Selection', 'Integration Support', 'Security Compliance']
                                ],
                                [
                                    'title' => 'Innovation Workshops',
                                    'description' => 'Interactive sessions to foster innovation and collaboration in health tech.',
                                    'features' => ['Design Thinking', 'Prototyping', 'User Research', 'Market Validation']
                                ],
                                [
                                    'title' => 'Partnership Network',
                                    'description' => 'Connect with industry leaders, investors, and potential collaborators.',
                                    'features' => ['Investor Matching', 'Strategic Partnerships', 'Industry Connections', 'Global Network']
                                ],
                                [
                                    'title' => 'Digital Health Solutions',
                                    'description' => 'Cutting-edge solutions for modern healthcare challenges.',
                                    'features' => ['mHealth Apps', 'Wearable Integration', 'Data Analytics', 'AI Solutions']
                                ],
                                [
                                    'title' => 'Regulatory Support',
                                    'description' => 'Navigate complex healthcare regulations and compliance requirements.',
                                    'features' => ['GDPR Compliance', 'Medical Device Regulations', 'Data Privacy', 'Quality Assurance']
                                ]
                            ];

                            foreach ($default_services as $service):
                                ?>
                                <div class="offer-service-item">
                                    <div class="service-content">
                                        <h3 class="service-title"><?php echo esc_html($service['title']); ?></h3>
                                        <div class="service-description">
                                            <p><?php echo esc_html($service['description']); ?></p>
                                        </div>
                                        <ul class="service-features">
                                            <?php foreach ($service['features'] as $feature): ?>
                                                <li><?php echo esc_html($feature); ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                        <div class="service-action">
                                            <a href="#" class="service-btn">Learn More</a>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            endforeach;
                        endif;
                        ?>
                    </div>

                    <!-- CTA Section -->
                    <div class="offer-cta-section">
                        <div class="offer-cta-content">
                            <h2>Ready to Transform Healthcare?</h2>
                            <p>Join our ecosystem and be part of the health tech revolution</p>
                            <div class="offer-cta-buttons">
                                <a href="#" class="btn-primary">Get Started</a>
                                <a href="#" class="btn-secondary">Contact Us</a>
                            </div>
                        </div>
                    </div>

                    <!-- Page Content -->
                    <?php if (have_posts()) { ?>
                        <?php while (have_posts()) {
                            the_post(); ?>
                            <div class="offer-page-content">
                                <?php the_content(); ?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </main>

<?php get_footer(); ?>
