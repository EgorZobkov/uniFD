public function loadCountriesList()
{   

    if(!$this->user->verificationAccess('view')->status){
        return json_answer(["access"=>false]);
    }

    $result = '';

    $countries_list = $this->system->uniApi("countries_list");

    $result = '<option value="" >'.translate("tr_591cca300870eb571563ef4b8c8756ff").'</option>';

    if($countries_list){
      foreach ($countries_list as $key => $value) {
         $result .= '<option value="'.$value["id"].'" >'.$value["name"].'</option>';
      }
    }

    return json_answer(["status"=>true, "content"=>$result]);

}