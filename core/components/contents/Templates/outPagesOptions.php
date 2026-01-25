public function outPagesOptions(){
    global $app;

    $getPages = $app->model->template_pages->sort("id desc")->getAll("freeze=?", [0]);
    if($getPages){
      foreach ($getPages as $value) {

        echo '<option value="'.$value["id"].'" >'.translateField($value["name"]).'</option>';

      }
    }

}