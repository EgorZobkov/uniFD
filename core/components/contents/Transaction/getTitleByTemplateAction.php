public function getTitleByTemplateAction($data=[]){
    global $app;

    $data = (array)$data;
    
    $macrosList = [];
    $template = $this->getActionCode($data["target"])->template;

    if($data["service_data"]){

        $macrosList = [
            "{service_name}"=>$data["service_data"]["name"],
            "{service_count_day}"=>$data["service_data"]["count"] . ' ' . endingWord($data["service_data"]["count"], translate("tr_48e438a146f96b54bbe9d5046ffc3a2b"), translate("tr_0871eeafdf38726742fa5affa8a5d6eb"), translate("tr_c183655a02377815e6542875555b1340")),
        ];

    }elseif($data["tariff_data"]){

        $count_day = $data["tariff_data"]["count"] ? $data["tariff_data"]["count"] . ' ' . endingWord($data["tariff_data"]["count"], translate("tr_48e438a146f96b54bbe9d5046ffc3a2b"), translate("tr_0871eeafdf38726742fa5affa8a5d6eb"), translate("tr_c183655a02377815e6542875555b1340")) : translate("tr_2da14cc34b6c4853a3e022eab0b02e06");

        $macrosList = [
            "{tariff_name}"=>$data["tariff_data"]["name"],
            "{tariff_count_day}"=>$count_day,
        ];

    }elseif($data["category_name"]){

        $macrosList = [
            "{category_name}"=>$data["category_name"],
        ];

    }

    if($macrosList){
        foreach ($macrosList as $key => $value) {
            $template = str_replace($key, $value, $template);
        }
    }

    return $template;
}