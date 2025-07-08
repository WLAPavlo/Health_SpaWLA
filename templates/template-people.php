<?php
/**
 * Template Name: People Page
 */
get_header(); ?>

    <main class="main-content people-page">
        <div class="grid-container">
            <div class="grid-x grid-margin-x">
                <div class="cell">
                    <!-- Page Title -->
                    <div class="people-page-header">
                        <h1 class="people-page-title">Our People</h1>
                        <div class="people-page-subtitle">
                            <p>Meet the experts driving health tech innovation</p>
                        </div>
                    </div>

                    <!-- People Info Stripe -->
                    <div class="people-info-stripe">
                        <p class="stripe-text">HEALTH TECH INNOVATION EXPERTS</p>
                    </div>

                    <!-- People Grid -->
                    <div class="people-grid">
                        <?php
                        // Get team members from ACF repeater
                        $team_members = get_field('team_members');

                        if ($team_members):
                            foreach ($team_members as $member):
                                ?>
                                <div class="people-member-item">
                                    <?php if ($member['member_photo']): ?>
                                        <div class="member-photo">
                                            <img src="<?php echo esc_url($member['member_photo']['url']); ?>"
                                                 alt="<?php echo esc_attr($member['member_name']); ?>"
                                                 loading="lazy">
                                        </div>
                                    <?php endif; ?>

                                    <div class="member-content">
                                        <h3 class="member-name"><?php echo esc_html($member['member_name']); ?></h3>

                                        <?php if ($member['member_position']): ?>
                                            <div class="member-position"><?php echo esc_html($member['member_position']); ?></div>
                                        <?php endif; ?>

                                        <?php if ($member['member_bio']): ?>
                                            <div class="member-bio">
                                                <?php echo wp_kses_post($member['member_bio']); ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($member['member_expertise']): ?>
                                            <div class="member-expertise">
                                                <h4>Expertise:</h4>
                                                <ul>
                                                    <?php foreach ($member['member_expertise'] as $expertise): ?>
                                                        <li><?php echo esc_html($expertise['skill']); ?></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($member['member_social']): ?>
                                            <div class="member-social">
                                                <?php foreach ($member['member_social'] as $social): ?>
                                                    <a href="<?php echo esc_url($social['social_url']); ?>"
                                                       target="_blank"
                                                       rel="noopener noreferrer"
                                                       class="social-link">
                                                        <i class="<?php echo esc_attr($social['social_icon']); ?>"></i>
                                                    </a>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php
                            endforeach;
                        else:
                            // Default team members if no ACF data
                            $default_members = [
                                [
                                    'name' => 'Dr. Sarah Johnson',
                                    'position' => 'Chief Innovation Officer',
                                    'bio' => 'Leading health tech innovation with over 15 years of experience in digital health solutions and startup acceleration.',
                                    'expertise' => ['Digital Health', 'AI in Healthcare', 'Startup Mentoring', 'Product Strategy']
                                ],
                                [
                                    'name' => 'Michael Chen',
                                    'position' => 'Technology Director',
                                    'bio' => 'Expert in health tech architecture and implementation, specializing in scalable healthcare platforms.',
                                    'expertise' => ['Software Architecture', 'Cloud Solutions', 'Data Security', 'System Integration']
                                ],
                                [
                                    'name' => 'Dr. Emma Rodriguez',
                                    'position' => 'Medical Advisor',
                                    'bio' => 'Practicing physician and health tech consultant, bridging the gap between medical needs and technology solutions.',
                                    'expertise' => ['Clinical Workflow', 'Medical Devices', 'Healthcare Standards', 'User Experience']
                                ],
                                [
                                    'name' => 'Alex Thompson',
                                    'position' => 'Business Development Lead',
                                    'bio' => 'Connecting startups with investors and strategic partners in the health tech ecosystem.',
                                    'expertise' => ['Partnership Development', 'Investment Strategy', 'Market Analysis', 'Business Growth']
                                ],
                                [
                                    'name' => 'Dr. Lisa Wang',
                                    'position' => 'Research Director',
                                    'bio' => 'Leading research initiatives in emerging health technologies and their practical applications.',
                                    'expertise' => ['Health Research', 'Data Analytics', 'Machine Learning', 'Clinical Trials']
                                ],
                                [
                                    'name' => 'James Miller',
                                    'position' => 'Operations Manager',
                                    'bio' => 'Ensuring smooth operations and efficient processes across all health tech initiatives.',
                                    'expertise' => ['Project Management', 'Process Optimization', 'Quality Assurance', 'Team Leadership']
                                ]
                            ];

                            foreach ($default_members as $member):
                                ?>
                                <div class="people-member-item">
                                    <div class="member-photo">
                                        <div class="member-placeholder">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    </div>

                                    <div class="member-content">
                                        <h3 class="member-name"><?php echo esc_html($member['name']); ?></h3>
                                        <div class="member-position"><?php echo esc_html($member['position']); ?></div>
                                        <div class="member-bio">
                                            <p><?php echo esc_html($member['bio']); ?></p>
                                        </div>
                                        <div class="member-expertise">
                                            <h4>Expertise:</h4>
                                            <ul>
                                                <?php foreach ($member['expertise'] as $skill): ?>
                                                    <li><?php echo esc_html($skill); ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                        <div class="member-social">
                                            <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                                            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            endforeach;
                        endif;
                        ?>
                    </div>

                    <!-- Join Team CTA -->
                    <div class="people-cta-section">
                        <div class="people-cta-content">
                            <h2>Join Our Team</h2>
                            <p>Be part of the health tech revolution and help shape the future of healthcare</p>
                            <div class="people-cta-buttons">
                                <a href="#" class="btn-primary">View Openings</a>
                                <a href="#" class="btn-secondary">Contact HR</a>
                            </div>
                        </div>
                    </div>

                    <!-- Page Content -->
                    <?php if (have_posts()) { ?>
                        <?php while (have_posts()) {
                            the_post(); ?>
                            <div class="people-page-content">
                                <?php the_content(); ?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </main>

<?php get_footer(); ?>
