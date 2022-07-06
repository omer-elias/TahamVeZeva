<?php

/**
 * Return the P for  index found in the post content.
 *
 * @since matat 1.0
 * @return string|bool URL or false when no link is present.
 */
function matat_get_paragraph($index)
{
    $content_by_p = preg_split('/&nbsp;/is', get_the_content());
    return (isset($content_by_p[$index])) ? $content_by_p[$index] : "";
}

/**
 * Return the URL for the first link found in the post content.
 *
 * @since matat 1.0
 * @return string|bool URL or false when no link is present.
 */
function matat_url_grabber()
{
    if (!preg_match('/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', get_the_content(), $matches))
        return false;

    return esc_url_raw($matches[1]);
}


/**
 * get_images
 * @param int $pid
 * @param bool $feature_image
 */
function get_images($pid, $feature_image = true)
{
    $args = array(
        'order' => 'ASC',
        'orderby' => 'menu_order',
        'post_type' => 'attachment',
        'post_parent' => $pid,
        'post_mime_type' => 'image',
        'post_status' => null,
        'numberposts' => -1,
        'exclude' => ($feature_image) ? -1 : get_post_thumbnail_id($pid),

    );
    return $attachments = get_posts($args);
}


/* WP Editor add font size and font */
function wp_editor_font_size_filter($options)
{
    array_shift($options);
    array_unshift($options, 'fontsizeselect');
    array_unshift($options, 'fontselect');
    array_unshift($options, 'formatselect');
    return $options;
}

add_filter('mce_buttons_2', 'wp_editor_font_size_filter');


// This function return the first parent taxonomy
function matat_tax_first_level($term, $tax)
{
    if ($term->parent == 0)
        return $term;
    $parent = get_term($term->parent, $tax);
    return matat_tax_first_level($parent, $tax);
}


function matat_get_youtube_thmb($url)
{
    require_once(ABSPATH . WPINC . '/class-oembed.php');
    $oembed = _wp_oembed_get_object();

    $provider = $oembed->get_provider($url);
    $fetch = $oembed->fetch($provider, $url);
    $url = $fetch->thumbnail_url;
    return $url;
}

function matat_get_video_thumbnail($id)
{
    $url = matat_meta('video_thumbnail', $id);


    if ($url == '') {
        $url = matat_get_youtube_thmb(matat_meta('video', $id));
        update_post_meta($id, '_matat_video_thumbnail', $url);
    }

    return $url;
}

function matat_youtube_thumbnail($id, $class = 'youtube-thumb')
{
    $url = matat_get_video_thumbnail($id);
    return "<img class='$class' src='$url'/>";
}

function matat_term_meta($key, $id)
{
    return get_tax_meta($id, "_matat_$key", true);
}

function matat_meta($key, $post_id = false)
{
    $id = (!$post_id) ? get_the_ID() : $post_id;

    return get_post_meta($id, "_matat_$key", true);
}


function matat_print_image($id, $thumb = 'full' , $class = '')
{
    $url = wp_get_attachment_image_src($id,$thumb);
    $alt = esc_attr(get_post_meta($id, '_wp_attachment_image_alt', true));
    if(!$alt){
        $alt = esc_attr(get_the_title($id));
    }

    echo "<img  class='$class' src='$url[0]' alt='$alt'/>";
}


function matat_bg()
{
    if (has_post_thumbnail()) {
        $img = get_the_post_thumbnail_url(get_the_ID(), 'full');
        echo " style='background-image: url($img)';";
    }
}


// Change default page template in wp admin

function matat_default_page_template() {
    global $post;
    if ( 'page' == $post->post_type
        && 0 != count( get_page_templates( $post ) )
        && get_option( 'page_for_posts' ) != $post->ID // Not the page for listing posts
        && '' == $post->page_template // Only when page_template is not set
    ) {
        $post->page_template = "page-content.php";
    }
}
//add_action('add_meta_boxes', 'matat_default_page_template', 1);

function matat_get_print_image($id, $thumb = 'full' , $class = '')
{
    $url = wp_get_attachment_image_src($id,$thumb);
    $alt = esc_attr(get_post_meta($id, '_wp_attachment_image_alt', true));
    if(!$alt){
        $alt = esc_attr(get_the_title($id));
    }

    return "<img  class='$class' src='$url[0]' alt='$alt'/>";
}


