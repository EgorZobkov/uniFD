public function buildCategories($user_id=0){   
    global $app;

    $cats = [];
    $categories = [];

    $data = $app->model->ads_data->getAll("status=? and user_id=?", [1, $user_id]);

    if($data){
        foreach ($data as $key => $value) {

            $ids = $app->component->ads_categories->getReverseMainIds($value["category_id"]);

            if($ids){
                foreach (explode(",", $ids) as $id) {
                    $cats[$id] = $id;
                }
            }

        }
    }

    if($cats){
        $categories = $app->component->ads_categories->getCategories(implode(",", $cats));

    }

    return $categories;
    
}