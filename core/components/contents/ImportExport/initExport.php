public function initExport($value=null, $page=1){
    global $app;

    $action = '';
    $output = 1000;
    $filename = $value["filename"];

    if(isset($value["filename"]) && file_exists($app->config->storage->files_import_export.'/'.$value["filename"])){

        $action = 'append';
        
        $reader = ReaderEntityFactory::createReaderFromFile($app->config->storage->files_import_export.'/'.$value["filename"]);
        $reader->setShouldFormatDates(true);
        $reader->setTempFolder($app->config->storage->files_import_export);
        $reader->open($app->config->storage->files_import_export.'/'.$value["filename"]);

        $newfilename = 'temp_'.$value["filename"];

        $writer = WriterEntityFactory::createWriterFromFile($app->config->storage->files_import_export.'/'.$newfilename);
        $writer->openToFile($app->config->storage->files_import_export.'/'.$newfilename);

        foreach ($reader->getSheetIterator() as $sheetIndex => $sheet) {
            if ($sheetIndex !== 1) {
                $writer->addNewSheetAndMakeItCurrent();
            }
            foreach ($sheet->getRowIterator() as $row) {
                $writer->addRow($row);
            }
        }

    }else{

        $action = 'create';

        if($value["export_format"] == "xlsx"){
            $writer = WriterEntityFactory::createXLSXWriter();
        }else{
            $writer = WriterEntityFactory::createCSVWriter();
        }

        $writer->openToFile($app->config->storage->files_import_export.'/'.$filename);

    }

    if($value["table"] == "users"){

        $getData = $app->model->users->pagination(true)->page($page)->output($output)->sort('id desc')->getAll();

        $uploaded_count = $value["uploaded_count"] + count($getData);

        if($getData){

            unset($getData[0]["admin"]);
            unset($getData[0]["password"]);
            unset($getData[0]["role_id"]);
            unset($getData[0]["import_id"]);
            unset($getData[0]["reason_blocking_code"]);
            unset($getData[0]["time_expiration_blocking"]);
            unset($getData[0]["privileges"]);
            unset($getData[0]["tariff_id"]);
            unset($getData[0]["online_payment_status"]);
            unset($getData[0]["notifications_method"]);
            unset($getData[0]["telegram_chat_id"]);
            unset($getData[0]["uniq_hash"]);
            unset($getData[0]["notifications"]);
            unset($getData[0]["delivery_status"]);
            unset($getData[0]["import_item_id"]);

            foreach ($getData[0] as $key => $field) {
               $headerCell[] = WriterEntityFactory::createCell($key);
               $header[] = $key;
            }   

            foreach ($getData as $field) {

                $rows = [];

                $field["avatar"] = $app->storage->host(true)->name($field["avatar"])->path('user-avatar')->get();

                if($field["contacts"]){
                    $field["contacts"] = decrypt($field["contacts"]);
                }

                foreach ($header as $name_field) {
                    $rows[] = WriterEntityFactory::createCell($field[$name_field]);
                }

                $multipleRows[] = WriterEntityFactory::createRow($rows);

            }

            if($action == "create"){
                $style = (new StyleBuilder())->setFontBold()->build();
                $writer->addRow(
                    WriterEntityFactory::createRow($headerCell, $style)
                );
            }

            $writer->addRows($multipleRows); 

        }

    }elseif($value["table"] == "blog_posts"){

        $getData = $app->model->blog_posts->pagination(true)->page($page)->output($output)->sort('id desc')->getAll();

        $uploaded_count = $value["uploaded_count"] + count($getData);

        if($getData){

            foreach ($getData[0] as $key => $field) {
               $headerCell[] = WriterEntityFactory::createCell($key);
               $header[] = $key;
            }   

            foreach ($getData as $field) {

                $rows = [];

                $field["image"] = $app->storage->host(true)->name($field["image"])->path('blog')->get();

                foreach ($header as $name_field) {
                    $rows[] = WriterEntityFactory::createCell($field[$name_field]);
                }

                $multipleRows[] = WriterEntityFactory::createRow($rows);

            }

            if($action == "create"){
                $style = (new StyleBuilder())->setFontBold()->build();
                $writer->addRow(
                    WriterEntityFactory::createRow($headerCell, $style)
                );
            }

            $writer->addRows($multipleRows); 

        }

    }elseif($value["table"] == "ads"){

        $fields = ["title", "alias", "user_id", "text", "status", "article_number", "address", "address_latitude", "address_longitude", "currency_code", "price", "old_price", "media", "category_id", "city_id", "region_id", "country_id", "delivery_status ", "total_rating", "total_reviews"];

        $getData = $app->model->ads_data->pagination(true)->page($page)->output($output)->sort('id desc')->getAll("status=?", [1]);

        $uploaded_count = $value["uploaded_count"] + count($getData);

        if($getData){

            foreach ($fields as $field) {
               $headerCell[] = WriterEntityFactory::createCell($field);
               $header[] = $field;
            }   

            foreach ($getData as $field) {

                $rows = [];

                $field["status"] = $app->component->ads->status($field["status"])->name;

                if($field["contacts"]){
                    $field["contacts"] = decrypt($field["contacts"]);
                }

                foreach ($header as $name_field) {
                    $rows[] = WriterEntityFactory::createCell($field[$name_field]);
                }

                $multipleRows[] = WriterEntityFactory::createRow($rows);

            }

            if($action == "create"){
                $style = (new StyleBuilder())->setFontBold()->build();
                $writer->addRow(
                    WriterEntityFactory::createRow($headerCell, $style)
                );
            }

            $writer->addRows($multipleRows); 

        }

    }

    $writer->close();

    if($action == "append"){
        rename($app->config->storage->files_import_export.'/'.$newfilename,$app->config->storage->files_import_export.'/'.$filename);
        $reader->close();
    }

    if($app->pagination->totalPages > 1){
        if($page > $app->pagination->totalPages){
            $app->model->import_export->update(['status'=>1,'done_percent'=>100,'filename'=>$filename, 'uploaded_count'=>$uploaded_count, 'errors_count'=>$value["errors_count"]+$errors_count], $value["id"]);
        }else{
            $page = $page + 1;
            $app->model->import_export->update(['params'=>_json_encode(['page'=>$page]),'done_percent'=>percentToCompletion($page*$output,$app->pagination->totalItems),'filename'=>$filename, 'uploaded_count'=>$uploaded_count, 'errors_count'=>$value["errors_count"]+$errors_count], $value["id"]);
        }
    }else{
        $app->model->import_export->update(['status'=>1,'done_percent'=>100,'filename'=>$filename, 'uploaded_count'=>$uploaded_count, 'errors_count'=>$errors_count], $value["id"]);
    }

}