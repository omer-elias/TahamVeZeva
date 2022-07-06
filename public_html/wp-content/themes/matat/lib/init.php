<?php
/**
 *  initial setup and constants
 */
function matat_setup() {
    global $meta_prefix;
    $meta_prefix =   "_matat_";
    // Make theme available for translation
    // Community translations can be found at https://github.com/roots/roots-translations
    load_theme_textdomain('matat', get_template_directory() . '/lang');
    // Enable plugins to manage the document title
    // http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
    add_theme_support('title-tag');
    // Register wp_nav_menu() menus
    // http://codex.wordpress.org/Function_Reference/register_nav_menus
    register_nav_menus(array(
        'primary_menu' => __('Primary Navigation', 'matat')
    ));
    register_nav_menus(array(
        'footer_menu' => __('Footer Navigation', 'matat')

    ));

	register_nav_menus(array(
		'content_menu' => __('Content page Navigation', 'matat')

	));

    register_nav_menus(array( 'discover_menu' => __( 'discover_menu' )
    ));

    // Add post thumbnails
    // http://codex.wordpress.org/Post_Thumbnails
    // http://codex.wordpress.org/Function_Reference/set_post_thumbnail_size
    // http://codex.wordpress.org/Function_Reference/add_image_size
    add_theme_support('post-thumbnails');
    // Add post formats
    // http://codex.wordpress.org/Post_Formats
//    add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio'));
    // Add HTML5 markup for captions
    // http://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
    add_theme_support('html5', array('caption', 'comment-form', 'comment-list'));
    // Tell the TinyMCE editor to use a custom stylesheet
 //   add_editor_style('/assets/css/editor-style.css');
}
add_action('after_setup_theme', 'matat_setup');




// Cleaning up the Wordpress Head
function matat_head_cleanup() {
    // remove header links
    remove_action( 'wp_head', 'feed_links_extra', 3 );                    // Category Feeds
    remove_action( 'wp_head', 'feed_links', 2 );                          // Post and Comment Feeds
    remove_action( 'wp_head', 'rsd_link' );                               // EditURI link
    remove_action( 'wp_head', 'wlwmanifest_link' );                       // Windows Live Writer
    remove_action( 'wp_head', 'index_rel_link' );                         // index link
    remove_action( 'wp_head', 'parent_post_rel_link', 10 );               // previous link
    remove_action( 'wp_head', 'start_post_rel_link', 10);                 // start link
    remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );    // Links for Adjacent Posts
    remove_action( 'wp_head', 'wp_generator' );                           // WP version
}
// launching operation cleanup
add_action('init', 'matat_head_cleanup');
