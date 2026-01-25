
import Helpers from './helpers.class.js';

$(document).ready(function () {

   var helpers = new Helpers();

   var current_count_messages = 0;
   var current_count_channel_messages = [];
   var access_status = true;

   function updateChat(){

      if(access_status == true){
         helpers.request({url:"dashboard-chat-update-count-messages", checkAccess: false}, function(data) {

            if(data['access'] != undefined || data['auth'] != undefined){
               access_status = false;
            }

            if(current_count_messages != data["count"]){

               $(".chat-dialogues-container").html(data["dialogues"]);

                $.each(data["data"]["support"], function(key, value) {
                  
                  if(value.count){

                     if($(".chat-dialogue-messages-container[data-token="+value.token+"]").length){
                        helpers.request({url:"dashboard-chat-load-dialogue", data: {token: value.token}}, function(data) {

                           $(".chat-dialogue-messages-container[data-token="+value.token+"]").html(data["content"]);

                        });
                     }

                  }

                });

            }

            $.each(data["data"]["channel"], function(key, value) {
               
               if(current_count_channel_messages[value.channel_id] != value.count){

                  if($(".chat-dialogue-messages-container[data-channel-id="+value.channel_id+"]").length){
                     helpers.request({url:"dashboard-chat-load-dialogue", data: {channel_id: value.channel_id}}, function(data) {

                        $(".chat-dialogue-messages-container[data-channel-id="+value.channel_id+"]").html(data["content"]);

                     });
                  }

                  current_count_channel_messages[value.channel_id] = value.count;

               }

            });

            current_count_messages = data["count"];

            if(current_count_messages > 0){
               $(".labelChatCountMessages").html(current_count_messages).css("display", "inline-flex");
            }else{
               $(".labelChatCountMessages").hide();
            }

         });
      }

   }

   $(document).on('click','.actionLoadCanvasChat', function (e) { 

      helpers.request({url:"dashboard-chat-load-support-dialogues"}, function(data) {

         $(".offcanvas-chat-content-dialogues").html(data["content"]);         

      });      

      e.preventDefault();

   });

   $(document).on('click','.offcanvas-chat-content-dialogues .chat-dialogues-item', function (e) { 

      helpers.request({url:"dashboard-chat-load-support-dialogue", data: {id: $(this).data("id")}}, function(data) {

         $(".offcanvas-chat-content-dialogues").html(data["content"]);         

      });  

      return false;    

      e.preventDefault();

   });

   $(document).on('click','.actionChatDeleteMessage', function (e) {  

      var _this = this;

      helpers.request({url:"dashboard-chat-delete-message", data: {id: $(this).data("id")}}, function(data) {

         $(_this).parents(".chat-dialogue-item-container").remove().hide();

      });

      e.preventDefault();

   });

   $(document).on('click','.actionChatDeleteDialogue', function (e) {  

      helpers.deleteByAlert("dashboard-chat-delete-dialogue",{id:$(this).data("id")});

      e.preventDefault();

   });

   $(document).on('click','.actionChatAddUserToBlacklist', function (e) {  

      var _this = this;

      helpers.request({url:"dashboard-chat-add-blacklist", data: {id: $(this).data("id"), channel_id: $(this).data("channel-id")}}, function(data) {

         helpers.showNoticeAnswer(data["answer"]);
         $(_this).html(data["label"]);

      });

      e.preventDefault();

   });

   function send(container){

      var date = new Date();
      var text;
      var attachFiles = [];
      var uniq_message_id = helpers.generateStr(24);

      if(container.find('.chat-dialogue-footer-action-textarea').val().trim() || container.find('.uni-attach-files-item input').length){

         if(container.find(".uni-attach-files-item input").length){
            container.find(".uni-attach-files-item img").each(function( index ) {
               attachFiles.push('<a class="chat-dialogue-item-message-text-attach-image uniMediaSliderItem" href="'+$(this).attr("src")+'" data-media-key="'+index+'" data-media-type="image" ><img src="'+$(this).attr("src")+'" /></a>');
            }); 
            text = container.find('.chat-dialogue-footer-action-textarea').val()+'<div class="chat-dialogue-item-message-text-attach-list uniMediaSliderContainer" >'+attachFiles.join('')+'</div>';           
         }else{
            text = container.find('.chat-dialogue-footer-action-textarea').val();
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

         if($(".chat-dialogue-items-scroll").length){
            $(".chat-dialogue-items-scroll").scrollTop($(".chat-dialogue-items-scroll").get(0).scrollHeight);
         }else if($(".chat-dialogue-container-content").length){
            $(".chat-dialogue-container-content").scrollTop($(".chat-dialogue-container-content").get(0).scrollHeight);
         }
         

         helpers.request({url:"dashboard-chat-send-message", data: container.serialize()+"&uniq_id="+uniq_message_id}, function(data) {

             $('.actionChatDeleteMessage[data-uniq-id='+uniq_message_id+']').attr("data-id", data["id"]);            

         });      
         
         if(container.find(".uni-attach-files-item input").length){
            container.find(".uni-attach-files-item").remove();
         }

      }

      $('.chat-dialogue-footer-action-textarea').val('');
      
   }

   $(document).on('click','.chat-dialogue-footer-action-send', function (e) {
      send($(this).parents("form"));
      e.preventDefault();
   });

   $(document).on('keydown','.chat-dialogue-footer-action-textarea', function (e) { 
       if (e.keyCode == 13 && !e.shiftKey) {
         send($(this).parents("form"));
         e.preventDefault();
       }
   });

   setInterval(function() {
      updateChat();
   }, 3000);

   $(function(){ 
      
      updateChat();

   });

});
