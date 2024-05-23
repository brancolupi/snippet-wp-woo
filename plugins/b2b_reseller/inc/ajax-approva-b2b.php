<?php

define('WP_USE_THEMES', false);
require_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

global $woocommerce;
global $wordpress;

$id_utente_b2b = $_GET['id_utente_b2b'];

if( isset($_GET['id_utente_b2b']) && !isset($_POST['sdi_rivenditore']) ){

    $utente_b2b = get_user_by( 'ID', $id_utente_b2b );
    $utente_b2b->remove_role( 'Pending' );
    $utente_b2b->add_role( 'Rivenditori' );

    $to = get_user_meta($id_utente_b2b, 'billing_email', true);
    $subject = 'HELU\' il tuo account B2B è stato abilitato.';
   
 
    $message = <<<HTML
       Il tuo account rivenditore è stato abilitato.
       Puoi ora accedere al sito e visulaizzare il listino riservato.
    HTML;
    
    $headers = array(
            'From' => 'no-reply@helushop.com',
            'Reply-To' => 'no-reply@stampasoluzioni.it',
            'X-Mailer' => 'X-Mailer: PHP v' . phpversion()    
    );
    
        
    wp_mail($to, $subject, $message, $headers);

    echo 'Elaborazione in corso..';

}

if( isset($_POST['sdi_rivenditore']) && !isset($_GET['id_utente_b2b']) ){


$userdata = array(
	'ID' 					=> '', 	//(int) User ID. If supplied, the user will be updated.
	'user_pass'				=> $_POST['password_rivenditore'], 	//(string) The plain-text user password.
	'user_login' 			=> $_POST['email_rivenditore'], 	//(string) The user's login username.
	'user_nicename' 		=> '', 	//(string) The URL-friendly user name.
	'user_url' 				=> '', 	//(string) The user URL.
	'user_email' 			=> $_POST['email_rivenditore'], 	//(string) The user email address.
	'display_name' 			=> $_POST['nome_rivenditore'] . ' ' . $_POST['cognome_rivenditore'], 	//(string) The user's display name. Default is the user's username.
	'nickname' 				=> '', 	//(string) The user's nickname. Default is the user's username.
	'first_name' 			=> $_POST['nome_rivenditore'], 	//(string) The user's first name. For new users, will be used to build the first part of the user's display name if $display_name is not specified.
	'last_name' 			=> $_POST['cognome_rivenditore'], 	//(string) The user's last name. For new users, will be used to build the second part of the user's display name if $display_name is not specified.
	'description' 			=> '', 	//(string) The user's biographical description.
	'rich_editing' 			=> 'false', 	//(string|bool) Whether to enable the rich-editor for the user. False if not empty.
	'syntax_highlighting' 	=> 'false', 	//(string|bool) Whether to enable the rich code editor for the user. False if not empty.
	'comment_shortcuts' 	=> 'false', 	//(string|bool) Whether to enable comment moderation keyboard shortcuts for the user. Default false.
	'admin_color' 			=> '', 	//(string) Admin color scheme for the user. Default 'fresh'.
	'use_ssl' 				=> 'false', 	//(bool) Whether the user should always access the admin over https. Default false.
	'user_registered' 		=> '', 	//(string) Date the user registered. Format is 'Y-m-d H:i:s'.
	'show_admin_bar_front' 	=> 'false', 	//(string|bool) Whether to display the Admin Bar for the user on the site's front end. Default true.
	'role' 					=> 'Pending', 	//(string) User's role.
	'locale' 				=> '', 	//(string) User's locale. Default empty.

);

$user_id_created = wp_insert_user($userdata);

if(!is_wp_error($user_id_created)){

add_user_meta( $user_id_created, 'billing_first_name', $_POST['nome_rivenditore'] );
add_user_meta( $user_id_created, 'billing_last_name', $_POST['cognome_rivenditore'] );
add_user_meta( $user_id_created, 'billing_company', $_POST['ragione_sociale_rivenditore'] );
add_user_meta( $user_id_created, 'billing_address_1', $_POST['via_e_numero_rivenditore'] );
add_user_meta( $user_id_created, 'billing_address_2', '' );
add_user_meta( $user_id_created, 'billing_city', $_POST['citta_rivenditore'] );
add_user_meta( $user_id_created, 'billing_state', $_POST['provincia_rivenditore'] );
add_user_meta( $user_id_created, 'billing_postcode', $_POST['cap_rivenditore'] );
add_user_meta( $user_id_created, 'billing_country', $_POST['nazione_rivenditore'] );
add_user_meta( $user_id_created, 'billing_email', $_POST['email_rivenditore'] );
add_user_meta( $user_id_created, 'billing_phone', $_POST['telefono_rivenditore'] );

add_user_meta( $user_id_created, 'p_iva_rivenditore', $_POST['p_iva_rivenditore'] );
add_user_meta( $user_id_created, 'codice_fiscale_rivenditore', $_POST['codice_fiscale_rivenditore'] );
add_user_meta( $user_id_created, 'sdi_rivenditore', $_POST['sdi_rivenditore'] );

add_user_meta( $user_id_created, 'shipping_first_name', $_POST['nome_rivenditore'] );
add_user_meta( $user_id_created, 'shipping_last_name', $_POST['cognome_rivenditore'] );
add_user_meta( $user_id_created, 'shipping_company', $_POST['ragione_sociale_rivenditore'] );
add_user_meta( $user_id_created, 'shipping_address_1', $_POST['via_e_numero_rivenditore'] );
add_user_meta( $user_id_created, 'shipping_address_2', '' );
add_user_meta( $user_id_created, 'shipping_city', $_POST['citta_rivenditore'] );
add_user_meta( $user_id_created, 'shipping_state', $_POST['provincia_rivenditore'] );
add_user_meta( $user_id_created, 'shipping_postcode', $_POST['cap_rivenditore'] );
add_user_meta( $user_id_created, 'shipping_country', $_POST['nazione_rivenditore'] );
add_user_meta( $user_id_created, 'shipping_phone', $_POST['telefono_rivenditore'] );

add_user_meta( $user_id_created, 'user_login', $_POST['email_rivenditore'] );
add_user_meta( $user_id_created, 'user_pass', password_hash($_POST['password_rivenditore'], PASSWORD_DEFAULT) );
add_user_meta( $user_id_created, 'user_id', $user_id_created );

$to = 'info@helushop.com';
$subject = 'HELU\' Un utente B2B attende l\'approvazione per accedere';


$message = <<<HTML
   Un nuovo utente B2B si è registrato ed attenda la conferma per accedere al sito.
   Clicca sul link sottostante
   https://helushop.com/wp-admin/admin.php?page=manager-b2b
HTML;

$headers = array(
        'From' => 'no-reply@helushop.com',
        'Reply-To' => 'no-reply@stampasoluzioni.it',
        'X-Mailer' => 'X-Mailer: PHP v' . phpversion()    
);

    
wp_mail($to, $subject, $message, $headers);


echo '✓ Perfetto, attendi la mail di approvazione da parte dello staff di HELU\'';

}else{

echo '⚠ Si è verificato un errore.<br>Controlla di aver compilato correttamente tutti i campi e riprova.';

}

}


?>