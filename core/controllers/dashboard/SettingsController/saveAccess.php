public function saveAccess(){

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    if(!$_POST["access_status"]){

        if($this->validation->requiredField($_POST['access_action'])->status == false){
            $answer['access_action'] = $this->validation->error;
        }

        if($_POST['access_action'] == "text"){

            if($this->validation->requiredField($_POST['access_text'])->status == false){
                $answer['access_text'] = $this->validation->error;
            }

        }elseif($_POST['access_action'] == "redirect"){
            
            if($this->validation->requiredField($_POST['access_redirect_link'])->status == false){
                $answer['access_redirect_link'] = $this->validation->error;
            }

        }

    }

    if(empty($answer)){

        $this->model->settings->update($_POST["access_status"],"access_status");
        $this->model->settings->update($_POST["access_action"],"access_action");
        $this->model->settings->update($_POST["access_text"],"access_text");
        $this->model->settings->update($_POST["access_redirect_link"],"access_redirect_link");
        $this->model->settings->update($_POST["access_allowed_ip"],"access_allowed_ip");

        return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

}