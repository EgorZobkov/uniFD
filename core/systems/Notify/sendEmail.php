public function sendEmail(){
    global $app;

    $to = null;
    $result = [];
    $macrosList = $this->macrosBuild();

    if(isset($this->to)){
        $to = $this->to;
    }elseif(isset($this->user)){
        $to = $this->user->email;
    }

    if(isset($to)){

        $getActionCode = $app->notify->getActionCode($this->code);

        if($getActionCode){

            if(file_exists($app->config->resource->mail->path.'/'.$getActionCode->mail_tpl)){

                $subject = $getActionCode->name;
                $body = obContent($app->config->resource->mail->path.'/'.$getActionCode->mail_tpl);

                foreach($macrosList AS $key => $value){
                    $body = str_replace($key, $value, $body);
                    $subject = str_replace($key, $value, $subject);
                }

                $result = $app->mailer->body(['subject'=>$subject,'body'=>$body, 'attachments'=>$this->params['attachments']?:null])->to($to)->send();   
                            
            }

        }else{

            foreach($macrosList AS $key => $value){
                $this->params['text'] = str_replace($key, $value, $this->params['text']);
                $this->params['subject'] = str_replace($key, $value, $this->params['subject']);
            }

            $result = $app->mailer->body(['subject'=>$this->params['subject'],'body'=>$this->params['text'], 'attachments'=>$this->params['attachments']?:null])->to($to)->send();

        }

    }

    $this->params(null);
    $this->code(null);
    $this->userId(null);
    $this->to(null);

    return $result;

}