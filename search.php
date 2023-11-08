<?php

$context = Timber::context();
$context['title'] = 'Search Results for "' . get_search_query() .'"';
$context['title_modifier'] = 'search';
$context['posts'] = new Timber\PostQuery();

$templates = array( 'search.twig' );

Timber::render( $templates, $context );