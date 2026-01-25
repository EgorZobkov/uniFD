public function getHomeReviews($user_id=0){   
    global $app;

    $content = '';

    $getReviews = $app->model->reviews->sort("id desc")->getAll("whom_user_id=? and status=? and parent_id=?", [$user_id,1,0]);

    if($getReviews){
        foreach ($getReviews as $key => $value) {
           
            $value = $app->component->reviews->getDataByValue($value);

            $content .= $app->view->setParamsComponent(['value'=>(object)$value])->includeComponent('items/shop-review-list.tpl');

        }
    }

    return $content;
    
}