<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers\Dashboard;

 use App\Systems\Controller;

 class UniApiController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

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

public function checkUpdate()
{

    $data = $this->system->uniApi("check-update");
    return json_answer($data);

}

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

public function logoutUniId()
{

    $this->model->settings->update("","uniid_token");
    $this->model->settings->update("","uniid_data");
    return json_answer(["status"=>true]);

}



 }