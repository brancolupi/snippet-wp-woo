<?php 
/** 
* Template Name: Custom Login
*/
get_header(); 
 
$login  = (isset($_GET['login']) ) ? $_GET['login'] : 0;
  
if($login === "failed"){ $error_message = '<p><strong style="color:black; font-size: 0.8rem;">Errore:&nbsp;</strong><span style="color:#ffa500; font-size: 0.8rem;"> Hai inserito un username o una password errata.</span></p>';
} elseif($login === "empty"){ $error_message = '<p><strong style="color:black; font-size: 0.8rem;">Errore:&nbsp;</strong><span style="color:#ffa500; font-size: 0.8rem;"> Alcuni campi sono stati lasciati vuoti.</span></p>';
} elseif($login === "false"){ $error_message = '<p><strong style="color:black; font-size: 0.8rem;">Errore:&nbsp;</strong><span style="color:#ffa500; font-size: 0.8rem;"> Ti sei disconesso.</span></p>'; }
  
?>
 
<body>

<style>
    :root{ --box-height: 50rem; }
    @media screen and (max-width: 500px) {
    :root{ --box-height: auto; }    
    }
</style>
     
<div class="container-fluid">

<div class="row align-items-center justify-content-center" style="margin:5%;">

    <div class="col-12 col-xl-4 align-items-center justify-content-center mt-4 mb-5 mt-xl-0 mb-xl-0" style="background: #FFE9CC; border-radius:5px; padding:5% 2%; margin: 0% 1% 0% 0%; height:var(--box-height);">

        <style> .input_reg_log { all: unset;  width: 95%;   height: 3rem;   padding: 0% 0% 0% 5%;   margin: 0% 0% 0% 0%;   background: white; } </style>
     
        <div class="row align-items-center justify-content-center">
            <div class="col">
                <h1 class="text-center" style="color: black; font-weight:bold;">Accedi</h1>    
            </div>
        </div>
        <div class="row align-items-center justify-content-center">

            <div class="col">

                <form name="custom_loginform" id="custom_loginform" action="/wp-login.php" method="post" style="background: transparent; padding:5%;">

                    <div class="row">
                        <p class="login-username">
                            <label for="user_login"></label>
                            <input class="input_reg_log" placeholder="La tua email" type="text" name="log" id="user_login" autocomplete="username" class="input" value="" size="20">
                        </p>                        
                    </div>

                    <div class="row">
                        <p class="login-password">
                            <label for="user_pass"></label>
                            <input class="input_reg_log" placeholder="La tua password" type="password" name="pwd" id="user_pass" autocomplete="current-password" class="input" value="" size="20">
                        </p>
                    </div>

                    <div class="row" style="margin-top:1%;">
                        <p class="text-start login-remember" style="color: white; margin-top:2%;">
                            <label style="color:black; font-size: 0.8rem;"><input name="rememberme" type="checkbox" id="rememberme" value="forever">&nbsp;&nbsp;Ricorda le mie credenziali</label>
                        </p>
                    </div>

                    <div class="row text-end">
                        <p class="login-submit" style="margin-top:5%;">
                            <input class="botton-helu" style="border: 0px;" type="submit" name="wp-submit" id="wp-submit" value="ACCEDI">
                            <input type="hidden" name="redirect_to" value="/wp-admin/">
                        </p>
                    </div>

                </form>

            </div>

        </div>
        <div class="row align-items-center justify-content-center">
            <div class="col" style="margin-right:5%;">        
                <div class="text-end">
                    <div><p style="color: black; font-size: 0.8rem;">Hai dimenticato la tua password? <a style="color: black;" href="/password-dimenticata">Recupera</a></p></div>
                    <div class="text-right" style="color: white; text-align:center; margin-top:5%;"><?php echo $error_message; ?></div>

                </div>
            </div>
        </div>   
    
    </div>

        
    <div class="col-12 col-xl-4" style="background: #FFF5E9; border-radius:5px; padding:5% 2%; margin: 0% 1% 0% 0%; height:50rem;">

        <style> .input_reg_log { all: unset;  width: 95%;   height: 3rem;   padding: 0% 0% 0% 5%;   margin: 0% 0% 0% 0%;   background: white; } </style>

        <div class="row align-items-center justify-content-center">
            <div class="col">
                <h1 class="text-center" style="color: black; font-weight:bold;">Registrati</h1>    
            </div>
        </div>

        <div class="row align-items-center justify-content-center text-center" style="margin-top:7%;">
            <div class="col">
                    <a style="background-color:#CA8759; padding: 2% 5%; border-radius:5px; color:white; padding: 2% !important; color: white !important;" href="/registrazione-rivenditori">SEI UN PROFESSIONISTA? Clicca qui</a>
                    <style> .b2b a:hover {    border-bottom: 0px solid #CA8759 !important; }</style>
            </div>
        </div>


        <div class="row align-items-center justify-content-center">

            <div class="col">

                <form name="custom_register_form" id="custom_register_form" action="/registrazione-utente" method="post" style="background: transparent; padding:5%;">

                    <div class="row">
                        <p class="register-nome-utente">
                            <label for="registrazione_nome_utente"></label>
                            <input class="input_reg_log" placeholder="Inserisci il tuo nome" type="text" name="registrazione_nome_utente" id="registrazione_nome_utente" class="input" value="" required>
                        </p>                        
                    </div>

                    <div class="row">
                        <p class="register-cognome-utente">
                            <label for="registrazione_cognome_utente"></label>
                            <input class="input_reg_log" placeholder="Inserisci il tuo cognome" type="text" name="registrazione_cognome_utente" id="registrazione_cognome_utente" class="input" value="" required>
                        </p>                        
                    </div>


                    <div class="row">
                        <p class="register-email-utente">
                            <label for="registrazione_email_utente"></label>
                            <input class="input_reg_log" placeholder="Inserisci la tua email" type="email" name="registrazione_email_utente" id="registrazione_email_utente" class="input" value="" required>
                        </p>                        
                    </div>

                    <div class="row">
                        <p class="register-password-utente">
                            <label for="registrazione_password_utente"></label>
                            <input class="input_reg_log" placeholder="Crea la tua password" type="password" name="registrazione_password_utente" id="registrazione_password_utente" class="input" value="" pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&amp;])[A-Za-z\d@$!%*#?&amp;]{8,}$" required>
                        </p>
                        <p style="font-size:0.8rem; margin-top:5%; color: #bfb8b8;">La password deve essere composta almeno da 8 caratteri, deve contenere almeno una lettera minuscola, una lettera maiuscola, un numero ed un carattere speciale (\|!"£$%&/()=?^[]+*@°#§,;.:-)</p>                        
                    </div>

                    <div class="row" style="margin-top:5%;">
                        <p class="text-start login-remember" style="color: white; margin-top:2%;">
                            <label style="color:black; font-size: 0.8rem;">
                            <input name="registrazione_accettazione_policy_privacy" type="checkbox" id="registrazione_accettazione_policy_privacy" value="" required>
                            &nbsp;&nbsp;Accetto che i dati rilasciati vengano trattati secondo la Privacy Policy del sito</label>
                        </p>
                    </div>
                    <div class="row" style="margin-top:1%;">
                        <p class="text-start login-remember" style="color: white;">
                            <label style="color:black; font-size: 0.8rem;">
                            <input name="registrazione_accettazione_newsletter" type="checkbox" id="registrazione_accettazione_newsletter" value="" required>
                            &nbsp;&nbsp;Accetto l’iscrizione al servizio di newsletter</label>
                        </p>
                    </div>

                    <div class="row text-end">
                        <p class="login-submit" style="margin-top:5%;">
                            <input class="botton-helu" style="border: 0px;" type="submit" name="submit_registrazione_utente" id="submit_registrazione_utente" value="REGISTRATI">
                        </p>
                    </div>

                </form>

            </div>

        </div> 

        </div>

</div>

     
</div>
 
 
 
<?php get_footer(); ?>