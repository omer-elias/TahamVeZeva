<?php
 /*
 excerpt functions
--------------------------------------------*/

function custom_excerpt_length( $length ) {
    return 40;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

//todo: please change the read more to translation and not hebrew in the code
function matat_continue_reading_link() {
    return ' <a class="read-more" href="'. esc_url( get_permalink() ) . '">' . __( 'Read More', 'matat' ) . '</a>';
}

function matat_custom_excerpt_more( $output ) {
    if ( has_excerpt() && ! is_attachment() ) {
        $output .= matat_continue_reading_link();
    }
    return $output;
}
//add_filter( 'get_the_excerpt', 'matat_custom_excerpt_more' );

// Replaces "[...]"
function matat_auto_excerpt_more( $more ) {
    return ''; // &hellip; => ... (remove it if you don't need it)
}
add_filter( 'excerpt_more', 'matat_auto_excerpt_more' );
