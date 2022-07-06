<?php
add_action('init', 'matat_register_all');



function matat_register_all(){
    $types =  function_exists('matat_get_post_types') ? matat_get_post_types() : array();
    $taxs =  function_exists('matat_get_taxonomies') ? matat_get_taxonomies() : array();

    foreach ((array)$types as $type){
        matat_register_post_type( $type  );
    }

    foreach ((array)$taxs as $tax){
        matat_register_taxonomy( $tax );
    }
}




// keep the child theme text domain
function matat_register_post_type($args, $label = '') {

    $labels = array(
        'name'               => __($args['label'], 'matat'),
        'menu_name'          => __($args['label'], 'matat')
    );

    $defaults = array(
        'public'  => true,
        'show_ui' => true,
        'show_in_nav_menus' => true,
        'show_in_menu' => true,
        'has_archive' => true,
        'rewrite' =>array(
            'slug'         =>  '',
            'with_front'   => true
        ),
        'hierarchical' => true,
        'menu_icon'    => get_template_directory_uri() . '/admin/images/workers.png',
        'supports'     =>  array('title','editor','thumbnail','author'),
        'labels'     =>  $labels
    ) ;

    $args = wp_parse_args($args,$defaults);
    register_post_type( $args['type'],$args);



}


function matat_register_taxonomy( $tax ) {
    $labels = array(
        'name'          => _x( $tax['label'],'matat' ),
        'singular_name' => _x( $tax['label'] ,'matat' ),
        'search_items'  => __( "Search {$tax['label']}" ,'matat'),
        'popular_items' => __( "Popular {$tax['label']}" ,'matat'),
        'all_items'     => __( "All {$tax['label']}" ,'matat'),
        'edit_item'     => __( "Edit {$tax['label']}" ,'matat'),
        'update_item'   => __( "Update {$tax['label']}" ,'matat'),
        'add_new_item'  => __( "Add {$tax['label']}",'matat' )

    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' =>__( $tax['slug'],'matat' ) ),
    );
    register_taxonomy( $tax['slug'], array($tax['post_type']) , $args );

}




