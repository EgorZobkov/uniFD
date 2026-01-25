public function outContentDashboard($content=null){
    global $app;

    if($content){

        foreach (_json_decode($content) as $key => $nested) {
            foreach ($nested as $type => $value) { 
                
                if($type == "image"){

                    ?>
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

                               <div class="blog-post-content-item-image-container"><img src="<?php echo $app->storage->name($value)->host(true)->get(); ?>"></div>
                               <input type="hidden" name="content[][image]" value="<?php echo $value; ?>" >

                             </div>
                           </div>

                         </div>
                       </div>
                     </section>
                    <?php

                }elseif($type == "link_video"){

                    ?>
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
                               <input type="text" name="content[][link_video]" placeholder="<?php echo translate("tr_2bc5310f23302c852c02348e3dafe75a"); ?>" value="<?php echo $value; ?>" >
                             </div>
                           </div>

                         </div>
                       </div>
                     </section>
                    <?php
                    
                }elseif($type == "text"){

                    ?>
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
                               <textarea name="content[][text]" id="inline-editor-<?php echo mt_rand(100000,999999); ?>" class="blog-post-content-item-inline-editor" ><?php echo htmlspecialchars(urldecode($value), ENT_QUOTES, 'UTF-8'); ?></textarea>
                             </div>
                           </div>

                         </div>
                       </div>
                     </section>
                    <?php
                    
                }elseif($type == "code"){
                    
                    ?>
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
                               <textarea name="content[][code]" placeholder="<?php echo translate("tr_a759da84e452911705c964beb95b319c"); ?>" class="blog-post-content-item-textarea" ><?php echo htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); ?></textarea>
                               <div class="blog-post-content-item-hidden-text" ></div>
                             </div>
                           </div>

                         </div>
                       </div>
                     </section>
                    <?php

                }elseif($type == "separator"){
                    
                    ?>
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
                    <?php

                }

            }
        }

    }

}