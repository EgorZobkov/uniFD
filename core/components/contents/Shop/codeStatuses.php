public function codeStatuses(){   
    global $app;

    $result["awaiting_verification"] = ["code"=>"awaiting_verification", "name"=>translate("tr_13068c40c12a556c1ed7cd182ac6ab87"), "label"=>'warning'];
    $result["published"] = ["code"=>"published", "name"=>translate("tr_93928aafced6398c7dbc2ee42e498ad9"), "label"=>"success"];
    $result["blocked"] = ["code"=>"blocked", "name"=>translate("tr_06d1f50f12d3f3426428c3de06aac118"), "label"=>"danger"];
    $result["rejected"] = ["code"=>"rejected", "name"=>translate("tr_22c9a6fed5c73377cc7b17aed5d649df"), "label"=>"secondary"];
    
    return $result;

}