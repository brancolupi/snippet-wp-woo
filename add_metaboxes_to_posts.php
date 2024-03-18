////////////////////////// START AGGIUNTA METABOX C/FIELDS PER DFLIP PDF /////////////////////////////////////////////////////////////////
<?php
    function crea_dflip_metabox(){
  
        add_meta_box(
                'dflip_metabox', //id
                'Impostazioni dflip agiguntive', // titolo
                'aggiungi_dflip_fields', // funzione 
                'dflip' // post type
            );
    }
    add_action('add_meta_boxes', 'crea_dflip_metabox');

    function aggiungi_dflip_fields(){ 

        global $post; 

        $_pdf_anno_magazine = get_post_meta( $post->ID, '_pdf_anno_magazine', true);
        $_pdf_numero_magazine = get_post_meta( $post->ID, '_pdf_numero_magazine', true);

       
    ?> 

    <div class="row">
            <label>Anno</label><input style="width:50%" type="number" name="_pdf_anno_magazine" value="<?php echo $_pdf_anno_magazine; ?>"> 
            <label>Numero</label><input style="width:50%" type="number" name="_pdf_numero_magazine" value="<?php echo $_pdf_numero_magazine; ?>">
    </div>
     
    <?php    
    }

    function salva_dflip_metabox(){
  
        global $post;
          
          
            if(isset($_POST["_pdf_anno_magazine"])) :
                update_post_meta($post->ID, '_pdf_anno_magazine', $_POST["_pdf_anno_magazine"]);
            endif;
          
            if(isset($_POST["_pdf_numero_magazine"])) :
                update_post_meta($post->ID, '_pdf_numero_magazine', $_POST["_pdf_numero_magazine"]);
            endif;
          
         
        }
          
    add_action('save_post', 'salva_dflip_metabox');

?>

    ////////////////////////// END AGGIUNTA METABOX C/FIELDS PER DFLIP PDF /////////////////////////////////////////////////////////////////
