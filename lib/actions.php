<?php

// Remove tags from posts
add_action( 'init', 'spm_remove_tags' );
function spm_remove_tags() {
    unregister_taxonomy_for_object_type( 'post_tag', 'post' );
}

// Add excerpts to pages
add_action( 'init', 'spm_excerpts' );
function spm_excerpts() {
    add_post_type_support( 'page', 'excerpt' );
}

// Remove emojis
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

// Remove certain body classes
add_action( 'body_class', 'spm_remove_body_classes' );
function spm_remove_body_classes( $classes ) {
    // Remove 'search' class
    if ( in_array( 'search', $classes ) ) {
        unset( $classes[array_search('search', $classes)] );
    }

    return $classes;
}