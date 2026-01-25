public function buildFeed($id=0){
    global $app;

    $feed = $app->model->import_export_feeds->find("id=?", [$id]);

    if($feed){

        $limit = $feed->count_upload_items ?: 1000;

        if($feed->category_id){

            $categories_ids = $app->component->ads_categories->joinId($feed->category_id)->getParentIds($feed->category_id);

            $data = $app->model->ads_data->sort("id desc limit ".$limit)->getAll("status=? and category_id IN (".$categories_ids.")", [1]);

        }else{

            $data = $app->model->ads_data->sort("id desc limit ".$limit)->getAll("status=?", [1]);

        }

        if($data){

            if($feed->feed_format == "json"){

                $result = [];

                foreach ($data as $key => $value) {

                    $value = $app->component->ads->getDataByValue($value);

                    $result["id"] = $value->id;
                    $result["title"] = $value->title;
                    $result["article_number"] = $value->article_number;
                    $result["text"] = $value->text;
                    $result["currency_code"] = $value->currency_code;
                    $result["price"] = $value->price;
                    $result["old_price"] = $value->old_price;
                    $result["category_id"] = $value->category_id;
                    $result["category_name"] = $value->category->name;
                    $result["delivery_status"] = $value->delivery_status;
                    $result["total_rating"] = $value->total_rating;
                    
                    if($feed->utm_data){
                        $url = $app->component->ads->buildAliasesAdCard($value) . '?' . $feed->utm_data;
                    }else{
                        $url = $app->component->ads->buildAliasesAdCard($value);
                    }

                    $result["link"] = $url;

                    if($value->media->images->all){
                        foreach ($value->media->images->all as $link) {
                           $result["images"][] = $link;
                        }
                    }

                    if($feed->out_filters_status){
                        $property = $app->component->ads_filters->outPropertyAd($value->id, [], true);
                        if($property){
                            foreach ($property as $filter_key => $filter_value) {
                                $result["filters"][$filter_key] = $filter_value;
                            }
                        }
                    }

                }

                _file_put_contents($app->config->storage->files_import_export.'/'.$feed->filename, _json_encode($result));

            }else{
                _file_put_contents($app->config->storage->files_import_export.'/'.$feed->filename, $this->buildXml($data, $feed));
            }

        }

    }

}