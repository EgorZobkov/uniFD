public function mainCatalogTplBody(){
    global $app;

    if(file_exists($app->config->resource->view->web->path."/catalog.tpl")){
        return _file_get_contents($app->config->resource->view->web->path."/catalog.tpl");
    }

    return $this->defaultTplBody();

}