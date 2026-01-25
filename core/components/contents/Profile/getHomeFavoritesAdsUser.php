public function getHomeFavoritesAdsUser($user_id=0){   
    global $app;

    $content = '';

    $getFavorites = $app->model->users_favorites->sort("id desc limit 4")->getAll("user_id=?", [$user_id]);
    if($getFavorites){
        foreach ($getFavorites as $key => $value) {
           
            $getAd = $app->component->ads->getAd($value["ad_id"]);
            if($getAd){
                $content .= $app->view->setParamsComponent(['value'=>$getAd])->includeComponent('items/home-profile-grid.tpl');
            }

        }
    }

    return $content;
    
}