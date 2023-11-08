<?php

$context = Timber::context();
$timber_post = new TimberPost();

$context['post'] = $timber_post;

$context['title'] = $timber_post->title;
if ( $timber_post->post_parent ) {
    $context['breadcrumbs'] = bcn_display(true);
}

/* Sidebar */
$context['sidebar'] = true;
$context['sidebar_nav'] = spm_get_child_pages(0, true);
$context['sidebar_modules'] = get_field( 'sidebar_modules' );

/* Below */
$below = get_field( 'below_modules' );
$context['below'] = spm_add_data_to_modules( $below );

$templates = array( 'default.twig' );

Timber::render( $templates, $context );