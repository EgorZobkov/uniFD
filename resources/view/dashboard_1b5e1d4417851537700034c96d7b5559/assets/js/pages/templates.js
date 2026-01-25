
import Helpers from '../helpers.class.js';

$(document).ready(function () {

   const helpers = new Helpers();

   var codemirror = null;

   helpers.loadBody(null,function() {

     if($(".templates-page-code-view").length){   
        codemirror = CodeMirror.fromTextArea(document.querySelector(".templates-page-code-view"), {
            lineNumbers: true,
            mode: "text/html",
            enterMode: "keep",
            autoRefresh: true
        });
     }

   });

   $(document).on('click','.buttonSaveTemplate', function (e) {  

      helpers.startProcessLoadButton($('.buttonSaveTemplate'));
      
      var form = new FormData($(".formTemplates")[0]);

      if(codemirror!=null){
         form.append('template_body', encodeURIComponent(codemirror.getValue()));
      }

      helpers.request({url:"dashboard-template-save", data: form, contentType: false, processData: false}, function(data) {

         helpers.showNoticeAnswer(data["answer"], data["type_answer"]);
         helpers.endProcessLoadButton($('.buttonSaveTemplate'));

      });

      e.preventDefault();

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
