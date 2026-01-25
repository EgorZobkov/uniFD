public function outAcceptUploadFormatFiles($group_formats=null){
    global $app;

    $result = [];

    if($group_formats == "multiple"){

        foreach ($app->settings->allowed_extensions_images as $key => $value) {
            $result[] = "image/".$value;
        }

        foreach ($app->settings->allowed_extensions_videos as $key => $value) {
            $result[] = "video/".$value;
        }

    }elseif($group_formats == "image"){

        foreach ($app->settings->allowed_extensions_images as $key => $value) {
            $result[] = "image/".$value;
        }

    }elseif($group_formats == "video"){

        foreach ($app->settings->allowed_extensions_videos as $key => $value) {
            $result[] = "video/".$value;
        }

    }

    return 'accept="'.implode(",", $result).'"';

}