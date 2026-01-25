public function addLog($import_id=0, $message=null){
    global $app;

    if(isset($message)){
        $name = "import_".md5($import_id).'.txt';
        _file_put_contents($app->config->storage->logs.'/'.$name, $app->datetime->getDate().": ".$message."\n", FILE_APPEND);         
    }

}