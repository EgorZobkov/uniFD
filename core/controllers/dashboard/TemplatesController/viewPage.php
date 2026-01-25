public function viewPage($id)
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerCss(["view"=>"dashboard", "name"=>"<link rel=\"stylesheet\" href=\"{assets_path}/vendors/codemirror/codemirror.css\" />"]);
    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/vendors/codemirror/codemirror.js\" ></script>"]);
    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/templates.js\" type=\"module\" ></script>"]);

    $data = (object)[];

    $data = $this->model->template_pages->find("id=?", [$id]); 

    if(!$data || !$this->component->templates->fileExists($data->template_name, "pages")){
        abort(404);
    }

    $data->content = $this->component->templates->include($data->template_name, "pages");
    $data->filepath = getRelativePath($this->config->resource->view->web->path.'/'.$data->template_name.'.tpl');
    $data->filename = $data->template_name.'.tpl';

    if($data->alias){
        $data->link = $data->freeze == 0 ? getHost(true) . '/' . $data->alias : null;
    }else{
        $data->link = null;
    }

    $this->view->setParamsComponent(["data"=>(object)$data, "breadcrumbs"=>["chain"=>[translate("tr_74ff549c01bf978d89857d678258a717")=>$this->router->getRoute("dashboard-templates"), translateField($data->name)=>null],"route_name"=>"dashboard-templates","page_name"=>translate("tr_74ff549c01bf978d89857d678258a717")]]);

    return $this->view->preload('templates/view-page', ["title"=>translate("tr_74ff549c01bf978d89857d678258a717"),"data"=>(object)$data]);

}