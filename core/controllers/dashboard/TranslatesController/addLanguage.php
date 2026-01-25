 public function addLanguage()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['iso'])->status == false){
        $answer['iso'] = $this->validation->error;
    }else{
        $check = $this->model->languages->find("iso=?", [$_POST['iso']]);
        if($check){
            $answer['iso'] = translate("tr_121989c6f00cf39786cde16b709f5d00");
        }            
    }

    if($this->validation->requiredField($_POST['locale'])->status == false){
        $answer['locale'] = $this->validation->error;
    }

    if(empty($answer)){

        if(_mkdir($this->config->storage->translations . '/' . $_POST['iso'], 0777)){

            if(_file_put_contents($this->config->storage->translations . '/' . $_POST['iso'] . '/content.tr', _file_get_contents($this->config->storage->translations . '/default.tr')) && _file_put_contents($this->config->storage->translations . '/' . $_POST['iso'] . '/js.tr', _file_get_contents($this->config->storage->translations . '/js.tr')) && _file_put_contents($this->config->storage->translations . '/' . $_POST['iso'] . '/app.tr', _file_get_contents($this->config->storage->translations . '/app.tr'))){

                $this->model->languages->insert(["name"=>$_POST['name'], "iso"=>$_POST['iso'], "locale"=>$_POST['locale'], "image"=>$_POST["manager_image"] ?: null, "status"=>(int)$_POST['status']]);

                $this->component->translate->insertColumnTables($_POST['iso']);

                $this->session->setNotifyDashboard('success', code_answer("add_successfully"));
                return json_answer(["status"=>true]);

            }else{

                return json_answer(["status"=>false, "type_show"=>"notice", "type_answer"=>"error", "answer"=>translate("tr_0e8dbf20de9a97f7fbf4abf591daf382") . " storage/translations/" . $_POST['iso']]);

            }

        }else{
            return json_answer(["status"=>false, "type_show"=>"notice", "type_answer"=>"error", "answer"=>translate("tr_31ff0706c2c6111d99bf20d5a2422125") . " storage/translations"]);
        }

        

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }    

}