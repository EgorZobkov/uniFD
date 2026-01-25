public function metaCsrf(){
    global $app;

    $token = generationCsrfToken();

    return '<meta name="csrf-token" content="'.$token.'">';

}