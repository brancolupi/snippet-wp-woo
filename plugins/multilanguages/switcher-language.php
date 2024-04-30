<form id="form_language" name="switcher-language" method="POST" action="/">
   
    <select id="select_language" name="language" style="background: transparent; border: 0px;">
        
        <?php if(WC()->session->get( 'language' ) == 'it_IT' || is_null(WC()->session->get( 'language' )) ){ ?>

        <option value="it_IT">ITA</option>
        <option value="en_US">ENG</option>

        <?php }else{ ?>

        <option value="en_US">ENG</option>
        <option value="it_IT">ITA</option>

        <?php } ?>

    </select>   

</form>

<script>

    document.getElementById("select_language").addEventListener('change', function(){  

        var form_language = document.getElementById('form_language');
            			   
	    event.preventDefault();
			
        xhttpImpostaLingua = new XMLHttpRequest();
        var formData = new FormData(form_language);
    
        xhttpImpostaLingua.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){ location.reload(); }                   
        }
    
        xhttpImpostaLingua.open("POST", '/wp-content/themes/kitoko/incs/ajax-language.php', true);
        xhttpImpostaLingua.send(formData);
		
        });

</script>
