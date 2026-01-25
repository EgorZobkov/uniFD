public function deleteByImport($id=0,$limit=null){
    global $app;

    if(isset($limit)){
       $getData = $app->model->ads_data->getAll("import_id=? limit $limit", [$id]); 
    }else{
       $getData = $app->model->ads_data->getAll("import_id=?", [$id]);
    }

    if($getData){

        foreach ($getData as $key => $value) {

            $this->deleteMedia(_json_decode($getData->media));

            $app->model->ads_data->delete("id=?", [$value["id"]]);

        }
      
    }

}