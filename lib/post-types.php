<?php

/**
 * Post Type: Documents.
 */

$labels = array(
    "name" => __("Documents", "aifc-board-portal"),
    "singular_name" => __("Document", "aifc-board-portal"),
);

$args = array(
    "label" => __("Documents", "aifc-board-portal"),
    "labels" => $labels,
    "description" => "",
    "public" => true,
    "publicly_queryable" => true,
    "show_ui" => true,
    "delete_with_user" => false,
    "show_in_rest" => true,
    "rest_base" => "",
    "rest_controller_class" => "WP_REST_Posts_Controller",
    "has_archive" => true,
    "show_in_menu" => true,
    "show_in_nav_menus" => true,
    "exclude_from_search" => false,
    "capability_type" => "post",
    "map_meta_cap" => true,
    "hierarchical" => false,
    "query_var" => true,
    "supports" => array("title", "excerpt"),
    "rewrite" => array("slug" => "documents", "with_front" => false),
);

register_post_type("document", $args);

/**
 * Remove the single views of certain post types.
 */

add_filter('is_post_type_viewable', function ($is_viewable, $post_type) {
    if ('document' === $post_type->name) {
        return false;
    }
    return $is_viewable;
}, 10, 2);
