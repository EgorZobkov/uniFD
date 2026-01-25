public function editPage()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    $getPage = $this->model->template_pages->find('id=?', [$_POST['id']]);

    if(!$getPage) return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"notice", "answer"=>code_answer("record_not_found")]);

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['alias'])->status == true){
        $find = $this->model->template_pages->find("alias=? and id!=?", [$_POST['alias'],$_POST['id']]);
        if($find){
            $answer['alias'] = translate("tr_36103ff759652e3b17f5fb189a1173f7");
        }
    }else{
        $_POST['alias'] = $_POST['name'];
    }

    if(empty($answer)){

        $this->model->template_pages->update(["status"=>(int)$_POST['status'], "name"=>$_POST['name'], 'alias'=>slug($_POST['alias'])], (int)$_POST['id']);
        
        return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

           
}