import Helpers from './helpers.class.js';

$(document).ready(function () {
   
   const helpers = new Helpers();

   var uploadFiles = [];
   var uploadKey = 0;
   var uploadRoute = null;
   var parentContainer = null;

   $(document).on('click','.uniAttachFilesDeleteItem', function () {  
      $(this).parents(".uni-attach-files-item").remove().hide();
   });

   $(document).on('click','.uniAttachFilesChange', function () { uniAttachFilesChange($(this)); });

   $(document).on('change','.uniAttachFilesInput', function () {  

      var countFiles = $(this)[0].files.length < 10 ? $(this)[0].files.length : 10;

      for(var i = 0; i < countFiles; i++){

          var uniqid = helpers.generateStr(32);

            $("."+parentContainer).find(".uni-attach-files-container").append(`
                  <div class="uni-attach-files-item uni-attach-files-item-in-load`+uniqid+`" >
                    <div class="uni-attach-files-item-loader" ><span class="spinner-border me-1" role="status" aria-hidden="true"></span></div>
                  </div>
            `).show();

            uploadFiles.push({"key": uniqid, "file": $(this)[0].files[i]});

      }

      $(this).val("");

      uniAttachFilesUpload(uploadFiles[uploadKey]);

      $("."+parentContainer).find(".uni-attach-files-container").show();   

   });

  function uniAttachFilesChange(selector=null){

      uploadRoute = selector.data("upload-route");
      parentContainer = selector.data("parent-container");

      $(".uniAttachFilesInput").remove();

      if(selector.data("accept") == "images"){
        $("body").append('<input type="file" accept=".jpg,.jpeg,.png" multiple="true" style="display: none;" class="uniAttachFilesInput">');
      }

      $(".uniAttachFilesInput").click();
      
  }

  function uniAttachFilesUpload(arrayFile=null){

      if(arrayFile){

          var formData = new FormData();

          formData.append('attach_files', arrayFile.file);

          helpers.request({url:uploadRoute, data: formData, contentType: false, processData: false}, function(data) {

             if(data["content"] != ""){
                $("."+parentContainer).find(".uni-attach-files-item-in-load"+arrayFile.key).html(data["content"]);
             }else{
                $("."+parentContainer).find(".uni-attach-files-item-in-load"+arrayFile.key).remove();
             }

             uploadKey++;

             if(uploadFiles[uploadKey]){
                uniAttachFilesUpload(uploadFiles[uploadKey]);
             }

          });   

      }

  }

});