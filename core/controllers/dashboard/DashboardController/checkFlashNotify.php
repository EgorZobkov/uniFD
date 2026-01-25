public function checkFlashNotify(){   
    $notify = $this->session->getNotify("dashboard");
    if(isset($notify)){
        return _json_encode($notify);
    }
    return null;
}