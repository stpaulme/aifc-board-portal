<?php

/**
 * Template Name: Home
 */

$context = Timber::get_context();
$timber_post = new TimberPost();

$context['post'] = $timber_post;

// Hero
$context['hero'] = get_field( 'hero' );

// Content
$content_modules = get_field( 'content_modules' );
$context['content'] = spm_add_data_to_modules( $content_modules );

Timber::render( array( 'spm-home.twig' ), $context );