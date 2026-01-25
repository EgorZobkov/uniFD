public function outFrontendHomeWidgetsItem(){
    global $app;

    $result = $app->model->frontend_home_widgets->sort("sorting asc")->getAll();
    if($result){
        foreach ($result as $key => $value) {
            if($value["status"]){
                echo '
                <div class="settings-home-widgets-sortable-handle" >
                <label class="switch">
                  <input type="checkbox" name="frontend_home_visible_widgets_active['.$value["code"].']" value="1" class="switch-input" checked >
                  <span class="switch-toggle-slider">
                    <span class="switch-on"></span>
                    <span class="switch-off"></span>
                  </span>
                  <span class="switch-label">'.translateField($value["name"]).'</span>
                </label>
                <input type="hidden" name="frontend_home_visible_widgets['.$value["code"].']" />
                </div>';
            }else{
                echo '
                <div class="settings-home-widgets-sortable-handle" >
                <label class="switch">
                  <input type="checkbox" name="frontend_home_visible_widgets_active['.$value["code"].']" value="1" class="switch-input" >
                  <span class="switch-toggle-slider">
                    <span class="switch-on"></span>
                    <span class="switch-off"></span>
                  </span>
                  <span class="switch-label">'.translateField($value["name"]).'</span>
                </label>
                <input type="hidden" name="frontend_home_visible_widgets['.$value["code"].']" />
                </div>';
            }
        }
    }

}