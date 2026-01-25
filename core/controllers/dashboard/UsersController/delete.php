public function delete()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    if($_POST['user_id'] == $this->user->data->id){
        return json_answer(["status"=>false, "type_answer"=>"warning", "type_show"=>"notice", "answer"=>translate("tr_b6ce0032ceef5257ffba58e11a9093cf")]);
    }

    $user = $this->model->users->find('id=?', [$_POST['user_id']]);

    if($this->user->getRole($user->role_id)->chief){
        if(!$this->user->data->role->chief){
            return json_answer(["status"=>false, "type_answer"=>"warning", "type_show"=>"notice", "answer"=>translate("tr_46827be3ca8fc4bc6fee6d290954e050")]);
        }
    }

    $this->user->delete($_POST['user_id']);

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);
}