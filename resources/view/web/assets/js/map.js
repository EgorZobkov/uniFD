import Helpers from './helpers.class.js';

$(document).ready(function () {

   const helpers = new Helpers();

   $(document).on("click",".actionMapShowItems", function (e) { 

       if($(window).width() <= 992){
          $(".search-map-sidebar").hide();
          $(".search-map-sidebar-card").hide();
       }else{
          $(".search-map-sidebar").show();
          $(".search-map-sidebar-card").hide();
       }

       e.preventDefault();
   });

   $(document).on("click",".actionMapShowFilters", function (e) { 

       $(".search-map-sidebar").css("opacity", 0.9);
       $(".search-map-sidebar-filters").show();

       e.preventDefault();
   });

   $(document).on("click",".actionMapCloseFilters", function (e) { 

       $(".search-map-sidebar").css("opacity", 1);
       $(".search-map-sidebar-filters").hide();

       e.preventDefault();
   });


});