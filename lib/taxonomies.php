<?php

/**
 * Taxonomy: Document Year.
 */

$labels = array(
    'name' => _x('Years', 'Taxonomy General Name', 'aifc-board-portal'),
    'singular_name' => _x('Year', 'Taxonomy Singular Name', 'aifc-board-portal'),
);

$args = array(
    'labels' => $labels,
    'public' => false,
    'show_ui' => true,
    'show_admin_column' => true,
    'meta_box_cb' => 'post_categories_meta_box',
);

register_taxonomy('document_year', array('document'), $args);

/**
 * Taxonomy: Document Month.
 */

$labels = array(
    'name' => _x('Months', 'Taxonomy General Name', 'aifc-board-portal'),
    'singular_name' => _x('Month', 'Taxonomy Singular Name', 'aifc-board-portal'),
);

$args = array(
    'labels' => $labels,
    'public' => false,
    'show_ui' => true,
    'show_admin_column' => true,
    'meta_box_cb' => 'post_categories_meta_box',
);

register_taxonomy('document_month', array('document'), $args);

/**
 * Taxonomy: Document Category.
 */

$labels = array(
    'name' => _x('Categories', 'Taxonomy General Name', 'aifc-board-portal'),
    'singular_name' => _x('Category', 'Taxonomy Singular Name', 'aifc-board-portal'),
);

$args = array(
    'labels' => $labels,
    'public' => false,
    'show_ui' => true,
    'show_admin_column' => true,
    'meta_box_cb' => 'post_categories_meta_box',
);

register_taxonomy('document_category', array('document'), $args);
