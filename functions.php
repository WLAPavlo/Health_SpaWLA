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
if (class_exists('theme\CreateLazyImg')) {
    add_action('template_redirect', function () {
        ob_start(function ($html) {
            $lazy = new CreateLazyImg();
            $buffer = $lazy->ignoreScripts($html);
            $buffer = $lazy->ignoreNoscripts($buffer);
            $html = $lazy->lazyloadImages($html, $buffer);
            $html = $lazy->lazyloadPictures($html, $buffer);

            return $lazy->lazyloadBackgroundImages($html, $buffer);
        });
    });
}

/** ========================================================================
 * PUT YOU FUNCTIONS BELOW.
 */

// Auto-populate month and day fields based on date picker
add_action('acf/save_post', function($post_id) {
    // Check if this is a spa_event post
    if (get_post_type($post_id) !== 'spa_event') {
        return;
    }

    // Only auto-populate if month and day fields are empty
    $current_month = get_field('event_month', $post_id);
    $current_day = get_field('event_day', $post_id);

    // If both month and day are manually set, don't override them
    if (!empty($current_month) && !empty($current_day)) {
        return;
    }

    // Get the date picker value only if month/day fields are empty
    $event_date = get_field('event_date', $post_id);

    if ($event_date && (empty($current_month) || empty($current_day))) {
        // Convert date to timestamp
        $timestamp = strtotime($event_date);

        // Only update empty fields
        if (empty($current_month)) {
            $month = strtoupper(date('M', $timestamp));
            update_field('event_month', $month, $post_id);
        }

        if (empty($current_day)) {
            $day = date('j', $timestamp);
            update_field('event_day', $day, $post_id);
        }
    }
}, 20);

// Add JavaScript to admin for real-time date updates
add_action('admin_footer', function() {
    global $post_type;
    if ($post_type === 'spa_event') {
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                // Function to update month and day fields only if they are empty for specific post
                function updateDateFields(postId) {
                    var dateSelector = postId ? 'input[data-name="event_date"][data-post-id="' + postId + '"]' : 'input[data-name="event_date"]';
                    var monthSelector = postId ? 'input[data-name="event_month"][data-post-id="' + postId + '"]' : 'input[data-name="event_month"]';
                    var daySelector = postId ? 'input[data-name="event_day"][data-post-id="' + postId + '"]' : 'input[data-name="event_day"]';

                    var dateValue = $(dateSelector).val();
                    var monthField = $(monthSelector);
                    var dayField = $(daySelector);

                    // Only update if fields are empty
                    if (dateValue && (!monthField.val() || !dayField.val())) {
                        // Handle different date formats
                        var date;
                        if (dateValue.includes('/')) {
                            // Format: dd/mm/yyyy
                            var parts = dateValue.split('/');
                            date = new Date(parts[2], parts[1] - 1, parts[0]);
                        } else if (dateValue.includes('-')) {
                            // Format: yyyy-mm-dd
                            date = new Date(dateValue);
                        } else {
                            date = new Date(dateValue);
                        }

                        var months = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN',
                            'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
                        var month = months[date.getMonth()];
                        var day = date.getDate();

                        // Only update if field is empty
                        if (!monthField.val()) {
                            monthField.val(month);
                        }
                        if (!dayField.val()) {
                            dayField.val(day);
                        }
                    }
                }

                // Add button to sync date fields manually for each event
                function addSyncButton() {
                    $('input[data-name="event_date"]').each(function() {
                        var $this = $(this);
                        var dateField = $this.closest('.acf-field');
                        var postId = $this.closest('form').find('input[name="post_ID"]').val() || 'new';

                        if (dateField.length && !dateField.find('.sync-date-btn').length) {
                            var syncBtn = $('<button type="button" class="button sync-date-btn" style="margin-top: 5px;" data-post-id="' + postId + '">Sync Month & Day from Date</button>');
                            dateField.append(syncBtn);

                            syncBtn.on('click', function(e) {
                                e.preventDefault();
                                var currentPostId = $(this).data('post-id');
                                var dateSelector = 'input[data-name="event_date"]';
                                var monthSelector = 'input[data-name="event_month"]';
                                var daySelector = 'input[data-name="event_day"]';

                                // If we have multiple events on page, target specific ones
                                if ($('input[data-name="event_date"]').length > 1) {
                                    dateSelector = 'input[data-name="event_date"]';
                                    monthSelector = 'input[data-name="event_month"]';
                                    daySelector = 'input[data-name="event_day"]';

                                    // Find the closest form container
                                    var formContainer = $(this).closest('.acf-fields, form, .post-body');
                                    dateSelector = formContainer.find('input[data-name="event_date"]');
                                    monthSelector = formContainer.find('input[data-name="event_month"]');
                                    daySelector = formContainer.find('input[data-name="event_day"]');
                                } else {
                                    dateSelector = $(dateSelector);
                                    monthSelector = $(monthSelector);
                                    daySelector = $(daySelector);
                                }

                                var dateValue = dateSelector.val();
                                if (dateValue) {
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

                                    monthSelector.val(month);
                                    daySelector.val(day);

                                    alert('Month and Day fields updated for this event!');
                                }
                            });
                        }
                    });
                }

                // Update on date change only if fields are empty - handle each event separately
                $(document).on('change', 'input[data-name="event_date"]', function() {
                    var $this = $(this);
                    var formContainer = $this.closest('.acf-fields, form, .post-body');
                    var monthField = formContainer.find('input[data-name="event_month"]');
                    var dayField = formContainer.find('input[data-name="event_day"]');

                    // Only update if fields are empty
                    if ($this.val() && (!monthField.val() || !dayField.val())) {
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

                        // Only update if field is empty
                        if (!monthField.val()) {
                            monthField.val(month);
                        }
                        if (!dayField.val()) {
                            dayField.val(day);
                        }
                    }
                });

                // Add sync button on page load
                setTimeout(function() {
                    addSyncButton();
                }, 1000);

                // Re-add sync buttons when new fields are added (for repeater fields or AJAX)
                $(document).on('acf/setup_fields', function() {
                    setTimeout(function() {
                        addSyncButton();
                    }, 500);
                });
            });
        </script>
        <?php
    }
});

// Custom media library's image sizes
add_image_size('full_hd', 1920, 0, ['center', 'center']);
add_image_size('large_high', 1024, 0, false);
// add_image_size( 'name', width, height, ['center','center']);

// Disable gutenberg
add_filter('use_block_editor_for_post_type', '__return_false');
