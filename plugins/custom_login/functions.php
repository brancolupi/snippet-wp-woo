<?php

/////////////////////////////////////////// START CUSTOM LOGIN USERS ////////////////////////////////////////


// REDIRECTION "login_redirect" se il processo di login è superato con successo

// function custom_login_redirect() {
// return '/il-tuo-account';
// }

// add_filter('login_redirect', 'custom_login_redirect');


function custom_login_redirect( $redirect_to, $request, $user ) {
	//is there a user to check?
	if ( isset( $user->roles ) && is_array( $user->roles ) ) {
		//check for admins
		if ( in_array( 'Pending', $user->roles ) ) {
			// redirect them to the default place
			return '/logout';
		} else {
			return '/il-tuo-account';
		}
	} else {
		return '/logout';
	}
}

add_filter( 'login_redirect', 'custom_login_redirect', 10, 3 );


      
// REDIRECTION override del redirezzamenti standard di worpdress
      
function redirect_login_page() {
	
   $login_url  = home_url( '/effettua-login');
   $url = basename($_SERVER['REQUEST_URI']); // get requested URL
	
   isset( $_REQUEST['redirect_to'] ) ? ( $url   = "wp-login.php" ): 0; // if users ssend request to wp-admin
   if( $url  == "wp-login.php" && $_SERVER['REQUEST_METHOD'] == 'GET')  {
		  wp_redirect( $login_url );
		  exit;
   }
}

add_action('init','redirect_login_page');
     
// REDIRECTION "wp_login_failed" se il processo di login fallisce

function login_failed() {
   $login_page  = home_url( '/effettua-login');
   wp_redirect( $login_page . '?login=failed' );
   exit;
}

add_action( 'wp_login_failed', 'login_failed' );
     
     
// REDIRECTION "authenticate" se il processo di login fallisce per dati mancanti
       
function verify_username_password( $user, $username, $password ) {
   $login_page  = home_url( '/effettua-login');
   if( $username == "" || $password == "" ) {
       wp_redirect( $login_page . "?login=empty" );
       exit;
   }
}

add_filter( 'authenticate', 'verify_username_password', 1, 3);
     
// REDIRECTION "wp_logout" se si effettua il logout
     
function logout_page() {
    $login_page  = home_url( '/effettua-login');
    wp_redirect( $login_page . "?login=false" );
    exit;
}

add_action('wp_logout','logout_page');

/////////////////////////////////////////// END CUSTOM LOGIN USERS ////////////////////////////////////////

?>