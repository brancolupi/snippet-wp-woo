<?php

/**
 * Ottieni tutte le categorie e sottocategorie di WooCommerce.
 *
 * @return array La struttura ad albero delle categorie.
 */

function get_woocommerce_categories_tree() {

    // Ottieni tutte le categorie in una singola query

    $args = array(
        'taxonomy'   => 'product_cat',
        'hide_empty' => false,
        'hierarchical' => true,
    );    

    $terms = get_terms($args);

    // hide_empty: Il parametro hide_empty è impostato su false per includere anche le categorie vuote. Puoi impostarlo su true se desideri escludere le categorie senza prodotti.
    // hierarchical: Il parametro hierarchical è impostato su true per garantire che le categorie siano organizzate gerarchicamente.


    // Costruisci un array associativo delle categorie

    $categories = array();

    foreach ($terms as $term) {

        $thumbnail_id = get_term_meta($term->term_id, 'thumbnail_id', true);
        $thumbnail_url = wp_get_attachment_url($thumbnail_id);
        
        $term->thumbnail_url = $thumbnail_url;
        $categories[$term->term_id] = $term;
        $categories[$term->term_id]->children = array();
    }

    // Organizza le categorie in una struttura ad albero

    $tree = array();
    
    foreach ($categories as $term_id => $term) {
        if ($term->parent == 0) {
            $tree[] = $term;
        } else {
            $categories[$term->parent]->children[] = $term;
        }
    }

    return $tree;

}

/**
 * Stampa la struttura delle categorie in un formato leggibile.
 *
 * @param array $categories La struttura ad albero delle categorie.
 * @param int $depth La profondità corrente della categoria (usata per l'indentazione).
 */


// function print_woocommerce_categories($categories, $depth = 0, $child = false) {
//
//     // str_repeat(string,repeat) La funzione str_repeat() ripete una stringa un numero specificato di volte.
//     // il parametro depth per gestire l'indentazione delle sottocategorie.
//
//     foreach ($categories as $category) {
//         echo str_repeat('&nbsp;', $depth * 4) . $category->name . '<br>';        
//         if (!empty($category->children)) {
//             print_woocommerce_categories($category->children, $depth + 1, true);
//         }
//     }
// }


// // Ottieni tutte le categorie e sottocategorie

// $all_categories = get_woocommerce_categories_tree();

// // Stampa la struttura delle categorie

// print_woocommerce_categories($all_categories);


$categories_tree =  get_woocommerce_categories_tree();

?> 

<div style="display:flex; justify-content: space-evenly"> 

    <a href="/" style="text-transform: uppercase; color:black;">Home<span style="width:1rem;"></span></a>

<?php

// var_dump($categories_tree);

foreach($categories_tree as $category){ // Livello 1 --> Categoria

        $_arrow_icon = (!empty($category->children)) ? '<img src="/wp-content/uploads/2024/05/down_arrow_icon.png" style="width:1rem;">' : '<span style="width:1rem;"></span>';

        echo '
        <div style="position:relative;" 
        onmouseover="
        document.querySelectorAll(\'.cutom_submenu\').forEach(function(el){el.style.display=\'none\'; });
        this.querySelector(\'.cutom_submenu\').style.cssText=\'position: absolute; left: 50%; top:150%; transform:translate(-50%, 0%); width: max-content;  background:white;\'">
        <a href="/categoria/' . $category->slug . '" style="text-transform: uppercase; color:black;">' . str_repeat('&nbsp;', 0) . $category->name  .  $_arrow_icon . '</a>';
        
        if(!empty($category->children)){

            echo '<div class="row align-items-start justify-content-center cutom_submenu" style="display:none;">
            <div class="col p-4" style="display: flex; flex-direction: column;">';

            foreach($category->children as $children){ // Livello 2 --> Sottocategoria

                echo '<a class="mt-2 mb-2" href="/categoria/' . $children->slug . '" style="font-weight:bold; color:black;">' . str_repeat('&nbsp;', 0) . $children->name . '</a>';

                if(!empty($children->children)){

                    foreach($children->children as $subchildren){ // Livello 3 --> Sottocategoria della sottocategoria

                        echo '<a href="/categoria/' . $subchildren->slug . '" style="color:black; font-size: 0.85rem;"> ' . str_repeat('&nbsp;', 0) . $subchildren->name . '</a> ';

                    }

                }

                echo '<a class="mt-2 mb-2" href="/categoria/' . $category->slug . '" style="font-weight:bold; color:black; font-size: 0.85rem;">Tutte le sezioni</a> ';

            }

            echo '</div>';
            if(!empty($category->thumbnail_url)){
                   echo '<div class="col m-4" style="aspect-ratio: 0 / 1;"><a href="/categoria/' . $category->slug .'"><img src="' . esc_url($category->thumbnail_url) . '" style="height:100%; width:auto;"></a></div>';
            }

            foreach($category->children as $children){
                if(!empty($children->thumbnail_url)){
                    echo '<div class="col m-4" style="aspect-ratio: 0 / 1;"><a href="/categoria/' . $children->slug .'"><img src="' . esc_url($children->thumbnail_url) . '" style="height:100%; width:auto;"></a></div>';
                }
            }

            foreach($category->children as $children){
                foreach($children->children as $subchildren){ 
                    if(!empty($subchildren->thumbnail_url)){
                        echo '<div class="col m-4"  style="aspect-ratio: 0 / 1;"><a href="/categoria/' . $subchildren->slug .'"><img src="' . esc_url($subchildren->thumbnail_url) . '" style="height:100%; width:auto;"></a></div>';
                    }                
                }
            
            }




            echo '</div>';

        }

        echo '</div>';

}

?>

<a href="/about" style="text-transform: uppercase; color:black;">About<span style="width:1rem;"></span></a>

</div>

<?php

?>