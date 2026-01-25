public function decryptAES($text=null){
    global $app;

    $result = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', openssl_decrypt(base64_decode($text), 'AES-256-CTR', $app->config->api->encryption_key, OPENSSL_RAW_DATA, $app->config->api->encryption_iv));

    return base64_decode($result);

}