public function deleteLanguage()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $data = $this->model->languages->find('id=?', [$_POST['id']]);

    if($data->iso){
    
        deleteFolder($this->config->storage->translations.'/'.$data->iso, "*.tr");

        $this->model->languages->delete("id=?", [$_POST['id']]);

        $this->component->translate->deleteColumnTables($data->iso);

    }

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);

}