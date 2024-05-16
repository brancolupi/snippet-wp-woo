<?php
// Aggiungi un campo per aggiungere un metadato ad una categoria
// La stessa struttura è utilizzabile per i tag

add_action( 'init', 'aggiungi_meta_box_traduzione_termine' );

function aggiungi_meta_box_traduzione_termine() {

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
?>
