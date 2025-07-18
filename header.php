<?php
/**
 * Header.
 */

use theme\FoundationNavigation;

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <!-- Set up Meta -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta charset="<?php bloginfo('charset'); ?>">

    <!-- Set the viewport width to device width for mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, user-scalable=yes">
    <!-- Remove Microsoft Edge's & Safari phone-email styling -->
    <meta name="format-detection" content="telephone=no,email=no,url=no">

    <?php wp_head(); ?>
</head>

<body <?php body_class('no-outline fwp'); ?>>
<?php wp_body_open(); ?>

<?php
// Hide debug output on frontend
if (!is_admin() && !current_user_can('administrator')) {
    error_reporting(0);
    ini_set('display_errors', 0);
}
?>

<!-- BEGIN of header -->
<header class="header">
    <div class="menu-grid-container">
        <div class="grid-x">
            <!-- Header Content Container - Logo + Menu centered together -->
            <div class="header-content">
                <!-- Logo -->
                <div class="logo">
                    <h1>
                        <?php show_custom_logo(); ?><span class="show-for-sr"><?php echo get_bloginfo('name'); ?></span>
                    </h1>
                </div>

                <!-- Navigation Menu -->
                <?php if (has_nav_menu('header-menu')) { ?>
                    <!-- Кастомний мобільний бургер -->
                    <button class="mobile-menu-toggle hide-for-medium" type="button" aria-label="Menu" aria-controls="main-menu">
                        <span></span>
                    </button>

                    <!-- Desktop/Mobile Navigation -->
                    <nav class="top-bar" id="main-menu">
                        <div class="menu-container">
                            <?php wp_nav_menu([
                                'theme_location' => 'header-menu',
                                'menu_class' => 'menu header-menu',
                                'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                                'walker' => new FoundationNavigation(),
                            ]); ?>
                        </div>
                    </nav>
                <?php } ?>
            </div>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const blockedLinks = ['/stories', '/offer', '/people', '/partners', '/contact'];

        document.querySelectorAll('.header-menu a').forEach(function (link) {
            const href = link.getAttribute('href');
            if (href && blockedLinks.some(path => href.includes(path))) {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                });
                link.setAttribute('href', '#');
            }
        });
    });
</script>

<!-- END of header -->
