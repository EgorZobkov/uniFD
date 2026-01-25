<?php

/**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Components;

class Reviews
{

 public $alias = "reviews";

 public function changeStatus($review_id=0){
    global $app;

    $review = $app->model->reviews->find("id=?", [$review_id]);

    if($review){
        $app->model->reviews->update(["status"=>1],$review_id);
        $app->component->profile->updateRatingAndReviews($review->whom_user_id);
        $app->component->ads->updateRatingAndReviews($review->whom_user_id, $review->item_id);
        $app->event->changeStatusReview(["item_id"=>$review->item_id, "from_user_id"=>$review->from_user_id, "whom_user_id"=>$review->whom_user_id, "status"=>1]);
    }

}

public function countByAdId($data=[]){
    global $app;

    return $app->model->reviews->count("item_id=? and whom_user_id=? and status=? and parent_id=?", [$data->id,$data->user_id,1,0]);

}

public function create($params=[]){
    global $app;

    if($params['order_id']){
        $order = $app->component->transaction->getDealItem($params['order_id']);
        if($order){

            if($order->from_user_id != $params['from_user_id'] && $order->whom_user_id != $params['from_user_id']){
                return false;
            }

            if($order->from_user_id == $params['from_user_id']){
                $params['whom_user_id'] = $order->whom_user_id;
            }else{
                $params['whom_user_id'] = $order->from_user_id;
            }

            $params['item_id'] = $order->item->item_id;

        }else{
            return false;
        }
    }elseif($params['whom_user_id']){

        $chat = $app->model->chat_messages->find("(action=? and from_user_id=? and whom_user_id=? and ad_id=?) or (action=? and from_user_id=? and whom_user_id=? and ad_id=?)", ["user_asks_review",$params['whom_user_id'],$params['from_user_id'],$params['item_id'],"new_review",$params['from_user_id'],$params['whom_user_id'],$params['item_id']]);
        
        if(!$chat){
            return false;
        }

    }else{
        return false;
    }

    $rating = 1;

    if($params['rating']){
        $rating = abs($params['rating']) <= 5 ? abs($params['rating']) : 5;
    }

    $attach_files = $app->storage->uploadAttachFiles($params['attach_files'], $app->config->storage->users->attached);

    $app->model->reviews->insert(["item_id"=>(int)$params['item_id'], "from_user_id"=>(int)$params['from_user_id'], "whom_user_id"=>(int)$params['whom_user_id'], "text"=>$params['text'], "rating"=>$rating, "media"=>$attach_files ? _json_encode($attach_files) : null,"time_create"=>$app->datetime->getDate(),"order_id"=>$params['order_id']?:null]);

    $app->event->createReview(["item_id"=>(int)$params['item_id'], "from_user_id"=>(int)$params['from_user_id'], "whom_user_id"=>(int)$params['whom_user_id'], "text"=>$params['text'], "rating"=>$rating]);

    return true;

}

public function delete($review_id=0, $user_id=0){
    global $app;

    if($user_id){
        $review = $app->model->reviews->find("id=? and from_user_id=?", [$review_id, $user_id]);
    }else{
        $review = $app->model->reviews->find("id=?", [$review_id]);
    }

    if($review){

        if($review->media){
            foreach (_json_decode($review->media) as $key => $value) {
                $app->storage->name($value)->delete();
            }
        }

        $app->model->reviews->delete("id=?", [$review_id]);
        $app->model->reviews->delete("parent_id=?", [$review_id]);

        $app->component->profile->updateRatingAndReviews($review->whom_user_id);
        $app->component->ads->updateRatingAndReviews($review->whom_user_id, $review->item_id);

    }

}

public function getDataByValue($value=[]){
    global $app;

    $value["item"] = $app->component->ads->getAd($value["item_id"]);
    $value["from_user"] = $app->model->users->findById($value["from_user_id"]);
    $value["whom_user"] = $app->model->users->findById($value["whom_user_id"]);

    return (object)$value;

}

public function outAllMediaByItemId($data=[]){
    global $app;

    $result = '';
    $item_key = 0;

    $getReviews = $app->model->reviews->sort("id desc")->getAll("item_id=? and whom_user_id=? and parent_id=? and media is not null", [$data->id,$data->user_id,0]);

    if($getReviews){

        foreach ($getReviews as $key => $value) {

            if($value["media"]){
                foreach (_json_decode($value["media"]) as $item) {
                    $result .= '<a class="container-reviews-media-item uniMediaSliderItem swiper-slide" href="'.$app->storage->name($item)->host(true)->get().'" data-media-type="image" data-media-key="'.$item_key.'" ><img class="image-autofocus" src="'.$app->storage->name($item)->host(true)->get().'" ></a>';
                    $item_key++;
                }
            }

        }

    }

    if($result){
        return '<div class="container-reviews-media uniMediaSliderContainer reviews-media-swiper" ><div class="swiper-wrapper" >' . $result . '</div></div>';
    }

}

public function outAllMediaByUserId($user_id=0){
    global $app;

    $result = '';
    $item_key = 0;

    $getReviews = $app->model->reviews->sort("id desc")->getAll("whom_user_id=? and parent_id=? and media is not null", [$user_id,0]);

    if($getReviews){

        foreach ($getReviews as $key => $value) {

            if($value["media"]){
                foreach (_json_decode($value["media"]) as $item) {
                    $result .= '<a class="container-reviews-media-item uniMediaSliderItem swiper-slide" href="'.$app->storage->name($item)->host(true)->get().'" data-media-type="image" data-media-key="'.$item_key.'" ><img class="image-autofocus" src="'.$app->storage->name($item)->host(true)->get().'" ></a>';
                    $item_key++;
                }
            }

        }

    }

    if($result){
        return '<div class="container-reviews-media uniMediaSliderContainer reviews-media-swiper" ><div class="swiper-wrapper" >' . $result . '</div></div>';
    }

}

public function outInfoRatingByColor($ad=[]){
    global $app;

    if(round($ad->total_rating, 1) >= 4.0){
        return '<div class="label-info-rating-by-color color-rating-green" ><span>'.sprintf("%.1f", $ad->total_rating).'</span> '.$ad->total_reviews.' '.endingWord($ad->total_reviews, translate("tr_22c585f75c24d937f90165dc341b1dbd"), translate("tr_702db99a476541dc4de2d765ee4653ac"), translate("tr_cb704af04e2a3ac14a6eae2f02251d72")).'</div>';
    }
    
    if(round($ad->total_rating, 1) >= 3.0 && round($ad->total_rating, 1) < 4.0){
        return '<div class="label-info-rating-by-color color-rating-yellow" ><span>'.sprintf("%.1f", $ad->total_rating).'</span> '.$ad->total_reviews.' '.endingWord($ad->total_reviews, translate("tr_22c585f75c24d937f90165dc341b1dbd"), translate("tr_702db99a476541dc4de2d765ee4653ac"), translate("tr_cb704af04e2a3ac14a6eae2f02251d72")).'</div>';
    }

    return '<div class="label-info-rating-by-color color-rating-gray" ><span>'.sprintf("%.1f", $ad->total_rating).'</span> '.$ad->total_reviews.' '.endingWord($ad->total_reviews, translate("tr_22c585f75c24d937f90165dc341b1dbd"), translate("tr_702db99a476541dc4de2d765ee4653ac"), translate("tr_cb704af04e2a3ac14a6eae2f02251d72")).'</div>';

}

public function outMedia($media=null){
    global $app;

    if($media){
        ?>

           <div class="container-reviews-list-item-media uniMediaSliderContainer">
                <?php
                foreach (_json_decode($media) as $key => $item) {
                    ?>
                    <a class="container-reviews-list-item-media-photo uniMediaSliderItem" href="<?php echo $app->storage->name($item)->host(true)->get(); ?>" data-media-type="image" data-media-key="<?php echo $key; ?>" ><img class="image-autofocus" src="<?php echo $app->storage->name($item)->host(true)->get(); ?>" ></a>
                    <?php
                }
                ?>
           </div>            

        <?php
    }

}

public function outParentMessages($id=0){
    global $app;

    $parent_reviews = $app->model->reviews->sort("id asc")->getAll("parent_id=?", [$id]);

    if($parent_reviews){

        foreach ($parent_reviews as $parent_value) {

            $from_user = $app->model->users->findById($parent_value["from_user_id"]);

            ?>

              <div class="container-reviews-list-item container-reviews-list-item-parent" >
                
                 <div class="container-reviews-list-item-info" >
                    <div class="container-reviews-list-item-info-block1" > <div class="container-reviews-list-item-info-avatar" ><img class="image-autofocus" src="<?php echo $app->storage->name($from_user->avatar)->host(true)->get(); ?>"></div> </div>
                    <div class="container-reviews-list-item-info-block2" >
                       <span class="container-reviews-list-item-info-name" ><?php echo $app->user->name($from_user,true); ?></span>
                       <span class="container-reviews-list-item-info-date" ><?php echo $app->datetime->outDate($parent_value["time_create"]); ?></span>
                    </div>
                 </div>

                 <div class="container-reviews-list-item-text" >
                  <?php echo $parent_value["text"]; ?>
                 </div>

                 <?php if($parent_value["from_user_id"] == $app->user->data->id){ ?>
                 <span class="btn-custom-mini button-color-scheme6 mt10 actionDeleteReview" data-id="<?php echo $parent_value["id"]; ?>" ><?php echo translate("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8"); ?></span>
                <?php } ?>
                
              </div>

            <?php
        }

    }

}

public function outReviewsByItemId($data=[]){
    global $app;

    $getReviews = $app->model->reviews->sort("id desc")->getAll("item_id=? and whom_user_id=? and parent_id=? and status=?", [$data->id,$data->user_id,0,1]);

    if($getReviews){

        foreach ($getReviews as $key => $value) {

            $from_user = $app->model->users->findById($value["from_user_id"]);
            $parent_reviews = $app->model->reviews->sort("id asc")->getAll("item_id=? and parent_id=?", [$data->id,$value["id"]]);

            ?>

            <div class="container-reviews-list-item" >
              
               <div class="container-reviews-list-item-info" >
                  <div class="container-reviews-list-item-info-block1" > <div class="container-reviews-list-item-info-avatar" ><img class="image-autofocus" src="<?php echo $app->storage->name($from_user->avatar)->host(true)->get(); ?>"></div> </div>
                  <div class="container-reviews-list-item-info-block2" >
                     <span class="container-reviews-list-item-info-name" ><?php echo $app->user->name($from_user,true); ?></span>
                     <span class="container-reviews-list-item-info-date" ><?php echo $app->datetime->outDate($value["time_create"]); ?></span>
                  </div>
                  <div class="container-reviews-list-item-info-block3" >

                    <div class="container-user-rating-stars menu-user-rating-stars" >
                        <?php echo $app->component->profile->outStarsRating($value["rating"]); ?>
                    </div>

                  </div>
               </div>

               <div class="container-reviews-list-item-text" >
                  <?php echo $value["text"]; ?>
               </div>

               <?php echo $this->outMedia($value["media"]); ?>

               <?php if($data->owner){ ?>
               <span class="btn-custom-mini button-color-scheme1 mt10 actionOpenStaticModal" data-modal-target="responseReview" data-modal-params="<?php echo buildAttributeParams(["id"=>$value["id"], "name"=>$app->user->name($from_user,true)]); ?>" ><?php echo translate("tr_e5681e2700570729e8d3a3bf4efa2d5c"); ?></span>
               <?php } ?>
               
               <?php
               if($parent_reviews){

                    foreach ($parent_reviews as $parent_value) {

                        $from_user = $app->model->users->findById($parent_value["from_user_id"]);

                        ?>

                          <div class="container-reviews-list-item container-reviews-list-item-parent" >
                            
                             <div class="container-reviews-list-item-info" >
                                <div class="container-reviews-list-item-info-block1" > <div class="container-reviews-list-item-info-avatar" ><img class="image-autofocus" src="<?php echo $app->storage->name($from_user->avatar)->host(true)->get(); ?>"></div> </div>
                                <div class="container-reviews-list-item-info-block2" >
                                   <span class="container-reviews-list-item-info-name" ><?php echo $app->user->name($from_user,true); ?></span>
                                   <span class="container-reviews-list-item-info-date" ><?php echo $app->datetime->outDate($parent_value["time_create"]); ?></span>
                                </div>
                             </div>

                             <div class="container-reviews-list-item-text" >
                              <?php echo $parent_value["text"]; ?>
                             </div>

                             <?php if($parent_value["from_user_id"] == $app->user->data->id){ ?>
                             <span class="btn-custom-mini button-color-scheme6 mt10 actionDeleteReview" data-id="<?php echo $parent_value["id"]; ?>" ><?php echo translate("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8"); ?></span>
                            <?php } ?>
                            
                          </div>

                        <?php
                    }

               }
               ?>

            </div>                

            <?php
        }


    }

}

public function outReviewsFromUser($value, $response=true){
     global $app;

     ?>

        <div class="container-reviews-list-item-info" >
           <div class="container-reviews-list-item-info-block1" > <div class="container-reviews-list-item-info-avatar" ><img class="image-autofocus" src="<?php echo $app->storage->name($value->from_user->avatar)->host(true)->get(); ?>"></div> </div>
           <div class="container-reviews-list-item-info-block2" >
              <span class="container-reviews-list-item-info-name" >             
                 <?php echo $app->user->name($value->from_user,true); ?> <span class="container-reviews-list-item-info-name-and-date" ><?php echo $app->datetime->outDate($value->time_create); ?></span> 
             </span>
              <span class="container-reviews-list-item-info-title" ><?php echo $value->item->title; ?></span>
           </div>
           <div class="container-reviews-list-item-info-block3" >

             <div class="container-user-rating-stars menu-user-rating-stars" >
                 <?php echo $app->component->profile->outStarsRating($value->rating); ?>
             </div>

           </div>
        </div>

        <div class="container-reviews-list-item-text" >
           <?php echo $value->text; ?>
        </div>

        <?php echo $this->outMedia($value->media); ?>

        <?php if($response){ ?>

        <?php if($value->whom_user->id == $app->user->data->id){ ?>
        <span class="btn-custom-mini button-color-scheme1 mt10 actionOpenStaticModal" data-modal-target="responseReview" data-modal-params="<?php echo buildAttributeParams(["id"=>$value->id, "name"=>$app->user->name($value->from_user,true)]); ?>" ><?php echo translate("tr_e5681e2700570729e8d3a3bf4efa2d5c"); ?></span>
        <?php } ?>
        
        <?php echo $this->outParentMessages($value->id); ?>

        <?php } ?>

     <?php

 }

public function outReviewsWhomUser($value){
     global $app;

     ?>

        <div class="container-reviews-list-item-info" >
           <div class="container-reviews-list-item-info-block1" > <div class="container-reviews-list-item-info-avatar" ><img class="image-autofocus" src="<?php echo $app->storage->name($value->whom_user->avatar)->host(true)->get(); ?>"></div> </div>
           <div class="container-reviews-list-item-info-block2" >
              <span class="container-reviews-list-item-info-name" >
                 <?php if($value->status == 0){ ?>
                 <div>
                   <span class="status-label status-label-color-warning"><?php echo translate("tr_d9d74d385363cf3fdf9c1e62b484acca"); ?></span>
                 </div>  
                 <?php } ?>              
                 <?php echo $app->user->name($value->whom_user,true); ?> <span class="container-reviews-list-item-info-name-and-date" ><?php echo $app->datetime->outDate($value->time_create); ?></span> 
             </span>
              <span class="container-reviews-list-item-info-title" ><?php echo $value->item->title; ?></span>
           </div>
           <div class="container-reviews-list-item-info-block3" >

             <div class="container-user-rating-stars menu-user-rating-stars" >
                 <?php echo $app->component->profile->outStarsRating($value->rating); ?>
             </div>

           </div>
        </div>

        <div class="container-reviews-list-item-text" >
           <?php echo $value->text; ?>
        </div>

        <?php echo $this->outMedia($value->media); ?>

        <?php if($value->from_user->id == $app->user->data->id){ ?>
        <span class="btn-custom-mini button-color-scheme6 mt10 actionDeleteReview" data-id="<?php echo $value->id; ?>" ><?php echo translate("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8"); ?></span>
        <?php } ?>
        
        <?php echo $this->outParentMessages($value->id); ?>

     <?php

 }

public function responseCreate($params=[]){
    global $app;

    $review = $app->model->reviews->find("id=? and status=? and (from_user_id=? or whom_user_id=?)", [$params["review_id"],1,$params["user_id"],$params["user_id"]]);

    if($params["text"] && $review){
        $app->model->reviews->insert(["item_id"=>$review->item_id, "from_user_id"=>$params["user_id"], "whom_user_id"=>$review->from_user_id, "text"=>$params["text"], "time_create"=>$app->datetime->getDate(), "parent_id"=>$params["review_id"], "status"=>1]);
        $app->event->createResponseReview(["item_id"=>$review->item_id, "from_user_id"=>$params["user_id"], "whom_user_id"=>$review->from_user_id]);
    }

}



}