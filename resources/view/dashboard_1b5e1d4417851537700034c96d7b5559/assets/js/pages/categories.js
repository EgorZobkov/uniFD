
import Helpers from '../helpers.class.js';

$(document).ready(function () {

   const helpers = new Helpers();
   var sortingIds = [];

   helpers.loadBody(null,function() {

      var el = document.getElementById('sorting-container');
      var sortable = Sortable.create(el, {
         handle: ".handle-sorting",   
         onEnd: function (evt) {

            $(".categories-tr-container").each(function(){
                sortingIds.push($(this).data("id"));
            });

            helpers.request({url:"dashboard-ads-categories-sorting", data: {ids: sortingIds.join(",")}}, function(data) {});

            sortingIds = [];

         },  
      });

   });

   $(document).on('submit','.formAddCategory', function (e) {  

      $('.formAddCategory .form-label-error').hide();

      var form = new FormData($(".formAddCategory")[0]);

      form.append("seo_text", encodeURIComponent($(".formAddCategory textarea[name=seo_text]").val()));

      helpers.startProcessLoadButton($('.buttonAddCategory'));
      
      helpers.request({url:"dashboard-ads-category-add", data: form, contentType: false, processData: false, button: $('.buttonAddCategory')}, function(data) {

         if(data["status"] == true){
            location.reload();
         }else{
            helpers.formNoticeManager($('.formAddCategory'), data);
            helpers.endProcessLoadButton($('.buttonAddCategory'));
         }

      });

      e.preventDefault();

   });   

   $(document).on('submit','.formEditCategory', function (e) {  

      $('.formEditCategory .form-label-error').hide();

      var form = new FormData($(".formEditCategory")[0]);

      form.append("seo_text", encodeURIComponent($(".formEditCategory textarea[name=seo_text]").val()));

      helpers.startProcessLoadButton($('.buttonSaveEditCategory'));
      
      helpers.request({url:"dashboard-ads-category-edit", data: form, contentType: false, processData: false, button: $('.buttonSaveEditCategory')}, function(data) {

         if(data["status"] == true){

            helpers.hideModal("loadContentModal");
            helpers.showNoticeAnswer(data["answer"], data["type_answer"]);

         }else{
            helpers.formNoticeManager($('.formEditCategory'), data);
         }

         helpers.endProcessLoadButton($('.buttonSaveEditCategory'));

      });

      e.preventDefault();

   });

   $(document).on('click','.deleteCategory', function (e) {  

      helpers.deleteByAlert("dashboard-ads-category-delete",{id:$(this).data("id")});

      e.preventDefault();

   });
   
   $(document).on('click','.loadEditCategory', function (e) {  

      helpers.openModal("loadContentModal", "medium", this);

      helpers.request({url:"dashboard-ads-category-load-edit", data: {id:$(this).data("id")}}, function(data) {

         $("#loadContentModal .load-content-container").html(data["content"]);

      });

      e.preventDefault();

   });

   $(document).on('click','.loadTableSubcategories', function (e) {  

      var _this = this;
      var ids = $(this).data("parent-ids").toString();

      if($(this).data("open") == false){

         helpers.request({url:"dashboard-ads-categories-load-subcategories", data: {id:$(this).data("id")}}, function(data) {
               $(_this).parents("tr.categories-tr-container").after(data["content"]);
               $(_this).data("open",true);            
         });

      }else{
         $(_this).data("open",false);

         if(ids.indexOf(",") != "-1"){
            $.each(ids.split(","),function(index,value){
              $(".subcategory-item-"+value).remove().hide(); 
            });            
         }else{
            $(".subcategory-item-"+ids).remove().hide();
         }

      }

      e.preventDefault();

   });

   $(document).on('change','.formAddCategory input[name=price_status]', function (e) {

      if($(this).prop("checked") == true){
         $('.add-category-options-price-container').show();
      }else{
         $('.add-category-options-price-container').hide();
      }

   });

   $(document).on('change','.formAddCategory input[name=paid_status]', function (e) {

      if($(this).prop("checked") == true){
         $('.add-category-options-price-paid-container').show();
      }else{
         $('.add-category-options-price-paid-container').hide();
      }

   });

   $(document).on('change','.formAddCategory input[name=booking_status]', function (e) {

      if($(this).prop("checked") == true){
         $('.add-category-options-booking-container').show();
      }else{
         $('.add-category-options-booking-container').hide();
      }

   });

   $(document).on('change','.formEditCategory input[name=price_status]', function (e) {

      if($(this).prop("checked") == true){
         $('.edit-category-options-price-container').show();
      }else{
         $('.edit-category-options-price-container').hide();
      }

   });

   $(document).on('change','.formEditCategory input[name=paid_status]', function (e) {

      if($(this).prop("checked") == true){
         $('.edit-category-options-price-paid-container').show();
      }else{
         $('.edit-category-options-price-paid-container').hide();
      }

   });

   $(document).on('change','.formEditCategory input[name=booking_status]', function (e) {

      if($(this).prop("checked") == true){
         $('.edit-category-options-booking-container').show();
      }else{
         $('.edit-category-options-booking-container').hide();
      }

   });

   $(document).on('change','.formEditCategory input[name=filter_generation_title]', function (e) {

      if($(this).prop("checked") == true){
         $('.edit-category-template-title-container').show();
      }else{
         $('.edit-category-template-title-container').hide();
      }

   });

   $(document).on('change','.formAddCategory input[name=filter_generation_title]', function (e) {

      if($(this).prop("checked") == true){
         $('.add-category-template-title-container').show();
      }else{
         $('.add-category-template-title-container').hide();
      }

   });

   $(document).on('click','.modal-filter-template-change-category-id', function (e) {  

      var selected = $(this).find('option:selected'); 

      if(selected.val()){
         helpers.request({url:"dashboard-ads-category-load-template-filter-items", data: {id:selected.val()}}, function(data) {

            $(".modal-filter-template-items-list").html(data["content"]).show();

         });
      }else{
         $(".modal-filter-template-items-list").html("").hide();
      }

      e.preventDefault();

   });

});
