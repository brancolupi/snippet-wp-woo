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

        // Dati per l'elaborazione dei CSV

        $csvFileName = (isset($_GET['csvFileName'])) ? $_GET['csvFileName'] : "drop_finale.csv"; // $csvFileName = 'exemple.csv';
        $csvFileRoot = "https://charming-margulis.78-46-83-170.plesk.page/wp-content/plugins/ArpfCSV/deposit/" . $csvFileName;
        $csvDelimiter = (isset($_GET['delimiter'])) ? $_GET['delimiter'] : "|"; // $csvDelimiter = ';';        

        // Dati per il caricamento di prodotti tramite API REST Woocommerce

        $consumer_key = "ck_57fcfa65b2b3326b9a1d5d50827dff660d0ce936"; // $consumer_key = 'tua_chiave_api';
        $consumer_secret = "cs_1329bbf5ab15f2e4a5c25a275843387bb5453a96"; // $consumer_secret = 'tuo_segreto_api';
        $url = 'https://charming-margulis.78-46-83-170.plesk.page/wp-json/wc/v2/products?consumer_key=' . $consumer_key . '&consumer_secret=' . $consumer_secret; // $url = 'https://tuo-dominio.com/wp-json/wc/v3/products';   

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


        $openFile = fopen($csvFileRoot, 'r'); // Aprire il file in modalità lettura ("r")

        if($openFile != false){
            
            // Leggere la prima riga (intestazione) che contiene i nomi dei campi
            $headerRow = fgetcsv($openFile, 1000, $csvDelimiter);

            // Controllare se la riga di intestazione è stata letta correttamente
            if ($headerRow != false) {

                // Leggere le righe successive

                    while(($dataRow = fgetcsv($openFile, 1000, $csvDelimiter)) != false) {

                    // Creare un array associativo per ogni riga
                    $rowArray = [];

                    // Mapping: Associare i dati ai rispettivi campi

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

                    // END Mapping dei capi

                    foreach ($headerRow as $key => $field) {

                            if( $field == 'codice' ){  $rowArray['sku'] = (string)$dataRow[$key]; 

                            // }elseif( $field == 'parent'){ $rowArray['parent_id'] = empty($dataRow[$key]) ? 0 : $dataRow[$key]; ($rowArray['parent_id'] == 0) ? $rowArray['type'] = "simple" : $rowArray['type'] = "variable";
                            // Attualmente disattiviamo la gestione di prodotti variabile in quanto seppur present un campo parent non è chiara come il csv passi le variazioni
                            }elseif( $field == 'parent'){ $rowArray['parent_id'] = empty($dataRow[$key]) ? 0 : $dataRow[$key]; ($rowArray['parent_id'] == 0) ? $rowArray['type'] = "simple" : $rowArray['type'] = "simple";


                            }elseif( $field == 'nome_it'){ $rowArray['name'] = $dataRow[$key]; 

                            }elseif( $field == 'descrizione_it'){ $rowArray['description'] = $dataRow[$key]; 

                            }elseif( $field == 'listino Retail ivato'){ $rowArray['regular_price'] = (string)number_format(floatval($dataRow[$key]), 2, '.'); 

                            }elseif( $field == 'quantita'){ $rowArray['stock_quantity'] = intval($dataRow[$key]); 

                            }elseif( $field == 'codice a barre'){ 
                                if(!isset($rowArray['meta_data'])){ $rowArray['meta_data'] = []; $rowArray['meta_data'][] = (object)["key" => "codice a barre", "value" =>  $dataRow[$key] ];
                                }else{ $rowArray['meta_data'][] = (object)["key" => "codice a barre", "value" =>  $dataRow[$key] ]; }

                            }elseif( $field == 'marca'){ 
                                if(!isset($rowArray['meta_data'])){
                                    $rowArray['meta_data'] = []; $rowArray['meta_data'][] = (object)["key" => "marca", "value" =>  $dataRow[$key] ];
                                }else{ $rowArray['meta_data'][] = (object)["key" => "marca", "value" =>  $dataRow[$key] ]; }

                            }elseif( $field == 'peso'){ 
                                if(!isset($rowArray['meta_data'])){
                                    $rowArray['meta_data'] = []; $rowArray['meta_data'][] = (object)["key" => "peso", "value" =>  $dataRow[$key] ];
                                }else{ $rowArray['meta_data'][] = (object)["key" => "peso", "value" =>  $dataRow[$key] ]; }

                            }elseif( $field == 'colore'){ 
                                if(!isset($rowArray['meta_data'])){ $rowArray['meta_data'] = []; $rowArray['meta_data'][] = (object)["key" => "colore", "value" =>  $dataRow[$key] ];
                                }else{$rowArray['meta_data'][] = (object)["key" => "colore", "value" =>  $dataRow[$key] ]; }

                            }elseif( $field == 'costo ivato'){ 
                                if(!isset($rowArray['meta_data'])){ $rowArray['meta_data'] = []; $rowArray['meta_data'][] = (object)["key" => "costo ivato", "value" =>  $dataRow[$key] ];
                                }else{ $rowArray['meta_data'][] = (object)["key" => "costo ivato", "value" =>  $dataRow[$key] ]; }

                            }elseif( $field == 'listino ufficiale netto'){ 
                                if(!isset($rowArray['meta_data'])){ $rowArray['meta_data'] = []; $rowArray['meta_data'][] = (object)["key" => "listino ufficiale netto", "value" =>  $dataRow[$key] ];
                                }else{ $rowArray['meta_data'][] = (object)["key" => "listino ufficiale netto", "value" =>  $dataRow[$key] ]; }

                            }elseif( $field == 'immagini'){ 

                                $explodeImmagini = explode('>', $dataRow[$key] );

                                // gallery_images

                                foreach($explodeImmagini as $immagine){

                                    if(!isset($rowArray['gallery_images'])){ $rowArray['gallery_images'] = []; $rowArray['gallery_images'][] = (object)["src" => trim($immagine)];
                                    }else{ $rowArray['gallery_images'][] = (object)["src" => trim($immagine)]; }    

                                }

                                // images

                                if(!isset($rowArray['images'])){ $rowArray['images'] = []; $rowArray['images'][] = (object)["src" => trim($explodeImmagini[0])];
                                }else{ $rowArray['images'][] = (object)["src" => trim($explodeImmagini[0])]; }    

                            }elseif( $field == 'categoria_it'){ 

                                $explodeCategoria_it = explode('>', $dataRow[$key] ); 
                                // Debug exp: exlode restituisce una array vuoto nel caso in cui $dataRow[$key] è una stringa vuota

                                if(is_array($explodeCategoria_it) && !empty($explodeCategoria_it)){

                                    foreach($explodeCategoria_it as $categoria){

                                        $id_categoria;
                                        $categoria = (string)trim($categoria);

                                        $term_categoria = get_term_by('name', $categoria, 'product_cat');

                                        if(!$term_categoria){  
                                            $new_term = wp_insert_term($categoria, 'product_cat'); 
                                            if(!is_wp_error($new_term)){ 
                                                $id_categoria = $new_term['term_id']; 
                                            }else{
                                                // 296 è la categoria di default "Tutti i prodotti" se non sono indicate categorie nel CSV
                                                $id_categoria = 296;
                                            }
                                        }else{ 
                                            $id_categoria = $term_categoria->term_id; 
                                        }

                                        if(!isset($rowArray['categories'])){ $rowArray['categories'] = []; $rowArray['categories'][] = (object)["id" => $id_categoria];
                                        }else{ $rowArray['categories'][] = (object)["id" => $id_categoria]; }

                                    }

                                }

                            }else{
                                $rowArray[$field] = $dataRow[$key]; // Assegna valore ai campi
                            }

                    
                            // Aggiunta di campi non gestiti dal CSV esterno

                            // $rowArray['sale_price'] = (string)number_format(0, 2, '.');
                            $rowArray['sale_price'] = ""; // sale_price
                            $rowArray['short_description'] = ""; // short_description
                            if(!isset($rowArray['meta_data'])){ $rowArray['meta_data'] = []; $rowArray['meta_data'][] = (object)["key" => "acquistato_n_volte", "value" =>  "1" ]; // acquistato_n_volte
                            }else{ $rowArray['meta_data'][] = (object)["key" => "acquistato_n_volte", "value" => "1" ]; }
                            if(!isset($rowArray['meta_data'])){ $rowArray['meta_data'] = []; $rowArray['meta_data'][] = (object)["key" => "valore_punti_fedeltà", "value" =>  "50" ]; // valore_punti_fedeltà
                            }else{ $rowArray['meta_data'][] = (object)["key" => "valore_punti_fedeltà", "value" => "50" ]; }
                            if(!isset($rowArray['meta_data'])){ $rowArray['meta_data'] = []; $rowArray['meta_data'][] = (object)["key" => "peso_volumetrico", "value" =>  "50" ]; // peso_volumetrico
                            }else{ $rowArray['meta_data'][] = (object)["key" => "peso_volumetrico", "value" => "50" ]; }
                            if(!isset($rowArray['meta_data'])){ $rowArray['meta_data'] = []; $rowArray['meta_data'][] = (object)["key" => "tab_composizione_prodotto", "value" =>  "Materiale parte superiore:Pelle;Rivestimento:Pelle;Soletta:Pelle;Suola:Gomma naturale" ]; // tab_composizione_prodotto
                            }else{ $rowArray['meta_data'][] = (object)["key" => "tab_composizione_prodotto", "value" => "Materiale parte superiore:Pelle;Rivestimento:Pelle;Soletta:Pelle;Suola:Gomma naturale" ]; }
                            if(!isset($rowArray['meta_data'])){ $rowArray['meta_data'] = []; $rowArray['meta_data'][] = (object)["key" => "tab_dettagli_prodotto", "value" =>  "Punta:Tonda;Tipo di tacco:Tacco largo;Chiusura:Fibbia;Fantasia:Monocromo;Dettaglio:Accessorio oro satinanto;Codice aritcolo:01POE849599;Altezza tacco:3.9cm" ]; // tab_dettagli_prodotto
                            }else{ $rowArray['meta_data'][] = (object)["key" => "tab_dettagli_prodotto", "value" => "Punta:Tonda;Tipo di tacco:Tacco largo;Chiusura:Fibbia;Fantasia:Monocromo;Dettaglio:Accessorio oro satinanto;Codice aritcolo:01POE849599;Altezza tacco:3.9cm" ]; }
                            if(!isset($rowArray['meta_data'])){ $rowArray['meta_data'] = []; $rowArray['meta_data'][] = (object)["key" => "consigliato_da_helu", "value" =>  "1" ]; // consigliato_da_helu || value 1/0
                            }else{ $rowArray['meta_data'][] = (object)["key" => "consigliato_da_helu", "value" => "" ]; }
                            if(!isset($rowArray['meta_data'])){ $rowArray['meta_data'] = []; $rowArray['meta_data'][] = (object)["key" => "scelta_top", "value" =>  "" ]; // scelta_top || value 1/0
                            }else{ $rowArray['meta_data'][] = (object)["key" => "scelta_top", "value" => "" ]; }
                        
                    }

                    // START Logica per caricare il prodotto


                    // START Debugging section
                    ob_start();
                        echo "data: " . (string)json_encode((object)$rowArray) . "\n\n";
                    ob_flush();
                    flush(); 
                    // END Debugging section


                    $product_data = (object)$rowArray;

                    $client = new Client(); 
                    $response = $client->request('POST', $url, ['json' => $product_data] );

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
