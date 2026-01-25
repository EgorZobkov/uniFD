public function changeStatusVerifyCodeByInternalId($status, $service_internal_id=0){
    global $app;
    $app->model->users_waiting_verify_code->update(["status"=>intval($status)], ["service_internal_id=?", [$service_internal_id]]);
}