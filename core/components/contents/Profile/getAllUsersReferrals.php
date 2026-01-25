public function getAllUsersReferrals($user_id=0){   
    global $app;

    $content = '';
    
    $getUsers = $app->model->users_referrals->pagination(true)->page($_GET['page'])->output(10)->sort("id desc")->getAll("whom_user_id=?", [$user_id]);

    if($getUsers){
        foreach ($getUsers as $key => $value) {
           
            $user = $app->model->users->find('id=?', [$value["from_user_id"]]);

            $content .= $app->view->setParamsComponent(['value'=>(object)$value, 'user'=>$user])->includeComponent('items/profile-referral-grid.tpl');

        }
    }

    return $content;
    
}