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