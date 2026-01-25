public function outGeoMetroInAdCard($data=[]){
    global $app;

    $result = "";

    $metro = $this->getCityMetroByAd($data->id)->data;

    if($metro){
        foreach ($metro as $key => $value) {
            $station = $app->model->geo_cities_metro->find("id=?", [$value["parent_id"]]);
            if($station){
                $result .= '
                  <div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="17" height="17"><path fill="'.$station->color.'" fill-rule="evenodd" d="M11.154 4L8 9.53 4.845 4 1.1 13.466H0v1.428h5.657v-1.428H4.81l.824-2.36L8 15l2.365-3.893.824 2.36h-.85v1.427H16v-1.428h-1.1z"></path></svg>
                    '.$value["name"].', '.$station->name.'
                  </div>
                ';
            }
        }
    }

    if($result){
        return '<div class="ad-card-content-geo-metro" >' . $result . '</div>';
    }

}