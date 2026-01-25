public function card($id)
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();

    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/seo.js\" type=\"module\" ></script>"]);

    $data = $this->model->template_pages->find("id=?", [$id]);

    if(!$data){
        abort(404);
    }

    if($_POST['iso']){
        $data->lang_iso = $_POST['iso'];
    }else{
        $data->lang_iso = $this->settings->default_language;
    }

    $data->content = $this->component->seo->getContent($id, $data->lang_iso);

    $this->view->setParamsComponent(["data"=>(object)$data, "breadcrumbs"=>["chain"=>[translate("tr_67a30d0847a390ae56549987bb2d469a")=>$this->router->getRoute("dashboard-seo")],"route_name"=>"dashboard-seo","page_name"=>translate("tr_67a30d0847a390ae56549987bb2d469a"),"page_icon"=>"ti-template","favorite_status"=>true]]);

    $this->view->setParamsPreload(["id"=>$id]);

    return $this->view->preload('seo/card', ["title"=>translate("tr_67a30d0847a390ae56549987bb2d469a"), "data"=>(object)$data]);

}