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