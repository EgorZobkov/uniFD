public function modalSize($id=null){
    if($id == "nano"){
        return "max-width: 450px!important;";
    }elseif($id == "small"){
        return "max-width: 550px!important;";
    }elseif($id == "medium"){
        return "max-width: 650px!important;";
    }elseif($id == "big"){
        return "max-width: 750px!important;";
    }elseif($id == "mega"){
        return "max-width: 950px!important;";
    }else{
        return "max-width: ".$id."!important;";
    }
}