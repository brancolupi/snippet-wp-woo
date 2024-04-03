<?php

/** AGGIUNGERE CAMPI AL CHECKOUT
* Aggiunta campi personalizzati alla pagina di checkout
* Hooks:
* woocommerce_after_checkout_billing_form
* woocommerce_after_order_notes
*/

add_action('woocommerce_after_checkout_billing_form', 'aggiungi_custom_checkout_field');

function aggiungi_custom_checkout_field($checkout){ 
    
    echo '<section style="margin:8% 0%;">';	
    echo '<div id="custom_id_field"><h2>' . __('') . '</h2>';
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////// TEXT INPUT EXEMPLE //////////////////////////////////////////////////////////////////////////////
      
    woocommerce_form_field('custom_field_name_p_iva', array(
    'type' => 'text',
    'maxlength' => 11,
    'class' => array(
    'my-field-class'
    ),
    'label' => __('Partita IVA') ,
    'placeholder' => __('Inserisci la tua partita iva') ,
    ),
    $checkout->get_value('custom_field_name_p_iva'));
    
    woocommerce_form_field('custom_field_name_codice_fiscale', array(
    'type' => 'text',
    'maxlength' => 16,
    'class' => array(
    'my-field-class'
    ),
    'label' => __('Codice fiscale') ,
    'placeholder' => __('Inserisci il tuo codice fiscale') ,
    ),
    $checkout->get_value('custom_field_name_codice_fiscale'));
    
    ////////////////////////////////////////////////////////////////////////////// SELECT INPUT //////////////////////////////////////////////////////////////////////////////
      
    woocommerce_form_field( 'custom_field_its_gift', array(
        'type'          => 'select',
        'class'         => array(''),
        'label'         => __('Si tratta di ua regalo? In tal caso non invieremo la distina con i prezzi'),
        'required'    => false,
        'options'     => array(
                          'Y' => __('Si'),
                          'N' => __('No')
        ),
        'default' => 'N'), 
        $checkout->get_value( 'custom_field_its_gift' )
    );	
    
    woocommerce_form_field( 'custom_field_alert_tel', array(
        'type'          => 'select',
        'class'         => array(''),
        'label'         => __('Richiedi preavviso telefonico gratuito'),
        'required'    => false,
        'options'     => array(
                          'Y' => __('Si'),
                          'N' => __('No')
        ),
        'default' => 'N'), 
        $checkout->get_value( 'custom_field_alert_tel' )
    );	
    		
    	
    ////////////////////////////////////////////////////////////////////////////// TEXTAREA INPUT EXEMPLE //////////////////////////////////////////////////////////////////////////////
      
    woocommerce_form_field('custom_field_name_nota_spedizione', array(
    'type' => 'textarea',
    'maxlength' => 140,
    'class' => array(
    'my-field-class'
    ),
    'label' => __('Aggiungi nota sulla spezione'),
    'placeholder' => __('Qui può scrivere delle note sulla spedizione.') ,
    ),
    $checkout->get_value('custom_field_name_nota_spedizione'));	
    
    ////////////////////////////////////////////////////////////////////////////// CHECKBOX INPUT EXEMPLE //////////////////////////////////////////////////////////////////////////////
    
    woocommerce_form_field( 'custom_field_alert_tel', array( 
    'type' => 'checkbox', 
    'class' => array('input-checkbox'), 
    'label' => __('Richiedi preavviso telefonico gratuito'), 
    'required' => false, 
    'value'  => true, 
    ), $checkout->get_value( 'custom_field_alert_tel' ));	
    	
    woocommerce_form_field( 'custom_field_its_gift', array( 
    'type' => 'checkbox', 
    'class' => array('input-checkbox'), 
    'label' => __('Si tratta di un regalo? In tal caso non invieremo la distina con i prezzi'), 
    'required' => false, 
    'value'  => true, 
    ), $checkout->get_value( 'custom_field_its_gift' ));
    
    woocommerce_form_field( 'custom_field_floor_shipping', array( 
    'type' => 'checkbox', 
    'class' => array('input-checkbox'), 
    'label' => __('Aggiungi consegna al piano (+15,00€)'), 
    'required' => false, 
    'value'  => true, 
    ), $checkout->get_value( 'custom_field_floor_shipping' ));	
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    echo '</section>';		
    echo '</div>';

}


/**
* PROCESSO VALIDAZIONE NEL CHECKOUT
*/
add_action('woocommerce_checkout_process', 'custom_checkout_field_processo_validazione');
function custom_checkout_field_processo_validazione(){
  // Mostra messaggio di errore se il campo non è stato definito.
  if (!$_POST['custom_field_name_p_iva']) wc_add_notice(__('Devi compilare il campo "Partita IVA".') , 'error');
  if (!$_POST['custom_field_name_codice_fiscale']) wc_add_notice(__('Devi compilare il campo "Codice Fiscale".') , 'error');	
  if (!$_POST['custom_field_name_indirizzo_pec']) wc_add_notice(__('Devi compilare il campo "indirizzo PEC".') , 'error');	
  if (!$_POST['custom_field_name_SDI']) wc_add_notice(__('Devi compilare il campo "SDI".') , 'error');	
}

/**
* AGGIORNAMENTO DEI VALORI DEI CAMPI CUSTOM
*/

add_action('woocommerce_checkout_update_order_meta', 'custom_checkout_field_aggiornamento_order_meta');

function custom_checkout_field_aggiornamento_order_meta($order_id){
    if (!empty($_POST['custom_field_name_p_iva'])){
    update_post_meta($order_id, 'Partita IVA', sanitize_text_field($_POST['custom_field_name_p_iva']));
    }
    if (!empty($_POST['custom_field_name_codice_fiscale'])){
    update_post_meta($order_id, 'Codice fiscale', sanitize_text_field($_POST['custom_field_name_codice_fiscale']));
    }
    if (!empty($_POST['custom_field_name_indirizzo_pec'])){
    update_post_meta($order_id, 'Indirizzo PEC', sanitize_text_field($_POST['custom_field_name_indirizzo_pec']));
    }
    if (!empty($_POST['custom_field_name_SDI'])){
    update_post_meta($order_id, 'SDI', sanitize_text_field($_POST['custom_field_name_SDI']));
    }
    if (!empty($_POST['custom_field_name_nota_spedizione'])){
    update_post_meta($order_id, 'Note spedizione', sanitize_text_field($_POST['custom_field_name_nota_spedizione']));
    }	
    	
    if (!empty($_POST['custom_field_its_gift'])){
    update_post_meta($order_id, 'Ordine regalo', sanitize_text_field($_POST['custom_field_its_gift']));
    }	
    
    if (!empty($_POST['custom_field_alert_tel'])){
    update_post_meta($order_id, 'Preavviso telefonico', sanitize_text_field($_POST['custom_field_alert_tel']));
    }		
    	
    if (!empty($_POST['custom_field_floor_shipping'])){
    update_post_meta($order_id, 'Spedizione al piano', sanitize_text_field($_POST['custom_field_floor_shipping']));
    }			
}

/**
* MOSTRARE CAMPI NELLA PAGINA ADMIN DELL'ORDINE
*/
add_action( 'woocommerce_admin_order_data_after_billing_address', 'custom_checkout_field_display_admin_order', 10, 1 );

function custom_checkout_field_display_admin_order($order){

    $peavviso = get_post_meta( $order->id, 'Preavviso telefonico', true );
    $preavviso_result = ($peavviso == 1) ? 'Si' : 'No';
    $regalo = get_post_meta( $order->id, 'Ordine regalo', true );
    $regalo_result = ($regalo == 1) ? 'Si' : 'No';
    	
    echo '<p style="margin: 9px 0 0;"><label><strong>'.__('Ordine regalo').':</strong></label> ' . $regalo_result . '</p>';
    echo '<p style="margin: 9px 0 0;"><label><strong>'.__('Preavviso telefonico').':</strong></label> ' . $preavviso_result . '</p>';	
    echo '<p style="margin: 9px 0 0;"><label><strong>'.__('Partita IVA').':</strong></label> ' . get_post_meta( $order->id, 'Partita IVA', true ) . '</p>';
    echo '<p style="margin: 9px 0 0;"><label><strong>'.__('Codice fiscale').':</strong></label> ' . get_post_meta( $order->id, 'Codice fiscale', true ) . '</p>';
    echo '<p style="margin: 9px 0 0;"><label><strong>'.__('Idirizzo PEC').':</strong></label> ' . get_post_meta( $order->id, 'Indirizzo PEC', true ) . '</p>';
    echo '<p style="margin: 9px 0 0;"><label><strong>'.__('SDI').':</strong></label> ' . get_post_meta( $order->id, 'SDI', true ) . '</p>';
    echo '<p style="margin: 9px 0 0;"><label><strong>'.__('Note: spedizione').':</strong></label> ' . get_post_meta( $order->id, 'Note spedizione', true ) . '</p>';
  
}


/**
* RIORDINARE I CAMPI NEL CHECKOUT
*/

add_filter("woocommerce_checkout_fields", "custom_override_checkout_fields");

function custom_override_checkout_fields($fields) {
	
$order = array(
'custom_field_its_gift',
'billing_first_name',
'billing_last_name',
'billing_company',
'custom_field_name_p_iva',
'custom_field_name_codice_fiscale',
'custom_field_name_SDI',
'billing_country',
'billing_address_1',
'billing_address_2',
'billing_postcode',
'billing_city',	
'billing_state',	
'billing_phone',	
'billing_email',	
'custom_field_name_nota_ordine',	
'custom_field_name_nota_spedizione',
);
	
foreach($order as $field){
    $ordered_fields[$field] = $fields['billing'][$field];
    }
    
    $fields['billing'] = $ordered_fields;
    	
    $fields['billing']['custom_field_its_gift']['priority'] = 10;	
    $fields['billing']['billing_first_name']['priority'] = 20;	
    $fields['billing']['billing_last_name']['priority'] = 30;	
    $fields['billing']['billing_company']['priority'] = 40;
    $fields['billing']['custom_field_name_p_iva']['priority'] = 50;
    $fields['billing']['custom_field_name_codice_fiscale']['priority'] = 60;
    $fields['billing']['custom_field_name_SDI']['priority'] = 70;	
    $fields['billing']['billing_country']['priority'] = 80;
    $fields['billing']['billing_address_1']['priority'] = 90;
    $fields['billing']['billing_address_2']['priority'] = 100;
    $fields['billing']['billing_postcode']['priority'] = 110;
    $fields['billing']['billing_city']['priority'] = 120;
    $fields['billing']['billing_state']['priority'] = 130;
    $fields['billing']['billing_phone']['priority'] = 140;
    $fields['billing']['billing_email']['priority'] = 150;
    $fields['billing']['custom_field_name_nota_ordine']['priority'] = 160;
    $fields['billing']['custom_field_name_nota_spedizione']['priority'] = 170;
    	
    return $fields;
  }


/**
* MODIFICA DEGLI ATTRIBUTI DEI CAMPI NEL CHECKOUT
* MAXLENGTH EXEMPLE
*/

add_filter( 'woocommerce_checkout_fields', 'checkout_fields_custom_attributes', 9999 );
 
function checkout_fields_custom_attributes( $fields ) {
   	$fields['billing']['billing_first_name']['maxlength'] = 40;
	$fields['billing']['billing_last_name']['maxlength'] = 40;
	$fields['billing']['billing_company']['maxlength'] = 40;
	$fields['billing']['billing_address_1']['maxlength'] = 40;
	$fields['billing']['billing_address_2']['maxlength'] = 40;
	$fields['billing']['billing_postcode']['maxlength'] = 15;
	$fields['billing']['billing_city']['maxlength'] = 40;
	$fields['billing']['billing_phone']['maxlength'] = 40;
	$fields['billing']['billing_email']['maxlength'] = 40;
	$fields['shipping']['shipping_first_name']['maxlength'] = 40;
	$fields['shipping']['shipping_last_name']['maxlength'] = 40;
	$fields['shipping']['shipping_company']['maxlength'] = 40;
	$fields['shipping']['shipping_address_1']['maxlength'] = 40;
	$fields['shipping']['shipping_address_2']['maxlength'] = 40;
	$fields['shipping']['shipping_postcode']['maxlength'] = 15;
	$fields['shipping']['shipping_city']['maxlength'] = 40;
   return $fields;
}





?>
