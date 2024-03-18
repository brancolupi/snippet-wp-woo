///////////////////////////////////////// START ADD BOOTSTRAP TO ADMIN DESIGN ////////////////////////////////////////

<?php 
function wpbootstrap_enqueue_styles() {
wp_enqueue_style( 'bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' );
}
add_action('wp_enqueue_scripts', 'wpbootstrap_enqueue_styles');
add_action('admin_enqueue_scripts', 'wpbootstrap_enqueue_styles');

///////////////////////////////////////// END ADD BOOTSTRAP TO ADMIN DESIGN ////////////////////////////////////////

///////////////////////////////////////// START ADD CUSTOM STYLE TO ADMIN DESIGN ////////////////////////////////////////


function wpcustom_admin_enqueue_styles() { 
    wp_enqueue_style( 'custom-style-admin', '/wp-content/themes/nikolaos/assets/css/custom-admin.css' ); 
    }
    add_action('admin_enqueue_scripts', 'wpcustom_admin_enqueue_styles');
    
?>
///////////////////////////////////////// END ADD CUSTOM STYLE TO ADMIN DESIGN ////////////////////////////////////////
