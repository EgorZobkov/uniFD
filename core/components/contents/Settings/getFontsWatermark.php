public function getFontsWatermark(){
    global $app;

    $fonts = glob($app->config->storage->fonts.'/*.ttf');

    if($fonts){
        foreach ($fonts as $file){
            $basename = getInfoFile($file)->basename;
            if($app->settings->watermark_title_font == $basename){
                echo '<option value="'.$basename.'" selected="" >'.$basename.'</option>';
            }else{
                echo '<option value="'.$basename.'" >'.$basename.'</option>';
            }
        }
    }
}