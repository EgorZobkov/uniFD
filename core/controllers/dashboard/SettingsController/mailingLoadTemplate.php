public function mailingLoadTemplate(){   
    if($_POST["code"]){
        $getTpl = $this->notify->getActionCode($_POST["code"]);
        if(file_exists($this->config->resource->mail->path.'/'.$getTpl->mail_tpl)){
            return json_answer(["content"=>_file_get_contents($this->config->resource->mail->path.'/'.$getTpl->mail_tpl)]);                    
        }
    }
    return json_answer(["content"=>""]);
}