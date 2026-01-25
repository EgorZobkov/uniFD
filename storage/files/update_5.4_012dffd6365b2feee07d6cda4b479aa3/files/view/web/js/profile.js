import Helpers from './helpers.class.js';

$(document).ready(function () {

   const helpers = new Helpers();
   var searchTimeout = null;
   var searchContainer = null;
   var checkVerifyPhoneIntervalId;

   loadReports();
   bonusModal();

   function checkVerifyPhone(phone){

      checkVerifyPhoneIntervalId = setInterval(function(){
         
         helpers.request({url:"check-verify-phone", data: {phone: phone}}, function(data) {

            if(data["status"] == true){

               helpers.hideModal("verificationCodeModal");
               $(".actionSendVerifyCodeEmailContainer").hide();
               $(".actionSendVerifyCodePhoneContainer").hide();

               clearInterval(checkVerifyPhoneIntervalId);

            }

         });         

      }, 3000);

   }

   function loadReports(){

      if($('.profile-statistics-chart').length){

         helpers.request({url:"profile-statistics-load-data-chart", data:{item_id:helpers.urlParamValue("item_id"),month:helpers.urlParamValue("month"),year:helpers.urlParamValue("year")}}, function(data) {

            var monthReportsConfig = {
                series: data,
                chart: {
                height: 270,
                type: 'area',
                 toolbar: {
                   show: false
                 }
              },
              dataLabels: {
                enabled: false
              },
              stroke: {
                curve: 'smooth',
                width: 1,
              },
              xaxis: {
                type: 'datetime',
                labels: {
                  formatter: function (value) {
                     const formatter = new Intl.DateTimeFormat(helpers.translate.locale(), { day: '2-digit', month: 'short' });
                     const formattedDate = formatter.format(value);
                     return formattedDate 
                     }, 
                 }
              },
              yaxis: {
                tickAmount: 5,
                labels: {
                 style: {
                   color: '#a5a3ae',
                 },
                 formatter: function (val) {
                     return val;
                 }
                }
              },
              legend: {
                show: false,
              },
              tooltip: {
                x: {
                      format: 'dd.MM.yyyy'
                   },
                y: {
                  formatter: function (val) {
                    return val;
                  }
                }      
               },
           };

           var monthReports = new ApexCharts(document.querySelector("#profile-statistics-chart"), monthReportsConfig);
           monthReports.render();

         });

      }

   }

   function bonusModal(){
      if(window.location.hash == "#bonus"){
         helpers.openModal("profileRegistrationBonusModal");
         var hashes = window.location.href.split('#');
         history.pushState("", "", hashes[0]);
      }
   }

   $(document).on('click','.option-payment-item-change-wallet', function (e) {  

      $('.option-payment-item-change-wallet').removeClass("active");
      $(this).addClass("active");
      $(".profile-wallet-payment-form input[name=payment_id]").val($(this).data("id"));

      e.preventDefault();

   });

   $(document).on('submit','.profile-wallet-payment-form', function (e) {  

      helpers.startProcessLoadButton($('.profile-wallet-payment-action-replenishment'));

      helpers.request({url:"payment-wallet", data: $(".profile-wallet-payment-form").serialize(), precheck: true, button:$('.profile-wallet-payment-action-replenishment')}, function(data) {

         if(data["status"]){
            if(data["link"] != undefined){
                location.href = data["link"];
            }else{
                location.reload();
            }
         }else{
            helpers.showNoticeAnswer(data["answer"]);
            helpers.endProcessLoadButton($('.profile-wallet-payment-action-replenishment'));
         }
  
      });

      e.preventDefault();

   });

   $(document).on('submit','.profile-verification-form', function (e) {  

      helpers.startProcessLoadButton($('.actionSendUserVerification'));

      helpers.request({url:"profile-verification-send", data: $(".profile-verification-form").serialize(), precheck: true, button:$('.actionSendUserVerification')}, function(data) {

         if(data["status"]){
            location.reload();
         }else{
            helpers.showNoticeAnswer(data["answer"]);
            helpers.endProcessLoadButton($('.actionSendUserVerification'));
         }
  
      });

      e.preventDefault();

   });

   $(document).on('submit','.profile-settings-form', function (e) {  

      helpers.startProcessLoadButton($('.actionSettingsSaveEditProfile'));

      $('.profile-settings-form .form-label-error').hide();

      helpers.request({url:"profile-settings-edit", data: $(".profile-settings-form").serialize(), precheck: true, button:$('.actionSettingsSaveEditProfile')}, function(data) {

         if(data["status"]){
            helpers.showNoticeAnswer(data["answer"]);
         }else{
            helpers.formNoticeManager($('.profile-settings-form'), data);
         }

         helpers.endProcessLoadButton($('.actionSettingsSaveEditProfile'));
  
      });

      e.preventDefault();

   });

   $(document).on('click','.actionSettingsDeleteProfile', function (e) {  

      helpers.deleteByAlert("profile-settings-delete");

      e.preventDefault();

   });

   $(document).on('click','.actionProfileDeleteSearch', function (e) {  

      helpers.deleteByAlert("profile-searches-delete", {id: $(this).data("id")});

      e.preventDefault();

   });

   $(document).on('click','.actionProfileDeleteRenewal', function (e) {  

      helpers.deleteByAlert("profile-renewal-delete", {id: $(this).data("id")});

      e.preventDefault();

   });

   $(document).on('click','.actionChangeUserAvatar', function (e) {

      $(".userAttachAvatarInput").remove();

      $("body").append('<input type="file" accept=".jpg,.jpeg,.png" style="display: none;" class="userAttachAvatarInput">');

      $(".userAttachAvatarInput").click();

      e.preventDefault(); 

   });

   $(document).on('change','.userAttachAvatarInput', function (e) { 

      var formData = new FormData();

      formData.append('attach_files', $(this)[0].files[0]);

      helpers.request({url:"profile-upload-avatar", data: formData, contentType: false, processData: false}, function(data) { 

         if(data["status"] == true){
            location.reload();
         }else{
            helpers.showNoticeAnswer(data["answer"]);
            $(this).val("");
         }

      });

      e.preventDefault(); 

   });

   $(document).on('click','.actionSettingsSaveEditProfilePassword', function (e) {  

      helpers.startProcessLoadButton($('.actionSettingsSaveEditProfilePassword'));

      $('.profile-settings-password-form .form-label-error').hide();

      helpers.request({url:"profile-settings-edit-password", data: $(".profile-settings-password-form").serialize(), precheck: true, button:$('.actionSettingsSaveEditProfilePassword')}, function(data) {

         if(data["status"]){
            helpers.showNoticeAnswer(data["answer"]);
            $('.modal').modal('hide');
         }else{
            helpers.formNoticeManager($(".profile-settings-password-form"), data);
         }

         helpers.endProcessLoadButton($('.actionSettingsSaveEditProfilePassword'));
  
      });

      e.preventDefault();

   });

   $(document).on('change','.profile-settings-form input[name=user_status]', function (e) {  

      if($(this).val() == 2){
         $(".profile-settings-section-item-organization").show();
      }else{
         $(".profile-settings-section-item-organization").hide();
      }

      e.preventDefault();

   });

   $(document).on('click','.actionSendVerifyCodeEmail', function (e) {

      var element = this;

      $('.form-label-error').hide();

      helpers.startProcessLoadButton($('.actionSendVerifyCodeEmail'));

      helpers.request({url:"send-code-verify-contact", data: {email: $('.profile-settings-form input[name=email]').val()}}, function(data) {

            if(data["status"]){

                helpers.loadModal("verificationCode", {email:$('.profile-settings-form input[name=email]').val()}, null, element);

            }else{
                if(data["captcha"]){
                   helpers.openCaptcha(data["captcha_id"], element);                
                }else if(data["answer"]){
                   helpers.showNoticeAnswer(data["answer"]);                
                }
            }

            helpers.endProcessLoadButton($('.actionSendVerifyCodeEmail'));

      });

      e.preventDefault();

   });

   $(document).on('click','.actionSendVerifyCodePhone', function (e) {

      var element = this;
      var call_phone = null;

      $('.form-label-error').hide();

      helpers.startProcessLoadButton($('.actionSendVerifyCodePhone'));

      helpers.request({url:"send-code-verify-contact", data: {phone: $('.profile-settings-form input[name=phone]').val()}}, function(data) { 

            if(data["status"]){

                 call_phone = data["call_phone"];

                 helpers.loadModal("verificationCode", {phone:$('.profile-settings-form input[name=phone]').val()}, function(data) {
                     if(call_phone){
                         $(".verify-call-phone-container").html(call_phone);
                         checkVerifyPhone($('.profile-settings-form input[name=phone]').val());
                     }
                 },element);

            }else{
                if(data["captcha"]){  
                   helpers.openCaptcha(data["captcha_id"], element);            
                }else if(data["answer"]){
                   helpers.showNoticeAnswer(data["answer"]);                
                }
            }

            helpers.endProcessLoadButton($('.actionSendVerifyCodePhone'));

      });

      e.preventDefault();

   });


   $(document).on('input click','.profile-settings-form input[name=email]', function (e) {

      helpers.request({url:"check-verify-contact", data: {email: $('.profile-settings-form input[name=email]').val()}}, function(data) { 

        if(data["status"]){
            $(".actionSendVerifyCodeEmailContainer").show();
        }else{
            $(".actionSendVerifyCodeEmailContainer").hide();
        }

      });

      e.preventDefault();

   });

   $(document).on('input click','.profile-settings-form input[name=phone]', function (e) {

      helpers.request({url:"check-verify-contact", data: {phone: $('.profile-settings-form input[name=phone]').val()}}, function(data) { 

        if(data["status"]){
            $(".actionSendVerifyCodePhoneContainer").show();
        }else{
            $(".actionSendVerifyCodePhoneContainer").hide();
        }

      });

      e.preventDefault();

   });

   $(document).on('input','.user-statistics-items-search', function (e) {  

      if (searchTimeout != null) {
        clearTimeout(searchTimeout);
      }

      if(!searchContainer){
        searchContainer = $(".user-items-container").html();
      }

      if($(this).val().length >= 2){
        searchTimeout = setTimeout(function() {
          searchTimeout = null;
          helpers.request({url:"profile-statistics-search-user-items", data: {query: $('.user-statistics-items-search').val()}}, function(data) {

             $(".user-items-container").html(data["answer"]);

          });
        }, 200);
      }else{
        $(".user-items-container").html(searchContainer);
      }

      e.preventDefault();

   });

   $(document).on('change','.profile-settings-form input[name=notifications_method]', function (e) {  

      if($(this).val() == "telegram"){
         $(".profile-settings-section-notifications-method-telegram").show();
      }else{
         $(".profile-settings-section-notifications-method-telegram").hide();
      }

      e.preventDefault();

   });

   $(document).on('submit','.profile-statistics-dates-form', function (e) {  

      helpers.setParamsFormUrl('.profile-statistics-dates-form');

      location.reload();

      e.preventDefault();

   });

   $(document).on('click','.actionClearProfileStatisticsDates', function (e) {  

      $(".profile-statistics-dates-form input[name=date_start]").val("");
      $(".profile-statistics-dates-form input[name=date_end]").val("");

      helpers.setParamsFormUrl('.profile-statistics-dates-form');

      location.reload();

      e.preventDefault();

   });

   $(document).on('click','.actionAddPaymentScore', function (e) {  

      helpers.startProcessLoadButton($('.actionAddPaymentScore'));

      helpers.request({url:"profile-settings-payment-score-add", data: {score: $("input[name=payment_score]").val()}, precheck: true, button:$('.actionAddPaymentScore')}, function(data) {

         if(data["status"] == true){
            location.reload();
         }else{
            helpers.showNoticeAnswer(data["answer"]);
         }

         helpers.endProcessLoadButton($('.actionAddPaymentScore'));
  
      });

      e.preventDefault();

   });

   $(document).on('click','.actionDeletePaymentScore', function (e) {  

      helpers.request({url:"profile-settings-payment-score-delete", data: {id: $(this).data("id")}, precheck: true, button:$('.actionDeletePaymentScore')}, function(data) {

         if(data["status"] == true){
            location.reload();
         }else{
            helpers.showNoticeAnswer(data["answer"]);
         }

      });

      e.preventDefault();

   });

   $(document).on('click','.actionAddDefaultPaymentScore', function (e) {  

      helpers.request({url:"profile-settings-payment-score-default", data: {id: $(this).data("id")}, precheck: true, button:$('.actionAddDefaultPaymentScore')});

      $(".actionAddDefaultPaymentScore i").removeClass("active-yellow");
      $(".actionAddDefaultPaymentScore[data-id="+$(this).data("id")+"] i").addClass("active-yellow");

      helpers.showNoticeAnswer(helpers.translate.content("tr_70ef9b79f84f3cfabbec0c93f05372e6"), "success");

      e.preventDefault();

   });

   $(document).on('click','.actionAddPaymentCardToLink', function (e) {  

      $('.actionAddPaymentCardToLink').prop("disabled", true);

      helpers.request({url:"profile-settings-payment-card-add", precheck: true}, function(data) {

         if(data["status"] == true){
            window.open(data["link"],'_blank');
         }else{
            helpers.showNoticeAnswer(data["answer"]);
            $('.actionAddPaymentCardToLink').prop("disabled", false);
         }

      });

      e.preventDefault();

   });

   $(document).on('click','.actionCloseSidebarMapDelivery', function () {
        
        $(".delivery-points-map-sidebar-modal").hide();    
      
   });

   $(document).on('click','.actionChangePointMapDelivery', function () {
        
        $(".delivery-points-map-sidebar-modal").hide();    
        helpers.hideModal("deliveryPointsModal");

        helpers.request({url:"profile-settings-delivery-add-point", data: {id: $(this).data("id"), point_code: $(this).data("point-code")}}, function(data) {

         location.reload();

       });
      
   });

   $(document).on('change','.profile-settings-form input[name=delivery_status]', function () {
        
        helpers.request({url:"profile-settings-delivery-status", data: {status: $(this).prop("checked")}}, function(data) {

         helpers.showNoticeAnswer(helpers.translate.content("tr_6547cb6a2c87bfb8dc7643bdb7bddedc"), "success");

       });
      
   });

});