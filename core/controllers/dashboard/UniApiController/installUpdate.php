public function installUpdate()
{

    if($this->settings->uniid_token){

        $data = $this->system->uniApi("install-update");

        if($data["status"]){

            $result = $this->system->installUpdates($data["files"]);

            return json_answer($result);

        }else{

            return json_answer(["status"=>false, "answer"=>$data["answer"]]);

        }
        
    }else{
        return json_answer(["status"=>false, "answer"=>translate("tr_02291e7df20dc290c96a20e423a33f84")]);
    }

}