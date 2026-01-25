public function getFavorites($user_id=0){   
    global $app;

    $content = '';

    $data = $app->model->users_favorites->pagination(true)->page($_GET['page'])->output(60)->sort("id desc")->getAll("user_id=?", [$user_id]);

    if($data){
        foreach ($data as $key => $value) {
           
            $value = $app->component->ads->getAd($value["ad_id"]);

            $content .= $app->view->setParamsComponent(['value'=>(object)$value])->includeComponent('items/profile-ads-grid.tpl');

        }
    }

    return $content;
    
}