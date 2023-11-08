<?php

$context = Timber::context();

$context['title'] = 'Archive';
if ( is_day() ) {
	$context['title'] = 'Archive: ' . get_the_date( 'D M Y' );
} else if ( is_month() ) {
	$context['title'] = 'Archive: ' . get_the_date( 'M Y' );
} else if ( is_year() ) {
	$context['title'] = 'Archive: ' . get_the_date( 'Y' );
} else if ( is_tag() ) {
	$context['title'] = single_tag_title( '', false );
} else if ( is_category() ) {
	$context['title'] = single_cat_title( '', false );
	$context['breadcrumbs'] = bcn_display(true);

	// Featured image
	$page_for_posts = get_option( 'page_for_posts' );
	$manually_featured_image = new Timber\Image( get_post_thumbnail_id($page_for_posts) );
	$context['manually_featured_image'] = $manually_featured_image;
	
	// Categories
	$context['current_category'] = new Timber\Term();

	// array_unshift( $templates, 'archive-' . get_query_var( 'cat' ) . '.twig' );
} else if ( is_post_type_archive() ) {
	$context['title'] = post_type_archive_title( '', false );
	// array_unshift( $templates, 'archive-' . get_post_type() . '.twig' );
}

$context['posts'] = new Timber\PostQuery();

$templates = array( 'archive.twig', 'index.twig' );

Timber::render( $templates, $context );