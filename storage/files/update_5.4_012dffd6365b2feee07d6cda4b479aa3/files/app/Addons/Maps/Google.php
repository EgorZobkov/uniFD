<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Addons\Maps;

class Google
{

    public function langs(){
        return [];
    }

    public function setMapVendor(){
        global $app;
        $app->asset->registerJs(["view"=>"web", "name"=>"<script src=\"https://maps.googleapis.com/maps/api/js?key=".$app->settings->integration_map_key."&libraries=places\" type=\"text/javascript\"></script>"]);
        $app->asset->registerJs(["view"=>"web", "name"=>"<script src=\"https://unpkg.com/@googlemaps/markerclusterer/dist/index.min.js\" type=\"text/javascript\"></script>"]);
    }

    public function outMapChangeAddressScript(){
        global $app;

        $latitude = $app->component->geo->defaultCountry->capital_latitude?:$app->settings->map_default_latitude;
        $longitude = $app->component->geo->defaultCountry->capital_longitude?:$app->settings->map_default_longitude;

        ob_start();

        ?>

        <script type="text/javascript">

        $(document).ready(function(){

            var latitude, longitude;

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

            function initialize(lat=0,lon=0) {

                var myLatlng = new google.maps.LatLng(lat, lon);
                
                var myOptions = {
                    zoom: 12,
                    center: myLatlng,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    animation:google.maps.Animation.BOUNCE,
                };
                map = new google.maps.Map(document.getElementById("initMapAddress"), myOptions);

                var marker = new google.maps.Marker({
                    draggable: true,
                    position: myLatlng,
                    map: map
                });

                google.maps.event.addListener(marker, 'dragend', function (event) {

                    $("input[name=geo_address_latitude]").val(event.latLng.lat());
                    $("input[name=geo_address_longitude]").val(event.latLng.lng());

                    geocoder.geocode({
                      'latLng': event.latLng
                    }, function(results, status) {

                      if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                          $(".ad-create-search-address input").val(results[0].formatted_address);
                        }
                      }

                    });

                });

                var geocoder = new google.maps.Geocoder();

                google.maps.event.addListener(map, 'click', function(event) {

                  marker.setPosition(event.latLng);

                  $("input[name=geo_address_latitude]").val(event.latLng.lat());
                  $("input[name=geo_address_longitude]").val(event.latLng.lng());

                  geocoder.geocode({
                    'latLng': event.latLng
                  }, function(results, status) {

                    if (status == google.maps.GeocoderStatus.OK) {
                      if (results[0]) {
                        $(".ad-create-search-address input").val(results[0].formatted_address);
                      }
                    }

                  });

                });

            }

            setInterval(function(){
             
                if($(".initMapAddress").html() == ""){

                    google.maps.event.addDomListener(window, 'load', initialize(latitude, longitude));

                }

            }, 1000);                

            $(document).on("click",".ad-create-search-address .geo-city-item", function () {
           
                  initialize($(this).data("latitude"), $(this).data("longitude"));
             
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

                        function initMap() {
                          var myLatLng = {lat: '.$latitude.', lng: '.$longitude.'};
                          var map = new google.maps.Map(document.getElementById("initMapAddress"), {
                            zoom: 14,
                            center: myLatLng
                          });
                          var marker = new google.maps.Marker({
                            position: myLatLng,
                            map: map
                          });
                        }
                        
                        google.maps.event.addDomListener(window, "load", initMap);

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

        $get = _json_decode(curl('get', 'https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($query).'&key='.$app->settings->integration_map_key));

        if($get){

            foreach ($get['results'] as $value) {

                $results[$value['formatted_address']] = ["lat"=>$value['geometry']['location']['lat'], "lon"=>$value['geometry']['location']['lng'], "address"=>$value['formatted_address']];

            }

            return $results;
            
        }      

    }

    public function searchAddressByCoordinates($latitude = 0, $longitude = 0){
        global $app;

        if($latitude && $longitude){

            $get = _json_decode(curl('get', 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.$latitude.','.$longitude.'&key='.$app->settings->integration_map_key));

            if($get){

                foreach ($get['results'] as $value) {

                    return $value['formatted_address'];

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
                  var markers = [];
                  var cluster;

                  var coorTopLeft;
                  var coorTopRight;
                  var coorBottomLeft;
                  var coorBottomRight;
                  var initialBounds = false;


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

                  async function initMap() {

                      const { Map } = await google.maps.importLibrary("maps");
                      const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");
                      const center = {
                        lat: <?php echo $latitude; ?>,
                        lng: <?php echo $longitude; ?>
                      };

                      markers = [];

                      map = new Map(document.getElementById("initMap"), {
                        center: center,
                        zoom: 6,
                        mapId: "4504f8b37365c3d0",
                        zoomControl: true
                      });

                      google.maps.event.addListener(map, 'bounds_changed', () => {

                        let ne = map.getBounds().getNorthEast();
                        let sw = map.getBounds().getSouthWest();

                        coorTopLeft = ne.lat();
                        coorTopRight = ne.lng();
                        coorBottomLeft = sw.lat();
                        coorBottomRight = sw.lng();

                        if(!initialBounds){

                              helpers.request({url:"map-load-markers", data: helpers.paramsForm(".live-filters, .modal-geo-form") + "&topLeft=" + coorTopLeft + "&topRight=" + coorTopRight + "&bottomLeft=" + coorBottomLeft + "&bottomRight=" + coorBottomRight}, function(data) {

                                $.each(data["features"], function (key, data) {

                                        marker = new AdvancedMarkerElement({
                                          map: map,
                                          position: new google.maps.LatLng(data["geometry"]["coordinates"][0], data["geometry"]["coordinates"][1]),
                                          title: data["id"],
                                        });

                                        marker.addListener("click", () => {
                                             if(data["id"] && data["id"] != undefined){
                                                  $(".search-map-sidebar").hide();
                                                  $(".search-map-sidebar-card").show();                
                                                  loadItemById(data["id"]);
                                             }
                                        });

                                        markers.push(marker);

                                });

                                cluster = new markerClusterer.MarkerClusterer({
                                    map: map,
                                    markers: markers,
                                });

                              });

                            initialBounds = true;
                        }

                      });

                      google.maps.event.addListener(map, 'idle', function(){

                        let ne = map.getBounds().getNorthEast();
                        let sw = map.getBounds().getSouthWest();

                        coorTopLeft = ne.lat();
                        coorTopRight = ne.lng();
                        coorBottomLeft = sw.lat();
                        coorBottomRight = sw.lng();

                        currentPageLoadItems = 1;

                        if (updateTimeout != null) {
                           clearTimeout(updateTimeout);
                        }

                        updateTimeout = setTimeout(function() {

                              cluster = null;
                              markers = [];

                              helpers.request({url:"map-load-markers", data: helpers.paramsForm(".live-filters, .modal-geo-form") + "&topLeft=" + coorTopLeft + "&topRight=" + coorTopRight + "&bottomLeft=" + coorBottomLeft + "&bottomRight=" + coorBottomRight}, function(data) {

                                $.each(data["features"], function (key, data) {

                                        marker = new AdvancedMarkerElement({
                                          map: map,
                                          position: new google.maps.LatLng(data["geometry"]["coordinates"][0], data["geometry"]["coordinates"][1]),
                                          title: data["id"],
                                        });

                                        marker.addListener("click", () => {
                                             if(data["id"] && data["id"] != undefined){
                                                  $(".search-map-sidebar").hide();
                                                  $(".search-map-sidebar-card").show();                
                                                  loadItemById(data["id"]);
                                             }
                                        });

                                        markers.push(marker);

                                });

                                cluster = new markerClusterer.MarkerClusterer({
                                    map: map,
                                    markers: markers,
                                });

                              });

                              if($(window).width() >= 992){
                                  loadItemsByCoordinates();
                              }

                        }, 500);

                      });

                  }

                  initMap();

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
                  var markers = [];
                  var cluster;

                  var coorTopLeft;
                  var coorTopRight;
                  var coorBottomLeft;
                  var coorBottomRight;
                  var initialBounds = false;

                  function loadItemById(id=0){

                      helpers.request({url:"map-load-delivery-point-item", data: {id:id, params: "<?php echo buildAttributeParams($params); ?>"}}, function(data) {

                           $(".delivery-points-map-sidebar-modal").html(data["content"]);

                      });

                  }

                  async function initMap() {

                      const { Map } = await google.maps.importLibrary("maps");
                      const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");
                      const center = {
                        lat: <?php echo $latitude; ?>,
                        lng: <?php echo $longitude; ?>
                      };

                      markers = [];

                      map = new Map(document.getElementById("initMapDeliveryPoints"), {
                        center: center,
                        zoom: 6,
                        mapId: "4504f8b37365c3d0",
                        zoomControl: true
                      });

                      google.maps.event.addListener(map, 'bounds_changed', () => {

                        let ne = map.getBounds().getNorthEast();
                        let sw = map.getBounds().getSouthWest();

                        coorTopLeft = ne.lat();
                        coorTopRight = ne.lng();
                        coorBottomLeft = sw.lat();
                        coorBottomRight = sw.lng();

                        if(!initialBounds){

                              helpers.request({url:"map-load-delivery-points-markers", data: {id: <?php echo $delivery_id; ?>, params: "<?php echo buildAttributeParams($params); ?>", topLeft: coorTopLeft, topRight: coorTopRight, bottomLeft: coorBottomLeft, bottomRight: coorBottomRight}}, function(data) {

                                $.each(data["features"], function (key, data) {

                                        marker = new AdvancedMarkerElement({
                                          map: map,
                                          position: new google.maps.LatLng(data["geometry"]["coordinates"][0], data["geometry"]["coordinates"][1]),
                                          title: data["id"],
                                        });

                                        marker.addListener("click", () => {
                                             if(data["id"] && data["id"] != undefined){
                                                  $(".delivery-points-map-sidebar-modal").show();                 
                                                  loadItemById(data["id"]);
                                             }
                                        });

                                        markers.push(marker);

                                });

                                cluster = new markerClusterer.MarkerClusterer({
                                    map: map,
                                    markers: markers,
                                });

                              });

                            initialBounds = true;
                        }

                      });

                      google.maps.event.addListener(map, 'idle', function(){

                        let ne = map.getBounds().getNorthEast();
                        let sw = map.getBounds().getSouthWest();

                        coorTopLeft = ne.lat();
                        coorTopRight = ne.lng();
                        coorBottomLeft = sw.lat();
                        coorBottomRight = sw.lng();

                        currentPageLoadItems = 1;

                        if (updateTimeout != null) {
                           clearTimeout(updateTimeout);
                        }

                        updateTimeout = setTimeout(function() {

                              cluster = null;
                              markers = [];

                              helpers.request({url:"map-load-delivery-points-markers", data: {id: <?php echo $delivery_id; ?>, params: "<?php echo buildAttributeParams($params); ?>", topLeft: coorTopLeft, topRight: coorTopRight, bottomLeft: coorBottomLeft, bottomRight: coorBottomRight}}, function(data) {

                                $.each(data["features"], function (key, data) {

                                        marker = new AdvancedMarkerElement({
                                          map: map,
                                          position: new google.maps.LatLng(data["geometry"]["coordinates"][0], data["geometry"]["coordinates"][1]),
                                          title: data["id"],
                                        });

                                        marker.addListener("click", () => {
                                             if(data["id"] && data["id"] != undefined){
                                                  $(".delivery-points-map-sidebar-modal").show();                
                                                  loadItemById(data["id"]);
                                             }
                                        });

                                        markers.push(marker);

                                });

                                cluster = new markerClusterer.MarkerClusterer({
                                    map: map,
                                    markers: markers,
                                });

                              });

                        }, 500);

                      });

                  }

                  initMap();

                });
            </script>

        <?php

        $script = ob_get_contents();
        ob_end_clean();

        return $script;

    }

}