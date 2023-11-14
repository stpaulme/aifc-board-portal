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
        $module['bg_color'] = 'white';

        if ($module['acf_fc_layout'] == 'board') {
            $module['bg_color'] = 'gray';
        }

        if ($module['acf_fc_layout'] == 'cta_pair') {
            $module['bg_color'] = 'black';
        }

        if ($module['acf_fc_layout'] == 'cta_group') {
            $module['bg_color'] = 'gray';
        }

        if ($module['acf_fc_layout'] == 'feed_document') {
            $module['bg_color'] = 'gray';

            $selection_choice = $module['selection_choice'];

            if ($selection_choice == 'auto') {
                // Get data from ACF
                $year = $module['year'];
                $month = $module['month'];
                $category = $module['category'];

                // Add posts to module in Timber
                $args = array(
                    'post_type' => 'document',
                    'posts_per_page' => -1,
                    'tax_query' => array(
                        'relation' => 'AND',
                    ),
                );

                if ($year != false) {
                    $args['tax_query'][] = array(
                        'taxonomy' => 'document_year',
                        'field' => 'term_id',
                        'terms' => $year,
                    );
                }

                if ($month != false) {
                    $args['tax_query'][] = array(
                        'taxonomy' => 'document_month',
                        'field' => 'term_id',
                        'terms' => $month,
                    );
                }

                if ($category != false) {
                    $args['tax_query'][] = array(
                        'taxonomy' => 'document_category',
                        'field' => 'term_id',
                        'terms' => $category,
                    );
                }

                $module['posts'] = Timber::get_posts($args);
            } else {
                // Get data from ACF
                $documents = $module['documents'];
                $module['posts'] = [];

                foreach ($documents as $post_id) {
                    $post = new Timber\Post($post_id);
                    $module['posts'][] = $post;
                }
            }
        }

    }

    return $modules;

}

function spm_is_acf_date_in_future($field_name)
{
    $acf_date = get_field($field_name);

    $current_date = date('Y-m-d H:i:s');

    return strtotime($acf_date) > strtotime($current_date);
}