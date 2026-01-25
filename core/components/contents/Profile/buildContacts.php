public function buildContacts($params=[]){
    global $app;
    return encrypt(_json_encode(["whatsapp"=>$params["whatsapp"],"telegram"=>trim($params["telegram"], "@"),"max"=>trim($params["max"], "@")]));
}