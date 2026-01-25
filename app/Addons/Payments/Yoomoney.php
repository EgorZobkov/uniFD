<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Addons\Payments;

class Yoomoney{

    public $alias = "yoomoney";
    public $data;

    public function __construct(){
        global $app;
        $this->data = $this->getData();
    }

    public function getData(){
        global $app;
        $data = $app->model->system_payment_services->find("alias=?", [$this->alias]);
        if($data){
            $data->params = (object)_json_decode(decrypt($data->params));
            return $data;
        }
    }

    public function logo(){
        global $app;

        if(!$app->storage->name($this->data->image)->exist()){
        return 'data:image/png;base64,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';
        }else{
            return $app->storage->name($this->data->image)->get();
        }

    }

    public function createPayment($params=[]){
        global $app;

        try {

            $link = 'https://yoomoney.ru/quickpay/confirm.xml?sum='.numberFormat($params["amount"],2,".","").'&receiver='.$this->data->params->wallet_number.'&label='.$params["order_id"].'&quickpay-form=donate&targets='.trim($params["title"]).'&successURL=&paymentType=PC';

            return ["link"=>$link];

        } catch (\Exception $e) {
            logger("Payment ".$this->alias." createPayment error: {$e->getMessage()}");
        }

    }

    public function createPayout($data=[]){
        global $app;

        try {

           $options =  [
                 'client_id'=>$this->data->params->client_id,
                 'pattern_id'=>'p2p',
                 'to'=>$data["payment_data"]["score"],
                 'amount_due'=>round($data["amount"],2),
                 'message'=>$data["title"],
                 'comment'=>$data["title"],
                 'label'=>$data["order_id"],
           ];

           $answer = $this->sendRequest('/api/request-payment', $options, $this->data->params->access_token);
           $result = _json_decode($answer->body);

           if($result['status'] == "success"){

                  $request_id = $result['request_id'];

                  $options =  [
                       'request_id'=>$request_id,
                       'money_source'=>'wallet',
                  ];

                  $answer = $this->sendRequest('/api/process-payment', $options, $this->data->params->access_token);

                  $result = _json_decode($answer->body);

                  if($result['status'] == "success"){

                      $app->model->transactions_deals_payments->update(["comment"=>NULL, "status_processing"=>"done"], $data["id"]);

                  }else{

                      if($result['error_description']){
                          $app->model->transactions_deals_payments->update(["comment"=>$result['error_description'], "status_processing"=>"payment_error", "user_show_error"=>0], $data["id"]);
                      }else{
                          $app->model->transactions_deals_payments->update(["comment"=>translate("tr_ab2630021015478c54c9c5fa3cbb5b18"), "status_processing"=>"payment_error", "user_show_error"=>0], $data["id"]);
                      }

                  }

           }else{
                if(!$result['error_description']){
                    $result['error_description'] = $answer->status_code == 401 ? "A non-existent, expired, or revoked token is specified." : $answer->status_code;
                }
                $app->model->transactions_deals_payments->update(["comment"=>$result['error_description'], "status_processing"=>"payment_error", "user_show_error"=>0], $data["id"]);
           }

        } catch (Exception $e) {
            logger("Payment ".$this->alias." createPayout error: {$e->getMessage()}");
        }

    }

    public function createRefund($data=[]){
        global $app;

        try {

            $app->model->transactions_operations->update(["status_processing"=>"error","refund_data"=>null], ["order_id=?", [$data->order_id]]);

        } catch (Exception $e) {
            logger("Payment ".$this->alias." createRefund error: {$e->getMessage()}");
        }

    }

    public function sendRequest($url="", $options=[], $access_token=NULL) {

        $curl = curl_init('https://yoomoney.ru'.$url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer " . $access_token
        ));
        curl_setopt ($curl, CURLOPT_USERAGENT, 'Yandex.Money.SDK/PHP');
        curl_setopt ($curl, CURLOPT_POST, 1);
        $query = http_build_query($options);
        curl_setopt ($curl, CURLOPT_POSTFIELDS, $query);
        curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt ($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt ($curl, CURLOPT_SSL_VERIFYHOST, 2);
        $body = curl_exec ($curl);
        $result = new \StdClass();
        $result->status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $result->body = $body;
        curl_close ($curl);
        return $result;
    }

    public function callback($action=null){
        global $app;

        try {

            if($action == "oauth"){

                if($_GET['code']){

                    $options = [
                        'client_id'=>$this->data->params->client_id,
                        'code'=>$_GET['code'],
                        'grant_type'=>'authorization_code',
                        'redirect_uri'=>$app->system->buildWebhook("payment", $this->alias, "oauth"),
                        'scope'=>'account-info operation-history',
                        'client_secret'=>$this->data->params->client_secret
                    ];

                    $result = $this->sendRequest('/oauth/token', $options, $_GET['code']);

                    $token = _json_decode($result->body);

                    if($token["access_token"]){

                        $this->data->params->access_token = $token["access_token"];

                        $app->model->system_payment_services->update(["params"=>encrypt(_json_encode((array)$this->data->params))], $this->data->id);

                        $app->router->goToUrl();

                    }

                }

            }else{

                $sha1_hash = sha1($_POST['notification_type'].'&'.$_POST['operation_id'].'&'.$_POST['amount'].'&'.$_POST['currency'].'&'.$_POST['datetime'].'&'.$_POST['sender'].'&'.$_POST['codepro'].'&'.$this->data->params->private_key.'&'.$_POST['label']);

                if($_POST['label'] && $_POST['sha1_hash'] == $sha1_hash){

                    $order = $app->component->transaction->getOperation($_POST['label']);

                    if($order){
                        $app->component->transaction->callback($order->data, _json_encode($_POST));
                        header("HTTP/1.1 200 OK");
                    }else{
                        logger("Error payment not found order:".$_POST['label']);
                        header("HTTP/1.1 404 ERROR");
                    }

                }
                
            }

        } catch (Exception $e) {
            logger("Payment ".$this->alias." callback error: {$e->getMessage()}");
            header("HTTP/1.1 404 ERROR");
        }

    }

    public function buildLinkToken(){
        global $app;

        $link = [
            'client_id'=>$this->data->params->client_id,
            'response_type'=>'code',
            'redirect_uri'=>$app->system->buildWebhook("payment", $this->alias, "oauth"),
            'scope'=>'account-info operation-history payment-p2p',
        ];

        return 'https://yoomoney.ru/oauth/authorize?' . urldecode(http_build_query($link));

    }

    public function fieldsForm($params=[]){
        global $app;

        $secure_deal_available = '';
        $secure_deal_status = '';

        if($this->data->secure_deal_available){

            $secure_deal_available = '

                <h3 class="mt-3" >'.translate("tr_1eb027fdbd155cb5c39d813737a8318f").'</h3>

                <div class="col-12">

                  <label class="form-label mb-2" >'.translate("tr_5ef086ccb3f6de5eb731fd04b72b5bb6").'</label>

                  <div class="input-group">
                    <input type="text" class="form-control" name="params[client_id]" value="'.$this->data->params->client_id.'" />
                  </div>

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >'.translate("tr_3ce30f716cae2661df51c6d9ac6afc4b").'</label>

                  <div class="input-group">
                    <input type="text" class="form-control" name="params[client_secret]" value="'.$this->data->params->client_secret.'" />
                  </div>

                </div>

                <div class="col-12 mt-3">

                  <div class="alert alert-warning d-flex align-items-center mt-2 mb-2" role="alert">
                    '.translate("tr_9d3f62d3d4673cf3f868553fcf33d937").'
                  </div>

                  <a class="btn btn-danger" target="_blank" href="'.$this->buildLinkToken().'" >'.($this->data->params->access_token ? translate("tr_c4534c95d25fc290ed3b94f6848deea7") : translate("tr_ca9e30371381a92890e331877c204464")).'</a>
                  <input type="hidden" name="params[access_token]" value="'.($this->data->params->access_token ?: '').'" >

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >'.translate("tr_39638dcb384d3f96f6cf2ab55236e85e").'</label>

                  <input type="text" name="type_score_name" class="form-control" value="'.$this->data->type_score_name.'" />

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >'.translate("tr_62b685c7d7c78ac9b69b36cfc70c566f").'</label>

                  <textarea name="secure_description" class="form-control" >'.$this->data->secure_description.'</textarea>

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >'.translate("tr_4c9b813328913ee49b0cf7b9f329c335").'</label>

                  <div class="input-group">
                    <input type="number" class="form-control" name="secure_deal_min_amount" value="'.$this->data->secure_deal_min_amount.'" />
                    <span class="input-group-text">'.$app->system->getDefaultCurrency()->symbol.'</span>
                  </div>

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >'.translate("tr_7efac46fd7c18bde256303c3c21d398e").'</label>

                  <div class="input-group">
                    <input type="number" class="form-control" name="secure_deal_max_amount" value="'.$this->data->secure_deal_max_amount.'" />
                    <span class="input-group-text">'.$app->system->getDefaultCurrency()->symbol.'</span>
                  </div>

                </div>
            ';

            $secure_deal_status = '
                <div class="col-12 mt-2">

                    <label class="switch">
                      <input type="checkbox" name="secure_deal_status" value="1" class="switch-input" '.($this->data->secure_deal_status ? 'checked=""' : '').' >
                      <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                      </span>
                      <span class="switch-label">'.translate("tr_c21b2ddff1f121219f81a576c5f6a242").'</span>
                    </label>

                </div>
            ';

        }

        return '
        <form class="integrationPaymentForm" >

            <h3>'.$this->data->name.'</h3>

            <div class="row">

                <div class="col-12">

                    <label class="switch">
                      <input type="checkbox" name="status" value="1" class="switch-input" '.($this->data->status ? 'checked=""' : '').' >
                      <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                      </span>
                      <span class="switch-label">'.translate("tr_87a4286b7b9bf700423b9277ab24c5f1").'</span>
                    </label>

                </div>

                '.$secure_deal_status.'

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >'.translate("tr_55c9488fbbf51f974a38acd8ccb87ee1").'</label>

                  '.$app->ui->managerFiles(["filename"=>$this->data->image, "type"=>"images", "path"=>"images"]).'

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-1" >'.translate("tr_673b49f1887ca36b7e1d37d4f8c112b9").'</label>

                  <strong>'.$app->system->buildWebhook("payment", $this->alias).'</strong>

                  <div class="alert alert-warning d-flex align-items-center mt-2 mb-0" role="alert">
                    '.translate("tr_d6049d9c844a6dfea6051bfe3f0d7462").'
                  </div>

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >'.translate("tr_602680ed8916dcc039882172ef089256").'</label>

                  <input type="text" name="name" class="form-control" value="'.$this->data->name.'" />

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >'.translate("tr_cfe494c750a7c11908a7c19249bf200f").'</label>

                  <input type="text" name="title" class="form-control" value="'.$this->data->title.'" />

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >'.translate("tr_2fdb05c9d5cf1ff667dac68b85b1dd94").'</label>

                  <input type="text" name="params[wallet_number]" class="form-control" value="'.$this->data->params->wallet_number.'" />

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >'.translate("tr_447cb983775fcfddd907f09a22c79821").'</label>

                  <input type="text" name="params[private_key]" class="form-control" value="'.$this->data->params->private_key.'" />

                </div>

                '.$secure_deal_available.'

                <input type="hidden" name="id" value="'.$this->data->id.'" />

                <div class="mt-4 d-grid col-lg-6 mx-auto">
                  <button class="btn btn-primary buttonIntegrationPaymentSave">'.translate("tr_74ea58b6a801f0dce4e5d34dbca034dc").'</button>
                </div>

            </div>

        </from>
        ';

    }


}