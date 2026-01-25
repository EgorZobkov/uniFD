 public function changeStatus()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $data = $this->model->shops->find("id=?", [$_POST['id']]);

    $this->model->shops->update(["status"=>$_POST['status'], "comment"=>null],$_POST['id']);

    $this->event->changeStatusShop(["user_id"=>$data->user_id, "status"=>$_POST['status'], "shop_id"=>$_POST['id'], "shop_link"=>$this->component->shop->linkToShopCard($data->alias)]);

    $this->session->setNotifyDashboard('success', code_answer("action_successfully"));

    return json_answer(["status"=>true]);

}