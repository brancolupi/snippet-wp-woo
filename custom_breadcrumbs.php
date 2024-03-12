// La seguente funzione è da inserire nel file functions.php del thema corrente o all'interno di un plugin esterno

function the_breadcrumb() {

    $separator = ' <span style="color:#BA2F2F; font-weight:bold;"> » </span> ';
	
	// Start the breadcrumb with a link to your homepage

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
	
	// Check if the current page is a category, an archive or a single page. If so show the category or archive name.
    // Controlla se la pagina corrente è una categoria, un archivio o una pagina singola. In tal caso mostra la categoria o il nome dell'archivio.
        // if (is_category() || is_single() ){
        //     the_category('title_li=');
        // } elseif (is_archive() || is_single()){
        //     if ( is_day() ) {
        //         printf( __( '%s', 'text_domain' ), get_the_date() );
        //     } elseif ( is_month() ) {
        //         printf( __( '%s', 'text_domain' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'text_domain' ) ) );
        //     } elseif ( is_year() ) {
        //         printf( __( '%s', 'text_domain' ), get_the_date( _x( 'Y', 'yearly archives date format', 'text_domain' ) ) );
        //     } else {
        //         _e( 'Blog Archives', 'text_domain' );
        //     }
        // }
	
	// Se la pagina corrente è la visualizzazione di un singolo post, mostra la categoria di appartenzenza ed il suo titolo com separatori
        if (is_single()){

            echo '&nbsp;'.$separator.'&nbsp;';
            the_category('title_li=');

            the_title( '&nbsp;'.$separator.'&nbsp;', '', true );
        }
	
	// Se la pagina corrente è una pagina statica, mostra il suo titolo con separatore
        if (is_page()){

             the_title( '&nbsp;'.$separator.'&nbsp;', '', true );

        }
	
	// if you have a static page assigned to be you posts list page. It will find the title of the static page and display it. i.e Home >> Blog
        // if (is_home()){
        //     global $post;
        //     $page_for_posts_id = get_option('page_for_posts');
        //     if ( $page_for_posts_id ) { 
        //         $post = get_post($page_for_posts_id);
        //         setup_postdata($post);
        //         the_title();
        //         rewind_posts();
        //     }

        // }

        echo '</p></div>';

    }


// Richiamare la funzione all'interno delle pagine desiderate in questo modo

<div class="row align-items-center justify-content-center text-start">
        <div class="col-10 pt-3 pb-3">
            <?php the_breadcrumb(); ?>
</div>
</div>
