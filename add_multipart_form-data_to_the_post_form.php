////////////////////////////////////////////////// START POST ENCTYPE //////////////////////////////////////////////////
<?php

if (is_admin()) {
  $current_admin_page = substr(strrchr($_SERVER['PHP_SELF'], '/'), 1, -4);
  if ($current_admin_page == 'page' 
    || $current_admin_page == 'page-new' 
    || $current_admin_page == 'post' 
    || $current_admin_page == 'post-new') {

    /** Need to force the form to have the correct enctype. */
    function add_post_enctype() {
      echo "<script type=\"text/javascript\">
        jQuery(document).ready(function(){
        jQuery('#post').attr('enctype','multipart/form-data');
        jQuery('#post').attr('encoding', 'multipart/form-data');
        });
        </script>";
    }

    add_action('admin_head', 'add_post_enctype');
  }
}

?>

////////////////////////////////////////////////// END POST ENCTYPE //////////////////////////////////////////////////
