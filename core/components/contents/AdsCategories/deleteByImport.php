public function deleteByImport($id=0,$limit=null){
    global $app;

    if(isset($limit)){
       $getIds = $app->model->ads_categories->getAll("import_id=? limit $limit", [$id]); 
    }else{
       $getIds = $app->model->ads_categories->getAll("import_id=?", [$id]);
    }

    if($getIds){

        foreach ($getIds as $key => $value) {

            $this->delete($value["id"]);

        }          

    }

}