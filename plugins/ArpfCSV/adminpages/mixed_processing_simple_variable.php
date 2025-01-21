<?php

        header('Content-Type: text/event-stream');

        define('WP_USE_THEMES', false);
        require_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
        require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/woocommerce/woocommerce.php');

        global $wordpress;
        global $woocommerce;

        // Includi il file autoload.php
        require_once ABSPATH . 'vendor/autoload.php';
        use GuzzleHttp\Client; 
        
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

        $csvFileName = (isset($_GET['csvFileName'])) ? $_GET['csvFileName'] : "drop_finale.csv"; // $csvFileName = 'exemple.csv';
        $csvFileRoot = 'https://' . $_SERVER['HTTP_HOST'] . "/wp-content/plugins/ArpfCSV/deposit/" . $csvFileName;
        $csvDelimiter = (isset($_GET['delimiter'])) ? $_GET['delimiter'] : "|"; // $csvDelimiter = ';';        

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

        $numberOfReadedRow = 1;
        $readedPercentual = 1;
        
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
                                $rowArray['sku'] = (string)$dataRow[$key];
                                break;
                            case 'parent':
                                $rowArray['parent_id'] = empty($dataRow[$key]) ? 0 : (int)$dataRow[$key];
                                $rowArray['type'] = ($rowArray['parent_id'] == 0) ? "simple" : "variable";

                                if(!isset($rowArray['meta_data'])){
                                    $rowArray['meta_data'] = [];
                                }
                                $rowArray['meta_data'][] = (object)["key" => "__parent_id", "value" => empty($dataRow[$key]) ? 0 : (string)$dataRow[$key] ];
                                $rowArray['__parent_id'] = empty($dataRow[$key]) ? null : (string)$dataRow[$key];

                                // var_dump($rowArray['meta_data']);
                                // Ho necessita di crearmi una marchera-metadata in quanto ad es. il valore "0005" viene convertito in "5"
                                break;
                            case 'nome_it':
                                $rowArray['name'] = $dataRow[$key];
                                break;
                            case 'descrizione_it':
                                $rowArray['description'] = $dataRow[$key];
                                break;
                            case 'listino Retail ivato':
                                $rowArray['regular_price'] = (string)number_format(floatval($dataRow[$key]), 2, '.');
                                break;
                            case 'quantita':
                                $rowArray['stock_quantity'] = intval($dataRow[$key]);
                                break;
                            case 'codice a barre':
                            case 'marca':
                            case 'peso':
                            case 'colore':
                            case 'costo ivato':
                            case 'listino ufficiale netto':
                                if (!isset($rowArray['meta_data'])) {
                                    $rowArray['meta_data'] = [];
                                }
                                $rowArray['meta_data'][] = (object)["key" => $field, "value" => $dataRow[$key]];
                                break;
                            case 'immagini':
                                $explodeImmagini = explode('>', $dataRow[$key]);
                    
                                // gallery_images
                                foreach ($explodeImmagini as $immagine) {
                                    if (!isset($rowArray['gallery_images'])) {
                                        $rowArray['gallery_images'] = [];
                                    }
                                    $rowArray['gallery_images'][] = (object)["src" => trim($immagine)];
                                }
                    
                                // images
                                if (!isset($rowArray['images'])) {
                                    $rowArray['images'] = [];
                                }
                                $rowArray['images'][] = (object)["src" => trim($explodeImmagini[0])];
                                break;
                            case 'categoria_it':
                                $explodeCategoria_it = explode('>', $dataRow[$key]);
                                // Debug exp: exlode restituisce una array vuoto nel caso in cui $dataRow[$key] è una stringa vuota
                    
                                if (is_array($explodeCategoria_it) && !empty($explodeCategoria_it)) {
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
                                }
                                break;
                            default:
                                $rowArray[$field] = $dataRow[$key]; // Assegna valore ai campi
                                break;
                        }
                        
                    }

                        
                    // Aggiunta di campi non gestiti dal CSV esterno

                    $rowArray['sale_price'] = ""; // sale_price
                    $rowArray['short_description'] = ""; // short_description
                    if(!isset($rowArray['meta_data'])){ $rowArray['meta_data'] = []; $rowArray['meta_data'][] = (object)["key" => "acquistato_n_volte", "value" =>  "1" ]; // acquistato_n_volte
                    }else{ $rowArray['meta_data'][] = (object)["key" => "acquistato_n_volte", "value" => "1" ]; }
                    if(!isset($rowArray['meta_data'])){ $rowArray['meta_data'] = []; $rowArray['meta_data'][] = (object)["key" => "valore_punti_fedeltà", "value" =>  "50" ]; // valore_punti_fedeltà
                    }else{ $rowArray['meta_data'][] = (object)["key" => "valore_punti_fedeltà", "value" => "50" ]; }
                    if(!isset($rowArray['meta_data'])){ $rowArray['meta_data'] = []; $rowArray['meta_data'][] = (object)["key" => "peso_volumetrico", "value" =>  "50" ]; // peso_volumetrico
                    }else{ $rowArray['meta_data'][] = (object)["key" => "peso_volumetrico", "value" => "50" ]; }
                    if(!isset($rowArray['meta_data'])){ $rowArray['meta_data'] = []; $rowArray['meta_data'][] = (object)["key" => "tab_composizione_prodotto", "value" =>  "" ]; // tab_composizione_prodotto
                    }else{ $rowArray['meta_data'][] = (object)["key" => "tab_composizione_prodotto", "value" => "" ]; }
                    if(!isset($rowArray['meta_data'])){ $rowArray['meta_data'] = []; $rowArray['meta_data'][] = (object)["key" => "tab_dettagli_prodotto", "value" =>  "" ]; // tab_dettagli_prodotto
                    }else{ $rowArray['meta_data'][] = (object)["key" => "tab_dettagli_prodotto", "value" => "" ]; }
                    if(!isset($rowArray['meta_data'])){ $rowArray['meta_data'] = []; $rowArray['meta_data'][] = (object)["key" => "consigliato_da_helu", "value" =>  1 ]; // consigliato_da_helu || value 1/0
                    }else{ $rowArray['meta_data'][] = (object)["key" => "consigliato_da_helu", "value" => "" ]; }
                    if(!isset($rowArray['meta_data'])){ $rowArray['meta_data'] = []; $rowArray['meta_data'][] = (object)["key" => "scelta_top", "value" =>  1 ]; // scelta_top || value 1/0
                    }else{ $rowArray['meta_data'][] = (object)["key" => "scelta_top", "value" => 1 ]; }

                    // END Mapping dei capi

                    // START Logica per caricare il prodotto


                    // START Debugging section
                    ob_start();
                        echo "data: " . (string)json_encode((object)$rowArray) . "\n\n";
                    ob_flush();
                    flush(); 
                    // END Debugging section


                    // Verificare se caricare una variazione ad un prodotto variabile o un nuovo prodotto container
                    //
                    // Per questa funzionalità dobbiamo prevedere 3 possibili scenari:
                    // 1. Il prodotto è simple -> carico il prodotto
                    // 2. il prodotto è variabile ed è presente già un prodotto con parent_id impostato -> carico la variazione
                    // 3. Il prodotto è variable e non vi è già un prodotto con parent_id esistente -> creo il prodotto container


                    // Verifico se è già presente un prodotto container con il parent_id impostato
                    $metadata_parent_id = $rowArray['__parent_id']; // es. o 0 o 0005

                    //prendere il primo prodotto che presenterà il parent_id e da questo recuperare l'id a quest'ultimo sarà possibile aggiungere una variazione
                    $product_parent_id = null;                 
                    
                    $args = array(
                        'post_type' => 'product',
                        'meta_query' => array(
                            array(
                                'key'   => '__parent_id',
                                'value' => $metadata_parent_id,
                                'compare' => '=',
                            )
                            ),
                        // 'meta_key'       => '__parent_id', 
                        // 'meta_value'     => $metadata_parent_id,
                        // 'numberposts' => 1, // Limit to one result
                    );
                    
                    // $product_parents = new WP_Query( $args );

                    // $query = new WP_Query( $args );

                    // if ( $query->have_posts() ) {
                    //     while ( $query->have_posts() ) {
                    //         $query->the_post();
                    //         // Fai qualcosa con il post, ad esempio:
                    //         // the_title();
                    //         // the_content();
                    //         $product_parent_id = $post->ID;
                    //     }
                    // }

                    // $product_parent = ( $product_parents->have_posts() ) ? $product_parents->the_post() : null;
                    // $product_parent_id = ( $product_parent != null) ? $product_parent->get_the_ID() : null; 

                    echo '$product_parent_id ' . $product_parent_id; 

                    
                    // Scenaio 1:   Il prodotto è simple -> carico il prodotto
                    if($rowArray['type'] == "simple"){

                        $product_data = (object)$rowArray;

                        $client = new Client(); 
                        $response = $client->request('POST', $url, ['json' => $product_data] );
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

                        // var_dump( $product_data);
                    }

                                   
                    // Scenaio 2:    il prodotto è variabile ed è presente già un prodotto con parent_id impostato -> carico la variazione
                    if(($rowArray['type'] == "variable") && ($product_parent_id != null)){

                        // JSON EXEMPLE
                        // {
                        //     "name": "Maglietta Bianca - Taglia L",
                        //     "type": "variation",
                        //     "regular_price": "29.99",
                        //     "attributes": [
                        //       {
                        //         "name": "taglia", 
                        //         "option": "L" 
                        //       },
                        //       {
                        //         "name": "colore", 
                        //         "option": "bianco" 
                        //       }
                        //     ]
                        //  }

                        // $product_variation = array(
                        //     'name' => $rowArray['name'],
                        //     'type' => 'variation',
                        //     'regular_price' => $rowArray['regular_price'],
                        //     'parent_id' => $product_parent_id,
                        //     'attributes' => (object)array(
                        //         'attribute_pa_colore' => $rowArray['meta_data'][4]->value,
                        //     )
                        // );

                        // $product_variation = (object)$product_variation;

                        $product_variation = new stdClass();
                        $product_variation->name = $rowArray['name'];
                        $product_variation->type = 'variation';
                        $product_variation->regular_price = $rowArray['regular_price'];
                        $product_variation->parent_id = $product_parent_id;
                        $product_variation->attributes = [];

                        $arribute_obj = new stdClass();
                        $arribute_obj->name = 'colore';
                        $arribute_obj->option = $rowArray['meta_data'][4]->value;

                        $product_variation->attributes[] =  $arribute_obj;



                        // Per il caricamento delle variazioni l'endpoint è differente
                        // POST /wp-json/wc/v3/products/{product_id}/variations
                        $urlVariation = 'https://' . $_SERVER['HTTP_HOST'] . '/wp-json/wc/v3/products/' . $product_parent_id . '/variations?consumer_key=' . $consumer_key . '&consumer_secret=' . $consumer_secret;;

                        $client = new Client(); 
                        $response = $client->request('POST', $urlVariation, ['json' => $product_variation] );

                        // var_dump( $product_variation);
                    }

                    // Scenaio 3:    Il prodotto è variable e non vi è già un prodotto con parent_id esistente -> creo il prodotto container/parent
                    if(($rowArray['type'] == "variable") && ($product_parent_id == null)){
                        // Procedimento: In questo caso dobbiamo modificare il body della richiesta con un json che dichiari gli attributi valorizzabili per il prodotto variabile 
                        // JSON Exemple:
                        // {
                        //     "name": "Maglietta",
                        //     "type": "variable",
                        //     "attributes": [
                        //       {
                        //         "name": "Taglia",
                        //         "slug": "pa_taglia", 
                        //         "position": 0,
                        //         "visible": true,
                        //         "variation": true, 
                        //         "options": ["S", "M", "L", "XL"] 
                        //       },
                        //       {
                        //         "name": "Colore",
                        //         "slug": "pa_colore", 
                        //         "position": 1,
                        //         "visible": true,
                        //         "variation": true, 
                        //         "options": ["Bianco", "Nero", "Rosso"] 
                        //       }
                        //     ]
                        //   }

                        $product_variable_parent = array(
                            'name' => $rowArray['name'],
                            'type' => 'variable',
                            "attributes" => array(
                                (object)array(
                                "name" => "Colore",
                                "slug" => 'pa_colore', 
                                "position" => 1,
                                "visible" => true,
                                "variation" => true, 
                                "options" =>  $optionsPaColore
                                )
                            ),
                            "meta_data" => array(
                                (object)array(
                                    "key" => "__parent_id",
                                    "value" => $metadata_parent_id
                                )
                            )
                        );
                        
                        $product_variable_parent = (object)$product_variable_parent;

                        var_dump($product_variable_parent);

                        $client = new Client(); 
                        $response = $client->request('POST', $url, ['json' => $product_variable_parent] );

                        // var_dump($product_variation);


                    }

                    // // START Logica per caricare il prodotto

                    // if($response->getStatusCode() === 201){

                    //     // Inizia l'output buffering
                    //     ob_start();

                    //     // Calcolo percentuale di lettura attuale
                    //     $readedPercentual = ($numberOfReadedRow / $totalCountRows) * 100 + 1;

                    //     // Invia l'evento solo quando il blocco è completo
                    //     echo "data: " . (string)$readedPercentual . "\n\n"; // Il formato SSE richiede che i dati vengano inviati al client in un formato specifico, con una linea che inizia con "data: " seguita dai dati effettivi. Il doppio a capo (\n\n) è un elemento fondamentale nel formato SSE e garantisce una corretta comunicazione tra server e client. Assicurati di includerlo alla fine di ogni messaggio che invii utilizzando Server-Sent Events.
                            
                    //     ob_flush(); // ob_flush(): Invia il contenuto del buffer di output al browser. Il buffer di output è un'area di memoria temporanea in cui PHP accumula i dati prima di inviarli al client. Non svuota il buffer. Il contenuto viene inviato al browser, ma rimane nel buffer.
                    //     flush(); // flush(): Svuota il buffer di output del sistema operativo.
                    
                    //     // Incrementa il contatore solo dopo aver inviato l'evento
                    //     $numberOfReadedRow++;

                    //     // ob_end_flush(): Termina il buffering dell'output alla fine dello script.
                    //     ob_end_flush();

                    //     // Verificare che non sia EOF (End Of File)
                    //     if(feof($openFile)){$finished = true; }

                    // }else{

                    //     break;
                    //     echo "Errore nella lettura del file.";

                    // }

                    // Svuotare array associativo di ogni riga
                    $rowArray = [];


                }

                // START Chiusura SSE
                ob_start();
                    echo "data: EOF \n\n";
                ob_flush();
                flush(); 
                // END Chiusura SSE

            }
            
            // Chiudere il file
            fclose($openFile);


        }else{

        echo "Errore nell'apertura del file.";

        }


?>
