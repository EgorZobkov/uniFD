
public function main()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/categories.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_6926e02be4135897ae84b36941554684")=>$this->router->getRoute("dashboard-ads-categories")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_e00f391c7735dc851cfed26cbd6bbfb7"),"page_icon"=>"ti-list","favorite_status"=>true]]);

    return $this->view->preload('board/ads-categories', ["title"=>translate("tr_6926e02be4135897ae84b36941554684")]);

}
