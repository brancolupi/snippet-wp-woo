<?php 


				header('Content-Type: text/event-stream');

				$csvFileName = $_GET['csvFileName']; // $csvFileName = 'exemple.csv';
				$csvFileRoot = "https://charming-margulis.78-46-83-170.plesk.page/wp-content/plugins/ArpfCSV/deposit/" . $csvFileName;
				$csvDelimiter = $_GET['delimiter']; // $csvDelimiter = ';';
                $chunkSize = $_GET['chunkSize'];  // $chunkSize = 100;

				// START Calcolo percentuale di lettura file
				//
				// Per calcolare la percentuale di lettura eseguita per il file csv, dobbiamo conoscere il numero totale di righe che sono contenute nel documento
				// e il punto/posizione in cui si trova il ciclo
				// la formula per calcolare la percentuale è la seguente:
				// Percentuale di lettura è uguale a: numero-riga-letta / totale-righe-documento x 100 
                
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

					// Array per conservare i dati
					$resultArray = [];
					
					// Array dematerializzati di dati
                    $tempArray = [];
					$serializedArray = serialize($tempArray);
                    $jsonedArray = json_encode($tempArray);
					
					// Leggere la prima riga (intestazione) che contiene i nomi dei campi
					$headerRow = fgetcsv($openFile, 1000, $csvDelimiter);

					// Controllare se la riga di intestazione è stata letta correttamente
					if ($headerRow != false) {

						// Determinare condizione di terminazione esplicita
						$finished = false;

						// Leggere le righe successive
						while(!$finished && ($dataRow = fgetcsv($openFile, 1000, $csvDelimiter)) != false) {

							// Inizia l'output buffering
							ob_start();

							// Creare un array associativo per ogni riga
							$rowArray = [];

							// Associare i dati ai rispettivi campi
							foreach ($headerRow as $key => $field) {
								$rowArray[$field] = $dataRow[$key]; // Assegna valore ai campi
							}

							// Aggiungere la riga all'array finale
							$resultArray[] = $rowArray;
							
							// Se il blocco ha raggiunto la dimensione massima, processalo e svuota l'array temporaneo
							if (count($resultArray) >= $chunkSize) {
								// Qui puoi elaborare il blocco di dati, ad esempio salvarlo in un database o inviarlo ad un'altra funzione
								$serializedArray = serialize(array_merge(unserialize($serializedArray), $resultArray));
                                (empty($jsonedArray)) ? $jsonedArray =  json_encode($resultArray) :  $jsonedArray = json_encode(array_merge(json_decode($jsonedArray), $resultArray));
								// Svuota l'array temporaneo
								$resultArray = [];

							}

							// Calcolo percentuale di lettura attuale
							$readedPercentual = ($numberOfReadedRow / $totalCountRows) * 100 + 1;

							// Invia l'evento solo quando il blocco è completo
							echo "data: " . (string)$readedPercentual . "\n\n"; // Il formato SSE richiede che i dati vengano inviati al client in un formato specifico, con una linea che inizia con "data: " seguita dai dati effettivi. Il doppio a capo (\n\n) è un elemento fondamentale nel formato SSE e garantisce una corretta comunicazione tra server e client. Assicurati di includerlo alla fine di ogni messaggio che invii utilizzando Server-Sent Events.

							// var_dump(unserialize($serializedArray));

								
							ob_flush(); // ob_flush(): Invia il contenuto del buffer di output al browser. Il buffer di output è un'area di memoria temporanea in cui PHP accumula i dati prima di inviarli al client. Non svuota il buffer. Il contenuto viene inviato al browser, ma rimane nel buffer.
							flush(); // flush(): Svuota il buffer di output del sistema operativo.
						
							// Incrementa il contatore solo dopo aver inviato l'evento
							$numberOfReadedRow++;

							// ob_end_flush(): Termina il buffering dell'output alla fine dello script.
							ob_end_flush();

							// Verificare che non sia EOF (End Of File)
							if(feof($openFile)){$finished = true; }

						}

						// Processa eventuali dati rimanenti nel blocco finale
						if (!empty($resultArray)) {
								$serializedArray = serialize(array_merge(unserialize($serializedArray), $resultArray));
                                (empty($jsonedArray)) ? $jsonedArray =  json_encode($resultArray) :  $jsonedArray = json_encode(array_merge(json_decode($jsonedArray), $resultArray));

						}

						// Invio JSON risultato di elaborazione
						ob_start();
                            echo "data: " . "EOF" . $jsonedArray . "\n\n"; 
						ob_flush();
						flush(); 
						ob_end_flush();

					}
                    
                    // Chiudere il file
                    fclose($openFile);

					// Stampa o utilizza l'array multidimensionale
					// var_dump(unserialize($serializedArray));


				}else{

				echo "Errore nell'apertura del file.";

				}


?>