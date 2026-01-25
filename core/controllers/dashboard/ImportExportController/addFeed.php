public function addFeed()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['feed_format'])->status == false){
        $answer['feed_format'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['shop_title'])->status == false){
        $answer['shop_title'] = $this->validation->error;
    }

    if($_POST['feed_format'] == "yandex_yml"){

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

        if($_POST['feed_format'] == "json"){
            $filename = generateCode(30).".json";
        }else{
            $filename = generateCode(30).".xml";
        }

        $insert_id = $this->model->import_export_feeds->insert(["name"=>$_POST['name'], "shop_title"=>$_POST['shop_title']?:null, "shop_company_name"=>$_POST['shop_company_name']?:null, "shop_contact_phone"=>$_POST['shop_contact_phone']?:null, "category_id"=>(int)$_POST['category_id'], "filename"=>$filename, "feed_format"=>$_POST['feed_format'], "count_upload_items"=>(int)$_POST['count_upload_items'], "autoupdate"=>(int)$_POST['autoupdate'], "utm_data"=>$_POST['utm_data']?:null, "out_filters_status"=>(int)$_POST['out_filters_status']]);

        $this->component->import_export->buildFeed($insert_id);

        $this->session->setNotifyDashboard('success', code_answer("add_successfully"));

        return json_answer(["status"=>true]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

}