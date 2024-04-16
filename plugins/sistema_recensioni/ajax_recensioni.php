<?php

define('WP_USE_THEMES', false);
require_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

global $wordpress;
	
$nome_recensione = $_POST['nome_recensione'];
$cognome_recensione = $_POST['cognome_recensione'];
$email_recensione = $_POST['email_recensione'];
$valutazione_recensione = $_POST['valutazione_recensione'];
$corpo_recensione = $_POST['corpo_recensione'];


if( isset($_POST['nome_recensione']) && isset($_POST['cognome_recensione']) && isset($_POST['email_recensione']) && isset($_POST['valutazione_recensione']) && isset($_POST['corpo_recensione']) ){

$args = array(
'post_title'    =>  $valutazione_recensione . '/5 - ' . $cognome_recensione . ' ' . $nome_recensione . '  Email: ' . $email_recensione,
'post_type'     => 'recensioni',
'post_status'   => 'publish',
'post_author'   => 1,
);

$post_id = wp_insert_post( $args );
	
add_post_meta( $post_id, 'nome_recensione', $nome_recensione );
add_post_meta( $post_id, 'cognome_recensione', $cognome_recensione );
add_post_meta( $post_id, 'email_recensione', $email_recensione );
add_post_meta( $post_id, 'valutazione_recensione', $valutazione_recensione );
add_post_meta( $post_id, 'corpo_recensione', $corpo_recensione );


echo 'Ti ringraziamo, la tua recensione è stata inviata correttamente.';


}




