public function outInfoPaidCategory($category_id=0, $user_id=0){
    global $app;

    if($app->component->ads_categories->categories[$category_id]["paid_status"]){

        if($app->component->ads_categories->categories[$category_id]["paid_free_count"]){

            if($app->user->isAuth()){

                if($app->component->ads->getCountFreePublicationsByUser($user_id, $category_id) >= (int)$app->component->ads_categories->categories[$category_id]["paid_free_count"]){

                    return translate("tr_e7a1c347a5499e07ddb193041121d536")." ".$app->system->amount($app->component->ads_categories->categories[$category_id]["paid_cost"]);

                }else{

                    return translate("tr_df0ef1856bbdb1391833422d6e4b9cae")." ".$app->component->ads->getRemainedCountFreePublicationsByUser($user_id, $category_id)." ".translate("tr_d6ef87c45f89a8c35aafff615fa38b50")." ".$app->system->amount($app->component->ads_categories->categories[$category_id]["paid_cost"]);
                }

            }else{
                return translate("tr_63fa00b1e6fbf0669ea74ebc737d4d21")." ".$app->component->ads_categories->categories[$category_id]["paid_free_count"]." ".endingWord($app->component->ads_categories->categories[$category_id]["paid_free_count"], translate("tr_72da6e264d15bb3fe698cdf4845f5299"), translate("tr_b97a105b2dbb49756bfddbe508adcd3e"), translate("tr_ea8b58390b62bab148e8624a35c7b796"))." ".translate("tr_d6ef87c45f89a8c35aafff615fa38b50")." ".$app->system->amount($app->component->ads_categories->categories[$category_id]["paid_cost"]);
            }
            

        }else{
            return translate("tr_c91ec5934a89a80809ec4d183fb441d3")." ".$app->system->amount($app->component->ads_categories->categories[$category_id]["paid_cost"]);
        }

    }

}