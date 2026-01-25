public function encryptAES($text=null){
    global $app;

    $encrypt = openssl_encrypt($text, "AES-256-CBC", $app->config->api->encryption_key, OPENSSL_RAW_DATA, $app->config->api->encryption_iv);

    return base64_encode($encrypt);

}