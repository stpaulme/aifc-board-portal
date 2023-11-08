<?php

$context = Timber::context();
$context['title'] = '404';
$context['title_modifier'] = '404';
$context['content'] = get_field( '404_page', 'option' );

Timber::render( '404.twig', $context );