<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Http\Controllers\Api;

use App\Systems\Controller;

class AuthorizeController extends Controller {

    public function __construct($app){
        parent::__construct($app); 
    }

    public function authToken(){   

        if($this->api->verificationAuth($_GET['token'], $_GET['user_id'])){

            $user = $this->model->users->findById($_GET['user_id']);

            return json_answer(["status"=>true, "id"=>$_GET['user_id'], "token"=>$_GET['token'], "count_messages"=>$this->component->chat->countMessages($_GET['user_id']), "data"=>$this->api->userFullData($user)]);

        }

        return json_answer(["status"=>false]);

    }

    public function auth(){

        $device = $_POST['device'] ? _json_decode(htmlspecialchars_decode($_POST['device'])) : [];
        $_POST['pass'] = $_POST['pass'] ? $this->api->decryptAES($_POST['pass']) : null;

        if($this->validation->requiredField($_POST['login'])->status == false){
            $answer[] = translate("tr_12cf33c00dc99c4b50402bfc401cd7ce");
        }else{

            $login = $this->validation->correctLogin($_POST['login']);

            if($login->status == false){
                $answer[] = $login->answer;
            }

        }

        if($this->validation->requiredField($_POST['pass'])->status == false){
            $answer[] = translate("tr_2fc1e93e098e15fef75366843009dc33");
        }

        if(empty($answer)){

            if($login->email){
                $getUser = $this->model->users->find('email=?', [$login->email]);
            }else{
                $getUser = $this->model->users->find('phone=?', [$login->phone]);
            }

            if($getUser){

                if($getUser->status == 2){

                    if($getUser->time_expiration_blocking){
                        $answer = translate("tr_1d05fd75df267dbcc432b2b7de4aa9f3")." ".$this->datetime->outDateTime($getUser->time_expiration_blocking) . ". " . translate("tr_ce28b881ebd7df5f6f26f319aeb91a30") . " " . $this->system->getReasonBlocking($getUser->reason_blocking_code)->text;
                    }else{
                        $answer = translate("tr_ce28b881ebd7df5f6f26f319aeb91a30").' '.$this->system->getReasonBlocking($getUser->reason_blocking_code)->text;
                    }

                    return json_answer(["status"=>false, "blocking"=>true, "answer"=>$answer]);
                }

                if(password_verify($_POST["pass"].$this->config->app->encryption_token, $getUser->password)){

                    $result = $this->user->initAuthorization($getUser, null, "app", $device['model']);

                    $this->model->users->update(["firebase_token"=>$_POST['firebase_token']?:null], $getUser->id);

                    return json_answer(["status"=>true, "token"=>$result->token, "user_id"=>$getUser->id]);

                }else{
                    return json_answer(["status"=>false, "answer"=>translate("tr_063a2b7c4f3d9fdf21b33aeb9919fd2c")]);
                }

            }else{
                return json_answer(["status"=>false, "answer"=>translate("tr_063a2b7c4f3d9fdf21b33aeb9919fd2c")]);
            }

        }else{

            return json_answer(["status"=>false, "answer"=>implode("\n", $answer)]);

        }

    }

    public function recovery(){   

        if($this->validation->requiredField($_POST['login'])->status == false){
            $answer[] = translate("tr_12cf33c00dc99c4b50402bfc401cd7ce");
        }else{

            $login = $this->validation->correctLogin($_POST['login']);

            if($login->status == false){
                $answer[] = $login->answer;
            }

        }

        if(empty($answer)){

            if($login->email){
                $getUser = $this->model->users->find('email=?', [$login->email]);
            }else{
                $getUser = $this->model->users->find('phone=?', [$login->phone]);
            }

            if($getUser){

                if($getUser->status == 2){

                    if($getUser->time_expiration_blocking){
                        $answer = translate("tr_1d05fd75df267dbcc432b2b7de4aa9f3")." ".$this->datetime->outDateTime($getUser->time_expiration_blocking) . ". " . translate("tr_ce28b881ebd7df5f6f26f319aeb91a30") . " " . $this->system->getReasonBlocking($getUser->reason_blocking_code)->text;
                    }else{
                        $answer = translate("tr_ce28b881ebd7df5f6f26f319aeb91a30").' '.$this->system->getReasonBlocking($getUser->reason_blocking_code)->text;
                    }

                    return json_answer(["status"=>false, "blocking"=>true, "answer"=>$answer]);
                }

                if($this->settings->phone_confirmation_status || $this->settings->email_confirmation_status){

                    if($login->phone){

                        if($this->settings->phone_confirmation_status){

                            $result = $this->system->sendCodeVerifyContact(["phone"=>$login->phone], $_POST['session_id']);

                            if($result["status"] == true){

                                if($result["call_phone"]){
                                    return json_answer(["status"=>true, "call_phone"=>$result["call_phone"], "title"=>$result["title"]." ".$result["call_phone"], "phone"=>$login->phone, "user_id"=>$getUser->id, "verify"=>true]); 
                                }else{
                                    return json_answer(["status"=>true, "phone"=>$login->phone, "user_id"=>$getUser->id, "title"=>$result["title"], "verify"=>true]);
                                } 

                            }else{
                                return json_answer(["status"=>false, "answer"=>$result["answer"]]);
                            }     

                        }                     

                    }elseif($login->email){

                        if($this->settings->email_confirmation_status){

                            $result = $this->system->sendCodeVerifyContact(["email"=>$login->email], $_POST['session_id']);

                            if($result["status"] == true){
                                return json_answer(["status"=>true, "email"=>$login->email, "user_id"=>$getUser->id, "title"=>$result["title"], "verify"=>true]);
                            }else{
                                return json_answer(["status"=>false, "answer"=>$result["answer"]]);
                            }

                        }

                    }

                }

                return json_answer(["status"=>true, "verify"=>false]);

            }else{
                return json_answer(["status"=>false, "answer"=>translate("tr_063a2b7c4f3d9fdf21b33aeb9919fd2c")]);
            }

        }else{

            return json_answer(["status"=>false, "answer"=>implode("\n", $answer)]);

        }

    }

    public function recoveryEditPass(){   

        $device = $_POST['device'] ? _json_decode(htmlspecialchars_decode($_POST['device'])) : [];
        $_POST['pass'] = $_POST['pass'] ? $this->api->decryptAES($_POST['pass']) : null;

        $login = $this->validation->correctLogin($_POST['login']);

        if($login->status == false){
            $answer[] = $login->answer;
        }

        if($this->validation->correctPassword($_POST['pass'])->status == false){
            $answer[] = translate("tr_2fc1e93e098e15fef75366843009dc33");
        }

        if(empty($answer)){

            if($login->email){
                $getUser = $this->model->users->find('email=?', [$login->email]);
            }else{
                $getUser = $this->model->users->find('phone=?', [$login->phone]);
            }

            if($getUser){

                if($this->settings->phone_confirmation_status || $this->settings->email_confirmation_status){

                   if($this->system->checkVerifyContact(["email"=>$login->email, "phone"=>$login->phone], $_POST['code'], $_POST["session_id"])){

                       $result = $this->user->initAuthorization($getUser, null, "app", $device['model']);

                       $this->model->users->update(["password"=>password_hash($_POST['pass'].$this->config->app->encryption_token, PASSWORD_DEFAULT)], $getUser->id);
                       $this->system->clearVerifyCodes(["email"=>$login->email, "phone"=>$login->phone]);

                       return json_answer(["status"=>true, "token"=>$result->token, "user_id"=>$getUser->id]);
                       
                   }else{
                       return json_answer(["status"=>false, "answer"=>translate("tr_703c05dad1b7df58d8949481538de6b4")]);
                   }

                }else{

                   $result = $this->user->initAuthorization($getUser, null, "app", $device['model']);

                   $this->model->users->update(["password"=>password_hash($_POST['pass'].$this->config->app->encryption_token, PASSWORD_DEFAULT)], $getUser->id);
                   $this->system->clearVerifyCodes(["email"=>$login->email, "phone"=>$login->phone]);
                
                   return json_answer(["status"=>true, "token"=>$result->token, "user_id"=>$getUser->id]);

                }

            }else{
                return json_answer(["status"=>false, "answer"=>translate("tr_5dc3e8080e0f9a323ad981f13972c15a")]);
            }

        }else{

            return json_answer(["status"=>false, "answer"=>implode("\n", $answer)]);

        }

    }

    public function registration(){   

        $device = $_POST['device'] ? _json_decode(htmlspecialchars_decode($_POST['device'])) : [];
        $_POST['pass'] = $_POST['pass'] ? $this->api->decryptAES($_POST['pass']) : null;

        if($this->validation->requiredField($_POST['login'])->status == false){
            $answer[] = translate("tr_12cf33c00dc99c4b50402bfc401cd7ce");
        }else{

            $login = $this->validation->correctLogin($_POST['login']);

            if($login->status == false){
                $answer[] = $login->answer;
            }else{

                if($login->email){

                    $check = $this->model->users->find("email=?", [$login->email]);
                    if($check){
                        $answer[] = translate("tr_39a86c7c7e022ce4a7987d7dc283a024");
                    }else{

                        if($this->validation->isAllowedEmail($login->email)->status == false){
                            $answer[] = translate("tr_99d738d679cdadd3386402846380a0d0")." ".$this->validation->error;
                        }

                    }

                }else{

                    $check = $this->model->users->find("phone=?", [$login->phone]);
                    if($check){
                        $answer[] = translate("tr_c73c35b22a20f6f50528d200d258f805");
                    }else{

                        if($this->validation->isAllowedPhone($login->phone)->status == false){
                            $answer[] = translate("tr_0f70e0aaba5711f57ecd3f4a4cea93a2")." ".$this->validation->error;
                        }

                    }

                }

            }

        }

        if($this->validation->requiredField($_POST['name'])->status == false){
            $answer[] = translate("tr_9ec3a36b1ab3272ad20dd668e6ca95b3");
        }

        if($this->validation->correctPassword($_POST['pass'])->status == false){
            $answer[] = $this->validation->error;
        }

        if(empty($answer)){

            if($this->system->checkVerifyContact(["email"=>$login->email, "phone"=>$login->phone], $_POST['code'], $_POST["session_id"])){

                $result = $this->user->initRegistration(["name"=>$_POST['name'], "email"=>$login->email, "phone"=>$login->phone, "status"=>1, "password"=>$_POST['pass']], "app", $device['model']);

                if($result->user_id){
                    $this->model->users->update(["firebase_token"=>$_POST['firebase_token']?:null], $result->user_id);
                    $this->system->clearVerifyCodes(["email"=>$login->email, "phone"=>$login->phone]);
                    $user = $this->model->users->findById($result->user_id);
                }

                return json_answer(["status"=>true, "verify"=>false, "user_id"=>$result->user_id, "token"=>$result->token, "user_data"=>$this->api->userFullData($user)]);
               
            }else{
               return json_answer(["status"=>false, "answer"=>translate("tr_8654dd4b9b223759fbc4681161f79066")]);
            }

        }else{

            return json_answer(["status"=>false, "answer"=>implode("\n", $answer)]);

        }

    }

}