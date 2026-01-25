public function manageUserBalance($params=[], $action=null){
    global $app;

    if($params && isset($action)){

        $user = $app->model->users->find("id=?", [$params["user_id"]]);

        if($params["amount"] > 1000000){
            $params["amount"] = 1000000;
        }

        $params["amount"] = round($params["amount"],2);

        if($action == "+"){

            $amount = round($user->balance + $params["amount"], 2);
            $app->model->users->update(["balance"=> $amount], $user->id);
            $app->model->transactions_balance->insert(["user_id"=> $user->id,"amount"=>$params["amount"], "action"=>$action, "action_code"=>"BALANCE_REPLENISHMENT", "time_create"=>$app->datetime->getDate()]);

            $app->event->replenishmentBalanceUser($params);

        }elseif($action == "-"){

            if(round($params["amount"], 2) > round($user->balance, 2)){
                $params["amount"] = round($user->balance,2);
            }

            $amount = round($user->balance - $params["amount"], 2);
            $app->model->users->update(["balance"=> $amount], $user->id);
            $app->model->transactions_balance->insert(["user_id"=> $user->id,"amount"=>$params["amount"], "action"=>$action, "action_code"=>"BALANCE_WRITE_DOWNS", "time_create"=>$app->datetime->getDate()]);

            $app->event->writedownBalanceUser($params);

        }
    }

}