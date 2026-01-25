<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Systems;

 class User
 {

 public $data = [];
 public $user = [];
 
 public function add(){
    global $app;

    if($this->params){

        $this->params['time_create'] = $this->params['time_create']?:$app->datetime->getDate();
        $this->params['password'] = isset($this->params['password']) ? password_hash($this->params['password'].$app->config->app->encryption_token, PASSWORD_DEFAULT) : null;

        if($this->params['status'] != 2){
            $this->params['reason_blocking_code'] = null;
            $this->params['time_expiration_blocking'] = null;
        }

        $this->params['admin'] = $this->params['role_id'] ? 1 : 0;

        if(!$this->params['manager_image']){
            $this->params['avatar'] = $app->image->generateAvatar($this->params['name'].' '.$this->params['surname']);
        }else{
            $this->params['avatar'] = $this->params["manager_image"];
        }

        $user_id = $app->model->users->insert(["time_create"=>$this->params['time_create'], "name"=>$this->params['name'], "surname"=>$this->params['surname'], "email"=>$this->params['email']?:null, "phone"=>$this->params['phone']?:null, "password"=>$this->params['password'], "avatar"=>$this->params['avatar']?:null, "status"=>(int)$this->params['status'], "reason_blocking_code"=>$this->params['reason_blocking_code']?:null, "time_expiration_blocking"=>$this->params['time_blocking'], "role_id"=>(int)$this->params['role_id'], "notifications_method"=>"email", "admin"=>$this->params['admin'], "alias"=>generateCode(30), "uniq_hash"=>generateHashString(), "notifications"=>'{"chat":"1","expiration_ads":"1","expiration_tariff":"1","add_to_favorite":"1","view_ad_contacts":"1"}', "import_id"=>$this->params['import_id']?:0]);

        if($user_id && $this->params['admin']){

            if(!$this->getRole($this->params['role_id'])->chief){
                if($this->params['privileges']){
                    $app->model->users_privileges->delete("user_id=?", [$user_id]);
                    foreach ($this->params['privileges'] as $privilege_id => $nested) {
                        $privilege = $app->model->system_privileges->find("id=?", [$privilege_id]);
                        if($privilege){
                            foreach ($nested as $privilege_name => $value) {
                                $app->model->users_privileges->insert(["user_id"=>$user_id, "privilege_id"=>$privilege_id, "privilege_name"=>$privilege_name, "route_id"=>$privilege->route_id]); 
                            }
                        }
                    }
                }
            }

        }

        return $user_id;

    }

    return null;
}

public function avatar($data=[]){
    global $app;

    ?>
    <img class="image-autofocus" src="<?php echo $app->storage->name($data->avatar)->get(); ?>">
    <?php

}

public function buildData($user=[]){
    global $app;

    $user->avatar_src = $app->storage->name($user->avatar)->path(null)->host(true)->get();
    $user->role_name = $app->user->getRole($user->role_id)->name;
    $user->status_name = $app->user->status($user->status)->name;
    $user->status_label = $app->user->status($user->status)->label;
    $user->reason_blocking = $app->system->getReasonBlocking($user->reason_blocking_code);
    $user->label_activity = $app->user->labelActivity($user->time_last_activity);
    $user->short_name = $app->user->name($user,true);
    $user->full_name = $user->name.' '.$user->surname;
    $user->balance_by_currency = $app->system->amount($user->balance);
    $user->last_auth_data = $app->user->getLastAuthData($user->id);
    $user->contacts = $user->contacts ? (object)_json_decode(decrypt($user->contacts)) : [];
    $user->notifications = $user->notifications ? _json_decode($user->notifications) : [];
    $user->shop = $app->component->shop->getActiveShopByUserId($user->id);
    $user->service_tariff = $app->component->service_tariffs->getOrderByUserId($user->id);

    if($user->role_id){
        $user->role = $app->user->getRole($user->role_id);
        $user->privileges = $app->user->getPrivileges($user->id);
        $user->privilegesList = $app->user->getPrivilegesList($user->id);
    }
    
    $user->customize_template = $app->model->system_customize_template->find('user_id=?', [$user->id]);
    $user->access_key = $app->model->auth_access_key->find("user_id=?", [$user->id]);
    $user->delivery_data = $app->model->users_delivery_data->find("user_id=?", [$user->id]);

    return $user;
    
}

public function codePermissions(){   
    global $app;

    $result["view"] = ["code"=>"view", "name"=>translate("tr_842484fb6ad9bb3a8a2730301423a0b6")];
    $result["control"] = ["code"=>"control", "name"=>translate("tr_6fdd7d3aa90e5786fa24fb6117f96669")];

    return $result;

}

public function codeVerification(){   
    global $app;

    $result["awaiting_verification"] = ["code"=>"awaiting_verification", "name"=>translate("tr_415e61b1b8e1ead55cf24792dd8da945"), "label"=>"warning"];
    $result["verified"] = ["code"=>"verified", "name"=>translate("tr_93fac5956a123559ab44a812038a7ea8"), "label"=>"success"];
    $result["rejected"] = ["code"=>"rejected", "name"=>translate("tr_7c1a8fcbf63d6f7fa992bd34949a37c1"), "label"=>"secondary"];

    return $result;

}

public function createSessionId(){
    global $app;

    $session_id = md5(time().uniqid());

    if(_getcookie("user-session-id")){
        $session_id = _getcookie("user-session-id");
    }elseif($app->session->get("user-session-id")){
        $session_id = $app->session->get("user-session-id");
    }

    _setcookie(["key"=>"user-session-id", "value"=>$session_id, "lifetime"=>strtotime('+360 days')]);
    $app->session->set("user-session-id", $session_id);

}

public function dashboard($status=null){
    $this->dashboard = $status;
    return $this;
}

public function delete($user_id=null){
    global $app;
    if(isset($user_id)){
        $user = $app->model->users->find('id=?', [$user_id]);
        if($user){

            $app->model->auth->delete('user_id=?', [$user_id]);
            $app->model->auth_access_key->delete('user_id=?', [$user_id]);
            $app->model->auth_sessions->delete('user_id=?', [$user_id]);
            $app->model->users_payment_data->delete('user_id=?', [$user_id]);
            $app->model->users_referrals->delete('whom_user_id=?', [$user_id]);
            $app->model->users_referral_transitions->delete('user_id=?', [$user_id]);
            $app->model->users_tariffs_orders->delete('user_id=?', [$user_id]);
            $app->model->users_verified_contacts->delete('user_id=?', [$user_id]);
            $app->model->users_delivery_data->delete('user_id=?', [$user_id]);
            $app->model->users_waiting_notifications->delete('user_id=?', [$user_id]);
            $app->model->users_tariffs_onetime->delete('user_id=?', [$user_id]);
            $app->model->users_subscriptions->delete('user_id=?', [$user_id]);
            $app->model->users_favorites->delete('user_id=?', [$user_id]);
            $app->model->users_blacklist->delete('from_user_id=?', [$user_id]);
            $app->model->users_blacklist->delete('whom_user_id=?', [$user_id]);
            $app->model->transactions_balance->delete('user_id=?', [$user_id]);
            $app->component->ads->deleteAllByUserId($user_id);
            $app->component->stories->deleteAllByUserId($user_id);
            $app->storage->name($user->avatar)->delete();
            $app->model->users_delete->insert(["user_id"=>$user_id, "user_alias"=>$user->alias, "name"=>$user->name, "time_delete"=>$app->datetime->getDate()]);
            $app->model->users->cacheKey(["id"=>$user_id])->delete('id=?', [$user_id]);

            $app->session->delete("administrator-enter-profile");
            
            $app->event->deleteUser($user);

            return ['status'=>true];

        }
    }
}

public function deleteByImport($id=null, $limit=null){
    global $app;
    if(isset($id)){
        $userIds = $app->model->users->getAll('import_id=?', [$id]);
        if($userIds){
            foreach ($userIds as $key => $value) {
                $app->storage->path('user-avatar')->name($value["avatar"])->delete();
                $app->model->users->cacheKey(["id"=>$value["id"]])->delete('id=?', [$value["id"]]);
                $app->model->users_logs->delete('user_id=?', [$value["id"]]);
            }
        }
    }
}

public function deleteMulti($adIds=[]){
    global $app;

    if($adIds){
        foreach ($adIds as $key => $id) {

            if($id != $app->user->data->id){
                $this->delete($id);
            }

        }
    }

}

public function deleteToken(){
    global $app;
    if(isset($this->dashboard)){
        $app->session->delete("dashboard-token-auth");
        _deletecookie("dashboard-token-auth");
    }else{
         $app->session->delete("token-auth");
        _deletecookie("token-auth");           
    }
}

public function edit($user_id=0){
    global $app;

    $user = $app->model->users->find("id=?", [$user_id]);

    if($this->params && $user_id){

        if($this->data->id == $user_id){
            $this->params["role_id"] = $user->role_id;
            $this->params["status"] = $user->status;
            $this->params['admin'] = 1;
        }else{
            $this->params['admin'] = $this->params['role_id'] ? 1 : 0;
        }

        if($this->params['password']){
            $this->params['password'] = password_hash($this->params['password'].$app->config->app->encryption_token, PASSWORD_DEFAULT);
        }else{
            $this->params['password'] = $user->password;
        }

        if($this->params['status'] != 2){
            $this->params['reason_blocking_code'] = null;
            $this->params['time_expiration_blocking'] = null;
        }

        if(!$this->params['manager_image']){
            $this->params['avatar'] = $app->image->generateAvatar($this->params['name'].' '.$this->params['surname']);
        }else{
            $this->params['avatar'] = $this->params["manager_image"];
        }

        $app->model->users->update(["name"=>$this->params['name'], "surname"=>$this->params['surname'], "email"=>$this->params['email'], "phone"=>$this->params['phone'], "password"=>$this->params['password'], "avatar"=>$this->params['avatar'] ?: null, "status"=>(int)$this->params['status'], "reason_blocking_code"=>$this->params['reason_blocking_code']?:null, "time_expiration_blocking"=>$this->params['time_blocking']?:null, "role_id"=>(int)$this->params['role_id'], "admin"=>$this->params['admin']], $user_id);

        if(!$this->params['admin']){
             $app->model->users_notify_list->delete("user_id=?", [$user_id]);
        }

        if($this->data->id != $user_id && !$this->getRole($this->params['role_id'])->chief){
            if($this->params['privileges']){
                $app->model->users_privileges->delete("user_id=?", [$user_id]);
                foreach ($this->params['privileges'] as $privilege_id => $nested) {
                    $privilege = $app->model->system_privileges->find("id=?", [$privilege_id]);
                    if($privilege){
                        foreach ($nested as $privilege_name => $value) {
                            $app->model->users_privileges->insert(["user_id"=>$user_id, "privilege_id"=>$privilege_id, "privilege_name"=>$privilege_name, "route_id"=>$privilege->route_id]); 
                        }
                    }
                }
            }
        }

        return ['status'=>true];

    }

}

public function getData($user_id=0){
    global $app;
    return $app->model->users->findById($user_id, true);
}

public function getLastAuthData($user_id=0){
    global $app;
    $data = $app->model->auth->find("user_id=? order by id desc", [$user_id]);
    if($data){
        $data->geo = $data->geo ? (object)_json_decode($data->geo) : [];
    }
    return $data;
}

public function getPrivileges($user_id=0){
    global $app;
    $privileges = [];
    $getPrivileges = $app->model->users_privileges->getAll('user_id=?', [$user_id]);
    if($getPrivileges){
        foreach ($getPrivileges as $value) {
            $privileges[$value['privilege_id']][$value['privilege_name']] = true;
        }
    }
    return $privileges;
}

public function getPrivilegesList($user_id=0){
    global $app;
    $privileges = [];
    $getPrivileges = $app->model->users_privileges->getAll('user_id=?', [$user_id]);
    if($getPrivileges){
        foreach ($getPrivileges as $value) {
            $privileges[$value['route_id']][$value['privilege_name']] = true;
        }
    }
    return $privileges;
}

public function getRole($role_id=0){
    global $app;
    if($role_id){
        return $app->model->system_roles->cacheKey(["id"=>$role_id])->find('id=?', [$role_id]);
    }
    return [];
}

public function getToken(){
    global $app;
    $token = null;

    if(isset($this->dashboard)){
        if($app->session->get("dashboard-token-auth")){
            $token = $app->clean->str($app->session->get("dashboard-token-auth"));
        }elseif(_getcookie("dashboard-token-auth")){
            $token = $app->clean->str(_getcookie("dashboard-token-auth"));
            $app->session->set("dashboard-token-auth", $token);
        }
    }else{
        if($app->session->get("token-auth")){
            $token = $app->clean->str($app->session->get("token-auth"));
        }elseif(_getcookie("token-auth")){
            $token = $app->clean->str(_getcookie("token-auth"));
            $app->session->set("token-auth", $token);
        }            
    }

    return $token;
}

public function getVerificationCode($name=null){
    global $app;

    $code = $this->codeVerification();

    return $code[$name] ? (object)$code[$name] : [];

}

public function initAuthorization($user=[], $remember_me=false, $entry_point=null, $device_model=null){
    global $app;

    if($user){

        $token = $this->setAuth($user->id,$remember_me ? true : false, $entry_point, $device_model);
        $app->event->authorizationUser($user); 

        if($app->session->get("ad-create-save")){
            $result = $app->component->ads->publication($app->session->getOnce("ad-create-save"),$user->id);
            return (object)["route"=>$app->component->ads->detectRoute($result), "user_id"=>$user->id, "token"=>$token];
        }

        return (object)["route"=>$app->router->getRoute("profile", [$user->alias]), "user_id"=>$user->id, "token"=>$token];

    }

}

public function initRegistration($params=[], $entry_point=null, $device_model=null){
    global $app;

    if($params){

        $user_id = $this->params($params)->add();

        $token = $this->setAuth($user_id, false, $entry_point, $device_model);

        $user = $app->model->users->find('id=?', [$user_id]);

        $app->event->createUser(["user_id"=>$user->id]);

        if($app->session->get("ad-create-save")){
            $result = $app->component->ads->publication($app->session->getOnce("ad-create-save"),$user->id);
            return (object)["route"=>$app->component->ads->detectRoute($result), "user_id"=>$user_id, "token"=>$token];
        }

        if($app->settings->registration_bonus_status){
            return (object)["route"=>$app->router->getRoute("profile", [$user->alias])."#bonus", "user_id"=>$user_id, "token"=>$token];
        }else{
            return (object)["route"=>$app->router->getRoute("profile", [$user->alias]), "user_id"=>$user_id, "token"=>$token];
        }

    }

}

public function isAdminAuth($token=null){
    global $app;

    if(!$token){
        $token = $app->session->get("dashboard-token-auth");
    }

    if($token){

        $auth = $app->model->auth->find('token=?', [$token]);

        if($auth){

            if($auth->time_expiration == null || strtotime($auth->time_expiration) > $app->datetime->getTime()){

                $user = $app->model->users->find('id=?', [$auth->user_id]);
                if($user && !$user->delete){
                    if($user->status == 1){
                        return (object)["status"=>true, "user_id"=>$auth->user_id];
                    }
                }

            }

        }

    }

    return (object)["status"=>false];
    
}

public function isAdminAuthAndCheckAccess($permission=null, $route_id=null){
    global $app;

    $auth = $this->isAdminAuth();

    if($auth->status){
        $user = $app->model->users->find('id=?', [$auth->user_id]);
    }

    if(!$user || $user->delete){
        return (object)["status"=>false];
    }

    if($user->role_id){
        $user->role = $this->getRole($user->role_id);
        $user->privileges = $this->getPrivileges($auth->user_id);
    }

    if($user->role->chief){
        return (object)["status"=>true];
    }

    if(isset($permission) && $route_id){

        $getPrivilege = $app->model->system_privileges->find('route_id=?', [$route_id]);

        if($getPrivilege){

            if($user->privileges){

                if(isset($user->privileges[$getPrivilege->id][$permission])){
                    return (object)["status"=>true];
                }

            }

        }

    }

    return (object)["status"=>false];

}

public function isAuth(){
    global $app;

    if($this->data){
        return true;
    }

    return false;
}

public function labelActivity($time_last_activity=null){
    global $app;
    if(isset($time_last_activity)){
        if($app->datetime->addMinute(5)->getTime($time_last_activity) > $app->datetime->currentTime()){
            return translate("tr_49baa6a68525093720247b1c9012ec2b");
        }else{
            return translate("tr_136d70f1713206f5bf8c4506cd4d1e6f").' '.$app->datetime->outLastTime($time_last_activity);
        }
    }
    return '';
}

public function logout(){
    global $app;
    $token = $this->getToken();
    if(isset($token)){
        $app->model->auth->delete('token=?', [$token]);
        $this->deleteToken();      
    }
    $app->session->delete("administrator-enter-profile");
}

public function name($data=[],$shortName=false){
    global $app;

    $join = [];

    if(!is_array($data)){
        $data = (array)$data;
    }

    if($data['name']){
        $join['name'] = _ucfirst($data['name']);
    }

    if($data['surname']){
        if($shortName){
            $join['surname'] = _ucfirst($data['surname'], true) . '.';
        }else{
            $join['surname'] = $data['surname'];
        }
    }

    return $join ? implode(' ', $join) : '';
}

public function outTablePrivileges($user_id=0){
    global $app;

    $codePermissions = $this->codePermissions();

    ob_start();

    $userPrivileges = $user_id ? $this->getPrivileges($user_id) : [];
    $getPrivileges = $app->model->system_privileges->sort("id desc")->getAll();
    if($getPrivileges){
      foreach ($getPrivileges as $key => $privilege) {

        ?>
        <tr>
          <td class="text-nowrap fw-medium"><?php echo translateField($privilege['name']); ?></td>
          <td>
            <div class="d-flex">

              <?php
              foreach (explode(",", $privilege['permissions']) as $permission_key) {
                ?>

                <div class="form-check me-3 me-lg-5 container-all-checkbox">
                  <input class="form-check-input" type="checkbox" <?php if(isset($userPrivileges[$privilege['id']][$permission_key])){ echo 'checked=""'; } ?> name="privileges[<?php echo $privilege['id']; ?>][<?php echo $permission_key; ?>]" value="1" id="user_privilege_<?php echo $permission_key; ?>_<?php echo $privilege['id']; ?>" />
                  <label class="form-check-label" for="user_privilege_<?php echo $permission_key; ?>_<?php echo $privilege['id']; ?>"> <?php echo $codePermissions[$permission_key]["name"]; ?> </label>
                </div>

                <?php
              }
              ?>
              
            </div>
          </td>
        </tr>
        <?php
      }
    }

    return ob_get_clean();

}

public function params($params=[]){
    $this->params = $params;
    return $this;
}

public function setActionLog($action_id=null, $params=[]){
    global $app;
    if(isset($action_id)){
        $app->model->users_logs->insert(["user_id"=>$this->data->id, "time_create"=>$app->datetime->getDate(), "action_id"=>$action_id, "body"=>encrypt(_json_encode($params))]);
    }
}

public function setAuth($user_id=0, $remember_me=null, $entry_point=null, $device_model=null){
    global $app;

    if($user_id){

        $token = generateHashString();

        $app->system->addAuth(["user_id"=>$user_id, "token"=>$token, "entry_point"=>$entry_point, "device_model"=>$device_model]);
        $app->system->addAuthSession(["user_id"=>$user_id, "device_model"=>$device_model]);

        if($this->dashboard){

            if($remember_me){
                _setcookie(["key"=>"dashboard-token-auth", "value"=>$token, "lifetime"=>$app->datetime->addDay(30)->getTime()]);
            }

            $app->session->set("dashboard-token-auth", $token);
            $app->session->delete("dashboard-login-attempts");

        }else{

            if($remember_me){
                _setcookie(["key"=>"token-auth", "value"=>$token, "lifetime"=>$app->datetime->addDay(30)->getTime()]);
            }

            $app->session->set("token-auth", $token);
            $app->session->delete("login-attempts");

        }

        return $token;

    }

}

public function setTimeLastActivity($user_id=0){
    global $app;
    $app->model->users->update(["time_last_activity"=>$app->datetime->getDate()], $user_id);
}

public function setUserId($userId=null){
    $this->userId = $userId;
    return $this;
}

public function status($status=0){
    global $app;
    if($status == 1){
        return (object)["name"=>translate("tr_318150c53b2ec43a3ffef0f443596df1"), "label"=>"success"];
    }elseif($status == 2){
        return (object)["name"=>translate("tr_b6c10e7546945122976732d133e2d28a"), "label"=>"danger"];
    }else{
        return (object)["name"=>translate("tr_17de549418a3c05ceb11239adee121a8"), "label"=>"secondary"];
    }
}

public function statusActivity($time_last_activity=null){
    global $app;
    if(isset($time_last_activity)){
        if($app->datetime->addMinute(5)->getTime($time_last_activity) > $app->datetime->currentTime()){
            return true;
        }
    }
    return false;
}

public function verificationAccess($permission=null, $route_id=null){
    global $app;

    if(!isset($route_id)){
        $route_id = $app->router->currentRoute->route_id;
    }

    if($this->data->role->chief){
        return (object)["status"=>true];
    }

    if(isset($this->userId)){
        if($this->userId == $this->data->id){
            $this->userId = null;
            return (object)["status"=>true];
        }
        $this->userId = null;
    }

    if(isset($permission) && $route_id){

        $getPrivilege = $app->model->system_privileges->find('route_id=?', [$route_id]);

        if($getPrivilege){

            if($this->data->privileges){

                if(isset($this->data->privileges[$getPrivilege->id][$permission])){
                    return (object)["status"=>true];
                }

            }

        }

    }

    return (object)["status"=>false];

}

public function verificationAuth($token=null){
    global $app;

    if(!isset($token)){
        $token = $this->getToken();
    }

    if(!$this->dashboard){
        if($app->session->get("administrator-enter-profile")){

            $user = $this->getData($app->session->get("administrator-enter-profile"));

            if($user && !$user->delete){
                $this->data = $user;
                return true;
            }
            
        }
    }
    
    if(isset($token)){

        $auth = $this->isAdminAuth($token);

        if($auth->status){

            $user = $this->getData($auth->user_id);

            if($user && !$user->delete){
                $this->data = $user;
                $this->setTimeLastActivity($auth->user_id);
                return true;
            }
                
        }

    }

    return false;
}



 }