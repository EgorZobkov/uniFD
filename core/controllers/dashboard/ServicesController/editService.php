public function editService(){

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    $get = $this->model->ads_services->find('id=?', [$_POST['id']]);

    if(!$get) return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"notice", "answer"=>code_answer("record_not_found")]);

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['text'])->status == false){
        $answer['text'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['price'])->status == false){
        $answer['price'] = $this->validation->error;
    }

    if($_POST['old_price']){
        if($_POST['old_price'] < $_POST['price']){
            $_POST['old_price'] = 0;
        }
    }

    if($_POST["count_day_fixed"]){
        if($this->validation->requiredField($_POST['count_day'])->status == false){
            $answer['count_day'] = $this->validation->error;
        }
    }

    if(empty($answer)){

        $this->model->ads_services->update(["status"=>(int)$_POST["status"], "image"=>$_POST["manager_image"] ?: null, "name"=>$_POST["name"], "text"=>$_POST["text"], "price"=>$_POST["price"], "old_price"=>$_POST["old_price"], "count_day"=>$_POST["count_day"], "count_day_fixed"=>$_POST["count_day_fixed"], "recommended"=>(int)$_POST["recommended"]], (int)$_POST['id']);
        
        return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

}