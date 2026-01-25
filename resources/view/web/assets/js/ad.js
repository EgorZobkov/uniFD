import Helpers from './helpers.class.js';

$(document).ready(function () {

  const helpers = new Helpers();
  var checkVerifyPhoneIntervalId; 

   if($('.unidropzone-container').length){
       var sortable = Sortable.create(document.querySelector('.unidropzone-container'), {
          handle: ".unidropzone-item",      
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

   $(document).on('submit','.form-ad-create', function (e) {

      $('.form-label-error').hide();

      helpers.startProcessLoadButton($('.adActionPublication'));

      helpers.request({url:"ad-publication", data: $(".form-ad-create").serialize(), precheck: true, button: $('.adActionPublication')}, function(data) { 

         if(data["status"] == true){

            location.href = data["route"];

         }else{

            if(data["auth"] == false){
                helpers.loadModal("auth");
            }

            helpers.formNoticeManager($('.form-ad-create'), data);
            helpers.endProcessLoadButton($('.adActionPublication'));

         }

      });

      e.preventDefault();

   });

   $(document).on('submit','.form-ad-update', function (e) {

      $('.form-label-error').hide();

      helpers.startProcessLoadButton($('.adActionUpdate'));

      helpers.request({url:"ad-update", data: $(".form-ad-update").serialize(), precheck: true}, function(data) {

         if(data["status"] == true){

            location.href = data["route"];

         }else{

            helpers.formNoticeManager($('.form-ad-update'), data);
            helpers.endProcessLoadButton($('.adActionUpdate'));

         }

      });

      e.preventDefault();

   });

   $(document).on('click','.ad-create-categories-item, .ad-create-categories-back', function (e) {

      $('input[name=category_id]').val($(this).data("id"));

      helpers.request({url:"ad-create-change-category-options", data: $(".form-ad-create, .form-ad-update").serialize()}, function(data) {

         if(data["subcategories"]){

             $(".ad-create-categories-container-items").html(data["content"]);

         }else{

             $(".ad-create-categories-container").hide();
             $(".ad-create-content-container").html(data["content"]);
             $(".ad-create-options-container").show();

             var sortable = Sortable.create(document.querySelector('.unidropzone-container'), {
                 handle: ".unidropzone-item",      
             });

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

            helpers.initPhoneMask();

         }
         
      });

      e.preventDefault();

   });

   $(document).on('click','.ad-create-categories-close', function (e) {

      $(".ad-create-categories-container").hide();
      $(".ad-create-options-container").show();

      e.preventDefault();

   });

   $(document).on('click','.ad-create-options-category-chain', function (e) {

      $(".ad-create-categories-container").show();
      $(".ad-create-options-container").hide();

      e.preventDefault();

   });

   var searchTimeout = null;

   $(document).on('input click','.ad-create-search-city > input', function (e) {  

      var parent = $(this).parents(".input-geo-search-container");
      var query = $(this).val();

      if (searchTimeout != null) {
        clearTimeout(searchTimeout);
      }

      if($(this).val().length != 0){
        searchTimeout = setTimeout(function() {
          searchTimeout = null;
          helpers.request({url:"geo-search-city", data: {query: query}}, function(data) {

             if(data["answer"]){
                parent.find(".input-geo-search-container-result").html(data["answer"]).fadeIn(100);
             }else{
                parent.find(".input-geo-search-container-result").html("").hide();
             }

          });
        }, 200);
      }else{
          parent.find(".input-geo-search-container-result").html("").hide();
      }

      e.preventDefault();

   });

   $(document).on('click','.ad-create-search-city .geo-city-item', function (e) {  

      $("input[name=geo_city_id]").val($(this).data("id"));
      $("input[name=geo_latitude]").val($(this).data("latitude"));
      $("input[name=geo_longitude]").val($(this).data("longitude"));
      $(".ad-create-search-city input").val($(this).html());
      $(".input-geo-search-container-result").hide();

      helpers.request({url:"ad-create-load-geo-options", data: {city_id: $(this).data("id")}}, function(data) {

         if(data["status"]){
            $(".ad-create-options-container-item-box-geo").html(data["answer"]).show();
         }else{
            $(".ad-create-options-container-item-box-geo").html("").hide();
         }

      });

      e.preventDefault();

   });

   $(document).on('input click','.ad-create-search-address > input', function (e) {  

      var parent = $(this).parents(".input-geo-search-container");
      var query = $(this).val();

      if (searchTimeout != null) {
        clearTimeout(searchTimeout);
      }

      if($(this).val().length != 0){
        searchTimeout = setTimeout(function() {
          searchTimeout = null;
          helpers.request({url:"geo-search-address", data: {city_id:$("input[name=geo_city_id]").val(),query: query}}, function(data) {

             if(data["answer"]){
                parent.find(".input-geo-search-container-result").html(data["answer"]).fadeIn(100);
             }else{
                parent.find(".input-geo-search-container-result").html("").hide();
             }

          });
        }, 200);
      }else{
          parent.find(".input-geo-search-container-result").html("").hide();
      }

      e.preventDefault();

   });

   $(document).on('click','.ad-create-search-address .geo-city-item', function (e) {  

      $("input[name=geo_address_latitude]").val($(this).data("latitude"));
      $("input[name=geo_address_longitude]").val($(this).data("longitude"));
      $(".ad-create-search-address input").val($(this).html());
      $(".input-geo-search-container-result").hide();

      e.preventDefault();

   });

   function removeFilterItems(parent){
       
       var ids = '';

       if(parent.attr("data-parent-ids") != undefined){
           ids = parent.attr("data-parent-ids").split(",");
           $.each(ids,function(index,value){

             $('.params-form-item[data-id="'+value+'"]').remove().hide();

           });
       }

   }

   $(document).on('change','input[type=radio], input[type=checkbox]', function (e) {

       var parent = $(this).parents(".params-form-item");

       if($(this).val()!="null"){
          helpers.request({url:"ad-create-load-filter-items", data: {filter_id: parent.data("id"),item_id:$(this).val()}}, function(data) {

             removeFilterItems(parent);
             parent.after(data["content"]);
            
          });
       }else{
          removeFilterItems(parent);
       }

       e.preventDefault();
   });


   $(document).on('click','.unidropzone-change', function (e) {

      $(".init-unidropzone input[type=file]").trigger("click");

       e.preventDefault();
   });

   $(document).on('click','.unidropzone-item-delete', function (e) {

       $(this).parents(".unidropzone-item").remove().hide();

       e.preventDefault();
   });

   var uploadFiles = [];
   var uploadKey = 0;

   function unidropzoneUpload(arrayFile=null){

      if(arrayFile){

          var formData = new FormData();

          formData.append('unidropzone_files', arrayFile.file);

          helpers.request({url:"ad-create-load-media", data: formData, contentType: false, processData: false}, function(data) {

             if(data["content"] != "" && data["content"] != undefined){
                $(".unidropzone-item-in-load"+arrayFile.key).html(data["content"]);
             }else{
                $(".unidropzone-item-in-load"+arrayFile.key).remove().hide();
             }

             uploadKey++;

             if(uploadFiles[uploadKey]){
                unidropzoneUpload(uploadFiles[uploadKey]);
             }else{
                uploadFiles = [];
                uploadKey = 0;         
             }

          });   

      } 

   }

   $(document).on('change','.init-unidropzone input[type=file]', function (e) {

      var countFiles = $(this)[0].files.length < 10 ? $(this)[0].files.length : 10;

      for(var i = 0; i < countFiles; i++){

          var size = $(this)[0].files.item(i).size;
          var type = $(this)[0].files.item(i).type;
          var uniqid = helpers.generateStr(32);

          if(type.split("/")[0] == "image"){

              if(size > helpers.config("board_publication_max_size_image")*1024*1024){
                  $(".unidropzone-container").append(`
                        <div class="unidropzone-item" >
                          <span class="unidropzone-item-delete" ><i class="ti ti-x"></i></span>
                          <div class="unidropzone-item-error" >`+helpers.translate.content("tr_da64c3d2aebe085e37b81de2b8f291d6")+` `+helpers.config("board_publication_max_size_image")+` `+helpers.translate.content("tr_505c12388f06a422b00aa0ac07de72c5")+`</div>
                        </div>
                  `).show();
              }else{
                  $(".unidropzone-container").append(`
                        <div class="unidropzone-item unidropzone-item-in-load`+uniqid+`" >
                          <div class="unidropzone-item-loader" ><span class="spinner-border me-1" role="status" aria-hidden="true"></span></div>
                        </div>
                  `).show();
                  uploadFiles.push({"key": uniqid, "file": $(this)[0].files[i]});
              }

          }else if(type.split("/")[0] == "video"){

              if(size > helpers.config("board_publication_max_size_video")*1024*1024){
                  $(".unidropzone-container").append(`
                        <div class="unidropzone-item" >
                          <span class="unidropzone-item-delete" ><i class="ti ti-x"></i></span>
                          <div class="unidropzone-item-error" >`+helpers.translate.content("tr_9ae516c38adb35538122d6c0ac3d98f0")+` `+helpers.config("board_publication_max_size_video")+` `+helpers.translate.content("tr_505c12388f06a422b00aa0ac07de72c5")+`</div>
                        </div>
                  `).show();
              }else{
                  $(".unidropzone-container").append(`
                        <div class="unidropzone-item unidropzone-item-in-load`+uniqid+`" >
                          <div class="unidropzone-item-loader" ><span class="spinner-border me-1" role="status" aria-hidden="true"></span></div>
                        </div>
                  `).show();
                  uploadFiles.push({"key": uniqid, "file": $(this)[0].files[i]});
              }

          }else{

              if(size > helpers.config("board_publication_max_size_image")*1024*1024){
                  $(".unidropzone-container").append(`
                        <div class="unidropzone-item" >
                          <span class="unidropzone-item-delete" ><i class="ti ti-x"></i></span>
                          <div class="unidropzone-item-error" >`+helpers.translate.content("tr_da64c3d2aebe085e37b81de2b8f291d6")+` `+helpers.config("board_publication_max_size_image")+` `+helpers.translate.content("tr_505c12388f06a422b00aa0ac07de72c5")+`</div>
                        </div>
                  `).show();
              }else{
                  $(".unidropzone-container").append(`
                        <div class="unidropzone-item unidropzone-item-in-load`+uniqid+`" >
                          <div class="unidropzone-item-loader" ><span class="spinner-border me-1" role="status" aria-hidden="true"></span></div>
                        </div>
                  `).show();
                  uploadFiles.push({"key": uniqid, "file": $(this)[0].files[i]});
              }
            
          }

      }

      $(this).val("");

      unidropzoneUpload(uploadFiles[uploadKey]);

      e.preventDefault();
   });

   $(document).on('change','input[name=not_limited]', function (e) {  

      if($(this).prop("checked") == true){
         $('.ad-create-options-container-item-box-available-settings').hide();
      }else{
         $('.ad-create-options-container-item-box-available-settings').show();
      }

   });

   $(document).on('click','.actionSendVerifyCodeEmail', function (e) {

      var element = this;

      $('.form-label-error').hide();

      helpers.startProcessLoadButton($('.actionSendVerifyCodeEmail'));

      helpers.request({url:"send-code-verify-contact", data: {email: $('.form-ad-create input[name=contact_email], .form-ad-update input[name=contact_email]').val()}}, function(data) { 

            if(data["status"]){

                 helpers.loadModal("verificationCode", {email:$('.form-ad-create input[name=contact_email], .form-ad-update input[name=contact_email]').val()}, null, element);

            }else{
                if(data["captcha"]){
                   helpers.openCaptcha(data["captcha_id"],element);                
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

      helpers.request({url:"send-code-verify-contact", data: {phone: $('.form-ad-create input[name=contact_phone], .form-ad-update input[name=contact_phone]').val()}}, function(data) {

            if(data["status"]){

                 call_phone = data["call_phone"];

                 helpers.loadModal("verificationCode", {phone:$('.form-ad-create input[name=contact_phone], .form-ad-update input[name=contact_phone]').val()}, function(data) {
                     if(call_phone){
                         $(".verify-call-phone-container").html(call_phone);
                         checkVerifyPhone($('.form-ad-create input[name=contact_phone], .form-ad-update input[name=contact_phone]').val());
                     }
                 },element);

            }else{
                if(data["captcha"]){  
                   helpers.openCaptcha(data["captcha_id"],element);            
                }else if(data["answer"]){
                   helpers.showNoticeAnswer(data["answer"]);                
                }
            }

            helpers.endProcessLoadButton($('.actionSendVerifyCodePhone'));

      });

      e.preventDefault();

   });


   $(document).on('input click','.form-ad-create input[name=contact_email], .form-ad-update input[name=contact_email]', function (e) {

      helpers.request({url:"check-verify-contact", data: {email: $('.form-ad-create input[name=contact_email], .form-ad-update input[name=contact_email]').val()}}, function(data) { 

        if(data["status"]){
            $(".actionSendVerifyCodeEmailContainer").show();
        }else{
            $(".actionSendVerifyCodeEmailContainer").hide();
        }

      });

      e.preventDefault();

   });

   $(document).on('input click','.form-ad-create input[name=contact_phone], .form-ad-update input[name=contact_phone]', function (e) {

      helpers.request({url:"check-verify-contact", data: {phone: $('.form-ad-create input[name=contact_phone], .form-ad-update input[name=contact_phone]').val()}}, function(data) {

        if(data["status"]){
            $(".actionSendVerifyCodePhoneContainer").show();
        }else{
            $(".actionSendVerifyCodePhoneContainer").hide();
        }

      });

      e.preventDefault();

   });

   $(document).on('click','.actionAddBookingAdditionalService', function (e) {

      var key = helpers.generateStr(12);

      $(".ad-create-options-additional-services-container").append(`
            <div class="ad-create-options-additional-services-item" >
              
              <div class="row" >
                <div class="col-lg-8 col-12" >
                      <input type="text" name="booking_additional_services[`+key+`][name]" class="form-control" placeholder="`+helpers.translate.content("tr_45a4c11809990f3313f8f38748db27df")+`" >
                </div>
                <div class="col-lg-3 col-8" >
                      <input type="number" name="booking_additional_services[`+key+`][price]" step="0.01" class="form-control" placeholder="`+helpers.translate.content("tr_682fa8dbadd54fda355b27f124938c93")+`" >
                </div>
                <div class="col-lg-1 col-2" >
                      <span class="ad-create-options-additional-services-item-delete" ><i class="ti ti-trash"></i></span>
                </div>
              </div>

            </div>
      `);

      e.preventDefault();

   });

   $(document).on('click','.ad-create-options-additional-services-item-delete', function (e) {

      $(this).parents(".ad-create-options-additional-services-item").remove().hide();

      e.preventDefault();

   });

   $(document).on('change','input[name=booking_deposit_status]', function (e) {  

      if($(this).prop("checked") == true){
         $('.ad-create-options-container-item-box-booking-deposit-settings').show();
      }else{
         $('.ad-create-options-container-item-box-booking-deposit-settings').hide();
      }

   });

   $(document).on('change','input[name=booking_full_payment_status]', function (e) {  

      if($(this).prop("checked") == true){
         $('.ad-create-options-container-item-box-booking-prepayment-settings').hide();
      }else{
         $('.ad-create-options-container-item-box-booking-prepayment-settings').show();
      }

   });

   $(document).on('click','.actionAddBookingSpecialDays', function (e) {

      var key = helpers.generateStr(12);

      $(".ad-create-options-special-days-container").append(`
            <div class="ad-create-options-special-days-item" >
              
              <div class="row" >
                <div class="col-lg-8 col-12" >
                      <input type="date" name="booking_special_days[`+key+`][date]" class="form-control" placeholder="`+helpers.translate.content("tr_8cdd8bb771bcf038dfb2740fd50b332c")+`" >
                </div>
                <div class="col-lg-3 col-8" >
                      <input type="number" name="booking_special_days[`+key+`][price]" class="form-control" step="0.01" placeholder="`+helpers.translate.content("tr_682fa8dbadd54fda355b27f124938c93")+`" >
                </div>
                <div class="col-lg-1 col-2" >
                      <span class="ad-create-options-special-days-item-delete" ><i class="ti ti-trash"></i></span>
                </div>
              </div>

            </div>
      `);

      e.preventDefault();

   });

   $(document).on('click','.ad-create-options-special-days-item-delete', function (e) {

      $(this).parents(".ad-create-options-special-days-item").remove().hide();

      e.preventDefault();

   });


});