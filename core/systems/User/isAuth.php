public function isAuth(){
    global $app;

    if($this->data){
        return true;
    }

    return false;
}