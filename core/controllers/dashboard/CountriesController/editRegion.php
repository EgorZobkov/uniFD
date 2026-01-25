public function editRegion()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    $data = $this->model->geo_regions->find('id=?', [$_POST['id']]);

    if(!$data) return json_answer(["status"=>true, "type_answer"=>"error", "type_show"=>"notice", "answer"=>code_answer("record_not_found")]);

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

        $this->model->geo_regions->cacheKey(["id"=>$data->id])->update(["status"=>(int)$_POST['status'], "name"=>$_POST['name'], "alias"=>slug($_POST['alias']), "capital_latitude"=>$_POST['latitude'], "capital_longitude"=>$_POST['longitude'],'declension'=>$_POST['declension'],'seo_text'=>$_POST['seo_text']], $data->id);

        $this->model->geo_cities->update(["region_name"=>$_POST['name']], ["region_id=?", [$data->id]]);

        return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }    

}