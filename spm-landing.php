<?php

/**
 * Template Name: Landing
 */

if (!is_user_logged_in()) {
    auth_redirect();
}

$context = Timber::get_context();
$timber_post = new TimberPost();

$context['post'] = $timber_post;
$context['title'] = $timber_post->name;

$content_modules = get_field('content_modules');
$context['content'] = spm_add_data_to_modules($content_modules);

Timber::render(array('spm-landing.twig'), $context);
