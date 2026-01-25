public function uploadBanner()
{   

    $shop = $this->model->shops->find("user_id=? and id=?", [$this->user->data->id, $_POST['id']]);

    if(!$shop){
        return json_answer(["status"=>false]);
    }

    if($this->model->shops_banners->count("shop_id=?", [$shop->id]) >= $this->settings->shop_max_banners){
        return json_answer(["status"=>false, "answer"=>translate("tr_e6000795b8f4845f6f660f49de980e11")]);
    }else{

        $resultUpload = $this->storage->files($_FILES['attach_files'])->path('temp')->extList('images')->use("resize")->width(1920)->upload();

        if($resultUpload){

            $image = $this->storage->uploadAttachFiles([$resultUpload["name"]], $this->config->storage->users->attached);

            $this->model->shops_banners->insert(["user_id"=>$this->user->data->id, "shop_id"=>$shop->id, "image"=>$image[0]]);

            $this->event->editShop(["user_id"=>$this->user->data->id, "shop_id"=>$shop->id, "action"=>"add_banner_shop"]);

        }

    }

    return json_answer(["status"=>true]);
       
}