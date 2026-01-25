public function importExport()
{   

    $getTasks = $this->model->import_export->getAll("status=? order by id desc limit ?", [2,1]);

    if($getTasks){

        foreach ($getTasks as $value) {

            $paramsData = isset($value["params"]) ? _json_decode($value["params"]) : [];
            $page = $paramsData['page'] ? (int)$paramsData['page'] : 0;
            $uploaded_count = 0;
            $errors_count = 0;
            
            if($value["action"] == "import"){

                $errors_count = $this->component->import_export->initImport($value);

                $uploaded_count = $this->component->import_export->uploadedCount($value["id"], $value["table"]);

                if($value["autoupdate"]){
                    $status = 4;
                }else{
                    $status = 1;
                }

                $this->model->import_export->update(['status'=>$status,'done_percent'=>100, 'uploaded_count'=>$uploaded_count, 'errors_count'=>$errors_count], $value["id"]);

            }elseif($value["action"] == "export"){

                $this->component->import_export->initExport($value, $page);

            }

        }

    }

}