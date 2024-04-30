<?php 

define("WP_USE_THEMES", false);
require_once($_SERVER["DOCUMENT_ROOT"]."/wp-load.php");

global $woocommerce;
global $wordpress;

if( isset($_POST["language"]) ){

    WC()->session->set("language", $_POST["language"]);
    echo "Lingua impostata";

}

?>