public function outAllStatusesOptions($status_id=null){
    global $app;

    $result = '';

    foreach ($this->allStatuses() as $key => $value) {
        if(isset($status_id)){
            if($status_id == $key){
                $result .= '<option value="'.$key.'" selected="" >'.$value.'</option>';
            }else{
                $result .= '<option value="'.$key.'" >'.$value.'</option>';
            }
        }else{
            $result .= '<option value="'.$key.'" >'.$value.'</option>';
        }
    }

    return $result;

}