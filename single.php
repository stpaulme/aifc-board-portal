<?php

if (!is_user_logged_in()) {
    auth_redirect();
}

$context = Timber::context();
$post = Timber::query_post();

$context['post'] = $post;
$context['show_date'] = true;
$context['title'] = $post->title;
$context['breadcrumbs'] = bcn_display(true);

if (is_singular('staff')) {
    $context['show_date'] = false;
    $context['title'] = 'Staff';
}

Timber::render(array('single-' . $post->ID . '.twig', 'single-' . $post->post_type . '.twig', 'single.twig'), $context);
