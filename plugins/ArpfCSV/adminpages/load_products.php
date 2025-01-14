<?php

// Come funziona:

// Abilitazione dell'API REST:

// Accedi al tuo pannello di amministrazione di WordPress.
// Vai su WooCommerce > Impostazioni > Avanzate > REST API.
// Crea una nuova chiave API assegnando i permessi necessari (lettura e scrittura per l'inserimento di prodotti).
// Utilizzo di PHP:

// Installazione delle librerie: Per semplificare l'interazione con l'API, puoi utilizzare librerie come la WooCommerce REST API Client Library.
// Autenticazione: Utilizza la chiave API e il segreto ottenuti al punto 1 per autenticarti.
// Creazione della richiesta: Costruisci una richiesta HTTP POST all'endpoint appropriato dell'API, fornendo i dati del prodotto nel formato JSON.
// Invio della richiesta: Invia la richiesta all'API utilizzando una libreria HTTP per PHP, come GuzzleHttp.
// Gestione della risposta: Analizza la risposta dell'API per verificare se l'operazione è andata a buon fine e gestire eventuali errori.

// Sostituisci con i tuoi dati

$consumer_key = "ck_57fcfa65b2b3326b9a1d5d50827dff660d0ce936"; // $consumer_key = 'tua_chiave_api';
$consumer_secret = "cs_1329bbf5ab15f2e4a5c25a275843387bb5453a96"; // $consumer_secret = 'tuo_segreto_api';
$url = 'https://charming-margulis.78-46-83-170.plesk.page/wp-json/wc/v2/products?consumer_key=' . $consumer_key . '&consumer_secret=' . $consumer_secret; // $url = 'https://tuo-dominio.com/wp-json/wc/v3/products';


// Dati del prodotto da inserire
$product_data = [
    'name' => 'Premium Quality',
    'type' => 'simple',
    'regular_price' => '21.99',
    'description' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.',
    'short_description' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.',
];

$product_data = (object)$product_data;

use GuzzleHttp\Client; 

$client = new Client(); 

$response = $client->request('POST', $url, ['json' => $product_data] );

if($response->getStatusCode() === 201){
    echo 'Prodotto inserito con successo!';
    // print_r($product_data);
}else{
    echo 'Errore durante l\'inserimento del prodotto: ' . $response->getBody();
    // print_r($product_data);
}


?>