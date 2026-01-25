public function publicationSuccess($id){   

    $this->view->visible_header = false;
    $this->view->visible_footer = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/ad_paid_services.js\" type=\"module\" ></script>"]);

    $data = $this->component->ads->getAd($id);
    if(!$data){
        abort(404);
    }else{
        if($data->user_id != $this->user->data->id || $data->status != 1){
            abort(404);
        }
    }

    $seo = $this->component->seo->content();

    return $this->view->render('ad-publication-success', ["data"=>(object)$data, "seo"=>$seo]);
}