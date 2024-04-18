<?php
/////////////////////// START Add REST API support to an already registered taxonomy //////////////////////

/*add rest API support to event post type*/

add_filter( 'register_taxonomy_args', 'my_taxonomy_args', 10, 2 );

function my_taxonomy_args( $args, $taxonomy_name ) {

    if ( 'bollino' === $taxonomy_name ) {
        $args['show_in_rest'] = true;
        $args['rest_base']             = 'bollino';
        $args['rest_controller_class'] = 'WP_REST_Terms_Controller';
    }
	if ( 'brand' === $taxonomy_name ) {
        $args['show_in_rest'] = true;
        $args['rest_base']             = 'brand';
        $args['rest_controller_class'] = 'WP_REST_Terms_Controller';
    }
	if ( 'caratteristiche' === $taxonomy_name ) {
        $args['show_in_rest'] = true;
        $args['rest_base']             = 'caratteristiche';
        $args['rest_controller_class'] = 'WP_REST_Terms_Controller';
    }
	if ( 'caratteristiche_prodotti_capelli' === $taxonomy_name ) {
        $args['show_in_rest'] = true;
        $args['rest_base']             = 'caratteristiche_prodotti_capelli';
        $args['rest_controller_class'] = 'WP_REST_Terms_Controller';
    }

    return $args;
}

/////////////////////// END Add REST API support to an already registered taxonomy ///////////////////////

?>
