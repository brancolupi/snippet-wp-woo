<?php

//////////////////////////////////////////////////////////////////////////////// BASIC FUNCTIONS ////////////////////////////////////////////////////////////////////////////////

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

//////////////////////////////////////////////////////////////////////////////// BASIC USAGE ////////////////////////////////////////////////////////////////////////////////

/**
* Plugin Name: Play with product's attributes
* Plugin URI: https://www.cinquepuntozero.it/
* Description: Funzioni speciali custom
* Version: 1.0.0
* Author: Lucio Asciolla
* Author URI: https://www.cinquepuntozero.it/
**/
?>

<?php

function nomi_attributi_del_prodotto($product_id){
    $___product = wc_get_product( $product_id );
    $___array_of_string = [];
    foreach($___product->get_attributes() as $attribute){ $___array_of_string[] = $attribute["name"]; } ?>
    <pre><?php //var_dump($___array_of_string); ?></pre>
    <?php return $___array_of_string;
}

// Esempio
// Uso:  nomi_attributi_del_prodotto(get_the_ID()); OR nomi_attributi_del_prodotto(80);
// Output: ['pa_taglia','pa_colore']
// Note: Estrae i nomi degli attributi. Uso indipendente da se si tratta di un prodotto singolo o variabile


function valori_attributi_del_prodotto_single($product_id, $name_of_attribute){
    $___product = wc_get_product( $product_id );
    $__string_values = str_replace(' ', '', $___product->get_attribute( $name_of_attribute ));
    $__array_values = explode(',', $__string_values); ?>
    <pre><?php //var_dump($__array_values); ?></pre>
    <?php return $__array_values;
}

// Esempio
// Uso:  valori_attributi_del_prodotto_single(get_the_ID(), 'pa_taglia'); 
// Output: ['36','37', '38' ...]
// Note: Estrae da un prodotto single tutti i valori contenuti negli attributi che non sviluppano variazioni ma che sono state agganciate all'interno del prodotto.

function lista_id_dei_prodotti_variazione($product__id){
    $___product_parent = wc_get_product($product__id);
    $__list_products_varation = $___product_parent->get_children(); ?>
    <pre><?php //var_dump($__list_products_varation); ?></pre>
    <?php return $__list_products_varation;
}

// Esempio
// Uso:  lista_id_dei_prodotti_variazione(get_the_ID()); 
// Output: ['205','206', '207' ...]
// Note: Estrae da l'id di un product-parent la lista degli id dei product-varation


function lista_combo_variazioni_prodotto($product_id){

$args = array( 'parent' => $product_id, 'type' => 'variation' );
$variations = wc_get_products( $args );

$___array_combo_variazioni_prodotto = [];
$counter = 0;

$___attributes = nomi_attributi_del_prodotto($product_id);

foreach($variations as $variation){

    $id = $variation->get_id();

    $___array_combo_variazioni_prodotto[$counter]['product_varation_id'] = $id;
    $___array_combo_variazioni_prodotto[$counter]['product_parent_id'] = $product_id;
    foreach($___attributes as $attribute_name){
        $attribute = $variation->get_attribute($attribute_name);
        $___array_combo_variazioni_prodotto[$counter][$attribute_name] = $attribute;
    }

    $counter++;

} ?>

<pre><?php //var_dump($___array_combo_variazioni_prodotto); ?><?php

}

// Esempio
// Uso:  lista_combo_variazioni_prodotto(get_the_ID()); 
// Output: 
// 	Array(5){
// 		[0] =>
// 			['product_varation_id'] => 205,
// 			['product_parent_id'] => 80,
// 			['pa_taglia'] => '37',
// 			['pa_colore'] => 'Verde',
// 		[1] =>
// 	...
// Note: Estrae un array multidimensionale di tutte le variazioni completi di tutti i dati


function valori_attributi_del_prodotto_varation($product_id, $attribute_name){

$args = array( 'parent' => $product_id, 'type' => 'variation' );
$variations = wc_get_products( $args );

$___array_variazioni_prodotto = [];

foreach($variations as $variation){ $___array_variazioni_prodotto[] = $variation->get_attribute($attribute_name); } ?>

<pre><?php //var_dump($___array_variazioni_prodotto); ?></pre><?php
	
return $___array_variazioni_prodotto;

}

// Esempio
// Uso:  valori_attributi_del_prodotto_varation(get_the_ID(), 'pa_taglia'); 
// Output: ['36','37', '38' ...]
// Note: Estrae da un prodotto variable tutti i valori contenuti nelle variazioni.


?>



<?php

//////////////////////////////////////////////////////////////////////////////// ADVANCED USAGE ////////////////////////////////////////////////////////////////////////////////

/**
* Plugin Name: Play with product's attributes
* Plugin URI: https://www.cinquepuntozero.it/
* Description: Funzioni speciali custom
* Version: 1.0.0
* Author: Lucio Asciolla
* Author URI: https://www.cinquepuntozero.it/
**/
?>

<?php

function nomi_attributi_del_prodotto($product_id){
    $___product = wc_get_product( $product_id );
    $___array_of_string = [];
    foreach($___product->get_attributes() as $attribute){ $___array_of_string[] = $attribute["name"]; } ?>
<!--     <pre><?php //var_dump($___array_of_string); ?></pre> -->
    <?php return $___array_of_string;
}

// Esempio
// Uso:  nomi_attributi_del_prodotto(get_the_ID()); OR nomi_attributi_del_prodotto(80);
// Output: ['pa_taglia','pa_colore']
// Note: Estrae i nomi degli attributi. Uso indipendente da se si tratta di un prodotto singolo o variabile


function valori_attributi_del_prodotto_single($product_id, $name_of_attribute){
    $___product = wc_get_product( $product_id );
    $__string_values = str_replace(' ', '', $___product->get_attribute( $name_of_attribute ));
    $__array_values = explode(',', $__string_values); ?>
<!--     <pre><?php //var_dump($__array_values); ?></pre> -->
    <?php return $__array_values;
}

// Esempio
// Uso:  valori_attributi_del_prodotto_single(get_the_ID(), 'pa_taglia'); 
// Output: ['36','37', '38' ...]
// Note: Estrae da un prodotto single tutti i valori contenuti negli attributi che non sviluppano variazioni ma che sono state agganciate all'interno del prodotto.

function lista_id_dei_prodotti_variazione($product__id){
    $___product_parent = wc_get_product($product__id);
    $__list_products_varation = $___product_parent->get_children(); ?>
<!--     <pre><?php //var_dump($__list_products_varation); ?></pre> -->
    <?php return $__list_products_varation;
}

// Esempio
// Uso:  lista_id_dei_prodotti_variazione(get_the_ID()); 
// Output: ['205','206', '207' ...]
// Note: Estrae da l'id di un product-parent la lista degli id dei product-varation


function lista_combo_variazioni_prodotto($product_id){

$args = array( 'parent' => $product_id, 'type' => 'variation' );
$variations = wc_get_products( $args );

$___array_combo_variazioni_prodotto = [];
$counter = 0;

$___attributes = nomi_attributi_del_prodotto($product_id);

foreach($variations as $variation){

    $id = $variation->get_id();

    $___array_combo_variazioni_prodotto[$counter]['product_varation_id'] = $id;
    $___array_combo_variazioni_prodotto[$counter]['product_parent_id'] = $product_id;
    foreach($___attributes as $attribute_name){
        $attribute = $variation->get_attribute($attribute_name);
        $___array_combo_variazioni_prodotto[$counter][$attribute_name] = $attribute;
    }

    $counter++;

} ?>

<!-- <pre><?php //var_dump($___array_combo_variazioni_prodotto); ?></pre> -->

<?php

}

// Esempio
// Uso:  lista_combo_variazioni_prodotto(get_the_ID()); 
// Output: 
// 	Array(5){
// 		[0] =>
// 			['product_varation_id'] => 205,
// 			['product_parent_id'] => 80,
// 			['pa_taglia'] => '37',
// 			['pa_colore'] => 'Verde',
// 		[1] =>
// 	...
// Note: Estrae un array multidimensionale di tutte le variazioni completi di tutti i dati


function valori_attributi_del_prodotto_varation($product_id, $attribute_name){

$args = array( 'parent' => $product_id, 'type' => 'variation' );
$variations = wc_get_products( $args );

$___array_variazioni_prodotto = [];

foreach($variations as $variation){ 
	$___array_variazioni_prodotto[] = $variation->get_attribute($attribute_name); 
} ?>

<!-- <pre><?php //var_dump($___array_variazioni_prodotto); ?></pre> -->

<?php
return $___array_variazioni_prodotto;
}

// Esempio
// Uso:  valori_attributi_del_prodotto_varation(get_the_ID(), 'pa_taglia'); 
// Output: ['36','37', '38' ...]
// Note: Estrae da un prodotto variable tutti i valori contenuti nelle variazioni.


function composit_valori_attributi_del_prodotto_varation($product_id, $attribute_name){

$args = array( 'parent' => $product_id, 'type' => 'variation' );
$variations = wc_get_products( $args );

$___array_combo_variazioni_prodotto = [];
$counter = 0;

foreach($variations as $variation){

    $variation_id = $variation->get_id();
	$variation_value = $variation->get_attribute($attribute_name); 

    $___array_combo_variazioni_prodotto[$counter]['variation_id'] = $variation_id;
    $___array_combo_variazioni_prodotto[$counter]['variation_value'] = $variation_value;

    $counter++;
		
} ?>

<!-- <pre><?php //var_dump($___array_combo_variazioni_prodotto); ?></pre> -->

<?php
	
	return $___array_combo_variazioni_prodotto;

}

// Esempio
// Uso:  composit_valori_attributi_del_prodotto_varation(get_the_ID(), 'pa_taglia'); 
// Output: 
// 	Array(2){
// 		[0] =>
// 			['variation_id'] => 205,
// 			['variation_value'] => '37',
// 		[1] =>
// 	...


function src_image_valori_attributi_del_prodotto_varation($product_id, $attribute_name){

$product = new WC_Product_Variable( $product_id );
$variations = $product->get_available_variations();

$___array_src_variazioni_prodotto = [];

foreach($variations as $variation){ 
	$___array_src_variazioni_prodotto[] = $variation['image']['thumb_src']; 
} ?>

<!-- <pre><?php //var_dump($___array_src_variazioni_prodotto); ?></pre> -->

<?php
return $___array_src_variazioni_prodotto;
}

// Esempio
// Uso:  src_image_valori_attributi_del_prodotto_varation(get_the_ID(), 'pa_colore'); 
// Output: ['/image.jpg','/image2.jpg', '/image3.jpg' ...]
// Note: Estrae da un prodotto variable tutti gli src valori contenuti nelle variazioni.


function composit_src_image_valori_attributi_del_prodotto_varation($product_id, $attribute_name){

$product = new WC_Product_Variable( $product_id );
$variations = $product->get_available_variations();

$___array_src_variazioni_prodotto = [];
$counter = 0;

foreach($variations as $variation){
	
	if( isset( $variation['attributes']['attribute_'.$attribute_name] ) ){

    $variation_id = $variation['variation_id'];
	$variation_img_src = $variation['image']['thumb_src']; 

    $___array_src_variazioni_prodotto[$counter]['variation_id'] = $variation_id;
    $___array_src_variazioni_prodotto[$counter]['variation_img_src'] = $variation_img_src;

    $counter++;
		
	}

} ?>

<!-- <pre><?php //var_dump($___array_src_variazioni_prodotto); ?></pre> -->

<?php
	
	return $___array_src_variazioni_prodotto;

}


?>
