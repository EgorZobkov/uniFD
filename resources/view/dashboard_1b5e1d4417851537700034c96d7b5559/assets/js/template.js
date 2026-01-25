import Helpers from './helpers.class.js';

$(document).ready(function () {

   const helpers = new Helpers();

   var searchTimeout = null;
   var layout_options = [];

   layout_options["style"] = "light-style";
   layout_options["layout"] = "layout-compact";
   layout_options["menu-fixed"] = "layout-menu-fixed";
   layout_options["navbar-fixed"] = "layout-navbar-fixed";
   layout_options["menu-collapsed"] = $(".menu-vertical").data("status") == "hidden" ? "layout-menu-collapsed" : "";
   layout_options["menu-hover"] = "layout-menu-hover";

   if($(".selectpicker").length) $(".selectpicker").selectpicker("render");

   function buildOptions(){

      var item = [];

      for (var name in layout_options) {
          item.push(layout_options[name]);
      }

      return item.join(" ");

   }

   $(document).on('click','.openModal', function (e) {  

      helpers.openModal($(this).data("modal-id"), null, this);

      e.preventDefault();

   });

   $(document).on('click','.closeModal', function (e) {  

      helpers.hideModal($(this).parents(".modal").attr('id'), this);

      e.preventDefault();

   });

   function addToFavorites(routeName=null, pageName=null, pageIcon=null){

    helpers.request({url:"dashboard-system-add-to-favorites", data: {route_name: routeName, page_name: pageName, page_icon: pageIcon},dataType: "json",cache: false}, function(data) {

      $(".header-favorites-container").html(data["favorites"]);

      if(data["status"] == "added"){
        $(".template-add-to-favorites").html('<span class="ti ti-heart-filled"></span>');
      }else{
        $(".template-add-to-favorites").html('<span class="ti ti-heart-plus"></span>');
      }

    });

   }

   function deleteFavorite(id=null){

    helpers.request({url:"dashboard-system-delete-favorite", data: {id: id}}, function(data) {

      $(".header-favorites-container").html(data["favorites"]);

    });

   }

   function collapsedSidebar(status=1){
      helpers.request({url:"dashboard-system-collapsed-sidebar",data: {status: status},cache: false});
   }

   function formFilters(){
       return $.param($('.formControlFilters').serializeArray().filter(function(el) {
           return $.trim(el.value);
       }));  
   }

   function setFiltersUrl(){
       var hashes = window.location.href.split('?');
       if(formFilters()){
         history.pushState("", "", hashes[0]+"?"+formFilters());
       }else{
         history.pushState("", "", hashes[0]);
       }
   }

   if($('.menu-inner-list-container').length){
      const menu = new PerfectScrollbar('.menu-inner-list-container');
   }
   if($('.dropdown-shortcuts-list').length){
      const favorites = new PerfectScrollbar('.dropdown-shortcuts-list');
   }
   if($('.header-search-results-container').length){
      const search = new PerfectScrollbar('.header-search-results-container');
   }

   $(document).on('click','.sidebar-menu-toggle-icon', function (e) {  

      if(layout_options["menu-collapsed"] == "layout-menu-collapsed"){
         layout_options["menu-collapsed"] = "";
         layout_options["menu-hover"] = "";
         $('.layout-menu').data('status', 'visible');
         $(this).attr('class', 'ti ti-circle-dot sidebar-menu-toggle-icon d-none d-xl-block ti-sm align-middle');
         collapsedSidebar(0);
      }else{
         layout_options["menu-collapsed"] = "layout-menu-collapsed";
         layout_options["menu-hover"] = "layout-menu-hover";
         $('.layout-menu').data('status', 'hidden');
         $(this).attr('class', 'ti ti-circle sidebar-menu-toggle-icon d-none d-xl-block ti-sm align-middle');
         collapsedSidebar(1);
      }

      $("html").attr("class", buildOptions());

   });  

   $('body').on('mouseenter', `.layout-menu`, function () {
        if($("html").attr('class').indexOf('layout-menu-collapsed') != -1){
           $('.layout-menu').data('status', 'visible');
           layout_options["menu-hover"] = "layout-menu-hover";
           $("html").attr("class", buildOptions());
        }
   }).on('mouseleave', `.layout-menu`, function () {
        if($("html").attr('class').indexOf('layout-menu-hover') != -1){
           $('.layout-menu').data('status', 'hidden');
           layout_options["menu-hover"] = "";
           $("html").attr("class", buildOptions());
        }
   })

   $(document).on('click','.open-mobile-navbar', function (e) {  

        $('.layout-menu').data('status', 'visible');
        $("html").attr("class", "light-style layout-navbar-fixed layout-compact layout-menu-100vh layout-menu-fixed layout-menu-expanded");

   });

   $(document).on('click','.close-mobile-navbar', function (e) {  

        $('.layout-menu').data('status', 'visible');
        $("html").attr("class", buildOptions());

   });

   $(document).on('click','.menu-item', function (e) {  

      if($(this).attr("class") == "menu-item open"){
         $(this).removeClass('open');
      }else{
         $('.menu-inner .menu-item').removeClass('open');
         $(this).addClass('open');
      }

   }); 

   $(document).on('click','.select-all-checkbox', function (e) {

      if($(this).prop("checked") == true){
         $('.container-all-checkbox input[type=checkbox]').prop("checked", true);
      }else{
         $('.container-all-checkbox input[type=checkbox]').prop("checked", false);
      }

   });

   $(document).on('click','.action-generate-password', function (e) {

      $('.input-generate-password').val(helpers.generateStr(20));

   });

   $(document).on('click','.template-add-to-favorites', function (e) {

      addToFavorites($(this).data("route-name"),$(this).data("page-name"),$(this).data("page-icon"));

   });

   $(document).on('click','.template-delete-favorite', function (e) {

      deleteFavorite($(this).data("id"));

   });

   $(document).on('click','.formCustomizeTemplate .form-check', function (e) {  

      $(this).parents('.template-customize-styles-options').find('.form-check').removeClass("checked");
      $(this).parents('.template-customize-styles-options').find('input').prop("checked", false);
      $(this).addClass("checked");
      $(this).find('input').prop("checked", true);

      e.preventDefault();

   });

   $(document).on('submit','.formCustomizeTemplate', function (e) {  

      helpers.startProcessLoadButton($('.buttonSaveOffcanvasCustomizeTemplate'));

      helpers.request({url:"dashboard-system-customize-template",data: $(".formCustomizeTemplate").serialize(),cache: false}, function(data) {
         location.reload();
      });

      e.preventDefault();

   });

   $(document).on('input','.inTranslite', function (e) {

      helpers.translite($(this).val(), $(".outTranslite"));

   });

   $(document).on('change submit','.formControlDefaultFilters', function (e) {  

      setFiltersUrl();

      location.reload();

      e.preventDefault();

   });   

   $(document).on('submit','.formControlFilters', function (e) {  

      setFiltersUrl();

      location.reload();

      e.preventDefault();

   });
   
   $(document).on('click','.formControlFiltersClear', function (e) {  

      $('.formControlFilters .form-filter-select').val("");
      $('.formControlFilters .form-filter-input').val("");
      $('.formControlFilters .form-filter-check').prop("checked", false);

      setFiltersUrl();
      location.reload();

      e.preventDefault();

   });

   $(document).on('click','.container-input-tag-delete', function (e) {  

      $(this).parents(".container-input-tag").remove().hide();

   });

   $(document).on('click','.container-live-search-results-item', function (e) {  

      $(".container-live-search-results").hide();

   });

   $(document).on('click', function(e) { 

      if(!$(e.target).closest(".container-live-search-results").length && !$(e.target).closest(".input-live-search-cities").length && !$(e.target).closest(".input-live-search-users").length) {
         $(".container-live-search-results").hide();
      }

      if(!$(e.target).closest(".uni-dropdown-name,.action-open-uni-dropdown").length && !$(e.target).closest(".uni-dropdown-content").length) {
          $(".uni-dropdown-content").hide();
      }

      e.stopPropagation();

   });

   $(document).on('change','.actionAllCheckboxItems', function (e) { 
       if($(this).prop("checked") == false){ $(".formItemsList input.itemCheckboxItem").prop("checked", false); $(".actionsWithSelectedItems").hide(); $(".control-filters-container").show(); } else { $(".formItemsList input.itemCheckboxItem").prop("checked", true); $(".actionsWithSelectedItemsCount").html($(".formItemsList input.itemCheckboxItem:checked").length); $(".actionsWithSelectedItems").show(); $(".control-filters-container").hide(); }
   });    

   $(document).on('change','.formItemsList input.itemCheckboxItem', function (e) {
       if($(this).prop("checked") == false){ if($(".formItemsList input.itemCheckboxItem:checked").length == 0){ $(".actionsWithSelectedItems").hide(); $(".control-filters-container").show(); }else{ $(".actionsWithSelectedItemsCount").html($(".formItemsList input.itemCheckboxItem:checked").length); } } else { $(".actionsWithSelectedItemsCount").html($(".formItemsList input.itemCheckboxItem:checked").length); $(".actionsWithSelectedItems").show();  $(".control-filters-container").hide(); }
   });

   $(document).on('click','.header-search-toggler', function (e) {
       $(".layout-navbar").removeClass("layout-navbar-index-active");
       $(".layout-navbar").addClass("layout-navbar-index-active");
       $(".header-search-toggler-wrapper, .header-navbar-menu-icons").hide();
       $(".ui-search-screen, .header-search-container").show();
       $(".layout-mobile-menu-toggle").hide();
       $("body").css("overflow", "hidden");
   });

   $(document).on('click','.header-search-toggler-close, .ui-search-screen', function (e) {
      $(".layout-navbar").removeClass("layout-navbar-index-active");
       $(".header-search-toggler-wrapper, .header-navbar-menu-icons").show();
       $(".ui-search-screen, .header-search-container").hide();
       $(".layout-mobile-menu-toggle").show();
       $("body").css("overflow", "auto");
   });

   $(document).on('click','.password-reveal-toggle', function (e) {
      if($(this).parents(".input-group").find("input").attr("type") == "password"){
         $(this).parents(".input-group").find("input").attr("type", "text");
         $(this).html('<i class="ti ti-eye"></i>');
      }else{
         $(this).parents(".input-group").find("input").attr("type", "password");
         $(this).html('<i class="ti ti-eye-off"></i>');
      }
   });

   $(document).on('submit','.formAuthUniId', function (e) {  

      helpers.startProcessLoadButton($('.actionAuthUniId'));

      helpers.request({url:"dashboard-uniid-auth", data: $(".formAuthUniId").serialize()}, function(data) {

         if(data["status"] == true){
            location.reload();
         }else{
            helpers.showNoticeAnswer(data["answer"]);
         }

         helpers.endProcessLoadButton($('.actionAuthUniId'));

      });

      e.preventDefault();

   });

   $(document).on('click','.actionLogoutUniId', function (e) {  

      helpers.startProcessLoadButton($('.actionLogoutUniId'));

      helpers.request({url:"dashboard-uniid-logout"}, function(data) {

         location.reload();

      });

      e.preventDefault();

   });

   $(document).on('click','.copyToClipboard', function (e) {  

      helpers.copyToClipboard($(this).html());

   });

   var filemanagerContainer;

   $(document).on('click','.filemanager-frontend-change', function (e) {  

      var _this = this;

      helpers.startProcessLoadButton($(_this));
      helpers.openModal("fileManagerModal",null,this);

      filemanagerContainer = $(this).parents(".filemanager-frontend");

      helpers.request({url:"dashboard-filemanager-load-files",data: {path: $(this).data("path")}}, function(data) {

         $("#fileManagerModal .load-content-container").html(data["content"]);

         helpers.endProcessLoadButton($(_this));

      });

      e.preventDefault();

   });

   $(document).on('click','.filemanager-backend-file-item', function (e) {  

      filemanagerContainer.find(".filemanager-frontend-container").html(`
         <span class="filemanager-frontend-item-delete" ><i class="ti ti-trash-x"></i></span>
         <img src="`+$(this).data("path")+`" class="image-autofocus" >
      `).show();

      filemanagerContainer.find("input").val($(this).data("clear-path"));

      helpers.hideModal("fileManagerModal",this);

      e.preventDefault();

   });

   $(document).on('click','.filemanager-frontend-item-delete', function (e) {  

      $(this).parents(".filemanager-frontend").find("input").val("");
      $(this).parents(".filemanager-frontend").find(".filemanager-frontend-container").html("").hide();

      e.preventDefault();

   });

   $(document).on('click','.filemanager-backend-area-add', function (e) {

      $(".filemanager-backend-input-upload").click();     

      e.preventDefault();

   });

   $(document).on('change','.filemanager-backend-input-upload', function (e) {  

      helpers.showUiLoadingScreen();

      var form = new FormData($(".filemanager-backend-form")[0]);

      helpers.request({url:"dashboard-filemanager-upload-files", data: form, contentType: false, processData: false}, function(data) {

         helpers.request({url:"dashboard-filemanager-load-files"}, function(data) {

            $("#fileManagerModal .load-content-container").html(data["content"]);
            helpers.hideUiLoadingScreen();

         });         

      });      

      e.preventDefault();

   });

   $(document).on('click','.filemanager-backend-file-delete', function (e) { 

      helpers.showUiLoadingScreen();

      helpers.request({url:"dashboard-filemanager-delete-file", data: {name: $(this).data("name")}}, function(data) {

         helpers.request({url:"dashboard-filemanager-load-files"}, function(data) {

            $("#fileManagerModal .load-content-container").html(data["content"]);
            helpers.hideUiLoadingScreen();

         });         

      });      

      return false; 

      e.preventDefault();

   });

   $(document).on('change','.select-change-reason-blocking', function (e) {  

      var selected = $(this).find('option:selected');

      if(selected.val() == "other"){
         $(".container-comment-reason-blocking").show();
      }else{
         $(".container-comment-reason-blocking").hide();
      }

   });

   $(document).on('click','.uni-dropdown-name, .action-open-uni-dropdown', function (e) { 

     $(".uni-dropdown .uni-dropdown-content").not($(this).parents(".uni-dropdown").find(".uni-dropdown-content")).hide();
     $(this).parents(".uni-dropdown").find(".uni-dropdown-content").toggle();

   });

   $(document).on('click','.uni-dropdown-content-item', function (e) { 

     $(this).parents(".uni-dropdown").find(".uni-dropdown-content").toggle();

   });

   $(document).on('input click','.header-search-input', function (e) {  

      var query = $(this).val();

      if (searchTimeout != null) {
        clearTimeout(searchTimeout);
      }

      if($(this).val().length != 0){
        searchTimeout = setTimeout(function() {
          searchTimeout = null;
          helpers.request({url:"dashboard-search", data: {query: query}}, function(data) {
 
             if(data["status"]){
                $(".header-search-results-container").html(data["answer"]).fadeIn(100);
             }else{
                $(".header-search-results-container").html("").hide();
             }

          });
        }, 200);
      }else{
          $(".header-search-results-container").html("").hide();
      }

      e.preventDefault();

   });

   $(function(){ 
      
      helpers.checkFlashNotify();
      helpers.initCountryPhoneInput();

   });

});
