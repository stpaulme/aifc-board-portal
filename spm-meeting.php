<?php

/**
 * Template Name: Meeting
 */

if (!is_user_logged_in()) {
    auth_redirect();
}

$context = Timber::get_context();
$timber_post = new TimberPost();

$context['post'] = $timber_post;
$context['title'] = spm_is_acf_date_in_future('meeting_date') ? 'Upcoming Board Meeting' : 'Past Board Meeting';

/* Below */
$below = get_field('below_modules');
$context['below'] = spm_add_data_to_modules($below);

Timber::render(array('spm-meeting.twig'), $context);
