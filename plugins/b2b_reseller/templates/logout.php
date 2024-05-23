<?php

/** 
* Template Name: Custom Logout
* 
*/
	$user_id = get_current_user_id();

	wp_destroy_current_session();
	wp_clear_auth_cookie();
	wp_set_current_user( 0 );

	$redirect_url = site_url();
    wp_safe_redirect( $redirect_url );

?>