<?php
/*
 * Plugin Name:       Aggiungi galleria ai post wordpress
 * Plugin URI:        https://www.cinquepuntozero.it
 * Description:       Aggiungi galleria ai post wordpress
 * Version:           1.0.0
 * Author:            Lucio Asciolla Full Stack Web Developer
 * Author URI:        https://www.cinquepuntozero.it
 * Cellulare:	      +393477085217
 * Email:	          lucio.asciolla@gmail.com
 * License:           GPL v2 or later
 * License URI:       HTTPS://WWW.GNU.ORG/LICENSES/GPL-2.0.HTML
 * Update URI:        HTTPS://EXAMPLE.COM/MY-PLUGIN/
 * Text Domain:       custom-plugin
 * Domain Path:       /languages
 */
?>

<?php 

    ///////////// START Abilitare $_FILES aggiungendo "multipart/form-data" al form dei post ///////////////

    if(is_admin()){
    $current_admin_page = substr(strrchr($_SERVER['PHP_SELF'], '/'), 1, -4);
        
        if($current_admin_page == 'page' || $current_admin_page == 'page-new' || $current_admin_page == 'post' || $current_admin_page == 'post-new'){

            function aggiungi_post_enctype(){
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
       
		<!-- START Caricamento immagini box -->
				
		<div class="row align-items-center justify-content-center"> 
			
			<!--  START Recupero dati -->
			<div>
			
			<?php 
				$_esistenti_image_loaders_da_salvare = get_post_meta( $post->ID, '_esistenti_image_loaders_da_salvare', true);

				$_esistenti_image_loaders_urls = [];	
				foreach($_esistenti_image_loaders_da_salvare as $_esistenti_image_loader){
				$_esistenti_image_loaders_urls[] = get_post_meta($post->ID, $_esistenti_image_loader, true);
				}
			?>
				
			<input 
				type="hidden" 
				id="_esistenti_image_loaders_da_salvare" 
				name="_esistenti_image_loaders_da_salvare" 
				style="width:100%;"
				value="<?php if(get_post_meta($post->ID, '_esistenti_image_loaders_da_salvare', true)!= ''){ echo implode(',', get_post_meta($post->ID, '_esistenti_image_loaders_da_salvare', true)); } ?>">
				
			<input 
				type="hidden" 
				id="_esistenti_image_loaders_da_salvare_urls" 
				name="_esistenti_image_loaders_da_salvare_urls" 
   				style="width:100%;"
				value="<?php if($_esistenti_image_loaders_urls != ''){ echo implode(',', $_esistenti_image_loaders_urls); } ?>">
			
			</div>
			
			<!--  END Recupero dati -->
			
			
			<div id="container_box_image_load" class="row mt-2 mb-2">
				
				<!-- START Lavorazione dati e compilazione -->
				
				<script>
					
				var _esistenti_image_loaders_da_salvare = document.getElementById('_esistenti_image_loaders_da_salvare').value;
										
				var _esistenti_image_loaders_da_salvare_Array_Strs;
						if(_esistenti_image_loaders_da_salvare.value != ''){
							 _esistenti_image_loaders_da_salvare_Array_Strs = _esistenti_image_loaders_da_salvare.split(',')
						} else {
							_esistenti_image_loaders_da_salvare_Array_Strs = [];
						}
					
					_esistenti_image_loaders_da_salvare_Array_Ids = [];
					_esistenti_image_loaders_da_salvare_Array_Strs.forEach(function(image_loader){
								_esistenti_image_loaders_da_salvare_Array_Ids.push(image_loader.substring(15));	
					})
					
				var _esistenti_image_loaders_da_salvare_urls = document.getElementById('_esistenti_image_loaders_da_salvare_urls').value;
					
				var _esistenti_image_loaders_da_salvare_urls_Array_Strs;
						if(_esistenti_image_loaders_da_salvare_urls.value != ''){
							 _esistenti_image_loaders_da_salvare_urls_Array_Strs = _esistenti_image_loaders_da_salvare_urls.split(',');
						} else {
							_esistenti_image_loaders_da_salvare_urls_Array_Strs = [];
						}
					
				console.log(_esistenti_image_loaders_da_salvare_Array_Strs);
				console.log(_esistenti_image_loaders_da_salvare_Array_Ids);
					
				var container_box_image_load = document.getElementById('container_box_image_load');
				var container_box_image_load_content = '';
				var _esistenti_image_loaders_da_salvare_Array_Ids_length = _esistenti_image_loaders_da_salvare_Array_Ids.length;
					
				if(_esistenti_image_loaders_da_salvare_Array_Ids[0] != ''){	
					
				for(var x=0; x < _esistenti_image_loaders_da_salvare_Array_Ids_length; x++){
					container_box_image_load_content += `
					<div image_loader_number="${_esistenti_image_loaders_da_salvare_Array_Ids[x]}" class="col-2 image_loader" style="position:relative;">
						<p 
						   class="image_delete_button" 
						   style="position: absolute; top: -2%; right: 0%; background: #BA2F2F; padding: 1% 5%; border-radius: 5px; color: white; cursor:pointer;" 
						   onclick="deleteImage(${_esistenti_image_loaders_da_salvare_Array_Ids[x]})"
						>Elimina</p>
						<img 
							 id="image_view_${_esistenti_image_loaders_da_salvare_Array_Ids[x]}" 
							 src="${_esistenti_image_loaders_da_salvare_urls_Array_Strs[x]}" style="width: 100%;"
							 >
						<br>
						<div class="row mt-2 mb-2 ms-2">
							<input 
								   id="image_load_input_${_esistenti_image_loaders_da_salvare_Array_Ids[x]}" 
								   type="file" 
								   name="_image_gallery_${_esistenti_image_loaders_da_salvare_Array_Ids[x]}" 
								   value="" 
								   onchange="letturaFile(${_esistenti_image_loaders_da_salvare_Array_Ids[x]})">
						</div></div>`;
				}
					
				}
				
				container_box_image_load.innerHTML = container_box_image_load_content;
					
				</script>
				
				<!-- END Lavorazione dati e compilazione -->

				
					<script>
						
						var _esistenti_image_loaders_da_salvare;
						if(document.getElementById('_esistenti_image_loaders_da_salvare').value != ''){
							 _esistenti_image_loaders_da_salvare = (document.getElementById('_esistenti_image_loaders_da_salvare').value).split(','); 
						} else {
							_esistenti_image_loaders_da_salvare = [];
						}

						function aggiungi_inputs_name_da_salvare(number){
							var campoFile = document.getElementById(`image_load_input_${number}`);

			                            if(!_esistenti_image_loaders_da_salvare.includes(campoFile.getAttribute('name'))){
			                                _esistenti_image_loaders_da_salvare.push(campoFile.getAttribute('name'));
			                            }

   							document.getElementById('_esistenti_image_loaders_da_salvare').value = _esistenti_image_loaders_da_salvare.join(',');
                        			}

						function rimuovi_inputs_name_da_salvare(number){
							var campoFile = document.getElementById(`image_load_input_${number}`);
							var nameCampoFile = campoFile.getAttribute('name');
							var indexCampoFile = _esistenti_image_loaders_da_salvare.indexOf(nameCampoFile);
							_esistenti_image_loaders_da_salvare.splice(indexCampoFile, 1);
							document.getElementById('_esistenti_image_loaders_da_salvare').value = _esistenti_image_loaders_da_salvare.join(',');
						}
						
						function letturaFile(number){
							var campoFile = document.getElementById(`image_load_input_${number}`);
							var immagine = document.getElementById(`image_view_${number}`);	
							fileCaricato = campoFile.files[0];

							var reader = new FileReader();
							reader.readAsDataURL(fileCaricato);

							reader.onload = function(event){
							immagine.src = reader.result; 
							}
							
							aggiungi_inputs_name_da_salvare(number);
						}	
						
						function deleteImage(number){
							rimuovi_inputs_name_da_salvare(number);
							document.querySelector(`div[image_loader_number="${number}"]`).remove();
						}
					</script>
			
					
				</div>
			</div>

        </div> 
			
		<!-- END Caricamento immagini box -->
			
		<script>
					
		
		function counter_of_image_loader(){
			
			all_image_loader_number = document.querySelectorAll('.image_loader');
			number_of_image_loader_number = all_image_loader_number.length;
		            if(number_of_image_loader_number > 0 ){
		                counter_last_image_loader = all_image_loader_number[number_of_image_loader_number-1].getAttribute('image_loader_number');
		
		            }else{
		                counter_last_image_loader = 0;
		            }

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
					   class="image_delete_button" 
					   style="position: absolute; top: -2%; right: 0%; background: #BA2F2F; padding: 1% 5%; border-radius: 5px; color: white; cursor:pointer;" 
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
		<strong>post_type:</strong> "post"<br>
		<strong>meta_key:</strong> "_esistenti_image_loaders_da_salvare" (array serializzato es. a:4:{i:0;s:0:"";i:1;s:16:"_image_gallery_1";i:2;s:16:"_image_gallery_2";i:3;s:16:"_image_gallery_3";} )<br>
		<strong>meta_value:</strong> <?php if($_esistenti_image_loaders_da_salvare != ''){ echo implode(', ', $_esistenti_image_loaders_da_salvare); } ?> (deserializzato)
            </p>
            </div>
        </div> 

	
</div> 

     
<?php 

} 



function salva_dati_gallery_metabox(){
  
global $post;

if(isset( $_POST["_esistenti_image_loaders_da_salvare"] )){
	
	$_convert_array_from_string_js = explode( ',', str_replace( '"', '', str_replace( '[', '', str_replace(']', '', $_POST['_esistenti_image_loaders_da_salvare'] ) ) ) );
	update_post_meta( $post->ID, '_esistenti_image_loaders_da_salvare', $_convert_array_from_string_js );

    $counter_files = 0;

    foreach($_FILES as $file){

            if($file['tmp_name'] != ''){
                move_uploaded_file( $file['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/nikolaos/assets/img/post/' . $file['name'] );
                update_post_meta( $post->ID, $_convert_array_from_string_js[$counter_files], '/wp-content/themes/nikolaos/assets/img/post/' . $file['name'] );
            }
        
            $counter_files++;
    }

}
	
}

add_action('save_post', 'salva_dati_gallery_metabox');

?>
