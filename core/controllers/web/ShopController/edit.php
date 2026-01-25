public function edit()
{   

    $answer = [];

    $shop = $this->model->shops->find("user_id=? and id=?", [$this->user->data->id, $_POST['id']]);

    if(!$shop){
        return json_answer(["status"=>false]);
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
            $check = $this->model->shops->find("alias=? and id!=?", [$alias, $shop->id]);
            if($check){
                $answer['alias'] = translate("tr_4620efb761967524f1d5a5d395d4e3d6");
            }
        }
    }

    if(!$answer){

        if($_POST['attach_files']){
            $_POST["attach_files"] = $this->storage->uploadAttachFiles($_POST['attach_files'], $this->config->storage->users->attached);
        }

        if($this->user->data->service_tariff->items->unique_shop_address){
            $unique_shop_address = $alias;
        }else{
            $unique_shop_address = md5(time() . uniqid());
        }

        $this->model->shops->update(["title"=>$_POST['title'], "text"=>$_POST['text'], "category_id"=>(int)$_POST['category_id'], "image"=>$_POST['attach_files'] ? $_POST['attach_files'][0] : $shop->image, "alias"=>$unique_shop_address, "status"=>$this->settings->shop_moderation_status ? "awaiting_verification" : "published"], $shop->id);

        $this->event->editShop(["user_id"=>$this->user->data->id, "shop_id"=>$shop->id, "action"=>"edit_shop"]);

        return json_answer(["status"=>true, "answer"=>translate("tr_9b23d5607cca7e8b1486ac8055ab9e78")]);

    }else{

        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);

    }

}