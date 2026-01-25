<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Addons\Maps;

class Yandex
{

    public function langs(){
        return ["ru_RU", "ru_UA", "uk_UA", "tr_TR", "en_RU", "en_US", "he_IL", "en_IL"];
    }

    public function setMapVendor(){
        global $app;
        $app->asset->registerJs(["view"=>"web", "name"=>"<script src=\"//api-maps.yandex.ru/2.1/?apikey=".$app->settings->integration_map_key."&lang=".($app->settings->integration_map_lang?:"ru_RU")."\" type=\"text/javascript\"></script>"]);
    }

    public function outMapChangeAddressScript(){
        global $app;

        $latitude = $app->component->geo->defaultCountry->capital_latitude?:$app->settings->map_default_latitude;
        $longitude = $app->component->geo->defaultCountry->capital_longitude?:$app->settings->map_default_longitude;

        ob_start();

        ?>

        <script type="text/javascript">

        $(document).ready(function(){

            var myMap;
            var latitude, longitude;

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

                    ymaps.ready(function () {

                        myMap = new ymaps.Map("initMapAddress", {
                            center: [latitude, longitude],
                            zoom: 11,
                            behaviors: ["default", "scrollZoom"]
                        });
                        myMap.controls.add("zoomControl");

                        var myPlacemark = new ymaps.Placemark([latitude, longitude]);
                        myMap.geoObjects.add(myPlacemark);

                        myMap.events.add("click", function (e) {
                            var coords = e.get("coords");

                            myPlacemark.geometry.setCoordinates(e.get("coords"));

                            ymaps.geocode(coords).then(function(res) {
                                var first = res.geoObjects.get(0);
                                $(".ad-create-search-address input").val(first.properties.get("text"));
                                $("input[name=geo_address_latitude]").val(coords[0]);
                                $("input[name=geo_address_longitude]").val(coords[1]);                            
                            });
                        });

                        myMap.setCenter([latitude, longitude], 11);

                    });

                }
            }, 1000);                

            $(document).on("click",".ad-create-search-address .geo-city-item", function () {
           
                  var myPlacemark = new ymaps.Placemark([$(this).data("latitude"), $(this).data("longitude")]);

                  myMap.geoObjects.removeAll();
                  myMap.geoObjects.remove();
                  myMap.geoObjects.add(myPlacemark);

                  myMap.events.add("click", function (e) {
                      var coords = e.get("coords");

                      myPlacemark.geometry.setCoordinates(e.get("coords"));

                      ymaps.geocode(coords).then(function(res) {
                          var first = res.geoObjects.get(0);
                          $(".ad-create-search-address input").val(first.properties.get("text"));
                          $("input[name=geo_address_latitude]").val(coords[0]);
                          $("input[name=geo_address_longitude]").val(coords[1]);                            
                      });
                  });

                  myMap.setCenter([$(this).data("latitude"), $(this).data("longitude")], 13);
             
                  $(".input-geo-search-container-result").hide();

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
                        ymaps.ready(init);

                        var myMap, 
                            myPlacemark;

                        $(window).resize(function() {
                          myMap.destroy();  
                          ymaps.ready(init);
                        });
                
                        function init(){ 
                            myMap = new ymaps.Map("initMapAddress", {
                                center: ['.$latitude.', '.$longitude.'],
                                zoom: 14
                            }); 
                            myMap.behaviors.enable("scrollZoom");

                            myPlacemark = new ymaps.Placemark(['.$latitude.', '.$longitude.']);
                            
                            myMap.geoObjects.add(myPlacemark);
                        }
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

        $get = _json_decode(curl('get', 'https://geocode-maps.yandex.ru/v1/?apikey='.$app->settings->integration_map_key.'&format=json&lang='.($app->settings->integration_map_lang?:"ru_RU").'&geocode='.urlencode($query)));

        if($get){

            foreach ($get['response']['GeoObjectCollection']['featureMember'] as $value) {

                $concat = [];
                $data = $value['GeoObject']['metaDataProperty']['GeocoderMetaData']['Address']['Components'];

                if(isset($data)){   

                    foreach ($data as $item) {
                      if($item["kind"] == "street"){
                        $concat[$item["name"]] = $item["name"];
                      }
                      if($item["kind"] == "house"){
                        $concat[$item["name"]] = $item["name"];
                      }                           
                      if($item["kind"] == "area"){
                        $concat[$item["name"]] = $item["name"];
                      } 
                      if($item["kind"] == "province"){
                        $concat[$item["name"]] = $item["name"];
                      } 
                      if($item["kind"] == "locality"){
                        $concat[$item["name"]] = $item["name"];
                      }                               
                      if($item["kind"] == "other"){
                        $concat[$item["name"]] = $item["name"];
                      }                                                                           
                    }

                    $coordinates = explode(' ', $value['GeoObject']['Point']['pos']);

                    if($concat && $coordinates) $results[implode(', ',$concat)] = ["lat"=>$coordinates[1], "lon"=>$coordinates[0], "address"=>implode(', ',$concat)];                                          
                }
            }

            return $results;
            
        }      

    }

    public function searchAddressByCoordinates($latitude = 0, $longitude = 0){
        global $app;

        if($latitude && $longitude){

            $get = _json_decode(curl('get','https://geocode-maps.yandex.ru/v1/?apikey='.$app->settings->integration_map_key.'&format=json&results=1&lang='.($app->settings->integration_map_lang?:"ru_RU").'&geocode='.urlencode($longitude.' '.$latitude)));

            if($get){

                foreach ($get['response']['GeoObjectCollection']['featureMember'] as $value) {

                    $concat = [];
                    $data = $value['GeoObject']['metaDataProperty']['GeocoderMetaData']['Address']['Components'];

                    if(isset($data)){   

                        foreach ($data as $item) {
                          if($item["kind"] == "street"){
                            $concat[$item["name"]] = $item["name"];
                          }
                          if($item["kind"] == "house"){
                            $concat[$item["name"]] = $item["name"];
                          }                           
                          if($item["kind"] == "area"){
                            $concat[$item["name"]] = $item["name"];
                          } 
                          if($item["kind"] == "province"){
                            $concat[$item["name"]] = $item["name"];
                          } 
                          if($item["kind"] == "locality"){
                            $concat[$item["name"]] = $item["name"];
                          }                               
                          if($item["kind"] == "other"){
                            $concat[$item["name"]] = $item["name"];
                          }                                                                           
                        }

                        return implode(', ',$concat);                                          
                    }
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

                  var updateTimeout = null;
                  var currentPageLoadItems = 1;
                  var map = null;
                  var idsString = "";
                  var labelGeoObjects;
                  var objectManager;

                  var coorTopLeft;
                  var coorTopRight;
                  var coorBottomLeft;
                  var coorBottomRight;


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

                  function loadItemsByIds(ids=null, page=1, button){

                      $(".search-map-sidebar").show();
                      $(".search-map-sidebar-card").hide();
                      $(".search-map-sidebar-container").addClass("active");

                      helpers.request({url:"map-load-items", data: helpers.paramsForm(".live-filters, .modal-geo-form") + "&ids=" + ids + "&page=" + page}, function(data) {

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

                      coorTopLeft = bounds[1][0];
                      coorTopRight = bounds[1][1];
                      coorBottomLeft = bounds[0][0];
                      coorBottomRight = bounds[0][1];

                      helpers.request({url:"map-load-markers", data: helpers.paramsForm(".live-filters, .modal-geo-form") + "&topLeft=" + coorTopLeft + "&topRight=" + coorTopRight + "&bottomLeft=" + coorBottomLeft + "&bottomRight=" + coorBottomRight}, function(data) {

                            objectManager.add(data);

                      });

                  }

                  ymaps.ready(["Map", "Polygon"]).then(function() {
                
                    map = new ymaps.Map("initMap", { center: [<?php echo $latitude?:$app->settings->map_default_latitude; ?>,<?php echo $longitude?:$app->settings->map_default_longitude; ?>], zoom: 12, controls: [] });

                    geoObjects = [];
                    
                    objectManager = new ymaps.ObjectManager({
                        clusterize: true,
                        gridSize: 18,
                        openBalloonOnClick: false,
                        clusterDisableClickZoom: true
                    });

                    objectManager.objects.options.set("preset", "islands#redDotIcon");
                    objectManager.clusters.options.set("preset", "islands#redDotIcon");

                    map.geoObjects.add(objectManager);

                    map.events.add("boundschange", function(e) { 

                        currentPageLoadItems = 1;

                        if (updateTimeout != null) {
                           clearTimeout(updateTimeout);
                        }

                        updateTimeout = setTimeout(function() {

                            loadMarkersByCoordinates();

                            if($(window).width() >= 992){
                                loadItemsByCoordinates();
                            }

                        }, 500);

                    });

                    objectManager.clusters.events.add("click", function (e) {

                        var ids = [];
                        var cluster = objectManager.clusters.getById(e.get("objectId")),
                        objects = cluster.properties.geoObjects;

                        objects.forEach(function(element) {
                           ids.push(element.id); 
                        });

                        idsString = ids.join(",");

                        $(".search-map-sidebar").hide();
                        $(".search-map-sidebar-card").show(); 

                        loadItemsByIds(idsString);            

                    });

                    objectManager.objects.events.add("click", function (e) {
                        var objectId = e.get("objectId"),  
                        object = objectManager.objects.getById(objectId);
                        if(object.id != undefined){
                          $(".search-map-sidebar").hide();
                          $(".search-map-sidebar-card").show();                
                          loadItemById(object.id);
                        }
                    });

                    loadMarkersByCoordinates();

                    if($(window).width() >= 992){
                        loadItemsByCoordinates();
                    }
                    
                  });

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
                  var objectManager;

                  var coorTopLeft;
                  var coorTopRight;
                  var coorBottomLeft;
                  var coorBottomRight;

                  function loadItemById(id=0){

                      helpers.request({url:"map-load-delivery-point-item", data: {id:id, params: "<?php echo buildAttributeParams($params); ?>"}}, function(data) {

                           $(".delivery-points-map-sidebar-modal").html(data["content"]);

                      });

                  }

                  function loadMarkersByCoordinates(){

                      var bounds = map.getBounds();

                      coorTopLeft = bounds[1][0];
                      coorTopRight = bounds[1][1];
                      coorBottomLeft = bounds[0][0];
                      coorBottomRight = bounds[0][1];

                      helpers.request({url:"map-load-delivery-points-markers", data: {id: <?php echo $delivery_id; ?>, params: "<?php echo buildAttributeParams($params); ?>", topLeft: coorTopLeft, topRight: coorTopRight, bottomLeft: coorBottomLeft, bottomRight: coorBottomRight}}, function(data) {

                            objectManager.add(data);

                      });

                  }

                  ymaps.ready(["Map", "Polygon"]).then(function() {
                
                    map = new ymaps.Map("initMapDeliveryPoints", { center: [<?php echo $latitude; ?>,<?php echo $longitude; ?>], zoom: 12, controls: ['searchControl'] });

                    geoObjects = [];
                    
                    objectManager = new ymaps.ObjectManager({
                        clusterize: true,
                        gridSize: 50,
                        openBalloonOnClick: false,
                        clusterDisableClickZoom: true
                    });

                    objectManager.objects.options.set("preset", "islands#redDotIcon");
                    objectManager.clusters.options.set("preset", "islands#redDotIcon");

                    map.geoObjects.add(objectManager);

                    map.events.add("boundschange", function(e) { 

                        currentPageLoadItems = 1;

                        if (updateTimeout != null) {
                           clearTimeout(updateTimeout);
                        }

                        updateTimeout = setTimeout(function() {

                            loadMarkersByCoordinates();

                        }, 500);

                    });

                    objectManager.objects.events.add("click", function (e) {
                        var objectId = e.get("objectId"),  
                        object = objectManager.objects.getById(objectId);
                        if(object.id != undefined){
                          $(".delivery-points-map-sidebar-modal").show();                
                          loadItemById(object.id);
                        }
                    });

                    loadMarkersByCoordinates();

                  });

                });
            </script>

        <?php

        $script = ob_get_contents();
        ob_end_clean();

        return $script;

    }

}