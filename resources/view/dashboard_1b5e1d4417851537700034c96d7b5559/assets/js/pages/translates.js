
import Helpers from '../helpers.class.js';

$(document).ready(function () {

   var helpers = new Helpers();

   helpers.loadBody(null,function() {
   });

   $(document).on('submit','.formAddLanguage', function (e) {  

      $('.formAddLanguage .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonAddLanguage'));
      
      helpers.request({url:"dashboard-translates-add-language", data: $('.formAddLanguage').serialize()}, function(data) {

         if(data["status"] == true){

            location.reload();

         }else{
            helpers.formNoticeManager($('.formAddLanguage'), data);
         }

         helpers.endProcessLoadButton($('.buttonAddLanguage'));

      });

      e.preventDefault();

   });

   $(document).on('click','.deleteLanguage', function (e) {  

      helpers.deleteByAlert("dashboard-translates-delete-language",{id:$(this).data("id")});

      e.preventDefault();

   });

   $(document).on('click','.actionSaveEditTranslatesContent', function (e) {  

      $('.formTranslatesContent .form-label-error').hide();

      helpers.startProcessLoadButton($('.actionSaveEditTranslatesContent'));
      
      helpers.request({url:"dashboard-translates-edit-content", data: {data: encodeURIComponent($('.formTranslatesContent').serialize())}}, function(data) {

         helpers.showNoticeAnswer(data["answer"], data["type_answer"]);

         helpers.endProcessLoadButton($('.actionSaveEditTranslatesContent'));

      });

      e.preventDefault();

   });

   $(document).on('click','.loadEditLanguage', function (e) {  

      helpers.openModal("loadContentModal", "medium");

      helpers.request({url:"dashboard-translates-language-load-edit", data: {id:$(this).data("id")}}, function(data) {

         $("#loadContentModal .load-content-container").html(data["content"]);

      });

      e.preventDefault();

   });

   $(document).on('click','.actionUpdateTranslatesContent', function (e) {  

      helpers.showUiLoadingScreen();

      helpers.request({url:"dashboard-translates-update-content"}, function(data) {

         helpers.hideUiLoadingScreen();

         $("#testLogModal textarea").val(data["answer"]);
         helpers.openModal("testLogModal", "modal-md");

      });

      e.preventDefault();

   });

   $(document).on('submit','.formEditLanguage', function (e) {  

      $('.formEditLanguage .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonSaveEditLanguage'));
      
      helpers.request({url:"dashboard-translates-edit-language", data: $(".formEditLanguage").serialize(), button: $('.buttonSaveEditLanguage')}, function(data) {

         if(data["status"] == true){

            helpers.hideModal("loadContentModal");
            helpers.showNoticeAnswer(data["answer"], data["type_answer"]);

         }else{
            helpers.formNoticeManager($('.formEditLanguage'), data);
         }

         helpers.endProcessLoadButton($('.buttonSaveEditLanguage'));

      });

      e.preventDefault();

   });

});
