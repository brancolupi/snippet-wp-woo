<?php
/**
* Plugin Name: Product translation
* Plugin URI: https://www.cinquepuntozero.it/
* Description: Logica traduzione prodotti
* Version: 1.0.0
* Author: Lucio Asciolla
* Author URI: https://www.cinquepuntozero.it/
**/
?>


<?php 

///////////////// English product fileds ///////////////

function crea_english_translate_metabox(){
  
    add_meta_box(
      'english_translate_metabox', //id
      '<div style="display:flex; width:100%;"><img src="/wp-content/uploads/2024/05/uk.png" style="width:2%;"><p style="margin:0;">&nbsp;&nbsp;Campi traduzione</p></div>', // titolo
      'aggiungi_contenuto_interfaccia_english_translate_metabox', // funzione 
      'product' // post type
    );
    
    }
    
    add_action('add_meta_boxes', 'crea_english_translate_metabox');

    function aggiungi_contenuto_interfaccia_english_translate_metabox(){ 

        global $post; 

        $__eng_product_title = get_post_meta( get_the_ID(), '__eng_product_title', true);
        $__eng_product_description = get_post_meta( get_the_ID(), '__eng_product_description', true);

        ?>

        <div class="container-fluid m-0 p-0">

            <div class="row">
                <div class="col-12">
                    <label>Titolo prodotto</label><br>
                    <input name="__eng_product_title" value="<?php echo $__eng_product_title; ?>" placeholder="<?php echo get_the_title(); ?>" style="width:100%;">
                    <p style="color:#80808042; font-size:0.65rem; margin:0;">meta_key: "__eng_product_title"</p>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <label>Descrizione prodotto</label><br>
                    <textarea rows="5" style="width:100%" name="__eng_product_description" placeholder="<?php echo get_the_content(); ?>"><?php echo $__eng_product_description; ?></textarea>
                    <p style="color:#80808042; font-size:0.65rem; margin:0;">meta_key: "__eng_product_description"</p>
                </div>
            </div>

        </div>

    <?php
    
    }

function salva_dati_english_translate_metabox(){
  
    global $post;
                  
        if(isset($_POST["__eng_product_title"])) :
        update_post_meta($post->ID, '__eng_product_title', $_POST["__eng_product_title"]);
        endif;
        if(isset($_POST["__eng_product_description"])) :
        update_post_meta($post->ID, '__eng_product_description', $_POST["__eng_product_description"]);
        endif;
               
    }
                  
add_action('save_post', 'salva_dati_english_translate_metabox');


///////////////// Override woocommerce functions con suffisso "tl_" ///////////////

function tl_get_the_title(){
	
	$post_title = (get_the_title() == null) ? 'Titolo prodotto vuoto' :  get_the_title();
	$translate_post_title = (get_post_meta(get_the_ID(), '__eng_product_title', true) == null) ? 'Empty product title' : get_post_meta(get_the_ID(), '__eng_product_title', true);
	
    if(WC()->session){
        if(WC()->session->get( 'language' ) == 'it_IT'){
            return $post_title;
        }else{
            return $translate_post_title;
        }
    }
}

function tl_get_the_content(){
	
	$post_content = (get_the_content() == null) ? 'Descrizione prodotto vuota' :  get_the_content();
	$translate_post_content = (get_post_meta(get_the_ID(), '__eng_product_description', true) == null) ? 'Empty product description' : get_post_meta(get_the_ID(), '__eng_product_description', true);
	
    if(WC()->session){
        if(WC()->session->get( 'language' ) == 'it_IT'){
            return $post_content;
        }else{
            return $translate_post_content;
        }
    }
}

// function custom_get_the_title($post){

// $post_title = (get_the_title() == null) ? 'Titolo prodotto' :  get_the_title();
// $translate_post_title = (get_post_meta(get_the_ID(), '__eng_product_title', true) == null) ? 'Product title' : get_post_meta(get_the_ID(), '__eng_product_title', true);

// if(WC()->session){
// 	if(WC()->session->get( 'language' ) == 'it_IT'){
//            	return $post_title;
//        }else{
// 		return $translate_post_title;
//        }
//    }

// }

// add_filter('the_title', 'custom_get_the_title', 10, 2);

?>
