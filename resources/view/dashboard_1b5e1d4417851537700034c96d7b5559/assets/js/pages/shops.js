
import Helpers from '../helpers.class.js';

$(document).ready(function () {

   const helpers = new Helpers();

   helpers.loadBody(null,function() {
   });

   $(document).on('click','.deleteShop', function (e) {  

      helpers.deleteByAlert("dashboard-shops-delete",{id: $(this).data("id")});

      e.preventDefault();

   });

   $(document).on('click','.loadCardShop', function (e) {  

      helpers.openModal("loadContentModal",null,this);

      helpers.request({url:"dashboard-shops-load-card", data: {id: $(this).data("id")}}, function(data) {

        $("#loadContentModal .load-content-container").html(data["content"]);

      });

      e.preventDefault();

   });

   $(document).on('click','.selectShopChangeStatus', function (e) { 

      if($(this).data("status") == "rejected"){

         $(".shop-card-container-reason").show();

      }else{

         helpers.request({url:"dashboard-shops-change-status", data: {id: $(this).data("id"), status: $(this).data("status")}}, function(data) {

            location.reload();

         });

      }

      e.preventDefault();

   });

   $(document).on('click','.buttonSaveShopReasonStatus', function (e) { 

      helpers.startProcessLoadButton($(this));

      helpers.request({url:"dashboard-shops-save-comment-status", data: $(".reason-blocking-form").serialize()}, function(data) {

         if(data["status"] == true){
            location.reload();
         }else{
            helpers.formNoticeManager($('.reason-blocking-form'), data);
            helpers.endProcessLoadButton($('.buttonSaveShopReasonStatus'));
         }

      });

      e.preventDefault();

   });

   $(document).on('click','.loadEditShop', function (e) {  

      helpers.openModal("loadContentModal", "medium",this);

      helpers.request({url:"dashboard-shops-load-edit", data: {id:$(this).data("id")}}, function(data) {

         $("#loadContentModal .load-content-container").html(data["content"]);

      });

      e.preventDefault();

   });

   $(document).on('submit','.formEditShop', function (e) {  

      $('.formEditShop .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonSaveEditShop'));
      
      helpers.request({url:"dashboard-shops-edit", data: $(".formEditShop").serialize()}, function(data) {

         if(data["status"] == true){

            helpers.hideModal("loadContentModal");
            helpers.formNoticeManager($('.formEditShop'), data);

         }else{
            helpers.formNoticeManager($('.formEditShop'), data);
         }

         helpers.endProcessLoadButton($('.buttonSaveEditShop'));

      });

      e.preventDefault();

   });


});
