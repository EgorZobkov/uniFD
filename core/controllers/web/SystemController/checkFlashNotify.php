public function checkFlashNotify(){   
    $notify = $this->session->getNotify("web");
    if(isset($notify)){
        return _json_encode($notify);
    }
    return null;
}