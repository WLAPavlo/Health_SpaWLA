<?php
/**
 * Footer.
 */

// Get footer settings from ACF
$get_in_touch = get_field('footer_get_in_touch', 'options');
$connect_with_us = get_field('footer_connect_with_us', 'options');
$main_partners = get_field('footer_main_partners', 'options');
$layout_settings = get_field('footer_layout_settings', 'options');

// Default values if ACF fields are empty
$get_in_touch = $get_in_touch ?: [
    'title' => 'Get in touch',
    'background_color' => '#e91e63',
    'text_color' => '#ffffff'
];

$connect_with_us = $connect_with_us ?: [
    'title' => 'Connect with us',
    'background_color' => '#1e88e5',
    'text_color' => '#ffffff',
    'social_links' => []
];

$main_partners = $main_partners ?: [
    'title' => 'Main partners',
    'background_color' => '#ffffff',
    'text_color' => '#1e88e5',
    'border_color' => '#1e88e5',
    'partner_logos' => []
];

$layout_settings = $layout_settings ?: [
    'padding_top' => 40,
    'padding_bottom' => 40,
    'gap_between_sections' => 20,
    'border_radius' => 12
];
?>

<!-- BEGIN of footer -->
<footer class="footer spa-footer" style="padding-top: <?php echo esc_attr($layout_settings['padding_top']); ?>px; padding-bottom: <?php echo esc_attr($layout_settings['padding_bottom']); ?>px;">
    <div class="grid-container">
        <div class="grid-x grid-margin-x align-center" style="gap: <?php echo esc_attr($layout_settings['gap_between_sections']); ?>px;">

            <!-- Get in Touch Section -->
            <div class="cell small-12 medium-4 large-auto">
                <div class="footer-section get-in-touch"
                     style="background-color: <?php echo esc_attr($get_in_touch['background_color']); ?>;
                         color: <?php echo esc_attr($get_in_touch['text_color']); ?>;
                         border-radius: <?php echo esc_attr($layout_settings['border_radius']); ?>px;">
                    <h3 class="footer-section-title"><?php echo esc_html($get_in_touch['title']); ?></h3>
                </div>
            </div>

            <!-- Connect With Us Section -->
            <div class="cell small-12 medium-4 large-auto">
                <div class="footer-section connect-with-us"
                     style="background-color: <?php echo esc_attr($connect_with_us['background_color']); ?>;
                         color: <?php echo esc_attr($connect_with_us['text_color']); ?>;
                         border-radius: <?php echo esc_attr($layout_settings['border_radius']); ?>px;">
                    <h3 class="footer-section-title"><?php echo esc_html($connect_with_us['title']); ?></h3>

                    <?php if (!empty($connect_with_us['social_links'])): ?>
                        <div class="social-links">
                            <?php foreach ($connect_with_us['social_links'] as $social): ?>
                                <a href="<?php echo esc_url($social['url']); ?>"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="social-link"
                                   style="color: <?php echo esc_attr($social['color'] ?: $connect_with_us['text_color']); ?>;">
                                    <i class="<?php echo esc_attr($social['icon']); ?>"></i>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Main Partners Section -->
            <div class="cell small-12 medium-4 large-auto">
                <div class="footer-section main-partners"
                     style="background-color: <?php echo esc_attr($main_partners['background_color']); ?>;
                         color: <?php echo esc_attr($main_partners['text_color']); ?>;
                         border: 2px solid <?php echo esc_attr($main_partners['border_color']); ?>;
                         border-radius: <?php echo esc_attr($layout_settings['border_radius']); ?>px;">
                    <h3 class="footer-section-title"><?php echo esc_html($main_partners['title']); ?></h3>

                    <?php if (!empty($main_partners['partner_logos'])): ?>
                        <div class="partner-logos">
                            <?php foreach ($main_partners['partner_logos'] as $partner): ?>
                                <div class="partner-logo">
                                    <?php if (!empty($partner['url'])): ?>
                                    <a href="<?php echo esc_url($partner['url']); ?>"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       title="<?php echo esc_attr($partner['name']); ?>">
                                        <?php endif; ?>

                                        <img src="<?php echo esc_url($partner['logo']['url']); ?>"
                                             alt="<?php echo esc_attr($partner['name']); ?>"
                                             loading="lazy">

                                        <?php if (!empty($partner['url'])): ?>
                                    </a>
                                <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Copyright Section -->
    <?php if ($copyright = get_field('copyright', 'options')) { ?>
        <div class="footer__copy">
            <div class="grid-container">
                <div class="grid-x grid-margin-x">
                    <div class="cell">
                        <?php echo $copyright; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</footer>
<!-- END of footer -->

<?php wp_footer(); ?>
</body>
</html>
