public function deleteFeed($id=0){
    global $app;

    $data = $app->model->import_export_feeds->find("id=?", [$id]);

    if($data){
        $app->model->import_export_feeds->delete("id=?", [$id]);
        unlink($app->config->storage->files_import_export.'/'.$data->filename);
    }

}