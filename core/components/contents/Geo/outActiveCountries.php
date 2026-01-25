public function outActiveCountries(){
    global $app;

    $result = '';

    $countries = $app->model->geo_countries->sort("default_status desc, name asc")->getAll("status=?", [1]);

    if($countries){

        foreach ($countries as $key => $value) {

            $image = '';
            $active = '';

            if($this->getChange()->country_id){
                if($this->getChange()->country_id == $value["id"]){
                    $active = 'active';
                }
            }else{
                if($this->defaultCountry){
                    if($this->defaultCountry->id == $value["id"]){
                        $active = 'active';
                    }
                }
            }

            if($app->storage->name($value["image"])->path('images')->exist()){
                $image = '<img src="'.$app->storage->name($value["image"])->path('images')->get().'" />';
            }

            $result .= '<a href="#" data-id="'.$value["id"].'" class="link-geo-country-item '.$active.'" >'.$image.translateFieldReplace($value, "name").'</a>';

        }

    }

    return $result;

}