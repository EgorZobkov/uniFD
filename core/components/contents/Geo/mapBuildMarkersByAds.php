public function mapBuildMarkersByAds($data=[]){
    global $app;

    $result = [];

    $result["type"] = "FeatureCollection";

    foreach ($data as $key => $value) {

        $latitude = $value["address_latitude"] ?: $value["geo_latitude"];
        $longitude = $value["address_longitude"] ?: $value["geo_longitude"];         

        if($latitude && $longitude){       

            if($app->settings->integration_map_service == "yandex"){

                $result["features"][] = [
                    "id"=>$value["id"],
                    "type"=>"Feature",
                    "geometry"=>[
                        "type"=>"Point",
                        "coordinates"=>[$latitude,$longitude],
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
                        "coordinates"=>[$latitude, $longitude],
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
                        "coordinates"=>[$longitude,$latitude],
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