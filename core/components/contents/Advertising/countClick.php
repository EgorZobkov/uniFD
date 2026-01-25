public function countClick($id=0){
    global $app;

    return $app->model->advertising_transitions->count("advertising_id=?", [$id]);
    
}