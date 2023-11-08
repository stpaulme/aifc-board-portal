<?php

wp_enqueue_style( 'spm-css', get_template_directory_uri() . '/dist/css/spm.min.css', array(), filemtime(get_template_directory() . '/dist/css/spm.min.css'), false );
wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap' );
wp_enqueue_script( 'spm-js', get_template_directory_uri() . '/dist/js/spm.min.js', array( 'jquery' ) );