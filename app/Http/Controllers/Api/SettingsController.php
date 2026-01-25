<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Http\Controllers\Api;

use App\Systems\Controller;

class SettingsController extends Controller {

    public function __construct($app){
        parent::__construct($app); 
    }

    public function get(){   

        return json_answer($this->api->getSettings());

    }

    public function getCombinedData(){
        
        $device = $_GET['device'] ? _json_decode(htmlspecialchars_decode($_GET['device'])) : [];

        $this->api->fixStat(["device_platform"=>$device['platform'],"device_model"=>$device['model'], "ip"=>$_GET['ip'], "session_id"=>$_GET['session_id'], "user_id"=>(int)$_GET['user_id']]);

        if($this->api->verificationAuth($_GET['token'], $_GET['user_id'])){

            $user = $this->model->users->findById($_GET['user_id']);

            return json_answer(["user_id"=>$_GET['user_id'], "token"=>$_GET['token'], "count_messages"=>$this->component->chat->countMessages($_GET['user_id']), "settings"=>$this->api->getSettings(), "user_data"=>$this->api->userFullData($user), "users_stories"=>$this->api->usersStoriesData()?:null]);

        }

        return json_answer(["settings"=>$this->api->getSettings(), "user_data"=>null]);

    }

}