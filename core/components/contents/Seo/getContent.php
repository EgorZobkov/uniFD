public function getContent($page_id=0, $lang_iso=null){
    global $app;

    if(!$lang_iso){
        $lang_iso = $app->settings->default_language;
    }

    $content = [];

    $data = $app->model->seo_content->find("page_id=?", [$page_id]); 
    if($data){
        $content = _json_decode($data->content);
    }

    $content[$lang_iso]["text"] = urldecode($content[$lang_iso]["text"]);

    return arrayToObject($content[$lang_iso]);

}