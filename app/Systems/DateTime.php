<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Systems;

use Carbon\Carbon;

class DateTime
{

    public function addDay($day=null){
        $this->day = $day;
        return $this;
    }

    public function addSeconds($seconds=null){
        $this->seconds = $seconds;
        return $this;
    }

    public function addMinute($minute=null){
        $this->minute = $minute;
        return $this;
    }

    public function addHours($hours=null){
        $this->hours = $hours;
        return $this;
    }

    public function format($format=null){
        $this->format = $format;
        return $this;
    }

    public function currentTime(){
        return time();
    }

    public function getTime($time=null){

        if(isset($time)){
            $time = strtotime($time);
        }else{
            $time = time();
        }

        if(isset($this->day)){
            $time = $time + (intval($this->day) * 86400);
            $this->clearVariables();
            return $time;
        }
        if(isset($this->minute)){
            $time = $time + (intval($this->minute) * 60);
            $this->clearVariables();
            return $time;
        }
        if(isset($this->hours)){
            $time = $time + (intval($this->hours) * 3600);
            $this->clearVariables();
            return $time;
        }
        if(isset($this->seconds)){
            $time = $time + $this->seconds;
            $this->clearVariables();
            return $time;
        }

        return $time;
    }

    public function getDate($time=null){

        if(isset($time)){
            $time = strtotime($time);
        }else{
            $time = time();
        }

        $format = isset($this->format) ? $this->format : "Y-m-d H:i:s";

        if(isset($this->day)){
            $time = $time + (intval($this->day) * 86400);
            $this->clearVariables();
            return date($format, $time);
        }
        
        if(isset($this->minute)){
            $time = $time + (intval($this->minute) * 60);
            $this->clearVariables();
            return date($format, $time);
        }
        
        if(isset($this->hours)){
            $time = $time + (intval($this->hours) * 3600);
            $this->clearVariables();
            return date($format, $time);
        }

        if(isset($this->seconds)){
            $time = $time + $this->seconds;
            $this->clearVariables();
            return date($format, $time);
        }

        $this->clearVariables();
        return date($format);
    }

    public function convert($date=null){
        $format = isset($this->format) ? $this->format : "Y-m-d H:i:s";
        $this->clearVariables();
        return date($format, strtotime($date));
    }

    public function currentYear(){
        return date("Y");
    }

    public function currentMonth(){
        return abs(date("m"));
    }

    public function outDate($time=null){
        global $app;
        return Carbon::parse($time)->locale($app->translate->current->locale?:'ru_RU')->isoFormat('LL');
    }

    public function outDateTime($time=null){
        global $app;
        return Carbon::parse($time)->locale($app->translate->current->locale?:'ru_RU')->isoFormat('LLL');
    }

    public function outLastTime($time=null){
        global $app;
        if(isset($time)){
            return Carbon::createFromFormat('Y-m-d H:i:s', $time)->locale($app->translate->current->locale?:'ru_RU')->diffForHumans();
        }
    }

    public function outRemainedTime($start=null, $end=null){
        global $app;
        if($start && $end){

            $start = Carbon::parse($start);
            $end = Carbon::parse($end);

            return $end->locale($app->translate->current->locale?:'ru_RU')->diff($start)->format('%I:%S');

        }
    }

    public function outDiffDay($time=null){
        global $app;

        if(isset($time)){

            return abs(intval(Carbon::createFromFormat('Y-m-d H:i:s', $time)->locale($app->translate->current->locale?:'ru_RU')->diffInDays()));
        }

        return 0;

    }

    public function outDiffMonth($start=null, $end=null){
        global $app;

        $months = 0;

        if(isset($start) && isset($end)){

            $start = strtotime($start);
            $end = strtotime($end);
             
            while (strtotime('+1 month', $start) < $end) {
                $months++;
                $start = strtotime('+1 month', $start);
            }

        }

        return $months;

    }

    public function daysInMonth($month=null, $year=null){
        
        return cal_days_in_month(CAL_GREGORIAN, $month, $year);

    }

    public function outStringDiff($start=null, $end=null){
        
        if(isset($end)){

            $result = [];

            $start = new \DateTime($start ? $start : date("Y-m-d H:i:s"));
            $end = new \DateTime($end);

            $interval = $start->diff($end);

            if($interval->y){
                $result[] = $interval->y . ' ' . endingWord($interval->y, translate("tr_6270693d76d15c0b806abbb0929ca8a8"), translate("tr_7443f947f549b6ebaf7ef46fc250ebcb"), translate("tr_257a7675c4de6732049a6df12a39974e"));
            }

            if($interval->m){
                $result[] = $interval->m . ' ' . endingWord($interval->m, translate("tr_163261267d25c50d92408b3cd386cbd4"), translate("tr_d4782ccd1152d1f4898ae37bf29c5974"), translate("tr_437f2ad70a1c2f03b0e6bf350b62f58a"));
            }

            if($interval->d){
                $result[] = $interval->d . ' ' . endingWord($interval->d, translate("tr_48e438a146f96b54bbe9d5046ffc3a2b"), translate("tr_0871eeafdf38726742fa5affa8a5d6eb"), translate("tr_c183655a02377815e6542875555b1340"));
            }

            if($interval->h){
                $result[] = $interval->h . ' ' . endingWord($interval->h, translate("tr_62bbcd05019d00983f23da51757868dd"), translate("tr_f0e3c390cb88d16db2764163a8098c60"), translate("tr_aa0b458eec4f4b95694d83559b43ecee"));
            }

            if($interval->i){
                $result[] = $interval->i . ' ' . endingWord($interval->i, translate("tr_62d4666711e4375934b9103db792508e"), translate("tr_5bc997d1a93d20df6d35de25a26e18f4"), translate("tr_b877a76d5951435262ba8620ec4fc184"));
            }

            if(!$interval->h){
                if($interval->s){
                    $result[] = $interval->s . ' ' . endingWord($interval->s, translate("tr_bb454d4869b57bf8a07accab00ce20e2"), translate("tr_fd87c8da32aa6764176f847a6bddde07"), translate("tr_ccaa89f9bc459f1812820ab348acc23e"));
                }
            }

            if($result){
                return implode(" ", $result);
            }
        }

        return '';

    }

    public function getDaysDiff($start=null, $end=null){
        
        $end = $end ?: $this->getDate();
        $start = new \DateTime($start);
        $end = new \DateTime($end);

        return $end->diff($start)->days;

    }

    public function getCurrentNameMonth($number_month=null){

        if(!$number_month){
            $number_month = date("m");
        }
        
        if($number_month == 1){
            return translate("tr_ee86202a6d6721da43373b3fb9ee5475");
        }elseif($number_month == 2){
            return translate("tr_28ffcf8a6b65b57cbd165a751d465d69");
        }elseif($number_month == 3){
            return translate("tr_d766d4fca8fe0965a78a4b8460c464b1");
        }elseif($number_month == 4){
            return translate("tr_03e90d6b997d3d8b567c12c78613868f");
        }elseif($number_month == 5){
            return translate("tr_2e53bf643cfcc39b5f7c83fe5c2b8926");
        }elseif($number_month == 6){
            return translate("tr_cfcb9c95859979d826e5865a3942ba70");
        }elseif($number_month == 7){
            return translate("tr_89fb2f551593a981cde15f554cd2b712");
        }elseif($number_month == 8){
            return translate("tr_de5ab5bcab12870a07dbd41e4fa3d968");
        }elseif($number_month == 9){
            return translate("tr_ebfbaeb6ae53d2d5e2c4b97012447241");
        }elseif($number_month == 10){
            return translate("tr_17208f1f784b167b199ff1a90ab200b5");
        }elseif($number_month == 11){
            return translate("tr_66fbc4dc04af4158a7cf9885203dad3c");
        }elseif($number_month == 12){
            return translate("tr_39b3dc4cd1bff016d0da77b2ace44e88");
        }

    }

    public function getNameDayWeek($date=null, $short=false){

        $number_day_week = date("w",strtotime($date));
        
        if($number_day_week == 1){
            return $short ? translate("tr_2c1ec3e4ea62c1b5d31d795bcf7697e7") : translate("tr_aae9f1f89cb94eca5395ee5895ec3254");
        }elseif($number_day_week == 2){
            return $short ? translate("tr_714517b4191534c9afcd6f145945041b") : translate("tr_5ee6823986a8f899e72867769cc79f50");
        }elseif($number_day_week == 3){
            return $short ? translate("tr_c6e47c918f104178ee19e6efcb592b1d") : translate("tr_05a6fc3b0f38613c1204533941d7fbf2");
        }elseif($number_day_week == 4){
            return $short ? translate("tr_a51f2ee4c52f5577035ae0f967f18ce1") : translate("tr_afc65037bfd6f02b96fed9402a04e559");
        }elseif($number_day_week == 5){
            return $short ? translate("tr_012388c64b115db842951c2b4d4b7953") : translate("tr_e22ad436a75ddca627ceceb8133ed473");
        }elseif($number_day_week == 6){
            return $short ? translate("tr_3a4b2ba55d5521de6d5e15e6d2c1ce4b") : translate("tr_cee58b7423c8a4be832c9c6b451266a3");
        }elseif($number_day_week == 7 || $number_day_week == 0){
            return $short ? translate("tr_4ad91dca7b97f941c86e0b9a8bd41b92") : translate("tr_aa48fa26be782a62ae1c97db92b52286");
        }

    }

    public function getDaysInYearMonth($year, $month){

        $dates = [];

        $days_in_month = $this->daysInMonth($month, $year);

        $x=0;
        while ($x++<$days_in_month){
           $dates[date("Y-m-d", strtotime($year."-".$month."-".$x))] = date("Y-m-d", strtotime($year."-".$month."-".$x));
        }

        return $dates;
    }

    public function getDaysBetweenDates($start, $end){

        $day = 86400;
        $start = strtotime($start . ' -1 days');
        $end = strtotime($end . ' +1 days');
        $nums = round(($end - $start) / $day); 
       
        $days = [];
        for ($i = 1; $i < $nums; $i++) { 
            $days[] = date("Y-m-d", ($start + ($i * $day)));
        }

        return $days;
    }

    public function clearVariables(){
        $this->addDay(null);
        $this->addMinute(null);
        $this->addHours(null);
        $this->addSeconds(null);
        $this->format(null);
    }


}