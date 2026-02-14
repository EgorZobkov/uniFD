import Helpers from './helpers.class.js';

$(document).ready(function () {

   const helpers = new Helpers();

   var currentPageLoadItems = 1;

   function loadItems(page=1,button,scroll=false){

      var showLoadError = function(){
         var errorHtml = '<div class="catalog-load-error text-center py-5">' +
            '<p class="text-muted mb-3">' + (helpers.translate && helpers.translate.content ? helpers.translate.content("tr_catalog_load_error") : "Не удалось загрузить объявления") + '</p>' +
            '<button type="button" class="btn-custom button-color-scheme1 actionRetryLoadItems">' + (helpers.translate && helpers.translate.content ? helpers.translate.content("tr_catalog_load_retry") : "Попробовать снова") + '</button>' +
            '</div>';
         $(".container-load-items").html(errorHtml);
      };

      helpers.request({
         url:"home-load-items",
         data: {page: page},
         timeout: 15000,
         button: button,
         error: function(){
            if(button){ helpers.endProcessLoadButton && helpers.endProcessLoadButton($(button)); }
            if(page == 1){ showLoadError(); } else { helpers.showNotice && helpers.showNotice("warning", (helpers.translate && helpers.translate.content ? helpers.translate.content("tr_catalog_load_error") : "Не удалось загрузить объявления")); }
         }
      }, function(data) {

         if(!data || data["content"] === undefined){
            if(page == 1){ showLoadError(); }
            return;
         }

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

   $(document).on('click','.actionRetryLoadItems', function () {
       currentPageLoadItems = 1;
       $(this).prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status"></span>' + ($(this).text() || "Загрузка..."));
       loadItems(1);
   });

   loadItems();

});