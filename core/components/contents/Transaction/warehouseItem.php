public function warehouseItem($item_id=0,$count=0,$action=null){
    global $app;

    $getAd = $app->model->ads_data->find("id=?", [$item_id]);

    if(!$getAd->not_limited){

        if($action == "-"){

            $count = abs($getAd->in_stock - $count);

            if($count){
                $app->model->ads_data->cacheKey(["id"=>$item_id])->update(["in_stock"=>$count], $item_id);
            }else{
                $app->model->ads_data->cacheKey(["id"=>$item_id])->update(["in_stock"=>0, "status"=>7], $item_id);
            }

        }elseif($action == "+"){

            $count = $getAd->in_stock + $count;

            $app->model->ads_data->cacheKey(["id"=>$item_id])->update(["in_stock"=>$count, "status"=>1], $item_id);

        }

    }

}