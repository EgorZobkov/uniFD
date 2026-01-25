public function getPages(){
    global $app;

    $getSections = $app->model->template_pages->sort("id desc")->getAll();
    if($getSections){
      foreach ($getSections as $value) {

         $edit_button = '';

         if($value["edit_status"]){
            $edit_button = '
                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light actionTemplatesLoadEditPage" data-id="'.$value["id"].'" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>
            ';
         }

         if($value["freeze"]){
             echo '
              <a href="'.$app->router->getRoute("dashboard-template-view-page", [$value["id"]]).'" class="list-group-item list-group-item-action d-flex justify-content-between">
                <div class="li-wrapper d-flex justify-content-start align-items-center">
                  <div class="list-content">
                    '.translateField($value["name"]).'
                  </div>
                </div>
                <div>
                    <span class="badge badge-small bg-label-warning">'.translate("tr_2b7d9946852ba858f7a8498670750958").'</span>
                </div>
              </a>
             ';
         }else{
             echo '
              <a href="'.$app->router->getRoute("dashboard-template-view-page", [$value["id"]]).'" class="list-group-item list-group-item-action d-flex justify-content-between">
                <div class="li-wrapper d-flex justify-content-start align-items-center">
                  <div class="list-content">
                    '.translateField($value["name"]).'
                  </div>
                </div>
                <div>
                  '.$edit_button.'
                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light actionTemplatesDeletePage" data-id="'.$value["id"].'" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>
                </div>
              </a>
             ';                
         }

      }
    }

}