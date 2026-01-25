
import Helpers from '../helpers.class.js';

$(document).ready(function () {

   const helpers = new Helpers();

   helpers.loadBody(null,function() {
   });

   $(document).on('submit','.formAddTask', function (e) {  

      $('.formAddTask .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonAddTask'));
      
      var form = new FormData($(".formAddTask")[0]);

      helpers.request({url:"dashboard-import-export-add", data: form, cache: false, contentType: false, processData: false}, function(data) {

         if(data["status"] == true){
            location.href = data["redirect"];
         }else{
            helpers.formNoticeManager($('.formAddTask'), data);
            helpers.endProcessLoadButton($('.buttonAddTask'));
         }

      });

      e.preventDefault();

   });   

   $(document).on('click','.buttonStartImport', function (e) {  

      $('.formFieldsImport .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonStartImport'));
      
      helpers.request({url:"dashboard-import-start", data: $(".formParamsImport, .formFieldsImport").serialize()}, function(data) {

         if(data["status"] == true){
            location.href = data["redirect"];
         }else{
            helpers.formNoticeManager($('.formFieldsImport'), data);
            helpers.endProcessLoadButton($('.buttonStartImport'));
         }

      });

      e.preventDefault();

   }); 

   $(document).on('click','.buttonSaveImport', function (e) {  

      $('.formFieldsImport .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonStartImport'));
      
      helpers.request({url:"dashboard-import-save", data: $(".formParamsImport, .formFieldsImport").serialize()}, function(data) {

         helpers.formNoticeManager($('.formFieldsImport'), data);
         helpers.endProcessLoadButton($('.buttonStartImport'));

      });

      e.preventDefault();

   });

   $(document).on('change','.import-export-select-action', function (e) {  

      var selected = $(this).find('option:selected');

      if(selected.val() == "export"){
         $('.import-export-container-action-export').show(); 
         $('.import-export-container-file-change, .import-export-container-link-file, .import-export-container-source-change,.import-export-container-import-options').hide();
      }else if(selected.val() == "import"){
         $('.import-export-container-source-change').show(); 
         $('.import-export-container-file-change, .import-export-container-link-file, .import-export-container-action-export,.import-export-container-import-options').hide();
      }else{
         $('.import-export-container-file-change, .import-export-container-link-file, .import-export-container-source-change, .import-export-container-source-change,.import-export-container-import-options').hide(); 
      }

   });

   $(document).on('change','.import-export-select-source', function (e) {  

      var selected = $(this).find('option:selected');

      if(selected.val() == "file"){
         $('.import-export-container-file-change').show(); 
         $('.import-export-container-link-file,.import-export-container-import-options').hide();
      }else if(selected.val() == "link"){
         $('.import-export-container-link-file,.import-export-container-import-options').show(); 
         $('.import-export-container-file-change').hide();
      }else{
         $('.import-export-container-file-change,.import-export-container-link-file,.import-export-container-import-options').hide();
      }

   });

   $(document).on('click','.deleteTaskImport', function (e) {  

      helpers.deleteByAlert("dashboard-import-export-delete",{id:$(this).data("id"), delete_data: $("#alertDeleteImportModal input[name=delete_data]").prop("checked")});

      e.preventDefault();

   });

   $(document).on('click','.deleteTaskExport', function (e) {  

      helpers.deleteByAlert("dashboard-import-export-delete",{id:$(this).data("id")});

      e.preventDefault();

   });

   $(document).on('change','.import-card-container-checked-category-auto', function (e) {  

      if($(this).prop("checked") == true){
         $('.import-card-container-selected-categories').hide(); 
      }else{
         $('.import-card-container-selected-categories').show();
      }

   });

   $(document).on('change','.import-card-container-checked-cities-auto', function (e) {  

      if($(this).prop("checked") == true){
         $('.import-card-container-selected-cities').hide(); 
      }else{
         $('.import-card-container-selected-cities').show();
      }

   });

   $(document).on('change','.import-card-container-checked-image-download', function (e) {  

      if($(this).prop("checked") == true){
         $('.import-card-container-count-download-photo').show(); 
      }else{
         $('.import-card-container-count-download-photo').hide();
      }

   });

   $(document).on('change','.import-card-container-checked-user-auto', function (e) {  

      if($(this).prop("checked") == true){
         $('.import-card-container-selected-users').hide(); 
      }else{
         $('.import-card-container-selected-users').show();
      }

   });

   $(document).on('input click','.input-live-search-cities', function (e) {  

      var _this = this;

      if($(this).val().length > 1){

         $(_this).parents(".container-live-search").find(".container-live-search-results").html('<div class="text-center" ><div class="spinner-border spinner-border-sm text-primary" role="status"><span class="visually-hidden"></span></div></div>').show();

         helpers.request({url:"dashboard-import-search-city", data:{query: $(this).val()}}, function(data) {

            $(_this).parents(".container-live-search").find(".container-live-search-results").html(data["content"]);

         });

      }else{
         $(_this).parents(".container-live-search").find(".container-live-search-results").hide();
      }

   });

   $(document).on('click','.container-live-search-results-item-city', function (e) {  

      $(".container-live-search-results").hide();

      $(this).parents(".container-live-search").find(".input-live-search").val($(this).data("city-name"));
      $(".input-live-search-city-id").val($(this).data("id"));

   });

   $(document).on('input click','.input-live-search-users', function (e) {  

      var _this = this;

      if($(this).val().length > 1){

         $(_this).parents(".container-live-search").find(".container-live-search-results").html('<div class="text-center" ><div class="spinner-border spinner-border-sm text-primary" role="status"><span class="visually-hidden"></span></div></div>').show();

         helpers.request({url:"dashboard-import-search-user", data:{query: $(this).val()}}, function(data) {

            $(_this).parents(".container-live-search").find(".container-live-search-results").html(data["content"]);

         });

      }else{
         $(_this).parents(".container-live-search").find(".container-live-search-results").hide();
      }

   });

   $(document).on('click','.container-live-search-results-item-user', function (e) {  

      $(".container-live-search-results").hide();

      $(this).parents(".container-live-search").find(".input-live-search").val($(this).data("user-name"));
      $(this).parents(".container-live-search").find(".input-live-search-user-id").val($(this).data("id"));
   });

   $(document).on('submit','.formAddFeed', function (e) {  

      $('.formAddFeed .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonAddFeed'));
      
      helpers.request({url:"dashboard-import-export-feed-add", data: $(".formAddFeed").serialize()}, function(data) {
         if(data["status"] == true){
            if(data["redirect"] != undefined){
               location.href = data["redirect"];
            }else{
               location.reload();
            }
         }else{
            helpers.formNoticeManager($('.formAddFeed'), data);
            helpers.endProcessLoadButton($('.buttonAddFeed'));
         }

      });

      e.preventDefault();

   });

   $(document).on('click','.deleteFeed', function (e) {  

      helpers.deleteByAlert("dashboard-import-export-feed-delete",{id:$(this).data("id")});

      e.preventDefault();

   });

   $(document).on('submit','.formEditFeed', function (e) {  

      $('.formEditFeed .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonSaveEditFeed'));
      
      helpers.request({url:"dashboard-import-export-feed-edit", data: $(".formEditFeed").serialize(), button: $('.buttonSaveEditFeed')}, function(data) {

         if(data["status"] == true){

            helpers.hideModal("loadContentModal");
            helpers.showNoticeAnswer(data["answer"], data["type_answer"]);

         }else{
            helpers.formNoticeManager($('.formEditFeed'), data);
         }

         helpers.endProcessLoadButton($('.buttonSaveEditFeed'));

      });

      e.preventDefault();

   });

   $(document).on('click','.loadEditFeed', function (e) {  

      helpers.openModal("loadContentModal", "small");

      helpers.request({url:"dashboard-import-export-feed-load-edit", data: {id:$(this).data("id")}}, function(data) {

         $("#loadContentModal .load-content-container").html(data["content"]);

      });

      e.preventDefault();

   });

   $(document).on('change','.formAddFeed select[name=feed_format]', function (e) { 

      var selected = $(this).find('option:selected'); 

      if(selected.val() == "yandex_yml"){
         $('.add-feed-format-info-container').show();
      }else{
         $('.add-feed-format-info-container').hide();         
      }

   });

   $(document).on('change','.formEditFeed select[name=feed_format]', function (e) { 

      var selected = $(this).find('option:selected'); 

      if(selected.val() == "yandex_yml"){
         $('.edit-feed-format-info-container').show();
      }else{
         $('.edit-feed-format-info-container').hide();         
      }

   });

});
