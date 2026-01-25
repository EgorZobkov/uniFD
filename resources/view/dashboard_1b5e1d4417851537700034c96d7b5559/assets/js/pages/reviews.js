
import Helpers from '../helpers.class.js';

$(document).ready(function () {

   const helpers = new Helpers();

   helpers.loadBody(null,function() {
   });

   $(document).on('click','.deleteReview', function (e) {  

      helpers.deleteByAlert("dashboard-review-delete",{id: $(this).data("id")});

      e.preventDefault();

   });

   $(document).on('click','.loadCardReview', function (e) {  

      helpers.openModal("loadContentModal");

      helpers.request({url:"dashboard-review-load-card", data: {id: $(this).data("id")}}, function(data) {

        $("#loadContentModal .load-content-container").html(data["content"]);

      });

      e.preventDefault();

   });

   $(document).on('click','.buttonConfirmReview', function (e) {  

      helpers.openModal("loadContentModal");

      helpers.request({url:"dashboard-review-confirm", data: {id: $(this).data("id")}}, function(data) {

        location.reload();

      });

      e.preventDefault();

   });

   $(document).on('click','.loadEditReview', function (e) {  

      helpers.openModal("loadContentModal", "medium");

      helpers.request({url:"dashboard-review-load-edit", data: {id:$(this).data("id")}}, function(data) {

         $("#loadContentModal .load-content-container").html(data["content"]);

      });

      e.preventDefault();

   });

   $(document).on('submit','.formEditReview', function (e) {  

      $('.formEditReview .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonSaveEditReview'));
      
      helpers.request({url:"dashboard-review-edit", data: $(".formEditReview").serialize()}, function(data) {

         if(data["status"] == true){

            helpers.hideModal("loadContentModal");
            helpers.showNoticeAnswer(data["answer"], data["type_answer"]);

         }else{
            helpers.formNoticeManager($('.formEditReview'), data);
         }

         helpers.endProcessLoadButton($('.buttonSaveEditReview'));

      });

      e.preventDefault();

   });

});
