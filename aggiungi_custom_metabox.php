<?php

function crea_gallery_metabox(){
  
add_meta_box(
  'gallery_metabox', //id
  'Galleria del post', // titolo
  'aggiungi_contenuto_interfaccia_metabox_gallery', // funzione 
  'post' // post type
);

}

add_action('add_meta_boxes', 'crea_gallery_metabox');


function aggiungi_contenuto_interfaccia_metabox_gallery(){ 

global $post; 

$_evento_breve_descrizione = get_post_meta( $post->ID, '_evento_breve_descrizione', true);
              
?> 

<div class="container-fluid m-0 p-0">
        <div class="row">
            <div class="col-12">
                <label>Breve descrizione</label><br>
                <textarea rows="5" style="width:100%" name="_evento_breve_descrizione" placeholder=""><?php echo $_evento_breve_descrizione; ?></textarea>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
            <p style="color:gray; font-size:0.65rem;">
            post_type: "post"<br>
            meta_key: "_evento_breve_descrizione"<br>
            </p>
            </div>
        </div>
</div>
     
<?php 

} 

function salva_dati_gallery_metabox(){
  
global $post;
          
if(isset($_POST["_evento_giorno"])) :
update_post_meta($post->ID, '_evento_giorno', $_POST["_evento_giorno"]);
endif;
       
}
          
add_action('save_post', 'salva_dati_gallery_metabox');

?>
