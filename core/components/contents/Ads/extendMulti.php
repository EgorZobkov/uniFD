public function extendMulti($adIds=[]){
    global $app;

    if($adIds){
        foreach ($adIds as $key => $id) {

            $expiration = $this->calculationTimeExpiration();

            $app->model->ads_data->cacheKey(["id"=>$id])->update(["status"=>1, "time_expiration"=>$expiration->date, "publication_period"=>$expiration->days], $id);

        }
    }

}