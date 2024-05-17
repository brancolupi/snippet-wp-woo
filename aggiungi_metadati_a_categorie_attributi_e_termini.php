<?php

////////////////////////////////////////////////////////////////////////// categorie //////////////////////////////////////////////////////////////////////////


add_action( 'init', 'aggiungi_meta_box_traduzione_categoria' );

function aggiungi_meta_box_traduzione_categoria() {

    add_action( 'product_cat_add_form_fields', 'campo_meta_box_traduzione_categoria' );
    add_action( 'product_cat_edit_form_fields', 'campo_meta_box_traduzione_categoria' );

}

function campo_meta_box_traduzione_categoria( $term ) {

    global $woocommerce;
    global $wordpress;

    $term_id = isset( $term->term_id ) ? $term->term_id : $_GET['tag_ID'];
    $__eng_nome_categoria = get_term_meta( $term_id, '__eng_nome_categoria', true );

    ?>

    <div>
        <label><img src="/wp-content/uploads/2024/05/uk.png" style="width:4%;">&nbsp;Traduzione Inglese</label>
        <input type="text" name="__eng_nome_categoria" value="<?php echo $__eng_nome_categoria; ?>">
        <p>Inserisci la traduzione della categoria in inglese</p>
    </div>
    
    <?php
}

// Salva il valore del campo metadato tradotto

add_action( 'create_product_cat', 'salva_meta_box_traduzione_categoria', 10, 2 );
add_action( 'edited_product_cat', 'salva_meta_box_traduzione_categoria', 10, 2 );

function salva_meta_box_traduzione_categoria( $term_id, $tt_id ) {

    global $woocommerce;
    global $wordpress;

    // $term_id = isset( $term->term_id ) ? $term->term_id : $_GET['tag_ID'];
    
    if( isset( $_POST['__eng_nome_categoria'] ) ){
        update_term_meta( $term_id, '__eng_nome_categoria', $_POST['__eng_nome_categoria'] );
    }
}

////////////////////////////////////////////////////////////////////////// attributi //////////////////////////////////////////////////////////////////////////

add_action( 'init', 'aggiungi_meta_box_traduzione_attributi' );

function aggiungi_meta_box_traduzione_attributi() {

add_action( 'woocommerce_after_add_attribute_fields', 'campo_meta_box_traduzione_attributo' );
add_action( 'woocommerce_after_edit_attribute_fields', 'campo_meta_box_traduzione_attributo' );

}

function campo_meta_box_traduzione_attributo( $attribute ) {
    $attribute_id = isset( $attribute->attribute_id ) ? $attribute->attribute_id : $_GET['edit'];
    $__eng_nome_attributo = $attribute_id ? get_option( "__eng_nome_attributo_$attribute_id" ) : '';
    ?>



    <div>
        <label><img src="/wp-content/uploads/2024/05/uk.png" style="width:1.4rem;">&nbsp;Traduzione Inglese</label>
        <input type="text" name="__eng_nome_attributo" id="__eng_nome_attributo" value="<?php echo $__eng_nome_attributo; ?>">
        <p>Inserisci la traduzione del valore dell'attributo in inglese</p>
    </div>

    <?php
}

// Salva il valore del campo metadato tradotto per gli attributi dei prodotti
add_action( 'woocommerce_attribute_added', 'salva_meta_box_traduzione_attributo', 10, 2 );
add_action( 'woocommerce_attribute_updated', 'salva_meta_box_traduzione_attributo', 10, 2 );

function salva_meta_box_traduzione_attributo( $attribute_id,  $tt_id ) {
    if( isset( $_POST['__eng_nome_attributo'] ) ) {
        update_option( "__eng_nome_attributo_$attribute_id", $_POST['__eng_nome_attributo'] );
    }
}


// Note:
// I termini degli attributi in WooCommerce sono gestiti in modo simile alle categorie e ai tag, poiché sono tutti tipi di tassonomie. 
// Questo significa che puoi utilizzare gli stessi meccanismi di WordPress per aggiungere e salvare metadati personalizzati.

?>
