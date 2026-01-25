
import Helpers from '../helpers.class.js';

$(document).ready(function () {

   const helpers = new Helpers();

   var thisContent;

   helpers.loadBody(null,function() {

      var el = document.getElementById('blog-post-content-container');
      var sortable = Sortable.create(el, {
         handle: ".actionMoveItemContentBlog",     
      });

      updateInlineEditor();
      updateTextarea();

   });

   $(document).on('click', function(e) { 

      if(!$(e.target).closest(".actionChangeItemContentBlog").length && !$(e.target).closest(".blog-post-content-change-items").length) {
          $(".blog-post-content-list-items").hide();
      }

      e.stopPropagation();

   });

   $(document).on('click','.actionPostsMultiDelete', function (e) {  

      helpers.showUiLoadingScreen();

      helpers.request({url:"dashboard-blog-post-multi-delete", data: $(".formItemsList").serialize()}, function(data) {

         location.reload();

      });

      e.preventDefault();

   });

   function updateInlineEditor(){

      if($(".blog-post-content-item-inline-editor:not(.inline-editor-init)").length){
           $(".blog-post-content-item-inline-editor:not(.inline-editor-init)").each(function(index,item){

               $(item).addClass("inline-editor-init");

               ClassicEditor.create( document.querySelector( "#"+$(item).attr("id") ), {
                  toolbar: {
                    items: [
                      'heading',
                      '|',
                      'bold',
                      'italic',
                      'link',
                      'bulletedList',
                      'numberedList',
                      '|',
                      'indent',
                      'outdent',
                      '|',
                      'blockQuote',
                      'insertTable',
                      'undo',
                      'redo',
                      'fontColor',
                      'fontSize'
                    ]
                  },
                  image: {
                    toolbar: [
                      'imageTextAlternative',
                      'imageStyle:full',
                      'imageStyle:side'
                    ]
                  },
                  table: {
                    contentToolbar: [
                      'tableColumn',
                      'tableRow',
                      'mergeTableCells'
                    ]
                  },
                  
                } )
                .then( editor => {
                    theEditor = editor;
                } )
                .catch( error => {

                } );

           });

      }

   }

   function updateTextarea(){

      if($(".blog-post-content-item-textarea").length){
           $(".blog-post-content-item-textarea").each(function(index,item){
               this.style.height = 'auto';
               this.style.height = (this.scrollHeight-4) + 'px';        
           });
      }

   }

   $(document).on('submit','.formAddPost', function (e) {  

      $('.formAddPost .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonAddPost'));
      
      helpers.request({url:"dashboard-blog-post-add", data: $(".formAddPost").serialize(), button: $('.buttonAddPost')}, function(data) {

         if(data["status"] == true){
            location.href = data["redirect"];
         }else{
            helpers.formNoticeManager($('.formAddPost'), data);
            helpers.endProcessLoadButton($('.buttonAddPost'));
         }

      });

      e.preventDefault();

   });

   $(document).on('submit','.formEditPost', function (e) {  

      $('.formEditPost .form-label-error').hide();

      helpers.startProcessLoadButton($('.buttonSaveEditPost'));
      
      helpers.request({url:"dashboard-blog-post-edit", data: $(".formEditPost").serialize(), button: $('.buttonSaveEditPost')}, function(data) {

         if(data["status"] == true){

            helpers.hideModal("loadContentModal");

         }

         helpers.formNoticeManager($('.formEditPost'), data);
         helpers.endProcessLoadButton($('.buttonSaveEditPost'));

      });

      e.preventDefault();

   });

   $(document).on('click','.deletePost', function (e) {  

      helpers.deleteByAlert("dashboard-blog-post-delete",{id:$(this).data("id")});

      e.preventDefault();

   });
   
   $(document).on('click','.loadEditPost', function (e) {  

      helpers.openModal("loadContentModal", "medium");

      helpers.request({url:"dashboard-blog-post-load-edit", data: {id:$(this).data("id")}}, function(data) {

         $("#loadContentModal .load-content-container").html(data["content"]);

      });

      e.preventDefault();

   });

   $(document).on('click','.actionChangeItemContentBlog', function (e) {  

      $(".blog-post-content-list-items").toggle();

      e.preventDefault();

   });

   $(document).on('click','.actionDeleteItemContentBlog', function (e) {  

      $(this).parents(".blog-post-content-item").remove();

      e.preventDefault();

   });

   $(document).on('input','.blog-post-content-item textarea', function (e) {  

      this.style.height = 'auto';
      this.style.height = (this.scrollHeight-4) + 'px';

      e.preventDefault();

   });

   $(document).on('click','.actionAddItemContentBlog', function (e) {  

      $(".blog-post-content-list-items").hide();

      if($(this).data("type") == "image"){

         $(".blog-post-content-container").append(`

             <section class="blog-post-content-item" >
               <div class="row" >
                 <div class="col-md-8" >

                   <div class="blog-post-content-item-flex" >
                     <div class="blog-post-content-item-flex-block1" >
                       
                       <span class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light actionDeleteItemContentBlog" >
                         <i class="ti ti-xs ti-trash"></i>
                       </span>

                       <span class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light actionMoveItemContentBlog" >
                         <i class="ti ti-menu-order"></i>
                       </span>

                     </div>
                     <div class="blog-post-content-item-flex-block2" >

                       <span class="btn btn-primary buttonChangeImageBlogPostContent" >`+helpers.translate.content("tr_346e125feb343c46c0b833c320bea4cf")+`</span>
                       <div class="blog-post-content-item-image-container"></div>
                       <input type="hidden" name="content[][image]" >

                     </div>
                   </div>

                 </div>
               </div>
             </section>

         `);

      }else if($(this).data("type") == "link_video"){

         $(".blog-post-content-container").append(`

             <section class="blog-post-content-item" >
               <div class="row" >
                 <div class="col-md-8" >

                   <div class="blog-post-content-item-flex" >
                     <div class="blog-post-content-item-flex-block1" >
                       
                       <span class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light actionDeleteItemContentBlog" >
                         <i class="ti ti-xs ti-trash"></i>
                       </span>

                       <span class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light actionMoveItemContentBlog" >
                         <i class="ti ti-menu-order"></i>
                       </span>

                     </div>
                     <div class="blog-post-content-item-flex-block2" >
                       <input type="text" name="content[][link_video]" placeholder="`+helpers.translate.content("tr_2bc5310f23302c852c02348e3dafe75a")+`" >
                       <div class="blog-post-content-item-hidden-text" ></div>
                     </div>
                   </div>

                 </div>
               </div>
             </section>

         `);

      }else if($(this).data("type") == "text"){

         $(".blog-post-content-container").append(`

             <section class="blog-post-content-item" >
               <div class="row" >
                 <div class="col-md-8" >

                   <div class="blog-post-content-item-flex" >
                     <div class="blog-post-content-item-flex-block1" >
                       
                       <span class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light actionDeleteItemContentBlog" >
                         <i class="ti ti-xs ti-trash"></i>
                       </span>

                       <span class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light actionMoveItemContentBlog" >
                         <i class="ti ti-menu-order"></i>
                       </span>

                     </div>
                     <div class="blog-post-content-item-flex-block2" >
                       <textarea name="content[][text]" id="inline-editor-`+helpers.generateStr()+`" class="blog-post-content-item-inline-editor" >`+helpers.translate.content("tr_2baec2686eed64fc34226dedf0a35a81")+`</textarea>
                    
                     </div>
                   </div>

                 </div>
               </div>
             </section>

         `);

      }else if($(this).data("type") == "code"){

         $(".blog-post-content-container").append(`

             <section class="blog-post-content-item" >
               <div class="row" >
                 <div class="col-md-8" >

                   <div class="blog-post-content-item-flex" >
                     <div class="blog-post-content-item-flex-block1" >
                       
                       <span class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light actionDeleteItemContentBlog" >
                         <i class="ti ti-xs ti-trash"></i>
                       </span>

                       <span class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light actionMoveItemContentBlog" >
                         <i class="ti ti-menu-order"></i>
                       </span>

                     </div>
                     <div class="blog-post-content-item-flex-block2" >
                       <textarea name="content[][code]" placeholder="`+helpers.translate.content("tr_3f34a617ceca19426da3343d81fe9ac0")+`" class="form-control" ></textarea>
                       <div class="blog-post-content-item-hidden-text" ></div>
                     </div>
                   </div>

                 </div>
               </div>
             </section>

         `);

      }else if($(this).data("type") == "separator"){

         $(".blog-post-content-container").append(`

             <section class="blog-post-content-item" >
               <div class="row" >
                 <div class="col-md-8" >

                   <div class="blog-post-content-item-flex" >
                     <div class="blog-post-content-item-flex-block1" >
                       
                       <span class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light actionDeleteItemContentBlog" >
                         <i class="ti ti-xs ti-trash"></i>
                       </span>

                       <span class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light actionMoveItemContentBlog" >
                         <i class="ti ti-menu-order"></i>
                       </span>

                     </div>
                     <div class="blog-post-content-item-flex-block2" >
                       <hr>
                       <input type="hidden" name="content[][separator]" value="separator" >
                     </div>
                   </div>

                 </div>
               </div>
             </section>

         `);

      }

      updateInlineEditor();

      e.preventDefault();

   });

   $(document).on('submit','.blog-post-content-form', function (e) {  

      helpers.startProcessLoadButton($('.buttonSaveBlogPostContent'));

      helpers.request({url:"dashboard-blog-post-content-save", data: {content: encodeURIComponent($('.blog-post-content-form').serialize())}, button: $('.buttonSaveBlogPostContent')}, function(data) {

         helpers.showNoticeAnswer(data["answer"]);
         helpers.endProcessLoadButton($('.buttonSaveBlogPostContent'));

      });

      e.preventDefault();

   });

   $(document).on('input','.blog-post-content-item textarea, .blog-post-content-item input', function (e) {  

      $(this).parents(".blog-post-content-item").find(".blog-post-content-item-hidden-text").html($(this).val());

      e.preventDefault();

   });

   $(document).on('click','.buttonChangeImageBlogPostContent', function (e) {

      thisContent = $(this).parents(".blog-post-content-item");

      $(".inputChangeImageBlogPostContent").remove();

      $("body").append('<input type="file" accept=".jpg,.jpeg,.png" style="display: none;" class="inputChangeImageBlogPostContent">');

      $(".inputChangeImageBlogPostContent").click();

      e.preventDefault(); 

   });

   $(document).on('change','.inputChangeImageBlogPostContent', function (e) { 

      var formData = new FormData();

      helpers.startProcessLoadButton(thisContent.find(".buttonChangeImageBlogPostContent"));

      formData.append('attach_files', $(this)[0].files[0]);

      helpers.request({url:"dashboard-blog-post-upload-image", data: formData, contentType: false, processData: false, button: thisContent.find(".buttonChangeImageBlogPostContent")}, function(data) { 

         helpers.endProcessLoadButton(thisContent.find(".buttonChangeImageBlogPostContent"));

         if(data["status"] == true){
            thisContent.find(".buttonChangeImageBlogPostContent").remove();
            thisContent.find(".blog-post-content-item-image-container").append(`<img src="`+data["path"]+`" />`);
            thisContent.find("input").val(data["clear_path"]);
         }

      });

      e.preventDefault(); 

   });


});
