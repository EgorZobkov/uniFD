import Helpers from './helpers.class.js';

$(document).ready(function () {

   const helpers = new Helpers();

   function nl2br (str, is_xhtml) {
       if (typeof str === 'undefined' || str === null) {
           return '';
       }
       var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
       return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
   }

   $(document).on('click','.actionChatDeleteDialogue', function (e) {  

      helpers.deleteByAlert("chat-delete-dialogue",{id:$(this).data("id")});
      
      e.preventDefault();

   });

   $(document).on('click','.actionChatRequestReview', function (e) {  
      
      helpers.request({url:"chat-send-request-review", data: {dialogue_id:$(this).data("id")}}, function(data) {

         helpers.showNoticeAnswer(data["answer"]);

      });
      
      e.preventDefault();

   });

   $(document).on('click','.actionChatDeleteMessage', function (e) {  

      var _this = this;

      helpers.request({url:"chat-delete-message", data: {id: $(this).data("id")}}, function(data) {

         $(_this).parents(".chat-dialogue-item-container").remove().hide();

      });

      e.preventDefault();

   });

   $(document).on('click','.actionChatChannelDisableNotify', function (e) {  

      var _this = this;

      helpers.request({url:"chat-channel-disable-notify", data: {id: $(this).data("id")}}, function(data) {

         helpers.showNoticeAnswer(data["answer"]);
         $(_this).html(data["label"]);

      });

      e.preventDefault();

   });

   $(document).on('click','.actionOpenDialogueSendMessage', function (e) {  
      
      helpers.startProcessLoadButton($('.actionOpenDialogueSendMessage'));

      helpers.request({url:"chat-open-send-message", data: {params:$(this).data("params")}, precheck: true, button: $('.actionOpenDialogueSendMessage')}, function(data) {

         $("#chatModal .chat-container").html(data["content"]);
         helpers.openModal('chatModal');
         helpers.endProcessLoadButton($('.actionOpenDialogueSendMessage'));

      });
      
      e.preventDefault();

   });

   $(document).on('click','.actionOpenModalChat', function (e) {  
      
      helpers.request({url:"chat-load-dialogues", precheck: true}, function(data) {

         $("#chatModal .chat-container").html(data["content"]);
         helpers.openModal('chatModal');

      });
      
      e.preventDefault();

   });

   $(document).on('click','.actionOpenDialogue', function (e) {  
      
      var _this = this;

      helpers.request({url:"chat-load-dialogue", data: {token: $(this).data("token")}, precheck: true}, function(data) {

         $(_this).parents(".chat-container").html(data["content"]);

      });
      
      e.preventDefault();

   });

   $(document).on('click','.actionOpenDialogues', function (e) {  

      var _this = this;
      
      helpers.request({url:"chat-load-dialogues", precheck: true}, function(data) {

         $(_this).parents(".chat-container").html(data["content"]);

      });
      
      e.preventDefault();

   });

   $(document).on('click','.actionOpenChannel', function (e) {  
      
      var _this = this;

      helpers.request({url:"chat-load-dialogue", data: {channel_id: $(this).data("id")}, precheck: true}, function(data) {

         $(_this).parents(".chat-container").html(data["content"]);

      });
      
      e.preventDefault();

   });

   function send(){

      var date = new Date();
      var text;
      var attachFiles = [];
      var uniq_message_id = helpers.generateStr(24);

      if($('.chat-dialogue-footer-action-textarea').val().trim() || $(".chat-dialogue-form .uni-attach-files-item input").length){

         if($(".chat-dialogue-form .uni-attach-files-item input").length){
            $(".chat-dialogue-form .uni-attach-files-item img").each(function( index ) {
               attachFiles.push('<a class="chat-dialogue-item-message-text-attach-image uniMediaSliderItem" href="'+$(this).attr("src")+'" data-media-key="'+index+'" data-media-type="image" ><img src="'+$(this).attr("src")+'" /></a>');
            }); 
            text = nl2br($('.chat-dialogue-footer-action-textarea').val())+'<div class="chat-dialogue-item-message-text-attach-list uniMediaSliderContainer" >'+attachFiles.join('')+'</div>';           
         }else{
            text = nl2br($('.chat-dialogue-footer-action-textarea').val());
         }

         if($(".chat-dialogue-items-container.chat-dialogue-not-messages").length){
            
            $(".chat-dialogue-items-container").removeClass("chat-dialogue-not-messages");
            $(".chat-dialogue-items-container").html("");

            $(".chat-dialogue-items-container").append(`
               <div class="chat-dialogue-item-container item-message-from" >
                  <div class="chat-dialogue-item-message" >
                     <div class="chat-dialogue-item-message-menu">
                         <div class="uni-dropdown">
                           <span class="uni-dropdown-name"> <div class="chat-dialogue-item-menu"><i class="ti ti-dots"></i></div> </span>  
                           <div class="uni-dropdown-content uni-dropdown-content-align-right uni-dropdown-content-position-bottom">
                                 <span class="uni-dropdown-content-item actionChatDeleteMessage" data-uniq-id="`+uniq_message_id+`">`+helpers.translate.content("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8")+`</span>
                           </div>               
                         </div>
                     </div>                  
                     <div class="chat-dialogue-item-message-text" >`+text+`</div>
                     <div class="chat-dialogue-item-message-date" >`+moment().format('h:mm')+`</div>
                  </div>
               </div>
            `);

         }else{

            $(".chat-dialogue-items-container").append(`
               <div class="chat-dialogue-item-container item-message-from" >
                  <div class="chat-dialogue-item-message" >
                     <div class="chat-dialogue-item-message-menu">
                         <div class="uni-dropdown">
                           <span class="uni-dropdown-name"> <div class="chat-dialogue-item-menu"><i class="ti ti-dots"></i></div> </span>  
                           <div class="uni-dropdown-content uni-dropdown-content-align-right uni-dropdown-content-position-bottom">
                                 <span class="uni-dropdown-content-item actionChatDeleteMessage" data-uniq-id="`+uniq_message_id+`">`+helpers.translate.content("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8")+`</span>
                           </div>               
                         </div>
                     </div>
                     <div class="chat-dialogue-item-message-text" >`+text+`</div>
                     <div class="chat-dialogue-item-message-date" >`+moment().format('h:mm')+`</div>
                  </div>
               </div>
            `);

         }

         $(".chat-dialogue-container-content").scrollTop($(".chat-dialogue-container-content").get(0).scrollHeight);

         helpers.request({url:"chat-send-message", data: $(".chat-dialogue-form").serialize()+"&uniq_id="+uniq_message_id}, function(data) {

             $('.actionChatDeleteMessage[data-uniq-id='+uniq_message_id+']').attr("data-id", data["id"]);            

         });      
         
         if($(".chat-dialogue-form .uni-attach-files-item input").length){
            $(".chat-dialogue-form .uni-attach-files-item").remove();
         }

      }

      $('.chat-dialogue-footer-action-textarea').val('');
      
   }

   var current_count_messages = 0;

   function update(){

      if($(".js-auth-status").data("status") == true){

         helpers.request({url:"chat-update-count-messages"}, function(data) { 

            if(current_count_messages != data["count"]){

               if($(".page-chat-container").length){ 
                  if($(".page-chat-container .chat-dialogues-container").length){
                     helpers.request({url:"chat-load-dialogues"}, function(data) {

                        $(".page-chat-container").html(data["content"]);

                     });
                  }else if($(".page-chat-container .chat-dialogue-container").length){
                     helpers.request({url:"chat-load-messages", data: $(".page-chat-container .chat-dialogue-form").serialize()}, function(data) {

                        $(".page-chat-container .chat-dialogue-items-container").html(data["content"]);

                     });
                  }
               }else if($(".modal-chat-container").length && $('#chatModal').is(':visible')){
                  if($(".modal-chat-container .chat-dialogues-container").length){
                     helpers.request({url:"chat-load-dialogues"}, function(data) {

                        $(".modal-chat-container").html(data["content"]);

                     });
                  }else if($(".modal-chat-container .chat-dialogue-container").length){
                     helpers.request({url:"chat-load-messages", data: $(".modal-chat-container .chat-dialogue-form").serialize()}, function(data) {

                        $(".modal-chat-container .chat-dialogue-items-container").html(data["content"]);

                     });
                  }
               }

            }

            current_count_messages = data["count"];

            if(data["notify"] > 0){
               $(".labelChatCountMessages").html(data["notify"]).css("display", "inline-flex");
            }else{
               $(".labelChatCountMessages").hide();
            }

         });

      }

   }

   $(document).on('click','.chat-dialogue-footer-action-send', function (e) {  
      send();
      e.preventDefault();
   });

   $(document).on('keydown','.chat-dialogue-footer-action-textarea', function (e) { 
       if (e.keyCode == 13 && !e.shiftKey) {
         send();
         e.preventDefault();
       }
   });

   setInterval(function() {
      update();
   }, 3000);

   update();

});