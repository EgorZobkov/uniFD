public function getUserCard($user_id=0){
    global $app;

    $user = $app->model->users->findById($user_id);

    if($user){

        $user->service_tariff = $app->component->service_tariffs->getOrderByUserId($user->id);
        $user->shop = $app->component->shop->getActiveShopByUserId($user->id);

        if($user->shop){
            $user->name = $user->shop->title;
            $user->avatar_src = $app->storage->name($user->shop->image)->host(true)->get();
            $user->link = $app->component->shop->linkToShopCard($user->shop->alias);
        }else{
            $user->name = $app->user->name($user, true);
            $user->avatar_src = $app->storage->name($user->avatar)->host(true)->get();
            $user->link = $this->linkUserCard($user->alias);
        }

    }

    return $user;

}