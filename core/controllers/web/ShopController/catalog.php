public function catalog($shop_alias, $main_request=null)
{   

    $this->view->visible_header = false;
    $this->view->visible_footer = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/shop.js\" type=\"module\" ></script>"]);

    $data = (object)[];

    if(!$this->settings->shops_status){
        abort(404);
    }

    $data->shop = $this->component->shop->getShopByAlias($shop_alias);

    if($data->shop){
        if($data->shop->status != "published"){
            if($data->shop->user_id != $this->user->data->id){
                abort(404);
            }
        }
    }else{
        abort(404);
    }

    $data->user = $this->model->users->findById($data->shop->user_id, true);

    if(!$data->user || $data->user->delete){
        abort(404);
    }

    if($main_request){
       $data->category = $this->component->shop->checkCategoriesByAliasShop(explode("/", trim($main_request, "/")));
       if(!$data->category){
          abort(404);
       } 
    }

    $data->owner = $data->shop->user_id == $this->user->data->id ? true : false;

    $data->tariff = $this->component->service_tariffs->getOrderByUserId($data->shop->user_id);
    $data->banners = $this->component->shop->getBanners($data->shop->id);

    $this->view->setParamsComponent(['data'=>(object)$data]);

    if(!$_GET['search']){
        $seo = $this->component->seo->content($data);
    }else{
        $seo["meta_title"] = translate("tr_91680e1909fc29c7471d2e8a6dc4159d")." «".$_GET['search']."»";
        $seo["h1"] = translate("tr_91680e1909fc29c7471d2e8a6dc4159d")." «".$_GET['search']."»";
    }

    return $this->view->render('shop-catalog', ["data"=>(object)$data, "seo"=>(object)$seo]);

}