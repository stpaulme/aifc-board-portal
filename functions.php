<?php

if (!class_exists('Timber')) {
    add_action(
        'admin_notices',
        function () {
            echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url(admin_url('plugins.php#timber')) . '">' . esc_url(admin_url('plugins.php')) . '</a></p></div>';
        }
    );
    return;
}

Timber::$dirname = array('templates');

class SPMSite extends Timber\Site {
    public function __construct()
    {
        add_action('after_setup_theme', array($this, 'theme_supports'));
        add_action('after_setup_theme', array($this, 'image_sizes'));
        add_filter('timber/context', array($this, 'add_to_context'));
        add_action('init', array($this, 'register_menus'));
        add_action('init', array($this, 'register_post_types'));
        add_action('init', array($this, 'register_taxonomies'));
        add_action('init', array($this, 'register_widgets'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue'));
        add_action('login_enqueue_scripts', array($this, 'enqueue'));

        parent::__construct();
    }

    public function register_menus()
    {
        require 'lib/menus.php';
    }

    public function register_post_types()
    {
        require 'lib/post-types.php';
    }

    public function register_taxonomies()
    {
        require 'lib/taxonomies.php';
    }

    public function register_widgets()
    {
        require 'lib/widgets.php';
    }

    public function add_to_context($context)
    {
        global $post;
        $context['blog_categories'] = Timber::get_terms('category');
        foreach (get_registered_nav_menus() as $location => $value) {
            $twig_location = str_replace('-', '_', $location);
            $context['menu_' . $twig_location] = new TimberMenu($location);
        }
        $context['options'] = get_fields('option');
        $context['search_form'] = get_search_form(false);
        $context['site'] = $this;
        $context['top_parent'] = spm_get_top_parent($post);
        $newsletter_signup = gravity_form('Newsletter Signup', false, false, true, false, false, 0, false);
        if (isset($newsletter_signup)) {
            $context['newsletter_signup'] = $newsletter_signup;
        }

        return $context;
    }

    public function theme_supports()
    {
        require 'lib/theme-supports.php';
    }

    public function image_sizes()
    {
        require 'lib/image-sizes.php';
    }

    public function enqueue()
    {
        require 'lib/enqueue.php';
    }
}

new SPMSite();

// ACF options page
if (function_exists('acf_add_options_page')) {
    require 'lib/acf-options-page.php';
}

// Additional actions
require 'lib/actions.php';

// Additional filters
require 'lib/filters.php';

// Custom functions
require 'lib/custom-functions.php';

function weichie_load_more()
{
    $ajaxposts = new WP_Query([
        'post_type' => 'document',
        'posts_per_page' => 6,
        'orderby' => 'date',
        'order' => 'DESC',
        'paged' => $_POST['paged'],
    ]);

    $response = '';

    if ($ajaxposts->have_posts()) {
        while ($ajaxposts->have_posts()): $ajaxposts->the_post();
            ob_start();
            echo '<div class="col-md-6 col-lg-4 documents-archive__col">';
            $context = Timber::context();
            $context['post'] = new Timber\Post(get_the_ID());
            $post_type = $context['post']->post_type;

            $templates = array('blocks/excerpt-' . $post_type . '.twig', 'blocks/excerpt.twig');

            Timber::render($templates, $context);

            $response .= ob_get_contents();
            echo '</div>';
            ob_end_clean();
        endwhile;
    } else {
        $response = '';
    }

    echo $response;
    exit;
}
add_action('wp_ajax_weichie_load_more', 'weichie_load_more');
add_action('wp_ajax_nopriv_weichie_load_more', 'weichie_load_more');

// Customize subscriber role

// See private posts
$role = get_role('subscriber');
$role->add_cap('read_private_pages');
$role->add_cap('read_private_posts');

// Redirect to home page on login
add_filter('login_redirect', 'spm_login_redirect', 10, 3);
function spm_login_redirect($redirect_to, $request_redirect_to, $user)
{
    if (is_a($user, 'WP_User') && $user->has_cap('edit_posts') === false) {
        return get_bloginfo('siteurl');
    }

    return $redirect_to;
}
