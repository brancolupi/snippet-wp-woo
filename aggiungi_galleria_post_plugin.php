<?php
/*
 * Plugin Name:       Aggiungi galleria ai post wordpress
 * Plugin URI:        https://www.cinquepuntozero.it
 * Description:       Aggiungi galleria ai post wordpress
 * Version:           1.0.0
 * Author:            Lucio Asciolla Full Stack Web Developer
 * Author URI:        https://www.cinquepuntozero.it
 * License:           GPL v2 or later
 * License URI:       HTTPS://WWW.GNU.ORG/LICENSES/GPL-2.0.HTML
 * Update URI:        HTTPS://EXAMPLE.COM/MY-PLUGIN/
 * Text Domain:       custom-plugin
 * Domain Path:       /languages
 */
?>

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

<!-- start metabox container -->
<div class="container-fluid m-0 p-0"> 
	 	
		<div class="row mt-4 mb-2 text-center"> 
            <label>Aggungi immagini alla galleria</label><br>
		</div>
	
		<div class="row align-items-center justify-content-center mt-2 mb-4 text-center">
			<div class="col-2">
				<p class="image_add_button" style="background: #436aff; padding: 1% 5%; border-radius: 5px; color: white; cursor:pointer;">Aggiungi altra immagine</p>
			</div>	
		</div>	
       
		<!-- start load image section -->
				
		<div class="row align-items-center justify-content-center"> 
			<div id="container_box_image_load" class="row mt-2 mb-2">
				<div image_loader_number="1" class="col-2 image_loader" style="position:relative;">
					<p 
					   class="image_remove_button" 
					   style="position: absolute; top: -2%; right: 0%; background: #BA2F2F; padding: 1% 5%; border-radius: 5px; color: white; cursor:pointer;" 
					   onclick="removeImage(1)"
					>Rimuovi</p>
					<p 
					   class="image_delete_button" 
					   style="position: absolute; top: 7%; right: 0%; background: #BA2F2F; padding: 1% 5%; border-radius: 5px; color: white; cursor:pointer;" 
					   onclick="deleteImage(1)"
					>Elimina</p>
					<img 
						 id="image_view_1" 
						 src="<?php if( get_post_meta( $post->ID, 'image_gallery_1', false) ){ echo get_post_meta( $post->ID, 'image_gallery_1', false); }else{ echo '/wp-content/uploads/2024/03/image_placeholder.jpg'; } ?>" style="width: 100%;"
						 >
					<br>
					<div class="row mt-2 mb-2 ms-2">
						<input 
							   id="image_load_input_1" 
							   type="file" 
							   name="_image_gallery_1" 
							   value="" 
							   onchange="letturaFile(1)">
					</div>
					
					<script>
						function letturaFile(number){
							var campoFile = document.getElementById(`image_load_input_${number}`);
							var immagine = document.getElementById(`image_view_${number}`);	
							fileCaricato = campoFile.files[0];

							var reader = new FileReader();
							reader.readAsDataURL(fileCaricato);

							reader.onload = function(event){
							immagine.src = reader.result; 
							}
						}	
						
						function removeImage(number){
							document.getElementById(`image_view_${number}`).setAttribute("src", "/wp-content/uploads/2024/03/image_placeholder.jpg");
							document.getElementById(`image_load_input_${number}`).setAttribute("value", "");
						}
						
						function deleteImage(number){
							document.querySelector(`div[image_loader_number="${number}"]`).remove();
						}
					</script>
			
					
				</div>
			</div>

        </div> 
			
		<!-- end load load section -->
			
		<script>
					
		
		function counter_of_image_loader(){
			
			all_image_loader_number = document.querySelectorAll('.image_loader');
			number_of_image_loader_number = all_image_loader_number.length;
			counter_last_image_loader = all_image_loader_number[number_of_image_loader_number-1].getAttribute('image_loader_number');

			console.log(Number(counter_last_image_loader));
			
		}
			
		counter_of_image_loader();
		
		var container_box_image_load = document.getElementById('container_box_image_load');
		var image_add_button = document.querySelector('.image_add_button');
			image_add_button.addEventListener('click', function(){
				var nuovo_load_box = document.createElement('div');
				nuovo_load_box.classList.add('col-2');
				nuovo_load_box.classList.add('image_loader');
				nuovo_load_box.style.cssText='position:relative;';
				nuovo_load_box.setAttribute('image_loader_number', Number(counter_last_image_loader) + 1);
				nuovo_load_box.innerHTML= `
					<p 
					   class="image_remove_button" 
					   style="position: absolute; top: -2%; right: 0%; background: #BA2F2F; padding: 1% 5%; border-radius: 5px; color: white; cursor:pointer;" 
					   onclick="removeImage( ${Number(counter_last_image_loader) + 1} );"
					   >Rimuovi</p>
					<p 
					   class="image_delete_button" 
					   style="position: absolute; top: 7%; right: 0%; background: #BA2F2F; padding: 1% 5%; border-radius: 5px; color: white; cursor:pointer;" 
					   onclick="deleteImage( ${Number(counter_last_image_loader) + 1} )"
						>Elimina</p>
					<img id="image_view_${Number(counter_last_image_loader) + 1}" src="/wp-content/uploads/2024/03/image_placeholder.jpg" 
					style="width: 100%;"><br>
					<div class="row mt-2 mb-2 ms-2">
						<input 
							id="image_load_input_${Number(counter_last_image_loader) + 1}" 
							type="file" name="_image_gallery_${Number(counter_last_image_loader) + 1}" 
							value="" 
							onchange="letturaFile(${Number(counter_last_image_loader) + 1})";
						>
					</div>`;
			
			container_box_image_load.appendChild(nuovo_load_box);
				
			counter_of_image_loader();
				
			})
		</script>
			
        <div class="row mt-3"> 
            <div class="col-12">
            <p style="color:gray; font-size:0.65rem;">
            post_type: "post"<br>
            meta_key: "_image_gallery_*"<br>
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
          
add_action('save_post', 'salva_gallery_metabox');

?>




<?php 

///////////// START Abilitare $_FILES aggiungendo "multipart/form-data" al form dei post ///////////////
if (is_admin()) {
$current_admin_page = substr(strrchr($_SERVER['PHP_SELF'], '/'), 1, -4);
if ($current_admin_page == 'page' 
|| $current_admin_page == 'page-new' 
|| $current_admin_page == 'post' 
   || $current_admin_page == 'post-new') {

/** Need to force the form to have the correct enctype. */
function aggiungi_post_enctype() {
echo "<script type=\"text/javascript\">
document.addEventListener('DOMContentLoaded', function() {
  var postForm = document.getElementById('post');
  postForm.setAttribute('enctype', 'multipart/form-data');
  postForm.setAttribute('encoding', 'multipart/form-data');
});
</script>";
}

add_action('admin_head', 'aggiungi_post_enctype');
}
}
///////////// END Abilitare $_FILES aggiungendo "multipart/form-data" al form dei post ///////////////

/////////// START Abilitare BOOTSTAP CSS Framework  C/CDN nella font-end e nel backend ///////////////
function abilita_bootstrap_css_framework() {
    wp_enqueue_style( 'bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' );
}

add_action('wp_enqueue_scripts', 'abilita_bootstrap_css_framework'); // Front-end
add_action('admin_enqueue_scripts', 'abilita_bootstrap_css_framework'); // Back-end
   
/////////// START Abilitare BOOTSTAP CSS Framework  C/CDN nella font-end e nel backend ///////////////

?>
