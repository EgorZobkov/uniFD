public function outButtonExtraFilters($category_id=0){
    global $app;

     $countFilters = $app->component->ads_filters->countFiltersIsNotDefault($category_id);    

     if($countFilters){
         return '<a class="btn-custom button-color-scheme4 width100 mb5 openModal" data-modal-id="extraFiltersModal" >'.translate("tr_beb17c7b102f4290331f8480b73bdfc1").' '.$countFilters.' '.endingWord($countFilters, translate("tr_f8e3cefbce6a55c82347db390278ddcc"), translate("tr_5da50b4c1f50b4dccbaf2c7d0ab3d86e"), translate("tr_05cd7932399b0242502822357140aaf8")).'</a>';
     }        

}