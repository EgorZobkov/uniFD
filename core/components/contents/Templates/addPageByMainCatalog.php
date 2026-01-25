public function addPageByMainCatalog($name=""){
    global $app;

    $filename = md5(uniqid());

    if(_file_put_contents($app->config->resource->view->web->path.'/'.$filename.'.tpl', $this->mainCatalogTplBody())){
        $insert_id = $app->model->template_pages->insert(["status"=>1, "name"=>$name, "template_name"=>$filename, "edit_status"=>0]);
        $app->model->seo_content->insert(["page_id"=>$insert_id]);
        return $insert_id; 
    }       

}