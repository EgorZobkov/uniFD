public function buildUniSelectFilters($items=[], $params=[]){
  global $app;

  $itemsList = '';
  $searchBox = '';

  if($params["view"] == "multi"){

     foreach ($items as $key => $value) {

          $checked = ''; $active = '';
          if($params["filter"]){
             if(compareValues($params["filter"][$value["filter_id"]],$value["id"])){
                $checked = 'checked=""';
                $active = 'uni-select-item-active';
             }
          }

          $itemsList .= '
                <label class="uni-select-content-item '.$active.'" >
                      <input type="checkbox" name="'.$params["input_name"].'" value="'.$value["id"].'" '.$checked.' />
                      <span>
                        '.translateFieldReplace($value, "name").'
                      </span>
                </label>
          ';

     }

     if(count($items) > 10){
       $searchBox = '
            <div class="uni-select-content-search" >
                <input type="text" class="form-control" placeholder="'.translate("tr_bfc95980634bf529e8a406db2c842b31").'" />
            </div>
       ';
     }

      return '
            <div class="uni-select" data-status="0" >
                <span class="uni-select-name" data-default-name="'.translate("tr_591cca300870eb571563ef4b8c8756ff").'" >'.translate("tr_591cca300870eb571563ef4b8c8756ff").'</span>
                <div class="uni-select-content" >
                  '.$searchBox.'
                  <div class="uni-select-content-container" >
                    '.$itemsList.'
                  </div>
                </div>
            </div>
      ';

  }elseif($params["view"]== "radio"){

     foreach ($items as $key => $value) {

          $checked = ''; $active = '';
          if($params["filter"]){
             if(compareValues($params["filter"][$value["filter_id"]],$value["id"])){
                $checked = 'checked=""';
                $active = 'uni-select-item-active';
             }
          }

          $itemsList .= '
                <label class="uni-select-content-item '.$active.'" >
                      <input type="radio" name="'.$params["input_name"].'" value="'.$value["id"].'" '.$checked.' />
                      <span>
                        '.translateFieldReplace($value, "name").'
                      </span>
                </label>
          ';

     }

     if(count($items) > 10){
       $searchBox = '
            <div class="uni-select-content-search" >
                <input type="text" class="form-control" placeholder="'.translate("tr_bfc95980634bf529e8a406db2c842b31").'" />
            </div>
       ';
     }


    return '
          <div class="uni-select" data-status="0" >
              <span class="uni-select-name" data-default-name="'.translate("tr_591cca300870eb571563ef4b8c8756ff").'" >'.translate("tr_591cca300870eb571563ef4b8c8756ff").'</span>
              <div class="uni-select-content" >
                '.$searchBox.'
                <div class="uni-select-content-container" >
                  <label class="uni-select-content-item" >
                        <input type="radio" value="null" />
                        <span>'.translate("tr_591cca300870eb571563ef4b8c8756ff").'</span>
                  </label>
                  '.$itemsList.'
                </div>
              </div>
          </div>
    ';

  }elseif($params["view"] == "input"){

    $inputs = '';

    if($items["input_name_from"] && $items["input_name_to"]){
        $inputs = '
          <div class="col-6" ><input type="number" class="form-control" data-type="from" name="'.$items["input_name_from"].'" value="'.$items["input_value_from"].'" placeholder="'.translate("tr_996b125bc9bba860718d999df2ecc61d").'" /></div>
          <div class="col-6" ><input type="number" class="form-control" data-type="to" name="'.$items["input_name_to"].'" value="'.$items["input_value_to"].'" placeholder="'.translate("tr_c2aa9c0cecea49717bb2439da36a7387").'" /></div>
        ';
    }elseif($items["input_name"]){
        $inputs = '
          <div class="col-12" ><input type="text" class="form-control" data-type="text" name="'.$items["input_name"].'" value="'.$items["input_value"].'" placeholder="'.translate("tr_22bbd9c9cc3f2db273ee25775659eed9").'" /></div>
        ';            
    }
    

    return '
          <div class="uni-select" data-status="0" >
              <span class="uni-select-name" data-default-name="'.translate("tr_7cddffa0460d1dab9bc69880f9201c2a").'" >'.translate("tr_7cddffa0460d1dab9bc69880f9201c2a").'</span>
              <div class="uni-select-content" >
                  <div class="uni-select-content-input" >
                      <div class="row" >
                          '.$inputs.'
                      </div>
                  </div>
              </div>
          </div>
    ';

  }


}