 public function setMainIso($iso=null){
    global $app;

    if($iso){

        $this->deleteColumnTables($iso);

        $langs = $app->model->languages->getAll("iso!=?", [$iso]);

        if($langs){
            foreach ($langs as $key => $value) {
                $this->insertColumnTables($value["iso"]);
            }
        }

    }

}