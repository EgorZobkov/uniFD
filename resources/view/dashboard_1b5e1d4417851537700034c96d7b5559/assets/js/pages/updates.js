
import Helpers from '../helpers.class.js';

$(document).ready(function () {

   const helpers = new Helpers();

   helpers.loadBody(null,function() {

      checkUpdate();

   });

   $(document).on('click','.actionUpdateInstall', function (e) {  

      helpers.startProcessLoadButton($('.actionUpdateInstall'));

      helpers.request({url:"dashboard-uniid-install-update"}, function(data) {

         if(data["status"] == true){
            location.reload();
         }else{
            if(data["answer"] != undefined){
               helpers.showNoticeAnswer(data["answer"]);
            }else{
               $("#testLogModal textarea").val(data["result"]);
               helpers.openModal("testLogModal", "big");
            }   
            helpers.endProcessLoadButton($('.actionUpdateInstall'));         
         }
        
      });

      e.preventDefault();

   });

   function checkUpdate(){

      helpers.request({url:"dashboard-uniid-check-update"}, function(data) {

         if(data["status"] == true){
            $(".update-container-info-version").html(data["answer"]);
            $(".update-container-button-install").show();
         }
        
      });      

   }

});
