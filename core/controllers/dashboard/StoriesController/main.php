public function main()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/stories.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_b84af1c46baa36df4513d427a6e0715a")=>$this->router->getRoute("dashboard-stories")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_b84af1c46baa36df4513d427a6e0715a"),"page_icon"=>"ti-movie","favorite_status"=>true]]);

    return $this->view->preload('stories/stories', ["data"=>(object)$data, "title"=>translate("tr_b84af1c46baa36df4513d427a6e0715a")]);

}