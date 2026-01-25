
import Helpers from '../helpers.class.js';

$(document).ready(function () {

   const helpers = new Helpers();

   var widgetsIds = [];
   var el = document.getElementById('widget-sortable-container');
   var sortable = Sortable.create(el, {
      handle: ".widget-sortable-handle",
      onEnd: function (evt) {

         $(".home-widget-item").each(function(){
             widgetsIds.push($(this).data("id"));
         });

         helpers.request({url:"dashboard-widgets-sorting", data: {ids: widgetsIds.join(",")}}, function(data) {});

         widgetsIds = [];

      },      
   });

   $(document).on('click','.home-widget-item-remove', function (e) {  

      var _this = this;

      helpers.request({url:"dashboard-widget-remove", data: {id: $(_this).data("id")}}, function(data) {

            $(_this).parents(".home-widget-item").fadeOut(150, function() {
                $(_this).parents(".home-widget-item").remove();
                if($(".home-widget-item").length == 0){
                  location.reload();
                }
            });

      });

      e.preventDefault();

   });

   function widgetsUpdate(){

      if($(".home-widget-item").length != 0){

         helpers.request({url:"dashboard-home-update"}, function(data) {

               if(data != undefined){
                  $.each(data,function(id,content){
                     if(content["hash"] != $(".home-widget-item[data-id="+id+"]").attr("data-hash")){
                        $(".home-widget-javascript-container > script").remove();
                        $(".home-widget-item[data-id="+id+"]").html($(content["data"]).filter(".home-widget-item").html());
                        $(".home-widget-item[data-id="+id+"]").attr("data-hash",content["hash"]);
                     }
                  });  
               }

         });

      }

   }

   widgetsUpdate();

   setInterval(function() {
      widgetsUpdate();
   }, 5000);


});
