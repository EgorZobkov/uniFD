public function addChannel()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if(empty($answer)){

        $this->model->chat_channels->insert(["name"=>$_POST['name'], "text"=>$_POST['text'], "image"=>$_POST["manager_image"] ?: null, "type"=>$_POST['type'], "status"=>(int)$_POST['status']]);

        return json_answer(["status"=>true, "type_answer"=>"success", "type_show"=>"notice", "answer"=>code_answer("add_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }    

}