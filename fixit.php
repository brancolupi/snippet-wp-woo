<?php

////////////////////////// Fix "Missing a Temporary Folder" Error //////////////////////////

// wp-confing.php
define('WP_TEMP_DIR', dirname(__FILE__) . '/wp-content/temp/');

// Creare la directory /wp-content/temp/
// Modificare i permessi in "775" della directory /wp-content
// Potrebbe essere necessario effettuare un refesh della versione PHP

?>

