public function outOptionsFavoritesCities($country_id=0){
    global $app;

    if($country_id){

        if($this->getChange()->country_id == $country_id){

            if(!$this->getChange()->city_id && !$this->getChange()->region_id){

                return '
                    <div class="modal-geo-container-favorites mt-3" >

                      <div class="row" >
                        '.$this->outFavoritesCities($country_id).'
                      </div>

                    </div>
                ';

            }elseif($this->getChange()->city_id){

                return $this->outOptionsCities();

            }

        }else{

            return '
                <div class="modal-geo-container-favorites mt-3" >

                  <div class="row" >
                    '.$this->outFavoritesCities($country_id).'
                  </div>

                </div>
            ';

        }

    }else{

        if(!$this->getChange()->city_id && !$this->getChange()->region_id){

            return '
                <div class="modal-geo-container-favorites mt-3" >

                  <div class="row" >
                    '.$this->outFavoritesCities().'
                  </div>

                </div>
            ';

        }elseif($this->getChange()->city_id){

            $options = $this->outOptionsCities();

            if($options){
                return $options;
            }

            return '
                <div class="modal-geo-container-favorites mt-3" >

                  <div class="row" >
                    '.$this->outFavoritesCities($country_id).'
                  </div>

                </div>
            ';

        }

    }

}