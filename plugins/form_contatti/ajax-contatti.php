<?php 

define('WP_USE_THEMES', false);
require_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

global $woocommerce;
global $wordpress;

if( isset($_POST['nome_contatto']) ){

$nome_contatto = $_POST['nome_contatto'];
$cognome_contatto = $_POST['cognome_contatto'];
$email_contatto = $_POST['email_contatto'];
$oggetto_contatto = $_POST['oggetto_contatto'];
$contenuto_contatto = $_POST['contenuto_contatto'];
$privacy_contatto = $_POST['privacy_contatto'];

// $to = 'info@fondazionenikolaos.com';
$to = 'lucio.asciolla@holly.agency';

$subject = 'Richiesta di contatto ' .  $nome_contatto . ' ' . $cognome_contatto;


$message = <<<HTML
   Hai ricevuto una richiesta di contatto:
   Nominativo: $nome_contatto $cognome_contatto
   Email: $email_contatto

   Oggetto: $oggetto_contatto
   Messaggio: $contenuto_contatto
   
   L'utente ha accettato che i dati rilasciati vengano trattati secondo la Privacy Polity del sito https://www.fondazionenikolaos.com/.
HTML;

$headers = array(
        'From' => 'no-reply@helushop.com',
        'Reply-To' => 'no-reply@stampasoluzioni.it',
        'X-Mailer' => 'X-Mailer: PHP v' . phpversion()    
);

    
$send_email = wp_mail($to, $subject, $message, $headers);

if($send_email){
        echo 'Messaggio inviato con successo. Sarà ricontattato al più presto.';
} else {
        echo 'Si è verificato un errore. Contattaci con un altro canale.';
}


} 

?>