import Helpers from './helpers.class.js';

$(document).ready(function () {

   const helpers = new Helpers();
   var currentPageLoadItems = 1;
   var startDateBookingCalendar;
   var endDateBookingCalendar;

   loadItems();
   loadCalendar();

   function loadCalendar(){

       if($(".params-form-item-calendar").length){

         $(".params-form-item-calendar").datepicker({
             inputs: $(".params-form-item-calendar-range1, .params-form-item-calendar-range2"),
             language: "ru",
             startDate: new Date(),
             keyboardNavigation: false,
             forceParse: false,
             updateViewDate: false,
         }).on("changeDate",function(event){

              var startDate = new Date(event.date);

              $(".params-form-item-calendar-range1, .params-form-item-calendar-range2").datepicker("update", startDate);

              if(startDateBookingCalendar && endDateBookingCalendar){
                 startDateBookingCalendar = null;
                 endDateBookingCalendar = null;
              }

              if(!startDateBookingCalendar || startDateBookingCalendar >= moment(event.date).format('YYYY-MM-DD')){
                  startDateBookingCalendar = moment(event.date).format('YYYY-MM-DD');
                  endDateBookingCalendar = null;
              }else{
                  endDateBookingCalendar = moment(event.date).format('YYYY-MM-DD');
              }     

              $(".params-form-calendar-date-start").val(startDateBookingCalendar);     
              $(".params-form-calendar-date-end").val(endDateBookingCalendar);

         });

         var startDate = new Date($(".params-form-calendar-date-start").val());
         var endDate = new Date($(".params-form-calendar-date-end").val());

         $(".params-form-item-calendar-range1, .params-form-item-calendar-range2").datepicker("update", startDate);   
         $(".params-form-item-calendar-range1, .params-form-item-calendar-range2").datepicker("update", endDate);  

         $(".params-form-item-calendar table tr td[data-date="+startDate.getTime()+"]").addClass("selected range-start day");
         $(".params-form-item-calendar table tr td[data-date="+endDate.getTime()+"]").addClass("active selected range-end day");

       }

   }

   function loadItems(page=1,button,scroll=false){

      var showLoadError = function(){
         var errorHtml = '<div class="catalog-load-error text-center py-5">' +
            '<p class="text-muted mb-3">' + (helpers.translate && helpers.translate.content ? helpers.translate.content("tr_catalog_load_error") : "Не удалось загрузить объявления") + '</p>' +
            '<button type="button" class="btn-custom button-color-scheme1 actionRetryLoadItems">' + (helpers.translate && helpers.translate.content ? helpers.translate.content("tr_catalog_load_retry") : "Попробовать снова") + '</button>' +
            '</div>';
         $(".container-load-items").html(errorHtml);
      };

      helpers.request({
         url:"catalog-load-items",
         data: helpers.paramsForm('.live-filters, .modal-geo-form, .live-search-form')+"&page="+page,
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

   $(document).on('click','.catalog-action-change-view-item > span', function (e) { 

      helpers.request({url:"catalog-change-view-item", data: {view:$(this).data("view")}}, function(data) {

         location.reload();
         
      });

      e.preventDefault();

   });

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

      $(document).on('change','.params-form-subcategory-select', function () {

       const link = $(this).find('option:selected').data('link');

       if(link){
          window.location.href = link;
       }

   });


   $(document).on('click','.actionApplyLiveFilters', function (e) {

       helpers.startProcessLoadButton($('.actionApplyLiveFilters'));

       helpers.setParamsFormUrl('.live-filters, .modal-geo-form:input[name!=geo_alias], .live-search-form');

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

   $(document).on('change','.params-form-subcategory-select', function () {

       const link = $(this).find('option:selected').attr('data-link');

       if(link){
          window.location.href = link;
       }

   });


   $(document).on('click','.actionClearLiveFilters', function (e) {

       helpers.startProcessLoadButton($('.actionClearLiveFilters'));

       helpers.request({url:"catalog-clear-filters", data: {url:encodeURIComponent(helpers.getUrl())}}, function(data) {

         if(data["link"]){
             location.href = data["link"];
         }else{
             location.reload();
         }
        
       });

       e.preventDefault();
   });

   $(document).on('click','.actionSaveSearch', function (e) {

       var _this = this;

       helpers.request({url:"catalog-save-search", data: helpers.paramsForm('.live-filters, .modal-geo-form[name!=geo_alias], .live-search-form')+"&link="+encodeURIComponent(helpers.getUrl()), precheck: true}, function(data) {

          helpers.showNoticeAnswer(data["answer"]);
          $(_this).html(data["label"]);
        
       });

       e.preventDefault();
   });

   $(document).on('change','.search-map-sidebar-filters-container .params-form-item-categories input[type=radio]', function (e) {

       $(".search-map-sidebar-filters-container input[name=c_id]").val($(this).val());

       helpers.request({url:"catalog-load-subcategories", data: {id: $(this).val()}}, function(data) {

            if(data["content"] != undefined){
                $(".search-map-sidebar-filters-container .params-form-item-subcategories").show().html(data["content"]);
            }else{
                $(".search-map-sidebar-filters-container .params-form-item-subcategories").hide().html("");
            }

            $(".search-map-sidebar-filters-container .params-form-filters-container").show().html(data["filters"]);

            loadCalendar();
          
       });

       e.preventDefault();
   });

   


});