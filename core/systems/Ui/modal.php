public function modal($id=null, $size="medium", $data=[]){
    global $app;

    $tpl = $this->tpl;
    $this->tpl = null;

    if(isset($tpl)){

        return '
          <div class="modal fade" id="'.$id.'Modal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-fullscreen-md-down" style="'.$this->modalSize($size).'">
            <div class="modal-content">
              <button type="button" class="btn-close closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
              '.$app->view->setParamsComponent(["data"=>(object)$data])->includeComponent($tpl).'
              </div>
            </div>
          </div>
          </div>
        ';            

    }

}