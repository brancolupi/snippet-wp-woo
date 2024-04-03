<?php

function register_taxonomy_gusto() {
     $labels = array(
         'name'              => _x( 'Gusto', 'taxonomy general name' ),
         'singular_name'     => _x( 'Gusto', 'taxonomy singular name' ),
         'search_items'      => __( 'Search Gusto' ),
         'all_items'         => __( 'All Gusto' ),
         'parent_item'       => __( 'Parent Gusto' ),
         'parent_item_colon' => __( 'Parent Gusto:' ),
         'edit_item'         => __( 'Edit Gusto' ),
         'update_item'       => __( 'Update Gusto' ),
         'add_new_item'      => __( 'Add New Gusto' ),
         'new_item_name'     => __( 'New Gusto Name' ),
         'menu_name'         => __( 'Gusto' ),
     );
     $args   = array(
         'hierarchical'      => true, // make it hierarchical (like categories)
         'labels'            => $labels,
         'show_ui'           => true,
         'show_admin_column' => true,
         'query_var'         => true,
         'rewrite'           => [ 'slug' => 'gusto-prodotto' ],
     );
     register_taxonomy( 'gusto-prodotto', [ 'product' ], $args );
}
add_action( 'init', 'register_taxonomy_gusto' );



?>
