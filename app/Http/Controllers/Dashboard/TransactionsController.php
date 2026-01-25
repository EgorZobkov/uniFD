<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers\Dashboard;

 use App\Systems\Controller;

 class TransactionsController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

 public function delete()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->model->transactions->delete("id=?", [$_POST['id']]);

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);
}

public function deleteOperation()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->model->transactions_operations->delete("id=?", [$_POST['id']]);

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);
}

public function loadCardOperation()
{

    if(!$this->user->verificationAccess('view')->status){
        return json_answer(["access"=>false]);
    }
    
    $operation = $this->model->transactions_operations->find("id=?", [$_POST['id']]);

    $operation->data = decrypt($operation->data);
    $operation->callback_data = $operation->callback_data ? decrypt($operation->callback_data) : '-';
    $operation->refund_data = $operation->refund_data ? decrypt($operation->refund_data) : '-';

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$operation])->includeComponent('transactions/load-card-operation.tpl')]);
}

public function loadDataChartMonth()
{

    if(!$this->user->verificationAccess('view')->status){
        return json_answer(["access"=>false]);
    }

    $date = "";

    if($_POST["year"] && $_POST["month"]){
        $date = $_POST["year"]."-".$_POST["month"];
    }

    return $this->component->transaction->getStatisticsByMonthChart($date);

}

public function loadDataChartWeekAndMonth()
{

    if(!$this->user->verificationAccess('view')->status){
        return json_answer(["access"=>false]);
    }

    return ["week"=>$this->component->transaction->getTotalTransactionsByWeekChart(), "month"=>$this->component->transaction->getStatisticsByMonthChart()];

}

public function main()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/transactions.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_6f99d23532d69316b48a8bd20bf2b085")=>$this->router->getRoute("dashboard-transactions")],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_6f99d23532d69316b48a8bd20bf2b085"),"page_icon"=>"ti-timeline","favorite_status"=>true]]);

    return $this->view->preload('transactions/transactions', ["title"=>translate("tr_6f99d23532d69316b48a8bd20bf2b085")]);

}

public function multiDelete()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->component->transaction->deleteTransactionMulti($_POST['ids_selected']);

    $this->session->setNotifyDashboard('success', code_answer("delete_successfully"));

    return json_answer(["status"=>true]);
}

public function operations()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/transactions.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_6f99d23532d69316b48a8bd20bf2b085")=>$this->router->getRoute("dashboard-transactions"),translate("tr_1ec0db83a649974785419afafde20176")=>null]]]);

    return $this->view->preload('transactions/operations', ["title"=>translate("tr_1ec0db83a649974785419afafde20176")]);

}

public function statistics()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/transactions-statistics.js\" type=\"module\" ></script>"]);

    $this->view->setParamsComponent(["breadcrumbs"=>["chain"=>[translate("tr_6f99d23532d69316b48a8bd20bf2b085")=>$this->router->getRoute("dashboard-transactions"),translate("tr_5e3753ce80a1394ad160591140abb966")=>null],"route_name"=>$this->router->currentRoute->name,"page_name"=>translate("tr_7c6cbc6fd88e2e3ab9c86c7dc6ef6fd9"),"page_icon"=>"ti-timeline","favorite_status"=>true]]);

    return $this->view->preload('transactions/transactions-statistics', ["title"=>translate("tr_7c6cbc6fd88e2e3ab9c86c7dc6ef6fd9")]);

}



 }