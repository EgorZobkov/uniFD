public function userId($id=null)
{
    global $app;
    $this->user = $id ? $app->model->users->find("id=?", [$id]) : [];
    $this->userId = $id;
    return $this;
}