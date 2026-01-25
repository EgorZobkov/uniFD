public function getRole($role_id=0){
    global $app;
    if($role_id){
        return $app->model->system_roles->cacheKey(["id"=>$role_id])->find('id=?', [$role_id]);
    }
    return [];
}