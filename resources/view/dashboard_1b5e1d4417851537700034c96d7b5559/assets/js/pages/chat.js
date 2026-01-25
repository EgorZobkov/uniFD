
import Helpers from '../helpers.class.js';

$(document).ready(function () {

   var helpers = new Helpers();

   helpers.loadBody(null,function() {});

   $(document).on('submit','.formAddChannel', function (e) {  

      $('.formAddChannel .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonAddChannel'));
      
      helpers.request({url:"dashboard-chat-add-channel", data: $('.formAddChannel').serialize()}, function(data) {

         if(data["status"] == true){

            location.reload();

         }else{
            helpers.formNoticeManager($('.formAddChannel'), data);
         }

         helpers.endProcessLoadButton($('.buttonAddChannel'));

      });

      e.preventDefault();

   });

   $(document).on('change','.formAddResponder select[name=send]', function (e) { 

      var selected = $(this).find('option:selected'); 

      if(selected.val() == "date"){
         $('.chat-add-responder-send-date-container').show();
      }else{
         $('.chat-add-responder-send-date-container').hide();
      }

   });

   $(document).on('submit','.formAddResponder', function (e) {  

      $('.formAddResponder .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonAddResponder'));
      
      helpers.request({url:"dashboard-chat-add-responder", data: $('.formAddResponder').serialize()}, function(data) {

         if(data["status"] == true){

            location.reload();

         }else{
            helpers.formNoticeManager($('.formAddResponder'), data);
         }

         helpers.endProcessLoadButton($('.buttonAddResponder'));

      });

      e.preventDefault();

   });

   $(document).on('click','.loadEditResponder', function (e) {  

      helpers.openModal("loadContentModal",null,this);

      helpers.request({url:"dashboard-chat-responder-load-edit", data: {id: $(this).data("id")}}, function(data) {

         $("#loadContentModal .load-content-container").html(data["content"]);

      });

      e.preventDefault();

   });

   $(document).on('submit','.formEditResponder', function (e) {  

      $('.formEditResponder .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonSaveEditResponder'));
      
      helpers.request({url:"dashboard-chat-edit-responder", data: $('.formEditResponder').serialize()}, function(data) {

         if(data["status"] == true){

            location.reload();

         }else{
            helpers.formNoticeManager($('.formEditResponder'), data);
         }

         helpers.endProcessLoadButton($('.buttonSaveEditResponder'));

      });

      e.preventDefault();

   });

   $(document).on('click','.loadEditChannel', function (e) {  

      helpers.openModal("loadContentModal",null,this);

      helpers.request({url:"dashboard-chat-channel-load-edit", data: {id: $(this).data("id")}}, function(data) {

         $("#loadContentModal .load-content-container").html(data["content"]);

      });

      e.preventDefault();

   });

   $(document).on('submit','.formEditChannel', function (e) {  

      $('.formEditChannel .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonSaveEditChannel'));
      
      helpers.request({url:"dashboard-chat-edit-channel", data: $('.formEditChannel').serialize()}, function(data) {

         if(data["status"] == true){

            location.reload();

         }else{
            helpers.formNoticeManager($('.formEditChannel'), data);
         }

         helpers.endProcessLoadButton($('.buttonSaveEditChannel'));

      });

      e.preventDefault();

   });

   $(document).on('click','.deleteResponder', function (e) {

      helpers.deleteByAlert("dashboard-chat-delete-responder",{id:$(this).data("id")});  

      e.preventDefault();

   });

   $(document).on('click','.deleteChannel', function (e) {

      helpers.deleteByAlert("dashboard-chat-delete-channel",{id:$(this).data("id")});  

      e.preventDefault();

   });

   $(document).on('click','.deleteUserBlacklist', function (e) {  


      helpers.request({url:"dashboard-chat-delete-blacklist", data: {id: $(this).data("id")}}, function(data) {

         location.reload();

      });

      e.preventDefault();

   });

   $(document).on('submit','.formChatAutoMessages', function (e) {  

      $('.formChatAutoMessages .form-label-error').hide();

      helpers.startProcessLoadButton($('.actionSaveEditChatAutoMessages'));
      
      helpers.request({url:"dashboard-chat-edit-automessages", data: $('.formChatAutoMessages').serialize()}, function(data) {

         location.reload();

      });

      e.preventDefault();

   });

   $(document).on('click','.loadMessageChat', function (e) {  

      helpers.openModal("loadContentModal");

      helpers.request({url:"dashboard-chat-load-message", data: {id: $(this).data("id")}}, function(data) {

        $("#loadContentModal .load-content-container").html(data["content"]);

      });

      e.preventDefault();

   });

});
