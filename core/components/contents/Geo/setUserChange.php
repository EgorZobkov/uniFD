public function setUserChange(){
    global $app;

    if(!$this->getChange()){

        if(_getcookie("geo")){

            $params = _json_decode(_getcookie("geo"));

            if($params){

                if($params["purpose"] == "country"){
                    if($this->statusMultiCountries()){
                        $this->setChange($params["id"], $params["purpose"]);
                    }
                }else{
                    $this->setChange($params["id"], $params["purpose"]);
                }

            }

        }
        
    }

}