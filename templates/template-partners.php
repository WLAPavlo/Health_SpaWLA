<?php
/**
 * Template Name: Partners Page
 */
get_header(); ?>

    <main class="main-content partners-page">
        <div class="grid-container">
            <div class="grid-x grid-margin-x">
                <div class="cell">
                    <!-- Page Title -->
                    <div class="partners-page-header">
                        <h1 class="partners-page-title">Our Partners</h1>
                        <div class="partners-page-subtitle">
                            <p>Building the future of health tech together with industry leaders</p>
                        </div>
                    </div>

                    <!-- Partners Info Stripe -->
                    <div class="partners-info-stripe">
                        <p class="stripe-text">HEALTH TECH INNOVATION PARTNERS</p>
                    </div>

                    <!-- Main Partners Section -->
                    <div class="partners-main-section">
                        <h2 class="section-title">Main Partners</h2>
                        <div class="main-partners-grid">
                            <?php
                            // Get main partners from ACF repeater
                            $main_partners = get_field('main_partners');

                            if ($main_partners):
                                foreach ($main_partners as $partner):
                                    ?>
                                    <div class="main-partner-item">
                                        <?php if ($partner['partner_logo']): ?>
                                            <div class="partner-logo">
                                                <?php if ($partner['partner_url']): ?>
                                                <a href="<?php echo esc_url($partner['partner_url']); ?>"
                                                   target="_blank"
                                                   rel="noopener noreferrer"
                                                   title="<?php echo esc_attr($partner['partner_name']); ?>">
                                                    <?php endif; ?>

                                                    <img src="<?php echo esc_url($partner['partner_logo']['url']); ?>"
                                                         alt="<?php echo esc_attr($partner['partner_name']); ?>"
                                                         loading="lazy">

                                                    <?php if ($partner['partner_url']): ?>
                                                </a>
                                            <?php endif; ?>
                                            </div>
                                        <?php endif; ?>

                                        <div class="partner-content">
                                            <h3 class="partner-name"><?php echo esc_html($partner['partner_name']); ?></h3>

                                            <?php if ($partner['partner_category']): ?>
                                                <div class="partner-category"><?php echo esc_html($partner['partner_category']); ?></div>
                                            <?php endif; ?>

                                            <?php if ($partner['partner_description']): ?>
                                                <div class="partner-description">
                                                    <?php echo wp_kses_post($partner['partner_description']); ?>
                                                </div>
                                            <?php endif; ?>

                                            <?php if ($partner['partner_services']): ?>
                                                <div class="partner-services">
                                                    <h4>Services:</h4>
                                                    <ul>
                                                        <?php foreach ($partner['partner_services'] as $service): ?>
                                                            <li><?php echo esc_html($service['service']); ?></li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </div>
                                            <?php endif; ?>

                                            <?php if ($partner['partner_url']): ?>
                                                <div class="partner-action">
                                                    <a href="<?php echo esc_url($partner['partner_url']); ?>"
                                                       target="_blank"
                                                       rel="noopener noreferrer"
                                                       class="partner-btn">
                                                        Visit Website
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php
                                endforeach;
                            else:
                                // Default main partners if no ACF data
                                $default_main_partners = [
                                    [
                                        'name' => 'HealthTech Ventures',
                                        'category' => 'Investment Partner',
                                        'description' => 'Leading venture capital firm specializing in health technology investments and startup acceleration.',
                                        'services' => ['Funding', 'Mentorship', 'Strategic Guidance', 'Market Access']
                                    ],
                                    [
                                        'name' => 'MedDevice Solutions',
                                        'category' => 'Technology Partner',
                                        'description' => 'Innovative medical device manufacturer providing cutting-edge solutions for healthcare providers.',
                                        'services' => ['Device Development', 'Regulatory Support', 'Manufacturing', 'Distribution']
                                    ],
                                    [
                                        'name' => 'Digital Health Platform',
                                        'category' => 'Platform Partner',
                                        'description' => 'Comprehensive digital health platform enabling seamless integration of health tech solutions.',
                                        'services' => ['Platform Integration', 'API Access', 'Data Analytics', 'Cloud Infrastructure']
                                    ],
                                    [
                                        'name' => 'Healthcare Innovation Lab',
                                        'category' => 'Research Partner',
                                        'description' => 'Research institution focused on advancing healthcare through technology and innovation.',
                                        'services' => ['Research Collaboration', 'Clinical Trials', 'Innovation Support', 'Academic Partnership']
                                    ]
                                ];

                                foreach ($default_main_partners as $partner):
                                    ?>
                                    <div class="main-partner-item">
                                        <div class="partner-logo">
                                            <div class="partner-placeholder">
                                                <i class="fas fa-building"></i>
                                            </div>
                                        </div>

                                        <div class="partner-content">
                                            <h3 class="partner-name"><?php echo esc_html($partner['name']); ?></h3>
                                            <div class="partner-category"><?php echo esc_html($partner['category']); ?></div>
                                            <div class="partner-description">
                                                <p><?php echo esc_html($partner['description']); ?></p>
                                            </div>
                                            <div class="partner-services">
                                                <h4>Services:</h4>
                                                <ul>
                                                    <?php foreach ($partner['services'] as $service): ?>
                                                        <li><?php echo esc_html($service); ?></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                            <div class="partner-action">
                                                <a href="#" class="partner-btn">Visit Website</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                endforeach;
                            endif;
                            ?>
                        </div>
                    </div>

                    <!-- Supporting Partners Section -->
                    <div class="partners-supporting-section">
                        <h2 class="section-title">Supporting Partners</h2>
                        <div class="supporting-partners-grid">
                            <?php
                            // Get supporting partners from ACF repeater
                            $supporting_partners = get_field('supporting_partners');

                            if ($supporting_partners):
                                foreach ($supporting_partners as $partner):
                                    ?>
                                    <div class="supporting-partner-item">
                                        <?php if ($partner['partner_logo']): ?>
                                            <?php if ($partner['partner_url']): ?>
                                                <a href="<?php echo esc_url($partner['partner_url']); ?>"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                title="<?php echo esc_attr($partner['partner_name']); ?>">
                                            <?php endif; ?>

                                            <img src="<?php echo esc_url($partner['partner_logo']['url']); ?>"
                                                 alt="<?php echo esc_attr($partner['partner_name']); ?>"
                                                 loading="lazy">

                                            <?php if ($partner['partner_url']): ?>
                                                </a>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <div class="partner-placeholder-small">
                                                <span><?php echo esc_html(substr($partner['partner_name'], 0, 2)); ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php
                                endforeach;
                            else:
                                // Default supporting partners
                                $default_supporting_partners = [
                                    'TechStart Incubator', 'Innovation Hub', 'HealthCare Connect', 'MedTech Alliance',
                                    'Digital Wellness', 'BioTech Partners', 'Smart Health', 'Future Medicine',
                                    'Health Innovation', 'MedDevice Network', 'Wellness Tech', 'Care Solutions'
                                ];

                                foreach ($default_supporting_partners as $partner_name):
                                    ?>
                                    <div class="supporting-partner-item">
                                        <div class="partner-placeholder-small">
                                            <span><?php echo esc_html(substr($partner_name, 0, 2)); ?></span>
                                        </div>
                                    </div>
                                <?php
                                endforeach;
                            endif;
                            ?>
                        </div>
                    </div>

                    <!-- Partnership CTA -->
                    <div class="partners-cta-section">
                        <div class="partners-cta-content">
                            <h2>Become Our Partner</h2>
                            <p>Join our ecosystem and help shape the future of health technology innovation</p>
                            <div class="partners-cta-buttons">
                                <a href="#" class="btn-primary">Partnership Inquiry</a>
                                <a href="#" class="btn-secondary">Download Partnership Guide</a>
                            </div>
                        </div>
                    </div>

                    <!-- Page Content -->
                    <?php if (have_posts()) { ?>
                        <?php while (have_posts()) {
                            the_post(); ?>
                            <div class="partners-page-content">
                                <?php the_content(); ?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </main>

<?php get_footer(); ?>
