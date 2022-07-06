<?php

function matat_scripts()
{
    if (!is_admin()) {
        // enqueue to header
        wp_enqueue_script('jquery');
      //  wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), '', true);

        // Enable threaded comments
        if ((!is_admin()) && is_singular() && comments_open() && get_option('thread_comments'))
            wp_enqueue_script('comment-reply');

        wp_localize_script('bootstrap', 'matat', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'ajax_nonce' => wp_create_nonce('csrf-token'),
        ));

    }
}

add_action('wp_enqueue_scripts', 'matat_scripts');






