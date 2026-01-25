public function outLinkSorting(){
  global $app;

   if($_GET["sort"] == "news"){
      $name = translate("tr_2ebf5bc73c343c4a3432e2830fc2305a");
   }elseif($_GET["sort"] == "price_asc"){
      $name = translate("tr_bb83caef0c698fbb9281ce5c1aa8b4fb");
   }elseif($_GET["sort"] == "price_desc"){
      $name = translate("tr_4bc6552ecd53b60e5ad26be683b25d56");
   }else{
      $name = translate("tr_2ebf5bc73c343c4a3432e2830fc2305a");
   }

  return '
     <div class="uni-dropdown" >
        <span class="uni-dropdown-name"> <span>'.$name.'</span> <i class="ti ti-chevron-down"></i></span>  
        <div class="uni-dropdown-content uni-dropdown-content-align-right" >
         <a href="'.requestBuildVars(["sort"=>"news"]).'" class="uni-dropdown-content-item" >'.translate("tr_2ebf5bc73c343c4a3432e2830fc2305a").'</a>
         <a href="'.requestBuildVars(["sort"=>"price_asc"]).'" class="uni-dropdown-content-item" >'.translate("tr_bb83caef0c698fbb9281ce5c1aa8b4fb").'</a>
         <a href="'.requestBuildVars(["sort"=>"price_desc"]).'" class="uni-dropdown-content-item" >'.translate("tr_4bc6552ecd53b60e5ad26be683b25d56").'</a>
        </div>               
     </div>
     ';

}