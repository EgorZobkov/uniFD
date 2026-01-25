
import Helpers from '../helpers.class.js';

$(document).ready(function () {

   const helpers = new Helpers();

   var codemirror = null;

   helpers.loadBody(null,function() {

      if($('.settings-home-widgets-container').length){
         var el = document.getElementById('settings-home-widgets-container');
         var sortable = Sortable.create(el, {
            handle: ".settings-home-widgets-sortable-handle",     
         });
      }

      if($('.settings-api-app-page-out-content-container').length){
         var el = document.getElementById('settings-api-app-page-out-content-container');
         var sortable = Sortable.create(el, {
            handle: ".settings-api-app-page-out-content-sortable-handle",     
         });
      }

      if($('.minicolors-input').length){
          $(".minicolors-input").minicolors({
             swatches: $(".minicolors-input").attr('data-swatches') ? $(".minicolors-input").attr('data-swatches').split('|') : [],
             change: function(value, opacity) {
               if( !value ) return;
               if( opacity ) value += ', ' + opacity;
               if( typeof console === 'object' ) {
               }
             },
             theme: 'bootstrap'
          });
      }

   });

   $(document).on('submit','.formSettings', function (e) {  

      $('.formSettings .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonSaveSettings'));
      
      var form = new FormData($(this)[0]);

      if(codemirror!=null){
         form.append('mailer_template_body', encodeURIComponent(codemirror.getValue()));
      }

      if($('.formSettings textarea[name=frontend_scripts]').length){
         form.append('frontend_scripts', encodeURIComponent($('.formSettings textarea[name=frontend_scripts]').val()));
      }

      if($('.formSettings textarea[name=api_app_firebase_push_params]').length){
         form.append('api_app_firebase_push_params', encodeURIComponent($('.formSettings textarea[name=api_app_firebase_push_params]').val()));
      }

      helpers.request({url:$('.buttonSaveSettings').data("route-name"),data: form,cache: false, contentType: false, processData: false}, function(data) {

         if(data["status"] == true){
            helpers.showNoticeAnswer(data["answer"], data["type_answer"]);
         }else{
            helpers.formNoticeManager($('.formSettings'), data);
         }

         helpers.endProcessLoadButton($('.buttonSaveSettings'));

      });

      e.preventDefault();

   });	

   $(document).on('change','.select-watermark-type-settings', function (e) { 

      var selected = $(this).find('option:selected'); 

      if(selected.val() == "title"){
         $('.settings-watermark-type-title-container').show();
         $('.settings-watermark-type-image-container').hide();
      }else if(selected.val() == "image"){
         $('.settings-watermark-type-image-container').show();
         $('.settings-watermark-type-title-container').hide();
      }else{
         $('.settings-watermark-type-image-container').hide();
         $('.settings-watermark-type-title-container').hide();         
      }

   });

   $(document).on('change','.settings-select-mailer-service', function (e) {  

      var selected = $(this).find('option:selected'); 

      if(selected.val() == ""){
         $('.settings-mailer-smtp-alert').show();
         $('.settings-mailer-service-smtp-container, .settings-mailer-services-container').hide();
      }else if(selected.val() == "smtp"){
         $('.settings-mailer-service-smtp-container').show();
         $('.settings-mailer-services-container, .settings-mailer-smtp-alert').hide();
      }else{
         $('.settings-mailer-service-smtp-container, .settings-mailer-services-container, .settings-mailer-smtp-alert').hide();
         $('.settings-mailer-services-container').show();
      }

   });

   $(document).on('change','.settings-select-access-action', function (e) {  

      var selected = $(this).find('option:selected');

      if(selected.val() == "text"){
         $('.settings-access-text-container').show();
         $('.settings-access-redirect-link-container').hide();
      }else if(selected.val() == "redirect"){
         $('.settings-access-text-container').hide();
         $('.settings-access-redirect-link-container').show();
      }else{
         $('.settings-access-text-container').hide();
         $('.settings-access-redirect-link-container').hide();
      }

   });

   $(document).on('change','.settings-select-mailer-template', function (e) {

      var selected = $(this).find('option:selected');

      helpers.request({url:"dashboard-settings-mailing-load-template",data: {code: selected.val()}}, function(data) {

         $(".settings-mailer-template-body").val('');

         if(data["content"]){
            $(".settings-mailer-template-container").show();
            $(".settings-mailer-template-body").val(data["content"]);
         }else{
            $(".settings-mailer-template-container").hide();
         }

         $(".CodeMirror").remove();

         codemirror = CodeMirror.fromTextArea(document.querySelector(".settings-mailer-template-body"), {
             lineNumbers: true,
             mode: "text/html",
             enterMode: "keep",
             autoRefresh: true
         });

      });

   });

   $(document).on('click','.buttonSendTestMailSettings', function (e) {

      helpers.startProcessLoadButton($(this));

      helpers.request({url:"dashboard-settings-mailing-test-send",data: $('.formSettings').serialize(), dataType: "html"}, function(data) {

         $("#testLogModal textarea").val(data);
         helpers.openModal("testLogModal", "small");
         helpers.endProcessLoadButton($('.buttonSendTestMailSettings'));

      });

   });

   $(document).on('click','.buttonIntegrationTelegramKey', function (e) {

      helpers.startProcessLoadButton($(this));

      helpers.request({url:"dashboard-settings-integrations-test-key-telegram",data: $('.formSettings').serialize()}, function(data) {

         if(data["status"] == true){
            $("#testLogModal textarea").val(data["answer"]);
            helpers.openModal("testLogModal", "medium");
         }else{
            helpers.formNoticeManager($('.formSettings'), data);
         }

         helpers.endProcessLoadButton($('.buttonIntegrationTelegramKey'));

      });

   });

   $(document).on('click','.buttonIntegrationSmsTest', function (e) {

      helpers.startProcessLoadButton($(this));

      helpers.request({url:"dashboard-settings-integrations-test-sms",data: $('.formSettings').serialize()}, function(data) {

         if(data["status"] == true){
            $("#testLogModal textarea").val(data["answer"]);
            helpers.openModal("testLogModal", "medium");
         }else{
            helpers.showNoticeAnswer(data["answer"], data["type_answer"]);
         }

         helpers.endProcessLoadButton($('.buttonIntegrationSmsTest'));

      });

   });

   $(document).on('change','.settings-select-integration-map-service', function (e) {  

      var selected = $(this).find('option:selected'); 

      if(selected.val()){
         $('.settings-integration-service-api-key-container').show();
      }else{
         $('.settings-integration-service-api-key-container').hide();
      }

   });

   $(document).on('change','.settings-select-integration-sms-service', function (e) {  

      var selected = $(this).find('option:selected');

      if(selected.val()){
         helpers.request({url:"dashboard-settings-integrations-sms-load-options",data: {id: selected.val()}}, function(data) {

            $(".settings-integration-sms-service-container-options").html(data["content"]).show();

         });
      }else{
         $(".settings-integration-sms-service-container-options").html("").hide();
      }

   });

   $(document).on('click','.settings-select-integration-payment-load-edit', function (e) {

      helpers.openModal("loadContentModal", "medium");

      helpers.request({url:"dashboard-settings-integrations-payment-load-edit",data: {id: $(this).data("id")}}, function(data) {

         $("#loadContentModal .load-content-container").html(data["content"]);

      });

   });

   $(document).on('change','.settings-board-select-cost-publication', function (e) {  

      var selected = $(this).find('option:selected');

      if(selected.val() == "free"){
         $('.settings-board-cost-publication-container').hide();
      }else if(selected.val() == "paid"){
         $('.settings-board-cost-publication-container').show();
      }

   });

   $(document).on('change','input[name=board_publication_moderation_status]', function (e) {  

      if($(this).prop("checked") == true){
         $('.settings-board-publication-moderation-container').hide();
      }else{
         $('.settings-board-publication-moderation-container').show();
      }

   });

   $(document).on('change','input[name=board_publication_premoderation_status]', function (e) {  

      if($(this).prop("checked") == true){
         $('.settings-board-publication-premoderation-container').show();
      }else{
         $('.settings-board-publication-premoderation-container').hide();
      }

   });

   $(document).on('click','.settingsSystemAddMeasuremen', function (e) {  

      $(".settings-system-measurement-container").append(`<div class="settings-system-measurement-item mb-2" ><div class="col-12 col-md-6" ><div class="input-group"><input type="text" class="form-control" name="system_measurement[add][]" value=""><span class="btn btn-icon btn-label-danger waves-effect buttonDeleteItemMeasurement"><i class="ti ti-trash"></i></span></div></div>
          </div>`);

   });

   $(document).on('click','.buttonDeleteItemMeasurement', function (e) {  

      $(this).parents(".settings-system-measurement-item").remove().fadeOut(300);

   });

   $(document).on('click','.settingsSystemAddPriceNames', function (e) {  

      $(".settings-system-price-names-container").append(`<div class="settings-system-price-names-item mb-2" ><div class="col-12 col-md-6" ><div class="input-group"><input type="text" class="form-control" name="system_price_names[add][]" value=""><span class="btn btn-icon btn-label-danger waves-effect buttonDeleteItemPriceNames"><i class="ti ti-trash"></i></span></div></div>
          </div>`);

   });

   $(document).on('click','.buttonDeleteItemPriceNames', function (e) {  

      $(this).parents(".settings-system-price-names-item").remove().fadeOut(300);

   });

   $(document).on('click','.buttonIntegrationPaymentSave', function (e) {

      helpers.startProcessLoadButton($(this));

      helpers.request({url:"dashboard-settings-integrations-payment-save-edit",data: $('.integrationPaymentForm').serialize()}, function(data) {

         if(data["status"] == true){
            location.reload();
         }

         helpers.endProcessLoadButton($('.buttonIntegrationPaymentSave'));

      });

   });

   $(document).on('click','.buttonSettingsClearCache', function (e) {

      helpers.startProcessLoadButton($(this));

      helpers.request({url:"dashboard-settings-clear-cache"}, function(data) {

         location.reload();

         helpers.endProcessLoadButton($('.buttonSettingsClearCache'));

      });

   });

   $(document).on('change','.integration-payment-services-edit-receipt-switch', function (e) {  

      if($(this).prop("checked") == true){
         $('.integration-payment-services-edit-receipt-container').show();
      }else{
         $('.integration-payment-services-edit-receipt-container').hide();
      }

   });

   $(document).on('change','input[name=allowed_templates_email_all_status]', function (e) {  

      if($(this).prop("checked") == true){
         $('.settings-profile-allowed-emails-container').hide();
      }else{
         $('.settings-profile-allowed-emails-container').show();
      }

   });

   $(document).on('change','input[name=allowed_templates_phone_all_status]', function (e) {  

      if($(this).prop("checked") == true){
         $('.settings-profile-allowed-phones-container').hide();
      }else{
         $('.settings-profile-allowed-phones-container').show();
      }

   });

   $(document).on('change','input[name=phone_confirmation_status]', function (e) {  

      if($(this).prop("checked") == true){
         $('.settings-profile-phone-confirmation-method-container').show();
      }else{
         $('.settings-profile-phone-confirmation-method-container').hide();
      }

   });

   $(document).on('change','input[name=seo_robots_manual]', function (e) {  

      if($(this).prop("checked") == true){
         $('.settings-seo-robots-text-container').show();
         $('.settings-seo-robots-index-container').hide();
      }else{
         $('.settings-seo-robots-text-container').hide();
         $('.settings-seo-robots-index-container').show();
      }

   });

   $(document).on('change','select[name=system_report_period]', function (e) { 

      var selected = $(this).find('option:selected'); 

      if(selected.val() == "24"){
         $('.settings-system-report-send-time-container').show();
      }else{
         $('.settings-system-report-send-time-container').hide();       
      }

   });

   $(document).on('click','.settings-select-integration-delivery-load-edit', function (e) {

      helpers.openModal("loadContentModal", "medium");

      helpers.request({url:"dashboard-settings-integrations-delivery-load-edit",data: {id: $(this).data("id")}}, function(data) {

         $("#loadContentModal .load-content-container").html(data["content"]);

      });

   });

   $(document).on('click','.buttonIntegrationDeliverySave', function (e) {

      helpers.startProcessLoadButton($(this));

      helpers.request({url:"dashboard-settings-integrations-delivery-save-edit",data: $('.integrationDeliveryForm').serialize()}, function(data) {

         if(data["status"] == true){
            location.reload();
         }

         helpers.endProcessLoadButton($('.buttonIntegrationDeliverySave'));

      });

   });

   $(document).on('click','.settings-select-integration-oauth-load-edit', function (e) {

      helpers.openModal("loadContentModal", "medium");

      helpers.request({url:"dashboard-settings-integrations-oauth-load-edit",data: {id: $(this).data("id")}}, function(data) {

         $("#loadContentModal .load-content-container").html(data["content"]);

      });

   });

   $(document).on('click','.buttonIntegrationOAuthSave', function (e) {

      helpers.startProcessLoadButton($(this));

      helpers.request({url:"dashboard-settings-integrations-oauth-save-edit",data: $('.integrationOAuthForm').serialize()}, function(data) {

         if(data["status"] == true){
            location.reload();
         }

         helpers.endProcessLoadButton($('.buttonIntegrationOAuthSave'));

      });

   });

   $(document).on('click','.settings-select-integration-messenger-load-edit', function (e) {

      helpers.openModal("loadContentModal", "medium");

      helpers.request({url:"dashboard-settings-integrations-messenger-load-edit",data: {id: $(this).data("id")}}, function(data) {

         $("#loadContentModal .load-content-container").html(data["content"]);

      });

   });

   $(document).on('click','.buttonIntegrationMessengerSave', function (e) {

      helpers.startProcessLoadButton($(this));

      helpers.request({url:"dashboard-settings-integrations-messenger-save-edit",data: $('.integrationMessengerForm').serialize()}, function(data) {

         if(data["status"] == true){
            location.reload();
         }

         helpers.endProcessLoadButton($('.buttonIntegrationMessengerSave'));

      });

   });

   $(document).on('change','input[name=api_app_download_only_apk]', function (e) {  

      if($(this).prop("checked") == true){
         $('.settings-api-app-apk-link-container').show();
         $('.settings-api-app-download-links-container').hide();
      }else{
         $('.settings-api-app-apk-link-container').hide();
         $('.settings-api-app-download-links-container').show();
      }

   });

   $(document).on('click','.settingsApiAppStartBannerAdd', function (e) {

      var key = helpers.generateStr(6);

      $(".settings-api-app-start-banners-container").append(`
        <div class="bg-lighter rounded p-3 position-relative settings-api-app-start-banners-item mb-2">

          <div class="row" >
            
            <div class="col-md-6" >
              
              <div class="mb-2">
                <label class="form-label mb-2">`+helpers.translate.content("tr_2e9d7991efe99efaf9cf325b6f10d8a0")+`</label>

                <input type="text" name="api_app_start_promo_banners[`+key+`][title]" class="form-control" value="">
              </div>              

            </div>

            <div class="col-md-6" >
              
              <div class="mb-2">
                <label class="form-label mb-2">`+helpers.translate.content("tr_22ded0df4bf2dbd70dc9699b69ee9cd9")+`</label>

                <input type="text" name="api_app_start_promo_banners[`+key+`][image_link]" class="form-control" value=""> 
              </div>              
              
            </div>

            <div class="col-md-6" >
              
              <div class="mb-2">
                <label class="form-label mb-2">`+helpers.translate.content("tr_544cca5cb61dcdd02a248f8062dc2957")+`</label>

                <input type="text" name="api_app_start_promo_banners[`+key+`][color_bg]" class="form-control minicolors-input" value="">
              </div>              

            </div>

            <div class="col-md-6" >
              
              <div class="mb-2">
                <label class="form-label mb-2">`+helpers.translate.content("tr_8bb4a3e13a130f6b9311d47a89291f3b")+`</label>

                <input type="text" name="api_app_start_promo_banners[`+key+`][color_text]" class="form-control minicolors-input" value=""> 
              </div>              
              
            </div>

          </div>

          <div>
            <label class="form-label mb-2">`+helpers.translate.content("tr_62b685c7d7c78ac9b69b36cfc70c566f")+`</label>

            <div class="row">
              <div class="col-12 col-md-12"> 
                <textarea class="form-control" name="api_app_start_promo_banners[`+key+`][text]" rows="4" ></textarea>
              </div>
            </div>

          </div>

          <div class="text-end" >
            <span class="btn btn-sm btn-danger waves-effect waves-light settingsApiAppStartBannerDelete mt-2">`+helpers.translate.content("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8")+`</span>
          </div>

        </div>
      `);

      if($('.minicolors-input').length){
          $(".minicolors-input").minicolors({
             swatches: $(".minicolors-input").attr('data-swatches') ? $(".minicolors-input").attr('data-swatches').split('|') : [],
             change: function(value, opacity) {
               if( !value ) return;
               if( opacity ) value += ', ' + opacity;
               if( typeof console === 'object' ) {
               }
             },
             theme: 'bootstrap'
          });
      }

   });

   $(document).on('click','.settingsApiAppStartBannerDelete', function (e) {

      $(this).parents(".settings-api-app-start-banners-item").remove().hide();

   });

   $(document).on('click','.settingsApiAppSliderBannerAdd', function (e) {

      var key = helpers.generateStr(6);

      $(".settings-api-app-slider-banners-container").append(`
        <div class="bg-lighter rounded p-3 position-relative settings-api-app-slider-banners-item mb-2">

          <div class="row" >
            
            <div class="col-md-6" >
              
              <div class="mb-2">
                <label class="form-label mb-2">`+helpers.translate.content("tr_b87eae9ed7afc4de539846d81943a94c")+`</label>

                <input type="text" name="api_app_main_page_slider_banners[`+key+`][target]" class="form-control" value="">
              </div>              

            </div>

            <div class="col-md-6" >
              
              <div class="mb-2">
                <label class="form-label mb-2">`+helpers.translate.content("tr_22ded0df4bf2dbd70dc9699b69ee9cd9")+`</label>

                <input type="text" name="api_app_main_page_slider_banners[`+key+`][image_link]" class="form-control" value=""> 
              </div>              
              
            </div>

          </div>

          <div class="text-end" >
            <span class="btn btn-sm btn-danger waves-effect waves-light settingsApiAppSliderBannerDelete">`+helpers.translate.content("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8")+`</span>
          </div>

        </div>
      `);

   });

   $(document).on('click','.settingsApiAppSliderBannerDelete', function (e) {

      $(this).parents(".settings-api-app-slider-banners-item").remove().hide();

   });

   $(document).on('click','.settingsApiAppPromoSectionsAdd', function (e) {

      var key = helpers.generateStr(6);

      $(".settings-api-app-promo-sections-container").append(`
        <div class="bg-lighter rounded p-3 position-relative settings-api-app-promo-sections-item mb-2">

          <div class="row" >
            
            <div class="col-md-4" >
              
              <div class="mb-2">
                <label class="form-label mb-2">`+helpers.translate.content("tr_e52a37d9a87c69681d5b40e88b9b2f49")+`</label>

                <input type="text" name="api_app_main_page_promo_sections[`+key+`][name]" class="form-control" value="">
              </div>              

            </div>

            <div class="col-md-4" >
              
              <div class="mb-2">
                <label class="form-label mb-2">`+helpers.translate.content("tr_b87eae9ed7afc4de539846d81943a94c")+`</label>

                <input type="text" name="api_app_main_page_promo_sections[`+key+`][target]" class="form-control" value="">
              </div>              

            </div>

            <div class="col-md-4" >
              
              <div class="mb-2">
                <label class="form-label mb-2">`+helpers.translate.content("tr_22ded0df4bf2dbd70dc9699b69ee9cd9")+`</label>

                <input type="text" name="api_app_main_page_promo_sections[`+key+`][image_link]" class="form-control" value=""> 
              </div>              
              
            </div>

          </div>

          <div class="text-end" >
            <span class="btn btn-sm btn-danger waves-effect waves-light settingsApiAppPromoSectionsDelete">`+helpers.translate.content("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8")+`</span>
          </div>

        </div>
      `);

   });

   $(document).on('click','.settingsApiAppPromoSectionsDelete', function (e) {

      $(this).parents(".settings-api-app-promo-sections-item").remove().hide();

   });

   $(document).on('click','.settingsApiAppServicesPagesAdd', function (e) {

      var key = helpers.generateStr(6);

      $(".settings-api-app-services-pages-container").append(`
        <div class="bg-lighter rounded p-3 position-relative settings-api-app-services-pages-item mb-2">

          <div class="row" >
            
            <div class="col-md-6" >
              
              <div class="mb-2">
                <label class="form-label mb-2">`+helpers.translate.content("tr_e52a37d9a87c69681d5b40e88b9b2f49")+`</label>

                <input type="text" name="api_app_services_pages[`+key+`][name]" class="form-control" value="">
              </div>              

            </div>

            <div class="col-md-6" >
              
              <div class="mb-2">
                <label class="form-label mb-2">`+helpers.translate.content("tr_b87eae9ed7afc4de539846d81943a94c")+`</label>

                <input type="text" name="api_app_services_pages[`+key+`][target]" class="form-control" value="">
              </div>              

            </div>

          </div>

          <div class="text-end" >
            <span class="btn btn-sm btn-danger waves-effect waves-light settingsApiAppServicesPagesDelete">`+helpers.translate.content("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8")+`</span>
          </div>

        </div>
      `);

   });

   $(document).on('click','.settingsApiAppServicesPagesDelete', function (e) {

      $(this).parents(".settings-api-app-services-pages-item").remove().hide();

   });

   $(document).on('click','.settingsInformationAddSocialLink', function (e) {  

      var key = helpers.generateStr(6);

      $(".settings-information-contact-social-links-container").append(`
         <div class="col-12 mb-2 contact-social-link-item">

           <div class="row" >
             <div class="col-12 col-md-3 mb-1" >
               <input type="text" name="contact_social_links[`+key+`][name]" class="form-control" placeholder="`+helpers.translate.content("tr_602680ed8916dcc039882172ef089256")+`" /> 
             </div>
             <div class="col-12 col-md-4 mb-1" >
               <input type="text" name="contact_social_links[`+key+`][link]" class="form-control" placeholder="`+helpers.translate.content("tr_9797b9494600869ec6a941dae3f2a198")+`" /> 
             </div>
             <div class="col-12 col-md-4 mb-1" >
               <input type="text" name="contact_social_links[`+key+`][image]" class="form-control" placeholder="`+helpers.translate.content("tr_22ded0df4bf2dbd70dc9699b69ee9cd9")+`" /> 
             </div>
             <div class="col-12 col-md-1" >
               <span class="btn btn-icon btn-label-danger waves-effect settingsInformationDeleteSocialLink"><i class="ti ti-trash"></i></span> 
             </div>
           </div>

         </div>
      `);

   });

   $(document).on('click','.settingsInformationDeleteSocialLink', function (e) {  

      $(this).parents(".contact-social-link-item").remove().hide();

   });

});
