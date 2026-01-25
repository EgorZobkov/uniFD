public function edit()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    $data = $this->model->shops->find('id=?', [$_POST['id']]);

    if(!$data) return json_answer(["status"=>true, "type_answer"=>"error", "type_show"=>"notice", "answer"=>code_answer("record_not_found")]);

    if($this->validation->requiredField($_POST['title'])->status == false){
        $answer['title'] = $this->validation->error;
    }

    $alias = slug($_POST['alias']);

    if($this->validation->requiredField($alias)->status == false){
        $answer['alias'] = $this->validation->error;
    }else{
        $check = $this->model->shops->find("alias=? and id!=?", [$alias,$_POST['id']]);
        if($check){
            $answer['alias'] = "Идентификатор уже используется";
        }            
    }
 
    if(empty($answer)){

        $this->model->shops->update(["title"=>$_POST['title'], "text"=>$_POST['text'], "alias"=>$alias, "category_id"=>(int)$_POST['category_id']], $_POST['id']);

        return json_answer(["status"=>true, "answer"=>code_answer("save_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }

}