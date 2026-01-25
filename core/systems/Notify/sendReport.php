public function sendReport($data=[]){
    global $app;

    $result = '';

    foreach ($data as $key => $value) {

        if($key == "transactions_amount"){

            $result .= '
                    <tr>
                        <td align="left">'.$value->name.'</td>
                        <td align="right">'.numberFormat($value->count,2) . ' ' . $app->system->getDefaultCurrency()->code.'</td>
                    </tr>
            ';

        }elseif($key == "users_traffic"){
            
            $result .= '
                    <tr>
                        <td align="left">'.$value->name.'</td>
                        <td align="right">'.$value->count.' '.endingWord($value->count, translate("tr_e457d998e4f41614ef24902a655fd86f"), translate("tr_738df4403f3662927ce7424f7abbafb4"), translate("tr_e457d998e4f41614ef24902a655fd86f")).'</td>
                    </tr>
            ';

        }elseif($key == "users"){
            
            $result .= '
                    <tr>
                        <td align="left">'.$value->name.'</td>
                        <td align="right">'.$value->count.' '.endingWord($value->count, translate("tr_e457d998e4f41614ef24902a655fd86f"), translate("tr_738df4403f3662927ce7424f7abbafb4"), translate("tr_e457d998e4f41614ef24902a655fd86f")).'</td>
                    </tr>
            ';

        }else{

            $result .= '
                    <tr>
                        <td align="left">'.$value->name.'</td>
                        <td align="right">'.$value->count.'</td>
                    </tr>
            ';

        }

    }

    $template = '
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        
        <style type="text/css">

        @import url("https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin-ext");
        body {font-family: "Roboto", sans-serif; font-size: 14px;}
        table {margin: 0 0 15px 0;width: 100%;border-collapse: collapse;border-spacing: 0;}     
        table th {padding: 5px;font-weight: bold;}        
        table td {padding: 5px;}    

        h1 {margin: 0 0 10px 0;padding: 10px 0;border-bottom: 2px solid #000;font-weight: bold;font-size: 20px;}
            
        .list thead, .list tbody  {border: 2px solid #000; width: 100%; }
        .list thead th {padding: 4px 0;border: 1px solid #000;vertical-align: middle;text-align: center;}   
        .list tbody td {padding: 10px;border: 1px solid #000;vertical-align: middle;font-size: 14px;}    
        .list tfoot th {padding: 3px 2px;border: none;text-align: right;}   
     
        .logo{ width: 150px; }

        </style>
    </head>
    <body>
     
        <div class="logo" ><img src="{logo}" /></div>
     
        <h1>'.translate("tr_a35eccff74655ccf90feda2704ee3ab6").' '.$app->settings->system_report_last_time_generation.' '.translate("tr_22d57c9399ca22ffbe414f057e8ff6dc").' '.$app->datetime->getDate().' '.translate("tr_f003608f862cd300f291ab8c66805fa4").' {project_name}</h1>
     
        <table class="list">
            <tbody>
            
                '.$result.'

            </tbody>
        </table>
        
    </body>
    </html>
    ';

    foreach($this->macrosList() AS $macrosKey => $macrosValue){
        $template = str_replace($macrosKey, $macrosValue, $template);
    }

    $filename = $app->doc->pdf($template);

    if($app->settings->system_report_recipients_ids){

        if(is_array($app->settings->system_report_recipients_ids)){

            $getUsers = $app->model->users->getAll("id IN(".implode(",", $app->settings->system_report_recipients_ids).")");

            if($getUsers){
                foreach ($getUsers as $key => $value) {
                    if($value["messenger_token_id"] && $app->settings->integration_messenger_service){
                        $app->addons->messenger($app->settings->integration_messenger_service)->sendDocument(["text"=>translate("tr_f7e7bb3adb7bd115d9b21d37f1dfb468")." ".$app->settings->project_name, "filename"=>$filename, "chat_id"=>$value["messenger_token_id"]]);
                    }else{
                        $this->params(["link"=>path($filename, true), "user_name"=>$value["name"], "user_email"=>$value["email"]])->code("system_report")->to($value["email"])->sendEmail();
                    }
                }
            }

        }

    }

}