public function getSubscriptions($user_id=0){   
    global $app;

    $content = '';

    $data = $app->model->users_subscriptions->pagination(true)->page($_GET['page'])->output(30)->sort("id desc")->getAll("user_id=?", [$user_id]);

    if($data){
        foreach ($data as $key => $value) {
           
            $user = $app->model->users->cacheKey(["id"=>$value["whom_user_id"]])->find("id=?", [$value["whom_user_id"]]);

            $content .= $app->view->setParamsComponent(['user'=>(object)$user])->includeComponent('items/user-grid.tpl');

        }
    }

    return $content;
    
}