public function buildUniSelect($items=[], $params=[]){
  global $app;

  $itemsList = '';
  $searchBox = '';

  if($params["view"] == "multi"){

     foreach ($items as $key => $value) { 

          $checked = '';
          $active = '';

          if($params["selected"]){
             if(compareValues($params["selected"],$value["input_value"])){
                $checked = 'checked=""';
                $active = 'uni-select-item-active';
             }
          }

          $itemsList .= '
                <label class="uni-select-content-item '.$active.'" >
                      <input type="checkbox" name="'.$value["input_name"].'" value="'.$value["input_value"].'" '.$checked.' />
                      <span>
                        '.$value["item_name"].'
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

     if($params["no_selected"]){
        $noSelected = '
              <label class="uni-select-content-item" >
                    <input type="radio" name="'.$params["no_selected"]["input_name"].'" value="'.$params["no_selected"]["input_value"].'" />
                    <span>'.translate("tr_591cca300870eb571563ef4b8c8756ff").'</span>
              </label>
        ';
     }else{
        $noSelected = '
              <label class="uni-select-content-item" >
                    <input type="radio" value="null" />
                    <span>'.translate("tr_591cca300870eb571563ef4b8c8756ff").'</span>
              </label>
        ';
     }

     foreach ($items as $key => $value) {

          $checked = ''; 
          $active = '';

          if($params["selected"]){
             if(compareValues($params["selected"],$value["input_value"])){
                $checked = 'checked=""';
                $active = 'uni-select-item-active';
             }
          }

          $itemsList .= '
                <label class="uni-select-content-item '.$active.'" >
                      <input type="radio" name="'.$value["input_name"].'" value="'.$value["input_value"].'" '.$checked.' />
                      <span>
                        '.$value["item_name"].'
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
                  '.$noSelected.'
                  '.$itemsList.'
                </div>
              </div>
          </div>
    ';

  }elseif($params["view"] == "input"){

    return '
          <div class="uni-select" data-status="0" >
              <span class="uni-select-name" data-default-name="'.translate("tr_7cddffa0460d1dab9bc69880f9201c2a").'" >'.translate("tr_7cddffa0460d1dab9bc69880f9201c2a").'</span>
              <div class="uni-select-content" >
                  <div class="uni-select-content-input" >
                      <div class="row" >
                          <div class="col-6" ><input type="number" class="form-control" data-type="from" name="'.$value["name_from"].'" value="'.$value["value_from"].'" placeholder="'.translate("tr_996b125bc9bba860718d999df2ecc61d").'" /></div>
                          <div class="col-6" ><input type="number" class="form-control" data-type="to" name="'.$value["name_to"].'" value="'.$value["value_to"].'" placeholder="'.translate("tr_c2aa9c0cecea49717bb2439da36a7387").'" /></div>
                      </div>
                  </div>
              </div>
          </div>
    ';

  }


}