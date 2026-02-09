public function getAd($id=0, $user_id=0){
    global $app;

    if($user_id){
        $data = $app->model->ads_data->find("id=? and user_id=?", [$id,$user_id]);
    }else{
        $data = $app->model->ads_data->find("id=?", [$id]);
    }

    if($data){

        $data->category = (object)$app->component->ads_categories->categories[$data->category_id];
        $data->geo = $app->component->geo->getCityData($data->city_id);
        $data->user = $app->model->users->findById($data->user_id, true);
        $data->raw_media = $data->media ? _json_decode($data->media) : [];
        $data->media = $this->getMedia($data->media);
        $visibility = $app->model->users_contacts_visibility->find("user_id=?", [$data->user_id]);
        $uc = is_object($data->user->contacts ?? null) ? $data->user->contacts : (object)[];
        $data->contacts = (object)[
            "name" => $data->user->name ?? '',
            "email" => $visibility ? ($visibility->email ?: $data->user->email) : ($data->user->email ?? ''),
            "phone" => $visibility ? ($visibility->phone ?: $data->user->phone) : ($data->user->phone ?? ''),
            "telegram" => $visibility ? ($visibility->telegram ?? '') : ($uc->telegram ?? ''),
            "vk" => $visibility ? ($visibility->vk ?? '') : '',
            "whatsapp" => $uc->whatsapp ?? '',
            "max" => $uc->max ?? ''
        ];
        $data->external_content = $data->external_content ? decrypt($data->external_content) : null;
        if($data->reason_blocking_code){
            $data->reason = $app->system->getReasonBlocking($data->reason_blocking_code);
        }

        if($data->booking_status){
            $data->booking = $app->model->ads_booking_data->find("ad_id=?", [$id]);
            if($data->booking){
                $data->booking->week_days_price = $data->booking->week_days_price ? _json_decode($data->booking->week_days_price) : [];
                $data->booking->additional_services = $data->booking->additional_services ? _json_decode($data->booking->additional_services) : [];
                $data->booking->special_days = $data->booking->special_days ? _json_decode($data->booking->special_days) : [];
            }
        }
        
        return $data;
    }else{

        $data = (object)[];
        $get = $app->model->ads_delete->find("ad_id=?", [$id]);
        if($get){
            $data = arrayToObject(_json_decode($get->data));
            $data->title = $data->title . '(' . translate("tr_0c450c40f3e9bca781dd6f676691d793") . ')';
            $data->delete = true;
            $data->media = $this->getMedia();
            return $data;
        }

    }

    return [];

}