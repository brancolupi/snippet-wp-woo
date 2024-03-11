<?php echo wp_nav_menu( array('menu' => 'menu-desktop-v2', 'menu_class' => 'menu_custom_desktop' ) ); ?>

    <style>      
    ul#menu-menu-desktop-v2 li { margin: 0% 0.2%; }

    ul.menu_custom_desktop  { display: flex;  position: relative; flex-direction: row;  justify-content: space-between; z-index: 1; list-style-type: none; }   
    ul.menu_custom_desktop li {  width: 100%; border-radius: 5px; }
    ul.menu_custom_desktop > li > a { display: flex; position: relative; align-items: center; width: 100%; text-align: left; font-weight:500; color: #8d8989 !important; padding: 0% 0%; }
    ul.menu_custom_desktop, li, a:not(ul.sub-menu li a) { justify-content: center; }  
    ul.menu_custom_desktop li a:hover {  display: flex; align-items: center; text-decoration: none; background: #CA8759; color: white !important; border-radius: 5px; }  

    
    ul.sub-menu { display: flex; position: absolute; flex-direction: column; top: 105%; z-index: 1; text-align: left; }
    ul.sub-menu li { margin: 2% 0% !important; text-decoration: none; background: #CA8759; border-radius: 5px; width: max-content; min-width: 10vw; max-width: 10vw; margin: 1% 0%; }
    ul.sub-menu li, a { color:white !important; cursor:pointer; text-decoration:none; padding: 0% 5%;  } 
    #menu-item-587 li, a { padding: 0% 0% !important; }

    ul#menu-menu-desktop > li, a:not(ul.sub-menu li a) { color: black !important; }

    li#menu-item-535 a { outline: 2px solid #CA8759; border-radius: 5px;  }
    li#menu-item-587 a { outline: 2px solid #CA8759; border-radius: 5px; }


    ul.sub-menu { display: none; }

    dl, ol, ul {  margin-top: 0 !important; }
   

    </style>

    <script>

    var all_menu_items = document.querySelectorAll("ul#menu-menu-desktop-v2 li:not(ul.sub-menu li)");
    var all_submenu_items = document.querySelectorAll("ul.sub-menu");

        
        all_menu_items.forEach(function(item){
            item.addEventListener('mouseover', function(event){

                event.stopPropagation();
                
                all_submenu_items.forEach(function(sub_item){ sub_item.style.display="none";  });
                all_menu_items.forEach(function(item){ item.style.cssText="color:#8d8989; background:white;"; item.querySelector('a').style.cssText = 'color:black !important;'; });

                item.style.cssText = 'background:#CA8759; color:white;';
                item.querySelector('a').style.cssText = 'color:white !important;';

            
                var item_submenu = item.querySelector('ul.sub-menu');
                if(item_submenu != null){ item_submenu.style.display="flex"; }
                
            })
        })

        all_menu_items.forEach(function(item){
            item.addEventListener('click', function(event){

                event.stopPropagation();
                
                all_submenu_items.forEach(function(sub_item){ sub_item.style.display="none";  });
                all_menu_items.forEach(function(item){ item.style.cssText="color:#8d8989; background:white;"; item.querySelector('a').style.cssText = 'color:#8d8989 !important;'; });

                item.style.cssText = 'background:#CA8759; color:white;';
                item.querySelector('a').style.cssText = 'color:white !important;';

            
                var item_submenu = item.querySelector('ul.sub-menu');
                if(item_submenu != null){ item_submenu.style.display="flex"; }
                
            })
        })

        document.addEventListener('click', function(){

            all_submenu_items.forEach(function(sub_item){ sub_item.style.display="none";  });
            all_menu_items.forEach(function(item){ item.style.cssText="color:#8d8989; background:white;"; item.querySelector('a').style.cssText = 'color:black !important;'; });
            
        })

        all_sub_submenu_items = document.querySelectorAll("ul.sub-menu li");

        all_sub_submenu_items.forEach(function(item){
            
            item.addEventListener('mouseover', function(event){

                event.stopPropagation();
                
                var item_submenu = item.querySelector('ul.sub-menu');
                if(item_submenu != null){ item_submenu.style.display="flex"; }
                
            })

            item.addEventListener('mouseleave', function(event){

            event.stopPropagation();

            all_sub_submenu_items.forEach(function(li){ li.querySelector('ul.sub-menu').style.display='none'; });

            })


        })

    </script>


<style>
    ul.sub-menu ul.sub-menu {   display: flex;  position: absolute;  flex-direction: column;  top: 0%;  left: 115%;  z-index: 1;  width: 100%;  text-align: left; }
</style>
