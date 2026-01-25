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