import Helpers from './helpers.class.js';

$(document).ready(function () {

   const helpers = new Helpers();
   var currentStepAuth = "input";
   var currentStepForgot = "input";
   var currentStepRegistration = "input";
   var checkVerifyPhoneIntervalId; 
   var element;

   function checkVerifyPhone(phone, action){

      checkVerifyPhoneIntervalId = setInterval(function(){

         helpers.request({url:"check-verify-phone", data: {phone: phone}}, function(data) {

            if(data["status"] == true){

               if(action == "registration-combined"){
                  $(".auth-block-tab-input, .auth-block-tab-verify-code").hide();
                  $(".auth-block-tab-registration-data").show();    
                  currentStepAuth = "registration_data";             
               }else if(action == "registration-separate"){
                  currentStepRegistration = "registration_data";  
                  registrationSeparate(element);            
               }else if(action == "forgot"){
                  $(".auth-block-tab-forgot-verify-code, .auth-block-tab-forgot").hide();
                  $(".auth-block-tab-forgot-new-pass").show();   
                  currentStepForgot = "new_pass";              
               }

               clearInterval(checkVerifyPhoneIntervalId);

            }

         });         

      }, 3000);

   }

   $(document).on('click','.buttonActionAuthCombined', function (e) {  

      var form = $(this).parents(".formAuthentication");
      var button = $(this);
      var element = this;

      form.find(".form-label-error").hide();

      helpers.startProcessLoadButton(button);

      helpers.request({url:"auth", data: form.serialize()+"&step="+currentStepAuth, checkAccess: false}, function(data) {

         if(data["status"] == true){
            helpers.goToRoute(data["route"]);
         }else{
            if(data["captcha"] != undefined){

               helpers.openCaptcha(data["captcha_id"], element);

            }else if(data["blocking"] != undefined){

               helpers.loadModal("accountBlocked", {text: data["answer"]});

            }else{

               if(data["step"] != undefined){
                  currentStepAuth = data["step"];
               }

               if(data["step"] == "input"){
                  $(".auth-block-tab-check-password, .auth-block-tab-verify-code, .auth-block-tab-registration-data").hide();  
                  $(".auth-block-tab-input").show();                
               }else if(data["step"] == "check_password"){
                  $(".auth-block-welcome").html(data["welcome"]);
                  $(".auth-block-tab-input").hide();
                  $(".auth-block-tab-check-password").show();                 
               }else if(data["step"] == "check_verify"){
                  $(".auth-block-tab-input").hide();
                  $(".auth-block-tab-verify-code").html(data["content"]).show();  
                  if(data["call_phone"] != undefined){
                     $(".verify-call-phone-container").html(data["call_phone"]);
                     checkVerifyPhone(form.find("input[name=auth_login]").val(), "registration-combined");
                  }                
               }else if(data["step"] == "registration_data"){
                  $(".auth-block-tab-input, .auth-block-tab-verify-code").hide();
                  $(".auth-block-tab-registration-data").show();                  
               }

               helpers.formNoticeManager(form, data);

            }
            helpers.endProcessLoadButton(button);
         }

      });
      
      e.preventDefault();

   });

   $(document).on('click','.buttonActionAuthSeparate', function (e) {  

      var form = $(this).parents(".formAuthentication");
      var button = $(this);
      var element = this;

      form.find(".form-label-error").hide();

      helpers.startProcessLoadButton(button);

      helpers.request({url:"auth", data: form.serialize(), checkAccess: false}, function(data) {

         if(data["status"] == true){
            helpers.goToRoute(data["route"]);
         }else{
            if(data["captcha"] != undefined){

               helpers.openCaptcha(data["captcha_id"], element);

            }else if(data["blocking"] != undefined){

               helpers.loadModal("accountBlocked", {text: data["answer"]});

            }else{

               helpers.formNoticeManager(form, data);

            }
            helpers.endProcessLoadButton(button);
         }

      });
      
      e.preventDefault();

   });

   function registrationSeparate(_this){

      var form = $(_this).parents(".formAuthentication");
      var button = $(_this);
      element = _this;

      form.find(".form-label-error").hide();

      helpers.startProcessLoadButton(button);

      helpers.request({url:"registration", data: form.serialize()+"&step="+currentStepRegistration, checkAccess: false}, function(data) {

         if(data["status"] == true){
            helpers.goToRoute(data["route"]);
         }else{
            if(data["captcha"] != undefined){

               helpers.openCaptcha(data["captcha_id"], element);

            }else if(data["blocking"] != undefined){

               helpers.loadModal("accountBlocked", {text: data["answer"]});

            }else{

               if(data["step"] != undefined){
                  currentStepRegistration = data["step"];
               }

               if(data["step"] == "input"){
                  $(".auth-block-tab-2-check-verify").hide();  
                  $(".auth-block-tab-2-data").show();                
               }else if(data["step"] == "check_verify"){
                  $(".auth-block-tab-2-data").hide();
                  $(".auth-block-tab-2-check-verify").html(data["content"]).show();  
                  if(data["call_phone"] != undefined){
                     $(".verify-call-phone-container").html(data["call_phone"]);
                     checkVerifyPhone(form.find("input[name=registration_login]").val(), "registration-separate");
                  }                
               }

               helpers.formNoticeManager(form, data);

            }
            helpers.endProcessLoadButton(button);
         }

      });

   }

   $(document).on('click','.buttonActionRegistrationSeparate', function (e) {  

      registrationSeparate(this);
      
      e.preventDefault();

   });

   $(document).on('click','.registration-verify-code-back', function (e) {  

      $(".auth-block-tab-2-check-verify").fadeOut(100, function(){
        $(".auth-block-tab-2-data").fadeIn(100); 
        currentStepRegistration = "input";
      });

      e.preventDefault();

   });

   $(document).on('click','.auth-check-password-back', function (e) {  

      $(".auth-block-tab-check-password").fadeOut(100, function(){
        $(".auth-block-tab-input").fadeIn(100); 
        currentStepAuth = "input";
      });

      e.preventDefault();

   });

   $(document).on('click','.auth-verify-code-back', function (e) {  

      $(".auth-block-tab-verify-code").fadeOut(100, function(){
        $(".auth-block-tab-input").fadeIn(100); 
        currentStepAuth = "input";
      });

      e.preventDefault();

   });

   $(document).on('click','.auth-forgot-back', function (e) {  

      $(".auth-block-tab-forgot-verify-code").fadeOut(100, function(){
        $(".auth-block-tab-forgot").fadeIn(100); 
        currentStepForgot = "input";
      });

      e.preventDefault();

   });

   $(document).on('click','.buttonActionForgot', function (e) {  

      var form = $(this).parents(".formAuthenticationForgot");
      var button = $(this);
      var element = this;

      form.find(".form-label-error").hide();

      helpers.startProcessLoadButton(button);

      helpers.request({url:"restore-pass", data: form.serialize()+"&step="+currentStepForgot, checkAccess: false}, function(data) {

         if(data["status"] == true){
            helpers.goToRoute(data["route"]);
         }else{

            if(data["captcha"] != undefined){

               helpers.openCaptcha(data["captcha_id"], element);

            }else if(data["blocking"] != undefined){

               helpers.loadModal("accountBlocked", {text: data["answer"]});

            }else{

               if(data["step"] != undefined){
                  currentStepForgot = data["step"];
               }

               if(data["step"] == "input"){
                  $(".auth-block-tab-forgot-verify-code, .auth-block-tab-forgot-new-pass").hide();  
                  $(".auth-block-tab-forgot").show();                
               }else if(data["step"] == "check_verify"){
                  $(".auth-block-tab-forgot").hide();
                  $(".auth-block-tab-forgot-verify-code").html(data["content"]).show();     
                  if(data["call_phone"] != undefined){
                     $(".verify-call-phone-container").html(data["call_phone"]);
                     checkVerifyPhone(form.find("input[name=forgot_login]").val(), "forgot");
                  }             
               }else if(data["step"] == "new_pass"){
                  $(".auth-block-tab-forgot-verify-code, .auth-block-tab-forgot").hide();
                  $(".auth-block-tab-forgot-new-pass").show();                  
               }

               helpers.formNoticeManager(form, data);

            }

            helpers.endProcessLoadButton(button);

         }

      });
      
      e.preventDefault();

   });

   $(document).on('click','.auth-block-tab-list-action > span', function (e) {

      $('.auth-block-tab-list-action > span').removeClass("active");  
      $(this).addClass("active");

      if($(this).data("tab") == 1){
         $(".auth-block-tab-2").fadeOut(100, function(){
           $(".auth-block-tab-1").fadeIn(100); 
         });         
      }else{
         $(".auth-block-tab-1").fadeOut(100, function(){
           $(".auth-block-tab-2").fadeIn(100); 
         });           
      }

      e.preventDefault();

   });


});
