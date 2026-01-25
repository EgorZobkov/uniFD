public function changeStatusShop($data = []){
    global $app;

    if($data["status"] == "published"){
        $app->notify->params((array)$data)->userId($data["user_id"])->code("user_shop_published")->addWaiting();
    }else{
        $app->notify->params((array)$data)->userId($data["user_id"])->code("user_shop_rejected")->addWaiting();
    }

}