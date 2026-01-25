public function codePermissions(){   
    global $app;

    $result["view"] = ["code"=>"view", "name"=>translate("tr_842484fb6ad9bb3a8a2730301423a0b6")];
    $result["control"] = ["code"=>"control", "name"=>translate("tr_6fdd7d3aa90e5786fa24fb6117f96669")];

    return $result;

}