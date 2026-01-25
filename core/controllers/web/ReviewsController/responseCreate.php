public function responseCreate()
{   

    if($this->validation->requiredField($_POST['text'])->status == false){
        return json_answer(["status"=>false, "answer"=>translate("tr_9236dee57cf1f06c152210bf429c87e1")]);
    }else{
        $this->component->reviews->responseCreate(["review_id"=>$_POST["id"], "user_id"=>$this->user->data->id, "text"=>$_POST["text"]]);
        return json_answer(["status"=>true]);
    }

}