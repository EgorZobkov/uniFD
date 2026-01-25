 public function buildPresetFilters($ad_id=0, $category_id = 0){
      global $app;

      $ids = [];
      $template = $app->component->ads_categories->categories[$category_id]["filter_template_preset"];
      
      if(!$template){
          return '';
      }

      preg_match_all("|{(.*?)}|", $template, $result);

      if($result[1]){

         foreach ($result[1] as $id) {

             $ids[] = $id;

         }

      }

      if($ids){
         return $this->outPropertyAd($ad_id,$ids);
      }else{
         return '';
      }

 }