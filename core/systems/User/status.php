public function status($status=0){
    global $app;
    if($status == 1){
        return (object)["name"=>translate("tr_318150c53b2ec43a3ffef0f443596df1"), "label"=>"success"];
    }elseif($status == 2){
        return (object)["name"=>translate("tr_b6c10e7546945122976732d133e2d28a"), "label"=>"danger"];
    }else{
        return (object)["name"=>translate("tr_17de549418a3c05ceb11239adee121a8"), "label"=>"secondary"];
    }
}