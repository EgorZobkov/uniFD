public function countByAdId($data=[]){
    global $app;

    return $app->model->reviews->count("item_id=? and whom_user_id=? and status=? and parent_id=?", [$data->id,$data->user_id,1,0]);

}