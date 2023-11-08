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

    }

    return $modules;

}