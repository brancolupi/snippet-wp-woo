// La seguente funzione è da inserire nel file functions.php del thema corrente o all'interno di un plugin esterno

function the_breadcrumb() {

    // Definizione del separatore

    $separator = ' <span style="color:#BA2F2F; font-weight:bold;"> » </span> ';
	
	// Inizia il breadcrumb con un collegamento alla tua home page

        $starter = <<<HTML
        <div class="breadcrumbs">
            <p class="h6" style="
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            justify-content: flex-start;
            align-items: center;
            "><img src="/wp-content/uploads/2024/03/home_icon.png" style="width:1%;"><a href="/">&nbsp;Home</a>
        HTML;

        echo $starter;
	
    // Controlla se la pagina corrente è una categoria, un archivio o una pagina singola. In tal caso mostra la categoria o il nome dell'archivio.
        
        if( is_category() || is_single() ){

            if( !is_archive() ){

            echo '&nbsp;' . $separator . '&nbsp;';
            the_category('title_li=');

            }

        }elseif( is_archive() || is_single()){

            if( is_day() ){
                printf( __( '%s', 'text_domain' ), get_the_date() );
            }elseif( is_month() ){
                printf( __( '%s', 'text_domain' ), get_the_date( _x( 'F Y', 'formato della data degli archivi mensili', 'text_domain' ) ) );
            }elseif ( is_year() ){
                printf( __( '%s', 'text_domain' ), get_the_date( _x( 'Y', 'formato della data degli archivi annuali', 'text_domain' ) ) );
            }else{
                _e( 'Archivio', 'text_domain' );
            }

        }


  	// Se la pagina corrente è una pagina categoria di un archivio, visualizzazione il nome dell'archivio ed il nome della categoria

        
        if( is_category() && is_archive() ){

            echo '&nbsp;' . $separator . '&nbsp;';
            global $post;
            $page_for_posts_id = get_option('page_for_posts');
            if ( $page_for_posts_id ){ 
                $post = get_post($page_for_posts_id);
                setup_postdata($post);
                the_title('<a href="'. get_permalink($post->ID) . '">','</a>');
                rewind_posts();
                wp_reset_postdata();
            }

            echo '&nbsp;' . $separator . '&nbsp;';
            the_category('title_li=');

        } 
	
	// Se la pagina corrente è la visualizzazione di un singolo post, mostra il separatore ed il suo titolo del post
       
        if( is_single() ){

            the_title( '&nbsp;' . $separator . '&nbsp;', '', true );
        }
	
	// Se la pagina corrente è una pagina statica, mostra il separatore ed il titolo della pagina
        
        if( is_page() ){

             the_title( '&nbsp;' . $separator . '&nbsp;', '', true );

        }
	
    // Se hai una pagina assegnata come pagina di elenco dei tuoi post. Troverà il titolo della pagina statica e lo visualizzerà. Es. Home >> Blog
        
        if( is_home() ){
            
            global $post;
            $page_for_posts_id = get_option('page_for_posts');
            if ( $page_for_posts_id ) { 
                $post = get_post($page_for_posts_id);
                setup_postdata($post);
                the_title( '&nbsp;' . $separator . '&nbsp;', '', true );
                rewind_posts();
            }

        }

        echo '</p></div>';

    }

		
// Richiamare la funzione all'interno delle pagine desiderate in questo modo

<div class="row align-items-center justify-content-center text-start">
        <div class="col-10 pt-3 pb-3">
            <?php the_breadcrumb(); ?>
</div>
</div>
