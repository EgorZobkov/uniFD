public function viewCss($template_name)
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerCss(["view"=>"dashboard", "name"=>"<link rel=\"stylesheet\" href=\"{assets_path}/vendors/codemirror/codemirror.css\" />"]);
    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/vendors/codemirror/codemirror.js\" ></script>"]);
    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/templates.js\" type=\"module\" ></script>"]);

    if(!$this->component->templates->fileExists($template_name, "css")){
        abort(404);
    }

    $data = (object)[];

    $data->template_name = $template_name;
    $data->content = $this->component->templates->include($template_name, "css");
    $data->filepath = getRelativePath($this->config->resource->assets->web->css.'/'.$template_name.'.css');
    $data->filename = $template_name.'.css';

    $this->view->setParamsComponent(["data"=>(object)$data, "breadcrumbs"=>["chain"=>[translate("tr_74ff549c01bf978d89857d678258a717")=>$this->router->getRoute("dashboard-templates"), $template_name=>null],"route_name"=>"dashboard-templates","page_name"=>translate("tr_74ff549c01bf978d89857d678258a717")]]);

    return $this->view->preload('templates/view-css', ["title"=>translate("tr_74ff549c01bf978d89857d678258a717"),"data"=>(object)$data]);

}