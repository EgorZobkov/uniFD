
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

            helpers.request({url:"dashboard-blog-categories-sorting", data: {ids: sortingIds.join(",")}}, function(data) {});

            sortingIds = [];

         },  
      });

   });

   $(document).on('submit','.formAddCategory', function (e) {  

      $('.formAddCategory .form-label-error').hide();

      var form = new FormData($(".formAddCategory")[0]);

      form.append("seo_text", encodeURIComponent($(".formAddCategory textarea[name=seo_text]").val()));

      helpers.startProcessLoadButton($('.buttonAddCategory'));
      
      helpers.request({url:"dashboard-blog-category-add", data: form, contentType: false, processData: false, button: $('.buttonAddCategory')}, function(data) {

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
      
      helpers.request({url:"dashboard-blog-category-edit", data: form, contentType: false, processData: false, button: $('.buttonSaveEditCategory')}, function(data) {

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

      helpers.deleteByAlert("dashboard-blog-category-delete",{id:$(this).data("id")});

      e.preventDefault();

   });
   
   $(document).on('click','.loadEditCategory', function (e) {  

      helpers.openModal("loadContentModal", "medium");

      helpers.request({url:"dashboard-blog-category-load-edit", data: {id:$(this).data("id")}}, function(data) {

         $("#loadContentModal .load-content-container").html(data["content"]);

      });

      e.preventDefault();

   });

   $(document).on('click','.loadTableSubcategories', function (e) {  

      var _this = this;
      var ids = $(this).data("parent-ids").toString();

      if($(this).data("open") == false){

         helpers.request({url:"dashboard-blog-categories-load-subcategories", data: {id:$(this).data("id")}}, function(data) {
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

});
