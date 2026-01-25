public function delete($id=0, $user_id=0){
    global $app;

    if($user_id){
        $shop = $app->model->shops->find("id=? and user_id=?", [$id, $user_id]);
    }else{
        $shop = $app->model->shops->find("id=?", [$id]);
    }

    if($shop){
        $app->storage->clearAttachFiles([$shop->image]);
        $app->model->shops->delete("id=?", [$shop->id]);
        $app->model->shops_pages->delete("shop_id=?", [$shop->id]);

        $banners = $app->model->shops_banners->getAll("shop_id=?", [$shop->id]);
        if($banners){
            foreach ($banners as $key => $value) {
                $app->storage->clearAttachFiles([$value["image"]]);
            }
        }
        $app->model->shops_banners->delete("shop_id=?", [$shop->id]);
    }

}