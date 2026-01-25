public function editCityDistrict()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    $data = $this->model->geo_cities_districts->find('id=?', [$_POST['id']]);

    if(!$data) return json_answer(["status"=>true, "type_answer"=>"error", "type_show"=>"notice", "answer"=>code_answer("record_not_found")]);

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if(empty($answer)){

        $this->model->geo_cities_districts->cacheKey(["id"=>$data->id])->update(["name"=>$_POST['name']], $data->id);

        return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }    

}