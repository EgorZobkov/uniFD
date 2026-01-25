public function deliveryStatus()
{

    if($_POST["status"] == "true"){
        $this->model->users->cacheKey(["id"=>$this->user->data->id])->update(["delivery_status"=>1], $this->user->data->id);
        $this->model->ads_data->update(["delivery_status"=>1], ["user_id=? and delivery_status=?", [$this->user->data->id,2]]);
    }else{
        $this->model->users->cacheKey(["id"=>$this->user->data->id])->update(["delivery_status"=>0], $this->user->data->id);
        $this->model->ads_data->update(["delivery_status"=>2], ["user_id=? and delivery_status=?", [$this->user->data->id,1]]);
    }

    return json_answer(["status"=>true]);

}