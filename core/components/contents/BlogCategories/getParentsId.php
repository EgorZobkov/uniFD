public function getParentsId($id=0){
    global $app;

    $data = [];

    $category = $this->getCategory($id);

    if($category["parent_id"]!=0){ 
        $data = $this->getParentsId($category["parent_id"]);            
    }

    $data[] = $category;

    return $data; 
           
}