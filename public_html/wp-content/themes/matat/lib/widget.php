<?php
/**
 * Register sidebars
 */
if (!function_exists('matat_widgets_init')) {
    function matat_widgets_init()
    {
        register_sidebar(array(
            'name' => __('Footer', 'roots'),
            'id' => 'sidebar-footer',
            'before_widget' => '<li>',
            'after_widget' => '</li>',
//            'before_title' => '<span class="footer-nav-title">',
//            'after_title' => '</span>',

        ));
    }

    add_action('widgets_init', 'matat_widgets_init');
}
