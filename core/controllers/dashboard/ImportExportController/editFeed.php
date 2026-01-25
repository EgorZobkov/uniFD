public function editFeed()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    $data = $this->model->import_export_feeds->find('id=?', [$_POST['id']]);

    if(!$data) return json_answer(["status"=>true, "type_answer"=>"error", "type_show"=>"notice", "answer"=>code_answer("record_not_found")]);

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['shop_title'])->status == false){
        $answer['shop_title'] = $this->validation->error;
    }

    if($data->feed_format == "yandex_yml"){

        if($this->validation->requiredField($_POST['shop_company_name'])->status == false){
            $answer['shop_company_name'] = $this->validation->error;
        }

        if($this->validation->requiredField($_POST['shop_contact_phone'])->status == false){
            $answer['shop_contact_phone'] = $this->validation->error;
        }

    }

    if($this->validation->requiredField($_POST['count_upload_items'])->status == false){
        $answer['count_upload_items'] = $this->validation->error;
    }

    if(empty($answer)){

        $this->model->import_export_feeds->update(["name"=>$_POST['name'], "shop_title"=>$_POST['shop_title']?:null, "shop_company_name"=>$_POST['shop_company_name']?:null, "shop_contact_phone"=>$_POST['shop_contact_phone']?:null, "category_id"=>(int)$_POST['category_id'], "count_upload_items"=>(int)$_POST['count_upload_items'], "autoupdate"=>(int)$_POST['autoupdate'], "utm_data"=>$_POST['utm_data']?:null, "out_filters_status"=>(int)$_POST['out_filters_status']], $_POST['id']);

        $this->component->import_export->buildFeed($_POST['id']);

        return json_answer(["status"=>true, "answer"=>code_answer("save_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

}