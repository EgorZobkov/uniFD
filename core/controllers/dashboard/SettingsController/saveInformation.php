public function saveInformation()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    if($this->validation->requiredField($_POST['project_name'])->status == false){
        $answer['project_name'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['project_title'])->status == false){
        $answer['project_title'] = $this->validation->error;
    }

    if(empty($answer)){

        $this->model->settings->update($_POST["project_name"],"project_name");
        $this->model->settings->update($_POST["project_title"],"project_title");
        $this->model->settings->update($_POST["contact_email"],"contact_email");
        $this->model->settings->update($_POST["contact_phone"],"contact_phone");
        $this->model->settings->update($_POST["contact_organization_name"],"contact_organization_name");
        $this->model->settings->update($_POST["contact_organization_address"],"contact_organization_address");
        $this->model->settings->update(_json_encode($_POST["contact_social_links"]),"contact_social_links");

        return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

}