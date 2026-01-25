public function start()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    if($this->settings->testdrive){
        return json_answer(["status"=>false, "type_show"=>"notice", "type_answer"=>"error", "answer"=>"В тестовом режиме импорт ограничен"]);
    }

    $data = $this->model->import_export->find("id=?",[$_POST['id']]);

    $answer = [];

    if($this->validation->requiredFieldsImport($_POST['params']['fields'])->status == false){
        $answer['fields'] = $this->validation->error;
    }

    if(empty($answer)){

        $this->model->import_export->update(['status'=>2, 'params'=>_json_encode($_POST['params']), 'next_update'=>$this->datetime->addSeconds($_POST['update_interval'])->getDate(), "update_interval"=>(int)$_POST['update_interval'], 'autoupdate'=>(int)$_POST['autoupdate']], $data->id);

        return json_answer(["status"=>true, "redirect"=>$this->router->getRoute("dashboard-import-export")]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

}