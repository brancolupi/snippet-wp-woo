<?php

function register_custom_sidebar() {
	register_sidebar( array(
		'name'          => __( 'Mobile Shop Sidebar', 'textdomain' ),
		'id'            => 'custom-sidebar',
		'description'   => __( 'I widget in questa sidebar sono mostrati solo nella pagina catalogo-prodotti.', 'textdomain' ),
		'before_widget' => '<section style="display:flex;">',
		'after_widget'  => '</section>',
		'before_title'  => '<h1>',
		'after_title'   => '</h1>',
	) );
}

add_action( 'widgets_init', 'register_custom_sidebar' );

?>

<!-- Utilizzo -->
<?php dynamic_sidebar('custom-sidebar'); ?>
