public function getMainCategories(){
    global $app;

    return $this->categories["parent_id"][0];

}