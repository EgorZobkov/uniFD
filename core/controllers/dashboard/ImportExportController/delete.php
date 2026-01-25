public function delete()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->component->import_export->delete($_POST['id']);

    unlink($this->config->storage->logs.'/import_'.md5($_POST['id']).'.txt');

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);
}