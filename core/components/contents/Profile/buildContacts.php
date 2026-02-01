public function buildContacts($params=[]){
    global $app;
    return encrypt(_json_encode([
        "whatsapp"=>$params["whatsapp"] ?? null,
        "telegram"=>trim($params["telegram"] ?? "", "@"),
        "max"=>trim($params["max"] ?? "", "@"),
    ]));
}
