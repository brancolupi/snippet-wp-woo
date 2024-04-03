<?php

///////////// START Abilitare $_FILES aggiungendo "multipart/form-data" al form dei post ///////////////

// JS Vanilla

if (is_admin()) {
$current_admin_page = substr(strrchr($_SERVER['PHP_SELF'], '/'), 1, -4);
if ($current_admin_page == 'page' 
|| $current_admin_page == 'page-new' 
|| $current_admin_page == 'post' 
   || $current_admin_page == 'post-new') {

/** Need to force the form to have the correct enctype. */
function aggiungi_post_enctype() {
echo "<script type=\"text/javascript\">
document.addEventListener('DOMContentLoaded', function() {
  var postForm = document.getElementById('post');
  postForm.setAttribute('enctype', 'multipart/form-data');
  postForm.setAttribute('encoding', 'multipart/form-data');
});
</script>";
}

add_action('admin_head', 'aggiungi_post_enctype');
}
}


// JQUERY Version
  
// if (is_admin()) {
//   $current_admin_page = substr(strrchr($_SERVER['PHP_SELF'], '/'), 1, -4);
//   if ($current_admin_page == 'page' 
//     || $current_admin_page == 'page-new' 
//     || $current_admin_page == 'post' 
//     || $current_admin_page == 'post-new') {

//     /** Need to force the form to have the correct enctype. */
//     function add_post_enctype() {
//       echo "<script type=\"text/javascript\">
//         jQuery(document).ready(function(){
//         jQuery('#post').attr('enctype','multipart/form-data');
//         jQuery('#post').attr('encoding', 'multipart/form-data');
//         });
//         </script>";
//     }

//     add_action('admin_head', 'add_post_enctype');
//   }
// }
  
///////////// END Abilitare $_FILES aggiungendo "multipart/form-data" al form dei post ///////////////
  
?>
