public function getVerificationCode($name=null){
    global $app;

    $code = $this->codeVerification();

    return $code[$name] ? (object)$code[$name] : [];

}