<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Systems;

class Geo
{

    public function getInfoLocation($ip=null){
        global $app;
        $ip = isset($ip) ?: getIp();
        return [];
    }

    public function linkToIpInfo($ip=null){
        global $app;
        return "{$app->settings->uni_api_link}/ipcheck.php?ip={$ip}";
    }

    public function outStringGeoByLastAuth($data=null){
        global $app;
        $result = [];
        if($data){
            if($data->last_auth_data->geo->city){
                $result[] = $data->last_auth_data->geo->city;
            }
            if($data->last_auth_data->geo->region){
                $result[] = $data->last_auth_data->geo->region;
            }
            return implode(",", $result);
        }
        return null;
    }

    public function coordinatesByRadius($latitude, $longitude, $radius=100){
        global $app;

        if($latitude && $longitude){

            $lat_range = $radius/69.172;  
            $lon_range = abs($radius/(cos($latitude) * 69.172));  
            $min_lat = number_format($latitude - $lat_range, "4", ".", "");  
            $max_lat = number_format($latitude + $lat_range, "4", ".", "");  
            $min_lon = number_format($longitude - $lon_range, "4", ".", "");  
            $max_lon = number_format($longitude + $lon_range, "4", ".", ""); 

        }

        return ["min_lat"=>$min_lat,"max_lat"=>$max_lat,"min_lon"=>$min_lon,"max_lon"=>$max_lon];

    }

    public function coordinatesDetect($lat=null, $lon=null, $url=null){
        global $app;

        $results = [];

        $curl=curl_init('https://nominatim.openstreetmap.org/reverse?lat='.$lat.'&lon='.$lon.'&format=json&accept-language=ru');

        curl_setopt_array($curl,[
            CURLOPT_USERAGENT=>'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:60.0) Gecko/20100101 Firefox/60.0',
            CURLOPT_ENCODING=>'gzip, deflate',
            CURLOPT_RETURNTRANSFER=>1,
            CURLOPT_HTTPHEADER=>[
              'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
              'Accept-Language: en-US,en;q=0.5',
              'Accept-Encoding: gzip, deflate',
              'Connection: keep-alive',
              'Upgrade-Insecure-Requests: 1',
            ],
        ]);

        $data = _json_decode(curl_exec($curl));

        if($data){

            $results["display_name"] = $data["display_name"] ?: null;
            $results["city"] = $data["address"]["city"] ?: null;
            $results["state"] = $data["address"]["state"] ?: null;
            $results["country"] = $data["address"]["country"] ?: null;
            $results["country_code"] = $data["address"]["country_code"] ?: null;

            return $results;
         
        }

        return $results;

    }

}