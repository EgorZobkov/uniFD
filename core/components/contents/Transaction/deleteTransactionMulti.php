public function deleteTransactionMulti($adIds=[]){
    global $app;

    if($adIds){
        foreach ($adIds as $key => $id) {

            $app->model->transactions->delete("id=?", [$id]);

        }
    }

}