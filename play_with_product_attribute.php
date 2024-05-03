<?php
// echo '<pre>';
// $product_exemple = wc_get_product( 80 );
// echo "Generale - nome degli attributi disponibili <br>";
// var_dump($product_exemple->get_attributes());
// echo "Generale - valori in stringa di tutte le variazioni taglia (dispnibili o non disponibili) <br>";
// var_dump($product_exemple->get_attribute( 'pa_taglia' ));
// echo "Generale -  valori in stringa di tutte le variazioni colore (dispnibili o non disponibili) <br>";
// var_dump($product_exemple->get_attribute( 'pa_colore' )); 
// echo "Generale -  Codici id di tutte le variazioni del prodotto <br>";
// var_dump($product_exemple->get_children()); // Codice id di tutte le variazioni

// echo "Codice prodotto variazione perso singolarmente <br>";
// $product_exemple_variation = wc_get_product(205);
// echo "Specifico - variazioni taglia disponibili  della specifica variazione <br>";
// var_dump($product_exemple_variation->get_attribute( 'pa_taglia' ));
// echo "Specifico - variazioni colore disponibili della specifica variazione <br>";
// var_dump($product_exemple_variation->get_attribute( 'pa_colore' ));

// echo '</pre>';
?>




<?php

// FUNZIONE >> nome_attributi_associati_al_prodotto()
// ARGOMENTO >> product_parent_id (number) 
// RETURN >> array (of string) dei nomi degli attributi associati

function nome_attributi_associati_al_prodotto_parent($product_parent_id){
    $___product = wc_get_product( $product_parent_id );
    $___array_of_string = [];
    foreach($___product->get_attributes() as $attribute){ $___array_of_string[] = $attribute["name"]; } ?>
    <pre><?php var_dump($___array_of_string); ?></pre>
    <?php return $___array_of_string;
}

// Esempio utilizzo
nome_attributi_associati_al_prodotto_parent(80);

?>

<?php

// FUNZIONE >> valori_dell_attributo_associati_al_prodotto() 
// ARGOMETI >> product_parent_id (number), name_of_attribute (string) 
// RETURN >> array (of string) dei valori dell'attributo associati al prodotto

function valori_dell_attributo_associati_al_prodotto_parent($product_parent_id, $name_of_attribute){
    $___product = wc_get_product( $product_parent_id );
    $__string_values = str_replace(' ', '', $___product->get_attribute( $name_of_attribute ));
    $__array_values = explode(',', $__string_values); ?>
    <pre><?php var_dump($__array_values); ?></pre>
    <?php return $__array_values;
}

// Esempio utilizzo
valori_dell_attributo_associati_al_prodotto_parent(80, 'pa_taglia');
valori_dell_attributo_associati_al_prodotto_parent(80, 'pa_colore');

?>

<?php

// FUNZIONE >> lista_id_dei_prodotti_variazione_di_un_prodotto_parent() 
// ARGOMENTI >> product_parent_id (number) 
// RETURN >> array (of number) degli id degli articoli child varation del prodotto

function lista_id_dei_prodotti_variazione_di_un_prodotto_parent($product_parent_id){
    $___product_parent = wc_get_product($product_parent_id);
    $__list_products_varation = $___product_parent->get_children(); ?>
    <pre><?php var_dump($__list_products_varation); ?></pre>
    <?php return $__list_products_varation;
}

// Esempio utilizzo
lista_id_dei_prodotti_variazione_di_un_prodotto_parent(80);

?>

<?php

// FUNZIONE >> valori_dell_attributo_associati_al_prodotto_varation() 
// ARGOMETI >> product_varation_id (number), name_of_attribute (string) 
// RETURN >> array (of string) dei valori dell'attributo associati al prodotto variazione

function valori_dell_attributo_associati_al_prodotto_varation($product_varation_id, $name_of_attribute){
    $___product = wc_get_product( $product_varation_id );
    $__string_values = str_replace(' ', '', $___product->get_attribute( $name_of_attribute ));
    $__array_values = explode(',', $__string_values); ?>
    <pre><?php var_dump($__array_values); ?></pre>
    <?php return $__array_values;
}

// Esempio utilizzo
valori_dell_attributo_associati_al_prodotto_varation(205, 'pa_taglia');
valori_dell_attributo_associati_al_prodotto_varation(205, 'pa_colore');

?>

<?php

function lista_combo_variazioni_prodotto_parent($product_id){

$args = array( 'parent' => $product_id, 'type' => 'variation' );
$variations = wc_get_products( $args );

$__array_combo_variazioni_prodotto = [];
$counter = 0;

$___attributes = nome_attributi_associati_al_prodotto_parent($product_id);

foreach($variations as $variation){

    $id = $variation->get_id();

    $__array_combo_variazioni_prodotto[$counter]['product_varation_id'] = $id;
    $__array_combo_variazioni_prodotto[$counter]['product_parent_id'] = $product_id;
    // $taglia = $variation->get_attribute('pa_taglia');
    // $__array_combo_variazioni_prodotto[$counter]['pa_taglia'] = $taglia;
    // $colore = $variation->get_attribute('pa_colore');
    // $__array_combo_variazioni_prodotto[$counter]['pa_colore'] = $colore;
    foreach($___attributes as $attribute_name){
        $attribute = $variation->get_attribute($attribute_name);
        $__array_combo_variazioni_prodotto[$counter][$attribute_name] = $attribute;
    }


    $counter++;

} ?>

<pre><?php var_dump($__array_combo_variazioni_prodotto); ?><?php

}

lista_combo_variazioni_prodotto_parent(80);

?>
