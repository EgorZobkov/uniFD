public function main($ad_id){   

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/ad_paid_services.js\" type=\"module\" ></script>"]);

    $data = $this->component->ads->getAd($ad_id);

    if(!$data || !$this->settings->paid_services_status){
        abort(404);
    }else{

        if($data->user_id != $this->user->data->id){
            abort(404);
        }

        if($data->status != 1){
            abort(404);
        }

    }

    $seo = $this->component->seo->content($data);

    return $this->view->render('ad-paid-services', ["data"=>(object)$data, "seo"=>$seo]);
}