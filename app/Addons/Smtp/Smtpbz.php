<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code!
 */

namespace App\Addons\Smtp;

class Smtpbz
{

    public function sendByApi($params=[]){
        global $app;

        return curl("post", "https://api.smtp.bz/v1/smtp/send", [
            "subject" => $params["subject"] ?: 'No subject',
            "name" => $params["from_name"],
            "html" => $params["body"],
            "reply" => $params["from_email"],
            "from" => $params["from_email"],
            "to" => $params["to"],
        ], ["authorization"=>$params["api_key"]]);
        
    }

}