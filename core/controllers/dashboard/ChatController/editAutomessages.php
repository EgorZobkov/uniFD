public function editAutomessages()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    if($_POST["actions"]){
        if(is_array($_POST["actions"])){
            foreach ($_POST["actions"] as $id => $value) {
                $this->model->chat_automessages->update(["text"=>$value], $id);
            }
        }
    }
    
    $this->session->setNotifyDashboard("success", code_answer("save_successfully"));

    return json_answer(["status"=>true]);

}