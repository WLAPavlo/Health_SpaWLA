<?php

namespace theme;

/**
 * Class DynamicAdmin.
 *
 * Create custom columns and filters on Posts list page in admin
 */
class DynamicAdmin
{
    public $list_field = [];

    public $acf_list_field = [];
    private $featured_image_key;

    private $filter_fn = [];

    public function __construct($featured_key = 'da_featured_image')
    {
        $this->featured_image_key = $featured_key;
    }

    /**
     * Shown featured image for post.
     *
     * @param string $column_name
     * @param int $post_id
     */
    public function daThumbnailImage($column_name, $post_id): void
    {
        if ($column_name == $this->featured_image_key) {
            $img = get_attached_img_url($post_id);
            echo '<img src="' . $img . '" style="width: 50px; height: auto">';
        }
    }

    /**
     * Adds column with custom value.
     *
     * @param string $post_type Post type name
     * @param string $field_key Column id
     * @param string $field_name Column name
     * @param string $callback Function name that fills column with necessary data
     * @param string $after Column id after which create custom column
     */
    public function addField($post_type, $field_key, $field_name, $callback, $after = 'title'): void
    {
        $this->list_field[] = [
            'post_type' => $post_type,
            'key' => $field_key,
            'field' => $field_name,
            'after' => $after,
            'callback' => $callback,
        ];
    }

    /**
     * @param string $post_type
     * @param string $field_name
     * @param mixed $post_type
     */
    public function addFeaturedImage($post_type, $field_name = 'Featured Image'): void
    {
        $this->addField($post_type, $this->featured_image_key, $field_name, [$this, 'daThumbnailImage']);
    }

    /**
     * Adds column with basic ACF field.
     *
     * @param string $post_type Post type name
     * @param string $field_key Column id
     * @param string $field_name Column name
     * @param string $after
     * @param bool $sortable
     */
    public function addACFField($post_type, $field_key, $field_name, $after = 'title', $sortable = false): void
    {
        $this->acf_list_field[] = [
            'post_type' => $post_type,
            'key' => $field_key,
            'field' => $field_name,
            'after' => $after,
            'sortable' => $sortable,
        ];
    }

    /**
     * Adds custom filter for posts.
     *
     * @param string $post_type Post type name
     * @param string $meta_key Filter id
     * @param string $label Filter placeholder/name
     * @param array $value_list List of filter values
     * @param callable $args Query args to filter posts
     * @param bool|callable $custom_filter Custom complicated filter function
     */
    public function addFilter($post_type, $meta_key, $label, $value_list, $args, $custom_filter = false): void
    {
        $args_arr = compact('post_type', 'meta_key', 'label', 'value_list', 'args', 'custom_filter');
        $this->filter_fn[] = $args_arr;
    }

    public function run()
    {
        $this->buildColumns();

        $this->buildFilters();

        $this->buildACFColumns();
    }

    /**
     * Build custom columns.
     */
    private function buildColumns()
    {
        // Proceed build custom column
        if ($this->list_field) {
            foreach ($this->list_field as $field) {
                // Add new column
                $manage_edit_callback = function ($columns) use ($field) {
                    $res = [];
                    foreach ($columns as $key => $col) {
                        $res[$key] = $col;
                        if ($key == $field['after']) {
                            $res[$field['key']] = $field['field'];
                        }
                    }

                    return $res;
                };
                add_filter('manage_edit-' . $field['post_type'] . '_columns', $manage_edit_callback, 30);

                // Fill new column
                add_filter('manage_' . $field['post_type'] . '_posts_custom_column', $field['callback'], 5, 2);
            }
        }
    }

    /**
     * Build custom filters.
     */
    private function buildFilters()
    {
        // Proceed build filter dropdown and filter posts
        if ($this->filter_fn) {
            foreach ($this->filter_fn as $filter) {
                $create_filter_callback = function () use ($filter) {
                    // Get necessary post_type, works for 'post' post type
                    $type = $filter['post_type'];

                    // Redefine $type with actual viewed post type page
                    if (isset($_GET['post_type'])) {
                        $type = $_GET['post_type'];
                    }

                    if ($type == $filter['post_type']) {
                        // If filter is active get its value
                        $current_v = isset($_GET[$filter['meta_key']]) ? $_GET[$filter['meta_key']] : '';

                        // Build select output
                        $filter_output = '';
                        $filter_output .= "<select name='{$filter['meta_key']}' id='filter-by-{$filter['meta_key']}'>";
                        $filter_output .= "<option value=''>{$filter['label']}</option>";

                        foreach ($filter['value_list'] as $key => $value) {
                            $selected = strval($key) === $current_v ? 'selected="selected"' : '';
                            $filter_output .= "<option value='{$key}' {$selected}>{$value}</option>";
                        }

                        $filter_output .= '</select>';

                        echo $filter_output;
                    }
                };
                add_action('restrict_manage_posts', $create_filter_callback);

                $parse_query_callback = function ($query) use ($filter) {
                    global $pagenow;

                    if (isset($_GET['post_type']) && 'edit.php' == $pagenow) {
                        $type = $_GET['post_type'];
                        if ($filter['post_type'] == $type
                            && is_admin()
                            && isset($_GET[$filter['meta_key']])
                            && '' != $_GET[$filter['meta_key']]) {
                            // Get active filter value
                            $filter_value = $_GET[$filter['meta_key']];

                            // Modify query with active filter value using passed args array
                            $query->query_vars = array_merge($query->query_vars, $filter['args']($filter_value));
                        }
                    }
                };

                // Redefine filter function with custom if specified
                $parse_query_callback = $filter['custom_filter'] ? $filter['custom_filter'] : $parse_query_callback;

                add_filter('parse_query', $parse_query_callback);
            }
        }
    }

    private function buildACFColumns()
    {
        // Proceed build basic ACF column
        if ($this->acf_list_field) {
            foreach ($this->acf_list_field as $field) {
                // Add new column
                $manage_edit_callback = function ($columns) use ($field) {
                    $res = [];
                    foreach ($columns as $key => $col) {
                        $res[$key] = $col;
                        if ($key == $field['after']) {
                            $res[$field['key']] = $field['field'];
                        }
                    }

                    return $res;
                };
                add_filter('manage_edit-' . $field['post_type'] . '_columns', $manage_edit_callback, 30);

                $acf_render_callback = function ($column_name, $post_id) use ($field) {
                    if ($column_name == $field['key'] && is_callable('get_field')) {
                        $acf_object = get_field_object($field['key'], $post_id);
                        if ($acf_object) {
                            $val = get_field($field['key'], $post_id);

                            switch ($acf_object['type']) {
                                case 'image':
                                    echo '<img src="' . $val['url'] . '" style="max-width: 40px;">';

                                    break;

                                case 'text':
                                case 'email':
                                case 'number':
                                case 'select':
                                case 'true_false':
                                case 'textarea':
                                case 'date_picker':
                                case 'date_time_picker':
                                case 'time_picker':
                                    echo $val;

                                    break;

                                case 'page_link':
                                case 'url':
                                    echo '<a href="' . $val . '" target="_blank">' . $val . '</a>';

                                    break;

                                case 'color_picker':
                                    echo '<div style="
                                        width: 40px;
                                        height: 40px;
                                        border: 1px solid #ccc;
                                        background-color: ' . $val . '
                                        "></div>';

                                    break;

                                case 'post_object':
                                    $post = get_post($val);
                                    if ($post) {
                                        echo $post->post_title;
                                    }

                                    break;
                            }
                        }
                    }
                };
                add_filter('manage_' . $field['post_type'] . '_posts_custom_column', $acf_render_callback, 5, 2);

                // Make column sortable
                if ($field['sortable']) {
                    $acf_sortable_column = function ($columns) use ($field) {
                        $columns[$field['key']] = $field['key'];

                        return $columns;
                    };

                    add_filter('manage_edit-' . $field['post_type'] . '_sortable_columns', $acf_sortable_column);

                    $proceed_posts_sorting = function ($query) use ($field) {
                        if (!is_admin()) {
                            return;
                        }

                        $orderby = $query->get('orderby');

                        if ($field['key'] == $orderby) {
                            $query->set('meta_key', $field['key']);
                        }
                    };

                    add_action('pre_get_posts', $proceed_posts_sorting);
                }

                // add_filter('manage_edit-'.$field['post_type'].'_columns', $acf_render_callback, 30);
            }
        }
    }
}
