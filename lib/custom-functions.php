<?php

function spm_get_top_parent($post)
{

    // Bail early if we don't have the post object
    if (!is_object($post)) {
        return false;
    }

    if ($post->post_parent) {
        $ancestors = get_post_ancestors($post->ID);
        $root = count($ancestors) - 1;
        $parent = $ancestors[$root];
    } else {
        $parent = $post->ID;
    }

    return $parent;

}

function spm_get_child_pages($depth, $show_title_li)
{
    global $post;

    $top_parent = spm_get_top_parent($post);

    $args = array(
        'child_of' => $top_parent,
        'depth' => $depth,
        'echo' => false,
        'sort_column' => 'menu_order',
        'title_li' => '',
    );

    if ($show_title_li == true) {
        $args['title_li'] = '<h2>' . get_the_title($top_parent) . '</h2>';
    }

    $child_pages = wp_list_pages($args);

    return $child_pages;
}

function spm_add_data_to_modules($modules)
{

    if (empty($modules)) {
        return false;
    }

    foreach ($modules as &$module) {

        if ($module['acf_fc_layout'] == 'feed_post') {
            // Get data from ACF
            $post_category = $module['post_category'];

            // Add post category to module in Timber
            if (!empty($post_category)) {
                $module['post_category'] = new Timber\Term($post_category);
            }

            // Add posts to module in Timber
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => 1,
                'cat' => $post_category,
            );

            $module['posts'] = Timber::get_posts($args);
        }

        if ($module['acf_fc_layout'] == 'feed_event') {
            // Get data from ACF
            $event_category = $module['event_category'];
            $max = $module['max'];

            // Add event category to module in Timber
            if (!empty($event_category)) {
                $module['event_category'] = new Timber\Term($event_category, 'tribe_events_cat');
            }

            // Add events to module in Timber
            $args = array(
                'posts_per_page' => $max,
                'start_date' => 'now',
            );
            if (!empty($event_category)) {
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'tribe_events_cat',
                        'field' => 'term_id',
                        'terms' => $event_category,
                    ),
                );
            }
            $events = tribe_get_events($args);
            if ($events):
                $module['events'] = new Timber\PostQuery($events, 'Event');
            endif;
        }

    }

    return $modules;

}

// TEC: Use default events template for single event series
add_filter(
    'template_include',
    function ($template) {
        if (is_singular('tribe_event_series')) {
            $template = locate_template('tribe/events/v2/default-template.php');
        }

        return $template;
    }
);

// TEC: Load missing assets on single event series
function spm_tec_load_missing_assets_on_series()
{
    if (is_singular('tribe_event_series')) {
        // CSS
        wp_enqueue_style('tribe-events-views-v2-bootstrap-datepicker-styles-css', WP_PLUGIN_URL . '/the-events-calendar/vendor/bootstrap-datepicker/css/bootstrap-datepicker.standalone.min.css');
        wp_enqueue_style('tribe-common-skeleton-style-css', WP_PLUGIN_URL . '/the-events-calendar/common/src/resources/css/common-skeleton.min.css');
        wp_enqueue_style('tribe-tooltipster-css-css', WP_PLUGIN_URL . '/the-events-calendar/common/vendor/tooltipster/tooltipster.bundle.min.css');
        wp_enqueue_style('tribe-events-views-v2-skeleton-css', WP_PLUGIN_URL . '/the-events-calendar/src/resources/css/views-skeleton.min.css');
        wp_enqueue_style('tribe-common-full-style-css', WP_PLUGIN_URL . '/the-events-calendar/common/src/resources/css/common-full.min.css');
        wp_enqueue_style('tribe-events-views-v2-full-css', WP_PLUGIN_URL . '/the-events-calendar/src/resources/css/views-full.min.css');
        wp_enqueue_style('tribe-events-views-v2-print-css', WP_PLUGIN_URL . '/the-events-calendar/src/resources/css/views-print.min.css');
        wp_enqueue_style('tribe-events-pro-views-v2-skeleton-css', WP_PLUGIN_URL . '/events-calendar-pro/src/resources/css/views-skeleton.min.css');
        wp_enqueue_style('tribe-events-pro-views-v2-full-css', WP_PLUGIN_URL . '/events-calendar-pro/src/resources/css/views-full.min.css');
        wp_enqueue_style('tribe-events-pro-views-v2-print-css', WP_PLUGIN_URL . '/events-calendar-pro/src/resources/css/views-print.min.css');

        // JS
        wp_enqueue_script('tribe-common-js', WP_PLUGIN_URL . '/the-events-calendar/common/src/resources/js/tribe-common.min.js', );
        wp_enqueue_script('tribe-events-views-v2-breakpoints-js', WP_PLUGIN_URL . '/the-events-calendar/src/resources/js/views/breakpoints.min.js', array('jquery'), );
    }
}
add_action('wp_enqueue_scripts', 'spm_tec_load_missing_assets_on_series');

// TEC: Force list view on single event series
add_filter(
    'tec_events_pro_custom_tables_v1_series_event_view_slug',
    function ($view) {
        return 'list';
    }
);
