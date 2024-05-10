  <?php 
  
          global $wordpress;
          global $woocommerce;
          global $product;
  
          $arr_products_in_whislist = WC()->session->get('whislist');
  
  ?>

  <?php

        if(count($arr_products_in_whislist) > 0) {

            foreach($arr_products_in_whislist as $__product_in_whislist){

                $post_object = get_post(  $__product_in_whislist );

				        setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

                get_template_part('parts/advanced-product-card');

            }

        }else{

                echo 'Non sono presenti prodotti';

        }

        ?>
