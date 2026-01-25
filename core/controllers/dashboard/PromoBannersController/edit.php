public function edit()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    $data = $this->model->promo_banners->find('id=?', [$_POST['id']]);

    if(!$data) return json_answer(["status"=>true, "type_answer"=>"error", "type_show"=>"notice", "answer"=>code_answer("record_not_found")]);

    if($this->validation->requiredField($_POST['title'])->status == false){
        $answer['title'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['link'])->status == false){
        $answer['link'] = $this->validation->error;
    }

    if(!$_POST['page_show']){
        $_POST['category_id'] = 0;
    }
 
    if(empty($answer)){

        $this->model->promo_banners->update(["status"=>(int)$_POST['status'], "title"=>$_POST['title'], "image"=>$_POST["manager_image"] ?: null, "text"=>$_POST['subtitle'], "link"=>$_POST['link'], "bg_color"=>$_POST['bg_color']?:'white', "text_color"=>$_POST['text_color']?:'black', "page_show"=>$_POST['page_show'] ?: null, "category_id"=>(int)$_POST['category_id'], "geo_link_status"=>(int)$_POST['geo_link_status']], $_POST['id']);

        return json_answer(["status"=>true, "answer"=>code_answer("save_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }

}