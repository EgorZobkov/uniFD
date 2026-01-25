public function checkVerifyPhone()
{   

    $result = [];

    $session_id = $this->session->get("user-session-id");

    $_POST["phone"] = $this->clean->phone($_POST["phone"]);

    if($_POST["phone"]){

        $data = $this->model->users_waiting_verify_code->find("contact=? and session_id=? and status=?", [$_POST["phone"], $session_id, 1]);

        if($data){
            if($this->user->data->id){
                $this->model->users_verified_contacts->insert(["user_id"=>$this->user->data->id,"contact"=>$_POST["phone"]]);
            }
            return json_answer(["status"=>true]);
        }

    }

    return json_answer(["status"=>false]);

}