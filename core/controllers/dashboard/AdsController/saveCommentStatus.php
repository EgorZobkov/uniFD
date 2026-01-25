public function saveCommentStatus()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];
    $reason_code = $_POST['reason_code'];

    if($this->validation->requiredField($_POST['reason_code'])->status == false){
        $answer['reason_code'] = $this->validation->error;
    }else{
        if($reason_code == "other"){
            if($this->validation->requiredField($_POST['reason_comment'])->status == false){
                $answer['reason_comment'] = $this->validation->error;
            }
        }
    }

    if(empty($answer)){

        if($reason_code == "other"){
            $reason_code = $this->system->addReasonBlocking($_POST['reason_comment']);
        }

        $this->component->ads->changeStatus($_POST['id'],$_POST['status'],$reason_code,$_POST['block_forever_status']);

        $this->session->setNotifyDashboard('success', translate("tr_2133642cd2cd569e5d5e3961d52d5750"));

        return json_answer(["status"=>true]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    } 

}