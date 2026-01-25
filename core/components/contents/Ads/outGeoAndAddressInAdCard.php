public function outGeoAndAddressInAdCard($data=[]){
    global $app;

    $result = [];

    if($data->address){

        $result[] = $data->address;

    }else{

        if($data->geo->region){
            $result[] = $data->geo->region->name;
        }

        $result[] = $data->geo->name;

    }

    $districts = $this->getCityDistrictsByAd($data->id)->data;

    if($districts){
        foreach ($districts as $key => $value) {
            $result[] = translate("tr_66f872ee0c56fb3dc21a01e1cb8724f1") . " " . $value["name"];
        }
    }

    return implode(", ", $result);

}