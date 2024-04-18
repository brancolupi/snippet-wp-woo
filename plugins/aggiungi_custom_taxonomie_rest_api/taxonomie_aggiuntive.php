<?php
/*
 * Plugin Name:       Campi aggiuntivi per i prodotti dell'ecommerce
 * Plugin URI:        HTTPS://CINQUEPUNTOZERO.IT
 * Description:       Campi aggiuntivi per i prodotti dell'ecommerce
 * Version:           1.0.0
 * Author:            Lucio Asciolla Full Stack Web Developer
 * Author URI:         HTTPS://CINQUEPUNTOZERO.IT
 * License:           GPL v2 or later
 * License URI:       HTTPS://WWW.GNU.ORG/LICENSES/GPL-2.0.HTML
 * Update URI:        HTTPS://EXAMPLE.COM/MY-PLUGIN/
 * Text Domain:       custom-plugin
 * Domain Path:       /languages
 */
?>

<?php


///////////////////////////////// Aggiungiamo la taxonomia "Prodotti per capelli" ai prodotto Woocommerce /////////////////////////////

function prodotti_capelli_taxonomies() {
	$labels = array(
		'name'              => _x( 'Caratteristiche prodotti capelli', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Caratteristica prodotto capelli', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Ricerca caratteristica prodotto capelli', 'textdomain' ),
		'all_items'         => __( 'Tutti le caratteristiche prodotti capelli', 'textdomain' ),
		'parent_item'       => __( 'Genitore caratteristica prodotto capelli', 'textdomain' ),
		'parent_item_colon' => __( 'Genitore caratteristica prodotto capelli:', 'textdomain' ),
		'edit_item'         => __( 'Modifica caratteristica prodotto capelli', 'textdomain' ),
		'update_item'       => __( 'Aggiorna caratteristica prodotto capelli', 'textdomain' ),
		'add_new_item'      => __( 'Aggiungi nuovo caratteristica prodotto capelli', 'textdomain' ),
		'new_item_name'     => __( 'Nuovo nome caratteristica prodotto capelli', 'textdomain' ),
		'menu_name'         => __( 'Caratteristiche prodotti capelli', 'textdomain' ),
	);
	
	$capabilities = array(
        'manage_terms'               => 'manage_woocommerce',
        'edit_terms'                 => 'manage_woocommerce',
        'delete_terms'               => 'manage_woocommerce',
        'assign_terms'               => 'manage_woocommerce',
    ); 

	$args = array(
		'show_in_rest'      => true,
		'rest_base'			=> 'caratteristiche_prodotti_capelli',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
		'hierarchical'          => true,
		'labels'                => $labels,
		'show_ui'               => true,
        'show_in_quick_edit'    => false,
        'meta_box_cb'           => false,
		'show_admin_column'     => true,
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'caratteristiche_prodotti_capelli' ),
		'capabilities'          => $capabilities,
	);
    register_taxonomy( 'caratteristiche_prodotti_capelli', array( 'product' ), $args );
    register_taxonomy_for_object_type( 'caratteristiche_prodotti_capelli', 'product' );

}
	
add_action( 'init', 'prodotti_capelli_taxonomies', 4 );


//Register taxonomy API for WC
add_action( 'rest_api_init', 'register_rest_field_for_custom_taxonomy_caratteristiche_prodotti_capelli' );

function register_rest_field_for_custom_taxonomy_caratteristiche_prodotti_capelli() {
register_rest_field('product', "caratteristiche_prodotti_capelli", array(
'get_callback'    => 'product_get_callback_caratteristiche_prodotti_capelli',
'update_callback'    => 'product_update_callback_caratteristiche_prodotti_capelli',
'schema' => null,
));    
}
//Get Taxonomy record in wc REST API
function product_get_callback_caratteristiche_prodotti_capelli($post, $attr, $request, $object_type){
$terms = array();

// Get terms
foreach (wp_get_post_terms( $post[ 'id' ],'caratteristiche_prodotti_capelli') as $term){
$terms[] = array(
'id'        => $term->term_id,
'name'      => $term->name,
'slug'      => $term->slug,
'custom_field_name'  => get_term_meta($term->term_id, 'custom_field_name', true)
);
}

return $terms;
}
        
//Update Taxonomy record in wc REST API
function product_update_callback_caratteristiche_prodotti_capelli($values, $post, $attr, $request, $object_type){   
// Post ID
$postId = $post->get_id();
// Set terms
wp_set_object_terms( $postId, $values , 'caratteristiche_prodotti_capelli');
}

//Update Taxonomy record in wc REST API
function product_update_callback_Leerjaar_caratteristiche_prodotti_capelli($values, $post, $attr, $request, $object_type){   
// Post ID            
$postId = $post->id;
error_log("debug on values");
error_log(json_encode($values));
                         
$numarray = [];             
foreach($values as $value){
$numarray[] = (int)$value['id'];
}
          
wp_set_object_terms( $postId, $numarray , 'caratteristiche_prodotti_capelli');
}


///////////////////////////////// END Aggiungiamo la taxonomia "Bollini" ai prodotto Woocommerce /////////////////////////////



///////////////////////////////// Aggiungiamo la taxonomia "Bollini" ai prodotto Woocommerce /////////////////////////////

function bollini_taxonomies() {
	$labels = array(
		'name'              => _x( 'Bollini / Etichette', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Bollino', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Ricerca bollini', 'textdomain' ),
		'all_items'         => __( 'Tutti i bollini', 'textdomain' ),
		'parent_item'       => __( 'Genitore bollino', 'textdomain' ),
		'parent_item_colon' => __( 'Genitore bolllino:', 'textdomain' ),
		'edit_item'         => __( 'Modifica bollino', 'textdomain' ),
		'update_item'       => __( 'Aggiorna bollino', 'textdomain' ),
		'add_new_item'      => __( 'Aggiungi nuovo bollino', 'textdomain' ),
		'new_item_name'     => __( 'Nuovo nome bollino', 'textdomain' ),
		'menu_name'         => __( 'Bollini / Etichette', 'textdomain' ),
	);
	
	$capabilities = array(
        'manage_terms'               => 'manage_woocommerce',
        'edit_terms'                 => 'manage_woocommerce',
        'delete_terms'               => 'manage_woocommerce',
        'assign_terms'               => 'manage_woocommerce',
    ); 

	$args = array(
		'show_in_rest'      => true,
		'rest_base'			=> 'bollino',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'bollino' ),
		'capabilities'               => $capabilities,

	);
    register_taxonomy( 'bollino', array( 'product' ), $args );
	register_taxonomy_for_object_type( 'bollino', 'product' );

}
	
add_action( 'init', 'bollini_taxonomies', 1 );



//Register taxonomy API for WC
add_action( 'rest_api_init', 'register_rest_field_for_custom_taxonomy_bollino' );

function register_rest_field_for_custom_taxonomy_bollino() {
register_rest_field('product', "bollino", array(
'get_callback'    => 'product_get_callback_bollino',
'update_callback'    => 'product_update_callback_bollino',
'schema' => null,
));    
}
//Get Taxonomy record in wc REST API
function product_get_callback_bollino($post, $attr, $request, $object_type){
$terms = array();

// Get terms
foreach (wp_get_post_terms( $post[ 'id' ],'bollino') as $term){
$terms[] = array(
'id'        => $term->term_id,
'name'      => $term->name,
'slug'      => $term->slug,
'custom_field_name'  => get_term_meta($term->term_id, 'custom_field_name', true)
);
}

return $terms;
}
        
//Update Taxonomy record in wc REST API
function product_update_callback_bollino($values, $post, $attr, $request, $object_type){   
// Post ID
$postId = $post->get_id();
// Set terms
wp_set_object_terms( $postId, $values , 'bollino');
}

//Update Taxonomy record in wc REST API
function product_update_callback_Leerjaar_bollino($values, $post, $attr, $request, $object_type){   
// Post ID            
$postId = $post->id;
error_log("debug on values");
error_log(json_encode($values));
                         
$numarray = [];             
foreach($values as $value){
$numarray[] = (int)$value['id'];
}
          
wp_set_object_terms( $postId, $numarray , 'bollino');
}





///////////////////////////////// END Aggiungiamo la taxonomia "Bollini" ai prodotto Woocommerce /////////////////////////////



///////////////////////////////// Aggiungiamo la taxonomia "Brand" ai prodotto Woocommerce /////////////////////////////


function brand_taxonomies() {
	$labels = array(
		'name'              => _x( 'Brands', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Brand', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Ricerca brand', 'textdomain' ),
		'all_items'         => __( 'Tutti i brand', 'textdomain' ),
		'parent_item'       => __( 'Genitore brand', 'textdomain' ),
		'parent_item_colon' => __( 'Genitore brand:', 'textdomain' ),
		'edit_item'         => __( 'Modifica brand', 'textdomain' ),
		'update_item'       => __( 'Aggiorna brand', 'textdomain' ),
		'add_new_item'      => __( 'Aggiungi nuovo brand', 'textdomain' ),
		'new_item_name'     => __( 'Nuovo nome brand', 'textdomain' ),
		'menu_name'         => __( 'Brands', 'textdomain' ),
	);

	$capabilities = array(
        'manage_terms'               => 'manage_woocommerce',
        'edit_terms'                 => 'manage_woocommerce',
        'delete_terms'               => 'manage_woocommerce',
        'assign_terms'               => 'manage_woocommerce',
    ); 

	$args = array(
		'show_in_rest'      => true,
		'rest_base'			=> 'brand',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'brand' ),
		'capabilities'               => $capabilities,
	);
    register_taxonomy( 'brand', array( 'product' ), $args );
	register_taxonomy_for_object_type( 'brand', 'product' );
}

add_action( 'init', 'brand_taxonomies', 2 );

//Register taxonomy API for WC
add_action( 'rest_api_init', 'register_rest_field_for_custom_taxonomy_brands' );

function register_rest_field_for_custom_taxonomy_brands() {
register_rest_field('product', "brand", array(
'get_callback'    => 'product_get_callback',
'update_callback'    => 'product_update_callback',
'schema' => null,
));    
}
//Get Taxonomy record in wc REST API
function product_get_callback($post, $attr, $request, $object_type){
$terms = array();

// Get terms
foreach (wp_get_post_terms( $post[ 'id' ],'brand') as $term){
$terms[] = array(
'id'        => $term->term_id,
'name'      => $term->name,
'slug'      => $term->slug,
'custom_field_name'  => get_term_meta($term->term_id, 'custom_field_name', true)
);
}

return $terms;
}
        
//Update Taxonomy record in wc REST API
function product_update_callback($values, $post, $attr, $request, $object_type){   
// Post ID
$postId = $post->get_id();
// Set terms
wp_set_object_terms( $postId, $values , 'brand');
}

//Update Taxonomy record in wc REST API
function product_update_callback_Leerjaar($values, $post, $attr, $request, $object_type){   
// Post ID            
$postId = $post->id;
error_log("debug on values");
error_log(json_encode($values));
                         
$numarray = [];             
foreach($values as $value){
$numarray[] = (int)$value['id'];
}
          
wp_set_object_terms( $postId, $numarray , 'brand');
}


///////////////////////////////// END Aggiungiamo la taxonomia "Brand" ai prodotto Woocommerce /////////////////////////////



///////////////////////////////// Aggiungiamo la taxonomia "Brand" ai prodotto Woocommerce /////////////////////////////


function caratteristiche_prodotto_taxonomies() {
	$labels = array(
		'name'              => _x( 'Caratteristiche generali', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Caratteristica', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Ricerca caratteristiche', 'textdomain' ),
		'all_items'         => __( 'Tutti le caratteristiche', 'textdomain' ),
		'parent_item'       => __( 'Genitore caratteristica', 'textdomain' ),
		'parent_item_colon' => __( 'Genitore caratteristica:', 'textdomain' ),
		'edit_item'         => __( 'Modifica caratteristica', 'textdomain' ),
		'update_item'       => __( 'Aggiorna caratteristica', 'textdomain' ),
		'add_new_item'      => __( 'Aggiungi nuova caratteristica', 'textdomain' ),
		'new_item_name'     => __( 'Nuovo nome caratteristica', 'textdomain' ),
		'menu_name'         => __( 'Caratteristiche generali', 'textdomain' ),
	);

	$capabilities = array(
        'manage_terms'               => 'manage_woocommerce',
        'edit_terms'                 => 'manage_woocommerce',
        'delete_terms'               => 'manage_woocommerce',
        'assign_terms'               => 'manage_woocommerce',
    ); 


	$args = array(
		'show_in_rest'      => true,
		'rest_base'			=> 'caratteristiche',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'caratteristiche' ),
		'capabilities'               => $capabilities,
	);
    register_taxonomy( 'caratteristiche', array( 'product' ), $args );
	register_taxonomy_for_object_type( 'caratteristiche', 'product' );
}

add_action( 'init', 'caratteristiche_prodotto_taxonomies', 3 );

//Register taxonomy API for WC
add_action( 'rest_api_init', 'register_rest_field_for_custom_taxonomy_caratteristiche' );

function register_rest_field_for_custom_taxonomy_caratteristiche() {
register_rest_field('product', "caratteristiche", array(
'get_callback'    => 'product_get_callback_caratteristiche',
'update_callback'    => 'product_update_callback_caratteristiche',
'schema' => null,
));    
}
//Get Taxonomy record in wc REST API
function product_get_callback_caratteristiche($post, $attr, $request, $object_type){
$terms = array();

// Get terms
foreach (wp_get_post_terms( $post[ 'id' ],'caratteristiche') as $term){
$terms[] = array(
'id'        => $term->term_id,
'name'      => $term->name,
'slug'      => $term->slug,
'custom_field_name'  => get_term_meta($term->term_id, 'custom_field_name', true)
);
}

return $terms;
}
        
//Update Taxonomy record in wc REST API
function product_update_callback_caratteristiche($values, $post, $attr, $request, $object_type){   
// Post ID
$postId = $post->get_id();
// Set terms
wp_set_object_terms( $postId, $values , 'caratteristiche');
}

//Update Taxonomy record in wc REST API
function product_update_callback_Leerjaar_caratteristiche($values, $post, $attr, $request, $object_type){   
// Post ID            
$postId = $post->id;
error_log("debug on values");
error_log(json_encode($values));
                         
$numarray = [];             
foreach($values as $value){
$numarray[] = (int)$value['id'];
}
          
wp_set_object_terms( $postId, $numarray , 'caratteristiche');
}





///////////////////////////////// END Aggiungiamo la taxonomia "Brand" ai prodotto Woocommerce /////////////////////////////



/////// Nascondiamo le taxonomie "Tag" & "Caratteristiche prodotto capelli" dei prodotto Woocommerce inutilizzata dalla Post list table ////////


add_action('init', function() {
    register_taxonomy('product_tag', 'product', [
        'public'            => false,
        'show_ui'           => false,
        'show_admin_column' => false,
        'show_in_nav_menus' => false,
        'show_tagcloud'     => false,
    ]);
}, 100);

add_action( 'admin_init' , function() {
    add_filter('manage_product_posts_columns', function($columns) {
        unset($columns['product_tag']);
        unset($columns['taxonomy-caratteristiche_prodotti_capelli']);
        return $columns;
    }, 100);
});


/////// END Nascondiamo le taxonomie "Tag" & "Caratteristiche prodotto capelli" dei prodotto Woocommerce inutilizzata dalla Post list table ////////


///////////////////////////////// Aggiunta di metaboxes per i prodotti wooocommerce ///////////////////////////////////////////////////


function aggiungi_metabox_prodotti(){
  
    add_meta_box(
            'ulteriori_campi_descrizione_prodotto', //id
            'Campi aggiuntivi descrizione prodotto', // titolo
            'aggiungi_campi_aggiuntivi_descrizione', // funzione 
            'product' // post type
        );

    add_meta_box(
            'punti_fedeltà_prodotto', //id
            'Valore punti fedeltà prodotto', // titolo
            'aggiungi_campo_punti_fedeltà', // funzione 
            'product' // post type
        );

    add_meta_box(
            'peso_volumetrico_prodotto', //id
            'Peso volumetrico prodotto', // titolo
            'aggiungi_campo_peso_volumetrico', // funzione 
            'product' // post type
        );

    add_meta_box(
            'acquistato_n_volte', //id
            'Prodotto acquistato n volte', // titolo
            'aggiungi_campo_acquistato_n_volte', // funzione 
            'product' // post type
        );    

    add_meta_box(
            'caratteristiche_prodotti_capelli', //id
            'Caratteristiche prodotti per capelli', // titolo
            'aggiungi_campi_caratteristiche_prodotti_capelli', // funzione 
            'product' // post type
        );
    add_meta_box(
            'funzioni_speciali', //id
            'Funzioni speciali', // titolo
            'aggiungi_campi_funzioni_speciali', // funzione 
            'product' // post type
        );


}

add_action('add_meta_boxes', 'aggiungi_metabox_prodotti');


function aggiungi_campo_acquistato_n_volte(){ 

    global $post;

    $acquistato_n_volte = get_post_meta( $post->ID, 'acquistato_n_volte', true);

?>


<div class="row align-items-start justify-content-center" style="padding: 0% 0%;">
    <div class="col">
        <label>Prodotto acquistato n volte</label>
        <input style="width:100%; margin: 1% 0%;" type="number" name="acquistato_n_volte" value="<?php if($acquistato_n_volte!=''){ echo $acquistato_n_volte; }else{ echo '0'; } ?>">
        <p style="color: #c7c6c6;  font-size: 0.6rem;">Post-meta: 'acquistato_n_volte'</p>
        <p style="color: #c7c6c6;  font-size: 0.6rem;">Note: il campo è aggiornato in automatico, ma puoi modificarlo manualmente</p>
    </div>
</div>

<?php
}


function aggiungi_campi_funzioni_speciali(){ 

    global $post;

    $consigliato_da_helu = get_post_meta( $post->ID, 'consigliato_da_helu', true);
    $scelta_top = get_post_meta( $post->ID, 'scelta_top', true);


?>


<div class="row align-items-start justify-content-center" style="padding: 0% 0%;">
    <div class="col">
        <div class="row" style="margin-top:5%;">
            <label>Inserire tra i prodotti consigliati</label>
        </div>
        <div class="row" style="margin-top:5%;">
            <p style="padding-top:0%;"><input id="consigliato_da_helu" style="margin: 0% 5% 0% 5%" type="checkbox" name="consigliato_da_helu" value="<?php echo $consigliato_da_helu; ?>">Inserisci</p>
        </div>
        <div class="row">
            <p style="color: #c7c6c6;  font-size: 0.6rem;">Post-meta: 'consigliato_da_helu'</p>
        </div>
    </div>
</div>

<div class="row align-items-start justify-content-center" style="padding: 0% 0%;">
    <div class="col">
        <div class="row" style="margin-top:5%;">
            <label>Inserire tra "Scelta top per i tuoi capelli"</label>
        </div>
        <div class="row" style="margin-top:5%;">
            <p style="padding-top:0%;"><input id="scelta_top" style="margin: 0% 5% 0% 5%" type="checkbox" name="scelta_top" value="<?php echo $scelta_top; ?>">Inserisci</p>
        </div>
        <div class="row">
            <p style="color: #c7c6c6;  font-size: 0.6rem;">Post-meta: 'scelta_top'</p>
        </div>
    </div>
</div>

<script>

    var consigliato_da_helu = document.getElementById('consigliato_da_helu');
    consigliato_da_helu.addEventListener('change', function(event){
        var target = event.target;
        if(target.checked){
            target.value=1;
            target.setAttribute('checked','checked');
        }
    })

    if(document.getElementById('consigliato_da_helu').value==1){
            document.getElementById('consigliato_da_helu').setAttribute('checked','checked');
        }

        var scelta_top = document.getElementById('scelta_top');
        scelta_top.addEventListener('change', function(event){
        var target = event.target;
        if(target.checked){
            target.value=1;
            target.setAttribute('checked','checked');
        }
    })

    if(document.getElementById('scelta_top').value==1){
            document.getElementById('scelta_top').setAttribute('checked','checked');
        }        
    
    </script>

<?php
}





function aggiungi_campi_aggiuntivi_descrizione(){ 

    global $post;

    $tab_campo_descrizione_cose = get_post_meta( $post->ID, 'tab_campo_descrizione_cose', true);
    $tab_campo_descrizione_a_cosa_serve = get_post_meta( $post->ID, 'tab_campo_descrizione_a_cosa_serve', true);
    $tab_campo_descrizione_consigli_duso = get_post_meta( $post->ID, 'tab_campo_descrizione_consigli_duso', true);
    $tab_campo_descrizione_a_chi_e_o_non_indicato = get_post_meta( $post->ID, 'tab_campo_descrizione_a_chi_e_o_non_indicato', true);
    $tab_campo_descrizione_ingredienti = get_post_meta( $post->ID, 'tab_campo_descrizione_ingredienti', true);
    $tab_campo_descrizione_risultato_finale = get_post_meta( $post->ID, 'tab_campo_descrizione_risultato_finale', true);

?>
     
<div class="row align-items-start justify-content-center" style="padding: 0% 0%;">
    <div class="col">
        <label>Cos'è</label>
        <textarea rows="5" style="width:100%; margin: 1% 0%;" name="tab_campo_descrizione_cose"><?php echo $tab_campo_descrizione_cose; ?></textarea>
        <p style="color: #c7c6c6;  font-size: 0.6rem;">Post-meta: 'tab_campo_descrizione_cose'</p>
    </div>
    <div class="col">
        <label>A cosa serve</label>
        <textarea rows="5" style="width:100%; margin: 1% 0%;" name="tab_campo_descrizione_a_cosa_serve"><?php echo $tab_campo_descrizione_a_cosa_serve; ?></textarea>
        <p style="color: #c7c6c6;  font-size: 0.6rem;">Post-meta: 'tab_campo_descrizione_a_cosa_serve'</p>
    </div>
</div>
<div class="row align-items-start justify-content-center" style="padding: 0% 0%;">
    <div class="col">
        <label>A chi è/non è indicato</label>
        <textarea rows="5" style="width:100%; margin: 1% 0%;" name="tab_campo_descrizione_a_chi_e_o_non_indicato"><?php echo $tab_campo_descrizione_a_chi_e_o_non_indicato; ?></textarea>
        <p style="color: #c7c6c6;  font-size: 0.6rem;">Post-meta: 'tab_campo_descrizione_a_chi_e_o_non_indicato'</p>
    </div>
    <div class="col">
        <label>Consigli d'uso</label>
        <textarea rows="5" style="width:100%; margin: 1% 0%;" name="tab_campo_descrizione_consigli_duso"><?php echo $tab_campo_descrizione_consigli_duso; ?></textarea>
        <p style="color: #c7c6c6;  font-size: 0.6rem;">Post-meta: 'tab_campo_descrizione_consigli_duso'</p>
    </div>
</div>
<div class="row align-items-start justify-content-center" style="padding: 0% 0%;">
    <div class="col">
        <label>Ingredienti</label>
        <textarea rows="5" style="width:100%; margin: 1% 0%;" name="tab_campo_descrizione_ingredienti"><?php echo $tab_campo_descrizione_ingredienti; ?></textarea>
        <p style="color: #c7c6c6;  font-size: 0.6rem;">Post-meta: 'tab_campo_descrizione_ingredienti'</p>
    </div>
    <div class="col">
        <label>Risultato finale</label>
        <textarea rows="5" style="width:100%; margin: 1% 0%;" name="tab_campo_descrizione_risultato_finale"><?php echo $tab_campo_descrizione_risultato_finale; ?></textarea>
        <p style="color: #c7c6c6;  font-size: 0.6rem;">Post-meta: 'tab_campo_descrizione_risultato_finale'</p>
    </div>
</div>


<?php    
}


function aggiungi_campo_punti_fedeltà(){ 

    global $post;

    $valore_punti_fedeltà = get_post_meta( $post->ID, 'valore_punti_fedeltà', true);

?>


<div class="row align-items-start justify-content-center" style="padding: 0% 0%;">
    <div class="col">
        <label>Punti fedeltà</label>
        <input style="width:100%; margin: 1% 0%;" type="number" name="valore_punti_fedeltà" value="<?php echo $valore_punti_fedeltà; ?>">
        <p style="color: #c7c6c6;  font-size: 0.6rem;">Post-meta: 'valore_punti_fedeltà'</p>
    </div>
</div>

<?php
}


function aggiungi_campi_caratteristiche_prodotti_capelli(){ 

    global $post;

    $caratteristica_tipologia_capello = get_post_meta( $post->ID, 'caratteristica_tipologia_capello', true);
    $caratteristica_tipologia_cuoio_capelluto = get_post_meta( $post->ID, 'caratteristica_tipologia_cuoio_capelluto', true);
    $caratteristica_colore_capello = get_post_meta( $post->ID, 'caratteristica_colore_capello', true);
    $caratteristica_capello_trattato = get_post_meta( $post->ID, 'caratteristica_capello_trattato', true);


?>


<div class="row align-items-start justify-content-center" style="padding: 0% 0%;">
    <div class="col">
        <label>Tipologia capello</label>

        <select style="width:100%; margin: 1% 0%;" name="caratteristica_tipologia_capello" value="<?php echo $caratteristica_tipologia_capello; ?>">

        <?php 
        if(get_post_meta( $post->ID, 'caratteristica_tipologia_capello', true) != ''){
        ?>
        
        <option selected value="<?php echo get_post_meta( $post->ID, 'caratteristica_tipologia_capello', true); ?>">
        Precedente selezione: <?php echo get_post_meta( $post->ID, 'caratteristica_tipologia_capello', true); ?>
        </option>

        <?php
        }
        ?>

        <option value="">Nessuna</option>

        <?php 

        $taxonomies = get_terms( array(
        'parent' => 125,
        'childless' => true,
        'taxonomy' => 'caratteristiche_prodotti_capelli',
        'hide_empty' => false 
        ) );

        ?>

        <?php 

        foreach($taxonomies as $taxonomie){ 
        echo '
        <option value="' . trim($taxonomie->name) . '">' . trim($taxonomie->name) . '</option>';
        } 

        ?>
        
        </select>

        <p style="color: #c7c6c6;  font-size: 0.6rem;">Post-meta: 'caratteristica_tipologia_capello'</p>

    </div>

    <div class="col">
        <label>Tipologia cuoio capelluto</label>

        <select style="width:100%; margin: 1% 0%;" name="caratteristica_tipologia_cuoio_capelluto" value="<?php echo $caratteristica_tipologia_cuoio_capelluto; ?>">

        <?php 
        if(get_post_meta( $post->ID, 'caratteristica_tipologia_cuoio_capelluto', true) != ''){
        ?>
        
        <option selected value="<?php echo get_post_meta( $post->ID, 'caratteristica_tipologia_cuoio_capelluto', true); ?>">
        Precedente selezione: <?php echo get_post_meta( $post->ID, 'caratteristica_tipologia_cuoio_capelluto', true); ?>
        </option>

        <?php
        }
        ?>

        <option value="">Nessuna</option>

        <?php 

        $taxonomies = get_terms( array(
        'parent' => 129,
        'childless' => true,
        'taxonomy' => 'caratteristiche_prodotti_capelli',
        'hide_empty' => false 
        ) );

        ?>

        <?php 

        foreach($taxonomies as $taxonomie){ 
        echo '
        <option value="' . trim($taxonomie->name) . '">' . trim($taxonomie->name) . '</option>';
        } 

        ?>

        </select>

        <p style="color: #c7c6c6;  font-size: 0.6rem;">Post-meta: 'caratteristica_tipologia_cuoio_capelluto'</p>

    </div>
</div>

<div class="row align-items-start justify-content-center" style="padding: 0% 0%;">
    <div class="col">

        <label>Colore capello</label>

        <select style="width:100%; margin: 1% 0%;" name="caratteristica_colore_capello" value="<?php echo $caratteristica_colore_capello; ?>">

        <?php 
        if(get_post_meta( $post->ID, 'caratteristica_colore_capello', true) != ''){
        ?>
        
        <option selected value="<?php echo get_post_meta( $post->ID, 'caratteristica_colore_capello', true); ?>">
        Precedente selezione: <?php echo get_post_meta( $post->ID, 'caratteristica_colore_capello', true); ?>
        </option>

        <?php
        }
        ?>

        <option value="">Nessuna</option>

        <?php 

        $taxonomies = get_terms( array(
        'parent' => 134,
        'childless' => true,
        'taxonomy' => 'caratteristiche_prodotti_capelli',
        'hide_empty' => false 
        ) );

        ?>

        <?php 

        foreach($taxonomies as $taxonomie){ 
        echo '
        <option value="' . trim($taxonomie->name) . '">' . trim($taxonomie->name) . '</option>';
        } 

        ?>
        
        </select>

        <p style="color: #c7c6c6;  font-size: 0.6rem;">Post-meta: 'caratteristica_colore_capello'</p>

    </div>
    <div class="col">

        <label>Capello trattato</label>
        
        <select style="width:100%; margin: 1% 0%;" name="caratteristica_capello_trattato" value="<?php echo $caratteristica_capello_trattato; ?>">

        <?php 
        if(get_post_meta( $post->ID, 'caratteristica_capello_trattato', true) != ''){
        ?>
        
        <option selected value="<?php echo get_post_meta( $post->ID, 'caratteristica_capello_trattato', true); ?>">
        Precedente selezione: <?php echo get_post_meta( $post->ID, 'caratteristica_capello_trattato', true); ?>
        </option>

        <?php
        }
        ?>

        <option value="">Nessuna</option>

        <?php 

        $taxonomies = get_terms( array(
        'parent' => 141,
        'childless' => true,
        'taxonomy' => 'caratteristiche_prodotti_capelli',
        'hide_empty' => false 
        ) );

        ?>

        <?php 

        foreach($taxonomies as $taxonomie){ 
        echo '
        <option value="' . trim($taxonomie->name) . '">' . trim($taxonomie->name) . '</option>';
        } 

        ?>
        
        </select>

        <p style="color: #c7c6c6;  font-size: 0.6rem;">Post-meta: 'caratteristica_capello_trattato'</p>

    </div>
</div>

<?php
}



function aggiungi_campo_peso_volumetrico(){ 

    global $post;

    $peso_volumetrico = get_post_meta( $post->ID, 'peso_volumetrico', true);

?>


<div class="row align-items-start justify-content-center" style="padding: 0% 0%;">
    <div class="col">
        <label>Peso volumetrico</label>
        <input style="width:100%; margin: 1% 0%;" type="number" name="peso_volumetrico" value="<?php echo $peso_volumetrico; ?>">
        <p style="color: #c7c6c6;  font-size: 0.6rem;">Post-meta: 'peso_volumetrico'</p>
    </div>
</div>

<?php
}




function salva_campi_aggiuntivi_descrizione(){
  
    global $post;

    
        if(isset($_POST["tab_campo_descrizione_cose"])) :
            update_post_meta($post->ID, 'tab_campo_descrizione_cose', $_POST["tab_campo_descrizione_cose"]);
        endif;
        if(isset($_POST["tab_campo_descrizione_a_cosa_serve"])) :
            update_post_meta($post->ID, 'tab_campo_descrizione_a_cosa_serve', $_POST["tab_campo_descrizione_a_cosa_serve"]);
        endif;
        if(isset($_POST["tab_campo_descrizione_consigli_duso"])) :
            update_post_meta($post->ID, 'tab_campo_descrizione_consigli_duso', $_POST["tab_campo_descrizione_consigli_duso"]);
        endif;
        if(isset($_POST["tab_campo_descrizione_a_chi_e_o_non_indicato"])) :
            update_post_meta($post->ID, 'tab_campo_descrizione_a_chi_e_o_non_indicato', $_POST["tab_campo_descrizione_a_chi_e_o_non_indicato"]);
        endif;
        if(isset($_POST["tab_campo_descrizione_ingredienti"])) :
            update_post_meta($post->ID, 'tab_campo_descrizione_ingredienti', $_POST["tab_campo_descrizione_ingredienti"]);
        endif;
        if(isset($_POST["tab_campo_descrizione_risultato_finale"])) :
            update_post_meta($post->ID, 'tab_campo_descrizione_risultato_finale', $_POST["tab_campo_descrizione_risultato_finale"]);
        endif;
        if(isset($_POST["valore_punti_fedeltà"])) :
            update_post_meta($post->ID, 'valore_punti_fedeltà', $_POST["valore_punti_fedeltà"]);
        endif;

        if(isset($_POST["peso_volumetrico"])) :
            update_post_meta($post->ID, 'peso_volumetrico', $_POST["peso_volumetrico"]);
        endif;
        
        if(isset($_POST["caratteristica_tipologia_capello"])) :
            update_post_meta($post->ID, 'caratteristica_tipologia_capello', $_POST["caratteristica_tipologia_capello"]);
        endif;
        if(isset($_POST["caratteristica_tipologia_cuoio_capelluto"])) :
            update_post_meta($post->ID, 'caratteristica_tipologia_cuoio_capelluto', $_POST["caratteristica_tipologia_cuoio_capelluto"]);
        endif;
        if(isset($_POST["caratteristica_colore_capello"])) :
            update_post_meta($post->ID, 'caratteristica_colore_capello', $_POST["caratteristica_colore_capello"]);
        endif;
        if(isset($_POST["caratteristica_capello_trattato"])) :
            update_post_meta($post->ID, 'caratteristica_capello_trattato', $_POST["caratteristica_capello_trattato"]);
        endif; 

        if(isset($_POST["acquistato_n_volte"])) :
            update_post_meta($post->ID, 'acquistato_n_volte', $_POST["acquistato_n_volte"]);
        endif; 

        if(isset($_POST["acquistato_n_volte"])) :
            update_post_meta($post->ID, 'acquistato_n_volte', $_POST["acquistato_n_volte"]);
        endif; 

        if(isset($_POST["consigliato_da_helu"])) :
            update_post_meta($post->ID, 'consigliato_da_helu', $_POST["consigliato_da_helu"]);
        endif; 

        if(!isset($_POST["consigliato_da_helu"])) :
            update_post_meta($post->ID, 'consigliato_da_helu', "");
        endif; 

        if(isset($_POST["scelta_top"])) :
            update_post_meta($post->ID, 'scelta_top', $_POST["scelta_top"]);
        endif; 
        
        if(!isset($_POST["scelta_top"])) :
            update_post_meta($post->ID, 'scelta_top', "");
        endif; 
        


    }
      
    add_action('save_post', 'salva_campi_aggiuntivi_descrizione');



///////////////////////////////// END Aggiunta di metaboxes per i prodotti wooocommerce ///////////////////////////////////////////////



?>
