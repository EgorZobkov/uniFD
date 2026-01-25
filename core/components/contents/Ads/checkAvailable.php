public function checkAvailable($item_id=0){
    global $app;

    $getAd = $app->model->ads_data->find("id=?", [$item_id]);

    if(!$getAd->not_limited){

        if($getAd->in_stock){
            return true;
        }else{
            return false;
        }

    }

    return true;

}