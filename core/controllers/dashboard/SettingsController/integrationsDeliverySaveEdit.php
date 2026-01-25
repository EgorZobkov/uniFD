public function integrationsDeliverySaveEdit(){

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $data = $this->model->system_delivery_services->find("id=?", [$_POST["id"]]);

    if($data){

        $this->model->system_delivery_services->update(["status"=>$_POST["status"], "name"=>$_POST["name"], "params"=>encrypt(_json_encode($_POST["params"])), "image"=>$_POST['manager_image'] ?: null, "available_price_min"=>(int)$_POST["available_price_min"], "available_price_max"=>(int)$_POST["available_price_max"], "min_weight"=>(int)$_POST["min_weight"], "max_weight"=>(int)$_POST["max_weight"]], $_POST["id"]);

        $this->addons->delivery($data->alias)->getPoints();

    }

    $this->session->setNotifyDashboard('success', code_answer("save_successfully"));

    return json_answer(["status"=>true]);

}