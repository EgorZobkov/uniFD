public function outBookingEndingWord($count=0, $category_id=0){
    global $app;

    if($app->component->ads_categories->categories[$category_id]["booking_action"] == "booking"){
        return endingWord($count, translate("tr_1b154879c7ea4edfdabef1b2f7fcf184"), translate("tr_f8f61c85fc663385d3fdc791e3a3b8f1"), translate("tr_62a420d2028f13db2842ec1b4bc432cc"));
    }else{
        return endingWord($count, translate("tr_48e438a146f96b54bbe9d5046ffc3a2b"), translate("tr_0871eeafdf38726742fa5affa8a5d6eb"), translate("tr_c183655a02377815e6542875555b1340"));
    }                

}