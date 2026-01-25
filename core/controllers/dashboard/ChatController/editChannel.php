public function editChannel()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if(empty($answer)){

        $this->model->chat_channels->update(["name"=>$_POST['name'], "text"=>$_POST['text'], "image"=>$_POST["manager_image"] ?: null, "status"=>(int)$_POST['status']], $_POST['id']);

        $this->session->setNotifyDashboard("success", code_answer("save_successfully"));

        return json_answer(["status"=>true]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }    

}