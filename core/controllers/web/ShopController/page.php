public function page($shop_alias, $page_alias)
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

    $data->page = $this->model->shops_pages->find("shop_id=? and alias=?", [$data->shop->id,$page_alias]);

    if(!$data->page){
        abort(404);
    }

    $data->page->text = urldecode($data->page->text);
    $data->owner = $data->shop->user_id == $this->user->data->id ? true : false;

    $this->view->setParamsComponent(['data'=>(object)$data]);

    return $this->view->render('shop-page', ["data"=>(object)$data, "seo"=>(object)["meta_title"=>$data->page->name . ' - ' . $data->shop->title]]);

}