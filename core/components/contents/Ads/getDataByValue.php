public function getDataByValue($data=[]){
    global $app;

    $data["category"] = (object)$app->component->ads_categories->categories[$data["category_id"]];
    $data["geo"] = $app->component->geo->getCityData($data["city_id"]);
    $data["user"] = $app->model->users->findById($data["user_id"], false, true);
    $data["media"] = $this->getMedia($data["media"]);
    $visibility = $app->model->users_contacts_visibility->find("user_id=?", [$data["user_id"]]);
    $user = $data["user"];
    $uc = is_object($user->contacts ?? null) ? $user->contacts : (object)[];
    $data["contacts"] = (object)[
        "name" => $user->name ?? '',
        "email" => $visibility ? ($visibility->email ?: $user->email) : ($user->email ?? ''),
        "phone" => $visibility ? ($visibility->phone ?: $user->phone) : ($user->phone ?? ''),
        "telegram" => $visibility ? ($visibility->telegram ?? '') : ($uc->telegram ?? ''),
        "vk" => $visibility ? ($visibility->vk ?? '') : '',
        "whatsapp" => $uc->whatsapp ?? '',
        "max" => $uc->max ?? ''
    ];

    return (object)$data;

}