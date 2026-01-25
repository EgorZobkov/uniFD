
import Helpers from '../helpers.class.js';

$(document).ready(function () {

   const helpers = new Helpers();
   var sortingIds = [];
   var containerItemsFilter;

   helpers.loadBody(null,function() {

      var sortable1 = Sortable.create(document.getElementById('sorting-container'), {
         handle: ".handle-sorting",   
         onEnd: function (evt) {

            $(".filters-tr-container").each(function(){
                sortingIds.push($(this).data("id"));
            });

            helpers.request({url:"dashboard-ads-filters-sorting", data: {ids: sortingIds.join(",")}}, function(data) {});

            sortingIds = [];

         },  
      });

      var sortable2 = Sortable.create(document.getElementById('add-filter-items-container'), {
         handle: ".handle-sorting",     
      });

   });

   $(document).on('submit','.formAddFilter', function (e) {  

      $('.formAddFilter .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonAddFilter'));
      
      helpers.request({url:"dashboard-ads-filter-add", data: $(".formAddFilter").serialize()}, function(data) {

            if(data["status"] == true){
               location.reload();
            }else{
               helpers.formNoticeManager($('.formAddFilter'), data);
               helpers.endProcessLoadButton($('.buttonAddFilter'));
            }

      });

      e.preventDefault();

   });

   $(document).on('click','.buttonAddItemFilter', function (e) {  

      $(this).parents(".filters-items-container").find(".filter-items-container").append('<div class="block-filter-item" ><div class="input-group"><span class="input-group-text"><div class="handle-sorting handle-sorting-move"><i class="ti ti-arrows-sort"></i></div></span><input type="text" class="form-control" name="items[add][]" ><span class="btn btn-icon btn-label-danger waves-effect buttonDeleteItemFilter"><i class="ti ti-trash"></i></span></div></div>');

      e.preventDefault();

   });

   $(document).on('click','.buttonDeleteItemFilter', function (e) {  

      $(this).parents('.block-filter-item').remove().hide();

      e.preventDefault();

   });

   $(document).on('change','.select-filters-type-view', function (e) {  

      var selected = $(this).find('option:selected');

      if(selected.val() == "input_text"){
         $('.filters-items-input-alert').hide(); 
         $('.filters-items-container').hide();
         $('.filters-items-container input').attr("disabled", true);
      }else if(selected.val() == "input"){
         $('.filters-items-input-alert').show();  
         $('.filters-items-container').show();
         $('.filters-items-container input').attr("disabled", false);   
      }else{
         $('.filters-items-input-alert').hide();
         $('.filters-items-container').show();
         $('.filters-items-container input').attr("disabled", false);
      }

   });

   $(document).on('click','.deleteFilter', function (e) {  

      helpers.deleteByAlert("dashboard-ads-filter-delete",{id:$(this).data("id")});

      e.preventDefault();

   });

   $(document).on('submit','.formEditFilter', function (e) {  

      $('.formEditFilter .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonSaveEditFilter'));
      
      helpers.request({url:"dashboard-ads-filter-edit", data: $(".formEditFilter").serialize()}, function(data) {

            if(data["status"] == true){
               helpers.hideModal("loadContentModal");
               helpers.showNoticeAnswer(data["answer"], data["type_answer"]);
            }else{
               helpers.formNoticeManager($('.formEditFilter'), data);
            }

            helpers.endProcessLoadButton($('.buttonSaveEditFilter'));

      });

      e.preventDefault();

   });

   $(document).on('click','.loadEditFilter', function (e) {  

      helpers.openModal("loadContentModal", "medium");

      helpers.request({url:"dashboard-ads-filter-load-edit", data: {id:$(this).data("id")}}, function(data) {

           $("#loadContentModal .load-content-container").html(data["content"]);

           var sortable3 = Sortable.create(document.getElementById('edit-filter-items-container'), {
               handle: ".handle-sorting",     
           });

      });

      e.preventDefault();

   });

   $(document).on('click','.loadAddPodFilter', function (e) {  

      helpers.openModal("loadContentModal", "medium");

      helpers.request({url:"dashboard-ads-filter-load-add-podfilter", data: {id:$(this).data("id")}}, function(data) {

           $("#loadContentModal .load-content-container").html(data["content"]);

           var sortable3 = Sortable.create(document.getElementById('edit-filter-items-container'), {
               handle: ".handle-sorting",     
           });

      });

      e.preventDefault();

   });

   $(document).on('submit','.formAddPodFilter', function (e) {  

      $('.formAddPodFilter .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonAddPodFilter'));
      
      helpers.request({url:"dashboard-ads-filter-add-podfilter", data: $(".formAddPodFilter").serialize()}, function(data) {

         if(data["status"] == true){
            location.reload();
         }else{
            helpers.formNoticeManager($('.formAddPodFilter'), data);
            helpers.endProcessLoadButton($('.buttonAddPodFilter'));
         }

      });

      e.preventDefault();

   });

   $(document).on('change','.select-filter-item-id', function (e) {  

      var selected = $(this).find('option:selected');

      helpers.request({url:"dashboard-ads-filter-load-items-filter", data: {id:$(".formEditFilter input[name=id]").val(), item_id:selected.val()}}, function(data) {

          $(".formEditFilter .filter-items-container").html(data["content"]);

      });

      e.preventDefault();

   });

   $(document).on('click','.loadTableSubfilters', function (e) {  

      var _this = this;
      var ids = $(this).data("parent-ids").toString();

      if($(this).data("open") == false){

         helpers.request({url:"dashboard-ads-filters-load-subfilters", data: {id:$(this).data("id"), category_id: $(".selectFilterCategoryId").find('option:selected').val()}}, function(data) {
               $(_this).parents("tr.filters-tr-container").after(data["content"]);
               $(_this).data("open",true);            
         });

      }else{
         $(_this).data("open",false);

         if(ids.indexOf(",") != "-1"){
            $.each(ids.split(","),function(index,value){
              $(".subfilter-item-"+value).remove().hide(); 
            });            
         }else{
            $(".subfilter-item-"+ids).remove().hide();
         }

      }

      e.preventDefault();

   });

   $(document).on('submit','.formAddFilterLink', function (e) {  

      $('.formAddFilterLink .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonAddFilterLink'));
      
      helpers.request({url:"dashboard-ads-filter-link-add", data: $(".formAddFilterLink").serialize()}, function(data) {

            if(data["status"] == true){
               location.reload();
            }else{
               helpers.formNoticeManager($('.formAddFilterLink'), data);
               helpers.endProcessLoadButton($('.buttonAddFilterLink'));
            }

      });

      e.preventDefault();

   });

   $(document).on('click','.deleteFilterLink', function (e) {  

      helpers.deleteByAlert("dashboard-ads-filter-link-delete",{id:$(this).data("id")});

      e.preventDefault();

   });

   $(document).on('submit','.formEditFilterLink', function (e) {  

      $('.formEditFilterLink .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonSaveEditFilterLink'));
      
      helpers.request({url:"dashboard-ads-filter-link-edit", data: $(".formEditFilterLink").serialize()}, function(data) {

            if(data["status"] == true){
               helpers.hideModal("loadContentModal");
               helpers.showNoticeAnswer(data["answer"], data["type_answer"]);
            }else{
               helpers.formNoticeManager($('.formEditFilterLink'), data);
            }

            helpers.endProcessLoadButton($('.buttonSaveEditFilterLink'));

      });

      e.preventDefault();

   });

   $(document).on('click','.loadEditFilterLink', function (e) {  

      helpers.openModal("loadContentModal", "medium");

      helpers.request({url:"dashboard-ads-filter-link-load-edit", data: {id:$(this).data("id")}}, function(data) {

           $("#loadContentModal .load-content-container").html(data["content"]);

      });

      e.preventDefault();

   });

   $(document).on('click','.buttonInsertListItemsFilter', function (e) {  

      helpers.startProcessLoadButton($('.buttonInsertListItemsFilter'));
      
      helpers.request({url:"dashboard-ads-filter-insert-list-items", data: {list: $(".textareaListItemsFilter").val()}}, function(data) {

            containerItemsFilter.append(data["content"]);

            $(".textareaListItemsFilter").val('');

            helpers.endProcessLoadButton($('.buttonInsertListItemsFilter'));

      });

      e.preventDefault();

   });

   $(document).on('click','.buttonAddListItemsFilter', function (e) {  

      containerItemsFilter = $(this).parents("form").find(".filter-items-container");

      e.preventDefault();

   });

});
