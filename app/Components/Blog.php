<?php

/**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Components;

class Blog
{

 public $alias = "blog";
 public $data = [];

 public function buildAliasesPostCard($data=[]){
    global $app;

    $data = (array)$data;

    $chain = $app->component->blog_categories->chainCategory($data["category_id"]);

    return outLink('blog/' . $chain->chain_build_alias_dash . '/' . translateFieldReplace($data, "alias") . '-' . $data["id"]);
    
}

public function countPostsByIdCategory($category_id=0){
    global $app;

    return $app->model->blog_posts->count("category_id IN(".$app->component->blog_categories->joinId($category_id)->getParentIds($category_id).")");

}

public function delete($id=0){
    global $app;

    $data = $app->model->blog_posts->find("id=?", [$id]);

    if($data){

        $app->storage->name($data->image)->delete();
        $app->model->blog_posts->delete("id=?", [$id]);

    }

}

public function fixView($post_id=0, $user_id=0, $ip=null){
    global $app;

    if($user_id){

        $get = $app->model->blog_posts_views->find("user_id=? and post_id=?", [$user_id, $post_id]);
        
        if(!$get){
            $app->model->blog_posts_views->insert(["post_id"=>$post_id, "user_id"=>$user_id, "ip"=>getIp(), "time_create"=>$app->datetime->getDate()]);
        }

    }elseif($ip){

        if(isBot(getUserAgent())){
            return;
        }

        $get = $app->model->blog_posts_views->find("ip=? and post_id=? and date(time_create)=?", [$ip, $post_id, $app->datetime->format("Y-m-d")->getDate()]);

        if(!$get){
            $app->model->blog_posts_views->insert(["post_id"=>$post_id, "ip"=>$ip, "time_create"=>$app->datetime->getDate()]);
        }

    }
    
}

public function getViews($post_id=0){
    global $app;

    return $app->model->blog_posts_views->count("post_id=?", [$post_id]);

}

public function getViewsToday($post_id=0){
    global $app;

    return $app->model->blog_posts_views->count("post_id=? and date(time_create)=?", [$post_id,$app->datetime->format("Y-m-d")->getDate()]);

}

public function multiDelete($ids=0){
    global $app;

    if($ids){
        foreach ($ids as $key => $value) {
            $this->delete($value);
        }
    }

}

public function outBreadcrumb(){
    global $app;

    $result = '';
    $position = 3;

    if($this->data->category){
        foreach ($this->data->category->chain->chain_array as $value) {
       
            $result .= '
                <li class="breadcrumb-item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                  <a itemprop="item" href="'.$app->component->blog_categories->buildAliases($value).'"><span itemprop="name">'.translateFieldReplace($value, "name").'</span></a><meta itemprop="position" content="'.$position.'">
                </li>
            ';

            $position++;
        }
    }

    return $result;

}

public function outBreadcrumbInPost($category_id=0){
    global $app;

    $result = '';
    $position = 3;

    $chain = $app->component->blog_categories->chainCategory($category_id);

    foreach ($chain->chain_array as $value) {
   
        $result .= '
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
              <a itemprop="item" href="'.$app->component->blog_categories->buildAliases($value).'"><span itemprop="name">'.translateFieldReplace($value, "name").'</span></a><meta itemprop="position" content="'.$position.'">
            </li>
        ';

        $position++;
    }

    return $result;

}

public function outCardPosts($id=0,$count=4){
    global $app;

    $data = $app->model->blog_posts->sort("id desc limit 50")->getAll("status=? and id!=?", [1,$id]);
    if($data){

        shuffle($data);

        foreach (array_slice($data, 0, $count) as $key => $value) {

            echo $app->view->setParamsComponent(['value'=>(object)$value])->includeComponent('items/post.tpl');

        }

    }

}

public function outContent($data=[]){
    global $app;

    if($data->content){

        foreach (_json_decode(translateFieldReplace($data, "content")) as $key => $nested) {
            foreach ($nested as $type => $value) { 
                
                if($type == "image"){

                    ?>
                    <section class="blog-content-image" >
                        <div>
                            <img src="<?php echo $app->storage->name($value)->host(true)->get(); ?>" alt="<?php echo translateFieldReplace($data, "title"); ?>" >
                        </div>
                    </section>
                    <?php

                }elseif($type == "link_video"){

                    $video = $app->video->parseLinkSource($value);

                    if($video){
                        ?>
                        <section class="blog-content-iframe" >
                            <div>
                             <iframe
                                src="<?php echo $video->link; ?>"
                                allowfullscreen
                                allowtransparency
                              ></iframe> 
                            </div>                       
                        </section>
                        <?php
                    }else{
                        ?>
                        <section class="blog-content-iframe" >
                            <div>
                            <video class="blog-post-plyr-video" playsinline controls >
                             <iframe
                                src="<?php echo $value; ?>"
                                allowfullscreen
                                allowtransparency
                              ></iframe>
                            </video>  
                            </div>                      
                        </section>
                        <?php                            
                    }
                    
                }elseif($type == "text"){

                    ?>
                    <section class="blog-content-text" >
                    <p><?php echo outTextWithLinks(urldecode($value), false); ?></p>
                    </section>
                    <?php
                    
                }elseif($type == "code"){
                    
                    ?>
                    <section class="blog-content-code-text" >
                    <?php echo $value; ?>
                    </section>
                    <?php

                }elseif($type == "separator"){
                    
                    ?>
                    <section class="blog-content-separator" >
                    <hr>
                    </section>
                    <?php

                }

            }
        }

    }

}

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



}