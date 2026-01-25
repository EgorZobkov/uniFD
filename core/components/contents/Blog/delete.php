public function delete($id=0){
    global $app;

    $data = $app->model->blog_posts->find("id=?", [$id]);

    if($data){

        $app->storage->name($data->image)->delete();
        $app->model->blog_posts->delete("id=?", [$id]);

    }

}