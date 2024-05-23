<?php
/*
 * Plugin Name:       Sistema di approvazione rivenditori dell'ecommerce
 * Plugin URI:        HTTPS://CINQUEPUNTOZERO.IT
 * Description:       Campi aggiuntivi per i prodotti dell'ecommerce
 * Version:           1.0.0
 * Author:            Lucio Asciolla Full Stack Web Developer
 * Author URI:         HTTPS://CINQUEPUNTOZERO.IT
 * License:           GPL v2 or later
 * License URI:       HTTPS://WWW.GNU.ORG/LICENSES/GPL-2.0.HTML
 * Update URI:        HTTPS://EXAMPLE.COM/MY-PLUGIN/
 * Text Domain:       custom-plugin
 * Domain Path:       /languages
 */
?>

<?php
//  Funzione per aggiungere pagina alla dashboard
 
function aggiungi_pagina() {
    add_menu_page(
        'Gestione approvazione utenti B2B',
        'Richieste B2B',
        'manage_options',
        'manager-b2b',
        'custom_plugin_page'
    );
}
add_action( 'admin_menu', 'aggiungi_pagina' );
 
// Funzione per caricare la pagina
 
function custom_plugin_page() {
    require_once dirname( __FILE__ ) . "/adminpages/settings.php";
}

?>