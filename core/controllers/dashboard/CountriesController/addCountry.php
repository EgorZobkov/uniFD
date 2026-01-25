public function addCountry()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    $_POST['latitude'] = str_replace([",","°","\"","'"],[".","","",""],$_POST['latitude']);
    $_POST['longitude'] = str_replace([",","°","\"","'"],[".","","",""],$_POST['longitude']);

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['iso'])->status == false){
        $answer['iso'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['alias'])->status == false){
        $answer['alias'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['latitude'])->status == false){
        $answer['latitude'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['longitude'])->status == false){
        $answer['longitude'] = $this->validation->error;
    }
 
    if(empty($answer)){

        $insert_id = $this->model->geo_countries->insert(["status"=>(int)$_POST['status'], "default_status"=>(int)$_POST['default'], "name"=>$_POST['name'], "alias"=>slug($_POST['alias']), "code"=>_strtoupper($_POST['iso']), "capital_latitude"=>$_POST['latitude'], "capital_longitude"=>$_POST['longitude'], "image"=>$_POST["manager_image"] ?: null,'declension'=>$_POST['declension'],'seo_text'=>$_POST['seo_text']]);

        if($_POST['default']){
            $this->model->geo_countries->update(["default_status"=>0], ["id!=?", [$insert_id]]);
        }

        $this->component->geo->updateActiveCountries();

        $this->session->setNotifyDashboard('success', code_answer("add_successfully"));

        return json_answer(["status"=>true]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }

}