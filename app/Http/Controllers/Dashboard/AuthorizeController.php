<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers\Dashboard;

 use App\Systems\Controller;

 class AuthorizeController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

 public function accessKey($key=null)
{

    if(isset($key)){
        $get = $this->model->auth_access_key->find('access_key=?', [$key]);
        if($get){
            $getUser = $this->model->users->find('id=? and admin=?', [$get->user_id, 1]);
            if($getUser){
                $token = generateHashString();
                $this->model->auth->insert(["user_id"=>$get->user_id, "token"=>$token, "time_expiration"=>$this->datetime->addDay(30)->getDate(), "ip"=>getIp(), "user_agent"=>_json_encode(getUserAgent()), "geo"=>_json_encode(getGeolocation()), "entry_point"=>"key"]);
                $this->system->addAuthSession(["user_id"=>$get->user_id]);
                $this->session->set("dashboard-token-auth", $token);
                $this->router->goToRoute("dashboard");         
            }    
        }
    }

    $this->router->goToRoute("dashboard-auth");
    
}

public function auth()
{

    $answer = [];

    if($this->validation->isEmail($_POST['login'])->status == false){
        $answer[] = $this->validation->error;
    }

    if($this->validation->isPassword($_POST['password'])->status == false){
        $answer[] = $this->validation->error;
    }

    if($this->session->getInt("dashboard-login-attempts") >= 3){
        return json_answer(["status"=>false, "captcha"=>true]);
        exit;
    }

    if(empty($answer)){
        $getUser = $this->model->users->find('email=? and admin=?', [$_POST['login'], 1]);
        if($getUser){

            if($getUser->status == 2){

                if($getUser->time_expiration_blocking){
                    $answer = translate("tr_1d05fd75df267dbcc432b2b7de4aa9f3")." ".$this->datetime->outDateTime($getUser->time_expiration_blocking) . ". ". translate("tr_ce28b881ebd7df5f6f26f319aeb91a30") . $this->system->getReasonBlocking($getUser->reason_blocking_code)->text;
                }else{
                    $answer = translate("tr_ce28b881ebd7df5f6f26f319aeb91a30")." ".$this->system->getReasonBlocking($getUser->reason_blocking_code)->text;
                }

                return json_answer(["status"=>false, "blocking"=>true, "answer"=>$answer]);
            }

            if(password_verify($_POST["password"].$this->config->app->encryption_token, $getUser->password)){

                $this->user->dashboard(true)->setAuth($getUser->id,$_POST['remember_me'] ? true : false, "web");

                if($this->session->get("dashboard-route-end-point")){
                    $route = $this->session->get("dashboard-route-end-point");
                }else{
                    $route = $this->router->getRoute("dashboard");
                }

                return json_answer(["status"=>true, "route"=> $route]);

            }else{
                $this->session->set("dashboard-login-attempts", $this->session->getInt("dashboard-login-attempts")+1);
                return json_answer(["status"=>false, "answer"=>translate("tr_fb455705f2417620bd45ac48d857f189")]);
            }

        }else{ 
            $this->session->set("dashboard-login-attempts", $this->session->getInt("dashboard-login-attempts")+1);
            return json_answer(["status"=>false, "answer"=>translate("tr_fb455705f2417620bd45ac48d857f189")]);
        }
    }else{
        return json_answer(["status"=>false, "answer"=>$answer]);
    }

}

public function captchaVerify()
{   
    $codes = $this->session->get("captcha");
    if(isset($codes)){
        if(empty($_POST['code'])){
            return json_answer(["status"=>false, "answer"=>translate("tr_74ae10c77013a9fdccd7268e9a9d1328")]);
        }else{
            if(in_array($_POST['code'], $codes)){
                $this->session->delete("captcha");
                $this->session->delete("dashboard-login-attempts");
                $this->session->delete("dashboard-login-forgot-attempts");
                return json_answer(["status"=>true]);
            }else{
                return json_answer(["status"=>false, "answer"=>translate("tr_f3d36dc0151f78dc12e1d428a4c5f599")]);
            }
        }
    }else{
        return json_answer(["status"=>false, "answer"=>translate("tr_b033c1aed3f5073873e0d02f5af7abed")]);
    }
}

public function forgot()
{

    $this->asset->registerCss(["view"=>"dashboard", "name"=>"<link rel=\"stylesheet\" href=\"{assets_path}/css/auth.css\" />"]);
    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/auth.js\" type=\"module\" ></script>"]);

    return $this->view->render('forgot', ["title"=>translate("tr_f490b86156968b0c43cbf28feefacd33")]);

}

public function login()
{   

    $this->asset->registerCss(["view"=>"dashboard", "name"=>"<link rel=\"stylesheet\" href=\"{assets_path}/css/auth.css\" />"]);
    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/auth.js\" type=\"module\" ></script>"]);

    return $this->view->render('auth', [ "title"=>translate("tr_865b129166f4e52286bb98bdc42850ef")]);

}

public function logout(){
    $this->user->dashboard(true)->logout();
    $this->router->goToRoute("dashboard-auth");
}

public function restorePass()
{

    $answer = [];

    if($this->validation->isEmail($_POST['login'])->status == false){
        $answer[] = $this->validation->error;
    }

    if($this->session->getInt("dashboard-login-forgot-attempts") >= 3){
        return json_answer(["status"=>false, "captcha"=>true]);
        exit;
    }

    if(empty($answer)){
        $getUser = $this->model->users->find('email=? and admin=?', [$_POST['login'], 1]);
        if($getUser){

            if($getUser->status == 2){

                if($getUser->time_expiration_blocking){
                    $answer = translate("tr_1d05fd75df267dbcc432b2b7de4aa9f3")." ".$this->datetime->outDateTime($getUser->time_expiration_blocking) . ". ". translate("tr_ce28b881ebd7df5f6f26f319aeb91a30") . $this->system->getReasonBlocking($getUser->reason_blocking_code)->text;
                }else{
                    $answer = translate("tr_ce28b881ebd7df5f6f26f319aeb91a30")." ".$this->system->getReasonBlocking($getUser->reason_blocking_code)->text;
                }

                return json_answer(["status"=>false, "blocking"=>true, "answer"=>$answer]);
            }

            $newPass =  generateCode(20);
            $hashPass = password_hash($newPass.$this->config->app->encryption_token, PASSWORD_DEFAULT);

            $this->model->users->update(["password"=>$hashPass], $getUser->id);

            $this->notify->params(["user_name"=>$getUser->name, "user_email"=>$getUser->email, "password"=>$newPass])->code("system_auth_reset_password")->to($getUser->email)->sendEmail();

            $this->session->setNotifyDashboard("success", translate("tr_a15aa14c5d021535af27fe5eb11b932c"));
            $this->session->set("dashboard-login-forgot-attempts", $this->session->getInt("dashboard-login-forgot-attempts")+1);

            return json_answer(["status"=>true, "route"=>$this->router->getRoute("dashboard-auth")]);

        }else{
            return json_answer(["status"=>false, "answer"=>translate("tr_a7518766bd95f2ba00c1beff04eb892f")]);
        }
    }else{
        return json_answer(["status"=>false, "answer"=>$answer]);
    }

}



 }