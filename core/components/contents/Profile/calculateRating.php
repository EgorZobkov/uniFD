function calculateRating($user_id=0, $item_id=0){
     global $app;

     $array = [];
     $result = 0;

     $array["total_rating"] = 0;
     $array["rating_1"] = 0;
     $array["rating_2"] = 0;
     $array["rating_3"] = 0;
     $array["rating_4"] = 0;
     $array["rating_5"] = 0;

     if($item_id){
         $getReviews = $app->model->reviews->getAll("whom_user_id=? and item_id=? and status=?", [$user_id, $item_id, 1]);
     }else{
         $getReviews = $app->model->reviews->getAll("whom_user_id=? and status=?", [$user_id, 1]);
     }

     if($getReviews){
          foreach ($getReviews as $value) {
              $array["total_rating"] += $value["rating"];
              $array["rating_".$value["rating"]] += $value["rating"];
          }
      }

      $array["rating_1"] = $array["rating_1"] ? $array["rating_1"] : 0;
      $array["rating_2"] = $array["rating_2"] ? $array["rating_2"] : 0;
      $array["rating_3"] = $array["rating_3"] ? $array["rating_3"] : 0;
      $array["rating_4"] = $array["rating_4"] ? $array["rating_4"] : 0;
      $array["rating_5"] = $array["rating_5"] ? $array["rating_5"] : 0;

      if($array["total_rating"]){
         $result = ($array["rating_1"]*1+$array["rating_2"]*2+$array["rating_3"]*3+$array["rating_4"]*4+$array["rating_5"]*5)/$array["total_rating"];
      }

      if($result <= 5){
         return sprintf("%.1f", $result);
      }else{
         return 5.0;
      }

}