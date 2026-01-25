public function delete($id=0){
    global $app;

    $parentIds = $this->getParentIds($id);

    if($parentIds){
        foreach (explode(",", $parentIds) as $key => $value) {
           $app->model->blog_categories->delete("id=?", [$value]);
        }
    }

    $app->model->blog_categories->delete("id=?", [$id]);

} 