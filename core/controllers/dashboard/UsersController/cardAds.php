public function cardAds($id)
{   

    if(!$this->user->setUserId($id)->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/users.js\" type=\"module\" ></script>"]);
    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/ads.js\" type=\"module\" ></script>"]);

    $data = $this->model->users->findById($id, true);

    if(!$data || $data->delete){
        $this->router->goToRoute("dashboard-users");
    }

    $this->view->setParamsComponent(["data"=>$data, "breadcrumbs"=>["chain"=>[translate("tr_b8c4e70da7bea88961184a1c1be9cb13")=>$this->router->getRoute("dashboard-users"), $data->short_name=>null, translate("tr_083ab3d9a9221cf6a1641c2c7c5f0d3c")=>null]]]);

    $this->view->setParamsPreload(["user_id"=>$id]);

    return $this->view->preload('users/user-card-ads', ["data"=>$data,"title"=>translate("tr_083ab3d9a9221cf6a1641c2c7c5f0d3c")]);

}