<?php

/**
* AGGIUNGI CAMPI PERSONALIZZATI (DELL'ORDINE) ALLE EMAIL
*/

add_filter( 'woocommerce_email_order_meta_fields', 'custom_woocommerce_email_order_meta_fields', 10, 3 );

function custom_woocommerce_email_order_meta_fields( $fields, $sent_to_admin, $order ) {
   
			$fields['partita_iva'] = array(
			'label' => __( 'Partita IVA:' ),
			'value' => get_post_meta($order->id, 'Partita IVA', true ),
			);
			
			$fields['codice_sdi'] = array(
			'label' => __( 'SDI:' ),
			'value' => get_post_meta($order->id, 'SDI', true ),
			);
			
			$fields['codice_fiscale'] = array(
			'label' => __( 'Codice fiscale:' ),
			'value' => get_post_meta( $order->id, 'Codice fiscale', true ),
			);
			
			$fields['indirizzo_pec'] = array(
			'label' => __( 'Indirizzo PEC:' ),
			'value' => get_post_meta($order->id, 'Indirizzo PEC', true ),
			);
	
    return $fields;
}

?>
