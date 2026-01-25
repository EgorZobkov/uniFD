public function saveEdit()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    if($this->validation->requiredFieldsImport($_POST['params']['fields'])->status == false){
        $answer['fields'] = $this->validation->error;
    }

    if(empty($answer)){
        $this->model->import_export->update(['params'=>_json_encode($_POST['params']), "autoupdate"=>(int)$_POST['autoupdate'], "update_interval"=>(int)$_POST['update_interval'], 'next_update'=>$this->datetime->addSeconds($_POST['update_interval'])->getDate()], $_POST['id']);

        return json_answer(["status"=>false, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);
    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

}