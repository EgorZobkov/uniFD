public function addCitiesFromList()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    if($this->validation->requiredField($_POST['country_id'])->status == false){
        $answer['country_id'] = $this->validation->error;
    }

    if(empty($answer)){

        $country_id = 0;

        $country = $this->system->uniApi("country_load", ["country_id"=>$_POST['country_id']]);

        if($country){

            $country["temp_id"] = $country["id"];
            $country["status_api_import"] = 1;

            unset($country["id"]);

            $country_id = $this->model->geo_countries->insert($country);

        }

        if($country_id){

            $regions = $this->system->uniApi("regions_load", ["country_id"=>$_POST['country_id']]);

            if($regions){
                foreach ($regions as $key => $value) {
                    $value["temp_id"] = $value["id"];
                    unset($value["id"]);
                    $value["country_id"] = $country_id;
                    $this->model->geo_regions->insert($value);
                }
            }

            $this->session->setNotifyDashboard('success', code_answer("add_successfully"));

        }else{

            $this->session->setNotifyDashboard('error', code_answer("something_went_wrong"));

        }

        return json_answer(["status"=>true]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

}