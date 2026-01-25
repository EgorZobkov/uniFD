public function editCountry()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    $data = $this->model->geo_countries->find('id=?', [$_POST['id']]);

    if(!$data) return json_answer(["status"=>true, "type_answer"=>"error", "type_show"=>"notice", "answer"=>"Запись не найдена"]);

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

        $this->model->geo_countries->cacheKey(["id"=>$data->id])->update(["status"=>(int)$_POST['status'], "default_status"=>(int)$_POST['default'], "name"=>$_POST['name'], "alias"=>slug($_POST['alias']), "code"=>_strtoupper($_POST['iso']), "capital_latitude"=>$_POST['latitude'], "capital_longitude"=>$_POST['longitude'], "image"=>$_POST["manager_image"] ?: null,'declension'=>$_POST['declension'],'seo_text'=>$_POST['seo_text']], $data->id);

        $this->model->geo_cities->cacheKey(["country_id"=>$data->id])->update(["country_name"=>$_POST['name']],["country_id=?", [$data->id]]);

        if($_POST['default']){
            $this->model->geo_countries->update(["default_status"=>0], ["id!=?", [$data->id]]);
        }

        $this->component->geo->updateActiveCountries();

        return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }    

}