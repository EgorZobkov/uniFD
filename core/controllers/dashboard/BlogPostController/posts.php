public function posts()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/blog.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_40479311ccd23f5d64eb927684429cbb")=>$this->router->getRoute("dashboard-blog-posts")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_40479311ccd23f5d64eb927684429cbb"),"page_icon"=>"ti-article","favorite_status"=>true]]);

    return $this->view->preload('blog/posts', ["title"=>translate("tr_40479311ccd23f5d64eb927684429cbb")]);

}