public function dataComparisonAndImport($data=[], $fields=[], $update=false){
    global $app;

    $result = [];
    $errors = [];
    $ad = [];
    $user_id = 0;
    $city_id = 0;
    $category_id = 0;
    $paramsData = isset($data["params"]) ? _json_decode($data["params"]) : [];
    $fields_table = $this->fieldsTable($data["table"]);

    if($data && $fields && $paramsData){

        if($data["table"] == "ads"){

            foreach ($fields as $key => $value) {

                if($paramsData["fields"]["title"] == $key){ $result["title"] = trim($value); }
                if($paramsData["fields"]["price"] == $key){ $result["price"] = trim($value); }
                if($paramsData["fields"]["old_price"] == $key){ $result["old_price"] = trim($value); }
                if($paramsData["fields"]["images"] == $key){ $result["images"] = trim($value); }
                if($paramsData["fields"]["text"] == $key){ $result["text"] = trim($value); }
                if($paramsData["fields"]["date"] == $key){ $result["date"] = trim($value); }
                if($paramsData["fields"]["category"] == $key){ $result["category"] = trim($value); }
                if($paramsData["fields"]["in_stock"] == $key){ $result["in_stock"] = trim($value); }
                if($paramsData["fields"]["link_video"] == $key){ $result["link_video"] = trim($value); }
                if($paramsData["fields"]["external_content"] == $key){ $result["external_content"] = trim($value); }
                if($paramsData["fields"]["partner_link"] == $key){ $result["partner_link"] = trim($value); }
                if($paramsData["fields"]["city"] == $key){ $result["city"] = trim($value); }
                if($paramsData["fields"]["region"] == $key){ $result["region"] = trim($value); }
                if($paramsData["fields"]["filter"] == $key){ $result["filter"] = trim($value); }
                if($paramsData["fields"]["address_latitude"] == $key){ $result["address_latitude"] = trim($value); }
                if($paramsData["fields"]["address_longitude"] == $key){ $result["address_longitude"] = trim($value); }
                if($paramsData["fields"]["contact_name"] == $key){ $result["contact_name"] = trim($value); }
                if($paramsData["fields"]["contact_surname"] == $key){ $result["contact_surname"] = trim($value); }
                if($paramsData["fields"]["contact_phone"] == $key){ $result["contact_phone"] = trim($value); }
                if($paramsData["fields"]["contact_email"] == $key){ $result["contact_email"] = trim($value); }
                if($paramsData["fields"]["import_item_id"] == $key){ $result["import_item_id"] = trim($value); }
                
            }

            if($result){

                if($result["import_item_id"]){
                    $ad = $app->model->ads_data->find("import_item_id=? and import_id=?", [$result["import_item_id"], $data["id"]]);
                }

                if(!$ad){

                    if(!trim($result["title"])){
                        $errors[] = translate("tr_057300f3a6ae1ac1288c1f3d0d92f4d5");
                    }elseif(!trim($result["text"])){
                        $errors[] = translate("tr_94e212c1ee775cf0d07dde374efb4d78");
                    }

                    if($paramsData["city_auto"]){

                        if(trim($result["city"]) && trim($result["region"])){
                            $getCity = $app->model->geo_cities->find("name=? and region_name=?", [trim($result["city"]), trim($result["region"])]);
                            if($getCity){
                                $city_id = $getCity->id;
                            }
                        }

                    }else{
                        $city_id = $paramsData["city_id"];
                    }

                    if($paramsData["user_reg"]){

                        if(!trim($result["contact_name"])){
                            $errors[] = translate("tr_9f28549fa7d5099affe70c481f38b8be");
                        }elseif(!trim($result["contact_phone"])){
                            $errors[] = translate("tr_053c97bc2f9cfef167aded2ee183c957");
                        }

                    }else{
                        $user_id = $paramsData["user_id"];
                    }

                    if($paramsData["category_auto"]){

                        if(trim($result["category"])){

                            if(strpos(trim($result["category"]), "|") !== false){

                                $explode_category = explode("|", trim($result["category"]));

                                if(count($explode_category) >= 2){

                                    $end_name_category = $explode_category[count($explode_category)-1];
                                    $penultimate_name_category = $explode_category[count($explode_category)-2];
                                    
                                    $getCategories = $app->model->ads_categories->getAll("name=?", [$end_name_category]);

                                    if($getCategories){

                                        foreach ($getCategories as $cat_value) {
                                            
                                            $getCategory = $app->model->ads_categories->find("id=? and name=?", [$cat_value["parent_id"], $penultimate_name_category]);

                                            if($getCategory){
                                                $category_id = $cat_value["id"];
                                                break;
                                            }

                                        }

                                    }

                                }

                                if(!$category_id){
                                    $errors[] = translate("tr_d502d66a9145993fae0678d0396687bb");
                                }

                            }elseif(intval($result["category"])){

                                $getCategory = $app->model->blog_categories->find("id=?", [intval($result["category"])]);
                                if($getCategory){
                                    $category_id = $getCategory->id;
                                }else{
                                    $errors[] = translate("tr_64d6945e074f23091202ba876d53b26e");
                                }

                            }else{

                                $getCategory = $app->model->blog_categories->find("name=?", [trim($result["category"])]);
                                if($getCategory){
                                    $category_id = $getCategory->id;
                                }else{
                                    $errors[] = translate("tr_97c1869be5a30a4dcbf7877f2f1f5070");
                                }

                            }
                            
                        }

                    }else{
                        if($paramsData["category_id"]){
                            $category_id = $paramsData["category_id"];
                        }else{
                            $errors[] = translate("tr_79341b0c3296b10149c99d29bc55e263");
                        }
                    }
                    
                    if(!$errors){

                        if($paramsData["image_download"]){
                            $result["images"] = $this->uploadImagesAds($result["images"], $paramsData["image_count_download"] ?: 5);
                        }else{
                            $result["images"] = $this->buildLinksImagesAds($result["images"]);
                        }

                        if($paramsData["only_photos"]){
                            if(!$result["images"]){
                                $errors[] = translate("tr_65109552db266f5841336023201b4879");
                            }
                        }

                    }

                    if(!$errors){

                        if(!$user_id){
                            $findUser = $app->model->users->find("email=? or phone=?", [$result["contact_email"],$result["contact_phone"]]);
                            if(!$findUser){
                                $user_id = $app->user->params(["status"=>1, "name"=>$result["contact_name"] ?: null, "surname"=>$result["contact_surname"] ?: null, "email"=>$result["contact_email"] ?: null, "phone"=>$result["contact_phone"] ?: null, "import_id"=>$data["id"]])->add();
                            }else{
                                $user_id = $findUser->id;
                            }
                        }

                        $result["filter"] = $app->component->ads_filters->buildIdsByNames($result["filter"]);

                        $app->component->ads->publicationByImport(["title"=>$result["title"] ?: null, "price"=>$result["price"] ?: 0, "old_price"=>$result["old_price"] ?: 0, "category_id"=>$category_id, "text"=>$result["text"] ?: null, "date"=>$result["date"] ?: null, "in_stock"=>$result["in_stock"], "link_video"=>$result["link_video"] ?: null, "external_content"=>$result["external_content"] ?: null, "partner_link"=>$result["partner_link"] ?: null, "geo_address_latitude"=>$result["address_latitude"] ?: null, "geo_address_longitude"=>$result["address_longitude"] ?: null, "auto_renewal"=>$result["auto_renewal"], "geo_city_id"=>$city_id, "user_id"=>$user_id, "contact_name"=>$result["contact_name"] ?: null, "contact_phone"=>$result["contact_phone"] ?: null, "contact_email"=>$result["contact_email"] ?: null, "import_id"=>$data["id"], "media"=>$result["images"] ?: null, "filter"=>$result["filter"] ?: null, "import_item_id"=>$result["import_item_id"]]);
                    }

                }else{

                    $update_fields = [];

                    if($update){

                        if($paramsData["update_fields"]){
                            foreach ($paramsData["update_fields"] as $key => $value) {

                                if($result[$value]){

                                    if($value == "title"){
                                        if($ad->title != $result[$value]){
                                            $update_fields[$value] = $result[$value];
                                        }
                                    }elseif($value == "price"){
                                        $result[$value] = preg_replace('/\s+/', '', $result[$value]);
                                        if($ad->price != $result[$value]){
                                            $update_fields[$value] = $result[$value];
                                        }
                                    }elseif($value == "old_price"){
                                        $result[$value] = preg_replace('/\s+/', '', $result[$value]);
                                        if($ad->old_price != $result[$value]){
                                            $update_fields[$value] = $result[$value];
                                        }
                                    }elseif($value == "text"){
                                        if($ad->text != $result[$value]){
                                            $update_fields[$value] = $result[$value];
                                        }
                                    }elseif($value == "in_stock"){
                                        $result[$value] = preg_replace('/\s+/', '', $result[$value]);
                                        if($ad->in_stock != $result[$value]){
                                            $update_fields[$value] = (int)$result[$value];
                                        }
                                    }

                                }

                            }
                        }

                        if($update_fields){
                            $update_fields["time_update"] = $app->datetime->getDate();
                            $app->model->ads_data->update($update_fields, $ad->id);
                            $this->addLog($data["id"], 'Update: №'.$ad->article_number.', fields: '._json_encode($update_fields));
                        }

                    }

                }

            }else{
                $errors[] = translate("tr_3ddf0b144ffb3e2a5d2d2580d689ee3e");
            }

            if($errors){
                $this->addLog($data["id"], implode(",", $errors));
            }

            return count($errors);

        }elseif($data["table"] == "users"){

            foreach ($fields as $key => $value) {

                if($paramsData["fields"]["name"] == $key){ $result["name"] = trim($value); }
                if($paramsData["fields"]["surname"] == $key){ $result["surname"] = trim($value); }
                if($paramsData["fields"]["email"] == $key){ $result["email"] = trim($value); }
                if($paramsData["fields"]["phone"] == $key){ $result["phone"] = trim($value); }
                if($paramsData["fields"]["avatar"] == $key){ $result["avatar"] = trim($value); }
                if($paramsData["fields"]["password"] == $key){ $result["password"] = trim($value); }
                if($paramsData["fields"]["balance"] == $key){ $result["balance"] = trim($value); }
                if($paramsData["fields"]["organization_name"] == $key){ $result["organization_name"] = trim($value); }

            } 

            if($result){

                if(!trim($result["name"])){
                    $errors[] = translate("tr_fe79ce33b28b1861636d9686e91b9dde");
                }elseif(!trim($result["email"])){
                    $errors[] = translate("tr_315ac6d9f14dfa4bff167979bc6245a6");
                }
                
                if(!$errors){
                    $app->user->params(["status"=>1, "name"=>$result["name"] ?: null, "surname"=>$result["surname"] ?: null, "email"=>$result["email"] ?: null, "phone"=>$result["phone"] ?: null, "avatar"=>$result["avatar"] ?: null, "import_id"=>$data["id"], "password"=>$result["password"] ?: null, "balance"=>$result["balance"] ? round($result["balance"], 2) : 0, "organization_name"=>$result["organization_name"] ?: null, "user_status"=>$result["organization_name"] ? 'company' : 'user'])->add();
                }
                
            }else{
                $errors[] = translate("tr_3ddf0b144ffb3e2a5d2d2580d689ee3e");
            }

            if($errors){
                $this->addLog($data["id"], implode(",", $errors));
            }

            return count($errors);

        }elseif($data["table"] == "blog_posts"){

            foreach ($fields as $key => $value) {

                if($paramsData["fields"]["title"] == $key){ $result["title"] = trim($value); }
                if($paramsData["fields"]["content"] == $key){ $result["content"] = trim($value); }
                if($paramsData["fields"]["category"] == $key){ $result["category"] = trim($value); }
                if($paramsData["fields"]["image"] == $key){ $result["image"] = trim($value); }
                if($paramsData["fields"]["alias"] == $key){ $result["alias"] = trim($value); }

            } 

            if($result){

                if(!trim($result["title"])){
                    $errors[] = translate("tr_057300f3a6ae1ac1288c1f3d0d92f4d5");
                }elseif(!trim($result["content"])){
                    $errors[] = translate("tr_94e212c1ee775cf0d07dde374efb4d78");
                }

                if(!$paramsData["category_id"]){

                    if(trim($result["category"])){

                        if(strpos(trim($result["category"]), "|") !== false){

                            $explode_category = explode("|", trim($result["category"]));

                            if(count($explode_category) >= 2){

                                $end_name_category = $explode_category[count($explode_category)-1];
                                $penultimate_name_category = $explode_category[count($explode_category)-2];
                                
                                $getCategories = $app->model->blog_categories->getAll("name=?", [$end_name_category]);

                                if($getCategories){

                                    foreach ($getCategories as $cat_value) {
                                        
                                        $getCategory = $app->model->blog_categories->find("id=? and name=?", [$cat_value["parent_id"], $penultimate_name_category]);

                                        if($getCategory){
                                            $category_id = $cat_value["id"];
                                            break;
                                        }

                                    }

                                }

                            }

                            if(!$category_id){
                                $errors[] = translate("tr_d502d66a9145993fae0678d0396687bb");
                            }

                        }elseif(intval($result["category"])){

                            $getCategory = $app->model->blog_categories->find("id=?", [intval($result["category"])]);
                            if($getCategory){
                                $category_id = $getCategory->id;
                            }else{
                                $errors[] = translate("tr_64d6945e074f23091202ba876d53b26e");
                            }

                        }else{

                            $getCategory = $app->model->blog_categories->find("name=?", [trim($result["category"])]);
                            if($getCategory){
                                $category_id = $getCategory->id;
                            }else{
                                $errors[] = translate("tr_97c1869be5a30a4dcbf7877f2f1f5070");
                            }

                        }
                        
                    }

                }else{
                    if($paramsData["category_id"]){
                        $category_id = $paramsData["category_id"];
                    }else{
                        $errors[] = translate("tr_79341b0c3296b10149c99d29bc55e263");
                    }
                }
                
                if(!$errors){

                    if(!isJson($result["content"])){
                        $result["content"] = _json_encode([["text"=>$result["content"]]]);
                    }

                    $result["alias"] = $result["alias"] ? slug($result["alias"]) : slug($result["title"]);

                    if($paramsData["image_download"]){
                        if($result["image"]){
                            $result["image"] = $this->uploadImages($result["image"], $app->config->storage->blog, 1)[0];
                        }
                    }

                    $app->model->blog_posts->insert(["status"=>1, "time_create"=>$app->datetime->getDate(), "title"=>$result["title"] ?: null, "image"=>$result["image"] ?: null, "category_id"=>$category_id, "content"=>$result["content"] ?: null, "alias"=>$result["alias"] ?: null, "import_id"=>$data["id"]]);
                }
                
            }else{
                $errors[] = translate("tr_3ddf0b144ffb3e2a5d2d2580d689ee3e");
            }

        }
       
    }

    if($errors){
        $this->addLog($data["id"], implode(",", $errors));
    }

    return count($errors);

}