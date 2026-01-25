public function clearCache()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->caching->flush();

    $this->session->setNotifyDashboard('success', code_answer("action_successfully"));
    return json_answer(["status"=>true]);

}