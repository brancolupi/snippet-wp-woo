<?php

////////////////////////// Fix "Missing a Temporary Folder" Error //////////////////////////

// wp-confing.php
define('WP_TEMP_DIR', dirname(__FILE__) . '/wp-content/temp/');

// Creare la directory /wp-content/temp/
// Modificare i permessi in "775" della directory /wp-content
// Potrebbe essere necessario effettuare un refesh della versione PHP

////////////////////////// Aggiungere funzionalità wordpress a file (es. ajax) *.php esterno //////////////////////////

define('WP_USE_THEMES', false);
require_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

global $woocommerce;
global $wordpress;

////////////////////////// Upgrade maximum upload size //////////////////////////
// Link utile: https://kinsta.com/blog/increase-max-upload-size-wordpress/

// functions.php
ini_set( 'upload_max_size' , '256M' );
ini_set( 'post_max_size', '256M');
ini_set( 'max_execution_time', '300' );

// .htaccess
// php_value upload_max_filesize 32M
// php_value post_max_size 64M
// php_value memory_limit 128M
// php_value max_execution_time 300
// php_value max_input_time 300

// Aggiungere le seguenti lineee nel codice del file
// Nota: potresti ricevere un errore 500 Internal Server Error dopo aver utilizzato il metodo sopra. 
// Molto probabilmente è perché il tuo server esegue PHP in modalità CGI . 
// In questi casi, non puoi utilizzare i comandi precedenti nel tuo file .htaccess

// php.ini
// Il file php.ini è dove definisci le modifiche alle impostazioni PHP predefinite.  Il file dovrebbe trovarsi nella directory principale di WordPress.
// Se non dovesse essere presente possiamo creare un nuovo file con lo stesso nome nella directory principale.

// upload_max_filesize = 32M
// post_max_size = 64M
// memory_limit = 128M

// .user.ini
// Se il tuo provider di hosting ha bloccato le impostazioni globali di PHP, potrebbe aver configurato il server per funzionare con i file .user.ini anziché con i file php.ini
// Il procedimento è il medesimo del file php.ini






?>

