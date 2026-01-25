public function replaceData($content=[], $data=[]){
    global $app;
   
    $result = [];

    $macrosList = [
        "{domain}"=>getHost(false),
        "{domain_link}"=>getHost(),
        "{project_name}"=>$app->settings->project_name,
        "{project_title}"=>$app->settings->project_title,
        "{contact_email}"=>$app->settings->contact_email,
        "{contact_phone}"=>$app->settings->contact_phone,
        "{contact_organization_name}"=>$app->settings->contact_organization_name,
        "{contact_organization_address}"=>$app->settings->contact_organization_address,
        "{current_geo_name}" => $app->component->geo->getCurrentGeoBySeo()->name,
        "{current_geo_name_declension}" => $app->component->geo->getCurrentGeoBySeo()->name_declension,
        "{current_geo_text}" => $app->component->geo->getCurrentGeoBySeo()->seo_text,
        "{current_category_name}" => translateFieldReplace($app->component->catalog->data->category, "name"),
        "{current_category_title}" => translateFieldReplace($app->component->catalog->data->category, "seo_title"),
        "{current_category_desc}" => translateFieldReplace($app->component->catalog->data->category, "seo_desc"),
        "{current_category_h1}" => translateFieldReplace($app->component->catalog->data->category, "seo_h1"),
        "{current_category_text}" => translateFieldReplace($app->component->catalog->data->category, "seo_text"),
        "{ad_title}" => $data->title,
        "{ad_text}" => $data->text,
        "{ad_price}" => $app->system->amount($data->price),
        "{ad_category_name}" => translateFieldReplace($data->category, "name"),
        "{ad_category_meta_title}" => translateFieldReplace($data->category, "seo_title"),
        "{ad_category_meta_desc}" => translateFieldReplace($data->category, "seo_desc"),
        "{ad_category_h1}" => translateFieldReplace($data->category, "seo_h1"),
        "{ad_category_text}" => translateFieldReplace($data->category, "seo_text"),
        "{ad_city_name}" => translateFieldReplace($data->geo, "name"),
        "{ad_city_name_declension}" => translateFieldReplace($data->geo, "declension"),
        "{ad_city_text}" => translateFieldReplace($data->geo, "seo_text"),
        "{user_name}" => $data->user->name,
        "{user_surname}" => $data->user->surname,
        "{total_reviews}" => $app->component->profile->outTotalReviews($data->user->total_reviews),
        "{shop_title}" => $data->shop->title,
        "{shop_text}" => $data->shop->text,
        "{post_title}" => translateFieldReplace($data, "title"),
        "{post_desc}" => translateFieldReplace($data, "seo_desc"),
        "{blog_current_category_name}" => translateFieldReplace($app->component->blog->data->category, "name"),
        "{blog_current_category_meta_title}" => translateFieldReplace($app->component->blog->data->category, "seo_title"),
        "{blog_current_category_meta_desc}" => translateFieldReplace($app->component->blog->data->category, "seo_desc"),
        "{blog_current_category_h1}" => translateFieldReplace($app->component->blog->data->category, "seo_h1"),
        "{blog_current_category_text}" => translateFieldReplace($app->component->blog->data->category, "seo_text"),
        "{shop_current_category_name}" => translateFieldReplace($data->category, "name"),
        "{shop_current_category_meta_title}" => translateFieldReplace($data->category, "seo_title"),
        "{shop_current_category_meta_desc}" => translateFieldReplace($data->category, "seo_desc"),
        "{shop_current_category_h1}" => translateFieldReplace($data->category, "seo_h1"),
        "{shop_current_category_text}" => translateFieldReplace($data->category, "seo_text"),
    ];

    if($content){

        foreach ($content as $key1 => $value1) {

            foreach ($macrosList as $key2 => $value2) {
                $value1 = str_replace($key2, $value2, $value1);
            }

            $result[$key1] = $this->replaceDefaultData($value1);

        }           

    }

    return (object)$result;

}