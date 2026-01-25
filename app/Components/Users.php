<?php

/**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Components;

class Users
{

 public $alias = "users";

 public function allStatuses(){
    return [
        1 => translate("tr_318150c53b2ec43a3ffef0f443596df1"),
        2 => translate("tr_b6c10e7546945122976732d133e2d28a"),
    ];
}

public function getListUsersOnline($limit=10){
    global $app;
    return $app->model->users->getAll("unix_timestamp(time_last_activity)+300 > unix_timestamp(now()) limit $limit");
}

public function getStatisticsUsersByMonthChart($filter_date=null){   
    global $app;

    $series = [];
    $dates = [];
    $data = [];
    $action_count = [];

    if($filter_date){
        $y = date("Y", strtotime($filter_date));
        $m = date("m", strtotime($filter_date));  
    }else{
        $y = $app->datetime->format("Y")->getDate();
        $m = $app->datetime->format("m")->getDate();            
    }

    $days_in_month = $app->datetime->daysInMonth($m, $y);

    $x=0;
    while ($x++<$days_in_month){
       $dates[$y."-".$m."-".$x] = $y."-".$m."-".$x;
    }

    foreach ($dates as $date) {

        $totalCount = $app->model->users->count("date(time_create)=?", [$date]);

        $action_count[translate("tr_57f847852a19664cee0c91d73974301c")][] = ["date"=>date("d.M.Y", strtotime($date)), "count"=>(int)$totalCount];

    }

    foreach ($action_count as $action => $nested) {
        $data = [];
        foreach ($nested as $key => $value) {
            $data[] = ["x"=>$value["date"], "y"=>$value["count"]];
        }
        $series[] = ["name"=>$action, "data"=>$data];
    }

    return $series;
}

public function getTotalUsers(){   
    global $app;

    return numberFormat($app->model->users->count());

}

public function getTotalUsersActive(){   
    global $app;

    return numberFormat($app->model->users->count("status=?", [1]));

}

public function getTotalUsersBlocked(){   
    global $app;

    return numberFormat($app->model->users->count("status=?", [2]));

}

public function getTotalUsersByWeekChart(){   
    global $app;

    $data = [];

    $week[date('Y-m-d')] = date('Y-m-d');

    $currentWeek = date("w",strtotime(date('Y-m-d'))) == 0 ? 7 : date("w",strtotime(date('Y-m-d')));

    if($currentWeek > 1){
        $x=0;
        while ($x++<$currentWeek-1){
           $week[date('Y-m-d', strtotime("-".$x." day"))] = date('Y-m-d', strtotime("-".$x." day"));
        }
    }

    foreach ($week as $key => $value) {
        $count = $app->model->users->count("date(time_create)=?", [$value]);
        $data[$value] = ["x"=>$app->datetime->getNameDayWeek($value, true),"y"=>$count, "title"=>$count.' '.endingWord($count, translate("tr_1075de897df42cd76107c5e32827ef92"), translate("tr_10837c2e8c09a894e000ed95430024dc"), translate("tr_11e586d97e9b7fc95413e27878a89692"))];
    }

    ksort($data);

    $data = array_values($data);

    return $data;
}

public function getTotalUsersOnline($key = null){
    global $app;
    if(isset($key)){
        if($key == "administrators"){
            return $app->model->users->count("admin=? and unix_timestamp(time_last_activity)+300 > unix_timestamp(now())", [1]);
        }elseif($key == "users"){
            return $app->model->users->count("admin=? and unix_timestamp(time_last_activity)+300 > unix_timestamp(now())", [0]);
        }
    }
}

public function getTotalUsersToday(){   
    global $app;

    return numberFormat($app->model->users->count("status=? and date(time_create) = date(now())", [1]));

}

public function outAllRolesOptions($role_id=null){
    global $app;

    $result = '';

    $getRoles = $app->model->system_roles->sort("id asc")->getAll();
    if($getRoles){
      foreach ($getRoles as $key => $role) {
        if(isset($role_id)){
            if($role_id == $role["id"]){
                $result .= '<option value="'.$role["id"].'" data-chief="'.$role["chief"].'" selected="" >'. translateField($role["name"]).'</option>';
            }else{
                $result .= '<option value="'.$role["id"].'" data-chief="'.$role["chief"].'" >'. translateField($role["name"]).'</option>';
            }
        }else{
            $result .= '<option value="'.$role["id"].'" data-chief="'.$role["chief"].'" >'. translateField($role["name"]).'</option>';
        }
      }
    }

    return $result;

}

public function outAllStatusesOptions($status_id=null){
    global $app;

    $result = '';

    foreach ($this->allStatuses() as $key => $value) {
        if(isset($status_id)){
            if($status_id == $key){
                $result .= '<option value="'.$key.'" selected="" >'.$value.'</option>';
            }else{
                $result .= '<option value="'.$key.'" >'.$value.'</option>';
            }
        }else{
            $result .= '<option value="'.$key.'" >'.$value.'</option>';
        }
    }

    return $result;

}



}