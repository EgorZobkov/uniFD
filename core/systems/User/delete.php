public function delete($user_id=null){
    global $app;
    if(isset($user_id)){
        $user = $app->model->users->find('id=?', [$user_id]);
        if($user){

            $app->model->auth->delete('user_id=?', [$user_id]);
            $app->model->auth_access_key->delete('user_id=?', [$user_id]);
            $app->model->auth_sessions->delete('user_id=?', [$user_id]);
            $app->model->users_payment_data->delete('user_id=?', [$user_id]);
            $app->model->users_referrals->delete('whom_user_id=?', [$user_id]);
            $app->model->users_referral_transitions->delete('user_id=?', [$user_id]);
            $app->model->users_tariffs_orders->delete('user_id=?', [$user_id]);
            $app->model->users_verified_contacts->delete('user_id=?', [$user_id]);
            $app->model->users_delivery_data->delete('user_id=?', [$user_id]);
            $app->model->users_waiting_notifications->delete('user_id=?', [$user_id]);
            $app->model->users_tariffs_onetime->delete('user_id=?', [$user_id]);
            $app->model->users_subscriptions->delete('user_id=?', [$user_id]);
            $app->model->users_favorites->delete('user_id=?', [$user_id]);
            $app->model->users_blacklist->delete('from_user_id=?', [$user_id]);
            $app->model->users_blacklist->delete('whom_user_id=?', [$user_id]);
            $app->model->transactions_balance->delete('user_id=?', [$user_id]);
            $app->component->ads->deleteAllByUserId($user_id);
            $app->component->stories->deleteAllByUserId($user_id);
            $app->storage->name($user->avatar)->delete();
            $app->model->users_delete->insert(["user_id"=>$user_id, "user_alias"=>$user->alias, "name"=>$user->name, "time_delete"=>$app->datetime->getDate()]);
            $app->model->users->cacheKey(["id"=>$user_id])->delete('id=?', [$user_id]);

            $app->session->delete("administrator-enter-profile");
            
            $app->event->deleteUser($user);

            return ['status'=>true];

        }
    }
}