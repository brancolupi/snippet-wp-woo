<?php

/////////////////////////////////////////// START CUSTOM UPDATE CART ////////////////////////////////////////

function custom_aggiorna_carrello(){
    
    global $woocommerce;

    $riduzione_prezzo = WC()->session->get( 'riduzione_prezzo');
    $confezione_regalo = WC()->session->get( 'confezione_regalo');


    $nuovo_totale = (WC()->cart->total) - $riduzione_prezzo;
    $nuovo_subtotale = (WC()->cart->total) - $riduzione_prezzo;

    if($confezione_regalo>0){
        $nuovo_totale =  $nuovo_totale + $confezione_regalo;
        $nuovo_subtotale = $nuovo_subtotale + $confezione_regalo;
    }

    WC()->cart->add_fee('Confezione regalo', $confezione_regalo, true, '' );
    WC()->cart->add_fee('Sconto con punti ricciolo', $riduzione_prezzo, true, '' );

    WC()->cart->set_total($nuovo_totale);
    // WC()->cart->set_subtotal($nuovo_subtotale);

    WC()->session->set('cart_totals', array( 'total' => $nuovo_totale, 'subtotal' => $nuovo_subtotale, ));

}

add_action('woocommerce_before_cart_totals', 'custom_aggiorna_carrello', 30);
add_action('woocommerce_after_calculate_totals', 'custom_aggiorna_carrello', 30);
add_action('woocommerce_review_order_before_order_total', 'custom_aggiorna_carrello', 30);
add_action('woocommerce_review_order_before_payment', 'custom_aggiorna_carrello', 30);
add_action('woocommerce_cart_calculate_fees', 'custom_aggiorna_carrello', 30);




/////////////////////////////////////////// END CUSTOM UPDATE CART ////////////////////////////////////////

?>
