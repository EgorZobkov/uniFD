public function outInfoPaidCategory($category_id=0, $user_id=0){
    global $app;

    if($app->component->ads_categories->categories[$category_id]["paid_status"]){

        if($app->component->ads_categories->categories[$category_id]["paid_free_count"]){

            if($app->component->ads->getCountFreePublicationsByUser($user_id, $category_id) >= (int)$app->component->ads_categories->categories[$category_id]["paid_free_count"]){

                return translate("tr_e7a1c347a5499e07ddb193041121d536")." ".$app->system->amount($app->component->ads_categories->categories[$category_id]["paid_cost"]);

            }else{

                return translate("tr_df0ef1856bbdb1391833422d6e4b9cae")." ".$app->component->ads->getRemainedCountFreePublicationsByUser($user_id, $category_id)." ".translate("tr_d6ef87c45f89a8c35aafff615fa38b50")." ".$app->system->amount($app->component->ads_categories->categories[$category_id]["paid_cost"]);
            }
            
        }else{
            return translate("tr_c91ec5934a89a80809ec4d183fb441d3")." ".$app->system->amount($app->component->ads_categories->categories[$category_id]["paid_cost"]);
        }

    }

}