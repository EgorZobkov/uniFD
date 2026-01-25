public function renewalDelete()
{   

    $this->model->ads_data->cacheKey(["id"=>$_POST['id']])->update(["auto_renewal_status"=>0], ["id=? and user_id=?", [$_POST['id'], $this->user->data->id]]);
    return json_answer(["status"=>true]);
    
}