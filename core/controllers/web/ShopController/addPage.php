 public function addPage()
{   

    $answer = [];

    if(!$this->user->data->service_tariff->items->shop_page){
        return json_answer(["status"=>false]);
    }

    $shop = $this->model->shops->find("user_id=? and id=?", [$this->user->data->id, $_POST['id']]);

    if(!$shop){
        return json_answer(["status"=>false]);
    }

    if($this->model->shops_pages->count("shop_id=?", [$shop->id]) >= $this->settings->shop_max_pages){
        return json_answer(["status"=>false, "answer"=>translate("tr_8104c6c3a3e7b62a653218094b3926ee")]);
    }

    $alias = slug($_POST['name']);

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }else{
        $check = $this->model->shops_pages->find("alias=? and shop_id=?", [$alias, $shop->id]);
        if($check){
            $answer['name'] = translate("tr_0aa88c0caa1820b71895d6f44422da78");
        }
    }

    if(!$answer){

        $this->model->shops_pages->insert(["user_id"=>$this->user->data->id, "name"=>$_POST['name'], "shop_id"=>$shop->id, "alias"=>$alias]);

        $this->event->editShop(["user_id"=>$this->user->data->id, "shop_id"=>$shop->id, "action"=>"add_page_shop"]);

        return json_answer(["status"=>true, "redirect"=>$this->component->shop->linkToPageCard($shop->alias, $alias)]);

    }else{

        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);

    }
       
}