<?php

/**
 * WC Stuff
 */

add_filter('woocommerce_admin_order_preview_line_item_columns', function ($columns) {
    return ['image' => __('Image')] + $columns;
});

add_filter('woocommerce_admin_order_preview_line_item_column_image', function ($append, $item, $item_id, $order) {
    $product = $item->get_product();
    $thumbnail = $product ? apply_filters('woocommerce_admin_order_item_thumbnail', $product->get_image('thumbnail', array('title' => ''), false), $item_id, $item) : '';

    return wp_kses_post($thumbnail);
}, 10, 4);

/*
 * debug a given object in a nice way
 *
 * */
function debug($obj)
{
    echo "<pre dir='lrt' style='text-align:left'>";
    var_dump($obj);
    echo "</pre>";
}


$matat_includes = array(

    'lib/init.php',                                 // register items
    'lib/enqueue.php',                              // load scripts
    'lib/post-types.php',                           // register post type
    'lib/extras.php',                               // Matat custom functions
    'lib/excerpt.php',                              // Initial theme setup and constants
    'lib/widget.php',                               // Initial theme setup and constants
//    'lib/class/login.php',
    'lib/class/Matat_Nav_Walker.php',
//    'lib/class/Textme.php',
);
matat_include($matat_includes);


function matat_main_class_autoload($matat_includes)
{

    foreach (glob(dirname(__FILE__) . "/lib/class/*.php") as $filename) {
        $matat_includes[] = "lib/class/" . basename($filename);
    }
    // parent function.
    return $matat_includes;
}


function matat_include($matat_includes)
{

    foreach ($matat_includes as $file) {
        if (!$filepath = locate_template($file)) {
            trigger_error(sprintf(__('Error locating %s for include', 'matat'), $file), E_USER_ERROR);
        }
        require_once $filepath;
    }
    unset($file, $filepath);
}


function matat_theme_setup()
{
    // load text domain
    load_theme_textdomain('matat', get_template_directory() . '/languages');

}

add_action('after_setup_theme', 'matat_theme_setup');


remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// hide ACF menus for all users except those specified
function show_hide_acf_menu($show)
{

    // array of user IDs that are allowed to see ACF menu
    $allowedUsers = array(1, 2);

    // get the current user's ID
    $userID = get_current_user_id();

    if (in_array($userID, $allowedUsers)) {
        return true;
    } else {
        return false;
    }
}

add_filter('acf/settings/show_admin', 'show_hide_acf_menu');


function matat_help_dashboard_widget()
{ ?>
    <p><b>האתר נבנה ע"י מתת טכנולוגיות בע"מ</b></p>
    <p>פרטי יצירת קשר לשירות ותמיכה:
    <ul>
        <li>טלפון: 055-9-90-90-90</li>
        <li>משרד: 055-9-91-91-91</li>
        <li>אימייל: amit@matat.co.il</li>
    </ul>
    </p>
<?php }

// calling all custom dashboard widgets
function matat_custom_dashboard_widgets()
{
    //add_meta_box('ohav_rss_dashboard_widget', __('Recent Sites'), 'ohav_rss_dashboard_widget', 'dashboard', 'normal', 'core');
    add_meta_box('oh_help_dashboard_widget', __('תמיכה ושירות'), 'matat_help_dashboard_widget', 'dashboard', 'side', 'core');
}

// adding any custom widgets
add_action('wp_dashboard_setup', 'matat_custom_dashboard_widgets');


// Custom Backend Footer
function matat_custom_admin_footer()
{
    echo '<span id="footer-thank-you">Developed by: <a href="https://matat.co.il" target="_blank">Matat technologies LTD</a></span>.';
}

// adding it to the admin area
add_filter('admin_footer_text', 'matat_custom_admin_footer');


/* Automatically set the image Title, Alt-Text, Caption & Description upon upload
--------------------------------------------------------------------------------------*/
add_action('add_attachment', 'matat_set_image_meta_upon_image_upload');
function matat_set_image_meta_upon_image_upload($post_ID)
{

    // Check if uploaded file is an image, else do nothing

    if (wp_attachment_is_image($post_ID)) {

        $my_image_title = get_post($post_ID)->post_title;

        // Sanitize the title:  remove hyphens, underscores & extra spaces:
        $my_image_title = preg_replace('%\s*[-_\s]+\s*%', ' ', $my_image_title);

        // Sanitize the title:  capitalize first letter of every word (other letters lower case):
        $my_image_title = ucwords(strtolower($my_image_title));

        // Create an array with the image meta (Title, Caption, Description) to be updated
        // Note:  comment out the Excerpt/Caption or Content/Description lines if not needed
        $my_image_meta = array(
            'ID' => $post_ID,            // Specify the image (ID) to be updated
            'post_title' => $my_image_title,        // Set image Title to sanitized title
            'post_excerpt' => $my_image_title,        // Set image Caption (Excerpt) to sanitized title
            'post_content' => $my_image_title,        // Set image Description (Content) to sanitized title
        );

        // Set the image Alt-Text
        update_post_meta($post_ID, '_wp_attachment_image_alt', $my_image_title);

        // Set the image meta (e.g. Title, Excerpt, Content)
        wp_update_post($my_image_meta);

    }
}

add_filter('wp_get_attachment_image_attributes', 'matat_auto_add_alt_to_image_from_image_title', 99, 2);
function matat_auto_add_alt_to_image_from_image_title($arr1, $arr2)
{

    if (empty($arr1['alt'])) {
        $arr1['alt'] = $arr2->post_title;
    }

    return $arr1;
}

function custom_mtypes($m)
{
    $m['svg'] = 'image/svg+xml';
    $m['svgz'] = 'image/svg+xml';

    return $m;
}

add_filter('upload_mimes', 'custom_mtypes');



/**
 * @param $field
 * Create option page
 */

if (function_exists('acf_add_options_page') && current_user_can('administrator')) {


    $icon = get_template_directory_uri() . '/assets/img/favicon.png';
    $titleText = is_rtl() == true ? 'ניהול אתר' : 'Theme option';
    $title = '<img src="' . $icon . '"> ' . $titleText;



    $parent = acf_add_options_page(array(
        'page_title' => $titleText,
        'menu_title' => $titleText,
        'menu_slug' => 'matat-settings',
        'capability' => 'edit_posts',
        'redirect' => false,
        'icon_url' => $icon, // Add this line and replace the second inverted commas with class of the icon you like

    ));

    $GLOBALS['matat_acf_parent'] = $parent;


}


function remove_api()
{
    remove_action('wp_head', 'rest_output_link_wp_head', 10);
    remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
    remove_action('template_redirect', 'rest_output_link_header', 11, 0);
}

add_action('after_setup_theme', 'remove_api');


/**
 * remove editor from pages
 */
function hide_editor()
{

    // Get the Post ID.
    if (isset ($_GET['post'])) {
        $post_id = $_GET['post'];
    } else if (isset ($_POST['post_ID'])) {
        $post_id = $_POST['post_ID'];
    }

    if (!isset ($post_id) || empty ($post_id)) {
        return;
    }

    // Get the name of the Page Template file.
    $template_file = get_post_meta($post_id, '_wp_page_template', true);
    $arr = array('front-page.php');

    if (in_array($template_file, $arr)) { // edit the template name
        remove_post_type_support('page', 'editor');
    }

}

add_action('admin_init', 'hide_editor');


/**
 * function matat_insert_gallery_to_the_post
 *
 * @param $content
 *
 * @return string
 *
 */
function matat_insert_gallery_to_the_post($content)
{

    if (is_single()) {

        if (get_field('gal')) {

            ob_start();

            echo '<div class="content-gallery-holder">';
            echo '<div class="content-gallery">';

            foreach (get_field('gal') as $value) {

                echo '<div class="slide">';

                matat_print_image($value['ID']);

                echo '</div>';


            }
            echo ' </div>';
            echo ' </div>';


            $append = ob_get_clean();

        } else {

            $append = '';

        }

        $p_num = get_field('lead_p', get_the_ID());
        $lead_p = isset($p_num) ? $p_num : 3;

        return matat_insert_after_paragraph($append, $lead_p, $content);
    }

    return $content;
}

add_filter('the_content', 'matat_insert_gallery_to_the_post');

/**
 *  function matat_insert_after_paragraph
 *
 * insert gallery to the post after a specific paragraph
 *
 * @param $insertion
 * @param $paragraph_id
 * @param $content
 *
 * @return string
 */

function matat_insert_after_paragraph($insertion, $paragraph_id, $content)
{
    $closing_p = '</p>';
    $paragraphs = explode($closing_p, $content);
    foreach ($paragraphs as $index => $paragraph) {

        if (trim($paragraph)) {
            $paragraphs[$index] .= $closing_p;
        }

        if ($paragraph_id == $index + 1) {
            $paragraphs[$index] .= $insertion;
        }
    }

    return implode('', $paragraphs);
}


/***
 * Yoast breadcrumb
 */
function matat_yoast_breadcrumb()
{
    if (function_exists('yoast_breadcrumb')) {
        yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
    }
}


function matat_get_instegram_feed()
{

    $access_token = '';
    $username = '';
    $user_search = matat_instagram_api_curl_connect("https://api.instagram.com/v1/users/search?q=" . $username . "&access_token=" . $access_token);

    $user_id = '';
    $return = matat_instagram_api_curl_connect("https://api.instagram.com/v1/users/" . $user_id . "/media/recent?access_token=" . $access_token);

//var_dump( $return ); // if you want to display everything the function returns
    return $return;
}


function matat_instagram_api_curl_connect($api_url)
{
    $connection_c = curl_init(); // initializing
    curl_setopt($connection_c, CURLOPT_URL, $api_url); // API URL to connect
    curl_setopt($connection_c, CURLOPT_RETURNTRANSFER, 1); // return the result, do not print
    curl_setopt($connection_c, CURLOPT_TIMEOUT, 20);
    $json_return = curl_exec($connection_c); // connect and get json data
    curl_close($connection_c); // close connection

    return json_decode($json_return); // decode and return
}

function matat_get_instagram_followed_by()
{


    $xml = file_get_contents("https://api.instagram.com/v1/users/self/?access_token=1469316818.1677ed0.395c8b2b0fdd44d89066b650ef6f2233");

    return $xml;

}


function matat_remove_dashboard_widgets()
{
    global $wp_meta_boxes;

    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
    //unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
    remove_meta_box('dashboard_activity', 'dashboard', 'normal');


}

add_action('wp_dashboard_setup', 'matat_remove_dashboard_widgets');


function matat_change_login_img()
{
    $path = get_template_directory_uri() . '/assets/img/logo.png';
    ?>
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url(<?php echo $path; ?>);
            padding-bottom: 30px;
            width: 300px;
            height: 25px;
            background-size: 300px;
        }

    </style>
    <?php
}

add_action('login_enqueue_scripts', 'matat_change_login_img');


function add_matat_logo($wp_admin_bar)
{

    $icon = get_template_directory_uri() . '/assets/img/favicon.png';

    $args = array(
        'id' => 'matat',
        'title' => '<img src="' . $icon . '" >',
        'href' => 'http://matat.co.il',
    );
    $wp_admin_bar->add_node($args);
}

add_action('admin_bar_menu', 'add_matat_logo', 1);


function remove_wp_logo($wp_admin_bar)
{
    $wp_admin_bar->remove_node('wp-logo');
}

add_action('admin_bar_menu', 'remove_wp_logo', 999);


function my_custom_fonts()
{
    echo '<style>
   li#wp-admin-bar-matat img {
    margin-top: 7px;
}
  </style>';
}

add_action('admin_head', 'my_custom_fonts');


function add_favicon_admin()
{
    $favicon_url = get_template_directory_uri() . '/assets/img/favicon.png';
    echo '<link rel="icon" href="' . $favicon_url . '" type="image/x-icon"/>';
}

// Now, just make sure that function runs when you're on the login page and admin pages
add_action('login_head', 'add_favicon_admin');
add_action('admin_head', 'add_favicon_admin');


function add_favicon()
{
    $favicon_url = get_stylesheet_directory_uri() . '/assets/images/favicon.png';
    echo '<link rel="icon" href="' . $favicon_url . '" type="image/x-icon"/>';
}

add_action('wp_head', 'add_favicon');