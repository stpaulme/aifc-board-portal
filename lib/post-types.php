<?php

/**
 * Post Type: Staff Members.
 */

$labels = array(
    "name" => __( "Staff Members", "custom-post-type-ui" ),
    "singular_name" => __( "Staff Member", "custom-post-type-ui" ),
    "menu_name" => __( "Staff", "custom-post-type-ui" ),
);

$args = array(
    "label" => __( "Staff Members", "custom-post-type-ui" ),
    "labels" => $labels,
    "description" => "",
    "public" => true,
    "publicly_queryable" => true,
    "show_ui" => true,
    "delete_with_user" => false,
    "show_in_rest" => true,
    "rest_base" => "",
    "rest_controller_class" => "WP_REST_Posts_Controller",
    "has_archive" => false,
    "show_in_menu" => true,
    "show_in_nav_menus" => true,
    "exclude_from_search" => false,
    "capability_type" => "post",
    "map_meta_cap" => true,
    "hierarchical" => false,
    "rewrite" => array( "slug" => "about/staff", "with_front" => false ),
    "query_var" => true,
    "menu_icon" => "dashicons-groups",
    "supports" => array( "title", "editor", "thumbnail" ),
);

register_post_type( "staff", $args );