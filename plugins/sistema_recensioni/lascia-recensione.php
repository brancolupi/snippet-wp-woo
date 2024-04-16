<?php 
/* Template Name: Lascia recensione
*/ ?>

<?php get_header(); ?>

<div class="container-fluid p-5" style="background:#F4F7FC;">
	
	<div class="row align-items-start justify-content-center text-center">
		<h1 style="color:#007fff;">Lascia la tua recensione</h1>
	</div>
	
	<form id="form_recensione" name="form_recensione" action="/" method="GET">
	
		<div class="row align-items-start justify-content-center text-start">
			<div class="col-3">
				<label style="color:#252628;">Nome*</label><br>
				<input type="text" name="nome_recensione" value="" required><br>
				<label style="color:#252628;">Cognome*</label><br>
				<input type="text" name="cognome_recensione" value="" required><br>
				<label style="color:#252628;">Email*</label><br>
				<input type="text" name="email_recensione" value="" required><br>
			</div>
			<div class="col-3">
				<label style="color:#252628;">Valutazione*</label><br>
				<input type="number" name="valutazione_recensione" value="5" min="1" max="5" required> / 5 <br>
				<label style="color:#252628;">Messaggio*</label><br>
				<textarea name="corpo_recensione" value="" style="width:100%;" rows="5" required><?php echo $corpo_recensione; ?></textarea><br>
			</div>
		</div>
		
		<div class="row align-items-start justify-content-center text-start mt-5 mb-3">
			<button id="bottone_recensione" class="bottone_recensione" style="padding: 1% 5%; background: white; border: 0px; border-radius:5px;" type="submit">INVIA VALUTAZIONE</button>
		</div>
		
		<div class="row align-items-start justify-content-center text-start mt-2 mb-5">
			<p id="notifica_recensione" style="color:#007fff; font-weight:bold;"></p>
			<?php //echo do_shortcode('[percentuale_voti]'); ?>
		</div>
		
	</form>
	
	<style>
		.bottone_recensione:hover{ outline: 2px solid #007fff; }
	</style>
	
	<script>
		
		var form_recensione = document.getElementById('form_recensione');
		var notifica_recensione = document.getElementById('notifica_recensione');
		var bottone_recensione = document.getElementById('bottone_recensione');
	
		function invia_recensione(){
			   
	    event.preventDefault();
			
            xhttpInvioRecensione = new XMLHttpRequest();

            var formData = new FormData(form_recensione);
    
                xhttpInvioRecensione.onreadystatechange = function(){
                    if(this.readyState == 4 && this.status == 200){
                        notifica_recensione.innerHTML = this.responseText;
						bottone_recensione.setAttribute('disabled', 'disabled');
						setTimeout(function(){ window.location.href="/"; } ,1500);
                        }                   
                }
    
            xhttpInvioRecensione.open("POST", '/wp-content/themes/itsoft-child/incs/ajax-recensioni.php', true);
            xhttpInvioRecensione.send(formData);
        }
		
		form_recensione.addEventListener("submit", invia_recensione);	

	</script>
	
</div>

<?php get_footer(); ?>
