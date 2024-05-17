<?php

/////////////////////////////////////////////////////// Aggiungi campo traduzione nella taxonomie e attributi ////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////// Categorie (taxonomy) //////////////////////////////////////////////////////////////////////////


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
        <label><img src="/wp-content/uploads/2024/05/uk.png" style="width:1.4rem;">&nbsp;Traduzione Inglese</label>
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
    
    if( isset( $_POST['__eng_nome_categoria'] ) ){
        update_term_meta( $term_id, '__eng_nome_categoria', $_POST['__eng_nome_categoria'] );
    }
}


////////////////////////////////////////////////////////////////////////// Attributi (attribute) //////////////////////////////////////////////////////////////////////////



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

////////////////////////////////////////////////////////////////////////// Termini attributi (taxonomy) //////////////////////////////////////////////////////////////////////////


add_action( 'init', 'aggiungi_meta_box_traduzione_termini_attributi' );

function aggiungi_meta_box_traduzione_termini_attributi() {

add_action( 'pa_colore_add_form_fields', 'campo_meta_box_traduzione_termine' ); // Cambia 'pa_colore' con la tua tassonomia
add_action( 'pa_colore_edit_form_fields', 'campo_meta_box_traduzione_termine' ); // Cambia 'pa_colore' con la tua tassonomia

}

function campo_meta_box_traduzione_termine( $term ) {
    $term_id = isset( $term->term_id ) ? $term->term_id : $_GET['tag_ID'];
    $__eng_nome_termine = get_term_meta( $term_id, '__eng_nome_termine', true );
    ?>
    
    <div>
        <label><img src="/wp-content/uploads/2024/05/uk.png" style="width:1.4rem;">&nbsp;Traduzione Inglese</label>
        <input type="text" name="__eng_nome_termine" id="__eng_nome_termine" value="<?php echo $__eng_nome_termine; ?>">
        <p>Inserisci la traduzione del termine in inglese</p>
    </div>
    <?php
}


// Salva il valore del campo metadato tradotto per i termini degli attributi
function salva_meta_box_traduzione_termine( $term_id, $tt_id) {
    if( isset( $_POST['__eng_nome_termine'] ) ) {
        update_term_meta( $term_id, '__eng_nome_termine', $_POST['__eng_nome_termine'] );
    }
}
add_action( 'created_pa_colore', 'salva_meta_box_traduzione_termine', 10, 2 ); // Cambia 'pa_colore' con la tua tassonomia
add_action( 'edited_pa_colore', 'salva_meta_box_traduzione_termine', 10, 2 ); // Cambia 'pa_colore' con la tua tassonomia


// Note:
// Gli attributi di prodotto in WooCommerce non sono tassonomie standard di WordPress, ma sono gestiti come tassonomie personalizzate quindi dovremo gestirli separatamente.
// I termini degli attributi in WooCommerce sono gestiti in modo simile alle categorie e ai tag, poiché sono tutti tipi di tassonomie. 
// Questo significa che puoi utilizzare gli stessi meccanismi di WordPress per aggiungere e salvare metadati personalizzati.
// Quindi possiamo gestirli o tutti con lo snippet che segue o singolarmente con gli snippet specifici qui sopra.



?>
