public function profileAuth()
{
    if(!$this->user->setUserId($_POST['user_id'])->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $getUser = $this->model->users->find('id=?', [$_POST['user_id']]);

    $this->session->set("administrator-enter-profile", $_POST['user_id']);

    return json_answer(["link"=>$this->router->getRoute("profile", [$getUser->alias])]);
}