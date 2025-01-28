<?php

        header('Content-Type: text/event-stream');

        define('WP_USE_THEMES', false);
        require_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
        require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/woocommerce/woocommerce.php');

        global $wordpress;
        global $woocommerce;
        global $wp_query;
        global $post;
        global $product;

        // Includi il file autoload.php
        require_once ABSPATH . 'vendor/autoload.php';
        use GuzzleHttp\Client; 
        use GuzzleHttp\Psr7\Request;
        
        // START Recuperare file da sito di terze parti

        // https://capellimonelli.it/drop2/drop_final.csv
        // si aggiorna il sabato alle 2
        // https://capellimonelli.it/drop2/drop_update.csv
        // si aggiorna ogni 15 minuti
        // Delimitatore di campo: |

        // $url = "https://www.esempio.com/percorso/al/file.csv"; // Sostituisci con l'URL reale
        // $csv_content = file_get_contents($url);
        
        // if($csv_content === false){ die("Errore durante il download del file.");} 

        // // Salva il contenuto in un file locale
        // file_put_contents("file.csv", $csv_content);
        
        // echo "File scaricato con successo!";

        // $source_file = "file.csv";
        // $destination_file = "/percorso/sul/tuo/host/file.csv"; // Sostituisci con il percorso di destinazione

        // if(copy($source_file, $destination_file)){ echo "File copiato con successo!"; } else { echo "Errore durante la copia del file."; }
        
        // Considerazioni importanti per PHP:
        // • allow_url_fopen: Assicurati che l'opzione allow_url_fopen sia abilitata nel tuo file php.ini. Questa opzione permette a PHP di accedere a URL tramite funzioni come file_get_contents().
        // • Gestione degli errori: Utilizza le funzioni is_writable() e error_get_last() per verificare la presenza di errori durante il download e la copia del file e per gestirli in modo appropriato.
        // • Contesto: Se il sito web di terze parti richiede autenticazione o l'impostazione di header specifici, puoi utilizzare la funzione stream_context_create() per configurare il contesto della richiesta HTTP. 

        // END Recuperare file da sito di terze parti

        // Dati per l'elaborazione dei CSV

        $csvFileName = (isset($_GET['csvFileName'])) ? (string)$_GET['csvFileName'] : "drop_finale.csv"; // $csvFileName = 'exemple.csv';
        $csvFileRoot = 'https://' . $_SERVER['HTTP_HOST'] . "/wp-content/plugins/ArpfCSV/deposit/" . $csvFileName;
        $csvDelimiter = (isset($_GET['delimiter'])) ? (string)$_GET['delimiter'] : "|"; // $csvDelimiter = ';'; 
        $chunkSize = (isset($_GET['chunkSize'])) ? (int)$_GET['chunkSize'] : 1000; // $chunkSize = 1000;


        // Dati per il caricamento di prodotti tramite API REST Woocommerce

        $consumer_key = "ck_57fcfa65b2b3326b9a1d5d50827dff660d0ce936"; // $consumer_key = 'tua_chiave_api';
        $consumer_secret = "cs_1329bbf5ab15f2e4a5c25a275843387bb5453a96"; // $consumer_secret = 'tuo_segreto_api';
        $url = 'https://' . $_SERVER['HTTP_HOST'] . '/wp-json/wc/v2/products?consumer_key=' . $consumer_key . '&consumer_secret=' . $consumer_secret; // $url = 'https://tuo-dominio.com/wp-json/wc/v3/products';   

        // START Calcolo percentuale di lettura file

        // Per calcolare la percentuale di lettura eseguita per il file csv, dobbiamo conoscere il numero totale di righe che sono contenute nel documento
        // e il punto/posizione in cui si trova il ciclo. La formula per calcolare la percentuale è la seguente: Percentuale di lettura = numero-riga-letta / totale-righe-documento x 100 
        
        $openFile = fopen($csvFileRoot, 'r'); // Aprire il file in modalità lettura ("r")

        $totalCountRows = 0; 
        while(($dataRowCount = fgetcsv($openFile, 1000, $csvDelimiter)) != false){ 
        	$totalCountRows++; 
        }

        fclose($openFile); // Chiudere il file

        $numberOfReadedRow = 0;
        $readedPercentual = 0;
        
        // END Calcolo percentuale di lettura file

        // START recupero valori per variazioni colore

        // Attualmente il csv contiene un unico paramentro/attributo "colore" dovendo provvedere al caricamento di prodotti singoli, variable/parent e variation/child prima di iniziare il caricamento devo 
        // recuperare tutti i valori dell'attributo "pa_colore" contenuti nel CSV; questo perchè il parent deve dichiararli tutti ed il child solo gli utilizzati.

        $openFile = fopen($csvFileRoot, 'r'); // Aprire il file in modalità lettura ("r")

        $optionsPaColore = [];

        if($openFile != false){
            $headerRow = fgetcsv($openFile, 1000, $csvDelimiter);
            if($headerRow != false){
                while(($dataRow = fgetcsv($openFile, 1000, $csvDelimiter)) != false) {
                    foreach($headerRow as $key => $field){
                        if($field == 'colore'){
                            if($dataRow[$key] != ""){
                                $optionsPaColore[] = $dataRow[$key];
                            }
                        }
                    }                
                }
            }
        }

        fclose($openFile); // Chiudere il file

        // var_dump($optionsPaColore); 

        // END recupero valori per variazioni colore


        $openFile = fopen($csvFileRoot, 'r'); // Aprire il file in modalità lettura ("r")

        if($openFile != false){
            
            // Leggere la prima riga (intestazione) che contiene i nomi dei campi
            $headerRow = fgetcsv($openFile, 1000, $csvDelimiter);

            // Controllare se la riga di intestazione è stata letta correttamente
            if ($headerRow != false) {

                // Leggere le righe successive

                    // Creare un array associativo per ogni riga
                    $rowArray = [];
                    // Vincolo per creare parent
                    $lastCodeParent = 0;

                    while(($dataRow = fgetcsv($openFile, 1000, $csvDelimiter)) != false) {

                    // Mapping: Associare i dati ai rispettivi campi

                    // JSON Exemple:
                    // {
                    //     "name" : "Prodotto generico 3",
                    //     "type" : "simple",
                    //     "regular_price" : "19.99",
                    //     "sale_price" : "10.00",
                    //     "sku" : "",
                    //     "description" : "Descirizone del prodotto generico",
                    //     "short_description" : "Breve descrizione del prodotto generico",
                    //     "meta_data" : [
                    //         { "key": "acquistato_n_volte", "value" : "1" },
                    //         { "key": "valore_punti_fedeltà", "value" : "25" },
                    //         { "key": "peso_volumetrico", "value" : "50" },
                    //         { "key": "tab_campo_descrizione_cose", "value" : "Cos'è lorem ipsum" },
                    //         { "key": "tab_campo_descrizione_a_cosa_serve", "value" : "A cosa serve lorem ipsum" },
                    //         { "key": "tab_campo_descrizione_a_chi_e_o_non_indicato", "value" : "A chi è/non è indicato lorem ipsum" },
                    //         { "key": "tab_campo_descrizione_consigli_duso", "value" : "Consigli d'uso lorem ipsum" },
                    //         { "key": "tab_campo_descrizione_ingredienti", "value" : "Ingredienti lorem ipsum" },
                    //         { "key": "tab_campo_descrizione_risultato_finale", "value" : "Risultato finale lorem ipsum" },
                    //         { "key": "consigliato_da_helu", "value" : "1" },
                    //         { "key": "scelta_top", "value" : "1" }
                    //     ],
                    //     "categories": [
                    //         { "id": "77" },
                    //         { "id": "176"}
                    //     ],
                    //     "brand" : [ "alessi", "bluemarines" ],
                    //     "caratteristiche_prodotti_capelli" : [ "capello-trattato", "tipologia-capello" ],
                    //     "bollino" : [ "green", "naturale"],
                    //     "caratteristiche" : [ "accessori-colore", "anti-pollution" ],
                    //     "images" : [
                    //         { "src" : "https://optimistic-noether.78-46-83-170.plesk.page/wp-content/uploads/2023/09/dior-sauvage-eau-de-parfum-100ml.jpg" }
                    //     ],
                    //     "gallery_images" : [
                    //         { "src" : "https://optimistic-noether.78-46-83-170.plesk.page/wp-content/uploads/2023/09/dior-sauvage-elixir-100-ml-1di0000000388-01_7568276e-3af8-43c6-8746-4b3373965b36.webp" },
                    //         { "src" : "https://optimistic-noether.78-46-83-170.plesk.page/wp-content/uploads/2023/09/dior-sauvage-elixir-100-ml-1di0000000388-04_b6b46824-fe8f-4f61-9207-bd848f8f7579_500x.webp" }
                    //     ]
                    // }



                    // START Mapping dei capi

                    // SCHEMA
                    // Campi CSV Impoted            Campi Woocommerce               Note
                    // codice                       sku                 ***         ---
                    // parent                       parent_id           ***         ---
                    // ---                          type                            ---
                    // nome_it                      name                ***         ---
                    // descrizione_it               description         ***         ---
                    // codice a barre               meta_data[]         ***         ---
                    // marca                        meta_data[]         ***         ---
                    // peso                         meta_data[]         ***         ---
                    // colore                       meta_data[]         ***         ---
                    // costo ivato                  meta_data[]         ***         ---
                    // listino ufficiale netto      meta_data[]         ***         ---  
                    // immagini                     images              ***         Da file solo singola immagine
                    // categoria_it                 categories          ***         ---        
                    // listino Retail ivato         regular_price       ***         ---
                    // quantita                     stock_quantity      ***         ---
                    // ---                          sale_price                      ---
                    // ---                          short_description               ---

                    // Link DOC: https://woocommerce.github.io/woocommerce-rest-api-docs/#product-properties 


                    foreach($headerRow as $key => $field){

                        switch ($field) {
                            case 'codice':
                                $rowArray['sku'] = (isset($dataRow[$key])) ? (string)$dataRow[$key] : "";
                                break;
                            case 'parent':
                                $rowArray['parent_id'] = (($dataRow[$key]) == "" || ($dataRow[$key]) == null) ? 0 : (int)$dataRow[$key];
                                $rowArray['type'] = ($rowArray['parent_id'] == 0) ? "simple" : "variable";

                                if(!isset($rowArray['meta_data'])){
                                    $rowArray['meta_data'] = [];
                                }
                                $rowArray['meta_data'][] = (object)["key" => "custom_parent_id", "value" => empty($dataRow[$key]) ? 0 : (string)$dataRow[$key] ];
                                $rowArray['custom_parent_id'] = (empty($dataRow[$key])) ? 0 : (string)$dataRow[$key];

                                // var_dump($rowArray['meta_data']);
                                // Ho necessita di crearmi una marchera-metadata in quanto ad es. il valore "0005" viene convertito in "5"
                                break;
                            case 'nome_it':
                                $rowArray['name'] = (isset($dataRow[$key])) ? $dataRow[$key] : "";
                                break;
                            case 'descrizione_it':
                                $rowArray['description'] = (isset($dataRow[$key])) ? $dataRow[$key] : "";
                                break;
                            case 'listino Retail ivato':
                                $rowArray['regular_price'] = (isset($dataRow[$key])) ? (string)number_format(floatval($dataRow[$key]), 2, '.') : "";
                                break;
                            case 'quantita':
                                $rowArray['stock_quantity'] = (isset($dataRow[$key])) ? intval($dataRow[$key]) : 0;
                                break;
                            case 'colore':
                                if (!isset($rowArray['meta_data'])) {
                                    $rowArray['meta_data'] = [];
                                }
                                $rowArray['meta_data'][] = (object)["key" => $field, "value" => (isset($dataRow[$key])) ? $dataRow[$key] : ""];
                                // Anche in questo caso per facilitare l'import mi creo un proprietà a parte per valorizzarmi il valore della proprietà colore
                                $rowArray['colore'] = (isset($dataRow[$key])) ? $dataRow[$key] : "";
                            case 'codice a barre':
                            case 'marca':
                            case 'peso':
                            case 'costo ivato':
                            case 'listino ufficiale netto':
                                if (!isset($rowArray['meta_data'])) {
                                    $rowArray['meta_data'] = [];
                                }
                                $rowArray['meta_data'][] = (object)["key" => $field, "value" => (isset($dataRow[$key])) ? $dataRow[$key] : ""];
                                break;
                            case 'immagini':

                                // $explodeImmagini = explode('>', $dataRow[$key]);
                    
                                // // gallery_images
                                // foreach ($explodeImmagini as $immagine) {
                                //     if (!isset($rowArray['gallery_images'])) {
                                //         $rowArray['gallery_images'] = [];
                                //     }
                                //     $rowArray['gallery_images'][] = (object)["src" => trim($immagine)];
                                // }
                    
                                // // images
                                // if (!isset($rowArray['images'])) {
                                //     $rowArray['images'] = [];
                                // }
                                // $rowArray['images'][] = (object)["src" => trim($explodeImmagini[0])];

                                if(!isset($rowArray['images'])){
                                    $rowArray['images'] = [];
                                }
                                $rowArray['images'][] = (object)["src" => (isset($dataRow[$key])) ? $dataRow[$key] : ""];

                                break;
                            case 'categoria_it':
                                $explodeCategoria_it = explode('>', $dataRow[$key]);
                                // Debug exp: exlode restituisce una array vuoto nel caso in cui $dataRow[$key] è una stringa vuota
                    
                                if(is_array($explodeCategoria_it) && !empty($explodeCategoria_it)){
                                    foreach ($explodeCategoria_it as $categoria) {
                                        $id_categoria;
                                        $categoria = (string)trim($categoria);
                    
                                        $term_categoria = get_term_by('name', $categoria, 'product_cat');
                    
                                        if (!$term_categoria) {
                                            $new_term = wp_insert_term($categoria, 'product_cat');
                                            if (!is_wp_error($new_term)) {
                                                $id_categoria = $new_term['term_id'];
                                            } else {
                                                // 296 è la categoria di default "Tutti i prodotti" se non sono indicate categorie nel CSV
                                                $id_categoria = 296;
                                            }
                                        } else {
                                            $id_categoria = $term_categoria->term_id;
                                        }
                    
                                        if (!isset($rowArray['categories'])) {
                                            $rowArray['categories'] = [];
                                        }
                                        $rowArray['categories'][] = (object)["id" => $id_categoria];
                                    }
                                }else{
                                    $rowArray['categories'][] = (object)["id" => $id_categoria];
                                }
                                break;
                            // default:
                            //     $rowArray[$field] = $dataRow[$key]; // Assegna valore ai campi
                            //     break;
                        }
                        
                    }

                        
                    // Aggiunta di campi non gestiti dal CSV esterno

                    $rowArray['sale_price'] = ""; // sale_price
                    $rowArray['short_description'] = ""; // short_description
                    if(!isset($rowArray['meta_data'])){ 
                        $rowArray['meta_data'] = []; 
                        $rowArray['meta_data'][] = (object)["key" => "acquistato_n_volte", "value" =>  "1" ]; // acquistato_n_volte
                    }else{ 
                        $rowArray['meta_data'][] = (object)["key" => "acquistato_n_volte", "value" => "1" ]; 
                    }
                    if(!isset($rowArray['meta_data'])){ 
                        $rowArray['meta_data'] = []; 
                        $rowArray['meta_data'][] = (object)["key" => "valore_punti_fedeltà", "value" =>  "50" ]; // valore_punti_fedeltà
                    }else{ 
                        $rowArray['meta_data'][] = (object)["key" => "valore_punti_fedeltà", "value" => "50" ]; 
                    }
                    if(!isset($rowArray['meta_data'])){ 
                        $rowArray['meta_data'] = []; 
                        $rowArray['meta_data'][] = (object)["key" => "peso_volumetrico", "value" =>  "50" ]; // peso_volumetrico
                    }else{ 
                        $rowArray['meta_data'][] = (object)["key" => "peso_volumetrico", "value" => "50" ]; 
                    }
                    if(!isset($rowArray['meta_data'])){ 
                        $rowArray['meta_data'] = []; 
                        $rowArray['meta_data'][] = (object)["key" => "tab_composizione_prodotto", "value" =>  "" ]; // tab_composizione_prodotto
                    }else{ 
                        $rowArray['meta_data'][] = (object)["key" => "tab_composizione_prodotto", "value" => "" ]; 
                    }
                    if(!isset($rowArray['meta_data'])){ 
                        $rowArray['meta_data'] = []; 
                        $rowArray['meta_data'][] = (object)["key" => "tab_dettagli_prodotto", "value" =>  "" ]; // tab_dettagli_prodotto
                    }else{ 
                        $rowArray['meta_data'][] = (object)["key" => "tab_dettagli_prodotto", "value" => "" ]; 
                    }
                    if(!isset($rowArray['meta_data'])){ 
                        $rowArray['meta_data'] = []; 
                        $rowArray['meta_data'][] = (object)["key" => "consigliato_da_helu", "value" =>  1 ]; // consigliato_da_helu || value 1/0
                    }else{ 
                        $rowArray['meta_data'][] = (object)["key" => "consigliato_da_helu", "value" => 1 ]; 
                    }
                    if(!isset($rowArray['meta_data'])){ 
                        $rowArray['meta_data'] = []; 
                        $rowArray['meta_data'][] = (object)["key" => "scelta_top", "value" =>  1 ]; // scelta_top || value 1/0
                    }else{ 
                        $rowArray['meta_data'][] = (object)["key" => "scelta_top", "value" => 1 ]; 
                    }

                    // END Mapping dei capi

                    // START Logica per caricare il prodotto 

                    // Caricheremo prima product single e product parent (variable/container)

                    // START Definiamo la natura del record (singola riga letta del csv)
                    $product_action;
                    if(($rowArray['type'] == "simple")){ $product_action = 'simple'; }
                    if(($rowArray['type'] == "variable")){ $product_action = 'parent'; }
                    // END Definiamo la natura del record (singola riga letta del csv)

                    echo  'Action: ' . $product_action . "\n\n";

                    // START Debugging section
                    // ob_start();
                    //     echo "data: " . (string)json_encode((object)$rowArray) . "\n\n";
                    // ob_flush();
                    // flush(); 
                    // END Debugging section

                    switch ($product_action) {
                        case 'simple':

                                    $product_data = (object)$rowArray;

                                    $client = new Client(); 
                                    $response = $client->requestAsync('POST', $url, ['json' => $product_data] );
                                    $response->wait(); // Attendi la risposta
                                    // Elaborare la risposta
                                    if ($response->getState() === 'fulfilled') {

                                        echo 'E\' stato creato il prodotto single' . "\n\n"; // ... elaborare la risposta ...

                                        //Calcolo percentuale di lettura attuale
                                        $readedPercentual = ($numberOfReadedRow / $totalCountRows) * 100;
                                        // Invia l'evento solo quando il blocco è completo
                                        ob_start();
                                            echo "data: " . (string)(int)$readedPercentual . "\n\n";
                                        ob_flush();
                                        flush();
                                        // Incrementa il contatore solo dopo aver inviato l'evento
                                        $numberOfReadedRow++;

                                    } else {
                                        echo 'Errore non è stato creato alcun prodotto single' . "\n\n"; // Gestisci l'errore
                                    }

                                    // $response: conterrà un oggetto JSON contenente le informazioni relative al prodotto appena creato tra cui "id" che è necessario per caricare variazioni di prodotto
                                    // https://woocommerce.github.io/woocommerce-rest-api-docs/#create-a-product
                                    //
                                    // JSON Exemple
                                    // {
                                    //     "id": 794,
                                    //     "name": "Premium Quality",
                                    //     "slug": "premium-quality-19",
                                    //     "permalink": "https://example.com/product/premium-quality-19/",
                                    //     "date_created": "2017-03-23T17:01:14",
                                    // ...

                                    break;

                        case 'parent':
                                   
                                    if($lastCodeParent != $rowArray['custom_parent_id']){

                                        $metadata_parent_id = $rowArray['custom_parent_id'];

                                        // JSON Exemple:
                                        // {
                                        //     "name": "Maglietta",
                                        //     "type": "variable",
                                        //     "attributes": [
                                        //     {
                                        //         "name": "Taglia",
                                        //         "slug": "pa_taglia", 
                                        //         "position": 0,
                                        //         "visible": true,
                                        //         "variation": true, 
                                        //         "options": ["S", "M", "L", "XL"] 
                                        //     },
                                        //     {
                                        //         "name": "Colore",
                                        //         "slug": "pa_colore", 
                                        //         "position": 1,
                                        //         "visible": true,
                                        //         "variation": true, 
                                        //         "options": ["Bianco", "Nero", "Rosso"] 
                                        //     }
                                        //     ],
                                        //      "images" : [
                                        //         { "src" : "https://optimistic-noether.78-46-83-170.plesk.page/wp-content/uploads/2023/09/dior-sauvage-eau-de-parfum-100ml.jpg" }
                                        //     ],
                                        //     "gallery_images" : [
                                        //         { "src" : "https://optimistic-noether.78-46-83-170.plesk.page/wp-content/uploads/2023/09/dior-sauvage-elixir-100-ml-1di0000000388-01_7568276e-3af8-43c6-8746-4b3373965b36.webp" },
                                        //         { "src" : "https://optimistic-noether.78-46-83-170.plesk.page/wp-content/uploads/2023/09/dior-sauvage-elixir-100-ml-1di0000000388-04_b6b46824-fe8f-4f61-9207-bd848f8f7579_500x.webp" }
                                        //     ]
                                        // }

                                        $product_variable_parent = array(
                                            'name' => $rowArray['name'],
                                            'type' => 'variable',
                                            'images' =>  $rowArray['images'],
                                            'gallery_images' => $rowArray['gallery_images'],
                                            "attributes" => array(
                                                (object)array(
                                                "name" => "Colore",
                                                "slug" => 'pa_colore', 
                                                "position" => 1,
                                                "visible" => true,
                                                "variation" => true, 
                                                "options" =>  $optionsPaColore,
                                                )
                                            ),
                                            "meta_data" => array(
                                                (object)array(
                                                    "key" => "custom_parent_id",
                                                    "value" => $metadata_parent_id,
                                                )
                                            )
                                        );
                                        
                                        $product_variable_parent = (object)$product_variable_parent;

                                        $client = new Client(); 
                                        $response = $client->requestAsync('POST', $url, ['json' => $product_variable_parent] );
                                        $response->wait(); // Attendi la risposta
                                        // Elaborare la risposta
                                        if ($response->getState() === 'fulfilled') {

                                            echo 'E\' stato creato il prodotto parent' . "\n\n"; // ... elaborare la risposta ...

                                            //Calcolo percentuale di lettura attuale
                                            $readedPercentual = ($numberOfReadedRow / $totalCountRows) * 100;
                                            // Invia l'evento solo quando il blocco è completo
                                            ob_start();
                                                echo "data: " . (string)(int)$readedPercentual . "\n\n";
                                            ob_flush();
                                            flush();
                                            // Incrementa il contatore solo dopo aver inviato l'evento
                                            $numberOfReadedRow++;
                                            
                                        } else {
                                            echo 'Errore non è stato creato alcun prodotto parent' . "\n\n"; // Gestisci l'errore
                                        }

                                        $lastCodeParent = $rowArray['custom_parent_id'];

                                    }

                                    break;
                        default:
                                        // Incrementa il contatore solo dopo aver inviato l'evento
                                        $numberOfReadedRow++;
                                    break;
                    }
                    

                }


            }

        }else{

        echo "Errore nell'apertura del file.";

        }

        // Chiudere il file
        fclose($openFile);


        ///////////////////////////////////////////////////////////////// FINE PRIMA FASE


        $openFile = fopen($csvFileRoot, 'r'); // Aprire il file in modalità lettura ("r")

        if($openFile != false){
            
            // Leggere la prima riga (intestazione) che contiene i nomi dei campi
            $headerRow = fgetcsv($openFile, 1000, $csvDelimiter);

            // Controllare se la riga di intestazione è stata letta correttamente
            if ($headerRow != false) {

                // Leggere le righe successive

                    // Creare un array associativo per ogni riga
                    $rowArray = [];

                    while(($dataRow = fgetcsv($openFile, 1000, $csvDelimiter)) != false) {

                    // Mapping: Associare i dati ai rispettivi campi

                    // JSON Exemple:
                    // {
                    //     "name" : "Prodotto generico 3",
                    //     "type" : "simple",
                    //     "regular_price" : "19.99",
                    //     "sale_price" : "10.00",
                    //     "sku" : "",
                    //     "description" : "Descirizone del prodotto generico",
                    //     "short_description" : "Breve descrizione del prodotto generico",
                    //     "meta_data" : [
                    //         { "key": "acquistato_n_volte", "value" : "1" },
                    //         { "key": "valore_punti_fedeltà", "value" : "25" },
                    //         { "key": "peso_volumetrico", "value" : "50" },
                    //         { "key": "tab_campo_descrizione_cose", "value" : "Cos'è lorem ipsum" },
                    //         { "key": "tab_campo_descrizione_a_cosa_serve", "value" : "A cosa serve lorem ipsum" },
                    //         { "key": "tab_campo_descrizione_a_chi_e_o_non_indicato", "value" : "A chi è/non è indicato lorem ipsum" },
                    //         { "key": "tab_campo_descrizione_consigli_duso", "value" : "Consigli d'uso lorem ipsum" },
                    //         { "key": "tab_campo_descrizione_ingredienti", "value" : "Ingredienti lorem ipsum" },
                    //         { "key": "tab_campo_descrizione_risultato_finale", "value" : "Risultato finale lorem ipsum" },
                    //         { "key": "consigliato_da_helu", "value" : "1" },
                    //         { "key": "scelta_top", "value" : "1" }
                    //     ],
                    //     "categories": [
                    //         { "id": "77" },
                    //         { "id": "176"}
                    //     ],
                    //     "brand" : [ "alessi", "bluemarines" ],
                    //     "caratteristiche_prodotti_capelli" : [ "capello-trattato", "tipologia-capello" ],
                    //     "bollino" : [ "green", "naturale"],
                    //     "caratteristiche" : [ "accessori-colore", "anti-pollution" ],
                    //     "images" : [
                    //         { "src" : "https://optimistic-noether.78-46-83-170.plesk.page/wp-content/uploads/2023/09/dior-sauvage-eau-de-parfum-100ml.jpg" }
                    //     ],
                    //     "gallery_images" : [
                    //         { "src" : "https://optimistic-noether.78-46-83-170.plesk.page/wp-content/uploads/2023/09/dior-sauvage-elixir-100-ml-1di0000000388-01_7568276e-3af8-43c6-8746-4b3373965b36.webp" },
                    //         { "src" : "https://optimistic-noether.78-46-83-170.plesk.page/wp-content/uploads/2023/09/dior-sauvage-elixir-100-ml-1di0000000388-04_b6b46824-fe8f-4f61-9207-bd848f8f7579_500x.webp" }
                    //     ]
                    // }



                    // START Mapping dei capi

                    // SCHEMA
                    // Campi CSV Impoted            Campi Woocommerce               Note
                    // codice                       sku                 ***         ---
                    // parent                       parent_id           ***         ---
                    // ---                          type                            ---
                    // nome_it                      name                ***         ---
                    // descrizione_it               description         ***         ---
                    // codice a barre               meta_data[]         ***         ---
                    // marca                        meta_data[]         ***         ---
                    // peso                         meta_data[]         ***         ---
                    // colore                       meta_data[]         ***         ---
                    // costo ivato                  meta_data[]         ***         ---
                    // listino ufficiale netto      meta_data[]         ***         ---  
                    // immagini                     images              ***         Da file solo singola immagine
                    // categoria_it                 categories          ***         ---        
                    // listino Retail ivato         regular_price       ***         ---
                    // quantita                     stock_quantity      ***         ---
                    // ---                          sale_price                      ---
                    // ---                          short_description               ---

                    // Link DOC: https://woocommerce.github.io/woocommerce-rest-api-docs/#product-properties 


                    foreach($headerRow as $key => $field){

                        switch ($field) {
                            case 'codice':
                                $rowArray['sku'] = (isset($dataRow[$key])) ? (string)$dataRow[$key] : "";
                                break;
                            case 'parent':
                                $rowArray['parent_id'] = (($dataRow[$key]) == "" || ($dataRow[$key]) == null) ? 0 : (int)$dataRow[$key];
                                $rowArray['type'] = ($rowArray['parent_id'] == 0) ? "simple" : "variable";

                                if(!isset($rowArray['meta_data'])){
                                    $rowArray['meta_data'] = [];
                                }
                                $rowArray['meta_data'][] = (object)["key" => "custom_parent_id", "value" => empty($dataRow[$key]) ? 0 : (string)$dataRow[$key] ];
                                $rowArray['custom_parent_id'] = (empty($dataRow[$key])) ? 0 : (string)$dataRow[$key];

                                // var_dump($rowArray['meta_data']);
                                // Ho necessita di crearmi una marchera-metadata in quanto ad es. il valore "0005" viene convertito in "5"
                                break;
                            case 'nome_it':
                                $rowArray['name'] = (isset($dataRow[$key])) ? $dataRow[$key] : "";
                                break;
                            case 'descrizione_it':
                                $rowArray['description'] = (isset($dataRow[$key])) ? $dataRow[$key] : "";
                                break;
                            case 'listino Retail ivato':
                                $rowArray['regular_price'] = (isset($dataRow[$key])) ? (string)number_format(floatval($dataRow[$key]), 2, '.') : "";
                                break;
                            case 'quantita':
                                $rowArray['stock_quantity'] = (isset($dataRow[$key])) ? intval($dataRow[$key]) : 0;
                                break;
                            case 'colore':
                                if (!isset($rowArray['meta_data'])) {
                                    $rowArray['meta_data'] = [];
                                }
                                $rowArray['meta_data'][] = (object)["key" => $field, "value" => (isset($dataRow[$key])) ? $dataRow[$key] : ""];
                                // Anche in questo caso per facilitare l'import mi creo un proprietà a parte per valorizzarmi il valore della proprietà colore
                                $rowArray['colore'] = (isset($dataRow[$key])) ? $dataRow[$key] : "";
                            case 'codice a barre':
                            case 'marca':
                            case 'peso':
                            case 'costo ivato':
                            case 'listino ufficiale netto':
                                if (!isset($rowArray['meta_data'])) {
                                    $rowArray['meta_data'] = [];
                                }
                                $rowArray['meta_data'][] = (object)["key" => $field, "value" => (isset($dataRow[$key])) ? $dataRow[$key] : ""];
                                break;
                            case 'immagini':

                                // $explodeImmagini = explode('>', $dataRow[$key]);
                    
                                // // gallery_images
                                // foreach ($explodeImmagini as $immagine) {
                                //     if (!isset($rowArray['gallery_images'])) {
                                //         $rowArray['gallery_images'] = [];
                                //     }
                                //     $rowArray['gallery_images'][] = (object)["src" => trim($immagine)];
                                // }
                    
                                // // images
                                // if (!isset($rowArray['images'])) {
                                //     $rowArray['images'] = [];
                                // }
                                // $rowArray['images'][] = (object)["src" => trim($explodeImmagini[0])];

                                if(!isset($rowArray['images'])){
                                    $rowArray['images'] = [];
                                }
                                $rowArray['images'][] = (object)["src" => (isset($dataRow[$key])) ? $dataRow[$key] : ""];

                                break;
                            case 'categoria_it':
                                $explodeCategoria_it = explode('>', $dataRow[$key]);
                                // Debug exp: exlode restituisce una array vuoto nel caso in cui $dataRow[$key] è una stringa vuota
                    
                                if(is_array($explodeCategoria_it) && !empty($explodeCategoria_it)){
                                    foreach ($explodeCategoria_it as $categoria) {
                                        $id_categoria;
                                        $categoria = (string)trim($categoria);
                    
                                        $term_categoria = get_term_by('name', $categoria, 'product_cat');
                    
                                        if (!$term_categoria) {
                                            $new_term = wp_insert_term($categoria, 'product_cat');
                                            if (!is_wp_error($new_term)) {
                                                $id_categoria = $new_term['term_id'];
                                            } else {
                                                // 296 è la categoria di default "Tutti i prodotti" se non sono indicate categorie nel CSV
                                                $id_categoria = 296;
                                            }
                                        } else {
                                            $id_categoria = $term_categoria->term_id;
                                        }
                    
                                        if (!isset($rowArray['categories'])) {
                                            $rowArray['categories'] = [];
                                        }
                                        $rowArray['categories'][] = (object)["id" => $id_categoria];
                                    }
                                }else{
                                    $rowArray['categories'][] = (object)["id" => $id_categoria];
                                }
                                break;
                            // default:
                            //     $rowArray[$field] = $dataRow[$key]; // Assegna valore ai campi
                            //     break;
                        }
                        
                    }

                        
                    // Aggiunta di campi non gestiti dal CSV esterno

                    $rowArray['sale_price'] = ""; // sale_price
                    $rowArray['short_description'] = ""; // short_description
                    if(!isset($rowArray['meta_data'])){ 
                        $rowArray['meta_data'] = []; 
                        $rowArray['meta_data'][] = (object)["key" => "acquistato_n_volte", "value" =>  "1" ]; // acquistato_n_volte
                    }else{ 
                        $rowArray['meta_data'][] = (object)["key" => "acquistato_n_volte", "value" => "1" ]; 
                    }
                    if(!isset($rowArray['meta_data'])){ 
                        $rowArray['meta_data'] = []; 
                        $rowArray['meta_data'][] = (object)["key" => "valore_punti_fedeltà", "value" =>  "50" ]; // valore_punti_fedeltà
                    }else{ 
                        $rowArray['meta_data'][] = (object)["key" => "valore_punti_fedeltà", "value" => "50" ]; 
                    }
                    if(!isset($rowArray['meta_data'])){ 
                        $rowArray['meta_data'] = []; 
                        $rowArray['meta_data'][] = (object)["key" => "peso_volumetrico", "value" =>  "50" ]; // peso_volumetrico
                    }else{ 
                        $rowArray['meta_data'][] = (object)["key" => "peso_volumetrico", "value" => "50" ]; 
                    }
                    if(!isset($rowArray['meta_data'])){ 
                        $rowArray['meta_data'] = []; 
                        $rowArray['meta_data'][] = (object)["key" => "tab_composizione_prodotto", "value" =>  "" ]; // tab_composizione_prodotto
                    }else{ 
                        $rowArray['meta_data'][] = (object)["key" => "tab_composizione_prodotto", "value" => "" ]; 
                    }
                    if(!isset($rowArray['meta_data'])){ 
                        $rowArray['meta_data'] = []; 
                        $rowArray['meta_data'][] = (object)["key" => "tab_dettagli_prodotto", "value" =>  "" ]; // tab_dettagli_prodotto
                    }else{ 
                        $rowArray['meta_data'][] = (object)["key" => "tab_dettagli_prodotto", "value" => "" ]; 
                    }
                    if(!isset($rowArray['meta_data'])){ 
                        $rowArray['meta_data'] = []; 
                        $rowArray['meta_data'][] = (object)["key" => "consigliato_da_helu", "value" =>  1 ]; // consigliato_da_helu || value 1/0
                    }else{ 
                        $rowArray['meta_data'][] = (object)["key" => "consigliato_da_helu", "value" => 1 ]; 
                    }
                    if(!isset($rowArray['meta_data'])){ 
                        $rowArray['meta_data'] = []; 
                        $rowArray['meta_data'][] = (object)["key" => "scelta_top", "value" =>  1 ]; // scelta_top || value 1/0
                    }else{ 
                        $rowArray['meta_data'][] = (object)["key" => "scelta_top", "value" => 1 ]; 
                    }

                    // END Mapping dei capi

                    // START Logica per caricare il prodotto 

                    // Carichiamo solo le variazioni di prodotto

                    // START Definiamo la natura del record (singola riga letta del csv)
                    $product_action;
                    if(($rowArray['type'] == "simple")){ $product_action = 'no-action'; }
                    if(($rowArray['type'] == "variable")){ $product_action = 'variation'; }
                    // END Definiamo la natura del record (singola riga letta del csv)

                    echo  'Action: ' . $product_action . "\n\n";

                    // START Debugging section
                    // ob_start();
                    //     echo "data: " . (string)json_encode((object)$rowArray) . "\n\n";
                    // ob_flush();
                    // flush(); 
                    // END Debugging section

                    if($product_action == 'variation'){

                        $metadata_parent_id = $rowArray['custom_parent_id'];

                                    $product_parent_id_con_metadato;  

                                    $args = array(
                                        'post_type' => 'product',
                                        'numberposts' => 1,
                                        'fields' => 'ids', // Imposta 'fields' su 'ids' per ottenere Array di ID di post
                                        'meta_query' => array(
                                            array(
                                                'key'   => 'custom_parent_id',
                                                'value' => (string)$metadata_parent_id,
                                            )
                                        )
                                    );

                                    $searchProducts = get_posts( $args ); // Questo sarà comunque un array con un solo indice

                                    $product_parent_id_con_metadato = (count($searchProducts) > 0) ? $searchProducts[0] : 0;

                                    if($product_parent_id_con_metadato != 0){

                                        $product_variation = new stdClass();
                                        $product_variation->name = $rowArray['name'];
                                        $product_variation->type = 'variation';
                                        $product_variation->regular_price = $rowArray['regular_price'];
                                        $product_variation->parent_id = $product_parent_id_con_metadato;
                                        $product_variation->attributes = [];
    
                                        $arribute_obj = new stdClass();
                                        $arribute_obj->name = 'colore';
                                        $arribute_obj->option = $rowArray['colore'];
    
                                        $product_variation->attributes[] =  $arribute_obj;
    
                                        echo '$rowArray["colore"]: ' . $rowArray['colore'] . "\n\n";
    
                                        // Per il caricamento delle variazioni l'endpoint è differente
                                        // POST /wp-json/wc/v3/products/{product_id}/variations
                                        $urlVariation = 'https://' . $_SERVER['HTTP_HOST'] . '/wp-json/wc/v3/products/' . $product_parent_id_con_metadato . '/variations?consumer_key=' . $consumer_key . '&consumer_secret=' . $consumer_secret;
    
                                        $client = new Client(); 
                                        // Invia la richiesta in modo asincrono
                                        $response = $client->requestAsync('POST', $urlVariation, ['json' => $product_variation] );
                                        $response->wait(); // Attendi la risposta
                                        // Elaborare la risposta
                                        if ($response->getState() === 'fulfilled'){

                                            echo 'E\' stato creato il prodotto variation' . "\n\n"; // ... elaborare la risposta ...
                                            
                                            //Calcolo percentuale di lettura attuale
                                            $readedPercentual = ($numberOfReadedRow / $totalCountRows) * 100;
                                            // Invia l'evento solo quando il blocco è completo
                                            ob_start();
                                                echo "data: " . (string)(int)$readedPercentual . "\n\n";
                                            ob_flush();
                                            flush();
                                            // Incrementa il contatore solo dopo aver inviato l'evento
                                            $numberOfReadedRow++;

                                        } else {
                                            echo 'Errore non è stato creato alcun prodotto variation' . "\n\n"; // Gestisci l'errore
                                        }
    
                                    }else{
                                        // Incrementa il contatore solo dopo aver inviato l'evento
                                        $numberOfReadedRow++;
                                    }

                    }

                 
                }


            }

        }else{

        echo "Errore nell'apertura del file.";

        }

        // Chiudere il file
        fclose($openFile);

        ///////////////////////////////////////////////////////////////// FINE SECONDA FASE
      

        // START Chiusura SSE
        ob_start();
            echo "data: EOF \n\n";
        ob_flush();
        flush(); 
        // END Chiusura SSE

?>
