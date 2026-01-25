<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Addons\Maps;

class Openmapstreet
{

    public function langs(){
        return ["ru", "en"];
    }

    public function setMapVendor(){
        global $app;
        $app->asset->registerJs(["view"=>"web", "name"=>"<script src=\"https://unpkg.com/leaflet@0.7.3/dist/leaflet.js\" ></script>"]);
        $app->asset->registerCss(["view"=>"web", "name"=>"<link rel=\"stylesheet\" href=\"https://unpkg.com/leaflet@0.7.3/dist/leaflet.css\" />"]);

        $app->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/vendors/leaflet.markercluster.js\" type=\"text/javascript\"></script>"]);
        $app->asset->registerCss(["view"=>"web", "name"=>"<link rel=\"stylesheet\" href=\"{assets_path}/vendors/leaflet.markercluster.css\" />"]);
    }
            
    public function outMapChangeAddressScript(){
        global $app;

        $latitude = $app->component->geo->defaultCountry->capital_latitude?:$app->settings->map_default_latitude;
        $longitude = $app->component->geo->defaultCountry->capital_longitude?:$app->settings->map_default_longitude;

        ob_start();

        ?>

        <script type="text/javascript">

        $(document).ready(function(){

              var L = window.L;

              var map = null;
              var marker = null;
              var markersList = [];

              function centerLeafletMapOnMarker(map, marker) {
                var latLngs = [ marker.getLatLng() ];
                var markerBounds = L.latLngBounds(latLngs);
                map.fitBounds(markerBounds);
                map.setZoom(14);
              }

              function shortName(data){

                listName = [];

                if( data.address.city != undefined ){

                    if( listName.indexOf( data.address.city ) == -1 )
                    {  
                        listName.push( data.address.city );
                    }

                }

                if( data.address.road != undefined ){

                    if( listName.indexOf( data.address.road ) == -1 )
                    {  
                        listName.push( data.address.road );
                    }

                }

                if( data.address.house_number != undefined ){

                    if( listName.indexOf( data.address.house_number ) == -1 )
                    {  
                        listName.push( data.address.house_number );
                    }

                }

                if( data.address.state != undefined ){

                    if( listName.indexOf( data.address.state ) == -1 )
                    {  
                        listName.push( data.address.state );
                    }

                }

                if( data.address.suburb != undefined ){

                    if( listName.indexOf( data.address.suburb ) == -1 )
                    {  
                        listName.push( data.address.suburb );
                    }

                }

                if( data.address.country != undefined ){

                    if( listName.indexOf( data.address.country ) == -1 )
                    {  
                        listName.push( data.address.country );
                    }

                }

                return listName.join(', ');

              }

              function addMarker(lat, lng){

                  if( markersList.length ){

                      $.each(markersList,function(index,value){

                          map.removeLayer(marker);

                      });

                  }

                  var geojsonFeature = {

                      "type": "Feature",
                      "properties": {},
                      "geometry": {
                              "type": "Point",
                              "coordinates": [lat, lng]
                      }
                  }

                  L.geoJson(geojsonFeature, {

                      pointToLayer: function(feature, latlng){

                          marker = L.marker( { 'lat': lat, 'lng': lng } , {

                              riseOnHover: true,
                              draggable: false,

                          });

                          markersList.push( marker );

                          return marker;
                      }

                  }).addTo(map);

                  return marker;

              }

            setInterval(function(){
             
                if($(".initMapAddress").html() == ""){

                    if($("input[name=geo_latitude]").val() != "0" && $("input[name=geo_latitude]").val() != "" && $("input[name=geo_longitude]").val() != "0" && $("input[name=geo_longitude]").val() != ""){
                        latitude = $("input[name=geo_latitude]").val();
                        longitude = $("input[name=geo_longitude]").val();
                    }else if($("input[name=geo_address_latitude]").val() != "0" && $("input[name=geo_address_latitude]").val() != "" && $("input[name=geo_address_longitude]").val() != "0" && $("input[name=geo_address_longitude]").val() != ""){
                        latitude = $("input[name=geo_address_latitude]").val();
                        longitude = $("input[name=geo_address_longitude]").val();
                    }else{
                        latitude = "<?php echo $latitude; ?>";
                        longitude = "<?php echo $longitude; ?>";
                    }

                    map = L.map('initMapAddress').setView([latitude, longitude], 12);

                    L.tileLayer('https://api.mapbox.com/styles/v1/mapbox/streets-v11/tiles/{z}/{x}/{y}?access_token=<?php echo $app->settings->integration_map_key; ?>', {
                       attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(map);

                    map.on('click', function(e) {

                          addMarker(e.latlng.lat, e.latlng.lng);

                          $("input[name=geo_address_latitude]").val(e.latlng.lat);
                          $("input[name=geo_address_longitude]").val(e.latlng.lng);
                          $.getJSON('https://nominatim.openstreetmap.org/reverse?format=json&lat='+e.latlng.lat+'&lon='+e.latlng.lng+'&addressdetails=1', function(data) {
                               $(".ad-create-search-address input").val(shortName(data));
                          });

                    });

                }
            }, 1000);                

            $(document).on("click",".ad-create-search-address .geo-city-item", function () {
           
                  $(".ad-create-search-address input").val($(this).html());
                  $("input[name=geo_address_latitude]").val($(this).data("latitude"));
                  $("input[name=geo_address_longitude]").val($(this).data("longitude"));

                  getMarker = addMarker($(this).data("latitude"), $(this).data("longitude"));

                  centerLeafletMapOnMarker(map, getMarker);

                  $(".input-geo-search-container-result").hide();

            }); 

            function mapUpdate(){

                map.invalidateSize();
                map._onResize(); 

            }

            $(function(){
                
                setInterval(function() { mapUpdate() }, 1000);

            });

        });
        </script>

        <?php

        $script = ob_get_contents();
        ob_end_clean();

        $app->asset->registerJs(["view"=>"web", "name"=>$script]);

    }

    public function outMapPointAddressScript($latitude=0, $longitude=0){
        global $app;

        if($latitude && $longitude){

            $script = '
                <script type="text/javascript">
                    $(document).ready(function(){

                          var map;

                          function loadOpenstreetmap(){

                                var L = window.L;

                                map = L.map("initMapAddress").setView(['.$latitude.', '.$longitude.'], 13);

                                L.tileLayer("https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token='.$app->settings->integration_map_key.'", {
                                  maxZoom: 18,
                                  attribution: `Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>`,
                                  id: "mapbox/streets-v11",
                                  tileSize: 512,
                                  zoomOffset: -1
                                }).addTo(map);

                                L.marker(['.$latitude.', '.$longitude.']).addTo(map);

                          }

                          loadOpenstreetmap();

                          function mapUpdate(){

                              map.invalidateSize();
                              map._onResize(); 

                          }

                          $(function(){
                                
                              setInterval(function() { mapUpdate() }, 1000);

                          });

                    });
                </script>
            ';

        }

        $app->asset->registerJs(["view"=>"web", "name"=>$script]);

    }

    public function searchAddress($query = null, $city_id = 0){
        global $app;

        if($city_id){
           $city = $app->model->geo_cities->find("id=?", [$city_id]);
           $query = $city->name . ' ' . $query;
        }

        $curl=curl_init('https://nominatim.openstreetmap.org/search?q='.urlencode($query).'&format=json&polygon=1&addressdetails=1&accept-language='.$app->settings->integration_map_lang?:'ru');

        curl_setopt_array($curl,array(
                CURLOPT_USERAGENT=>'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:60.0) Gecko/20100101 Firefox/60.0',
                CURLOPT_ENCODING=>'gzip, deflate',
                CURLOPT_RETURNTRANSFER=>1,
                CURLOPT_HTTPHEADER=>array(
                        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                        'Accept-Language: en-US,en;q=0.5',
                        'Accept-Encoding: gzip, deflate',
                        'Connection: keep-alive',
                        'Upgrade-Insecure-Requests: 1',
                ),
        ));

        $get = _json_decode(curl_exec($curl));

        if($get){

            foreach ($get as $value) { 
                if(isset($value["address"])){   
                    if(isset($value["address"]["country_code"])) unset($value["address"]["country_code"]);
                    if(isset($value["address"]["country"])) unset($value["address"]["country"]);
                    if(isset($value["address"]["postcode"])) unset($value["address"]["postcode"]);
                    if(isset($value["address"]["region"]))  unset($value["address"]["region"]);
                    if(isset($value["address"]["state"])) unset($value["address"]["state"]);
                    if(isset($value["address"]["city"])) unset($value["address"]["city"]);
                    if(isset($value["address"]["region"])) unset($value["address"]["region"]);
                    if(isset($value["address"]["ISO3166-2-lvl3"])) unset($value["address"]["ISO3166-2-lvl3"]);
                    if(isset($value["address"]["ISO3166-2-lvl4"])) unset($value["address"]["ISO3166-2-lvl4"]);
                    if($value["address"]) $results[implode(', ',$value["address"])] = ["lat"=>$value['lat'], "lon"=>$value['lon'], "address"=>implode(', ',$value["address"])];                                            
                }
            }

            return $results;
            
        }      

    }

    public function searchAddressByCoordinates($latitude = 0, $longitude = 0){
        global $app;

        if($latitude && $longitude){

            $curl = curl_init('https://nominatim.openstreetmap.org/reverse?format=json&accept-language='.($app->settings->integration_map_lang?:"ru").'&lat='.$latitude.'&lon='.$longitude.'&zoom=18&addressdetails=1');

            curl_setopt_array($curl,array(
                    CURLOPT_USERAGENT=>'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:60.0) Gecko/20100101 Firefox/60.0',
                    CURLOPT_ENCODING=>'gzip, deflate',
                    CURLOPT_RETURNTRANSFER=>1,
                    CURLOPT_HTTPHEADER=>array(
                            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                            'Accept-Language: en-US,en;q=0.5',
                            'Accept-Encoding: gzip, deflate',
                            'Connection: keep-alive',
                            'Upgrade-Insecure-Requests: 1',
                    ),
            ));

            $get = _json_decode(curl_exec($curl));

            if($get){

                foreach ($get as $value) { 
                    if(isset($value["address"])){   
                        if(isset($value["address"]["country_code"])) unset($value["address"]["country_code"]);
                        if(isset($value["address"]["country"])) unset($value["address"]["country"]);
                        if(isset($value["address"]["postcode"])) unset($value["address"]["postcode"]);
                        if(isset($value["address"]["region"]))  unset($value["address"]["region"]);
                        if(isset($value["address"]["state"])) unset($value["address"]["state"]);
                        if(isset($value["address"]["city"])) unset($value["address"]["city"]);
                        if(isset($value["address"]["region"])) unset($value["address"]["region"]);
                        if(isset($value["address"]["ISO3166-2-lvl3"])) unset($value["address"]["ISO3166-2-lvl3"]);
                        if(isset($value["address"]["ISO3166-2-lvl4"])) unset($value["address"]["ISO3166-2-lvl4"]);    
                        if($value["address"]) $results[implode(', ',$value["address"])] = implode(', ',$value["address"]);                                        
                    }
                }

                if($results){
                    return implode('',$results);
                }
                
            }

        }      

    }

    public function outMapSearchItemsScript(){
        global $app;

        $geo = $app->session->get("geo");

        $latitude = $geo->latitude ?: $app->component->geo->defaultCountry->capital_latitude;
        $longitude = $geo->longitude ?: $app->component->geo->defaultCountry->capital_longitude;

        ob_start();

        ?>

            <script type="text/javascript">
                $(document).ready(function(){

                  var helpers = new window.Helpers();

                  var currentPageLoadItems = 1;
                  var updateTimeout = null;
                  var map = null;
                  var markers = L.markerClusterGroup();
                  var ids = [];
                  var geoJsonLayer = null;
                  var coorTopLeft;
                  var coorTopRight;
                  var coorBottomLeft;
                  var coorBottomRight;

                  map = L.map('initMap').setView([<?php echo $latitude?:$app->settings->map_default_latitude; ?>,<?php echo $longitude?:$app->settings->map_default_longitude; ?>], 12);

                  L.tileLayer('https://api.mapbox.com/styles/v1/mapbox/streets-v11/tiles/{z}/{x}/{y}?access_token=<?php echo $app->settings->integration_map_key; ?>', {
                      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                  }).addTo(map);

                  function loadItemsByCoordinates(page=1, button){

                      $(".search-map-sidebar").show();
                      $(".search-map-sidebar-card").hide();
                      $(".search-map-sidebar-container").addClass("active");

                      helpers.request({url:"map-load-items", data: helpers.paramsForm(".live-filters, .modal-geo-form") + "&topLeft=" + coorTopLeft + "&topRight=" + coorTopRight + "&bottomLeft=" + coorBottomLeft + "&bottomRight=" + coorBottomRight + "&page=" + page}, function(data) {

                         $(".search-map-sidebar-container").removeClass("active");

                         if(page == 1){
                            $(".search-map-sidebar-container").html("");
                         }

                         $(".search-map-sidebar-container").append('<div class="load-items-page'+page+'" ></div>'+data["content"]);
                         
                         $(".load-items-page"+page).next().fadeIn('slow');

                         if(button != undefined){
                             $(button).remove();
                         }

                         if(scroll){

                             $(".search-map-sidebar-container").animate({
                               scrollTop: $(".load-items-page"+page).offset().top-50
                             }, 300, 'linear');

                         }

                      });

                  }

                  function loadItemById(id=0){

                      helpers.request({url:"map-load-item", data: {id:id}}, function(data) {

                           $(".search-map-sidebar-card").html(data["content"]);

                           if($('.ad-card-media-slider-swiper').length){
                              new Swiper(document.querySelector('.ad-card-media-slider-swiper'), {
                                 loop: false,
                                 slidesPerView: "auto",
                                 spaceBetween: 10,
                                 navigation: {
                                   nextEl: '.ad-card-media-slider-nav-right',
                                   prevEl: '.ad-card-media-slider-nav-left',
                                 },
                              });
                           }

                      });

                  }

                  function loadMarkersByCoordinates(){

                      var bounds = map.getBounds();
                      southWest = bounds.getSouthWest();
                      northEast = bounds.getNorthEast();

                      coorTopLeft = northEast.lat;
                      coorTopRight = northEast.lng;
                      coorBottomLeft = southWest.lat;
                      coorBottomRight = southWest.lng;

                      helpers.request({url:"map-load-markers", data: helpers.paramsForm(".live-filters, .modal-geo-form") + "&topLeft=" + coorTopLeft + "&topRight=" + coorTopRight + "&bottomLeft=" + coorBottomLeft + "&bottomRight=" + coorBottomRight}, function(data) {

                            if(geoJsonLayer != null){
                               markers.clearLayers(); 
                            }

                            geoJsonLayer = L.geoJson(data, {
                              onEachFeature: function (feature, layer) {
                                ids.push(feature.id);
                                layer.on('click', function () {
                                  $(".search-map-sidebar").hide();
                                  $(".search-map-sidebar-card").show();                
                                  loadItemById(feature.id);                         
                                });                        
                              }
                            });

                            markers.addLayer(geoJsonLayer);

                            map.addLayer(markers);

                      });

                  }

                  map.on('moveend', function(e) {

                        currentPageLoadItems = 1;

                        if (updateTimeout != null) {
                           clearTimeout(updateTimeout);
                        }

                        updateTimeout = setTimeout(function() {

                            loadMarkersByCoordinates();

                            if($(window).width() >= 992){
                                loadItemsByCoordinates();
                            }

                        }, 1000);

                  });

                  loadMarkersByCoordinates();

                  if($(window).width() >= 992){
                      loadItemsByCoordinates();
                  }

                  $(document).on('click','.actionMapShowMoreItems', function () {
                       
                       currentPageLoadItems = currentPageLoadItems + 1;

                       helpers.startProcessLoadButton($(this));
                       
                       loadItemsByCoordinates(currentPageLoadItems, this);   
                     
                  });


                });
            </script>

        <?php

        $script = ob_get_contents();
        ob_end_clean();

        $app->asset->registerJs(["view"=>"web", "name"=>$script]);

    }

    public function outMapDeliveryPoints($delivery_id=0, $params=[]){
        global $app;

        $latitude = $app->component->geo->defaultCountry->capital_latitude?:$app->settings->map_default_latitude;
        $longitude = $app->component->geo->defaultCountry->capital_longitude?:$app->settings->map_default_longitude;

        ob_start();

        ?>

            <script type="text/javascript">
                $(document).ready(function(){

                  var helpers = new window.Helpers();

                  var updateTimeout = null;
                  var map = null;
                  var markers = L.markerClusterGroup();
                  var ids = [];
                  var geoJsonLayer = null;
                  var coorTopLeft;
                  var coorTopRight;
                  var coorBottomLeft;
                  var coorBottomRight;

                  map = L.map('initMapDeliveryPoints').setView([<?php echo $latitude; ?>,<?php echo $longitude; ?>], 12);

                  L.tileLayer('https://api.mapbox.com/styles/v1/mapbox/streets-v11/tiles/{z}/{x}/{y}?access_token=<?php echo $app->settings->integration_map_key; ?>', {
                      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                  }).addTo(map);

                  function loadItemById(id=0){

                      helpers.request({url:"map-load-delivery-point-item", data: {id:id, params: "<?php echo buildAttributeParams($params); ?>"}}, function(data) {

                           $(".delivery-points-map-sidebar-modal").html(data["content"]);

                      });

                  }

                  function loadMarkersByCoordinates(){

                      var bounds = map.getBounds();
                      southWest = bounds.getSouthWest();
                      northEast = bounds.getNorthEast();

                      coorTopLeft = northEast.lat;
                      coorTopRight = northEast.lng;
                      coorBottomLeft = southWest.lat;
                      coorBottomRight = southWest.lng;

                      helpers.request({url:"map-load-delivery-points-markers", data: {id: <?php echo $delivery_id; ?>, params: "<?php echo buildAttributeParams($params); ?>", topLeft: coorTopLeft, topRight: coorTopRight, bottomLeft: coorBottomLeft, bottomRight: coorBottomRight}}, function(data) {

                            if(geoJsonLayer != null){
                               markers.clearLayers(); 
                            }

                            geoJsonLayer = L.geoJson(data, {
                              onEachFeature: function (feature, layer) {
                                ids.push(feature.id);
                                layer.on('click', function () {
                                  $(".delivery-points-map-sidebar-modal").show();               
                                  loadItemById(feature.id);                         
                                });                        
                              }
                            });

                            markers.addLayer(geoJsonLayer);

                            map.addLayer(markers);

                      });

                  }

                  map.on('moveend', function(e) {

                        if (updateTimeout != null) {
                           clearTimeout(updateTimeout);
                        }

                        updateTimeout = setTimeout(function() {

                            loadMarkersByCoordinates();

                        }, 1000);

                  });

                  loadMarkersByCoordinates();

                  function mapUpdate(){

                      map.invalidateSize();
                      map._onResize(); 

                  }

                  $(function(){
                        
                      setInterval(function() { mapUpdate() }, 1000);

                  });

                });
            </script>

        <?php

        $script = ob_get_contents();
        ob_end_clean();

        return $script;

    }

}