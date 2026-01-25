public function shop()
{   

    $this->view->visible_header = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/profile.js\" type=\"module\" ></script>"]);
    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/shop.js\" type=\"module\" ></script>"]);

    $shop = $this->component->shop->getShopByUserId($this->user->data->id);

    if($shop){
        if($this->user->data->service_tariff->items->shop){
            $this->router->goToUrl($this->component->shop->linkToShopCard($shop->alias));
        }
    }

    return $this->view->render('profile/shop', ["seo"=>(object)["meta_title"=>translate("tr_838c33a96c1a3d15354de92dae7a0f08")]]);
}