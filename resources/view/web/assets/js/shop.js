import Helpers from './helpers.class.js';

$(document).ready(function () {

   const helpers = new Helpers();
   var theEditor;
   var shop_id;
   var currentPageLoadItems = 1;

   if($('.personal-shop-banners-swiper').length){
      new Swiper(document.querySelector('.personal-shop-banners-swiper'), {
         slidesPerView: 1,
         loop: true,
         autoplay: {
           delay: 3500,
           disableOnInteraction: true,
         },
         navigation: {
           nextEl: '.personal-shop-banners-next',
           prevEl: '.personal-shop-banners-prev',
         },
      });
   }

   $(document).on('click', function(e) { 

      if(!$(e.target).closest(".shopOpenCatalogCategories").length && !$(e.target).closest(".shop-catalog-categories-dropdowns-content").length) {
          $(".shop-catalog-categories-dropdowns-content").hide();
      }

      e.stopPropagation();

   });

   $(document).on('click','.actionOpenShop', function (e) {  

      $('.modal-open-shop-form .form-label-error').hide();

      helpers.startProcessLoadButton($('.actionOpenShop'));
      
      helpers.request({url:"shop-open", data: $('.modal-open-shop-form').serialize()}, function(data) {

         if(data["status"] == true){
            location.href = data["redirect"];
         }else{
            helpers.formNoticeManager($('.modal-open-shop-form'), data);
            helpers.endProcessLoadButton($('.actionOpenShop'));
         }

      });
      
      e.preventDefault();

   });

   $(document).on('click','.actionSaveEditShop', function (e) {  

      $('.modal-edit-shop-form .form-label-error').hide();

      helpers.startProcessLoadButton($('.actionSaveEditShop'));
      
      helpers.request({url:"shop-edit", data: $('.modal-edit-shop-form').serialize()}, function(data) {

         if(data["status"] == true){
            helpers.hideModal("editShopModal");
            helpers.showNoticeAnswer(data["answer"]);
         }else{
            helpers.formNoticeManager($('.modal-edit-shop-form'), data);
            helpers.endProcessLoadButton($('.actionSaveEditShop'));
         }

      });
      
      e.preventDefault();

   });

   $(document).on('click','.actionAddPageShop', function (e) {  

      $('.modal-add-page-shop-form .form-label-error').hide();

      helpers.startProcessLoadButton($('.actionAddPageShop'));

      helpers.request({url:"shop-add-page", data: $('.modal-add-page-shop-form').serialize()}, function(data) {

         if(data["status"] == true){
            location.href = data["redirect"];
         }else{
            helpers.formNoticeManager($('.modal-add-page-shop-form'), data);
            helpers.endProcessLoadButton($('.actionAddPageShop'));
         }

      });
      
      e.preventDefault();

   });

   $(document).on('click','.actionEditPageShop', function (e) {  

      helpers.startProcessLoadButton($('.actionEditPageShop'));
      
      helpers.request({url:"shop-edit-page", data: {text: encodeURIComponent(theEditor.getData()), id: $(this).data("id")}}, function(data) {

         helpers.showNoticeAnswer(data["answer"]);
         helpers.endProcessLoadButton($('.actionEditPageShop'));

      });
      
      e.preventDefault();

   });

   $(document).on('click','.actionDeletePageShop', function (e) {  

      helpers.deleteByAlert("shop-delete-page",{id:$(this).data("id")});
      
      e.preventDefault();

   });

   $(document).on('click','.actionDeleteShop', function (e) {  

      helpers.deleteByAlert("shop-delete",{id:$(this).data("id")});
      
      e.preventDefault();

   });

   $(document).on('click','.actionChangeShopBanner', function (e) {

      shop_id = $(this).data("id");

      $(".shopAttachBannerInput").remove();

      $("body").append('<input type="file" accept=".'+helpers.config("allowed_extensions_images").join(",.")+'" style="display: none;" class="shopAttachBannerInput">');

      $(".shopAttachBannerInput").click();

      e.preventDefault(); 

   });

   $(document).on('change','.shopAttachBannerInput', function (e) { 

      var formData = new FormData();

      formData.append('attach_files', $(this)[0].files[0]);
      formData.append('id', shop_id);

      helpers.request({url:"shop-upload-banner", data: formData, contentType: false, processData: false}, function(data) { 

         if(data["status"] == true){
            location.reload();
         }else{
            helpers.showNoticeAnswer(data["answer"]);
            $(this).val("");
         }

      });

      e.preventDefault(); 

   });

   $(document).on('click','.actionDeleteShopBanner', function (e) {

      helpers.request({url:"shop-delete-banner", data: {id:$(this).data("id")}}, function(data) {

         location.reload();

      });

      e.preventDefault(); 

   });

   $(document).on('click','.catalog-action-change-view-item > span', function (e) { 

      helpers.request({url:"catalog-change-view-item", data: {view:$(this).data("view")}}, function(data) {

         location.reload();
         
      });

      e.preventDefault();

   });

   $(document).on('click','.actionShowMoreItems', function () {
       
       currentPageLoadItems = currentPageLoadItems + 1;

       helpers.startProcessLoadButton($(this));
       
       loadItems(currentPageLoadItems, this, true);   
     
   });

   function loadItems(page=1,button,scroll=false){

      helpers.request({url:"shop-load-items", data: helpers.paramsForm('.live-filters, .live-shop-search-form')+"&url="+encodeURIComponent(window.location.pathname)+"&page="+page}, function(data) {

         if(page == 1){
            $(".shop-catalog-container").html("");
         }

         $(".shop-catalog-container").append('<div class="load-items-page'+page+' col-lg-12" ></div>'+data["content"]);
         
         $('.load-items-page'+page).next().fadeIn('slow');

         $(button).remove();

         if(scroll){

             $('html, body').animate({
               scrollTop: $('.load-items-page'+page).offset().top-50
             }, 300, 'linear');

         }

      });

   }

   function removeFilterItems(parent){
       
       var ids = '';

       if(parent.attr("data-parent-ids") != undefined){
           ids = parent.attr("data-parent-ids").split(",");
           $.each(ids,function(index,value){

             $('.params-form-item[data-id="'+value+'"]').remove().hide();

           });
       }

   }

   $(document).on('change','.live-filters input[type=radio], .live-filters input[type=checkbox]', function (e) {

       var parent = $(this).parents(".params-form-item");

       if($(this).val()!="null"){
          helpers.request({url:"catalog-load-filter-items", data: {filters: helpers.paramsForm('.live-filters'), filter_id: parent.data("id"),item_id:$(this).val()}}, function(data) {

             removeFilterItems(parent);
             parent.after(data["content"]);
            
          });
       }else{
          removeFilterItems(parent);
       }

       e.preventDefault();
   });

   $(document).on('click','.actionApplyLiveFilters', function (e) {

       helpers.startProcessLoadButton($(this));

       helpers.setParamsFormUrl('.live-filters');

       location.reload();

       e.preventDefault();

   });

   $(document).on('change','.live-filters-mobile input[type=radio], .live-filters-mobile input[type=checkbox]', function (e) {

       var parent = $(this).parents(".params-form-item");

       if($(this).val()!="null"){
          helpers.request({url:"catalog-load-filter-items", data: {filters: helpers.paramsForm('.live-filters'), filter_id: parent.data("id"),item_id:$(this).val()}}, function(data) {

             removeFilterItems(parent);
             parent.after(data["content"]);
            
          });
       }else{
          removeFilterItems(parent);
       }

       e.preventDefault();
   });

   $(document).on('click','.actionApplyLiveFiltersMobile', function (e) {

       helpers.startProcessLoadButton($(this));

       helpers.setParamsFormUrl('.live-filters-mobile');

       location.reload();

       e.preventDefault();

   });

   $(document).on('click','.actionClearLiveFilters', function (e) {

       helpers.startProcessLoadButton($(this));

       helpers.request({url:"catalog-clear-filters", data: {url:encodeURIComponent(helpers.getUrl())}}, function(data) {

         if(data["link"]){
             location.href = data["link"];
         }else{
             location.reload();
         }
        
       });

       e.preventDefault();
   });

   $(document).on('click','.shopOpenCatalogCategories', function (e) {

       $(".shop-catalog-categories-dropdowns-content").toggle();

       e.preventDefault();

   });

   if($("#InlineEditor").length){

      InlineEditor.create( document.querySelector( '#InlineEditor' ), {
         ckfinder: {
            uploadUrl: helpers.getRoute("ckfinder"),
         },
         toolbar: {
           items: [
             'heading',
             '|',
             'bold',
             'italic',
             'link',
             'bulletedList',
             'numberedList',
             '|',
             'indent',
             'outdent',
             '|',
             'imageUpload',
             'blockQuote',
             'insertTable',
             'undo',
             'redo',
             'fontColor',
             'fontSize'
           ]
         },
         image: {
           toolbar: [
             'imageTextAlternative',
             'imageStyle:full',
             'imageStyle:side'
           ]
         },
         table: {
           contentToolbar: [
             'tableColumn',
             'tableRow',
             'mergeTableCells'
           ]
         },
         
       } )
       .then( editor => {
           theEditor = editor;
       } )
       .catch( error => {

       } );

   }

   $(function(){ 

       loadItems();

   });


});