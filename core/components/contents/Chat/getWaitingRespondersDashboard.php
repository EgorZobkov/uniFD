public function getWaitingRespondersDashboard(){
    global $app;

    return $app->model->chat_responders->count("status=?", [0]);

}