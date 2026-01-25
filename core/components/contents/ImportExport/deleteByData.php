public function deleteByData($data=null){
    global $app;

    if($data["table"] == "ads"){
        $app->component->ads->deleteByImport($data["id"], 5000);  
        $app->user->deleteByImport($data["id"], 5000);
        $countAds = $app->model->ads_ids->count('import_id=?', [$data["id"]]);    
        $countUsers = $app->model->users->count('import_id=?', [$data["id"]]);
        if(!$countAds && !$countUsers){
            $this->delete($data["id"]);
        }      
    }elseif($data["table"] == "ads_categories"){
        $app->component->ads_categories->deleteByImport($data["id"], 5000);
        $countCategories = $app->model->ads_categories->count('import_id=?', [$data["id"]]);    
        if(!$countCategories){
            $this->delete($data["id"]);
        }      
    }

}