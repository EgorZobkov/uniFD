
import Helpers from '../helpers.class.js';

$(document).ready(function () {

   const helpers = new Helpers();

   var textEditor = null

   helpers.loadBody(null,function() {
   });

   $(document).on('click','.actionSeoSaveEdit', function (e) {  

      helpers.startProcessLoadButton($('.actionSeoSaveEdit'));

      helpers.request({url:"dashboard-seo-save", data: {content: encodeURIComponent($(".formSeo").serialize())}}, function(data) {

         if(data["status"] == true){
            helpers.showNoticeAnswer(data["answer"], data["type_answer"]);
         }else{
            helpers.formNoticeManager($('.formSeo'), data);
         }

         helpers.endProcessLoadButton($('.actionSeoSaveEdit'));

      });

      e.preventDefault();

   });   

   $(document).on('change','.seo-catalog-change-condition-category', function (e) { 

      var selected = $(this).find('option:selected'); 

      if(selected.val() == "category"){
         $('.seo-catalog-condition-category-container-1').show();
         $('.seo-catalog-condition-category-container-2').hide();
      }else if(selected.val() == "not_category"){
         $('.seo-catalog-condition-category-container-2').show();
         $('.seo-catalog-condition-category-container-1').hide();
      }

   });



   $(document).on('click','.actionTemplatesAddPage', function (e) {  

      $('.formAddPage .form-label-error').hide();

      helpers.startProcessLoadButton($('.actionTemplatesAddPage'));

      helpers.request({url:"dashboard-template-add-page", data: $(".formAddPage").serialize()}, function(data) {

            if(data["status"] == true){
               location.href = data["redirect"];
            }else{
               helpers.formNoticeManager($('.formAddPage'), data);
               helpers.endProcessLoadButton($('.actionTemplatesAddPage'));
            }
 
      });
      
      e.preventDefault();

   });   

   $(document).on('click','.actionTemplatesDeletePage', function (e) {  

      helpers.deleteByAlert("dashboard-template-delete-page",{id: $(this).data("id")});

      e.preventDefault();

   });
   
   $(document).on('click','.actionTemplatesLoadEditPage', function (e) {  

      helpers.openModal("loadContentModal", "small");

      helpers.request({url:"dashboard-template-load-edit-page", data: {id: $(this).data("id")}}, function(data) {

        $("#loadContentModal .load-content-container").html(data["content"]);

      });

      e.preventDefault();

   });

   $(document).on('submit','.formEditPage', function (e) {  

      $('.formEditPage .form-label-error').hide();

      helpers.startProcessLoadButton($('.actionTemplatesSaveEditPage'));
      
      helpers.request({url:"dashboard-template-edit-page", data: $('.formEditPage').serialize()}, function(data) {

         if(data["status"] == true){

            helpers.hideModal("loadContentModal");
            helpers.showNoticeAnswer(data["answer"], data["type_answer"]);

         }else{
            helpers.formNoticeManager($('.formEditPage'), data);
         }

         helpers.endProcessLoadButton($('.actionTemplatesSaveEditPage'));

      });

      e.preventDefault();

   });

});
