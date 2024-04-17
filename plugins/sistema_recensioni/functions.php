<?php 

function recensioni_custom_post_type() {
	register_post_type('recensioni',
		array(
			'labels'      => array(
				'name'          => __('Recensioni', 'textdomain'),
				'singular_name' => __('Recensione', 'textdomain'),
			),
			'supports'    => array(
                'title',
//                 'editor',
//                 'custom-fields',
            ),
			'public'      => true,
			'has_archive' => true,
		)
	);
}
add_action('init', 'recensioni_custom_post_type');

function recensioni_add_custom_box() {
		add_meta_box(
			'recensioni_box_id',    // Unique ID
			'Dettagli recensione',  // Box title
			'recensioni_custom_box_html', // Content callback, must be of type callable
			'recensioni'  // Post type
		);
}
add_action( 'add_meta_boxes', 'recensioni_add_custom_box' );


function recensioni_custom_box_html( $post ) {
?>

<?php
$nome_recensione = get_post_meta($post->ID, 'nome_recensione', true);
$cognome_recensione = get_post_meta($post->ID, 'cognome_recensione', true);
$email_recensione = get_post_meta($post->ID, 'email_recensione', true);
$valutazione_recensione = get_post_meta($post->ID, 'valutazione_recensione', true);
$corpo_recensione = get_post_meta($post->ID, 'corpo_recensione', true);
?>

<label>Nome:</label><br>
<input type="text" name="nome_recensione" value="<?php echo $nome_recensione; ?>" style="width:50%;"><br>

<label>Cognome:</label><br>
<input type="text" name="cognome_recensione" value="<?php echo $cognome_recensione; ?>" style="width:50%;"><br>

<label>Email:</label><br>
<input type="text" name="email_recensione" value="<?php echo $email_recensione; ?>" style="width:50%;"><br>

<label>Valutazione:</label><br>
<input type="number" name="valutazione_recensione" value="<?php echo $valutazione_recensione; ?>" style="width:5%;" min="1" max="5">/5<br>

<label>Contenuto:</label><br>
<textarea name="corpo_recensione" value="<?php echo $corpo_recensione; ?>" style="width:100%;" rows="5"><?php echo $corpo_recensione; ?></textarea><br>

<?php
}

function salva_recensioni_custom_box(){

global $post;

if(isset( $_POST["nome_recensione"] )){
	update_post_meta( $post->ID, 'nome_recensione', $_POST["nome_recensione"] );
}
if(isset( $_POST["cognome_recensione"] )){
	update_post_meta( $post->ID, 'cognome_recensione', $_POST["cognome_recensione"] );
}
if(isset( $_POST["email_recensione"] )){
	update_post_meta( $post->ID, 'email_recensione', $_POST["email_recensione"] );
}
if(isset( $_POST["valutazione_recensione"] )){
	update_post_meta( $post->ID, 'valutazione_recensione', $_POST["valutazione_recensione"] );
}
if(isset( $_POST["corpo_recensione"] )){
	update_post_meta( $post->ID, 'corpo_recensione', $_POST["corpo_recensione"] );
}

}

add_action('save_post', 'salva_recensioni_custom_box');

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
