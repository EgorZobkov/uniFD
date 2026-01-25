public function editResponder()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];
    $time_send = $this->datetime->getDate();

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($_POST['send'] == "date"){
        if($this->validation->requiredField($_POST['date'])->status == false){
            $answer['date'] = $this->validation->error;
        }else{
            $time_send = $this->datetime->format("Y-m-d H:i:s")->convert($_POST['date']);
            if($time_send < $this->datetime->getDate()){
                $answer['date'] = "tr_822c6c202c2e953029ad54b4f87cdf9f";
            }
        }
    }

    if($this->validation->requiredFieldArray($_POST['channels'])->status == false){
        $answer['channels'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['text'])->status == false){
        $answer['text'] = $this->validation->error;
    }

    if(empty($answer)){

        $this->model->chat_responders->update(["name"=>$_POST['name'], "text"=>$_POST['text'], "image"=>$_POST["manager_image"] ?: null, "send"=>$_POST['send'], "time_send"=>$time_send, "channels"=>_json_encode($_POST['channels'])], $_POST['id']);

        $this->session->setNotifyDashboard("success", code_answer("save_successfully"));

        return json_answer(["status"=>true]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }    

}