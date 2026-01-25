
import Helpers from '../helpers.class.js';

$(document).ready(function () {

   const helpers = new Helpers();

   helpers.loadBody(null,function() {
   });

   $(document).on('click','.deleteVerification', function (e) {  

      helpers.deleteByAlert("dashboard-users-verification-delete",{id: $(this).data("id")});

      e.preventDefault();

   });

   $(document).on('click','.loadCardVerification', function (e) {  

      helpers.openModal("loadContentModal");

      helpers.request({url:"dashboard-users-verification-load-card", data: {id: $(this).data("id")}}, function(data) {

        $("#loadContentModal .load-content-container").html(data["content"]);

      });

      e.preventDefault();

   });

   $(document).on('click','.selectVerificationChangeStatus', function (e) { 

      if($(this).data("status") == "rejected"){

         $(".verification-card-container-reason").show();

      }else{

         helpers.request({url:"dashboard-users-verification-change-status", data: {id: $(this).data("id"), status: $(this).data("status")}}, function(data) {

            location.reload();

         });

      }

      e.preventDefault();

   });

   $(document).on('click','.buttonSaveVerificationReasonStatus', function (e) { 

      helpers.startProcessLoadButton($(this));

      helpers.request({url:"dashboard-users-verification-save-comment-status", data: $(".reason-blocking-form").serialize()}, function(data) {

         if(data["status"] == true){
            location.reload();
         }else{
            helpers.formNoticeManager($('.verification-card-container-reason'), data);
            helpers.endProcessLoadButton($('.buttonSaveVerificationReasonStatus'));
         }

      });

      e.preventDefault();

   });

});
