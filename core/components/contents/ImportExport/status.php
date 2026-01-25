public function status($status=0){
    global $app;
    if($status == 0){
        return (object)['name'=>translate("tr_017d8732fe062c99eb47cf54f2c7eb08"), 'label'=>'secondary'];
    }elseif($status == 1){
        return (object)['name'=>translate("tr_c665d401097529f7f09717764178123b"), 'label'=>'success'];
    }elseif($status == 2){
        return (object)['name'=>translate("tr_848a83b00a92e5664b4af49d35661a50"), 'label'=>'warning'];
    }elseif($status == 3){
        return (object)['name'=>translate("tr_c6fd3c6a629b51b28c19e8495994f4ca"), 'label'=>'danger'];
    }elseif($status == 4){
        return (object)['name'=>translate("tr_d29a4ba9bbcbf1e1ed1a6b99f8ed3c52"), 'label'=>'secondary'];
    }elseif($status == 5){
        return (object)['name'=>translate("tr_be68dffdb4af0ae31056c5b4dc513cab"), 'label'=>'warning'];
    }
}