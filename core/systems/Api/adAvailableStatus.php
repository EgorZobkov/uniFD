 public function adAvailableStatus($unlimitedly=false, $available=0){
    if($unlimitedly){
       return true;
    }else{
       if($available > 0){
         return true;
       }else{
         return false;
       }
    }
 }