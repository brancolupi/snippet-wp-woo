// Rediraction by user's browser-language

var lingua = navigator.language || navigator.userLanguage;
var url_endpoint = 'https://' + window.location.host + '/shop/us/homepage/'; // hostname + US pathname
var url_it = 'https://' + window.location.host + '/shop/it/homepage/'; // hostname + IT pathname
var url_eu = 'https://' + window.location.host + '/shop/eu/homepage/'; // hostname + EU pathname
var url_us = 'https://' + window.location.host + '/shop/us/homepage/'; // hostname + US pathname


// Elenco delle lingue ISO 639-1 (due lettere) e ISO 639-2/B (tre lettere) rilevabili attraverso navigator.language:
// Afrikaans: 'af'
// Albanese: 'sq'
// Arabo: 'ar'
// Bielorusso: 'be'
// Bengalese: 'bn'
// Bosniaco: 'bs'
// Bulgaro: 'bg'
// Catalano: 'ca'
// Cinese (semplificato): 'zh'
// Cinese (tradizionale): 'zh-TW'
// Croato: 'hr'
// Ceco: 'cs'
// Danese: 'da'
// Olandese: 'nl'
// Inglese: 'en'
// Esperanto: 'eo'
// Estone: 'et'
// Filippino: 'fil'
// Finlandese: 'fi'
// Francese: 'fr'
// Galiziano: 'gl'
// Georgiano: 'ka'
// Tedesco: 'de'
// Greco: 'el'
// Gujarati: 'gu'
// Haitiano Creolo: 'ht'
// Hausa: 'ha'
// Ebraico: 'he'
// Hindi: 'hi'
// Ungherese: 'hu'
// Islandese: 'is'
// Igbo: 'ig'
// Indonesiano: 'id'
// Irlandese: 'ga'
// Italiano: 'it'
// Giapponese: 'ja'
// Kannada: 'kn'
// Kazako: 'kk'
// Khmer: 'km'
// Coreano: 'ko'
// Kurdo: 'ku'
// Kirghiso: 'ky'
// Lao: 'lo'
// Latino: 'la'
// Lettone: 'lv'
// Lituano: 'lt'
// Macedone: 'mk'
// Malgascio: 'mg'
// Malese: 'ms'
// Maltese: 'mt'
// Maori: 'mi'
// Marathi: 'mr'
// Mongolo: 'mn'
// Nepalese: 'ne'
// Norvegese: 'no'
// Persiano: 'fa'
// Polacco: 'pl'
// Portoghese: 'pt'
// Punjabi: 'pa'
// Rumeno: 'ro'
// Russo: 'ru'
// Samoano: 'sm'
// Scozzese Gaelico: 'gd'
// Serbo: 'sr'
// Sesotho: 'st'
// Shona: 'sn'
// Sindhi: 'sd'
// Singalese: 'si'
// Slovacco: 'sk'
// Sloveno: 'sl'
// Somalo: 'so'
// Spagnolo: 'es'
// Sundanese: 'su'
// Swahili: 'sw'
// Svedese: 'sv'
// Tagalog: 'tl'
// Tamil: 'ta'
// Tatar: 'tt'
// Telugu: 'te'
// Tailandese: 'th'
// Turco: 'tr'
// Turkmeno: 'tk'
// Ucraino: 'uk'
// Urdu: 'ur'
// Uzbeco: 'uz'
// Vietnamita: 'vi'
// Gallese: 'cy'
// Xhosa: 'xh'
// Yiddish: 'yi'
// Yoruba: 'yo'
// Zulu: 'zu'

// Potrebbero esserci altre lingue supportate da browser diversi.


var lingueItaliane = ['it', 'it-IT', 'it-CH', 'it-SM', 'it-SM'];
var lingueEuropee = ['sq', 'bs', 'bg', 'ca', 'hr', 'cs', 'da', 'nl', 'en', 'en-GB', 'eo', 'et', 'fi', 'fr', 'fr-BE', 'fr-CH', 'fr-FR', 'gl', 'de', 'de-AT', 'de-CH', 'de-DE', 'el', 'hu', 'is', 'ga', 'la', 'lv', 'lt', 'mk', 'mt', 'no', 'pl', 'pt', 'pt-BR', 'ro', 'ru', 'sr', 'sk', 'sl', 'es', 'es-ES', 'es-MX', 'es-AR', 'es-CL', 'es-CO', 'es-CR', 'es-DO', 'es-EC', 'es-GT', 'es-HN', 'es-NI', 'es-PA', 
    'es-PE', 'es-PR', 'es-PY', 'es-SV', 'es-UY', 'es-VE', 'sv', 'sv-SE', 'uk'];
var lingueUSA = ['en-US'];
var lingueExtra = ['af', 'ar', 'be', 'bn', 'zh', 'zh-TW', 'fil', 'gu', 'ht', 'ha', 'he', 'hi', 'id', 'ja', 'kk', 'km', 'ko', 'ku', 'ky', 'lo', 'mg', 'ms', 'mi', 'mr', 'mn', 'ne', 'fa', 'pa', 'sd', 'si', 'so', 'su', 'sw', 'tl', 'ta', 'tt', 'te', 'th', 'tr', 'tk', 'ur', 'uz', 'vi', 'cy', 'xh', 'yi', 'yo', 'zu' ];

if( lingueItaliane.includes(lingua) ){ url_endpoint = url_it; }
if( lingueEuropee.includes(lingua) ){  url_endpoint = url_eu; }
if( lingueUSA.includes(lingua) ){ url_endpoint = url_us; }

if(window.location.href != url_endpoint){ window.location.href = url_endpoint; }
