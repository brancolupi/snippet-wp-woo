///////////////// Switch logic languages ///////////////

add_action( 'wp_loaded', 'kitoko_caricamento_lingua' );

function kitoko_caricamento_lingua(){

    global $woocommerce;

    if(!(is_user_logged_in() || is_admin())){

        if(isset(WC()->session) && ! WC()->session->has_session()){
           WC()->session->set_customer_session_cookie(true); 
        }

    }

    if(WC()->session){
    if(is_null(WC()->session->get("language"))){
            
        WC()->session->set("language", "it_IT");

    }else{

        switch(WC()->session->get("language")){
            case "it_IT":
            switch_to_locale("it_IT"); 
            break;
            case "en_US":
            switch_to_locale("en_US"); 
            break;
        }

    }
    }

}
