public function editCityMetro()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    $data = $this->model->geo_cities_metro->find('id=?', [$_POST['id']]);

    if(!$data) return json_answer(["status"=>true, "type_answer"=>"error", "type_show"=>"notice", "answer"=>code_answer("record_not_found")]);

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['color'])->status == false){
        $answer['color'] = $this->validation->error;
    }

    if(empty($answer)){

        $this->model->geo_cities_metro->cacheKey(["id"=>$data->id])->update(["name"=>$_POST['name'],"color"=>$_POST['color']], $data->id);

        if($_POST["stations"]){
            $current_ids = [];
            if(is_array($_POST["stations"])){
                foreach ($_POST["stations"] as $action => $nested) {
                    foreach ($nested as $id => $value) {
                        if($action == "add"){
                            if(trim($value)){
                                $current_ids[] = $this->model->geo_cities_metro->insert(["name"=>$value, "parent_id"=>$data->id, "city_id"=>$data->city_id]);
                            }
                        }
                        if($action == "update"){
                            if(trim($value)){
                                $this->model->geo_cities_metro->cacheKey(["id"=>$id])->update(["name"=>$value],$id);
                                $current_ids[] = $id;
                            }
                        }
                    }  
                }
                if($current_ids){
                    $this->model->geo_cities_metro->delete("id NOT IN(".implode(",", $current_ids).") and parent_id=?", [$data->id]);
                }
            }
        }else{
            $this->model->geo_cities_metro->delete("parent_id=?", [$data->id]);
        }

        return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }    

}