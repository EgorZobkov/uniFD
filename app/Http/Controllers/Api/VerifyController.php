<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Http\Controllers\Api;

use App\Systems\Controller;

class VerifyController extends Controller {

    public function __construct($app){
        parent::__construct($app); 
    }

    public function send(){   

        if($this->validation->requiredField($_POST['contact'])->status == false){
            $answer[] = translate("tr_2f09ba19eae23afb04e5c7b515d5982d");
        }else{

            $contact = $this->validation->correctContact($_POST['contact']);

            if($contact->status == false){
                $answer[] = $contact->answer;
            }else{

                if($contact->email){

                    $check = $this->model->users->find("email=?", [$contact->email]);
                    if($check){
                        $answer[] = translate("tr_39a86c7c7e022ce4a7987d7dc283a024");
                    }else{

                        if($this->validation->isAllowedEmail($contact->email)->status == false){
                            $answer[] = translate("tr_99d738d679cdadd3386402846380a0d0")." ".$this->validation->error;
                        }

                    }

                }else{

                    $check = $this->model->users->find("phone=?", [$contact->phone]);
                    if($check){
                        $answer[] = translate("tr_c73c35b22a20f6f50528d200d258f805");
                    }else{

                        if($this->validation->isAllowedPhone($contact->phone)->status == false){
                            $answer[] = translate("tr_0f70e0aaba5711f57ecd3f4a4cea93a2")." ".$this->validation->error;
                        }

                    }

                }

            }

        }

        if(empty($answer)){

            if($this->settings->phone_confirmation_status || $this->settings->email_confirmation_status){

                if($contact->phone){

                    if($this->settings->phone_confirmation_status){

                        $result = $this->system->sendCodeVerifyContact(["phone"=>$contact->phone], $_POST['session_id']);

                        if($result["status"] == true){

                            if($result["call_phone"]){
                                return json_answer(["status"=>true, "call_phone"=>$result["call_phone"], "title"=>$result["title"]." ".$result["call_phone"], "phone"=>$contact->phone, "user_id"=>null, "verify"=>true]);
                            }else{
                                return json_answer(["status"=>true, "phone"=>$contact->phone, "user_id"=>null, "title"=>$result["title"], "verify"=>true]);
                            } 

                        }else{
                           return json_answer(["status"=>false, "answer"=>$result["answer"]]);
                        }     

                    }                     

                }elseif($contact->email){

                    if($this->settings->email_confirmation_status){

                        $result = $this->system->sendCodeVerifyContact(["email"=>$contact->email], $_POST['session_id']);

                        if($result["status"] == true){
                            return json_answer(["status"=>true, "email"=>$contact->email, "user_id"=>null, "title"=>$result["title"], "verify"=>true]);
                        }else{
                            return json_answer(["status"=>false, "answer"=>$result["answer"]]);
                        }

                    }

                }

            }

            return json_answer(["status"=>true, "verify"=>false, "email"=>$contact->email ?: null, "phone"=>$contact->phone ?: null]);

        }else{

            return json_answer(["status"=>false, "answer"=>implode("\n", $answer)]);

        }

    }    

    public function verifyCode(){

        $contact = $this->validation->correctContact($_POST['contact']);

        if($contact->status == false){
            $answer[] = $contact->answer;
        }

        if($this->validation->requiredField($_POST['code'])->status == false){
            $answer[] = translate("tr_e50f521048d080c3e367547ee1f785fa");
        }

        if(empty($answer)){

           if($this->system->checkVerifyContact(["email"=>$contact->email, "phone"=>$contact->phone], $_POST['code'], $_POST["session_id"])){

                if($_POST["user_id"]){
                    $this->model->users_verified_contacts->insert(["user_id"=>$_POST["user_id"],"contact"=>$contact->email ?: $contact->phone]);
                }

               return json_answer(["status"=>true]);
               
           }else{
               return json_answer(["status"=>false, "answer"=>translate("tr_97084b0ab2cc806ea55a7ea61f5b8ff9")]);
           }

        }else{

           return json_answer(["status"=>false, "answer"=>implode("\n", $answer)]);

        }

    }

    public function checkVerifyPhone(){   

        $result = [];

        $_POST["phone"] = $this->clean->phone($_POST["phone"]);

        if($_POST["phone"]){

            $data = $this->model->users_waiting_verify_code->find("contact=? and session_id=? and status=?", [$_POST["phone"], $_POST["session_id"], 1]);

            if($data){
                if($_POST["user_id"]){
                    $this->model->users_verified_contacts->insert(["user_id"=>$_POST["user_id"],"contact"=>$_POST["phone"]]);
                }
                return json_answer(["status"=>true]);
            }

        }

        return json_answer(["status"=>false]);

    }

}
