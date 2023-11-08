<?php

$context = Timber::context();
$post = new TimberPost();

// Featured image
$page_for_posts = get_option( 'page_for_posts' );
$manually_featured_image = new Timber\Image( get_post_thumbnail_id($page_for_posts) );
$context['manually_featured_image'] = $manually_featured_image;

$context['title'] = $post->title;

$context['posts'] = new Timber\PostQuery();

$templates = array( 'index.twig' );
if ( is_home() ) {
	array_unshift( $templates, 'front-page.twig', 'home.twig' );
}

Timber::render( $templates, $context );