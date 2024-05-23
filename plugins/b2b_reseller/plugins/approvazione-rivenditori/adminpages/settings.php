<div class="container-fluid">
	<div class="row align-items-center justify-content-center text-center">
		<h1>Utenti B2B da approvare</h1>
		<h2 id="notifica_azioni_b2b"></h2>
	</div>
	<div class="row align-items-center justify-content-center text-center pt-5 pb-5">
		
		<div class="row mb-3">
			<div class="col-1" style="border:1px solid;">
				ID
			</div>
			<div class="col-1" style="border:1px solid;">
				Ragione sociale
			</div>
			<div class="col-2" style="border:1px solid;">
				Indirizzo
			</div>
			<div class="col-1" style="border:1px solid;">
				Città
			</div>
			<div class="col-1" style="border:1px solid;">
				Provincia
			</div>
			<div class="col-1" style="border:1px solid;">
				Nazione
			</div>
			<div class="col-2" style="border:1px solid;">
				Email
			</div>
			<div class="col-1" style="border:1px solid;">
				Telefono
			</div>
			<div class="col-1" style="border:1px solid;">
				P.IVA
			</div>
			<div class="col-1" style="border:1px solid;">
				Azioni
			</div>
		</div>
		
		<?php
		$args =   array( 'role' => 'Pending' );
		$available_users = get_users($args);

		foreach($available_users as $user){  ?>
		
		<div class="row">
			<div class="col-1">
				<?php echo $user->ID; ?>
			</div>
			<div class="col-1">
				<?php echo get_user_meta($user->ID, 'billing_company', true) ?>
			</div>
			<div class="col-2">
				<?php echo get_user_meta($user->ID, 'billing_address_1', true) ?>
			</div>
			<div class="col-1">
				<?php echo get_user_meta($user->ID, 'billing_city', true) ?>
			</div>
			<div class="col-1">
				<?php echo get_user_meta($user->ID, 'billing_state', true) ?>
			</div>
			<div class="col-1">
				<?php echo get_user_meta($user->ID, 'billing_country', true) ?>
			</div>
			<div class="col-2">
				<?php echo get_user_meta($user->ID, 'billing_email', true) ?>
			</div>
			<div class="col-1">
				<?php echo get_user_meta($user->ID, 'billing_phone', true) ?>
			</div>
			<div class="col-1">
				<?php echo get_user_meta($user->ID, 'p_iva_rivenditore', true) ?>
			</div>
			<div class="col-1">
				<button style="border-radius:5px;" onclick="approvaUtente(<?php echo $user->ID; ?>)">APPROVA</button>
			</div>
		</div>
		
		<?php
		}

		?>
	</div>
	
	<script>
		
	var notifica_azioni_b2b = document.getElementById('notifica_azioni_b2b');	
		
	function approvaUtente(id){

		xhttpApprovaUtente = new XMLHttpRequest();

			xhttpApprovaUtente.onreadystatechange = function(){
				if(this.readyState == 4 && this.status == 200){
					notifica_azioni_b2b.innerHTML = this.responseText;
					setTimeout(() => {
						location.reload();
					}, 1000);
					}                   
			}

		xhttpApprovaUtente.open("GET", `/wp-content/themes/helu/inc/ajax-approva-b2b.php?id_utente_b2b=${id}`, true);
		xhttpApprovaUtente.send();
	}
	</script>
	
</div>