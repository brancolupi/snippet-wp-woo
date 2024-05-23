<?php 
/** 
* Template Name: Custom Registrazione rivenditori
*/
get_header(); 

?>

<div class="container-fluid">
    <div class="row align-items-center justify-content-center text-center pt-5 pb-2 ps-0 pe-0">
        <div class="col">
            <h1>Registrazione professionisti</h1>
            <p>Effettua la registrazione per visualizzare il listino riservato</p>
        </div>
    </div>
    <div class="row align-items-center justify-content-center text-center pt-5 pb-2 ps-0 pe-0">
        <div class="col">
            <form id="registrazione-rivenditori" name="registrazione-rivenditori" method="POST" action="">

                <div class="row align-items-center justify-content-center text-start pt-0 pb-4 ps-0 pe-0">  

                    <div class="col-6 mt-0 mb-4 ms-0 me-0">
                        <h2 class="h2-helu text-center" style="color:#CA8759; font-weight:bold;">DATI AZIENDALI</h2>
                    </div>

                </div>   

                <div class="row align-items-center justify-content-center text-start pt-0 pb-0 ps-5 pe-5">

                    <div class="col-2 mt-0 mb-0 ms-0 me-2">
                        <label>Nome</label><br>
                        <input type="text" name="nome_rivenditore" value="" style="width:100%; border: 0; border-bottom: 1px solid;" required>
                    </div>
                    <div class="col-2 mt-0 mb-0 ms-0 me-2">
                        <label>Cognome</label><br>
                        <input type="text" name="cognome_rivenditore" value="" style="width:100%; border: 0; border-bottom: 1px solid;" required>
                    </div>
                    <div class="col-2 mt-0 mb-0 ms-0 me-2">
                        <label>Ragione sociale</label><br>
                        <input type="text" name="ragione_sociale_rivenditore" value="" style="width:100%; border: 0; border-bottom: 1px solid;" required>
                    </div>

                </div>

                <div class="row align-items-center justify-content-center text-start pt-2 pb-0 ps-5 pe-5">

                    <div class="col-2 mt-0 mb-0 ms-0 me-2">
                        <label>Codice fiscale</label><br>
                        <input type="text" name="codice_fiscale_rivenditore" value="" style="width:100%; border: 0; border-bottom: 1px solid;" required>
                    </div>
                    <div class="col-2 mt-0 mb-0 ms-0 me-2">
                        <label>P.IVA</label><br>
                        <input type="text" name="p_iva_rivenditore" value="" style="width:100%; border: 0; border-bottom: 1px solid;" required>
                    </div>
                    <div class="col-2 mt-0 mb-0 ms-0 me-2">
                        <label>Codice SDI</label><br>
                        <input type="text" name="sdi_rivenditore" value="" style="width:100%; border: 0; border-bottom: 1px solid;" required>
                    </div>

                </div>

                <div class="row align-items-center justify-content-center text-start pt-2 pb-0 ps-5 pe-5">

                    <div class="col-2 mt-0 mb-0 ms-0 me-2">
                        <label>Telefono</label><br>
                        <input type="text" name="telefono_rivenditore" value="" style="width:100%; border: 0; border-bottom: 1px solid;" required>
                    </div>
                    <div class="col-2 mt-0 mb-0 ms-0 me-2">
                        <label>Via e numero</label><br>
                        <input type="text" name="via_e_numero_rivenditore" value="" style="width:100%; border: 0; border-bottom: 1px solid;" required>
                    </div>
                    <div class="col-2 mt-0 mb-0 ms-0 me-2">
                        <label>C.A.P.</label><br>
                        <input type="text" name="cap_rivenditore" value="" style="width:100%; border: 0; border-bottom: 1px solid;" required>
                    </div>

                </div>

                <div class="row align-items-center justify-content-center text-start pt-2 pb-0 ps-5 pe-5">

                    <div class="col-2 mt-0 mb-0 ms-0 me-2">
                        <label>Città</label><br>
                        <input type="text" name="citta_rivenditore" value="" style="width:100%; border: 0; border-bottom: 1px solid;" required>
                    </div>
                    <div class="col-2 mt-0 mb-0 ms-0 me-2">
                        <label>Provincia</label><br>
                        <select name="provincia_rivenditore" id="provincia_rivenditore" class="state_select select2-hidden-accessible" autocomplete="address-level1" data-placeholder="Seleziona un'opzione…" data-input-classes="" data-label="Provincia" tabindex="-1" aria-hidden="true" required><option value="">Seleziona un'opzione…</option><option value="AG">Agrigento</option><option value="AL">Alessandria</option><option value="AN">Ancona</option><option value="AO">Aosta</option><option value="AR">Arezzo</option><option value="AP">Ascoli Piceno</option><option value="AT">Asti</option><option value="AV">Avellino</option><option value="BA">Bari</option><option value="BT">Barletta-Andria-Trani</option><option value="BL">Belluno</option><option value="BN">Benevento</option><option value="BG">Bergamo</option><option value="BI">Biella</option><option value="BO">Bologna</option><option value="BZ">Bolzano</option><option value="BS">Brescia</option><option value="BR">Brindisi</option><option value="CA">Cagliari</option><option value="CL">Caltanissetta</option><option value="CB">Campobasso</option><option value="CE">Caserta</option><option value="CT">Catania</option><option value="CZ">Catanzaro</option><option value="CH">Chieti</option><option value="CO">Como</option><option value="CS">Cosenza</option><option value="CR">Cremona</option><option value="KR">Crotone</option><option value="CN">Cuneo</option><option value="EN">Enna</option><option value="FM">Fermo</option><option value="FE">Ferrara</option><option value="FI">Firenze</option><option value="FG">Foggia</option><option value="FC">Forlì-Cesena</option><option value="FR">Frosinone</option><option value="GE">Genova</option><option value="GO">Gorizia</option><option value="GR">Grosseto</option><option value="IM">Imperia</option><option value="IS">Isernia</option><option value="SP">La Spezia</option><option value="AQ">L'Aquila</option><option value="LT">Latina</option><option value="LE">Lecce</option><option value="LC">Lecco</option><option value="LI">Livorno</option><option value="LO">Lodi</option><option value="LU">Lucca</option><option value="MC">Macerata</option><option value="MN">Mantova</option><option value="MS">Massa-Carrara</option><option value="MT">Matera</option><option value="ME">Messina</option><option value="MI">Milano</option><option value="MO">Modena</option><option value="MB">Monza e della Brianza</option><option value="NA">Napoli</option><option value="NO">Novara</option><option value="NU">Nuoro</option><option value="OR">Oristano</option><option value="PD">Padova</option><option value="PA">Palermo</option><option value="PR">Parma</option><option value="PV">Pavia</option><option value="PG">Perugia</option><option value="PU">Pesaro e Urbino</option><option value="PE">Pescara</option><option value="PC">Piacenza</option><option value="PI">Pisa</option><option value="PT">Pistoia</option><option value="PN">Pordenone</option><option value="PZ">Potenza</option><option value="PO">Prato</option><option value="RG">Ragusa</option><option value="RA">Ravenna</option><option value="RC">Reggio Calabria</option><option value="RE">Reggio Emilia</option><option value="RI">Rieti</option><option value="RN">Rimini</option><option value="RM">Roma</option><option value="RO">Rovigo</option><option value="SA">Salerno</option><option value="SS">Sassari</option><option value="SV">Savona</option><option value="SI">Siena</option><option value="SR">Siracusa</option><option value="SO">Sondrio</option><option value="SU">Sud Sardegna</option><option value="TA">Taranto</option><option value="TE">Teramo</option><option value="TR">Terni</option><option value="TO">Torino</option><option value="TP">Trapani</option><option value="TN">Trento</option><option value="TV">Treviso</option><option value="TS">Trieste</option><option value="UD">Udine</option><option value="VA">Varese</option><option value="VE">Venezia</option><option value="VB">Verbano-Cusio-Ossola</option><option value="VC">Vercelli</option><option value="VR">Verona</option><option value="VV">Vibo Valentia</option><option value="VI">Vicenza</option><option value="VT">Viterbo</option></select>
                    </div>
                    <div class="col-2 mt-0 mb-0 ms-0 me-2">
                        <label>Paese/regione</label><br>
                        <select name="nazione_rivenditore" id="nazione_rivenditore" class="country_to_state country_select select2-hidden-accessible" autocomplete="country" data-placeholder="Seleziona un Paese/una regione…" data-label="Paese/regione" tabindex="-1" aria-hidden="true" required><option value="">Seleziona un Paese/una regione…</option><option value="AF">Afghanistan</option><option value="AL">Albania</option><option value="DZ">Algeria</option><option value="AS">American Samoa</option><option value="AD">Andorra</option><option value="AO">Angola</option><option value="AI">Anguilla</option><option value="AQ">Antartide</option><option value="AG">Antigua e Barbuda</option><option value="SA">Arabia Saudita</option><option value="AR">Argentina</option><option value="AM">Armenia</option><option value="AW">Aruba</option><option value="AU">Australia</option><option value="AT">Austria</option><option value="AZ">Azerbaijan</option><option value="BS">Bahamas</option><option value="BH">Bahrain</option><option value="BD">Bangladesh</option><option value="BB">Barbados</option><option value="PW">Belau</option><option value="BE">Belgio</option><option value="BZ">Belize</option><option value="BJ">Benin</option><option value="BM">Bermuda</option><option value="BT">Bhutan</option><option value="BY">Bielorussia</option><option value="MM">Birmania</option><option value="BO">Bolivia</option><option value="BQ">Bonaire, Saint Eustatius e Saba</option><option value="BA">Bosnia-Erzegovina</option><option value="BW">Botswana</option><option value="BR">Brasile</option><option value="BN">Brunei</option><option value="BG">Bulgaria</option><option value="BF">Burkina Faso</option><option value="BI">Burundi</option><option value="KH">Cambogia</option><option value="CM">Camerun</option><option value="CA">Canada</option><option value="CV">Capo Verde</option><option value="TD">Ciad</option><option value="CL">Cile</option><option value="CN">Cina</option><option value="CY">Cipro</option><option value="CO">Colombia</option><option value="KM">Comore</option><option value="CG">Congo (Brazzaville)</option><option value="CD">Congo (Kinshasa)</option><option value="KP">Corea del Nord</option><option value="KR">Corea del Sud</option><option value="CI">Costa d'Avorio</option><option value="CR">Costa Rica</option><option value="HR">Croazia</option><option value="CU">Cuba</option><option value="CW">Curaçao</option><option value="DK">Danimarca</option><option value="DM">Dominica</option><option value="EC">Ecuador</option><option value="EG">Egitto</option><option value="SV">El Salvador</option><option value="AE">Emirati Arabi Uniti</option><option value="ER">Eritrea</option><option value="EE">Estonia</option><option value="SZ">Eswatini</option><option value="ET">Etiopia</option><option value="FJ">Figi</option><option value="PH">Filippine</option><option value="FI">Finlandia</option><option value="FR">Francia</option><option value="GA">Gabon</option><option value="GM">Gambia</option><option value="GE">Georgia</option><option value="DE">Germania</option><option value="GH">Ghana</option><option value="JM">Giamaica</option><option value="JP">Giappone</option><option value="GI">Gibilterra</option><option value="DJ">Gibuti</option><option value="JO">Giordania</option><option value="GR">Grecia</option><option value="GD">Grenada</option><option value="GL">Groenlandia</option><option value="GP">Guadalupa</option><option value="GU">Guam</option><option value="GT">Guatemala</option><option value="GG">Guernsey</option><option value="GN">Guinea</option><option value="GQ">Guinea Equatoriale</option><option value="GW">Guinea-Bissau</option><option value="GY">Guyana</option><option value="GF">Guyana Francese</option><option value="HT">Haiti</option><option value="HN">Honduras</option><option value="HK">Hong Kong</option><option value="IN">India</option><option value="ID">Indonesia</option><option value="IR">Iran</option><option value="IQ">Iraq</option><option value="IE">Irlanda</option><option value="IS">Islanda</option><option value="BV">Isola Bouvet</option><option value="IM">Isola di Man</option><option value="CX">Isola di Natale</option><option value="NF">Isola Norfolk</option><option value="AX">Isole Åland</option><option value="KY">Isole Cayman</option><option value="CC">Isole Cocos (Keeling)</option><option value="CK">Isole Cook</option><option value="FK">Isole Falkland</option><option value="FO">Isole Faroe</option><option value="HM">Isole Heard e McDonald</option><option value="MH">Isole Marshall</option><option value="SB">Isole Salomone</option><option value="VI">Isole Vergini Americane</option><option value="VG">Isole Vergini Britanniche</option><option value="IL">Israele</option><option value="IT">Italia</option><option value="JE">Jersey</option><option value="KZ">Kazakistan</option><option value="KE">Kenya</option><option value="KG">Kirghizistan</option><option value="KI">Kiribati</option><option value="KW">Kuwait</option><option value="LA">Laos</option><option value="LS">Lesotho</option><option value="LV">Lettonia</option><option value="LB">Libano</option><option value="LR">Liberia</option><option value="LY">Libia</option><option value="LI">Liechtenstein</option><option value="LT">Lituania</option><option value="LU">Lussemburgo</option><option value="MO">Macao</option><option value="MK">Macedonia del Nord</option><option value="MG">Madagascar</option><option value="MW">Malawi</option><option value="MY">Malaysia</option><option value="MV">Maldive</option><option value="ML">Mali</option><option value="MT">Malta</option><option value="MA">Marocco</option><option value="MQ">Martinica</option><option value="MR">Mauritania</option><option value="MU">Mauritius</option><option value="YT">Mayotte</option><option value="MX">Messico</option><option value="FM">Micronesia</option><option value="MD">Moldavia</option><option value="MC">Monaco</option><option value="MN">Mongolia</option><option value="ME">Montenegro</option><option value="MS">Montserrat</option><option value="MZ">Mozambico</option><option value="NA">Namibia</option><option value="NR">Nauru</option><option value="NP">Nepal</option><option value="NI">Nicaragua</option><option value="NE">Niger</option><option value="NG">Nigeria</option><option value="NU">Niue</option><option value="MP">Northern Mariana Islands</option><option value="NO">Norvegia</option><option value="NC">Nuova Caledonia</option><option value="NZ">Nuova Zelanda</option><option value="OM">Oman</option><option value="NL">Paesi Bassi</option><option value="PK">Pakistan</option><option value="PA">Panama</option><option value="PG">Papua Nuova Guinea</option><option value="PY">Paraguay</option><option value="PE">Perù</option><option value="PN">Pitcairn</option><option value="PF">Polinesia Francese</option><option value="PL">Polonia</option><option value="PT">Portogallo</option><option value="PR">Puerto Rico</option><option value="QA">Qatar</option><option value="GB">Regno Unito (UK)</option><option value="CZ">Repubblica Ceca</option><option value="CF">Repubblica Centrafricana</option><option value="DO">Repubblica Dominicana</option><option value="RE">Reunion</option><option value="RO">Romania</option><option value="RU">Russia</option><option value="RW">Rwanda</option><option value="EH">Sahara Occidentale</option><option value="SH">Saint Helena</option><option value="KN">Saint Kitts e Nevis</option><option value="LC">Saint Lucia</option><option value="MF">Saint Martin (Francia)</option><option value="SX">Saint Martin (Paesi Bassi)</option><option value="VC">Saint Vincent e Grenadine</option><option value="BL">Saint-Barthélemy</option><option value="PM">Saint-Pierre e Miquelon</option><option value="WS">Samoa</option><option value="SM">San Marino</option><option value="ST">São Tomé e Príncipe</option><option value="SN">Senegal</option><option value="RS">Serbia</option><option value="SC">Seychelles</option><option value="SL">Sierra Leone</option><option value="SG">Singapore</option><option value="SY">Siria</option><option value="SK">Slovacchia</option><option value="SI">Slovenia</option><option value="SO">Somalia</option><option value="GS">South Georgia/Sandwich Islands</option><option value="ES">Spagna</option><option value="LK">Sri Lanka</option><option value="US">Stati Uniti (US)</option><option value="UM">Stati Uniti (US) Isole Minori</option><option value="ZA">Sud Africa</option><option value="SD">Sudan</option><option value="SS">Sudan del Sud</option><option value="SR">Suriname</option><option value="SJ">Svalbard e Jan Mayen</option><option value="SE">Svezia</option><option value="CH">Svizzera</option><option value="TJ">Tagikistan</option><option value="TH">Tailandia</option><option value="TW">Taiwan</option><option value="TZ">Tanzania</option><option value="TF">Terre Australi e Antartiche Francesi</option><option value="PS">Territori palestinesi</option><option value="IO">Territorio Britannico dell'Oceano Indiano</option><option value="TL">Timor Est</option><option value="TG">Togo</option><option value="TK">Tokelau</option><option value="TO">Tonga</option><option value="TT">Trinidad e Tobago</option><option value="TN">Tunisia</option><option value="TR">Turchia</option><option value="TM">Turkmenistan</option><option value="TC">Turks e Caicos</option><option value="TV">Tuvalu</option><option value="UA">Ucraina</option><option value="UG">Uganda</option><option value="HU">Ungheria</option><option value="UY">Uruguay</option><option value="UZ">Uzbekistan</option><option value="VU">Vanuatu</option><option value="VA">Vaticano</option><option value="VE">Venezuela</option><option value="VN">Vietnam</option><option value="WF">Wallis e Futuna</option><option value="YE">Yemen</option><option value="ZM">Zambia</option><option value="ZW">Zimbabwe</option></select>
                    </div>

                </div>

                <div class="row align-items-center justify-content-center text-start pt-5 pb-4 ps-0 pe-0">  

                    <div class="col-6 mt-0 mb-4 ms-0 me-0">
                        <h2 class="h2-helu text-center" style="color:#CA8759; font-weight:bold;">DATI D'ACCESSO</h2>
                    </div>

                </div>   

                <div class="row align-items-center justify-content-center text-start pt-0 pb-0 ps-5 pe-5">

                    <div class="col-2 mt-0 mb-0 ms-0 me-2">
                        <label>Email</label><br>
                        <input type="email" name="email_rivenditore" value="" style="width:100%; border: 0; border-bottom: 1px solid;" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
                    </div>
                    <div class="col-2 mt-0 mb-0 ms-0 me-2">
                        <label>Password</label><br>
                        <input type="text" name="password_rivenditore" value="" style="width:100%; border: 0; border-bottom: 1px solid;" required>
                    </div>

                </div>


                <div class="row align-items-center justify-content-center text-center mt-4 pt-5 pb-2 ps-0 pe-0">

                    <div class="col">

                        <button class="botton-helu" style="border: 0px; padding: 0.25% 5%;"
                        name="submit_registrazione_rivenditore" 
                        id="submit_registrazione_rivenditore" 
                        type="submit" 
                        onclick="event.preventDefault(); registraUtenteB2B();">
                        INVIA RICHIESTA
                        </button>

                    </div>

                </div>

                <div class="row align-items-center justify-content-center text-center mt-2 pt-2 pb-2 ps-0 pe-0">
                    <p id="notifica_registrazione_b2b" style="color: #CA8759; font-weight: bold;"></p>
                </div>

            </form>
        </div>
    </div>

    <script>
		var formRegistrazioneB2B = document.getElementById('registrazione-rivenditori');
        var notifica_registrazione_b2b = document.getElementById('notifica_registrazione_b2b');	
            
        function registraUtenteB2B(){
    
            xhttpRegistraUtenteB2B = new XMLHttpRequest();

            var formData = new FormData(formRegistrazioneB2B);

            var dataString = '';

            for(var [key, value] of formData){
                dataString += `${key}=${value}&`;
            }
    
                xhttpRegistraUtenteB2B.onreadystatechange = function(){
                    if(this.readyState == 4 && this.status == 200){
                        notifica_registrazione_b2b.innerHTML = this.responseText;
                        // setTimeout(() => {
                        //     location.reload();
                        // }, 1000);
                        }                   
                }
    
            xhttpRegistraUtenteB2B.open("POST", `/wp-content/themes/helu/inc/ajax-approva-b2b.php`, true);
            xhttpRegistraUtenteB2B.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhttpRegistraUtenteB2B.send(dataString);
        }

    </script>


</div>


<?php get_footer(); ?>