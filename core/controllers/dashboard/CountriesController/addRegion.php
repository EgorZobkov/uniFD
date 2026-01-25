public function addRegion()
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

        $this->model->geo_regions->insert(["status"=>(int)$_POST['status'], "name"=>$_POST['name'], "alias"=>slug($_POST['alias']), "capital_latitude"=>$_POST['latitude'], "capital_longitude"=>$_POST['longitude'], "country_id"=>$_POST['country_id'],'declension'=>$_POST['declension'],'seo_text'=>$_POST['seo_text']]);

        $this->session->setNotifyDashboard('success', code_answer("add_successfully"));

        return json_answer(["status"=>true]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }

}