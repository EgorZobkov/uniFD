<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers;

 use App\Systems\Controller;

 class VerifyController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

 public function checkCodeVerifyContact(){

    if($this->system->checkVerifyContact(["email"=>$_POST['email'], "phone"=>$_POST['phone']], $_POST['code'])){
        $this->model->users_verified_contacts->insert(["user_id"=>$this->user->data->id,"contact"=>$_POST['email'] ?: $_POST['phone']]);
        return json_answer(["status"=>true]);
    }else{
        return json_answer(["status"=>false, "answer"=>translate("tr_97084b0ab2cc806ea55a7ea61f5b8ff9")]);
    }
    
}

public function checkVerifyContact(){

    if($_POST["email"] && $this->settings->email_confirmation_status){

        if($this->validation->isEmail($_POST["email"])->status == true){
            if($this->user->data->email != $_POST["email"]){

                if(!$this->model->users_verified_contacts->find("contact=? and user_id=?", [$_POST["email"], $this->user->data->id])){
                    return json_answer(["status"=>true]);
                }

            }
        }

    }elseif($this->clean->phone($_POST["phone"]) && $this->settings->phone_confirmation_status){

        if($this->validation->isPhone($_POST["phone"])->status == true){
            if($this->user->data->phone != $this->clean->phone($_POST["phone"])){

                if(!$this->model->users_verified_contacts->find("contact=? and user_id=?", [$this->clean->phone($_POST["phone"]), $this->user->data->id])){
                    return json_answer(["status"=>true]);
                }
  
            }
        }

    }

    return json_answer(["status"=>false]);
    
}

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

public function sendCodeVerifyContact(){

    if($this->session->getInt("contact-attempts") >= $this->settings->system_captcha_attempts_count && $this->settings->system_captcha_status){
        return json_answer(["status"=>false, "captcha"=>true, "captcha_id"=>"contact-attempts"]);
    }

    if($this->settings->email_confirmation_status || $this->settings->phone_confirmation_status){

        $this->session->set("contact-attempts", $this->session->getInt("contact-attempts")+1);

        if($_POST["phone"]){
            if($this->validation->isPhone($_POST["phone"])->status == true){
                if($this->settings->phone_confirmation_status){
                    $result = $this->system->sendCodeVerifyContact(["phone"=>$this->clean->phone($_POST["phone"])]);
                    if($result["status"] == true){
                        if($result["call_phone"]){
                            return json_answer(["status"=>true, "call_phone"=>$result["call_phone"]]); 
                        }else{
                            return json_answer(["status"=>true]);
                        }
                    }else{
                        return json_answer(["status"=>false, "answer"=>$result["answer"]]);
                    }
                }
            }else{
                return json_answer(["status"=>false, "answer"=>$this->validation->error]);
            }
        }

        if($_POST["email"]){
            if($this->validation->isEmail($_POST["email"])->status == true){
                if($this->settings->email_confirmation_status){
                    $result = $this->system->sendCodeVerifyContact(["email"=>$_POST["email"]]);
                    if($result["status"] == true){
                        return json_answer(["status"=>true]);
                    }else{
                        return json_answer(["status"=>false, "answer"=>$result["answer"]]);
                    }
                }
            }else{
                return json_answer(["status"=>false, "answer"=>$this->validation->error]);
            }
        }

    }

    return json_answer(["status"=>true]);

}



 }