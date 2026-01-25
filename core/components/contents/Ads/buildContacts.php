public function buildContacts($params=[]){
    global $app;
    return encrypt(_json_encode(["name"=>$params["contact_name"],"email"=>$params["contact_email"],"phone"=>$app->clean->phone($params["contact_phone"]),"whatsapp"=>$params["contact_whatsapp"],"telegram"=>trim($params["contact_telegram"], "@"),"max"=>trim($params["contact_max"], "@")]));
}