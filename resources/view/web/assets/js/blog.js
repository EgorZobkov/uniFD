import Helpers from './helpers.class.js';

$(document).ready(function () {

   const helpers = new Helpers();
   if($('.blog-post-plyr-video').length){
      const player = new Plyr('.blog-post-plyr-video');
   }
   var currentPageLoadItems = 1;

   function loadItems(page=1,button,scroll=false){

      helpers.request({url:"blog-load-items", data: {category_id: $("input[name=blog_category_id]").val(), page: page}}, function(data) {

         if(page == 1){
            $(".container-load-items").html("");
         }

         $(".container-load-items").append('<div class="load-items-page'+page+' col-lg-12" ></div>'+data["content"]);
         
         $('.load-items-page'+page).next().fadeIn('slow');

         $(button).remove();

         if(scroll){

             $('html, body').animate({
               scrollTop: $('.load-items-page'+page).offset().top-50
             }, 300, 'linear');

         }

      });

   }   

   $(document).on('click','.actionShowMoreItems', function () {
       
       currentPageLoadItems = currentPageLoadItems + 1;

       helpers.startProcessLoadButton($(this));
       
       loadItems(currentPageLoadItems, this, true);   
     
   });

   loadItems();

});