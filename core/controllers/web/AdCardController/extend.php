public function extend(){

    $this->component->ads->extend($_POST["id"], $this->user->data->id);

    $this->session->setNotify("success", translate("tr_6b4ee3c71b62d2b91f2f8374eb3aba57"));

    return json_answer(["status"=>true]);
    
}