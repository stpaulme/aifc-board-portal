<?php

if ( ! class_exists( 'Timber' ) ) {
	add_action(
		'admin_notices',
		function() {
			echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
		}
	);
	return;
}

Timber::$dirname = array( 'templates' );

class SPMSite extends Timber\Site {
	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
		add_action( 'after_setup_theme', array( $this, 'image_sizes' ) );
		add_filter( 'timber/context', array( $this, 'add_to_context' ) );
		add_action( 'init', array( $this, 'register_menus' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		add_action( 'init', array( $this, 'register_widgets' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );

		parent::__construct();
	}

	public function register_menus() {
		require( 'lib/menus.php' );
	}

	public function register_post_types() {
		require('lib/post-types.php');
	}

	public function register_taxonomies() {
		require('lib/taxonomies.php');
	}

	public function register_widgets() {
		require('lib/widgets.php');
	}

	public function add_to_context( $context ) {
		global $post;
		$context['blog_categories'] = Timber::get_terms('category');
		foreach( get_registered_nav_menus() as $location => $value ) {
			$twig_location = str_replace( '-', '_', $location );
			$context['menu_' . $twig_location] = new TimberMenu( $location );
		}
		$context['options'] = get_fields('option');
		$context['search_form']  = get_search_form(false);
		$context['site']  = $this;
		$context['top_parent'] = spm_get_top_parent( $post );
		$newsletter_signup = gravity_form( 'Newsletter Signup', false, false, true, false, false, 0, false );
		if ( isset( $newsletter_signup ) ) {
			$context['newsletter_signup'] = $newsletter_signup;
		}

		return $context;
	}

	public function theme_supports() {
		require('lib/theme-supports.php');
	}

	public function image_sizes() {
		require('lib/image-sizes.php');
	}

	public function enqueue() {
		require('lib/enqueue.php');
	}
}

class Event extends Timber\Post {

	var $_start;
	var $_end;
	var $_event_category;

    public function start() {
        if ( !$this->_start ) {
			$start = tribe_get_start_date($this);
            if ( isset($start) ) {
                $this->_start = $start;
            }
        }
        return $this->_start;
	}
	
	public function end() {
        if ( !$this->_end ) {
			$end = tribe_get_end_date($this);
            if ( isset($end) ) {
                $this->_end = $end;
            }
        }
        return $this->_end;
	}
	
	public function event_category() {
        if (!$this->_event_category) {
            $event_categories = $this->get_terms('tribe_events_cat');
            if ( is_array($event_categories) && count($event_categories) ) {
				$event_category = Timber::get_term( $event_categories[0] );
                $this->_event_category = $event_category;
            }
        }
        return $this->_event_category;
    }
	
	public function venue() {
		if ( !$this->_venue ) {
			$venue = tribe_get_venue($this);
			if ( isset($venue) ) {
				$this->_venue = $venue;
			}
		}
		return $this->_venue;
	}
}

new SPMSite();

// ACF options page
if( function_exists('acf_add_options_page') ) {
	require( 'lib/acf-options-page.php' );
}

// Additional actions
require( 'lib/actions.php' );

// Additional filters
require( 'lib/filters.php' );

// Custom functions
require( 'lib/custom-functions.php' );