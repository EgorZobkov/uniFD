public function installUpdates($files=[]){
    global $app;

    $update_errors = [];
    $update_result = [];
    $max_version = '';
    $compile_core = true;

    $zip = new \ZipArchive;

    if(!_file_put_contents($app->config->storage->files."/temp.txt", "temp")){
        return ["status"=>false, "result"=>translate("tr_63bc728d578f57002448a8439ca255a2") . $app->config->storage->files];
    }else{
        unlink($app->config->storage->files."/temp.txt");
    }

    if($files){

        foreach ($files as $key => $value) {

            $filename = "update_".$key."_".md5(uniqid());

            try {

                if(_mkdir($app->config->storage->files."/".$filename, 0777)){
            
                    if(_file_put_contents($app->config->storage->files."/".$filename."/".$filename.".zip", _file_get_contents($value))){

                        if($zip->open($app->config->storage->files."/".$filename."/".$filename.".zip") === TRUE) {

                            $zip->extractTo($app->config->storage->files."/".$filename."/");
                            $zip->close();

                            unlink($app->config->storage->files."/".$filename."/".$filename.".zip");

                            include($app->config->storage->files."/".$filename."/install.php");

                        }

                    }else{
                        $update_errors[] = translate("tr_31cadc6ecf349ebe52ab305caad87485").$app->config->storage->files."/".$filename.".zip";
                    }

                }else{
                    $update_errors[] = translate("tr_334050c5f836a554afed3509ed00e52e").$app->config->storage->files."/".$filename;
                }

            } catch (Exception $e) {

                logger("Update: {$e->getMessage()}");
                return ["status"=>false, "result"=>$e->getMessage()];

            }

        }

        if($update_errors){
            logger("Update error: ".implode(",", $update_errors));
            return ["status"=>false, "result"=>implode(",", $update_errors)];                
        }

        if($compile_core){

            $result = $app->builder->compileCore();

            if($result["status"]){
                foreach ($files as $key => $value) {
                    $app->model->system_updates->insert(["time_create"=>$app->datetime->getDate(), "version"=>$key]);
                    $max_version = $key;
                }
                $app->model->settings->update($max_version,"system_version");
                $app->model->settings->update($app->datetime->getDate(),"system_last_update");
            }else{
                return ["status"=>false, "result"=>$result["errors"]];
            }

        }else{

            foreach ($files as $key => $value) {
                $app->model->system_updates->insert(["time_create"=>$app->datetime->getDate(), "version"=>$key]);
                $max_version = $key;
            }
            $app->model->settings->update($max_version,"system_version");
            $app->model->settings->update($app->datetime->getDate(),"system_last_update");                

        }

    }

    logger("Update result: ".implode(",", $update_result));
    return ["status"=>true, "result"=>implode(",", $update_result)];

}