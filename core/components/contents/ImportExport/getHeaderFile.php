public function getHeaderFile($data=null){
    global $app;

    $values = [];
    $header = [];
    
    if(file_exists($app->config->storage->files_import_export.'/'.$data->filename)){

        $reader = ReaderEntityFactory::createReaderFromFile($app->config->storage->files_import_export.'/'.$data->filename);

        $extension = getInfoFile($app->config->storage->files_import_export.'/'.$data->filename)->extension;

        if($extension == "csv"){
            $reader->setFieldDelimiter(';');
        }

        $reader->open($app->config->storage->files_import_export.'/'.$data->filename);

        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $rowIndex => $row) {
                if($rowIndex == 1){
                    $header = $row->toArray();
                }
                if($rowIndex == 2){
                    $values = $row->toArray();
                    break;
                }                    
            }
        }

        $reader->close();

        if($values){
            foreach ($values as $key => $value) {
                if(trim($value)){
                    $values[$key] = trimStr(trim($value), 64, true);
                }else{
                    $values[$key] = translate("tr_e5b328b4e1c5fd66fc9df6594dd8964c");
                }
            }
        }

    }

    return (object)["header"=>$header, "values"=>$values];

}