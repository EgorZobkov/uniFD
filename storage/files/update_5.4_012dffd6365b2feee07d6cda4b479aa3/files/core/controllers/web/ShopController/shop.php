public function shop($shop_alias)
{   

    $this->view->visible_header = false;
    $this->view->visible_footer = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/shop.js\" type=\"module\" ></script>"]);

    $data = (object)[];

    if(!$this->settings->shops_status){
        abort(404);
    }

    $data->shop = $this->component->shop->getShopByAlias($shop_alias);

    if(!$data->shop){
        abort(404);
    }

    $data->user = $this->model->users->findById($data->shop->user_id, true);

    if(!$data->user || $data->user->delete){
        abort(404);
    }

    $data->tariff = $this->component->service_tariffs->getOrderByUserId($data->shop->user_id);

    $data->owner = $data->shop->user_id == $this->user->data->id ? true : false;
    $data->banners = $this->component->shop->getBanners($data->shop->id);
    
    $data->items = $this->component->shop->getHomeAdsUser($data->shop->user_id);
    $data->reviews = $this->component->shop->getHomeReviews($data->shop->user_id);

    $seo = $this->component->seo->content($data);
    $this->view->setParamsComponent(['data'=>(object)$data]);

    return $this->view->render('shop', ["data"=>(object)$data, "seo"=>$seo]);

}