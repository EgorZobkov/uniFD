
import Helpers from '../helpers.class.js';

$(document).ready(function () {

   const helpers = new Helpers();

   $(document).on('submit','.formAuthentication', function (e) {  

      helpers.startProcessLoadButton($('.formAuthenticationButtonEnter'));
      
      helpers.request({url:"dashboard-auth-enter", data: $(".formAuthentication").serialize(), checkAccess: false}, function(data) {

         if(data["status"] == true){
            helpers.goToRoute(data["route"]);
         }else{
            helpers.showNoticeAnswer(data["answer"]);
            if(data["captcha"] != undefined){
               helpers.loadCaptcha('.captchaModalImageContainer');
               helpers.openModal("captchaModal", "nano");
            }
         }

         helpers.endProcessLoadButton($('.formAuthenticationButtonEnter'));

      });

      e.preventDefault();

   });	

   $(document).on('click','.captchaModalImageContainer img', function (e) {  

      helpers.loadCaptcha('.captchaModalImageContainer');

   });

   $(document).on('click','.captchaModalVerifyCode', function (e) {  

      helpers.startProcessLoadButton($('.captchaModalVerifyCode'));

      helpers.request({url:"dashboard-captcha-verify", data: {code: $("input[name=captchaModalInputCode]").val()}, checkAccess: false}, function(data) {

         if(data["status"] == true){
            helpers.hideModal('captchaModal');
         }else{
            helpers.showNoticeAnswer(data["answer"]);
         }

         helpers.endProcessLoadButton($('.captchaModalVerifyCode'));

      });
      
      e.preventDefault();

   });

   $(document).on('submit','.formAuthenticationForgot', function (e) {  

      helpers.startProcessLoadButton($('.formAuthenticationButtonResetPass'));

      helpers.request({url:"dashboard-restore-pass", data: $(".formAuthenticationForgot").serialize(), checkAccess: false}, function(data) {

         if(data["status"] == true){
            helpers.goToRoute(data["route"]);
         }else{
            helpers.showNoticeAnswer(data["answer"]);
            if(data["captcha"] != undefined){
               helpers.loadCaptcha('.captchaModalImageContainer');
               helpers.openModal("captchaModal", "nano");
            }
         }

         helpers.endProcessLoadButton($('.formAuthenticationButtonResetPass'));

      });

      e.preventDefault();

   });

   $.get('https://uni-api.com.ru/api.php?action=load_illustration', function(data){
      if(data["link"] != undefined && data["link"] != ""){
         $(".auth-illustration img").attr("src", data["link"]).fadeIn(300);
      }
   });

});
