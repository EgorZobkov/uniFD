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