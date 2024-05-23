<?php

add_role( 'Rivenditori', 'capabilities _rivenditori', array('read'=> true) );
add_role( 'Pending', 'capabilities_pending', array('read'=> true) );

function custom_hide_admin_bar() {
// Verifica il ruolo dell'utente attuale
    if ( current_user_can('capabilities _rivenditori') || current_user_can('capabilities_pending') ) {
    	// Nascondi la barra di amministrazione per gli utenti con le indicate "possibilità"
        show_admin_bar(false);
     }
}

add_action('after_setup_theme', 'custom_hide_admin_bar');


function custom_login_redirect( $redirect_to, $request, $user ) {
	//is there a user to check?
	if ( isset( $user->roles ) && is_array( $user->roles ) ) {
		//check for admins
		if ( in_array( 'Pending', $user->roles ) ) {
			// redirect them to the default place
			return '/logout';
		} else {
			return '/il-tuo-account';
		}
	} else {
		return '/logout';
	}
}

add_filter( 'login_redirect', 'custom_login_redirect', 10, 3 );

?>