public function outPaymentHistoryWallet(){
    global $app;

    $result  = '';

    $getHistory = $app->model->transactions->sort("id desc")->getAll("user_id=? and status_payment=?", [$app->user->data->id,1]);
    if($getHistory){

        $result .= '
        <div class="table-responsive text-nowrap">
          <table class="table">
            <thead>
              <tr>
                <th><span>'.translate("tr_c4666dd6229b9f6cdc544a0b5ab4cb0a").'</span></th>
                <th><span>'.translate("tr_cf59ebf9edf7ebe3ece76645abb6de12").'</span></th>
                <th><span>'.translate("tr_8cdd8bb771bcf038dfb2740fd50b332c").'</span></th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
        ';

        foreach ($getHistory as $key => $value) {

            $result .= '
                <tr>
                  <td>'.$app->component->transaction->getTitleByTemplateAction(_json_decode(decrypt($value["data"]))).'</td>
                  <td>'.$app->system->amount($value["amount"], $value["currency_code"]).'</td>
                  <td>'.$app->datetime->outDateTime($value["time_create"]).'</td>
                </tr>
            ';

        }

        $result .= '   
            </tbody>
          </table>
        </div>
        ';

    }

    return $result;

}