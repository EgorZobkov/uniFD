public function authUniId()
{

    $answer = [];

    if($this->validation->isEmail($_POST['login'])->status == false){
        $answer[] = $this->validation->error;
    }

    if($this->validation->isPassword($_POST['password'])->status == false){
        $answer[] = $this->validation->error;
    }

    if(empty($answer)){

        $auth = $this->system->uniApi("auth", ["login"=>$_POST['login'], "password"=>$_POST['password']]);

        if($auth){
            if($auth["status"]){
                $this->model->settings->update($auth["token"],"uniid_token");
                $this->model->settings->update(_json_encode($auth["data"]),"uniid_data");
                return json_answer(["status"=>true]);
            }else{
                return json_answer(["status"=>false, "answer"=>$auth["answer"]]);
            }
        }else{
            return json_answer(["status"=>false, "answer"=>translate("tr_adfc20838eb5cd9419f125217a08a5a4")]);
        }

    }else{
        return json_answer(["status"=>false, "answer"=>$answer]);
    }

}