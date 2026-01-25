<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers;

 use App\Systems\Controller;

 class SystemController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

 public function advClick()
{
    $this->component->advertising->fixClick($_POST["code"],$this->user->data->id);
}

public function captcha()
{
    return $this->captcha->image("captcha");
}

public function captchaVerify()
{   
    $result = $this->system->captchaVerify($_POST['code'], $_POST["captcha_id"]);
    return json_answer($result);
}

public function checkFlashNotify(){   
    $notify = $this->session->getNotify("web");
    if(isset($notify)){
        return _json_encode($notify);
    }
    return null;
}

public function ckfinder()
{   

    $resultUpload = $this->storage->files($_FILES['upload'])->path('temp')->extList('images')->deleteOriginal(true)->use("resize")->upload();

    if($resultUpload){

        $image = $this->storage->uploadAttachFiles([$resultUpload["name"]], $this->config->storage->users->attached);

        echo json_answer(["uploaded"=>true, "url"=>$this->storage->name($image[0])->get()]);

    }

}

public function modalOpen()
{   

     $params = [];

     if($_POST['params']){
        if(is_array($_POST['params'])){
            $params = $_POST['params'];
        }else{
            $params = _json_decode(urldecode($_POST['params']));
        }
     }

     $content = $this->ui->managerModal($_POST['target'], $params);

     if($content){
         return json_answer(["status"=>true, "content"=>$content]);
     }else{
         return json_answer(["status"=>false, "content"=>""]);
     }

}

public function searchItemClick()
{
    $this->component->search->fixingRequest($_POST["query"], $_POST["link"], $this->user->data->id);
}

public function translite(){
    return json_answer(["result"=>slug($_POST['text'])]);
}

public function webhook($key=null, $addon=null, $alias=null, $action=null)
{   

    if($key != $this->config->app->private_service_key){
        return;
    }

    if($addon == "payment"){
        $this->addons->payment($alias)->callback($action);
    }elseif($addon == "messenger"){
        $this->addons->messenger($alias)->webhook($action);
    }elseif($addon == "sms"){
        $this->addons->sms($alias)->webhook($action);
    }

    http_response_code(200);
    
}



 }