<?php
/*
 * Plugin Name:       ArpfCSV Auto recovery products from csv
 * Plugin URI:        https://cinquepuntozero.it
 * Description:       Recupero e caricamento di prodotti da csv
 * Version:           1.0.0
 * Author:            Lucio Asciolla - Full Stack Developer
 * Author URI:        https://cinquepuntozero.it
 * License:           GPL v2 or later
 * License URI:       HTTPS://WWW.GNU.ORG/LICENSES/GPL-2.0.HTML
 * Update URI:        HTTPS://EXAMPLE.COM/MY-PLUGIN/
 * Text Domain:       arpfcsv
 * Domain Path:       /languages
 */
?>

<?php

// Includi il file autoload.php
require_once ABSPATH . 'vendor/autoload.php';

// Funzione per aggiungere pagina alla dashboard
 
function aggiungi_pagina() {

    add_menu_page(
        'Recupero e caricamento di prodotti da csv',
        'Arpf-CSV',
        'manage_options',
        'arpf-csv',
        'custom_plugin_page'
    );

    // Aggiungi la voce di sottomenu
    // add_submenu_page(
	// 'arpf-csv',    // Slug del menu principale
	// 'Impostazioni',      // Titolo della pagina del sottomenu
	// 'Impostazioni',      // Titolo del sottomenu
	// 'manage_options',    // Capacità richiesta
	// 'impostazioni-arpf-csv', // Slug del sottomenu
	// 'custom_submenu_page' // Funzione per visualizzare il contenuto del sottomenu   
    // );
}

add_action( 'admin_menu', 'aggiungi_pagina' );
 
// Funzione per caricare la pagina
 
function custom_plugin_page() {
    require_once dirname( __FILE__ ) . "/adminpages/run.php";
}

// Funzione per visualizzare il contenuto della pagina del sottomenu

// function custom_submenu_page() {
//     require_once dirname( __FILE__ ) . "/adminpages/settings.php";
// }

?>