<?php

////////////////////////// START REMOVE PARENT THEME STYLE & ADD CUTOM THEME STYLE /////////////////////////////////

function dequeue_parent_style_AND_enqueue_custom_style(){

    wp_dequeue_style( 'twentynineteen-style' );
    wp_deregister_style( 'twentynineteen-style' );
    wp_dequeue_style( 'twentynineteen-print-style' );
    wp_deregister_style( 'twentynineteen-print-style' );

    wp_enqueue_style( 'custom-style', '/wp-content/themes/nikolaos/assets/css/custom.css' );
}

add_action( 'wp_enqueue_scripts', 'dequeue_parent_style_AND_enqueue_custom_style' );

//////////////////////////// END REMOVE PARENT THEME STYLE & ADD CUTOM THEME STYLE /////////////////////////////////

?>
