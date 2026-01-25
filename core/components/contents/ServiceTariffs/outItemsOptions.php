public function outItemsOptions($items=[]){
    global $app;

    $getItems = $app->model->users_tariffs_items->getAll();

    if($getItems){
        foreach ($getItems as $key => $value){
            if(compareValues($items, $value["id"])){
                echo '<option value="'.$value["id"].'" selected="" >'.$value["name"].'</option>';
            }else{
                echo '<option value="'.$value["id"].'" >'.$value["name"].'</option>';
            }
        }            
    }

}