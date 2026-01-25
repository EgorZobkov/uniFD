
import Helpers from '../helpers.class.js';

$(document).ready(function () {

   const helpers = new Helpers();

   helpers.loadBody(null,function() {
   });

   $(document).on('click','.deleteStory', function (e) {  

      helpers.deleteByAlert("dashboard-stories-delete",{id: $(this).data("id")});

      e.preventDefault();

   });

   $(document).on('click','.loadStory', function (e) {  

      helpers.request({url:"dashboard-stories-load-story", data: {id: $(this).data("id")}}, function(data) {

          if($(".user-stories-modal").length){
             $(".user-stories-modal").remove();
          } 

          $("body").css("overflow", "hidden");
          $("body").append(data["content"]);   

          $('.user-stories-modal-container-item[data-index="1"]').show();

          if($('.user-stories-modal-container-item[data-index="1"] .story-video').length){
              $('.user-stories-modal-container-item[data-index="1"] .story-video')[0].currentTime = 0;
              $('.user-stories-modal-container-item[data-index="1"] .story-video')[0].play();
          }        

      });

      e.preventDefault();

   });

   $(document).on('click','.changeStatusStory', function (e) { 

      helpers.startProcessLoadButton($('.changeStatusStory'));

      helpers.request({url:"dashboard-stories-change-status", data: {id: $(this).data("id")}}, function(data) {

         location.reload();

      });

      e.preventDefault();

   });

   $(document).on('click','.actionCloseModalStories', function (e) { 

       closeModalStories();

   });

   function closeModalStories(){

       $('.user-stories-modal').fadeOut(200, function(){
          $('.user-stories-modal').remove();
       });
 
       $("body").css("overflow", "auto");

       if($('.story-video').length){
          $(".story-video")[0].pause();
       }  

   }

});
