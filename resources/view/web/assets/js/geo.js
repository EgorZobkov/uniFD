import Helpers from './helpers.class.js';

$(document).ready(function () {

   const helpers = new Helpers();
   var changeCityId = 0;
   var changeCountryId = 0;
   var changePurpose;
   var geoId = 0;
   var geoLink = '';
   var searchTimeout = null;

   if(helpers.config("geo_autodetect") && $.cookie("geo-autodetect") != "disabled"){
      if ("geolocation" in navigator) {

         $.cookie("geo-autodetect", "disabled", {expires: 30, path: '/'});

         navigator.geolocation.getCurrentPosition(
           function (position) {

            helpers.request({url:"geo-coordinates-detect", data: {lat:position.coords.latitude, lon:position.coords.longitude, url:encodeURIComponent(helpers.getUrl())}}, function(data) {

               if(data["status"] == true){ 
                   location.reload();
               }
               
            });

           },
           function (error) {
           }
         );

      }
   }

   $(document).on('click', function(e) { 

      if(!$(e.target).closest(".modal-geo-search > input").length && !$(e.target).closest(".modal-geo-search-results").length) {
          $(".modal-geo-search-results").hide();
      }

      if(!$(e.target).closest(".input-geo-search-container > input").length && !$(e.target).closest(".input-geo-search-container-result").length) {
          $(".input-geo-search-container-result").hide();
      }

      e.stopPropagation();

   });

   $(document).on('click','.link-geo-item', function (e) {

      var _this = this;
      geoLink = $(_this).attr("href");
      changePurpose = $(_this).data("purpose");
      geoId = $(_this).data("id");

      $(".modal-geo-form input[name=geo_alias]").val(geoLink);

      $(".modal-geo-search-results").hide();

      if($(_this).data("purpose") == "all"){

         helpers.hideModal("geoModal");
         $(".modal-geo-container-content").html("");
         apply();

      }else{

         if($(_this).data("purpose") == "city"){
            changeCityId = $(_this).data("id");
         }else{
            changeCityId = 0;
         }

         helpers.request({url:"geo-change", data: {id:$(_this).data("id"), purpose:$(_this).data("purpose")}}, function(data) {

            if(data["content"]){

                $(".modal-geo-search > input").val($(_this).html());
                $(".modal-geo-container-content").html(data["content"]);

            }else{

                helpers.hideModal("geoModal");
                $(".modal-geo-container-content").html("");
                apply();

            }
            
         });

      }

      e.preventDefault();

   });

   function apply(){

      helpers.request({url:"geo-change-options", data: helpers.paramsForm('.live-filters, .modal-geo-form')+"&url="+encodeURIComponent(window.location.pathname)}, function(data) {

         location.href = data["link"];
         
      });

   }

   $(document).on('click','.actionApplyGeoModal', function (e) {  

      helpers.startProcessLoadButton($('.actionApplyGeoModal'));

      apply();

      e.preventDefault();

   });

   $(document).on('click','.actionClearGeoModal', function (e) {  

      helpers.startProcessLoadButton($(this));

      helpers.request({url:"geo-clear-options", data: {url:encodeURIComponent(helpers.getUrl())}}, function(data) {

         if(data["link"]){
             location.href = data["link"];
         }else{
             location.reload();
         }
         
      });

      e.preventDefault();

   });

   $(document).on('click','.link-geo-country-item', function (e) { 

      $('.link-geo-country-item').removeClass("active");
      $(this).addClass("active");

      changeCountryId = $(this).data("id");

      helpers.request({url:"geo-change-country", data: {id:$(this).data("id")}}, function(data) {

         $(".modal-geo-container-content").html(data["content"]);
         
      });

      e.preventDefault();

   });

   $(document).on('click','.modal-geo-tabs > div', function (e) { 

      $('.modal-geo-tabs > div').removeClass("active");
      $(this).addClass("active");

      $(".modal-geo-tab-1,.modal-geo-tab-2").hide();

      if($(this).data("tab") == 1){
         $(".modal-geo-tab-1").show();
      }else if($(this).data("tab") == 2){
         $(".modal-geo-tab-2").show();
      }

      e.preventDefault();

   });

   $(document).on('input click','.modal-geo-search > input', function (e) {  

      var query = $(this).val();

      if (searchTimeout != null) {
        clearTimeout(searchTimeout);
      }

      if($(this).val().length != 0){
        searchTimeout = setTimeout(function() {
          searchTimeout = null;
          helpers.request({url:"geo-search-combined", data: {query: query, country_id: changeCountryId}}, function(data) {

             if(data["status"]){
                $(".modal-geo-search-results").html(data["answer"]).fadeIn(100);
             }else{
                $(".modal-geo-search-results").html("").hide();
             }

          });
        }, 200);
      }else{
          $(".modal-geo-search-results").html("").hide();
      }

      e.preventDefault();

   });


});