public function disputeSave()
{

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    if($this->validation->requiredField($_POST['dispute_solution_code'])->status == false){
        $answer['dispute_solution_code'] = $this->validation->error;
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }else{

        $this->component->transaction->addSolutionDisputeDeal($_POST["order_id"], $_POST["dispute_solution_code"], $_POST["dispute_text"]);
        
        $this->session->setNotifyDashboard('success', code_answer("action_successfully"));
        return json_answer(['status'=>true]);       

    }


}