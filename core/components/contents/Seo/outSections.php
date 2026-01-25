public function outSections($id=0){
    global $app;

    $getSections = $app->model->template_pages->sort("id desc")->getAll("seo=?", [1]);
    if($getSections){
      foreach ($getSections as $key => $value) {

         $active = '';
         if($id == $value["id"]){
             $active = 'active-light';
         }

         echo '
          <li class="nav-item">
            <a href="'.$app->router->getRoute("dashboard-seo-card", [$value["id"]]).'" class="nav-link '.$active.'">
              '.translateField($value["name"]).'
            </a>
          </li>
         '; 

      }
    }        

}