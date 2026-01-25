public function updateAdsStat(){

    $data = $this->model->ads_stat->getAll();     

    if($data){

        foreach ($data as $key => $value) {

            $parentIds = $this->component->ads_categories->joinId($value["category_id"])->getParentIds($value["category_id"]); 

            $count = $this->model->ads_data->count("category_id IN(".$parentIds.") and city_id=? and region_id=? and country_id=? and status=?", [$value["city_id"],$value["region_id"],$value["country_id"],1]);

            if($count){
                $this->model->ads_stat->update(["count_items"=>$count], $value["id"]); 
            }else{
                $this->model->ads_stat->delete("id=?", [$value["id"]]); 
            }

        }

    } 

}