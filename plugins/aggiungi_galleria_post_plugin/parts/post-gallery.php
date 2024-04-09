<div class="row align-items-center justify-content-center text-center mt-5" style="padding:0% 0%;">
     <div class="col-5">
        <div class="swiper postGallery" style="z-index:0;">
                <div class="swiper-wrapper">
                        <?php 
                            $_post_galleria_array = get_post_meta(get_the_ID(), '_esistenti_image_loaders_da_salvare', true);
                            //var_dump($_post_galleria_array); 
                            foreach($_post_galleria_array as $image_meta){
                                echo '
                                <div class="swiper-slide">
                                    <div style="width:100%; aspect-ratio: 1 / 1;">
                                        <img id="' . $image_meta . '" style="cursor: zoom-in; width:100%; height: 100%; object-fit:cover;" src="' . get_post_meta(get_the_ID(), $image_meta, true) . '" onclick="showImage(this.id);">
                                    </div>
                                </div>';
                                
                            }
                        ?>

                </div>
        </div>

        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <!-- <div class="swiper-scrollbar"></div> -->
        <!-- <div class="swiper-pagination"></div> -->

        <script>
            var swiper = new Swiper(".postGallery", {
            slidesPerView: 4,
            spaceBetween: 15,
            freeMode: true,
            breakpoints: {
                1000: { slidesPerView: 4, slidesPerGroup: 2,  },
            },
            scrollbar: {
                el: ".swiper-scrollbar",
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            });
        </script>
        
        <style>
            .swiper { width: 100%;  height: 100%;  }
            /* .swiper-slide {  text-align: center;  font-size: 18px;  background: #fff;  display: flex;  justify-content: center;  align-items: center;  } */
            /* .swiper-slide img {  display: block;   width: 100%;  height: 100%;  object-fit: cover; } */
            .swiper-button-next, .swiper-button-prev { color: #BA2F2F !important;}
            .swiper-button-next{ transform: translateX(200%) scale(0.75); }
            .swiper-button-prev{ transform: translateX(-200%) scale(0.75); }
        </style>

        <script>

            current_image = 0;
            
            function showImage(image_meta){

                document.getElementById('images-modal-gallery').style.display="block";
                allimages = document.querySelectorAll('.gallery_imgs');
                
                allimages.forEach(function(img){ img.style.display="none"; });
                
                document.querySelector(`img[img_id='${image_meta}']`).style.display="block";
                current_image = Number(document.querySelector(`img[img_id='${image_meta}']`).getAttribute('id'));
                
                //console.log(current_image);

                document.getElementById('p-curr').innerHTML = current_image + 1;
            
            }

            function gallery_next(){

                (current_image > allimages.length -2) ? current_image = 0 : current_image++; 

                allimages = document.querySelectorAll('.gallery_imgs');
                allimages.forEach(function(img){ img.style.display="none"; });
                
                document.getElementById(current_image).style.display="block";

                // console.log(current_image);

                document.getElementById('p-curr').innerHTML = current_image + 1;

            }
            
            function gallery_prev(){
           
                (current_image <= 0) ? current_image = 0 : current_image-- ; 

                allimages = document.querySelectorAll('.gallery_imgs');
                allimages.forEach(function(img){ img.style.display="none"; });
                
                document.getElementById(current_image).style.display="block";

                // console.log(current_image);

                document.getElementById('p-curr').innerHTML = current_image + 1;
                
            }
        </script>

     </div>
 </div> 


 <?php  $_counter_gallery = 0; ?>

 <images-modal-gallery 
    id="images-modal-gallery" 
    style="display:none; position:fixed; top:55%; left:50%; transform:translate(-50%, -50%); padding:1% 0% 1% 0%; background:#BA2F2F; border-radius:5px; z-index:2; box-shadow:white 0px 0px 5px 0px; width:50%;">

    <div class="row align-items-center justifiy-content-center text-center">
        <close class="mb-4" style="color:white; cursor:pointer;" onclick="document.getElementById('images-modal-gallery').style.display='none';">𐌢 Chiudi</close>
            <div class="col-1" style="color:white; cursor:pointer;" onclick="gallery_prev()">❮</div>
            <div class="col">
                <?php 
    
                    $_post_galleria_array = get_post_meta(get_the_ID(), '_esistenti_image_loaders_da_salvare', true);
                    foreach($_post_galleria_array as $image_meta){
                        echo '<img id="' . $_counter_gallery . '" img_id="' . $image_meta . '" class="gallery_imgs" style="display:none; width:100%; height: 100%; border-radius:5px; outline: 5px solid white; max-height: 40rem;"  src="' . get_post_meta(get_the_ID(), $image_meta, true) . '" onclick="showImage(this.id);">';
                        $_counter_gallery++;      
                    }

                ?>
            </div>
            <div class="col-1" style="color:white; cursor:pointer;" onclick="gallery_next()">❯</div>
        <pagination class="mt-4" style="color:white;"><span id="p-curr">1</span> di <span id="p-tot">0</span></pagination>
    </div>

 </images-modal-gallery>

 <script>
    allimages = document.querySelectorAll('.gallery_imgs');
    document.getElementById('p-tot').innerHTML = allimages.length;
</script>
