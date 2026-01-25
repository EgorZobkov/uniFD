$(document).ready(function () {

    var current_slide_key = 0;
    var slider_array = [];
    var players = [];

    function stopVideos(){

        if(players.length){
            for (let i = 0; i < players.length; i++) {
              players[i].stop();
            }
        }

    }

    $(document).on('click','.uni-media-slider-modal-container-nav-left', function (e) {

       if(current_slide_key == 0){
          $(".uni-media-slider-modal-container-item").hide();
          $(".uni-media-slider-modal-container-item[data-key=0]").show();
       }else{
          current_slide_key--;
          $(".uni-media-slider-modal-container-item").hide();
          $(".uni-media-slider-modal-container-item[data-key="+current_slide_key+"]").show();
       }

       stopVideos();

       e.preventDefault();
    });

    $(document).on('click','.uni-media-slider-modal-container-nav-right', function (e) {

       current_slide_key++;

       if($(".uni-media-slider-modal-container-item[data-key="+current_slide_key+"]").length){
          $(".uni-media-slider-modal-container-item").hide();
          $(".uni-media-slider-modal-container-item[data-key="+current_slide_key+"]").show();
       }else{
          $(".uni-media-slider-modal-container-item").hide();
          $(".uni-media-slider-modal-container-item[data-key=0]").show();   
          current_slide_key = 0; 
       }

       stopVideos();

       e.preventDefault();
    });

    $(document).on('click','.uniMediaSliderItem', function (e) {

        slider_array = [];
        var navigation = [];
        current_slide_key = $(this).data("media-key") ? $(this).data("media-key") : 0;

        $("body").css("overflow", "hidden");
        $(".uni-media-slider-modal").remove();

        $(this).parents('.uniMediaSliderContainer').find('.uniMediaSliderItem').each(function (index, element) {

            if($(element).data("media-type") == "image"){

                slider_array.push(`
                    <div class="uni-media-slider-modal-container-item" data-key="`+index+`" >
                        <div class="uni-media-slider-modal-backing" style="background-image: url(`+$(element).attr("href")+`);" ></div>
                        <img src="`+$(element).attr("href")+`" >
                    </div>
                `);

            }else if($(element).data("media-type") == "video"){
                slider_array.push(`
                    <div class="uni-media-slider-modal-container-item" data-key="`+index+`" >
                        <video class="uni-media-slider-modal-plyr-video" playsinline controls data-poster="`+$(element).attr("href")+`">
                          <source src="`+$(element).data("media-video")+`" type="video/mp4" />
                        </video>
                    </div>
                `);             
            }else if($(element).data("media-type") == "link_video"){
                slider_array.push(`
                    <div class="uni-media-slider-modal-container-item" data-key="`+index+`" >
                        <div class="uni-media-slider-modal-plyr-video" >
                          <iframe
                            class="uni-media-slider-modal-iframe-video"
                            src="`+$(element).data("media-video")+`"
                            allowfullscreen
                            allowtransparency
                          ></iframe>
                        </div>
                    </div>
                `);             
            }

        });

        if(slider_array.length > 1){
            navigation.push(`
                <span class="uni-media-slider-modal-container-nav-left" ><i class="ti ti-chevron-left"></i></span>  
                <span class="uni-media-slider-modal-container-nav-right" ><i class="ti ti-chevron-right"></i></span>
            `);
        }

        $("body").append(
            `
            <div class="uni-media-slider-modal" >

              <div class="uni-media-slider-modal-container" >

                <span class="uni-media-slider-modal-close" ><i class="ti ti-x"></i></span>

                `+slider_array.join('')+`
                `+navigation.join('')+`
 
              </div>

            </div>
            `
        );

        players = Array.from(document.querySelectorAll('.uni-media-slider-modal-plyr-video')).map((p) => new Plyr(p));

        $(".uni-media-slider-modal-container-item[data-key="+current_slide_key+"]").show(); 
        $(".uni-media-slider-modal").fadeIn(100);

        e.preventDefault();
    });

    $(document).on('click','.uni-media-slider-modal-close', function (e) {
        
       $(".uni-media-slider-modal").fadeOut(100, function(){
           slider_array = [];
           $(".uni-media-slider-modal").remove();
           $("body").css("overflow", "auto");
           stopVideos();
       });

       e.preventDefault();
    });

    $(document).on('click','.uni-media-slider-modal', function (e) {

       if(!$(e.target).closest(".uni-media-slider-modal-container").length) {
           $(".uni-media-slider-modal").fadeOut(100, function(){
               slider_array = [];
               $(".uni-media-slider-modal").remove();
               $("body").css("overflow", "auto");
               stopVideos();
           });
       }

    });

});