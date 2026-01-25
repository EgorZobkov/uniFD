<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Addons\Payments;

class Robokassa{

    public $alias = "robokassa";
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
        return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAC0AAAAvCAYAAAB30kORAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAydpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDkuMS1jMDAyIDc5LmE2YTYzOTY4YSwgMjAyNC8wMy8wNi0xMTo1MjowNSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIDI1LjExIChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpBNEYxQTEwRTE5QzUxMUYwODU0QTkwREY0NTEwNkZFNSIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpBNEYxQTEwRjE5QzUxMUYwODU0QTkwREY0NTEwNkZFNSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOkE0RjFBMTBDMTlDNTExRjA4NTRBOTBERjQ1MTA2RkU1IiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOkE0RjFBMTBEMTlDNTExRjA4NTRBOTBERjQ1MTA2RkU1Ii8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+yNxvsAAAA3NJREFUeNrU2utPUmEcB/ADYmbNC5cDCIgoSoqm5XRO0dVabdXWWheGZqSgc6251ryktPUqTap/IntZa2utrCVdVs1ZmnmLkKERIl7iJiLeSnqOi83KC7fDOfzenec8z7MPX54HOM8guN1uKJzKMueKJRFK6m1hI+bCY7rb1adIfy7jcQ9OhPtGblWd4bNpBmJYJMyi9quVVWIBB9Yjl/hHMymDQ3eqxRlgaXia8I1mkocHADiLS9etb8Yvmh6v/qSUSbJ5DO2/t/CJhuM0PUq5JJfPVm90G39oaqz2IwDnpbGHN+uCLzQ5RtcNlkS+gDO4VTf8oON3jXUBcEE6t3+7rvhAx0Xr3ymrJIXCpD5vumOPjok2vG6VlRVn8nq9HYItevdO48u2yrKDOfxuX4aRMANHR5k62+Rlh3L4Xb4OxSbpqEjTM6Ws7PB+/nt/hhMxAE89VcrLj+amvfV3itCiIyNmHrdWSI/nCd4EMg0xhGDzo1aZ9ERBhirQqUKDjiBaH7ZUSk8WZrwIxnToo4kE+4OWCunpIuHzoE2JMtl+v6Wi/GxxVkdQc0AZLBWX7O0I+puHlvh6zbEb4gPZT1BZcaj8YBOwoVdqQ/4HjWFfWKCj9nCgTPraiURpfbuqqUdrzMY1mgQSzoPj1jeV1t3tVPRqjVm4RJMELKiA/v+Zj9vtLm1sVyn6dBNCXKEJaWwAJm96f2V19VwDSLxfZxLiA52aABUxtj9VW/61er7hnqppYGwyHVs0PwESMSled19c+XmhESQ+pJ8SYIPmMyFRAsXnYS4AvwrgX/TTqaFFp4CEE6h+v965pZXKxvZOxVfDTEpo0AiYRQl4KzgWl+VI4ppx3+G+oZOZQQF7yrawVI18qowYzTx00AiYTYWCXXbXUjWSuHbCe7h36BQ6KmBPWeYXahC4zmThBgedDMAsGPVnBbMTwMHmHJ20cgJD85CE0Qd7asbhutgEEv82bWP5h05iQCJO6MCemnLMX2oGcP0W8I3RSSDhRBqEVU3YnbXNYKkYfswyvUNzYQCGIazLaHPWKkDi4+ZZ+tZoLkiYS4fwUt+tjssI3GRx0DZGg+Ug4sIQ3kpvcVxB4JPWOdrfaAQMNh5ea9Q8W3cNPLpN251rX8cESHLzsyiZoYHCoAQMslFZeaSVEG7/QnAuLu/4LcAA8+gnTl6qUsYAAAAASUVORK5CYII=';
        }else{
            return $app->storage->name($this->data->image)->get();
        }

    }

    public function createPayment($params=[]){
        global $app;

        try {

            if($this->data->params->sandbox){
               $this->data->params->pass1 = $this->data->params->test_pass1;
            }

            $mrh_login = $this->data->params->shop_id;
            $mrh_pass1 = $this->data->params->pass1;
            $inv_id = $params["order_id"]; 
            $inv_desc = $params["title"]; 
            $out_sum = numberFormat($params["amount"],2,".","");

            if($this->data->params->receipt){

               $items['sno'] = $this->data->params->tax;
               $items['items'][] = [
                  'name' => $params["title"],
                  'quantity' => 1,
                  'sum' => $out_sum,
                  'payment_method' => 'full_payment',
                  'payment_object' => 'payment',
                  'tax' => $this->data->params->vat,
               ];

               $arr_encode = _json_encode($items);
               $receipt = urlencode($arr_encode);
               $receipt_urlencode = urlencode($receipt);
              
               $crc = md5("$mrh_login:$out_sum:$inv_id:$receipt:$mrh_pass1");

               $url = "https://auth.robokassa.ru/Merchant/Index.aspx?MrchLogin=$mrh_login&OutSum=$out_sum&InvId=$inv_id&Receipt=$receipt_urlencode&Desc=$inv_desc&SignatureValue=$crc";

            }else{

               $crc = md5("$mrh_login:$out_sum:$inv_id:$mrh_pass1");

               $url = "https://auth.robokassa.ru/Merchant/Index.aspx?MrchLogin=$mrh_login&OutSum=$out_sum&InvId=$inv_id&Desc=$inv_desc&SignatureValue=$crc&IsTest={$param["test"]}";

            }

            return ["link"=>$url];

        } catch (\Exception $e) {
            logger("Payment ".$this->alias." createPayment error: {$e->getMessage()}");
        }

    }

    public function createPayout($data=[]){
        global $app;

        try {



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

    public function callback($action=null){
        global $app;

        try {

            if($this->data->params->sandbox){
               $this->data->params->pass2 = $this->data->params->test_pass2;
            }

            $amount = $_REQUEST["OutSum"];
            $order_id = $_REQUEST["InvId"];
            $crc = strtoupper($_REQUEST["SignatureValue"]);

            $my_crc = strtoupper(md5("$amount:$order_id:".$this->data->params->pass2));

            if ($my_crc != $crc)
            {
                logger("Payment ".$this->alias." callback error: bad sign");
                header("HTTP/1.1 404 ERROR");
                return "bad sign";
            }

            $order = $app->component->transaction->getOperation($order_id);

            if($order){
                $app->component->transaction->callback($order->data, _json_encode($_REQUEST));
                header("HTTP/1.1 200 OK");
                return "OK$order_id";
            }else{
                logger("Error payment not found order:".$order_id);
                header("HTTP/1.1 404 ERROR");
            }

        } catch (Exception $e) {
            logger("Payment ".$this->alias." callback error: {$e->getMessage()}");
            header("HTTP/1.1 404 ERROR");
        }

    }

    public function fieldsForm($params=[]){
        global $app;

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

                <div class="col-12 mt-3">

                    <label class="switch">
                      <input type="checkbox" name="params[sandbox]" value="1" class="switch-input" '.($this->data->params->sandbox ? 'checked=""' : '').' >
                      <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                      </span>
                      <span class="switch-label">Sandbox</span>
                    </label>

                </div>

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

                    <label class="switch">
                      <input type="checkbox" name="params[receipt]" value="1" class="switch-input integration-payment-services-edit-receipt-switch" '.($this->data->params->receipt ? 'checked=""' : '').' >
                      <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                      </span>
                      <span class="switch-label">'.translate("tr_87e8dd3eac313bc2e7f73640d0755300").'</span>
                    </label>

                </div>

                <div class="integration-payment-services-edit-receipt-container" '.($this->data->params->receipt ? 'style="display: block;"' : 'style="display: none;"').' >

                    <div class="col-12 mt-3">

                        <div>

                          <label class="form-label mb-2" >'.translate("tr_6aa03bc8477412d9d4fec0d3aa2f0a00").'</label>

                          <select class="form-select selectpicker" name="params[tax]" title="'.translate("tr_591cca300870eb571563ef4b8c8756ff").'" >
                            <option value="osn" '.($this->data->params->tax == "osn" ? 'selected=""' : '').' >'.translate("tr_31f33f3abe036acb73740e38aa428b96").'</option>
                            <option value="usn_income" '.($this->data->params->tax == "usn_income" ? 'selected=""' : '').' >'.translate("tr_c312eec9bc05d4ca36b8c0b97d6361f8").'</option>
                            <option value="usn_income_outcome" '.($this->data->params->tax == "usn_income_outcome" ? 'selected=""' : '').' >'.translate("tr_10a32a52ec8ef4dba251e40f5c085bc8").'</option>
                            <option value="esn" '.($this->data->params->tax == "esn" ? 'selected=""' : '').' >'.translate("tr_d543313331865a30387343d27aa8f40c").'</option>
                            <option value="patent" '.($this->data->params->tax == "patent" ? 'selected=""' : '').' >'.translate("tr_e032aa607069a6d8c81f8ff43481ca41").'</option>
                          </select>

                        </div>

                        <div class="mt-3">

                          <label class="form-label mb-2" >'.translate("tr_343abee101c00ff5fc746fc7dba664d3").'</label>

                          <select class="form-select selectpicker" name="params[vat]" title="'.translate("tr_591cca300870eb571563ef4b8c8756ff").'" >
                            <option value="none" '.($this->data->params->vat == "none" ? 'selected=""' : '').' >'.translate("tr_976ce0e8aa4277c8cbfa375771130a93").'</option>
                            <option value="vat0" '.($this->data->params->vat == "vat0" ? 'selected=""' : '').' >'.translate("tr_a9b8d0f446d92e45592cfe10b06a5ad3").'</option>
                            <option value="vat10" '.($this->data->params->vat == "vat10" ? 'selected=""' : '').' >'.translate("tr_b3ffe5e5d2f93b8f075b8eda1f7abc2e").'</option>
                            <option value="vat20" '.($this->data->params->vat == "vat20" ? 'selected=""' : '').' >'.translate("tr_513186c07238e50793ef398018c85c32").'</option>
                            <option value="vat110" '.($this->data->params->vat == "vat110" ? 'selected=""' : '').' >'.translate("tr_e3391a3446bbe6302195ddc1483ba8c7").'</option>
                            <option value="vat120" '.($this->data->params->vat == "vat120" ? 'selected=""' : '').' >'.translate("tr_4e782b7d5f1e9bcef1d1d543a86f45f6").'</option>
                          </select>

                        </div>

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

                  <label class="form-label mb-2" >'.translate("tr_ccf107a5d46c6501c9f2f4345400dc2e").'</label>

                  <input type="text" name="params[shop_id]" class="form-control" value="'.$this->data->params->shop_id.'" />

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >'.translate("tr_b918c40c6ab16f3a20b5d97215fde5d6").'</label>

                  <input type="text" name="params[pass1]" class="form-control" value="'.$this->data->params->pass1.'" />

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >'.translate("tr_a9a1f8c4d8d66a401b1df20a72bd21ff").'</label>

                  <input type="text" name="params[pass2]" class="form-control" value="'.$this->data->params->pass2.'" />

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >'.translate("tr_2c593e4f5844d0a6c4df0ad0418d8643").'</label>

                  <input type="text" name="params[test_pass1]" class="form-control" value="'.$this->data->params->test_pass1.'" />

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >'.translate("tr_277ef07c56bd8e225aa6b405ada23f9e").'</label>

                  <input type="text" name="params[test_pass2]" class="form-control" value="'.$this->data->params->test_pass2.'" />

                </div>

                <input type="hidden" name="id" value="'.$this->data->id.'" />

                <div class="mt-4 d-grid col-lg-6 mx-auto">
                  <button class="btn btn-primary buttonIntegrationPaymentSave">'.translate("tr_74ea58b6a801f0dce4e5d34dbca034dc").'</button>
                </div>

            </div>

        </from>
        ';

    }


}