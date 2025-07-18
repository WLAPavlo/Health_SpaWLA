<?php

use theme\CreateLazyImg;
use theme\DynamicAdmin;
use theme\WlAcfGfField;

/**
 * Functions.
 */

// Declaring the assets manifest
$manifest_json = get_theme_file_path() . '/dist/assets.json';
$assets = [
    'manifest' => file_exists($manifest_json) ? json_decode(file_get_contents($manifest_json), true) : [],
    'dist' => get_theme_file_uri() . '/dist',
    'dist_path' => get_theme_file_path() . '/dist',
];
unset($manifest_json);

/**
 * Retrieve the path to the asset, use hashed version if exists.
 *
 * @param mixed $asset
 * @param bool|string $path (optional) Defines if returned result is a path or a url (without leading slash if using path)
 *
 * @return string
 */
function asset_path($asset, $path = false)
{
    global $assets;
    $asset = isset($assets['manifest'][$asset]) ? $assets['manifest'][$asset] : $asset;

    return "{$assets[$path ? 'dist_path' : 'dist']}/{$asset}";
}

/** ========================================================================
 * Constants.
 */
define('IMAGE_PLACEHOLDER', asset_path('images/placeholder.jpg'));

/** ========================================================================
 * Included Functions.
 */
spl_autoload_register(function ($class_name) {
    if (0 === strpos($class_name, 'theme\\')) {
        $class_name = str_replace('theme\\', '', $class_name);
        $file = get_stylesheet_directory() . "/inc/classes/{$class_name}.php";

        if (!file_exists($file)) {
            echo sprintf(__('Error locating <code>%s</code> for inclusion.', 'fwp'), $file);
        } else {
            require_once $file;
        }
    }
});

array_map(function ($filename) {
    $file = get_stylesheet_directory() . "/inc/{$filename}.php";
    if (!file_exists($file)) {
        echo sprintf(__('Error locating <code>%s</code> for inclusion.', 'fwp'), $file);
    } else {
        include_once $file;
    }
}, [
    'helpers',
    'recommended-plugins',
    'theme-customizations',
    'home-slider',
    'svg-support',
    'gravity-form-customizations',
    'custom-fields-search',
    'google-maps',
    'tiny-mce-customizations',
    'posttypes',
    'rest',
    'spa-events-cpt', // Додано новий файл для SPA Events CPT
    //    'gutenberg-support', // !!!IMPORTANT Comment the "Disable gutenberg" filter to enable Gutenberg
    //    'woo-customizations',
    //    'divi-support',
    //    'elementor-support',
    //    'shortcodes',
    'acf-placeholder',
    'twitter-integration', // Twitter integration
]);

// Register ACF Gravity Forms field
if (class_exists('WlAcfGfField')) {
    // initialize
    new WlAcfGfField();
}

/** ========================================================================
 * Enqueue Scripts and Styles for Front-End.
 */
add_action('init', function () {
    wp_register_script('runtime.js', asset_path('scripts/runtime.js'), [], null, true);
    wp_register_script('ext.js', asset_path('scripts/ext.js'), [], null, true);
    if (file_exists(asset_path('styles/ext.css', true))) {
        wp_register_style('ext.css', asset_path('styles/ext.css'), [], null);
    }
});

add_action('wp_enqueue_scripts', function () {
    if (!is_admin()) {
        // Disable gutenberg built-in styles
        // wp_dequeue_style('wp-block-library');

        wp_enqueue_script('jquery');

        wp_enqueue_style('ext.css');
        wp_enqueue_style('main.css', asset_path('styles/main.css'), [], null);
        wp_enqueue_script(
            'main.js',
            asset_path('scripts/main.js'),
            ['jquery', 'runtime.js', 'ext.js'],
            null,
            true
        );

        wp_localize_script(
            'main.js',
            'ajax_object',
            [
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('project_nonce'),
            ]
        );
    }
});

/** ========================================================================
 * Additional Functions.
 */

// Dynamic Admin
if (class_exists('theme\DynamicAdmin') && is_admin()) {
    $dynamic_admin = new DynamicAdmin();
    //    $dynamic_admin->addField('page', 'template', __('Page Template', 'fwp'), 'template_detail_field_for_page');
    $dynamic_admin->run();
}

// Apply lazyload to whole page content
// Auto-populate month and day fields from event_date
add_action('acf/save_post', function($post_id) {
    // Check if this is a spa_event post type
    if (get_post_type($post_id) !== 'spa_event') {
        return;
    }

    // Auto-populate legacy fields from start_date for backward compatibility
    $start_date = get_field('start_date', $post_id);

    if ($start_date) {
        $timestamp = strtotime($start_date);

        // Update legacy fields for backward compatibility
        $month = strtoupper(date('M', $timestamp));
        $day = date('j', $timestamp);
        $year = date('Y', $timestamp);

        update_field('event_month', $month, $post_id);
        update_field('event_day', $day, $post_id);
        update_field('event_year', $year, $post_id);
    }
}, 20);

// Add JavaScript to admin for real-time date updates
add_action('admin_footer', function() {
    global $post_type;
    if ($post_type === 'spa_event') {
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                // Update legacy fields when start_date changes
                $(document).on('change', 'input[data-name="start_date"]', function() {
                    var $this = $(this);
                    var formContainer = $this.closest('.acf-fields, form, .post-body');
                    var monthField = formContainer.find('input[data-name="event_month"]');
                    var dayField = formContainer.find('input[data-name="event_day"]');
                    var yearField = formContainer.find('input[data-name="event_year"]');
                    var eventDateField = formContainer.find('input[data-name="event_date"]');

                    if ($this.val()) {
                        var dateValue = $this.val();
                        var date;
                        if (dateValue.includes('/')) {
                            var parts = dateValue.split('/');
                            date = new Date(parts[2], parts[1] - 1, parts[0]);
                        } else if (dateValue.includes('-')) {
                            date = new Date(dateValue);
                        } else {
                            date = new Date(dateValue);
                        }

                        var months = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN',
                            'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
                        var month = months[date.getMonth()];
                        var day = date.getDate();
                        var year = date.getFullYear();

                        // Update legacy fields for backward compatibility
                        monthField.val(month);
                        dayField.val(day);
                        yearField.val(year);
                        eventDateField.val(dateValue);
                    }
                });

                // Also update when end_date changes (for validation purposes)
                $(document).on('change', 'input[data-name="end_date"]', function() {
                    // You can add validation here to ensure end_date is after start_date
                    var $this = $(this);
                    var formContainer = $this.closest('.acf-fields, form, .post-body');
                    var startDateField = formContainer.find('input[data-name="start_date"]');

                    if ($this.val() && startDateField.val()) {
                        var startDate = new Date(startDateField.val());
                        var endDate = new Date($this.val());

                        if (endDate < startDate) {
                            alert('End date cannot be before start date!');
                            $this.val('');
                        }
                    }
                });
            });
        </script>
        <?php
    }
});

// Disable gutenberg
add_filter('use_block_editor_for_post_type', '__return_false');

// Disable debug output on frontend
if (!is_admin()) {
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    error_reporting(0);
}

// Hide PHP errors, warnings and notices
add_action('init', function() {
    if (!is_admin() && !WP_DEBUG) {
        ini_set('display_errors', 0);
        error_reporting(0);
    }
});

/// Ensure Events page uses archive-spa_event.php
add_filter('page_template', function($template) {
    global $post;

    if ($post && $post->post_name === 'events') {
        $new_template = locate_template(array('archive-spa_event.php'));
        if (!empty($new_template)) {
            return $new_template;
        }
    }

    return $template;
});




