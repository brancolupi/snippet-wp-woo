<?php 

/////////// START Abilitare BOOTSTAP CSS Framework  C/CDN nella font-end e nel backend ///////////////
function abilita_bootstrap_css_framework() {
    wp_enqueue_style( 'bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' );
}

add_action('wp_enqueue_scripts', 'abilita_bootstrap_css_framework'); // Front-end
add_action('admin_enqueue_scripts', 'abilita_bootstrap_css_framework'); // Back-end
   
/////////// START Abilitare BOOTSTAP CSS Framework  C/CDN nella font-end e nel backend ///////////////

?>
