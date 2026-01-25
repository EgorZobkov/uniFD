public function clearTempFiles(){

    $dirTemp = $this->config->storage->temp;

    $files = scandir($dirTemp);

    unset($files[0]);
    unset($files[1]);

    if(!$files) return;

    foreach ($files as $fileName) {
        
        if($fileName != ".htaccess" && $fileName != "ffmpeg" && $fileName != "mpdf"){
            $unix_time = filemtime($dirTemp . "/" . $fileName) + 10800;
            if($unix_time < time()){
                unlink($dirTemp . "/" . $fileName);
            }
        }

    }    

}