<?php

///////////////// Create user's roles ///////////////

add_role( 'Risorsa', 'risorsa_capability', array('read'=> true) );

function custom_hide_admin_bar() {
    // Verifica il ruolo dell'utente attuale
    if ( current_user_can('risorsa_capability') ) {
        // Nascondi la barra di amministrazione per gli utenti con il ruolo "Subscriber"
        show_admin_bar(false);
    }
}
add_action('after_setup_theme', 'custom_hide_admin_bar');



?>
