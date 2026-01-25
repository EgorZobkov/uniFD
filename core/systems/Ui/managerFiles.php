public function managerFiles($params=[]){
    global $app;

    if($params["input_name"]){
        $input_name = $params["input_name"];
    }else{
        $input_name = "manager_image";
    }
    
    if($app->storage->name($params["filename"])->exist()){

        return '
          <div class="filemanager-frontend" >

            <span class="btn btn-sm btn-primary filemanager-frontend-change" data-path="'.$params["path"].'" >'.translate("tr_5eba283b81890978e67f4aa96dde1724").'</span>

            <div class="filemanager-frontend-container" style="display: block;" >
              <span class="filemanager-frontend-item-delete" ><i class="ti ti-trash-x"></i></span>
              <img src="'.$app->storage->name($params["filename"])->get().'" class="image-autofocus" >
            </div>

            <input type="hidden" name="'.$input_name.'" value="'.$params["filename"].'" />

          </div>
          <label class="form-label-error" data-name="'.$input_name.'" ></label>
        ';               

    }else{

        return '
          <div class="filemanager-frontend" >
             <span class="btn btn-sm btn-primary filemanager-frontend-change" >'.translate("tr_5eba283b81890978e67f4aa96dde1724").'</span>
             <div class="filemanager-frontend-container" ></div>
             <input type="hidden" name="'.$input_name.'" value="" />
          </div>
          <label class="form-label-error" data-name="'.$input_name.'" ></label>
        ';

    }

}