 public function content($data=[],$page_id=0){
    global $app;

    $content = [];

    if($page_id){

        $content = $this->getContent($page_id, $this->langIso);

    }else{

        if($data->filter_link){

            $content["meta_title"] = translateFieldReplace($data->filter_link, "seo_title");
            $content["meta_desc"] = translateFieldReplace($data->filter_link, "seo_desc");
            $content["h1"] = translateFieldReplace($data->filter_link, "seo_h1");
            $content["text"] = translateFieldReplace($data->filter_link, "seo_text");

        }else{

            $page = $app->model->template_pages->find("route_name=?", [$app->router->currentRoute->name]);

            $content = $this->getContent($page->id, $this->langIso);

            if($app->router->currentRoute->name == "catalog"){
                if($app->component->catalog->data->category){
                    return $this->replaceData($content->category);
                }else{
                    return $this->replaceData($content->not_category);
                }
            }elseif($app->router->currentRoute->name == "blog"){
                if($app->component->blog->data->category){
                    return $this->replaceData($content->category);
                }else{
                    return $this->replaceData($content->not_category);
                }
            }elseif($app->router->currentRoute->name == "shop-catalog"){
                if($data->category){
                    return $this->replaceData($content->category,$data);
                }else{
                    return $this->replaceData($content->not_category,$data);
                }
            }

        }

    }

    return $this->replaceData($content, $data);
}