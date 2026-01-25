public function mailingTestSend(){

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->mailer->mailer_service = $_POST['mailer_service'];
    $this->mailer->mailer_from_email = $_POST['mailer_from_email'];
    $this->mailer->mailer_from_name = $_POST['mailer_from_name'];
    $this->mailer->mailer_smtp_host = $_POST['mailer_smtp_host'];
    $this->mailer->mailer_smtp_username = $_POST['mailer_smtp_username'];
    $this->mailer->mailer_smtp_password = $_POST['mailer_smtp_password'];
    $this->mailer->mailer_smtp_port = $_POST['mailer_smtp_port'];
    $this->mailer->mailer_smtp_secure = $_POST['mailer_smtp_secure'];
    $this->mailer->mailer_service_api_key = $_POST['mailer_service_api_key'];

    return $this->mailer->body(['subject'=>translate("tr_5e3d5c58fa308ad3fc40c94d4f9c79d2"),'body'=>translate("tr_5e3d5c58fa308ad3fc40c94d4f9c79d2")])->to($_POST['mailer_from_email'])->send();
}