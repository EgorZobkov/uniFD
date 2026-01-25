public function editPassword()
{   

    $answer = [];

    if($this->user->data->password){

        if($this->validation->requiredField($_POST['old_pass'])->status == false){
            $answer['old_pass'] = $this->validation->error;
        }else{
            if(!password_verify($_POST["old_pass"].$this->config->app->encryption_token, $this->user->data->password)){
                $answer['old_pass'] = translate("tr_e76187c75f69608ef386fc23db8eec34");
            }
        }

        if($this->validation->correctPassword($_POST['new_pass'])->status == false){
            $answer['new_pass'] = $this->validation->error;
        }

    }else{

        if($this->validation->correctPassword($_POST['new_pass'])->status == false){
            $answer['new_pass'] = $this->validation->error;
        }            

    }

    if(empty($answer)){

        $this->model->users->cacheKey(["id"=>$this->user->data->id])->update(["password"=>password_hash($_POST['new_pass'].$this->config->app->encryption_token, PASSWORD_DEFAULT)], $this->user->data->id);

        return json_answer(["status"=>true, "answer"=>translate("tr_162eb0f2ead5d9cbb88ded41a2ba7644")]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

}