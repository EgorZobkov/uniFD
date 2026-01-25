public function getSystemHomeWidgets(){
    global $app;

    $getWidgets = $app->model->system_home_widgets->sort("sorting asc")->getAll();

    if($getWidgets){
        foreach ($getWidgets as $value) {

            $findWidget = $app->model->system_home_users_widgets->find("user_id=? and widget_id=?", [$app->user->data->id,$value["id"]]);

            if($findWidget){
                echo '
                    <li class="list-group-item d-flex justify-content-between align-items-center list-group-item-padding" draggable="false" >
                      <span class="d-flex justify-content-between align-items-center">
                        <span>'.translateField($value["name"]).'</span>
                      </span>
                      <span>
                        <label class="switch">
                            <input type="checkbox" class="switch-input" value="'.$value["id"].'" name="template_home_widgets[]" checked="" >
                            <span class="switch-toggle-slider">
                              <span class="switch-on"></span>
                              <span class="switch-off"></span>
                            </span>
                        </label>
                      </span>
                    </li>
                ';
            }else{
                echo '
                    <li class="list-group-item d-flex justify-content-between align-items-center list-group-item-padding" draggable="false" >
                      <span class="d-flex justify-content-between align-items-center">
                        <span>'.translateField($value["name"]).'</span>
                      </span>
                      <span>
                        <label class="switch">
                            <input type="checkbox" class="switch-input" value="'.$value["id"].'" name="template_home_widgets[]" >
                            <span class="switch-toggle-slider">
                              <span class="switch-on"></span>
                              <span class="switch-off"></span>
                            </span>
                        </label>
                      </span>
                    </li>
                ';                    
            }

        }
    }

}