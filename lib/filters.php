<?php

// Add "Formats" dropdown to TinyMCE editor
function spm_add_formats_dropdown( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}
add_filter( 'mce_buttons_2', 'spm_add_formats_dropdown' );

// Insert formats into "Formats" dropdown
function spm_insert_formats( $init_array ) {
    $style_formats = array(
        array(
            'title' => 'Button',
            'selector' => 'a',
            'classes' => 'button',        
		),
	);
	
    // Insert the array, JSON ENCODED, into 'style_formats'
    $init_array['style_formats'] = json_encode( $style_formats );

    return $init_array;
} 
add_filter( 'tiny_mce_before_init', 'spm_insert_formats' );

// Make default WordPress embeds responsive by wrapping them in .er-container div
function spm_wrap_embeds( $html ) {
    return '<div class="er-container">' . $html . '</div>';
}
add_filter( 'embed_oembed_html', 'spm_wrap_embeds' );

// Customize which menu item is marked active
function spm_menu_item_classes( $classes, $item, $args ) {
    /* News */
    if( ( is_singular( 'post' ) || is_category() ) && 'News' == $item->title )
		$classes[] = 'current-menu-item';

    /* Staff */
    if( ( is_singular( 'staff' ) ) && 'About' == $item->title )
        $classes[] = 'current-menu-item';
    
    return array_unique( $classes );
    
}
add_filter( 'nav_menu_css_class', 'spm_menu_item_classes', 10, 3 );

// GF: Scroll to confirmation text or validation message
add_filter( 'gform_confirmation_anchor', '__return_true' );

// GF: Enable legacy markup
add_filter('gform_enable_legacy_markup', '__return_true');
