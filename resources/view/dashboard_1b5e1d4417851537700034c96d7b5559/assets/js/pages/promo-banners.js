
import Helpers from '../helpers.class.js';

$(document).ready(function () {

   const helpers = new Helpers();

   helpers.loadBody(null,function() {
   });

   $(document).on('submit','.formAddPromoBanner', function (e) {  

      $('.formAddPromoBanner .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonAddPromoBanner'));
      
      helpers.request({url:"dashboard-promo-banner-add", data: $(".formAddPromoBanner").serialize(), button: $('.buttonAddPromoBanner')}, function(data) {

         if(data["status"] == true){
            location.reload();
         }else{
            helpers.formNoticeManager($('.formAddPromoBanner'), data);
            helpers.endProcessLoadButton($('.buttonAddPromoBanner'));
         }

      });

      e.preventDefault();

   });   

   $(document).on('submit','.formEditPromoBanner', function (e) {  

      $('.formEditPromoBanner .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonSaveEditPromoBanner'));
      
      helpers.request({url:"dashboard-promo-banner-edit", data: $(".formEditPromoBanner").serialize(), button: $('.buttonSaveEditPromoBanner')}, function(data) {

         if(data["status"] == true){

            helpers.hideModal("loadContentModal");
            helpers.showNoticeAnswer(data["answer"], data["type_answer"]);

         }else{
            helpers.formNoticeManager($('.formEditPromoBanner'), data);
         }

         helpers.endProcessLoadButton($('.buttonSaveEditPromoBanner'));

      });

      e.preventDefault();

   });

   $(document).on('click','.deleteBanner', function (e) {  

      helpers.deleteByAlert("dashboard-promo-banner-delete",{id: $(this).data("id")});

      e.preventDefault();

   });

   $(document).on('click','.loadEditBanner', function (e) {  

      helpers.openModal("loadContentModal", "medium");

      helpers.request({url:"dashboard-promo-banner-load-edit", data: {id:$(this).data("id")}}, function(data) {

         $("#loadContentModal .load-content-container").html(data["content"]);

      });

      e.preventDefault();

   });

   $(document).on('change','select[name=page_show]', function (e) { 

      var selected = $(this).find('option:selected'); 

      if(selected.val() == "catalog"){
         $('.add-promo-banner-categories-container').show();
      }else{
         $('.add-promo-banner-categories-container').hide();         
      }

   });

});
