public function addCityMetro()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['color'])->status == false){
        $answer['color'] = $this->validation->error;
    }

    if(empty($answer)){

        $insert_id = $this->model->geo_cities_metro->insert(["name"=>$_POST['name'],"color"=>$_POST['color'], "city_id"=>$_POST['city_id']]);

        if($_POST['stations']){
            foreach ($_POST['stations']['add'] as $key => $station) {
                if(trim($station)){
                    $this->model->geo_cities_metro->insert(["name"=>$station, "parent_id"=>$insert_id, "city_id"=>$_POST['city_id']]);
                }
            }
        }

        $this->session->setNotifyDashboard('success', code_answer("add_successfully"));

        return json_answer(["status"=>true]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }

}