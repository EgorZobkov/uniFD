public function addFreePublications($ad_id=0, $user_id=0, $category_id=0){
    global $app;

    if($app->component->ads_categories->categories[$category_id]["paid_status"]){
        if($app->component->ads_categories->categories[$category_id]["paid_free_count"]){

            $getPublication = $app->model->ads_free_publications->find("user_id=? and category_id=? and ad_id=?", [$user_id,$category_id,$ad_id]);
            if(!$getPublication){

                if($this->getRemainedCountFreePublicationsByUser($user_id, $category_id)){
                    $app->model->ads_free_publications->insert(["ad_id"=>$ad_id, "user_id"=>$user_id, "category_id"=>$category_id]);
                }

            }

        }
    }

}