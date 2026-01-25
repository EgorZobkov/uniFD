public function mapBuildMarkersByDelivery($data=[]){
    global $app;

    $result = [];

    $result["type"] = "FeatureCollection";

    foreach ($data as $key => $value) {

        if($value["latitude"] && $value["longitude"]){       

            if($app->settings->integration_map_service == "yandex"){

                $result["features"][] = [
                    "id"=>$value["id"],
                    "type"=>"Feature",
                    "geometry"=>[
                        "type"=>"Point",
                        "coordinates"=>[$value["latitude"],$value["longitude"]],
                        "properties"=>[
                            "id"=>$value["id"],
                        ],
                        "options"=>["preset"=>"islands#redDotIcon"]
                    ]
                ];

            }elseif($app->settings->integration_map_service == "google"){

                $result["features"][] = [
                    "id"=>$value["id"],
                    "type"=>"Feature",
                    "geometry"=>[
                        "type"=>"Point",
                        "coordinates"=>[$value["latitude"], $value["longitude"]],
                        "properties"=>[
                            "id"=>$value["id"],
                        ],
                        "options"=>["preset"=>"islands#redDotIcon"]
                    ]
                ];

            }elseif($app->settings->integration_map_service == "openmapstreet"){

                $result["features"][] = [
                    "id"=>$value["id"],
                    "type"=>"Feature",
                    "geometry"=>[
                        "type"=>"Point",
                        "coordinates"=>[$value["longitude"], $value["latitude"]],
                        "properties"=>[
                            "id"=>$value["id"],
                        ],
                        "options"=>["preset"=>"islands#redDotIcon"]
                    ]
                ];

            }

        }
        
    }

    return $result;

}