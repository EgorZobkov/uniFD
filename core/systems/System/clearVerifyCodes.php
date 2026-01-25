public function clearVerifyCodes($contact=[]){
    global $app;
    if($contact["email"] || $contact["phone"]){
        $app->model->users_waiting_verify_code->delete("contact=?", [$contact["email"] ?: $contact["phone"]]);
    }
}