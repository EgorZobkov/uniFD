
import Helpers from '../helpers.class.js';

$(document).ready(function () {

   const helpers = new Helpers();

   helpers.loadBody(null,function() {
   });

   $(document).on('click','.deleteSearchKeyword', function (e) {  

      helpers.deleteByAlert("dashboard-search-keywords-delete",{id: $(this).data("id")});

      e.preventDefault();

   });

   $(document).on('click','.actionSearchClearRequests', function (e) {

      helpers.showUiLoadingScreen();  

      helpers.request({url:"dashboard-search-requests-clear"}, function(data) {

        location.reload();

      });

      e.preventDefault();

   });

   $(document).on('submit','.formAddSearchKeyword', function (e) {  

      $('.formAddSearchKeyword .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonAddSearchKeyword'));
      
      helpers.request({url:"dashboard-search-keywords-add", data: $(".formAddSearchKeyword").serialize(), button: $('.buttonAddSearchKeyword')}, function(data) {

         if(data["status"] == true){
            location.reload();
         }else{
            helpers.formNoticeManager($('.formAddSearchKeyword'), data);
            helpers.endProcessLoadButton($('.buttonAddSearchKeyword'));
         }

      });

      e.preventDefault();

   });

   $(document).on('click','.loadEditSearchKeyword', function (e) {  

      helpers.openModal("loadContentModal", "small");

      helpers.request({url:"dashboard-search-keyword-load-edit", data: {id:$(this).data("id")}}, function(data) {

         $("#loadContentModal .load-content-container").html(data["content"]);

      });

      e.preventDefault();

   });

   $(document).on('submit','.formEditSearchKeyword', function (e) {  

      $('.formEditSearchKeyword .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonSaveEditSearchKeyword'));
      
      helpers.request({url:"dashboard-search-keywords-edit", data: $(".formEditSearchKeyword").serialize()}, function(data) {

         if(data["status"] == true){

            helpers.hideModal("loadContentModal");
            helpers.showNoticeAnswer(data["answer"], data["type_answer"]);

         }else{
            helpers.formNoticeManager($('.formEditSearchKeyword'), data);
         }

         helpers.endProcessLoadButton($('.buttonSaveEditSearchKeyword'));

      });

      e.preventDefault();

   });

   $(document).on('change','.formAddSearchKeyword select[name=goal_type]', function (e) { 

      var selected = $(this).find('option:selected'); 

      $('.add-search-keyword-container-1,.add-search-keyword-container-2,.add-search-keyword-container-3').hide();

      if(selected.val() == "1"){
         $('.add-search-keyword-container-1').show();
      }else if(selected.val() == "2"){
         $('.add-search-keyword-container-2').show();
      }else if(selected.val() == "3"){
         $('.add-search-keyword-container-3').show();
      }

   });

   $(document).on('change','.formEditSearchKeyword select[name=goal_type]', function (e) { 

      var selected = $(this).find('option:selected'); 

      $('.edit-search-keyword-container-1,.edit-search-keyword-container-2,.edit-search-keyword-container-3').hide();

      if(selected.val() == "1"){
         $('.edit-search-keyword-container-1').show();
      }else if(selected.val() == "2"){
         $('.edit-search-keyword-container-2').show();
      }else if(selected.val() == "3"){
         $('.edit-search-keyword-container-3').show();
      }

   });

});
