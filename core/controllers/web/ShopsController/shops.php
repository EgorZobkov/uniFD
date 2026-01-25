public function shops()
{   

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/shops.js\" type=\"module\" ></script>"]);

    $data = (object)[];

    if(!$this->settings->shops_status){
        abort(404);
    }

    $seo = $this->component->seo->content($data);

    return $this->view->render('shops', ["data"=>(object)$data, "seo"=>$seo]);

}