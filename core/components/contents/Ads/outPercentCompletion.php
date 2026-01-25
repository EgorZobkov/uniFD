public function outPercentCompletion($data=[]){

    $result = 0;

    $start = strtotime($data->time_expiration) - ($data->publication_period * 86400);

    if($start){

        $result = ((time() - $start) / (strtotime($data->time_expiration) - $start)) * 100;

    }

    return $result >= 100 ? 100 : round($result, 2);

}