
<?php 

//    $categories_level_1 = get_terms(array( 'taxonomy' => 'product_cat','hide_empty' => false, 'parent' => 0 ));
        
//    foreach($categories_level_1 as $level_1){

//    echo '[LEVEL 1]--' . $level_1->name . '<br>';
      
//    $categories_level_2 = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => false, 'parent' => $level_1->term_id ) );
      
//    if( count($categories_level_2) > 0 ){

//         foreach($categories_level_2 as $level_2){

//             echo '[LEVEL 2]----'  . $level_2->name . '<br>';

//             $categories_level_3 = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => false, 'parent' => $level_2->term_id ) );

//             if( count($categories_level_3) > 0 ){

//                 foreach($categories_level_3 as $level_3){

//                     echo '[LEVEL 3]------'  . $level_3->name . '<br>';

//                 }
                
//             }

//         }
       
//    }
      
//    }

?>


        <?php 

        $categories_level_1 = get_terms(array( 'taxonomy' => 'product_cat','hide_empty' => false, 'parent' => 0 ));
        
        foreach($categories_level_1 as $level_1){ 

        ?>
            <?php if($level_1->name != 'Campioni gratuiti' && $level_1->name != 'Premi' ){ ?>
            
            <div class="col">
                <p class="h6 mt-3 mb-3 ms-0 me-0">
                    <a style="color:#CA8759 !important; font-weight:bold; text-decoration:none;" href="<?php echo get_category_link( $level_1->term_id ); ?>"><?php echo $level_1->name; ?></a>
                </p><br>
                <section>

        <?php

        // echo '[LEVEL 1]--' . $level_1->name . '<br>';

        $categories_level_2 = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => false, 'parent' => $level_1->term_id ) );

        if( count($categories_level_2) > 0 ){

            foreach($categories_level_2 as $level_2){

                // echo '[LEVEL 2]----'  . $level_2->name . '<br>';

                echo '<p class="mega-menu-links h6 ms-3" style="color:black; font-weight:bold;"><a href="' . get_category_link( $level_2->term_id ) . '">' . $level_2->name. '</a></p><br>';

                $categories_level_3 = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => false, 'parent' => $level_2->term_id ) );

                if( count($categories_level_3) > 0 ){

                    foreach($categories_level_3 as $level_3){

                        // echo '[LEVEL 3]------'  . $level_3->name . '<br>';

                        echo '<p class="mega-menu-links h6 ms-5"><a href="' . get_category_link( $level_3->term_id ) . '">' . $level_3->name. '</a></p><br>';


                    }
                
                }

            }


        }

        ?>

                </section>
            </div>

<?php } ?>
<?php  }  ?>


       
