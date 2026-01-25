import Helpers from './helpers.class.js';

$(document).ready(function () {

   const helpers = new Helpers();

   function loadShops(){

      helpers.request({url:"shops-load-items", data: {category_id: $("input[name=shops_category_id]").val()}}, function(data) {

         $(".shops-container-items").html(data["content"]);

      });      

   }

   loadShops();

});