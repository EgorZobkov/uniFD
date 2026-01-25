public function initImport($value=null, $update=false){
    global $app;

    $errors_count = 0;

    if(isset($value["filename"]) && file_exists($app->config->storage->files_import_export.'/'.$value["filename"])){

        $reader = ReaderEntityFactory::createReaderFromFile($app->config->storage->files_import_export.'/'.$value["filename"]);

        $extension = getInfoFile($app->config->storage->files_import_export.'/'.$value["filename"])->extension;

        if($extension == "csv"){
            $reader->setFieldDelimiter(';');
        }

        $reader->open($app->config->storage->files_import_export.'/'.$value["filename"]);

        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $rowIndex => $row) {
                if($rowIndex != 1){
                    $errors_count += $this->dataComparisonAndImport($value,$row->toArray(),$update);
                }                    
            }
        }

    }else{
        $this->addLog($value["id"], translate("tr_2b5a9e35fbbbafa4059f752520300978"));
    }

    return $errors_count;

}