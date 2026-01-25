public function runUpdateImportExport()
{   

    $getTasks = $this->model->import_export->getAll("status=? and now() > next_update order by id desc limit ?", [4,1]);

    if($getTasks){

        foreach ($getTasks as $value) {

            $this->model->import_export->update(['status'=>5], $value["id"]);

            $paramsData = isset($value["params"]) ? _json_decode($value["params"]) : [];
            $uploaded_count = 0;
            $errors_count = 0;
            
            if($value["action"] == "import"){

                unlink($this->config->storage->files_import_export . '/' . $value["filename"]);

                $data = _file_get_contents($value['link_file']);

                _file_put_contents($this->config->storage->files_import_export . '/' . $value["filename"], $data);

                $errors_count = $this->component->import_export->initImport($value, true);

                $uploaded_count = $this->component->import_export->uploadedCount($value["id"], $value["table"]);

            }

            $this->model->import_export->update(['status'=>4, 'uploaded_count'=>$uploaded_count, 'errors_count'=>$value["errors_count"]+$errors_count, 'next_update'=>$this->datetime->addSeconds($value["update_interval"])->getDate()], $value["id"]);

        }

    }

}