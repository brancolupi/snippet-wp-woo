////////////////////////// START REMOVE PARENT THEME STYLE & ADD CUTOM THEME STYLE /////////////////////////////////
<?php

function my_theme_enqueue_styles(){

    wp_dequeue_style( 'twentynineteen-style' );
    wp_deregister_style( 'twentynineteen-style' );
    wp_dequeue_style( 'twentynineteen-print-style' );
    wp_deregister_style( 'twentynineteen-print-style' );

    wp_enqueue_style( 'custom-style', '/wp-content/themes/nikolaos/assets/css/custom.css' );
}

add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

?>

//////////////////////////// END REMOVE PARENT THEME STYLE & ADD CUTOM THEME STYLE /////////////////////////////////
