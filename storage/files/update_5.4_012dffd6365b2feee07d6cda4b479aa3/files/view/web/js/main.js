import Helpers from './helpers.class.js';

$(document).ready(function () {

   const helpers = new Helpers();
   var searchTimeout = null;
   var mainFloatingMenuUpScroll = 0;
   var mainFloatingMenuDownScroll = 0;

   helpers.checkFlashNotify();
   helpers.initPhoneMask();

   mainFloatingMenu($(document).scrollTop());
   resizeSubcategoriesAll();

   if($('.advertising-banner-swiper').length){

      $('.advertising-banner-swiper').each(function(){

          var idSlider = 'banner-swiper-' + helpers.generateStr(6);
          $(this).addClass(idSlider);

          new Swiper(document.querySelector('.'+idSlider), {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            autoplay: {
              delay: 3500,
              disableOnInteraction: true,
            },
            pagination: {
              clickable: true,
              el: '.advertising-banner-swiper-pagination',
            },
          });

      });

   }

   if($('.profile-tariffs-swiper').length){
      new Swiper(document.querySelector('.profile-tariffs-swiper'), {
         loop: false,
         slidesPerView: "auto",
         spaceBetween: 15,
         navigation: {
           nextEl: '.profile-tariffs-swiper-next',
           prevEl: '.profile-tariffs-swiper-prev',
         },
      });
   }

   $(document).on('click','.input-phone-countries-change-item', function (e) {

      $(".input-phone-countries-items-container").toggle();

      e.preventDefault();

   });

   $(document).on('click','.input-phone-countries-items-container span', function (e) {

      var item = '<img src="'+$(this).data("icon")+'" /> '+$(this).data("code");

      $(".input-phone-countries-items-container").hide();
      $(".input-phone-countries input").val("");
      $(".input-phone-countries-change-item").html(item);

      if($(this).data("format")){
         $(".input-phone-countries input").attr("data-phone-template", $(this).data("format"));
         $(".input-phone-countries input").attr("placeholder", $(this).data("format"));         
      }else{
         $(".input-phone-countries input").attr("data-phone-template", "");
         $(".input-phone-countries input").attr("placeholder", "");             
      }

      helpers.setPhoneMask(".input-phone-countries input", $(this).data("format"));

      e.preventDefault();

   });

   $(document).on('click','.profile-tariffs-list-item', function (e) {

      $(".profile-tariffs-action-payment").hide();
      $(".profile-tariffs-list-item").removeClass("active");
      $("input[name=tariff_id]").val($(this).data("id"));
      $(this).addClass("active");

      e.preventDefault();

   });

   $(document).on('click','.profile-tariffs-list-item:not(.added)', function (e) {

      $(".profile-tariffs-action-payment").show();
      
      e.preventDefault();

   });

   $(document).on('click','.initOptionsPaymentServiceTariff', function (e) {  

      helpers.startProcessLoadButton($('.initOptionsPaymentServiceTariff'));

      helpers.request({url:"payment-load-option", data: $(".profile-tariffs-form").serialize(), precheck: true, button:$('.initOptionsPaymentServiceTariff')}, function(data) {

         $("#paymentModal .modal-payment-container").html(data["content"]);
         helpers.openModal("paymentModal");
         helpers.endProcessLoadButton($('.initOptionsPaymentServiceTariff'));
         
      });

      e.preventDefault();

   });

   if($('.widget-promo-banners-swiper').length){
      new Swiper(document.querySelector('.widget-promo-banners-swiper'), {
         loop: false,
         slidesPerView: "auto",
         spaceBetween: 10,
      });
   }

   if($('.reviews-media-swiper').length){
      new Swiper(document.querySelector('.reviews-media-swiper'), {
         loop: false,
         slidesPerView: "auto",
         spaceBetween: 10,
      });
   }

   if($('.user-stories-swiper').length){
      new Swiper(document.querySelector('.user-stories-swiper'), {
         spaceBetween: 10,
         loop: false,
         slidesPerView: "auto",
      });
   }

   $(document).on('click', function(e) { 

      if(!$(e.target).closest(".open-header-menu-catalog").length && !$(e.target).closest(".big-catalog-menu-container").length) {
          $(".big-catalog-menu-container").hide();
      }

      if(!$(e.target).closest(".uni-dropdown-name,.action-open-uni-dropdown").length && !$(e.target).closest(".uni-dropdown-content").length) {
          $(".uni-dropdown-content").hide();
      }

      if(!$(e.target).closest(".header-user-dropdown-menu").length && !$(e.target).closest(".header-user-dropdown-menu-box").length) {
          $(".header-user-dropdown-menu-box").hide();
      }

      if(!$(e.target).closest(".live-search-form-input").length && !$(e.target).closest(".live-search-results").length) {
          $(".live-search-results").hide();
      }

      if(!$(e.target).closest(".input-phone-countries-change-item").length && !$(e.target).closest(".input-phone-countries-items-container").length) {
          $(".input-phone-countries-items-container").hide();
      }

      e.stopPropagation();

   });

   $(document).on('click','.splash-notification, .splash-notification-alert', function (e) {  

       $(this).hide();

   });

   $(document).on('click','.openModal', function (e) {  

      helpers.openModal($(this).data("modal-id"), null, this);

      e.preventDefault();

   });

   $(document).on('click','.closeModal', function (e) {  

      helpers.hideModal($(this).parents(".modal").attr('id'), this);

      e.preventDefault();

   });

   $(document).on('click','.actionCookieHide', function (e) {  

       $(".footer-cookie-container").hide();
       $.cookie("cookie-policy", "hide", {expires: 30, path: '/'});

   });

   if($.cookie("cookie-policy") != "hide"){
       setTimeout('$(".footer-cookie-container").fadeIn();', 1000);
   }

   $(document).on('click','.captchaModalImageContainer img', function (e) {  

       helpers.loadCaptcha('.captchaModalImageContainer');

   });

   $(document).on('click','.actionOpenStaticModal', function (e) {  

      helpers.loadModal($(this).data("modal-target"),$(this).data("modal-params"), function(){
         helpers.initPhoneMask();
      },this);    
      
      e.preventDefault();

   });

   $(document).on('click','.actionAdvertisingClick', function (e) {  

      helpers.request({url:"adv-click", data: {code: $(this).data("code")}});
      
   });

   $(document).on('click','.actionItemSearchClick', function (e) {  

      helpers.request({url:"search-item-click", data: {query: $(this).data("query"), link: $(this).attr("href")}});
      
   });

   $(document).on('click','.captchaModalVerifyCode', function (e) {  
      
      var button = $(this);
      var element = this;

      helpers.startProcessLoadButton(button);

      helpers.request({url:"captcha-verify", data: {code:$("input[name=captchaModalInputCode]").val(), captcha_id:$("input[name=captchaModalId]").val()}}, function(data) {

         if(data["status"] == true){
            helpers.hideModal('captchaModal', element);
         }else{
            helpers.showNoticeAnswer(data["answer"]);
         }

         helpers.endProcessLoadButton(button);

      });
      
      e.preventDefault();

   });

   $(document).on('click','.header-user-dropdown-menu', function () {  
      
      $(this).find(".header-user-dropdown-menu-box").toggle();

   });

   $(document).on('click','.dropdown-box-list-nested-toggle > a', function (e) {
        $(this).next().toggle();
        return false;
   });

   $(document).on('click','.my-tabs-item', function (e) {  

       $('.my-tabs-item').removeClass("active");
       $(this).addClass("active");
       $('.my-tabs-content').hide();
       $('.my-tabs-content-'+$(this).data("id")).show();

   });

   $(".big-catalog-menu-content-categories .big-catalog-menu-category-item").on("mouseover", function () {
        var id = $(this).data("id");
        $(".big-catalog-menu-category-item").removeClass("active");
        $(this).addClass("active");
        $(".big-catalog-menu-content-subcategories").hide();
        $('.big-catalog-menu-content-subcategories[data-id-parent="'+id+'"]').show();
   });

   $(document).on('click','.open-header-menu-catalog', function (e) { 

      $('.big-catalog-menu-container').toggle();

   });

   $(document).on('click','.open-header-menu-mobile-catalog', function (e) { 

      $('.big-catalog-menu-mobile-container').toggle();
      $("body").css("overflow", "hidden");

   });

   $(document).on('click','.close-header-menu-mobile', function (e) { 

      $('.big-catalog-menu-mobile-container').hide();
      $("body").css("overflow", "auto");

   });

   $(document).on('click','.open-menu-filters-mobile', function (e) { 

      $('.header-menu-filters-mobile-container').toggle();
      $("body").css("overflow", "hidden");

   });

   $(document).on('click','.close-menu-filters-mobile', function (e) { 

      $('.header-menu-filters-mobile-container').hide();
      $("body").css("overflow", "auto");

   });

   $(document).on('click','.uni-dropdown-name, .action-open-uni-dropdown', function (e) { 

     $(".uni-dropdown .uni-dropdown-content").not($(this).parents(".uni-dropdown").find(".uni-dropdown-content")).hide();
     $(this).parents(".uni-dropdown").find(".uni-dropdown-content").toggle();

   });

   $(document).on('click','.uni-dropdown-content-item', function (e) { 

     $(this).parents(".uni-dropdown").find(".uni-dropdown-content").toggle();

   });

   function resizeSubcategoriesAll(){

      if ($(window).width() <= 992) {
         if($('.widget-categories-or-subcategories a').length > 2){
            $('.widget-categories-or-subcategories-button-all').show();
         }else{
            $('.widget-categories-or-subcategories-button-all').hide();
         }
      }else{
         if($('.widget-categories-or-subcategories a').length > 6){
            $('.widget-categories-or-subcategories-button-all').show();
         }else{
            $('.widget-categories-or-subcategories-button-all').hide();
         }
      }

   }

   $(document).on('click','.widget-categories-or-subcategories-button-all > span', function (e) { 

      $(".widget-categories-or-subcategories-hide").css("max-height","100%");
      $(".widget-categories-or-subcategories-hide").css("height","auto");
      $(".widget-categories-or-subcategories-hide").css("overflow","visible");
      
      $('.widget-categories-or-subcategories-button-all').hide();

   });

   $(document).on({
        mouseenter: function() {
            $(this).parents(".container-item-images").find("img").hide();
            $(this).parents(".container-item-images").find("img[data-key="+$(this).data("key")+"]").show();
        }
   }, '.container-item-images-indicator span');

   $(document).on('click','.initOptionsPayment', function (e) {  

      helpers.startProcessLoadButton($('.initOptionsPayment'));

      helpers.request({url:"payment-load-option", data: {params: $(this).data("params")}, precheck: true, button:$('.initOptionsPayment')}, function(data) {

         $("#paymentModal .modal-payment-container").html(data["content"]);
         helpers.openModal("paymentModal");
         helpers.endProcessLoadButton($('.initOptionsPayment'));
         
      });

      e.preventDefault();

   });

   $(document).on('click','.initTargetPayment', function (e) {  

      helpers.startProcessLoadButton($('.initTargetPayment'));

      helpers.request({url:"payment-target", data: $(".option-payment-form").serialize(), precheck: true, button:$('.initTargetPayment')}, function(data) {

         if(data["status"]){
            if(data["link"] != undefined){
                location.href = data["link"];
            }else{
                location.reload();
            }
         }else{
            helpers.showNotice("error", data["answer"]);
            helpers.endProcessLoadButton($('.initTargetPayment'));
         }
  
      });

      e.preventDefault();

   });

   $(document).on('click','.option-payment-item-change', function (e) {  

      $('.option-payment-item-change').removeClass("active");
      $(this).addClass("active");
      $('.option-payment-item-change input[name=payment_id]').attr("checked", false);
      $(this).find("input[name=payment_id]").attr("checked", true);

      e.preventDefault();

   });

   $(document).on('click','.actionManageFavorite', function (e) {  
      
      var _this = this;

      helpers.request({url:"profile-favorite-add", data: {id: $(_this).data("id")}, precheck: true, button:$('.actionManageFavorite')}, function(data) {

         if(data["status"] == true){
             $('.actionManageFavorite[data-id='+$(_this).data("id")+']').html('<i class="ti ti-heart-filled"></i>');
         }else{
             $('.actionManageFavorite[data-id='+$(_this).data("id")+']').html('<i class="ti ti-heart"></i>');
         }

      });
      
      e.preventDefault();

   });

   $(document).on('click','.actionAddUserToBlacklist', function (e) {  
      
      var _this = this;
      
      helpers.request({url:"profile-blacklist-add", data: {id:$(this).data("id")}}, function(data) {

         helpers.showNoticeAnswer(data["answer"]);
         $(_this).html(data["label"]);

      });
      
      e.preventDefault();

   });

   $(document).on('click','.actionSubscribeUser', function (e) {  
      
      var id = $(this).data("id");

      helpers.startProcessLoadButton($('.actionSubscribeUser'));
      
      helpers.request({url:"profile-subscribe", data: {id:id}, precheck: true, button:$('.actionSubscribeUser')}, function(data) {

         helpers.showNoticeAnswer(data["answer"]);
         $('.actionSubscribeUser[data-id="'+id+'"]').html(data["label"]);
         helpers.endProcessLoadButton($('.actionSubscribeUser'));

      });
      
      e.preventDefault();

   });

   $(document).on('click','.actionSendAdComplaint', function (e) {  
      
      helpers.startProcessLoadButton($('.actionSendAdComplaint'));

      helpers.request({url:"ad-add-complaint", data: $('.modal-ad-complain-form').serialize(), precheck: true, button:$('.actionSendAdComplaint')}, function(data) {

         if(data["status"] == true){
            helpers.showNoticeAnswer(data["answer"]);
            helpers.hideModal("adComplainModal");
         }else{
            helpers.showNoticeAnswer(data["answer"]);
         }

         helpers.endProcessLoadButton($('.actionSendAdComplaint'));

      });
      
      e.preventDefault();

   });

   $(document).on('click','.actionSendUserComplaint', function (e) {  
      
      helpers.startProcessLoadButton($('.actionSendUserComplaint'));

      helpers.request({url:"user-add-complaint", data: $('.modal-user-complain-form').serialize(), precheck: true, button:$('.actionSendUserComplaint')}, function(data) {

         if(data["status"] == true){
            helpers.showNoticeAnswer(data["answer"]);
            helpers.hideModal("userComplainModal");
         }else{
            helpers.showNoticeAnswer(data["answer"]);
         }

         helpers.endProcessLoadButton($('.actionSendUserComplaint'));

      });
      
      e.preventDefault();

   });

   $(document).on('click','.copyToClipboard', function (e) {  
      
      helpers.copyToClipboard($(this).data("link"));
      
      e.preventDefault();

   });   

   $(document).on('click','.actionSendResponseReview', function (e) {  

      helpers.startProcessLoadButton($('.actionSendResponseReview'));
      
      helpers.request({url:"review-response-create", data: $('.modal-response-review-form').serialize()}, function(data) {

         if(data["status"] == true){
            location.reload();
         }else{
            helpers.showNoticeAnswer(data["answer"]);
            helpers.endProcessLoadButton($('.actionSendResponseReview'));
         }

      });
      
      e.preventDefault();

   });

   $(document).on('click','.actionDeleteReview', function (e) {  

      helpers.deleteByAlert("review-delete",{id:$(this).data("id")});
      
      e.preventDefault();

   });

   $(document).on('input click','.live-search-form-input', function (e) {  

      var _this = this;
      var query = $(this).val();

      if (searchTimeout != null) {
        clearTimeout(searchTimeout);
      }

        searchTimeout = setTimeout(function() {
          searchTimeout = null;
          helpers.request({url:"search-items-combined", data: {query: query}}, function(data) {
 
             if(data["status"]){
                $(_this).parents(".live-search-container").find(".live-search-results").html(data["answer"]).fadeIn(100);
             }else{
                $(_this).parents(".live-search-container").find(".live-search-results").html("").hide();
             }

          });
        }, 200);

      e.preventDefault();

   });

   $(document).on('click','.actionCheckVerifyCodeContact', function (e) {

      var element = this;

      helpers.startProcessLoadButton($('.actionCheckVerifyCodeContact'));

      helpers.request({url:"check-code-verify-contact", data: {code: $('input[name=verify_code_contact]').val(), email: $('input[name=verify_email_contact]').val(), phone: $('input[name=verify_phone_contact]').val()}}, function(data) {

        if(data["status"]){
            helpers.hideModal("verificationCodeModal", element);
            $(".actionSendVerifyCodeEmailContainer").hide();
            $(".actionSendVerifyCodePhoneContainer").hide();
        }else{
            if(data["captcha"]){  
               helpers.openCaptcha(data["captcha_id"], element);            
            }else{
               $(".verify-code-label-error").html(data["answer"]).show();
            }
        }

        helpers.endProcessLoadButton($('.actionCheckVerifyCodeContact'));

      });

      e.preventDefault();

   });

   function mainFloatingMenu(scroll){

     if(scroll <= 150){
         $(".main-floating-menu").css('transform', 'translate3d(0px, 0px, 0px)');
     }else{

         if(mainFloatingMenuUpScroll){

             if(scroll <= mainFloatingMenuUpScroll){
               $(".main-floating-menu").css('transform', 'translate3d(0px, 0px, 0px)');
               mainFloatingMenuUpScroll = parseInt(scroll)-150;                 
             }

         }else{
             mainFloatingMenuUpScroll = parseInt(scroll)-150;
         }            

         if(scroll > mainFloatingMenuDownScroll){
           $(".main-floating-menu").css('transform', 'translate3d(0px, '+($(".main-floating-menu").outerHeight()+30)+'px, 0px)');
           mainFloatingMenuUpScroll = parseInt(scroll)-150;
         }

     }

     mainFloatingMenuDownScroll = scroll;

   }

   $(window).scroll(function () {

       mainFloatingMenu($(this).scrollTop());

   });

   $(window).resize(function(){

      resizeSubcategoriesAll();

   });

});