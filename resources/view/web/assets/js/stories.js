import Helpers from './helpers.class.js';

$(document).ready(function () {

   const helpers = new Helpers();

   var storyTimeline;
   var totalCountStories = 0;
   var indexStory = 1;
   var openStoriesId = 0;
   const timeout = 300;
   let idTimeout;
   var forward = true;

   $(document).on('click','.actionChangeAddStory', function (e) {

      $(".storyAttachMediaInput").remove();

      $("body").append('<input type="file" '+helpers.config("stories_accept_upload_formats")+' style="display: none;" class="storyAttachMediaInput">');

      $(".storyAttachMediaInput").click();

      e.preventDefault(); 

   });

   $(document).on('change','.storyAttachMediaInput', function (e) { 

      $('.actionChangeAddStory').prop('disabled', true);
      $('.actionChangeAddStory .widget-stories-item-process-load').css("visibility", "visible");

      var formData = new FormData();

      formData.append('attach_files', $(this)[0].files[0]);

      var size = $(this)[0].files.item(0).size;
      var type = $(this)[0].files.item(0).type;

      if(type.split("/")[0] == "image"){

           if(size > helpers.config("stories_max_size_image")*1024*1024){
               helpers.showNoticeAnswer(helpers.translate.content("tr_da64c3d2aebe085e37b81de2b8f291d6")+' '+helpers.config("stories_max_size_image")+' '+helpers.translate.content("tr_505c12388f06a422b00aa0ac07de72c5"));
           }

      }else if(type.split("/")[0] == "video"){

           if(size > helpers.config("stories_max_size_video")*1024*1024){
               helpers.showNoticeAnswer(helpers.translate.content("tr_9ae516c38adb35538122d6c0ac3d98f0")+' '+helpers.config("stories_max_size_video")+' '+helpers.translate.content("tr_505c12388f06a422b00aa0ac07de72c5"));
           }

      }else{

           if(size > helpers.config("stories_max_size_image")*1024*1024){
               helpers.showNoticeAnswer(helpers.translate.content("tr_da64c3d2aebe085e37b81de2b8f291d6")+' '+helpers.config("stories_max_size_image")+' '+helpers.translate.content("tr_505c12388f06a422b00aa0ac07de72c5"));
           }         
         
      }

      helpers.request({url:"stories-upload-attach", data: formData, contentType: false, processData: false}, function(data) {

         $('.actionChangeAddStory').prop('disabled', false);
         $('.actionChangeAddStory .widget-stories-item-process-load').css("visibility", "hidden");

         if(data["status"] == true){

            if($(".user-stories-modal").length){
              $(".user-stories-modal").remove();
            } 

            $("body").css("overflow", "hidden");
            $("body").append(data["content"]);   

            $('.user-stories-modal-container-item[data-index="1"]').show();
            
         }

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

       var hashes = window.location.href.split('#');

       history.pushState("", "", hashes[0]);  

       $("body").css("overflow", "auto");

       if($('.story-video').length){
          $(".story-video")[0].pause();
       }  

   }

   function loadStories(id, category_id){

      openStoriesId = id;

      helpers.request({url:"stories-load", data: {id: id, category_id: category_id}}, function(data) {

          $('.actionOpenModalUserStories[data-id="'+id+'"]').find(".stories-border-no-view").removeClass("stories-border-no-view");

          indexStory = 1;
          totalCountStories = parseInt($('.user-stories-modal-container-item').length);

          if($(".user-stories-modal").length){
             $(".user-stories-modal").remove();
          } 

          $("body").css("overflow", "hidden");
          $("body").append(data["content"]);   

          $('.user-stories-modal-container-item[data-index="'+indexStory+'"]').show();

          if($('.user-stories-modal-container-item[data-index="'+indexStory+'"] .story-video').length){
              $('.user-stories-modal-container-item[data-index="'+indexStory+'"] .story-video')[0].currentTime = 0;
              $('.user-stories-modal-container-item[data-index="'+indexStory+'"] .story-video')[0].play();
          }

          timeline(indexStory);      

      });  

   }

   function timeline(index=1){

      var duration = $('.user-stories-modal-container-item[data-index="'+index+'"]').data("duration") ? $('.user-stories-modal-container-item[data-index="'+index+'"]').data("duration") : '10';

      $('.user-stories-modal-container-header-timeline>div[data-index="'+index+'"]').html("");
      $('.user-stories-modal-container-header-timeline>div[data-index="'+index+'"]').append('<span class="animation" ></span>');

      storyTimeline = $('.user-stories-modal-container-header-timeline>div[data-index="'+index+'"] span');

      storyTimeline.css("animation-duration", duration+"s");

      storyTimeline.on('animationend', function () {
         nextStory();
      });

      storyTimeline.css("animation-play-state", "running");

   }

   $(document).on('click','.actionPublicationStory', function (e) { 

      helpers.startProcessLoadButton($('.actionPublicationStory'));
         
      helpers.request({url:"stories-publication", data: {name: $(this).data("name"), type: $(this).data("type")}}, function(data) {

         if(data["status"] == true){
            closeModalStories();
            helpers.showNoticeAnswer(data["answer"]);
         }else{
            helpers.showNoticeAnswer(data["answer"]);
            helpers.endProcessLoadButton($('.actionPublicationStory'));
         }

      });

      e.preventDefault(); 

   });

   $(document).on('click','.actionDeleteStory', function (e) { 

      helpers.deleteByAlert("stories-delete",{id:$(this).data("id")});

      e.preventDefault(); 

   });

   $(document).on('click','.actionOpenModalUserStories', function (e) { 

      loadStories($(this).data("id"), $(this).data("category-id"));

      e.preventDefault(); 

   });

   $(document).on('click','.actionPrevLoadStory', function (e) { 

      prevStory();

      e.preventDefault(); 

   });

   $(document).on('mousedown','.actionNextLoadStory', function (e) { 

       idTimeout = setTimeout(function() {

          forward = false;
          storyTimeline.css("animation-play-state", "paused");
          if($('.story-video').length){
             $(".story-video")[0].pause();
          }

       }, timeout);

   });

   $(document).on('mouseup','.actionNextLoadStory', function (e) { 

       storyTimeline.css("animation-play-state", "running");
       if($('.user-stories-modal-container-item[data-index="'+indexStory+'"] .story-video').length){
          $('.user-stories-modal-container-item[data-index="'+indexStory+'"] .story-video')[0].play();
       }

       clearTimeout(idTimeout);

       if(forward){
          nextStory();
       }

       forward = true;

   });

   function nextStory(){

      let i = 1;

      if($('.story-video').length){
        $('.story-video')[0].pause();
      }

      indexStory = indexStory + 1;

      if($('.user-stories-modal-container-item[data-index="'+indexStory+'"]').length){

           $('.user-stories-modal-container-item').hide();
           $('.user-stories-modal-container-item[data-index="'+indexStory+'"]').show();

           while (i < indexStory) {
             $('.user-stories-modal-container-header-timeline>div[data-index="'+i+'"]').html("");
             $('.user-stories-modal-container-header-timeline>div[data-index="'+i+'"]').append('<span class="end" ></span>');
             i++;
           }

           $('.user-stories-modal-container-header-timeline>div[data-index="'+indexStory+'"]').html("");
           $('.user-stories-modal-container-header-timeline>div[data-index="'+indexStory+'"]').append('<span class="start" ></span>');

           if($('.user-stories-modal-container-item[data-index="'+indexStory+'"] .story-video').length){
              $('.user-stories-modal-container-item[data-index="'+indexStory+'"] .story-video')[0].currentTime = 0;
              $('.user-stories-modal-container-item[data-index="'+indexStory+'"] .story-video')[0].play();
           }

           timeline(indexStory);

      }else{

           if($('.actionOpenModalUserStories[data-id="'+openStoriesId+'"]').next().data("id") != undefined){
               loadStories($('.actionOpenModalUserStories[data-id="'+openStoriesId+'"]').next().data("id"), $('.actionOpenModalUserStories[data-id="'+openStoriesId+'"]').next().data("category-id"));
           }else{
               closeModalStories();
           }

      }

   }

   function prevStory(){
      
      let i = 1;

      if($('.story-video').length){
        $('.story-video')[0].pause();
      }

      indexStory = indexStory - 1;

      if($('.user-stories-modal-container-item[data-index="'+indexStory+'"]').length){

           $('.user-stories-modal-container-item').hide();
           $('.user-stories-modal-container-item[data-index="'+indexStory+'"]').show();

           $('.user-stories-modal-container-header-timeline>div').html("");
           $('.user-stories-modal-container-header-timeline>div').append('<span class="start" ></span>');

           while (i < indexStory) {
             $('.user-stories-modal-container-header-timeline>div[data-index="'+i+'"]').html("");
             $('.user-stories-modal-container-header-timeline>div[data-index="'+i+'"]').append('<span class="end" ></span>');
             i++;
           }

           if($('.user-stories-modal-container-item[data-index="'+indexStory+'"] .story-video').length){
              $('.user-stories-modal-container-item[data-index="'+indexStory+'"] .story-video')[0].currentTime = 0;
              $('.user-stories-modal-container-item[data-index="'+indexStory+'"] .story-video')[0].play();
           }

           timeline(indexStory);

      }else{

           if($('.actionOpenModalUserStories[data-id="'+openStoriesId+'"]').prev().data("id") != undefined){
               loadStories($('.actionOpenModalUserStories[data-id="'+openStoriesId+'"]').prev().data("id"), $('.actionOpenModalUserStories[data-id="'+openStoriesId+'"]').next().data("category-id"));
           }else{
               closeModalStories();
           }

      }

   }

});
