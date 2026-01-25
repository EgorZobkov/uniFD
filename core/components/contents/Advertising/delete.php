public function delete($id=0){
    global $app;

    $app->model->advertising->delete("id=?", [$id]);
    $app->model->advertising_transitions->delete("advertising_id=?", [$id]);

}