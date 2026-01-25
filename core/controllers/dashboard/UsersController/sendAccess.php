public function sendAccess()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->notify->params(["user_name"=>$_POST['name'], "user_email"=>$_POST['email'], "login"=>$_POST['email'], "password"=>$_POST['password']])->code("system_send_access_administrator")->to($_POST['email'])->sendEmail();

    return json_answer(["status"=>true, "type_answer"=>"success", "type_show"=>"notice"]);
}