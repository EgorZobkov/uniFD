public function buyItemCard($id)
{   

    $this->view->visible_header = false;
    $this->view->visible_footer = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/transaction.js\" type=\"module\" ></script>"]);

    $data["ad"] = $this->component->ads->getAd($id);

    if($data["ad"]){
        if(!$this->component->ads->hasBuySecureDeal($data["ad"])){
            abort(404);
        }
    }else{
        abort(404);
    }

    return $this->view->render('order/buy', ["data"=>(object)$data, "seo"=>(object)["meta_title"=>translate("tr_f50d065821e1d997a32ec402f29cf6ea")]]);

}