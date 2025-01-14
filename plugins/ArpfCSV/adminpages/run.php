<div class="container-fluid" style="padding:2% 10%;">

    <!-- START PRESENTATION -->
	<div class="row py-2 px-1 mb-4" style="border:1px solid black;">
		<div class="col">
			<h1 class="m-0">ARPF-CSV Auto recovery products from *.csv file</h1>
			<div class="row">
				<div class="col"><p class="m-0">Powered by Holly Agency</p></div>
				<div class="col text-end"><p class="m-0">Developed by Lucio Asciolla</p></div>
			</div>
		</div>
	</div>
    <!-- END PRESENTATION -->

    <!-- START FORM ELABORAZIONE MANUALE -->

    <form id="elaborazione-manuale-csv" name="elaborazione-manuale-csv" action="" method="GET">
        <div class="row">
            <div class="col">
                <h2>Elaborazione manuale</h2>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p class="m-0 my-1"><span style="font-weight:bold;">Nome file: </span><?php echo $_SERVER['DOCUMENT_ROOT'] . "/wp-content/plugins/ArpfCSV/deposit/ "; ?><input name="csvFileName" type="text" value="drop_finale.csv"  style="min-height: 15px;"></p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p class="m-0 my-1"><span style="font-weight:bold;">Delimitatore: </span><input name="delimiter" type="text" value="|" style="min-height: 15px;"></p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p class="m-0 my-1"><span style="font-weight:bold;">Dimensione chunk: </span><input name="chunkSize" type="number" value="1000" style="min-height: 15px;"></p>
            </div>
        </div>
        <div class="row align-items-center justify-content-start text-start my-4">
            <div class="col-6">
                <button id="bottone-elaborazione" type="submit" style="border: 1px solid black; background: white; padding: 0.2% 20%; border-radius:5px;">Elabora file</button>
            </div>
        </div>
    </form>

    <script>
        document.getElementById('bottone-elaborazione').addEventListener('click', function(event){

        event.preventDefault();

        const form = document.getElementById('elaborazione-manuale-csv');
        const formData = new FormData(form);

        // // Creare una stringa di query con i dati del form
        const urlParams = new URLSearchParams(formData);

        // console.log(urlParams.toString());

        // const eventSource = new EventSource(`https://charming-margulis.78-46-83-170.plesk.page/wp-content/plugins/ArpfCSV/adminpages/execution_elaboration.php?${urlParams.toString()}`);
        const eventSource = new EventSource(`https://charming-margulis.78-46-83-170.plesk.page/wp-content/plugins/ArpfCSV/adminpages/mixed_processing.php`);

        eventSource.addEventListener('message', function(event){
			// console.log(event.data);
			switch(event.data.includes("EOF")){
				case true:
					eventSource.close();
					// document.getElementById('output-elaborazione').innerHTML = JSON.stringify(JSON.parse(event.data.replace("EOF", "")), null, 2); // 2 spazi di indentazione
                    // console.log(event.data.replace("EOF", ""));
                    console.log(event.data);
                    break;
				default:
					const progress = parseInt(event.data); // Converti in numero intero
					document.getElementById('percent-bar').style.width = String(progress) + '%';
					document.getElementById('percent-number').innerText = String(progress);
			}
		})

        eventSource.addEventListener('error', function(event){
            console.log(event.data);
        })

    });

    </script>
    
    <!-- END FORM ELABORAZIONE MANUALE -->
    
    <div class="row align-items-center justify-content-start text-start my-4">
            <div class="col-6">
                <p>Progresso <span id="percent-number">0</span>%</p>
                <div style="width: 100%; background: #e1e1e1; height: 1vh; border-radius:5px;">
                    <div id="percent-bar" style="width: 1%; background: green; height: 1vh; border-radius:5px;"></div>
                </div>
            </div>
    </div>

	<div class="row align-items-center justify-content-start text-start my-4">
		<div class="col-6">
		<button id="bottone-caricamento-prodotti" style="border: 1px solid black; background: white; padding: 0.2% 20%; border-radius:5px;" onclick="loadProducts();">Carica prodotti</button>
		</div>
    </div>

	<script>
		function loadProducts(){
			console.log('Caricamento in corso...');
			// Invia la richiesta AJAX
			fetch('/wp-content/plugins/ArpfCSV/adminpages/load_products.php' , { method: 'POST'} )
				.then(response => response.text())
				.then(data => {
				console.log(data); // Gestisci la risposta del server
				})
				.catch(error => {
				console.error('Errore:', error);
				});
		}

	</script>

	<!-- <div class="row py-3">
		<div class="col">
			<p style="font-weight:bold;">Output</p>
			<pre id="output-elaborazione" style="display: block; height: 20vh; background: black; color: green; padding: 1% 2%;  font-size:0.75rem;">//Lettura file *.csv<br><br></pre>
		</div>
	</div> -->
	<div class="row">
		<div class="col">
			<p><span style="font-weight:bold;">Esempio utilizzo API WOOCOMMERCE</span></p>
			<p class="m-0"><span style="font-weight:bold;">Endpoint:</span> https://optimistic-noether.78-46-83-170.plesk.page/wp-json/wc/v2/products?consumer_key=ck_0313fb8cacbe7f5d33efc155fb03e259ce6df3ee&consumer_secret=cs_d5a73073d5d5fc8e344672467f990fdd928e8216</p>
			<p class="m-0 mb-4"><span style="font-weight:bold;">Body request:</span></p>
			<pre style="display: block; height: 50vh; background: black; color: green; padding: 1% 2%; font-size:0.75rem;">
			{
				"name" : "Prodotto generico 3",
				"type" : "simple",
				"regular_price" : "19.99",
				"sale_price" : "10.00",
				"sku" : "",
				"description" : "Descirizone del prodotto generico",
				"short_description" : "Breve descrizione del prodotto generico",
				"meta_data" : [
					{ "key": "acquistato_n_volte", "value" : "1" },
					{ "key": "valore_punti_fedeltà", "value" : "25" },
					{ "key": "peso_volumetrico", "value" : "50" },
					{ "key": "tab_campo_descrizione_cose", "value" : "Cos'è lorem ipsum" },
					{ "key": "tab_campo_descrizione_a_cosa_serve", "value" : "A cosa serve lorem ipsum" },
					{ "key": "tab_campo_descrizione_a_chi_e_o_non_indicato", "value" : "A chi è/non è indicato lorem ipsum" },
					{ "key": "tab_campo_descrizione_consigli_duso", "value" : "Consigli d'uso lorem ipsum" },
					{ "key": "tab_campo_descrizione_ingredienti", "value" : "Ingredienti lorem ipsum" },
					{ "key": "tab_campo_descrizione_risultato_finale", "value" : "Risultato finale lorem ipsum" },
					{ "key": "consigliato_da_helu", "value" : "1" },
					{ "key": "scelta_top", "value" : "1" }
				],
				"categories": [
					{ "id": "77" },
					{ "id": "176"}
				],
				"brand" : [ "alessi", "bluemarines" ],
				"caratteristiche_prodotti_capelli" : [ "capello-trattato", "tipologia-capello" ],
				"bollino" : [ "green", "naturale"],
				"caratteristiche" : [ "accessori-colore", "anti-pollution" ],
				"images" : [
					{ "src" : "https://optimistic-noether.78-46-83-170.plesk.page/wp-content/uploads/2023/09/dior-sauvage-eau-de-parfum-100ml.jpg" }
				],
				"gallery_images" : [
					{ "src" : "https://optimistic-noether.78-46-83-170.plesk.page/wp-content/uploads/2023/09/dior-sauvage-elixir-100-ml-1di0000000388-01_7568276e-3af8-43c6-8746-4b3373965b36.webp" },
					{ "src" : "https://optimistic-noether.78-46-83-170.plesk.page/wp-content/uploads/2023/09/dior-sauvage-elixir-100-ml-1di0000000388-04_b6b46824-fe8f-4f61-9207-bd848f8f7579_500x.webp" }
				]
			}
			</pre>
		</div>
	</div>
</div>	

