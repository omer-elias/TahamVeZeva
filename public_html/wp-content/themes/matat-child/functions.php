<?php

require_once 'vendor/autoload.php';
require_once( __DIR__ . '/lib/Site-Management/class-matat-site-management.php' );;

\Matat\Users\Actions::get_instance();

function matat_class_autoload()
{

    $matat_includes = array();
    $matat_includes = matat_main_class_autoload($matat_includes);
    foreach (glob(dirname(__FILE__) . "/lib/class/*.php") as $filename) {
        $matat_includes[] = "lib/class/" . basename($filename);
    }
    // parent function.
    matat_include($matat_includes);

}

function matat_child_theme_setup()
{
    add_theme_support('post-thumbnails');

    // add_image_size('woocommerce_thumbnail_new', 230, 300, true);


    /**
     * Check if use Woocommerce
     */
    $plugin_name = 'woocommerce/woocommerce.php';
    $active_plugins = apply_filters('active_plugins', get_option('active_plugins'));

    if (in_array($plugin_name, $active_plugins)) {
        add_theme_support('woocommerce');
        include 'woo_functions.php';
        include 'lib/woo_email.php';
    }

    add_filter('widget_text', 'do_shortcode');

    // load child text domain
    load_child_theme_textdomain('matat', get_stylesheet_directory() . '/languages');


    // load external files
    $matat_includes = array(
        'lib/widget.php',   // Utility functions
        'lib/post-type-init.php',   // Utility functions
    );
    //parent function.
    matat_include($matat_includes);
    matat_class_autoload();
}

add_action('after_setup_theme', 'matat_child_theme_setup');

function matat_child_scripts()
{
    if (!is_admin()) {

        wp_enqueue_script('jquery');

        //Parent theme
        wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
        wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), '', true);
        wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css');


        //Child theme
        wp_register_script('scripts', get_stylesheet_directory_uri() . '/assets/js/jquery.main.js', array('jquery'), '', true);
        wp_enqueue_script('matat', get_stylesheet_directory_uri() . '/assets/js/matat.js', array('jquery'), '', true);
        wp_enqueue_style('matat-style', get_stylesheet_uri());
        wp_enqueue_script('scripts');
    }
}

add_action('wp_enqueue_scripts', 'matat_child_scripts', 2);


// Function to change email address

function wpb_sender_email( $original_email_address ) {
    return 'tim.smith@example.com';
}

// Function to change sender name
function wpb_sender_name( $original_email_from ) {
    return 'Tim Smith';
}

// Hooking up our functions to WordPress filters
//add_filter( 'wp_mail_from', 'wpb_sender_email' );
//add_filter( 'wp_mail_from_name', 'wpb_sender_name' );

function matat_custom_body_class($classes)
{
//	if ( is_front_page() ) {
//		$classes[] = 'home-page';
//	}

    return $classes;
}

add_filter('body_class', 'matat_custom_body_class');





