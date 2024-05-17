<?php

///////////////////////////////////////////////////////// Aggiungi campi metadati alle taxonomie e attributi Woocommerce ////////////////////////////////////////////////////////////////////


// Attributi di prodotto WooCommerce: 
// Gli attributi di prodotto sono trattati come tassonomie personalizzate. Ad esempio, se crei un attributo "Colore", WooCommerce creerà una tassonomia personalizzata chiamata pa_color.
// Termini degli attributi di prodotto: 
// I termini all'interno degli attributi di prodotto sono simili ai termini delle tassonomie standard (categorie e tag).


////////////////////////////////////////////////////////////////////////// Categorie woocommerce (tassonomia standard) //////////////////////////////////////////////////////////////////////////


add_action( 'init', 'aggiungi_meta_box_traduzione_categoria', 20 );

function aggiungi_meta_box_traduzione_categoria() {

    add_action( 'product_cat_add_form_fields', 'campo_meta_box_traduzione_categoria' );
    add_action( 'product_cat_edit_form_fields', 'campo_meta_box_traduzione_categoria' );

}

function campo_meta_box_traduzione_categoria( $term ) {

    global $woocommerce;
    global $wordpress;

    $term_id = isset( $term->term_id ) ? $term->term_id : ( isset( $_GET['tag_ID'] ) ? $_GET['tag_ID'] : 0 );
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

////////////////////////////////////////////////////////////////////////// Tag woocommerce (tassonomia standard) //////////////////////////////////////////////////////////////////////////


add_action( 'init', 'aggiungi_meta_box_traduzione_tag', 20 );

function aggiungi_meta_box_traduzione_tag() {

    add_action( 'product_tag_add_form_fields', 'campo_meta_box_traduzione_tag' );
    add_action( 'product_tag_edit_form_fields', 'campo_meta_box_traduzione_tag' );

}

function campo_meta_box_traduzione_tag( $term ) {

    $term_id = isset( $term->term_id ) ? $term->term_id : ( isset( $_GET['tag_ID'] ) ? $_GET['tag_ID'] : 0 );
    $__eng_nome_tag = get_term_meta( $term_id, '__eng_nome_tag', true );
    ?>

    <div>
    <label><img src="/wp-content/uploads/2024/05/uk.png" style="width:1.4rem;">&nbsp;Traduzione Inglese</label>
        <input type="text" name="__eng_nome_tag" id="__eng_nome_tag" value="<?php echo $__eng_nome_tag; ?>">
        <p>Inserisci la traduzione del tag in inglese</p>
    </div>
    <?php
}

// Salva il valore del campo metadato tradotto per i tag dei prodotti
add_action( 'create_product_tag', 'salva_meta_box_traduzione_tag', 10, 2 );
add_action( 'edited_product_tag', 'salva_meta_box_traduzione_tag', 10, 2  );

function salva_meta_box_traduzione_tag( $term_id, $tt_id ) {
    if( isset( $_POST['__eng_nome_tag'] ) ) {
        update_term_meta( $term_id, '__eng_nome_tag', $_POST['__eng_nome_tag'] );
    }
}



//////////////////////////////////////////////////////////// Attributi di prodotto woocommerce (tassonomia personalizzata) /////////////////////////////////////////////////////////////////

// Gli attributi di prodotto in WooCommerce non sono tassonomie standard di WordPress, ma sono gestiti come tassonomie personalizzate quindi dovremo gestirli separatamente.
// Gli attributi di prodotto WooCommerce, la gestione dei metadati dei termini è un po' diversa rispetto alle tassonomie standard.
// WooCommerce memorizza i dettagli degli attributi come opzioni nel database anziché come metadati dei termini.

add_action( 'init', 'aggiungi_meta_box_traduzione_attributi', 20 );

function aggiungi_meta_box_traduzione_attributi() {

add_action( 'woocommerce_after_add_attribute_fields', 'campo_meta_box_traduzione_attributo' );
add_action( 'woocommerce_after_edit_attribute_fields', 'campo_meta_box_traduzione_attributo' );

}

function campo_meta_box_traduzione_attributo( $attribute ) {

    $attribute_id = isset( $attribute->attribute_id ) ? $attribute->attribute_id : ( isset( $_GET['edit'] ) ? $_GET['edit'] : 0 );
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


//////////////////////////////////////////////////// Termini degli attributi di prodotto woocommerce (taxonomy) //////////////////////////////////////////////////////////////////////////

// I termini degli attributi in WooCommerce sono gestiti in modo simile alle categorie e ai tag, poiché sono tutti tipi di tassonomie. 

add_action( 'init', 'aggiungi_meta_box_traduzione_termini_attributi', 20 );

function aggiungi_meta_box_traduzione_termini_attributi() {

    $attribute_taxonomies = wc_get_attribute_taxonomies();
    if ( $attribute_taxonomies ) {
        foreach ( $attribute_taxonomies as $tax ) {
            $taxonomy_name = wc_attribute_taxonomy_name( $tax->attribute_name );
            add_action( "{$taxonomy_name}_add_form_fields", 'campo_meta_box_traduzione_termine', 10, 2 );
            add_action( "{$taxonomy_name}_edit_form_fields", 'campo_meta_box_traduzione_termine', 10, 2 );
        }
    }

// Es. add_action( 'pa_colore_add_form_fields', 'campo_meta_box_traduzione_termine' ); 
// Es. add_action( 'pa_colore_edit_form_fields', 'campo_meta_box_traduzione_termine' ); 
// Es. add_action( 'pa_taglia_edit_form_fields', 'campo_meta_box_traduzione_termine' ); 
// Es. add_action( 'pa_taglia_edit_form_fields', 'campo_meta_box_traduzione_termine' ); 
// ...


}

function campo_meta_box_traduzione_termine( $term ) {
    $term_id = isset( $term->term_id ) ? $term->term_id : ( isset( $_GET['tag_ID'] ) ? $_GET['tag_ID'] : 0 );
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

$attribute_taxonomies = wc_get_attribute_taxonomies();
    if ( $attribute_taxonomies ) {
        foreach ( $attribute_taxonomies as $tax ) {
            $taxonomy_name = wc_attribute_taxonomy_name( $tax->attribute_name );
            add_action( "created_{$taxonomy_name}", 'campo_meta_box_traduzione_termine', 10, 2 );
            add_action( "edited_{$taxonomy_name}", 'campo_meta_box_traduzione_termine', 10, 2 );
        }
    }


// Es. add_action( 'created_pa_colore', 'salva_meta_box_traduzione_termine', 10, 2 ); 
// Es. add_action( 'edited_pa_colore', 'salva_meta_box_traduzione_termine', 10, 2 ); 
// Es. add_action( 'created_pa_taglia', 'salva_meta_box_traduzione_termine', 10, 2 ); 
// Es. add_action( 'edited_pa_taglia', 'salva_meta_box_traduzione_termine', 10, 2 ); 
// ...



// Note: 
// Priorità di init aumentata a 20: Questo assicura che WooCommerce abbia registrato le sue tassonomie prima che il tuo codice venga eseguito.
