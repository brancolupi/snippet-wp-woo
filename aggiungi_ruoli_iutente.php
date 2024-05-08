<?php 

///////////////// Create user's roles ///////////////
// https://developer.wordpress.org/reference/functions/add_role/
// https://developer.wordpress.org/reference/functions/current_user_can/

add_role( 'Rivenditore', 'rivenditore_capability', array('read'=> true) );

function custom_hide_admin_bar() {
    // Verifica il ruolo dell'utente attuale
    if ( current_user_can('rivenditore_capability') ) {
        // Nascondi la barra di amministrazione per gli utenti con il ruolo "Subscriber"
        show_admin_bar(false);
    }
}

add_action('after_setup_theme', 'custom_hide_admin_bar');

?>
