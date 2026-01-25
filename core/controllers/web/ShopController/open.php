public function open()
{   

    $answer = [];

    $getShop = $this->model->shops->find("user_id=?", [$this->user->data->id]);

    if($getShop){
        return json_answer(["status"=>false, "answer"=>translate("tr_d1c60794308340dbc7ef0acfd4b82e1a")]);
    }

    if(!$this->component->profile->checkVerificationPermissions($this->user->data->id, "open_shop")){
        return json_answer(["verification"=>false, "answer"=>translate("tr_0e28cd53f7623cf9ffab15a7a719a274")]);
    }

    if(!$this->user->data->service_tariff->items->shop){
        return json_answer(["status"=>false]);
    }

    if($this->validation->requiredFieldArray($_POST['attach_files'])->status == false){
        $answer['logo'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['title'])->status == false){
        $answer['title'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['category_id'])->status == true){
        if(!$this->component->ads_categories->categories[$_POST['category_id']]){
            $answer['category_id'] = translate("tr_e501b221d7a65fc7efe1e52988bd4d5d");
        }
    }

    $alias = slug($_POST['alias']);

    if($this->user->data->service_tariff->items->unique_shop_address){
        if($this->validation->requiredField($alias)->status == false){
            $answer['alias'] = $this->validation->error;
        }else{
            $check = $this->model->shops->find("alias=?", [$alias]);
            if($check){
                $answer['alias'] = translate("tr_4620efb761967524f1d5a5d395d4e3d6");
            }else{
                $unique_shop_address = $alias;
            }
        }
    }else{
        $unique_shop_address = generateCode(30);
    }

    if(!$answer){

        if($_POST['attach_files']){
            $_POST["attach_files"] = $this->storage->uploadAttachFiles($_POST['attach_files'], $this->config->storage->users->attached);
        }

        $shop_id = $this->model->shops->insert(["user_id"=>$this->user->data->id, "title"=>$_POST['title'], "text"=>$_POST['text'], "category_id"=>(int)$_POST['category_id'], "image"=>$_POST['attach_files'] ? $_POST['attach_files'][0] : null, "alias"=>$unique_shop_address, "status"=>$this->settings->shop_moderation_status ? "awaiting_verification" : "published", "time_create"=>$this->datetime->getDate()]);

        $this->event->createShop(["user_id"=>$this->user->data->id, "shop_id"=>$shop_id]);

        return json_answer(["status"=>true, "redirect"=>$this->component->shop->linkToShopCard($unique_shop_address)]);

    }else{

        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);

    }

}