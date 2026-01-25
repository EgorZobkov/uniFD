<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers\Dashboard;

 use App\Systems\Controller;

 class UsersController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

 public function add()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    if(intval($_POST['status']) == 2){

        if($this->validation->requiredField($_POST['reason_blocking_code'])->status == false){
            $answer['reason_blocking_code'] = $this->validation->error;
        }else{
            if($_POST['reason_blocking_code'] == "other"){
                if($this->validation->requiredField($_POST['reason_blocking_comment'])->status == false){
                    $answer['reason_blocking_comment'] = $this->validation->error;
                }
            }
        } 

        if($this->validation->isUserName($_POST['time_blocking'])->status == false){
            $answer['time_blocking'] = $this->validation->error;
        }

    }

    if($this->validation->isUserName($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($this->validation->isEmail($_POST['email'])->status == true){
        $check = $this->model->users->find("email=?", [$_POST['email']]);
        if($check){
            $answer['email'] = translate("tr_de1e3f7f8a020772823b30b60c8e970d");
        }
    }else{
        if($_POST["role_id"]){
            $answer['email'] = $this->validation->error;
        }
    } 

    if($this->validation->requiredField($_POST['phone'])->status == true){
        $check = $this->model->users->find("phone=?", [$_POST['phone']]);
        if($check){
            $answer['phone'] = translate("tr_24ccb7a9a72c62fd47e9b876908f2b52");
        }            
    }

    if($this->validation->correctPassword($_POST['password'])->status == false){
        $answer['password'] = $this->validation->error;
    }
 
    if($_POST['role_id']){

        if($this->validation->isRoleAdmin($_POST['role_id'])->status == false){
            $answer['role_id'] = $this->validation->error;
        }else{

            $getRole = $this->model->system_roles->find("id=?", [$_POST['role_id']]);

            if(!$getRole->chief){
                if($this->validation->isRolePrivilege($_POST['privileges'])->status == false){
                    $answer['privileges'] = $this->validation->error;
                }
            }

        }

    }

    if(empty($answer)){

        if($_POST['reason_blocking_code'] == "other"){
            $_POST['reason_blocking_code'] = $this->system->addReasonBlocking($_POST['reason_blocking_comment']);
        }

        if($_POST['time_blocking']){
            if($_POST['time_blocking'] == "forever"){
                $_POST['time_blocking'] = null;
            }else{
                $_POST['time_blocking'] = $this->datetime->addHours($_POST['time_blocking'])->getDate();
            }
        }

        $this->user->params($_POST)->add();

        return json_answer(["status"=>true, "type_answer"=>"success", "type_show"=>"notice", "admin" => $_POST['role_id'] ? true : false]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }    

}

public function allTraffic()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/users.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_befd5878a9365dcdc4306c77b413c3e8")=>$this->router->getRoute("dashboard-users-traffic")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_befd5878a9365dcdc4306c77b413c3e8"),"page_icon"=>"ti-users-group","favorite_status"=>true]]);

    return $this->view->preload('users/traffic', ["title"=>translate("tr_befd5878a9365dcdc4306c77b413c3e8")]);

}

public function card($id)
{   

    if(!$this->user->setUserId($id)->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/users.js\" type=\"module\" ></script>"]);

    $data = $this->model->users->findById($id, true);

    if(!$data || $data->delete){
        $this->router->goToRoute("dashboard-users");
    }

    $this->view->setParamsComponent(["data"=>$data, "breadcrumbs"=>["chain"=>[translate("tr_b8c4e70da7bea88961184a1c1be9cb13")=>$this->router->getRoute("dashboard-users"), translate("tr_099eb541519b8a89eea93fae6c83fb07")=>null]]]);

    $this->view->setParamsPreload(["user_id"=>$id]);

    return $this->view->preload('users/user-card', ["title"=>translate("tr_099eb541519b8a89eea93fae6c83fb07"),"data"=>$data]);

}

public function cardAds($id)
{   

    if(!$this->user->setUserId($id)->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/users.js\" type=\"module\" ></script>"]);
    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/ads.js\" type=\"module\" ></script>"]);

    $data = $this->model->users->findById($id, true);

    if(!$data || $data->delete){
        $this->router->goToRoute("dashboard-users");
    }

    $this->view->setParamsComponent(["data"=>$data, "breadcrumbs"=>["chain"=>[translate("tr_b8c4e70da7bea88961184a1c1be9cb13")=>$this->router->getRoute("dashboard-users"), $data->short_name=>null, translate("tr_083ab3d9a9221cf6a1641c2c7c5f0d3c")=>null]]]);

    $this->view->setParamsPreload(["user_id"=>$id]);

    return $this->view->preload('users/user-card-ads', ["data"=>$data,"title"=>translate("tr_083ab3d9a9221cf6a1641c2c7c5f0d3c")]);

}

public function cardDeals($id)
{   

    if(!$this->user->setUserId($id)->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/users.js\" type=\"module\" ></script>"]);

    $data = $this->model->users->findById($id, true);

    if(!$data || $data->delete){
        $this->router->goToRoute("dashboard-users");
    }

    $this->view->setParamsComponent(["data"=>$data, "breadcrumbs"=>["chain"=>[translate("tr_b8c4e70da7bea88961184a1c1be9cb13")=>$this->router->getRoute("dashboard-users"), $data->short_name=>null, translate("tr_9a3dc867f2fd583f53c561442ecf34b0")=>null]]]);

    $this->view->setParamsPreload(["user_id"=>$id]);

    return $this->view->preload('users/user-card-deals', ["data"=>$data,"title"=>translate("tr_9a3dc867f2fd583f53c561442ecf34b0")]);

}

public function cardReviews($id)
{   

    if(!$this->user->setUserId($id)->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/users.js\" type=\"module\" ></script>"]);
    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/reviews.js\" type=\"module\" ></script>"]);

    $data = $this->model->users->findById($id, true);

    if(!$data || $data->delete){
        $this->router->goToRoute("dashboard-users");
    }

    $this->view->setParamsComponent(["data"=>$data, "breadcrumbs"=>["chain"=>[translate("tr_b8c4e70da7bea88961184a1c1be9cb13")=>$this->router->getRoute("dashboard-users"), $data->short_name=>null, translate("tr_1c3fea01a64e56bd70c233491dd537aa")=>null]]]);

    $this->view->setParamsPreload(["user_id"=>$id]);

    return $this->view->preload('users/user-card-reviews', ["data"=>$data,"title"=>translate("tr_1c3fea01a64e56bd70c233491dd537aa")]);

}

public function cardSecurity($id)
{   

    if(!$this->user->setUserId($id)->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/users.js\" type=\"module\" ></script>"]);

    $data = $this->model->users->findById($id, true);

    if(!$data || $data->delete){
        $this->router->goToRoute("dashboard-users");
    }

    $this->view->setParamsComponent(["data"=>$data, "breadcrumbs"=>["chain"=>[translate("tr_b8c4e70da7bea88961184a1c1be9cb13")=>$this->router->getRoute("dashboard-users"), $data->short_name=>null, translate("tr_3677ee79e51454e8da26eb578c6c4e5c")=>null]]]);

    $this->view->setParamsPreload(["user_id"=>$id]);

    return $this->view->preload('users/user-card-security', ["data"=>$data, "title"=>translate("tr_3677ee79e51454e8da26eb578c6c4e5c")]);

}

public function cardTransactions($id)
{   

    if(!$this->user->setUserId($id)->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/users.js\" type=\"module\" ></script>"]);

    $data = $this->model->users->findById($id, true);

    if(!$data || $data->delete){
        $this->router->goToRoute("dashboard-users");
    }

    $this->view->setParamsComponent(["data"=>$data, "breadcrumbs"=>["chain"=>[translate("tr_b8c4e70da7bea88961184a1c1be9cb13")=>$this->router->getRoute("dashboard-users"), $data->short_name=>null, translate("tr_6f99d23532d69316b48a8bd20bf2b085")=>null]]]);

    $this->view->setParamsPreload(["user_id"=>$id]);

    return $this->view->preload('users/user-card-transactions', ["data"=>$data,"title"=>translate("tr_6f99d23532d69316b48a8bd20bf2b085")]);

}

public function changeStatusVerification()
{   

    if(!$this->user->setUserId($_POST['id'])->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    if($_POST['status'] == 1){
        $this->model->users->update(["verification_status"=>1],$_POST['id']);
    }else{
        $this->model->users->update(["verification_status"=>0],$_POST['id']);
    }

    $this->session->setNotifyDashboard('success', code_answer("action_successfully"));

    return json_answer(["status"=>true]);

}

public function delete()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    if($_POST['user_id'] == $this->user->data->id){
        return json_answer(["status"=>false, "type_answer"=>"warning", "type_show"=>"notice", "answer"=>translate("tr_b6ce0032ceef5257ffba58e11a9093cf")]);
    }

    $user = $this->model->users->find('id=?', [$_POST['user_id']]);

    if($this->user->getRole($user->role_id)->chief){
        if(!$this->user->data->role->chief){
            return json_answer(["status"=>false, "type_answer"=>"warning", "type_show"=>"notice", "answer"=>translate("tr_46827be3ca8fc4bc6fee6d290954e050")]);
        }
    }

    $this->user->delete($_POST['user_id']);

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);
}

public function deleteAccessKey(){

    if(!$this->user->setUserId($_POST['user_id'])->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->model->auth_access_key->delete("user_id=?", [$_POST['user_id']]);   

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);

}

public function deleteAuthHistory(){

    if(!$this->user->setUserId($_POST['user_id'])->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->model->auth_sessions->delete('user_id=?', [$_POST['user_id']]);

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);

}

public function deleteAuthSession()
{

    if(!$this->user->setUserId($_POST['user_id'])->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->model->auth->delete('id=? and user_id=?', [$_POST['auth_id'],$_POST['user_id']]);

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);

}

public function deleteTariff()
{   

    if(!$this->user->verificationAccess('control')->status){
        return $this->view->accessDenied();
    }

    if($_POST['user_id']){

        $this->model->users_tariffs_orders->delete("user_id=?", [$_POST['user_id']]);
        $this->model->users->update(["tariff_id"=>0], $_POST['user_id']);

    }

    $this->session->setNotifyDashboard('success', code_answer("action_successfully"));

    return json_answer(["status"=>true]);

}

public function edit()
{   

    if(!$this->user->setUserId($_POST['id'])->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    $getUser = $this->model->users->find('id=?', [$_POST['id']]);

    if(!$getUser) return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"notice", "answer"=>code_answer("record_not_found")]);

    if($this->user->getRole($getUser->role_id)->chief){
        if(!$this->user->data->role->chief){
            return json_answer(['status'=>false, "type_answer"=>"warning", "type_show"=>"notice", "answer"=>translate("tr_746322b39c6699a4e8e84297db9038f5")]);
        }
    }

    if($this->user->data->id != $_POST['id']){

        if(intval($_POST['status']) == 2){

            if($this->validation->requiredField($_POST['reason_blocking_code'])->status == false){
                $answer['reason_blocking_code'] = $this->validation->error;
            }else{
                if($_POST['reason_blocking_code'] == "other"){
                    if($this->validation->requiredField($_POST['reason_blocking_comment'])->status == false){
                        $answer['reason_blocking_comment'] = $this->validation->error;
                    }
                }
            } 

            if($this->validation->isUserName($_POST['time_blocking'])->status == false){
                $answer['time_blocking'] = $this->validation->error;
            }

        }

    }

    if($this->validation->isUserName($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($this->validation->isEmail($_POST['email'])->status == true){
        $check = $this->model->users->find("email=? and id!=?", [$_POST['email'], $getUser->id]);
        if($check){
            $answer['email'] = translate("tr_de1e3f7f8a020772823b30b60c8e970d");
        }
    }else{
        if($_POST["role_id"]){
            $answer['email'] = $this->validation->error;
        }
    }  

    if($this->validation->requiredField($_POST['phone'])->status == true){
        $check = $this->model->users->find("phone=? and id!=?", [$_POST['phone'], $getUser->id]);
        if($check){
            $answer['phone'] = translate("tr_24ccb7a9a72c62fd47e9b876908f2b52");
        }            
    }

    if($_POST['password']){
        if($this->validation->correctPassword($_POST['password'])->status == false){
            $answer['password'] = $this->validation->error;
        }
    }

    if($_POST['role_id']){

        if($this->validation->isRoleAdmin($_POST['role_id'])->status == false){
            $answer['role_id'] = $this->validation->error;
        }else{

            $getRole = $this->model->system_roles->find("id=?", [$_POST['role_id']]);

            if(!$getRole->chief){
                if($this->validation->isRolePrivilege($_POST['privileges'])->status == false){
                    $answer['privileges'] = $this->validation->error;
                }
            }

        }

    }

    if(empty($answer)){

        if($_POST['reason_blocking_code'] == "other"){
            $_POST['reason_blocking_code'] = $this->system->addReasonBlocking($_POST['reason_blocking_comment']);
        }

        if($_POST['time_blocking']){
            if($_POST['time_blocking'] == "forever"){
                $_POST['time_blocking'] = null;
            }else{
                $_POST['time_blocking'] = $this->datetime->addHours($_POST['time_blocking'])->getDate();
            }
        }

        $this->user->params($_POST)->edit($_POST['id']);

        return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }    

}

public function editBalance()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    if($this->validation->requiredField($_POST['action'])->status == false){
        $answer['action'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['amount'])->status == false){
        $answer['amount'] = $this->validation->error;
    }

    if(empty($answer)){

        $this->component->transaction->manageUserBalance(["user_id"=>$_POST['user_id'], "amount"=>$_POST['amount'], "text"=>$_POST['text']], $_POST['action']);

        return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("action_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

}

public function editNotifications()
{
    if(!$this->user->setUserId($_POST['id'])->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $user = $this->model->users->find("id=?", [$_POST['id']]);

    if($user->admin && $this->user->data->role->chief){
        $this->model->users_notify_list->delete("user_id=?", [$_POST['id']]);
        if($_POST['notifications_list']){
            foreach ($_POST['notifications_list'] as $code) {
                $this->model->users_notify_list->insert(["user_id"=>$_POST['id'], "action_code"=>$code]);
            }
        }
    }

    if($this->user->data->id == $_POST['id']){
        $this->model->users->update(["notifications_method"=>$_POST['notifications_method']], $_POST['id']);
    }

    return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);

}

public function generateAccessKey(){

    if(!$this->user->setUserId($_POST['user_id'])->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->model->auth_access_key->delete("user_id=?", [$_POST['user_id']]);   
    $this->model->auth_access_key->insert(["user_id"=>$_POST['user_id'], "access_key"=>generateHashString()]);

    $this->session->setNotifyDashboard('success', code_answer("action_successfully"));

    return json_answer(["status"=>true]);

}

public function loadDataChartWeekAndMonth()
{

    return ["week"=>$this->component->users->getTotalUsersByWeekChart(), "month"=>$this->component->users->getStatisticsUsersByMonthChart()];

}

public function loadEdit()
{

    if(!$this->user->setUserId($_POST['user_id'])->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $data = $this->model->users->find("id=?", [$_POST['user_id']]);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('users/load-edit.tpl')]);

}

public function main()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/users.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_b8c4e70da7bea88961184a1c1be9cb13")=>$this->router->getRoute("dashboard-users")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_b8c4e70da7bea88961184a1c1be9cb13"),"page_icon"=>"ti-users","favorite_status"=>true]]);

    return $this->view->preload('users/users', ["title"=>translate("tr_b8c4e70da7bea88961184a1c1be9cb13")]);

}

public function multiDelete()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->user->deleteMulti($_POST['ids_selected']);

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);
}

public function profileAuth()
{
    if(!$this->user->setUserId($_POST['user_id'])->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $getUser = $this->model->users->find('id=?', [$_POST['user_id']]);

    $this->session->set("administrator-enter-profile", $_POST['user_id']);

    return json_answer(["link"=>$this->router->getRoute("profile", [$getUser->alias])]);
}

public function sendAccess()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->notify->params(["user_name"=>$_POST['name'], "user_email"=>$_POST['email'], "login"=>$_POST['email'], "password"=>$_POST['password']])->code("system_send_access_administrator")->to($_POST['email'])->sendEmail();

    return json_answer(["status"=>true, "type_answer"=>"success", "type_show"=>"notice"]);
}

public function sendMessage()
{   

    if(!$this->user->verificationAccess('control')->status){
        return $this->view->accessDenied();
    }

    if($this->validation->requiredField($_POST['text'])->status == false){
        $answer['text'] = $this->validation->error;
    }        

    if(empty($answer)){

        $user = $this->model->users->find("id=?", [$_POST['user_id']]);

        if($user){
            $this->component->chat->createDialogueAndMessage(["from_user_id"=>0, "whom_user_id"=>$_POST['user_id'], "text"=>$_POST['text'], "channel_id"=>1, "attach_files"=>null]);
        }

        return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("action_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

}



 }