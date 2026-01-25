<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers\Dashboard;

 use App\Systems\Controller;

 class DealsController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

 public function card($order_id)
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/deals.js\" type=\"module\" ></script>"]);

    $data = $this->component->transaction->getDealByOrderId($order_id);

    if(!$data){
        abort(404);
    }

    $data->payments = $this->model->transactions_deals_payments->getAll("order_id=?", [$order_id]);

    $this->view->setParamsComponent(["data"=>(object)$data, "breadcrumbs"=>["chain"=>[translate("tr_9a3dc867f2fd583f53c561442ecf34b0")=>$this->router->getRoute("dashboard-deals"), $order_id=>null]]]);

    return $this->view->preload('deals/card', ["data"=>(object)$data, "title"=>translate("tr_9a3dc867f2fd583f53c561442ecf34b0")]);

}

public function delete()
{

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->component->transaction->deleteDeal($_POST['id']);

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(['status'=>true]);  

}

public function disputeSave()
{

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    if($this->validation->requiredField($_POST['dispute_solution_code'])->status == false){
        $answer['dispute_solution_code'] = $this->validation->error;
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }else{

        $this->component->transaction->addSolutionDisputeDeal($_POST["order_id"], $_POST["dispute_solution_code"], $_POST["dispute_text"]);
        
        $this->session->setNotifyDashboard('success', code_answer("action_successfully"));
        return json_answer(['status'=>true]);       

    }


}

public function loadCardPayment()
{

    if(!$this->user->verificationAccess('view')->status){
        return json_answer(["access"=>false]);
    }
    
    $data = $this->model->transactions_deals_payments->find("id=?", [$_POST['id']]);

    $data->whom_user = $this->model->users->findById($data->whom_user_id);
    $data->payment_data = $this->component->profile->getPaymentData($data->whom_user_id);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('deals/load-card-payment.tpl')]);
}

public function loadDataChartMonth()
{

    return $this->component->transaction->getDealsByMonthChart();

}

public function main()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/deals.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_9a3dc867f2fd583f53c561442ecf34b0")=>$this->router->getRoute("dashboard-deals")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_9a3dc867f2fd583f53c561442ecf34b0"),"page_icon"=>"ti-briefcase","favorite_status"=>true]]);

    return $this->view->preload('deals/deals', ["title"=>translate("tr_9a3dc867f2fd583f53c561442ecf34b0")]);

}

public function paymentChangeStatus()
{

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }
    
    $this->model->transactions_deals_payments->update(["status_processing"=>$_POST['status'], "comment"=>null, "user_show_error"=>0], $_POST['id']);

    return json_answer(['status'=>true]);

}

public function paymentSaveCommentError()
{

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    if($this->validation->requiredField($_POST['comment'])->status == false){
        $answer['comment'] = $this->validation->error;
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }else{

        $this->component->transaction->paymentSaveCommentError($_POST['id'], $_POST['comment'], $_POST['notify_recipient']);

        return json_answer(['status'=>true]);       

    }

}



 }