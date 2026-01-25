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