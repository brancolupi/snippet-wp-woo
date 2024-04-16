<?php 

function media_voti_clienti_in_percentuale(){
	
	global $post;
	
// 	$numero_recensioni = 0;
	$somma_voti = 0;
// 	$media_voti = 0;
// 	$percentuale_voti = 0;

	$recensioni_args = array(	
		'post_type' => 'recensioni',
		'post_status' => 'publish',
		'posts_per_page' => -1,
	);

	$recensioni_query = new WP_Query( $recensioni_args );

	$numero_recensioni = $recensioni_query->found_posts;
	
	if( $recensioni_query->have_posts() ){
		while($recensioni_query->have_posts() ){
		 $recensioni_query->the_post();
		 $somma_voti =  $somma_voti + intval( get_post_meta($post->ID, 'valutazione_recensione', true) );
		}
	}          


	$media_voti = $somma_voti / $numero_recensioni;
	$percentuale_voti = $media_voti * 20;

	return $percentuale_voti;

}

add_shortcode( 'percentuale_voti', 'media_voti_clienti_in_percentuale' );

?>
