public function editContent()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $data = urldecode($_POST["data"]);

    parse_str(htmlspecialchars_decode($data), $data);

    $this->component->translate->editContent($data['content'], $data['iso'], $data['view']);

    return json_answer(["status"=>true, "type_answer"=>"success", "type_show"=>"notice", "answer"=>code_answer("save_successfully")]);

}